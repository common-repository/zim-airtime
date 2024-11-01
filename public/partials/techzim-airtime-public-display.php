<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 * Currently contains the airtime buying form that is displayed at the end of posts or on /airtime
 *
 * @link       https://www.techzim.co.zw/
 * @since      1.0.0
 *
 * @package    Techzim_Airtime
 * @subpackage Techzim_Airtime/public/partials
 */

$settings       = get_option( $this->techzim_airtime . '-settings' );
$tz_vendor_name = $settings['vendor_name'];
$use_netone_pinless = get_option( $this->techzim_airtime . '-use-netone-pinless' );
global $product;
?>
<form class="tz-a-tw-buying-form tz-a-tw-w-full
<?php
	echo esc_attr( is_page( $post ) || $product ? ' sm:tz-a-tw-w-56 ' : '' );
	echo esc_attr( is_page( $post ) ? ' tz-a-tw-m-auto ' : '' );
?>
" onsubmit="return tz_airtime_confirmation(this);" action-xhr="https://europe-west2-techzim-airtime-system.cloudfunctions.net/create_order" method="post">
	<input type="hidden" name="action" value="tz_airtime_handle_simple_buying_form">
	<input type="hidden" name="tz_airtime[nonce]" value="<?php echo esc_attr( wp_create_nonce( 'tz_airtime_simple_buying_form_nonce' ) ); ?>">
	<input type="hidden" name="tz_airtime[channel]" value="<?php echo esc_attr( $tz_vendor_name ); ?>">
	<input type="hidden" name="tz_airtime[transaction_source_url]" value="<?php echo esc_attr( home_url() ); ?>">
	<input type="hidden" name="tz_airtime[use_netone_pinless]" id="tz-airtime-use-netone-pinless" value="<?php echo esc_attr($use_netone_pinless) ?>">

	<div class="tz-a-tw-form-container">
		<label class="tz-a-tw-max-w-full tz-a-tw-w-full" for="tz-airtime-number-to-recharge">Number to recharge:</label>
		<input class="tz-a-tw-form-input" type="tel" id="tz-airtime-number-to-recharge" name="tz_airtime[number_to_recharge]" title="NetOne/Telecel/Econet/Africom Number to recharge e.g 071x123456 or 08644123456">
	</div>

	<div class="tz-a-tw-form-container">
		<label class="tz-a-tw-max-w-full tz-a-tw-w-full" for="tz-airtime-airtime-amount">Airtime amount ($):</label>
		<input class="tz-a-tw-form-input" type="number" step="any" min="0" id="tz-airtime-airtime-amount" name="tz_airtime[airtime_amount]" title="A number greater than 1 with max of 2 decimals.">
	</div>

	<div class="tz-a-tw-form-container">
		<label class="tz-a-tw-max-w-full tz-a-tw-w-full" for="tz-airtime-mobile-money-number"><span style="font-weight:900;"><span style="color:#105baa;">Eco</span><span style="color:#ff0000;">Cash</span></span> number:</label>
		<input class="tz-a-tw-form-input" type="tel" id="tz-airtime-mobile-money-number" name="tz_airtime[mobile_money_number]" title="EcoCash Number e.g 07xx123456">
	</div>

	<div class="tz-a-tw-btn-container<?php echo esc_attr( is_page( $post ) ? '' : ' tz-a-tw-items-end' ); ?>">
		<button class="tz-a-tw-btn-orange" type="submit">Buy</button>
	</div>

	<?php if ($use_netone_pinless == 'false') { ?>
		<div class="tz-a-tw-text-red-600" id="tz-airtime-use-netone-pinless-message">
			If buying NetOne, please note we are sending you PINs to recharge manually. The recharge PINs will be on the page that loads after clicking 'Buy'
		</div>
	<?php } ?>

	<div class="tz-a-tw-form-response-container" submit-success>
		<template type="amp-mustache">
		{{error_message}}
		</template>
	</div>
	<div class="tz-a-tw-form-response-container" submit-error>
		<template type="amp-mustache">
		{{error_message}}
		</template>
	</div>
	<div class="tz-a-tw-loader"></div>
</form>
<?php
if ( home_url() . '/airtime/' === get_the_permalink() || $product ) {
	?>
		<p class="tz-airtime-query-form">If anything goes wrong, chat with us using the chat feature at the bottom right of this screen.</p>
	<?php
}
