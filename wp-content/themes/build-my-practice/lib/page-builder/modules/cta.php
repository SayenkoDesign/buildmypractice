<?php


/**
 * CTA Button
 * Create a formatted anchor for an ACF button
 * If using clone field check for prefix
 * @param array  $args
 * @param array  $attr
 * @param string $prefix
 * @return string anchor
 */
function pb_get_cta_button( $args = array(), $attr = '', $prefix = '' ) {
        	    
    $args = _get_args( $args, $attr, $prefix );
        	
	extract( $args );
     
	$url = $target = '';
	
	// Link type
    if( 'none' == $link || '' == $text ) {
        return false;
    }
     
	else if ( $link == 'Page' ) {
		if ( ! empty( $page ) ) {
			$url = $page;
		}
 	} else if( $link == 'File' ) {
        $url = $file;
 	} else {
		if ( ! empty( $url ) ) {
			$url = $url;
		}
		// Link target
		if ( $target == 'New Tab' ) {
			$target = ' target="_blank"';
		}
	} 
	
    	
	if ( ! empty( $attr ) ) {
		$attr = _s_attr( '', $attr );
	}
    	
	$button =  sprintf( '<a href="%s" %s %s><span>%s</span></a>', $url, $attr, $target, $text );
            
    return $button;
}


/**
 * CTA URL
 * Return the URL
 * If using clone field check for prefix
 * @param array  $args
 * @param array  $attr
 * @param string $prefix
 * @return string anchor
 */
function pb_get_cta_url( $args = array(), $attr = '', $prefix = '' ) {
    	    
    $args = _get_args( $args = array(), $attr = '', $prefix = '' );
	
	extract( $args );
     
	$url = $target = '';
	
	// Link type
    if( 'none' == $link ) {
        return false;
    }
     
	else if ( $link == 'Page' ) {
		if ( ! empty( $page ) ) {
			$url = $page;
        }
    } else if( $link == 'File' ) {
            $url = $file;
 	} else {
		if ( ! empty( $url ) ) {
			$url = $url;
		}
		// Link target
		if ( $target == 'New Tab' ) {
			$target = ' target="_blank"';
		}
	} 
	
    	
	if ( ! empty( $attr ) ) {
		$attr = _s_attr( '', $attr );
	}
    	
	return $url;
            
 }
 
 
 
 function _get_args( $args = array(), $attr = '', $prefix = '' ) {
	    
    $prefix = set_field_prefix( $prefix );
    
    $defaults = array(
        $prefix . 'text' => '',
        $prefix . 'link' => '',
        $prefix . 'page' => '',
        $prefix . 'file'        => '',
        $prefix . 'url'         => '',
        $prefix . 'target' => '',
    );
    
    return wp_parse_args( $args, $defaults );
     
 }