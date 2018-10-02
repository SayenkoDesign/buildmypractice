<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'column row' ); ?>>
	
	<?php
         
    if( !is_single() ) {
        
        $post_image = get_the_post_thumbnail_url( get_the_ID(), 'large' );
        if( !empty( $post_image ) ) {
            $post_image = sprintf( 'background-image: url(%s);', $post_image );
        }
        $post_categories =  get_the_category_list( '' );
        
        $post_title = sprintf( '<h2><a href="%s">%s</a></h2>', get_permalink(), get_the_title() );
        $post_author = _s_get_post_author();
    
        printf( '<div class="post-hero" style="%s"><div class="flex"><header class="entry-header">%s%s%s</header></div></div>', 
                $post_image, $post_categories, $post_title, $post_author );
                
        
    }
	?>
	
	<div class="entry-content">
	
		<?php 
		if( is_single() ) {
			
			the_content(); 
			
		} else {
	
			_s_the_excerpt( '', '', 80 );
			
			printf( '<p class="read-more"><a href="%s" class="more">%s ></a></p>', get_permalink(), __( 'Continue Reading', '_s' ) ) ;
		}
		?>
		
	</div><!-- .entry-content -->

	<footer class="entry-footer">
        
        <?php 
        if( is_single() ) {
  			
            printf( '<h4 class="text-left">%s</h4>', __( 'Share This:', '_s' ) );
            
            printf( '<div class="column row">%s</div>', _s_get_addtoany_share_icons() );
  			
		} 
        
        ?>
        
         
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
