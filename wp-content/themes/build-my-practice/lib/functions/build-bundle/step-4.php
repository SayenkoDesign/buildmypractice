<?php

// Step #1

/*
form_id = 3
*/

$form_id = 5;

add_filter( sprintf( 'gform_pre_render_%s', $form_id ), 'preferred_email_address' );
add_filter( sprintf( 'gform_pre_validation_%s', $form_id ), 'preferred_email_address' );
add_filter( sprintf( 'gform_pre_submission_filter_%s', $form_id ), 'preferred_email_address' );
//add_filter( sprintf( 'gform_admin_pre_render_%s', $form_id ), 'preferred_email_address' );
function preferred_email_address( $form ) {
    
    
 
    foreach ( $form['fields'] as &$field ) {
 
        if ( $field->type != 'radio' || strpos( $field->cssClass, 'preferred-email-address' ) === false ) {
            continue;
        }
        
        $defaults = array(
            'first' => 'first',
            'last' => 'last',
            'email' => 'email',
        );
        
        $step_2_data = WC()->session->get( 'step_2_data' );        
        $step_2_data = wp_parse_args( $step_2_data, $defaults );
                        
        $first = $step_2_data['first'];
        $first = strtolower( $first );
        
        $first_letter = '[FIRST LETTER OF FIRST NAME]';
        if( '[FIRST NAME]' != $first ) {
            $first_letter = $first[0];
        }
        
        $last = $step_2_data['last'];
        $last = strtolower( $last );
        
        $domain = 'domain.com';
        $step_3_data = WC()->session->get( 'step_3_data' );
        if( isset( $step_3_data['domain'] ) && !empty( $step_3_data['domain'] ) ) {
           $domain = $step_3_data['domain']; 
        }
        
        $last_option = '';

        $email_option = $step_2_data['email_option'];

        if( _string_contains( 'I already have', $email_option ) ) {
        	$last_option = 'I already have an email address';
        }
        else {
        	$last_option = 'Other';
        }
         
        $options = array(
            sprintf( '%s.%s@%s', $first, $last, $domain ),
            sprintf( '%s@%s', $first, $domain ),
            sprintf( '%s@%s', $last, $domain ),
            sprintf( '%s.%s@%s', $first_letter, $last, $domain ),
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


add_filter( 'gform_field_value_preferred_email', 'bmp_populate_preferred_email' );
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
