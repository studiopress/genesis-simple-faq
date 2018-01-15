<?php
/*
Plugin Name: Genesis Simple FAQ
Plugin URI: https://github.com/copyblogger/genesis-simple-faq

Description: A plugin for the Genesis Framework to manage FAQ components via shortcodes.

Author: StudioPress
Author URI: http://www.studiopress.com/

Version: 0.9.1

Text Domain: genesis-simple-faq
Domain Path: /languages

License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/**
 * The main class.
 *
 * @since 0.9.0
 */
final class Genesis_Simple_FAQ {

	/**
	 * Plugin version
	 */
	public $plugin_version = '0.9.0';

	/**
	 * Minimum WordPress version
	 */
	 public $min_wp_version = '4.8';

	/**
	 * Minimum Genesis version
	 */
	 public $min_genesis_version = '2.5';

	/**
	 * The plugin textdomain, for translations.
	 */
	public $plugin_textdomain = 'genesis-simple-faq';

	/**
	 * The url to the plugin directory.
	 */
	public $plugin_dir_url;

	/**
	 * The path to the plugin directory.
	 */
	public $plugin_dir_path;

	/**
	 * Post type object.
	 */
	public $post_type;

	/**
	 * Post type taxonomy.
	 */
	public $post_type_tax;

	/**
	 * Shortcode object.
	 */
	public $shortcode;

	/**
	 * Widget object.
	 */
	public $widget;

	/**
	 * Assets object.
	 */
	public $assets;

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

		$this->load_plugin_textdomain();

		register_activation_hook( __FILE__, 'flush_rewrite_rules' );

		add_action( 'admin_notices', array( $this, 'requirements_notice' ) );
		add_action( 'genesis_setup', array( $this, 'instantiate' ) );

	}

	/**
	 * Show admin notice if minimum requirements aren't met.
	 *
	 * @since 0.9.0
	 */
	public function requirements_notice() {

		if ( ! defined( 'PARENT_THEME_VERSION' ) || ! version_compare( PARENT_THEME_VERSION, $this->min_genesis_version, '>=' ) ) {

			$plugin = get_plugin_data( __FILE__ );

			$action = defined( 'PARENT_THEME_VERSION' ) ? __( 'upgrade to', 'genesis-simple-faq' ) : __( 'install and activate', 'genesis-simple-faq' );

			$message = sprintf( __( '%s requires WordPress %s and <a href="%s" target="_blank">Genesis %s</a>, or greater. Please %s the latest version of Genesis to use this plugin.', 'genesis-simple-faq' ), $plugin['Name'], $this->min_wp_version, 'http://my.studiopress.com/?download_id=91046d629e74d525b3f2978e404e7ffa', $this->min_genesis_version, $action );
			echo '<div class="notice notice-warning"><p>' . $message . '</p></div>';

		}

	}

	/**
	 * Load the plugin textdomain, for translation.
	 *
	 * @since 0.9.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( $this->plugin_textdomain, false, $this->plugin_dir_path . 'languages/' );
	}

	/**
	 * Include the class file, instantiate the classes, create objects.
	 *
	 * @since 0.9.0
	 */
	public function instantiate() {

		/**
		 * Instance of the plugin assets (loaded in the class).
		 */
		require_once( $this->plugin_dir_path . 'includes/class-gs-faq-assets.php' );
		$this->assets = new Genesis_Simple_FAQ_Assets;

		/**
		 * Instance of the Genesis Simple FAQ custom post type.
		 */
		require_once( $this->plugin_dir_path . 'includes/class-gs-faq-cpt.php' );
		$this->post_type = new Genesis_Simple_FAQ_CPT;

		/**
		 * Instance of the Genesis Simple FAQ taxonomy.
		 */
		require_once( $this->plugin_dir_path . 'includes/class-gs-faq-taxonomy.php' );
		$this->post_type_tax = new Genesis_Simple_FAQ_Tax;

		/**
		 * Instance of the Genesis Simple FAQ shortcode.
		 */
		require_once( $this->plugin_dir_path . 'includes/class-gs-faq-shortcode.php' );
		$this->shortcode = new Genesis_Simple_FAQ_Shortcode;

		/**
		 * Instance of the Genesis Simple FAQ Widget.
		 */
		require_once( $this->plugin_dir_path . 'includes/class-gs-faq-widget.php' );
		$this->widget = new Genesis_Simple_FAQ_Widget;
		add_action( 'widgets_init',  array( $this, 'register_widgets' ) );

	}

	/**
	 * Register Widget(s).
	 *
	 * @since 0.9.0
	 */
	public function register_widgets() {

		register_widget( 'Genesis_Simple_FAQ_Widget' );

	}

}

/**
 * Helper function to retrieve the static object without using globals.
 *
 * @since 0.9.0
 */
function Genesis_Simple_FAQ() {

	static $object;

	if ( null == $object ) {
		$object = new Genesis_Simple_FAQ;
	}

	return $object;

}

/**
 * Initialize the object on	`plugins_loaded`.
 */
add_action( 'plugins_loaded', array( Genesis_Simple_FAQ(), 'init' ) );
