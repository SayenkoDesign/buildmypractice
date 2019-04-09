<?php

// Step #1

$form_id = 5;

function preferred_email_address( $form ) {
    
    // Need to check for empty session data and bail if not found.
 
    foreach ( $form['fields'] as &$field ) {
 
        if ( $field->type != 'radio' || strpos( $field->cssClass, 'preferred-email-address' ) === false ) {
            continue;
        }
        
        // Defaults
        $domain = 'domain.com'; 
        $last_option = 'Other';
        
                
        // Do they have an existing storage option?
        $existing = false;
        $storage_option = bmp_session_get_field_value( 3, 31 );
        
        if( _string_contains( 'I already have', $storage_option ) ) {
            $existing = true;
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
        } else {
            $email = '';
        }
                
        
        
        $first_name = bmp_session_get_field_value( 3, 24 );
        if( empty( $first_name ) ) {
            $first_name = 'sabir';
        }
        
        $last_name = bmp_session_get_field_value( 3, 25 );
        if( empty( $last_name ) ) {
            $last_name = 'ibrahim';
        }
        
        
        // did they register a domain name or have an existing domain?
        $register_domain = bmp_session_get_field_value( 4, 2 );
        $existing_domain = bmp_session_get_field_value( 4, 3 );
        if( ! empty( $register_domain ) ) {
            $domain = $register_domain; 
        } elseif( ! empty( $existing_domain ) ) {
            $domain = $existing_domain; 
        } else {
            $domain = 'domain.com'; 
        }
        
        
        $domain_option = bmp_session_get_field_value( 4, 1 );
        if( _string_contains( 'choose a domain later', $domain_option ) ) {
            $domain = 'yourdomain.com'; 
        }
        
        
        // Format and set up choices
        $first_name = strtolower( $first_name );
        $first_letter = $first_name[0];
        $last_name = strtolower( $last_name );
                 
        $options = array(
            sprintf( '%s.%s@%s', $first_name, $last_name, $domain ),
            sprintf( '%s@%s', $first_name, $domain ),
            sprintf( '%s@%s', $last_name, $domain ),
            sprintf( '%s.%s@%s', $first_letter, $last_name, $domain ),
            $last_option
        );
 
        $choices = array();
        
 
        foreach ( $options as $option ) {
            $selected = false; //$key ? false : true;
            $choices[] = array( 'text' => $option, 'value' => $option );
        }
 
        // update 'Select a Post' to whatever you'd like the instructive option to be
        //$field->placeholder = 'Select a Post';
        $field->choices = $choices;
        
 
    }
 
    return $form;
}
add_filter( sprintf( 'gform_pre_render_%s', $form_id ), 'preferred_email_address' );
//add_filter( sprintf( 'gform_pre_validation_%s', $form_id ), 'preferred_email_address' );
//add_filter( sprintf( 'gform_pre_submission_filter_%s', $form_id ), 'preferred_email_address' );




// Populate Other value
function gform_field_value_gf_form_5_field_8( $value ) {
    
    $existing = false;
    $storage_option = bmp_session_get_field_value( 3, 31 );
    
    if( _string_contains( 'I already have', $storage_option ) ) {
        $existing = true;
        $office_email = bmp_session_get_field_value( 3, 26 );
        $gsuite_email = bmp_session_get_field_value( 3, 27 );
        if( ! empty( $office_email ) ) {
            $value = $office_email;
        }
        else if( ! empty( $office_email ) ) {
            $value = $office_email;
        }
        else {
            $value = bmp_session_get_field_value( 3, 33 );
        }
    }
    
    return $value;
}
add_filter( 'gform_field_value_gf_form_5_field_8', 'gform_field_value_gf_form_5_field_8' );
