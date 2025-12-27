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
<div class="woocommerce-checkout-review-order woocommerce-checkout-review-order-table shop_table">
<div class="shipping-payment-block">
    <div class="checkout-col col-md-4 col-sm-12 col-xs-12" style="display: none;"></div>
    <div class="checkout-col col-md-8 col-sm-12 col-xs-12">
        <div class="row no-gutters">
            <div class="checkout-col col-md-6 col-sm-12 col-xs-12">
                <div class="checkout-title payment-block-padding">Verzendwijze</div>
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
            <?php
            $options = get_option( 'theme_settings' );
            if(@$options["show_vac"] && @$options["vac_message"]) {
	            ?>
                <div class="vac-message">
                    <?php echo esc_attr($options["vac_message"]); ?>
                </div>
	            <?php
            }
            ?>
            <div class="cc-payment-list">
                <img src="<?php bloginfo('template_directory'); ?>/img/payment/webshop.png" alt="webshop" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/AfterPay.png" alt="AfterPay" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/mijnbetaalplan.png" alt="mijnbetaalplan" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/postnl.png" alt="postnl" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/ideal.png" alt="ideal" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/Paypal.png" alt="PayPal" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/mastercard.png" alt="MasterCard" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/PIN-LOGO.png" alt="PIN-LOGO" title="" />
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="new-review-order">
	<div class="checkout-title payment-block-padding">Uw bestelling:</div>

    <div class="checkout-middle">
	<?php
	do_action( 'woocommerce_review_order_before_cart_contents' );

	$cilinderCount = 0;
	$keyCount = 0;
	$isKeyplan = false;
	$doorNames = array();
	$keyProducts = array();
	$extraKeyId = 0;
	$cilinderProductId = 0;
	$noAddKeys = false;
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

		if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
		    //is keyplan
		    if($_product->get_id() == 1577 || $_product->get_name() == "Sluitplan")
			{
				$isKeyplan = true;
			}
			//nabestellen
            if(strpos(strtolower($_product->get_name()),"nabestellen") !== false || $_product->get_id() == 1284 || $_product->get_id() == 1265)
            {
	            $noAddKeys = true;
            }
		    //category
			$categories = get_the_terms($_product->get_id(), 'product_cat');
			$productType = "";
			foreach($categories as $category) {
				if($category->term_id == 32 || $category->name == "Deurcilinders")
				{
					$productType = "cilinder";
					break;
				}
                elseif($category->term_id == 36 || $category->name == "Sleutels")
				{
					$productType = "key";
					break;
				}
			}
			if($productType == "cilinder") {
			    $cilinderCount += $cart_item["quantity"];
			    for($i = 0; $i < $cart_item["quantity"]; $i++) {
				    ?>
                    <div class="checkout-products-data">
                        <div class="cilinder-config-options clearfix">
	                        <?php
	                        $color = "";
	                        $size = "";
	                        $knopShort = "";
	                        $knopLong = "";
	                        foreach($cart_item["addons"] as $meta) {
		                        if($meta["name"] == "Uitvoering") {
			                        $color = $meta["value"];
		                        }
                                elseif($meta["name"] == "Maat") {
			                        $size = $meta["value"];
		                        }
                                elseif($meta["name"] == "Door type") {
			                        if($meta["value"] == "Binnendeur") {
				                        $size = $meta["value"];
			                        }
		                        }
                                elseif($meta["name"] == "Extra knop korte kant") {
			                        $knopShort = $meta["value"];
		                        }
                                elseif($meta["name"] == "Extra knop lange kant") {
			                        $knopLong = $meta["value"];
		                        }
                                elseif($meta["name"] == "Door name")
		                        {
			                        $doorNames[$meta["value"]] = $meta["value"];
		                        }
	                        }
	                        ?>
                            <div class="cilinder-count-item active block-align-center">
                                <div class="cilinder-count-title">Cilinder</div>
							    <?php
							    //$image = wp_get_attachment_image_src( get_post_thumbnail_id( $_product->get_id() ), 'single-post-thumbnail' );
							    ?>
                                <div class="cilinder-count-img" style="background-image: url(<?php echo bloginfo( 'template_directory' ) . "/img/cilinders/cilinder-1.jpg"; ?>);" data-folder="<?php bloginfo('template_directory'); ?>/img/cilinder-types/"></div>
                            </div>
                            <div class="cilinder-params clearfix">
                                <div class="param-item param-1">
                                    <div class="change-param-value">Maat</div>
                                    <div class="param-value" data-value="<?=sanitize_title($size). '-1';?>"><?php echo $size; ?></div>
                                </div>
                                <div class="param-item param-2">
                                    <div class="change-param-value">Knop korte kant</div>
                                    <div class="param-value" data-value="<?=sanitize_title($knopShort)?>"><?php echo $knopShort; ?></div>
                                </div>
                                <div class="param-item param-3">
                                    <div class="change-param-value">Knop lange kant</div>
                                    <div class="param-value" data-value="<?=sanitize_title($knopLong)?>"><?php echo $knopLong; ?></div>
                                </div>
                                <div class="param-item param-4">
                                    <div class="change-param-value">Uitvoering</div>
                                    <div class="param-value" data-value="<?=sanitize_title($color)?>"><?php echo $color; ?></div>
                                </div>
                                <div class="param-item param-5">
                                    <div class="change-param-value">Prijs</div>
                                    <div class="param-value"><?php echo wc_price( ( $cart_item['line_total'] + $cart_item['line_tax'] ) / $cart_item['quantity'] ); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
				    <?php
			    }
				$cilinderProductId = $_product->get_id();
			}
			elseif($productType == "key")
            {
				if ( $cart_item['line_total'] > 0 ) {
					$keyCount += $cart_item["quantity"];
				}
				$keyName   = "";
				$keyAccess = "";
				foreach ( $cart_item["addons"] as $meta ) {
					if ( $meta["name"] == "User" ) {
						$keyName = $meta["value"];
					} elseif ( $meta["name"] == "Access" ) {
						$keyAccess = $meta["value"];
					}
				}
				if ( array_key_exists( $keyName, $keyProducts ) ) {
					$keyProducts[ $keyName ]["quantity"] += $cart_item["quantity"];
				} else {
					$keyProducts[ $keyName ] = array( "quantity" => $cart_item["quantity"], "access" => $keyAccess );
				}
				$extraKeyId = $cart_item["product_id"];
			}
		}
	}

	if($cilinderCount == 0)
    {
        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
	        $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

	        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
		        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $_product->get_id() ), 'single-post-thumbnail' );
		        ?>
                <div class="checkout-products-data extra-products-data">
                    <div class="cilinder-config-options clearfix">
                        <div class="cilinder-count-item active block-align-center">
                            <div class="cilinder-count-img" style="background-image: url(<?php if ( $image[0] ) {
						        echo $image[0];
					        } else {
						        echo bloginfo( 'template_directory' ) . "/img/cilinders/cilinder-1.jpg";
					        } ?>);"></div>
                        </div>
                        <div class="cilinder-params clearfix">
                            <div class="param-item">
                                <div class="param-value">
	                                <?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;'; ?>
	                                <?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); ?>
                                </div>
                            </div>
                            <div class="param-item param-5">
                                <div class="param-value"><?php echo wc_price( $cart_item['line_total'] + $cart_item['line_tax'] ); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
		        <?php
	        }
        }
    }

	$cilinderKey = array(
	        "879" => 926,//mc color pro
	        "1265" => 926,//mc color pro
	        "251" => 927,//mc condor
	        "1284" => 927,//mc condor
	        "1516" => 1517,//mc matrix
        );
	if($extraKeyId == 0 && $cilinderProductId > 0)
    {
        $extraKeyId = $cilinderKey[$cilinderProductId];
    }

	do_action( 'woocommerce_review_order_after_cart_contents' );
	?>
        <div id="checkout-sleutels-info">
            <input id="sleutels-num"<?php if($isKeyplan){ ?> class="keyplan"<?php } elseif($noAddKeys) { ?> class="no-add-keys"<?php }?> type="hidden" value="" />
            <div class="lead block-align-center">
                U krijgt bij uw bestelling <span class="cilinder-num"><?php echo $cilinderCount; ?></span> <span>cilinders</span> en <span class="sleutel-num-standard">x</span> <span>sleutels</span> geleverd.<br/>
                Daarnaast heeft u <span class="sleutel-num-extra"><?php echo $keyCount; ?></span> <span>sleutels</span> extra besteld.
            </div>
        </div>
        <?php
        if($isKeyplan){
            ?>
            <div class="cm-title">Uw gekozen sluitplan</div>

                <table class="keys-outer-table">
                    <tr>
                        <td>
                            <table class="keys-access-table">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="cilinder-count-item active block-align-center">
                                            <div class="cilinder-count-title">Persoon/afdeling</div>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="change-param-value">Aantal sleutels</div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
	                            <?php
	                            foreach($keyProducts as $k => $v)
	                            {
		                            ?>
                                    <tr>
                                        <td>
				                            <?php echo $k; ?>
                                        </td>
                                        <td>
				                            <?php echo $v["quantity"]; ?> stuks
                                        </td>
                                    </tr>
		                            <?php
	                            }
	                            ?>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <div class="table-wrapper">
                                <table class="keys-access-table">
                                    <thead>
                                        <tr>
                                            <?php
                                            foreach($doorNames as $doorName)
                                            {
                                                ?>
                                                <th>
                                                    <div class="change-param-value"><?php echo $doorName; ?></div>
                                                </th>
                                                <?php
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($keyProducts as $k => $v)
                                    {
                                        ?>
                                        <tr>
                                            <?php
                                            $doors = explode(",", $v["access"]);
                                            $doors = array_map("trim", $doors);
                                            foreach($doorNames as $doorName) {
                                                echo "<td class='access-mark'>";
                                                if($doors[0] == "*masterkey" || in_array($doorName, $doors))
                                                {
                                                    echo "X";
                                                }
                                                echo "</td>";
                                            }
                                            ?>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>

            <?php
        }
        ?>
    </div>
	<div class="clear"></div>

    <div class="checkout-bottom">
        <div class="checkout-col col-md-4 col-sm-12 col-xs-12">
            <div class="checkout-title">Bijbestellen:</div>
            <div class="row">
                <?php if(!$isKeyplan && $extraKeyId){ ?>
                <div class="extra-product">
                    <div class="cilinder-count-item">
                        <div class="cilinder-count-title">Extra sleutels</div>
	                    <?php
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $extraKeyId ), 'single-post-thumbnail' );
	                    ?>
                        <div class="cilinder-count-img" style="background-image: url(<?php if ( $image[0] ) {
		                    echo $image[0];
	                    } else {
		                    echo bloginfo( 'template_directory' ) . "/img/sleutels/sleutel-2.png";
	                    } ?>);"></div>
                    </div>
                    <div class="ep-text">
                        Bestel hier gemakkelijk en snel nog wat extra sleutels.
                        <div class="ep-middle">
                            <select class="ep-select">
                                <option value="">-</option>
                                <?php
                                $extraKey = wc_get_product($extraKeyId);
                                for($i = 0; $i < 10; $i++)
                                {
                                    echo "<option value='" . ($i + 1) . "'>" . " (" . wc_price(wc_get_price_to_display($extraKey, array("qty" => $i + 1))) . ")</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <input type="button" class="order-extra-key button alt view-btn view-btn-shadow" data-key-id="<?php echo $extraKeyId; ?>" value="Bestellen" />
                    </div>
                </div>
                <?php } ?>
                <div class="extra-product">
                    <div class="cilinder-count-item" data-fancybox data-src="#servicepen">
                        <div class="cilinder-count-title">Servicepen</div>
	                    <?php
	                    $servicePenId = 1715;
	                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $servicePenId ), 'single-post-thumbnail' );
	                    ?>
                        <div class="cilinder-count-img" style="background-image: url(<?php if ( $image[0] ) {
		                    echo $image[0];
	                    } else {
		                    echo bloginfo( 'template_directory' ) . "/img/cilinders/cilinder-1.jpg";
	                    } ?>);"></div>
                    </div>
                    <div class="ep-text">
                        <div class="ep-price">
		                    <?php
		                    $servicePen = wc_get_product($servicePenId);
		                    echo wc_price(wc_get_price_to_display($servicePen));
		                    ?>
                        </div>
                        <input type="button" class="order-extra-product button alt view-btn view-btn-shadow" data-id="<?php echo $servicePenId; ?>" value="Bestellen" />
                    </div>
                    <div style="display:none;" id="servicepen" class="main popup-container">
                        <div class="block-align-center">
                            <div class="config-name">Hoe werkt een servicepen</div>
                            <span class="lead">Het onderhouden van de M&C deurcilinders</span>
                            <div class="row ep-popup-info clearfix">
                                <div class="col-md-6 col-xs-12">
					                <?php
					                echo "<strong class='ep-title'>" . apply_filters('the_title', get_post_field('post_title', $servicePenId)) . "</strong>";
					                echo apply_filters('the_content', get_post_field('post_content', $servicePenId));
					                ?>
                                </div>
                                <div class="col-md-6 col-xs-12" style="background-image: url(<?php echo $image[0]; ?>);"></div>
                            </div>
                            <a href="javascript:;" class="view-btn view-btn-inverse" onclick="$.fancybox.close();"><span>Terug naar bestellen</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>

		<div class="checkout-col col-md-8 col-sm-12 col-xs-12">
			<div class="checkout-title">Uw bestelling:</div>
			<div class="qc-totals">
				<?php
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						//category
						$categories = get_the_terms($_product->get_id(), 'product_cat');
						if(empty($categories)) {
							?>
                            <div class="row <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                                <label class="col-sm-9 col-xs-6 control-label">
									<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . "&nbsp;"; ?>
									<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); ?>
                                </label>
                                <div class="col-sm-3 col-xs-6 form-control-static text-right">
									<?php echo wc_price( $cart_item['line_total'] ); ?>
                                </div>
                            </div>
							<?php
						}
					}
				}
				?>

				<div class="row cart-subtotal">
					<label class="col-sm-9 col-xs-6 control-label">Subtotaal</label>
					<div class="col-sm-3 col-xs-6 form-control-static text-right"><?php echo wc_price( WC()->cart->get_subtotal() ); ?></div>
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

				<?php if ( wc_tax_enabled()/* && 'excl' === WC()->cart->tax_display_cart*/ ) : ?>
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
					<div class="col-sm-3 col-xs-6 form-control-static sum-total text-right"><?php echo '<strong>' . WC()->cart->get_total() . '</strong> '; ?></div>
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
			<div class="clear"></div>
			<div class="cc-payment-list">
				<img src="<?php bloginfo('template_directory'); ?>/img/payment/webshop.png" alt="webshop" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/AfterPay.png" alt="AfterPay" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/mijnbetaalplan.png" alt="mijnbetaalplan" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/postnl.png" alt="postnl" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/ideal.png" alt="ideal" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/Paypal.png" alt="PayPal" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/mastercard.png" alt="MasterCard" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/PIN-LOGO.png" alt="PIN-LOGO" title="" />
			</div>
		</div>
    </div>
    <div class="clear"></div>
</div>
</div>
