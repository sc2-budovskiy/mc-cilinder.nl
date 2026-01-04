<?php

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

/* Styles
=============================================================== */

function nm_child_theme_styles() {
    // Enqueue child theme styles
    wp_enqueue_style( 'nm-child-theme', get_stylesheet_directory_uri() . '/style.css' );
}

add_action( 'wp_enqueue_scripts', 'nm_child_theme_styles', 1000 ); // Note: Use priority "1000" to include the stylesheet after the parent theme stylesheets

function sc_include_myuploadscript() {
    /*
     * I recommend to add additional conditions just to not to load the scipts on each page
     * like:
     * if ( !in_array('post-new.php','post.php') ) return;
     */
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }

    wp_enqueue_script( 'myuploadscript', get_stylesheet_directory_uri() . '/js/upload.button.js', array( 'jquery' ), NULL, FALSE );
}

add_action( 'admin_enqueue_scripts', 'sc_include_myuploadscript' );

/*
* @param string $name Name of option or name of post custom field.
* @param string $value Optional Attachment ID
* @return string HTML of the Upload Button
*/
function sc_image_uploader_field( $name, $value = '' ) {
    $image      = ' button">Upload image';
    $image_size = 'thumbnail'; // it would be better to use thumbnail size here (150x150 or so)
    $display    = 'none'; // display state ot the "Remove image" button

    if ( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {

        // $image_attributes[0] - image URL
        // $image_attributes[1] - image width
        // $image_attributes[2] - image height

        $image   = '"><img src="' . $image_attributes[0] . '" style="max-width:95%;display:block;" />';
        $display = 'inline-block';
    }

    return '
		<div>
			<a href="#" class="sc_upload_image_button' . $image . '</a>
			<input type="hidden" name="' . $name . /*'" id="' . $name .*/
        '" value="' . $value . '" />
			<a href="#" class="sc_remove_image_button" style="display:inline-block;display:' . $display . '">Remove image</a>
		</div>';
}

function addons_settings_fields( $post, $product_addons, $loop, $option ) {

    //echo "<td class='image_column'><input type='file' name='product_addon_option_image[" . $loop . "][]'/></td>";

    $meta_key   = 'product_addon_option_image[' . $loop . '][]';
    $upload_btn = sc_image_uploader_field( $meta_key, $option['image'] /*, get_post_meta($post->ID, $meta_key, true)*/ );

    echo "<td class='image_column'>" . $upload_btn . "</td>";

    //d( $option );
}

add_action( 'woocommerce_product_addons_panel_option_row', 'addons_settings_fields', 10, 4 );

function addons_settings_fields_heading( $post, $product_addons, $loop ) {
    echo "<th class='image_column'>" . __( 'Option image', 'woocommerce-product-addons' ) . "</th>";
}

add_action( 'woocommerce_product_addons_panel_option_heading', 'addons_settings_fields_heading', 10, 3 );

function addons_add_image_field( $option ) {

    $option['image'] = "";

    return $option;
}

add_filter( 'woocommerce_product_addons_new_addon_option', 'addons_add_image_field' );

function addons_save_image_data( $data, $i ) {
    $option['image'] = ! empty( $_POST['product_addon_option_image'][ $i ] ) ? $_POST['product_addon_option_image'][ $i ] : "";

    for ( $ii = 0; $ii < sizeof( $option['image'] ); $ii ++ ) {
        $image = sanitize_text_field( stripslashes( $option['image'][ $ii ] ) );

        $data['options'][ $ii ]['image'] = $option['image'][ $ii ];
    }

    if ( sizeof( $data['options'] ) == 0 ) {
        return; // Needs options
    }

    return $data;
}

add_filter( 'woocommerce_product_addons_save_data', 'addons_save_image_data', 10, 2 );

function show_addon_values( $addon ) {

    //d( $addon );
}

add_action( 'wc_product_addon_end', 'show_addon_values', 10, 1 );

//$product_addons[] = apply_filters( 'woocommerce_product_addons_save_data', $data, $i );



//Add Function Style CSS
function custom_colors() {
    echo '<style type="text/css">
h2#title {
    font-size: 23px;
    font-weight: 400;
    padding: 9px 15px 4px 0;
    line-height: 29px;
}

th {
    vertical-align: top;
    text-align: left;
    padding: -1px 10px 20px 0;
    width: 200px;
    line-height: 1.3;
    font-weight: 600;
    font-size: 14px;
}

input[type=text],select,textarea {
    border: 1px solid #ddd;
    -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,.07);
    box-shadow: inset 0 1px 2px rgba(0,0,0,.07);
    background-color: #fff;
    color: #333;
    -webkit-transition: .05s border-color ease-in-out;
    transition: .05s border-color ease-in-out;
}

/*#submit {
    background: #2ea2cc;
    border-color: #0074a2;
    -webkit-box-shadow: inset 0 1px 0 rgba(120,200,230,.5),0 1px 0 rgba(0,0,0,.15);
    box-shadow: inset 0 1px 0 rgba(120,200,230,.5),0 1px 0 rgba(0,0,0,.15);
    color: #fff;
    text-decoration: none;
    padding: 5px 8px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    font-size: 13px;
}*/
</style>';
}

add_action('admin_head', 'custom_colors');

//Add thumbnail support
add_theme_support( 'post-thumbnails' );

//Add menu support and register main menu
if ( function_exists( 'register_nav_menus' ) ) {
    register_nav_menus(
        array(
            'main_menu' => 'Main Menu'
        )
    );
}

// filter the Gravity Forms button type
add_filter("gform_submit_button", "form_submit_button", 10, 2);
function form_submit_button($button, $form){
    return "<button class='button btn' id='gform_submit_button_{$form["id"]}'><span>Submit</span></button>";
}

