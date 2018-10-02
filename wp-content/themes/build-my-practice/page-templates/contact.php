<?php
/*
Template Name: Contact
*/

get_header(); ?>

<?php
// Hero
get_template_part( 'template-parts/hero', 'page' );
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
		
		print( '<div class="row"><div class="small-12 small-centered large-8 columns">' );
		
		while ( have_posts() ) :

			the_post();
			
			the_content();
				
		endwhile;
		
		print( '</div></div>' );
		_s_section_close();	
	}
	?>
	</main>


</div>

<?php
get_footer();
