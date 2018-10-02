<?php

/**
 * CPT- Jobs
 */

class CPT_Jobs extends CPT_Core {

    const POST_TYPE = 'job';
	const TEXTDOMAIN = '_s';

	/**
     * Register Custom Post Types. See documentation in CPT_Core, and in wp-includes/post.php
     */
    public function __construct() {


		// Register this cpt
        // First parameter should be an array with Singular, Plural, and Registered name
        
        $capabilities = $this->compile_post_type_capabilities('job', 'jobs' );
        
        parent::__construct(

        	array(
				__( 'Job', self::TEXTDOMAIN ), // Singular
				__( 'Jobs', self::TEXTDOMAIN ), // Plural
				self::POST_TYPE // Registered name/slug
			),
			array(
				'public'              => true,
				'publicly_queryable'  => true,
				'show_ui'             => true,
				'query_var'           => true,
				'capability_type'     => 'job',
                'map_meta_cap'        => false,
                'capabilities'        => $capabilities,
				'has_archive'         => true,
				'hierarchical'        => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => false,
				'exclude_from_search' => true,
				'rewrite'             => array( 'slug' => 'jobs' ),
 				'supports' => array( 'comments' ),
			)

        );
        
        
        add_action('after_switch_theme', function() {
            $role = get_role( 'administrator' );
            $capabilities = $this->compile_post_type_capabilities('job', 'jobs' );
            foreach ($capabilities as $capability) {
                $role->add_cap( $capability );
            }
        });
        
        
        
        add_action('switch_theme', function() {
            $role = get_role( 'administrator' );
            $capabilities = $this->compile_post_type_capabilities('job', 'jobs' );
            foreach ($capabilities as $capability) {
                $role->remove_cap( $capability );
            }
        });
        
        add_filter('pre_get_posts', array( $this, 'posts_for_current_author' ) );
        
        add_filter('wp_count_posts', array( $this, 'show_user_wp_count_posts' ), 10, 3);
        
        
  
     } 
     
     
     /**
	 * Registers admin columns to display. Hooked in via CPT_Core.
	 * @since  0.1.0
	 * @param  array  $columns Array of registered column names/labels
	 * @return array           Modified array
	 */
	public function columns( $columns ) {
		$new_column = array(
			'job_title' => 'Title',
		);
        
        unset( $columns['title'] );
		return array_merge( $new_column, $columns );
	}
     
     /**
	 * Handles admin column display. Hooked in via CPT_Core.
	 * @since  0.1.0
	 * @param  array  $column Array of registered column names
	 */
	public function columns_display( $column, $post_id ) {
		
        // variables
        $post               = get_post( $post_id );
        $title              = _draft_or_post_title();
        $post_type_object   = get_post_type_object( $post->post_type );
        $can_edit_post      = current_user_can( 'edit_post', $post->ID );       
        
        switch ( $column ) {
			case 'job_title':
				printf(
					__( '%1$s', '_s' ),
					'<a href="' . admin_url( 'post.php?post=' . absint( $post->ID ) . '&action=edit' ) . '" class="row-title"><strong>Job #' . esc_attr( $post->ID ) . '</strong></a>'
				);
         
                
                echo '<button type="button" class="toggle-row"><span class="screen-reader-text">' . __( 'Show more details', 'woocommerce' ) . '</span></button>';
                
                // set up row actions
                $actions = array();
                if ( $can_edit_post && 'trash' != $post->post_status ) {
                    $actions['edit'] = '<a href="' . get_edit_post_link( $post->ID, true ) . '" title="' . esc_attr( __( 'Edit this item' ) ) . '">' . __( 'Edit' ) . '</a>';
                    
                }
                if ( current_user_can( 'delete_post', $post->ID ) ) {
                    if ( 'trash' == $post->post_status )
                        $actions['untrash'] = "<a title='" . esc_attr( __( 'Restore this item from the Trash' ) ) . "' href='" . wp_nonce_url( admin_url( sprintf( $post_type_object->_edit_link . '&amp;action=untrash', $post->ID ) ), 'untrash-post_' . $post->ID ) . "'>" . __( 'Restore' ) . "</a>";
                    elseif ( EMPTY_TRASH_DAYS )
                        $actions['trash'] = "<a class='submitdelete' title='" . esc_attr( __( 'Move this item to the Trash' ) ) . "' href='" . get_delete_post_link( $post->ID ) . "'>" . __( 'Trash' ) . "</a>";
                    if ( 'trash' == $post->post_status || !EMPTY_TRASH_DAYS )
                        $actions['delete'] = "<a class='submitdelete' title='" . esc_attr( __( 'Delete this item permanently' ) ) . "' href='" . get_delete_post_link( $post->ID, '', true ) . "'>" . __( 'Delete Permanently' ) . "</a>";
                }
                if ( $post_type_object->public ) {
                    if ( in_array( $post->post_status, array( 'pending', 'draft', 'future' ) ) ) {
                        if ( $can_edit_post ) {
                            $preview_link = set_url_scheme( get_permalink( $post->ID ) );
                            /** This filter is documented in wp-admin/includes/meta-boxes.php */
                            $preview_link = apply_filters( 'preview_post_link', add_query_arg( 'preview', 'true', $preview_link ), $post );
                            $actions['view'] = '<a href="' . esc_url( $preview_link ) . '" title="' . esc_attr( sprintf( __( 'Preview &#8220;%s&#8221;' ), $title ) ) . '" rel="permalink">' . __( 'Preview' ) . '</a>';
                        }
                    } elseif ( 'trash' != $post->post_status ) {
                        $actions['view'] = '<a href="' . get_permalink( $post->ID ) . '" title="' . esc_attr( sprintf( __( 'View &#8220;%s&#8221;' ), $title ) ) . '" rel="permalink">' . __( 'View' ) . '</a>';
                    }
                }
        
                // invoke row actions
                $table = new WP_Posts_List_Table;
                echo $table->row_actions( $actions, true );
				break;
		}
	}

     
     
     
     
     
     private function compile_post_type_capabilities( $singular = 'post', $plural = 'posts' ) {
        
        
        return [
            'edit_post'                 => "edit_$singular",
            'read_post'                 => "read_$singular",
            'delete_post'               => "delete_$singular",
            'edit_posts'                => "edit_$plural",
            'edit_others_posts'         => "edit_others_$plural",
            'publish_posts'             => "publish_$plural",
            'read_private_posts'        => "read_private_$plural",
            'read'                      => "read",
            'delete_posts'              => "delete_$plural",
            'delete_private_posts'      => "delete_private_$plural",
            'delete_published_posts'    => "delete_published_$plural",
            'delete_others_posts'       => "delete_others_$plural",
            'edit_private_posts'        => "edit_private_$plural",
            'edit_published_posts'      => "edit_published_$plural",
            'create_posts'              => "edit_$plural",
        ];
    }
     
