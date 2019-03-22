<?php

function bmp_build_bundle_progress_bar() {

    if( is_product() ) {
        global $product;
        $current = $product->get_id();
    } else {
        global $post;
        $current = $post->ID;   
    }
        
    $products = bmp_get_products_by_cat( 32 );
    
    if( empty( $products ) ) {
        return false;
    }
    
    $products_in_cart = [];
     
    foreach( WC()->cart->cart_contents as $cart_item_key => $prod_in_cart ) {
        // Get the Variation or Product ID
        $prod_id = ( isset( $prod_in_cart['variation_id'] ) && 
                     $prod_in_cart['variation_id'] != 0 ) ? $prod_in_cart['variation_id'] : $prod_in_cart['product_id'];
        $products_in_cart[] = $prod_id;
    }
    
    $steps = [];
    
    // First we add step 1 which is not a product
    
    $data = sprintf( '<span class="progress-check"><i></i></span><span class="progress-number">%s</span><span class="progress-title">%s</span>',
                     1,
                     'Start'
                   );
    
    $classes = [];
    
    // Should we check first for session data?
    if( is_product() ) {
        $classes[] = 'step-complete';
    } else {
        $classes[] = 'step-current';
        $classes[] = 'step-first';
    }
    
    $steps[] = sprintf( '<li class="step %s"><a href="%s">%s</a></li>', join( ' ', $classes ), get_permalink( 150 ), $data ); 
    
    foreach( $products as $key => $product_id ) {
        
        $classes = [];
        
        // Current step?
        $classes[] = $current == $product_id ? 'step-current' : '';
        
        // Step already in cart?
        if( in_array( $product_id, $products_in_cart ) ) {
            $classes[] =  'step-complete';
        } else {
            $classes[] =  'step-incomplete';
        }
        
        // custom progress name for step?
        $title = get_field( 'progress_name', $product_id );
        if( empty( $title ) ) {
            $title = sprintf( 'Long Step %s', $key + 2 );
        }
        
        $data = sprintf( '<span class="progress-check"><i></i></span><span class="progress-number">%s</span><span class="progress-title">%s</span>',
                     $key + 2,
                     $title
                   );
        
        $steps[] = sprintf( '<li class="step %s"><a href="%s">%s</a></li>', join( ' ', $classes ), get_permalink( $product_id ), $data );        
    }

    printf( '<div class="progress-bar" id="progress-bar" data-toggler=".expanded">
                <button class="close-button" data-toggle="progress-bar" aria-hidden="true">&times;</button>
                <button class="toggle-mobile" data-toggle="progress-bar" aria-hidden="true"></button>
                <ul>%s</ul>
            </div>', 
            join( '', $steps ) );

}
add_action( 'woocommerce_before_single_product', 'bmp_build_bundle_progress_bar', 10 );