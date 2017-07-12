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
		add_shortcode( 'gs_faq', array( $this, 'shortcode' ) );

		// Print critical styles to header.
		add_action( 'wp_head', array( $this, 'print_critical_styles' ) );

		// Register and maybe load scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts'     ) );
		add_action( 'genesis_before',     array( $this, 'load_content_scripts' ) );

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
	function shortcode( $atts ) {

		$a = shortcode_atts( array(
			'id'  => '',
			'cat' => '',
		), $atts );

		// If IDs are set, use them. Otherwise retrieve all.
		$ids = '' !== $a['id'] ? explode( ',', $a['id'] ) : array();

		// If category IDs are set, use them. Otherwise retrieve all.
		$cats = '' !== $a['cat'] ? explode( ',', $a['cat'] ) : array();

		// Query arguments.
		$args = array(
			'orderby'    => 'post__in',
			'post_type'  => 'gs_faq',
			'post__in'   => $ids,
			'cat'        => $cats,
		);

		// The loop.
		$faqs = new WP_Query( $args );

		if ( $faqs->have_posts() ) {

			$output = '<div class="gs-faq">';

			while ( $faqs->have_posts() ) {
				$faqs->the_post();

				$question = get_the_title();
				$answer   = wpautop( get_the_content() );
				$template = sprintf(
					'<button class="gs-faq__question" type="button">%1$s</button><div class="gs-faq__answer no-animation"><h2 class="gs-faq__answer__heading">%1$s</h2>%2$s</div>',
					esc_html( $question ),
					$answer
				);

				// Allow filtering of the template markup.
				$output .= apply_filters( 'gs_faq_template', $template, $question, $answer );
			}

			$output .= '</div>';

		}

		wp_reset_query();

		return $output;

	}

	/**
	 * Function to register plugin assets in the queue.
	 *
	 * @return void
	 *
	 * @since 0.9.0
	 */
	function register_scripts() {

		$vanilla_path = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG )
			? 'vanilla.genesis-simple-faq.js'
			: 'min/vanilla.genesis-simple-faq.min.js';

		$jquery_path = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG )
			? 'jquery.genesis-simple-faq.js'
			: 'min/jquery.genesis-simple-faq.min.js';

		wp_register_script( 'gs-faq-jquery-js',  plugin_dir_url( __FILE__ ) . '../assets/js/' . $jquery_path,   array( 'jquery' ), '0.9.0', true );
		wp_register_script( 'gs-faq-vanilla-js', plugin_dir_url( __FILE__ ) . '../assets/js/' . $vanilla_path, array(),           '0.9.0', true );

	}

	/**
	 * Function to output the plugin's basic styles.
	 *
	 * @return void
	 *
	 * @since 0.9.0
	 */
	function print_critical_styles() {

		$styles = sprintf(
			'.gs-faq {
				padding: 5px 0;
			}

			.gs-faq__question {
				display: block;
				margin-top: 20px;
				text-align: left;
				width: 100%%;
			}

			.gs-faq__question:first-of-type {
				margin-top: 0;
			}

			.gs-faq__answer {
				display: none;
				padding: 5px;
			}

			.gs-faq__answer__heading {
				display: none;
			}

			.gs-faq__answer.no-animation.gs-faq--expanded {
				display: block;
			}'
		);

		$css = sprintf( '<style type="text/css" id="gs-faq-critical">%s</style>', apply_filters( 'gs_faq_critical_styles', $this->minifyCSS( $styles ) ) );

		echo $css;

	}

	/**
	 * Load the scripts and styles on the front-end if required.
	 *
	 * @return void
	 *
	 * @since 0.9.0
	 */
	function load_content_scripts() {

		global $post;
		$content = $post->post_content;

		// Load assets if in post content.
		if ( has_shortcode( $content, 'gs_faq' ) ) {
			$this->enqueue_scripts();
		}

	}

	/**
	 * Helper function to load appropriate FAQ assets.
	 *
	 * @return void
	 *
	 * @since 0.9.0
	 */
	function enqueue_scripts() {

		if ( wp_script_is( 'jquery', 'registered' ) ) {
			wp_enqueue_script( 'gs-faq-jquery-js' );
		} else {
			wp_enqueue_script( 'gs-faq-vanilla-js' );
		}

		wp_localize_script(
			'gs-faq-jquery-js',
			'gs_faq_animation',
			array(
				'js_animation' => apply_filters( 'gs_faq_js_animation', true ),
			)
		);

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

}
