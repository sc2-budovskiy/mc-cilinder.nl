<?php /* Template Name: Test Export */ ?>

<?php
/*$order_id = 1726;

// Lets grab the order
$order = wc_get_order( $order_id );

$keyplan = false;

// This is how to grab line items from the order
$lineItems = $order->get_items();

// This loops over line items
foreach ( $lineItems as $item ) {
	// This will be a product
	$product = $order->get_product_from_item( $item );

	$productId = $product->get_id();
	$productName = $product->get_name();

	if($productId == 1577 || $productName == "Sluitplan")
	{
		$keyplan = true;
		break;
	}
}

if($keyplan) {
	$date = $order->get_date_created();

	$company = $order->get_billing_company();

	$address = $order->get_shipping_address_1();

	$postcode = $order->get_shipping_postcode();

	$city = $order->get_shipping_city();

	$country = $order->get_shipping_country();

	$brand = "";

	require_once( get_template_directory() . '/includes/phpexcel/PHPExcel.php' );
	require_once( get_template_directory() . '/includes/phpexcel/PHPExcel/IOFactory.php' );

	// Create new PHPExcel object
	$objPHPExcel = PHPExcel_IOFactory::load( $_SERVER["DOCUMENT_ROOT"] . "/keyplan_excel/blank.xlsx" );

	// Add some data
	$objPHPExcel->setActiveSheetIndex( 0 );

	$sheet = $objPHPExcel->getActiveSheet();

	$sheet->setCellValue( "D8", $order_id );
	$sheet->setCellValue( "D9", $company );
	$sheet->setCellValue( "I9", wc_format_datetime( $date, "d.m.Y" ) );
	$sheet->setCellValue( "D10", $address );
	$sheet->setCellValue( "D12", $postcode . ", " . $city . ", " . $country );

	$cilinderIndex = 0;
	$cilinderStartRow = 15;
	$doorNames = array();
	$keyIndex = 0;
	$keyStartCol = "N";
	$keyNames = array();
	$keyAccess = array();
	foreach ( $lineItems as $itemId => $item ) {
		$product = $order->get_product_from_item( $item );
		$productId = $product->get_id();

		//category
		$categories = get_the_terms($productId, 'product_cat');
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

		// This is the qty purchased
		$qty = $item['qty'];

		//addons
		if($productType == "cilinder") {
			//check brand condor/matrix
			if(!$brand) {
				$productName = strtolower( $product->get_name() );
				if ( strpos( $productName, "matrix" ) !== false ) {
					$brand = "Matrix";
				}
				elseif(strpos( $productName, "condor") !== false)
				{
					$brand = "Condor";
				}
			}

			$color = "";
			$doorName = "";
			$size = "";
			$knop = "";
			foreach($item->get_formatted_meta_data() as $meta) {
				if(strpos($meta->key, "Uitvoering") !== false) {
					$color = strtolower($meta->value);
				}
				if(strpos($meta->key, "Door name") !== false) {
					$doorName = $meta->value;
				}
				if(strpos($meta->key, "Maat") !== false) {
					$size = $meta->value;
				}
				if(strpos($meta->key, "Door type") !== false) {
					if($meta->value == "Binnendeur") {
						$size = strtolower($meta->value);
					}
				}
				if(strpos($meta->key, "Extra knop korte kant") !== false || strpos($meta->key, "Extra knop lange kant") !== false) {
					if($meta->value != "Geen") {
						if ( $knop ) {
							$knop .= ", ";
						}
						$knop .= strtolower( $meta->value );
					}
				}
			}
			$doorNames[$cilinderIndex] = $doorName;

			$curCilinderRow = $cilinderStartRow + $cilinderIndex;
			$sheet->setCellValue("C" . $curCilinderRow, $doorName);
			$sheet->setCellValue("F" . $curCilinderRow, $size);
			$sheet->setCellValue("J" . $curCilinderRow, $qty);
			$sheet->setCellValue("K" . $curCilinderRow, $knop);
			$sheet->setCellValue("L" . $curCilinderRow, $color);
			$cilinderIndex++;
		}
		elseif($productType == "key")
		{
			//check the same key name
			$keyName = "";
			foreach($item->get_formatted_meta_data() as $meta) {
				if ( strpos( $meta->key, "User" ) !== false ) {
					$keyName = $meta->value;
				}
				if ( strpos( $meta->key, "Access" ) !== false ) {
					$keyAccess[$keyIndex] = $meta->value;
				}
			}
			if(!in_array($keyName, $keyNames))
			{
				$keyNames[$keyIndex] = $keyName;

				$curKeyCol = chr(ord($keyStartCol) + $keyIndex);
				$sheet->setCellValue($curKeyCol . "4", $keyName);
				$sheet->setCellValue($curKeyCol . "1", $qty);
				$keyIndex++;
			}
			else
			{
				//sum key quantity
				$qtyKeyCol = chr(ord($keyStartCol) + array_keys($keyNames, $keyName)[0]);
				$sheet->setCellValue($qtyKeyCol . "1", intval($sheet->getCell($qtyKeyCol . "1")->getValue()) + $qty);
			}
		}
	}

	//key access
	foreach($keyAccess as $keyIndex => $access)
	{
		$curKeyCol = chr(ord($keyStartCol) + $keyIndex);
		$accessList = explode(",", $access);
		foreach($accessList as $door)
		{
			$door = trim($door);
			//check masterkey
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
	}

	$sheet->setCellValue( "I8", $brand );

	$objWriter = PHPExcel_IOFactory::createWriter( $objPHPExcel, 'Excel2007' );
	$objWriter->save($_SERVER["DOCUMENT_ROOT"] . "/keyplan_excel/" . $order_id . ".xlsx");
}*/

