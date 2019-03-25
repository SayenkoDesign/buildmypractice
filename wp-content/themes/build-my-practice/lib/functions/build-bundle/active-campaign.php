<?php

function bmp_activate_campaign_send_request( $data  = [] ) {
    
    if( empty( $data ) ) {
        return false;
    }
    
    // https://www.activecampaign.com/api/example.php?call=contact_sync
    
    $post_url = 'https://exactifyit.api-us1.com/admin/api.php';
    $api_key = '6807ea88db67eb50cf97c73a7e200af46d6126b1cbff89ade976c28ef7e09cf68c12ca8c';
    
    $params = [
        'api_action'   => 'contact_sync',
        'api_key'      => $api_key,
        'api_output'   => 'json',
    ];
    
    $post_url = sprintf( '%s?%s', $post_url, http_build_query( $params ) );
    
    $first_name = bmp_session_get_field_value( 3, 24 );
    $last_name = bmp_session_get_field_value( 3, 25 );
    $email = bmp_session_get_field_value( 3, 33 );
    
    $defaults = array(
            'instantresponders[123]' => 0, // set to 0 to if you don't want to sent instant autoresponders
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email            
		);
        
    
    $data = wp_parse_args( $data, $defaults ); 
        
            
    $response = wp_remote_post( $post_url, [ 'body' => $data ] );
    
    if ( is_wp_error( $response ) ) {
       $error_message = $response->get_error_message();
       //error_log( $error_message );
    } else {
       //error_log( print_r( $response, 1 ) );
    }
    
}