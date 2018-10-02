<?php
 
/**
 * Create new CPT - Case Studies
 */
 
class CPT_CASE_STUDY extends CPT_Core {

    const POST_TYPE = 'case_study';
	const TEXTDOMAIN = '_s';
	
	/**
     * Register Custom Post Types. See documentation in CPT_Core, and in wp-includes/post.php
     */
    public function __construct() {

 		
		// Register this cpt
        // First parameter should be an array with Singular, Plural, and Registered name
        parent::__construct(
        
        	array(
				__( 'Case Study', self::TEXTDOMAIN ), // Singular
				__( 'Case Studies', self::TEXTDOMAIN ), // Plural
				self::POST_TYPE // Registered name/slug
			),
			array( 
				'public'              => true,
				'publicly_queryable'  => true,
				'show_ui'             => true,
				'query_var'           => true,
				'capability_type'     => 'post',
				'has_archive'         => true,
				'hierarchical'        => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => false,
				'exclude_from_search' => false,
				'rewrite'             => array( 'slug' => 'case-studies' ),
				'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'revisions' ),
				 )

        );
		
			 add_action( 'pre_get_posts', array( $this,'pre_get_posts' ) );

     }
	 

    function pre_get_posts( $query ){
 	
        if ( $query->is_main_query() && ! is_admin() && ( is_post_type_archive( 'case_study' ) || is_tax( 'case_study_cat' ) ) ) {
            $query->set( 'posts_per_page', '-1' );
        }
      }
 
}

new CPT_CASE_STUDY();


$cpt_case_study_categories = array(
    __( 'Case Study Category', CPT_CASE_STUDY::TEXTDOMAIN ), // Singular
    __( 'Case Study Categories', CPT_CASE_STUDY::TEXTDOMAIN ), // Plural
    'case_study_cat' // Registered name
);

register_via_taxonomy_core( $cpt_case_study_categories, 
	array(
		//'public' => false,
        'rewrite' => array( 'slug' => 'case-studies-category' ),
	), 
	array( CPT_CASE_STUDY::POST_TYPE ) 
);
