<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

?>
<div class="woocommerce-shipping-fields">
    <?php if ( true === WC()->cart->needs_shipping_address() ) : ?>

        <?php
        if ( empty( $_POST ) ) {

            $ship_to_different_address = get_option( 'woocommerce_ship_to_destination' ) === 'shipping' ? 1 : 0;
            $ship_to_different_address = apply_filters( 'woocommerce_ship_to_different_address_checked', $ship_to_different_address );

        } else {

            $ship_to_different_address = $checkout->get_value( 'ship_to_different_address' );

        }
        ?>

        <input id="payment_address_shipping_address" type="checkbox" value="1" <?php checked( $ship_to_different_address === 1 ? 0 : 1, 1 ); ?> />
        <label for="payment_address_shipping_address">Mijn factuur- en afleveradres zijn hetzelfde.</label>

        <div id="ship-to-different-address" style="display: none;">
            <input id="ship-to-different-address-checkbox" class="input-checkbox nm-custom-checkbox" <?php checked( $ship_to_different_address, 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" />
            <label for="ship-to-different-address-checkbox" class="checkbox nm-custom-checkbox-label"><?php _e( 'Ship to a different address?', 'woocommerce' ); ?></label>
        </div>

        <div class="shipping_address">

            <h3>Verzendgegevens</h3>

            <?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

            <div class="choose-client-type">
                <label class="nm-custom-radio-label"><input class="nm-custom-radio" type="radio" name="cc_type_shipping" value="user" checked="checked" /> <span>Particulier</span></label>
                <label class="nm-custom-radio-label"><input class="nm-custom-radio" type="radio" name="cc_type_shipping" value="company" /> <span>Zakelijk</span></label>
            </div>

            <?/*php foreach ( $checkout->checkout_fields['shipping'] as $key => $field ) : ?>

				<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

			<?php endforeach; */?>

            <?php
            $street = @explode(",", $checkout->get_value( 'shipping_address_1' ))[0];
            $houseNum = @explode(",", $checkout->get_value( 'shipping_address_1' ))[1];

            $fields = $checkout->get_checkout_fields( 'shipping' );

            foreach ( $fields as $key => $field ) {
                if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
                    $field['country'] = $checkout->get_value( $field['country_field'] );
                }
                if(($key == "shipping_address_1" && WC()->customer->get_shipping_country() == "NL") || $key == "shipping_address_2") {
                    $field["class"][] = "hidden-field";
                }

                if($key == "shipping_company") {
                    $field["class"][] = "hidden-field";
                }

                $label = strip_tags($field["label"]);
                if($field["required"])
                {
                    $label = "* " . $label;
                }
                $field["placeholder"] = $label;
                $field["label"] = "";
                woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );

            }
            ?>
            <?php /* <input type="text" class="input-text" name="shipping_first_name" id="shipping_first_name" autocomplete="given-name" value="<?=$checkout->get_value( 'shipping_first_name' )?>" placeholder="* Naam" />
            <input type="text" class="input-text" name="shipping_last_name" id="shipping_last_name" autocomplete="family-name" value="<?=$checkout->get_value( 'shipping_last_name' )?>" placeholder="* Achternaam" />
            <input type="text" class="input-text" name="shipping_company" id="shipping_company" placeholder="Bedrijf" autocomplete="organization" value="<?=$checkout->get_value( 'shipping_company' )?>" />
            <div class="clearfix">
                <input class="postcode" type="text" class="input-text" name="shipping_postcode" id="shipping_postcode" placeholder="* Postcode" autocomplete="postal-code" value="<?=$checkout->get_value( 'shipping_postcode' )?>" />
                <input class="address-2 shipping-address-2" type="text" value="<?=$houseNum?>" placeholder="* Huisnr." />
            </div>
            <span class="postcode-after">Adres wordt automatisch ingevuld.</span>
            <input class="shipping-address-1" type="text" value="<?=$street?>" placeholder="* Straatnaam" />
            <input style="display: none;" type="text" class="input-text" name="shipping_address_1" id="shipping_address_1" placeholder="Street address" autocomplete="address-line1" value="<?=$checkout->get_value( 'shipping_address_1' )?>" />
            <input type="text" class="input-text" name="shipping_city" id="shipping_city" placeholder="* Plaats" autocomplete="address-level2" value="<?=$checkout->get_value( 'shipping_city' )?>" />
            <input type="email" class="input-text" name="shipping_email" id="shipping_email" placeholder="* E-mailadres" autocomplete="email" value="<?=$checkout->get_value( 'shipping_email' )?>" />
            <input type="tel" class="input-text" name="shipping_phone" id="shipping_phone" placeholder="* Telefoonnummer" autocomplete="tel" value="<?=$checkout->get_value( 'shipping_phone' )?>" />
            <span class="update_totals_on_change"><select name="shipping_country" id="shipping_country" autocomplete="country" class="country_to_state country_select" tabindex="-1" title="Country *">
                <option value="">Select country</option>
                    <?php
                    $countries = WC()->countries->get_allowed_countries();
                    foreach ( $countries as $ckey => $cvalue ) {
                        echo '<option value="' . esc_attr( $ckey ) . '" '. selected( $checkout->get_value( 'shipping_country' ), $ckey, false ) . '>'. __( $cvalue, 'woocommerce' ) .'</option>';
                    }
                    ?>
            </select><?php echo '<noscript><input type="submit" name="woocommerce_checkout_update_totals" value="' . esc_attr__( 'Update country', 'woocommerce' ) . '" /></noscript>';?>
            </span> */ ?>

            <?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

        </div>

    <?php endif; ?>

</div>
