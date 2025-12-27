<?php
/**
 * Email Order Items (plain)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/plain/email-order-items.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails/Plain
 * @version     5.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

foreach ( $items as $item_id => $item ) :
    if ( apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
        $product       = $item->get_product();
        $sku           = '';
        $purchase_note = '';

        if ( is_object( $product ) ) {
            $sku           = $product->get_sku();
            $purchase_note = $product->get_purchase_note();
        }

        // phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
        echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, false ) );
        if ( $show_sku && $sku ) {
            echo ' (#' . $sku . ')';
        }
        echo ' X ' . apply_filters( 'woocommerce_email_order_item_quantity', $item->get_quantity(), $item );
        echo ' = ' . $order->get_formatted_line_subtotal( $item ) . "\n";
        // phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped

        // allow other plugins to add additional product information here
        do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, $plain_text );

        $flat = true;
        $delimiter = ", \n";
        $output         = '';
        $formatted_meta = $item_meta->get_formatted( "_" );

        if ( ! empty( $formatted_meta ) ) {
            $meta_list = array();

            foreach ( $formatted_meta as $meta ) {
                if(sanitize_html_class( sanitize_text_field( $meta['key'] ) ) != "Userimage") {
                    if ( $flat ) {
                        $meta_list[] = wp_kses_post( $meta['label'] . ': ' . $meta['value'] );
                    } else {
                        $meta_list[] = '
						<dt class="variation-' . sanitize_html_class( sanitize_text_field( $meta['key'] ) ) . '">' . wp_kses_post( $meta['label'] ) . ':</dt>
						<dd class="variation-' . sanitize_html_class( sanitize_text_field( $meta['key'] ) ) . '">' . wp_kses_post( wpautop( make_clickable( $meta['value'] ) ) ) . '</dd>
					';
                    }
                }
            }

            if ( ! empty( $meta_list ) ) {
                if ( $flat ) {
                    $output .= implode( $delimiter, $meta_list );
                } else {
                    $output .= '<dl class="variation">' . implode( '', $meta_list ) . '</dl>';
                }
            }
        }

        $output = apply_filters( 'woocommerce_order_items_meta_display', $output, $item_meta );

        $item_meta_content = $output;

        // Variation
        echo ( $item_meta_content ) ? "\n" . $item_meta_content : '';

        // Quantity
        echo "\n" . sprintf( __( 'Quantity: %s', 'woocommerce' ), apply_filters( 'woocommerce_email_order_item_quantity', $item['qty'], $item ) );

        // Cost
        echo "\n" . sprintf( __( 'Cost: %s', 'woocommerce' ), $order->get_formatted_line_subtotal( $item ) );

        // Download URLs
        if ( $show_download_links && $_product->exists() && $_product->is_downloadable() ) {
            $download_files = $order->get_item_downloads( $item );
            $i              = 0;

            foreach ( $download_files as $download_id => $file ) {
                $i++;

                if ( count( $download_files ) > 1 ) {
                    $prefix = sprintf( __( 'Download %d', 'woocommerce' ), $i );
                } elseif ( $i == 1 ) {
                    $prefix = __( 'Download', 'woocommerce' );
                }

                echo "\n" . $prefix . '(' . esc_html( $file['name'] ) . '): ' . esc_url( $file['download_url'] );
            }
        }

        // allow other plugins to add additional product information here
        do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, $plain_text );
    }
    // Note.
    if ( $show_purchase_note && $purchase_note ) {
        echo "\n" . do_shortcode( wp_kses_post( $purchase_note ) );
    }
    echo "\n\n";
endforeach;
