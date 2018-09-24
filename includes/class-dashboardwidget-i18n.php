<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.github.com/utshab-roy
 * @since      1.0.0
 *
 * @package    Dashboardwidget
 * @subpackage Dashboardwidget/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Dashboardwidget
 * @subpackage Dashboardwidget/includes
 * @author     Utshab Roy <utshab.roy@gmail.com>
 */
class Dashboardwidget_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'dashboardwidget',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
