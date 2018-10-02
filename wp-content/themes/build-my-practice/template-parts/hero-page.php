<?php

/*
Hero
		
*/

page_hero();
function page_hero() {
    global $post;
    
    $prefix = 'hero';
    $prefix = set_field_prefix( $prefix );
    
    $style = '';
    
    $attr = array( 'id' => 'hero', 'class' => 'section hero' );
    
    $heading 		        = get_field( sprintf( '%sheading', $prefix ), $event_category );
     
    $background_image	    = get_field( sprintf( '%sbackground_image', $prefix ), $event_category );
    $background_position_x	= get_field( sprintf( '%sbackground_position_x', $prefix ), $event_category );
    $background_position_y	= get_field( sprintf( '%sbackground_position_y', $prefix ), $event_category );
    
    $content = '';
        
    if( !empty( $background_image ) ) {
        $attachment_id = $background_image;
        $size = 'hero';
        $background = wp_get_attachment_image_src( $attachment_id, $size );
        $attr['style'] = sprintf( 'background-image: url(%s);', $background[0] );
        $attr['style'] .= sprintf( ' background-position: %s %s;', $background_position_x, $background_position_y );
    }
      
    $content = '';
    
    
    if( !empty( $heading ) ) {
        
        $heading = _s_wrap_text( $heading );
        
        $content .= sprintf( '<h1>%s</h1>', $heading );
    }
      
    _s_section_open( $attr );
            
        if( !empty( $content ) ) {
            
            print( '<div class="row"><div class="small-12 columns">' );

            printf( '<header class="entry-header">%s</header>', $content );
            
            echo '</div></div>';
        }
        
 
    _s_section_close();	   
        
}


function _get_page_hero_background( $post_id ) {
    
    $style= false;
    
    $prefix = 'hero';
    $prefix = set_field_prefix( $prefix );
    
    $background_image       = get_field( sprintf( '%sbackground_image', $prefix ), $post_id );
    $background_position_x  = get_field( sprintf( '%sbackground_position_x', $prefix ), $post_id );
    $background_position_y  = get_field( sprintf( '%sbackground_position_y', $prefix ), $post_id );
    
    if( !empty( $background_image ) ) {
        $attachment_id = $background_image;
        $size = 'hero';
        $background = wp_get_attachment_image_src( $attachment_id, $size );
        $style = sprintf( 'background-image: url(%s);', $background[0] );
        
        if( !empty( $style ) ) {
            $style .= sprintf( ' background-position: %s %s;', $background_position_x, $background_position_y );
        }
    }
    
    return $style;
}