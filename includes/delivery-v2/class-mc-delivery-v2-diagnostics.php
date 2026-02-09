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
            $checks[] = self::check_runtime_resolution();
            $checks[] = self::check_matrix_rows();
            $checks[] = self::check_scenario_defaults();
            $checks[] = self::check_mapping_coverage();
            $checks[] = self::check_mapping_rate_existence();
            $checks[] = self::check_mapping_rate_uniqueness();
            $checks[] = self::check_mapping_method_type_compatibility();
            $checks[] = self::check_mapping_rate_enabled();
            $checks[] = self::check_mapping_primary_nl_zone();
            $checks[] = self::check_nl_zone_count();

            return $checks;
        }

        public static function get_blocking_errors() {
            $errors = array();
            foreach ( self::collect_strict_runtime_checks() as $check ) {
                if ( isset( $check['status'] ) && $check['status'] === 'error' ) {
                    $errors[] = $check;
                }
            }

            return $errors;
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

        private static function check_runtime_resolution() {
            if ( ! class_exists( 'MC_Delivery_V2_Runtime' ) ) {
                return array(
                    'label'   => 'Runtime resolution',
                    'status'  => 'error',
                    'details' => 'Runtime service is not available.',
                );
            }

            $details = MC_Delivery_V2_Runtime::get_runtime_resolution_details();

            $parts = array(
                'Enabled now: ' . ( ! empty( $details['enabled_for_request'] ) ? 'yes' : 'no' ),
                'Bucket: ' . ( isset( $details['bucket'] ) ? intval( $details['bucket'] ) : 0 ),
                'User ID: ' . ( isset( $details['current_user_id'] ) ? intval( $details['current_user_id'] ) : 0 ),
            );

            $status = 'ok';
            $strict_error_count = isset( $details['strict_error_count'] ) ? absint( $details['strict_error_count'] ) : 0;
            if ( $strict_error_count > 0 ) {
                $status  = 'error';
                $parts[] = 'Strict gate blocked by ' . $strict_error_count . ' error(s)';
                if ( ! empty( $details['strict_error_labels'] ) && is_array( $details['strict_error_labels'] ) ) {
                    $parts[] = 'Strict checks: ' . implode( ', ', array_filter( $details['strict_error_labels'] ) );
                }
            }

            if ( $status !== 'error' && empty( $details['enabled_for_request'] ) && $details['mode'] !== MC_Delivery_V2_Options::RUNTIME_MODE_LEGACY ) {
                $status = 'warning';
            }

            return array(
                'label'   => 'Runtime resolution',
                'status'  => $status,
                'details' => implode( '; ', $parts ),
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

        private static function check_scenario_defaults() {
            $rows            = MC_Delivery_V2_Matrix_Service::get_rows();
            $scenario_labels = MC_Delivery_V2_Options::get_scenario_labels();
            $scenario_stats  = array();
            $messages        = array();
            $status          = 'ok';

            foreach ( array_keys( $scenario_labels ) as $scenario_key ) {
                $scenario_stats[ $scenario_key ] = array(
                    'rows'             => 0,
                    'enabled_defaults' => 0,
                );
            }

            foreach ( $rows as $row ) {
                if ( empty( $row['scenario_key'] ) || ! isset( $scenario_stats[ $row['scenario_key'] ] ) ) {
                    continue;
                }

                $scenario_stats[ $row['scenario_key'] ]['rows']++;

                if ( ! empty( $row['enabled'] ) && ! empty( $row['is_default'] ) ) {
                    $scenario_stats[ $row['scenario_key'] ]['enabled_defaults']++;
                }
            }

            foreach ( $scenario_stats as $scenario_key => $stats ) {
                $scenario_label = isset( $scenario_labels[ $scenario_key ] ) ? $scenario_labels[ $scenario_key ] : $scenario_key;

                if ( $stats['rows'] === 0 ) {
                    $status     = 'warning';
                    $messages[] = 'No matrix rows configured for scenario "' . $scenario_label . '".';
                    continue;
                }

                if ( $stats['enabled_defaults'] === 1 ) {
                    continue;
                }

                $status = 'warning';
                if ( $stats['enabled_defaults'] === 0 ) {
                    $messages[] = 'No enabled default method for scenario "' . $scenario_label . '".';
                } else {
                    $messages[] = 'Multiple enabled defaults for scenario "' . $scenario_label . '".';
                }
            }

            return array(
                'label'   => 'Scenario defaults',
                'status'  => $status,
                'details' => empty( $messages ) ? 'Exactly one enabled default method configured per scenario.' : implode( '; ', $messages ),
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
                    'status'  => 'error',
                    'details' => 'Missing mapping for: ' . implode( ', ', $missing ),
                );
            }

            return array(
                'label'   => 'Required mapping coverage',
                'status'  => 'ok',
                'details' => 'All required methods mapped.',
            );
        }

        private static function check_mapping_rate_enabled() {
            $mapping   = MC_Delivery_V2_Options::get_mapping_option();
            $invalid   = array();
            $rate_cache = MC_Delivery_V2_Mapping_Repo::get_available_rates();

            foreach ( array_keys( MC_Delivery_V2_Options::get_method_labels() ) as $method_key ) {
                if ( empty( $mapping[ $method_key ] ) ) {
                    continue;
                }

                $rate_id = sanitize_text_field( $mapping[ $method_key ] );
                if ( ! isset( $rate_cache[ $rate_id ] ) ) {
                    continue;
                }

                if ( empty( $rate_cache[ $rate_id ]['is_enabled'] ) ) {
                    $invalid[] = $method_key . ' -> ' . $rate_id;
                }
            }

            if ( ! empty( $invalid ) ) {
                return array(
                    'label'   => 'Mapped rate enabled state',
                    'status'  => 'error',
                    'details' => 'Mapped rate is disabled: ' . implode( '; ', $invalid ),
                );
            }

            return array(
                'label'   => 'Mapped rate enabled state',
                'status'  => 'ok',
                'details' => 'All mapped rates are enabled.',
            );
        }

        private static function check_mapping_rate_uniqueness() {
            $mapping    = MC_Delivery_V2_Options::get_mapping_option();
            $rate_usage = array();
            $duplicates = array();

            foreach ( array_keys( MC_Delivery_V2_Options::get_method_labels() ) as $method_key ) {
                if ( empty( $mapping[ $method_key ] ) ) {
                    continue;
                }

                $rate_id = sanitize_text_field( $mapping[ $method_key ] );
                if ( $rate_id === '' ) {
                    continue;
                }

                if ( ! isset( $rate_usage[ $rate_id ] ) ) {
                    $rate_usage[ $rate_id ] = array();
                }

                $rate_usage[ $rate_id ][] = $method_key;
            }

            foreach ( $rate_usage as $rate_id => $method_keys ) {
                if ( count( $method_keys ) <= 1 ) {
                    continue;
                }

                $duplicates[] = $rate_id . ' <- ' . implode( ', ', $method_keys );
            }

            if ( ! empty( $duplicates ) ) {
                return array(
                    'label'   => 'Mapped rate uniqueness',
                    'status'  => 'error',
                    'details' => 'One Woo rate is mapped to multiple method keys: ' . implode( '; ', $duplicates ),
                );
            }

            return array(
                'label'   => 'Mapped rate uniqueness',
                'status'  => 'ok',
                'details' => 'Each method key maps to a unique Woo rate ID.',
            );
        }

        private static function check_mapping_method_type_compatibility() {
            $mapping       = MC_Delivery_V2_Options::get_mapping_option();
            $compatibility = self::get_method_type_compatibility_map();
            $invalid       = array();

            foreach ( $compatibility as $method_key => $allowed_method_ids ) {
                if ( empty( $mapping[ $method_key ] ) ) {
                    continue;
                }

                $rate_id = sanitize_text_field( $mapping[ $method_key ] );
                if ( $rate_id === '' ) {
                    continue;
                }

                $rate = MC_Delivery_V2_Mapping_Repo::get_rate( $rate_id );
                if ( empty( $rate ) || ! is_array( $rate ) || empty( $rate['method_id'] ) ) {
                    continue;
                }

                $actual_method_id = sanitize_text_field( $rate['method_id'] );
                if ( in_array( $actual_method_id, $allowed_method_ids, true ) ) {
                    continue;
                }

                $invalid[] = $method_key . ' -> ' . $rate_id . ' (method_id: ' . $actual_method_id . ', expected: ' . implode( '|', $allowed_method_ids ) . ')';
            }

            if ( ! empty( $invalid ) ) {
                return array(
                    'label'   => 'Mapped method type compatibility',
                    'status'  => 'error',
                    'details' => 'Mapped rate method_id is not allowed: ' . implode( '; ', $invalid ),
                );
            }

            return array(
                'label'   => 'Mapped method type compatibility',
                'status'  => 'ok',
                'details' => 'All mapped method types are compatible with canonical method keys.',
            );
        }

        private static function check_mapping_primary_nl_zone() {
            $mapping          = MC_Delivery_V2_Options::get_mapping_option();
            $primary_nl_zone  = MC_Delivery_V2_Mapping_Repo::get_primary_zone_id_by_country( 'NL' );
            $primary_nl_label = MC_Delivery_V2_Mapping_Repo::get_zone_name_by_id( $primary_nl_zone );
            $invalid          = array();

            if ( $primary_nl_zone <= 0 ) {
                return array(
                    'label'   => 'Mapped rate NL zone alignment',
                    'status'  => 'error',
                    'details' => 'No primary NL shipping zone detected.',
                );
            }

            foreach ( array_keys( MC_Delivery_V2_Options::get_method_labels() ) as $method_key ) {
                if ( empty( $mapping[ $method_key ] ) ) {
                    continue;
                }

                $rate_id = sanitize_text_field( $mapping[ $method_key ] );
                $rate    = MC_Delivery_V2_Mapping_Repo::get_rate( $rate_id );
                if ( empty( $rate ) || ! is_array( $rate ) ) {
                    continue;
                }

                if ( absint( $rate['zone_id'] ) !== $primary_nl_zone ) {
                    $invalid[] = $method_key . ' -> ' . $rate_id . ' (zone: ' . $rate['zone_name'] . ')';
                }
            }

            if ( ! empty( $invalid ) ) {
                return array(
                    'label'   => 'Mapped rate NL zone alignment',
                    'status'  => 'error',
                    'details' => 'Expected primary NL zone #' . $primary_nl_zone . ( $primary_nl_label ? ' (' . $primary_nl_label . ')' : '' ) . '. Mismatches: ' . implode( '; ', $invalid ),
                );
            }

            return array(
                'label'   => 'Mapped rate NL zone alignment',
                'status'  => 'ok',
                'details' => 'All mapped rates belong to primary NL zone #' . $primary_nl_zone . ( $primary_nl_label ? ' (' . $primary_nl_label . ')' : '' ) . '.',
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

        private static function collect_strict_runtime_checks() {
            return array(
                self::check_woocommerce(),
                self::check_matrix_rows(),
                self::check_scenario_defaults(),
                self::check_mapping_coverage(),
                self::check_mapping_rate_existence(),
                self::check_mapping_rate_uniqueness(),
                self::check_mapping_method_type_compatibility(),
                self::check_mapping_rate_enabled(),
                self::check_mapping_primary_nl_zone(),
            );
        }

        private static function get_method_type_compatibility_map() {
            $map = array(
                'postnl_parcel'           => array( 'flat_rate' ),
                'postnl_letterbox'        => array( 'flat_rate' ),
                'postnl_collection_point' => array( 'innosend', 'service_point_shipping_method' ),
                'trunkrs_evening_delivery'=> array( 'flat_rate', 'trunkrs', 'trunkrs_shipping', 'trunkrs_delivery' ),
                'pickup_by_appointment'   => array( 'local_pickup' ),
            );

            $map = apply_filters( 'mc_delivery_v2_method_type_compatibility_map', $map );
            if ( ! is_array( $map ) ) {
                return array();
            }

            foreach ( $map as $method_key => $method_ids ) {
                if ( ! is_array( $method_ids ) ) {
                    $map[ $method_key ] = array();
                    continue;
                }

                $map[ $method_key ] = array_values(
                    array_filter(
                        array_unique(
                            array_map( 'sanitize_text_field', $method_ids )
                        ),
                        'strlen'
                    )
                );
            }

            return $map;
        }
    }
}
