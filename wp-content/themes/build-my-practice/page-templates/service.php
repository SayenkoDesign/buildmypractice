<?php
/*
Template Name: Service
*/


get_header(); 

// Hero
get_template_part( 'template-parts/section', 'hero' );
    

get_template_part( 'template-parts/section', 'sub-menu' );
?>

<div id="primary" class="content-area">
                
    <main id="main" class="site-main" role="main">
    
    
    <?php
        
    section_featured_photo();
    function section_featured_photo() {
        
        $photo = get_field( 'featured_photo' );
        $photo = _s_get_acf_image( $photo );
        
        if( empty( $photo ) ) {
            return false;
        }
        
        $attr = array( 'id' => 'featured-photo', 'class' => 'section featured-photo' );        
          
        _s_section_open( $attr );		
        
        echo '<div class="column row">';
         
        printf( '<div class="entry-content">%s</div>', $photo );

        echo '</div>';
        
        _s_section_close();	
    }
    
    
    // Logos
    get_template_part( 'template-parts/section', 'logos' );
     
     
    // Services
    section_services();
    function section_services() {
                
        global $post;
        
        $prefix = 'services';
        $prefix = set_field_prefix( $prefix );
        
        $field = get_field( 'services' );
           
        $grid = $field['grid']; 
                          
        $attr = array( 'id' => 'services', 'class' => 'section services' );        
          
        _s_section_open( $attr );		
        
        echo '<div class="column row">';
                
        $grid_items = _kr_grid_items( $grid );
        
        if( !empty( $grid_items ) ) {
            
            $grid_items = sprintf( '<div class="row small-up-1 large-up-3 grid">%s</div>', implode( '', $grid_items ) );
        }
        
        printf( '<div class="entry-content">%s</div>', $grid_items );

        echo '</div>';
        
        _s_section_close();	
    }    
    
    // Blog Articles
    get_template_part( 'template-parts/section', 'blog-articles' );
    
 	  
    get_template_part( 'template-parts/section', 'faq' );

    ?>
  
	</main>

</div>
<?php
get_footer();
