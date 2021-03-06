<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://apie.cl
 * @since             1.0.0
 * @package           Landing_culturapopular
 *
 * @wordpress-plugin
 * Plugin Name:       Landing Evento
 * Plugin URI:        https://culturapopular.cl
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Pablo Selín Carrasco Armijo
 * Author URI:        https://apie.cl
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       landing_culturapopular
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
define( 'LANDING_TABLENAME', 'landing' );

/*
* CMB 2 included for metabox creation
*/
require_once plugin_dir_path( __FILE__ ) . 'vendor/CMB2/init.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-landing_culturapopular-activator.php
 */
function activate_landing_culturapopular() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-landing_culturapopular-activator.php';
	Landing_culturapopular_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-landing_culturapopular-deactivator.php
 */
function deactivate_landing_culturapopular() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-landing_culturapopular-deactivator.php';
	Landing_culturapopular_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_landing_culturapopular' );
register_deactivation_hook( __FILE__, 'deactivate_landing_culturapopular' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-landing_culturapopular.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_landing_culturapopular() {

	$plugin = new Landing_culturapopular();
	$plugin->run();

}
run_landing_culturapopular();
