<?php /* Template Name: Order Change */ ?>

<?php
$excl_btw = isset($_COOKIE["excl_btw"]) && $_COOKIE["excl_btw"] ? true : false;

if(isset($_GET["submit_rma"])) {
    if(isset($_POST) && !empty($_POST["items"])) {
        function save_addon_meta_and_get_price($order_item_id, $product_addons, $post_data, $meta_prefix="") {
            $addonPrice = 0;
            if ( is_array( $product_addons ) && ! empty( $product_addons ) ) {
                foreach ( $product_addons as $addon ) {

                    $value = isset( $post_data[ 'addon-' . $addon['field-name'] ] ) ? $post_data[ 'addon-' . $addon['field-name'] ] : '';

                    if(!$value) {
                        continue;
                    }

                    if ( is_array( $value ) ) {
                        $value = array_map( 'stripslashes', $value );
                    } else {
                        $value = stripslashes( $value );
                    }

                    $chosen_option = '';
                    $loop          = 0;

                    foreach ( $addon['options'] as $option ) {
                        $loop++;
                        if ( sanitize_title( $option['label'] . '-' . $loop ) == $value || sanitize_title( $option['label'] ) == $value ) {
                            $chosen_option = $option;
                            break;
                        }
                    }

                    if($chosen_option) {
                        $formatted_value = $chosen_option['label'];
                        $name = ($meta_prefix ? $meta_prefix . " " : "") . $addon['name'];
                        $addonPrice += ($chosen_option['price'] > 0 ? floatval($chosen_option['price']) : 0);

                        wc_add_order_item_meta($order_item_id, $name, $formatted_value, true);
                    }
                }
            }

            return $addonPrice;
        }

        $order = wc_create_order();
        $tax_amount = 0;

        foreach($_POST["items"] as $item_index=>$item) {
            $productId = $item["add-to-cart"];
            $product = wc_get_product($productId);
            $order_item_id = wc_add_order_item(
                $order->get_id(),
                array(
                    'order_item_type' => 'line_item',
                    'order_item_name' => $product->get_name(),
                )
            );

            $product_addons = get_product_addons( $productId );

            $post_data = $item;
            $addonPrice = 0;
            $old_post_data = isset($_POST["old_items"][$item_index]) ? $_POST["old_items"][$item_index] : null;
            $oldAddonPrice = 0;

            $addonPrice = save_addon_meta_and_get_price($order_item_id, $product_addons, $post_data);
            $oldAddonPrice = save_addon_meta_and_get_price($order_item_id, $product_addons, $old_post_data, "Original");

            $item_line_subtotal = $addonPrice - $oldAddonPrice;
            if($item_line_subtotal < 0) {
                $item_line_subtotal = 0;
            }
            $item_line_total = $item["quantity"] * $item_line_subtotal;

            wc_add_order_item_meta( $order_item_id, '_product_id', $product->get_id(), true );
            wc_add_order_item_meta( $order_item_id, '_line_subtotal', $item_line_subtotal, true );
            wc_add_order_item_meta( $order_item_id, '_qty', $item["quantity"], true );
            wc_add_order_item_meta( $order_item_id, '_line_total', $item_line_total, true );

            /*wc_add_order_item_meta( $order_item_id, 'Original inside size', $_POST["old_items"][$item_index]["size_inside"], true );
            wc_add_order_item_meta( $order_item_id, 'Original outside size', $_POST["old_items"][$item_index]["size_outside"], true );
            wc_add_order_item_meta( $order_item_id, 'Original knop', $_POST["old_items"][$item_index]["extra"], true );*/

            $tax_rate_info = 0;
            $tax_rates = WC_Tax::get_rates( $product->get_tax_class() );
            if (!empty($tax_rates)) {
                $tax_rate = reset($tax_rates);
                $tax_rate_info = (float)$tax_rate['rate'];
            }
            $tax_amount += ($tax_rate_info / 100) * $item["quantity"] * (floatval($product->get_regular_price()) + $addonPrice);
        }

        //add conversion product
        $conversion = wc_get_product(get_field("conversion_product"));
        $order_item_id = wc_add_order_item(
            $order->get_id(),
            array(
                'order_item_type' => 'line_item',
                'order_item_name' => $conversion->get_name(),
            )
        );
        wc_add_order_item_meta( $order_item_id, '_product_id', $conversion->get_id(), true );
        wc_add_order_item_meta( $order_item_id, '_line_subtotal', floatval($conversion->get_regular_price()), true );
        wc_add_order_item_meta( $order_item_id, '_qty', 1, true );
        wc_add_order_item_meta( $order_item_id, '_line_total', floatval($conversion->get_regular_price()), true );
        $tax_rate_info = 0;
        $tax_rates = WC_Tax::get_rates( $conversion->get_tax_class() );
        if (!empty($tax_rates)) {
            $tax_rate = reset($tax_rates);
            $tax_rate_info = (float)$tax_rate['rate'];
        }
        $tax_amount += ($tax_rate_info / 100) * (floatval($conversion->get_regular_price()));

        $order_item_id = wc_add_order_item(
            $order_id,
            array(
                'order_item_name' => 'BTW',
                'order_item_type' => 'fee',
            )
        );
        if( $order_item_id ) {
            wc_add_order_item_meta( $order_item_id, '_fee_amount', $tax_amount, true );
            wc_add_order_item_meta( $order_item_id, '_line_total', $tax_amount, true );
        }

        $order->calculate_totals();

        //add original order number
        update_post_meta($order->get_id(), 'original_order_number', $_POST["order_number"]);
        $note = "Original order number: " . $_POST["order_number"];
        $order->add_order_note( $note );

        //add updated customer info
        $order->set_billing_phone($_POST["phone"]);
        $order->set_billing_email($_POST["email"]);
        $name = $_POST["order_name"];
        if($name) {
            $names = explode(" ", $name);
            update_post_meta($order->get_id(), '_billing_first_name', $names[0]);
            if($names[1]) {
                update_post_meta($order->get_id(), '_billing_last_name', $names[1]);
            }
        }

        $order->save();

        //copy address info
        $args = array(
            'meta_key'      => '_wcj_order_number',
            'meta_value'    => intval(intval($_POST["order_number"])),
        );
        $orders = wc_get_orders( $args );
        if(!empty($orders)) {
            $originalOrder = $orders[0];
        }
        if($originalOrder) {
            $billing_country = $originalOrder->get_billing_country();
            $order->set_billing_country($billing_country);
            $shipping_country = $originalOrder->get_shipping_country();
            $order->set_shipping_country($shipping_country);
            $order->save();
        }

        echo json_encode(array("payment_url" => $order->get_checkout_payment_url()));
        exit();
    }
}

