<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://www.techzim.co.zw/
 * @since      1.0.0
 *
 * @package    Techzim_Airtime
 * @subpackage Techzim_Airtime/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Techzim_Airtime
 * @subpackage Techzim_Airtime/includes
 * @author     Techzim <marketplace@techzim.co.zw>
 */
class Techzim_Airtime_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		if ( wp_next_scheduled( 'check_netone_recharge_method' ) ) {
			wp_clear_scheduled_hook( 'check_netone_recharge_method' );
		}
		delete_option( 'techzim-airtime-system-use-netone-pinless' );

		// Delete the usd-zwl-rate.
		delete_option( 'techzim-airtime-usd-zwl-rate' );

		// Delete the mobile money payment methods data table.
		global $wpdb;
		$table_name = $wpdb->prefix . 'tz_airtime_mobile_money_payment_methods';
		$sql = 'DROP TABLE IF EXISTS ' . $table_name;
		$wpdb->query( $sql );

		// stop the scheduled chron jobs.
		if ( wp_next_scheduled( 'tz_airtime_mobile_money_payment_methods_update' ) ) {
			wp_clear_scheduled_hook( 'tz_airtime_mobile_money_payment_methods_update' );
		}

		if ( wp_next_scheduled( 'tz_airtime_usd_zwl_rate_update' ) ) {
			wp_clear_scheduled_hook( 'tz_airtime_usd_zwl_rate_update' );
		}
	}
}
