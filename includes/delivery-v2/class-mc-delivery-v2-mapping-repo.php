<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MC_Delivery_V2_Mapping_Repo' ) ) {
    class MC_Delivery_V2_Mapping_Repo {
        public static function get_available_rates() {
            static $rates = null;

            if ( $rates !== null ) {
                return $rates;
            }

            $rates = array();

            if ( ! class_exists( 'WooCommerce' ) ) {
                return $rates;
            }

            global $wpdb;

            $methods_table = $wpdb->prefix . 'woocommerce_shipping_zone_methods';
            $zones_table   = $wpdb->prefix . 'woocommerce_shipping_zones';

            if ( ! self::table_exists( $methods_table ) ) {
                return $rates;
            }

            $query = "
                SELECT
                    m.zone_id,
                    z.zone_name,
                    m.instance_id,
                    m.method_id,
                    m.method_order,
                    m.is_enabled
                FROM {$methods_table} m
                LEFT JOIN {$zones_table} z ON z.zone_id = m.zone_id
                ORDER BY m.zone_id ASC, m.method_order ASC
            ";

            $rows = $wpdb->get_results( $query, ARRAY_A );
            if ( empty( $rows ) ) {
                return $rates;
            }

            foreach ( $rows as $row ) {
                $zone_id     = isset( $row['zone_id'] ) ? absint( $row['zone_id'] ) : 0;
                $method_id   = isset( $row['method_id'] ) ? sanitize_text_field( $row['method_id'] ) : '';
                $instance_id = isset( $row['instance_id'] ) ? absint( $row['instance_id'] ) : 0;

                if ( $method_id === '' || $instance_id === 0 ) {
                    continue;
                }

                $rate_id  = $method_id . ':' . $instance_id;
                $settings = get_option( 'woocommerce_' . $method_id . '_' . $instance_id . '_settings', array() );

                $title = '';
                if ( isset( $settings['title'] ) ) {
                    $title = sanitize_text_field( $settings['title'] );
                }

                if ( $title === '' ) {
                    $title = ucwords( str_replace( '_', ' ', $method_id ) );
                }

                $zone_name = isset( $row['zone_name'] ) ? sanitize_text_field( $row['zone_name'] ) : '';
                if ( $zone_name === '' ) {
                    $zone_name = $zone_id === 0 ? 'Rest of the world' : 'Zone #' . $zone_id;
                }

                $rates[ $rate_id ] = array(
                    'rate_id'     => $rate_id,
                    'zone_id'     => $zone_id,
                    'zone_name'   => $zone_name,
                    'method_id'   => $method_id,
                    'instance_id' => $instance_id,
                    'title'       => $title,
                    'is_enabled'  => ! empty( $row['is_enabled'] ),
                );
            }

            return $rates;
        }

        public static function get_available_rate_ids() {
            return array_keys( self::get_available_rates() );
        }

        public static function get_rate_choices() {
            $choices = array();
            foreach ( self::get_available_rates() as $rate_id => $rate ) {
                $choices[ $rate_id ] = sprintf(
                    '%s -> %s [%s]%s',
                    $rate['zone_name'],
                    $rate['title'],
                    $rate['rate_id'],
                    $rate['is_enabled'] ? '' : ' (disabled)'
                );
            }

            return $choices;
        }

        public static function get_rate_label( $rate_id ) {
            $rates = self::get_available_rates();
            if ( isset( $rates[ $rate_id ] ) ) {
                return self::get_rate_choices()[ $rate_id ];
            }

            return '';
        }

        public static function get_zone_ids_by_country( $country_code ) {
            global $wpdb;

            $country_code = strtoupper( sanitize_text_field( $country_code ) );
            if ( $country_code === '' ) {
                return array();
            }

            $locations_table = $wpdb->prefix . 'woocommerce_shipping_zone_locations';
            if ( ! self::table_exists( $locations_table ) ) {
                return array();
            }

            $query = $wpdb->prepare(
                "
                    SELECT DISTINCT zone_id
                    FROM {$locations_table}
                    WHERE location_type = %s
                    AND location_code = %s
                    ORDER BY zone_id ASC
                ",
                'country',
                $country_code
            );

            $rows = $wpdb->get_col( $query );
            if ( empty( $rows ) ) {
                return array();
            }

            return array_map( 'absint', $rows );
        }

        private static function table_exists( $table_name ) {
            global $wpdb;
            $existing = $wpdb->get_var(
                $wpdb->prepare(
                    'SHOW TABLES LIKE %s',
                    $table_name
                )
            );

            return $existing === $table_name;
        }
    }
}

