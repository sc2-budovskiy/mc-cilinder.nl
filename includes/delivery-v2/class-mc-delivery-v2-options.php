<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MC_Delivery_V2_Options' ) ) {
    class MC_Delivery_V2_Options {
        const OPTION_MATRIX       = 'mc_delivery_matrix_v2';
        const OPTION_MAPPING      = 'mc_delivery_mapping_v2';
        const OPTION_CUTOFF_RULES = 'mc_delivery_cutoff_rules_v2';
        const OPTION_FLAGS        = 'mc_delivery_flags_v2';

        const RUNTIME_MODE_LEGACY     = 'legacy';
        const RUNTIME_MODE_ADMIN_ONLY = 'admin_only_v2';
        const RUNTIME_MODE_CANARY     = 'canary_v2';
        const RUNTIME_MODE_FULL       = 'full_v2';

        public static function register_settings() {
            register_setting(
                'mc_delivery_matrix_v2_flags',
                self::OPTION_FLAGS,
                array(
                    'type'              => 'array',
                    'sanitize_callback' => array( __CLASS__, 'sanitize_flags_option' ),
                    'default'           => self::get_default_flags_option(),
                )
            );

            register_setting(
                'mc_delivery_matrix_v2_mapping',
                self::OPTION_MAPPING,
                array(
                    'type'              => 'array',
                    'sanitize_callback' => array( __CLASS__, 'sanitize_mapping_option' ),
                    'default'           => self::get_default_mapping_option(),
                )
            );

            register_setting(
                'mc_delivery_matrix_v2_cutoff',
                self::OPTION_CUTOFF_RULES,
                array(
                    'type'              => 'array',
                    'sanitize_callback' => array( __CLASS__, 'sanitize_cutoff_rules_option' ),
                    'default'           => self::get_default_cutoff_rules_option(),
                )
            );

            register_setting(
                'mc_delivery_matrix_v2_matrix',
                self::OPTION_MATRIX,
                array(
                    'type'              => 'array',
                    'sanitize_callback' => array( __CLASS__, 'sanitize_matrix_option' ),
                    'default'           => self::get_default_matrix_option(),
                )
            );
        }

        public static function ensure_defaults() {
            self::maybe_add_option( self::OPTION_FLAGS, self::get_default_flags_option() );
            self::maybe_add_option( self::OPTION_MAPPING, self::get_default_mapping_option() );
            self::maybe_add_option( self::OPTION_CUTOFF_RULES, self::get_default_cutoff_rules_option() );
            self::maybe_add_option( self::OPTION_MATRIX, self::get_default_matrix_option() );
        }

        public static function get_runtime_mode_labels() {
            return array(
                self::RUNTIME_MODE_LEGACY     => 'Legacy',
                self::RUNTIME_MODE_ADMIN_ONLY => 'Admin Only V2',
                self::RUNTIME_MODE_CANARY     => 'Canary V2',
                self::RUNTIME_MODE_FULL       => 'Full V2',
            );
        }

        public static function get_method_labels() {
            return array(
                'postnl_parcel'           => 'PostNL parcel',
                'postnl_letterbox'        => 'PostNL letterbox parcel',
                'postnl_collection_point' => 'PostNL collection point (Innosend)',
                'trunkrs_evening_delivery'=> 'Evening delivery (DHL/Trunkrs)',
                'pickup_by_appointment'   => 'Pickup (by appointment)',
            );
        }

        public static function get_scenario_labels() {
            return array(
                'new_order_before_cutoff' => 'New order before cut-off',
                'new_order_after_cutoff'  => 'New order after cut-off',
                'reorder_before_cutoff'   => 'Reorder before cut-off',
                'reorder_after_cutoff'    => 'Reorder after cut-off',
            );
        }

        public static function get_method_cutoff_rule_map() {
            return array(
                'postnl_parcel'            => 'postnl_standard_cutoff',
                'postnl_letterbox'         => 'postnl_standard_cutoff',
                'postnl_collection_point'  => 'postnl_standard_cutoff',
                'trunkrs_evening_delivery' => 'evening_delivery_cutoff',
                'pickup_by_appointment'    => 'pickup_by_appointment_cutoff',
            );
        }

        public static function get_flags_option() {
            $defaults = self::get_default_flags_option();
            $value    = get_option( self::OPTION_FLAGS, array() );
            if ( ! is_array( $value ) ) {
                return $defaults;
            }

            $result = wp_parse_args( $value, $defaults );

            if ( ! isset( $result['canary_user_ids'] ) || ! is_array( $result['canary_user_ids'] ) ) {
                $result['canary_user_ids'] = array();
            }

            return $result;
        }

        public static function get_mapping_option() {
            $defaults = self::get_default_mapping_option();
            $value    = get_option( self::OPTION_MAPPING, array() );
            if ( ! is_array( $value ) ) {
                return $defaults;
            }

            return wp_parse_args( $value, $defaults );
        }

        public static function get_cutoff_rules_option() {
            $defaults = self::get_default_cutoff_rules_option();
            $value    = get_option( self::OPTION_CUTOFF_RULES, array() );
            if ( ! is_array( $value ) ) {
                return $defaults;
            }

            $result            = $defaults;
            $result['timezone'] = isset( $value['timezone'] ) ? sanitize_text_field( $value['timezone'] ) : $defaults['timezone'];

            if ( isset( $value['rules'] ) && is_array( $value['rules'] ) ) {
                foreach ( $defaults['rules'] as $rule_key => $rule_defaults ) {
                    if ( isset( $value['rules'][ $rule_key ]['cutoff'] ) ) {
                        $result['rules'][ $rule_key ]['cutoff'] = sanitize_text_field( $value['rules'][ $rule_key ]['cutoff'] );
                    }
                }
            }

            return $result;
        }

        public static function get_matrix_option() {
            $defaults = self::get_default_matrix_option();
            $value    = get_option( self::OPTION_MATRIX, array() );
            if ( ! is_array( $value ) ) {
                return $defaults;
            }

            $result = $defaults;

            if ( isset( $value['version'] ) ) {
                $result['version'] = absint( $value['version'] );
            }

            if ( isset( $value['rows'] ) && is_array( $value['rows'] ) ) {
                $result['rows'] = $value['rows'];
            }

            if ( isset( $value['updated_at'] ) ) {
                $result['updated_at'] = sanitize_text_field( $value['updated_at'] );
            }

            return $result;
        }

        public static function sanitize_flags_option( $value ) {
            $defaults = self::get_default_flags_option();
            $value    = is_array( $value ) ? $value : array();

            $runtime_modes = self::get_runtime_mode_labels();
            $runtime_mode  = isset( $value['runtime_mode'] ) ? sanitize_text_field( $value['runtime_mode'] ) : $defaults['runtime_mode'];

            if ( ! isset( $runtime_modes[ $runtime_mode ] ) ) {
                $runtime_mode = self::RUNTIME_MODE_LEGACY;
            }

            $canary_percentage = isset( $value['canary_percentage'] ) ? absint( $value['canary_percentage'] ) : $defaults['canary_percentage'];
            if ( $canary_percentage > 100 ) {
                $canary_percentage = 100;
            }

            $canary_user_ids = array();
            if ( isset( $value['canary_user_ids_raw'] ) ) {
                $canary_user_ids = self::parse_csv_user_ids( $value['canary_user_ids_raw'] );
            } elseif ( isset( $value['canary_user_ids'] ) && is_array( $value['canary_user_ids'] ) ) {
                $canary_user_ids = array_map( 'absint', $value['canary_user_ids'] );
                $canary_user_ids = array_filter( $canary_user_ids );
            }

            return array(
                'version'              => 1,
                'runtime_mode'         => $runtime_mode,
                'canary_percentage'    => $canary_percentage,
                'canary_user_ids'      => array_values( array_unique( $canary_user_ids ) ),
                'enable_admin_preview' => self::sanitize_checkbox_value( $value, 'enable_admin_preview' ),
                'updated_at'           => current_time( 'mysql' ),
            );
        }

        public static function sanitize_mapping_option( $value ) {
            $defaults   = self::get_default_mapping_option();
            $value      = is_array( $value ) ? $value : array();
            $sanitized  = $defaults;
            $rate_ids   = MC_Delivery_V2_Mapping_Repo::get_available_rate_ids();

            foreach ( array_keys( self::get_method_labels() ) as $method_key ) {
                if ( empty( $value[ $method_key ] ) ) {
                    continue;
                }

                $rate_id = sanitize_text_field( $value[ $method_key ] );
                if ( in_array( $rate_id, $rate_ids, true ) ) {
                    $sanitized[ $method_key ] = $rate_id;
                }
            }

            $sanitized['updated_at'] = current_time( 'mysql' );

            return $sanitized;
        }

        public static function sanitize_cutoff_rules_option( $value ) {
            $defaults = self::get_default_cutoff_rules_option();
            $value    = is_array( $value ) ? $value : array();
            $result   = $defaults;

            if ( isset( $value['timezone'] ) && in_array( $value['timezone'], timezone_identifiers_list(), true ) ) {
                $result['timezone'] = sanitize_text_field( $value['timezone'] );
            }

            if ( isset( $value['rules'] ) && is_array( $value['rules'] ) ) {
                foreach ( $defaults['rules'] as $rule_key => $rule_defaults ) {
                    if ( ! isset( $value['rules'][ $rule_key ]['cutoff'] ) ) {
                        continue;
                    }

                    $cutoff = sanitize_text_field( $value['rules'][ $rule_key ]['cutoff'] );
                    if ( $cutoff === '' || preg_match( '/^(?:[01][0-9]|2[0-3]):[0-5][0-9]$/', $cutoff ) ) {
                        $result['rules'][ $rule_key ]['cutoff'] = $cutoff;
                    }
                }
            }

            $result['version']    = 1;
            $result['updated_at'] = current_time( 'mysql' );

            return $result;
        }

        public static function sanitize_matrix_option( $value ) {
            $defaults = self::get_default_matrix_option();
            $value    = is_array( $value ) ? $value : array();

            if ( ! isset( $value['rows'] ) || ! is_array( $value['rows'] ) ) {
                return $defaults;
            }

            $valid_scenarios = array_keys( self::get_scenario_labels() );
            $valid_methods   = array_keys( self::get_method_labels() );
            $rows            = array();

            foreach ( $value['rows'] as $row ) {
                if ( ! is_array( $row ) ) {
                    continue;
                }

                $scenario_key = isset( $row['scenario_key'] ) ? sanitize_text_field( $row['scenario_key'] ) : '';
                $method_key   = isset( $row['method_key'] ) ? sanitize_text_field( $row['method_key'] ) : '';

                if ( ! in_array( $scenario_key, $valid_scenarios, true ) || ! in_array( $method_key, $valid_methods, true ) ) {
                    continue;
                }

                $rows[] = array(
                    'scenario_key'         => $scenario_key,
                    'method_key'           => $method_key,
                    'title_checkout'       => isset( $row['title_checkout'] ) ? sanitize_text_field( $row['title_checkout'] ) : '',
                    'delivery_promise_text'=> isset( $row['delivery_promise_text'] ) ? sanitize_text_field( $row['delivery_promise_text'] ) : '',
                    'price_expected'       => isset( $row['price_expected'] ) ? sanitize_text_field( $row['price_expected'] ) : '',
                    'enabled'              => empty( $row['enabled'] ) ? 0 : 1,
                    'is_default'           => empty( $row['is_default'] ) ? 0 : 1,
                    'sort_order'           => isset( $row['sort_order'] ) ? intval( $row['sort_order'] ) : 0,
                    'allowed_countries'    => isset( $row['allowed_countries'] ) && is_array( $row['allowed_countries'] ) ? array_map( 'sanitize_text_field', $row['allowed_countries'] ) : array( 'NL' ),
                    'cutoff_rule_key'      => isset( $row['cutoff_rule_key'] ) ? sanitize_text_field( $row['cutoff_rule_key'] ) : '',
                    'resolved_rate_id'     => isset( $row['resolved_rate_id'] ) ? sanitize_text_field( $row['resolved_rate_id'] ) : '',
                );
            }

            if ( empty( $rows ) ) {
                $rows = $defaults['rows'];
            }

            return array(
                'version'    => 1,
                'rows'       => $rows,
                'updated_at' => current_time( 'mysql' ),
            );
        }

        public static function get_default_flags_option() {
            return array(
                'version'              => 1,
                'runtime_mode'         => self::RUNTIME_MODE_LEGACY,
                'canary_percentage'    => 0,
                'canary_user_ids'      => array(),
                'enable_admin_preview' => 1,
                'updated_at'           => current_time( 'mysql' ),
            );
        }

        public static function get_default_mapping_option() {
            $mapping = array(
                'version'    => 1,
                'updated_at' => current_time( 'mysql' ),
            );

            foreach ( array_keys( self::get_method_labels() ) as $method_key ) {
                $mapping[ $method_key ] = '';
            }

            return $mapping;
        }

        public static function get_default_cutoff_rules_option() {
            return array(
                'version'    => 1,
                'timezone'   => 'Europe/Amsterdam',
                'rules'      => array(
                    'postnl_standard_cutoff' => array(
                        'label'  => 'PostNL (parcel/letterbox/collection point)',
                        'cutoff' => '16:00',
                    ),
                    'evening_delivery_cutoff' => array(
                        'label'  => 'Evening delivery (DHL/Trunkrs)',
                        'cutoff' => '23:59',
                    ),
                    'pickup_by_appointment_cutoff' => array(
                        'label'  => 'Pickup (by appointment)',
                        'cutoff' => '',
                    ),
                ),
                'updated_at' => current_time( 'mysql' ),
            );
        }

        public static function get_default_matrix_option() {
            return array(
                'version'    => 1,
                'rows'       => self::build_default_matrix_rows(),
                'updated_at' => current_time( 'mysql' ),
            );
        }

        private static function build_default_matrix_rows() {
            $scenarios = self::get_scenario_labels();
            $methods   = array(
                'postnl_parcel' => array(
                    'title_checkout' => 'PostNL parcel',
                    'price_expected' => '2.95',
                    'sort_order'     => 10,
                    'is_default'     => 1,
                ),
                'postnl_letterbox' => array(
                    'title_checkout' => 'PostNL letterbox parcel',
                    'price_expected' => '1.95',
                    'sort_order'     => 20,
                    'is_default'     => 0,
                ),
                'postnl_collection_point' => array(
                    'title_checkout' => 'PostNL collection point',
                    'price_expected' => '0.00',
                    'sort_order'     => 30,
                    'is_default'     => 0,
                ),
                'trunkrs_evening_delivery' => array(
                    'title_checkout' => 'Evening delivery',
                    'price_expected' => '3.95',
                    'sort_order'     => 40,
                    'is_default'     => 0,
                ),
                'pickup_by_appointment' => array(
                    'title_checkout' => 'Pickup (by appointment)',
                    'price_expected' => '0.00',
                    'sort_order'     => 50,
                    'is_default'     => 0,
                ),
            );

            $method_cutoff_map = self::get_method_cutoff_rule_map();
            $rows              = array();

            foreach ( array_keys( $scenarios ) as $scenario_key ) {
                foreach ( $methods as $method_key => $method_settings ) {
                    $rows[] = array(
                        'scenario_key'          => $scenario_key,
                        'method_key'            => $method_key,
                        'title_checkout'        => $method_settings['title_checkout'],
                        'delivery_promise_text' => '',
                        'price_expected'        => $method_settings['price_expected'],
                        'enabled'               => 1,
                        'is_default'            => $method_settings['is_default'],
                        'sort_order'            => $method_settings['sort_order'],
                        'allowed_countries'     => array( 'NL' ),
                        'cutoff_rule_key'       => isset( $method_cutoff_map[ $method_key ] ) ? $method_cutoff_map[ $method_key ] : '',
                        'resolved_rate_id'      => '',
                    );
                }
            }

            return $rows;
        }

        private static function maybe_add_option( $option_name, $default_value ) {
            if ( get_option( $option_name, null ) === null ) {
                add_option( $option_name, $default_value, '', false );
            }
        }

        private static function sanitize_checkbox_value( $source, $key ) {
            return empty( $source[ $key ] ) ? 0 : 1;
        }

        private static function parse_csv_user_ids( $value ) {
            $value = is_scalar( $value ) ? (string) $value : '';
            if ( trim( $value ) === '' ) {
                return array();
            }

            $parts = array_map( 'trim', explode( ',', $value ) );
            $parts = array_filter( $parts, 'strlen' );
            $ids   = array_map( 'absint', $parts );
            $ids   = array_filter( $ids );

            return array_values( array_unique( $ids ) );
        }
    }
}

