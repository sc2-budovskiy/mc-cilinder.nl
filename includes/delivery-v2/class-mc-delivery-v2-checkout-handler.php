<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MC_Delivery_V2_Checkout_Handler' ) ) {
    class MC_Delivery_V2_Checkout_Handler {
        private static $rate_context = array();
        private static $mapping_index = null;

        public static function register_hooks() {
            add_filter( 'woocommerce_package_rates', array( __CLASS__, 'filter_package_rates' ), 999, 2 );
            add_filter( 'woocommerce_cart_shipping_method_full_label', array( __CLASS__, 'filter_full_label' ), 999, 2 );
        }

        public static function filter_package_rates( $rates, $package ) {
            if ( ! class_exists( 'MC_Delivery_V2_Runtime' ) || ! MC_Delivery_V2_Runtime::is_enabled_for_request() ) {
                return $rates;
            }

            if ( empty( $rates ) || ! is_array( $rates ) ) {
                return $rates;
            }

            $original_rates = $rates;
            $mapping        = MC_Delivery_V2_Options::get_mapping_option();
            $method_keys    = array_keys( MC_Delivery_V2_Options::get_method_labels() );
            $reverse_map    = self::build_mapping_index( $mapping, $method_keys );

            if ( empty( $reverse_map ) ) {
                return $rates;
            }

            $result  = array();
            $context = self::build_checkout_context();

            foreach ( $rates as $rate_key => $rate ) {
                $rate_id = isset( $rate->id ) ? $rate->id : $rate_key;
                $method_key = self::resolve_method_key_for_rate( $rate, $rate_id, $reverse_map );
                if ( ! $method_key ) {
                    continue;
                }

                $scenario_key = MC_Delivery_V2_Scenario_Resolver::resolve_scenario_key( $method_key, $context );
                $row          = MC_Delivery_V2_Matrix_Service::get_row( $scenario_key, $method_key );

                if ( is_array( $row ) && isset( $row['enabled'] ) && ! intval( $row['enabled'] ) ) {
                    continue;
                }

                if ( is_array( $row ) && ! empty( $row['title_checkout'] ) ) {
                    $rate->label = sanitize_text_field( $row['title_checkout'] );
                }

                $result[ $rate_key ] = $rate;
                self::$rate_context[ $rate_id ] = array(
                    'method_key'   => $method_key,
                    'scenario_key' => $scenario_key,
                    'row'          => $row,
                    'sort_order'   => self::resolve_sort_order( $row ),
                    'is_default'   => self::resolve_is_default( $row ),
                );
            }

            if ( empty( $result ) ) {
                return $original_rates;
            }

            $result = self::sort_rates_by_matrix( $result );
            self::maybe_select_default_rate( $result );

            return $result;
        }

        public static function filter_full_label( $label, $method ) {
            if ( ! class_exists( 'MC_Delivery_V2_Runtime' ) || ! MC_Delivery_V2_Runtime::is_enabled_for_request() ) {
                return $label;
            }

            if ( ! is_object( $method ) || empty( $method->id ) ) {
                return $label;
            }

            // Theme template prints price separately, so we must return label-only text here.
            $base_label = $method->get_label();

            if ( empty( self::$rate_context[ $method->id ]['row'] ) || ! is_array( self::$rate_context[ $method->id ]['row'] ) ) {
                return $base_label;
            }

            $row = self::$rate_context[ $method->id ]['row'];
            if ( empty( $row['delivery_promise_text'] ) ) {
                return $base_label;
            }

            return $base_label . ' - ' . sanitize_text_field( $row['delivery_promise_text'] );
        }

        private static function build_mapping_index( $mapping, $method_keys ) {
            if ( self::$mapping_index !== null ) {
                return self::$mapping_index;
            }

            $index          = array();
            $available_rates = MC_Delivery_V2_Mapping_Repo::get_available_rates();

            foreach ( $method_keys as $method_key ) {
                if ( empty( $mapping[ $method_key ] ) ) {
                    continue;
                }

                $mapped_rate_id = sanitize_text_field( $mapping[ $method_key ] );
                if ( $mapped_rate_id === '' ) {
                    continue;
                }

                $index[ $mapped_rate_id ] = array(
                    'method_key'  => $method_key,
                    'rate_id'     => $mapped_rate_id,
                    'method_id'   => '',
                    'instance_id' => 0,
                );

                if ( isset( $available_rates[ $mapped_rate_id ] ) ) {
                    $index[ $mapped_rate_id ]['method_id']   = $available_rates[ $mapped_rate_id ]['method_id'];
                    $index[ $mapped_rate_id ]['instance_id'] = absint( $available_rates[ $mapped_rate_id ]['instance_id'] );
                }
            }

            self::$mapping_index = $index;

            return $index;
        }

        private static function resolve_method_key_for_rate( $rate, $rate_id, $mapping_index ) {
            // 1) Exact rate id match.
            if ( isset( $mapping_index[ $rate_id ]['method_key'] ) ) {
                return $mapping_index[ $rate_id ]['method_key'];
            }

            // 2) Prefix match (some shipping methods can append extra suffixes at runtime).
            foreach ( $mapping_index as $mapped_rate_id => $mapped ) {
                if ( strpos( $rate_id, $mapped_rate_id . ':' ) === 0 ) {
                    return $mapped['method_key'];
                }
            }

            // 3) Method + instance fallback.
            $rate_method_id   = isset( $rate->method_id ) ? sanitize_text_field( $rate->method_id ) : '';
            $rate_instance_id = isset( $rate->instance_id ) ? absint( $rate->instance_id ) : 0;
            if ( $rate_method_id === '' || $rate_instance_id === 0 ) {
                return '';
            }

            foreach ( $mapping_index as $mapped ) {
                if ( empty( $mapped['method_id'] ) || empty( $mapped['instance_id'] ) ) {
                    continue;
                }

                if ( $mapped['method_id'] === $rate_method_id && absint( $mapped['instance_id'] ) === $rate_instance_id ) {
                    return $mapped['method_key'];
                }
            }

            return '';
        }

        private static function build_checkout_context() {
            $is_reorder = false;

            if ( isset( $_GET['order_again'] ) && $_GET['order_again'] ) {
                $is_reorder = true;
            }

            if ( isset( $_GET['order-pay'] ) || isset( $_GET['pay_for_order'] ) ) {
                $is_reorder = true;
            }

            $context = array(
                'is_reorder' => $is_reorder,
                'timestamp'  => null,
            );

            return apply_filters( 'mc_delivery_v2_checkout_context', $context );
        }

        private static function resolve_sort_order( $row ) {
            if ( ! is_array( $row ) ) {
                return 9999;
            }

            return isset( $row['sort_order'] ) ? intval( $row['sort_order'] ) : 9999;
        }

        private static function resolve_is_default( $row ) {
            if ( ! is_array( $row ) ) {
                return false;
            }

            return ! empty( $row['is_default'] );
        }

        private static function sort_rates_by_matrix( $rates ) {
            uasort(
                $rates,
                function ( $a, $b ) {
                    $a_id = isset( $a->id ) ? $a->id : '';
                    $b_id = isset( $b->id ) ? $b->id : '';

                    $a_order = isset( self::$rate_context[ $a_id ]['sort_order'] ) ? intval( self::$rate_context[ $a_id ]['sort_order'] ) : 9999;
                    $b_order = isset( self::$rate_context[ $b_id ]['sort_order'] ) ? intval( self::$rate_context[ $b_id ]['sort_order'] ) : 9999;

                    if ( $a_order === $b_order ) {
                        return strcmp( $a_id, $b_id );
                    }

                    return ( $a_order < $b_order ) ? -1 : 1;
                }
            );

            return $rates;
        }

        private static function maybe_select_default_rate( $rates ) {
            if ( ! function_exists( 'WC' ) || ! WC()->session ) {
                return;
            }

            $keys = array_keys( $rates );
            if ( empty( $keys ) ) {
                return;
            }

            $chosen = WC()->session->get( 'chosen_shipping_methods' );
            if ( ! is_array( $chosen ) ) {
                $chosen = array();
            }

            $current = isset( $chosen[0] ) ? $chosen[0] : '';
            if ( $current && isset( $rates[ $current ] ) ) {
                return;
            }

            $target = '';
            foreach ( $rates as $rate_key => $rate ) {
                $rate_id = isset( $rate->id ) ? $rate->id : $rate_key;
                if ( ! empty( self::$rate_context[ $rate_id ]['is_default'] ) ) {
                    $target = $rate_key;
                    break;
                }
            }

            if ( $target === '' ) {
                $target = reset( $keys );
            }

            $chosen[0] = $target;
            WC()->session->set( 'chosen_shipping_methods', $chosen );
        }
    }
}
