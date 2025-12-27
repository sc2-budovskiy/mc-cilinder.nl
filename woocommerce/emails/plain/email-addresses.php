<?php
/**
 * Email Addresses (plain)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/plain/email-addresses.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails\Plain
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

echo "\n" . esc_html( wc_strtoupper( esc_html__( 'Billing address', 'woocommerce' ) ) ) . "\n\n";
echo preg_replace( '#<br\s*/?>#i', "\n", $order->get_formatted_billing_address() ) . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

if ( $order->get_billing_phone() ) {
    echo $order->get_billing_phone() . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

if ( $order->get_billing_email() ) {
    echo $order->get_billing_email() . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Fires after the core address fields in emails.
 *
 * @since 8.6.0
 *
 * @param string $type Address type. Either 'billing' or 'shipping'.
 * @param WC_Order $order Order instance.
 * @param bool $sent_to_admin If this email is being sent to the admin or not.
 * @param bool $plain_text If this email is plain text or not.
 */
do_action( 'woocommerce_email_customer_address_section', 'billing', $order, $sent_to_admin, true );

if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) {
    $shipping = $order->get_formatted_shipping_address();

    $order_id = $order->get_id();
    $spData = get_post_meta( $order_id, "sendcloudshipping_service_point_meta", true );
    if($spData) {
        $extraData = array_key_exists( 'extra', $spData ) ? $spData['extra'] : '';
        if($extraData) {
            try {
                $shipping = "";
                $addressLines = explode( '|', $extraData );
                $address1 = trim($addressLines[0]);
                $address2 = trim($addressLines[1]);
                $shipping .= $address1 . "<br/>";
                $shipping .= $address2 . "<br/>";
                $postcode = explode(" ", $addressLines[2])[0];
                $shipping .= $postcode . " ";
                $city = trim(str_replace($postcode,"",$addressLines[2]));
                $shipping .= $city . "<br/>";
            } catch (Exception $e) {
                //
            }
        }
    }

    if ( $shipping ) {
        echo "\n" . esc_html( wc_strtoupper( esc_html__( 'Shipping address', 'woocommerce' ) ) ) . "\n\n";
        echo preg_replace( '#<br\s*/?>#i', "\n", $shipping ) . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

        if ( $order->get_shipping_phone() ) {
            echo $order->get_shipping_phone() . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }

        /**
         * Fires after the core address fields in emails.
         *
         * @since 8.6.0
         *
         * @param string $type Address type. Either 'billing' or 'shipping'.
         * @param WC_Order $order Order instance.
         * @param bool $sent_to_admin If this email is being sent to the admin or not.
         * @param bool $plain_text If this email is plain text or not.
         */
        do_action( 'woocommerce_email_customer_address_section', 'shipping', $order, $sent_to_admin, true );
    }
}