    private function add_roles() {
        add_role('job_author', 'Job Author', array (
            'publish_jobs' => true,
            'edit_jobs' => true,
            'edit_others_jobs' => false,
            'delete_jobs' => true,
            'delete_others_jobs' => false,
            'read_private_jobs' => true,
            'edit_job' => true,
            'delete_job' => true,
            'read_job' => true,
            // more standard capabilities here
            'read' => true,
        ));
   
     }
     
     
     public function posts_for_current_author($query) {
        global $pagenow;
     
        //if( 'edit.php' != $pagenow || !$query->is_admin )
        if( !$query->is_admin )
            return $query;
     
        if( !current_user_can( 'edit_others_posts' ) ) {
            global $user_ID;
            $query->set('author', $user_ID );
        }
        return $query;
    }




    /**
     * Modify returned post counts by status for the current post type.
     *  Only retrieve counts of own items for users without rights to 'edit_others_posts'
     *
     * @since   26 June 2014
     * @version 26 June 2014
     * @author  W. van Dam
     *
     * @notes   Based on wp_count_posts (wp-includes/posts.php)
     *
     * @param object $counts An object containing the current post_type's post
     *                       counts by status.
     * @param string $type   Post type.
     * @param string $perm   The permission to determine if the posts are 'readable'
     *                       by the current user.
     * 
     * @return object Number of posts for each status
     */
    function show_user_wp_count_posts( $counts, $type, $perm ) {
        global $wpdb;
    
        // We only want to modify the counts shown in admin and depending on $perm being 'readable' 
        if ( ! is_admin() || 'readable' !== $perm ) {
            return $counts;
        }
    
        // Only modify the counts if the user is not allowed to edit the posts of others
        $post_type_object = get_post_type_object($type);
        if (current_user_can( $post_type_object->cap->edit_others_posts ) ) {
            return $counts;
        }
    
        $query = "SELECT post_status, COUNT( * ) AS num_posts FROM {$wpdb->posts} WHERE post_type = %s AND (post_author = %d) GROUP BY post_status";
        $results = (array) $wpdb->get_results( $wpdb->prepare( $query, $type, get_current_user_id() ), ARRAY_A );
        $counts = array_fill_keys( get_post_stati(), 0 );
    
        foreach ( $results as $row ) {
            $counts[ $row['post_status'] ] = $row['num_posts'];
        }
    
        return (object) $counts;
    }

}

new CPT_Jobs();
