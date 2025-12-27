<?php /* Template Name: Main */ ?>

<?php get_header();?>

<?php
$excl_btw = isset($_COOKIE["excl_btw"]) && $_COOKIE["excl_btw"] ? true : false;

//get theme options
$options = get_option( 'theme_settings' ); ?>

    <div class="main-top-slider header-slider">
        <div class="container-fluid item" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/slide.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-offset-6 col-lg-6 col-md-offset-5 col-md-7 col-sm-12 text-center">
                        <div class="slider-text">
                            <div class="st-logo"><img src="<?php bloginfo('template_directory'); ?>/img/mr_beveiliging.png" alt="" /><span>de leverancier van</span></div>
                            <div class="page-head"><?php if(get_field("banner_title")){ the_field("banner_title"); } else { ?><span>M&C</span> Cilinders<?php } ?></div>
                            <div class="lead">Dé manier om zelf uw thuis veiliger te maken.</div>
                            <div class="special-offer"><span>Al vanaf € <?php echo get_banner_price(); ?></span> <?php if($excl_btw){ ?>excl.<?php } else { ?>incl.<?php } ?> BTW verkrijgbaar</div>
                            <a href="<?php if(get_field("banner_link")) { echo get_field("banner_link"); } else { ?>/product-page/#bestellen<?php } ?>" class="btn view-btn">BESTEL NU</a>
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

    <div class="container-fluid">
        <div class="container">
            <div class="page-content row">
                <?php the_content();?>
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

    <div class="container-fluid advantage-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-5">
                    <div class="img-wrapper">
                        <?php $image1 = get_field('image_1'); ?>
                        <?php if($image1){ ?>
                            <img src="<?php echo esc_url($image1['url']); ?>" alt="<?php echo esc_attr($image1['alt']); ?>" title="" />
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-6 col-sm-7 col-xs-12">
                    <?php the_field("сilinders_pluspunten_1") ?>
                </div>
                <div class="col-xs-12">
                    <div class="divider-blue-line"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-7">
                    <?php the_field("сilinders_pluspunten_2") ?>
                </div>
                <div class="col-md-6 col-sm-5">
                    <div class="img-wrapper">
                        <?php $image2 = get_field('image_2'); ?>
                        <?php if($image2){ ?>
                            <img src="<?php echo esc_url($image2['url']); ?>" alt="<?php echo esc_attr($image2['alt']); ?>" title="" />
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid articles-block">
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

    <div class="container-fluid kiyoh-block">
        <div class="container">
            <div class="row">
                <div class="kiyoh-text col-lg-8 col-md-7 col-sm-6">
                    <?php the_field("extra_description", 875); ?>
                    <div class="btn-wrapper">
                        <a class="view-btn" href="/product-page">BESTEL NU</a>
                    </div>
                </div>
                <div class="col-xs-offset-2 col-xs-8 col-sm-offset-0 col-lg-4 col-md-5 col-sm-6 right-side">
                    <div class="main-image-block">
                        <div class="kv-rate-block">
                            <div class="kv-inner-block">
                                <!--<iframe border="0" frameborder="0" height="175" scrolling="no" src="https://kiyoh.nl/widget.php?company=4462&amp;border=0" width="210"></iframe>-->
                                <iframe frameborder="0"  scrolling="no" allowtransparency="true" src="https://www.kiyoh.com/retrieve-widget.html?color=white&button=true&lang=nl&tenantId=98&locationId=1045436" width="210" height="175"></iframe>
                            </div>
                        </div>
                        <img alt="Main Image" class="img-responsive" src="<?php bloginfo('template_directory'); ?>/img/cms_banner.png">
                    </div>
                    <div class="item-wrapper">
                        <h2>MR-Beveiliging<br>Kiyoh score</h2>
                        <p>We proberen er alles aan te doen om de klant tevreden te stellen. Zie hier onze onafhankelijke klantbeoordelingen. Wilt u ook een beoordeling achterlaten?</p>
                        <a href="https://www.kiyoh.nl/mr-beveiliging_nl/" target="_blank" class="view-btn">Bekijk al onze beoordelingen</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid direct-bestellen-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <?php the_post(); ?>
                    <div class="page-head"><?php if(get_field("banner_title")){ the_field("banner_title"); } else { ?><strong>M&C</strong> Deurcilinders<?php } ?></div>
                    <div class="lead">Dé manier om zelf uw thuis veiliger te maken, deze sloten zijn beveiligd tegen vele soorten inbraak!</div>
                    <div class="special-offer"><strong>Al vanaf € <?php echo get_banner_price(); ?></strong> <?php if($excl_btw){ ?>excl.<?php } else { ?>incl.<?php } ?> BTW verkrijgbaar</div>
                    <a href="/product-page/#bestellen" class="view-btn-inverse">BESTEL NU</a>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>