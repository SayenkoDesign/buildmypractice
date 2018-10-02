<?php

// Hero
section_my_account_hero();
function section_my_account_hero() {
    
    $post_id = MY_ACCOUNT_PAGE_ID;
    
    $prefix = 'hero';
    $prefix = set_field_prefix( $prefix );
    
    $current_user = wp_get_current_user();
    $name = $current_user->user_login;
    if( $current_user->user_firstname ) {
        $name = $current_user->user_firstname;
    }

    $heading	= 'My Dashboard';
    
    $background_image       = get_post_meta( $post_id, sprintf( '%sbackground_image', $prefix ), true );
    $background_position_x  = get_field( sprintf( '%sbackground_position_x', $prefix ), $post_id );
    $background_position_y  = get_field( sprintf( '%sbackground_position_y', $prefix ), $post_id );
    $hero_overlay           = get_field( sprintf( '%shero_overlay', $prefix ), $post_id );
    $hero_overlay           = $hero_overlay ? ' hero-overlay' : '';
        
    $style = '';
    $header = '';
     
    if( !empty( $background_image ) ) {
        $attachment_id = $background_image;
        $size = 'hero';
        $background = wp_get_attachment_image_src( $attachment_id, $size );
        $style = sprintf( 'background-image: url(%s);', $background[0] );
        
        if( !empty( $style ) ) {
            $style .= sprintf( ' background-position: %s %s;', $background_position_x, $background_position_y );
        }
    }
    
    
    
    if( !empty( $heading ) ) {
        $header = _s_get_heading( $heading, 'h1' );
        $name   = _s_get_heading( sprintf( 'Welcome, %s', $name ), 'h4' );
        $header = sprintf( '<header class="entry-header">%s%s</header>', $name, $header );
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
    
    
    $out .= sprintf( '<div class="row"><div class="small-12 columns text-center">%s</div></div>', $header );
    
    $out .= _s_structural_wrap( 'close', false );
    $out .= '</section>';
    
    echo $out;
        
}