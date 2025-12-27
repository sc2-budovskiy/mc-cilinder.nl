<?php /* Template Name: Product Page */ ?>

<?php get_header();?>

<?php
$excl_btw = isset($_COOKIE["excl_btw"]) && $_COOKIE["excl_btw"] ? true : false;

//get theme options
$options = get_option( 'theme_settings' ); ?>
<div class="breadcrumb-block">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo home_url(); ?>">Home</a></li>
            <li class="active">M&C Deurcilinders kiezen</li>
        </ol>
    </div>
</div>
<div class="main-top-slider main-top-products">
    <div class="container-fluid item" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/slide.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-6 col-md-6 col-sm-12 text-center">
                    <div class="slider-text">
                        <div class="page-head"><?php the_field("banner_title") ?></div>
                        <div class="lead">Dé manier om zelf uw thuis veiliger te maken.</div>
                        <div class="special-offer"><span>Al vanaf € <?php echo get_banner_price(); ?></span> <?php if($excl_btw){ ?>excl.<?php } else { ?>incl.<?php } ?> BTW verkrijgbaar</div>
                        <a href="#" class="view-btn view-btn-shadow cilinder-select">BESTEL NU</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid main-top-items">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-xs-6">
                <div class="item">
                    <div class="img-wrapper">
                        <img src="<?php bloginfo('template_directory'); ?>/img/main-item1.png" alt="item1" title="" />
                    </div>
                    <div class="text-wrapper">
                        <div class="title">Snelle levertijd</div>
                        <div class="text">Voor 17:00 uur besteld is de volgende dag in huis*</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-6">
                <div class="item">
                    <div class="img-wrapper">
                        <img src="<?php bloginfo('template_directory'); ?>/img/main-item2.png" alt="item2" title="" />
                    </div>
                    <div class="text-wrapper">
                        <div class="title">Geen verzendkosten</div>
                        <div class="text">Altijd gratis verzending in Nederland en België</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-6">
                <div class="item">
                    <div class="img-wrapper">
                        <img src="<?php bloginfo('template_directory'); ?>/img/main-item3.png" alt="item3" />
                    </div>
                    <div class="text-wrapper">
                        <div class="title">30 dagen bedenktijd</div>
                        <div class="text">Eenvoudig en gratis retour binnen 30 dagen</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-6">
                <div class="item">
                    <div class="img-wrapper">
                        <img src="<?php bloginfo('template_directory'); ?>/img/main-item4.png" alt="item4" />
                    </div>
                    <div class="text-wrapper">
                        <div class="title">Gratis support</div>
                        <div class="text">Gratis support tijdens en na uw aankoop</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
            <a href="#" class="view-btn view-btn-shadow cilinder-select">Cilinders kiezen</a>
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
            <a href="#" class="cilinder-select view-btn"><span>Aantal cilinders kiezen</span></a>
        </div>
    </div>
</div>
<div class="container-fluid config-title-block block-align-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-head">Stel je bestelling samen</div>
                <span class="lead">Kies de cilinders die je wil bestellen om je sloten te vervangen voor dé beveiligingsoplossing in sloten!</span>
                <span class="cilinder-select arrow-down"></span>
                <div class="divider-blue-line"></div>
            </div>
        </div>
    </div>
</div>
<?php
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

wp_reset_postdata();
$id = intval(get_field("cilinder"));
$productCnt = get_field("product_number", $id) ? intval(get_field("product_number", $id)) : 1;

