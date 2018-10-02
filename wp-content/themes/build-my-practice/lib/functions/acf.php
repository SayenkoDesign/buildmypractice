<?php

/**
*  Creates ACF Options Page(s)
*/


if( function_exists('acf_add_options_sub_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme Settings',
		'menu_title' 	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-settings',
		'capability' 	=> 'edit_posts',
 		'redirect' 	=> false
	));
    
    /*
 	 acf_add_options_page(array(
		'page_title' 	=> 'Error 404 Page Settings',
		'menu_title' 	=> 'Error 404 Page Settings',
        'menu_slug' 	=> 'theme-settings-404',
        'parent' 		=> 'theme-settings',
		'capability' => 'edit_posts',
 		'redirect' 	=> false
	));
    */

}


function _s_get_acf_image( $attachment_id, $size = 'large', $background = FALSE ) {

	if( ! absint( $attachment_id ) )
		return FALSE;

	if( wp_is_mobile() ) {
 		$size = 'large';
	}

	if( $background ) {
		$background = wp_get_attachment_image_src( $attachment_id, $size );
		return $background[0];
	}

	return wp_get_attachment_image( $attachment_id, $size );

}


function _s_get_acf_oembed( $iframe ) {


	// use preg_match to find iframe src
	preg_match('/src="(.+?)"/', $iframe, $matches);
	$src = $matches[1];


	// add extra params to iframe src
	$params = array(
		'controls'    => 1,
		'hd'        => 1,
		'autohide'    => 1,
		'rel' => 0
	);

	$new_src = add_query_arg($params, $src);

	$iframe = str_replace($src, $new_src, $iframe);


	// add extra attributes to iframe html
	$attributes = 'frameborder="0"';

	$iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);

	$iframe = sprintf( '<div class="embed-container">%s</div>', $iframe );


	// echo $iframe
	return $iframe;
}



// filter for a specific field based on it's name
add_filter('acf/fields/relationship/query/name=related_posts', 'my_relationship_query', 10, 3);
function my_relationship_query( $args, $field, $post_id ) {
	
    // exclude current post from being selected
    $args['exclude'] = $post_id;
	
	
	// return
    return $args;
    
}



function alter_specific_user_field( $result, $user, $field, $post_id ) {

    $result = $user->user_email;

    if( $user->first_name ) {
        
        $result .= ' (' .  $user->first_name;
        
        if( $user->last_name ) {
            
            $result .= ' ' . $user->last_name;
            
        }
        
        $result .= ')';
    }

    return $result;
}
add_filter("acf/fields/user/result", 'alter_specific_user_field', 10, 4);