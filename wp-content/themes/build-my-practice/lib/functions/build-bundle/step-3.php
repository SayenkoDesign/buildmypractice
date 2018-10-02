<?php

// Step #3

add_filter( 'gform_field_value_domain_option', 'bmp_populate_domain_option' );
function bmp_populate_domain_option( $value ) {
    
    $data = WC()->session->get( 'step_2_data' );
    
    if( isset( $data['email_option'] ) && !empty( $data['email_option'] ) ) {
        $email_option = $data['email_option'];
        
        if( _string_contains( 'I already have', $email_option ) ) {
            return 'I already have a domain - Included';
        }
    }
    
    // options "Register my domain - Included" or "I already have a domain - Included"
}

add_filter( 'gform_field_value_your_domain', 'bmp_populate_your_domain' );
function bmp_populate_your_domain( $value ) {
    
    $data = WC()->session->get( 'step_2_data' );
        
    if( isset( $data['email_option'] ) && !empty( $data['email_option'] ) ) {
        
        $email_option = $data['email_option'];
        
        if( _string_contains( 'I already have', $email_option ) ) {
            
            $email = '';
    
            if( ! empty( $data['office_email'] ) ) {
                $email = $data['office_email'];
            }
            else if( ! empty( $data['gsuite_email'] ) ) {
                $email = $data['gsuite_email'];
            }
            else {
                $email = $data['email'];
            }
            
            return substr( strrchr( $email, "@" ), 1 );
            
        }
    }
}

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