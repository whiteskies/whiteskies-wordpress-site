<?php

namespace organic_widget_area;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * This class stores helper functions that can be used statically in all of WP after plugins loaded hook
 *
 * Use the Utilites::get_% function to retrieve the variable. The following is a list of calls
 *
 * @package    organic_widget_area
 * @subpackage organic_widget_area/config
 * @author     Sole IT
 */
class Utilities {

	/**
	 * The name of the plugin
	 *
	 * @use get_plugin_name()
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */
	private static $plugin_name;

	/**
	 * The prefix of this plugin that is set in the config class
	 *
	 * @use get_version()
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */
	private static $prefix;

	/**
	 * The plugins version number
	 *
	 * @use get_version()
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */
	private static $version;

	/**
	 * The main plugin file path
	 *
	 * @use get_plugin_file()
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */
	private static $plugin_file;

	/**
	 * The references to autoloaded class instances
	 *
	 * @use get_autoloaded_class_instance()
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */
	private static $class_instances = array();

	/**
	 * The plugin specific debug mode
	 *
	 * @use get_debug_mode()
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      bool
	 */
	private static $debug_mode;

	/**
	 * The plugin date and time format
	 *
	 * @use get_date_time_format()
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      bool
	 */
	private static $date_time_format;

	/**
	 * The plugin date format
	 *
	 * @use get_date_format()
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      bool
	 */
	private static $date_format;

	/**
	 * The plugin time format
	 *
	 * @use get_time_format()
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      bool
	 */
	private static $time_format;

	/**
	 * The server time when the plugin was initialized
	 *
	 * @use get_time_format()
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      bool
	 */
	private static $plugin_initialization;

	/**
	 * Set the name of the plugin
	 *
	 * @since    1.0.0
	 *
	 * @param string $plugin_name The name of the plugin
	 *
	 * @return string
	 */
	public static function set_plugin_name( $plugin_name ) {
		if ( null === self::$prefix ) {
			self::$plugin_name = $plugin_name;
		}

		return self::$plugin_name;
	}

	/**
	 * Get the name of the plugin
	 *
	 * @since    1.0.0
	 *
	 * @return string
	 */
	public static function get_plugin_name() {
		return self::$plugin_name;
	}

	/**
	 * Set the prefix for the plugin
	 *
	 * @since    1.0.0
	 *
	 * @param string $prefix Variable used to prefix filters and actions
	 *
	 * @return string
	 */
	public static function set_prefix( $prefix ) {
		if ( null === self::$prefix ) {
			self::$prefix = $prefix;
		}

		return self::$prefix;
	}

	/**
	 * Get the prefix for the plugin
	 *
	 * @since    1.0.0
	 *
	 * @return string
	 */
	public static function get_prefix() {
		return self::$prefix;
	}

	/**
	 * Set the version for the plugin
	 *
	 * @since    1.0.0
	 *
	 * @param string $version Variable used to prefix filters and actions
	 *
	 * @return string
	 */
	public static function set_version( $version ) {
		if ( null === self::$version ) {
			self::$version = $version;
		}

		return self::$version;
	}

	/**
	 * Get the version for the plugin
	 *
	 * @since    1.0.0
	 *
	 * @return string
	 */
	public static function get_version() {
		return self::$version;
	}


	/**
	 * Set the main plugin file path
	 *
	 * @since    1.0.0
	 *
	 * @param string $plugin_file The main plugin file path
	 *
	 * @return string
	 */
	public static function set_plugin_file( $plugin_file ) {
		if ( null === self::$plugin_file ) {
			self::$plugin_file = $plugin_file;
		}

		return self::$plugin_file;
	}

	/**
	 * Get the version for the plugin
	 *
	 * @since    1.0.0
	 *
	 * @return string
	 */
	public static function get_plugin_file() {
		return self::$plugin_file;
	}

	/**
	 * Set the main plugin file path
	 *
	 * @since    1.0.0
	 *
	 * @param string $class_name The name of the class instance
	 * @param object $class_instance The reference to the class instance
	 *
	 */
	public static function set_class_instance( $class_name, $class_instance ) {

		self::$class_instances[ $class_name ] = $class_instance;

	}

