<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Smj_Ulm_Cal
 *
 * @wordpress-plugin
 * Plugin Name:       SMJ Ulm/Alb/Donau Kalender
 * Plugin URI:        https://smj-ulm.de
 * Description:       Abonnieren eines .ics feeds und Darstellung auf Wordpress Seite
 * Version:           0.0.1
 * Author:            Felix Betz
 * Author URI:        https://github.com/FelixBetz
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       smj-ulm-cal
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
define( 'SMJ_ULM_CAL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-smj-ulm-cal-activator.php
 */
function activate_smj_ulm_cal() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-smj-ulm-cal-activator.php';
	Smj_Ulm_Cal_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-smj-ulm-cal-deactivator.php
 */
function deactivate_smj_ulm_cal() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-smj-ulm-cal-deactivator.php';
	Smj_Ulm_Cal_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_smj_ulm_cal' );
register_deactivation_hook( __FILE__, 'deactivate_smj_ulm_cal' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-smj-ulm-cal.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_smj_ulm_cal() {

	$plugin = new Smj_Ulm_Cal();
	$plugin->run();

}

function shortcode_smj_ulm_cal( $atts ){
	//insert div for svelte app
	return '<div id="app"></div>';
}
add_shortcode( 'smj-ulm-cal_fulllist', 'shortcode_smj_ulm_cal' );


run_smj_ulm_cal();
