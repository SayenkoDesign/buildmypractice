<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

get_header(); ?>
<div id="primary" class="content-area">
                
    <main id="main" class="site-main" role="main">
    
    
    <?php
    section_hero();
    function section_hero() {
        global $post;
        
        $prefix = 'hero';
        $prefix = set_field_prefix( $prefix );
    
        $heading 		= get_field( sprintf( '%sheading', $prefix ) );
        $description	= get_field( sprintf( '%sdescription', $prefix ) );
        
        $background_image = get_post_meta( get_the_ID(), sprintf( '%sbackground_image', $prefix ), true );
        
        $video	            = get_field( sprintf( '%svideo', $prefix ) );
        $video_description	= get_field( sprintf( '%svideo_description', $prefix ) );
        
        $style = '';
        
        $header = '';
        
        $content = '';
         
        if( !empty( $background_image ) ) {
            $attachment_id = $background_image;
            $size = 'hero';
            $background = wp_get_attachment_image_src( $attachment_id, $size );
            $style = sprintf( 'background-image: url(%s);', $background[0] );
        }
        
        
        if( !empty( $description ) ) {
            $description = _s_wrap_text( $description, "\n" );
            $description = _s_get_heading( nl2br( $description ) );
         }
              
        if( !empty( $heading ) ) {
            $header = _s_get_heading( $heading, 'h1' );
            $header = sprintf( '<header class="entry-header">%s%s</header>', $header, $description );
        }
         
        
        // Video
        if( !empty( $video ) ) {
            $video_url = youtube_embed( $video );
            $content = sprintf( '<div class="entry-content"><p><button class="play-video" data-open="modal-video" data-src="%s">%s</button><span>%s</span></p></div>', $video_url, get_svg( 'play' ), $video_description );
        }
    
        $args = array(
            'html5'   => '<section %s>',
            'context' => 'section',
            'attr' => array( 'id' => 'hero', 'class' => 'section hero flex', 'style' => $style ),
            'echo' => false
        );
        
        $out = _s_markup( $args );
        $out .= _s_structural_wrap( 'open', false );
        
        
        $out .= sprintf( '<div class="row"><div class="small-12 columns text-center">%s%s</div></div>', $header, $content );
        
        $out .= _s_structural_wrap( 'close', false );
        $out .= '</section>';
        
        echo $out;
            
    }
    ?>
	
	
    <?php
     
    section_services();
    function section_services() {
                
        global $post;
        
        $prefix = 'services';
        $prefix = set_field_prefix( $prefix );
        
        $field = get_field( 'services' );
           
        $heading = $field['heading'];
        
        $editor = $field['editor'];  
        
        $grid = $field['grid']; 
        
        $more = get_field( sprintf( '%smore', $prefix ) );     
                  
        $attr = array( 'id' => 'services', 'class' => 'section services text-center' );        
          
        _s_section_open( $attr );		
        
        echo '<div class="column row">';
        
        if( !empty( $heading ) ) {
            $heading = _s_wrap_text( $heading );
            $heading = _s_get_heading( $heading );
            printf( '<header class="entry-header">%s</header>', $heading );
        }
        
        $grid_items = _kr_grid_items( $grid );
        
        if( !empty( $grid_items ) ) {
            
            if( !empty( $more ) ) {
                $more = sprintf( '<p class="text-center">%s</p>', $more );
            }
            
            $grid_items = sprintf( '<div class="row small-up-1 large-up-3 grid">%s</div>%s', implode( '', $grid_items ), $more );
        }
        
        printf( '<div class="entry-content">%s%s</div>', $editor, $grid_items );

        echo '</div>';
        
        _s_section_close();	
    }  
    
    
    echo '<div class="group">';  
        
    // Logos
    get_template_part( 'template-parts/section', 'logos' );
	  
    
    section_build_your_bundle();
    function section_build_your_bundle() {
                
        global $post;
        
        $prefix = 'build_your_bundle';
        
        $field = get_field( 'build_your_bundle' );
          
        $heading = $field['heading'];
        
        $editor = $field['editor'];
        
        $button = $field['button'];
                
        $button = pb_get_cta_button( $button, array( 'class' => 'button orange' ) );
                
        $attr = array( 'id' => 'build-your-bundle', 'class' => 'section build-your-bundle text-center' );        
          
        _s_section_open( $attr );		
        
        echo '<div class="column row">';
        
        if( !empty( $heading ) ) {
            $heading = _s_wrap_text( $heading );
            $heading = _s_get_heading( $heading );
            printf( '<header class="entry-header">%s</header>', $heading );
        }
        
        printf( '<div class="entry-content">%s%s</div>', $editor, $button );

        echo '</div>';
        
        _s_section_close();	
    }
    
    
    // Packages
    get_template_part( 'template-parts/section', 'pricing-table' );
    
    echo '</div>'; // end Group
    
    // Blog Articles
    get_template_part( 'template-parts/section', 'blog-articles' );
    
    ?>
  
	</main>

</div>
<?php
get_footer();
