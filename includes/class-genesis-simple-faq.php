<?php
/**
 * Genesis Simple FAQ main class.
 *
 * @package genesis-simple-faq
 */

/**
 * The main class.
 *
 * @since 0.9.0
 */
final class Genesis_Simple_FAQ {

	/**
	 * Plugin version
	 *
	 * @var string
	 */
	public $plugin_version = GENESIS_SIMPLE_PLUGIN_VERSION;

	/**
	 * Minimum WordPress version
	 *
	 * @var string
	 */
	public $min_wp_version = '4.8';

	/**
	 * Minimum Genesis version
	 *
	 * @var string
	 */
	public $min_genesis_version = '2.5';

	/**
	 * The plugin textdomain, for translations.
	 *
	 * @var string
	 */
	public $plugin_textdomain = 'genesis-simple-faq';

	/**
	 * The url to the plugin directory.
	 *
	 * @var string
	 */
	public $plugin_dir_url;

	/**
	 * The path to the plugin directory.
	 *
	 * @var string
	 */
	public $plugin_dir_path;

	/**
	 * Post type object.
	 *
	 * @var WP_Post
	 */
	public $post_type;

	/**
	 * Post type taxonomy.
	 *
	 * @var Object
	 */
	public $post_type_tax;

	/**
	 * Shortcode object.
	 *
	 * @var string
	 */
	public $shortcode;

	/**
	 * Widget object.
	 *
	 * @var WP_Widget
	 */
	public $widget;

	/**
	 * Assets object.
	 *
	 * @var Genesis_Simple_FAQ_Assets
	 */
	public $assets;

	/**
	 * Constructor.
	 *
	 * @since 0.9.0
	 */
	public function __construct() {

		$this->plugin_dir_url  = GENESIS_SIMPLE_FAQ_URL;
		$this->plugin_dir_path = GENESIS_SIMPLE_FAQ_DIR;

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

			$plugin = get_plugin_data( $this->plugin_dir_path . 'genesis-simple-faq.php' );

			$action = defined( 'PARENT_THEME_VERSION' ) ? __( 'upgrade to', 'genesis-simple-faq' ) : __( 'install and activate', 'genesis-simple-faq' );

			/* translators: 1 is the Plugin name, 2 is the minimum WordPress version, 4 is the Genesis download link and 4 is action, upgrade or install. */
			$message = sprintf( __( '%1$s requires WordPress %2$s and <a href="%3$s" target="_blank">Genesis %4$s</a>, or greater. Please %5$s the latest version of Genesis to use this plugin.', 'genesis-simple-faq' ), $plugin['Name'], $this->min_wp_version, 'http://my.studiopress.com/?download_id=91046d629e74d525b3f2978e404e7ffa', $this->min_genesis_version, $action );

			$allowed_tag = array(
				'a' => array(
					'href'   => array(),
					'target' => array(),
				),
			);

			echo '<div class="notice notice-warning"><p>' . wp_kses( $message, $allowed_tag ) . '</p></div>';

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
		require_once $this->plugin_dir_path . 'includes/class-genesis-simple-faq-assets.php';
		$this->assets = new Genesis_Simple_FAQ_Assets();

		/**
		 * Instance of the Genesis Simple FAQ custom post type.
		 */
		require_once $this->plugin_dir_path . 'includes/class-genesis-simple-faq-cpt.php';
		$this->post_type = new Genesis_Simple_FAQ_CPT();

		/**
		 * Instance of the Genesis Simple FAQ taxonomy.
		 */
		require_once $this->plugin_dir_path . 'includes/class-genesis-simple-faq-taxonomy.php';
		$this->post_type_tax = new Genesis_Simple_FAQ_Taxonomy();

		/**
		 * Instance of the Genesis Simple FAQ shortcode.
		 */
		require_once $this->plugin_dir_path . 'includes/class-genesis-simple-faq-shortcode.php';
		$this->shortcode = new Genesis_Simple_FAQ_Shortcode();

		/**
		 * Instance of the Genesis Simple FAQ Widget.
		 */
		require_once $this->plugin_dir_path . 'includes/class-genesis-simple-faq-widget.php';
		$this->widget = new Genesis_Simple_FAQ_Widget();
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );

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
