<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.techzim.co.zw/
 * @since      1.0.0
 *
 * @package    Techzim_Airtime
 * @subpackage Techzim_Airtime/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Techzim_Airtime
 * @subpackage Techzim_Airtime/admin
 * @author     Techzim <marketplace@techzim.co.zw>
 */
class Techzim_Airtime_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $techzim_airtime    The ID of this plugin.
	 */
	private $techzim_airtime;

	/**
	 * The version of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $techzim_airtime       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $techzim_airtime, $version ) {

		$this->techzim_airtime = $techzim_airtime;
		$this->version         = $version;

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-techzim-airtime-admin-settings.php';

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Techzim_Airtime_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Techzim_Airtime_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->techzim_airtime, plugin_dir_url( __FILE__ ) . 'css/techzim-airtime-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Techzim_Airtime_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Techzim_Airtime_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->techzim_airtime, plugin_dir_url( __FILE__ ) . 'js/techzim-airtime-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Update NetOne recharge method (pinless or pinful)
	 * Triggered by a scheduled job every 1 hour and on plugin activation
	 *
	 * @since        2.1.5
	 */
	public static function update_netone_recharge_method() {
		$transaction_source_url = home_url();
		$request_url = 'https://europe-west2-techzim-airtime-system.cloudfunctions.net/check_netone_recharge_method';
		if(strpos($transaction_source_url, 'localhost') || strpos($transaction_source_url, 'testing.techzim')){
			$transaction_source_url = 'https://testing.techzim.market';
			$request_url = 'https://europe-west2-test-techzim-airtime-system.cloudfunctions.net/check_netone_recharge_method';
		}

		$data = array (
			"transaction_source_url" => $transaction_source_url
		);
		
		try {
			$curl = curl_init($request_url);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$recharge_method_response = curl_exec($curl);
			curl_close($curl);
			$recharge_method_response = json_decode($recharge_method_response);

		} catch(Exception $e) {
			error_log("Failed to check NetOne recharge method.".$e->getMessage(), 0);
			return '';
		}
		$success = $recharge_method_response->success;
		$use_netone_pinless = $recharge_method_response->use_netone_pinless;

		$use_netone_pinless_text = 'true';
		if ($use_netone_pinless == false) {
			$use_netone_pinless_text = 'false';
		}

		update_option( 'techzim-airtime-use-netone-pinless', $use_netone_pinless_text, null );
		return '';
	}

	/**
	 * Updates airtime web order notice on order received page.
	 * scheduled task running twice daily.
	 * @since 2.3.0
	 */
	public static function update_airtime_notice() {
		try {
			$url = 'https://europe-west2-techzim-airtime-system.cloudfunctions.net/get_airtime_web_notice';
			$transaction_source_url = home_url();

			$body = array(
				'transaction_source_url'=> $transaction_source_url
			);
	
			$args = array(
				'body' =>json_encode($body),
				'timeout' => '5',
				'redirection' => '5',
				'httpversion' => '1.0',
				'blocking' => true,
				 'headers'   => array(
					'Content-Type' => 'application/json'
				),
			);
	
			$notice_data = wp_remote_post( $url, $args );
			$notice_data = (array) json_decode($notice_data['body']);
	
			$success = $notice_data['success'];
						
			if ($success == true || $success == 1) {
				$web_notice = $notice_data['airtime_web_notice'];
				update_option( 'techzim-airtime-order-received-notice', $web_notice );
			}
			return '';

		} catch(Exception $e) {
			error_log("Failed to get the airtime web notice".$e->getMessage(), 0);
			return '';
		}	
		
	}

}
