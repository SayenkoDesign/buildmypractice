<?php

// Turn on label visibility
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );


/*
save all fields with dynamic name
gf_form_XX_field_XX
example: gf_form_3_field_31
*/


// Helper function to get form session field value
function bmp_session_get_field_value( $form_id = false, $field_id = false ) {
    
    $data = WC()->session->get( sprintf( 'gf_form_%s_data', $form_id ) );
    $key = sprintf( 'gf_form_%s_field_%s', $form_id, $field_id );
    if( ! empty( $data[$key] ) ) {
        return $data[$key];
    }
    
    return false;
}


// Loop through all form submissions and save the data to a session. 
// This is all stored inside a session variable: gf_form_{FORM_ID}_data
function pre_submission_handler( $form ) {
	
    $session_values = [];
    
    foreach( $form["fields"] as &$field ) {
            $key = sprintf( 'gf_form_%s_field_%s', $form['id'], $field['id'] );
            $value = $_POST['input_' . $field['id']];
            $session_values[$key] = $value;            
	}
    
    if( ! empty( $session_values ) ) {
        WC()->session->set( sprintf( 'gf_form_%s_data', $form['id'] ) , $session_values );
    }
}
add_action("gform_pre_submission", "pre_submission_handler");


function add_auto_update_filters( $form ) {
	    
    $session_values = WC()->session->get( sprintf( 'gf_form_%s_data', $form['id'] ) );
            
    // Bail if no session data
    if( empty( $session_values ) ) {
        return $form;
    }
    
    foreach( $form["fields"] as &$field ) {
		
        // Check if field is set to be prepopulated?
        if( ! $field["allowsPrepopulate"] ) {
            continue;   
        }
        
        if( in_array( $field['inputName'], [ 'first_name', 'last_name', 'company', 'email', 'phone' ] ) ) {
            continue;
        }
                       
        add_filter( sprintf( 'gform_field_value_%s', $field['inputName'] ), function( $value, $field, $name ) use( &$form, &$session_values ) {
            
            $key = sprintf( 'gf_form_%s_field_%s', $form['id'], $field["id"] );
            
            // Bail on first visit
            if( empty( $session_values[$key] ) ) {
                return $value;
            }
            
            $values = $session_values[$key];
            
            // Silly Gravity forms, their Product options need to have the price removed.
            // AKA remove the |PRICE
            
            if( ! is_array( $values ) && 'option' == $field['type'] ) {
                $parts = explode( '|', $values );
                if( ! empty( $parts[0] ) ) {
                    $values = $parts[0];
                }
                $values = stripslashes( $values );
            } else {
                $values = array_map( 'stripslashes', $values );
            }
            
            
            // print_r( $session_values );
            return isset( $values ) ? $values : $value;
            
        }, 10, 3 );
		
	}
	return $form;
}
add_filter( 'gform_pre_render', 'add_auto_update_filters' );
//add_filter( 'gform_pre_validation', 'add_auto_update_filters' );
//add_filter( 'gform_pre_submission', 'add_auto_update_filters' );


// Override the following dynamic fields for Active Campiagn
add_filter( sprintf( 'gform_field_value_%s', 'first_name' ), function( $value, $field, $name ) {
            
    return bmp_session_get_field_value( 1, 2 );
    
}, 20, 3 );

add_filter( sprintf( 'gform_field_value_%s', 'last_name' ), function( $value, $field, $name ) {
            
    return bmp_session_get_field_value( 1, 3 );
    
}, 20, 3 );

add_filter( sprintf( 'gform_field_value_%s', 'company' ), function( $value, $field, $name ) {
            
    return bmp_session_get_field_value( 1, 4 );
    
}, 20, 3 );

add_filter( sprintf( 'gform_field_value_%s', 'email' ), function( $value, $field, $name ) {
            
    return bmp_session_get_field_value( 1, 5 );
    
}, 20, 3 );

