<?php
/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     8.8.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$formatted_destination    = isset( $formatted_destination ) ? $formatted_destination : WC()->countries->get_formatted_address( $package['destination'], ', ' );
$has_calculated_shipping  = ! empty( $has_calculated_shipping );
$show_shipping_calculator = ! empty( $show_shipping_calculator );
$calculator_text          = '';
?>

<?php
//get theme options
$options = get_option( 'theme_settings' ); ?>
<div id="shipping_method" class="delivery-list">
    <?php if ( 1 <= count( $available_methods ) ) : ?>
        <div class="delivery-title">Kies uw bezorgmoment <?php if($options["delivery_info"]) { ?><span class="op-info-icon" data-fancybox data-src="#info_delivery">i</span><?php } ?></div>
    <?php if($options["delivery_info"]) { ?>
        <div id="info_delivery" class="main adv-popup-info" style="display: none;">
            <?php echo $options["delivery_info"]; ?>
        </div>
    <?php } ?>
    <?php $ind = 0; ?>
    <?php foreach ( $available_methods as $method ) : ?>
        <div class="delivery-list-item">
            <?php
            if(!isset($_COOKIE["excl_btw"])) {
                if ( WC()->cart->tax_display_cart == 'excl' ) {
                    $price = wc_price( $method->cost );
                } else {
                    $price = wc_price( $method->cost + $method->get_shipping_tax() );
                }
            } else {
                if($_COOKIE["excl_btw"]) {
                    $price = wc_price( $method->cost );
                } else {
                    $price = wc_price( $method->cost + $method->get_shipping_tax() );
                }
            }
            printf( '<label for="shipping_method_%1$d_%2$s" class="nm-custom-radio-label"><input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method nm-custom-radio" %4$s />
								<span><span class="text">%5$s <span class="price">%6$s</span></span></span></label>',
                $index, sanitize_title( $method->id ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ), wc_cart_totals_shipping_method_label( $method ), $price );
            if(sanitize_title($method->id) == "service_point_shipping_method9") {
                echo ' <span class="op-info-icon" data-fancybox data-src="#info_' . sanitize_title( $method->id ) . '">i</span>';
            }
            do_action( 'woocommerce_after_shipping_rate', $method, $index );
            ?>
            <div id="info_<?php echo sanitize_title($method->id); ?>" class="main adv-popup-info" style="display: none;">
                <div class="config-name shipping-label">
                    <?php
                    echo wc_cart_totals_shipping_method_label( $method );
                    ?>
                </div>
                <?php
                if(sanitize_title($method->id) == "flat_rate23"){
                    ?>
                    Besteld u voor <?php echo $options["delivery_time"]; ?> uur dan wordt uw bestelling morgenavond (op werkdagen) tussen 18:00 en 20:00 uur bij u bezorgd. Kiest u voor deze optie op vrijdag dan wordt uw bestelling automatisch maandagavond bezorgd. Wilt u dat uw bestelling op zaterdag wordt bezorgd kies dan voor “standaard verzending”.<br/>
                    Deze optie is alleen mogelijk bij een nieuwe bestelling van M&C Condor of M&C Matrix cilinders en sleutels. Een bestelling met M&C Color pro cilinders of een nabestelling van cilinders wordt een dag later in de avond bezorgd.
                    <?php
                }
                elseif(sanitize_title($method->id) == "flat_rate24"){
                    ?>
                    Uw bestelling wordt de volgende dag (op maandag t/m zaterdag) overdag bij u aangeboden door Postnl of DHL.
                    <?php
                }
                elseif(sanitize_title($method->id) == "service_point_shipping_method9"){
                    ?>
                    U kunt een servicepunt van PostNL selecteren waar uw bestelling naartoe verstuurd wordt. U krijgt een melding hoe laat uw bestelling klaar ligt bij het geselecteerde ophaalpunt van PostNL.
                    <?php
                }
                ?>
            </div>
        </div>
    <?php
    $dMethods = array("flat_rate23",  "flat_rate24", "flat_rate25");
    if(in_array(sanitize_title($method->id), $dMethods) && $ind == count($available_methods) - 2 && count($available_methods) > 2 && $chosen_method != "service_point_shipping_method:9")
    {
    ?>
        <script>
            if(window.jQuery)
            {
                try {
                    var args = jQuery('#e_deliverydate_0').datepicker('option', 'all');
                    jQuery( ".cf_datepicker" ).attr( 'readonly' , 'readonly' ).datepicker(args);
                    var date = jQuery("#custom_deliverydate").val().split('-');
                    if(date.length >= 3)
                    {
                        jQuery( ".cf_datepicker" ).datepicker("setDate", new Date(date[2], date[1] - 1, date[0]) );
                    }
                }
                catch(error){}
            }
        </script>
        <div class="delivery-list-item">
                            <span class="text">
                                <span class="date-later">Kies een later moment</span>
                                <br/>
                                <input class="cf_datepicker" type="text" name="custom_deliverydate" value="" />
                                <input id="custom_deliverydate" type="hidden" value="<?php echo @WC()->session->get( 'custom_deliverydate' ); ?>" />
                                <input type="hidden" name="user_deliverydate" value="<?php echo @WC()->session->get( 'user_deliverydate' ); ?>" />
                            </span>
        </div>
        <?php
    }
        $ind++;
        ?>
    <?php endforeach; ?>

        <?/*php elseif ( 1 === count( $available_methods ) ) :  ?>
		<?php
		$method = current( $available_methods );
		printf( '%3$s <input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d" value="%2$s" class="shipping_method" />', $index, esc_attr( $method->id ), wc_cart_totals_shipping_method_label( $method ) );
		do_action( 'woocommerce_after_shipping_rate', $method, $index );
		*/?>
    <?php
    elseif ( ! $has_calculated_shipping || ! $formatted_destination ) :
        if ( is_cart() && 'no' === get_option( 'woocommerce_enable_shipping_calc' ) ) {
            echo wp_kses_post( apply_filters( 'woocommerce_shipping_not_enabled_on_cart_html', __( 'Shipping costs are calculated during checkout.', 'woocommerce' ) ) );
        } else {
            echo wp_kses_post( apply_filters( 'woocommerce_shipping_may_be_available_html', __( 'Enter your address to view shipping options.', 'woocommerce' ) ) );
        }
    elseif ( ! is_cart() ) :
        echo wp_kses_post( apply_filters( 'woocommerce_no_shipping_available_html', __( 'There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woocommerce' ) ) );
    else :
        // Translators: $s shipping destination.
        echo wp_kses_post( apply_filters( 'woocommerce_cart_no_shipping_available_html', sprintf( esc_html__( 'No shipping options were found for %s.', 'woocommerce' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' ) ) );
        $calculator_text = esc_html__( 'Enter a different address', 'woocommerce' );
    endif;
    ?>

    <?php if ( $show_package_details ) : ?>
        <?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html( $package_details ) . '</small></p>'; ?>
    <?php endif; ?>

    <?php if ( $show_shipping_calculator ) : ?>
        <?php woocommerce_shipping_calculator( $calculator_text ); ?>
    <?php endif; ?>
</div>