//register sidebar
if ( function_exists('register_sidebar') )
{
    register_sidebar( array(
        'id'            => 'sidebar-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => 'Footer Sidebar 1',
        'id'            => 'footer-sidebar-1',
        'description'   => 'Appears in the footer area',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}

$args = array(
    'default-image' => get_template_directory_uri() . '/img/logo.png',
);
add_theme_support( 'custom-header', $args );

remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
add_action( 'custom_woocommerce_payment', 'woocommerce_checkout_payment', 20 );

/* @ Redirect to thank you page after purchasing */
function custom_redirect_after_purchase() {
    global $wp;
    if (is_checkout() && !empty($wp->query_vars['order-received'])) {

        $order_id = absint($wp->query_vars['order-received']);
        $order_key = wc_clean($_GET['key']);

        $redirect = '/thank-you/';
        $redirect = add_query_arg(array(
            'order' => $order_id,
            'key' => $order_key,
        ), $redirect);

        wp_safe_redirect($redirect);
        exit;
    }
}

add_action('template_redirect', 'custom_redirect_after_purchase');

add_action("template_redirect", 'redirection_function');
function redirection_function(){
    global $woocommerce;
    if( is_cart() && WC()->cart->cart_contents_count == 0){
        wp_safe_redirect( "/product-page/" );
    }
}

add_action( 'template_redirect', 'set_cart_item_quantity' );
function set_cart_item_quantity() {
    if( isset( $_POST['new_qty'] ) && isset( $_POST['cart_item_key'] ) && $_SERVER['REQUEST_METHOD'] == "POST" ) {
        WC()->cart->set_quantity($_POST['cart_item_key'], intval($_POST['new_qty']));
    }
}

add_action( 'woocommerce_order_status_pending', 'save_to_excel', 10, 1);
add_action( 'woocommerce_order_status_on-hold', 'save_to_excel', 10, 1);
add_action( 'woocommerce_order_status_processing', 'save_to_excel', 10, 1);
add_action( 'woocommerce_order_status_completed', 'save_to_excel', 10, 1);
add_action( 'woocommerce_thankyou', 'save_to_excel' );
function save_to_excel( $order_id ) {
    if(!file_exists($_SERVER["DOCUMENT_ROOT"] . "/keyplan_excel/" . $order_id . ".xlsx")) {
        session_start();

        // Lets grab the order
        $order = wc_get_order( $order_id );

        $keyplan = false;

        // This is how to grab line items from the order
        $lineItems = $order->get_items();

        // This loops over line items
        foreach ( $lineItems as $item ) {
            // This will be a product
            $product = $order->get_product_from_item( $item );

            $productId   = $product->get_id();
            $productName = $product->get_name();

            if ( $productId == 1577 || $productName == "Sluitplan" ) {
                $keyplan = true;
                break;
            }
        }

        if ( $keyplan ) {
            $date = $order->get_date_created();

            $company = $order->get_billing_company();

            $address = $order->get_shipping_address_1();

            $postcode = $order->get_shipping_postcode();

            $city = $order->get_shipping_city();

            $country = $order->get_shipping_country();

            $firstName = $order->get_shipping_first_name();
            $lastName = $order->get_shipping_last_name();
            $phone = $order->get_billing_phone();
            $email = $order->get_billing_email();

            $brand = "";

            require_once( get_template_directory() . '/includes/phpexcel/PHPExcel.php' );
            require_once( get_template_directory() . '/includes/phpexcel/PHPExcel/IOFactory.php' );

            // Create new PHPExcel object
            $objPHPExcel = PHPExcel_IOFactory::load( $_SERVER["DOCUMENT_ROOT"] . "/keyplan_excel/blank_new.xlsx" );

            // Add some data
            $objPHPExcel->setActiveSheetIndex( 0 );

            $sheet = $objPHPExcel->getActiveSheet();

            $sheet->setCellValue( "D8", $order_id );
            $sheet->setCellValue( "D9", $company );
            $sheet->setCellValue( "H9", wc_format_datetime( $date, "d.m.Y" ) );
            //$sheet->setCellValue( "D10", $address );
            //$sheet->setCellValue( "D12", $postcode . ", " . $city . ", " . $country );
            $sheet->setCellValue( "D12", $firstName . " " . $lastName );
            $sheet->setCellValue( "D14", $phone );
            $sheet->setCellValue( "D16", $email );

            $cilinderIndex    = 0;
            $cilinderStartRow = 21;
            $doorNames        = array();
            $keyIndex         = 0;
            $keyStartCol      = "N";
            $keyNames         = array();
            $keyAccess        = array();
            foreach ( $lineItems as $itemId => $item ) {
                $product   = $order->get_product_from_item( $item );
                $productId = $product->get_id();

                //category
                $categories  = get_the_terms( $productId, 'product_cat' );
                $productType = "";
                foreach ( $categories as $category ) {
                    if ( $category->term_id == 32 || $category->name == "Deurcilinders" ) {
                        $productType = "cilinder";
                        break;
                    } elseif ( $category->term_id == 36 || $category->name == "Sleutels" ) {
                        $productType = "key";
                        break;
                    }
                }

                // This is the qty purchased
                $qty = $item['qty'];

                //addons
                if ( $productType == "cilinder" ) {
                    //check brand condor/matrix
                    if ( ! $brand ) {
                        $productName = strtolower( $product->get_name() );
                        if ( strpos( $productName, "matrix" ) !== false ) {
                            $brand = "Matrix";
                        } elseif ( strpos( $productName, "condor" ) !== false ) {
                            $brand = "Condor";
                        }
                    }

                    $color    = "";
                    $doorName = "";
                    $size     = "";
                    $knop     = "";
                    $innerSize = "";
                    $outerSize = "";
                    foreach ( $item->get_formatted_meta_data() as $meta ) {
                        if ( strpos( $meta->key, "Uitvoering" ) !== false ) {
                            $color = strtolower( $meta->value );
                        }
                        if ( strpos( $meta->key, "Door name" ) !== false ) {
                            $doorName = $meta->value;
                        }
                        if ( strpos( $meta->key, "Buitenzijde/Binnenzijde"/*"Maat"*/ ) !== false || strpos( $meta->key, "Cilindermaat" ) !== false ) {
                            $size = $meta->value;
                        }
                        if ( strpos( $meta->key, "Door type" ) !== false ) {
                            if ( $meta->value == "Binnendeur" ) {
                                $size = strtolower( $meta->value );
                            }
                        }
                        if ( strpos( $meta->key, "Buitenzijde"/*"Extra knop korte kant"*/ ) !== false || strpos( $meta->key, "Binnenzijde"/*"Extra knop lange kant"*/ ) !== false ) {
                            if ( $meta->value != "Geen" ) {
                                if ( $knop ) {
                                    $knop .= ", ";
                                }
                                $knop .= strtolower( $meta->value );
                            }
                        }
                        if ( strpos( $meta->key, "Maat binnenzijde" ) !== false ) {
                            $innerSize = $meta->value;
                        }
                        if ( strpos( $meta->key, "Maat buitenzijde" ) !== false ) {
                            $outerSize = $meta->value;
                        }
                    }
                    $doorNames[ $cilinderIndex ] = $doorName;

                    $curCilinderRow = $cilinderStartRow + $cilinderIndex;
                    $sheet->setCellValue( "C" . $curCilinderRow, $doorName );
                    $sheet->setCellValue( "F" . $curCilinderRow, $innerSize );
                    $sheet->setCellValue( "I" . $curCilinderRow, $outerSize );
                    $sheet->setCellValue( "J" . $curCilinderRow, $qty );
                    $sheet->setCellValue( "K" . $curCilinderRow, $knop );
                    $sheet->setCellValue( "L" . $curCilinderRow, $color );
                    $cilinderIndex ++;
                } elseif ( $productType == "key" ) {
                    //check the same key name
                    $keyName = "";
                    foreach ( $item->get_formatted_meta_data() as $meta ) {
                        if ( strpos( $meta->key, "User" ) !== false ) {
                            $keyName = $meta->value;
                        }
                        if ( strpos( $meta->key, "Access" ) !== false ) {
                            $keyAccess[ $keyIndex ] = $meta->value;
                        }
                    }
                    if ( ! in_array( $keyName, $keyNames ) ) {
                        $keyNames[ $keyIndex ] = $keyName;

                        $curKeyCol = chr( ord( $keyStartCol ) + $keyIndex );
                        $sheet->setCellValue( $curKeyCol . "4", $keyName );
                        $sheet->setCellValue( $curKeyCol . "1", $qty );
                        $keyIndex ++;
                    } else {
                        //sum key quantity
                        $qtyKeyCol = chr( ord( $keyStartCol ) + array_keys( $keyNames, $keyName )[0] );
                        $sheet->setCellValue( $qtyKeyCol . "1", intval( $sheet->getCell( $qtyKeyCol . "1" )->getValue() ) + $qty );
                    }
                }
            }

            //key access
            foreach ( $keyAccess as $keyIndex => $access ) {
                $curKeyCol  = chr( ord( $keyStartCol ) + $keyIndex );
                $accessList = explode( ",", $access );
                foreach ( $accessList as $door ) {
                    $door = trim( $door );
                    //check masterkey
                    if ( $door == "*masterkey" ) {
                        foreach ( $doorNames as $cilinderIndex => $cilinder ) {
                            $curCilinderRow = $cilinderStartRow + $cilinderIndex;
                            $sheet->setCellValue( $curKeyCol . $curCilinderRow, "x" );
                        }
                    } else {
                        $cilinderIndex  = array_keys( $doorNames, $door )[0];
                        $curCilinderRow = $cilinderStartRow + $cilinderIndex;
                        $sheet->setCellValue( $curKeyCol . $curCilinderRow, "x" );
                    }
                }
            }

            $sheet->setCellValue( "H8", $brand );

            $objWriter = PHPExcel_IOFactory::createWriter( $objPHPExcel, 'Excel2007' );
            $objWriter->save( $_SERVER["DOCUMENT_ROOT"] . "/keyplan_excel/" . $order_id . ".xlsx" );

            //delete temporary keyplan file
            if(isset($_SESSION["keyplan_file"]) && isset($_SESSION["date_dir"])) {
                wp_delete_file( $_SERVER["DOCUMENT_ROOT"] . "/keyplan_excel_cart/" . $_SESSION["date_dir"] . "/" . $_SESSION["keyplan_file"] . ".xlsx" );
                unset($_SESSION["keyplan_file"]);
            }
        }
    }
}

add_action( 'template_redirect', 'download_keyplan_excel' );
function download_keyplan_excel() {
    if(isset($_GET["action"]) && $_GET["action"]="download_keyplan")
    {
        session_start();

        $keyplanCart = false;
        $cilinderCount = 0;
        $doorProducts = array();
        $keyProducts = array();
        $allKeyCount = 0;

        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                $productId   = $_product->get_id();
                $productName = $_product->get_name();

                if ( $productId == 1577 || $productName == "Sluitplan" ) {
                    $keyplanCart = true;
                    break;
                }
            }
        }

        if($keyplanCart) {
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
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
                        $cilinderCount += $cart_item["quantity"];
                        for($i = 0; $i < $cart_item["quantity"]; $i++) {
                            $color = "";
                            $size = "";
                            $knopShort = "";
                            $knopLong = "";
                            $doorName = "";
                            $keyType = "";
                            $doorType = "";
                            $innerSize = "";
                            $outerSize = "";

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
                                    $doorType = $meta["value"];
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
                                }
                                elseif($meta["name"] == "Sleutel type") {
                                    $keyType = $meta["value"];
                                }
                                elseif($meta["name"] == "Maat binnenzijde") {
                                    $innerSize = $meta["value"];
                                }
                                elseif($meta["name"] == "Maat buitenzijde") {
                                    $outerSize = $meta["value"];
                                }

                            }

                            $doorProducts[$doorName] = new stdClass();
                            $doorProducts[$doorName]->doorName = $doorName;
                            $doorProducts[$doorName]->id = $_product->get_id();
                            $doorProducts[$doorName]->productName = $_product->get_name();
                            $doorProducts[$doorName]->color = $color;
                            $doorProducts[$doorName]->size = $size;
                            $doorProducts[$doorName]->knopShort = $knopShort;
                            $doorProducts[$doorName]->knopLong = $knopLong;
                            $doorProducts[$doorName]->keyType = $keyType;
                            $doorProducts[$doorName]->doorType = $doorType;
                            $doorProducts[$doorName]->innerSize = $innerSize;
                            $doorProducts[$doorName]->outerSize = $outerSize;
                        }
                        $doorProducts[$doorName]->qty = $cart_item["quantity"];
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
                        if($keyName) {
                            if ( array_key_exists( $keyName, $keyProducts ) ) {
                                $keyProducts[ $keyName ]["quantity"] += $cart_item["quantity"];
                            } else {
                                $keyProducts[ $keyName ] = array( "quantity" => $cart_item["quantity"], "access" => $keyAccess );
                            }
                            $allKeyCount += $cart_item["quantity"];
                        }
                    }
                }
            }
        }

        if($keyplanCart)
        {
            require_once( get_template_directory() . '/includes/phpexcel/PHPExcel.php' );
            require_once( get_template_directory() . '/includes/phpexcel/PHPExcel/IOFactory.php' );

            // Create new PHPExcel object
            $objPHPExcel = PHPExcel_IOFactory::load( $_SERVER["DOCUMENT_ROOT"] . "/keyplan_excel/blank_new.xlsx" );

            // Add some data
            $objPHPExcel->setActiveSheetIndex( 0 );

            $sheet = $objPHPExcel->getActiveSheet();

            $sheet->setCellValue( "H9", current_time("d.m.Y") );

            $cilinderIndex = 0;
            $cilinderStartRow = 21;
            $doorNames = array();
            $keyIndex = 0;
            $keyStartCol = "N";
            $keyNames = array();
            $keyAccess = array();
            $brand = "";

            foreach($doorProducts as $item) {
                //check brand condor/matrix
                if(!$brand) {
                    $productName = strtolower( $item->productName );
                    if ( strpos( $productName, "matrix" ) !== false ) {
                        $brand = "Matrix";
                    }
                    elseif(strpos( $productName, "condor") !== false)
                    {
                        $brand = "Condor";
                    }
                }

                $color = $item->color;
                $doorName = $item->doorName;
                $size = $item->size;
                $knop = "";
                if ( $item->knopShort != "Geen" ) {
                    $knop .= $item->knopShort;
                }
                if ( $item->knopLong != "Geen" ) {
                    if($knop)
                    {
                        $knop .= ", ";
                    }
                    $knop .= strtolower( $item->knopLong );
                }

                $doorNames[$cilinderIndex] = $doorName;

                $curCilinderRow = $cilinderStartRow + $cilinderIndex;
                $sheet->setCellValue("C" . $curCilinderRow, $doorName);
                $sheet->setCellValue("F" . $curCilinderRow, $item->innerSize);
                $sheet->setCellValue("I" . $curCilinderRow, $item->outerSize);
                $sheet->setCellValue("J" . $curCilinderRow, $item->qty);
                $sheet->setCellValue("K" . $curCilinderRow, $knop);
                $sheet->setCellValue("L" . $curCilinderRow, $color);
                $cilinderIndex++;
            }

            $keyIndex = 0;
            foreach($keyProducts as $key => $item)
            {
                $keyName = $key;
                $keyAccess = $item["access"];

                $keyNames[$keyIndex] = $keyName;

                $curKeyCol = chr(ord($keyStartCol) + $keyIndex);
                $sheet->setCellValue($curKeyCol . "4", $keyName);
                $sheet->setCellValue($curKeyCol . "1", $item["quantity"]);
                $keyIndex++;
            }

            $keyIndex = 0;
            foreach($keyProducts as $key => $item)
            {
                $access = $item["access"];
                $curKeyCol = chr(ord($keyStartCol) + $keyIndex);
                $accessList = explode(",", $access);
                foreach($accessList as $door)
                {
                    $door = trim($door);
                    //check for masterkey
                    if($door == "*masterkey")
                    {
                        foreach($doorNames as $cilinderIndex => $cilinder)
                        {
                            $curCilinderRow = $cilinderStartRow + $cilinderIndex;
                            $sheet->setCellValue($curKeyCol . $curCilinderRow, "x");
                        }
                    }
                    else
                    {
                        $cilinderIndex = array_keys($doorNames, $door)[0];
                        $curCilinderRow = $cilinderStartRow + $cilinderIndex;
                        $sheet->setCellValue($curKeyCol . $curCilinderRow, "x");
                    }
                }
                $keyIndex++;
            }

            $sheet->setCellValue( "H8", $brand );

            $objWriter = PHPExcel_IOFactory::createWriter( $objPHPExcel, 'Excel2007' );

            //delete temporary keyplan file
            if(isset($_SESSION["keyplan_file"]) && isset($_SESSION["date_dir"])) {
                wp_delete_file( $_SERVER["DOCUMENT_ROOT"] . "/keyplan_excel_cart/" . $_SESSION["date_dir"] . "/" . $_SESSION["keyplan_file"] . ".xlsx" );
                unset($_SESSION["keyplan_file"]);
            }
            if(isset($_POST["user_file"]) && $_POST["user_file"]) {
                $userFileName = $_POST["user_file"];
            }
            else {
                $userFileName = current_time("Y-m-d H-i");
            }
            $userFileName = preg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $userFileName);
            $userFileName = preg_replace("([\.]{2,})", '', $userFileName);
            $userFileName = substr($userFileName, 0, 15);
            if(!isset($_SESSION["keyplan_file"]) || !$_SESSION["keyplan_file"])
            {
                $_SESSION["keyplan_file"] = $userFileName . " " . uniqid();
            }
            $date = current_time("Y-m-d");
            $dirName = $_SERVER["DOCUMENT_ROOT"] . "/keyplan_excel_cart/" . $date;
            if(!isset($_SESSION["date_dir"]) || !$_SESSION["date_dir"]) {
                $_SESSION["date_dir"] = $date;
            }
            if(!is_dir($dirName))
            {
                mkdir($dirName);
            }
            $objWriter->save($dirName . "/" . $_SESSION["keyplan_file"] . ".xlsx");

            /*header('Cache-Control: max-age=0');
            header ( "Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" );
            header ( "Content-Disposition: attachment; filename=" . $_SESSION["keyplan_file"] . ".xlsx" );
            $objWriter->save('php://output');*/

            echo $_SESSION["keyplan_file"];
            exit();
        }
        exit();
    }
}

