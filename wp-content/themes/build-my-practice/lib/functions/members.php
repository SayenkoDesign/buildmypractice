<?php

function is_client_logged_in() {
    
    if( ! is_user_logged_in() ) {
        wp_redirect( site_url() );
        exit;
    }
 
    $user = wp_get_current_user();
    $role = ( array ) $user->roles;
            
    if( ! in_array( 'client', $role ) ) {
        wp_redirect( admin_url() );
        exit;
    }
    
}

//add_action( 'get_header', 'is_client_logged_in' );


/**
 * Redirect non-admins to the homepage after logging into the site.
 *
 * @since 	1.0
 */
function bmp_login_redirect( $redirect_to, $request, $user  ) {
	return ( is_array( $user->roles ) && in_array( array( 'administrator', 'vendor' ), $user->roles ) ) ? admin_url() : home_url();
}
add_filter( 'login_redirect', 'bmp_login_redirect', 10, 3 );




 /**
 * Disable admin bar on the frontend of your website
 * for subscribers.
 */
function _s_hide_admin_bar() {
    
  $user = wp_get_current_user();
  $role = ( array ) $user->roles;
    
  if ( in_array( 'client', $role )  ) {
    add_filter('show_admin_bar', '__return_false');
    remove_action('wp_head', '_admin_bar_bump_cb');
    add_action( 'wp_head', '_s_subscriber_remove_header_css' );
  }
  
}

add_action('init', '_s_hide_admin_bar');

function _s_subscriber_remove_header_css() {
?>
<style type="text/css" media="screen">
	.site-header {
        top: 0!important;   
    }
</style>
<?php
}