if(isset($_GET["order_number"]) && intval($_GET["order_number"]) > 0) {
    $order = null;
    $args = array(
        'meta_key'      => '_wcj_order_number',
        'meta_value'    => intval($_GET["order_number"]),
    );
    $orders = wc_get_orders( $args );
    if(!empty($orders)) {
        $order = $orders[0];
    }
    if($order) {
        $product_id = null;
        foreach ( $order->get_items() as  $item_key => $item_values ) {
            $item_data = $item_values->get_data();
            if($item_data["meta_data"]) {
                foreach($item_data["meta_data"] as $meta) {
                    if(strpos($meta->key, "Cilindermaat") !== false) {
                        $product_id = intval($item_data["product_id"]);
                    }
                }
            }
        }
        $product = wc_get_product($product_id);
        //get addons data
        $var = get_product_addons($product_id);
        foreach($var as &$itemVar) {
            foreach($itemVar["options"] as &$option) {
                $option["price"] = sprintf("%01.2f", get_product_addon_price_for_display_custom($option["price"]));
            }
        }
        $sizes = $var[3];
        $materials = $var[2];
        //$extra1 = $var[0];
        $extra2 = $var[1];
        $keyTypes = $var[5];
        //$outerSide = @$var[6];
        //$innerSide = @$var[7];

        foreach($sizes["options"] as $ind=>&$option) {
            $option["data-val"] = sanitize_title($option["label"]). '-'. ($ind + 1);
        }
        foreach($extra2["options"] as $ind=>&$option) {
            $option["data-val"] = sanitize_title($option["label"]);
        }

        //prices
        $base_price = get_product_addon_price_for_display_custom($product->get_regular_price());
        $conversion = wc_get_product(get_field("conversion_product"));
        $conversion_price = get_product_addon_price_for_display_custom($conversion->get_regular_price());
        echo json_encode(array(
            "product_id"=>$product->get_id(),
            "base_price"=>$base_price ? $base_price : 0,
            "conversion_price"=>$conversion_price ? $conversion_price : 0,
            "sizes"=>$sizes,
            "materials"=>$materials,
            "extra"=>$extra2,
            "key_types"=>$keyTypes,
        ));
    }
    exit();
}
?>

<?php get_header();?>

<div class="container-fluid breadcrumb-block">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo home_url(); ?>">Home</a></li>
            <li class="active"><?php the_title(); ?></li>
        </ol>
    </div>
</div>

<?php
//get theme options
$options = get_option( 'theme_settings' ); ?>

