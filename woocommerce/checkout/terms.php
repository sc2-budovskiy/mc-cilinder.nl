<?php
/**
 * Checkout terms and conditions checkbox
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( wc_get_page_id( 'terms' ) > 0 && apply_filters( 'woocommerce_checkout_show_terms', true ) && function_exists( 'wc_terms_and_conditions_checkbox_enabled' ) ) : ?>
	<?php do_action( 'woocommerce_checkout_before_terms_and_conditions' ); ?>

	<?php if ( wc_terms_and_conditions_checkbox_enabled() ) : ?>
        <span class="required">*</span> <input type="checkbox" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); ?> id="terms" />
        <label class="confirm" for="terms"><?php printf( __( 'Ik heb de <a href="%s" target="_blank">Algemene voorwaarden</a> gelezen en ga hiermee akkoord', 'woocommerce' ), esc_url( wc_get_page_permalink( 'terms' ) ) ); ?></label>
        <input type="hidden" name="terms-field" value="1" />
	<?php endif; ?>

	<?php do_action( 'woocommerce_checkout_after_terms_and_conditions' ); ?>
<?php endif; ?>
