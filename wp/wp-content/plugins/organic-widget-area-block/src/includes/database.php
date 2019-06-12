<?php

namespace organic_widget_area;
/**
 * Class Database
 * @package organic_widget_area
 */
class Database {
	/**
	 * Database constructor.
	 */
	public function __construct() {
	}


	/**
	 * @return false|int
	 */
	private static function is_table_exists() {
		global $wpdb;

		return;
	}

	/**
	 *
	 */
	public static function reset() {
		global $wpdb;
	}

	/**
	 *
	 */
	public static function reset_data() {
		global $wpdb;
	}

	/**
	 * @return bool
	 */
	public static function create_tables() {
		global $wpdb;

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	}
	
}