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

        public static function get_rate( $rate_id ) {
            $rate_id = sanitize_text_field( $rate_id );
            if ( $rate_id === '' ) {
                return null;
            }

            $rates = self::get_available_rates();
            if ( ! isset( $rates[ $rate_id ] ) ) {
                return null;
            }

            return $rates[ $rate_id ];
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
            $zones = self::get_country_zones( $country_code );
            if ( empty( $zones ) ) {
                return array();
            }

            return array_map(
                function ( $zone ) {
                    return absint( $zone['zone_id'] );
                },
                $zones
            );
        }

        public static function get_primary_zone_id_by_country( $country_code ) {
            $zones = self::get_country_zones( $country_code );
            if ( empty( $zones ) ) {
                return 0;
            }

            return absint( $zones[0]['zone_id'] );
        }

        public static function get_country_zones( $country_code ) {
            global $wpdb;

            $country_code = strtoupper( sanitize_text_field( $country_code ) );
            if ( $country_code === '' ) {
                return array();
            }

            $zones_table     = $wpdb->prefix . 'woocommerce_shipping_zones';
            $locations_table = $wpdb->prefix . 'woocommerce_shipping_zone_locations';
            if ( ! self::table_exists( $locations_table ) ) {
                return array();
            }

            $query = $wpdb->prepare(
                "
                    SELECT DISTINCT z.zone_id, z.zone_name, z.zone_order
                    FROM {$locations_table} l
                    LEFT JOIN {$zones_table} z ON z.zone_id = l.zone_id
                    WHERE l.location_type = %s
                    AND l.location_code = %s
                    ORDER BY z.zone_order ASC, z.zone_id ASC
                ",
                'country',
                $country_code
            );

            $rows = $wpdb->get_results( $query, ARRAY_A );
            if ( empty( $rows ) ) {
                return array();
            }

            $zones = array();
            foreach ( $rows as $row ) {
                $zone_id = isset( $row['zone_id'] ) ? absint( $row['zone_id'] ) : 0;
                if ( $zone_id <= 0 ) {
                    continue;
                }

                $zone_name = isset( $row['zone_name'] ) ? sanitize_text_field( $row['zone_name'] ) : '';
                if ( $zone_name === '' ) {
                    $zone_name = 'Zone #' . $zone_id;
                }

                $zones[] = array(
                    'zone_id'    => $zone_id,
                    'zone_name'  => $zone_name,
                    'zone_order' => isset( $row['zone_order'] ) ? intval( $row['zone_order'] ) : 0,
                );
            }

            return $zones;
        }

        public static function is_rate_in_zone( $rate_id, $zone_id ) {
            $zone_id = absint( $zone_id );
            if ( $zone_id <= 0 ) {
                return false;
            }

            $rate = self::get_rate( $rate_id );
            if ( empty( $rate ) || ! is_array( $rate ) ) {
                return false;
            }

            return absint( $rate['zone_id'] ) === $zone_id;
        }

        public static function get_zone_name_by_id( $zone_id ) {
            $zone_id = absint( $zone_id );
            if ( $zone_id <= 0 ) {
                return '';
            }

            foreach ( self::get_available_rates() as $rate ) {
                if ( absint( $rate['zone_id'] ) === $zone_id ) {
                    return isset( $rate['zone_name'] ) ? $rate['zone_name'] : '';
                }
            }

            global $wpdb;
            $zones_table = $wpdb->prefix . 'woocommerce_shipping_zones';
            if ( ! self::table_exists( $zones_table ) ) {
                return '';
            }

            $zone_name = $wpdb->get_var(
                $wpdb->prepare(
                    "
                        SELECT zone_name
                        FROM {$zones_table}
                        WHERE zone_id = %d
                        LIMIT 1
                    ",
                    $zone_id
                )
            );

            if ( ! is_string( $zone_name ) ) {
                return '';
            }

            return sanitize_text_field( $zone_name );
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
