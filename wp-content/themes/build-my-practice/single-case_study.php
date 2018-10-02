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
    
section_hero();
function section_hero() {
	global $post;
        
    $style = '';
  	$content = '';
     
    
    $header = _s_get_heading( get_the_title(), 'h1' );
    $header = sprintf( '<header class="entry-header">%s</header>', $header );
     
    $cats = _s_case_study_terms(); // do we want to remove this on the archives?
    $cats = '';
 	
    $prefix = 'hero';
    $prefix = set_field_prefix( $prefix );
 	$background_image	= get_field( sprintf( '%sbackground_image', $prefix ), CASE_STUDY_PAGE_ID );   
    
    if( !empty( $background_image ) ) {
        $attachment_id = $background_image;
        $size = 'hero';
        $background = wp_get_attachment_image_src( $attachment_id, $size );
        $style = sprintf( 'background-image: url(%s);', $background[0] );
        
    }
	
	$args = array(
        'html5'   => '<section %s>',
        'context' => 'section',
        'attr' => array( 'id' => 'hero', 'class' => 'section hero flex', 'style' => $style ),
        'echo' => false
    );
    
    $out = _s_markup( $args );
    $out .= _s_structural_wrap( 'open', false );
    
    
    $out .= sprintf( '<div class="row"><div class="small-12 columns text-center">%s%s</div></div>', $header, $cats );
    
    $out .= _s_structural_wrap( 'close', false );
    $out .= '</section>';
	
	echo $out;
		
}

?>

 
 <div id="primary" class="content-area">

    <main id="main" class="site-main" role="main">
        <?php
         
        section_challenge();
        function section_challenge() {
            
            $prefix = 'challenge';
            $prefix = set_field_prefix( $prefix );
                        
            $editor = get_field( sprintf( '%seditor', $prefix ) );
            
            if( empty( $editor ) ) {
                return false;
            }
             
            $attr = array( 'id' => 'challenge', 'class' => 'section challenge' );
                    
            _s_section_open( $attr );
            
                print( '<div class="column row">' );
    
                 printf( '<div class="entry-content">%s</div>', $editor );	
    
                 echo '</div>';
    
            _s_section_close();	   
        }
        
        
        
        section_solution();
        function section_solution() {
            
            $prefix = 'solution';
            $prefix = set_field_prefix( $prefix );
                        
            $editor = get_field( sprintf( '%seditor', $prefix ) );
            
            if( empty( $editor ) ) {
                return false;
            }
            
            $photo  = get_field( sprintf( '%sphoto', $prefix ) );
            $image  = _s_get_acf_image( $photo, 'why-us' );
            
            $attr = array( 'id' => 'solution', 'class' => 'section solution' );
                    
            _s_section_open( $attr );
            
                print( '<div class="column row">' );
                
                echo $image;
    
                printf( '<div class="white-box"><div class="entry-content">%s</div></div>', $editor );	
    
                echo '</div>';
    
            _s_section_close();	   
        }

        
        
        section_result();
        function section_result() {
            
            $prefix = 'result';
            $prefix = set_field_prefix( $prefix );
                        
            $editor = get_field( sprintf( '%seditor', $prefix ) );
            
            if( empty( $editor ) ) {
                return false;
            }
             
            $attr = array( 'id' => 'result', 'class' => 'section result' );
                    
            _s_section_open( $attr );
            
                print( '<div class="column row">' );
    
                 printf( '<div class="entry-content">%s</div>', $editor );	
    
                 echo '</div>';
    
            _s_section_close();	   
        }
        
        
        $previous = sprintf( '%s<span class="%s"></span>', 
                                         get_svg( 'next-arrow' ), __( 'Previous Post', '_s') );
                    
        $next = sprintf( '%s<span class="%s"></span>', 
                             get_svg( 'prev-arrow' ), __( 'Next Post', '_s') );
        
        printf( '<div class="column row">%s</div>', get_the_post_navigation( array( 'prev_text' => $previous, 'next_text' => $next ) ) );
         
        ?>

    </main>

</div>
  
 
<?php
get_footer();
