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
