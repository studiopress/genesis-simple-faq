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

		// Register shortcode.
		add_shortcode( 'genesis_faq', array( $this, 'genesis_simple_faq_shortcode' ) );

		// Print critical styles to header.
		add_action( 'wp_head', array( $this, 'genesis_simple_faq_print_styles' ) );

		// Register and maybe load scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'genesis_simple_faq_register_scripts' ) );
		add_action( 'genesis_before', array( $this, 'genesis_simple_faq_load_content_scripts' ) );

		// Include widget support for shortcode and asset loading.
		add_filter( 'widget_text',        array( $this, 'genesis_simple_faq_load_widget_scripts'  ) );
		add_filter( 'widget_text',        'do_shortcode'                                            );

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
	 * Function to register plugin assets in the queue.
	 *
	 * @return void
	 *
	 * @since 0.9.0
	 */
	function genesis_simple_faq_register_scripts() {

		$vanilla_path = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG )
			? 'vanilla.genesis-simple-faq.js'
			: 'min/vanilla.genesis-simple-faq.min.js';

		$jquery_path = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG )
			? 'jquery.genesis-simple-faq.js'
			: 'min/jquery.genesis-simple-faq.min.js';

		wp_register_script( 'genesis-simple-faq-jquery-js', plugin_dir_url( __FILE__ ) . '../assets/js/' . $jquery_path, array( 'jquery' ), '0.9.0', true );
		wp_register_script( 'genesis-simple-faq-vanilla-js', plugin_dir_url( __FILE__ ) . '../assets/js/' . $vanilla_path, array(), '0.9.0', true );

	}

	/**
	 * Function to output the plugin's basic styles.
	 *
	 * @return void
	 *
	 * @since 0.9.0
	 */
	function genesis_simple_faq_print_styles() {

		$styles = sprintf(
			'.genesis-simple-faq {
				padding: 5px 0;
			}

			.genesis-simple-faq__question {
				display: block;
				text-align: left;
				width: 100%%;
			}

			.genesis-simple-faq__answer {
				display: none;
				padding: 5px;
			}'
		);

		$css = sprintf( '<style type="text/css" id="genesis-simple-faq-critical">%s</style>', apply_filters( 'genesis_simple_faq_print_styles', $this->minifyCSS( $styles ) ) );

		echo $css;

	}

	/**
	 * Helper function to minify CSS output.
	 *
	 * @param  string $css CSS to minify.
	 * @return string      Minified string to output.
	 *
	 * @since 0.9.0
	 */
	private function minifyCSS( $css ) {
		return str_replace('; ',';',str_replace(' }','}',str_replace('{ ','{',str_replace(array("\r\n","\r","\n","\t",'  ','    ','    '),"",preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!','',$css)))));
	}

	/**
	 * Load the scripts and styles on the front-end if required.
	 *
	 * @return void
	 *
	 * @since 0.9.0
	 */
	function genesis_simple_faq_load_content_scripts() {

		global $post;
		$content = $post->post_content;

		// Load assets if in post content.
		if ( has_shortcode( $content, 'genesis_faq' ) ) {
			$this->genesis_simple_faq_scripts();
		}

	}

	/**
	 * Function to load the FAQ assets if a widget text contains it.
	 *
	 * @param  string  $widget_text The widget text string.
	 * @return void
	 *
	 * @since 0.9.0
	 */
	function genesis_simple_faq_load_widget_scripts( $widget_text ) {

		// Load assets if in widget text content.
		if ( has_shortcode( $widget_text, 'genesis_faq' ) ) {
			$this->genesis_simple_faq_scripts();
		}

		return $widget_text;

	}

	/**
	 * Helper function to load appropriate FAQ assets.
	 *
	 * @return void
	 *
	 * @since 0.9.0
	 */
	function genesis_simple_faq_scripts() {

		if ( wp_script_is( 'jquery', 'registered' ) ) {
			wp_enqueue_script( 'genesis-simple-faq-jquery-js' );
		} else {
			wp_enqueue_script( 'genesis-simple-faq-vanilla-js' );
		}

		wp_localize_script(
			'genesis-simple-faq-jquery-js',
			'genesis_simple_faq_animation',
			array(
				'js_animation' => apply_filters( 'genesis_simple_faq_js_animation', true ),
			)
		);

	}

}