$optionImages = get_field("option_images", $id);
if(!empty($optionImages)) {
    foreach($optionImages as $oi) {
        ?>
        <div class="coi-<?php echo $oi["option_key"]; ?>">
            <?php
            foreach($oi["images"] as $k=>$img) {
                if($img) {
                    ?><div class="<?php echo $k; ?>" data-img="<?php echo $img; ?>" ></div><?php
                }
            }
            ?>
        </div>
        <?php
    }
}
?>
<div class="container-fluid config-block block-align-center">
    <div class="container">
        <div class="row">
            <div id="select-cilinder" class="col-md-12 block-padding">
                <div class="config-name">Kies het aantal cilinders dat je nodig hebt</div>
                <span class="lead">Kies hier het aantal cilinders dat je nodig hebt om je sloten te vervangen.</span>
            </div>
            <div class="col-md-12 cilinder-step-one cilinder-count clearfix">
                <div class="row cilinder-count-item-row">
                    <?php for($i = 1; $i <= 8; $i++) { ?>
                        <div class="col-md-8ths">
                            <div class="cilinder-count-item<?php if($productCnt == $i) { ?> active<?php } ?>">
                                <div class="cilinder-count-title"><span class="num"><?php echo $i; ?></span></div>
                                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-<?php echo $i; ?>.jpg);"></div>
                                <div class="border-bottom"></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-12 btn-container">
                <a id="more-cilinders" href="javascript:;" class="view-btn view-btn-inverse"><span>Meer dan 8 cilinders nodig?</span></a>
                <input id="cilinders-num" class="single-product" type="text" value="<?php echo $productCnt; ?>" style="display: none;" />
            </div>
            <div class="col-md-12 btn-container">
                <a href="#" class="params-select view-btn view-btn-shadow">Doorgaan met bestellen</a>
            </div>
            <div class="col-md-12">
                <div class="divider-blue-line"></div>
            </div>
            <div id="select-params" class="col-md-12">
                <div class="config-name">Kies je optie per cilinder</div>
                <span class="lead">Maak je cilinders helemaal naar wens per slot.</span>
            </div>
            <div class="col-md-12 cilinder-config-block">
                <?php
                $var = get_product_addons($id);
                $sizes = $var[3];
                $materials = $var[2];
                $extra1 = $var[0];
                $extra2 = $var[1];
                $keyTypes = $var[5];
                $product = wc_get_product($id);

                $outerSide = $var[6] ?? null;
                $innerSide = $var[7] ?? null;

                if(!empty($extra2["options"])) {
                    foreach($extra2["options"] as $ind=>$option) {
                        if(!$option["image"]) {
                            if(($extra1["options"][$ind]["image"] ?? null) && $option["label"] == ($extra1["options"][$ind]["label"] ?? null)) {
                                $extra2["options"][$ind]["image"] = $extra1["options"][$ind]["image"];
                            }
                            else {
                                $diOption = get_field("di_extra", "option");
                                $diOptionVal = $diOption[sanitize_title(str_replace(" lange zijde", "", $option["label"]))];
                                if($diOption && $diOptionVal) {
                                    $extra2["options"][$ind]["image"] = $diOptionVal;
                                }
                            }
                        }
                    }
                }
                if(!empty($materials["options"])) {
                    foreach($materials["options"] as $ind=>$option) {
                        if(!$option["image"]) {
                            $diOption = get_field("di_material", "option");
                            $diOptionVal = $diOption[sanitize_title($option["label"])];
                            if($diOption && $diOptionVal) {
                                $materials["options"][$ind]["image"] = $diOptionVal;
                            }
                        }
                    }
                }

                $haveOptions = false;
                $defaultOptions = get_field("default_options", $id);
                foreach($defaultOptions as $opt) {
                    if($opt && $opt != "default") {
                        $haveOptions = true;
                        break;
                    }
                }
                //$dataDefaultImage = "";
                $defaultImage = get_bloginfo('template_directory') . "/img/cilinders/cilinder-1.jpg";
                if(!empty($var)) {
                    foreach($var as $ind => $item) {
                        if(!empty($item["options"]) && $item["name"] == "Maat") {
                            if($item["options"][0]["image"]) {
                                $defaultImage = ($img = wp_get_attachment_image_src($item["options"][0]["image"], null)) ? $img[0] : '';
                                //$dataDefaultImage = $defaultImage;
                            }
                        }
                    }
                }
                ?>
                <?php for($i=1; $i<=$productCnt; $i++ ) { ?>
                    <div class="row cilinder-config-options<?php if($haveOptions) { ?> change-img<?php } ?> clearfix">
                        <div class="col-md-8ths">
                            <div class="cilinder-count-item active">
                                <div class="opt-name">&nbsp;</div>
                                <div class="cilinder-count-title"><span class="num"><?php echo $i; ?></span></div>
                                <div class="cilinder-count-img" style="background-image: url(<?php echo $defaultImage; ?>);" data-folder="<?php bloginfo('template_directory'); ?>/img/cilinder-types/"></div>
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
                                    $sizeDefaultIndex = 0;
                                    $dVal = $defaultOptions ? $defaultOptions[substr($sizes["field-name"],strlen((string)$id."-"),-2)] : "";
                                    if($dVal) {
                                        foreach ($sizes["options"] as $ind=>$option)
                                        {
                                            if(trim($option["label"]) == trim($dVal)) {
                                                $sizeDefaultIndex = $ind;
                                            }
                                        }
                                    }
                                    ?>
                                    <select>
                                        <option value="<?=$sizes["options"][$sizeDefaultIndex]["label"]?>" data-value="<?=sanitize_title($sizes["options"][$sizeDefaultIndex]["label"]). '-1';?>">Kies je maat</option>
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
                                            <option value="<?=$option["label"]?>" data-value="<?=sanitize_title($option["label"]). '-'. ($ind + 1);?>"<?php if($ind == $sizeDefaultIndex) { ?> selected="selected"<?php } ?>><?=$option["label"]?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <div class="check-param" data-fancybox data-src="#options-window">Hoe maten bepalen?</div>
                                    <div class="param-value" data-value="<?=sanitize_title($sizes["options"][$sizeDefaultIndex]["label"]). '-' . ($sizeDefaultIndex + 1);?>" data-field="<?=substr($sizes["field-name"], strpos($sizes["field-name"],"-"))?>"><?=$sizes["options"][$sizeDefaultIndex]["label"]?></div>
                                </div>
                                <!--Список внушних размеров-->
                                <div class="col-md-3 col-xs-6">
                                    <div class="param-item param-11">
                                        <?php
                                        $osDefaultIndex = 0;
                                        $dVal = $defaultOptions ? $defaultOptions[substr($outerSide["field-name"],strlen((string)$id."-"),-2)] : "";
                                        if($dVal) {
                                            foreach ($outerSide["options"] as $ind=>$option)
                                            {
                                                if(trim($option["label"]) == trim($dVal)) {
                                                    $osDefaultIndex = $ind;
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="opt-name">Buitenzijde</div>
                                        <select class="outside">
                                            <option value="<?=trim(str_replace("mm","",$outerSide["options"][$osDefaultIndex]["label"]))?>" data-value="<?=sanitize_title($outerSide["options"][$osDefaultIndex]["label"]). '-1';?>"><?=$outerSide["options"][$osDefaultIndex]["label"]?></option>
                                            <?php
                                            foreach ($outerSide["options"] as $ind=>$option)
                                            {
                                                if($ind != $osDefaultIndex) {
                                                    ?>
                                                    <option value="<?=trim(str_replace("mm","",$option["label"]))?>" data-value="<?=sanitize_title($option["label"]). '-'. ($ind + 1);?>"<?php if($ind == $osDefaultIndex) { ?> selected="selected"<?php } ?>><?=$option["label"]?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="check-param" data-fancybox data-src="#options-window">Hoe maten bepalen?</div>
                                        <div class="param-value-not-matter hidden">Buitenzijde</div>
                                        <div class="param-value hidden" data-value="<?=sanitize_title($outerSide["options"][$osDefaultIndex]["label"]) . "-" . ($osDefaultIndex + 1);?>" data-field="<?=substr($outerSide["field-name"], strpos($outerSide["field-name"],"-"))?>"></div>
                                    </div>
                                </div>
                                <!--Список внутренних размеров-->
                                <div class="col-md-3 col-xs-6">
                                    <div class="param-item param-11">
                                        <?php
                                        $isDefaultIndex = 0;
                                        $dVal = $defaultOptions ? $defaultOptions[substr($innerSide["field-name"],strlen((string)$id."-"),-2)] : "";
                                        if($dVal) {
                                            foreach ($innerSide["options"] as $ind=>$option)
                                            {
                                                if(trim($option["label"]) == trim($dVal)) {
                                                    $isDefaultIndex = $ind;
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="opt-name">Binnenzijde</div>
                                        <select class="inside">
                                            <option value="<?=trim(str_replace("mm","",$innerSide["options"][$isDefaultIndex]["label"]))?>" data-value="<?=sanitize_title($innerSide["options"][$isDefaultIndex]["label"]). '-1';?>"><?=$innerSide["options"][$isDefaultIndex]["label"]?></option>
                                            <?php
                                            foreach ($innerSide["options"] as $ind=>$option)
                                            {
                                                if($ind != $isDefaultIndex) {
                                                    ?>
                                                    <option value="<?=trim(str_replace("mm","",$option["label"]))?>" data-value="<?=sanitize_title($option["label"]). '-'. ($ind + 1);?>"<?php if($ind == $isDefaultIndex) { ?> selected="selected"<?php } ?>><?=$option["label"]?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="check-param" data-fancybox data-src="#options-window">Hoe maten bepalen?</div>
                                        <div class="param-value-not-matter hidden">Binnenzijde</div>
                                        <div class="param-value hidden" data-value="<?=sanitize_title($innerSide["options"][$isDefaultIndex]["label"]) . "-" . ($isDefaultIndex + 1);?>" data-field="<?=substr($innerSide["field-name"], strpos($innerSide["field-name"],"-"))?>"></div>
                                    </div>
                                </div>

                                <div class="param-item param-2 hidden">
                                    <div class="change-param-value" data-fancybox data-src="#extra-select-<?php echo $i; ?>">Kies een extra knop korte kant</div>
                                    <div class="check-param" data-fancybox data-src="#knop-pushknop-info">Hoe werkt een knop?</div>
                                    <div class="param-value" data-value="<?=sanitize_title($extra1["options"][0]["label"])?>" data-field="<?=substr($extra1["field-name"], strpos($extra1["field-name"],"-"))?>"><?=$extra1["options"][0]["label"]?></div>
                                </div>
                                <div class="col-md-3 col-xs-6">
                                    <div class="param-item param-3">
                                        <?php
                                        $extraDefaultIndex = 0;
                                        $dVal = $defaultOptions ? $defaultOptions[substr($extra2["field-name"],strlen((string)$id."-"),-2)] : "";
                                        if($dVal) {
                                            foreach ($extra2["options"] as $ind=>$option)
                                            {
                                                if(trim($option["label"]) == trim($dVal)) {
                                                    $extraDefaultIndex = $ind;
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="opt-name">Extra</div>
                                        <div class="change-param-value" data-fancybox data-src="#extra2-select-<?php echo $i; ?>"><?=str_replace(" lange zijde", "", $extra2["options"][$extraDefaultIndex]["label"])?></div>
                                        <div class="check-param" data-fancybox data-src="#knop-pushknop-info">Hoe werkt een knop?</div>
                                        <div class="param-value hidden" data-value="<?=sanitize_title($extra2["options"][$extraDefaultIndex]["label"])?>" data-field="<?=substr($extra2["field-name"], strpos($extra2["field-name"],"-"))?>"><?=str_replace(" lange zijde", "", $extra2["options"][$extraDefaultIndex]["label"])?></div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-6">
                                    <div class="param-item param-4">
                                        <?php
                                        $materialsDefaultIndex = 0;
                                        $dVal = $defaultOptions ? $defaultOptions[substr($materials["field-name"],strlen((string)$id."-"),-2)] : "";
                                        if($dVal) {
                                            foreach ($materials["options"] as $ind=>$option)
                                            {
                                                if(trim($option["label"]) == trim($dVal)) {
                                                    $materialsDefaultIndex = $ind;
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="opt-name">Kleur</div>
                                        <div class="change-param-value" data-fancybox data-src="#materials-select-<?php echo $i; ?>"><?=$materials["options"][$materialsDefaultIndex]["label"]?></div>
                                        <div class="param-value hidden" data-value="<?=sanitize_title($materials["options"][$materialsDefaultIndex]["label"])?>" data-field="<?=substr($materials["field-name"], strpos($materials["field-name"],"-"))?>"><?=$materials["options"][$materialsDefaultIndex]["label"]?></div>
                                    </div>
                                </div>
                                <div class="param-item product-item-price"></div>
                                <div style="display:none;" id="materials-select-<?php echo $i; ?>" class="main materials-options popup-container">
                                    <div class="block-align-center">
                                        <div class="config-name">Kies de uitvoering</div>
                                        <span class="lead">Kies als uitvoering</span>
                                        <div class="options-list cilinder-count clearfix">
                                            <?php foreach($materials["options"] as $ind=>$option){ ?>
                                                <div class="cilinder-count-item<?=($ind==$materialsDefaultIndex?" active":"")?>" onclick="javascript:;">
                                                    <div class="cilinder-count-title" data-value="<?=sanitize_title($option["label"])?>"><?=$option["label"]?></div>
                                                    <div class="cilinder-count-img" style="background-image: url(<?=($img = wp_get_attachment_image_src($option["image"], null)) ? $img[0] : ''?>);"></div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <a href="javascript:;" class="material-select view-btn view-btn-inverse"><span>Bevestigen</span></a>
                                    </div>
                                </div>
                                <div style="display:none;" id="extra-select-<?php echo $i; ?>" class="main extra-options popup-container">
                                    <div class="block-align-center">
                                        <div class="config-name">Kies een extra knop voor de korte kant</div>
                                        <span class="lead">Kies als extra optie voor een knop of pushknop</span>
                                        <div class="options-list cilinder-count clearfix">
                                            <?php foreach($extra1["options"] as $ind=>$option){ ?>
                                                <div class="cilinder-count-item<?=($ind==0?" active":"")?>" onclick="javascript:;">
                                                    <div class="cilinder-count-title" data-value="<?=sanitize_title($option["label"])?>"><?=$option["label"]?></div>
                                                    <div class="cilinder-count-img" style="background-image: url(<?=($img = wp_get_attachment_image_src($option["image"], null)) ? $img[0] : ''?>);"></div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <a href="javascript:;" class="extra-select view-btn view-btn-inverse"><span>Bevestigen</span></a>
                                    </div>
                                </div>
                                <div style="display:none;" id="extra2-select-<?php echo $i; ?>" class="main extra2-options popup-container">
                                    <div class="block-align-center">
                                        <div class="config-name">Kies een extra knop</div>
                                        <span class="lead">Kies als extra optie voor een knop of pushknop</span>
                                        <div class="options-list cilinder-count clearfix">
                                            <?php foreach($extra2["options"] as $ind=>$option){ ?>
                                                <div class="cilinder-count-item<?=($ind==$extraDefaultIndex?" active":"")?>" onclick="javascript:;">
                                                    <div class="cilinder-count-title" data-value="<?=sanitize_title($option["label"])?>"><?= str_replace(" lange zijde", "",$option["label"]); ?></div>
                                                    <div class="cilinder-count-img" style="background-image: url(<?=($img = wp_get_attachment_image_src($option["image"], null)) ? $img[0] : ''?>);"></div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <a href="javascript:;" class="extra2-select view-btn view-btn-inverse"><span>Bevestigen</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-12 btn-container">
                <a href="#" class="keys-select view-btn view-btn-shadow">Doorgaan met bestellen</a>
            </div>
            <div class="col-xs-12">
                <div class="divider-blue-line"></div>
            </div>
            <div id="select-keys" class="col-md-12 block-padding">
                <div class="config-name">Kies het aantal extra sleutels</div>
                <span class="lead">Bij uw keuze van <span class="cilinder-num"><?php echo $productCnt; ?></span> <span>cilinders</span> worden er standaard <span class="sleutel-num-standard"><?php echo calcFreeKeysCnt($productCnt); ?></span> <span>sleutels</span> meegeleverd.<br/>
					De prijs voor een extra sleutel is € <span class="key-item-price">xx.xx</span></span>
            </div>
            <?php $keyColor = get_field("key_color");?>
            <div class="col-md-12 cilinder-step-three cilinder-count clearfix">
                <div class="row cilinder-step-three-row">
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item">
                            <div class="cilinder-count-title"><span class="num">1</span> sleutel</div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?><?php if($keyColor == "purple"){echo "/img/sleutels-num/sleutel-1.jpg";}elseif($keyColor == "blue"){echo "/img/blue-sleutels/mc-color1.jpg";}else{echo "/img/sleutels/sleutel-1.png";};?>);"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item">
                            <div class="cilinder-count-title"><span class="num">2</span> sleutels</div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?><?php if($keyColor == "purple"){echo "/img/sleutels-num/sleutel-2.jpg";}elseif($keyColor == "blue"){echo "/img/blue-sleutels/mc-color2.jpg";}else{echo "/img/sleutels/sleutel-2.png";};?>);"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item">
                            <div class="cilinder-count-title"><span class="num">3</span> sleutels</div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?><?php if($keyColor == "purple"){echo "/img/sleutels-num/sleutel-3.jpg";}elseif($keyColor == "blue"){echo "/img/blue-sleutels/mc-color3.jpg";}else{echo "/img/sleutels/sleutel-3.png";};?>);"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item">
                            <div class="cilinder-count-title"><span class="num">4</span> sleutels</div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?><?php if($keyColor == "purple"){echo "/img/sleutels-num/sleutel-4.jpg";}elseif($keyColor == "blue"){echo "/img/blue-sleutels/mc-color4.jpg";}else{echo "/img/sleutels/sleutel-4.png";};?>);"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item">
                            <div class="cilinder-count-title"><span class="num">5</span> sleutels</div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?><?php if($keyColor == "purple"){echo "/img/sleutels-num/sleutel-5.jpg";}elseif($keyColor == "blue"){echo "/img/blue-sleutels/mc-color5.jpg";}else{echo "/img/sleutels/sleutel-5.png";};?>);"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item">
                            <div class="cilinder-count-title"><span class="num">6</span> sleutels</div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?><?php if($keyColor == "purple"){echo "/img/sleutels-num/sleutel-6.jpg";}elseif($keyColor == "blue"){echo "/img/blue-sleutels/mc-color6.jpg";}else{echo "/img/sleutels/sleutel-6.png";};?>);"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item">
                            <div class="cilinder-count-title"><span class="num">7</span> sleutels</div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?><?php if($keyColor == "purple"){echo "/img/sleutels-num/sleutel-7.jpg";}elseif($keyColor == "blue"){echo "/img/blue-sleutels/mc-color7.jpg";}else{echo "/img/sleutels/sleutel-7.png";};?>);"></div>
                        </div>
                    </div>
                    <div class="col-md-8ths">
                        <div class="cilinder-count-item">
                            <div class="cilinder-count-title"><span class="num">8</span> sleutels</div>
                            <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?><?php if($keyColor == "purple"){echo "/img/sleutels-num/sleutel-8.jpg";}elseif($keyColor == "blue"){echo "/img/blue-sleutels/mc-color8.jpg";}else{echo "/img/sleutels/sleutel-8.png";};?>);"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 btn-container">
                <a id="more-sleutels" href="javascript:;" class="view-btn view-btn-inverse"><span>Meer dan 8 sleutels extra?</span></a>
                <input id="sleutels-num" type="text" value="0" style="display: none;" />
            </div>
            <div class="col-md-12 btn-container">
                <a href="#" class="offers-select view-btn view-btn-shadow">Doorgaan met bestellen</a>
            </div>
        </div>
    </div>
</div>
<div class="offers-block block-align-center">
    <div class="container">
        <div id="select-offers" class="block-padding">
            <div class="page-head">Je hebt je bestelling bijna afgerond</div>
            <span class="lead">Kies vanuit welke serie je de cilinders geleverd wil hebben.</span>
        </div>
        <div class="offer-item-table row no-gutters">
            <div class="ot-inner">
                <div class="ot-left">
                    <div class="oi-block"></div>
                    <?php
                    $aLabels = array();
                    $advantages = get_field("plus_en_minpunten", $id);
                    $advantages = array_keys($advantages);
                    if($advantages) {
                        while ( have_rows( "plus_en_minpunten", $id) ) {
                            the_row();
                            foreach($advantages as $advantage) {
                                $subField = get_sub_field_object( $advantage );
                                $aLabels[$advantage] = $subField["label"];
                                ?>
                                <div class="oi-block">
                                    <div class="offer-position op-label"><?= $subField["label"] ?></div>
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
                    <div class="col-md-10 col-sm-12 col-xs-12">
                        <div class="offer-item selected">
                            <div class="offer-item-inner">
                                <div class="oi-block">
                                    <div id="po-<?php the_field("cilinder") ?>" class="offer-prices" style="display: none;">
                                        <?
                                        $pId = intval(get_field("cilinder"));
                                        $pVar = get_product_addons($pId);
                                        $pKeyTypes = $pVar[5];
                                        $pSizes = $pVar[3];
                                        $pMaterials = $pVar[2];
                                        $pExtra1 = $pVar[0];
                                        $pExtra2 = $pVar[1];
                                        $pOuterSide = $pVar[6] ?? null;
                                        $pInnerSide = $pVar[7] ?? null;
                                        $product = wc_get_product($pId);
                                        $productImage = $product->get_image($size = 'shop_thumbnail');
                                        $regularPrice = $product->get_regular_price();
                                        $addonsPrice = 0;
                                        $additional_price = 0;
                                        foreach($pVar as $k=>$v)
                                        {
                                            $dVal = $defaultOptions ? $defaultOptions[substr($v["field-name"],strlen((string)$pId."-"),-2)] : "";
                                            if($dVal && $dVal != "default") {
                                                foreach($v["options"] as $option) {
                                                    if(trim($option["label"]) == trim($dVal)) {
                                                        $addonsPrice += floatval($option["price"]);
                                                        break;
                                                    }
                                                }
                                            } else {
                                                $addonsPrice += floatval($v["options"][0]["price"]);
                                            }
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
                                        $mainProduct = $product;
                                        $product = new WC_Product(intval(get_field("key")));
                                        $pKeyPrice = $product->get_regular_price();
                                        ?>
                                        <div class="key-price"><?php echo get_product_addon_price_for_display_custom($pKeyPrice)?></div>
                                        <?php if(get_field("additional_product") > 0) { ?>
                                            <?php
                                            $additional_product = new WC_Product(get_field("additional_product"));
                                            $additional_price = $additional_product->get_regular_price();
                                            ?>
                                            <div class="additional-product"><?php echo $additional_product->get_id(); ?></div>
                                            <div class="additional-price"><?php echo get_product_addon_price_for_display_custom($additional_price); ?></div>
                                        <?php } ?>
                                    </div>
                                    <h2><?php the_field("brand") ?><?php if(isset($additional_product)) { ?> + <?php echo $additional_product->get_name(); ?><?php } ?></h2>
                                    <div class="img-wrapper">
                                        <?php echo $productImage; ?>
                                    </div>
                                    <div class="special-offer-wrapper">
										<span class="special-offer">
											<span>€</span><span id="price-<?php the_field("cilinder") ?>"><?=sprintf("%01.2f", get_product_addon_price_for_display_custom(($regularPrice + $addonsPrice) * $productCnt + $additional_price))?></span>
										</span>
                                        <div class="btw"><?php if($excl_btw){ ?>excl.<?php } else { ?>incl.<?php } ?> BTW</div>
                                    </div>
                                    <div class="offer-info">
                                        <span class="cilinder-num"><?php echo $productCnt; ?></span> cilinders<br/>
                                        <span class="sleutel-num"><?php echo calcFreeKeysCnt($productCnt); ?></span> sleutels
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
                                            <meta itemprop="price" content="<?=sprintf("%01.2f", get_product_addon_price_for_display_custom(($regularPrice + $addonsPrice) * $productCnt + $additional_price))?>" />
                                        </div>
                                        <?php if(get_field("brand")) { ?>
                                            <div itemprop="brand" itemtype="https://schema.org/Brand" itemscope>
                                                <meta itemprop="name" content="<?php the_field("brand"); ?>" />
                                            </div>
                                        <?php } ?>
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
                                            <input class="<?=substr($pOuterSide["field-name"], strpos($pOuterSide["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($pOuterSide["field-name"]); ?>" value="<?php echo sanitize_title($pOuterSide["options"][0]["label"]). '-1'; ?>" />
                                            <input class="<?=substr($pInnerSide["field-name"], strpos($pInnerSide["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($pInnerSide["field-name"]); ?>" value="<?php echo sanitize_title($pInnerSide["options"][0]["label"]). '-1'; ?>" />
                                            <input type="hidden" name="quantity" value="1" />
                                            <input type="hidden" name="add-to-cart" value="<?=$pId?>">
                                        </form>
                                    </div>
                                    <button class="make-order view-btn view-btn-shadow offer-btn" data-id="<?=$pId?>" data-key-id="<?php the_field("key") ?>">Nu bestellen</button>
                                </div>
                            </div>
                            <?php
                            if(get_field("advies", $pId)) {
                                ?>
                                <div class="advies"></div>
                                <?php
                            }
                            ?>
                        </div>
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
                    <div class="cilinder-count-item<?=($ind==0?" active":"")?>" onclick="javascript:;">
                        <div class="cilinder-count-title" data-value="<?=sanitize_title($option["label"])?>"><?=$option["label"]?></div>
                        <div class="cilinder-count-img" style="background-image: url(<?=($img = wp_get_attachment_image_src($option["image"], null)) ? $img[0] : ''?>);"></div>
                    </div>
                <?php } ?>
            </div>
            <a href="javascript:;" class="key-type-select view-btn view-btn-inverse"><span>Bevestigen</span></a>
        </div>
    </div>
</div>

<?php get_footer(); ?>