	/**
	 * Get the version for the plugin
	 *
	 * @since    1.0.0
	 *
	 * @param string $class_name The name of the class instance
	 *
	 * @return string
	 */
	public static function get_class_instance( $class_name ) {
		return self::$class_instances[ $class_name ];
	}

	/**
	 * Set the default date and time format
	 *
	 * @since    1.0.0
	 *
	 * @param string $date Date format
	 * @param string $time Time format
	 * @param string $separator The separator between the date and time format
	 *
	 * @return bool
	 */
	public static function set_date_time_format( $date = 'F j, Y', $time = ' g:i a', $separator = ' ' ) {

		$date      = apply_filters( self::$prefix . '_date_time_format', $date );
		$time      = apply_filters( self::$prefix . '_date_time_format', $time );
		$separator = apply_filters( self::$prefix . '_date_time_format', $separator );

		if ( null === self::$date_time_format ) {
			self::$date_time_format = $date . $separator . $time;
		}

		if ( null === self::$date_format ) {
			self::$date_format = $date;
		}

		if ( null === self::$time_format ) {
			self::$time_format = $time;
		}

		return self::$date_time_format;
	}

	/**
	 * Get the date and time format for the plugin
	 *
	 * @since    1.0.0
	 *
	 * @return string
	 */
	public static function get_date_time_format() {
		return self::$date_time_format;
	}

	/**
	 * Get the date format for the plugin
	 *
	 * @since    1.0.0
	 *
	 * @return string
	 */
	public static function get_date_format() {
		return self::$date_time_format;
	}

	/**
	 * Get the time format for the plugin
	 *
	 * @since    1.0.0
	 *
	 * @return string
	 */
	public static function get_time_format() {
		return self::$date_time_format;
	}

	/**
	 * Set the main plugin file path
	 *
	 * @since    1.0.0
	 *
	 * @param bool $debug_mode The main plugin file path
	 *
	 * @return bool
	 */
	public static function set_debug_mode( $debug_mode ) {

		if ( null === self::$debug_mode ) {

			self::$debug_mode = $debug_mode;
		}

		return self::$debug_mode;
	}

	/**
	 * Set the version for the plugin
	 *
	 * @since    1.0.0
	 *
	 * @return bool
	 */
	public static function get_debug_mode() {
		return self::$debug_mode;
	}

	/**
	 * Set the server time when the plugin was initialized
	 *
	 * @since    1.0.0
	 *
	 * @param int $time Timestamp
	 *
	 * @return int
	 */
	public static function set_plugin_initialization( $time ) {

		if ( null === self::$plugin_initialization ) {
			self::$plugin_initialization = $time;
		}

		return self::$plugin_initialization;
	}

	/**
	 * Get the server time when the plugin was initialized
	 *
	 * @since    1.0.0
	 *
	 * @return int Timestamp
	 */
	public static function get_plugin_initialization() {
		return self::$plugin_initialization;
	}

	/**
	 * Returns the full url for the passed CSS file
	 *
	 * @since    1.0.0
	 *
	 * @param string $file_name
	 *
	 * @return string $asset_url
	 */
	public static function get_css( $file_name ) {
		$asset_url = plugins_url( 'assets/css/' . $file_name, __FILE__ );

		return $asset_url;
	}

	/**
	 * Returns the full url for the passed JS file
	 *
	 * @since    1.0.0
	 *
	 * @param string $file_name
	 *
	 * @return string $asset_url
	 */
	public static function get_js( $file_name ) {
		$asset_url = plugins_url( 'assets/js/' . $file_name, __FILE__ );

		return $asset_url;
	}
	
	/**
	 * Returns the full url for the passed Block CSS file
	 *
	 * @since    1.0.0
	 *
	 * @param string $file_name
	 *
	 * @return string $asset_url
	 */
	public static function get_block_css( $file_name ) {
		$asset_url = plugins_url( 'blocks/' . $file_name, __FILE__ );

		return $asset_url;
	}

