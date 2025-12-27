<?php /* Template Name: Test Products */ ?>

<?php get_header();?>

<?php
//get theme options
$options = get_option( 'theme_settings' ); ?>
<div class="container-fluid hidden-xs">
    <div class="row slider-container" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/slide.jpg);">
        <div class="col-md-offset-6 col-md-6 col-sm-12">
            <div class="slider-text">
                <div class="page-head"><?php the_field("banner_title") ?></div>
                <span class="lead">Dé manier om zelf uw thuis veiliger te maken.</span>
                <div class="special-offer">Al vanaf <span>€ <?php if(get_field("banner_price")){ echo get_field("banner_price"); }else{ echo $options["min_price"]; } ?></span></div>
                <a href="#" class="view-btn view-btn-shadow cilinder-select">Direct bestellen</a>
            </div>
        </div>
    </div>
</div>
<div class="breadcrumb-block">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo home_url(); ?>">Home</a></li>
            <li class="active">M&C Deurcilinders kiezen</li>
        </ol>
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
<div class="goods-options">
    <div class="container">
        <div class="row no-gutters">
            <div class="goods-options-title">M&C Deurcilinders voldoen aan de strengste eisen</div>
            <div class="goods-options-text">M&C Condor is beveiligd tegen boren, openpikken, kerntrekken, de slagmethode en de impressietechniek.</div>
            <div class="goods-options-list clearfix">
                <div class="goods-options-list-item">
                    <img src="<?php bloginfo('template_directory'); ?>/img/options/pick-resistant.png" alt="lockpick beveiliging" title="" />
                    <span class="option-name">Beveiligd tegen openpikken</span>
                </div><div class="goods-options-list-item">
                    <img src="<?php bloginfo('template_directory'); ?>/img/options/anti-snap.png" alt="Breek beveiliging" title="" />
                    <span class="option-name">Breek - beveiliging<br/><br/></span>
                </div><div class="goods-options-list-item">
                    <img src="<?php bloginfo('template_directory'); ?>/img/options/anti-bump.png" alt="Anti-klop" title="" />
                    <span class="option-name">Klop - beveiliging<br/><br/></span>
                </div><div class="goods-options-list-item">
                    <img src="<?php bloginfo('template_directory'); ?>/img/options/anti-pull.png" alt="trekbeveiliging" title="" />
                    <span class="option-name">Kerntrek- beveiliging<br/><br/></span>
                </div><div class="goods-options-list-item">
                    <img src="<?php bloginfo('template_directory'); ?>/img/options/drill-resistant.png" alt="boorbeveiliging" title="" />
                    <span class="option-name">Beveiligd tegen boren</span>
                </div><div class="goods-options-list-item">
                    <img src="<?php bloginfo('template_directory'); ?>/img/options/master-key-system.png" alt="sluitplan" title="" />
                    <span class="option-name">Geschikt voor alle sluitplannen</span>
                </div><div class="goods-options-list-item">
                    <img src="<?php bloginfo('template_directory'); ?>/img/options/warranty.png" alt="" title="" />
                    <span class="option-name">5 jaar garantie<br/><br/></span>
                </div>
            </div>
            <a href="#" class="cilinder-select view-btn view-btn-arrow"><span>Cilinders bestellen</span></a>
        </div>
    </div>
</div>
<div class="articles-block">
    <div class="container">
        <div class="row no-gutters">
			<?php
			$video = get_posts( array('numberposts' => 3, 'category' => 33) );
			foreach($video as $post)
			{
				?>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <a class="article-name"><?=$post->post_title?></a>
					<?=$post->post_content?>
                </div>
				<?php
			}
			?>
        </div>
        <div class="view-catalog">
            <a href="#" class="cilinder-select view-btn view-btn-shadow view-btn-arrow"><span>Aantal cilinders kiezen</span></a>
        </div>
    </div>
</div>
<div class="config-title-block block-align-center inverse-color">
    <div class="container">
        <div class="block-padding">
            <div class="page-head">Stel je bestelling samen</div>
            <span class="lead">Kies de cilinders die je wil bestellen om je sloten te vervangen voor dé beveiligingsoplossing in sloten!</span>
            <span class="cilinder-select arrow-down"></span>
        </div>
    </div>
