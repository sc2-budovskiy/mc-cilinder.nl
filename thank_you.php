<?php /* Template Name: Thank You */ ?>

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
            $order_key = isset($_GET["key"]) ? sanitize_text_field($_GET["key"]) : '';
            $order_id = isset($_GET["order"]) ? intval($_GET["order"]) : 0;

            if ($order_key && $order_id) {
                $id = wc_get_order_id_by_order_key($order_key);
                if ($id && $id == $order_id) {
                    $order = wc_get_order($order_id);
                    if ($order) {
                        wc_get_template("checkout/thankyou.php", array("order" => $order));
                    } else {
                        echo '<p class="woocommerce-notice woocommerce-notice--error">Bestelling niet gevonden.</p>';
                    }
                } else {
                    echo '<p class="woocommerce-notice woocommerce-notice--error">Ongeldige bestelgegevens.</p>';
                }
            } else {
                echo '<p class="woocommerce-notice woocommerce-notice--error">Geen bestelgegevens beschikbaar. Ga naar uw <a href="/mijn-account/">account</a> om uw bestellingen te bekijken.</p>';
            }
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
