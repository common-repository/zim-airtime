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
global $product;
?>

<amp-state id="tz_airtime_usd_zwl_rate" src="<?php echo esc_attr( home_url() ); ?>/wp-json/techzim-airtime/get_usd_zwl_rate"></amp-state>
<form class="tz-a-tw-relative tz-a-tw-flex tz-a-tw-flex-wrap tz-a-tw-justify-center lg:tz-a-tw-justify-between tz-a-tw-items-end tz-a-tw-max-w-full
<?php
	echo esc_attr( is_page( $post ) || $product ? ' tz-a-tw-w-56 ' : ' tz-a-tw-w-full ' );
	echo esc_attr( is_page( $post ) ? ' tz-a-tw-m-auto ' : '' );
?>
" id='tz-airtime-diaspora-simple-buying-form' onsubmit="return tz_airtime_diaspora_confirmation(this);" action-xhr="https://europe-west2-techzim-airtime-system.cloudfunctions.net/create_order" method="post">
	<input type="hidden" name="action" value="tz_airtime_handle_simple_buying_form">
	<input type="hidden" name="tz_airtime[nonce]" value="<?php echo esc_attr( wp_create_nonce( 'tz_airtime_simple_buying_form_nonce' ) ); ?>">
	<input type="hidden" name="tz_airtime[channel]" value="<?php echo esc_attr( $tz_vendor_name ); ?>">
	<input type="hidden" name="tz_airtime[transaction_source_url]" value="<?php echo esc_attr( home_url() ); ?>">
	<input type="hidden" name="tz_airtime[currency]" value="usd">
	<input type="hidden" id="tz-airtime-diaspora-payment-method" name="tz_airtime[payment_method]" value="paypal">

	<div class="tz-a-tw-form-container">
		<label class="tz-a-tw-w-full tz-a-tw-max-w-full" for="tz-airtime-diaspora-number-to-recharge">Number to recharge:</label>
		<input class="tz-a-tw-form-input" type="tel" id="tz-airtime-diaspora-number-to-recharge" name="tz_airtime[number_to_recharge]" title="NetOne/Telecel/Econet/Africom Number to recharge e.g 071x123456 or 08644123456">
	</div>

	<div class="tz-a-tw-form-container">
		<label class="tz-a-tw-w-full tz-a-tw-max-w-full" for="tz-airtime-diaspora-airtime-amount">Airtime amount (US$):</label>
		<input class="tz-a-tw-form-input" type="number" step="any" min="0" id="tz-airtime-diaspora-airtime-amount" name="tz_airtime[airtime_amount]" title="A number greater than 1 with max of 2 decimals." on="change:AMP.setState({ tz_airtime_state: { airtime_amount_zwl: (tz_airtime_usd_zwl_rate.usd_zwl_rate * event.value).toFixed(2) }})">
	</div>

	<div class="tz-a-tw-btn-container<?php echo esc_attr( is_page( $post ) ? '' : ' tz-a-tw-items-end' ); ?>">
		<button class="tz-a-tw-btn-orange" type="submit">Buy</button>
	</div>

	<div class="tz-a-tw-form-container tz-a-tw-h-10">
		<p id="tz-airtime-diaspora-airtime-amount-zwl" [text]="tz_airtime_state.airtime_amount_zwl > 0 ? ''Recipient will get ZW$' + tz_airtime_state.airtime_amount_zwl + ' airtime' : ''"></p>
	</div>

	<div class="tz-a-tw-form-response-container" style="color: red;" submit-success>
		<template type="amp-mustache">
		{{error_message}}
		</template>
	</div>
	<div class="tz-a-tw-form-response-container" style="color: red;" submit-error>
		<template type="amp-mustache">
		{{error_message}}
		</template>
	</div>
	<div class="tz-a-tw-loader"></div>
</form>
<?php
if ( home_url() . '/send-zimbabwe-airtime-from-diaspora/' === get_the_permalink() ) {
	?>
	<p class="tz-airtime-diaspora-query-form">If anything goes wrong, chat with us using the chat feature at the bottom right of this screen.</p>
	<?php
}
