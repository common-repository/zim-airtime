<?php
/**
 * Fired during plugin activation
 *
 * @link       https://www.techzim.co.zw/
 * @since      1.0.0
 *
 * @package    Techzim_Airtime
 * @subpackage Techzim_Airtime/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Techzim_Airtime
 * @subpackage Techzim_Airtime/includes
 * @author     Techzim <marketplace@techzim.co.zw>
 */
class Techzim_Airtime_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		if ( get_page_by_path( 'airtime' ) === null ) {
			// Create Airtime Page since it doesn't exist.
			$post_id = wp_insert_post(
				array(
					'post_type'    => 'page',
					'post_title'   => 'NetOne, Telecel, Econet And Africom Airtime',
					'post_name'    => 'airtime',
					'post_content' => 'You have money in EcoCash and you want to buy airtime from any network?
					
					Enter the number you want to recharge, the amount and your EcoCash number then click ‘Buy’.
					
					Check your EcoCash phone to confirm the transaction by entering your PIN.
					
					The airtime is sent directly to the phone you are recharging.',
				)
			);

			if ( ! is_wp_error( $post_id ) && ! empty( $post_id ) ) {
				wp_publish_post( $post_id );
			}
		}

		if ( get_page_by_path( 'airtime-order-received' ) === null ) {
			// Create Airtime order received Page since it doesn't exist.
			$post_id = wp_insert_post(
				array(
					'post_type'    => 'page',
					'post_title'   => 'Airtime order received',
					'post_name'    => 'airtime-order-received',
				)
			);

			if ( ! is_wp_error( $post_id ) && ! empty( $post_id ) ) {
				wp_publish_post( $post_id );
			}
		}

		if ( get_page_by_path( 'airtime-query-received' ) === null ) {
			// Create Airtime query received Page since it doesn't exist.
			$post_id = wp_insert_post(
				array(
					'post_type'    => 'page',
					'post_title'   => 'Airtime query received',
					'post_name'    => 'airtime-query-received',
				)
			);

			if ( ! is_wp_error( $post_id ) && ! empty( $post_id ) ) {
				wp_publish_post( $post_id );
			}
		}

		if ( ! wp_next_scheduled( 'check_netone_recharge_method' ) ) {
			wp_schedule_event( time(), 'hourly', 'check_netone_recharge_method' );
		}

		Techzim_Airtime_Admin::update_netone_recharge_method();

		// ! Buying airtime from diaspora is currently only available on techzim.market
		// * the feature may be opened up to vendors at a later date.
		if ( home_url() === 'https://techzim.market' || home_url() === 'https://testing.techzim.market' ) {
			// ! Code after this is for buying airtime from diaspora.
			if ( get_page_by_path( 'send-zimbabwe-airtime-from-diaspora' ) === null ) {
				$post_id = wp_insert_post(
					array(
						'post_type'    => 'page',
						'post_title'   => 'Buy Zim airtime from the diaspora',
						'post_name'    => 'send-zimbabwe-airtime-from-diaspora',
						'post_content' => 'The easy way to send airtime to your loved ones in Zimbabwe.
						You pay using your Visa, Mastercard, other cards. In some countries you can even use mobile money!
						Airtime is credited directly to your loved one.
						
						When you enter the amount you wish to send in US$, you will see how much ZW$ airtime will be sent to your loved one.',
					)
				);

				if ( ! is_wp_error( $post_id ) && ! empty( $post_id ) ) {
					wp_publish_post( $post_id );
				}
			}

			if ( get_page_by_path( 'airtime-order-cancelled' ) === null ) {
				// Create Airtime order cancelled Page since it doesn't exist.
				$post_id = wp_insert_post(
					array(
						'post_type'    => 'page',
						'post_title'   => 'Airtime order cancelled',
						'post_name'    => 'airtime-order-cancelled',
					)
				);
	
				if ( ! is_wp_error( $post_id ) && ! empty( $post_id ) ) {
					wp_publish_post( $post_id );
				}
			}

			$url = 'https://europe-west2-techzim-airtime-system.cloudfunctions.net/get_exchange_rate';
			$body = array(
				'transaction_source_url' => home_url(),
				'currency'               => 'usd',
			);

			$args = array(
				'body'        => wp_json_encode( $body ),
				'timeout'     => '5',
				'redirection' => '5',
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => array(
					'Content-Type' => 'application/json',
				),
			);

			$response = wp_remote_post( $url, $args );
			$response = (array) json_decode( $response['body'] );

			if ( $response['success'] === true ) {
				$usd_zwl_rate = $response['usd_zwl_rate'];

				update_option( 'techzim-airtime-usd-zwl-rate', $usd_zwl_rate );
			} else {
				error_log( 'Failed to get USD/ZWL exchange rate on plugin activation. Error message: ' . $response['error_message'], 0 );
				wp_die( 'There has been an error getting the USD/ZWL exchange rate from airtime system. Plugin installation could not continue.' );
			}

			if ( ! wp_next_scheduled( 'tz_airtime_usd_zwl_rate_update' ) ) {
				wp_schedule_event( time(), 'hourly', 'tz_airtime_usd_zwl_rate_update' );
			}
		}

		if ( ! wp_next_scheduled( 'tz_airtime_update_airtime_order_received_notice' ) ) {
			wp_schedule_event( time(), 'twice_daily', 'tz_airtime_update_airtime_order_received_notice' );
		}

		Techzim_Airtime_Admin::update_airtime_notice();
	}
}
