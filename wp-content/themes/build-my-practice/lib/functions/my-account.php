<?php

class My_Account {
    
    var $current_user_id;
    var $current_post_id;
    
    public function __construct( $current_user_id = false ) {
        
        global $post;
        $this->current_post_id = $post->ID;
        
        //$current_user_id = 4; // Set to Client #1 for testing
                
        $this->current_user_id = false !== $current_user_id ? $current_user_id : get_current_user_id();
        
        //add_filter( 'the_title', array( $this, 'bmp_service_title' ), 10, 2 );
    }
    
    
    public function bmp_service_title( $title, $id = null ) {

        $custom_title = get_field( 'custom_title', $id );
        
        if ( !empty( $custom_title ) ) {
            return $custom_title;
        }
    
        return $title;
    }

    
    
    public function get_client() {
        
        $args = array(
            'post_type'      => 'client',
            'post_status'    => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'client',
                    'value' => '"' . $this->current_user_id . '"',
                    'compare' => 'LIKE'
                )
            )
        );
                    
        // Use $loop, a custom variable we made up, so it doesn't overwrite anything
        $loop = new WP_Query( $args );
    
        $found_posts = $loop->found_posts;
          
        if( $found_posts ) {
            $data = $loop->post;
            wp_reset_postdata();
            return $data;
        }
        
        return false;
        
    }
    
    public function get_revisions( $post_type = false ) {
        
        if( empty( $post_type ) ) {
            return false;
        }
                
        $client = $this->get_client();
        
        if( ! is_object( $client ) ) {
            return false;
        }
                
        // Get the actual client post type ID
				        
        $prefix = set_field_prefix( $post_type );
        
        $args = array(
            'post_type'      => $post_type,
            'post_status'    => 'publish',
            'post__not_in' => array( $this->current_post_id ),
            'meta_query' => array(
                array(
                    'key' => sprintf( '%sclient', $prefix ),
                    'value' => $client->ID,
                    'compare' => '='
                )
            )
        );          
                      
        // Use $loop, a custom variable we made up, so it doesn't overwrite anything
        $loop = new WP_Query( $args );
    
        // have_posts() is a wrapper function for $wp_query->have_posts(). Since we
        // don't want to use $wp_query, use our custom variable instead.
        if ( $loop->have_posts() ) : 
            
            $links = '';
            
            $count = 1;
            
            while ( $loop->have_posts() ) : $loop->the_post(); 
            
               
                
                $date = date_i18n( 'm/d/y', get_the_time('U') );
                $title = sprintf( 'Revision #%s - %s', $count, $date );
                
                $custom_title = get_field( 'custom_title' );
        
                if ( !empty( $custom_title ) ) {
                    $title = $custom_title;
                }
                
                $links .= sprintf( '<li><a href="%s" class="button light-blue">%s</a></li>', get_permalink(), $title  );
                
                $count ++;
                
            endwhile;
            
        endif;
    
        wp_reset_postdata();   
        
        if( !empty( $links ) ) {
            return sprintf( '<h2>Previous Revisions</h2><ul class="menu">%s</ul>', $links );
        }
    }
    
    
    public function get_business_card_link() {
        
        $client = $this->get_client();
        
        if( ! is_object( $client ) ) {
            return false;
        }

        $prefix = 'business_card';
        $prefix = set_field_prefix( $prefix );
        
        $args = array(
            'post_type'      => 'business_card',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'meta_query' => array(
                array(
                    'key' => sprintf( '%sclient', $prefix ),
                    'value' => $client->ID,
                    'compare' => '='
                )
            )
        );
          
                      
        // Use $loop, a custom variable we made up, so it doesn't overwrite anything
        $loop = new WP_Query( $args );
        
        $found_posts = $loop->found_posts;
          
        if( $found_posts ) {
            $data = $loop->post;
            wp_reset_postdata();
            return $data;
        }
        
        return false;    
        
    }    
    
    public function get_logo_link() {
        
        $client = $this->get_client();
        
        if( ! is_object( $client ) ) {
            return false;
        }

        $prefix = 'logo';
        $prefix = set_field_prefix( $prefix );
        
        $args = array(
            'post_type'      => 'logo',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'meta_query' => array(
                array(
                    'key' => sprintf( '%sclient', $prefix ),
                    'value' => $client->ID,
                    'compare' => '='
                )
            )
        );
          
                      
        // Use $loop, a custom variable we made up, so it doesn't overwrite anything
        $loop = new WP_Query( $args );
        
        $found_posts = $loop->found_posts;
          
        if( $found_posts ) {
            $data = $loop->post;
            wp_reset_postdata();
            return $data;
        }
        
        return false;    
        
    }
    
    
    private function revisions( $type = false ) {
        
        $client = $this->get_client();
                
        if( ! is_object( $client ) ) {
            return false;
        }

        $prefix = set_field_prefix( $type );
        
        $args = array(
            'post_type'      => $type,
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'meta_query' => array(
                array(
                    'key' => sprintf( '%sclient', $prefix ),
                    'value' => $client->ID,
                    'compare' => '='
                )
            )
        );
                  
                      
        // Use $loop, a custom variable we made up, so it doesn't overwrite anything
        $loop = new WP_Query( $args );
                
        if ( $loop->have_posts() ) : 
                    
            while ( $loop->have_posts() ) : $loop->the_post(); 
            
                $revisions = get_field( 'revisions' );
                                
                if( ! empty( $revisions ) ) {
                    
                    $tab_args = array( 'class' => 'tabs', 
                       'id' => 'revision-tabs', 
                       'data' => array( 'data-tabs' => 'revision-tabs' )
                     );

                    $fa_tabs = new Foundation_Tabs( $tab_args );
                    $fa_tabs->clear();
                    
                    foreach( $revisions as $key => $revision ) {
                        $active = $key ? false : true;
                        $label  = $revision['label'];
                        $label  = ( 'Revision' == $label ) ? sprintf( '%s - %s', $label, $key + 1 ) : $label;
                        
                        $attachment = $revision['photo'];
                        $pdf        = $revision['pdf'];
                        
                        if( ! empty( $pdf ) ) {
                            $pdf = sprintf( '<a href="%s" class="button light-blue">View PDF</a>', $pdf );
                        }
                        
                        $background = _s_get_acf_image( $attachment, 'large', true ); 
                        if( ! empty( $background ) ) {
                            $background = sprintf( 'style="background: url(%s)"', $background );
                            
                            $content = sprintf( '<div class="business-card" %s>%s</div>', $background, $pdf );
                            
                            $args = array( 'title' => $label, 'content' => $content, 'active' => $active );
            
                            $fa_tabs->add_tab( $args );
                        }                        
                    }
                    
                    
                    if( count( $revisions ) > 1 ) {
                        echo $fa_tabs->get_tabs();
                    }
                    
                    echo $fa_tabs->get_panels();
                }
                                                
                if ( comments_open() || get_comments_number() ) :
                    comments_template( '/comments-services.php' );
                else:
                    
                    $download_link = get_field( 'download_link' );
                    
                    if( ! empty( $download_link ) ) {
                        printf( '<a href="%s" class="button blue">Download File</a>', $download_link );
                    }
                
                endif;
                
            endwhile;
            
        endif;
    
        wp_reset_postdata();   
    
        
    }
    
    
    public function the_business_card() {
        
        $prefix = 'business_card';
        
        $this->revisions( $prefix );
        
    }
    
    
    public function the_logo() {
        
        $prefix = 'logo';
        
        $this->revisions( $prefix );
        
    }
    
}