</div>
<div class="config-block block-align-center">
    <div class="container">
        <div id="select-cilinder" class="block-padding">
            <div class="config-name">Kies het aantal cilinders dat je nodig hebt</div>
            <span class="lead">Kies hier het aantal cilinders dat je nodig hebt om je sloten te vervangen.</span>
        </div>
        <div class="cilinder-step-one cilinder-count clearfix">
            <div class="cilinder-count-item active">
                <div class="cilinder-count-title"><span class="num">1</span> cilinder</div>
                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-1.jpg);"></div>
            </div>
            <div class="cilinder-count-item">
                <div class="cilinder-count-title"><span class="num">2</span> cilinder</div>
                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-2.jpg);"></div>
            </div>
            <div class="cilinder-count-item">
                <div class="cilinder-count-title"><span class="num">3</span> cilinder</div>
                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-3.jpg);"></div>
            </div>
            <div class="cilinder-count-item">
                <div class="cilinder-count-title"><span class="num">4</span> cilinder</div>
                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-4.jpg);"></div>
            </div>
            <div class="cilinder-count-item">
                <div class="cilinder-count-title"><span class="num">5</span> cilinder</div>
                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-5.jpg);"></div>
            </div>
            <div class="cilinder-count-item">
                <div class="cilinder-count-title"><span class="num">6</span> cilinder</div>
                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-6.jpg);"></div>
            </div>
            <div class="cilinder-count-item">
                <div class="cilinder-count-title"><span class="num">7</span> cilinder</div>
                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-7.jpg);"></div>
            </div>
            <div class="cilinder-count-item">
                <div class="cilinder-count-title"><span class="num">8</span> cilinder</div>
                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-8.jpg);"></div>
            </div>
        </div>
        <div class="btn-container">
            <a id="more-cilinders" href="javascript:;" class="view-btn view-btn-inverse"><span>Meer dan 8 cilinders nodig?</span></a>
            <input id="cilinders-num" class="product-page" type="text" value="1" style="display: none;" />
        </div>
        <div class="btn-container">
            <a href="#" class="params-select view-btn view-btn-shadow view-btn-arrow"><span>Doorgaan met bestellen</span></a>
        </div>
        <div class="sep"></div>
        <div id="select-params" class="block-padding">
            <div class="config-name">Kies je optie per cilinder</div>
            <span class="lead">Maak je cilinders helemaal naar wens per slot.</span>
        </div>
        <div class="cilinder-config-block">
			<?php
			$id = 251;
			$var = get_product_addons($id);
			$sizes = $var[3];
			$materials = $var[2];
			$extra1 = $var[0];
			$extra2 = $var[1];
			$keyTypes = $var[5];
			$product = wc_get_product($id);
			?>
            <div class="cilinder-config-options clearfix">
                <div class="cilinder-count-item active">
                    <div class="cilinder-count-title">Cilinder <span class="num">1</span></div>
                    <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/cilinders/cilinder-1.jpg);" data-folder="<?php bloginfo('template_directory'); ?>/img/cilinder-types/"></div>
                </div>
                <div class="cilinder-params clearfix">
                    <div class="param-item param-1">
                        <select>
                            <option value="<?=$sizes["options"][0]["label"]?>" data-value="<?=sanitize_title($sizes["options"][0]["label"]). '-1';?>">Kies je maat</option>
							<?php
							foreach ($sizes["options"] as $ind=>$option)
							{
								?>
                                <option value="<?=$option["label"]?>" data-value="<?=sanitize_title($option["label"]). '-'. ($ind + 1);?>"><?=$option["label"]?></option>
								<?php
							}
							?>
                        </select>
                        <div class="check-param" data-fancybox data-src="#options-window">Hoe maten bepalen?</div>
                        <div class="param-value" data-value="<?=sanitize_title($sizes["options"][0]["label"]). '-1';?>" data-field="<?=substr($sizes["field-name"], strpos($sizes["field-name"],"-"))?>"><?=$sizes["options"][0]["label"]?></div>
                    </div>
                    <div class="param-item param-2">
                        <div class="change-param-value" data-fancybox data-src="#extra-select-1">Kies een extra knop korte kant</div>
                        <div class="check-param" data-fancybox data-src="#knop-pushknop-info">Hoe werkt een knop?</div>
                        <div class="param-value" data-value="<?=sanitize_title($extra1["options"][0]["label"])?>" data-field="<?=substr($extra1["field-name"], strpos($extra1["field-name"],"-"))?>"><?=$extra1["options"][0]["label"]?></div>
                    </div>
                    <div class="param-item param-3">
                        <div class="change-param-value" data-fancybox data-src="#extra2-select-1">Kies een extra knop lange kant</div>
                        <div class="check-param" data-fancybox data-src="#knop-pushknop-info">Hoe werkt een knop?</div>
                        <div class="param-value" data-value="<?=sanitize_title($extra2["options"][0]["label"])?>" data-field="<?=substr($extra2["field-name"], strpos($extra2["field-name"],"-"))?>"><?=$extra2["options"][0]["label"]?></div>
                    </div>
                    <div class="param-item param-4">
                        <div class="change-param-value" data-fancybox data-src="#materials-select-1">Kies de uitvoering</div>
                        <div class="param-value" data-value="<?=sanitize_title($materials["options"][0]["label"])?>" data-field="<?=substr($materials["field-name"], strpos($materials["field-name"],"-"))?>"><?=$materials["options"][0]["label"]?></div>
                    </div>
                    <div class="param-item product-item-price"></div>
                    <div style="display:none;" id="materials-select-1" class="main materials-options popup-container">
                        <div class="block-align-center">
                            <div class="config-name">Kies de uitvoering</div>
                            <span class="lead">Kies als uitvoering</span>
                            <div class="options-list cilinder-count clearfix">
								<?php foreach($materials["options"] as $ind=>$option){ ?>
                                    <div class="cilinder-count-item<?=($ind==0?" active":"")?>" onclick="javascript:;">
                                        <div class="cilinder-count-title" data-value="<?=sanitize_title($option["label"])?>"><?=$option["label"]?></div>
                                        <div class="cilinder-count-img" style="background-image: url(<?=wp_get_attachment_image_src($option["image"], null)[0]?>);"></div>
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
                                    </div>
								<?php } ?>
                            </div>
                            <a href="javascript:;" class="extra-select view-btn view-btn-inverse"><span>Bevestigen</span></a>
                        </div>
                    </div>
                    <div style="display:none;" id="extra2-select-1" class="main extra2-options popup-container">
                        <div class="block-align-center">
                            <div class="config-name">Kies een extra knop voor de lange kant</div>
                            <span class="lead">Kies als extra optie voor een knop of pushknop</span>
                            <div class="options-list cilinder-count clearfix">
								<?php foreach($extra2["options"] as $ind=>$option){ ?>
                                    <div class="cilinder-count-item<?=($ind==0?" active":"")?>" onclick="javascript:;">
                                        <div class="cilinder-count-title" data-value="<?=sanitize_title($option["label"])?>"><?=$option["label"]?></div>
                                        <div class="cilinder-count-img" style="background-image: url(<?=wp_get_attachment_image_src($option["image"], null)[0]?>);"></div>
                                    </div>
								<?php } ?>
                            </div>
                            <a href="javascript:;" class="extra2-select view-btn view-btn-inverse"><span>Bevestigen</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-container">
            <a href="#" class="keys-select view-btn view-btn-shadow view-btn-arrow"><span>Doorgaan met bestellen</span></a>
        </div>
        <div class="sep"></div>
        <div id="select-keys" class="block-padding">
            <div class="config-name">Kies het aantal extra sleutels</div>
            <span class="lead">Bij uw keuze van <span class="cilinder-num">1</span> <span>cilinders</span> worden er standaard <span class="sleutel-num-standard">3</span> <span>sleutels</span> meegeleverd.<br/>
                De prijs voor een extra sleutel is € <span class="key-item-price">xx.xx</span><br/>
                Wilt u direct extra sleutels bij uw cilinder set bestellen:
            </span>
        </div>
        <div class="cilinder-step-three cilinder-count clearfix">
            <div class="cilinder-count-item">
                <div class="cilinder-count-title"><span class="num">1</span> sleutel</div>
                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/sleutels/sleutel-1.png);"></div>
            </div>
            <div class="cilinder-count-item">
                <div class="cilinder-count-title"><span class="num">2</span> sleutels</div>
                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/sleutels/sleutel-2.png);"></div>
            </div>
            <div class="cilinder-count-item">
                <div class="cilinder-count-title"><span class="num">3</span> sleutels</div>
                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/sleutels/sleutel-3.png);"></div>
            </div>
            <div class="cilinder-count-item">
                <div class="cilinder-count-title"><span class="num">4</span> sleutels</div>
                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/sleutels/sleutel-4.png);"></div>
            </div>
            <div class="cilinder-count-item">
                <div class="cilinder-count-title"><span class="num">5</span> sleutels</div>
                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/sleutels/sleutel-5.png);"></div>
            </div>
            <div class="cilinder-count-item">
                <div class="cilinder-count-title"><span class="num">6</span> sleutels</div>
                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/sleutels/sleutel-6.png);"></div>
            </div>
            <div class="cilinder-count-item">
                <div class="cilinder-count-title"><span class="num">7</span> sleutels</div>
                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/sleutels/sleutel-7.png);"></div>
            </div>
            <div class="cilinder-count-item">
                <div class="cilinder-count-title"><span class="num">8</span> sleutels</div>
                <div class="cilinder-count-img" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/sleutels/sleutel-8.png);"></div>
            </div>
        </div>
        <div class="btn-container">
            <a id="more-sleutels" href="javascript:;" class="view-btn view-btn-inverse"><span>Meer dan 8 sleutels extra?</span></a>
            <input id="sleutels-num" type="text" value="0" style="display: none;" />
        </div>
        <div class="btn-container">
            <a href="#" class="offers-select view-btn view-btn-shadow view-btn-arrow"><span>Doorgaan met bestellen</span></a>
        </div>
    </div>
