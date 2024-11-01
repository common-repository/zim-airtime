(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 $( window ).ready(function() {
		var airtime_amount = document.getElementById('tz-airtime-diaspora-airtime-amount');

		airtime_amount.addEventListener('change', function(event) {
			var form = document.getElementById('tz-airtime-diaspora-simple-buying-form');
			var transaction_source_url = form["tz_airtime[transaction_source_url]"].value.trim();
			var airtime_amount = event.target.value.trim();

			airtime_amount = airtime_amount === '' ? 0 : airtime_amount;

			if (!RegExp('^(\\d+|\\d+\\.\\d+)$', 'gm').test(airtime_amount)) {
				return alert('Please enter numbers only for amount.');
			}

			var airtime_amount_zwl_element = document.getElementById('tz-airtime-diaspora-airtime-amount-zwl');
			airtime_amount_zwl_element.innerText = 'Calculating ZW$ airtime amount...';

			jQuery.ajax({
				headers: {
                    'Content-Type': 'application/json'
                },
				type: "GET",
				url: transaction_source_url + "/wp-json/techzim-airtime/get_usd_zwl_rate",
				success: function(response_json){
					if (response_json.success) {
						var airtime_amount_zwl = (response_json.usd_zwl_rate * airtime_amount).toFixed(2);

						airtime_amount_zwl_element.innerText = 'Recipient will get ZW$' + airtime_amount_zwl + ' airtime';
					} else if (!response_json.success) {
						alert(response_json.error_message);
					}
				},
				error: function(xhr){
					if ( xhr.responseJSON && xhr.responseJSON.success === false ) {
						alert( xhr.responseJSON.error_message );
					} else {
						alert('Something went wrong. Please try again. Error: ' + xhr.responseText);
					}
				}
			});
		});
	 });

})( jQuery );

function tz_airtime_diaspora_confirmation(form) {
	var currency               = form["tz_airtime[currency]"].value.trim();
	var payment_method         = form["tz_airtime[payment_method]"].value.trim();
	var channel                = form["tz_airtime[channel]"].value.trim();
	var transaction_source_url = form["tz_airtime[transaction_source_url]"].value.trim();
	var airtime_amount         = form["tz_airtime[airtime_amount]"].value.trim();
	var number_to_recharge     = form["tz_airtime[number_to_recharge]"].value.trim();

	jQuery.ajax({
		headers: {
			'Content-Type': 'application/json'
		},
		type: "GET",
		url: transaction_source_url + "/wp-json/techzim-airtime/get_usd_zwl_rate",
		success: function(response_json){
			if (response_json.success) {
				var airtime_amount_zwl = (response_json.usd_zwl_rate * airtime_amount).toFixed(2);

				var airtime_amount_element_zwl = document.getElementById('tz-airtime-diaspora-airtime-amount-zwl');
				airtime_amount_element_zwl.innerText = 'Recipient will get ZW$' + airtime_amount_zwl + ' airtime';

				var request_data = { 
					order_data: {
						airtime_amount,
						channel,
						currency,
						payment_method,
						number_to_recharge,
					},
					transaction_source_url,
				};
				
				var loader = document.getElementsByClassName("tz-a-tw-loader");
			
				loader[0].style = "display: block";
			
				var btn_submit = document.getElementsByClassName("tz-a-tw-btn-orange");
			
				btn_submit[0].disabled = true;
			
				jQuery.ajax({
					type: "POST",
					url: "https://europe-west2-techzim-airtime-system.cloudfunctions.net/create_order",
					data: request_data,
					success: function(response_json){
						if (response_json.success) {
							console.log(response_json);
							window.location.href = response_json.order_checkout_url;
						} else if (!response_json.success) {
							alert(response_json.error_message);
							loader[0].style = "display: none";
							btn_submit[0].disabled = false;
						}
					},
					error: function(xhr){
						if ( xhr.responseJSON && xhr.responseJSON.success === false ) {
							alert( xhr.responseJSON.error_message );
						} else {
							alert('Something went wrong. Please try again. Error: ' + xhr.responseText);
						}
			
						loader[0].style = "display: none";
						btn_submit[0].disabled = false;
					}
				});
			} else if (!response_json.success) {
				alert(response_json.error_message);
			}
		},
		error: function(xhr){
			if ( xhr.responseJSON && xhr.responseJSON.success === false ) {
				alert( xhr.responseJSON.error_message );
			} else {
				alert('Something went wrong. Please try again. Error: ' + xhr.responseText);
			}
		}
	});

	return false;
}
