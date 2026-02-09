<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/class-mc-delivery-v2-options.php';
require_once __DIR__ . '/class-mc-delivery-v2-mapping-repo.php';
require_once __DIR__ . '/class-mc-delivery-v2-cutoff-service.php';
require_once __DIR__ . '/class-mc-delivery-v2-scenario-resolver.php';
require_once __DIR__ . '/class-mc-delivery-v2-matrix-service.php';
require_once __DIR__ . '/class-mc-delivery-v2-diagnostics.php';
require_once __DIR__ . '/class-mc-delivery-v2-admin.php';
require_once __DIR__ . '/class-mc-delivery-v2-runtime.php';
require_once __DIR__ . '/class-mc-delivery-v2-checkout-handler.php';

if ( ! class_exists( 'MC_Delivery_V2_Bootstrap' ) ) {
    class MC_Delivery_V2_Bootstrap {
        private static $is_initialized = false;

        public static function init() {
            if ( self::$is_initialized ) {
                return;
            }

            self::$is_initialized = true;

            add_action( 'admin_init', array( 'MC_Delivery_V2_Options', 'register_settings' ) );
            add_action( 'admin_init', array( 'MC_Delivery_V2_Options', 'ensure_defaults' ) );
            add_action( 'admin_menu', array( 'MC_Delivery_V2_Admin', 'register_menu' ) );
            MC_Delivery_V2_Runtime::register_hooks();
            MC_Delivery_V2_Checkout_Handler::register_hooks();
        }
    }
}

MC_Delivery_V2_Bootstrap::init();
