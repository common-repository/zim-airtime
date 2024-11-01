/**
 * Submits the airtime buying form using AJAX.
 *
 * @param {object} form The airtime buying form object
 */
function tz_airtime_confirmation(form) {
	
	var channel                = form["tz_airtime[channel]"].value.trim();
	var transaction_source_url = form["tz_airtime[transaction_source_url]"].value.trim();
	var airtime_amount         = form["tz_airtime[airtime_amount]"].value.trim();
	var number_to_recharge     = form["tz_airtime[number_to_recharge]"].value.trim();
    var mobile_money_number    = form["tz_airtime[mobile_money_number]"].value.trim();
    var use_netone_pinless    = form["tz_airtime[use_netone_pinless]"].value.trim();

	var answer = confirm("You are buying $" + airtime_amount + " for " + number_to_recharge + ", click OK and check your EcoCash phone to confirm.");

	if ( !answer ) {
		return false;
	}

	var loader = document.getElementsByClassName("tz-a-tw-loader");

	loader[0].style = "display: block";

	var btn_submit = document.getElementsByClassName("tz-a-tw-btn-orange");

	btn_submit[0].disabled = true;

	var request_data = { 
		order_data: {
			airtime_amount,
			channel,
			mobile_money_number,
			number_to_recharge,
		},
		transaction_source_url,
    }
    
	jQuery.ajax({
		type: "POST",
		url: "https://europe-west2-techzim-airtime-system.cloudfunctions.net/create_order",
		data: request_data,
		success: function(response_json){
			// console.log(response_json);
			if (response_json.success) {
                if (use_netone_pinless === 'false') {
                    setTimeout(() => {
                        window.location.href = response_json.order_received_url;
                    }, 15000);
                } else {
                    window.location.href = response_json.order_received_url;
                }
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
				console.log(`Err: ${xhr.responseText}`);
				alert('Something went wrong. Please try again.');
			}

			loader[0].style = "display: none";
			btn_submit[0].disabled = false;
		}
	});

	return false;

}
