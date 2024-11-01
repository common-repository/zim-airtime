<?php
/**
 * The admin settings of the plugin.
 *
 * @link       https://www.techzim.co.zw/
 * @since      1.0.0
 *
 * @package    Techzim_Airtime
 * @subpackage Techzim_Airtime/admin
 */

/**
 * The admin settings of the plugin.
 *
 *
 *
 * @package    Techzim_Airtime
 * @subpackage Techzim_Airtime/admin
 * @author     Techzim <marketplace@techzim.co.zw>
 */
class Techzim_Airtime_Admin_Settings {

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
	 * The ID of the plugin in a display friendly format
	 * 
	 * @since  1.0.0
	 * @access private
	 * @var    string
	 */
	private $display_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $techzim_airtime The name of this plugin.
	 * @param string $version         The version of this plugin.
	 */
	public function __construct( $techzim_airtime, $version ) {

		$this->techzim_airtime = $techzim_airtime;
		$this->version         = $version;
		$this->display_name    = ucwords( preg_replace( '/-/', ' ', $this->techzim_airtime ) );

	}

	/**
	 * Add options page
	 */
	public function add_plugin_page() {
		// * This page will be under "Settings".
		add_options_page(
			'Zim Airtime Settings',
			'Zim Airtime',
			'manage_options',
			$this->techzim_airtime . '-settings',
			array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page() {
		// Set class property.
		$this->options = get_option( $this->techzim_airtime . '-settings' );
		?>
		<div class="wrap">
			<h1>Zim Airtime</h1>
			<form method="post" action="options.php">
			<?php
				// This prints out all hidden setting fields.
				settings_fields( $this->techzim_airtime . '-settings-group' );
				do_settings_sections( $this->techzim_airtime . '-settings' );
				submit_button();
			?>
			</form>
		</div>
		<?php
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {
		register_setting(
			$this->techzim_airtime . '-settings-group', // Option group.
			$this->techzim_airtime . '-settings', // Option name.
			array( $this, 'sanitize' ) // Sanitize.
		);

		add_settings_section(
			$this->techzim_airtime . '-settings-display', // ID.
			'', // Title.
			array( $this, 'print_section_info' ), // Callback.
			$this->techzim_airtime . '-settings' // Page.
		);

		add_settings_field(
			'vendor_name',
			'Vendor Name',
			array( $this, 'vendor_name_callback' ),
			$this->techzim_airtime . '-settings', // Page.
			$this->techzim_airtime . '-settings-display' // Section.
		);

		add_settings_field(
			'show_below_post_form',
			'Airtime Buying Below Post',
			array( $this, 'show_below_post_form_callback' ),
			$this->techzim_airtime . '-settings', // Page.
			$this->techzim_airtime . '-settings-display' // Section.
		);

		add_settings_field(
			'live_chat_widget_id',
			'Live chat widget ID',
			array( $this, 'live_chat_widget_id_callback' ),
			$this->techzim_airtime . '-settings', // Page.
			$this->techzim_airtime . '-settings-display' // Section.
		);
	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys.
	 */
	public function sanitize( $input ) {
		$new_input = array();

		if ( isset( $input['vendor_name'] ) ) {
			$new_input['vendor_name'] = sanitize_text_field( $input['vendor_name'] );
		}

		if ( isset( $input['show_below_post_form'] ) && 1 == $input['show_below_post_form'] ) {
			$new_input['show_below_post_form'] = 1;
		}

		if ( isset( $input['live_chat_widget_id'] ) ) {
			$new_input['live_chat_widget_id'] = sanitize_text_field( $input['live_chat_widget_id'] );
		}

		return $new_input;
	}

	/**
	 * Print the Section text
	 */
	public function print_section_info() {
		?>
		<p>Enter your settings below.</p>
		<?php
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function vendor_name_callback() {
		printf(
			'<input type="text" id="vendor_name" name="' . $this->techzim_airtime . '-settings[vendor_name]" value="%s" />',
			isset( $this->options['vendor_name'] ) ? esc_attr( $this->options['vendor_name'] ) : ''
		);
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function show_below_post_form_callback() {
		?>
		<input type="checkbox" id="show_below_post_form" name="<?php echo esc_attr( $this->techzim_airtime ); ?>-settings[show_below_post_form]" value="1" <?php ( isset( $this->options['show_below_post_form'] ) ? checked( '1', $this->options['show_below_post_form'] ) : '' ); ?> />
		<?php
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function live_chat_widget_id_callback() {
		printf(
			'<input type="text" id="live_chat_widget_id" name="' . $this->techzim_airtime . '-settings[live_chat_widget_id]" value="%s" />',
			isset( $this->options['live_chat_widget_id'] ) ? esc_attr( $this->options['live_chat_widget_id'] ) : ''
		);
	}
}
