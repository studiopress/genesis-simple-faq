<?php

/**
 * The theme purchase admin page.
 */
class Plugin_Boilerplate_AJAX extends Genesis_Admin_Basic {

	/**
	 * The AJAX Action for this feature class.
	 */
	public $ajax_action = 'plugin_boilerplate_ajax';

	/**
	 * Constructor.
	 */
	public function __construct() {}

	/**
	 * Build the admin menu, init the AJAX.
	 *
	 * @since 0.9.0
	 */
	public function admin_menu() {

		$page_id = 'plugin_boilerplate_ajax';

		/**
		 * You can also make this a top level menu by following the example in Genesis.
		 * @link https://github.com/copyblogger/genesis/blob/develop/lib/admin/theme-settings.php
		 */
		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'genesis', // Where should this submenu go?
				'page_title'  => __( 'StudioPress Themes', 'sp-purchase' ),
				'menu_title'  => __( 'StudioPress Themes', 'sp-purchase' ),
			),
		);

		$this->create( $page_id, $menu_ops );

		// Register AJAX action callback
		add_action( 'wp_ajax_' . $this->ajax_action, array( $this, 'ajax_action_callback' ) );

	}

	/**
	 * The code that will respond to your AJAX request.
	 *
	 * @since 0.9.0
	 */
	public function ajax_action_callback() {

		// Nonce check
		if ( check_ajax_referer( $this->ajax_action, 'nonce', false ) ) {
			die( '0' );
		}

		// You can either die('0'), die('1'), or echo a custom string. Even JSON.
		// Your response here will determine how your AJAX JS code should display.

		die( '0' );

	}

	/**
	 * Enqueue scripts for this admin page.
	 *
	 * @since 0.9.0
	 */
	public function scripts() {

		wp_enqueue_script( 'plugin-boilerplate-ajax', Plugin_Boilerplate()->plugin_dir_url . 'assets/js/ajax.js', array( 'jquery' ), Plugin_Boilerplate()->plugin_version, true );
		wp_localize_script( 'plugin-boilerplate-ajax', $this->ajax_action, array(
			'nonce'           => wp_create_nonce( $this->ajax_action . '_nonce' ),
		) );

	}

	/**
	 * The admin view.
	 *
	 * @since 0.9.0
	 */
	public function admin() {

		require_once( Plugin_Boilerplate()->plugin_dir_path . 'includes/views/ajax-admin.php' );

	}

}
