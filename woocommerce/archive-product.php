<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>
<?php
$excl_btw = isset($_COOKIE["excl_btw"]) && $_COOKIE["excl_btw"] ? true : false;
$term = get_queried_object();
?>
    <div class="main-top-slider header-slider">
        <div class="container-fluid item" style="background-image: url(<?php bloginfo('template_directory'); ?>/img/slide.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-offset-6 col-lg-6 col-md-offset-5 col-md-7 col-sm-12 text-center">
                        <div class="slider-text">
                            <div class="page-head"><?php the_field("banner_title", $term) ?></div>
                            <div class="lead">Dé manier om zelf uw thuis veiliger te maken.</div>
                            <div class="special-offer"><span>Al vanaf € <?php echo get_banner_price($term); ?></span> <?php if($excl_btw){ ?>excl.<?php } else { ?>incl.<?php } ?> BTW verkrijgbaar</div>
                            <?php /*<a href="/product-page/#bestellen" class="btn view-btn">BESTEL NU</a>*/ ?>
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
            <div class="page-content">
                <?php
                /**
                 * Hook: woocommerce_before_main_content.
                 *
                 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                 * @hooked woocommerce_breadcrumb - 20
                 * @hooked WC_Structured_Data::generate_website_data() - 30
                 */
                do_action( 'woocommerce_before_main_content' );

                ?>
                <?php
                /**
                 * Hook: woocommerce_shop_loop_header.
                 *
                 * @since 8.6.0
                 *
                 * @hooked woocommerce_product_taxonomy_archive_header - 10
                 */
                do_action( 'woocommerce_shop_loop_header' );
                ?>
                <?php
                if ( woocommerce_product_loop() ) {

                    /**
                     * Hook: woocommerce_before_shop_loop.
                     *
                     * @hooked woocommerce_output_all_notices - 10
                     * @hooked woocommerce_result_count - 20
                     * @hooked woocommerce_catalog_ordering - 30
                     */
                    do_action( 'woocommerce_before_shop_loop' );

                    woocommerce_product_loop_start();

                    if ( wc_get_loop_prop( 'total' ) ) {
                        while ( have_posts() ) {
                            the_post();

                            /**
                             * Hook: woocommerce_shop_loop.
                             */
                            do_action( 'woocommerce_shop_loop' );

                            wc_get_template_part( 'content', 'product' );
                        }
                    }

                    woocommerce_product_loop_end();

                    /**
                     * Hook: woocommerce_after_shop_loop.
                     *
                     * @hooked woocommerce_pagination - 10
                     */
                    do_action( 'woocommerce_after_shop_loop' );
                } else {
                    /**
                     * Hook: woocommerce_no_products_found.
                     *
                     * @hooked wc_no_products_found - 10
                     */
                    do_action( 'woocommerce_no_products_found' );
                }

                /**
                 * Hook: woocommerce_after_main_content.
                 *
                 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                 */
                do_action( 'woocommerce_after_main_content' );

                /**
                 * Hook: woocommerce_sidebar.
                 *
                 * @hooked woocommerce_get_sidebar - 10
                 */
                //do_action( 'woocommerce_sidebar' );
                ?>
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
<?php if(get_field("seo_text", $term)) { ?>
    <div class="container content-row">
        <?php echo get_field("seo_text", $term); ?>
    </div>
<?php } ?>
<?php
get_footer( 'shop' );
