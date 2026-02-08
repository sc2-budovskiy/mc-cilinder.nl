<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MC_Delivery_V2_Matrix_Service' ) ) {
    class MC_Delivery_V2_Matrix_Service {
        public static function get_rows() {
            $matrix = MC_Delivery_V2_Options::get_matrix_option();
            if ( empty( $matrix['rows'] ) || ! is_array( $matrix['rows'] ) ) {
                return array();
            }

            return $matrix['rows'];
        }

        public static function get_rows_for_scenario( $scenario_key ) {
            $rows     = self::get_rows();
            $filtered = array();

            foreach ( $rows as $row ) {
                if ( ! is_array( $row ) || empty( $row['scenario_key'] ) ) {
                    continue;
                }

                if ( $row['scenario_key'] === $scenario_key ) {
                    $filtered[] = $row;
                }
            }

            usort(
                $filtered,
                function ( $a, $b ) {
                    $a_order = isset( $a['sort_order'] ) ? intval( $a['sort_order'] ) : 0;
                    $b_order = isset( $b['sort_order'] ) ? intval( $b['sort_order'] ) : 0;
                    if ( $a_order === $b_order ) {
                        return 0;
                    }

                    return ( $a_order < $b_order ) ? -1 : 1;
                }
            );

            return $filtered;
        }

        public static function get_row( $scenario_key, $method_key ) {
            foreach ( self::get_rows() as $row ) {
                if ( empty( $row['scenario_key'] ) || empty( $row['method_key'] ) ) {
                    continue;
                }

                if ( $row['scenario_key'] === $scenario_key && $row['method_key'] === $method_key ) {
                    return $row;
                }
            }

            return null;
        }
    }
}

