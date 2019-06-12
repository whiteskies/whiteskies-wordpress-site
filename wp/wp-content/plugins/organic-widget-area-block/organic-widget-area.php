<?php
/**
 * Plugin Name: Organic Widget Area Block
 * Plugin URI: https://organicthemes.com/builder
 * Description: A custom block for the Gutenberg content editor that adds a Widget Area for the display of traditional widgets within any page or post.
 * Version: 1.0
 * Author: Organic Themes
 * Author URI: https://organicthemes.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: organic-widget-area
 * Domain Path: /languages
 */

namespace organic_widget_area;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class InitializePlugin
 * @package organic_widget_area
 */
class InitializePlugin {

	/**
	 * The plugin name
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */
	private $plugin_name = 'Organic Widget Area Block';

	/**
	 * The plugin name acronym
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */
	private $plugin_prefix = 'owa';

	/**
	 * The plugin version number
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */
	private $plugin_version = '1.0';

	/**
	 * The database version number
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */
	const DATABASE_VERSION = '1.0';

	/**
	 * The full path and filename
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */
	private $path_to_plugin_file = __FILE__;

	/**
	 * Allows the debugging scripts to initialize and log them in a file
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */
	private $log_debug_messages = false;

	/**
	 * The instance of the class
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Object
	 */
	private static $instance = null;

	/**
	 * Class constructor
	 */
	private function __construct() {

		// Load Utilities.
		$this->initialize_utilities();

		// Load Configuration.
		$this->initialize_config();

		// Load the plugin files.
		$this->boot_plugin();

		add_action( 'plugins_loaded', [ $this, 'plugins_loaded' ], 99 );
	}

	/**
	 * Creates singleton instance of class
	 *
	 * @since 1.0.0
	 *
	 * @return InitializePlugin $instance The InitializePlugin Class
	 */
	public static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Initialize Static singleton class that has shared function and variables that can be used anywhere in WP
	 *
	 * @since 1.0.0
	 */
	private function initialize_utilities() {

		include_once( dirname( __FILE__ ) . '/src/utilities.php' );
		Utilities::set_date_time_format();

	}

	/**
	 * Initialize Static singleton class that configures all constants, utilities variables and handles activation/deactivation
	 *
	 * @since 1.0.0
	 */
	private function initialize_config() {

		include_once( dirname( __FILE__ ) . '/src/config.php' );
		$config_instance = Config::get_instance();

		$plugin_name = apply_filters( $this->plugin_prefix . '_plugin_name', $this->plugin_name );

		$config_instance->configure_plugin_before_boot( $plugin_name, $this->plugin_prefix, $this->plugin_version, $this->path_to_plugin_file, $this->log_debug_messages );


	}

	/**
	 * Initialize Static singleton class auto loads all the files needed for the plugin to work
	 *
	 * @since 1.0.0
	 */
	private function boot_plugin() {

		include_once( dirname( __FILE__ ) . '/src/boot.php' );
		Boot::get_instance();

	}

	/**
	 *
	 */
	public function plugins_loaded() {

		if ( self::DATABASE_VERSION !== get_option( 'owa_database_version', 0 ) ) {
			Database::create_tables();
			update_option( 'owa_database_version', self::DATABASE_VERSION );
		}
	}
}

// Let's run it.
InitializePlugin::get_instance();
