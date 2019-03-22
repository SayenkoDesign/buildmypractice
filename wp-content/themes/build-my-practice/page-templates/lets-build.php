<?php
/*
Template Name: Lets Build
*/

get_header(); ?>

<?php
// Hero
get_template_part( 'template-parts/section', 'hero' );
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
        
        bmp_build_bundle_progress_bar();
		
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
