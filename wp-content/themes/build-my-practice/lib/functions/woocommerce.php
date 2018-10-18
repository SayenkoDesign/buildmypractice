<?php

/* Code goes in theme functions.php */
add_filter( 'woocommerce_prevent_admin_access', '__return_false' );
add_filter( 'woocommerce_disable_admin_bar', '__return_false' );

// Remove add to cart notice
//add_filter( 'wc_add_to_cart_message_html', '__return_null' );


/// woocommerce/includes/wc-template-hooks.php

/**
 * Custom Body Class
 *
 * @param array $classes
 * @return array
 */
function _s_woocommerce_hooks() {
    
  // Remove breakcrumbs
  remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
  
  // WooCommerce Remove Sidebar 
  remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
  
  if( is_page_template( 'woocommerce/template-product-bundle.php' ) ) {
                
  }

}
add_action( 'woocommerce_init', '_s_woocommerce_hooks' );


// Remove product thumbnails
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );

// Remove Product tags, upsells and related products
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

add_action( 'woocommerce_before_main_content', function() {
    echo '<div class="column row">';
});


add_action( 'woocommerce_after_main_content', function() {
    echo '</div>';
});


add_filter( 'wc_add_to_cart_message', 'remove_add_to_cart_message' );

function remove_add_to_cart_message() {
    return;
}

 
function woo_custom_cart_button_text() {
   return __( 'Next', 'woocommerce' );
}

add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );    // 2.1 +


function bmp_show_cart_data() {
    
    if( ! WP_DEBUG ) {
        return;
    }
    
    
    
    global $woocommerce;
    
    echo '<pre>';
    // var_dump( $woocommerce->cart->get_cart() );
    var_dump( WC()->session->get( 'step_2_data' ) );
    echo '</pre>';
    
    
    
}

 //add_action( 'woocommerce_before_single_product', 'bmp_show_cart_data' );




/**
 * Redirect users after add to cart.
 */
function my_custom_add_to_cart_redirect( $url ) {
	
    $url = esc_url( wc_get_post_data_by_key( 'product_redirect_url', $url ) );
    	
	return $url;

}
add_filter( 'woocommerce_add_to_cart_redirect', 'my_custom_add_to_cart_redirect' );




function add_redirect_woocommerce_after_add_to_cart_button() {
    
    $url = get_field( 'product_redirect_url' );
    
    if( empty( $url ) ) {
        return;
    }
    
    printf( '<input type="hidden" name="product_redirect_url" value="%s" />', $url );
}

add_action( 'woocommerce_after_add_to_cart_button', 'add_redirect_woocommerce_after_add_to_cart_button' );



// Bundled Product Classes

add_filter( 'woocommerce_bundled_item_classes', 'bmp_woocommerce_bundled_item_classes', 10, 2 );

function bmp_woocommerce_bundled_item_classes( $classes, $obj ) {
    
    $class = sprintf( 'bundled_product_%s', $obj->get_id() );
    $classes[] = $class;
    return $classes;
}



// Wrap add to cart button

 
function bmp_wrap_open_add_to_cart_button() {
    
    echo '<div class="add-to-cart-box clear"><div class="wrap">';
 
}

add_action( 'woocommerce_before_add_to_cart_button', 'bmp_wrap_open_add_to_cart_button', 99 );


function bmp_wrap_close_add_to_cart_button() {
    
    echo '</div></div>';
}

add_action( 'woocommerce_after_add_to_cart_button', 'bmp_wrap_close_add_to_cart_button' );




add_filter('woocommerce_checkout_get_value', function($input, $key ) {
	global $current_user;
    
    $defaults = array(
        'first' => '',
        'last' => '',
        'email' => '',
        'phone' => '',
    );
    
    $step_2_data = WC()->session->get( 'step_2_data' );        
    $step_2_data = wp_parse_args( $step_2_data, $defaults );
    
    
	switch ($key) :
		case 'billing_first_name':
		case 'shipping_first_name':
			return ucwords( $step_2_data['first'] );
		break;
		
		case 'billing_last_name':
		case 'shipping_last_name':
			return ucwords( $step_2_data['last'] );
		break;
        case 'billing_company':
            return ucwords( $step_2_data['company'] );
        break;
		case 'billing_email':
			return $step_2_data['email'];
		break;
        case 'billing_phone':
			return $step_2_data['phone'];
		break;
	endswitch;
}, 10, 2);


