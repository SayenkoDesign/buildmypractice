<?php

// Debugging

function bmp_session_data() {
            
    // only show on local
    if( false == WP_DEBUG ) {
        return;
    }
    
    $forms = range(1,9);
    foreach( $forms as $form ) {
        $session_values = WC()->session->get( sprintf( 'gf_form_%s_data', $form ) );
        print_r( $session_values );
    }
    
}
add_action( 'woocommerce_before_single_product', 'bmp_session_data', 10 );