//Admin Panel Settings

//Register Settings Function
function theme_settings_init(){
    register_setting( 'theme_settings', 'theme_settings' );
}

//Add settings to page menu
function add_settings_page() {
    add_menu_page( __( 'Theme Settings' ), __( 'Theme Settings' ), 'manage_options', 'settings', 'theme_settings_page');
}

//Add Actions
add_action( 'admin_init', 'theme_settings_init' );
add_action( 'admin_menu', 'add_settings_page' );


//Start Setting Page
function theme_settings_page() {

    if ( ! isset( $_REQUEST['updated'] ) )
        $_REQUEST['updated'] = false;

    ?>

    <div>

        <div id="icon-options-general"></div>
        <h2 id="title"><?php _e( 'Theme Settings' ) //your admin panel title ?></h2>

        <?php
        //show saved options message
        if ( false !== $_REQUEST['updated'] ) : ?>
            <div><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
        <?php endif; ?>

        <form method="post" action="options.php">

            <?php settings_fields( 'theme_settings' ); ?>
            <?php $options = get_option( 'theme_settings' ); ?>

            <table>

                <!---->
                <tr valign="top">
                    <th scope="row"><?php _e( 'Logo Title' ); ?></th>
                    <td><input id="theme_settings[logo_title]" type="text" size="40" name="theme_settings[logo_title]" value="<?php esc_attr_e( $options['logo_title'] ); ?>" />
                    </td>
                </tr>

                <!---->
                <tr valign="top">
                    <th scope="row"><?php _e( 'Phone' ); ?></th>
                    <td><input id="theme_settings[phone]" type="text" size="40" name="theme_settings[phone]" value="<?php esc_attr_e( $options['phone'] ); ?>" />
                    </td>
                </tr>

                <!---->
                <tr valign="top">
                    <th scope="row"><?php _e( "Show What'sapp icon" ); ?></th>
                    <td><input id="theme_settings[whatsapp_icon]" type="checkbox" name="theme_settings[whatsapp_icon]" value="1"<?php if($options['whatsapp_icon']){ ?> checked="checked"<?php } ?> />
                    </td>
                </tr>
                <!---->
                <tr valign="top">
                    <th scope="row"><?php _e( "What'sapp text" ); ?></th>
                    <td><textarea id="theme_settings[whatsapp_text]" rows="2" cols="36" name="theme_settings[whatsapp_text]"><?php esc_attr_e( $options['whatsapp_text'] ); ?></textarea>
                    </td>
                </tr>

                <!---->
                <tr valign="top">
                    <th scope="row"><?php _e( 'Address' ); ?></th>
                    <td><textarea id="theme_settings[address]" rows="5" cols="36" name="theme_settings[address]"><?php esc_attr_e( $options['address'] ); ?></textarea>
                    </td>
                </tr>

                <!---->
                <tr valign="top">
                    <th scope="row"><?php _e( 'Email' ); ?></th>
                    <td><input id="theme_settings[email]" type="text" size="40" name="theme_settings[email]" value="<?php esc_attr_e( $options['email'] ); ?>" />
                    </td>
                </tr>

                <!---->
                <tr valign="top">
                    <th scope="row"><?php _e( 'Opening hours' ); ?></th>
                    <td><textarea id="theme_settings[opening_hours]" rows="5" cols="36" name="theme_settings[opening_hours]"><?php esc_attr_e( $options['opening_hours'] ); ?></textarea>
                    </td>
                </tr>

                <!---->
                <tr valign="top">
                    <th scope="row"><?php _e( 'Cut-off delivery time' ); ?></th>
                    <td><input id="theme_settings[delivery_time]" type="text" size="40" name="theme_settings[delivery_time]" value="<?php esc_attr_e( $options['delivery_time'] ); ?>" />
                    </td>
                </tr>

                <!---->
                <tr valign="top">
                    <th scope="row"><?php _e( 'Al vanaf' ); ?></th>
                    <td><input id="theme_settings[min_price]" type="text" size="40" name="theme_settings[min_price]" value="<?php esc_attr_e( $options['min_price'] ); ?>" />
                    </td>
                </tr>

                <!---->
                <tr valign="top">
                    <th scope="row"><?php _e( 'Show vacation message' ); ?></th>
                    <td><input id="theme_settings[show_vac]" type="checkbox" name="theme_settings[show_vac]" value="1"<?php if($options['show_vac']){ ?> checked="checked"<?php } ?> />
                    </td>
                </tr>
                <!---->
                <tr valign="top">
                    <th scope="row"><?php _e( 'Vacation message' ); ?></th>
                    <td><textarea id="theme_settings[vac_message]" rows="5" cols="36" name="theme_settings[vac_message]"><?php esc_attr_e( $options['vac_message'] ); ?></textarea>
                    </td>
                </tr>

                <!---->
                <tr valign="top">
                    <th scope="row"><?php _e( 'Delivery Info' ); ?></th>
                    <td><textarea id="theme_settings[delivery_info]" rows="5" cols="36" name="theme_settings[delivery_info]"><?php esc_attr_e( $options['delivery_info'] ); ?></textarea>
                    </td>
                </tr>

            </table>

            <p><input name="submit" id="submit" value="Save Changes" type="submit"></p>
        </form>

    </div>

    <?php
}
//validation
function options_validate( $input ) {
    global $select_options, $radio_options;
    if ( ! isset( $input['option1'] ) )
        $input['option1'] = null;
    $input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );
    $input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );
    if ( ! isset( $input['radioinput'] ) )
        $input['radioinput'] = null;
    if ( ! array_key_exists( $input['radioinput'], $radio_options ) )
        $input['radioinput'] = null;
    $input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );
    return $input;
}
add_filter( 'woocommerce_terms_is_checked_default', '__return_true' );

