<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://codecanyon.net/user/accolore/portfolio
 * @since             1.0.0
 * @package           Wp_Al_Settings_Demo
 *
 * @wordpress-plugin
 * Plugin Name:       WP Accolore Settings Demo
 * Plugin URI:        https://github.com/Accolore/wp-accolore-settings-demo
 * Description:       A plugin for Accolore settings demo
 * Version:           2.0.0
 * Author:            Accolore
 * Author URI:        https://codecanyon.net/user/accolore/portfolio
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-al-settings-demo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// call global configuration variable
global $accolore_config;

// if not exist instantiate it
if( ! isset($accolore_config)) {
	$accolore_config = array();
}

// include plugin configuration file
require_once 'wp-accolore-config.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-al-settings-demo-activator.php
 */
function activate_wp_al_settings_demo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-al-settings-demo-activator.php';
	Wp_Al_Settings_Demo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-al-settings-demo-deactivator.php
 */
function deactivate_wp_al_settings_demo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-al-settings-demo-deactivator.php';
	Wp_Al_Settings_Demo_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_al_settings_demo' );
register_deactivation_hook( __FILE__, 'deactivate_wp_al_settings_demo' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-al-settings-demo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_al_settings_demo() {

	$plugin = new Wp_Al_Settings_Demo();
	$plugin->run();

}
run_wp_al_settings_demo();
