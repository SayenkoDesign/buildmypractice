<?php

/*
Packages
		
*/
	
section_packages();
function section_packages() {
    
    $prefix = 'packages';
    $prefix = set_field_prefix( $prefix );
    
    $packages = get_field( 'packages' );
    
    $packages_heading = $packages['packages_heading'];
    
    $post_ids = $packages['packages'];
    
    if( empty( $post_ids ) ) {
        return false;
    }
                
            
    $loop = new WP_Query( array(
        'post_type' => 'package',
        'posts_per_page' => -1,
        'post__in' => $post_ids,
        'orderby' => 'post__in'
    ) );
    
    $items = '';
        
    if ( $loop->have_posts() ) : 
    
        while ( $loop->have_posts() ) :
        
            $loop->the_post();             
                                                                        
            $items .= _get_package( $loop->current_post +1 );
                        
        endwhile;
                    
    endif;
    
    wp_reset_postdata();
    
    if( empty( $items ) ) {
        return;        
    }
    
    $attr = array( 'id' => 'pricing-table', 'class' => 'section pricing-table' );
    
    _s_section_open( $attr );
        
        $heading        = $packages_heading;
        $heading        = _s_get_heading( $heading );
        
        if( !empty( $heading ) ) {
            printf( '<header class="entry-header">%s</header>', $heading );
        }    
        
                
        printf( '<div class="row small-up-1 large-up-3">%s</div>', $items );
    
    _s_section_close();	
        
}


function _get_package( $index ) {
    
    global $post;
    
    $heading = sprintf( '<li class="header">%s</li>', get_the_title() );
    
    $price = get_field( 'price' );
    if( ! empty( $price ) ) {
        $price = sprintf( '<li class="price">%s</li>', get_field( 'price' ) );
    }
    
    $description = get_field( 'description' );
    if( ! empty( $description ) ) {
        $description = sprintf( '<li class="description">%s</li>', get_field( 'description' ) );
    }
    
    $features = get_field( 'features' );
    
    $button = get_field( 'button' );
    if( ! empty( $button ) ) {
        $button = pb_get_cta_button( $button, array( 'class' => 'button orange' ) );
        $button = sprintf( '<li class="footer">%s</li>', $button );
    }
    
    
    $content = '';
    
    if( ! empty( $features ) ) {
        
        foreach( $features as $feature ) {
            
            $title = $feature['heading'];
            if( ! empty( $title ) ) {
                $title = sprintf( '<h4 class="title">%s</h4>', $title );
            }
            
            $label = $feature['divider_label'];
            
            $columns    = $feature['column'];
            $two_column = ( 2 == count( $columns ) ) ? true : false;
            
            $label = $two_column ? sprintf( '<span>%s</span>', $label ) : '';
            $group_class = $two_column ? ' class="grouped"' : '';
            
            $column_content_array = [];
            $column_content = '';
            
            if( ! empty( $columns ) ) {
                foreach( $columns as $column ) {
                    $photo = _s_get_acf_image( $column['photo'], 'medium' );
                    $text = $column['content'];
                    
                    $column_content_array[] = sprintf( '<div>%s%s</div>', $photo, $text );
                }
                
                $column_content = sprintf( '<div%s>%s</div>',  $group_class, join( $label, $column_content_array ) );
            }
            
            $footer = $feature['footer'];
            
            $content .= sprintf( '<li class="feature">%s%s%s</li>', $title, $column_content, $footer );
        }
    }
    
    $small_order = array(
        1 => 2,
        2 => 1,
        3 => 3
    );
    
    $column_classes = sprintf( ' small-order-%s large-order-%s', $small_order[$index], $index ) ;
    
    return sprintf( '<div class="column column-block%s"><ul class="no-bullet">%s%s%s%s%s</ul></div>', 
                    $column_classes, $heading, $price, $description, $content, $button );   
}