remove_action('woocommerce_thankyou', 'woocommerce_order_details_table', 10);
/**
 * @snippet       Add Conversion Tracking Code to Thank You Page
 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
 * @sourcecode    https://businessbloomer.com/?p=19964
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 2.5.2
 */

add_action( 'woocommerce_thankyou', 'sc_conversion_tracking' );

function sc_conversion_tracking() {
    ?>
    <!-- Google Code for bestelling Conversion Page -->
    <script type="text/javascript">
        / <![CDATA[ /
        var google_conversion_id = 849724941;
        var google_conversion_language = "en";
        var google_conversion_format = "3";
        var google_conversion_color = "ffffff";
        var google_conversion_label = "JNagCIrGkHIQjYyXlQM"; var google_remarketing_only = false;
        / ]]> /
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
    <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/849724941/?label=JNagCIrGkHIQjYyXlQM&amp;guid=ON&amp;script=0"/>
        </div>
    </noscript>
    <!-- Bing Code for bestelling Conversion Page -->
    <script>(function(w,d,t,r,u){var f,n,i;w[u]=w[u]||[],f=function(){var o={ti:"22011273"};o.q=w[u],w[u]=new UET(o),w[u].push("pageLoad")},n=d.createElement(t),n.src=r,n.async=1,n.onload=n.onreadystatechange=function(){var s=this.readyState;s&&s!=="loaded"&&s!=="complete"||(f(),n.onload=n.onreadystatechange=null)},i=d.getElementsByTagName(t)[0],i.parentNode.insertBefore(n,i)})(window,document,"script","//bat.bing.com/bat.js","uetq");</script>
    <?php
}

// New order status AFTER woo 2.2
add_action( 'init', 'register_my_new_order_statuses' );
function register_my_new_order_statuses() {
    register_post_status( 'wc-production', array(
        'label'                     => _x( 'In productie', 'Order status', 'woocommerce' ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'In productie <span class="count">(%s)</span>', 'In productie<span class="count">(%s)</span>', 'woocommerce' )
    ) );
}
add_filter( 'wc_order_statuses', 'my_new_wc_order_statuses' );
// Register in wc_order_statuses.
function my_new_wc_order_statuses( $order_statuses ) {
    $order_statuses['wc-production'] = _x( 'In productie', 'Order status', 'woocommerce' );

    return $order_statuses;
}

add_filter( 'woocommerce_package_rates', 'hide_date_shipping', 10, 2 );
function hide_date_shipping( $rates, $package ) {
    $isKeyplan = false;
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
            //is keyplan
            if($_product->get_id() == 1577 || $_product->get_name() == "Sluitplan")
            {
                $isKeyplan = true;
            }
        }
    }
    if($isKeyplan) {
        unset( $rates['flat_rate:23'] );
        unset( $rates['flat_rate:24'] );
        unset( $rates['flat_rate:25'] );
    }

    return $rates;
}

function action_woocommerce_load_shipping_methods() {
    if(!is_admin()) {
        if ( ! session_id() ) {
            session_start();
        }
        if(@WC()->session) {
            WC()->session->__unset( 'delivery_labels' );
        }
        elseif(@$_SESSION["delivery_labels"]) {
            unset($_SESSION["delivery_labels"]);
        }
    }
}
add_action( 'woocommerce_load_shipping_methods', 'action_woocommerce_load_shipping_methods');
function change_deilvery_label( $label, $method ) {
    $noDateShippingId = "flat_rate:26";
    $label = $method->get_label();
    $isKeyplan = false;
    $dMethods = array("flat_rate:23",  "flat_rate:24", "flat_rate:25");
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
            //is keyplan
            if($_product->get_id() == 1577 || $_product->get_name() == "Sluitplan")
            {
                $isKeyplan = true;
            }
        }
    }
    if ( in_array($method->id, $dMethods) && $method->id != $noDateShippingId && WC()->customer->get_shipping_country() == "NL" && !$isKeyplan ) {
        $postData = @$_REQUEST["post_data"];
        parse_str($postData, $data);
        $date = get_shipping_method_delivery_date($method->id, ($data["h_deliverydate_0"] ? strtotime($data["h_deliverydate_0"]) : null));
        $days = array('Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag');
        $dayOfWeek = date('w', strtotime($date));
        $label = $days[$dayOfWeek] . (strpos($label, "22:00") !== false ? "avond" : "") . " " . $label;
        $deliveryLabels = @WC()->session->get('delivery_labels');
        $deliveryDates = @WC()->session->get('delivery_dates');
        if(@$deliveryLabels[$method->id]) {
            unset($deliveryLabels[$method->id]);
        }
        if(@$deliveryDates[$method->id]) {
            unset($deliveryDates[$method->id]);
        }
        if(in_array($label, $deliveryLabels))
        {
            $oldDate = strtotime($date);
            $date = get_shipping_method_delivery_date($method->id, $oldDate, true);
            $dayOfWeek = date('w', strtotime($date));
            $origLabel = $method->get_label();
            $label = $days[$dayOfWeek] . (strpos($label, "22:00") !== false ? "avond" : "") . " " . $origLabel;
        }
        $deliveryLabels[$method->id] = $label;
        $deliveryDates[$method->id] = $date;
        WC()->session->set('delivery_labels', $deliveryLabels);
        WC()->session->set('delivery_dates', $deliveryDates);
        if($method->id == WC()->session->get( 'chosen_shipping_methods' )[0]) {
            WC()->session->set( 'custom_deliverydate', $data["h_deliverydate_0"] );
            WC()->session->set( 'user_deliverydate', date("j-n-Y", strtotime($date)) );
        }
    }
    else {
        if($method->id == WC()->session->get( 'chosen_shipping_methods' )[0]) {
            WC()->session->__unset( 'custom_deliverydate' );
            WC()->session->__unset( 'user_deliverydate' );
        }
    }

    return $label;
}
add_filter( 'woocommerce_cart_shipping_method_full_label', 'change_deilvery_label', 10, 2 );

