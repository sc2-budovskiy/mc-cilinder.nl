<?php /* Template Name: Checkout */ ?>

<?php get_header();?>

<div class="breadcrumb-block">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">Afrekenen</li>
        </ol>
    </div>
</div>
<div class="container">
    <div class="checkout-block">
        <h1>Afrekenen</h1>
        <div class="checkout-form row no-gutters">
	        <?php //wc_get_template("checkout/form-checkout.php") ?>
			<?php echo do_shortcode("[woocommerce_checkout]"); ?>
	        <?/*php the_content() */?>
        </div>
    </div>
</div>

<?php
//get theme options
$options = get_option( 'theme_settings' ); ?>
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

<?php get_footer(); ?>
