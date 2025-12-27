<?php /* Template Name: Thank You Test */ ?>

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
            <?php
            /*$id = wc_get_order_id_by_order_key($_GET["key"]);
            $rId = intval($_GET["order"]);
            if($id == $rId) {
	            $order = wc_get_order( $rId );
	            wc_get_template( "checkout/thankyou.php", array( "order" => $order ) );
            }*/
            $order = wc_get_order( 13825 );
                wc_get_template( "checkout/thankyou.php", array( "order" => $order ) );
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