add_action('woocommerce_checkout_update_order_review', 'checkout_update_refresh_shipping_methods', 10, 1);
function checkout_update_refresh_shipping_methods( $post_data ) {
    $packages = WC()->cart->get_shipping_packages();
    foreach ($packages as $package_key => $package ) {
        WC()->session->set( 'shipping_for_package_' . $package_key, false ); // Or true
    }
}
add_filter( 'woocommerce_package_rates' , 'my_sort_shipping_methods', 10, 2 );
function my_sort_shipping_methods( $rates, $package ) {
    if ( empty( $rates ) ) return;
    if ( ! is_array( $rates ) ) return;

    if(@WC()->session->get('delivery_dates')) {
        uasort( $rates, function ( $a, $b ) {
            if ( $a->method_id == "service_point_shipping_method" ) {
                return 1;
            } elseif ( $b->method_id == "service_point_shipping_method" ) {
                return - 1;
            }
            $date1 = @WC()->session->get( 'delivery_dates' )[ $a->id ];
            $date2 = @WC()->session->get( 'delivery_dates' )[ $b->id ];
            if ( ! $date1 || ! $date2 ) {
                return 0;
            }
            //sort if the same day too
            if ( $date1 == $date2 ) {
                if ( strpos( $a->get_label(), "22:00" ) !== false ) {
                    return 1;
                }
            }

            return strtotime( $date1 ) - strtotime( $date2 );
        } );
    }

    return $rates;
}

function get_shipping_method_delivery_date($methodId, $curDate=null, $getNextDay=false) {
    $options = get_option( 'delivery_settings' );
    //delivery date settings
    $ddSettings = array();
    $eveningDeliveryId = "flat_rate:23";
    $nextDayDeliveryId = "flat_rate:24";
    $nextDayEveningDeliveryId = "flat_rate:25";
    $servicePointDeliveryId = "service_point_shipping_method:9";
    //default
    $ddSettings[0] = array();
    $ddSettings[0]["cat_slug"] = array();
    $ddSettings[0]["shipping_ids"] = array();
    $ddSettings[0]["same_day_cut_off"] = @$options[0]["same_day_cut_off"] >= 0 ? intval($options[0]["same_day_cut_off"]) : 0;
    $ddSettings[0]["next_day_cut_off"] = @$options[0]["next_day_cut_off"] >= 0 ? intval($options[0]["next_day_cut_off"]) : 17;
    $ddSettings[0]["weekdays"] = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6);
    $ddSettings[0]["order_weekdays"] = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5);
    //
    $ddSettings[1] = array();
    $ddSettings[1]["cat_slug"] = array();
    $ddSettings[1]["shipping_ids"] = array($eveningDeliveryId, $nextDayEveningDeliveryId);
    $ddSettings[1]["same_day_cut_off"] = @$options[0]["same_day_cut_off"] >= 0 ? intval($options[0]["same_day_cut_off"]) : 0;
    $ddSettings[1]["next_day_cut_off"] = @$options[0]["next_day_cut_off"] >= 0 ? intval($options[0]["next_day_cut_off"]) : 17;
    $ddSettings[1]["weekdays"] = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5);
    $ddSettings[1]["order_weekdays"] = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6);
    //
    $ddSettings[2] = array();
    $ddSettings[2]["cat_slug"] = array("nabestellen");
    $ddSettings[2]["shipping_ids"] = array($eveningDeliveryId);
    $ddSettings[2]["same_day_cut_off"] = @$options[1]["same_day_cut_off"] >= 0 ? intval($options[1]["same_day_cut_off"]) : 0;
    $ddSettings[2]["next_day_cut_off"] = @$options[1]["next_day_cut_off"] >= 0 ? intval($options[1]["next_day_cut_off"]) : 12;
    $ddSettings[2]["weekdays"] = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6);
    $ddSettings[2]["order_weekdays"] = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5);
    //
    $ddSettings[3] = array();
    $ddSettings[3]["cat_slug"] = array("nabestellen");
    $ddSettings[3]["shipping_ids"] = array($nextDayDeliveryId, $servicePointDeliveryId);
    $ddSettings[3]["same_day_cut_off"] = @$options[2]["same_day_cut_off"] >= 0 ? intval($options[2]["same_day_cut_off"]) : 0;
    $ddSettings[3]["next_day_cut_off"] = @$options[2]["next_day_cut_off"] >= 0 ? intval($options[2]["next_day_cut_off"]) : 12;
    $ddSettings[3]["weekdays"] = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6);
    $ddSettings[3]["order_weekdays"] = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5);
    //
    $ddSettings[4] = array();
    $ddSettings[4]["cat_slug"] = array("mc-color-pro", "mc-condor", "mc-matrix", "mc-color-plus", "mc-move", "nabestellen-sleutels");
    $ddSettings[4]["shipping_ids"] = array($eveningDeliveryId);
    $ddSettings[4]["same_day_cut_off"] = @$options[3]["same_day_cut_off"] >= 0 ? intval($options[3]["same_day_cut_off"]) : 11;
    $ddSettings[4]["next_day_cut_off"] = @$options[3]["next_day_cut_off"] >= 0 ? intval($options[3]["next_day_cut_off"]) : 17;
    $ddSettings[4]["weekdays"] = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5);
    $ddSettings[4]["order_weekdays"] = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7);
    //
    $ddSettings[5] = array();
    $ddSettings[5]["cat_slug"] = array("mc-color-pro", "mc-condor", "mc-matrix", "mc-color-plus", "mc-move", "nabestellen-sleutels");
    $ddSettings[5]["shipping_ids"] = array($nextDayEveningDeliveryId);
    $ddSettings[5]["same_day_cut_off"] = @$options[4]["same_day_cut_off"] >= 0 ? intval($options[4]["same_day_cut_off"]) : 0;
    $ddSettings[5]["next_day_cut_off"] = @$options[4]["next_day_cut_off"] >= 0 ? intval($options[4]["next_day_cut_off"]) : 17;
    $ddSettings[5]["weekdays"] = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5);
    $ddSettings[5]["order_weekdays"] = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7);
    //
    $ddSettings[6] = array();
    $ddSettings[6]["cat_slug"] = array("nabestellen");
    $ddSettings[6]["shipping_ids"] = array($nextDayEveningDeliveryId);
    $ddSettings[6]["same_day_cut_off"] = @$options[5]["same_day_cut_off"] >= 0 ? intval($options[5]["same_day_cut_off"]) : 0;
    $ddSettings[6]["next_day_cut_off"] = @$options[5]["next_day_cut_off"] >= 0 ? intval($options[5]["next_day_cut_off"]) : 0;
    $ddSettings[6]["weekdays"] = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6);
    $ddSettings[6]["order_weekdays"] = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5);

    $siteDate = current_time( 'timestamp' );
    $hours = date("H", $siteDate);
    $diff = null;
    if(!$curDate)
    {
        $curDate = $siteDate;
    }
    elseif(strtotime(date("d.m.Y", $curDate)) > strtotime(date("d.m.Y", $siteDate)))
    {
        $hours = 0;
        $timeDiff = strtotime(date("d.m.Y", $siteDate)) - strtotime(date("d.m.Y", $curDate));
        //$diff = floor($timeDiff / 3600 / 24);
    }
    $dayOfWeek = intval(date("w", $curDate));
    if($dayOfWeek == 0)
    {
        $dayOfWeek = 7;
    }
    $w = null;
    $date = null;
    $catArray = array();
    $hasCustomColor = false;
    //get the product categories from the cart and check color
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
            $categories = get_the_terms($_product->get_id(), 'product_cat');
            foreach($categories as $category) {
                $catArray[$category->term_id] = $category->slug;
            }

            foreach($cart_item["addons"] as $meta) {
                if(strtolower(trim($meta["name"])) == "uitvoering" && in_array("deurcilinders", $catArray) && !in_array("nabestellen", $catArray)) {
                    $color = trim($meta["value"]);
                    if($color && strtolower($color) != "nikkel")
                    {
                        $hasCustomColor = true;
                    }
                }
            }
        }
    }
    if($hasCustomColor)
    {
        $catArray = array("nabestellen" => "nabestellen");
    }

    //find needed settings
    $sIndex = 0;
    foreach($ddSettings as $ind => $settings) {
        $catFound = false;
        if(!empty($settings["cat_slug"])) {
            foreach($catArray as $catSlug)
            {
                if(in_array($catSlug, $settings["cat_slug"])) {
                    $catFound = true;
                    break;
                }
            }
        }
        if($catFound || empty($settings["cat_slug"]))
        {
            if(empty($settings["shipping_ids"]) || in_array($methodId, $settings["shipping_ids"]))
            {
                $sIndex = $ind;
            }
        }
    }

    $w = $dayOfWeek;
    if(!$getNextDay)
    {
        $w = calcWeekDay($w, $diff, $ddSettings[$sIndex]["weekdays"], $hours, $ddSettings[$sIndex]["same_day_cut_off"], $ddSettings[$sIndex]["next_day_cut_off"], $ddSettings[$sIndex]["order_weekdays"]);
    }
    else
    {
        $w = getClosestWeekDay($w, $ddSettings[$sIndex]["weekdays"]);
    }

    $addDays = $w - $dayOfWeek;
    if($addDays < 0)
    {
        $addDays += 7;
    }

    if(!$addDays)
    {
        $date = date("d.m.Y", $curDate);
    }
    else {
        $date = date("d.m.Y", strtotime("+" . $addDays . " day", $curDate));
    }

    //add holidays
    $firstDate = "03.01.2020";
    /*if(in_array($eveningDeliveryId, $ddSettings[$sIndex]["shipping_ids"]) || in_array($nextDayEveningDeliveryId, $ddSettings[$sIndex]["shipping_ids"])) {
        $firstDate = "30.12.2019";
    }*/
    if(strtotime($date) < strtotime($firstDate)) {
        $date = $firstDate;
    }

    return $date;
}
function calcWeekDay($w, $diff, $weekdays, $hours, $sameDayCutOff, $nexDayCutOff, $orderWeekdays) {
    //check cut-off params
    if($diff === null || $diff < 0)
    {
        $subDiff = 0;
        if($diff < 0)
        {
            $subDiff = $diff + 1;
        }
        if(!isset($orderWeekdays[$w]))
        {
            $hours = 0;
        }
        if($sameDayCutOff > $hours) {
            $diff = 0;
        }
        elseif($nexDayCutOff > $hours) {
            $diff = 1;
        }
        else {
            $diff = 2;
        }
        if($subDiff < 0)
        {
            $diff += $subDiff;
            if($diff < 0)
            {
                $diff = 0;
            }
        }

    }
    $hours = 0;

    if(empty($weekdays)) {
        return ($w + $diff <= 7 ? $w + $diff : $w + $diff - 7);
    }
    //print_r("w=".$w.";diff=".$diff.";");
    $oldW = $w;
    $oldD = $diff;
    if(!isset($weekdays[$w])) {
        $w = ($w + 1 <= 7 ? $w + 1 : $w + 1 - 7);
        for($i = 0; $i < $oldD; $i++) {
            if(isset($orderWeekdays[($oldW + $i <= 7 ? $oldW + $i : $oldW + $i - 7)]) && !isset($weekdays[($oldW + $i <= 7 ? $oldW + $i : $oldW + $i - 7)])) {
                $diff--;
            }
        }
        $w = calcWeekDay($w, $diff, $weekdays, $hours, $sameDayCutOff, $nexDayCutOff, $orderWeekdays);
    }
    else {

        $w = ($w + $diff <= 7 ? $w + $diff : $w + $diff - 7);
        for($i = 0; $i < $oldD; $i++) {
            if(isset($orderWeekdays[($oldW + $i <= 7 ? $oldW + $i : $oldW + $i - 7)])) {
                $diff--;
            }
        }
        if(!isset($weekdays[$w]) || $diff > 0) {
            $w = calcWeekDay($w, $diff, $weekdays, $hours, $sameDayCutOff, $nexDayCutOff, $orderWeekdays);
        }
    }

    return $w;
}
function getClosestWeekDay($w, $weekdays)
{
    if(!empty($weekdays))
    {
        do
        {
            $w = ($w + 1 <= 7 ? $w + 1 : $w + 1 - 7);
        }
        while(!isset($weekdays[$w]));
    }
    return $w;
}

