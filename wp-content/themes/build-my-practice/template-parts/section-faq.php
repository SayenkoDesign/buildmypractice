<?php

section_faq();
    function section_faq() {
        
        $prefix = 'faq';
        $prefix = set_field_prefix( $prefix );
        
        $rows = get_field( sprintf( '%saccordion', $prefix ) );
                        
        if( empty( $rows ) ) {
            return false;
        }
        
        $fa = new Foundation_Accordion;
        
        $columns = '';
        
        foreach( $rows as $key => $row ) {
            $active = ! $key ? true : false;
            $fa->add_item( $row['heading'], $row['content'], $active );
        }
        
        $accordion_items = $fa->accordion_items;
                
        $attr = array( 'id' => 'faq', 'class' => 'section faq' );        
          
        _s_section_open( $attr );	
        
        $heading = get_field( sprintf( '%sheading', $prefix ) );
          
        if( !empty( $heading ) ) {
            $heading    = _s_get_heading( $heading );
            $subheading = get_field( sprintf( '%ssubheading', $prefix ) );
            $subheading = _s_get_heading( $subheading, 'h5' );	
            printf( '<div class="column row"><header class="entry-header">%s%s</header></div>', $heading, $subheading );
        }
           
        print( '<div class="entry-content">' );
                
        if( count( $accordion_items ) > 1 ) {
            $accordion_group = c2c_array_partition( $accordion_items, 2 );
            
            foreach( $accordion_group as $group ) {
                $accordion = $fa->get_accordion( $group );
                $columns .= sprintf( '<div class="column">%s</div>', $accordion );
            }
            
            printf( '<div class="row small-up-1 large-up-2">%s</div>', $columns );
        }
        else {
            $accordion = $fa->get_accordion();
            printf( '<div class="column row">%s</div>', $accordion );
        }
        
        print( '</div>' );

        
        
        _s_section_close();	
        
        
        
        
           
    }