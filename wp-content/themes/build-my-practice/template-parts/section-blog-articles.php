<?php

/*
Case Studies
		
*/
	
section_blog_articles();
function section_blog_articles() {
    
    $prefix = 'blog_articles';
    $prefix = set_field_prefix( $prefix );
    
    $loop = new WP_Query( array(
        'post_type' => 'post',
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'posts_per_page' => 12,
    ) );
        
    $posts = get_field( sprintf( '%sposts', $prefix ) );
    
    if( !empty( $posts ) ) {
        $args['post__in'] = $posts;
        $args['orderby'] = 'post__in';
    }
    
    $items = '';
    
    if ( $loop->have_posts() ) : 
                                
        while ( $loop->have_posts() ) : $loop->the_post();
              
            $items .= _blog_article();
 
        endwhile; 
         
    endif;
    
    // Reset things, for good measure
    $loop = null;
    
    wp_reset_postdata();
    
    if( empty( $items ) ) {
        return false;
    }
    
    $attr = array( 'id' => 'blog-articles', 'class' => 'section blog-articles' );
    
    _s_section_open( $attr );
        
        $heading        = get_field( sprintf( '%sheading', $prefix ) );
        $heading        = _s_get_heading( $heading );
        $subheading     = get_field( sprintf( '%ssubheading', $prefix ) );
        $subheading     = _s_get_heading( $subheading, 'h4' );
        
        if( !empty( $heading ) ) {
            printf( '<header class="entry-header">%s%s</header>', $heading, $subheading );
        }
                
        printf( '<div class="slick-posts">%s</div>', $items );
    
    _s_section_close();	
        
}


function _blog_article() {
    
    $background = get_the_post_thumbnail_url( get_the_ID(), 'large' );
    
    if( !empty( $background ) ) {
        $background = sprintf( ' style="background-image: url(%s);"', $background );
    }
    
          
    $title = sprintf( '<h3>%s</h3>', get_the_title() );
                      
    $excerpt = _s_get_the_excerpt( '', '', 20 );
    
    $button = sprintf( '<p><a href="%s" class="button blue">See Article</a></p>', 
                      get_permalink() );
                      
    $description = sprintf( '<div class="hover">%s%s</div>', $excerpt, $button );
     
    return sprintf( '<div class="post"><div class="background" %s></div><div class="details">%s%s</div></div>', $background, $title, $description );   
}