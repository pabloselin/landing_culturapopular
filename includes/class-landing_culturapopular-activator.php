<?php

/**
 * Fired during plugin activation
 *
 * @link       https://apie.cl
 * @since      1.0.0
 *
 * @package    Landing_culturapopular
 * @subpackage Landing_culturapopular/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Landing_culturapopular
 * @subpackage Landing_culturapopular/includes
 * @author     Pablo Selín Carrasco Armijo <pablo@apie.cl>
 */
class Landing_culturapopular_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		$dbver = '0.1';
		$actver = get_option('land_dbver');
		
		if(!get_site_option('land_dbver') || $dbver != get_site_option('land_dbver')) {
			$table_name = $wpdb->prefix . 'landing';
			$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE $table_name(
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			data text NOT NULL,
			confirmed boolean NOT NULL,
			UNIQUE KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($sql);
		add_option('land_dbver', $dbver);
		}
	}

}
