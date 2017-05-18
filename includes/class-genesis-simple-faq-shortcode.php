<?php

/**
 * A feature class.
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
	 * @param  array   $atts    Array of passed in attributes.
	 * @return string  $output  String of HTML to output.
	 */
	function genesis_simple_faq_shortcode($atts) {

		$a = shortcode_atts( array(
			'question' => '',
			'answer'   => '',
		), $atts );

		// Return empty string if question/answer parameters are not there.
		if ( empty( $a['question'] ) || empty( $a['answer'] ) ) {
			return '';
		}

		?>
		<div class="genesis-simple-faq">
			<button class="genesis-simple-faq__question" aria-expanded="false"><?php echo esc_html( $a['question'] ); ?></button>
			<div class="genesis-simple-faq__answer" aria-expanded="false"><?php echo $a['answer']; ?></div>
		</div>
		<?php

	}

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
