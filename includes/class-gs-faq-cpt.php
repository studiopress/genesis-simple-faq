<?php
/**
 * Class to handle post type creation.
 *
 * @since 0.9.0
 */
class Genesis_Simple_FAQ_CPT {

	public function __construct() {

		add_action( 'init',                  array( $this, 'register_cpt'             ) );
		add_action( 'init',                  array( $this, 'add_faq_shortcode_column' ) );
		add_filter( 'post_updated_messages', array( $this, 'cpt_updated_messages'     ) );

	}

	/**
	 * Function to register the post type.
	 *
	 * @return void
	 *
	 * @since 0.9.0
	 */
	function register_cpt() {

		register_post_type( 'gs_faq', $this->cpt_args() );

	}

	/**
	 * Function to return post type arguments.
	 *
	 * @return array args An array of post type arguments.
	 *
	 * @since 0.9.0
	 */
	function cpt_args() {

		$args = array(
			'labels' => array(
				'name' => __( 'Genesis Simple FAQs', 'genesis-simple-faq' ),
				'singular_name' => __( 'Genesis Simple FAQ', 'genesis-simple-faq' ),
				'menu_name'     => __( 'Simple FAQs', 'genesis-simple-faq' ),
				'add_new'       => _x( 'Add New', 'genesis-simple-faq' ),
				'add_new_item'  => __( 'Add New FAQ', 'genesis-simple-faq' ),
				'edit_item'     => __( 'Edit FAQ', 'genesis-simple-faq' ),
				'new_item'      => __( 'New FAQ', 'genesis-simple-faq' ),
				'view_item'     => __( 'View FAQ', 'genesis-simple-faq' ),
				'view_items'    => __( 'View FAQs', 'genesis-simple-faq' ),
				'search_items'  => __( 'Search FAQs', 'genesis-simple-faq' ),
				'not_found'     => __( 'No FAQs found', 'genesis-simple-faq' ),
				'not_found_in_trash' => __( 'No FAQs found in Trash', 'genesis-simple-faq' ),
				'all_items'          => __( 'All FAQs', 'genesis-simple-faq' ),
				'insert_into_item'   => __( 'Insert into FAQ', 'genesis-simple-faq' ),
				'uploaded_to_this_item' => __( 'Uploaded to this FAQ', 'genesis-simple-faq' ),
			),
			'show_ui'       => true,
			'show_in_menu'  => true,
			'menu_position' => 25,
			'menu_icon'     => 'dashicons-list-view',
			'supports'      => array(
				'title',
				'editor',
				'revisions',
			),
			'taxonomies'    => array( 'gs_faq_categories' ),
			'show_in_rest'  => true,
		);

		return $args;

	}

	/**
	 * Function to modify the updated messages for the post type.
	 *
	 * @param  array  $messages Existing post update messages.
	 * @return array            New update messages.
	 *
	 * @since 0.9.0
	 */
	function cpt_updated_messages( $messages ) {

		$post             = get_post();
		$post_type        = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );

		$messages['gs_faq'] = array(
			1  => __( 'FAQ updated.', 'genesis-simple-faq' ),
			2  => __( 'Custom field updated.', 'genesis-simple-faq' ),
			3  => __( 'Custom field deleted.', 'genesis-simple-faq' ),
			4  => __( 'FAQ updated.', 'genesis-simple-faq' ),
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'FAQ restored to revision from %s', 'genesis-simple-faq' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => __( 'FAQ published.', 'genesis-simple-faq' ),
			7  => __( 'FAQ saved.', 'genesis-simple-faq' ),
			8  => __( 'FAQ submitted.', 'genesis-simple-faq' ),
			9  => sprintf(
				__( 'FAQ scheduled for: <strong>%1$s</strong>.', 'genesis-simple-faq' ),
				date_i18n( __( 'M j, Y @ G:i', 'genesis-simple-faq' ), strtotime( $post->post_date ) )
			),
			10 => __( 'FAQ draft updated.', 'genesis-simple-faq' )
		);

		return $messages;

	}

	/**
	 * Function to modify the FAQ's table columns and add a shortcode snippet.
	 *
	 * @since 0.9.0
	 */
	function add_faq_shortcode_column() {

		add_filter( 'manage_gs_faq_posts_columns',       array( $this, 'faq_shortcode_column_head' ) );
		add_action( 'manage_gs_faq_posts_custom_column', array( $this, 'faq_shortcode_column_content' ), 10, 2 );

	}

	/**
	 * Filter the post column generation to add the FAQ column.
	 *
	 * @param  array $columns  Default array of column headings.
	 * @return array           Updated array of column headings.
	 *
	 * @since 0.9.0
	 */
	function faq_shortcode_column_head( $columns ) {

		$columns['gs_faq'] = __( 'Shortcode', 'genesis-simple-faq' );
		return $columns;

	}

	/**
	 * Generate the output for the shortcode column.
	 *
	 * @param  string $column_name Title of the column.
	 * @param  int    $post_ID     ID of the current post.
	 * @return void
	 *
	 * @since 0.9.0
	 */
	function faq_shortcode_column_content( $column_name, $post_ID ) {

		if ( 'gs_faq' === $column_name ) {
			echo '[gs_faq id="' . $post_ID . '"]';
		}

	}

}
