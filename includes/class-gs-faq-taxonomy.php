<?php
/**
 * Class to handle taxonomy registering.
 *
 * @since 0.9.0
 */
class Genesis_Simple_FAQ_Tax {

    public function __construct() {
        add_action( 'init', array( $this, 'register_taxonomy' ) );
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

}
