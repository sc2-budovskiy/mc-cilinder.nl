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
 * @version     5.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<?php
$excl_btw = isset($_COOKIE["excl_btw"]) && $_COOKIE["excl_btw"] ? true : false;
function calcFreeKeysCnt($cilinderCount, $isKeyplan = false, $noAddKeys = false) {
    $keysCount = 0;

    if($noAddKeys) {
        return 0;
    }

    if($isKeyplan)
    {
        return $cilinderCount;
    }
    if($cilinderCount == 1)
    {
        $keysCount = 3;
    }
    else if($cilinderCount >= 2 && $cilinderCount <= 3)
    {
        $keysCount = 5;
    }
    else if($cilinderCount >= 4 && $cilinderCount <= 5)
    {
        $keysCount = 7;
    }
    else if($cilinderCount > 0)
    {
        $keysCount = 8;
    }

    return $keysCount;
}
?>
<div class="woocommerce-checkout-review-order-table shop_table">
    <div class="shipping-payment-block">
        <div class="checkout-col col-md-4 col-sm-12 col-xs-12" style="display: none;"></div>
        <div class="checkout-col col-md-8 col-sm-12 col-xs-12">
            <div class="row no-gutters">
                <div class="checkout-col col-md-6 col-sm-12 col-xs-12">
                    <div class="cc-inner">
                        <div class="checkout-title payment-block-padding">Verzendwijze</div>
                        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

                            <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

                            <?php wc_cart_totals_shipping_html(); ?>

                            <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

                        <?php endif; ?>

                        <div style="height:42px;"></div>
                        <div class="checkout-title">Betaalwijze</div>
                        <?php
                        do_action( 'custom_woocommerce_payment' );
                        ?>

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
                    </div>
                </div>
                <div class="checkout-col col-md-6 col-sm-12 col-xs-12">
                    <div class="cc-inner">
                        <div class="checkout-title">Uw bestelling:</div>
                        <div style="height:42px;"></div>

                        <div class="panel-group">
                            <?php
                            do_action( 'woocommerce_review_order_before_cart_contents' );
                            ?>
                            <script>
                                if(window.jQuery)
                                {
                                    try{
                                        jQuery(document).ready(function () {
                                            jQuery('.panel-collapse').on('show.bs.collapse', function () {
                                                var obj = jQuery(this).siblings('.panel-heading').find("a");
                                                var label = obj.text();
                                                var newLabel = obj.attr("data-label");
                                                obj.text(newLabel);
                                                obj.attr("data-label", label);
                                            });
                                            jQuery('.checkout-col .panel-collapse').on('hide.bs.collapse', function () {
                                                var obj = jQuery(this).siblings('.panel-heading').find("a");
                                                var label = obj.text();
                                                var newLabel = obj.attr("data-label");
                                                obj.text(newLabel);
                                                obj.attr("data-label", label);
                                            });

                                            jQuery(".table-wrapper").mCustomScrollbar({
                                                axis: "x",
                                                theme: "inset-3-dark",
                                                scrollButtons:{
                                                    enable:true,
                                                    scrollType:"stepped"
                                                },
                                            });
                                        });
                                    }
                                    catch(error){}
                                }
                            </script>
                            <?php
                            //$cilinderTotalPrice = 0;
                            $cilinderTotals = array();
                            $cilinderCountArray = array();
                            $isKeyplanArray = array();
                            $noAddKeysArray = array();
                            $keyProducts = array();
                            $productGroup = "";
                            foreach ( apply_filters('woocommerce_cart_get_cart', WC()->cart->get_cart()) as $cart_item_key => $cart_item ) {
                                $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
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
                                        //$cilinderTotalPrice += ( $cart_item['line_total'] + (!$excl_btw ? $cart_item['line_tax'] : 0) );
                                        if(!isset($cilinderTotals[$_product->get_id()])) {
                                            $cilinderTotals[$_product->get_id()] = 0;
                                        }
                                        $cilinderTotals[$_product->get_id()] += ( $cart_item['line_total'] + (!$excl_btw ? $cart_item['line_tax'] : 0) );
                                    }
                                    elseif($productType == "key")
                                    {
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
                                    }
                                }
                            }

                            $cilinderCount = 0;
                            $keyCount = 0;
                            $isKeyplan = false;
                            $doorNames = array();
                            $extraKeyId = 0;
                            $cilinderProductId = 0;
                            $noAddKeys = false;
                            $otherProductsIds = array();
                            $keysTotalSum = 0;
                            $extraKeyImg = "";
                            $ind = 0;
                            foreach ( apply_filters('woocommerce_cart_get_cart', WC()->cart->get_cart()) as $cart_item_key => $cart_item ) {
                            $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

                            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                            //is keyplan
                            if($_product->get_id() == 1577 || $_product->get_name() == "Sluitplan")
                            {
                                $isKeyplan = true;
                                $isKeyplanArray[$_product->get_id()] = true;
                            }
                            if(strpos(strtolower($_product->get_name()),"sluitplan") !== false || strpos(strtolower($_product->get_name()),"keyplan") !== false) {
                                $isKeyplanArray[$_product->get_id()] = true;
                            }
                            //nabestellen
                            if(strpos(strtolower($_product->get_name()),"nabestellen") !== false || $_product->get_id() == 1284 || $_product->get_id() == 1265)
                            {
                                $noAddKeys = true;
                                $noAddKeysArray[$_product->get_id()] = true;
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
                                elseif($category->term_id != 46)//elseif($category->term_id == 47)
                                {
                                    $productType = "other";
                                    //break;
                                }
                            }
                            if($productType == "cilinder") {
                            if($productGroup != $_product->get_id() ) {
                            $productGroup = $_product->get_id();
                            $ind = 0;
                            if($cilinderCount != 0) {
                                echo "</div></div>";
                            }
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <?php
                                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $_product->get_id() ), 'single-post-thumbnail' );
                                    ?>
                                    <div class="cilinder-count-img" style="background-image: url(<?php echo $image[0]; ?>);"></div>
                                    <h4 class="panel-title">
                                        <table class="ph-table">
                                            <tr>
                                                <td><?php echo $_product->get_name(); ?><br/>
                                                    <a class="show-options" data-toggle="collapse" href="#collapse<?=$cart_item_key?>" data-label="Verberg opties">Toon opties</a></td>
                                                <td align="right"><?php echo wc_price( $cilinderTotals[$productGroup] ); ?></td>
                                            </tr>
                                        </table>
                                    </h4>
                                </div>
                                <div id="collapse<?=$cart_item_key?>" class="panel-collapse collapse">
                                    <?php
                                    }
                                    $cilinderCount += $cart_item["quantity"];
                                    if(!isset($cilinderCountArray[$productGroup])) {
                                        $cilinderCountArray[$productGroup] = 0;
                                    }
                                    $cilinderCountArray[$productGroup] += $cart_item["quantity"];
                                    for($i = 0; $i < $cart_item["quantity"]; $i++) {
                                        ?>
                                        <div class="checkout-products-data">
                                            <div class="cilinder-config-options clearfix">
                                                <?php
                                                $color = "";
                                                $size = "";
                                                $knopShort = "";
                                                $knopLong = "";
                                                $curDoorName = "";
                                                //echo "<!--";print_r($cart_item["addons"]);echo "-->";
                                                foreach($cart_item["addons"] as $meta) {
                                                    if($meta["name"] == "Uitvoering") {
                                                        $color = $meta["value"];
                                                    }
                                                    elseif($meta["name"] == "Buitenzijde/Binnenzijde"/*"Maat"*/ || $meta["name"] == "Cilindermaat") {
                                                        $size = $meta["value"];
                                                    }
                                                    elseif($meta["name"] == "Door type") {
                                                        if($meta["value"] == "Binnendeur") {
                                                            $size = $meta["value"];
                                                        }
                                                    }
                                                    elseif($meta["name"] == "Buitenzijde"/*"Extra knop korte kant"*/) {
                                                        $knopShort = $meta["value"];
                                                    }
                                                    elseif($meta["name"] == "Binnenzijde"/*"Extra knop lange kant"*/) {
                                                        $knopLong = $meta["value"];
                                                    }
                                                    elseif($meta["name"] == "Door name")
                                                    {
                                                        $doorNames[$meta["value"]] = $meta["value"];
                                                        $curDoorName = $meta["value"];
                                                    }
                                                }
                                                $ind++;
                                                ?>
                                                <div class="cilinder-params clearfix">
                                                    <div class="param-value">
                                                        <table class="ph-table">
                                                            <tr><td><span class="pht-label">Cilinder <?php echo $ind; ?>:</span> <?php echo $size; ?></td><td align="right"><?php echo wc_price( ( $cart_item['line_total'] + (!$excl_btw ? $cart_item['line_tax'] : 0) ) / $cart_item['quantity'] ); ?></td></tr>
                                                            <tr><td><span class="pht-label">Knop:</span> <?php echo $knopLong; ?></td><td></td></tr>
                                                            <tr><td><span class="pht-label">Uitvoering:</span> <?php echo $color; ?></td><td></td></tr>
                                                        </table>
                                                    </div>
                                                    <?php
                                                    if($isKeyplan){
                                                        ?>
                                                        <div class="param-value">
                                                            <table class="ph-table">
                                                                <tbody>
                                                                <?php
                                                                foreach($keyProducts as $k => $v)
                                                                {
                                                                    $doors = explode(",", $v["access"]);
                                                                    $doors = array_map("trim", $doors);
                                                                    $doorName = $curDoorName;
                                                                    if($doors[0] == "*masterkey" || in_array($doorName, $doors))
                                                                    {
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <span class="pht-label"><?php echo $k; ?>:</span> <?php echo $v["quantity"]; ?> sleutels
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="param-value">
                                                        <?php
                                                        echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                            'woocommerce_cart_item_remove_link',
                                                            sprintf(
                                                                '<a class="remove cilinder-remove" aria-label="%s" data-product_id="%s" data-product_sku="%s" data-cart-item-key="%s" data-qty-value="%s">&times;</a>',
                                                                '&times;',
                                                                esc_attr( $_product->get_id() ),
                                                                esc_attr( $_product->get_sku() ),
                                                                $cart_item_key,
                                                                $cart_item['quantity']
                                                            ),
                                                            $cart_item_key
                                                        );
                                                        ?>
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
                                            $otherProductsIds[$cart_item["product_id"]] = $cart_item["product_id"];
                                        }
                                        /*$keyName   = "";
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
                                        }*/
                                        $extraKeyId = $cart_item["product_id"];
                                        $keysTotalSum += $cart_item['line_total'] + (!$excl_btw ? $cart_item['line_tax'] : 0);

                                        if(!$extraKeyImg) {
                                            $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                                            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                                                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $_product->get_id() ), 'single-post-thumbnail' );
                                                $extraKeyImg = $image[0];
                                            }
                                        }
                                    }
                                    elseif($productType == "other")
                                    {
                                        $otherProductsIds[$cart_item["product_id"]] = $cart_item["product_id"];
                                    }
                                    }
                                    }
                                    //
                                    if($cilinderCount != 0) {
                                    ?>
                                </div></div>
                        <?php
                        }
                        //
                        foreach($cilinderCountArray as $group=>$count) {
                            $totalKeysCnt += calcFreeKeysCnt($count, isset($isKeyplanArray[$group]) ? $isKeyplanArray[$group] : false, isset($noAddKeysArray[$group]) ? $noAddKeysArray[$group] : false);
                        }
                        //$totalKeysCnt += $keyCount;
                        if($cilinderCount != 0 && $totalKeysCnt > 0) {
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <?php
                                    $image = $extraKeyImg ? $extraKeyImg : get_bloginfo("template_directory") . "/img/sleutels/sleutel-1.png";
                                    ?>
                                    <div class="cilinder-count-img" style="background-image: url(<?php echo $image; ?>);"></div>
                                    <h4 class="panel-title">
                                        <table class="ph-table">
                                            <tr>
                                                <td>Sleutels&nbsp;&times;&nbsp;<?php echo $totalKeysCnt; ?><br/>
                                                    <a class="show-options" data-toggle="collapse" href="#collapse-keys" data-label="Verberg opties">Toon opties</a></td>
                                                <td align="right"><?php echo wc_price( 0 ); ?></td>
                                            </tr>
                                        </table>
                                    </h4>
                                </div>
                                <div id="collapse-keys" class="panel-collapse collapse">
                                    <div class="checkout-products-data upd extra-products-data">
                                        <div class="cilinder-config-options clearfix">
                                            <div class="cilinder-params clearfix">
                                                <div class="">
                                                    <div class="param-item">
                                                        <div class="param-value">
                                                            <table class="ph-table">
                                                                <tr>
                                                                    <td>Sleutels&nbsp;&times;&nbsp;<?php echo $totalKeysCnt; ?></td>
                                                                    <td align="right"><?php echo wc_price( 0 ); ?></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        if($cilinderCount == 0 || !empty($otherProductsIds))
                        {
                            foreach ( apply_filters('woocommerce_cart_get_cart', WC()->cart->get_cart()) as $cart_item_key => $cart_item ) {
                                if($cilinderCount == 0 || in_array($cart_item["product_id"],$otherProductsIds)) {
                                    $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

                                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $_product->get_id() ), 'single-post-thumbnail' );
                                        ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <div class="cilinder-count-img" style="background-image: url(<?php echo $image[0]; ?>);"></div>
                                                <h4 class="panel-title">
                                                    <table class="ph-table">
                                                        <tr>
                                                            <td><?php echo $_product->get_name(); ?><br/>
                                                                <a class="show-options" data-toggle="collapse" href="#collapse<?=$cart_item_key?>" data-label="Verberg opties">Toon opties</a></td>
                                                            <td align="right"><?php echo wc_price( $cart_item['line_total'] + (!$excl_btw ? $cart_item['line_tax'] : 0) ); ?></td>
                                                        </tr>
                                                    </table>
                                                </h4>
                                            </div>
                                            <div id="collapse<?=$cart_item_key?>" class="panel-collapse collapse">
                                                <div class="checkout-products-data upd extra-products-data">
                                                    <div class="cilinder-config-options clearfix">
                                                        <div class="cilinder-params clearfix">
                                                            <div class="">
                                                                <div class="param-item">
                                                                    <div class="param-value">
                                                                        <table class="ph-table">
                                                                            <tr>
                                                                                <td>
                                                                                    <?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;'; ?>
                                                                                    <?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); ?>

                                                                                    <?php
                                                                                    echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                                                        'woocommerce_cart_item_remove_link',
                                                                                        sprintf(
                                                                                            '<a data-href="%s" class="remove simple-product-remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                                                                            esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                                                            '&times;',
                                                                                            esc_attr( $_product->get_id() ),
                                                                                            esc_attr( $_product->get_sku() )
                                                                                        ),
                                                                                        $cart_item_key
                                                                                    );
                                                                                    ?>
                                                                                </td>
                                                                                <td align="right"><?php echo wc_price( ($cart_item['line_total'] + (!$excl_btw ? $cart_item['line_tax'] : 0)) / $cart_item["quantity"] ); ?></td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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
                            <?php /*<div id="checkout-sleutels-info">
                                <input id="sleutels-num"<?php if($isKeyplan){ ?> class="keyplan"<?php } elseif($noAddKeys) { ?> class="no-add-keys"<?php }?> type="hidden" value="" />
                                <div class="lead block-align-center">
                                    <?php if($cilinderCount > 0) { ?>
                                        U krijgt bij uw bestelling <span class="cilinder-num"><?php echo $cilinderCount; ?></span> <span>cilinders</span> en <span class="sleutel-num-standard-pc"><?php echo $totalKeysCnt - $keyCount; ?></span> <span>sleutels</span> geleverd.<br/>
                                        Daarnaast heeft u <span class="sleutel-num-extra"><?php echo $keyCount; ?></span> <span>sleutels</span> extra besteld.
                                    <?php } else { ?>
                                        U krijgt bij uw bestelling <span>0</span> <span>cilinders</span> en <span><?php echo $keyCount; ?></span> <span>sleutels</span> geleverd.
                                    <?php } ?>
                                </div>
                            </div>*/ ?>
                            <?php
                            /*if($isKeyplan){
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
                            }*/
                            ?>
                        </div>

                        <div class="qc-totals">
                            <?php
                            foreach ( apply_filters('woocommerce_cart_get_cart', WC()->cart->get_cart()) as $cart_item_key => $cart_item ) {
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
                                                if($method->cost > 0) {
                                                    ?>
                                                    <label class="col-sm-9 col-xs-6 control-label">Verzending</label>
                                                    <div class="col-sm-3 col-xs-6 form-control-static text-right"><?= $price ?></div>
                                                    <?php
                                                }
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
                                <label class="col-sm-6 col-xs-6 control-label label-total">Totaal</label>
                                <div class="col-sm-6 col-xs-6 form-control-static sum-total text-right"><?php echo '<strong>' . WC()->cart->get_total() . '</strong> '; ?></div>
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

                            <?php echo apply_filters( 'woocommerce_order_button_html', '<input type="submit" class="button alt view-btn view-btn-shadow" name="woocommerce_checkout_place_order" id="place_order" value="Bestellen en afrekenen" data-value="Bestellen en afrekenen" />' ); ?>

                            <?php do_action( 'woocommerce_review_order_after_submit' ); ?>

                            <?php wp_nonce_field( 'woocommerce-process_checkout' ); ?>
                        </div>
                        <div class="clear"></div>
                        <?php /*<div class="cc-payment-list">
						<img src="<?php bloginfo('template_directory'); ?>/img/payment/webshop.png" alt="webshop" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/AfterPay.png" alt="AfterPay" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/mijnbetaalplan.png" alt="mijnbetaalplan" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/postnl.png" alt="postnl" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/ideal.png" alt="ideal" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/Paypal.png" alt="PayPal" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/mastercard.png" alt="MasterCard" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/PIN-LOGO.png" alt="PIN-LOGO" title="" />
					</div>*/ ?>
                    </div>
                </div>
            </div>
            <div class="row no-gutters">
                <?php /*<div class="cc-payment-list">
                    <img src="<?php bloginfo('template_directory'); ?>/img/payment/webshop.png" alt="webshop" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/AfterPay.png" alt="AfterPay" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/mijnbetaalplan.png" alt="mijnbetaalplan" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/postnl.png" alt="postnl" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/ideal.png" alt="ideal" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/Paypal.png" alt="PayPal" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/mastercard.png" alt="MasterCard" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/PIN-LOGO.png" alt="PIN-LOGO" title="" />
                </div>*/ ?>
            </div>
        </div>
    </div>
    <?php /*<div class="clear"></div>
    <div class="new-review-order">
        <div class="checkout-title payment-block-padding">Uw bestelling:</div>

        <div class="checkout-middle">

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
											echo "<option value='" . ($i + 1) . "'>" . ($i + 1) . " (" . wc_price(wc_get_price_to_display_custom($extraKey, array("qty" => $i + 1))) . ")</option>";
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
		                        echo wc_price(wc_get_price_to_display_custom($servicePen));
		                        ?>
                            </div>
                            <input type="button" class="order-extra-product button alt view-btn view-btn-shadow" data-id="<?php echo $servicePenId; ?>" value="Bestellen" />
                        </div>
                        <div style="display:none;" id="servicepen" class="main popup-container">
                            <div class="block-align-center">
                                <div class="config-name">Hoe werkt een flacon</div>
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

            </div>
        </div>
        <div class="clear"></div>
    </div>*/ ?>
</div>
