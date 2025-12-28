<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 7.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

wc_print_notices();

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

do_action( 'woocommerce_before_cart' ); ?>

<!-- Cart Loading Overlay -->
<div id="cart-loading-overlay" style="display:none;">
    <div class="cart-loading-spinner">
        <div class="big-loader"></div>
        <p>Verwijderen...</p>
    </div>
</div>

<form class="woocommerce-cart-form new-cart" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
    <?php do_action( 'woocommerce_before_cart_table' ); ?>

    <!---->
    <div class="checkout-title payment-block-padding">U heeft de volgende items in uw winkelmandje:</div>
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
        $cnt = 0;
        $otherProductsIds = array();
        $productName = "";
        $keysTotalSum = 0;
        $extraKeyImg = "";
        $cilinderCountArray = array();
        $isKeyplanArray = array();
        $noAddKeysArray = array();
        $productGroup = "";
        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
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
                        $productName = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
                        if(/*$cilinderCount == 0*/$productGroup != $_product->get_id() && $productName)
                        {
                            echo "<h2>" . $productName . "</h2>";
                            $productGroup = $_product->get_id();
                        }
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
                    $cilinderCount += $cart_item["quantity"];
                    if(!isset($cilinderCountArray[$productGroup])) {
                        $cilinderCountArray[$productGroup] = 0;
                    }
                    $cilinderCountArray[$productGroup] += $cart_item["quantity"];
                    for($i = 0; $i < $cart_item["quantity"]; $i++) {
                        ?>
                        <div class="checkout-products-data">
                            <div class="row cilinder-config-options clearfix">
                                <?php
                                $color = "";
                                $size = "";
                                $knopShort = "";
                                $knopLong = "";
                                $outerSize = "";
                                $innerSize = "";
                                $doorName = "";
                                $keyType = "";
                                $userImageUploaded = false;
                                foreach($cart_item["addons"] as $meta) {
                                    //echo '<div class="ccc">'.$meta["name"].' : '.$meta["value"].'</div>';

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
                                        $doorName = $meta["value"];
                                        $doorNames[$doorName] = $doorName;
                                    }
                                    elseif($meta["name"] == "Sleutel type") {
                                        $keyType = $meta["value"];
                                    }
                                    elseif($meta["name"] == "User image") {
                                        $userImageUploaded = true;
                                    }
                                    elseif($meta["name"] == "Maat buitenzijde") {
                                        $outerSize = $meta["value"];
                                    }
                                    elseif($meta["name"] == "Maat binnenzijde") {
                                        $innerSize = $meta["value"];
                                    }
                                }

                                $pId = $_product->get_id();
                                $var = get_product_addons($pId);
                                $sizes = $var[3];
                                $materials = $var[2];
                                $extra1 = $var[0];
                                $extra2 = $var[1];
                                $outerSide = array();
                                $innerSide = array();
                                $pDoorname = array();
                                $pFrontdoor = array();
                                $userImage = array();
                                if($isKeyplan)
                                {
                                    $pVar = get_product_addons($_product->get_id());
                                    $pDoorname = $pVar[4];
                                    $pFrontdoor = $pVar[5];

                                    $outerSide = @$pVar[8];
                                    $innerSide = @$pVar[9];
                                }
                                else {
                                    $pVar = get_product_addons($_product->get_id());

                                    $outerSide = @$pVar[6];
                                    $innerSide = @$pVar[7];
                                }
                                $pKeyTypes = array();
                                if($_product->get_id() == 1626 || $_product->get_id() == 1516) {//mc matrix
                                    $pKeyTypes = $var[7];

                                    $outerSide = @$var[8];
                                    $innerSide = @$var[9];
                                }
                                if($userImageUploaded) {
                                    $pVar = get_product_addons($_product->get_id());
                                    $userImage = $pVar[4];
                                }
                                ?>
                                <div class="col-md-8ths">
                                    <div class="cilinder-count-item active block-align-center">
                                        <div class="cilinder-count-title"><?php if($doorName) { ?><div class="cilinder-name" data-field="addon-<?=$_product->get_id() . substr($pDoorname["field-name"], strpos($pDoorname["field-name"],"-"))?>[]"><?php echo $doorName;?></div><?php } else { echo "Cilinder"; } ?></div>
                                        <?php
                                        //$image = wp_get_attachment_image_src( get_post_thumbnail_id( $_product->get_id() ), 'single-post-thumbnail' );
                                        ?>
                                        <div class="cilinder-count-img" style="background-image: url(<?php echo bloginfo( 'template_directory' ) . "/img/cilinders/cilinder-1.jpg"; ?>);" data-folder="<?php bloginfo('template_directory'); ?>/img/cilinder-types/"></div>
                                    </div>
                                </div>
                                <div class="col-md-min-8ths cilinder-params clearfix">
                                    <div class="row">
                                        <div class="param-item param-1 hidden">
                                            <select class="change-param-value" disabled="disabled">
                                                <?php
                                                $valIndex = 1;
                                                foreach ($sizes["options"] as $ind=>$option) {
                                                    if($option["label"] == $size)
                                                    {
                                                        $valIndex = $ind + 1;
                                                        break;
                                                    }
                                                }
                                                ?>
                                                <option value="<?=$size?>" data-value="<?=sanitize_title($size). '-' . $valIndex;?>">Maat</option>
                                                <?php
                                                foreach ($sizes["options"] as $ind=>$option)
                                                {
                                                    ?>
                                                    <option value="<?=$option["label"]?>" data-value="<?=sanitize_title($option["label"]). '-'. ($ind + 1);?>"><?=$option["label"]?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <div class="param-value" data-value="<?php if($size != "Binnendeur"){echo sanitize_title($size). '-' . $valIndex;}?>" data-field="addon-<?=$_product->get_id() . substr($sizes["field-name"], strpos($sizes["field-name"],"-"))?>"><?php if($size != "Binnendeur"){echo $size;} ?></div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="param-item param-11">
                                                <select class="change-param-value outside" disabled="disabled">
                                                    <?php
                                                    $valIndex = 1;
                                                    foreach ($outerSide["options"] as $ind=>$option) {
                                                        if($option["label"] == $outerSize)
                                                        {
                                                            $valIndex = $ind + 1;
                                                            break;
                                                        }
                                                    }
                                                    ?>
                                                    <option value="<?=trim(str_replace("mm","",$outerSize))?>" data-value="<?=sanitize_title($outerSize). '-' . $valIndex;?>">Maat buitenzijde (<?php echo $outerSize; ?>)</option>
                                                    <?php
                                                    foreach ($outerSide["options"] as $ind=>$option)
                                                    {
                                                        ?>
                                                        <option value="<?=trim(str_replace("mm","",$option["label"]))?>" data-value="<?=sanitize_title($option["label"]). '-'. ($ind + 1);?>"<?php if($outerSize == $option["label"]) { ?> selected="selected"<?php } ?>><?=$option["label"]?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div class="param-value" data-value="<?=sanitize_title($outerSize). '-' . $valIndex;?>" data-field="addon-<?=$_product->get_id() . substr($outerSide["field-name"], strpos($outerSide["field-name"],"-"))?>"><?=$outerSize;?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="param-item param-11">
                                                <select class="change-param-value inside" disabled="disabled">
                                                    <?php
                                                    $valIndex = 1;
                                                    foreach ($innerSide["options"] as $ind=>$option) {
                                                        if($option["label"] == $innerSize)
                                                        {
                                                            $valIndex = $ind + 1;
                                                            break;
                                                        }
                                                    }
                                                    ?>
                                                    <option value="<?=trim(str_replace("mm","",$innerSize))?>" data-value="<?=sanitize_title($innerSize). '-' . $valIndex;?>">Maat binnenzijde (<?php echo $innerSize; ?>)</option>
                                                    <?php
                                                    foreach ($innerSide["options"] as $ind=>$option)
                                                    {
                                                        ?>
                                                        <option value="<?=trim(str_replace("mm","",$option["label"]))?>" data-value="<?=sanitize_title($option["label"]). '-'. ($ind + 1);?>"<?php if($innerSize == $option["label"]) { ?> selected="selected"<?php } ?>><?=$option["label"]?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div class="param-value" data-value="<?=sanitize_title($innerSize). '-' . $valIndex;?>" data-field="addon-<?=$_product->get_id() . substr($innerSide["field-name"], strpos($innerSide["field-name"],"-"))?>"><?=$innerSize;?></div>
                                            </div>
                                        </div>
                                        <div class="param-item param-2 hidden">
                                            <div class="change-param-value param-disabled" data-src="#extra-select-<?=($cnt+1)?>">Knop</div>
                                            <div class="param-value" data-value="<?=sanitize_title($knopShort ? $knopShort : "geen")?>" data-field="addon-<?=$_product->get_id() . substr($extra1["field-name"], strpos($extra1["field-name"],"-"))?>[]"><?php echo $knopShort; ?></div>
                                            <div style="display:none;" id="extra-select-<?=($cnt+1)?>" class="main extra-options popup-container">
                                                <div class="block-align-center">
                                                    <div class="config-name">Kies een extra knop voor de korte kant</div>
                                                    <span class="lead">Kies als extra optie voor een knop of pushknop</span>
                                                    <div class="options-list cilinder-count clearfix">
                                                        <?php foreach($extra1["options"] as $ind=>$option){ ?>
                                                            <div class="cilinder-count-item<?=($option["label"]==$knopShort?" active":"")?>" onclick="javascript:;">
                                                                <div class="cilinder-count-title" data-value="<?=sanitize_title($option["label"])?>"><?=$option["label"]?></div>
                                                                <div class="cilinder-count-img" style="background-image: url(<?=wp_get_attachment_image_src($option["image"], null)[0]?>);"></div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <a href="javascript:;" class="extra-select view-btn view-btn-inverse"><span>Bevestigen</span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="param-item param-3">
                                                <div class="change-param-value param-disabled" data-src="#extra2-select-<?=($cnt+1)?>">Knop</div>
                                                <div class="param-value" data-value="<?=sanitize_title($knopLong)?>" data-field="addon-<?=$_product->get_id() . substr($extra2["field-name"], strpos($extra2["field-name"],"-"))?>[]"><?=$knopLong?></div>
                                                <div style="display:none;" id="extra2-select-<?=($cnt+1)?>" class="main extra2-options popup-container">
                                                    <div class="block-align-center">
                                                        <div class="config-name">Kies een extra knop</div>
                                                        <span class="lead">Kies als extra optie voor een knop of pushknop</span>
                                                        <div class="options-list cilinder-count clearfix">
                                                            <?php foreach($extra2["options"] as $ind=>$option){ ?>
                                                                <div class="cilinder-count-item<?=($option["label"]==$knopLong?" active":"")?>" onclick="javascript:;">
                                                                    <div class="cilinder-count-title" data-value="<?=sanitize_title($option["label"])?>"><?= str_replace(" lange zijde", "",$option["label"]); ?></div>
                                                                    <div class="cilinder-count-img" style="background-image: url(<?=wp_get_attachment_image_src($option["image"], null)[0]?>);"></div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <a href="javascript:;" class="extra2-select view-btn view-btn-inverse"><span>Bevestigen</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="param-item param-4">
                                                <div class="change-param-value param-disabled" data-src="#materials-select-<?=($cnt+1)?>">Uitvoering</div>
                                                <div class="param-value" data-value="<?=sanitize_title($color)?>" data-field="addon-<?=$_product->get_id() . substr($materials["field-name"], strpos($materials["field-name"],"-"))?>[]"><?php echo $color; ?></div>
                                                <div style="display:none;" id="materials-select-<?=($cnt+1)?>" class="main materials-options popup-container">
                                                    <div class="block-align-center">
                                                        <div class="config-name">Kies de uitvoering</div>
                                                        <span class="lead">Kies als uitvoering</span>
                                                        <div class="options-list cilinder-count clearfix">
                                                            <?php foreach($materials["options"] as $ind=>$option){ ?>
                                                                <?php if(strpos(strtolower($_product->get_name()), "move") === false || $option["label"] == "Nikkel") { ?>
                                                                    <div class="cilinder-count-item<?=($color==$option["label"]?" active":"")?>" onclick="javascript:;">
                                                                        <div class="cilinder-count-title" data-value="<?=sanitize_title($option["label"])?>"><?=$option["label"]?></div>
                                                                        <div class="cilinder-count-img" style="background-image: url(<?=wp_get_attachment_image_src($option["image"], null)[0]?>);"></div>
                                                                    </div>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </div>
                                                        <a href="javascript:;" class="material-select view-btn view-btn-inverse"><span>Bevestigen</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="param-item param-5">
                                                <div class="change-param-value">Prijs</div>
                                                <div class="param-value"><?php echo wc_price( ( $cart_item['line_total'] + (!$excl_btw ? $cart_item['line_tax'] : 0) ) / $cart_item['quantity'] ); ?></div>
                                            </div>
                                        </div>
                                        <?php
                                        if($isKeyplan){
                                            ?>
                                            <div class="col-md-3 col-xs-6">
                                                <div class="param-item param-6">
                                                    <input id="dt-<?=($cnt+1)?>" type="checkbox"<?php if($size == "Binnendeur"){?> checked="checked"<?php } ?> value="<?php echo sanitize_title($pFrontdoor["options"][1]["label"]); ?>" data-uncheked-value="<?php echo sanitize_title($pFrontdoor["options"][0]["label"]); ?>" data-uncheked-label="<?php echo $pFrontdoor["options"][0]["label"]; ?>" /><label for="dt-<?=($cnt+1)?>"><?=$pFrontdoor["options"][1]["label"]?></label>
                                                    <div style="display:none;" class="param-value" data-value="<?php if($size == "Binnendeur"){ echo sanitize_title($pFrontdoor["options"][1]["label"]); }else{ echo sanitize_title($pFrontdoor["options"][0]["label"]); }?>" data-field="addon-<?=$_product->get_id() . substr($pFrontdoor["field-name"], strpos($pFrontdoor["field-name"],"-"))?>[]"><?php if($size == "Binnendeur"){ echo $pFrontdoor["options"][1]["label"]; }else{ echo $pFrontdoor["options"][0]["label"]; }?></div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <?php if($pKeyTypes){ ?>
                                            <input class="key-type" type="hidden" name="addon-<?php echo sanitize_title($pKeyTypes["field-name"]); ?>[]" value="<?php echo sanitize_title($keyType); ?>" />
                                        <?php } ?>
                                        <?php if($userImage && $userImageUploaded){ ?>
                                            <div class="image-upload-form">
                                                <div class="upload-text">Upload hier een kopie van uw pas.</div>
                                                <button class="view-btn view-btn-shadow upload-image-cart">Pas uploaden</button>
                                            </div>
                                            <input class="user-image" type="file" name="addon-<?php echo sanitize_title($userImage["field-name"]); ?>-<?php echo sanitize_title( $userImage['options'][0]['label'] ); ?>" style="display:none;" />
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <a class="cilinder-edit show-cilinder-params">Cilinder aanpassen</a>
                            <a class="cilinder-edit submit-cilinder-params" data-product-id="<?php echo $_product->get_id(); ?>" data-cart-item-key="<?=$cart_item_key?>" data-qty-value="<?=$cart_item['quantity']?>">Change</a>
                            <div class="product-remove">
                                <a data-href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>" class="remove cilinder-remove" aria-label="&times;" data-product_id="<?php echo esc_attr( $product_id ); ?>" data-product_sku="<?php echo esc_attr( $_product->get_sku() ); ?>" data-cart-item-key="<?php echo $cart_item_key; ?>" data-qty-value="<?php echo $cart_item['quantity']; ?>">&times;</a>
                            </div>
                        </div>
                        <?php
                        $cnt++;
                    }
                    $cilinderProductId = $_product->get_id();
                }
                elseif($productType == "key")
                {
                    if ( $cart_item['line_total'] > 0 ) {
                        $keyCount += $cart_item["quantity"];
                        $otherProductsIds[$cart_item["product_id"]] = $cart_item["product_id"];
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

        foreach($cilinderCountArray as $group=>$count) {
            $totalKeysCnt += calcFreeKeysCnt($count, isset($isKeyplanArray[$group]) ? $isKeyplanArray[$group] : false, isset($noAddKeysArray[$group]) ? $noAddKeysArray[$group] : false);
        }
        //$totalKeysCnt += $keyCount;
        if($cilinderCount != 0 && $totalKeysCnt > 0) {
            $image = $extraKeyImg ? $extraKeyImg : get_bloginfo("template_directory") . "/img/sleutels/sleutel-1.png";
            ?>
            <div class="checkout-products-data extra-products-data">
                <div class="row cilinder-config-options clearfix">
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item active block-align-center">
                            <div class="cilinder-count-img" style="background-image: url(<?php echo $image; ?>);"></div>
                        </div>
                    </div>
                    <div class="col-md-min-8ths cilinder-params clearfix">
                        <div class="row">
                            <div class="col-md-3 col-xs-6">
                                <div class="param-item">
                                    <div class="param-value">
                                        Sleutels&nbsp;&times;&nbsp;<?php echo $totalKeysCnt; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-6">
                                <div class="param-item param-5">
                                    <div class="param-value"><?php echo wc_price( 0 ); ?></div>
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
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                if($cilinderCount == 0 || in_array($cart_item["product_id"],$otherProductsIds)) {
                    $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $_product->get_id() ), 'single-post-thumbnail' );
                        ?>
                        <div class="checkout-products-data extra-products-data">
                            <div class="row cilinder-config-options clearfix">
                                <div class="col-md-8ths">
                                    <div class="cilinder-count-item active block-align-center">
                                        <div class="cilinder-count-img"
                                             style="background-image: url(<?php if ( $image[0] ) {
                                                 echo $image[0];
                                             } else {
                                                 echo bloginfo( 'template_directory' ) . "/img/cilinders/cilinder-1.jpg";
                                             } ?>);"></div>
                                    </div>
                                </div>
                                <div class="col-md-min-8ths cilinder-params clearfix">
                                    <div class="row">
                                        <div class="col-md-3 col-xs-6">
                                            <div class="param-item">
                                                <div class="param-value">
                                                    <?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;'; ?>
                                                    <?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="param-item param-5">
                                                <div class="param-value"><?php echo wc_price( $cart_item['line_total'] + (!$excl_btw ? $cart_item['line_tax'] : 0) ); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-remove">
                                <a data-href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>" class="remove simple-product-remove" aria-label="&times;" data-product_id="<?php echo esc_attr( $product_id ); ?>" data-product_sku="<?php echo esc_attr( $_product->get_sku() ); ?>">&times;</a>
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
                    Daarnaast heeft u <span class="sleutel-num-extra"><?php echo $keyCount; ?></span> <span>sleutels</span> extra besteld.<br/>
                <?php } else { ?>
                    U krijgt bij uw bestelling <span>0</span> <span>cilinders</span> en <span><?php echo $keyCount; ?></span> <span>sleutels</span> geleverd.<br/>
                <?php } ?>
                U krijgt van ons gratis raamstickers bij uw bestelling.<br/>
                <span>Uw bestelling wordt direct en <strong>gratis</strong> gelijksluitend gemaakt.</span>
            </div>
        </div>*/ ?>
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
            <div class="clear"></div>
            <a href="<?php echo home_url() . "/sluitplan/#bestellen"; ?>" class="change-keyplan-btn view-btn view-btn-shadow">Sluitplan aanpassen</a>
            <div class="clear"></div>
            <div class="save-excel-block">
                <input class="excel-filename" type="text" value="" placeholder="Bestandsnaam Excel" />
                <a href="#" class="save-excel-btn view-btn view-btn-shadow">Export naar excel</a>
            </div>
            <div class="save-excel-text">
                Uw bestelling blijft bewaard in uw webbrowser.<br/>
                U kunt direct op bestellen klikken om te bestellen. U kunt ook het ingevulde sluitplan exporteren naar Excel door op de knop "Export naar Excel" te drukken. U kunt daarna contact met ons opnemen om het sluitplan door te nemen of naar u te versturen.
            </div>
            <?php
        }
        ?>
    </div>
    <div class="clear"></div>

    <div class="checkout-bottom">
        <div class="checkout-col col-md-4 col-sm-12 col-xs-12">
            <div class="checkout-title">Bijbestellen:</div>
            <div class="row">
                <?php /*if(!$isKeyplan && $extraKeyId){ ?>
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
                            <input type="button" class="order-extra-key view-btn view-btn-shadow" data-key-id="<?php echo $extraKeyId; ?>" value="Bestellen" />
                        </div>
                    </div>
                <?php }*/ ?>
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
                        <input type="button" class="order-extra-product view-btn view-btn-shadow" data-id="<?php echo $servicePenId; ?>" value="Bestellen" />
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

                <?php //do_action( 'woocommerce_review_order_before_order_total' ); ?>

                <div class="row order-total">
                    <label class="col-sm-9 col-xs-6 control-label label-total">Totaal</label>
                    <div class="col-sm-3 col-xs-6 form-control-static sum-total text-right"><?php echo '<strong>' . WC()->cart->get_total() . '</strong> '; ?></div>
                </div>

                <?php //do_action( 'woocommerce_review_order_after_order_total' ); ?>

                <div class="sep"></div>

            </div>
            <input id="place_order" type="button" class="checkout-button wc-forward view-btn view-btn-shadow" value="Doorgaan naar afrekenen" onclick="location.href='/checkout/';" />
            <div class="clear"></div>
            <a id="empty-cart">Winkelwagen legen</a>
            <div class="clear"></div>
            <div class="cc-payment-list">
                <img src="<?php bloginfo('template_directory'); ?>/img/payment/webshop.png" alt="webshop" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/AfterPay.png" alt="AfterPay" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/mijnbetaalplan.png" alt="mijnbetaalplan" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/postnl.png" alt="postnl" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/ideal.png" alt="ideal" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/Paypal.png" alt="PayPal" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/mastercard.png" alt="MasterCard" title="" /><img src="<?php bloginfo('template_directory'); ?>/img/payment/PIN-LOGO.png" alt="PIN-LOGO" title="" />
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <!---->

    <?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<div class="cart-collaterals">
    <?php
    /**
     * woocommerce_cart_collaterals hook.
     *
     * @hooked woocommerce_cross_sell_display
     * @hooked woocommerce_cart_totals - 10
     */
    //do_action( 'woocommerce_cart_collaterals' );
    ?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
