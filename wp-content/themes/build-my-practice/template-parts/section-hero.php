<?php

/*
Hero
		
*/
	section_hero();
    function section_hero() {
        global $post;
        
        $prefix = 'hero';
        $prefix = set_field_prefix( $prefix );
    
        $heading 		= get_field( sprintf( '%sheading', $prefix ) );
        $description	= get_field( sprintf( '%sdescription', $prefix ) );
        
        $background_image = get_post_meta( get_the_ID(), sprintf( '%sbackground_image', $prefix ), true );
        $background_position_x  = get_field( sprintf( '%sbackground_position_x', $prefix ) );
        $background_position_y  = get_field( sprintf( '%sbackground_position_y', $prefix ) );
        $hero_overlay           = get_field( sprintf( '%shero_overlay', $prefix ) );
        $hero_overlay           = $hero_overlay ? ' hero-overlay' : '';
        
        $button	            = get_field( sprintf( '%sbutton', $prefix ) );
        
        $style = '';
        $header = '';
        $content = '';
         
        if( !empty( $background_image ) ) {
            $attachment_id = $background_image;
            $size = 'hero';
            $background = wp_get_attachment_image_src( $attachment_id, $size );
            $style = sprintf( 'background-image: url(%s);', $background[0] );
            
            if( !empty( $style ) ) {
                $style .= sprintf( ' background-position: %s %s;', $background_position_x, $background_position_y );
            }
        }
        
        
        if( !empty( $description ) ) {
            $description = _s_wrap_text( $description, "\n" );
            $description = _s_get_heading( nl2br( $description ) );
         }
              
        if( !empty( $heading ) ) {
            $header = _s_get_heading( $heading, 'h1' );
            $header = sprintf( '<header class="entry-header">%s%s</header>', $header, $description );
        }
         
        
        // Video
        if( !empty( $button ) ) {
            $button = pb_get_cta_button( $button, array( 'class' => 'button orange' ) );
            $content = sprintf( '<div class="entry-content"><p>%s</p></div>', $button );
        }
    
        $args = array(
            'html5'   => '<section %s>',
            'context' => 'section',
            'attr' => array( 'id' => 'hero', 'class' => 'section hero flex', 'style' => $style ),
            'echo' => false
        );
        
        $args['attr']['class'] .= $hero_overlay;
        
        $out = _s_markup( $args );
        $out .= _s_structural_wrap( 'open', false );
        
        
        $out .= sprintf( '<div class="row"><div class="small-12 columns text-center">%s%s</div></div>', $header, $content );
        
        $out .= _s_structural_wrap( 'close', false );
        $out .= '</section>';
        
        echo $out;
            
    }