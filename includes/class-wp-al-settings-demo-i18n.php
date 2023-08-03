<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://codecanyon.net/user/accolore/portfolio
 * @since      1.0.0
 *
 * @package    Wp_Al_Settings_Demo
 * @subpackage Wp_Al_Settings_Demo/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp_Al_Settings_Demo
 * @subpackage Wp_Al_Settings_Demo/includes
 * @author     Accolore <support@accolore.com>
 */
class Wp_Al_Settings_Demo_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-al-settings-demo',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
