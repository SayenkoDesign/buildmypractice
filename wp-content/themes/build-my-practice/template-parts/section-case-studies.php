<?php

/*
Case Studies
		
*/
	
section_case_studies();
function section_case_studies() {
    
    $loop = new WP_Query( array(
        'post_type' => 'case_study',
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'posts_per_page' => -1,
    ) );
    
    $items = '';
    
    // single level, we'll just explode these
    $mobile = array();
    
    // how often we want to group
    $nth_child = 3;
    
    if ( $loop->have_posts() ) : 
                        
        $items .= '<div class="case-study">';
        
        while ( $loop->have_posts() ) : $loop->the_post();
        
                
            $index = $loop->current_post;		
            $last = ( $loop->current_post +1 ) == ( $loop->post_count );		
            
            $items .= _case_study_item( $index );
            
            // After first, after every third, and after last
            if( $index == 1 || ( $index % $nth_child !== 0  ) || $last ) {
                $items .= '</div>';
            }
            
            // after every third, but not last
            if( ( $index % $nth_child !== 0 ) && ! $last ) {
                                        
                $items .= '<div class="case-study">';
            }

            // mobile is a single row, we'll just store as an array then explode
            $mobile[] = sprintf( '<div class="case-study">%s</div>',  _case_study_item() );	
                    

        endwhile; 
        
        // Are mobile set
        $mobile_items = implode( '', $mobile );
        
        // Less thna 6, just show the moble layout
        if( $loop->found_posts < 6 ) {
            $items = $mobile_items;
        }
        
        
    endif;
    
    // Reset things, for good measure
    $loop = null;
    wp_reset_postdata();
    
    if( empty( $items ) ) {
        return false;
    }
    
    $attr = array( 'id' => 'case-studies', 'class' => 'section case-studies' );
    
    _s_section_open( $attr );
    
        print( '<div class="column row">' );
        
        $title = sprintf( '<h3>%s</h3>', __( 'Case Studies', '_s' ) );
        
        $subtitle = sprintf( '<h2>%s</h2>', __( 'The facts. Charges. Verdict.', '_s' ) );
        
        printf( '<header class="entry-header">%s%s</header>', $title, $subtitle );	
        
        printf( '<div class="hide-for-large"><div class="slick-case-studies">%s</div></div>', $mobile_items );
        
        printf( '<div class="show-for-large"><div class="slick-case-studies">%s</div></div>', $items );
        
        echo '</div>';
    
    _s_section_close();	
        
}