<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.nowfloats.com
 * @since      1.0.0
 *
 * @package    Boost360_For_Doctors
 * @subpackage Boost360_For_Doctors/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Boost360_For_Doctors
 * @subpackage Boost360_For_Doctors/includes
 * @author     NowFloats Technologies Pvt Ltd <developers@nowfloats.com>
 */
class Boost360_For_Doctors_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'boost360-for-doctors',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
