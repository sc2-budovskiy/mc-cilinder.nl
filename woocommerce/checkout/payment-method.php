<?php
/**
 * Output a single payment method
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nm_gateway_active_class = ( $gateway->chosen ) ? ' active' : '';
?>
<div class="payment-method-item wc_payment_method payment_method_<?php echo $gateway->id . $nm_gateway_active_class; ?>">
    <label for="payment_method_<?php echo $gateway->id; ?>" class="nm-custom-radio-label">
        <input id="payment_method_<?php echo $gateway->id; ?>" type="radio" class="input-radio nm-custom-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />
        <span class="nm-gateway-title"><span class="text"><?php echo $gateway->get_title(); ?></span></span>
	</label>
</div>