add_filter( 'woocommerce_default_address_fields' , 'custom_override_default_address_fields' );

// Our hooked in function - $address_fields is passed via the filter!
function custom_override_default_address_fields( $address_fields ) {
     $address_fields['company']['label'] = 'Firm Name';
     return $address_fields;
}


add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
     $fields['order']['order_comments']['label'] = 'Notes';
     $fields['order']['order_comments']['placeholder'] = '';
     return $fields;
}


function exactify_code() {
        
    if( ! is_singular( 'product' ) )
        return; 
            
    $first = $last = $email = $phone = '';
    
    $url = 'https://app.acuityscheduling.com/schedule.php';
    
    $args = array(
        'owner'             => 15127325,
        'appointmentType'   => 6886831,
        'firstName'         => $first,
        'lastName'          => $last,
        'email'             => $email,
        'phone'             => $phone
    );
    
    $url = add_query_arg( $args, $url );
    
    printf( '<div class="book-consultation text-center"><p>Questions? Not quite sure what you need? <button class="button" data-open="schedule">%s</button></p></div>', 'Book a Consultation'  );
            
    printf( '<div class="reveal large booking-reveal" id="schedule" data-reveal><iframe src="%s" class="exactify" frameBorder="0"></iframe><button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button></div><script src="https://d3gxy7nm8y4yjr.cloudfront.net/js/embed.js" type="text/javascript"></script>', $url );   
        
}

add_action( 'woocommerce_before_single_product', 'exactify_code' );



/**
 * Changes the redirect URL for the Return To Shop button in the cart.
 *
 * @return string
 */
function wc_empty_cart_redirect_url() {
	return get_permalink( 150 );
}
add_filter( 'woocommerce_return_to_shop_redirect', 'wc_empty_cart_redirect_url' );


add_filter( 'gettext', 'change_woocommerce_return_to_shop_text', 20, 3 );
function change_woocommerce_return_to_shop_text( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
                      case 'Return to shop' :
       $translated_text = __( 'Return to "Build My Bundle"', 'woocommerce' );
       break;
    }
     return $translated_text; 

}

// If someone hits back button, remove product
function remove_product_from_cart() {
    // Run only in the Cart or Checkout Page
    $allowed = false;
    if( !empty( $_GET['bmp-action'] ) ) {
        $allowed = $_GET['bmp-action'];
    }
    
    if( is_singular( 'product' ) ) {
        // Set the product ID to remove
        $prod_to_remove = get_the_ID();
        error_log( $prod_to_remove );
        // Cycle through each product in the cart
        foreach( WC()->cart->cart_contents as $cart_item_key => $prod_in_cart ) {
            // Get the Variation or Product ID
            $prod_id = ( isset( $prod_in_cart['variation_id'] ) && $prod_in_cart['variation_id'] != 0 ) ? $prod_in_cart['variation_id'] : $prod_in_cart['product_id'];
            // Check to see if IDs match
            if( ( ( $prod_to_remove == $prod_id ) && ( 'remove-product' == $allowed ) ) ) {
                WC()->cart->remove_cart_item( $cart_item_key );
                wc_add_notice( 'Step removed. You may now re-add this step.', 'success' );
            }
        }
    }
}

add_action( 'template_redirect', 'remove_product_from_cart' );



function custom_maybe_empty_cart( $valid, $product_id, $quantity ) {

    if( ! empty ( WC()->cart->get_cart() ) && $valid ){
 
        // Cycle through each product in the cart
        foreach( WC()->cart->cart_contents as $cart_item_key => $prod_in_cart ) {
            // Get the Variation or Product ID
            $prod_id = ( isset( $prod_in_cart['variation_id'] ) && $prod_in_cart['variation_id'] != 0 ) ? $prod_in_cart['variation_id'] : $prod_in_cart['product_id'];
            // Check to see if IDs match
            if( $product_id == $prod_id ) {
                $redirect = get_field( 'product_redirect_url', $product_id );
                $redirect = $redirect ? sprintf( '<a href="%s" class="">Continue to Next Step</a>', $redirect ) : '';
                $remove = sprintf( '<a href="%s?bmp-action=remove-product" class="">Clear this step</a>', 
                                   get_permalink( $product_id ) );
                $cart_url = sprintf( '<a href="%s" class="">Return to Cart</a>', wc_get_cart_url() );
                wc_add_notice( sprintf( 'You have completed this step. %s,  %s or %s.', $remove, $redirect, $cart_url ), 'error' );
                return false;
            }
        }
    }
    
    return $valid;
}
add_filter( 'woocommerce_add_to_cart_validation', 'custom_maybe_empty_cart', 10, 3 );




