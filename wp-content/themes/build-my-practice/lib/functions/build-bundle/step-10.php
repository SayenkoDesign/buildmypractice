<?php

function step_10_add_to_cart() {
 
    $product_id = wc_get_post_data_by_key( 'add-to-cart' ); 
        
    // Step 10: Your BuildMyPractice Membership ID 706
            
    if( 706 != $product_id ) {
        return;
    }
    
    $data = [
        'field[46,0]' => 'Step 10: Your BuildMyPractice Membership',
        'tags' => 'Completed Step 10'
    ];
    
    error_log( print_r( $data, 1 ) );
    
    bmp_activate_campaign_send_request( $data );
    
}
add_filter( 'woocommerce_add_to_cart', 'step_10_add_to_cart', 10 );



function bmp_woocommerce_bundled_items( $items, $obj ) {
    
    if( is_admin() ) {
        return $items;   
    }
    
    /*
    3: Thread Legal
    4: LawYaw
    5: Microsoft
    */    
    
    $storage_option = bmp_session_get_field_value( 3, 31 );
                
    if ( _string_contains( 'Google', $storage_option ) || _string_contains( 'G Suite', $storage_option ) ) {
        unset( $items[3] ); 
    }
    else if ( _string_contains( 'Office 365', $storage_option ) ) {
        unset( $items[5] ); 
    }
    else {
        
    }
    
    return $items;
}
add_filter( 'woocommerce_bundled_items', 'bmp_woocommerce_bundled_items', 10, 2 );