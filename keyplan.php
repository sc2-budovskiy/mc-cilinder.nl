<?php /* Template Name: Keyplan */ ?>

<?php get_header();?>

<div class="container-fluid breadcrumb-block">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo home_url(); ?>">Home</a></li>
            <li class="active">Sluitplan</li>
        </ol>
    </div>
</div>

<?php
$excl_btw = isset($_COOKIE["excl_btw"]) && $_COOKIE["excl_btw"] ? true : false;

//get theme options
$options = get_option( 'theme_settings' ); ?>
<div class="main-top-slider main-top-products">
    <div class="container-fluid item" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/slide.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-5 col-md-7 col-sm-12 text-center">
                    <div class="slider-text">
                        <div class="page-head page-head-small"><?php the_field("banner_title") ?></div>
                        <div class="lead">Dé manier om zelf uw thuis veiliger te maken.</div>
                        <div class="special-offer"><span>Al vanaf € <?php echo get_banner_price(); ?></span> <?php if($excl_btw){ ?>excl.<?php } else { ?>incl.<?php } ?> BTW verkrijgbaar</div>
                        <a href="#" class="view-btn view-btn-shadow cilinder-select">BESTEL NU</a>
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
                                <div class="text">
                                    <?php if(get_sub_field('title') == 'Snelle levertijd' || get_sub_field('text') == 'Voor 17:00 uur besteld is de volgende dag in huis*') { ?>
                                        Sluitplan binnen 10 a 15 werkdagen geleverd
                                    <?php } else { ?>
                                        <?php the_sub_field('text'); ?>
                                    <?php } ?>
                                </div>
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
                <?php the_field("product_description"); ?>

                <div class="text-center btn-wrapper">
                    <a class="view-btn-wht view-btn-shadow" href="<?php echo home_url(); ?>/MenC-sluitplan.xls">SLUITPLAN XLS</a>
                    <a href="#" class="view-btn view-btn-shadow cilinder-select">BESTEL NU</a>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="divider-blue-line"></div>
            </div>

            <div class="col-md-6 col-sm-12 col-xs-12">
                <?php $gallery = get_field('gallery'); ?>
                <div class="row">
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
            </div>
            <div class="products-block-text col-md-6 col-sm-12 col-xs-12">
                <?php the_field("product_description_right"); ?>
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

<div class="container-fluid articles-block articles-block-products">
    <div class="container">
        <div class="row">
            <?php
            $video = get_posts( array('numberposts' => 3, 'category' => 33) );
            $icon_iterator = 1;
            foreach($video as $post) { ?>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="icon-wrapper">
                        <img src="<?php bloginfo('template_directory'); ?>/img/article-icon<?=$icon_iterator?>.png" alt="article-icon1" title="" />
                    </div>
                    <div class="item">
                        <a class="article-name"><?=$post->post_title?></a>
                        <div class="article-content">
                            <?=$post->post_content?>
                        </div>
                    </div>
                </div>
                <?php $icon_iterator++; ?>
                <?php
            }
            ?>
        </div>
        <div class="view-catalog">
            <a href="/product-page/#bestellen" class="view-btn">CILINDERMAAT KIEZEN</a>
        </div>
    </div>
</div>

<div class="container-fluid config-title-block block-align-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-head"><strong>Stel</strong> je bestelling samen</div>
                <span class="lead">Kies de cilinders die je wil bestellen om je sloten te vervangen voor dé beveiligingsoplossing in sloten!</span>
                <span class="cilinder-select arrow-down"></span>
                <div class="divider-blue-line"></div>
            </div>
        </div>
    </div>