add_action( 'woocommerce_before_cart', 'bmp_find_product_in_cart' );
   
function bmp_find_product_in_cart() {
 
    // Get products
    
    $products = bmp_get_products_by_cat( 32 );
    
    $products_in_cart = [];
    
    $missing = [];
 
    foreach( WC()->cart->cart_contents as $cart_item_key => $prod_in_cart ) {
        // Get the Variation or Product ID
        $prod_id = ( isset( $prod_in_cart['variation_id'] ) && 
                     $prod_in_cart['variation_id'] != 0 ) ? $prod_in_cart['variation_id'] : $prod_in_cart['product_id'];
        $products_in_cart[] = $prod_id;
    }
    
    foreach( $products as $product ) {
        
        if( ! in_array( $product, $products_in_cart ) ) {
            $missing[] = sprintf( '<a href="%s">%s</a>', get_permalink( $product ), get_the_title( $product ) );
        }
    }
    
    if( empty( $missing ) ) {
        return;
    }
    
    $notice = 'The following steps are missing from your cart:<br />';
    $notice .= join( '<br />', $missing );
    wc_print_notice( $notice, 'notice' );
  
}

// Min qty on product pages
add_filter( 'woocommerce_quantity_input_args', 'min_qty_input_args', 20, 2 );
function min_qty_input_args( $args, $product ) {

    ## ---- Your settings ---- ##

    $product_categories = array(32);

    $quantity = 1;

    ## ---- The code: set minmun quantity for specif product categories ---- ##

    $product_id = $product->is_type('variation') ? $product->get_parent_id() : $product->get_id();

    if( has_term( $product_categories, 'product_cat', $product_id ) ){
        $args['min_value'] = $quantity;
    }

    return $args;
}

// Min qty on cart page
add_filter( 'woocommerce_quantity_input_args', 'hide_quantity_input_field', 20, 2 );
function hide_quantity_input_field( $args, $product ) {
    // Here set your product categories in the array (can be either an ID, a slug, a name or an array)
    $categories = array( 32 );

    // Handling product variation
    $the_id = $product->is_type('variation') ? $product->get_parent_id() : $product->get_id();

    // Only on cart page for a specific product category
    if( is_cart() && has_term( $categories, 'product_cat', $the_id ) ){
        $input_value = $args['input_value'];
        $args['min_value'] = 1;
        //$args['max_value'] = '1';
    }
    return $args;
}

// add_filter( 'woocommerce_quantity_input_args', 'hide_quantity_input_field', 20, 2 );
/*
function hide_quantity_input_field( $args, $product ) {
    // Here set your product IDs in the array
    $product_ids = array(706);

    // Handling product variation
    $the_id = $product->is_type('variation') ? $product->get_parent_id() : $product->get_id();

    // Only on cart page for a specific product category
    if( is_cart() && in_array( $the_id, $product_ids ) ){
        $input_value = $args['input_value'];
        $args['min_value'] = 1;
    }
    return $args;
}
*/

// Function that redirect from checkout to mandatory product category archives pages
function mandatory_category_checkout_redirect() {
    
    // If cart is not empty on checkout page
    if( ! WC()->cart->is_empty() && is_checkout() ){
        
        $products = bmp_get_products_by_cat( 32 );
    
        $products_in_cart = [];
        
        $missing = [];
     
        foreach( WC()->cart->cart_contents as $cart_item_key => $prod_in_cart ) {
            // Get the Variation or Product ID
            $prod_id = ( isset( $prod_in_cart['variation_id'] ) && 
                         $prod_in_cart['variation_id'] != 0 ) ? $prod_in_cart['variation_id'] : $prod_in_cart['product_id'];
            $products_in_cart[] = $prod_id;
        }
        
        foreach( $products as $product ) {
            
            if( ! in_array( $product, $products_in_cart ) ) {
                $missing[] = $product;
            }
        }
                
         if( ! empty( $missing ) ) {
            wp_safe_redirect( wc_get_cart_url() );
            exit;
        }
    }
}
// Disable for testing checkout
//add_action('template_redirect', 'mandatory_category_checkout_redirect');



