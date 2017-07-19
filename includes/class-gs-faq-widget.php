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
	 * Holds widget id.
	 *
	 * @var string
	 */
	public $id_base = 'gs-faq-widget';

    /**
	 * Constructor. Set the default widget options and create widget.
	 */
	public function __construct() {

		// Conditionally load dependencies.
		if ( is_active_widget( '', '', $this->widget_id ) ) {
			add_action( 'wp_enqueue_scripts', array( Genesis_Simple_FAQ()->assets, 'enqueue_scripts' ), 11 );
		}

		$this->defaults = array(
			'title'    => '',
			'taxonomy' => '',
		);

		$widget_ops = array(
			'classname'   => 'gs-faq-widget',
			'description' => __( 'Displays Genesis Simple FAQs.', 'genesis-simple-faq' ),
		);

		$control_ops = array(
			'id_base' => $this->id_base,
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

		// The FAQ loop.
		$faqs = new WP_Query( array(
			'post_type' => 'gs_faq',
			'cat'       => $instance['taxonomy'],
		));

		if ( $faqs->have_posts() ) {

			echo '<div class="gs-faq">';

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
				echo apply_filters( 'gs_faq_template', $template, $question, $answer );
			}

			echo '</div>';

		} else {
			echo '<p>No FAQs were found.</p>';
		}

		wp_reset_query();

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

		$new_instance['title']    = strip_tags( $new_instance['title'] );
		$new_instance['taxonomy'] = intval( $new_instance['taxonomy'] );

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
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'genesis-simple-faq' ); ?>:</label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_name( 'taxonomy' ) ); ?>"><?php _e( 'Choose a category.', 'genesis-simple-faq' ); ?></label><br />
			<?php
			wp_dropdown_categories(
				array(
					'taxonomy'        => 'gs_faq_categories',
					'selected'        => $instance['cat'],
					'show_option_all' => 'All Categories',
				)
			);
			?>
		</p>
		<?php
	}

	function load_dependencies() {
		if ( ! is_admin() && is_active_widget( '', '', $this->id_base ) ) {
			Genesis_Simple_FAQ()->assets->enqueue_scripts();
		}
	}
}

add_action( 'widgets_init', function() {
    register_widget( 'Genesis_Simple_FAQ_Widget' );
});
