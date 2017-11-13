<?php
/**
 * Class to handle taxonomy registering.
 *
 * @since 0.9.0
 */
class Genesis_Simple_FAQ_Tax {

    public function __construct() {
        add_action( 'init', array( $this, 'register_taxonomy' ) );
        add_action( 'init', array( $this, 'add_faq_shortcode_column' ) );
    }

    function register_taxonomy() {
        register_taxonomy(
            'gs_faq_categories',
            'gs_faq',
            array(
                'label'        => __( 'Categories', 'genesis-simple-faq' ),
                'public'       => false,
                'rewrite'      => false,
                'show_ui'      => true,
                'hierarchical' => true,
            )
        );
        register_taxonomy_for_object_type( 'gs_faq_categories', 'gs_faq' );
    }

    /**
	 * Function to modify the FAQ's Category table columns and add a shortcode snippet.
	 *
	 * @since 0.9.1
	 */
	function add_faq_shortcode_column() {

        add_filter( 'manage_edit-gs_faq_categories_columns',  array( $this, 'faq_shortcode_column_head' ) );
        add_action( 'manage_gs_faq_categories_custom_column', array( $this, 'faq_shortcode_column_content' ), 10, 3 );

    }

    /**
     * Filter the post column generation to add the FAQ column.
     *
     * @param  array $columns  Default array of column headings.
     * @return array           Updated array of column headings.
     *
     * @since 0.9.1
     */
    function faq_shortcode_column_head( $columns ) {

        $columns['gs_faq'] = __( 'Shortcode', 'genesis-simple-faq' );
        return $columns;

    }

    /**
     * Generate the output for the shortcode column.
     *
     * @param  string $content     String of content.
     * @param  string $column_name Title of the column.
     * @param  int    $term_id     ID of the current post.
     * @return void
     *
     * @since 0.9.1
     */
    function faq_shortcode_column_content( $content, $column_name, $term_id ) {

        if ( 'gs_faq' === $column_name ) {
            $content = '[gs_faq cat="' . $term_id . '"]';
        }

        return $content;

    }

}
