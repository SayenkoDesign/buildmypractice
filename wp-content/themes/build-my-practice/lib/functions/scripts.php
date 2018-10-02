<?php

// Register scripts to load later as needed
add_action( 'wp_enqueue_scripts', '_s_register_scripts' );
function _s_register_scripts() {

	// Foundation
	wp_register_script( 'foundation', trailingslashit( THEME_JS ) . 'foundation.min.js', array('jquery'), '', true );
    
    wp_register_script( 'macy', 
					   trailingslashit( THEME_ASSETS ) . 'bower_components/macy/dist/macy.js' );
                       
    wp_register_script( 'crypto-js', 'https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js' );
                       
                       

	// Frontpage
	wp_register_script( 'front-page', trailingslashit( THEME_JS ) . 'front-page.min.js', array('jquery'), '', true );

	// Project
 	wp_register_script( 'project' , trailingslashit( THEME_JS ) . 'project.js',
			array(
					'jquery',
 					'foundation',
                    'crypto-js',
                    'macy'
 					),
				NULL, TRUE );
                
    
    
    wp_localize_script( 'project', 'theme_vars', array( 
						'logo' 		    => get_svg( 'logo' ),
                        'menu_icon'     => get_svg( 'menu-icon' )
					
					 ) );
    

    // Slick Carousel
    wp_register_style( 'slick', 
					   trailingslashit( THEME_ASSETS ) . 'bower_components/slick-carousel/slick/slick.css' );
	wp_register_style( 'slick-theme', 
					   trailingslashit( THEME_ASSETS ) . 'bower_components/slick-carousel/slick/slick-theme.css' );

}


// Load Scripts
add_action( 'wp_enqueue_scripts', '_s_load_scripts' );
function _s_load_scripts() {

		wp_enqueue_script( 'project' );
        
         wp_enqueue_style( 'slick' );
         wp_enqueue_style( 'slick-theme' );

		if( is_front_page() ) {
 			wp_enqueue_script( 'front-page');
		}
}

// Testing Async and Defer
function add_defer_attribute($tag, $handle) {
   // add script handles to the array below
   $scripts_to_defer = array( 'project', 'front-page' );

   foreach($scripts_to_defer as $defer_script) {
      if ($defer_script === $handle) {
         return str_replace(' src', ' defer="defer" src', $tag);
      }
   }
   return $tag;
}

//add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);


function add_async_attribute($tag, $handle) {
   // add script handles to the array below
   $scripts_to_defer = array( 'project' );

   foreach($scripts_to_defer as $defer_script) {
      if ($defer_script === $handle) {
         return str_replace(' src', ' async src', $tag);
      }
   }
   return $tag;
}

//add_filter('script_loader_tag', 'add_async_attribute', 10, 2);
