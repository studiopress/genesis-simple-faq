<?php
/*
Plugin Name: Plugin Boilerplate
Plugin URI: https://github.com/copyblogger/plugin-boilerplate
Description: A simple boilerplate for new WordPress plugins.
Author: Nathan Rice
Author URI: http://nathanrice.net/

Version: 0.9.0

Text Domain: plugin-boilerplate
Domain Path: /languages

License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/**
 * The main class.
 *
 * @since 0.9.0
 */
final class Plugin_Boilerplate {

	/**
	 * Plugin version
	 */
	public $plugin_version = '0.9.0';

	/**
	 * The plugin textdomain, for translations.
	 */
	public $plugin_textdomain = 'plugin-boilerplate';

	/**
	 * The url to the plugin directory.
	 */
	public $plugin_dir_url;

	/**
	 * The path to the plugin directory.
	 */
	public $plugin_dir_path;

	/**
	 * Boilerplate feature object.
	 */
	public $plugin_boilerplate_feature;

	/**
	 * Boilerplate AJAX object.
	 */
	public $plugin_boilerplate_ajax;

	/**
	 * Constructor.
	 *
	 * @since 0.9.0
	 */
	public function __construct() {

		$this->plugin_dir_url  = plugin_dir_url( __FILE__ );
		$this->plugin_dir_path = plugin_dir_path( __FILE__ );

	}

	/**
	 * Initialize.
	 *
	 * @since 0.9.0
	 */
	public function init() {

		register_activation_hook( __FILE__, array( $this, 'activation' ) );

		$this->load_plugin_textdomain();
		$this->includes();
		$this->instantiate();

	}

	/**
	 * Plugin activation hook. Runs when plugin is activated.
	 *
	 * @since 0.9.0
	 */
	public function activation() {}

	/**
	 * Load the plugin textdomain, for translation.
	 *
	 * @since 0.9.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( $this->plugin_textdomain, false, $this->plugin_dir_path . 'languages/' );
	}

	/**
	 * Use this method to to general includes such as functions files or classes that won't be instantiated.
	 *
	 * @since 0.9.0
	 */
	public function includes() {

		require_once( $this->plugin_dir_path . 'includes/functions.php' );

	}

	/**
	 * Include the class file, instantiate the classes, create objects.
	 *
	 * @since 0.9.0
	 */
	public function instantiate() {

		/**
		 * For each feature, or naturally related groups of features, create a class file that contains a single class.
		 *
		 * Use this section to create the object after including the class file.
		 */
		require_once( $this->plugin_dir_path . 'includes/class-plugin-boilerplate-feature.php' );
		$this->plugin_boilerplate_feature = new Plugin_Boilerplate_Feature;

		/**
		 * Plugin or theme depencencies should be loaded via separate methods hooked to actions available in
		 * the theme or plugin which they depend on.
		 *
		 * In this case, we're loading some Genesis dependent code.
		 */
		add_action( 'genesis_setup', array( $this, 'genesis_dependencies' ) );

		/**
		 * If you need to an a WP-CLI command, do it this way.
		 */
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			require_once( $this->plugin_dir_path . 'includes/class-plugin-boilerplate-cli-command.php' );
			WP_CLI::add_command( 'plugin-boilerplate', 'Plugin_Boilerplate_CLI_Command' );
		}

	}

	/**
	 * Include the class file, instantiate the classes, create objects.
	 *
	 * @since 0.9.0
	 */
	public function genesis_dependencies() {

		require_once( $this->plugin_dir_path . 'includes/class-plugin-boilerplate-ajax.php' );
		$this->plugin_boilerplate_ajax = new Plugin_Boilerplate_AJAX;
		$this->plugin_boilerplate_ajax();

	}

}

/**
 * Helper function to retrieve the static object without using globals.
 *
 * @since 0.9.0
 */
function Plugin_Boilerplate() {

	static $object;

	if ( null == $object ) {
		$object = new Plugin_Boilerplate;
	}

	return $object;

}

/**
 * Initialize the object on	`plugins_loaded`.
 */
add_action( 'plugins_loaded', array( Plugin_Boilerplate(), 'init' ) );
