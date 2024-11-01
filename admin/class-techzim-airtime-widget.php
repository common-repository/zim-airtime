<?php

/**
 * The functionality to add and update the Airtime widget.
 *
 * @link       https://techzim.co.zw/about
 * @since      2.4.0
 *
 * @package    Techzim_Airtime
 * @subpackage Techzim_Airtime/admin
 */

/**
 * The functionality to add and update the Airtime widget.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Techzim_Airtime
 * @subpackage Techzim_Airtime/admin
 * @author     Techzim Market <marketplace@techzim.co.zw>
 */
class Techzim_Airtime_Widget extends WP_Widget {
	public function __construct() {
        parent::__construct(
            'techzim_airtime_widget',
            __('Techzim Airtime', 'techzim_airtime_widget'),
            array( 'description' => __(' Widget to display Airtime buying form', 'techzim_airtime_widget'),)
        );
	}
    
    function form($instance) { ?>
        <p>Airtime buying form will be displayed on this area. </p> 
    <?php }
    
    function update($new_instance, $old_instance) {
        // There is no update made here.
    }
    
    function widget($args, $instance) {
        echo do_shortcode("[techzim-airtime]");
    }

    function load_airtime_widget() {
        register_widget('Techzim_Airtime_Widget');
    }
}