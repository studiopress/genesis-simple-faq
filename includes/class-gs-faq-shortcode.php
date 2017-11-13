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

		// Conditionally load dependencies.
		add_action( 'genesis_before', array( $this, 'load_dependencies' ) );

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
			'id'    => '',
			'cat'   => '',
			'limit' => -1,
		), $atts );

		// If IDs are set, use them. Otherwise retrieve all.
		$ids = '' !== $a['id'] ? explode( ',', $a['id'] ) : array();

		// If category IDs are set, use them. Otherwise retrieve all.
		$cats = '' !== $a['cat'] ? explode( ',', $a['cat'] ) : array();

		$args = array(
			'orderby'        => 'post__in',
			'post_type'      => 'gs_faq',
			'post__in'       => $ids,
			'posts_per_page' => $a['limit'],
		);

		if ( $cats ) {
			$args['tax_query'] = array(
				array(
					'terms'    => $cats,
					'taxonomy' => 'gs_faq_categories',
				),
			);
		}

		$faqs = new WP_Query( $args );

		$output = '';

		if ( $faqs->have_posts() ) {

			$output .= '<div class="gs-faq" role="tablist">';

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
	 * Load asset dependencies if shortcode is used.
	 *
	 * @since 0.9.0
	 */
	public function load_dependencies() {

		if ( ! is_singular() ) {
			return;
		}

		global $post;
		$content = $post->post_content;

		// Load assets if in post content.
		if ( has_shortcode( $content, 'gs_faq' ) ) {
			Genesis_Simple_FAQ()->assets->enqueue_scripts();
		}

	}

}
