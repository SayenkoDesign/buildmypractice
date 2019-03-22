<?php

// Step #2

/*
function step_2_add_to_cart_redirect( $url ) {
	
    $product_id = wc_get_post_data_by_key( 'add-to-cart' );   
        
    if( 477 == $product_id ) {
        
        WC()->session->__unset( 'step_2_data' );
        
        $first = wc_get_post_data_by_key( 'input_24' );
        $last = wc_get_post_data_by_key( 'input_25' );
        $email = wc_get_post_data_by_key( 'input_33' );
        
        $company = wc_get_post_data_by_key( 'input_35' );
        $phone = wc_get_post_data_by_key( 'input_36' );

        $choice = wc_get_post_data_by_key( 'input_31' );
        
        $office_email = wc_get_post_data_by_key( 'input_26' );
        $gsuite_email = wc_get_post_data_by_key( 'input_27' );
        
        $data = array( 
        
            'first' => $first, 
            'last' => $last, 
            'email' => $email, 
            'company' => $company, 
            'phone' => $phone, 
            'email_option' => $choice,
            'office_email' => $office_email,
            'gsuite_email' => $gsuite_email,
             );
        
            //error_log( print_r( $data, 1 ) );
        
        WC()->session->set( 'step_2_data' , $data );
         
    }
    	
	return $url;

}
add_filter( 'woocommerce_add_to_cart_redirect', 'step_2_add_to_cart_redirect' );
*/