<div class="main-top-slider main-top-products">
    <div class="container-fluid item" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/slide.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-6 col-md-6 col-sm-12 text-center">
                    <div class="slider-text">
                        <div class="page-head"><?php the_field("banner_title") ?></div>
                        <div class="lead">Vul het onderstaande formulier in.</div>
                        <div class="special-offer"><span>binnen 48 uur</span> ontvangt u reactie.</div>
                        <a href="#" class="view-btn view-btn-shadow cilinder-select">NAAR FORMULIER</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if( have_rows('data_cols', 'option') ): ?>
    <div class="container-fluid main-top-items">
        <div class="container">
            <div class="row">
                <?php while ( have_rows('data_cols', 'option') ) : the_row(); ?>
                    <div class="col-md-3 col-xs-6">
                        <div class="item">
                            <div class="img-wrapper">
                                <img src="<?php the_sub_field('icon'); ?>" alt="<?php the_sub_field('title'); ?>" title="" />
                            </div>
                            <div class="text-wrapper">
                                <div class="title"><?php the_sub_field('title'); ?></div>
                                <div class="text"><?php the_sub_field('text'); ?></div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="container-fluid products-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading1"><?php the_field("content_title"); ?></div>
                <?php if(get_field("content_subtitle")) { ?>
                    <p class="text-center lead"><?php the_field("content_subtitle"); ?></p>
                <?php } ?>
                <?php the_content(); ?>
            </div>
        </div>

        <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/rma.css?v=<?php echo time(); ?>">
        <script src="<?php bloginfo('template_directory'); ?>/js/rma.js?v=<?php echo time(); ?>"></script>
        <?php if(isset($_GET["order_completed"])) { ?>
            <div>
                <?php echo get_field("order_completed_text"); ?>
            </div>
            <?php if(isset($_GET["payment_url"])) { ?>
                <a href="<?php echo $_GET["payment_url"]; ?>" class="btn view-btn">Pay Now</a>
            <?php } ?>
        <?php } else { ?>
            <form id="rma-form" class="rma" action="" method="POST">
                <input type="hidden" name="product_id" value="" />
                <div class="row">
                    <div class="form-group col-lg-3 col-sm-6">
                        <label for="rma-order">Bestelnummer</label>
                        <div class="input-out"><input type="number" name="order_number" class="form-control" id="rma-order" placeholder="Nummer..." required="required" /></div>
                    </div>
                    <div class="form-group col-lg-3 col-sm-6">
                        <label for="rma-name">Naam</label>
                        <div class="input-out"><input type="text" name="name" class="form-control" id="rma-name" placeholder="Naam Achternaam" required="required" /></div>
                    </div>
                    <div class="form-group col-lg-3 col-sm-6">
                        <label for="rma-phone">Telefoonnummer</label>
                        <div class="input-out"><input type="tel" name="phone" class="form-control" id="rma-phone" placeholder="Telefoonnummer" required="required" /></div>
                    </div>
                    <div class="form-group col-lg-3 col-sm-6">
                        <label for="rma-email">E-mailadres</label>
                        <div class="input-out"><input type="email" name="email" class="form-control" id="rma-email" placeholder="@" required="required" /></div>
                    </div>
                </div>
                <div class="row rma-params">
                    <div class="col-lg-6">
                        <label>Hoeveel cilinders ombouwen?</label>
                        <div class="rma-cilinder-num">
                            <?php for($i=0;$i<10;$i++) { ?>
                                <div class="rcn-col<?php if($i==0) { ?> active<?php } ?>"><?php echo $i+1; ?></div>
                            <?php } ?>
                        </div>
                        <div id="more-cilinders" class="rcn-col custom">Meer dan 10 cilinders laten ombouwen? Vul hier je aantal in...</div>
                        <input id="cilinders-num" class="product-page" type="number" value="1" min="1" style="display:none;" />
                        <div class="clear"></div>
                        <?php
                        $id = 251;
                        $var = get_product_addons($id);
                        $materials = $var[2];
                        $extra2 = $var[1];
                        $outerSide = @$var[6];
                        $innerSide = @$var[7];
                        ?>
                        <div class="rma-cilinders">
                            <div class="rc-row">
                                <div class="rc-num">1</div>
                                <div class="rc-from-order" data-size-field="-maat-3" data-size-val="" data-extra-field="-extra-knop-lange-kant-1" data-extra-val="">
                                    <label>Maat die het nu is?</label>
                                    <div class="rc-params">
                                        <div class="rc-param">
                                            <div class="rcp-label">Binnen</div>
                                            <div class="rcp-option">
                                                <select name="-maat-binnenzijde-7" class="form-control outside" required="required">
                                                    <option value="">...</option>
                                                    <?php
                                                    foreach ($innerSide["options"] as $ind=>$option)
                                                    {
                                                        ?>
                                                        <option value="<?=trim(str_replace("mm","",$option["label"]))?>" data-value="<?=sanitize_title($option["label"]). '-'. ($ind + 1);?>"><?=$option["label"]?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="rc-param">
                                            <div class="rcp-label">Buiten</div>
                                            <div class="rcp-option">
                                                <select name="-maat-buitenzijde-6" class="form-control inside" required="required">
                                                    <option value="">...</option>
                                                    <?php
                                                    foreach ($outerSide["options"] as $ind=>$option)
                                                    {
                                                        ?>
                                                        <option value="<?=trim(str_replace("mm","",$option["label"]))?>" data-value="<?=sanitize_title($option["label"]). '-'. ($ind + 1);?>"><?=$option["label"]?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="rc-param">
                                            <div class="rcp-label">Knop</div>
                                            <div class="rcp-option">
                                                <select class="form-control extra" required="required">
                                                    <option value="">...</option>
                                                    <?php foreach($extra2["options"] as $ind=>$option){ ?>
                                                        <option value="<?=sanitize_title(str_replace(" lange zijde", "",$option["label"]))?>"><?= str_replace(" lange zijde", "",$option["label"]); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rc-new-item" data-size-field="-maat-3" data-size-val="" data-extra-field="-extra-knop-lange-kant-1" data-extra-val="">
                                    <label>Maat die het moet worden?</label>
                                    <div class="rc-params">
                                        <div class="rc-param">
                                            <div class="rcp-label">Binnen</div>
                                            <div class="rcp-option">
                                                <select name="-maat-binnenzijde-7" class="form-control outside" required="required">
                                                    <option value="">...</option>
                                                    <?php
                                                    foreach ($innerSide["options"] as $ind=>$option)
                                                    {
                                                        ?>
                                                        <option value="<?=trim(str_replace("mm","",$option["label"]))?>" data-value="<?=sanitize_title($option["label"]). '-'. ($ind + 1);?>"><?=$option["label"]?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="rc-param">
                                            <div class="rcp-label">Buiten</div>
                                            <div class="rcp-option">
                                                <select name="-maat-buitenzijde-6" class="form-control inside" required="required">
                                                    <option value="">...</option>
                                                    <?php
                                                    foreach ($outerSide["options"] as $ind=>$option)
                                                    {
                                                        ?>
                                                        <option value="<?=trim(str_replace("mm","",$option["label"]))?>" data-value="<?=sanitize_title($option["label"]). '-'. ($ind + 1);?>"><?=$option["label"]?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="rc-param">
                                            <div class="rcp-label">Knop</div>
                                            <div class="rcp-option">
                                                <select name="-extra-knop-lange-kant-1" class="form-control extra" required="required">
                                                    <option value="">...</option>
                                                    <?php
                                                    foreach ($outerSide["options"] as $ind=>$option)
                                                    {
                                                        ?>
                                                        <option value="<?=trim(str_replace("mm","",$option["label"]))?>" data-value="<?=sanitize_title($option["label"]). '-'. ($ind + 1);?>"><?=$option["label"]?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="rma-order-block">
                            <label>De kosten voor ombouwen worden:</label>
                            <div class="ro-items">
                                <div class="ro-item-row">
                                    <div><strong class="num">1:</strong> <span class="item-from-order">//</span> naar <span class="item-new">//</span></div>
                                    <div><strong>€</strong> <span class="rma-item-price">0,00</span></div>
                                </div>
                            </div>
                            <div class="sep"></div>
                            <div class="ro-total">
                                <div>Totaal</div>
                                <div>€ <span id="rma-total">0,00</span></div>
                            </div>
                            <button id="rma-submit" type="submit" class="view-btn">NU BESTELLEN</button>
                        </div>
                    </div>
                </div>
                <div class="after-order">
                    <div class="ao-label">Na de bestelling:</div>
                    <div class="row">
                        <div class="col-lg-6">
                            <p>Je ontvang een e-mail met daarin instructies. U dient de cilinders op te sturen met 1 sleutel</p>
                        </div>
                        <div class="col-lg-6">
                            <p>Let erop dat u het goed verpakt en als pakket verstuurd.</p>
                        </div>
                    </div>
                </div>
            </form>
        <?php } ?>
    </div>
</div>

<div class="container-fluid direct-bestellen-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="page-head"><strong>M&C</strong> Deurcilinders</div>
                <div class="lead">Dé manier om zelf uw thuis veiliger te maken, deze sloten zijn beveiligd tegen vele soorten inbraak!</div>
                <div class="special-offer"><strong>Al vanaf € <?php echo get_banner_price(); ?></strong> <?php if($excl_btw){ ?>excl.<?php } else { ?>incl.<?php } ?> BTW verkrijgbaar</div>
                <a href="/product-page/#bestellen" class="view-btn-inverse">BESTEL NU</a>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
