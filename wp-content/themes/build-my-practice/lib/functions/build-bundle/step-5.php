<?php

function preferred_migration_option( $form ) {
    
    $storage_option = bmp_session_get_field_value( 3, 31 );
    $option = '';
    
    if( _string_contains( 'I already have', $storage_option ) ) {
        $office_email = bmp_session_get_field_value( 3, 26 );
        $gsuite_email = bmp_session_get_field_value( 3, 27 );
        if( ! empty( $office_email ) ) {
            $option = 'Office 365';
        }
        else if( ! empty( $office_email ) ) {
            $option = 'G Suite';
        }
        else {
            $option = '';
        }
    }
    
    if( ! empty( $option ) ) {
        
        foreach ( $form['fields'] as &$field ) {
        
            $choices = $field->choices;
     
            if ( _string_contains( 'preferred-migration-option', $field->cssClass ) ) {        
                $choices[0]['text'] = str_replace( '[Office 365/ G Suite]', $option, $choices[0]['text'] );
            }
            
            $field->choices = $choices;
                     
        }
    }
 
    return $form;
}
add_filter( sprintf( 'gform_pre_render_%s', 6 ), 'preferred_migration_option' );
add_filter( sprintf( 'gform_pre_validation_%s', 6 ), 'preferred_migration_option' );
add_filter( sprintf( 'gform_pre_submission_filter_%s', 6 ), 'preferred_migration_option' );


function gform_field_value_gf_form_6_field_3( $value ) {
    
    $storage_option = bmp_session_get_field_value( 3, 31 );
        
    if( _string_contains( 'I already have', $storage_option ) ) {
        return "I don't need any data migrated";
    }    
}
add_filter( 'gform_field_value_gf_form_6_field_3', 'gform_field_value_gf_form_6_field_3' );