add_filter( 'woocommerce_checkout_create_order', 'change_delivery_date', 10, 1 );
function change_delivery_date($order) {
    $newDate = @$_POST['user_deliverydate'] ? sanitize_text_field( $_POST['user_deliverydate'] ) : sanitize_text_field( @WC()->session->get( 'user_deliverydate' ) );
    if($newDate) {
        $_POST["h_deliverydate_0"] = $newDate;

        $months = array("January","February","March","April","May","June","July","August","September","October","November","December");
        $monthsDutch = array("januari","februari","maart","april","mei","juni","juli","augustus","september","oktober","november","december");
        $_POST["e_deliverydate_0"] = str_replace($months, $monthsDutch, date("d F, Y", strtotime($newDate)));
    }

    return $order;
}

//Register Settings Function
function theme_settings_delivery(){
    register_setting( 'delivery_settings', 'delivery_settings' );
}

//Add settings to page menu
function add_settings_delivery() {
    add_menu_page( __( 'Order Delivery Time' ), __( 'Order Delivery Time' ), 'manage_options', 'delivery_settings', 'theme_settings_page_delivery');
}

//Add Actions
add_action( 'admin_init', 'theme_settings_delivery' );
add_action( 'admin_menu', 'add_settings_delivery' );

//Start Setting Page
function theme_settings_page_delivery() {

    if ( ! isset( $_REQUEST['updated'] ) )
        $_REQUEST['updated'] = false;

    ?>

    <div>
        <div id="icon-options-general"></div>
        <h2 id="title"><?php _e( 'Order Delivery Settings' ) //your admin panel title ?></h2>
        <?php
        //show saved options message
        if ( false !== $_REQUEST['updated'] ) : ?>
            <div><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
        <?php endif; ?>

        <form method="post" action="options.php">
            <?php settings_fields( 'delivery_settings' ); ?>
            <?php $options = get_option( 'delivery_settings' ); ?>
            <h3>Default</h3>
            <table>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Same Day Cut-off Time' ); ?></th>
                    <td><input id="delivery_settings[0][same_day_cut_off]" type="text" size="2" name="delivery_settings[0][same_day_cut_off]" value="<?php esc_attr_e( $options[0]['same_day_cut_off'] ); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Next Day Cut-off Time' ); ?></th>
                    <td><input id="delivery_settings[0][next_day_cut_off]" type="text" size="2" name="delivery_settings[0][next_day_cut_off]" value="<?php esc_attr_e( $options[0]['next_day_cut_off'] ); ?>" />
                    </td>
                </tr>
            </table>
            <h3>Cilinders nabestellen</h3>
            <h4>Evening delivery</h4>
            <table>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Same Day Cut-off Time' ); ?></th>
                    <td><input id="delivery_settings[1][same_day_cut_off]" type="text" size="2" name="delivery_settings[1][same_day_cut_off]" value="<?php esc_attr_e( $options[1]['same_day_cut_off'] ); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Next Day Cut-off Time' ); ?></th>
                    <td><input id="delivery_settings[1][next_day_cut_off]" type="text" size="2" name="delivery_settings[1][next_day_cut_off]" value="<?php esc_attr_e( $options[1]['next_day_cut_off'] ); ?>" />
                    </td>
                </tr>
            </table>
            <h4>Next Day delivery</h4>
            <table>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Same Day Cut-off Time' ); ?></th>
                    <td><input id="delivery_settings[2][same_day_cut_off]" type="text" size="2" name="delivery_settings[2][same_day_cut_off]" value="<?php esc_attr_e( $options[2]['same_day_cut_off'] ); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Next Day Cut-off Time' ); ?></th>
                    <td><input id="delivery_settings[2][next_day_cut_off]" type="text" size="2" name="delivery_settings[2][next_day_cut_off]" value="<?php esc_attr_e( $options[2]['next_day_cut_off'] ); ?>" />
                    </td>
                </tr>
            </table>
            <h4>Next Day Evening delivery</h4>
            <table>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Same Day Cut-off Time' ); ?></th>
                    <td><input id="delivery_settings[5][same_day_cut_off]" type="text" size="2" name="delivery_settings[5][same_day_cut_off]" value="<?php esc_attr_e( $options[5]['same_day_cut_off'] ); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Next Day Cut-off Time' ); ?></th>
                    <td><input id="delivery_settings[5][next_day_cut_off]" type="text" size="2" name="delivery_settings[5][next_day_cut_off]" value="<?php esc_attr_e( $options[5]['next_day_cut_off'] ); ?>" />
                    </td>
                </tr>
            </table>

            <h3>M&C Color Pro, M&C Condor, M&C Matrix, Sleutels nabestellen</h3>
            <h4>Evening delivery</h4>
            <table>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Same Day Cut-off Time' ); ?></th>
                    <td><input id="delivery_settings[3][same_day_cut_off]" type="text" size="2" name="delivery_settings[3][same_day_cut_off]" value="<?php esc_attr_e( $options[3]['same_day_cut_off'] ); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Next Day Cut-off Time' ); ?></th>
                    <td><input id="delivery_settings[3][next_day_cut_off]" type="text" size="2" name="delivery_settings[3][next_day_cut_off]" value="<?php esc_attr_e( $options[3]['next_day_cut_off'] ); ?>" />
                    </td>
                </tr>
            </table>
            <h4>Next Day Evening delivery</h4>
            <table>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Same Day Cut-off Time' ); ?></th>
                    <td><input id="delivery_settings[4][same_day_cut_off]" type="text" size="2" name="delivery_settings[4][same_day_cut_off]" value="<?php esc_attr_e( $options[4]['same_day_cut_off'] ); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Next Day Cut-off Time' ); ?></th>
                    <td><input id="delivery_settings[4][next_day_cut_off]" type="text" size="2" name="delivery_settings[4][next_day_cut_off]" value="<?php esc_attr_e( $options[4]['next_day_cut_off'] ); ?>" />
                    </td>
                </tr>
            </table>

            <p><input name="submit" id="submit" value="Save Changes" type="submit"></p>
        </form>

    </div>

    <?php
}

