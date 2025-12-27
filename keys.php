<?php /* Template Name: Keys */ ?>

<?php get_header();?>

<?php
$excl_btw = isset($_COOKIE["excl_btw"]) && $_COOKIE["excl_btw"] ? true : false;

//get theme options
$options = get_option( 'theme_settings' ); ?>
<div class="main-top-slider main-top-products">
    <div class="container-fluid item" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/slide.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-6 col-md-6 col-sm-12 text-center">
                    <div class="slider-text">
                        <div class="page-head page-head-small"><?php the_field("banner_title") ?></div>
                        <div class="lead">Eenvoudig een M&C sleutel nabestellen</div>
                        <div class="special-offer"><span>Al vanaf € <?php echo get_banner_price(); ?></span></div>
                        <a href="#" class="view-btn view-btn-shadow keys-select">Direct bestellen</a>
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

<div class="container-fluid bg-gray">
    <div class="container content-row">
        <div class="row no-gutters">
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
                <a href="#" class="view-btn view-btn-shadow keys-select">Sleutels kiezen</a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid goods-options">
    <div class="container">
        <div class="row">
            <div class="col-md-12 goods-options-title"><strong>M&C</strong> Deurcilinders voldoen aan de strengste eisen</div>
            <div class="col-md-12 goods-options-text">M&C cilinderslot is beveiligd tegen boren, openpikken, kerntrekken, de slagmethode en de impressietechniek.</div>
        </div>

        <div class="row goods-options-list clearfix">
            <div class="col-md-7ths goods-options-list-item text-center">
                <div class="img-wrapper">
                    <img src="<?php bloginfo('template_directory'); ?>/img/options/pick-resistant-white.png" alt="lockpick beveiliging" title="" />
                </div>
                <div class="option-name">Beveiligd tegen openpikken</div>
            </div>
            <div class="col-md-7ths goods-options-list-item">
                <div class="img-wrapper">
                    <img src="<?php bloginfo('template_directory'); ?>/img/options/anti-snap-white.png" alt="Breek beveiliging" title="" />
                </div>
                <div class="option-name">Breek - beveiliging</div>
            </div>
            <div class="col-md-7ths goods-options-list-item">
                <div class="img-wrapper">
                    <img src="<?php bloginfo('template_directory'); ?>/img/options/anti-bump-white.png" alt="Anti-klop" title="" />
                </div>
                <div class="option-name">Klop - beveiliging</div>
            </div>
            <div class="col-md-7ths goods-options-list-item">
                <div class="img-wrapper">
                    <img src="<?php bloginfo('template_directory'); ?>/img/options/anti-pull-white.png" alt="trekbeveiliging" title="" />
                </div>
                <div class="option-name">Kerntrek- beveiliging</div>
            </div>
            <div class="col-md-7ths goods-options-list-item">
                <div class="img-wrapper">
                    <img src="<?php bloginfo('template_directory'); ?>/img/options/drill-resistant-white.png" alt="boorbeveiliging" title="" />
                </div>
                <div class="option-name">Beveiligd tegen boren</div>
            </div>
            <div class="col-md-7ths goods-options-list-item">
                <div class="img-wrapper">
                    <img src="<?php bloginfo('template_directory'); ?>/img/options/master-key-system-white.png" alt="sluitplan" title="" />
                </div>
                <div class="option-name">Geschikt voor alle sluitplannen</div>
            </div>
            <div class="col-md-7ths goods-options-list-item">
                <div class="img-wrapper">
                    <img src="<?php bloginfo('template_directory'); ?>/img/options/warranty-white.png" alt="" title="" />
                </div>
                <div class="option-name">5 jaar garantie</div>
            </div>
        </div>
        <a href="/product-page/#bestellen" class="view-btn-inverse">BESTEL NU</a>
    </div>
</div>

