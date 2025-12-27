<?php /* Template Name: Cart */ ?>

<?php get_header();?>

<div class="breadcrumb-block">
	<div class="container">
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li class="active">Winkelwagen</li>
		</ol>
	</div>
</div>
<div class="container">
	<div class="checkout-block">
		<h1>Winkelwagen</h1>
		<div class="checkout-form row no-gutters">
			<?php wc_get_template("cart/cart.php") ?>
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

<script type="text/javascript">
    window.smartlook||(function(d) {
    var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
    var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
    c.charset='utf-8';c.src='https://rec.smartlook.com/recorder.js';h.appendChild(c);
    })(document);
    smartlook('init', 'c8e79885924dc8fce18b299c7bafcec1c73cb58e');
</script>

<?php get_footer(); ?>
