<?php
/**
 * Plugin Name: Genesis Simple FAQ
 * Plugin URI: https://github.com/studiopress/genesis-simple-faq
 *
 * Description: A plugin for the Genesis Framework to manage FAQ components via shortcodes.
 *
 * Author: StudioPress
 * Author URI: https://www.studiopress.com/
 *
 * Version: 0.9.2
 *
 * Text Domain: genesis-simple-faq
 * Domain Path: /languages
 *
 * License: GPL-2.0-or-later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package genesis-simple-faq
 */

define( 'GENESIS_SIMPLE_PLUGIN_VERSION', '0.9.2' );
define( 'GENESIS_SIMPLE_FAQ_DIR', plugin_dir_path( __FILE__ ) );
define( 'GENESIS_SIMPLE_FAQ_URL', plugins_url( '', __FILE__ ) );

require_once GENESIS_SIMPLE_FAQ_DIR . '/includes/class-genesis-simple-faq.php';

/**
 * Helper function to retrieve the static object without using globals.
 *
 * @since 0.9.0
 */
function genesis_simple_faq() {

	static $object;

	if ( null === $object ) {
		$object = new Genesis_Simple_FAQ();
	}

	return $object;
}


// Initialize the object on	`plugins_loaded`.
add_action( 'plugins_loaded', array( Genesis_Simple_FAQ(), 'init' ) );