function _s_get_author_name( $user_id = false )  {
    $fname = get_the_author_meta('first_name', $user_id );
    $lname = get_the_author_meta('last_name', $user_id );
    $full_name = '';
    
    if( empty($fname)){
        $full_name = $lname;
    } elseif( empty( $lname )){
        $full_name = $fname;
    } else {
        //both first name and last name are present
        $full_name = "{$fname} {$lname}";
    }
    
    return $full_name;   
}


function bmp_comment( $comment, $depth, $args ) {
        $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
        $tag = 'div';
?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                 <div class="comment-content">
                    <?php comment_text(); ?>
                </div><!-- .comment-content -->
                
                <footer class="comment-meta">
                    <div class="comment-author vcard">
                        <?php
                        printf( '<p>%s</p>', _s_get_author_name( $comment->user_id ) );
                        ?>
                    </div><!-- .comment-author -->
 
                    <div class="comment-metadata">
                        <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
                            <time datetime="<?php comment_time( 'c' ); ?>">
                                <?php printf( _x( '%1$s at %2$s', '1: date, 2: time' ), get_comment_date(), get_comment_time() ); ?>
                            </time>
                        </a>
                        <?php //edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
                    </div><!-- .comment-metadata -->
 
                    <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
                    <?php endif; ?>
                </footer><!-- .comment-meta -->
 
                <?php
                /*comment_reply_link( array_merge( $args, array(
                    'add_below' => 'div-comment',
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'],
                    'before'    => '<div class="reply">',
                    'after'     => '</div>'
                ) ) );*/
                ?>
            </article><!-- .comment-body -->
<?php
}