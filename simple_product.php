<?php /* Template Name: Simple Product */ ?>

<?php get_header();?>

<?php
$excl_btw = isset($_COOKIE["excl_btw"]) && $_COOKIE["excl_btw"] ? true : false;

//get theme options
$options = get_option( 'theme_settings' ); ?>

<div class="container-fluid breadcrumb-block">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo home_url(); ?>">Home</a></li>
            <li class="active"><?php the_field("banner_title") ?></li>
        </ol>
    </div>
</div>

<?php
$pId = get_field("product");
$pVar = array();

// Initialize variables for PHP 8.3 compatibility
$product = null;
$productImage = '';
$basePrice = 0;
$productName = '';
$price = 0;
$showUserImage = false;
$userImage = null;
$mainProduct = null;

if($pId) {
    $product      = wc_get_product( $pId );
    $productImage = $product->get_image( $size = 'shop_thumbnail' );
    $basePrice    = $product->get_regular_price();
    $pVar         = get_product_addons( $pId );
    $productName = $product->get_name();
    $price = $basePrice;
    if(!empty($pVar)) {
        foreach($pVar as $ind => $item) {
            if(!empty($item["options"]) && isset($item["options"][0]["price"]) && $item["options"][0]["price"]) {
                $price += floatval($item["options"][0]["price"]);
            }
        }
    }
    $showUserImage = false;
    $showUserImageField = get_field("show_user_image_button");
    if($showUserImageField && $showUserImageField[0]) {
        $showUserImage = $showUserImageField[0];
    }
    $userImage = null;
    if($showUserImage && !empty($pVar)) {
        foreach($pVar as $ind => $item) {
            if($item["type"] == "file_upload") {
                $userImage = $item;
                break;
            }
        }
    }
    $mainProduct = $product;
}
?>

