<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     8.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! wp_doing_ajax() ) {
    do_action( 'woocommerce_review_order_before_payment' );
}
?>
<div id="payment" class="woocommerce-checkout-payment">
    <?php if ( WC()->cart->needs_payment() ) : ?>
		<div class="wc_payment_methods payment_methods methods payment-method-list">
			<?php
				if ( ! empty( $available_gateways ) ) {
					foreach ( $available_gateways as $gateway ) {
						wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
					}
					foreach ( $available_gateways as $gateway ) {
					    if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
                            <div class="payment_box payment_method_<?php echo $gateway->id; ?>" <?php if ( ! $gateway->chosen ) : ?>style="display:none;"<?php endif; ?>>
								<?php /*if($gateway->id == "mollie_wc_gateway_ideal"){
									?>
                                    <label class="bank"><span class="ideal-icon"></span>
                                    <?php
								}*/?>
                                <?php $gateway->payment_fields(); ?>
                                <?php /*if($gateway->id == "mollie_wc_gateway_ideal"){
	                                ?>
                                    </label>
                                    <?php
                                }*/?>
	                            <?php if($gateway->id == "afterpay_openinvoice"){
		                            ?>
                                    <p class="form-row validate-required" style="display: inline !important;">
                                        <span class="required">*</span> <input id="ap-terms" type="checkbox" class="input-checkbox" name="_<?php echo $gateway->id; ?>_terms" />
                                        <label for="ap-terms" style="display: inline;" onclick="document.getElementsByName('<?php echo $gateway->id; ?>_terms')[0].click();"><?php echo __( "I accept the", 'afterpay'  ) .  " <a href=\"" . $gateway->afterpay_invoice_terms . "\" target=\"blank\">" . __( "payment terms", 'afterpay'  ) . "</a>" . __( " from AfterPay.", 'afterpay' ); ?></label>
                                    </p>
		                            <?php
	                            }?>
                            </div>
						<?php endif;
                    }
				} else {
					echo apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? __( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : __( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) );
				}
			?>
		</div>
	<?php endif; ?>
</div>
<?php
if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}
    