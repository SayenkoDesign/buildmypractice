<?php

/*
Packages
		
*/
	
section_packages();
function section_packages() {
    
    $prefix = 'packages';
    $prefix = set_field_prefix( $prefix );
    
    $packages = get_field( 'packages' );
    
    $packages_heading = $packages['packages_heading'];
    
    $packages_id = $packages['package'];
        
    $rows = get_field( 'packages' , $packages_id );
    
    if( empty( $rows ) ) {
        return false;
    }
    
    $packages = array();
    
    
    foreach( $rows as $row ) {
        $heading = _s_get_heading( $row['heading'], 'h4' );
        $price = $row['price'];
        $price_details = _s_get_textarea( $row['package_price_details'], 'span' );
        $features = $row['features'];
        if( !empty( $features ) ) {
            foreach( $features as $feature ) {
                if( !empty( $feature['feature'] ) ) {
                    $_features[] = $feature['feature'];
                }
            }
            
            $features = $_features;
        }
        
        
        $button = pb_get_cta_button( $row['button'], array( 'class' => 'button orange' ) );
        
        $packages[] = array( 'header' => $heading,
                             'price' => sprintf( '<div class="price"><sup>$</sup>%s%s</div>', $price, $price_details ),
                             'features' => $features,
                             'button' => $button
                     );
    }
    
    
    $attr = array( 'id' => 'pricing-table', 'class' => 'section pricing-table' );
    
    _s_section_open( $attr );
        
        $heading        = $packages_heading;
        $heading        = _s_get_heading( $heading );
        
        if( !empty( $heading ) ) {
            printf( '<header class="entry-header">%s</header>', $heading );
        }
        
        $out = '';
        
        foreach( $packages as $package ) {
            $column = '';
            
            $column .= sprintf( '<li class="header">%s</li>', $package['header'] );
            $column .= sprintf( '<li class="price">%s</li>', $package['price'] );
            
            if( !empty( $package['features'] ) ) {
                foreach( $package['features'] as $feature ) {
                    $column .= sprintf( '<li class="feature">%s</li>', $feature );
                }
            }
            
            if( !empty( $package['button'] ) ) {
                $column .= sprintf( '<li class="footer">%s</li>', $package['button'] );
            }
            
            $out .= sprintf( '<div class="column column-block"><ul class="no-bullet">%s</ul></div>', $column );
        }
                
        printf( '<div class="row small-up-1 large-up-3">%s</div>', $out );
    
    _s_section_close();	
        
}