<div class="container-fluid">
    <div class="container content-row">
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <?php $gallery = get_field('gallery'); ?>
                <div class="col-xs-6">
                    <div class="small-product-item">
                        <a class="small-product-img" data-lightbox="image-1" href="<?php echo $gallery[0]["url"]; ?>">
                            <img src="<?php echo $gallery[0]["url"]; ?>" alt="" title="" />
                        </a>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="small-product-item">
                        <a class="small-product-img" data-lightbox="image-2" href="<?php echo $gallery[1]["url"]; ?>">
                            <img src="<?php echo $gallery[1]["url"]; ?>" alt="" title="" />
                        </a>
                    </div>
                </div>
                <div class="col-xs-6 hidden-xs">
                    <div class="small-product-item">
                        <a class="small-product-img" data-lightbox="image-3" href="<?php echo $gallery[2]["url"]; ?>">
                            <img src="<?php echo $gallery[2]["url"]; ?>" alt="" title="" />
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12 four-square">
                    <div class="col-xs-6">
                        <div class="small-product-item">
                            <a class="small-product-img" data-lightbox="image-4" href="<?php echo $gallery[3]["url"]; ?>">
                                <img src="<?php echo $gallery[3]["url"]; ?>" alt="" title="" />
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="small-product-item">
                            <a class="small-product-img" data-lightbox="image-5" href="<?php echo $gallery[4]["url"]; ?>">
                                <img src="<?php echo $gallery[4]["url"]; ?>" alt="" title="" />
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="small-product-item">
                            <a class="small-product-img" data-lightbox="image-6" href="<?php echo $gallery[5]["url"]; ?>">
                                <img src="<?php echo $gallery[5]["url"]; ?>" alt="" title="" />
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="small-product-item">
                            <a class="small-product-img" data-lightbox="image-7" href="<?php echo $gallery[6]["url"]; ?>">
                                <img src="<?php echo $gallery[6]["url"]; ?>" alt="" title="" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="products-block-text col-md-6 col-sm-12 col-xs-12">
                <?php the_field("product_description"); ?>
                <div class="special-offer-wrapper text-center">
                <span class="special-offer">
                    <span>€</span><span class="special-offer-price"><?= sprintf("%01.2f", get_product_addon_price_for_display_custom($price)) ?></span>
                </span><div class="btw"><?php if($excl_btw){ ?>excl.<?php } else { ?>incl.<?php } ?> BTW</div>
                </div>
                <div class="options-wrapper" data-price="<?php echo sprintf("%01.2f", get_product_addon_price_for_display_custom($basePrice)); ?>">
                    <?php
                    if(!empty($pVar)) {
                        foreach($pVar as $ind => $item) {
                            if(!empty($item["options"]) && isset($item["options"][0]["label"]) && $item["options"][0]["label"] && $ind < count($pVar) - 2) {
                                ?>
                                <div class="ow-item">
                                    <?php
                                    foreach ( $item["options"] as $oInd => $opt ) {
                                        ?>
                                        <div class="options-item <?= ($oInd == 0) ? 'active' : '' ;  ?>" data-for="addon-<?php echo sanitize_title($item["field-name"]) . "-" . $oInd; ?>" data-price="<?php echo sprintf("%01.2f", get_product_addon_price_for_display_custom( $opt["price"] )); ?>">
                                            <?php $optImg = wp_get_attachment_image_src($opt["image"], null); ?>
                                            <img src="<?= $optImg ? $optImg[0] : '' ?>">
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
                <?php if($userImage) { ?>
                    <div class="sp-ui-block">
                        <div class="upload-text">Upload hier een kopie van uw pas.</div>
                        <button class="view-btn view-btn-inverse view-btn-shadow upload-image">Pas uploaden</button><br/>
                    </div>
                <?php } ?>
                <span id="offers-select-simple" class="view-btn view-btn-shadow">BESTEL NU</span>
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

<?php if ( !empty( get_the_content() ) ){ ?>
    <div class="container-fluid simple-products-content-section bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php the_content();?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<input id="cilinders-num" type="hidden" value="1" />
<input id="sleutels-num" type="hidden" value="0" />

<div class="cilinder-config-block" style="display:none;">
    <div class="cilinder-config-options clearfix">
        <?php /* Don't delete this block! */ ?>
        <!-- Extra key options -->
        <div class="cilinder-params clearfix"></div>
    </div>
</div>

<div class="container-fluid">
    <div class="kiyoh-reviews">
        <div class="container">
            <?php echo do_shortcode("[kiyoh-klantenvertellen]"); ?>
        </div>
    </div>
</div>

<div class="container-fluid offers-block block-align-center hidden">
    <div class="container">
        <div id="select-offers" class="block-padding">
            <div class="page-head">Je hebt je bestelling bijna afgerond</div>
            <span class="lead"></span>
        </div>
        <div class="row no-gutters">
            <div class="col-xs-12">
                <div class="offer-item">
                    <div class="offer-item-inner">
                        <div id="po-<?php the_field("product") ?>" class="offer-prices" style="display: none;">

                            <div class="product-price"><?=get_product_addon_price_for_display_custom($basePrice)?></div>
                            <div class="key-price">0</div>
                        </div>
                        <h2><?php echo $productName; ?></h2>
                        <?php echo $productImage; ?>
                        <br/>
                        <span class="special-offer">
                            <span>€</span><span id="price-<?php the_field("product") ?>"><?=sprintf("%01.2f", get_product_addon_price_for_display_custom($price))?></span>
                        </span>
                        <div class="btw"><?php if($excl_btw){ ?>excl.<?php } else { ?>incl.<?php } ?> BTW</div>
                        <div class="short-sep"></div>
                        <div class="offer-info">
                            <span class="cilinder-num">1</span> item
                        </div>

                        <?php if($mainProduct): ?>
                        <div itemtype="https://schema.org/Product" itemscope>
                            <meta itemprop="name" content="<?php echo $mainProduct->get_name(); ?>" />
                            <?php if($mainProduct->get_image_id()) { ?>
                                <?php $img = wp_get_attachment_image_src( $mainProduct->get_image_id(), 'full' ); ?>
                                <link itemprop="image" href="<?php echo $img ? $img[0] : ''; ?>" />
                            <?php } ?>
                            <div itemprop="offers" itemtype="https://schema.org/Offer" itemscope>
                                <link itemprop="url" href="<?php echo get_permalink(); ?>" />
                                <meta itemprop="availability" content="https://schema.org/InStock" />
                                <meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
                                <meta itemprop="price" content="<?=sprintf("%01.2f", get_product_addon_price_for_display_custom($price))?>" />
                            </div>
                            <?php if(get_field("brand")) { ?>
                                <div itemprop="brand" itemtype="https://schema.org/Brand" itemscope>
                                    <meta itemprop="name" content="<?php the_field("brand"); ?>" />
                                </div>
                            <?php } ?>
                        </div>
                        <?php endif; ?>

                        <div class="sep"></div>
                        <?php
                        if(!empty($pVar)) {
                            foreach($pVar as $ind => $item) {
                                if(!empty($item["options"]) && isset($item["options"][0]["label"]) && $item["options"][0]["label"] && $ind < count($pVar) - 2) {
                                    ?>
                                    <div class="delivery-title"><?php echo $item["name"]; ?>:</div>
                                    <?php
                                    foreach ( $item["options"] as $oInd => $opt ) {
                                        ?>
                                        <div class="sp-option delivery-list-item">
                                            <label for="addon-<?php echo sanitize_title($item["field-name"]) . "-" . $oInd; ?>"><input id="addon-<?php echo sanitize_title($item["field-name"]) . "-" . $oInd; ?>" type="radio" name="addon-<?php echo sanitize_title($item["field-name"]); ?>" value="<?php echo sanitize_title($opt["label"]); ?>"<?php if($oInd == 0) { ?> checked="checked"<?php } ?> /><span
                                                        class="text"><?php echo $opt["label"]; ?> <span class="price"><?php if($opt["price"] > 0) { echo sprintf("+€%01.2f", get_product_addon_price_for_display_custom( $opt["price"] )); } ?></span></span></label>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                        }
                        ?>
                        <div class="forms-list">
                            <form action="" method="post" enctype="multipart/form-data">
                                <?php if($userImage) { ?><input id="user-image" type="file" name="addon-<?php echo sanitize_title($userImage["field-name"]); ?>-<?php echo sanitize_title( $userImage['options'][0]['label'] ); ?>" style="display:none;" /><?php } ?>
                                <input type="hidden" name="quantity" value="1" />
                                <input type="hidden" name="add-to-cart" value="<?=$pId?>">
                            </form>
                        </div>
                        <button class="view-btn view-btn-inverse offer-btn order-extra-product" data-id="<?=$pId?>">Nu bestellen</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="sep"></div>
        <div class="block-padding">
            <?php the_content();?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
