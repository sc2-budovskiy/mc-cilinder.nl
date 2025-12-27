<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
?>
<?php
$addonsPrice = 0;
$var = get_product_addons(get_the_ID());
if(!empty($var))
{
    $defaultOptions = get_field("default_options", get_the_ID());
    foreach($var as $k => $addon){
        $dVal = $defaultOptions ? $defaultOptions[substr($addon["field-name"],strlen((string)get_the_ID()."-"),-2)] : "";
        if($dVal && $dVal != "default") {
            foreach($addon["options"] as $option) {
                if(trim($option["label"]) == trim($dVal)) {
                    $addonsPrice += floatval($option["price"]);
                    break;
                }
            }
        } else {
            $addonsPrice += floatval($addon["options"][0]["price"]);
        }
    }
}
$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' );
$link = get_permalink();
if(get_field("link", get_the_ID())) {
    $link = get_field("link", get_the_ID());
}
$productCnt = get_field("product_number", get_the_ID()) ? intval(get_field("product_number", get_the_ID())) : 1;
?>
<li <?php wc_product_class( '', $product ); ?>>
    <a class="pi-obj-link" href="<?php echo $link; ?>">
	<span class="pi-img"<?php if($image && $image[0]) { ?> style="background-image:url(<?php echo $image[0]; ?>)"<?php } ?>>
		<span class="pi-label">Op Voorraad</span>
	</span>
        <span class="pi-info">
		<span class="pi-name"><?php the_title(); ?></span>
		<span class="pi-row icon-delivery">Morgen in huis</span>
		<span class="pi-row icon-geo">Vandaag ophalen in winkel </span>
		<span class="pi-bottom">
			<span>
				<span class="price-wrapper">
					<?php if($product->is_on_sale()){ ?>
                        <span class="old-price"><?php echo wc_price(wc_get_price_to_display_custom($product, array('price' => ($product->get_regular_price() + $addonsPrice))) * $productCnt); ?></span>
                    <?php } ?>
					<span class="price"><?php echo wc_price(wc_get_price_to_display_custom($product, array('price' => ($product->get_price() + $addonsPrice) * $productCnt))); ?></span>
				</span>
				<button class="view-btn view-btn-shadow"><i class="ib icon-cart"></i>Samenstellen</button>
			</span>
		</span>
	</span>
    </a>
</li>