add_filter("woocommerce_checkout_fields", "custom_override_checkout_fields", 1);
function custom_override_checkout_fields($fields) {
    $fields['billing']['billing_country']['priority'] = 100;
    $fields['shipping']['shipping_country']['priority'] = 100;
    $fields['billing']['billing_company']['priority'] = 5;
    $fields['shipping']['shipping_company']['priority'] = 5;
    return $fields;
}
add_filter( 'woocommerce_default_address_fields', 'custom_override_default_locale_fields' );
function custom_override_default_locale_fields( $fields ) {
    $fields['country']['priority'] = 100;
    $fields['company']['priority'] = 5;
    return $fields;
}

function mysite_woocommerce_order_delivery( $order_id = null ) {
    if(!$order_id)
    {
        $order_id = intval(@$_GET["order_id"]);
    }
    if(isset($_GET["delivery_export"]) && $order_id > 0 && current_user_can("administrator")) {
        $order = wc_get_order( $order_id );
        $order_data = $order->get_data();
        $deliveryApiKey = "8UJXwgZU9BZrM921s0K1dwebYqmt35HcZqawHaqR";
        $deliveryClientId = 81;
        $params = array();
        $params["client_id"] = $deliveryClientId;
        $params["title"] = $order->get_order_number();
        $params["delivery_date"] = date("Y-m-d H:i:s");
        $fields = http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.aendelivery.nl/deliveries');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $deliveryApiKey));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($response, true);
        //print_r($res);
        $deliveryId = intval(@$res["inserted_id"]);
        if($deliveryId > 0) {
            $addressField = $order_data['shipping']['address_1'];
            if(trim($order_data['shipping']['address_2']))
            {
                $addressField .= " " . $order_data['shipping']['address_2'];
            }
            $address = explode(" ", str_replace(",", " ", $addressField));
            $address1 = "";
            $address2 = "";
            foreach($address as $ind => $adr){
                if($ind < count($address) - 1) {
                    $address1 .= " " . $adr;
                }
                else {
                    $address2 = $adr;
                }
            }
            $params = array();
            $params["delivery_id"] = $deliveryId;
            $params["parcel_title"] = $order->get_order_number();
            $params["length"] = 20;
            $params["width"] = 17;
            $params["height"] = 6;
            $params["weight"] = 2;
            $params["parcel_type"] = 7;
            $params["parcel_pickup_street"] = "Sluis";
            $params["parcel_pickup_number"] = 23;
            $params["parcel_pickup_postal_code"] = "2376AS";
            $params["parcel_pickup_city"] = "Nieuwe Wetering";
            $params["parcel_pickup_country"] = "Nederland";
            $params["parcel_pickup_contact"] = "Marcel Randshuizen";
            $params["parcel_pickup_phone"] = "0232050100";
            $params["parcel_pickup_company"] = "Mr-Beveiliging";
            $params["parcel_delivery_street"] = trim($address1);
            $params["parcel_delivery_number"] = trim($address2);
            $params["parcel_delivery_postal_code"] = str_replace(" ", "", $order_data['shipping']['postcode']);
            $params["parcel_delivery_city"] = $order_data['shipping']['city'];
            $params["parcel_delivery_country"] = WC()->countries->countries[$order_data['shipping']['country']];
            $params["parcel_delivery_contact"] = $order_data['shipping']['first_name'] . " " . $order_data['shipping']['last_name'];
            $params["parcel_delivery_phone"] = preg_replace('/\D/', '', $order_data['billing']['phone']);
            $params["parcel_comment"] = "";
            if($order_data['shipping']['company']) {
                $params["parcel_delivery_company"] = $order_data['shipping']['company'];
            }
            $params["parcel_delivery_email"] = $order_data['billing']['email'];
            $params["parcel_duplicate"] = "Enkel pakket";
            $params["status"] = 2;
            $fields = http_build_query($params);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.aendelivery.nl/parcels');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $deliveryApiKey));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            curl_close($ch);
            $res = json_decode($response, true);
            wp_safe_redirect($_SERVER["HTTP_REFERER"]);
            exit();
        }
    }
}
add_action( 'template_redirect', 'mysite_woocommerce_order_delivery', 10, 1 );

add_filter( 'woocommerce_admin_order_actions', 'add_custom_delivery_export', 100, 2 );
function add_custom_delivery_export( $actions, $order ) {
    if ( $order->has_status( array( 'processing' ) ) ) {
        $action_slug = "aendelivery";
        // Set the action button
        $actions[$action_slug] = array(
            'url'       => home_url() . "/?delivery_export&order_id=" . $order->get_id(),
            'name'      => __( 'Export to a&delivery', 'woocommerce' ),
            'action'    => $action_slug,
        );
    }

    return $actions;
}
// Set Here the WooCommerce icon for your action button
add_action( 'admin_head', 'add_custom_order_status_actions_button_css' );
function add_custom_order_status_actions_button_css() {
    $action_slug = "aendelivery"; // The key slug defined for your action button
    echo '<style>.wc-action-button-'.$action_slug.'::after { font-family: woocommerce !important; content: "\e029" !important; }</style>';
}

// Add an aendelivery export button only for shop_order post type (order edit pages)
add_action( 'add_meta_boxes', 'add_meta_boxes_aen' );
function add_meta_boxes_aen()
{
    add_meta_box( 'aen_meta_box', __( 'Export to a&delivery', 'woocommerce' ),
        'aen_metabox_content', 'shop_order', 'normal', 'default');
}
function aen_metabox_content(){
    $post_id = isset($_GET['post']) ? $_GET['post'] : false;
    if(! $post_id ) return; // Exit

    $order = wc_get_order( $post_id );
    if(!empty($order))
    {
        if ( $order->has_status( array( 'processing' ) ) ) {
            echo "<p><a class='button' href='" . home_url() . "/?delivery_export&order_id=" . $order->get_id() . "'>" . __( 'Export to a&delivery', 'woocommerce' ) . "</a></p>";
        }
        else {
            echo "<p>Export works for 'processing' orders.</p>";
        }
    }
}

add_filter( 'wpseo_json_ld_output', '__return_false' );

add_filter( 'woocommerce_email_recipient_customer_on_hold_order', 'customer_on_hold_order_for_specified_payment', 10, 2 );
function customer_on_hold_order_for_specified_payment( $recipient, $order ) {
    if ( 'mollie_wc_gateway_klarnapaylater' == $order->get_payment_method() ) {
        $recipient = '';
    }
    return $recipient;
}

add_action( 'template_redirect', 'simple_cart_handler' );
function simple_cart_handler() {
    if( isset( $_GET['simple_cart'] ) && $_SERVER['REQUEST_METHOD'] == "POST" ) {
        global $Product_Addon_Cart;
        if($Product_Addon_Cart && !empty($_REQUEST["items"])) {

            foreach($_REQUEST["items"] as $ind => $item) {
                $cart_item_data_array = $item;
                $cart_item_data = $Product_Addon_Cart->add_cart_item_data(array(), $item["add-to-cart"], $cart_item_data_array);
                foreach ($cart_item_data["addons"] as $key => $cart_item_data_item) {
                    if ($cart_item_data_item["name"] == "Maat") {
                        $cart_item_data["addons"][$key]["name"] = "Cilindermaat";//"Buitenzijde/Binnenzijde";
                    }
                    if ($cart_item_data_item["name"] == "Extra knop lange kant") {
                        $cart_item_data["addons"][$key]["name"] = "Binnenzijde";
                    }
                    if ($cart_item_data_item["value"] == "Knop lange zijde") {
                        $cart_item_data["addons"][$key]["value"] = "Knop";
                    }
                    if ($cart_item_data_item["value"] == "Pushknop lange zijde") {
                        $cart_item_data["addons"][$key]["value"] = "Pushknop";
                    }
                    if ($cart_item_data_item["name"] == "Extra knop korte kant") {
                        //$cart_item_data["addons"][$key]["name"] = "Buitenzijde";
                        unset($cart_item_data["addons"][$key]);
                    }
                }
                unset($_FILES);
                WC()->cart->add_to_cart($item["add-to-cart"], $item["quantity"], 0, null, $cart_item_data);
            }
        }
        exit();
    }
}

add_action( 'woocommerce_cart_item_removed', 'after_remove_product_from_cart', 30, 2 );
function after_remove_product_from_cart($removed_cart_item_key, $cart) {
    if(WC()->cart->get_subtotal() == 0) {
        WC()->cart->empty_cart();
    }
}