// Function that redirect from checkout to mandatory product category archives pages
function product_step_redirect() {
    
    // If cart is not empty on checkout page
    if( is_singular( 'product' ) ){
        
        $current_product = get_the_ID();
        
        $products = bmp_get_products_by_cat( 32 );
        
        foreach( $products as $product ) {
            
            // Loop till we reach current product
            if( $current_product == $product ) {
                break;
            }
            
            $product_cart_id = WC()->cart->generate_cart_id( $product );
            $in_cart = WC()->cart->find_product_in_cart( $product_cart_id );
            
            if ( ! $in_cart ) {
                wp_safe_redirect( get_permalink( $product ) );
                exit;
            }
        }

    }
}

// add_action('template_redirect', 'product_step_redirect', 99 );


function bmp_get_products_by_cat( $cat = false ) {

	global $post;

	// arguments, adjust as needed
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
        'orderby' => 'menu_order',
        'order' => 'ASC',
		'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'terms' => array( $cat ),
                'operator' => 'IN',
            )
        )
	);
    

	// Use $loop, a custom variable we made up, so it doesn't overwrite anything
	$loop = new WP_Query( $args );
    
    $post_ids = wp_list_pluck( $loop->posts, 'ID' );

	wp_reset_postdata();
        
    return $post_ids;
}


// Wrap subscription thank you message

function bmp_subscriptions_thank_you_message( $thank_you_message ) {
    echo sprintf( '<div class="subscription-thankyou-message">%s</div>', $thank_you_message );
}

add_action( 'woocommerce_subscriptions_thank_you_message', 'bmp_subscriptions_thank_you_message' );




