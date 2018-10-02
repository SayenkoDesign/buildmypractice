<?php

function _s_blog_template_redirect( $template ) {
	if ( is_author() || is_search() ) 
		$template = get_query_template( 'home' );	
	return $template;
}
add_filter( 'template_include', '_s_blog_template_redirect' );	


function _s_add_blog_class( $classes ) {
  
  if ( is_category() || is_author() || is_search() ) {
      $classes[] = 'blog';
  }
   return $classes;
}
add_filter( 'body_class', '_s_add_blog_class' );


 
function _s_get_post_author( $size = 90, $user_id = false ) {
    global $post;
    
    if( false == $user_id ) {
        $author_id = get_the_author_meta('ID');
    }
    else {
        $author_id = $user_id;
    }
    
    if( empty( $author_id ) ) {
        return false;
    }
    
    $display_name = get_the_author_meta('display_name', $author_id );
    $author_image = '';
    if( $avatar = get_avatar( $author_id, $size ) ) {
         $author_url = get_author_posts_url( $author_id ); 
         return sprintf( '<div class="post-author"><a href="%s">%s<p>%s</p></a></div>',$author_url, $avatar, $display_name );
    }
    
    return '';
        
}


function _s_get_the_author_meta( $field, $user_id = false ) {
    
    if ( in_array( $field, array( 'login', 'pass', 'nicename', 'email', 'url', 'registered', 'activation_key', 'status' ) ) )
		return get_the_author_meta( $field, $user_id );
    
    $author_id = ! $user_id ? get_the_author_meta('ID') : $user_id;
    $value = get_field( $field, 'user_'. $author_id );
    
    return !empty( $value ) ? $value : '';
}


function _s_modify_user_contact_methods( $user_contact ) {

	// Add user contact methods
	$user_contact['facebook']   = __( 'Facebook URL' );
	$user_contact['twitter'] = __( 'Twitter URL' );
    $user_contact['instagram'] = __( 'Instagram URL' );
    $user_contact['youtube'] = __( 'YouTube URL' );
    
	return $user_contact;
}
add_filter( 'user_contactmethods', '_s_modify_user_contact_methods' );



// Callback function to remove default bio field from user profile page & re-title the section
// ------------------------------------------------------------------

if( !function_exists( 'remove_plain_bio' ) ){
	function remove_bio_box($buffer){
		$buffer = str_replace('<h2>About Yourself</h2>','',$buffer);
		$buffer = preg_replace('/<tr class=\"user-description-wrap\"[\s\S]*?<\/tr>/','',$buffer,1);
		return $buffer;
	}
	function user_profile_subject_start(){ ob_start('remove_bio_box'); }
	function user_profile_subject_end(){ ob_end_flush(); }
}
add_action('admin_head-profile.php','user_profile_subject_start');
add_action('admin_footer-profile.php','user_profile_subject_end');


function _s_get_post_terms( $post_id ) {
    $taxonomy = 'category';
    $terms = wp_get_post_terms( $post_id, $taxonomy );
    if( !is_wp_error( $terms ) && !empty( $terms ) ) {
        $out = '';
        foreach( $terms as $term ) {
            $term_class = sanitize_title( $term->name );
        $out .= sprintf( '<li><a href="%s" class="term-link %s">%s<span>%s</span></a></li>', get_term_link( $term->slug, $taxonomy ), $term_class, get_svg( $term_class ), $term->name );
        }
        
        return sprintf( '<ul class="post-categories">%s</ul>', $out );
        
    }
    
}


function _s_get_post_term( $post_id ) {
    $taxonomy = 'category';
    $terms = wp_get_post_terms( $post_id, $taxonomy );
    if( !is_wp_error( $terms ) ) {
        $term = array_pop($terms);
        $term_class = sanitize_title( $term->name );
        return sprintf( '<a href="%s" class="term-link %s">%s<span>%s</span></a>', get_term_link( $term->slug, $taxonomy ), $term_class, get_svg( $term_class ), $term->name );
    }
    
}


function comment_form_submit_button($button) {
    $button = sprintf( "<button class='submit button'><span>%s</span></button>", 'Post Comment' ) . //Add your html codes here
    get_comment_id_fields();
    return $button;
}
add_filter('comment_form_submit_button', 'comment_form_submit_button');