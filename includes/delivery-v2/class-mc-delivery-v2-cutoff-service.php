<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MC_Delivery_V2_Cutoff_Service' ) ) {
    class MC_Delivery_V2_Cutoff_Service {
        public static function get_timezone() {
            $cutoff_option = MC_Delivery_V2_Options::get_cutoff_rules_option();
            $timezone      = isset( $cutoff_option['timezone'] ) ? $cutoff_option['timezone'] : 'UTC';

            if ( ! in_array( $timezone, timezone_identifiers_list(), true ) ) {
                $timezone = 'UTC';
            }

            return $timezone;
        }

        public static function get_cutoff_by_rule_key( $rule_key ) {
            $cutoff_option = MC_Delivery_V2_Options::get_cutoff_rules_option();
            if ( ! isset( $cutoff_option['rules'][ $rule_key ]['cutoff'] ) ) {
                return '';
            }

            return sanitize_text_field( $cutoff_option['rules'][ $rule_key ]['cutoff'] );
        }

        public static function get_cutoff_for_method( $method_key ) {
            $map = MC_Delivery_V2_Options::get_method_cutoff_rule_map();
            if ( ! isset( $map[ $method_key ] ) ) {
                return '';
            }

            return self::get_cutoff_by_rule_key( $map[ $method_key ] );
        }

        public static function is_after_cutoff( $method_key, $timestamp = null ) {
            $cutoff = self::get_cutoff_for_method( $method_key );
            if ( $cutoff === '' ) {
                return false;
            }

            $timezone = new DateTimeZone( self::get_timezone() );
            $current  = new DateTime( 'now', $timezone );

            if ( $timestamp !== null ) {
                if ( is_numeric( $timestamp ) ) {
                    $current = new DateTime( '@' . intval( $timestamp ) );
                    $current->setTimezone( $timezone );
                } elseif ( $timestamp instanceof DateTime ) {
                    $current = clone $timestamp;
                    $current->setTimezone( $timezone );
                }
            }

            $today_cutoff = DateTime::createFromFormat( 'Y-m-d H:i', $current->format( 'Y-m-d' ) . ' ' . $cutoff, $timezone );
            if ( ! $today_cutoff ) {
                return false;
            }

            return $current > $today_cutoff;
        }
    }
}

