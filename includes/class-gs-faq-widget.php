<?php
/**
 * Class to handle widget creation and behavior.
 *
 * @since 0.9.0
 */
class Genesis_Simple_FAQ_Widget extends WP_Widget {

    /**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $defaults;

    	/**
	 * Constructor. Set the default widget options and create widget.
	 */
	public function __construct() {

		$this->defaults = array(
			'title'          => '',
			'faqs'	         => '',
			'cat'            => '',
		);

		$widget_ops = array(
			'classname'   => 'gs-faq-widget',
			'description' => __( 'Displays Genesis Simple FAQs.', 'genesis-simple-faq' ),
		);

		$control_ops = array(
			'id_base' => 'gs-faq-widget',
			'width'   => 200,
			'height'  => 250,
		);

		parent::__construct( 'gs-faq-widget', __( 'Genesis Simple FAQ', 'genesis-simple-faq' ), $widget_ops, $control_ops );

	}

	/**
	 * Echo the widget content.
	 *
	 * @param array $args     Display arguments including `before_title`, `after_title`,
	 *                        `before_widget`, and `after_widget`.
	 * @param array $instance The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {

		// Merge with defaults.
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo $args['before_widget'];

			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title']; // WPCS: prefix ok.
			}

			$text = '';

			if ( ! empty( $instance['alignment'] ) ) {
				$text .= '<span class="align' . esc_attr( $instance['alignment'] ) . '">';
			}

			$text .= get_avatar( $instance['user'], $instance['size'] );

			if( ! empty( $instance['alignment'] ) ) {
				$text .= '</span>';
			}

			if ( 'text' === $instance['author_info'] ) {
				$text .= $instance['bio_text']; // We run KSES on update.
			} else {
				$text .= get_the_author_meta( 'description', $instance['user'] );
			}

			$text .= $instance['page'] ? sprintf( ' <a class="pagelink" href="%s">%s</a>', get_page_link( $instance['page'] ), $instance['page_link_text'] ) : '';

			echo wpautop( $text );

			// If posts link option checked, add posts link to output.
			$display_name = get_the_author_meta( 'display_name', $instance['user'] );
			$user_name = ( ! empty ( $display_name ) && genesis_a11y( 'screen-reader-text' ) ) ? '<span class="screen-reader-text">' . $display_name. ': </span>' : '';

			if ( $instance['posts_link'] ) {
				printf( '<div class="posts_link posts-link"><a href="%s">%s%s</a></div>', get_author_posts_url( $instance['user'] ), $user_name, __( 'View My Blog Posts', 'genesis' ) );
			}

		echo $args['after_widget'];

	}

	/**
	 * Update a particular instance.
	 *
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @param array $new_instance New settings for this instance as input by the user via `form()`.
	 * @param array $old_instance Old settings for this instance.
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {

		$new_instance['title']          = strip_tags( $new_instance['title'] );
		$new_instance['bio_text']       = current_user_can( 'unfiltered_html' ) ? $new_instance['bio_text'] : genesis_formatting_kses( $new_instance['bio_text'] );
		$new_instance['page_link_text'] = strip_tags( $new_instance['page_link_text'] );

		return $new_instance;

	}

	/**
	 * Echo the settings update form.
	 *
	 * @param array $instance Current settings.
	 * @return void
	 */
	public function form( $instance ) {

		// Merge with defaults.
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'genesis' ); ?>:</label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_name( 'cat' ) ); ?>"><?php _e( 'Choose a category.', 'genesis' ); ?></label><br />
			<?php
			wp_dropdown_categories(
				array(
					'taxonomy'       => 'genesis_faq_categories',
					'selected'       => $instance['cat'],
				)
			);
			?>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'page_link_text' ) ); ?>"><?php _e( 'Extended page link text', 'genesis' ); ?>:</label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'page_link_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'page_link_text' ) ); ?>" value="<?php echo esc_attr( $instance['page_link_text'] ); ?>" class="widefat" />
		</p>

		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'posts_link' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'posts_link' ) ); ?>" value="1" <?php checked( $instance['posts_link'] ); ?>/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'posts_link' ) ); ?>"><?php _e( 'Show Author Archive Link?', 'genesis' ); ?></label>
		</p>
		<?php

	}
}

add_action( 'widgets_init', function() {
    register_widget( 'Genesis_Simple_FAQ_Widget' );
});
