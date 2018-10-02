<?php
/*
Template Name: My Account
*/

// Page is only available for clients
is_client_logged_in();

get_header(); 

get_template_part( 'template-parts/section', 'my-account-hero' );
    
get_template_part( 'template-parts/section', 'my-account-sub-menu' );


?>

<div id="primary" class="content-area">
                
    <main id="main" class="site-main" role="main">
    
    <?php
 	// Default
	section_default();
	function section_default() {
				
		global $post;
		
		$attr = array( 'class' => 'section default' );
		
		_s_section_open( $attr );		
		
		print( '<div class="column row">' );
		
		while ( have_posts() ) :

			the_post();
			
			the_content();
				
		endwhile;
		
		print( '</div>' );
		_s_section_close();	
	}
	?>
  
	</main>

</div>
<?php
get_footer();
