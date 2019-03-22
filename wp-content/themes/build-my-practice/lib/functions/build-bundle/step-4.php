<?php

// Step #1

/*
form_id = 3
*/

$form_id = 5;

function preferred_email_address( $form ) {
    
    // Need to check for empty session data and bail if not found.
 
    foreach ( $form['fields'] as &$field ) {
 
        if ( $field->type != 'radio' || strpos( $field->cssClass, 'preferred-email-address' ) === false ) {
            continue;
        }
        
        $first_name = bmp_session_get_field_value( 3, 24 );
        if( empty( $first_name ) ) {
            $first_name = '[FIRST NAME]';
        }
        $last_name = bmp_session_get_field_value( 3, 25 );
        if( empty( $last_name ) ) {
            $last_name = '[LAST NAME]';
        }
        $email = bmp_session_get_field_value( 3, 33 );
        if( empty( $email ) ) {
            $email = 'first';
        }
        
        $first_name = strtolower( $first_name );
        
        $first_letter = '[FIRST LETTER OF FIRST NAME]';
        if( ! empty( $first_name ) ) {
            $first_letter = $first_name[0];
        }
        
        $last_name = strtolower( $last_name );
        
        $domain = bmp_session_get_field_value( 4, 3 );
        if( empty( $domain ) ) {
           $domain = 'domain.com'; 
        }
        
        $last_option = '';
        
        /*
        $email_option = $step_2_data['email_option'];

        if( _string_contains( 'I already have', $email_option ) ) {
        	$last_option = 'I already have an email address';
        }
        else {
        	$last_option = 'Other';
        }
        */
         
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
add_filter( sprintf( 'gform_pre_validation_%s', $form_id ), 'preferred_email_address' );
add_filter( sprintf( 'gform_pre_submission_filter_%s', $form_id ), 'preferred_email_address' );


function bmp_populate_preferred_email( $value ) {
    
    $data = WC()->session->get( 'step_2_data' );
    
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
    
    if( ! empty( $email ) ) {
        return 'I already have an email address';
    }
    
}
add_filter( 'gform_field_value_preferred_email', 'bmp_populate_preferred_email' );



add_filter( 'gform_field_value_preferred_email_address', 'bmp_populate_preferred_email_address' );
function bmp_populate_preferred_email_address( $value ) {
    
    $data = WC()->session->get( 'step_2_data' );
    
    $email = '';
    
    if( ! empty( $data['office_email'] ) ) {
        $email = $data['office_email'];
    }
    else if( ! empty( $data['gsuite_email'] ) ) {
        $email = $data['gsuite_email'];
    }
    else {
        //$email = $data['email'];
    }
    
    if( ! empty( $email ) ) {
        return $email;
    }
    
}
