<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     8.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php
//get theme options
$options = get_option( 'theme_settings' ); ?>
<div class="woocommerce-order new-thankyou">

    <?php if ( $order ) :

        do_action( 'woocommerce_before_thankyou', $order->get_id() );
        ?>

        <?php if ( $order->has_status( 'failed' ) ) : ?>

        <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

        <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
            <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
            <?php if ( is_user_logged_in() ) : ?>
                <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My account', 'woocommerce' ); ?></a>
            <?php endif; ?>
        </p>

    <?php else : ?>

        <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); ?></p>
        <div class="checkout-bottom">
            <div class="checkout-col col-md-3 col-sm-12 col-xs-12">
                <div class="checkout-title">Ordergegevens:</div>
                <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

                    <li class="woocommerce-order-overview__order order">
                        <?php _e( 'Order number:', 'woocommerce' ); ?>
                        <strong><?php echo $order->get_order_number(); ?></strong>
                    </li>

                    <li class="woocommerce-order-overview__date date">
                        <?php _e( 'Date:', 'woocommerce' ); ?>
                        <strong><?php echo wc_format_datetime( $order->get_date_created(), "d-m-Y" ); ?></strong>
                    </li>

                    <?/*php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
                            <li class="woocommerce-order-overview__email email">
                                <?php _e( 'Email:', 'woocommerce' ); ?>
                                <strong><?php echo $order->get_billing_email(); ?></strong>
                            </li>
                        <?php endif; */?>

                    <li class="woocommerce-order-overview__total total">
                        <?php _e( 'Total:', 'woocommerce' ); ?>
                        <strong><?php echo $order->get_formatted_order_total(); ?></strong>
                    </li>

                    <?php if ( $order->get_payment_method_title() ) : ?>
                        <li class="woocommerce-order-overview__payment-method method">
                            <?php _e( 'Payment method:', 'woocommerce' ); ?>
                            <strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
                        </li>
                    <?php endif; ?>

                </ul>

                <div class="checkout-title">Betelgegevens:</div>
                <p>Uw bestelling wordt geleverd op
                    het volgende adres:<br/>
                    <strong><?php echo ( $address = $order->get_formatted_shipping_address() ) ? $address : __( 'N/A', 'woocommerce' ); ?></strong></p>
            </div>
            <div class="checkout-col col-md-9 col-sm-12 col-xs-12 order-status-info">
                <div class="checkout-title">Bedankt voor uw bestelling.</div>
                <p>Wij gaan voor u aan de slag! Met zorg zullen de deurcilinders en/of sleutels met de hand voor u samengesteld en gemonteerd worden en klaarmaken voor verzending.</p>
                <p>Een bestelling die voor <?php echo $options["delivery_time"]; ?> uur wordt geplaatst, zal in 99% van de gevallen, de eerst volgende werkdag of zaterdag worden aangeboden.</p>
                <p>U ontvangt na het versturen van uw bestelling een track en trace van PostNL of van DHL.</p>
                <p>Als uw pakket verzonden is ontvangt u automatisch een email met een track en trace code. Zo kunt u direct zien wanneer uw pakket bezorgd wordt.</p>
            </div>
        </div>
        <div class="clear"></div>
    <?php endif; ?>

        <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
        <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

    <?php else : ?>

        <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p>

    <?php endif; ?>

    <!---->
    <div class="checkout-title payment-block-padding">U heeft besteld:</div>
    <div class="checkout-middle">
        <?php
        $cilinderCount = 0;
        $keyCount = 0;
        $isKeyplan = false;
        $doorNames = array();
        $keyProducts = array();
        $extraKeyId = 0;
        $cilinderProductId = 0;
        $noAddKeys = false;
        $otherProductsIds = array();
        foreach ( $order->get_items() as $order_item_key => $order_item ) {
            $_product     = $order->get_product_from_item( $order_item );

            if ( $_product && $_product->exists() && $order_item['quantity'] > 0 ) {
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
                    elseif($category->term_id == 47)
                    {
                        $productType = "other";
                        break;
                    }
                }
                if($productType == "cilinder") {
                    $cilinderCount += $order_item["quantity"];
                    for($i = 0; $i < $order_item["quantity"]; $i++) {
                        ?>
                        <div class="checkout-products-data">
                            <div class="cilinder-config-options clearfix">
                                <?php
                                $color = "";
                                $size = "";
                                $knopShort = "";
                                $knopLong = "";
                                foreach($order_item->get_formatted_meta_data() as $meta) {
                                    if(strpos($meta->key, "Uitvoering") !== false) {
                                        $color = $meta->value;
                                    }
                                    elseif(strpos($meta->key, "Buitenzijde/Binnenzijde"/*"Maat"*/) !== false || strpos($meta->key, "Cilindermaat") !== false) {
                                        $size = $meta->value;
                                    }
                                    elseif(strpos($meta->key, "Door type") !== false) {
                                        if($meta->value == "Binnendeur") {
                                            $size = $meta->value;
                                        }
                                    }
                                    elseif(strpos($meta->key, "Extra knop korte kant") !== false) {
                                        $knopShort = $meta->value;
                                    }
                                    elseif(strpos($meta->key, "Extra knop lange kant") !== false) {
                                        $knopLong = $meta->value;
                                    }
                                    elseif(strpos($meta->key, "Door name") !== false) {
                                        $doorNames[$meta->value] = $meta->value;
                                    }
                                }
                                ?>
								<div class="col-md-8ths">
									<div class="cilinder-count-item active block-align-center">
										<div class="cilinder-count-title" style="display:none;">Cilinder</div>
										<?php
										//$image = wp_get_attachment_image_src( get_post_thumbnail_id( $_product->get_id() ), 'single-post-thumbnail' );
										?>
										<div class="cilinder-count-img" style="background-image: url(<?php echo bloginfo( 'template_directory' ) . "/img/cilinders/cilinder-1.jpg"; ?>);" data-folder="<?php bloginfo('template_directory'); ?>/img/cilinder-types/"></div>
									</div>
								</div>
                                <div class="col-md-min-8ths cilinder-params clearfix">
									<div class="row">
										<div class="col-md-3 col-xs-6">
											<div class="param-item param-1">
												<div class="change-param-value" style="display:none;">Maat</div>
												<div class="param-value" data-value="<?=sanitize_title($size). '-1';?>"><?php echo $size; ?></div>
											</div>
										</div>
										<div class="param-item param-2 hidden">
											<div class="change-param-value" style="display:none;">Knop korte kant</div>
											<div class="param-value" data-value="<?=sanitize_title($knopShort)?>"><?php echo $knopShort; ?></div>
										</div>
										<div class="col-md-3 col-xs-6">
											<div class="param-item param-3">
												<div class="change-param-value" style="display:none;">Knop lange kant</div>
												<div class="param-value" data-value="<?=sanitize_title($knopLong)?>"><?php echo $knopLong; ?></div>
											</div>
										</div>
										<div class="col-md-3 col-xs-6">
											<div class="param-item param-4">
												<div class="change-param-value" style="display:none;">Uitvoering</div>
												<div class="param-value" data-value="<?=sanitize_title($color)?>"><?php echo $color; ?></div>
											</div>
										</div>
										<div class="col-md-3 col-xs-6">
											<div class="param-item param-5">
												<div class="change-param-value" style="display:none;">Prijs</div>
												<div class="param-value"><?php echo wc_price( ( $order_item['line_total'] + $order_item['line_tax'] ) / $order_item['quantity'] ); ?></div>
											</div>
										</div>
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
                    if ( $order_item['line_total'] > 0 ) {
                        $keyCount += $order_item["quantity"];
                    }
                    $keyName   = "";
                    $keyAccess = "";
                    foreach($order_item->get_formatted_meta_data() as $meta) {
                        if ( strpos( $meta->key, "User" ) !== false ) {
                            $keyName = $meta->value;
                        } elseif ( strpos( $meta->key, "Access" ) !== false ) {
                            $keyAccess = $meta->value;
                        }
                    }
                    if ( array_key_exists( $keyName, $keyProducts ) ) {
                        $keyProducts[ $keyName ]["quantity"] += $order_item["quantity"];
                    } else {
                        $keyProducts[ $keyName ] = array( "quantity" => $order_item["quantity"], "access" => $keyAccess );
                    }
                    $extraKeyId = $order_item["product_id"];
                }
                elseif($productType == "other")
                {
                    $otherProductsIds[$order_item["product_id"]] = $order_item["product_id"];
                }
            }
        }

        if($cilinderCount == 0 || !empty($otherProductsIds)) {
            foreach ( $order->get_items() as $order_item_key => $order_item ) {
                if($cilinderCount == 0 || in_array($order_item["product_id"], $otherProductsIds)) {
                    $_product = $order->get_product_from_item( $order_item );
                    if ( $_product && $_product->exists() && $order_item['quantity'] > 0 ) {
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $_product->get_id() ), 'single-post-thumbnail' );
                        ?>
                        <div class="checkout-products-data extra-products-data">
                            <div class="cilinder-config-options clearfix">
                                <div class="cilinder-count-item active block-align-center">
                                    <div class="cilinder-count-img"
                                         style="background-image: url(<?php if ( $image[0] ) {
                                             echo $image[0];
                                         } else {
                                             echo bloginfo( 'template_directory' ) . "/img/cilinders/cilinder-1.jpg";
                                         } ?>);"></div>
                                </div>
                                <div class="cilinder-params clearfix">
                                    <div class="param-item">
                                        <div class="param-value">
                                            <?php echo $_product->get_title() . '&nbsp;'; ?>
                                            <?php echo ' <strong class="product-quantity">' . sprintf( '&times; %s', $order_item['quantity'] ) . '</strong>'; ?>
                                        </div>
                                    </div>
                                    <div class="param-item param-5">
                                        <div class="param-value"><?php echo wc_price( $order_item['line_total'] + $order_item['line_tax'] ); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
        }

        $cilinderKey = array(
            "879" => 926,//mc color pro
            "1265" => 926,//mc color pro
            "251" => 927,//mc condor
            "1284" => 927,//mc condor
            "1516" => 1517,//mc matrix
            "11141" => 11140//mc minos
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
											else
											{
												echo "&nbsp";
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
    <!---->
</div>
