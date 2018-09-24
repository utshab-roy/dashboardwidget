<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.github.com/utshab-roy
 * @since             1.0.0
 * @package           Dashboardwidget
 *
 * @wordpress-plugin
 * Plugin Name:       CBX Dashboard Widget
 * Plugin URI:        https://github.com/utshab-roy/dashboardwidget
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Utshab Roy
 * Author URI:        www.github.com/utshab-roy
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dashboardwidget
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dashboardwidget-activator.php
 */
function activate_dashboardwidget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dashboardwidget-activator.php';
	Dashboardwidget_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dashboardwidget-deactivator.php
 */
function deactivate_dashboardwidget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dashboardwidget-deactivator.php';
	Dashboardwidget_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dashboardwidget' );
register_deactivation_hook( __FILE__, 'deactivate_dashboardwidget' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dashboardwidget.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dashboardwidget() {

	$plugin = new Dashboardwidget();
	$plugin->run();

}
run_dashboardwidget();
