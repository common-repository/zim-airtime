<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.techzim.co.zw/
 * @since      1.0.0
 *
 * @package    Techzim_Airtime
 * @subpackage Techzim_Airtime/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Techzim_Airtime
 * @subpackage Techzim_Airtime/includes
 * @author     Techzim <marketplace@techzim.co.zw>
 */
class Techzim_Airtime {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Techzim_Airtime_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $techzim_airtime    The string used to uniquely identify this plugin.
	 */
	protected $techzim_airtime;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'TECHZIM_AIRTIME_VERSION' ) ) {
			$this->version = TECHZIM_AIRTIME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->techzim_airtime = 'techzim-airtime';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Techzim_Airtime_Loader. Orchestrates the hooks of the plugin.
	 * - Techzim_Airtime_i18n. Defines internationalization functionality.
	 * - Techzim_Airtime_Admin. Defines all hooks for the admin area.
	 * - Techzim_Airtime_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-techzim-airtime-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-techzim-airtime-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-techzim-airtime-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-techzim-airtime-public.php';

		/**
		 * The class that has the Airtime widget settings.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-techzim-airtime-widget.php';

		$this->loader = new Techzim_Airtime_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Techzim_Airtime_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Techzim_Airtime_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Techzim_Airtime_Admin( $this->get_techzim_airtime(), $this->get_version() );
		$plugin_admin_settings = new Techzim_Airtime_Admin_Settings( $this->get_techzim_airtime(), $this->get_version() );
		$airtime_widget = new Techzim_Airtime_Widget();

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		//$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_settings_menu' );
		// $this->loader->add_action( 'admin_init', $plugin_admin, 'display_settings_page_fields' );
		$this->loader->add_action( 'admin_menu', $plugin_admin_settings, 'add_plugin_page' );
		$this->loader->add_action( 'admin_init', $plugin_admin_settings, 'page_init' );
		$this->loader->add_action( 'check_netone_recharge_method', $plugin_admin, 'update_netone_recharge_method' );
		$this->loader->add_action( 'tz_airtime_update_airtime_order_received_notice', $plugin_admin, 'update_airtime_notice' );
		$this->loader->add_action( 'widgets_init', $airtime_widget, 'load_airtime_widget' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Techzim_Airtime_Public( $this->get_techzim_airtime(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'woocommerce_before_add_to_cart_form', $plugin_public, 'add_simple_buying_form', 5 );
		$this->loader->add_action( 'amp_post_template_css', $plugin_public, 'add_custom_amp_css', 11 );
		$this->loader->add_action( 'wp_head', $plugin_public, 'add_live_chat_widget_js', 11 );
		$this->loader->add_action( 'init', $plugin_public, 'register_airtime_buying_form_shortcode');

		// ! Buying airtime from diaspora is currently only available on techzim.market
		// * the feature may be opened up to vendors at a later date.
		if ( home_url() === 'https://techzim.market' || home_url() === 'https://testing.techzim.market' ) {
			$this->loader->add_action( 'tz_airtime_usd_zwl_rate_update', $plugin_public, 'update_usd_zwl_rate' );
			// * url will be /wp-json/techzim-airtime/get_usd_zwl_rate
			$this->loader->add_action( 'rest_api_init', $plugin_public, 'register_wp_route' );
		}

		$this->loader->add_filter( 'the_content', $plugin_public, 'add_below_post_airtime_buying', 999 );
		$this->loader->add_filter( 'the_content', $plugin_public, 'add_airtime_buying_form_to_page', 999 );
		$this->loader->add_filter( 'the_content', $plugin_public, 'add_diaspora_airtime_buying_form_to_page', 999 );
		$this->loader->add_filter( 'template_include', $plugin_public, 'show_order_or_query_received_page', 999 );
		$this->loader->add_filter( 'amp_post_template_data', $plugin_public, 'add_custom_amp_js', 11 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_techzim_airtime() {
		return $this->techzim_airtime;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Techzim_Airtime_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Checks if the current product is airtime
	 *
	 * @since        1.0.0
	 * @param string $product_sku The unique identifier of the product to be checked.
	 */
	public static function check_if_product_is_airtime( $product_sku ) {
		if ( 'netone-airtime' === $product_sku ||
			'telecel-airtime' === $product_sku ||
			'africom-airtime' === $product_sku ||
			'econet-airtime' === $product_sku ) {
			return true;
		}

		return false;
	}
}
