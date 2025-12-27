<?php /* Template Name: Test Cart */ ?>

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
			<?php wc_get_template("cart/new-cart.php") ?>
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
				<div class="add-info-title">Voor 17:00 uur besteld is de volgende dag in huis*</div>
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

<?php get_footer(); ?>
