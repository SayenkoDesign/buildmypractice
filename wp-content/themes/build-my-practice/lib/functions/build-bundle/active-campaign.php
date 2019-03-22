<?php

function bmp_post_to_active_campaign( $entry, $form ) {
 
    /*
     $post_url = 'http://thirdparty.com';
    $body = array(
        'first_name' => rgar( $entry, '1.3' ),
        'last_name' => rgar( $entry, '1.6' ),
        'message' => rgar( $entry, '3' ),
        );
    */
    
    $post_url = 'https://exactifyit.api-us1.com';
    $api_key = '6807ea88db67eb50cf97c73a7e200af46d6126b1cbff89ade976c28ef7e09cf68c12ca8c';
    
    $params = array(
	
	    	'api_key'      => $api_key,
	    	'api_action'   => 'contact_view_email',
	    	'api_output'   => 'serialize',
	    	'email'        => $email,
		);
    
    GFCommon::log_debug( 'gform_after_submission: body => ' . print_r( $body, true ) );
 
    $request = new WP_Http();
    $response = $request->post( $post_url, array( 'body' => $body ) );
    GFCommon::log_debug( 'gform_after_submission: response => ' . print_r( $response, true ) );
    
}
// add_action( 'gform_after_submission', 'bmp_post_to_active_campaign', 10, 2 );
