<?php

/*
for $39 per user, per month with 1 month free trial (billed directly by Thread)

for Free until you complete three projects, $59 per user, per month thereafter (billed directly by LawYaw)

microsoft- add for $10
*/

/**
 * Display the custom text field
 * @since 1.0.0
 */
function cfwc_create_custom_field() {
	$args = array(
		'id'            => 'bundled_item_product_price',
		'label'         => __( 'Custom Price', 'cfwc' ),
		'class'		    => 'cfwc-custom-field',
		'desc_tip'      => true,
		'description'   => __( 'Enter Bundled Product custom price.', 'ctwc' ),
	);
	woocommerce_wp_text_input( $args );
}
add_action( 'woocommerce_product_options_general_product_data', 'cfwc_create_custom_field' );

/**
 * Save the custom field
 * @since 1.0.0
 */
function cfwc_save_custom_field( $post_id ) {
	$product = wc_get_product( $post_id );
	$title = isset( $_POST['bundled_item_product_price'] ) ? $_POST['bundled_item_product_price'] : '';
	$product->update_meta_data( 'bundled_item_product_price', sanitize_text_field( $title ) );
	$product->save();
}
add_action( 'woocommerce_process_product_meta', 'cfwc_save_custom_field' );



// Bundled products filter the label title, then remove the price

add_filter( 'bundled_item_product_label_title', function( $price, $item ) { 
    global $post;
	// Check for the custom field value
	$product = wc_get_product( $item->product->get_id() );
	$custom_price = $product->get_meta( 'bundled_item_product_price' );
    if( ! empty( $custom_price ) ) {
        $price = $custom_price;
    }
    return $price;    
}, 10, 2 );

add_filter( 'bundled_item_product_price_html', function( $price, $item ) { 
    global $post;
	// Check for the custom field value
	$product = wc_get_product( $item->product->get_id() );
	$custom_price = $product->get_meta( 'bundled_item_product_price' );
    if( ! empty( $custom_price ) ) {
        $price = '';
    }
    return $price;    
}, 10, 2 );