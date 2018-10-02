<?php

/*
Section - Footer CTA
*/

 _s_footer_cta();
function _s_footer_cta() {
	
	global $post;
    
       
    if( is_post_type_archive( 'case_study' ) || is_singular( 'case_study' ) || is_tax( 'case_study_cat' ) ) {
		$post_id = CASE_STUDY_PAGE_ID;	
	}
    else if( is_home() || is_category() || is_author() || is_singular( 'post' ) ) {
        $post_id = get_option('page_for_posts');
    }
    else if( is_singular() ) {
        $post_id = get_the_ID();
    }
	else {
		$post_id = false;	
	}
	
	if( ! $post_id ) {
		return false;
	}
	
    	
 	$prefix = 'footer_cta';
	$prefix = set_field_prefix( $prefix );
	
	$show_in_footer = get_post_meta( $post_id, 'show_in_footer', true );
	
	if( ! $show_in_footer ) {
		return false;
	}
    
	$heading = get_field( 'cta_heading', $post_id );
    $heading = _s_get_heading( $heading );
    
    $button = get_field( 'cta_button_button', $post_id );
	$button = pb_get_cta_button( $button, array( 'class' => 'button orange' ) );
	
	if( !empty( $button ) ) {
		$button = sprintf( '<p>%s</p>', $button );
	}
				
	$attr = array( 'id' => 'footer-cta', 'class' => 'section footer-cta' );
					
	_s_section_open( $attr );
		printf( '<div class="column row">%s%s</div>', $heading, $button );
	_s_section_close();		
 }