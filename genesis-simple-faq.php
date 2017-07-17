<?php
/*
Plugin Name: Genesis Simple FAQ
Plugin URI: https://github.com/copyblogger/genesis-simple-faq
Description: A plugin for the Genesis Framework to manage FAQ components via shortcodes.
Author: StudioPress
Author URI: http://www.studiopress.com/

Version: 0.9.0

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

		register_activation_hook( __FILE__, array( $this, 'activation' ) );

		$this->load_plugin_textdomain();
		$this->instantiate();

	}

	/**
	 * Plugin activation hook. Runs when plugin is activated.
	 *
	 * @since 0.9.0
	 */
	public function activation() {

		//* If Genesis is not the active theme, deactivate and die.
		if ( 'genesis' != get_option( 'template' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die( sprintf( __( 'Sorry, you can\'t activate unless you have installed <a href="%s">Genesis</a>', $this->plugin_textdomain ), 'http://my.studiopress.com/themes/genesis/' ) );
		}

		// Flush rewrite rules for CPT.
		flush_rewrite_rules();

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
		 * Instance of the Genesis Simple FAQ taxonomy.
		 */
		require_once( $this->plugin_dir_path . 'includes/class-gs-faq-taxonomy.php' );
		$this->post_type_tax = new Genesis_Simple_FAQ_Tax;

		/**
		 * Instance of the Genesis Simple FAQ custom post type.
		 */
		require_once( $this->plugin_dir_path . 'includes/class-gs-faq-cpt.php' );
		$this->post_type = new Genesis_Simple_FAQ_CPT;

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

		/**
		 * Instance of the plugin assets (loaded in the class).
		 */
		require_once( $this->plugin_dir_path . 'includes/class-gs-faq-assets.php' );
		$this->assets = new Genesis_Simple_FAQ_Assets;

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