<?php $keyColor = get_field("key_color"); ?>
<div class="container-fluid config-block block-align-center">
    <div class="container">
        <div class="row">
            <div id="select-keys" class="col-md-12 block-padding">
                <div class="config-name">Kies het aantal extra sleutels</div>
                <span class="lead"></span>
            </div>
            <div class="col-md-12 cilinder-step-one cilinder-count clearfix">
                <div class="row cilinder-count-item-row">
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item">
                            <div class="cilinder-count-title"><span class="num">1</span></div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?><?php if($keyColor == "purple"){echo "/img/sleutels-num/sleutel-1.jpg";}elseif($keyColor == "blue"){echo "/img/blue-sleutels/mc-color1.jpg";}else{echo "/img/sleutels/sleutel-1.png";};?>);"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item">
                            <div class="cilinder-count-title"><span class="num">2</span></div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?><?php if($keyColor == "purple"){echo "/img/sleutels-num/sleutel-2.jpg";}elseif($keyColor == "blue"){echo "/img/blue-sleutels/mc-color2.jpg";}else{echo "/img/sleutels/sleutel-2.png";};?>);"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item">
                            <div class="cilinder-count-title"><span class="num">3</span></div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?><?php if($keyColor == "purple"){echo "/img/sleutels-num/sleutel-3.jpg";}elseif($keyColor == "blue"){echo "/img/blue-sleutels/mc-color3.jpg";}else{echo "/img/sleutels/sleutel-3.png";};?>);"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item">
                            <div class="cilinder-count-title"><span class="num">4</span></div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?><?php if($keyColor == "purple"){echo "/img/sleutels-num/sleutel-4.jpg";}elseif($keyColor == "blue"){echo "/img/blue-sleutels/mc-color4.jpg";}else{echo "/img/sleutels/sleutel-4.png";};?>);"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item">
                            <div class="cilinder-count-title"><span class="num">5</span></div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?><?php if($keyColor == "purple"){echo "/img/sleutels-num/sleutel-5.jpg";}elseif($keyColor == "blue"){echo "/img/blue-sleutels/mc-color5.jpg";}else{echo "/img/sleutels/sleutel-5.png";};?>);"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item">
                            <div class="cilinder-count-title"><span class="num">6</span></div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?><?php if($keyColor == "purple"){echo "/img/sleutels-num/sleutel-6.jpg";}elseif($keyColor == "blue"){echo "/img/blue-sleutels/mc-color6.jpg";}else{echo "/img/sleutels/sleutel-6.png";};?>);"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item">
                            <div class="cilinder-count-title"><span class="num">7</span></div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?><?php if($keyColor == "purple"){echo "/img/sleutels-num/sleutel-7.jpg";}elseif($keyColor == "blue"){echo "/img/blue-sleutels/mc-color7.jpg";}else{echo "/img/sleutels/sleutel-7.png";};?>);"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item">
                            <div class="cilinder-count-title"><span class="num">8</span></div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?><?php if($keyColor == "purple"){echo "/img/sleutels-num/sleutel-8.jpg";}elseif($keyColor == "blue"){echo "/img/blue-sleutels/mc-color8.jpg";}else{echo "/img/sleutels/sleutel-8.png";};?>);"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 btn-container">
                <a id="more-cilinders" href="javascript:;" class="view-btn view-btn-inverse"><span>Meer dan 8 sleutels extra?</span></a>
                <input id="cilinders-num" type="text" value="1" style="display: none;" />
                <input id="sleutels-num" type="hidden" value="0" />
            </div>
            <div class="col-md-12 btn-container">
                <a href="#" class="offers-select view-btn view-btn-shadow">DOORGAAN</a>
            </div>
        </div>
    </div>
</div>
<div class="cilinder-config-block" style="display:none;">
    <div class="cilinder-config-options clearfix">
        <?php /* Don't delete this block! */ ?>
        <!-- Extra key options -->
        <div class="cilinder-params clearfix"></div>
    </div>
</div>