</div>
<?php
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
                    $outerSize = "";
                    $innerSize = "";

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
                        elseif($meta["name"] == "Maat buitenzijde") {
                            $outerSize = $meta["value"];
                        }
                        elseif($meta["name"] == "Maat binnenzijde") {
                            $innerSize = $meta["value"];
                        }
                    }

                    $doorProducts[$doorName] = new stdClass();
                    $doorProducts[$doorName]->doorName = $doorName;
                    $doorProducts[$doorName]->id = $_product->get_id();
                    $doorProducts[$doorName]->color = $color;
                    $doorProducts[$doorName]->size = $size;
                    $doorProducts[$doorName]->knopShort = $knopShort;
                    $doorProducts[$doorName]->knopLong = $knopLong;
                    $doorProducts[$doorName]->keyType = $keyType;
                    $doorProducts[$doorName]->doorType = $doorType;
                    $doorProducts[$doorName]->outerSize = $outerSize;
                    $doorProducts[$doorName]->innerSize = $innerSize;
                }
                $cilinderProductId = $doorProducts[$doorName]->id;
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
?>
<div class="container-fluid config-block block-align-center">
    <div class="container">
        <div class="row">
            <div id="select-cilinder" class="col-md-12 block-padding">
                <div class="config-name">Selecteer het aantal cilinders dat u nodig heeft voor uw sluitplan</div>
                <span class="lead">Kies hier het aantal cilinders dat je nodig hebt om je sloten te vervangen.</span>
            </div>
            <div class="col-md-12 cilinder-step-one cilinder-count clearfix">
                <div class="row cilinder-count-item-row">
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item<?php if(!$cilinderCount || $cilinderCount == 1){ ?> active<?php } ?>">
                            <div class="cilinder-count-title"><span class="num">1</span></div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-1.jpg);"></div>
                            <div class="border-bottom"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item<?php if($cilinderCount == 2){ ?> active<?php } ?>">
                            <div class="cilinder-count-title"><span class="num">2</span></div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-2.jpg);"></div>
                            <div class="border-bottom"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item<?php if($cilinderCount == 3){ ?> active<?php } ?>">
                            <div class="cilinder-count-title"><span class="num">3</span></div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-3.jpg);"></div>
                            <div class="border-bottom"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item<?php if($cilinderCount == 4){ ?> active<?php } ?>">
                            <div class="cilinder-count-title"><span class="num">4</span></div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-4.jpg);"></div>
                            <div class="border-bottom"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item<?php if($cilinderCount == 5){ ?> active<?php } ?>">
                            <div class="cilinder-count-title"><span class="num">5</span></div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-5.jpg);"></div>
                            <div class="border-bottom"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item<?php if($cilinderCount == 6){ ?> active<?php } ?>">
                            <div class="cilinder-count-title"><span class="num">6</span></div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-6.jpg);"></div>
                            <div class="border-bottom"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item<?php if($cilinderCount == 7){ ?> active<?php } ?>">
                            <div class="cilinder-count-title"><span class="num">7</span></div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-7.jpg);"></div>
                            <div class="border-bottom"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item<?php if($cilinderCount == 8){ ?> active<?php } ?>">
                            <div class="cilinder-count-title"><span class="num">8</span></div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-8.jpg);"></div>
                            <div class="border-bottom"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 btn-container">
                <a id="more-cilinders" href="javascript:;" class="view-btn view-btn-inverse"><span>Meer dan 8 nodig? Vul hier je aantal in...</span></a>
                <input id="cilinders-num" type="text" value="<?php echo $cilinderCount ? $cilinderCount : 1; ?>"<?php if(intval($cilinderCount) <= 8){ ?> style="display: none;"<?php } ?> />
            </div>
            <div class="col-md-12 btn-container">
                <a href="#" class="params-select view-btn view-btn-shadow">DOORGAAN</a>
            </div>
            <div class="col-md-12">
                <div class="divider-blue-line"></div>
            </div>
            <div id="select-params" class="col-md-12 block-padding">
                <div class="config-name">Kies de optie per cilinder.</div>
                <span class="lead">In het grijze veld boven de afbeelding van de cilinder kunt u de cilinders een naam geven.<br/>heeft u binnendeuren selecteer u bij die cilinder de optie “binnendeur”<span class=""></span></span>
            </div>
            <div class="col-md-12 cilinder-config-block">
                <?php
                $pId = 1577;
                $pVar = get_product_addons($pId);
                $pDoorname = $pVar[4];
                $pFrontdoor = $pVar[5];

                $outerSide = @$pVar[8];
                $innerSide = @$pVar[9];

                $id = 251;
                $var = get_product_addons($id);
                $sizes = $var[3];
                $materials = $var[2];
                $extra1 = $var[0];
                $extra2 = $var[1];
                $keyTypes = $var[5];
                $product = wc_get_product($id);
                ?>
                <?php if(!$cilinderCount) { ?>
                    <div class="row cilinder-config-options clearfix">
                        <div class="col-md-8ths">
                            <div class="cilinder-count-item active">
                                <div class="opt-name">&nbsp;</div>
                                <div class="cilinder-count-title"><div class="cilinder-name" contenteditable="true"><span class="num">1</span></div></div>
                                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-1.jpg);" data-folder="<?php bloginfo('template_directory'); ?>/img/cilinder-types/"></div>
                                <div class="border-bottom"></div>
                            </div>
                        </div>
                        <div class="col-md-min-8ths cilinder-params clearfix">
                            <div class="row">
                                <!--Оригинальный скрытый общий список размеров-->
                                <div class="param-item param-1 hidden">
                                    <?php
                                    $outsideSizes = array();
                                    $insideSizes = array();
                                    ?>
                                    <select>
                                        <option value="<?=$sizes["options"][0]["label"]?>" data-value="<?=sanitize_title($sizes["options"][0]["label"]). '-1';?>">Kies je maat</option>
                                        <?php
                                        foreach ($sizes["options"] as $ind=>$option)
                                        {
                                            /*Сохраняем уникальные размеры в массив для наружных размеров и внутренних*/
                                            $size = strtok($option["label"],' ');
                                            $outsideSize = strtok($size,'/');
                                            $insideSize = substr($size, strpos($size, "/") + 1);
                                            if (!in_array($outsideSize, $outsideSizes)) {
                                                array_push($outsideSizes, $outsideSize);
                                            }
                                            if (!in_array($insideSize, $insideSizes)) {
                                                array_push($insideSizes, $insideSize);
                                            }
                                            ?>
                                            <option value="<?=$option["label"]?>" data-value="<?=sanitize_title($option["label"]). '-'. ($ind + 1);?>"><?=$option["label"]?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <div class="check-param" data-fancybox data-src="#options-window">Hoe maten bepalen?</div>
                                    <div class="param-value" data-value="<?=sanitize_title($sizes["options"][0]["label"]). '-1';?>" data-field="<?=substr($sizes["field-name"], strpos($sizes["field-name"],"-"))?>"><?=$sizes["options"][0]["label"]?></div>
                                </div>
                                <!--Список внушних размеров-->
                                <div class="col-md-3 col-xs-6">
                                    <div class="param-item param-11">
                                        <div class="opt-name">Buitenzijde</div>
                                        <select class="outside">
                                            <!--<option value="<?=trim(str_replace("mm","",$outerSide["options"][0]["label"]))?>" data-value="<?=sanitize_title($outerSide["options"][0]["label"]). '-1';?>">Maat buitenzijde</option>-->
                                            <?php
                                            foreach ($outerSide["options"] as $ind=>$option)
                                            {
                                                ?>
                                                <option value="<?=trim(str_replace("mm","",$option["label"]))?>" data-value="<?=sanitize_title($option["label"]). '-'. ($ind + 1);?>"><?=$option["label"]?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="check-param" data-fancybox data-src="#options-window">Hoe maten bepalen?</div>
                                        <div class="param-value-not-matter hidden">Buitenzijde</div>
                                        <div class="param-value hidden" data-value="<?=sanitize_title($outerSide["options"][0]["label"]). '-1';?>" data-field="<?=substr($outerSide["field-name"], strpos($outerSide["field-name"],"-"))?>"></div>
                                    </div>
                                </div>
                                <!--Список внутренних размеров-->
                                <div class="col-md-3 col-xs-6">
                                    <div class="param-item param-11">
                                        <div class="opt-name">Binnenzijde</div>
                                        <select class="inside">
                                            <!--<option value="<?=trim(str_replace("mm","",$innerSide["options"][0]["label"]))?>" data-value="<?=sanitize_title($innerSide["options"][0]["label"]). '-1';?>">Maat binnenzijde</option>-->
                                            <?php
                                            foreach ($innerSide["options"] as $ind=>$option)
                                            {
                                                ?>
                                                <option value="<?=trim(str_replace("mm","",$option["label"]))?>" data-value="<?=sanitize_title($option["label"]). '-'. ($ind + 1);?>"><?=$option["label"]?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="check-param" data-fancybox data-src="#options-window">Hoe maten bepalen?</div>
                                        <div class="param-value-not-matter hidden">Binnenzijde</div>
                                        <div class="param-value hidden" data-value="<?=sanitize_title($innerSide["options"][0]["label"]). '-1';?>" data-field="<?=substr($innerSide["field-name"], strpos($innerSide["field-name"],"-"))?>"></div>
                                    </div>
                                </div>

                                <div class="param-item param-2 hidden">
                                    <div class="change-param-value" data-fancybox data-src="#extra-select-1">Kies een extra knop korte kant</div>
                                    <div class="check-param" data-fancybox data-src="#knop-pushknop-info">Hoe werkt een knop?</div>
                                    <div class="param-value" data-value="<?=sanitize_title($extra1["options"][0]["label"])?>" data-field="<?=substr($extra1["field-name"], strpos($extra1["field-name"],"-"))?>"><?=$extra1["options"][0]["label"]?></div>
                                </div>
                                <div class="col-md-3 col-xs-6">
                                    <div class="param-item param-3">
                                        <div class="opt-name">Extra</div>
                                        <div class="change-param-value" data-fancybox data-src="#extra2-select-1"><?=$extra2["options"][0]["label"]?></div>
                                        <div class="check-param" data-fancybox data-src="#knop-pushknop-info">Hoe werkt een knop?</div>
                                        <div class="param-value hidden" data-value="<?=sanitize_title($extra2["options"][0]["label"])?>" data-field="<?=substr($extra2["field-name"], strpos($extra2["field-name"],"-"))?>"><?=$extra2["options"][0]["label"]?></div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-6">
                                    <div class="param-item param-4">
                                        <div class="opt-name">Kleur</div>
                                        <div class="change-param-value" data-fancybox data-src="#materials-select-1"><?=$materials["options"][0]["label"]?></div>
                                        <div class="param-value hidden" data-value="<?=sanitize_title($materials["options"][0]["label"])?>" data-field="<?=substr($materials["field-name"], strpos($materials["field-name"],"-"))?>"><?=$materials["options"][0]["label"]?></div>
                                    </div>
                                </div>
                                <div class="param-item product-item-price"></div>
                                <div class="param-item param-5">
                                    <input id="dt-1" type="checkbox" value="<?=sanitize_title($pFrontdoor["options"][1]["label"])?>" data-uncheked-value="<?=sanitize_title($pFrontdoor["options"][0]["label"])?>" data-uncheked-label="<?=$pFrontdoor["options"][0]["label"]?>" /><label for="dt-1"><?=$pFrontdoor["options"][1]["label"]?></label>
                                    <div class="param-value hidden" data-value="<?=sanitize_title($pFrontdoor["options"][0]["label"])?>" data-field="<?=substr($pFrontdoor["field-name"], strpos($pFrontdoor["field-name"],"-"))?>"><?=$pFrontdoor["options"][0]["label"]?></div>
                                </div>
                                <div style="display:none;" id="materials-select-1" class="main materials-options popup-container">
                                    <div class="block-align-center">
                                        <div class="config-name">Kies de uitvoering</div>
                                        <span class="lead">Kies als uitvoering</span>
                                        <div class="options-list cilinder-count clearfix">
                                            <?php foreach($materials["options"] as $ind=>$option){ ?>
                                                <div class="cilinder-count-item<?=($ind==0?" active":"")?>" onclick="javascript:;">
                                                    <div class="cilinder-count-title" data-value="<?=sanitize_title($option["label"])?>"><?=$option["label"]?></div>
                                                    <div class="cilinder-count-img" style="background-image: url(<?=wp_get_attachment_image_src($option["image"], null)[0]?>);"></div>
                                                    <!--<div class="border-bottom"></div>-->
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <a href="javascript:;" class="material-select view-btn view-btn-inverse"><span>Bevestigen</span></a>
                                    </div>
                                </div>
                                <div style="display:none;" id="extra-select-1" class="main extra-options popup-container">
                                    <div class="block-align-center">
                                        <div class="config-name">Kies een extra knop voor de korte kant</div>
                                        <span class="lead">Kies als extra optie voor een knop of pushknop</span>
                                        <div class="options-list cilinder-count clearfix">
                                            <?php foreach($extra1["options"] as $ind=>$option){ ?>
                                                <div class="cilinder-count-item<?=($ind==0?" active":"")?>" onclick="javascript:;">
                                                    <div class="cilinder-count-title" data-value="<?=sanitize_title($option["label"])?>"><?=$option["label"]?></div>
                                                    <div class="cilinder-count-img" style="background-image: url(<?=wp_get_attachment_image_src($option["image"], null)[0]?>);"></div>
                                                    <!--<div class="border-bottom"></div>-->
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <a href="javascript:;" class="extra-select view-btn view-btn-inverse"><span>Bevestigen</span></a>
                                    </div>
                                </div>
                                <div style="display:none;" id="extra2-select-1" class="main extra2-options popup-container">
                                    <div class="block-align-center">
                                        <div class="config-name">Kies een extra knop</div>
                                        <span class="lead">Kies als extra optie voor een knop of pushknop</span>
                                        <div class="options-list cilinder-count clearfix">
                                            <?php foreach($extra2["options"] as $ind=>$option){ ?>
                                                <div class="cilinder-count-item<?=($ind==0?" active":"")?>" onclick="javascript:;">
                                                    <div class="cilinder-count-title" data-value="<?=sanitize_title($option["label"])?>"><?= str_replace(" lange zijde", "",$option["label"]); ?></div>
                                                    <div class="cilinder-count-img" style="background-image: url(<?=wp_get_attachment_image_src($option["image"], null)[0]?>);"></div>
                                                    <!--<div class="border-bottom"></div>-->
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <a href="javascript:;" class="extra2-select view-btn view-btn-inverse"><span>Bevestigen</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <?php
                    $cnt = 0;
                    foreach($doorProducts as $item){
                        ?>

                        <div class="row cilinder-config-options change-img clearfix">
                            <div class="col-md-8ths">
                                <div class="cilinder-count-item active">
                                    <div class="opt-name">&nbsp;</div>
                                    <div class="cilinder-count-title"><div class="cilinder-name" contenteditable="true"><span class="num"><?php echo $item->doorName ? $item->doorName : $cnt; ?></span></div></div>
                                    <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-1.jpg);" data-folder="<?php bloginfo('template_directory'); ?>/img/cilinder-types/"></div>
                                    <div class="border-bottom"></div>
                                </div>
                            </div>
                            <div class="col-md-min-8ths cilinder-params clearfix">
                                <div class="row">
                                    <div class="param-item param-1 hidden">
                                        <select>
                                            <?php
                                            $outsideSizes = array();
                                            $insideSizes = array();
                                            ?>
                                            <?php
                                            $valIndex = 1;
                                            foreach ($sizes["options"] as $ind=>$option) {
                                                if($option["label"] == $item->size)
                                                {
                                                    $valIndex = $ind + 1;
                                                    break;
                                                }
                                            }
                                            ?>
                                            <option value="<?=$item->size?>" data-value="<?=sanitize_title($item->size). '-' . $valIndex;?>">Maat (<?php echo $item->size; ?>)</option>
                                            <?php
                                            foreach ($sizes["options"] as $ind=>$option)
                                            {
                                                /*Сохраняем уникальные размеры в массив для наружных размеров и внутренних*/
                                                $size = strtok($option["label"],' ');
                                                $outsideSize = strtok($size,'/');
                                                $insideSize = substr($size, strpos($size, "/") + 1);
                                                if (!in_array($outsideSize, $outsideSizes)) {
                                                    array_push($outsideSizes, $outsideSize);
                                                }
                                                if (!in_array($insideSize, $insideSizes)) {
                                                    array_push($insideSizes, $insideSize);
                                                }
                                                ?>
                                                <option value="<?=$option["label"]?>" data-value="<?=sanitize_title($option["label"]). '-'. ($ind + 1);?>"><?=$option["label"]?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="check-param" data-fancybox data-src="#options-window">Hoe maten bepalen?</div>
                                        <div class="param-value" data-value="<?php if($item->size != "Binnendeur"){echo sanitize_title($item->size). '-' . $valIndex;}?>" data-field="<?=substr($sizes["field-name"], strpos($sizes["field-name"],"-"))?>"><?php if($item->size != "Binnendeur"){echo $item->size;} ?></div>
                                    </div>
                                    <!--Список внушних размеров-->
                                    <div class="col-md-3 col-xs-6">
                                        <div class="param-item param-11">
                                            <div class="opt-name">Buitenzijde</div>
                                            <select class="outside">
                                                <?php
                                                $valIndex = 1;
                                                foreach ($outerSide["options"] as $ind=>$option) {
                                                    if($option["label"] == $item->outerSize)
                                                    {
                                                        $valIndex = $ind + 1;
                                                        break;
                                                    }
                                                }
                                                ?>
                                                <option value="<?=trim(str_replace("mm","",$item->outerSize))?>" data-value="<?=sanitize_title($item->outerSize). '-' . $valIndex;?>"><?php echo $item->outerSize; ?></option>
                                                <?php
                                                foreach ($outerSide["options"] as $ind=>$option)
                                                {
                                                    ?>
                                                    <?php if($item->outerSize != $option["label"]) { ?><option value="<?=trim(str_replace("mm","",$option["label"]))?>" data-value="<?=sanitize_title($option["label"]). '-'. ($ind + 1);?>"><?=$option["label"]?></option><?php } ?>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <div class="check-param" data-fancybox data-src="#options-window">Hoe maten bepalen?</div>
                                            <div class="param-value-not-matter hidden">Buitenzijde</div>
                                            <div class="param-value hidden" data-value="<?=sanitize_title($item->outerSize). '-' . $valIndex;?>" data-field="<?=substr($outerSide["field-name"], strpos($outerSide["field-name"],"-"))?>"></div>
                                        </div>
                                    </div>
                                    <!--Список внутренних размеров-->
                                    <div class="col-md-3 col-xs-6">
                                        <div class="param-item param-11">
                                            <div class="opt-name">Binnenzijde</div>
                                            <select class="inside">
                                                <?php
                                                $valIndex = 1;
                                                foreach ($innerSide["options"] as $ind=>$option) {
                                                    if($option["label"] == $item->innerSize)
                                                    {
                                                        $valIndex = $ind + 1;
                                                        break;
                                                    }
                                                }
                                                ?>
                                                <option value="<?=trim(str_replace("mm","",$item->innerSize))?>" data-value="<?=sanitize_title($item->innerSize). '-' . $valIndex;?>"><?php echo $item->innerSize; ?></option>
                                                <?php
                                                foreach ($innerSide["options"] as $ind=>$option)
                                                {
                                                    ?>
                                                    <?php if($item->innerSize != $option["label"]) { ?><option value="<?=trim(str_replace("mm","",$option["label"]))?>" data-value="<?=sanitize_title($option["label"]). '-'. ($ind + 1);?>"><?=$option["label"]?></option><?php } ?>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <div class="check-param" data-fancybox data-src="#options-window">Hoe maten bepalen?</div>
                                            <div class="param-value-not-matter hidden">Binnenzijde</div>
                                            <div class="param-value hidden" data-value="<?=sanitize_title($item->innerSize). '-' . $valIndex;?>" data-field="<?=substr($innerSide["field-name"], strpos($innerSide["field-name"],"-"))?>"></div>
                                        </div>
                                    </div>

                                    <div class="param-item param-2 hidden">
                                        <div class="change-param-value" data-fancybox data-src="#extra-select-<?=($cnt+1)?>">Kies een extra knop korte kant</div>
                                        <div class="check-param" data-fancybox data-src="#knop-pushknop-info">Hoe werkt een knop?</div>
                                        <div class="param-value" data-value="<?=sanitize_title($item->knopShort)?>" data-field="<?=substr($extra1["field-name"], strpos($extra1["field-name"],"-"))?>"><?php echo $item->knopShort; ?></div>
                                    </div>
                                    <div class="col-md-3 col-xs-6">
                                        <div class="param-item param-3">
                                            <div class="opt-name">Extra</div>
                                            <div class="change-param-value" data-fancybox data-src="#extra2-select-<?=($cnt+1)?>"><?php echo $item->knopLong; ?></div>
                                            <div class="check-param" data-fancybox data-src="#knop-pushknop-info">Hoe werkt een knop?</div>
                                            <div class="param-value hidden" data-value="<?=sanitize_title($item->knopLong)?>" data-field="<?=substr($extra2["field-name"], strpos($extra2["field-name"],"-"))?>"><?php echo $item->knopLong; ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-xs-6">
                                        <div class="param-item param-4">
                                            <div class="opt-name">Kleur</div>
                                            <div class="change-param-value" data-fancybox data-src="#materials-select-<?=($cnt+1)?>"><?php echo $item->color; ?></div>
                                            <div class="param-value hidden" data-value="<?=sanitize_title($item->color)?>" data-field="<?=substr($materials["field-name"], strpos($materials["field-name"],"-"))?>"><?php echo $item->color; ?></div>
                                        </div>
                                    </div>
                                    <div class="param-item product-item-price"></div>
                                    <div class="param-item param-5">
                                        <input id="dt-<?=($cnt+1)?>" type="checkbox"<?php if($item->size == "Binnendeur"){?> checked="checked"<?php } ?> value="<?php echo sanitize_title($pFrontdoor["options"][1]["label"]); ?>" data-uncheked-value="<?php echo sanitize_title($pFrontdoor["options"][0]["label"]); ?>" data-uncheked-label="<?php echo $pFrontdoor["options"][0]["label"]; ?>" /><label for="dt-<?=($cnt+1)?>"><?=$pFrontdoor["options"][1]["label"]?></label>
                                        <div class="param-value hidden" data-value="<?php if($item->size == "Binnendeur"){ echo sanitize_title($pFrontdoor["options"][1]["label"]); }else{ echo sanitize_title($pFrontdoor["options"][0]["label"]); }?>" data-field="<?=substr($pFrontdoor["field-name"], strpos($pFrontdoor["field-name"],"-"))?>"><?php if($item->size == "Binnendeur"){ echo $pFrontdoor["options"][1]["label"]; }else{ echo $pFrontdoor["options"][0]["label"]; }?></div>
                                    </div>
                                    <div style="display:none;" id="materials-select-<?=($cnt+1)?>" class="main materials-options popup-container">
                                        <div class="block-align-center">
                                            <div class="config-name">Kies de uitvoering</div>
                                            <span class="lead">Kies als uitvoering</span>
                                            <div class="options-list cilinder-count clearfix">
                                                <?php foreach($materials["options"] as $ind=>$option){ ?>
                                                    <div class="cilinder-count-item<?=($item->color==$option["label"]?" active":"")?>" onclick="javascript:;">
                                                        <div class="cilinder-count-title" data-value="<?=sanitize_title($option["label"])?>"><?=$option["label"]?></div>
                                                        <div class="cilinder-count-img" style="background-image: url(<?=wp_get_attachment_image_src($option["image"], null)[0]?>);"></div>
                                                        <!--<div class="border-bottom"></div>-->
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <a href="javascript:;" class="material-select view-btn view-btn-inverse"><span>Bevestigen</span></a>
                                        </div>
                                    </div>
                                    <div style="display:none;" id="extra-select-<?=($cnt+1)?>" class="main extra-options popup-container">
                                        <div class="block-align-center">
                                            <div class="config-name">Kies een extra knop voor de korte kant</div>
                                            <span class="lead">Kies als extra optie voor een knop of pushknop</span>
                                            <div class="options-list cilinder-count clearfix">
                                                <?php foreach($extra1["options"] as $ind=>$option){ ?>
                                                    <div class="cilinder-count-item<?=($option["label"]==$item->knopShort?" active":"")?>" onclick="javascript:;">
                                                        <div class="cilinder-count-title" data-value="<?=sanitize_title($option["label"])?>"><?=$option["label"]?></div>
                                                        <div class="cilinder-count-img" style="background-image: url(<?=wp_get_attachment_image_src($option["image"], null)[0]?>);"></div>
                                                        <!--<div class="border-bottom"></div>-->
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <a href="javascript:;" class="extra-select view-btn view-btn-inverse"><span>Bevestigen</span></a>
                                        </div>
                                    </div>
                                    <div style="display:none;" id="extra2-select-<?=($cnt+1)?>" class="main extra2-options popup-container">
                                        <div class="block-align-center">
                                            <div class="config-name">Kies een extra knop</div>
                                            <span class="lead">Kies als extra optie voor een knop of pushknop</span>
                                            <div class="options-list cilinder-count clearfix">
                                                <?php foreach($extra2["options"] as $ind=>$option){ ?>
                                                    <div class="cilinder-count-item<?=($option["label"]==$item->knopLong?" active":"")?>" onclick="javascript:;">
                                                        <div class="cilinder-count-title" data-value="<?=sanitize_title($option["label"])?>"><?= str_replace(" lange zijde", "",$option["label"]); ?></div>
                                                        <div class="cilinder-count-img" style="background-image: url(<?=wp_get_attachment_image_src($option["image"], null)[0]?>);"></div>
                                                        <!--<div class="border-bottom"></div>-->
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <a href="javascript:;" class="extra2-select view-btn view-btn-inverse"><span>Bevestigen</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        $cnt++;
                    }
                    ?>
                <?php } ?>
            </div>
            <div class="col-md-12 btn-container">
                <a href="#" class="keys-select view-btn view-btn-shadow">DOORGAAN</a>
            </div>
            <div class="col-md-12">
                <div class="divider-blue-line"></div>
            </div>
            <div id="select-keys" class="col-md-12">
                <div class="config-name">Geef hier bij alle personen of afdelingen aan hoeveel sleutels u wilt hebben.</div>
                <span class="lead">u kunt bij elke persoon of afdeling de naam aanpassen.</span>
            </div>
            <div id="select-user-departments" class="col-md-12 cilinder-count clearfix">
                <?php if(!$keyProducts){ ?>
                    <div class="row cilinder-count-item-row">
                        <div class="col-md-8ths">
                            <div class="cilinder-count-item">
                                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true">Afdeling <span class="num">1</span></div></div>
                                <div class="user-keys-cnt"><span class="arrow-left"></span><input class="user-keys-val" type="text" min="0" max="99" value="1" /><span class="arrow-right"></span></div>
                                <div class="border-bottom"></div>
                            </div>
                        </div>
                        <div class="col-md-8ths">
                            <div class="cilinder-count-item">
                                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true">Afdeling <span class="num">2</span></div></div>
                                <div class="user-keys-cnt"><span class="arrow-left"></span><input class="user-keys-val" type="number" min="0" max="99" value="" /><span class="arrow-right"></span></div>
                                <div class="border-bottom"></div>
                            </div>
                        </div>
                        <div class="col-md-8ths">
                            <div class="cilinder-count-item">
                                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true">Afdeling <span class="num">3</span></div></div>
                                <div class="user-keys-cnt"><span class="arrow-left"></span><input class="user-keys-val" type="number" min="0" max="99" value="" /><span class="arrow-right"></span></div>
                                <div class="border-bottom"></div>
                            </div>
                        </div>
                        <div class="col-md-8ths">
                            <div class="cilinder-count-item">
                                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true">Afdeling <span class="num">4</span></div></div>
                                <div class="user-keys-cnt"><span class="arrow-left"></span><input class="user-keys-val" type="number" min="0" max="99" value="" /><span class="arrow-right"></span></div>
                                <div class="border-bottom"></div>
                            </div>
                        </div>
                        <div class="col-md-8ths">
                            <div class="cilinder-count-item">
                                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true">Afdeling <span class="num">5</span></div></div>
                                <div class="user-keys-cnt"><span class="arrow-left"></span><input class="user-keys-val" type="number" min="0" max="99" value="" /><span class="arrow-right"></span></div>
                                <div class="border-bottom"></div>
                            </div>
                        </div>
                        <div class="col-md-8ths">
                            <div class="cilinder-count-item">
                                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true">Afdeling <span class="num">6</span></div></div>
                                <div class="user-keys-cnt"><span class="arrow-left"></span><input class="user-keys-val" type="number" min="0" max="99" value="" /><span class="arrow-right"></span></div>
                                <div class="border-bottom"></div>
                            </div>
                        </div>
                        <div class="col-md-8ths">
                            <div class="cilinder-count-item">
                                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true">Afdeling <span class="num">7</span></div></div>
                                <div class="user-keys-cnt"><span class="arrow-left"></span><input class="user-keys-val" type="number" min="0" max="99" value="" /><span class="arrow-right"></span></div>
                                <div class="border-bottom"></div>
                            </div>
                        </div>
                        <div class="col-md-8ths">
                            <div class="cilinder-count-item">
                                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true">Afdeling <span class="num">8</span></div></div>
                                <div class="user-keys-cnt"><span class="arrow-left"></span><input class="user-keys-val" type="number" min="0" max="99" value="" /><span class="arrow-right"></span></div>
                                <div class="border-bottom"></div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="row cilinder-count-item-row">
                        <?php
                        $cnt = 0;
                        foreach($keyProducts as $key => $item) { ?>
                            <div class="col-md-8ths">
                                <div class="cilinder-count-item">
                                    <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                    <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true"><?php echo $key ? $key : '<span class="num">' . ($cnt + 1) . '</span>'; ?></div></div>
                                    <div class="user-keys-cnt"><span class="arrow-left"></span><input class="user-keys-val" type="number" min="0" max="99" value="<?php echo $item["quantity"]; ?>" /><span class="arrow-right"></span></div>
                                    <div class="border-bottom"></div>
                                </div>
                            </div>
                            <?php
                            $cnt++;
                        }
                        $keyUsersCount = $cnt;
                        if($keyUsersCount < 8) {
                            for($i = $keyUsersCount; $i < 8; $i++) {
                                ?>
                                <div class="col-md-8ths">
                                    <div class="cilinder-count-item">
                                        <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                        <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true"><span class="num"><?php echo $i + 1; ?></span></div></div>
                                        <div class="user-keys-cnt"><span class="arrow-left"></span><input class="user-keys-val" type="number" min="0" max="99" value="" /><span class="arrow-right"></span></div>
                                        <div class="border-bottom"></div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-12 btn-container">
                <a id="more-user-sleutels" href="javascript:;" class="view-btn view-btn-inverse"><span>Meer dan 8 nodig? Vul hier je aantal in...</span></a>
                <input id="user-sleutels-num" type="text" value="<?php echo $keyUsersCount > 8 ? $keyUsersCount : "8"; ?>"<?php if($keyUsersCount <= 8){ ?> style="display: none;"<?php } ?> />
                <input id="sleutels-num" class="keyplan" type="hidden" value="0" />
            </div>
            <div class="col-md-12 btn-container">
                <a href="#" class="access-select view-btn view-btn-shadow">DOORGAAN</a>
            </div>
            <div class="col-md-12">
                <div class="divider-blue-line"></div>
            </div>
            <div id="keys-access" class="col-md-12">
                <div class="config-name">Geef hier aan welke personen en/of afdelingen tot welke deuren (cilinders) zij toegang hebben.</div>
                <span class="lead">Indien deze grijs is krijgt deze persoon of afdeling toegang om de deur te openen. U kunt achter elk persoon en/of cilinder zelf bepalen wie toegang moet hebben.</span>
            </div>
            <div class="col-md-12 access-params-block">
                <?php if(!$keyProducts){ ?>
                    <div class="row access-row">
                        <div class="col-md-8ths">
                            <div class="cilinder-count-item active">
                                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true">Afdeling <span class="num">1</span></div></div>
                                <div class="border-bottom"></div>
                            </div>
                            <div class="access-keys-num">1</div>
                        </div>
                        <div class="col-md-min-8ths">
                            <div class="cilinder-params access-params clearfix">
                                <div class="access-block"><div class="cilinder-name">1</div></div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix row access-row" style="display: none;">
                        <div class="col-md-8ths">
                            <div class="cilinder-count-item active">
                                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true">Afdeling <span class="num">2</span></div></div>
                                <div class="border-bottom"></div>
                            </div>
                            <div class="access-keys-num"></div>
                        </div>
                        <div class="col-md-min-8ths">
                            <div class="cilinder-params access-params clearfix">
                                <div class="access-block"><div class="cilinder-name">1</div></div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix row access-row" style="display: none;">
                        <div class="col-md-8ths">
                            <div class="cilinder-count-item active">
                                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true">Afdeling <span class="num">3</span></div></div>
                                <div class="border-bottom"></div>
                            </div>
                            <div class="access-keys-num"></div>
                        </div>
                        <div class="col-md-min-8ths">
                            <div class="cilinder-params access-params clearfix">
                                <div class="access-block"><div class="cilinder-name">1</div></div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix row access-row" style="display: none;">
                        <div class="col-md-8ths">
                            <div class="cilinder-count-item active">
                                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true">Afdeling <span class="num">4</span></div></div>
                                <div class="border-bottom"></div>
                            </div>
                            <div class="access-keys-num"></div>
                        </div>
                        <div class="col-md-min-8ths">
                            <div class="cilinder-params access-params clearfix">
                                <div class="access-block"><div class="cilinder-name">1</div></div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix row access-row" style="display: none;">
                        <div class="col-md-8ths">
                            <div class="cilinder-count-item active">
                                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true">Afdeling <span class="num">5</span></div></div>
                                <div class="border-bottom"></div>
                            </div>
                            <div class="access-keys-num"></div>
                        </div>
                        <div class="col-md-min-8ths">
                            <div class="cilinder-params access-params clearfix">
                                <div class="access-block"><div class="cilinder-name">1</div></div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix row access-row" style="display: none;">
                        <div class="col-md-8ths">
                            <div class="cilinder-count-item active">
                                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true">Afdeling <span class="num">6</span></div></div>
                                <div class="border-bottom"></div>
                            </div>
                            <div class="access-keys-num"></div>
                        </div>
                        <div class="col-md-min-8ths">
                            <div class="cilinder-params access-params clearfix">
                                <div class="access-block"><div class="cilinder-name">1</div></div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix row access-row" style="display: none;">
                        <div class="col-md-8ths">
                            <div class="cilinder-count-item active">
                                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true">Afdeling <span class="num">7</span></div></div>
                                <div class="border-bottom"></div>
                            </div>
                            <div class="access-keys-num"></div>
                        </div>
                        <div class="col-md-min-8ths">
                            <div class="cilinder-params access-params clearfix">
                                <div class="access-block"><div class="cilinder-name">1</div></div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix row access-row" style="display: none;">
                        <div class="col-md-8ths">
                            <div class="cilinder-count-item active">
                                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true">Afdeling <span class="num">8</span></div></div>
                                <div class="border-bottom"></div>
                            </div>
                            <div class="access-keys-num"></div>
                        </div>
                        <div class="col-md-min-8ths">
                            <div class="cilinder-params access-params clearfix">
                                <div class="access-block"><div class="cilinder-name">1</div></div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <?php
                    $cnt = 0;
                    foreach($keyProducts as $key => $item) { ?>
                        <div class="clearfix row access-row">
                            <div class="col-md-8ths">
                                <div class="cilinder-count-item active">
                                    <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                    <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true"><?php echo $key ? $key : 'Afdeling <span class="num">' . ($cnt + 1) . '</span>'; ?></div></div>
                                    <div class="border-bottom"></div>
                                </div>
                                <div class="access-keys-num"><?php echo $item["quantity"]; ?></div>
                            </div>
                            <div class="col-md-min-8ths">
                                <div class="cilinder-params access-params clearfix">
                                    <?php
                                    $ind = 0;
                                    foreach($doorProducts as $door) {
                                        $doors = explode(",", $item["access"]);
                                        $doors = array_map("trim", $doors);
                                        ?>
                                        <div class="access-block<?php if($doors[0] == "*masterkey" || in_array($door->doorName, $doors)){ ?> active<?php } ?>"><div class="cilinder-name"><?php echo $door->doorName ? $door->doorName : ($ind + 1); ?></div></div>
                                        <?php
                                        $ind++;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $cnt++;
                    }
                    $keyUsersCount = $cnt;
                    if($keyUsersCount < 8) {
                        for($i = $keyUsersCount; $i < 8; $i++) { ?>
                            <div class="clearfix row access-row" style="display: none;">
                                <div class="col-md-8ths">
                                    <div class="cilinder-count-item active">
                                        <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/group.png);"></div>
                                        <div class="cilinder-count-title"><div class="sleutel-name" contenteditable="true">Afdeling <span class="num"><?php echo ($i + 1); ?></span></div></div>
                                        <div class="border-bottom"></div>
                                    </div>
                                    <div class="access-keys-num"></div>
                                </div>
                                <div class="col-md-min-8ths">
                                    <div class="cilinder-params access-params clearfix">
                                        <?php
                                        $ind = 0;
                                        foreach($doorProducts as $door) {
                                            ?>
                                            <div class="access-block"><div class="cilinder-name"><?php echo $door->doorName ? $door->doorName : ($ind + 1); ?></div></div>
                                            <?php
                                            $ind++;
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }
                    ?>
                <?php } ?>
            </div>
            <div class="col-md-12 btn-container">
                <a href="#" class="offers-select view-btn view-btn-shadow">DOORGAAN</a>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid offers-block block-align-center">
    <div class="container">
        <div id="select-offers" class="block-padding">
            <div class="page-head">Je hebt je bestelling bijna afgerond</div>
            <span class="lead">
				Kies vanuit welke serie je de cilinders geleverd wil hebben. <br>
				Klikt u op bestellen dan duurt 10 a 15 seconden voordat u verder gaat naar de winkelwagen.
			</span>
        </div>
        <?php
        $kpId = 1631;
        $keyplan = wc_get_product($kpId);
        $keyplanPrice = $keyplan->get_regular_price();
        ?>
        <div class="keyplan-calculation" data-id="<?=$kpId?>" data-price="<?php echo get_product_addon_price_for_display_custom($keyplanPrice)?>"></div>
        <?php
        $aLabels = array();
        $advantages = get_field("plus_en_minpunten", $id);
        $advantages = array_keys($advantages);
        $infoPostId = 3435;
        if($advantages) {
            while ( have_rows( "plus_en_minpunten", $id ) ) {
                the_row();
                foreach ( $advantages as $advantage ) {
                    $subField = get_sub_field_object( $advantage );
                    $infoText = get_field($advantage, $infoPostId);
                    ?>
                    <div id="<?= $advantage ?>-info" class="main adv-popup-info" style="display:none;">
                        <div class="block-align-center">
                            <div class="config-name"><?= $subField["label"] ?></div>
                            <span class="lead">U treft hier meer informatie</span>
                            <div class="knop-info-block adv-info-block">
                                <?= $infoText ?>
                            </div>
                            <a href="javascript:;"
                               class="popup-close view-btn view-btn-inverse"><span>Terug naar bestellen</span></a>
                        </div>
                    </div>
                    <?php
                }
            }
        }
        ?>
        <div class="offer-item-table row no-gutters">
            <div class="ot-left">
                <div class="oi-block" style="display: block"></div>
                <?php
                if($advantages) {
                    while ( have_rows( "plus_en_minpunten", $id) ) {
                        the_row();
                        foreach($advantages as $advantage) {
                            $subField = get_sub_field_object( $advantage );
                            $aLabels[$advantage] = $subField["label"];
                            $hasInfoWindow = false;
                            $infoText = get_field($advantage, $infoPostId);
                            ?>
                            <?php
                            if($infoText){
                                $hasInfoWindow = true;
                            }
                            ?>
                            <div class="oi-block">
                                <div class="offer-position op-label"><?= $subField["label"] ?> <?php if($hasInfoWindow){ ?><span class="op-info-icon" data-fancybox data-src="#<?= $advantage ?>-info">i</span><?php } ?></div>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
                <div class="oi-block">
                    &nbsp;
                </div>
            </div>
            <div class="ot-right">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="offer-item offer-item-left<?php if(!$keyplanCart || $cilinderProductId == 1626 || !$cilinderProductId){ ?> selected<?php } ?>">
                        <div class="offer-item-inner">
                            <div class="oi-block">
                                <div id="po-1626" class="offer-prices" style="display: none;">
                                    <?php
                                    $pId = 1626;
                                    $pVar = get_product_addons($pId);
                                    $pKeyTypes = $pVar[7];
                                    $pDoorname = $pVar[4];
                                    $pFrontdoor = $pVar[5];
                                    $pSizes = $pVar[3];
                                    $pMaterials = $pVar[2];
                                    $pExtra1 = $pVar[0];
                                    $pExtra2 = $pVar[1];
                                    $pOuterSide = @$pVar[8];
                                    $pInnerSide = @$pVar[9];
                                    $product = wc_get_product($pId);
                                    $productImage = $product->get_image($size = 'shop_thumbnail');
                                    $regularPrice = $product->get_regular_price();
                                    $kVar = get_product_addons(1625);
                                    $extraKeyPrice = $kVar[0];
                                    $extraKeyUser = $kVar[1];
                                    $extraKeyAccess = $kVar[2];
                                    foreach($pVar as $k=>$v)
                                    {
                                        ?>
                                        <div class="<?=$v["field-name"]?>">
                                            <?
                                            foreach($v["options"] as $option)
                                            {
                                                ?>
                                                <div
                                                    <? if(strpos($v["field-name"], "extra-knop-lange-kant") === false) { ?>
                                                        data-val="<?=$option["label"]?>"
                                                    <? } else { ?>
                                                        data-val="<?=str_replace(" lange zijde", "", $option["label"]);?>"
                                                    <? } ?>
                                                >
                                                    <?php echo get_product_addon_price_for_display_custom($option["price"])?>
                                                </div>
                                                <?
                                            }
                                            ?>
                                        </div>
                                        <?
                                    }
                                    ?>
                                    <div class="product-price"><?=get_product_addon_price_for_display_custom($product->get_regular_price())?></div>
                                    <?php
                                    $product = new WC_Product(1625);
                                    $keyPrice = $product->get_regular_price();
                                    ?>
                                    <div class="key-price" data-value="<?=sanitize_title($extraKeyPrice["options"][0]["label"]). '-1';?>"><?php echo get_product_addon_price_for_display_custom($keyPrice + $extraKeyPrice["options"][0]["price"])?></div>
                                    <div class="extra-key-price" data-value="<?=sanitize_title($extraKeyPrice["options"][1]["label"]). '-2';?>"><?php echo get_product_addon_price_for_display_custom($keyPrice + $extraKeyPrice["options"][1]["price"])?></div>
                                    <div class="access-params-names" data-name-user="addon-<?php echo sanitize_title($extraKeyUser["field-name"]); ?>[]" data-name-price="addon-<?php echo sanitize_title($extraKeyPrice["field-name"]); ?>" data-name-access="addon-<?php echo sanitize_title($extraKeyAccess["field-name"]); ?>[]"></div>
                                    <div class="cilinder-name-field" data-name="addon-<?php echo sanitize_title($pDoorname["field-name"]); ?>[]"></div>
                                </div>
                                <h2>M&C Matrix<?php
                                    if(get_field("advies", $pId)) {
                                        ?>
                                        <span class="advies"></span>
                                        <?php
                                    }
                                    ?></h2>
                                <div class="img-wrapper">
                                    <?php echo $productImage; ?>
                                </div>
                                <div class="special-offer-wrapper">
                                    <span class="special-offer">
                                        <span>€</span><span id="price-1626"><?=sprintf("%01.2f", get_product_addon_price_for_display_custom($keyplanPrice + $regularPrice + $pSizes["options"][0]["price"] + $pExtra1["options"][0]["price"] + $pExtra2["options"][0]["price"] + $pMaterials["options"][0]["price"] + $pFrontdoor["options"][0]["price"]))?></span>
                                    </span>
                                    <div class="btw"><?php if($excl_btw){ ?>excl.<?php } else { ?>incl.<?php } ?> BTW</div>
                                </div>
                                <div class="offer-info">
                                    <span class="cilinder-num"><?php echo $cilinderCount ? $cilinderCount : "1"; ?></span> cilinders<br/>
                                    <span class="sleutel-num"><?php echo $allKeyCount ? $allKeyCount : "1"; ?></span> sleutels
                                    <?php /*<span data-fancybox data-src="#key-type-block" class="choose-key-type">Kies hier color of metalen sleutels</span>
                                    <input class="key-type" type="hidden" name="addon-<?php echo sanitize_title($pKeyTypes["field-name"]); ?>[]" value="<?php echo $keyType ? $keyType : ""; ?>" />*/ ?>
                                </div>
                            </div>
                            <?php
                            $advantages = get_field("plus_en_minpunten", $pId);
                            foreach($advantages as $k=>$advantage){
                                $advantageText = str_replace("-","<span class='offer-icon minus'></span>", $advantage);
                                $advantageText = str_replace("+","<span class='offer-icon plus'></span>", $advantageText);
                                ?>
                                <div class="oi-block">
                                    <div class="offer-position"><span class="adv-label"><?=$aLabels[$k]?></span><?=trim($advantageText)?></div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="oi-block">
                                <div class="forms-list">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <input class="<?=substr($pMaterials["field-name"], strpos($pMaterials["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($pMaterials["field-name"]); ?>[]" value="<?php echo sanitize_title($pMaterials["options"][0]["label"]); ?>" />
                                        <input class="<?=substr($pExtra1["field-name"], strpos($pExtra1["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($pExtra1["field-name"]); ?>[]" value="<?php echo sanitize_title($pExtra1["options"][0]["label"]); ?>" />
                                        <input class="<?=substr($pExtra2["field-name"], strpos($pExtra2["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($pExtra2["field-name"]); ?>[]" value="<?php echo sanitize_title($pExtra2["options"][0]["label"]); ?>" />
                                        <input class="<?=substr($pSizes["field-name"], strpos($pSizes["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($pSizes["field-name"]); ?>" value="<?php echo sanitize_title($pSizes["options"][0]["label"]). '-1'; ?>" />
                                        <input class="<?=substr($pFrontdoor["field-name"], strpos($pFrontdoor["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($pFrontdoor["field-name"]); ?>" value="<?=sanitize_title($pFrontdoor["options"][0]["label"])?>" />
                                        <input class="<?=substr($pOuterSide["field-name"], strpos($pOuterSide["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($pOuterSide["field-name"]); ?>" value="<?php echo sanitize_title($pOuterSide["options"][0]["label"]). '-1'; ?>" />
                                        <input class="<?=substr($pInnerSide["field-name"], strpos($pInnerSide["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($pInnerSide["field-name"]); ?>" value="<?php echo sanitize_title($pInnerSide["options"][0]["label"]). '-1'; ?>" />
                                        <input type="hidden" name="quantity" value="1" />
                                        <input type="hidden" name="add-to-cart" value="<?=$pId?>">
                                    </form>
                                </div>
                                <button class="make-order view-btn view-btn-shadow offer-btn" data-id="<?=$pId?>" data-key-id="1625">Nu bestellen</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="offer-item offer-item-right<?php if($cilinderProductId == 1577){ ?> selected<?php } ?>">
                        <div class="offer-item-inner">
                            <div class="oi-block">
                                <div id="po-1577" class="offer-prices" style="display: none;">
                                    <?php
                                    $pId = 1577;
                                    $pVar = get_product_addons($pId);
                                    $pDoorname = $pVar[4];
                                    $pFrontdoor = $pVar[5];
                                    $pSizes = $pVar[3];
                                    $pMaterials = $pVar[2];
                                    $pExtra1 = $pVar[0];
                                    $pExtra2 = $pVar[1];
                                    $pOuterSide = @$pVar[8];
                                    $pInnerSide = @$pVar[9];
                                    $product = wc_get_product($pId);
                                    $productImage = $product->get_image($size = 'shop_thumbnail');
                                    $regularPrice = $product->get_regular_price();
                                    $kVar = get_product_addons(1597);
                                    $extraKeyPrice = $kVar[0];
                                    $extraKeyUser = $kVar[1];
                                    $extraKeyAccess = $kVar[2];
                                    foreach($pVar as $k=>$v)
                                    {
                                        ?>
                                        <div class="<?=$v["field-name"]?>">
                                            <?
                                            foreach($v["options"] as $option)
                                            {
                                                ?>
                                                <div
                                                    <? if(strpos($v["field-name"], "extra-knop-lange-kant") === false) { ?>
                                                        data-val="<?=$option["label"]?>"
                                                    <? } else { ?>
                                                        data-val="<?=str_replace(" lange zijde", "", $option["label"]);?>"
                                                    <? } ?>
                                                >
                                                    <?php echo get_product_addon_price_for_display_custom($option["price"])?>
                                                </div>
                                                <?
                                            }
                                            ?>
                                        </div>
                                        <?
                                    }
                                    ?>
                                    <div class="product-price"><?=get_product_addon_price_for_display_custom($product->get_regular_price())?></div>
                                    <?php
                                    $product = new WC_Product(1597);
                                    $keyPrice = $product->get_regular_price();
                                    ?>
                                    <div class="key-price" data-value="<?=sanitize_title($extraKeyPrice["options"][0]["label"]). '-1';?>"><?php echo get_product_addon_price_for_display_custom($keyPrice + $extraKeyPrice["options"][0]["price"])?></div>
                                    <div class="extra-key-price" data-value="<?=sanitize_title($extraKeyPrice["options"][1]["label"]). '-2';?>"><?php echo get_product_addon_price_for_display_custom($keyPrice + $extraKeyPrice["options"][1]["price"])?></div>
                                    <div class="access-params-names" data-name-user="addon-<?php echo sanitize_title($extraKeyUser["field-name"]); ?>[]" data-name-price="addon-<?php echo sanitize_title($extraKeyPrice["field-name"]); ?>" data-name-access="addon-<?php echo sanitize_title($extraKeyAccess["field-name"]); ?>[]"></div>
                                    <div class="cilinder-name-field" data-name="addon-<?php echo sanitize_title($pDoorname["field-name"]); ?>[]"></div>
                                </div>
                                <h2>M&C Condor<?php
                                    if(get_field("advies", $pId)) {
                                        ?>
                                        <span class="advies"></span>
                                        <?php
                                    }
                                    ?></h2>
                                <div class="img-wrapper">
                                    <?php echo $productImage; ?>
                                </div>
                                <div class="special-offer-wrapper">
                                    <span class="special-offer">
                                        <span>€</span><span id="price-1577"><?=sprintf("%01.2f", get_product_addon_price_for_display_custom($keyplanPrice + $regularPrice + $pSizes["options"][0]["price"] + $pExtra1["options"][0]["price"] + $pExtra2["options"][0]["price"] + $pMaterials["options"][0]["price"] + $pFrontdoor["options"][0]["price"]))?></span>
                                    </span>
                                    <div class="btw"><?php if($excl_btw){ ?>excl.<?php } else { ?>incl.<?php } ?> BTW</div>
                                </div>
                                <div class="offer-info">
                                    <span class="cilinder-num"><?php echo $cilinderCount ? $cilinderCount : "1"; ?></span> cilinders<br/>
                                    <span class="sleutel-num"><?php echo $allKeyCount ? $allKeyCount : "1"; ?></span> sleutels
                                </div>
                            </div>
                            <?php
                            $advantages = get_field("plus_en_minpunten", $pId);
                            foreach($advantages as $k=>$advantage){
                                $advantageText = str_replace("-","<span class='offer-icon minus'></span>", $advantage);
                                $advantageText = str_replace("+","<span class='offer-icon plus'></span>", $advantageText);
                                ?>
                                <div class="oi-block">
                                    <div class="offer-position"><span class="adv-label"><?=$aLabels[$k]?></span><?=trim($advantageText)?></div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="oi-block">
                                <div class="forms-list">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <input class="<?=substr($pMaterials["field-name"], strpos($pMaterials["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($pMaterials["field-name"]); ?>[]" value="<?php echo sanitize_title($pMaterials["options"][0]["label"]); ?>" />
                                        <input class="<?=substr($pExtra1["field-name"], strpos($pExtra1["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($pExtra1["field-name"]); ?>[]" value="<?php echo sanitize_title($pExtra1["options"][0]["label"]); ?>" />
                                        <input class="<?=substr($pExtra2["field-name"], strpos($pExtra2["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($pExtra2["field-name"]); ?>[]" value="<?php echo sanitize_title($pExtra2["options"][0]["label"]); ?>" />
                                        <input class="<?=substr($pSizes["field-name"], strpos($pSizes["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($pSizes["field-name"]); ?>" value="<?php echo sanitize_title($pSizes["options"][0]["label"]). '-1'; ?>" />
                                        <input class="<?=substr($pFrontdoor["field-name"], strpos($pFrontdoor["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($pFrontdoor["field-name"]); ?>" value="<?=sanitize_title($pFrontdoor["options"][0]["label"])?>" />
                                        <input class="<?=substr($pOuterSide["field-name"], strpos($pOuterSide["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($pOuterSide["field-name"]); ?>" value="<?php echo sanitize_title($pOuterSide["options"][0]["label"]). '-1'; ?>" />
                                        <input class="<?=substr($pInnerSide["field-name"], strpos($pInnerSide["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($pInnerSide["field-name"]); ?>" value="<?php echo sanitize_title($pInnerSide["options"][0]["label"]). '-1'; ?>" />
                                        <input type="hidden" name="quantity" value="1" />
                                        <input type="hidden" name="add-to-cart" value="<?=$pId?>">
                                    </form>
                                </div>
                                <button class="make-order view-btn view-btn-shadow offer-btn" data-id="<?=$pId?>" data-key-id="1597">Nu bestellen</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ( !empty( get_the_content() ) ){ ?>
    <div class="container-fluid products-content-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php the_content();?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div style="display: none">
    <div id="options-window" class="main">
        <div class="block-align-center">
            <div class="config-name">Hoe bepaal ik de maatvoering?</div>
            <span class="lead">In de afbeelding hier onder tref je hoe de maatvoering werkt met een aantal voorbeeldweergaves van maten.</span>
            <img src="<?php bloginfo('template_directory'); ?>/img/params.png" alt="" title="" />
            <a href="javascript:;" class="popup-close view-btn view-btn-inverse"><span>Terug naar bestellen</span></a>
        </div>
    </div>
    <div id="knop-pushknop-info" class="main">
        <div class="block-align-center">
            <div class="config-name">Hoe werkt een knop?</div>
            <span class="lead">U kunt kiezen voor een knop of pushknop</span>
            <div class="knop-info-block">
                <div class="row no-gutters">
                    <div class="col-sm-6 col-xs-12 ki-text ki-text-left">
                        <div class="ki-title">Knop</div>
                        Kiest u voor een knop aan de cilinder dan hoeft u aan die zijde van de cilinder geen sleutel te gebruiken. U kunt door de knop te draaien de deur op slot doen of van het slot afhalen zonder de sleutel te gebruiken. Aan de buitenzijde van de deur kan het slot alleen open gemaakt worden met een sleutel.
                    </div>
                    <div class="col-sm-6 col-xs-12 ki-img">
                        <img src="<?php bloginfo('template_directory'); ?>/img/cilinder-types/short-nikkel.png" alt="" />
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-sm-6 hidden-xs ki-img">
                        <img src="<?php bloginfo('template_directory'); ?>/img/cilinder-types/short-nikkel.png" alt="" />
                    </div>
                    <div class="col-sm-6 col-xs-12 ki-text ki-text-right">
                        <div class="ki-title">Pushknop</div>
                        Kiest u voor een pushknop dan moet de knop eerst ingedrukt worden voordat de deur op slot of van het slot afgehaald kan worden. Dit is erg handig als er bijvoorbeeld een brievenbus in de voordeur zit. Echter wanneer de sleutel in het slot meerdere malen omgedraaid moet worden voordat de deur open gaat, dan is een pushknop niet te adviseren.
                    </div>
                    <div class="col-xs-12 visible-xs ki-img">
                        <img src="<?php bloginfo('template_directory'); ?>/img/cilinder-types/short-nikkel.png" alt="" />
                    </div>
                </div>
            </div>
            <a href="javascript:;" class="popup-close view-btn view-btn-inverse"><span>Terug naar bestellen</span></a>
        </div>
    </div>
    <div style="display:none;" id="key-type-block" class="main popup-container">
        <div class="block-align-center">
            <div class="config-name">Kies hier of u gekleurde sleutels of metalen sleutels bij uw bestelling wilt ontvangen</div>
            <span class="lead">Selecteer uw voorkeur en druk op bevestigen</span>
            <div class="options-list cilinder-count clearfix">
                <?php foreach($keyTypes["options"] as $ind=>$option){ ?>
                    <div class="cilinder-count-item<?=((sanitize_title($keyType) == sanitize_title($option["label"]) || (!$keyType && $ind==0))?" active":"")?>" onclick="javascript:;">
                        <div class="cilinder-count-title" data-value="<?=sanitize_title($option["label"])?>"><?=$option["label"]?></div>
                        <div class="cilinder-count-img" style="background-image: url(<?=wp_get_attachment_image_src($option["image"], null)[0]?>);"></div>
                        <!--<div class="border-bottom"></div>-->
                    </div>
                <?php } ?>
            </div>
            <a href="javascript:;" class="key-type-select view-btn view-btn-inverse"><span>Bevestigen</span></a>
        </div>
    </div>
</div>

<?php get_footer(); ?>
