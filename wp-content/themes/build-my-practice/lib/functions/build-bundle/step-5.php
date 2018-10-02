<?php

add_filter( sprintf( 'gform_pre_render_%s', 6 ), 'preferred_migration_option' );
add_filter( sprintf( 'gform_pre_validation_%s', 6 ), 'preferred_migration_option' );
add_filter( sprintf( 'gform_pre_submission_filter_%s', 6 ), 'preferred_migration_option' );

function preferred_migration_option( $form ) {
    
    $data = WC()->session->get( 'step_2_data' );
    
    $option = '';
    
    if( isset( $data['email_option'] ) && !empty( $data['email_option'] ) ) {
        $email_option = $data['email_option'];
        
        if ( _string_contains( 'Google', $email_option ) || _string_contains( 'G Suite', $email_option ) ) {
            $option = 'G Suite';
        }
        else if ( _string_contains( 'Office 365', $email_option ) ) {
            $option = 'Office 365';
        }
        else {
            
        }
    }
     
    foreach ( $form['fields'] as &$field ) {
        
        $choices = $field->choices;
 
        if ( _string_contains( 'preferred-migration-option', $field->cssClass ) ) {        
            $choices[0]['text'] = str_replace( '[Office 365/ G Suite]', $option, $choices[0]['text'] );
        }
        
        $field->choices = $choices;
                 
    }
 
    return $form;
}

add_filter( 'gform_field_value_migration_option', 'bmp_populate_migration_option' );
function bmp_populate_migration_option( $value ) {
    
    $data = WC()->session->get( 'step_2_data' );
    
    if( isset( $data['email_option'] ) && !empty( $data['email_option'] ) ) {
        $email_option = $data['email_option'];
        
        if( _string_contains( 'I already have', $email_option ) ) {
            return "I don't need any data migrated";
        }
    }
    
}