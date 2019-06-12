<?php

namespace organic_widget_area;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Boot
 * @package organic_widget_area
 */
class Boot {

	/**
	 * The instance of the class
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Boot
	 */
	private static $instance = null;

	/**
	 * The directories that are auto loaded and initialized
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array
	 */
	private static $auto_loaded_directories = null;

	/**
	 * class constructor
	 */
	private function __construct() {

		// We need to check if spl auto loading is available when activating plugin
		// Plugin will not activate if SPL extension is not enabled by throwing error
		if ( ! extension_loaded( 'SPL' ) ) {
			trigger_error( esc_html__( 'Please contact your hosting company to update to php version 5.3+ and enable spl extensions.', 'organic-widget-area' ), E_USER_ERROR );
		}

		spl_autoload_register( array( $this, 'require_class_files' ) );

		// Initialize all classes in given directories
		$this->auto_initialize_classes();

	}


	/**
	 * Creates singleton instance of Boot class and defines which directories are auto loaded
	 *
	 * @since 1.0.0
	 *
	 * @param array $auto_loaded_directories
	 *
	 * @return Boot
	 */
	public static function get_instance( $auto_loaded_directories = array( 'classes/', 'includes/' ) ) {

		if ( null === self::$instance ) {

			// Define directories were the auto loader looks for files and initializes them
			self::$auto_loaded_directories = $auto_loaded_directories;

			// Lets boot up!
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * SPL Auto Loader functions
	 *
	 * @since 1.0.0
	 *
	 * @param string $class Any
	 */
	private function require_class_files( $class ) {

		// Remove Class's namespace eg: my_namespace/MyClassName to MyClassName
		$class = str_replace( __NAMESPACE__, '', $class );
		$class = str_replace( '\\', '', $class );

		// First Character of class name to lowercase eg: MyClassName to myClassName
		$class_to_filename = lcfirst( $class );

		// Split class name on upper case letter eg: myClassName to array( 'my', 'Class', 'Name')
		$split_class_to_filename = preg_split( '#([A-Z][^A-Z]*)#', $class_to_filename, null, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );

		if ( 1 <= count( $split_class_to_filename ) ) {
			// Split class name to hyphenated name eg: array( 'my', 'Class', 'Name') to my-Class-Name
			$class_to_filename = implode( '-', $split_class_to_filename );
		}

		// Create file name that will be loaded from the classes directory eg: my-Class-Name to my-class-name.php
		$file_name = strtolower( $class_to_filename ) . '.php';


		// Check each directory
		foreach ( self::$auto_loaded_directories as $directory ) {

			$file_path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . $directory . $file_name;

			// Does the file exist
			if ( file_exists( $file_path ) ) {

				// File found, require it
				require_once( $file_path );

				// You can cannot have duplicate files names. Once the first file is found, the loop ends.
				return;
			}
		}

	}

	/**
	 * Looks through all defined directories and modifies file name to create new class instance.
	 *
	 * @since 1.0.0
	 *
	 */
	private function auto_initialize_classes() {

		// Check each directory
		foreach ( self::$auto_loaded_directories as $directory ) {

			// Get all files in directory
			$files = scandir( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . $directory );

			// remove parent directory, sub directory, and silence is golden index.php
			$files = array_diff( $files, array( '..', '.', 'index.php' ) );

			// Loop through all files in directory to create class names from file name
			foreach ( $files as $file ) {
				if ( strpos( $file, '.php' ) ) {
					// Remove file extension my-class-name.php to my-class-name
					$file_name = str_replace( '.php', '', $file );

					// Split file name on - eg: my-class-name to array( 'my', 'class', 'name')
					$class_to_filename = explode( '-', $file_name );

					// Make the first letter of each word in array upper case - eg array( 'my', 'class', 'name') to array( 'My', 'Class', 'Name')
					$class_to_filename = array_map( function ( $word ) {
						return ucfirst( $word );
					}, $class_to_filename );

					// Implode array into class name - eg. array( 'My', 'Class', 'Name') to MyClassName
					$class_name = implode( $class_to_filename );

					$class = __NAMESPACE__ . '\\' . $class_name;
					if ( class_exists( $class ) ) {
						Utilities::set_class_instance( $class_name, new $class );
					}
				}
			}
		}
	}


	/**
	 * Make clone magic method private, so nobody can clone instance.
	 *
	 * @since 1.0.0
	 */
	private function __clone() {
	}

	/**
	 * Make sleep magic method private, so nobody can serialize instance.
	 *
	 * @since 1.0.0
	 */
	private function __sleep() {
	}

	/**
	 * Make wakeup magic method private, so nobody can unserialize instance.
	 *
	 * @since 1.0.0
	 */
	private function __wakeup() {

	}

}

