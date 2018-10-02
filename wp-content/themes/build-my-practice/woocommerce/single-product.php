<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

<?php
section_hero();
    function section_hero() {
        global $post;

    
        $heading = 'Build My Bundle';
        
        $style = '';
        $header = '';
        $content = '';
         
        
        $style = sprintf( 'background-image: url(%shero-default.png);', trailingslashit(THEME_IMG) );
        
        $style .= sprintf( ' background-position: %s %s;', 'center', 'center' );

              
        if( !empty( $heading ) ) {
            $header = _s_get_heading( $heading, 'h1' );
            $header = sprintf( '<header class="entry-header">%s</header>', $header );
        }

        $args = array(
            'html5'   => '<section %s>',
            'context' => 'section',
            'attr' => array( 'id' => 'hero', 'class' => 'section hero flex', 'style' => $style ),
            'echo' => false
        );
        
        $out = _s_markup( $args );
        $out .= _s_structural_wrap( 'open', false );
        
        
        $out .= sprintf( '<div class="row"><div class="small-12 columns text-center">%s</div></div>', $header );
        
        $out .= _s_structural_wrap( 'close', false );
        $out .= '</section>';
        
        echo $out;
            
    }
?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