// Conditional add message to WooCommerce emails based on product GF selection
function gf_custom_email( $order, $sent_to_admin, $plain_text, $email )
{
    if ( $email->id == 'customer_invoice' || 
         $email->id == 'customer_processing_order' || 
         $email->id == 'customer_order_complete' ||
         $email->id == 'customer_on_hold'
         
          ) {  //email type to be specified here

        $order = wc_get_order( $order->ID );
        
        $schedule_link = '';
        
        $first = $last = $email = $phone = '';
    
        $url = 'https://app.acuityscheduling.com/schedule.php';
        
        $args = array(
            'owner'             => 15127325,
            'appointmentType'   => 6886831,
            'firstName'         => $order->get_billing_first_name(),
            'lastName'          => $order->get_billing_last_name(),
            'email'             => $order->get_billing_email(),
            'phone'             => $order->get_billing_phone()
        );
        
        $schedule_link = add_query_arg( $args, $url );
        
        $welcome_message_header = get_field( 'welcome_message_header', 'option' );
        
        // Swap out custom merge tags
        $find = array( '{customer_first_name}', '{schedule_link}' );
        $replace = array( $order->get_billing_first_name(), sprintf( '<a href="%s">Schedule your onboarding call</a>', $schedule_link ) );
        
        $welcome_message_header = str_replace( $find, $replace, $welcome_message_header );
        
        if( empty( $welcome_message_header ) ) {
            $welcome_message_header = sprintf( 'Hi %s,<br /><br />
    Welcome to BuildMyPractice! Our mission is to help you focus on what you do best—practicing law—by easing the administrative burden of managing your law firm. We aim to be your chief information officer and your digital design team, and to give you the resources and guidance you need to ensure that technology doesn’t act as a barrier to your success. <br /><br />
    We have received your selections and are hard at work on setting up your account. As a first step on your end, please schedule some time with your onboarding manager so we can learn more about your law firm and answer any questions you may have. Feel free to use our online scheduler to select a mutually convenient time: <a href="%s">Schedule your onboarding call</a>', $order->get_billing_first_name(), $schedule_link );   
        }
        
        // output welcome message
        echo $welcome_message_header;
        
        
        foreach ( $order->get_items() as $item_id => $item_data ) {
            $product_name = $item_data['name'];
            $product_id = $item_data['product_id'];

            /*
           * Below section to be repeated for each form where output is needed
            * (product_id is ID of the product for the specific form.
            * field_id is ID of the field which needs to be outputed )
            */

// start
            if ($product_id == 465) { // 465 is product id for "step 8"
                $g_field_id = '3'; //field ID to be set manually for each product
                $selected_field = get_gf_field_value_by_product($order->ID, $item_id, $g_field_id); // Note: it has "|0" at the end, so try to match

                // conditional output
                if ( _string_contains( 
                        'Have our professional designers create a new logo, business cards, and a letterhead for your firm', 
                        $selected_field ) 
                    ) {

                   echo '<br /><br />To enable our design team to get started on creating your firm’s logo, please complete our logo design questionnaire:<br /><br />';
                   printf( '<a href="%s">Logo design questionnaire</a><br /><br />', get_permalink( 484 ) );

                } else if( _string_contains( 
                        'Have our professional designers create business cards and a letterhead with your existing logo', 
                        $selected_field ) 
                    ) {

                    echo '<br /><br />To enable our design team to get started on creating your business cards and letterhead, please send us your existing logo files. You may reply to this email with the files attached (please include the original image files you received from your logo designer).<br /><br />';
                    //echo "my custom text for product <b>  $product_name </b> <br> selected value was --  <b>   $selected_field  </b><br>";
                }
                else {
                    
                }

            }
//end
            
        }
        
        // Message footer
        $welcome_message_footer = get_field( 'welcome_message_footer', 'option' );
        
        if( empty( $welcome_message_footer ) ) {
            $welcome_message_footer = sprintf( 'You’ll hear more from us over the coming days as we configure your resources in accordance with your selections. If you selected services offered through any of our partners, you may hear from them directly. If you have any questions, please feel free to reply to this email or contact us at <a href="mailto:%s">info@buildmypractice.com</a>. We look forward to getting to know you better and serving your law firm for years to come!<br /><br />
Sincerely,<br /><br />
The BuildMyPractice team<br /><br />', 'info@buildmypractice.com' );
        }
        
        // output message footer
        echo $welcome_message_footer;
        
        echo '<br /><br />';
    }
}

add_action('woocommerce_email_before_order_table', 'gf_custom_email', 20, 4);

// Helper function to get gravity forms values from order
function get_gf_field_value_by_product($order_id, $ordered_product, $field_id)
{

    $order = wc_get_order($order_id);
    foreach ($order->get_items() as $item_id => $item_data) {
        if ($item_id == $ordered_product) {
            $metas = wc_get_order_item_meta($item_id, '_gravity_forms_history', true);
            //$g_entry = $metas['_gravity_form_linked_entry_id'];
            $g_field_id = $field_id;
            $g_value = $metas['_gravity_form_lead'][$g_field_id];
        }

    }
    return $g_value;

}



function my_function_sample() {
  global $product;
  echo ' <button class="button go-back" type="button" onclick="history.back();"> Go back </button> '; 
}

add_action( 'woocommerce_after_add_to_cart_quantity', 'my_function_sample', 1 );



function my_back_to_cart() {
    printf( '<p style="padding-top: 30px;"><a class="button" href="%s">Back to Cart</a></p>', wc_get_cart_url() );
}

add_action( 'woocommerce_checkout_order_review', 'my_back_to_cart', 9 );



// Custom cart function sorted by menu_item
function bmp_sort_cart_items() {
    //if the cart is empty do nothing
    if ( WC()->cart->get_cart_contents_count() == 0 ) {
        return WC()->cart->cart_contents;
    }
    
	$products_in_cart = array();
    
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $order = $cart_item['data']->get_menu_order() ? $cart_item['data']->get_menu_order() : 100;
		$products_in_cart[ $cart_item_key ] = $order;
	}
	
    natsort( $products_in_cart );
    
    // error_log( print_r( $products_in_cart, 1 ) );
	
    $cart_contents = array();
	
    foreach ( $products_in_cart as $cart_key => $menu_order ) {
		$cart_contents[ $cart_key ] = WC()->cart->cart_contents[ $cart_key ];
	}
	
    return $cart_contents;
}

add_action( 'template_redirect', function() {
    if ( is_wc_endpoint_url( 'order-received' ) && is_user_logged_in() ) {
        global $wp;
        $current_url = add_query_arg( $_SERVER['QUERY_STRING'], '', home_url( $wp->request ) );
        wp_logout();
        wp_destroy_current_session();
        error_log( sprintf( 'template redirect tried to log them out %s', $current_url ) );
        wp_redirect( $current_url );
        exit;
    }
});


