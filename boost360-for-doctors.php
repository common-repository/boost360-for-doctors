<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.getboost360.com
 * @since             1.0.0
 * @package           Boost360_For_Doctors
 *
 * @wordpress-plugin
 * Plugin Name:       Boost360 for Doctors
 * Plugin URI:        https://online-clinic.getboost360.com
 * Description:       Boost360 enables doctors to convert their Wordpress website into a secure online clinic. Activate your Boost account to enable appointment booking on your Wordpress website. The appointment booking engine would enable patients to book appointment with you offline (at clinic) and online (online video consultation).
 * Version:           1.1.3
 * Author:            NowFloats Technologies Pvt Ltd
 * Author URI:        https://www.nowfloats.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       boost360-for-doctors
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'BOOST360_FOR_DOCTORS_VERSION', '1.1.3' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-boost360-for-doctors-activator.php
 */
function activate_boost360_for_doctors() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-boost360-for-doctors-activator.php';
	Boost360_For_Doctors_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-boost360-for-doctors-deactivator.php
 */
function deactivate_boost360_for_doctors() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-boost360-for-doctors-deactivator.php';
	Boost360_For_Doctors_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_boost360_for_doctors' );
register_deactivation_hook( __FILE__, 'deactivate_boost360_for_doctors' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-boost360-for-doctors.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_boost360_for_doctors() {

	$plugin = new Boost360_For_Doctors();
	$plugin->run();

}
run_boost360_for_doctors();
