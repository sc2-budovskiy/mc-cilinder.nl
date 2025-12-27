<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
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
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="order_review" class="checkout-col col-md-8 col-sm-12 col-xs-12 woocommerce-checkout-review-order shop_table woocommerce-checkout-review-order-table">
    <div class="row no-gutters">
        <div class="checkout-col col-md-6 col-sm-12 col-xs-12">
            <div class="checkout-title">Verzendwijze</div>
			<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

				<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

				<?php wc_cart_totals_shipping_html(); ?>

				<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

			<?php endif; ?>
        </div>
        <div class="checkout-col col-md-6 col-sm-12 col-xs-12">
            <div class="checkout-title">Betaalwijze</div>
	        <?php
	        if ( ! is_ajax() ) {
		        do_action( 'woocommerce_review_order_before_payment' );
	        }
	        ?>
	        <?php wc_get_template("checkout/payment.php"); ?>
	        <?php
	        if ( ! is_ajax() ) {
		        do_action( 'woocommerce_review_order_after_payment' );
	        }
	        ?>
        </div>
    </div>
    <div class="row no-gutters">
        <div class="checkout-col col-md-12 col-sm-12 col-xs-12">
            <div class="qc-totals">

                <div class="row">
                    <label class="col-sm-9 col-xs-6 control-label"><?php _e( 'Product', 'woocommerce' ); ?></label>
                    <div class="col-sm-3 col-xs-6 form-control-static text-right"><?php _e( 'Total', 'woocommerce' ); ?></div>
                </div>

                <?php
                do_action( 'woocommerce_review_order_before_cart_contents' );

                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                    $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                        ?>
                        <div class="row <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                            <label class="col-sm-9 col-xs-6 control-label">
	                            <?php $thumbnail = apply_filters( 'woocommerce_in_cart_product_thumbnail', $_product->get_image(), $cart_item, $cart_item_key ); echo $thumbnail; ?>
                                <span class="cart-item-data">
                                    <?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;'; ?>
                                    <?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); ?>
                                    <?php
                                    echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                        '<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">❌</a>',
                                        esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
                                        __( 'Remove this item', 'woocommerce' ),
                                        esc_attr( $_product->get_id() ),
                                        esc_attr( $_product->get_sku() )
                                    ), $cart_item_key );
                                    ?>
                                    <?php echo WC()->cart->get_item_data( $cart_item ); ?>
                                </span>
                            </label>
                            <div class="col-sm-3 col-xs-6 form-control-static text-right">
                                <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
                            </div>
                        </div>
                        <?php
                    }
                }

                do_action( 'woocommerce_review_order_after_cart_contents' );
                ?>

                <div class="row cart-subtotal">
                    <label class="col-sm-9 col-xs-6 control-label">Subtotaal</label>
                    <div class="col-sm-3 col-xs-6 form-control-static text-right"><?php wc_cart_totals_subtotal_html(); ?></div>
                </div>

                <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
                    <div class="row cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                        <label class="col-sm-9 col-xs-6 control-label"><?php wc_cart_totals_coupon_label( $coupon ); ?></label>
                        <div class="col-sm-3 col-xs-6 form-control-static text-right"><?php wc_cart_totals_coupon_html( $coupon ); ?></div>
                    </div>
                <?php endforeach; ?>

	            <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
	            <?php
	            $packages = WC()->shipping->get_packages();
	            foreach ( $packages as $i => $package ) {
		            $chosen_method     = isset( WC()->session->chosen_shipping_methods[ $i ] ) ? WC()->session->chosen_shipping_methods[ $i ] : '';
		            $available_methods = $package["rates"];
		            ?>
                    <div class="row">
			            <?php foreach ( $available_methods as $method ) : ?>
				            <?php
				            if ( $method->id == $chosen_method ) {
					            if ( WC()->cart->tax_display_cart == 'excl' ) {
						            $price = wc_price( $method->cost );
					            } else {
						            $price = wc_price( $method->cost + $method->get_shipping_tax() );
					            }
					            ?>
                                <label class="col-sm-9 col-xs-6 control-label"><?php echo $method->get_label(); ?></label>
                                <div class="col-sm-3 col-xs-6 form-control-static text-right"><?= $price ?></div>
					            <?php
				            }
				            ?>
			            <?php endforeach; ?>
                    </div>
		            <?php
	            }
	            ?>
	            <?php endif; ?>

                <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
                    <div class="row fee">
                        <label class="col-sm-9 col-xs-6 control-label"><?php echo esc_html( $fee->name ); ?></label>
                        <div class="col-sm-3 col-xs-6 form-control-static text-right"><?php wc_cart_totals_fee_html( $fee ); ?></div>
                    </div>
                <?php endforeach; ?>

                <?php if ( wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart ) : ?>
                    <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
                        <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
                            <div class="row tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
                                <label class="col-sm-9 col-xs-6 control-label"><?php echo esc_html( $tax->label ); ?></label>
                                <div class="col-sm-3 col-xs-6 form-control-static text-right"><?php echo wp_kses_post( $tax->formatted_amount ); ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="row tax-total">
                            <label class="col-sm-9 col-xs-6 control-label"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></label>
                            <div class="col-sm-3 col-xs-6 form-control-static text-right"><?php wc_cart_totals_taxes_total_html(); ?></div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="sep"></div>

                <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

                <div class="row order-total">
                    <label class="col-sm-9 col-xs-6 control-label label-total">Totaal</label>
                    <div class="col-sm-3 col-xs-6 form-control-static sum-total text-right"><?php wc_cart_totals_order_total_html(); ?></div>
                </div>

                <?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

            </div>
	        <?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	        <?php if ( apply_filters( 'woocommerce_enable_order_notes_field', get_option( 'woocommerce_enable_order_comments', 'yes' ) === 'yes' ) ) : ?>

		        <?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>

                    <h3><?php _e( 'Additional Information', 'woocommerce' ); ?></h3>

		        <?php endif; ?>

		        <?/* foreach ( $checkout->checkout_fields['order'] as $key => $field ) : ?>

			        <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

		        <?php endforeach; */?>
                <textarea name="order_comments" class="input-text" id="order_comments" placeholder="Opmerkingen"><?=$checkout->get_value( "order_comments" )?></textarea>

	        <?php endif; ?>

	        <?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>

            <div class="place-order">
                <noscript>
			        <?php _e( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the <em>Update Totals</em> button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ); ?>
                    <br/><input type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>" />
                </noscript>

		        <?php wc_get_template( 'checkout/terms.php' ); ?>

		        <?php do_action( 'woocommerce_review_order_before_submit' ); ?>

		        <?php echo apply_filters( 'woocommerce_order_button_html', '<input type="submit" class="button alt view-btn view-btn-shadow" name="woocommerce_checkout_place_order" id="place_order" value="Bevestig bestelling" data-value="Bevestig bestelling" />' ); ?>

		        <?php do_action( 'woocommerce_review_order_after_submit' ); ?>

		        <?php wp_nonce_field( 'woocommerce-process_checkout' ); ?>
            </div>
        </div>
    </div>
</div>