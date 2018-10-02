<?php

add_filter( 'woocommerce_bundled_items', 'bmp_woocommerce_bundled_items', 10, 2 );

function bmp_woocommerce_bundled_items( $items, $obj ) {
    
    if( is_admin() ) {
        return $items;   
    }
    
    /*
    3: Thread Legal
    4: LawYaw
    5: Microsoft
    */    
    
    $step_2_data = WC()->session->get( 'step_2_data' );     
    
    if( isset( $step_2_data['email_option'] ) ) {
        
        $email_option = $step_2_data['email_option'];
        
        if ( _string_contains( 'Google', $email_option ) || _string_contains( 'G Suite', $email_option ) ) {
            unset( $items[3] ); 
        }
        else if ( _string_contains( 'Office 365', $email_option ) ) {
            unset( $items[5] ); 
        }
        else {
            
        }
    }
    
    return $items;
}