add_filter( sprintf( 'gform_field_value_%s', 'phone' ), function( $value, $field, $name ) {
            
    return bmp_session_get_field_value( 1, 6 );
    
}, 20, 3 );


function is_valid_domain( $domain ) {
    
    $username = 'ExactifyIT'; // kylerumble
    $password = 'BuildMyPractice2018!'; // LpQUUw8OlDHTt8Inr4I
    
    $url = 'https://www.whoisxmlapi.com/whoisserver/WhoisService';
    $args = array(
        'domainName' => $domain,
        'cmd' => 'GET_DN_AVAILABILITY',
        'username' => $username,
        'password' => $password,
        'outputFormat' => 'JSON',
        'getMode'      => 'DNS_AND_WHOIS'
    );
    
    $response = wp_remote_get( add_query_arg( $args, $url ) );
    
    if ( is_array( $response ) ) {
      $body = $response['body']; // use the content
      $res = json_decode( $body );
      if($res){
        if($res->ErrorMessage){
            //echo $res->ErrorMessage->msg;
            return false;
        }	
        else{
            $domainInfo = $res->DomainInfo;
            if($domainInfo){
                return ( 'UNAVAILABLE' == $domainInfo->domainAvailability ) ? false : true;
            }
        }
      }
    }   
}

// Validate Domain - use class on field "validate-domain"

// 1 - Tie our validation function to the 'gform_validation' hook
function validate_domain( $validation_result ) {
    
    // 2 - Get the form object from the validation result
    $form = $validation_result['form'];
    
    // 3 - Get the current page being validated
    $current_page = rgpost( 'gform_source_page_number_' . $form['id'] ) ? rgpost( 'gform_source_page_number_' . $form['id'] ) : 1;
    
    // 4 - Loop through the form fields
    foreach( $form['fields'] as &$field ) {
        
        // 5 - If the field does not have our designated CSS class, skip it
        if ( strpos( $field->cssClass, 'validate-domain' ) === false ) {
            continue;
        }
        
        // 6 - Get the field's page number
        $field_page = $field->pageNumber;
        
        // 7 - Check if the field is hidden by GF conditional logic
        $is_hidden = RGFormsModel::is_field_hidden( $form, $field, array() );
        
        // 8 - If the field is not on the current page OR if the field is hidden, skip it
        if ( $field_page != $current_page || $is_hidden ) {
            continue;
        }
        
        // 9 - Get the submitted value from the $_POST
        $field_value = rgpost( "input_{$field['id']}" );
        
        // 10 - Make a call to your validation function to validate the value
        $is_valid = is_valid_domain( $field_value );
        
        // 11 - If the field is valid we don't need to do anything, skip it
        if ( $is_valid ) {
            continue;
        }
        
        // 12 - The field field validation, so first we'll need to fail the validation for the entire form
        $validation_result['is_valid'] = false;
        
        // 13 - Next we'll mark the specific field that failed and add a custom validation message
	
        $field->failed_validation = true;
        $field->validation_message = 'Domain not available';
            
    }
    
    // 14 - Assign our modified $form object back to the validation result
    $validation_result['form'] = $form;
    
    // 15 - Return the validation result
    return $validation_result;
}

add_filter( 'gform_validation', 'validate_domain' );



// fix redirect on build bundle form
/*
add_filter( 'gform_confirmation', function ( $confirmation, $form, $entry, $ajax ) {
    if ( isset( $confirmation['redirect'] ) ) {
        //$url          = esc_url_raw( $confirmation['redirect'] );
        error_log( print_r( $confirmation, 1) );
    }
 
    return $confirmation;
}, 10, 4 );
*/


// Bundle form

add_filter( 'gform_field_choice_markup_pre_render_3', 'get_bundle_images', 10, 4 );

