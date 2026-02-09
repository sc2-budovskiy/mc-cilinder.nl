<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MC_Delivery_V2_Runtime' ) ) {
    class MC_Delivery_V2_Runtime {
        const GUEST_CANARY_COOKIE = 'mc_delivery_v2_canary_bucket';

        private static $cached_is_enabled = null;
        private static $strict_gate_result = null;

        public static function register_hooks() {
            add_action( 'init', array( __CLASS__, 'maybe_seed_guest_canary_bucket' ), 1 );
        }

        public static function get_runtime_mode() {
            $flags = MC_Delivery_V2_Options::get_flags_option();
            return isset( $flags['runtime_mode'] ) ? $flags['runtime_mode'] : MC_Delivery_V2_Options::RUNTIME_MODE_LEGACY;
        }

        public static function is_enabled_for_request() {
            if ( self::$cached_is_enabled !== null ) {
                return self::$cached_is_enabled;
            }

            $mode  = self::get_runtime_mode();
            $flags = MC_Delivery_V2_Options::get_flags_option();
            $value = false;

            switch ( $mode ) {
                case MC_Delivery_V2_Options::RUNTIME_MODE_FULL:
                    $value = true;
                    break;

                case MC_Delivery_V2_Options::RUNTIME_MODE_ADMIN_ONLY:
                    $value = self::is_admin_preview_user();
                    break;

                case MC_Delivery_V2_Options::RUNTIME_MODE_CANARY:
                    $value = self::is_canary_match( $flags );
                    break;

                case MC_Delivery_V2_Options::RUNTIME_MODE_LEGACY:
                default:
                    $value = false;
                    break;
            }

            $value = (bool) apply_filters( 'mc_delivery_v2_is_enabled_for_request', $value, $mode, $flags );

            self::$strict_gate_result = self::evaluate_strict_gate( $mode, $value );
            if ( ! self::$strict_gate_result['passed'] ) {
                $value = false;
            }

            self::$cached_is_enabled = $value;

            return $value;
        }

        public static function is_admin_preview_user() {
            return is_user_logged_in() && current_user_can( 'manage_options' );
        }

        public static function get_runtime_resolution_details() {
            $flags = MC_Delivery_V2_Options::get_flags_option();
            $mode  = self::get_runtime_mode();
            $strict_gate = self::get_strict_gate_result();

            return array(
                'mode'                => $mode,
                'enabled_for_request' => self::is_enabled_for_request(),
                'is_admin_preview'    => self::is_admin_preview_user(),
                'current_user_id'     => get_current_user_id(),
                'canary_percentage'   => isset( $flags['canary_percentage'] ) ? absint( $flags['canary_percentage'] ) : 0,
                'canary_user_ids'     => isset( $flags['canary_user_ids'] ) && is_array( $flags['canary_user_ids'] ) ? $flags['canary_user_ids'] : array(),
                'bucket'              => self::get_request_bucket(),
                'strict_gate_passed'  => ! empty( $strict_gate['passed'] ),
                'strict_error_count'  => isset( $strict_gate['errors'] ) && is_array( $strict_gate['errors'] ) ? count( $strict_gate['errors'] ) : 0,
                'strict_error_labels' => isset( $strict_gate['errors'] ) && is_array( $strict_gate['errors'] ) ? array_map( array( __CLASS__, 'extract_check_label' ), $strict_gate['errors'] ) : array(),
            );
        }

        public static function maybe_seed_guest_canary_bucket() {
            if ( is_admin() && ! self::is_doing_ajax() ) {
                return;
            }

            if ( is_user_logged_in() ) {
                return;
            }

            $mode  = self::get_runtime_mode();
            $flags = MC_Delivery_V2_Options::get_flags_option();
            $pct   = isset( $flags['canary_percentage'] ) ? absint( $flags['canary_percentage'] ) : 0;

            if ( $mode !== MC_Delivery_V2_Options::RUNTIME_MODE_CANARY || $pct <= 0 ) {
                return;
            }

            if ( isset( $_COOKIE[ self::GUEST_CANARY_COOKIE ] ) ) {
                return;
            }

            $bucket = wp_rand( 1, 100 );
            self::set_guest_bucket_cookie( $bucket );
        }

        private static function is_canary_match( $flags ) {
            if ( ! empty( $flags['enable_admin_preview'] ) && self::is_admin_preview_user() ) {
                return true;
            }

            $user_id = get_current_user_id();
            if ( $user_id > 0 ) {
                $ids = isset( $flags['canary_user_ids'] ) && is_array( $flags['canary_user_ids'] ) ? array_map( 'absint', $flags['canary_user_ids'] ) : array();
                if ( in_array( $user_id, $ids, true ) ) {
                    return true;
                }
            }

            $percentage = isset( $flags['canary_percentage'] ) ? absint( $flags['canary_percentage'] ) : 0;
            if ( $percentage <= 0 ) {
                return false;
            }

            if ( $percentage >= 100 ) {
                return true;
            }

            $bucket = self::get_request_bucket();
            if ( $bucket <= 0 ) {
                return false;
            }

            return $bucket <= $percentage;
        }

        private static function get_request_bucket() {
            $user_id = get_current_user_id();
            if ( $user_id > 0 ) {
                return self::hash_to_bucket( 'user:' . $user_id );
            }

            if ( isset( $_COOKIE[ self::GUEST_CANARY_COOKIE ] ) ) {
                $bucket = absint( $_COOKIE[ self::GUEST_CANARY_COOKIE ] );
                if ( $bucket >= 1 && $bucket <= 100 ) {
                    return $bucket;
                }
            }

            $bucket = wp_rand( 1, 100 );
            self::set_guest_bucket_cookie( $bucket );

            return $bucket;
        }

        private static function hash_to_bucket( $value ) {
            $hash = crc32( $value );
            if ( $hash < 0 ) {
                $hash = $hash * -1;
            }

            return ( $hash % 100 ) + 1;
        }

        private static function set_guest_bucket_cookie( $bucket ) {
            if ( headers_sent() ) {
                return;
            }

            $bucket = absint( $bucket );
            if ( $bucket < 1 || $bucket > 100 ) {
                return;
            }

            $secure = is_ssl();
            $domain = defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : '';
            $path   = defined( 'COOKIEPATH' ) && COOKIEPATH ? COOKIEPATH : '/';
            $expire = time() + ( DAY_IN_SECONDS * 30 );

            setcookie(
                self::GUEST_CANARY_COOKIE,
                (string) $bucket,
                $expire,
                $path,
                $domain,
                $secure,
                true
            );

            $_COOKIE[ self::GUEST_CANARY_COOKIE ] = (string) $bucket;
        }

        private static function is_doing_ajax() {
            if ( function_exists( 'wp_doing_ajax' ) ) {
                return wp_doing_ajax();
            }

            return defined( 'DOING_AJAX' ) && DOING_AJAX;
        }

        private static function evaluate_strict_gate( $mode, $current_value ) {
            if ( ! $current_value || $mode === MC_Delivery_V2_Options::RUNTIME_MODE_LEGACY ) {
                return array(
                    'passed' => true,
                    'errors' => array(),
                );
            }

            if ( ! class_exists( 'MC_Delivery_V2_Diagnostics' ) ) {
                return array(
                    'passed' => false,
                    'errors' => array(
                        array(
                            'label'   => 'Diagnostics availability',
                            'status'  => 'error',
                            'details' => 'Diagnostics service is not available.',
                        ),
                    ),
                );
            }

            $blocking_errors = MC_Delivery_V2_Diagnostics::get_blocking_errors();

            return array(
                'passed' => empty( $blocking_errors ),
                'errors' => $blocking_errors,
            );
        }

        private static function get_strict_gate_result() {
            if ( self::$strict_gate_result !== null ) {
                return self::$strict_gate_result;
            }

            $mode  = self::get_runtime_mode();
            $flags = MC_Delivery_V2_Options::get_flags_option();
            $value = false;

            switch ( $mode ) {
                case MC_Delivery_V2_Options::RUNTIME_MODE_FULL:
                    $value = true;
                    break;

                case MC_Delivery_V2_Options::RUNTIME_MODE_ADMIN_ONLY:
                    $value = self::is_admin_preview_user();
                    break;

                case MC_Delivery_V2_Options::RUNTIME_MODE_CANARY:
                    $value = self::is_canary_match( $flags );
                    break;

                case MC_Delivery_V2_Options::RUNTIME_MODE_LEGACY:
                default:
                    $value = false;
                    break;
            }

            self::$strict_gate_result = self::evaluate_strict_gate( $mode, $value );

            return self::$strict_gate_result;
        }

        private static function extract_check_label( $check ) {
            if ( ! is_array( $check ) || empty( $check['label'] ) ) {
                return '';
            }

            return sanitize_text_field( $check['label'] );
        }
    }
}
