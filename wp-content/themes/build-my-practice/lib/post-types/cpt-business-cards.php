<?php

/**
 * CPT- Business Cards
 */

class CPT_Business_Cards extends CPT_Core {

    const POST_TYPE = 'business_card';
	const TEXTDOMAIN = '_s';
    
    var $capabilities = '';

	/**
     * Register Custom Post Types. See documentation in CPT_Core, and in wp-includes/post.php
     */
    public function __construct() {


		// Register this cpt
        // First parameter should be an array with Singular, Plural, and Registered name
        
        
        $this->capabilities = $this->compile_post_type_capabilities('business_card', 'business_cards' );
        
        parent::__construct(

        	array(
				__( 'Business Card', self::TEXTDOMAIN ), // Singular
				__( 'Business Cards', self::TEXTDOMAIN ), // Plural
				self::POST_TYPE // Registered name/slug
			),
			array(
				'public'              => true,
				'publicly_queryable'  => true,
				'show_ui'             => true,
				'query_var'           => true,
				'capability_type'     => 'business_card',
                'map_meta_cap'        => false,
                'capabilities'        => $this->capabilities,
				'has_archive'         => true,
				'hierarchical'        => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => false,
				'exclude_from_search' => true,
				'rewrite'             => array( 'slug' => 'business-cards' ),
 				'supports' => array( 'comments', 'author' ),
			)

        );
        
        
        add_action('after_switch_theme', function() {
            $role = get_role( 'administrator' );
            foreach ($this->capabilities as $capability) {
                $role->add_cap( $capability );
            }
        });
        
        
        
        add_action('switch_theme', function() {
            $role = get_role( 'administrator' );
            foreach ($this->capabilities as $capability) {
                $role->remove_cap( $capability );
            }
        });
        
        add_filter('pre_get_posts', array( $this, 'posts_for_current_author' ) );
        
        add_filter('wp_count_posts', array( $this, 'show_user_wp_count_posts' ), 10, 3);
        
        add_filter( 'wp_insert_post_data' , array( $this, 'modify_post_title' ) , '99', 2 );

        add_filter( 'parse_query', array( $this, 'prefix_parse_filter' ) );
        
        add_action('restrict_manage_posts', array( $this, 'add_extra_tablenav' ) );
        
        // turn off comment moderation
        add_filter('option_comment_moderation', array( $this, 'check_moderable_post_types' ) );

     } 
     
     
     
    function check_moderable_post_types( $value ) {
        if ( self::POST_TYPE == get_post_type() ) {
            return 0;
        }
        return $value;
    }
     

    public function modify_post_title( $data, $postarr ) {
        
        if ( self::POST_TYPE === $data['post_type'] && isset( $data['post_date'] ) ) {
			$post_title = 'Business Card';
			if ( $data['post_date'] ) {
				$post_title .= ' &ndash; ' . date_i18n( 'F j, Y @ h:i A', strtotime( $data['post_date'] ) );
			}
			$data['post_title'] = $post_title;
            //$data['post_name'] = absint( $postarr['ID'] );
		}
        

        return $data;
    }
     
     
     /**
	 * Registers admin columns to display. Hooked in via CPT_Core.
	 * @since  0.1.0
	 * @param  array  $columns Array of registered column names/labels
	 * @return array           Modified array
	 */
	public function columns( $columns ) {
		$new_column = array(
             'business_card_client' => 'Client',
		);
        
		/// return array_merge( $new_column, $columns );
        return array_slice( $columns, 0, 2, true ) + $new_column + array_slice( $columns, 1, null, true );
	}
     
     /**
	 * Handles admin column display. Hooked in via CPT_Core.
	 * @since  0.1.0
	 * @param  array  $column Array of registered column names
	 */
	public function columns_display( $column, $post_id ) {     
        
        switch ( $column ) {
            
            case 'business_card_client':
            $business_card_client = get_field( 'business_card_client', $post_id );
            if( absint( $business_card_client ) ) {
                $page = admin_url( 'edit.php' );
                $query_args = array( 'post_type' => self::POST_TYPE, 'client' => $business_card_client );
                $page = add_query_arg( $query_args, $page );
                printf( '<a href="%s">%s</a>', $page, get_the_title( $business_card_client ) );
            }
            break;
        }
           
	}
    
    
    
    function add_extra_tablenav($post_type){
    
        global $wpdb;
    
        /** Ensure this is the correct Post Type*/
        if( self::POST_TYPE != $post_type )
            return;
    
        /** Grab the results from the DB */
        $query = $wpdb->prepare('
            SELECT DISTINCT pm.meta_value FROM %1$s pm
            LEFT JOIN %2$s p ON p.ID = pm.post_id
            WHERE pm.meta_key = "%3$s" 
            AND p.post_status = "%4$s" 
            AND p.post_type = "%5$s"
            ORDER BY "%3$s"',
            $wpdb->postmeta,
            $wpdb->posts,
            'business_card_client', // Your meta key - change as required
            'publish',          // Post status - change as required
            $post_type,
            'post_title'
        );
        
        $results = $wpdb->get_col( $query );
    
        /** Ensure there are options to show */
        if(empty( $results ) )
            return;
    
        /** Grab all of the options that should be shown */
        $options[] = sprintf('<option value="">%1$s</option>', __('All Clients', '_s'));
        foreach( $results as $result ) :
            $selected = ( isset( $_GET['client'] ) && $result == $_GET['client'] ) ? 'selected="selected"' : ''; 
            $options[] = sprintf( '<option value="%1$s" %3$s>%2$s</option>', esc_attr( $result ), get_the_title( $result ), $selected );
        endforeach;
    
        /** Output the dropdown menu */
        echo '<select class="" id="client" name="client">';
        echo join( "\n", $options );
        echo '</select>';
    
    }

      
    public function  prefix_parse_filter($query) {
       global $pagenow;
       $current_page = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
    
       if ( is_admin() && 
         self::POST_TYPE == $current_page &&
         'edit.php' == $pagenow && 
          isset( $_GET['client'] ) && 
          $_GET['client'] != '') {
    
        $client_id = absint( $_GET['client'] );
        $query->query_vars['meta_key'] = 'business_card_client';
        $query->query_vars['meta_value'] = $client_id;
        $query->query_vars['meta_compare'] = '=';
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
      
     public function posts_for_current_author($query) {
        global $pagenow;
     
        //if( 'edit.php' != $pagenow || !$query->is_admin )
        if( !$query->is_admin )
            return $query;
     
        if( ! current_user_can( 'edit_others_posts' ) && ( 'edit.php' == $pagenow ) ) {
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

new CPT_Business_Cards();
