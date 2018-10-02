<?php

get_header(); ?>

<?php
section_hero();
function section_hero() {
	global $post;
    
    $background_image = get_the_post_thumbnail_url( get_the_ID(), 'hero' );
    
    $post_categories =  get_the_category_list( '' );
    
    $heading = sprintf( '<h1>%s</h1>', get_the_title() );
    $description = sprintf( '<p>%s</p>', _s_get_posted_on() );
    
    $post_author = _s_get_post_author( 120, $post->post_author );

 	
	$style = '';
  	$content = '';
	
	if( !empty( $background_image ) ) {
		$style = sprintf( 'background-image: url(%s);', $background_image );
	}
	
	
	$args = array(
		'html5'   => '<section %s>',
		'context' => 'section',
		'attr' => array( 'id' => 'hero', 'class' => 'section hero flex', 'style' => $style ),
		'echo' => false
	);
	
	$out = _s_markup( $args );
	$out .= _s_structural_wrap( 'open', false );
	
	
	$out .= sprintf( '<div class="row"><div class="small-12 columns">%s%s%s%s</div></div>', $post_categories, $heading, $description, $post_author );
	
	$out .= _s_structural_wrap( 'close', false );
	$out .= '</section>';
	
	echo $out;
		
}
?>

<div class="row">

    <div class="large-8 columns small-centered">
    
        <div id="primary" class="content-area">
        
            <main id="main" class="site-main" role="main">
                <?php
                 
                if ( have_posts() ) : ?>
        
                   <?php
                    while ( have_posts() ) :
        
                        the_post();
        
                        get_template_part( 'template-parts/content', 'post' );
        
                    endwhile;
                    
                    $previous = sprintf( '%s<span class="%s"></span>', 
                                         get_svg( 'next-arrow' ), __( 'Previous Post', '_s') );
                    
                    $next = sprintf( '%s<span class="%s"></span>', 
                                         get_svg( 'prev-arrow' ), __( 'Next Post', '_s') );
                    
                    the_post_navigation( array( 'prev_text' => $previous, 'next_text' => $next ) );
                    
                else :
        
                    get_template_part( 'template-parts/content', 'none' );
        
                endif; ?>
        
            </main>
        
        </div>
    
    </div>
    
    

</div>

<?php

section_related_articles();
function section_related_articles() {
    global $post;
    
    $prefix = 'related';
    $prefix = set_field_prefix( $prefix );
    
    $posts = get_field( sprintf( '%sposts', $prefix ) );
    
    if( empty( $posts ) ) {
        return false;
    }
    
    $loop = new WP_Query( array(
        'post_type' => 'post',
        'order' => 'ASC',
        'orderby' => 'post__in',
        'posts_per_page' => -1,
        'post__in' => $posts
    ) );
            
    $items = '';
    
    if ( $loop->have_posts() ) : 
                                
        while ( $loop->have_posts() ) : $loop->the_post();
              
            $items .= _related_article();
 
        endwhile; 
         
    endif;
    
    // Reset things, for good measure
    $loop = null;
    
    wp_reset_postdata();
    
    if( empty( $items ) ) {
        return false;
    }
    
    $attr = array( 'id' => 'blog-articles', 'class' => 'section blog-articles' );
    
    _s_section_open( $attr );
        
        $heading = _s_get_heading( 'Related Articles' );
        printf( '<header class="entry-header">%s</header>', $heading );
                
        printf( '<div class="slick-posts">%s</div>', $items );
    
    _s_section_close();	
        
}


function _related_article() {
    
    $background = get_the_post_thumbnail_url( get_the_ID(), 'large' );
    
    if( !empty( $background ) ) {
        $background = sprintf( ' style="background-image: url(%s);"', $background );
    }
    
          
    $title = sprintf( '<h3>%s</h3>', get_the_title() );
                      
    $excerpt = _s_get_the_excerpt( '', '', 20 );
    
    $button = sprintf( '<p><a href="%s" class="button blue">See Article</a></p>', 
                      get_permalink() );
                      
    $description = sprintf( '<div class="hover">%s%s</div>', $excerpt, $button );
     
    return sprintf( '<div class="post"><div class="background" %s></div><div class="details">%s%s</div></div>', $background, $title, $description );   
}
?>

<?php
get_footer();
