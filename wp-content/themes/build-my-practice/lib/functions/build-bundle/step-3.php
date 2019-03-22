<?php

// Step #3

// Your Selection "Register my domain - Included" or "I already have a domain - Included"
function bmp_populate_gf_form_4_field_1( $value ) {
        
    // Get data from previous form Step 2 = form ID #3
    $option = bmp_session_get_field_value( 3, 31 );
    
    if( ! empty( $option ) ) {        
        if( _string_contains( 'I already have', $option ) ) {
            return 'I already have a domain - Included';
        }
    }
    
}
add_filter( 'gform_field_value_gf_form_4_field_1', 'bmp_populate_gf_form_4_field_1' );


// Populate your domain
function bmp_populate_gf_form_4_field_3( $value ) {
    
    // if they already have a domain
    $have_domain = bmp_session_get_field_value( 4, 1 );
    
    if( ! empty( $have_domain ) ) {        
        if( _string_contains( 'I already have', $have_domain ) ) {
            
            $email = '';
            
            $office_email = bmp_session_get_field_value( 3, 26 );
            $gsuite_email = bmp_session_get_field_value( 3, 27 );
            if( ! empty( $office_email ) ) {
                $email = $office_email;
            }
            else if( ! empty( $office_email ) ) {
                $email = $office_email;
            }
            else {
                $email = bmp_session_get_field_value( 3, 33 );
            }
            
            return substr( strrchr( $email, "@" ), 1 );
            
        }
    }
}
add_filter( 'gform_field_value_gf_form_4_field_3', 'bmp_populate_gf_form_4_field_3' );


/*
function step_3_add_to_cart_redirect( $url ) {
	
    $product_id = wc_get_post_data_by_key( 'add-to-cart' );   
        
    if( 472 == $product_id ) {
        
        WC()->session->__unset( 'step_3_data' );
        
        $domain = '';
        $register = wc_get_post_data_by_key( 'input_2' );
        $existing = wc_get_post_data_by_key( 'input_3' );
        
        $domain = !empty( $existing ) ? $existing : $register;
        //$url = add_query_arg( 'domain', $domain, $url );
        
        $data = array( 'register_domain' => $register, 'existing_domain' => $existing, 'domain' => $domain );
        
        WC()->session->set( 'step_3_data' , $data );
    } 
        	
	return $url;

}
add_filter( 'woocommerce_add_to_cart_redirect', 'step_3_add_to_cart_redirect' );
*/