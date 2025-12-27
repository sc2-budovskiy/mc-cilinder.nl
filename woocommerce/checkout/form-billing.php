<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/** @global WC_Checkout $checkout */

?>

<?/*<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h3><?php _e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h3>

	<?php else : ?>

		<h3><?php _e( 'Billing Details', 'woocommerce' ); ?></h3>

	<?php endif; ?>*/?>
<div class="woocommerce-billing-fields">
    <?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

    <div class="choose-client-type">
        <label class="nm-custom-radio-label"><input class="nm-custom-radio" type="radio" name="cc_type_billing" value="user" checked="checked" /> <span>Particulier</span></label>
        <label class="nm-custom-radio-label"><input class="nm-custom-radio" type="radio" name="cc_type_billing" value="company" /> <span>Zakelijk</span></label>
    </div>
    <?php
    $street = @explode(",", $checkout->get_value( 'billing_address_1' ))[0];
    $houseNum = @explode(",", $checkout->get_value( 'billing_address_1' ))[1];

    $fields = $checkout->get_checkout_fields( 'billing' );

    foreach ( $fields as $key => $field ) {
        if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
            $field['country'] = $checkout->get_value( $field['country_field'] );
        }
        if(($key == "billing_address_1" && WC()->customer->get_billing_country() == "NL") || $key == "billing_address_2") {
            $field["class"][] = "hidden-field";
        }

        if($key == "billing_company") {
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
    <?php /* <input type="text" class="input-text" name="billing_first_name" id="billing_first_name" autocomplete="given-name" value="<?=$checkout->get_value( 'billing_first_name' )?>" placeholder="* Naam" />
<input type="text" class="input-text" name="billing_last_name" id="billing_last_name" autocomplete="family-name" value="<?=$checkout->get_value( 'billing_last_name' )?>" placeholder="* Achternaam" />
<input type="text" class="input-text" name="billing_company" id="billing_company" placeholder="Bedrijf" autocomplete="organization" value="<?=$checkout->get_value( 'billing_company' )?>" />
<div class="clearfix">
    <input class="postcode input-text" type="text" name="billing_postcode" id="billing_postcode" placeholder="* Postcode" autocomplete="postal-code" value="<?=$checkout->get_value( 'billing_postcode' )?>" />
    <input class="address-2 billing-address-2" type="text" value="<?=$houseNum?>" placeholder="* Huisnr." />
</div>
<span class="postcode-after">Adres wordt automatisch ingevuld.</span>
<input class="billing-address-1" type="text" value="<?=$street?>" placeholder="* Straatnaam" />
<input style="display: none;" type="text" class="input-text" name="billing_address_1" id="billing_address_1" placeholder="Street address" autocomplete="address-line1" value="<?=$checkout->get_value( 'billing_address_1' )?>" />
<input type="text" class="input-text" name="billing_city" id="billing_city" placeholder="* Plaats" autocomplete="address-level2" value="<?=$checkout->get_value( 'billing_city' )?>" />
<input type="email" class="input-text" name="billing_email" id="billing_email" placeholder="* E-mailadres" autocomplete="email" value="<?=$checkout->get_value( 'billing_email' )?>" />
<input type="tel" class="input-text" name="billing_phone" id="billing_phone" placeholder="* Telefoonnummer" autocomplete="tel" value="<?=$checkout->get_value( 'billing_phone' )?>" />
<span class="update_totals_on_change"><select name="billing_country" id="billing_country" autocomplete="country" class="country_to_state country_select" tabindex="-1" title="Country *">
        <option value="">Select country</option>
		<?php
		$countries = WC()->countries->get_allowed_countries();
		foreach ( $countries as $ckey => $cvalue ) {
			echo '<option value="' . esc_attr( $ckey ) . '" '. selected( $checkout->get_value( 'billing_country' ), $ckey, false ) . '>'. __( $cvalue, 'woocommerce' ) .'</option>';
		}
		?>
    </select>
	<?php echo '<noscript><input type="submit" name="woocommerce_checkout_update_totals" value="' . esc_attr__( 'Update country', 'woocommerce' ) . '" /></noscript>';?>
    </span> */ ?>
    <?php do_action('woocommerce_after_checkout_billing_form', $checkout ); ?>
    <div class="deliverydate-container" style="display:none;">
        <?php do_action('show_deliverydate_field'); ?>
    </div>
    <?php if ( ! is_user_logged_in() && $checkout->enable_signup ) : ?>

        <?php if ( ! $checkout->is_registration_required() ) : ?>

            <p class="create-account">
                <input class="input-checkbox nm-custom-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true) ?> type="checkbox" name="createaccount" value="1" /> <label for="createaccount" class="checkbox nm-custom-checkbox-label"><?php _e( 'Create an account?', 'woocommerce' ); ?></label>
            </p>

        <?php endif; ?>

        <?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

        <?php if ( ! empty( $checkout->get_checkout_fields( 'account' ) ) ) : ?>

            <div class="create-account">

                <p><?php _e( 'Create an account by entering the information below. If you are a returning customer please login at the top of the page.', 'woocommerce' ); ?></p>

                <?php foreach ( $checkout->get_checkout_fields('account') as $key => $field ) : ?>

                    <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

                <?php endforeach; ?>

                <div class="clear"></div>

            </div>

        <?php endif; ?>

        <?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>

    <?php endif; ?>
</div>