function get_bundle_images( $choice_markup, $choice, $field, $value ) {
    
    // Bail early
    if( is_admin() ) {
        return $choice_markup;
    }
    
    $choice_key = false;
    
    $choices = $field['choices'];
    
    foreach( $choices as $key => $chosen ) {
        if( $chosen['text'] == $choice['text'] ) {
            $choice_key = $key;
        }
    }
                
    $images = bmp_get_gf_field_images( $field->id, $choice_key );
            
    $gallery = '';
    
    if( !empty( $images ) ) {
        
        foreach( $images as $image ) {
            
            $gallery .= sprintf( '<div class="column column-block"><div class="logo-box" data-equalizer-watch>%s</div></div>', _s_get_acf_image( $image['ID'], 'medium' ) );
            
        }
        
        $markup = sprintf( '<div class="gf_field_images"><div class="row small-up-2 medium-up-3" data-equalizer data-equalize-on="medium">%s</div></div>', $gallery );
        
        $choice_markup = preg_replace('/(<label[^>]*>)(.*?)(<\/label>)/i', sprintf( '$1%s$2$3', $markup ), $choice_markup );
        
    }
    
    
    //$choice_key++;
 
    return $choice_markup;
};



// Logo Breif

add_filter( 'gform_field_choice_markup_pre_render_11', 'get_choice_images', 10, 4 );

function get_choice_images( $choice_markup, $choice, $field, $value ) {
    
    // Bail early
    if( is_admin() ) {
        return $choice_markup;
    }
    
    $choice_key = false;
    
    
    $choices = $field['choices'];
    
    foreach( $choices as $key => $chosen ) {
        if( $chosen['text'] == $choice['text'] ) {
            $choice_key = $key;
        }
    }
                
    $images = bmp_get_gf_field_images( $field->id, $choice_key );
    
    // var_dump( $field->id . ' - ' . $choice_key );
    
    $gallery = '';
    
    if( !empty( $images ) ) {
        
        foreach( $images as $image ) {
            
            
            if( 'checkbox' == $field->type ) {
                $gallery .= sprintf( '<div class="column column-block"><div class="logo-box" data-equalizer-watch>%s</div></div>', _s_get_acf_image( $image['ID'], 'medium' ) );
            }
            else {
                $gallery .= sprintf( '<div class="logo-box">%s</div>', _s_get_acf_image( $image['ID'], 'medium' ) );   
            }
            
        }
        
        if( 'checkbox' == $field->type ) {
                $markup = sprintf( '<div class="gf_field_images %s"><div class="row small-up-2 medium-up-3" data-equalizer data-equalize-on="medium">%s</div></div>', $field->type, $gallery );
            }
            else {
                $markup = sprintf( '<div class="gf_field_images %s">%s</div>', $field->type, $gallery );
            }
        
        
        
        $replace = '</label>' . $markup;
        
        if( 'radio' == $field->type ) {
            $replace = $markup . '</label>';
        }
        
        $choice_markup = str_replace( '</label>', $replace, $choice_markup );
    }
    
    
    //$choice_key++;
 
    return $choice_markup;
};


function bmp_get_gf_field_images( $field_id = false, $choice = false ) {
    
    
    // arguments, adjust as needed
	$args = array(
		'post_type'      => 'gf_field',
		'posts_per_page' => 1,
		'post_status'    => 'publish',
        'meta_query' => array(
           'relation' => 'AND',
            array(
                'key'     => 'field_id',
                'value'   => $field_id,
                'type'    => 'numeric',
                'compare' => '='
            ),
            array(
                'key'     => 'choice',
                'value'   => $choice,
                'type'    => 'numeric',
                'compare' => '='
            )
        )
	);

	// Use $loop, a custom variable we made up, so it doesn't overwrite anything
	$loop = new WP_Query( $args );
    
    $images = false;

	// have_posts() is a wrapper function for $wp_query->have_posts(). Since we
	// don't want to use $wp_query, use our custom variable instead.
	if ( $loop->have_posts() ) : 
		
		while ( $loop->have_posts() ) : $loop->the_post(); 

            $images = get_field( 'images' );

		endwhile;
	endif;
	
	wp_reset_postdata();
        
    return $images;
}