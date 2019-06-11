<?php
/**
 * This file handles asset loading.
 *
 * @since 0.9.0
 */
class Genesis_Simple_FAQ_Assets {

	/**
	 * Constructor.
	 *
	 * @since 0.9.0
	 */
    public function __construct() {

		// Print critical styles to header.
		add_action( 'wp_head', array( $this, 'print_critical_styles' ) );

		// Register and maybe load scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );

    }

	/**
	 * Function to register plugin assets for later enqueuing.
	 *
	 * @return void
	 *
	 * @since 0.9.0
	 */
	public function register_scripts() {

		$vanilla_path = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG )
			? 'vanilla.genesis-simple-faq.js'
			: 'min/vanilla.genesis-simple-faq.min.js';

		$jquery_path = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG )
			? 'jquery.genesis-simple-faq.js'
			: 'min/jquery.genesis-simple-faq.min.js';

		wp_register_script( 'gs-faq-jquery-js',  plugin_dir_url( __FILE__ ) . '../assets/js/' . $jquery_path,  array( 'jquery' ), Genesis_Simple_FAQ()->plugin_version, true );
		wp_register_script( 'gs-faq-vanilla-js', plugin_dir_url( __FILE__ ) . '../assets/js/' . $vanilla_path, array(),           Genesis_Simple_FAQ()->plugin_version, true );

	}

	/**
	 * Function to load appropriate FAQ assets.
	 *
	 * @return void
	 *
	 * @since 0.9.0
	 */
	public function enqueue_scripts() {

		if ( wp_script_is( 'jquery', 'registered' ) ) {
			wp_enqueue_script( 'gs-faq-jquery-js' );
			wp_localize_script(
				'gs-faq-jquery-js',
				'gs_faq_animation',
				array(
					'js_animation' => apply_filters( 'gs_faq_js_animation', true ),
				)
			);
		} else {
			wp_enqueue_script( 'gs-faq-vanilla-js' );
		}

	}

	/**
	 * Function to output the plugin's basic styles.
	 *
	 * @return void
	 *
	 * @since 0.9.1
	 */
	public function print_critical_styles() {

		$print = apply_filters( 'gs_faq_print_styles', true );

		if ( $print === false ) {
			return;
		}

		$styles =
			'.gs-faq {
				padding: 5px 0;
			}

			.gs-faq__question {
				display: none;
				margin-top: 10px;
				text-align: left;
				white-space: normal;
				width: 100%;
			}

			.js .gs-faq__question {
				display: block;
			}

			.gs-faq__question:first-of-type {
				margin-top: 0;
			}

			.js .gs-faq__answer {
				display: none;
				padding: 5px;
			}

			.gs-faq__answer p:last-of-type {
				margin-bottom: 0;
			}

			.js .gs-faq__answer__heading {
				display: none;
			}

			.gs-faq__answer.no-animation.gs-faq--expanded {
				display: block;
			}';

		$css = sprintf( '<style type="text/css" id="gs-faq-critical">%s</style>', apply_filters( 'gs_faq_critical_styles', $this->minifyCSS( $styles ) ) );

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

}
