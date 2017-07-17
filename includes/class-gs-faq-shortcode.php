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

}
