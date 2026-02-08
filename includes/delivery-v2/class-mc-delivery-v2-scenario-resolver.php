<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MC_Delivery_V2_Scenario_Resolver' ) ) {
    class MC_Delivery_V2_Scenario_Resolver {
        public static function resolve_scenario_key( $method_key, $context = array() ) {
            $is_reorder   = ! empty( $context['is_reorder'] );
            $reference_ts = isset( $context['timestamp'] ) ? $context['timestamp'] : null;
            $is_after     = MC_Delivery_V2_Cutoff_Service::is_after_cutoff( $method_key, $reference_ts );

            if ( $is_reorder ) {
                return $is_after ? 'reorder_after_cutoff' : 'reorder_before_cutoff';
            }

            return $is_after ? 'new_order_after_cutoff' : 'new_order_before_cutoff';
        }
    }
}

