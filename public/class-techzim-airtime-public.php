<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.techzim.co.zw/
 * @since      1.0.0
 *
 * @package    Techzim_Airtime
 * @subpackage Techzim_Airtime/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Techzim_Airtime
 * @subpackage Techzim_Airtime/public
 * @author     Techzim <marketplace@techzim.co.zw>
 */
class Techzim_Airtime_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $techzim_airtime    The ID of this plugin.
	 */
	private $techzim_airtime;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $techzim_airtime       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $techzim_airtime, $version ) {

		$this->techzim_airtime = $techzim_airtime;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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
		wp_enqueue_style( $this->techzim_airtime, plugin_dir_url( __FILE__ ) . 'css/techzim-airtime-public1615299931705.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

	}

	/**
	 * Adds a form for airtime buying to the end of a post
	 *
	 * @since 1.0.0
	 * @param array $content The content of the post.
	 */
	public function add_below_post_airtime_buying( $content ) {
		$settings = get_option( $this->techzim_airtime . '-settings' );

		$show_below_post_form = ( isset( $settings['show_below_post_form'] ) ? $settings['show_below_post_form'] : '' );

		if ( ! $this->is_rest() && 1 === $show_below_post_form && 'post' === get_post_type() ) {

			ob_start();
			include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/techzim-airtime-public-display.php';
			$below_post_form = ob_get_clean();

			wp_enqueue_script( $this->techzim_airtime, plugin_dir_url( __FILE__ ) . 'js/techzim-airtime-public202101252257.js', array( 'jquery' ), $this->version, false );

			return $content . '<section class="tz-airtime-container"><hr><h3><span>Quick NetOne, Econet, And Telecel Airtime Recharge</h3>' . $below_post_form . '</section>';
		}

		return $content;
	}

	/**
	 * Adds a form for airtime buying on a specific page
	 *
	 * @since 1.0.0
	 * @param array $content The content of the page.
	 */
	public function add_airtime_buying_form_to_page( $content ) {

		if ( ! $this->is_rest() && 'page' === get_post_type() ) {
			if ( home_url() . '/airtime/' !== get_the_permalink() ) {
				return $content;
			}

			ob_start();
			include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/techzim-airtime-public-display.php';
			$airtime_buying_form = ob_get_clean();

			wp_enqueue_script( $this->techzim_airtime, plugin_dir_url( __FILE__ ) . 'js/techzim-airtime-public202101252257.js', array( 'jquery' ), $this->version, false );

			return $content . '<section class="tz-airtime-container">' . $airtime_buying_form . '</section>';
		}

		return $content;
	}

	/**
	 * Adds a form for airtime buying on a specific page
	 *
	 * @since 1.0.0
	 * @param array $content The content of the page.
	 */
	public function add_diaspora_airtime_buying_form_to_page( $content ) {

		if ( ! $this->is_rest() && 'page' === get_post_type() ) {
			if ( ( home_url() !== 'https://techzim.market'
				&& home_url() !== 'https://testing.techzim.market' )
				|| home_url() . '/send-zimbabwe-airtime-from-diaspora/' !== get_the_permalink()
			) {
				return $content;
			}

			ob_start();
			include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/techzim-airtime-diaspora-public-display.php';
			$airtime_buying_form = ob_get_clean();

			wp_enqueue_script( $this->techzim_airtime . '-diaspora', plugin_dir_url( __FILE__ ) . 'js/techzim-airtime-diaspora-public202102221630.js', array( 'jquery' ), $this->version, false );

			return $content . '<section class="tz-airtime-container">' . $airtime_buying_form . '</section>';
		}

		return $content;
	}

	/**
	 * Overrides the WooCommerce buying flow with a custom simple buying form
	 *
	 * @since 1.0.0
	 */
	public function add_simple_buying_form() {
		global $product;
		$product_sku = $product->get_sku();

		if ( ! $this->is_rest() && Techzim_Airtime::check_if_product_is_airtime( $product_sku ) ) {
			wp_enqueue_script( $this->techzim_airtime, plugin_dir_url( __FILE__ ) . 'js/techzim-airtime-public202101252257.js', array( 'jquery' ), $this->version, false );

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/techzim-airtime-public-display.php';
		}
	}

	/**
	 * Add custom CSS to AMP if using AMPFORWP plugin
	 */
	public function add_custom_amp_css() {
		$css = file_get_contents( plugin_dir_path( dirname( __FILE__ ) ) . 'public/css/techzim-airtime-public1615299931705.css' );
		echo esc_html( $css );
	}

	/**
	 * Gets the custom template to be shown when we visit the airtime order/query received URL
	 */
	public function show_order_or_query_received_page( $template ) {
		if ( isset( $_GET['techzim_airtime_order_id'] ) && ! empty( $_GET['techzim_airtime_order_id'] ) ) {
			include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/techzim-airtime-public-order-received.php';
			die;
		} if ( isset( $_GET['techzim_airtime_diaspora_order_id'] ) && ! empty( $_GET['techzim_airtime_diaspora_order_id'] )
			&& isset( $_GET['cancelled'] ) && ! empty( $_GET['cancelled'] ) ) {
			include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/techzim-airtime-diaspora-public-order-cancelled.php';
			die;
		} if ( isset( $_GET['techzim_airtime_diaspora_order_id'] ) && ! empty( $_GET['techzim_airtime_diaspora_order_id'] ) ) {
				include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/techzim-airtime-diaspora-public-order-received.php';
			die;
		} else if ( isset( $_GET['techzim_airtime_query_id'] )  && ! empty( $_GET['techzim_airtime_query_id'] ) ) {
			include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/techzim-airtime-public-query-received.php';
			die;
		}

		return $template;
	}

	/**
	 * Add extra AMP JS to head
	 */
	public function add_custom_amp_js( $data ) {
		$data['amp_component_scripts'] = array_merge(
			$data['amp_component_scripts'],
			array(
				'amp-list' => 'https://cdn.ampproject.org/v0/amp-list-0.1.js',
			)
		);

		return $data;
	}

	/**
	 * Checks if a request is for WordPress Rest API.
	 */
	private function is_rest() {
		return ( defined( 'REST_REQUEST' ) && REST_REQUEST );
	}

	/**
	 * Add live chat widget script
	 * 
	 * @since 2.1.0
	 */
	public function add_live_chat_widget_js() {
		$settings = get_option( $this->techzim_airtime . '-settings' );

		$live_chat_widget_id = ( isset( $settings['live_chat_widget_id'] ) ? trim( $settings['live_chat_widget_id'] ) : '' );

		if ( ! empty( $live_chat_widget_id ) ) {
		?>
			<script>
			(function(I,n,f,o,b,i,p){
			I[b]=I[b]||function(){(I[b].q=I[b].q||[]).push(arguments)};
			I[b].t=1*new Date();i=n.createElement(f);i.async=1;i.src=o;
			p=n.getElementsByTagName(f)[0];p.parentNode.insertBefore(i,p)})
			(window,document,'script','https://livechat.infobip.com/widget.js','liveChat');

			liveChat('init', '<?php echo esc_attr( $live_chat_widget_id ) ?>');
			</script>
		<?php
		}
	}

	/**
	 * Updates the available mobile money payment methods in database
	 * * Triggered by a cron which runs twice a day
	 *
	 * @since 2.2.0
	 */
	public function update_available_dpo_mobile_money_payment_methods() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'tz_airtime_mobile_money_payment_methods';

		// Get the available mobile money services.
		$url  = 'https://europe-west2-techzim-airtime-system.cloudfunctions.net/get_available_dpo_mobile_money_payment_methods';
		$body = array(
			'transaction_source_url' => home_url(),
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

		if ( $response['success'] == true ) {
			$mobile_money_payment_options = (array) $response['available_mobile_money_payment_options'];
			if ( is_array( $mobile_money_payment_options ) ) {
				foreach ( $mobile_money_payment_options as $mobile_money_payment_option ) {
					$data = array(
						'mobile_money_id'    => $mobile_money_payment_option->mobile_money_id,
						'display_name'       => $mobile_money_payment_option->display_name,
						'mobile_money_name'  => $mobile_money_payment_option->mobile_money_name,
						'terminalmnocountry' => $mobile_money_payment_option->terminalmnocountry,
					);

					$mobile_money_id                        = $data['mobile_money_id'];

					$mobile_money_already_in_database_check = $wpdb->get_results( 'SELECT id FROM ' . $table_name . ' WHERE mobile_money_id="' . $mobile_money_id . '"' );

					if ( ! empty( $mobile_money_already_in_database_check ) ) {
						$wpdb->update( $table_name, $data, array( 'mobile_money_id' => $mobile_money_id ) );
					} else {
						$wpdb->insert( $table_name, $data );
						$insert_id = $wpdb->insert_id;
					}
				}
			}
		} else {
			error_log( 'Failed to get available mobile money payment options using CRON. Error message: ' . $response['error_message'], 0 );
			wp_die( 'There has been an error getting available mobile money payment options from airtime system. Plugin installation could not continue.' );
			return '';
		}
	}

	/**
	 * Updates the usd zwl rate
	 * * Triggered by a cron which runs twice a day
	 *
	 * @since 2.2.0
	 */
	public function update_usd_zwl_rate() {
		$url  = 'https://europe-west2-techzim-airtime-system.cloudfunctions.net/get_exchange_rate';
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
			error_log( 'Failed to get USD/ZWL exchange rate using CRON. Error message: ' . $response['error_message'], 0 );
			wp_die( 'There has been an error getting the USD/ZWL exchange rate from airtime system. Plugin installation could not continue.' ); 
		}
	}

	/**
	 * Retrieves all the mobile money payment methods from database
	 */
	public function get_available_dpo_mobile_money_payment_methods() {
		global $wpdb;

		$table_name                              = $wpdb->prefix . 'tz_airtime_mobile_money_payment_methods';
		$tz_airtime_mobile_money_payment_methods = $wpdb->get_results( 'SELECT * FROM ' . $table_name . ' ORDER BY display_name ASC' );

		$available_mobile_money_payment_options = $tz_airtime_mobile_money_payment_methods;

		return $available_mobile_money_payment_options;
	}

	/**
	 * Register WP API route used to calculate ZWL airtime amount.
	 */
	public function register_wp_route() {
		register_rest_route(
			$this->techzim_airtime,
			'/get_usd_zwl_rate',
			array(
				'methods'  => 'GET',
				'callback' => array( $this, 'get_usd_zwl_rate' ),
			)
		);
	}

	/**
	 * Retrieves the USD ZWL rate from DB for use in calculating ZWL airtime amount on frontend.
	 */
	public function get_usd_zwl_rate() {
		$exchange_rate = get_option( $this->techzim_airtime . '-usd-zwl-rate' );

		return array(
			'success'      => true,
			'usd_zwl_rate' => $exchange_rate,
		);
	}

	/**
	 * Adds an airtime buying form content to area where shortcode has been specified. 
	 *
	 * @since 2.3.0
	 */
	public function add_airtime_buying_form_shortcode_content() {
		ob_start();
		include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/techzim-airtime-public-display.php';
		$shortcode_content = ob_get_clean();

		return '<section class="tz-airtime-container"><h4><span>Buy airtime</h4>' . $shortcode_content . '</section>';
	}

	/**
	 * Registers the airtime buying form shortcode
	 * 
	 * @since 2.3.0
	 */
	public function register_airtime_buying_form_shortcode() {
		add_shortcode('techzim-airtime', array( $this, 'add_airtime_buying_form_shortcode_content'), 20);
	}
}