<div class="container-fluid offers-block block-align-center">
    <div class="container">
        <div id="select-offers" class="block-padding">
            <div class="page-head">Je hebt je bestelling bijna afgerond</div>
            <div class="lead">Kies vanuit welke serie je de cilinders geleverd wil hebben.</div>
        </div>
        <div class="row no-gutters">
            <div class="col-xs-12">
                <div class="offer-item">
                    <div class="offer-item-inner">
                        <div id="po-<?php the_field("key") ?>" class="offer-prices" style="display: none;">
                            <?
                            $pId = get_field("key");
                            $product = wc_get_product($pId);
                            $productImage = $product->get_image($size = 'shop_thumbnail');
                            $pKeyPrice = $product->get_regular_price();
                            $pVar = get_product_addons($pId);
                            $userImage = $pVar[0];
                            $pKeyTypes = $pVar[1];
                            $mainProduct = $product;
                            ?>
                            <div class="product-price"><?=get_product_addon_price_for_display_custom($pKeyPrice)?></div>
                            <div class="key-price">0</div>
                        </div>
                        <h2><?php the_field("brand") ?></h2>
                        <div class="img-wrapper"><?php echo $productImage; ?></div>
                        <div class="special-offer-wrapper">
                            <span class="special-offer">
                                <span>€</span><span id="price-<?php the_field("key") ?>"><?=sprintf("%01.2f", get_product_addon_price_for_display_custom($pKeyPrice))?></span>
                            </span>
                            <div class="btw"><?php if($excl_btw){ ?>excl.<?php } else { ?>incl.<?php } ?> BTW</div>
                        </div>
                        <div class="offer-info">
                            <span class="cilinder-num">1</span> sleutels
                            <?php /*if($_SERVER["REQUEST_URI"] == "/menc-matrix-sleutel/" && $pKeyTypes) { ?>
                                <span data-fancybox data-src="#key-type-block" class="choose-key-type">Kies hier color of metalen sleutels</span>
                                <input class="key-type" type="hidden" name="addon-<?php echo sanitize_title($pKeyTypes["field-name"]); ?>[]" value="" />
                                <div style="display:none;" id="key-type-block" class="main popup-container">
                                    <div class="block-align-center">
                                        <div class="config-name">Kies hier of u gekleurde sleutels of metalen sleutels bij uw bestelling wilt ontvangen</div>
                                        <span class="lead">Selecteer uw voorkeur en druk op bevestigen</span>
                                        <div class="options-list cilinder-count clearfix">
                                            <?php foreach($pKeyTypes["options"] as $ind=>$option){ ?>
                                                <div class="cilinder-count-item<?=($ind==0?" active":"")?>" onclick="javascript:;">
                                                    <div class="cilinder-count-title" data-value="<?=sanitize_title($option["label"])?>"><?=$option["label"]?></div>
                                                    <div class="cilinder-count-img" style="background-image: url(<?=wp_get_attachment_image_src($option["image"], null)[0]?>);"></div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <a href="javascript:;" class="key-type-select view-btn view-btn-inverse"><span>Bevestigen</span></a>
                                    </div>
                                </div>
                            <?php }*/ ?>
                        </div>

                        <div itemtype="https://schema.org/Product" itemscope>
                            <meta itemprop="name" content="<?php echo $mainProduct->get_name(); ?>" />
                            <?php if($mainProduct->get_image_id()) { ?>
                                <link itemprop="image" href="<?php echo wp_get_attachment_image_src( $mainProduct->get_image_id(), 'full' )[0]; ?>" />
                            <?php } ?>
                            <div itemprop="offers" itemtype="https://schema.org/Offer" itemscope>
                                <link itemprop="url" href="<?php echo get_permalink(); ?>" />
                                <meta itemprop="availability" content="https://schema.org/InStock" />
                                <meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
                                <meta itemprop="price" content="<?=sprintf("%01.2f", get_product_addon_price_for_display_custom($pKeyPrice))?>" />
                            </div>
                            <?php if(get_field("brand")) { ?>
                                <div itemprop="brand" itemtype="https://schema.org/Brand" itemscope>
                                    <meta itemprop="name" content="<?php the_field("brand"); ?>" />
                                </div>
                            <?php } ?>
                        </div>

                        <div class="sep"></div>
                        <div class="forms-list">
                            <form action="" method="post" enctype="multipart/form-data">
                                <input id="user-image" type="file" name="addon-<?php echo sanitize_title($userImage["field-name"]); ?>-<?php echo sanitize_title( $userImage['options'][0]['label'] ); ?>" style="display:none;" />
                                <input type="hidden" name="quantity" value="1" />
                                <input type="hidden" name="add-to-cart" value="<?=$pId?>">
                            </form>
                        </div>
                        <div class="upload-text">Upload hier een kopie van uw pas.</div>
                        <button class="view-btn view-btn-shadow upload-image">Pas uploaden</button>
                        <button class="make-order view-btn view-btn-inverse offer-btn" data-id="<?=$pId?>" data-key-id="<?php the_field("key") ?>">Nu bestellen</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="divider-blue-line"></div>
            </div>
            <div class="col-md-12">
                <?php the_content();?>
            </div>
        </div>
    </div>
</div>

<div style="display: none">
    <div id="options-window" class="main">
        <div class="block-align-center">
            <div class="config-name">Hoe bepaal ik de maatvoering?</div>
            <span class="lead">In de afbeelding hier onder tref je hoe de maatvoering werkt met een aantal voorbeeldweergaves van maten.</span>
            <img src="<?php bloginfo('template_directory'); ?>/img/params.png" alt="" title="" />
            <a href="javascript:;" class="popup-close view-btn view-btn-inverse"><span>Terug naar bestellen</span></a>
        </div>
    </div>
</div>

<?php get_footer(); ?>
