<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MC_Delivery_V2_Diagnostics' ) ) {
    class MC_Delivery_V2_Diagnostics {
        public static function collect() {
            $checks = array();

            $checks[] = self::check_woocommerce();
            $checks[] = self::check_runtime_mode();
            $checks[] = self::check_matrix_rows();
            $checks[] = self::check_mapping_coverage();
            $checks[] = self::check_mapping_rate_existence();
            $checks[] = self::check_nl_zone_count();

            return $checks;
        }

        private static function check_woocommerce() {
            $is_active = class_exists( 'WooCommerce' );

            return array(
                'label'   => 'WooCommerce availability',
                'status'  => $is_active ? 'ok' : 'error',
                'details' => $is_active ? 'WooCommerce class loaded.' : 'WooCommerce is not active.',
            );
        }

        private static function check_runtime_mode() {
            $flags = MC_Delivery_V2_Options::get_flags_option();
            $mode  = isset( $flags['runtime_mode'] ) ? $flags['runtime_mode'] : '';

            $modes = MC_Delivery_V2_Options::get_runtime_mode_labels();

            return array(
                'label'   => 'Runtime mode',
                'status'  => isset( $modes[ $mode ] ) ? 'ok' : 'error',
                'details' => isset( $modes[ $mode ] ) ? 'Current mode: ' . $modes[ $mode ] : 'Unknown runtime mode.',
            );
        }

        private static function check_matrix_rows() {
            $rows = MC_Delivery_V2_Matrix_Service::get_rows();

            if ( empty( $rows ) ) {
                return array(
                    'label'   => 'Matrix rows',
                    'status'  => 'error',
                    'details' => 'No matrix rows found.',
                );
            }

            return array(
                'label'   => 'Matrix rows',
                'status'  => 'ok',
                'details' => 'Rows loaded: ' . count( $rows ),
            );
        }

        private static function check_mapping_coverage() {
            $mapping       = MC_Delivery_V2_Options::get_mapping_option();
            $required_keys = array_keys( MC_Delivery_V2_Options::get_method_labels() );
            $missing       = array();

            foreach ( $required_keys as $method_key ) {
                if ( empty( $mapping[ $method_key ] ) ) {
                    $missing[] = $method_key;
                }
            }

            if ( ! empty( $missing ) ) {
                return array(
                    'label'   => 'Required mapping coverage',
                    'status'  => 'warning',
                    'details' => 'Missing mapping for: ' . implode( ', ', $missing ),
                );
            }

            return array(
                'label'   => 'Required mapping coverage',
                'status'  => 'ok',
                'details' => 'All required methods mapped.',
            );
        }

        private static function check_mapping_rate_existence() {
            $mapping     = MC_Delivery_V2_Options::get_mapping_option();
            $rate_ids    = MC_Delivery_V2_Mapping_Repo::get_available_rate_ids();
            $invalid_map = array();

            foreach ( array_keys( MC_Delivery_V2_Options::get_method_labels() ) as $method_key ) {
                if ( empty( $mapping[ $method_key ] ) ) {
                    continue;
                }

                if ( ! in_array( $mapping[ $method_key ], $rate_ids, true ) ) {
                    $invalid_map[] = $method_key . ' -> ' . $mapping[ $method_key ];
                }
            }

            if ( ! empty( $invalid_map ) ) {
                return array(
                    'label'   => 'Mapped rate existence',
                    'status'  => 'error',
                    'details' => 'Unknown rate IDs: ' . implode( '; ', $invalid_map ),
                );
            }

            return array(
                'label'   => 'Mapped rate existence',
                'status'  => 'ok',
                'details' => 'All mapped rate IDs exist in Woo shipping methods.',
            );
        }

        private static function check_nl_zone_count() {
            $zone_ids = MC_Delivery_V2_Mapping_Repo::get_zone_ids_by_country( 'NL' );

            if ( count( $zone_ids ) > 1 ) {
                return array(
                    'label'   => 'NL shipping zones',
                    'status'  => 'warning',
                    'details' => 'Multiple NL zones detected: ' . implode( ', ', $zone_ids ),
                );
            }

            if ( empty( $zone_ids ) ) {
                return array(
                    'label'   => 'NL shipping zones',
                    'status'  => 'warning',
                    'details' => 'No NL zones detected by country mapping.',
                );
            }

            return array(
                'label'   => 'NL shipping zones',
                'status'  => 'ok',
                'details' => 'Single NL zone detected: ' . implode( ', ', $zone_ids ),
            );
        }
    }
}