/*add_action( 'woocommerce_checkout_update_order_meta', 'sp_woocommerce_new_order_action', 100, 1 );
function sp_woocommerce_new_order_action( $order_id ){
    $order = new WC_Order($order_id);
    foreach( $order->get_items( 'shipping' ) as $item_id => $item ){
        $shipping_method_id = $item->get_method_id();
        if($shipping_method_id == "service_point_shipping_method") {
            $spData = get_post_meta( $order_id, "sendcloudshipping_service_point_meta", true );
            if($spData) {
                $extraData = array_key_exists( 'extra', $spData ) ? $spData['extra'] : '';
                if($extraData) {
                    try {
                        $addressLines = explode( '|', $extraData );
                        $address1 = trim($addressLines[1]) . ", ". $addressLines[0];
                        $order->set_shipping_address_1($address1);
                        $address2 = "";//not set
                        $order->set_shipping_address_2($address2);
                        $state = "";//not set
                        $order->set_shipping_state($state);
                        $postcode = explode(" ", $addressLines[2])[0];
                        $order->set_shipping_postcode($postcode);
                        $city = trim(str_replace($postcode,"",$addressLines[2]));
                        $order->set_shipping_city($city);
                        $country = "NL";//only Netherlands for service point
                        $order->set_shipping_country($country);
                        $order->save();
                        //unset other address fields
                        update_post_meta($order_id, '_shipping_street_name', '');
                        update_post_meta($order_id, '_shipping_house_number', '');
                    } catch (Exception $e) {
                        //
                    }
                }
            }
        }
    }
}*/

add_action( 'template_redirect', 'btw_handler' );
function btw_handler() {
    if(isset($_GET["btw_status"]) && isset($_POST)) {
        if($_POST["excl_btw"] == "true") {
            setcookie("excl_btw", true, time() + (86400 * 30), "/");
        } else {
            setcookie("excl_btw", false, time() + (86400 * 30), "/");
        }
    }
}
function get_product_addon_price_for_display_custom( $price, $cart_item = null ) {
    $excl_btw = isset($_COOKIE["excl_btw"]) && $_COOKIE["excl_btw"] ? true : false;
    if(!isset($_COOKIE["excl_btw"])) {
        if(get_product_addon_tax_display_mode() === 'incl') {
            $excl_btw = false;
        } else {
            $excl_btw = true;
        }
    }

    $product = ! empty( $GLOBALS['product'] ) && is_object( $GLOBALS['product'] ) ? clone $GLOBALS['product'] : null;

    if ( '' === $price || '0' == $price ) {
        return;
    }

    $neg = false;

    if ( $price < 0 ) {
        $neg = true;
        $price *= -1;
    }

    if ( ( is_cart() || is_checkout() ) && null !== $cart_item ) {
        $product = wc_get_product( $cart_item->get_id() );
    }

    if ( is_object( $product ) ) {
        // Support new wc_get_price_excluding_tax() and wc_get_price_excluding_tax() functions.
        if ( function_exists( 'wc_get_price_excluding_tax' ) ) {
            $display_price = !$excl_btw ? wc_get_price_including_tax( $product, array( 'qty' => 1, 'price' => $price ) ) : wc_get_price_excluding_tax( $product, array( 'qty' => 1, 'price' => $price ) );
        } else {
            $display_price = !$excl_btw ? $product->get_price_including_tax( 1, $price ) : $product->get_price_excluding_tax( 1, $price );
        }
    } else {
        $display_price = $price;
    }

    if ( $neg ) {
        $display_price = '-' . $display_price;
    }

    return $display_price;
}
function wc_get_price_to_display_custom( $product, $args = array() ) {
    $excl_btw = isset($_COOKIE["excl_btw"]) && $_COOKIE["excl_btw"] ? true : false;
    if(!isset($_COOKIE["excl_btw"])) {
        if('incl' === get_option( 'woocommerce_tax_display_shop' )) {
            $excl_btw = false;
        } else {
            $excl_btw = true;
        }
    }

    $args = wp_parse_args(
        $args,
        array(
            'qty'   => 1,
            'price' => $product->get_price(),
        )
    );

    $price = $args['price'];
    $qty   = $args['qty'];

    return !$excl_btw ?
        wc_get_price_including_tax(
            $product,
            array(
                'qty'   => $qty,
                'price' => $price,
            )
        ) :
        wc_get_price_excluding_tax(
            $product,
            array(
                'qty'   => $qty,
                'price' => $price,
            )
        );
}
function get_banner_price($obj=null) {
    $excl_btw = isset($_COOKIE["excl_btw"]) && $_COOKIE["excl_btw"] ? true : false;
    if(!isset($_COOKIE["excl_btw"])) {
        if('incl' === get_option( 'woocommerce_tax_display_shop' )) {
            $excl_btw = false;
        } else {
            $excl_btw = true;
        }
    }

    $price = "";
    if($obj) {
        $price = get_field("banner_price", $obj);
    }
    else {
        if(get_field("banner_price")) {
            $price = get_field("banner_price");
        } else {
            $options = get_option( 'theme_settings' );
            $price = $options["min_price"];
        }
    }
    if($price) {
        $price = floatval(str_replace(",",".",$price));

        if($excl_btw) {
            $tax_rate_info = 0;
            $tax_rates = WC_Tax::get_rates();
            if (!empty($tax_rates)) {
                $tax_rate = reset($tax_rates);
                $tax_rate_info = (float)$tax_rate['rate'];
            }
            $price /= (1 + $tax_rate_info / 100);
        }
    }

    return sprintf("%01.2f", $price);
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'wc_print_notices', 'woocommerce_result_count', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
//remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

function allow_payment_without_login( $allcaps, $caps, $args ) {
    // Check we are looking at the WooCommerce Pay For Order Page
    if ( !isset( $caps[0] ) || $caps[0] != 'pay_for_order' )
        return $allcaps;
    // Check that a Key is provided
    if ( !isset( $_GET['key'] ) )
        return $allcaps;

    // Find the Related Order
    $order = wc_get_order( $args[2] );
    if( !$order )
        return $allcaps; # Invalid Order

    // Get the Order Key from the WooCommerce Order
    $order_key = $order->get_order_key();
    // Get the Order Key from the URL Query String
    $order_key_check = $_GET['key'];

    // Set the Permission to TRUE if the Order Keys Match
    $allcaps['pay_for_order'] = ( $order_key == $order_key_check );

    return $allcaps;
}
add_filter( 'user_has_cap', 'allow_payment_without_login', 10, 3 );

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
}

add_filter('woocommerce_cart_get_cart', function($cart_contents) {
    // Return if the cart is empty
    if (empty($cart_contents)) return $cart_contents;

    // Sort items using custom logic
    uasort($cart_contents, function($a, $b) {
        // Sort by product name alphabetically
        return strcmp($a['data']->get_name(), $b['data']->get_name());
    });

    return $cart_contents;
});

/*
 * Fix Duplicate Content & Sitemap for Technical Products
 * 
 * 1. Redirect technical products (/product/slug) to marketing pages (/slug)
 * 2. Exclude these technical products from Yoast SEO Sitemap
 */

// 1. Redirect logic
add_action( 'template_redirect', 'redirect_technical_products_to_marketing_pages' );
function redirect_technical_products_to_marketing_pages() {
    // Only target single product pages that are NOT in the admin area
    if ( is_product() && ! is_admin() ) {
        $queried_object_id = get_queried_object_id();
        $redirect_link = '';

        // 1. Try ACF field first
        if ( function_exists('get_field') ) {
            $redirect_link = get_field('link', $queried_object_id);
        }

        // 2. Check for matching slug if ACF field is empty
        if ( empty( $redirect_link ) ) {
            $post = get_post( $queried_object_id );
            if ( $post && ! empty( $post->post_name ) ) {
                // Check if a standard marketing page with same slug exists
                $marketing_page = get_page_by_path( $post->post_name, OBJECT, 'page' );
                if ( $marketing_page ) {
                    $redirect_link = home_url( '/' . $post->post_name . '/' );
                } else {
                    // 3. Robust fallback to /sluitplan/ for technical products without a specific page
                    $redirect_link = home_url( '/sluitplan/' );
                }
            }
        }

        if ( ! empty( $redirect_link ) ) {
            wp_safe_redirect( $redirect_link, 301 );
            exit;
        }
    }
}

// 2. Yoast SEO Sitemap Exclusion
// Targeted solution: exclude individual product IDs instead of the entire post type
// This keeps the product sitemap container active (preserving the /winkel/ archive)
add_filter( 'wpseo_exclude_from_sitemap_by_post_ids', 'exclude_technical_products_from_sitemap' );
function exclude_technical_products_from_sitemap( $excluded_posts ) {
    global $wpdb;
    $product_ids = $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'product' AND post_status = 'publish'" );

    if ( ! empty( $product_ids ) ) {
        $ids_to_exclude = array_map( 'intval', $product_ids );
        $excluded_posts = array_merge( $excluded_posts, $ids_to_exclude );
    }

    return $excluded_posts;
}


