<?php
/**
 * Class to handle post type creation.
 *
 * @since 0.9.0
 */
class Genesis_Simple_FAQ_CPT {

	public function __construct() {
		add_action( 'init', array( $this, 'genesis_simple_faq_register_cpt' ) );
	}

	/**
	 * Function to register the post type.
	 *
	 * @return void
	 *
	 * @since 0.9.0
	 */
	function genesis_simple_faq_register_cpt() {
		register_post_type( 'genesis-simple-faq', $this->genesis_simple_faq_cpt_args() );
	}

	/**
	 * Function to return post type arguments.
	 *
	 * @return array args An array of post type arguments.
	 *
	 * @since 0.9.0
	 */
	function genesis_simple_faq_cpt_args() {

		$args = array(
			'labels' => array(
				'name' => __( 'Genesis Simple FAQs', 'genesis-simple-faq' ),
				'singular_name' => __( 'Genesis Simple FAQs', 'genesis-simple-faq' ),
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
			'taxonomies'    => array( 'category' ),
			'show_in_rest'  => true,
		);

		return $args;

	}

}
