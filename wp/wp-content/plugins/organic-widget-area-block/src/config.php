<?php

namespace organic_widget_area;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * This class is used to run any configurations before the plugin is initialized
 *
 * @package    organic_widget_area
 * @subpackage organic_widget_area/config
 * @author     Organic Themes
 */
class Config {


	/**
	 * The instance of the class
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Boot
	 */
	private static $instance = null;

	/**
	 * Creates singleton instance of class
	 *
	 * @since 1.0.0
	 *
	 * @return Config $instance
	 */
	public static function get_instance() {

		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Initialize the class and setup its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of the plugin
	 * @param      string $prefix The variable used to prefix filters and actions
	 * @param      string $version The version of this plugin
	 * @param      string $file The main plugin file __FILE__
	 * @param      bool $debug Whether debug log in php and js files are enabled
	 */
	public function configure_plugin_before_boot( $plugin_name, $prefix, $version, $file, $debug ) {


		$this->define_constants( $plugin_name, $prefix, $version, $file, $debug );

		do_action( Utilities::get_prefix() . '_define_constants_after' );

		register_activation_hook( Utilities::get_plugin_file(), array( $this, 'activation' ) );

		register_deactivation_hook( Utilities::get_plugin_file(), array( $this, 'deactivation' ) );

		do_action( Utilities::get_prefix() . '_config_setup_after' );

	}

	/**
	 *
	 * This action is documented in includes/class-plugin-name-deactivator.php
	 *
	 * @since    1.0.0
	 * @access   private
	 *
	 * @param      string $plugin_name The name of the plugin
	 * @param      string $prefix Variable used to prefix filters and actions
	 * @param      string $version The version of this plugin.
	 * @param      string $plugin_file The main plugin file __FILE__
	 * @param      string $debug_mode Whether debug log in php and js files are enabled
	 */
	private function define_constants( $plugin_name, $prefix, $version, $plugin_file, $debug_mode ) {


		// Set and define version
		if ( ! defined( strtoupper( $prefix ) . '_PLUGIN_NAME' ) ) {
			define( strtoupper( $prefix ) . '_PLUGIN_NAME', $plugin_name );
			Utilities::set_plugin_name( $plugin_name );
		}

		// Set and define version
		if ( ! defined( strtoupper( $prefix ) . '_VERSION' ) ) {
			define( strtoupper( $prefix ) . '_VERSION', $version );
			Utilities::set_version( $version );
		}

		// Set and define prefix
		if ( ! defined( strtoupper( $prefix ) . '_PREFIX' ) ) {
			define( strtoupper( $prefix ) . '_PREFIX', $prefix );
			Utilities::set_prefix( $prefix );
		}

		// Set and define the main plugin file path
		if ( ! defined( $prefix . '_FILE' ) ) {
			define( strtoupper( $prefix ) . '_FILE', $plugin_file );
			Utilities::set_plugin_file( $plugin_file );
		}

		// Set and define debug mode
		if ( ! defined( $prefix . '_DEBUG_MODE' ) ) {
			define( strtoupper( $prefix ) . '_DEBUG_MODE', $debug_mode );
			Utilities::set_debug_mode( $debug_mode );
		}

		// Set and define the server initialization time
		if ( ! defined( $prefix . '_SERVER_INITIALIZATION' ) ) {
			$time = time();
			define( strtoupper( $prefix ) . '_SERVER_INITIALIZATION', $time );
			Utilities::set_plugin_initialization( $time );
		}

		Utilities::log(
			array(
				'get_plugin_name'           => Utilities::get_plugin_name(),
				'get_version'               => Utilities::get_version(),
				'get_prefix'                => Utilities::get_prefix(),
				'get_plugin_file'           => Utilities::get_plugin_file(),
				'get_debug_mode'            => Utilities::get_debug_mode(),
				'get_plugin_initialization' => date( Utilities::get_date_time_format(), Utilities::get_plugin_initialization() )

			),
			'Configuration Variables'
		);

	}


	/**
	 * The code that runs during plugin activation.
	 * @since    1.0.0
	 */
	function activation() {

		do_action( Utilities::get_prefix() . '_activation_before' );

		do_action( Utilities::get_prefix() . '_activation_after' );

	}

	/**
	 * The code that runs during plugin deactivation.
	 * @since    1.0.0
	 */
	function deactivation() {

		do_action( Utilities::get_prefix() . '_deactivation_before' );

		do_action( Utilities::get_prefix() . '_deactivation_after' );

	}
}
