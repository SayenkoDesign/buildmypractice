<?php

/*
Logos
		
*/
	
section_logos();
function section_logos() {
    
    $prefix = 'logos';
    $prefix = set_field_prefix( $prefix );
    
    $rows = get_field( 'logos_logos' );
      
    if( empty( $rows ) ) {
        return false;
    }
    
    $attr = array( 'id' => 'logos', 'class' => 'section logos' );
    
    _s_section_open( $attr );
    
        $out = '';
        
       foreach( $rows as $row ) {
           $logo = _s_get_acf_image( $row['image'] );
            
           $anchor_open = $anchor_close = '';
           $url = $row['url'];
           if( !empty( $url ) ) {
               $anchor_open = sprintf( '<a href="%s">', $url );
               $anchor_close = '</a>';
           }
           
           $out .= sprintf( '<div class="column logo"><div class="spacer">%s%s%s</div></div>', $anchor_open, $logo, $anchor_close );
       }
       
       if( !empty( $out ) ) {
           printf( '<div class="row small-up-1 large-up-3">%s</div>', $out );
       }
    
    _s_section_close();	
        
}