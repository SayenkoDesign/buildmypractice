<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

get_header(); ?>

<?php
// Hero
    
$args = array(
    'post_type'      => 'page',
    'p'				 => CASE_STUDY_PAGE_ID,
    'posts_per_page' => 1,
    'post_status'    => 'publish'
);

// Use $loop, a custom variable we made up, so it doesn't overwrite anything
$loop = new WP_Query( $args );

// have_posts() is a wrapper function for $wp_query->have_posts(). Since we
// don't want to use $wp_query, use our custom variable instead.
if ( $loop->have_posts() ) : 
    while ( $loop->have_posts() ) : $loop->the_post(); 
         get_template_part( 'template-parts/section', 'hero' );
    endwhile;
endif;

// We only need to reset the $post variable. If we overwrote $wp_query,
// we'd need to use wp_reset_query() which does both.
wp_reset_postdata();
                

terms_menu();
function terms_menu() {
    
    $terms = _s_case_study_terms();
        
    if( empty( $terms ) )
        return false;
        
    $terms = sprintf('<ul class="term-list">%s</ul>', $terms );
    
    $args = array(
        'html5'   => '<nav %s>',
        'context' => 'nav',
        'attr' => array( 'id' => 'nav-terms', 'class' => 'nav-terms' ),
        'echo' => false
    );
    
    $out = _s_markup( $args );
    
    $out .= '<div class="row small-collapse medium-uncollapse"><div class="small-12 columns">';
    
    $out .= sprintf( '<div class="hide-for-medium"><button class="button terms" type="button" data-toggle="terms-dropdown"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 20 20">
<path fill="#fff" d="M17 7v-2h-14v2h14zM17 11v-2h-14v2h14zM17 15v-2h-14v2h14z"></path>
</svg> <span class="screen-reader-text">%s</span></button><div class="dropdown-pane terms" id="terms-dropdown" data-toggler=".expanded">%s</div></div>', __( 'Menu', '_s' ), $terms );
    
    $out .= sprintf( '<div class="show-for-medium">%s</div>', $terms );
           
    $out .= '</nav>';
    
    $out .= '</div>';
    
    echo $out;
 }

?>

<div class="column row">

     <div id="primary" class="content-area">
    
        <main id="main" class="site-main" role="main">
            <?php
             
            if ( have_posts() ) : ?>
    
               <div class="masonry-layout">
               
               <?php
                while ( have_posts() ) :
    
                    the_post();
                    
                    
                    printf( '<article id="post-%s" class="%s">', get_the_ID(), join( ' ', get_post_class( 'masonry-layout__panel case-study' ) ) );
    
                    echo _case_study_item();
                    
                    echo '</article>';
    
                endwhile;
                
                ?>
                </div>
                <?php
                
             else :
    
                get_template_part( 'template-parts/content', 'none' );
    
            endif; ?>
    
        </main>
    
    </div>
  
</div>

<?php
get_footer();
