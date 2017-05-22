<?php
/**
 * Class to handle shortcode creation, rendering, and asset loading.
 *
 * @since 0.9.0
 */
class Genesis_Simple_FAQ_Shortcode {

	/**
	 * Constructor function initiates the shortcode.
	 *
	 * @return void
	 *
	 * @since 0.9.0
	 */
	public function __construct() {

		// Register scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'genesis_simple_faq_scripts' ) );

		// Register shortcode.
		add_shortcode( 'genesis_faq', array( $this, 'genesis_simple_faq_shortcode' ) );
	}

	/**
	 * Shortcode builder function.
	 *
	 * @param  array   $atts    Array of passed in attributes.
	 * @param  array   $content The content the shortcode is wrapped around.
	 * @return string  $faq     String of HTML to output.
	 *
	 * @since 0.9.0
	 */
	function genesis_simple_faq_shortcode( $atts, $content = "" ) {

		$a = shortcode_atts( array(
			'title' => __( 'Show Hidden Content', 'genesis-simple-faq' ),
		), $atts );

		$faq = sprintf( '<div class="genesis-simple-faq">
					<button class="genesis-simple-faq__question" aria-expanded="false">%s</button>
					<div class="genesis-simple-faq__answer" aria-expanded="false">%s</div>
				</div>
		', esc_html( $a['title'] ), $content );

		return apply_filters( 'genesis_simple_faq_output', $faq, $a, $content );

	}

	/**
	 * Load the scripts and styles on the front-end if required.
	 *
	 * @return void
	 *
	 * @since 0.9.0
	 */
	function genesis_simple_faq_scripts() {

		global $post;
		$content = $post->post_content;

		wp_register_script( 'genesis-simple-faq-js', plugin_dir_url( __FILE__ ) . '../assets/js/genesis-simple-faq.js', array('jquery'), '0.9.0', true );
		wp_register_style( 'genesis-simple-faq-css', plugin_dir_url( __FILE__ ) . '../assets/css/genesis-simple-faq.css', array(), '0.9.0' );

		if ( has_shortcode( $content, 'genesis_faq' ) ) {

			// Enqueue JS and CSS.
			wp_enqueue_script( 'genesis-simple-faq-js'  );
			wp_enqueue_style(  'genesis-simple-faq-css' );

			wp_localize_script(
				'genesis-simple-faq-js',
				'genesis_simple_faq_animation',
				array(
					'js_animation' => apply_filters( 'genesis_simple_faq_js_animation', true ),
				)
			);
		}

	}

}