	/**
	 * Returns the full url for the passed Block JS file
	 *
	 * @since    1.0.0
	 *
	 * @param string $file_name
	 *
	 * @return string $asset_url
	 */
	public static function get_block_js( $file_name ) {
		$asset_url = plugins_url( 'blocks/' . $file_name, __FILE__ );

		return $asset_url;
	}

	/**
	 * Returns the full url for the passed media file
	 *
	 * @since    1.0.0
	 *
	 * @param string $file_name
	 *
	 * @return string $asset_url
	 */
	public static function get_media( $file_name ) {
		$asset_url = plugins_url( 'assets/media/' . $file_name, __FILE__ );

		return $asset_url;
	}

	/**
	 * Returns the full server path for the passed template file
	 *
	 * @param string $file_name
	 *
	 * @return string
	 */
	public static function get_template( $file_name ) {

		$templates_directory = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;

		/**
		 * Filters the director path to the template file
		 *
		 * This can be used for template overrides by modifying the path to go to a directory in the theme or another plugin.
		 *
		 * @since 1.0.0
		 *
		 * @param string $templates_directory Path to the plugins template folder
		 * @param string $file_name The file name of the template file
		 */
		$templates_directory = apply_filters( Utilities::get_prefix() . '_template_path', $templates_directory, $file_name );

		$asset_path = $templates_directory . $file_name;

		return $asset_path;
	}

	/**
	 * Returns the full server path for the passed include file
	 *
	 * @param string $file_name
	 *
	 * @return string
	 */
	public static function get_include( $file_name ) {

		$includes_directory = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR;

		/**
		 * Filters the director path to the include file
		 *
		 * This can be used for template overrides by modifying the path to go to a directory in the theme or another plugin.
		 *
		 * @since 1.0.0
		 *
		 * @param string $templates_directory Path to the plugins template folder
		 * @param string $file_name The file name of the template file
		 */
		$includes_directory = apply_filters( Utilities::get_prefix() . '_includes_path_to', $includes_directory, $file_name );

		$asset_path = $includes_directory . $file_name;

		return $asset_path;
	}

	/**
	 * Returns the heading for the Setting pages
	 *
	 * @since 2.5
	 *
	 * @param string $section_title
	 *
	 * @return string
	 */

	public static function get_settings_header( $section_title ){
		ob_start();

		?>

		<div>
		</div>

		<?php

		$output = ob_get_clean();

		return $output;
	}

	/**
	 * Create and store logs @ wp-content/{plugin_folder_name}/uo-{$file_name}.log
	 *
	 * @since    1.0.0
	 *
	 * @param string $trace_message The message logged
	 * @param string $trace_heading The heading of the current trace
	 * @param bool $force_log Create log even if debug mode is off
	 * @param string $file_name The file name of the log file
	 *
	 * @return bool $error_log Was the log successfully created
	 */
	public static function log( $trace_message = '', $trace_heading = '', $force_log = false, $file_name = 'logs' ) {

		// Only return log if debug mode is on OR if log is forced
		if ( ! $force_log ) {

			if ( ! self::get_debug_mode() ) {
				return false;
			}
		}

		$timestamp = date( self::get_date_time_format() );

		$current_page_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		$trace_start = "\n===========================<<<< $timestamp >>>>===========================\n";

		$trace_heading = "* Heading: $trace_heading \n";

		$trace_heading .= "* Current Page: $current_page_link \n";


		$trace_heading .= "* Plugin Initialized: " . date( self::get_date_time_format(), self::get_plugin_initialization() ) . "\n";

		$trace_end = "\n===========================<<<< TRACE END >>>>===========================\n\n";

		$trace_message = print_r( $trace_message, true );

		//$file = dirname( self::get_plugin_file() ) . '/uo-' . $file_name . '.log';
		$file = WP_CONTENT_DIR . '/uo-' . $file_name . '.log';

		$error_log = error_log( $trace_start . $trace_heading . $trace_message . $trace_end, 3, $file );

		return $error_log;

	}

}