$keyplanCart = false;
$cilinderCount = 0;
$doorProducts = array();
$keyProducts = array();
$cilinderProductId = 0;
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
							$doorType = $meta["value"];
						}
						elseif($meta["name"] == "Extra knop korte kant") {
							$knopShort = $meta["value"];
						}
						elseif($meta["name"] == "Extra knop lange kant") {
							$knopLong = $meta["value"];
						}
						elseif($meta["name"] == "Door name")
						{
							$doorName = $meta["value"];
						}
						elseif($meta["name"] == "Sleutel type") {
							$keyType = $meta["value"];
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
				}
				$cilinderProductId = $doorProducts[$doorName]->id;
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

if($keyplanCart)
{
	require_once( get_template_directory() . '/includes/phpexcel/PHPExcel.php' );
	require_once( get_template_directory() . '/includes/phpexcel/PHPExcel/IOFactory.php' );

	// Create new PHPExcel object
	$objPHPExcel = PHPExcel_IOFactory::load( $_SERVER["DOCUMENT_ROOT"] . "/keyplan_excel/blank.xlsx" );

	// Add some data
	$objPHPExcel->setActiveSheetIndex( 0 );

	$sheet = $objPHPExcel->getActiveSheet();

	$sheet->setCellValue( "I9", current_time("d.m.Y") );

	$cilinderIndex = 0;
	$cilinderStartRow = 15;
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
		$sheet->setCellValue("F" . $curCilinderRow, $size);
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

	$sheet->setCellValue( "I8", $brand );

	$objWriter = PHPExcel_IOFactory::createWriter( $objPHPExcel, 'Excel2007' );
	//$objWriter->save($_SERVER["DOCUMENT_ROOT"] . "/keyplan_excel_cart/" . current_time("Y-m-d H-i") . " " . uniqid() . ".xlsx");

	//header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
	//header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
	header('Cache-Control: max-age=0');
	//header ( "Pragma: no-cache" );
	header ( "Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" );
	header ( "Content-Disposition: attachment; filename=keyplan.xlsx" );
	$objWriter->save('php://output');
	exit();
}