</div>
<div class="add-info-block">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="add-info-img">
                    <img src="<?php bloginfo('template_directory'); ?>/img/info/clock.png" alt="klok" title="" />
                </div>
                <div class="add-info-title">Voor <?php echo $options["delivery_time"]; ?> uur besteld is de volgende dag geleverd*</div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="add-info-img">
                    <img src="<?php bloginfo('template_directory'); ?>/img/info/delivery.png" alt="verzending" title="" />
                </div>
                <div class="add-info-title">Altijd gratis verzenden<br/>in Nederland en België</div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="add-info-img">
                    <img src="<?php bloginfo('template_directory'); ?>/img/info/calendar.png" alt="kalender" title="" />
                </div>
                <div class="add-info-title">Eenvoudig en gratis retour,<br/>30 dagen bedenktijd</div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="add-info-img">
                    <img src="<?php bloginfo('template_directory'); ?>/img/info/phone.png" alt="telefoon" title="" />
                </div>
                <div class="add-info-title">Gratis support<br/>voor en na uw aankoop</div>
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
	    <?php
	    $spId = 6519;
	    $sp = wc_get_product($spId);
	    $spPrice = $sp->get_regular_price();
	    ?>
        <div class="add-servicepen" data-id="<?=$spId?>" data-price="<?php echo get_product_addon_price_for_display($spPrice)?>"></div>
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
                <div class="oi-block"></div>
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
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="offer-item offer-item-left selected">
                        <div class="offer-item-inner">
                            <div class="oi-block">
                                <div id="po-879" class="offer-prices" style="display: none;">
									<?
									$pId = 879;
									$pVar = get_product_addons($pId);
									$pKeyTypes = $pVar[5];
									$pSizes = $pVar[3];
									$pMaterials = $pVar[2];
									$pExtra1 = $pVar[0];
									$pExtra2 = $pVar[1];
									$product = wc_get_product($pId);
									$productImage = $product->get_image($size = 'shop_thumbnail');
									$regularPrice = $product->get_regular_price();
									foreach($pVar as $k=>$v)
									{
										?>
                                        <div class="<?=$v["field-name"]?>">
											<?
											foreach($v["options"] as $option)
											{
												?>
                                                <div data-val="<?=$option["label"]?>"><?php echo get_product_addon_price_for_display($option["price"])?></div>
												<?
											}
											?>
                                        </div>
										<?
									}
									?>
                                    <div class="product-price"><?=get_product_addon_price_for_display($product->get_regular_price())?></div>
									<?php
									$product = new WC_Product(926);
									$pKeyPrice = $product->get_regular_price();
									?>
                                    <div class="key-price"><?php echo get_product_addon_price_for_display($pKeyPrice)?></div>
                                </div>
                                <h2>M&C Color plus</h2>
								<?php echo $productImage; ?><br/>
                                <span class="special-offer">
	                            <span>€</span><span id="price-879"><?=sprintf("%01.2f", get_product_addon_price_for_display($regularPrice + $pSizes["options"][0]["price"] + $pExtra1["options"][0]["price"] + $pExtra2["options"][0]["price"] + $pMaterials["options"][0]["price"]))?></span>
	                        </span>
                                <div class="btw">incl. BTW</div>
                                <div class="short-sep"></div>
                                <div class="offer-info">
                                    <span class="cilinder-num">1</span> cilinders<br/>
                                    <span class="sleutel-num">3</span> sleutels
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
                                        <input type="hidden" name="quantity" value="1" />
                                        <input type="hidden" name="add-to-cart" value="<?=$pId?>">
                                    </form>
                                </div>
                                <button class="make-order view-btn view-btn-inverse offer-btn" data-id="<?=$pId?>" data-key-id="926">Nu bestellen</button>
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

                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="offer-item">
                        <div class="offer-item-inner">
                            <div class="oi-block">
                                <div id="po-1516" class="offer-prices" style="display: none;">
									<?
									$pId = 1516;
									$pVar = get_product_addons($pId);
									$pKeyTypes = $pVar[5];
									$pSizes = $pVar[3];
									$pMaterials = $pVar[2];
									$pExtra1 = $pVar[0];
									$pExtra2 = $pVar[1];
									$product = wc_get_product($pId);
									$productImage = $product->get_image($size = 'shop_thumbnail');
									$regularPrice = $product->get_regular_price();
									foreach($pVar as $k=>$v)
									{
										?>
                                        <div class="<?=$v["field-name"]?>">
											<?
											foreach($v["options"] as $option)
											{
												?>
                                                <div data-val="<?=$option["label"]?>"><?php echo get_product_addon_price_for_display($option["price"])?></div>
												<?
											}
											?>
                                        </div>
										<?
									}
									?>
                                    <div class="product-price"><?=get_product_addon_price_for_display($product->get_regular_price())?></div>
									<?php
									$product = new WC_Product(1517);
									$pKeyPrice = $product->get_regular_price();
									?>
                                    <div class="key-price"><?php echo get_product_addon_price_for_display($pKeyPrice)?></div>
                                </div>
                                <h2>M&C Matrix</h2>
								<?php echo $productImage; ?><br/>
                                <span class="special-offer">
	                            <span>€</span><span id="price-1516"><?=sprintf("%01.2f", get_product_addon_price_for_display($regularPrice + $pSizes["options"][0]["price"] + $pExtra1["options"][0]["price"] + $pExtra2["options"][0]["price"] + $pMaterials["options"][0]["price"]))?></span>
	                        </span>
                                <div class="btw">incl. BTW</div>
                                <div class="short-sep"></div>
                                <div class="offer-info">
                                    <span class="cilinder-num">1</span> cilinders<br/>
                                    <span class="sleutel-num">3</span> sleutels<br/>
                                    <span data-fancybox data-src="#key-type-block" class="choose-key-type">Kies hier color of metalen sleutels</span>
                                    <input class="key-type" type="hidden" name="addon-<?php echo sanitize_title($pKeyTypes["field-name"]); ?>[]" value="" />
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
                                        <input type="hidden" name="quantity" value="1" />
                                        <input type="hidden" name="add-to-cart" value="<?=$pId?>">
                                    </form>
                                </div>
                                <button class="make-order view-btn view-btn-inverse offer-btn" data-id="<?=$pId?>" data-key-id="1517">Nu bestellen</button>
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

                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="offer-item">
                        <div class="offer-item-inner">
                            <div class="oi-block">
                                <div id="po-6407" class="offer-prices" style="display: none;">
			                        <?
			                        $pId = 6407;
			                        $pVar = get_product_addons($pId);
			                        $pKeyTypes = $pVar[5];
			                        $pSizes = $pVar[3];
			                        $pMaterials = $pVar[2];
			                        $pExtra1 = $pVar[0];
			                        $pExtra2 = $pVar[1];
			                        $product = wc_get_product($pId);
			                        $productImage = $product->get_image($size = 'shop_thumbnail');
			                        $regularPrice = $product->get_regular_price();
			                        foreach($pVar as $k=>$v)
			                        {
				                        ?>
                                        <div class="<?=$v["field-name"]?>">
					                        <?
					                        foreach($v["options"] as $option)
					                        {
						                        ?>
                                                <div data-val="<?=$option["label"]?>"><?php echo get_product_addon_price_for_display($option["price"])?></div>
						                        <?
					                        }
					                        ?>
                                        </div>
				                        <?
			                        }
			                        ?>
                                    <div class="product-price"><?=get_product_addon_price_for_display($product->get_regular_price())?></div>
			                        <?php
			                        $product = new WC_Product(6409);
			                        $pKeyPrice = $product->get_regular_price();
			                        ?>
                                    <div class="key-price"><?php echo get_product_addon_price_for_display($pKeyPrice)?></div>
                                </div>
                                <h2>M&C Move</h2>
		                        <?php echo $productImage; ?><br/>
                                <span class="special-offer">
	                            <span>€</span><span id="price-6407"><?=sprintf("%01.2f", get_product_addon_price_for_display($regularPrice + $pSizes["options"][0]["price"] + $pExtra1["options"][0]["price"] + $pExtra2["options"][0]["price"] + $pMaterials["options"][0]["price"]))?></span>
	                        </span>
                                <div class="btw">incl. BTW</div>
                                <div class="short-sep"></div>
                                <div class="offer-info">
                                    <span class="cilinder-num">1</span> cilinders<br/>
                                    <span class="sleutel-num">3</span> sleutels<br/>
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
                                        <input type="hidden" name="quantity" value="1" />
                                        <input type="hidden" name="add-to-cart" value="<?=$pId?>">
                                    </form>
                                </div>
                                <button class="make-order view-btn view-btn-inverse offer-btn" data-id="<?=$pId?>" data-key-id="6409">Nu bestellen</button>
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

                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="offer-item offer-item-right">
                        <div class="offer-item-inner">
                            <div class="oi-block">
                                <div id="po-251" class="offer-prices" style="display: none;">
									<?php
									$product = wc_get_product($id);
									$productImage = $product->get_image($size = 'shop_thumbnail');
									$regularPrice = $product->get_regular_price();
									foreach($var as $k=>$v)
									{
										?>
                                        <div class="<?=$v["field-name"]?>">
											<?
											foreach($v["options"] as $option)
											{
												?>
                                                <div data-val="<?=$option["label"]?>"><?php echo get_product_addon_price_for_display($option["price"])?></div>
												<?
											}
											?>
                                        </div>
										<?
									}
									?>
                                    <div class="product-price"><?=get_product_addon_price_for_display($product->get_regular_price())?></div>
									<?php
									$product = new WC_Product(927);
									$keyPrice = $product->get_regular_price();
									?>
                                    <div class="key-price"><?php echo get_product_addon_price_for_display($keyPrice)?></div>
                                </div>
                                <h2>M&C Condor</h2>
								<?php echo $productImage; ?><br/>
                                <span class="special-offer">
	                            <span>€</span><span id="price-251"><?=sprintf("%01.2f", get_product_addon_price_for_display($regularPrice + $sizes["options"][0]["price"] + $extra1["options"][0]["price"] + $extra2["options"][0]["price"] + $materials["options"][0]["price"]))?></span>
	                        </span>
                                <div class="btw">incl. BTW</div>
                                <div class="short-sep"></div>
                                <div class="offer-info">
                                    <span class="cilinder-num">1</span> cilinders<br/>
                                    <span class="sleutel-num">3</span> sleutels
                                </div>
                            </div>
							<?php
							$advantages = get_field("plus_en_minpunten", $id);
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
                                        <input class="<?=substr($materials["field-name"], strpos($materials["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($materials["field-name"]); ?>[]" value="<?php echo sanitize_title($materials["options"][0]["label"]); ?>" />
                                        <input class="<?=substr($extra1["field-name"], strpos($extra1["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($extra1["field-name"]); ?>[]" value="<?php echo sanitize_title($extra1["options"][0]["label"]); ?>" />
                                        <input class="<?=substr($extra2["field-name"], strpos($extra2["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($extra2["field-name"]); ?>[]" value="<?php echo sanitize_title($extra2["options"][0]["label"]); ?>" />
                                        <input class="<?=substr($sizes["field-name"], strpos($sizes["field-name"],"-"))?>" type="hidden" name="addon-<?php echo sanitize_title($sizes["field-name"]); ?>" value="<?php echo sanitize_title($sizes["options"][0]["label"]). '-1'; ?>" />
                                        <input type="hidden" name="quantity" value="1" />
                                        <input type="hidden" name="add-to-cart" value="<?=$id?>">
                                    </form>
                                </div>
                                <button class="make-order view-btn view-btn-inverse offer-btn" data-id="<?=$id?>" data-key-id="927">Nu bestellen</button>
                            </div>
                        </div>
						<?php
						if(get_field("advies", $id)) {
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
    <div class="kiyoh-reviews">
        <div class="container">
			<?php echo do_shortcode("[kiyoh-klantenvertellen]"); ?>
        </div>
    </div>
    <div class="container">
		<?php
		$faqItems = get_posts( array('numberposts' => 18, 'category' => 48) );
		if($faqItems){
			?>
            <div class="faq-block row no-gutters">
                <div class="page-head">Veel gestelde vragen:</div>
                <span class="lead"></span>
                <div class="row no-gutters">
					<?php
					$ind = 0;
					foreach ($faqItems as $item) {
						$ind++;
						?>
                        <div class="faq-item col-md-4 col-sm-6 col-xs-12">
                            <div class="fi-title"><?php echo $item->post_title; ?></div>
                            <p><?php the_field("preview_text", $item->ID); ?></p>
                            <a class="fi-detail" data-fancybox data-type="ajax" data-src="<?php echo get_permalink( $item->ID ); ?> .main" href="javascript:;">Lees verder...</a>
                        </div>
						<?php if ( $ind % 2 == 0 ) { ?>
                            <div class="fi-clear visible-sm"></div>
						<?php } else if ( $ind % 3 == 0 ) { ?>
                            <div class="fi-clear hidden-sm"></div>
							<?php
						}
					}
					?>
                </div>
            </div>
		<?php } ?>
        <div class="sep"></div>
        <div class="block-padding">
			<?php the_content();?>
        </div>
    </div>
</div>

<div style="display: none">
    <div id="options-window" class="main">
        <div class="block-align-center">
            <div class="config-name">Selecteer de juiste maat</div>
            <span class="lead"></span>
            <div class="knop-info-block adv-info-block ib-no-padding">
                <div class="row no-gutters">
                    <div class="col-sm-6 col-xs-12 ki-text ki-text-left">
                        Een cilinder in een slot heeft altijd twee zijdes. Een cilinder heeft een schroefgat waarmee de cilinder vast in het slot komt te zitten. Meet de gewenste afstand altijd vanuit het hart van dit schroefgat. Bij het selecteren van de maat selecteert u altijd eerst de kortste maat.<br/>
                        <br/>
                        Als voorbeeld nemen we een cilinder met een afstand van 30mm naar de buitenzijde en 45mm naar de binnenzijde. U heeft een 45/30 75mm cilinder. Bij ons kiest u dan voor een 32/47 80mm cilinder.<br/>
                        <br/>
                        Door de vele beschikbare maten is er altijd een cilinder die past op alle gangbare sloten. Ondanks alle ingebouwde veiligheidsmaatregelen van de cilinder kies je bij voorkeur aan de buitenzijde niet voor een cilinder die meer dan 3 mm uitsteekt voorbij het aanwezige deurbeslag.
                    </div>
                    <div class="col-sm-6 col-xs-12 ki-img">
                        <img src="<?php bloginfo('template_directory'); ?>/img/parameters.png" alt="" title="" />
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-sm-6 col-xs-12 ki-img">
                        <iframe src="https://www.youtube.com/embed/s5Mi9Uhv43Q?ecver=1" width="100%" height="175" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
                    </div>
                    <div class="col-sm-6 col-xs-12 ki-text ki-text-right" style="font-size:20px;">
                        Bekijk hier het filmpje
                        hoe de cilinder
                        opgemeten wordt.
                    </div>
                </div>
            </div>
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
                        <div class="cilinder-count-img" style="background-image: url(<?=wp_get_attachment_image_src($option["image"], null)[0]?>);"></div>
                    </div>
				<?php } ?>
            </div>
            <a href="javascript:;" class="key-type-select view-btn view-btn-inverse"><span>Bevestigen</span></a>
        </div>
    </div>
</div>

<?php get_footer(); ?>
