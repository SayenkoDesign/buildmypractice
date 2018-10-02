<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */
?>

</div><!-- #content -->

<?php
get_template_part( 'template-parts/section', 'footer-cta' );
?>


<div class="footer-widgets">

    <div class="wrap">
        <div class="row">
        
            <div class="small-12 large-4 large-push-8 columns">
            <?php
            if(is_active_sidebar('footer-2')){
                dynamic_sidebar('footer-2');
            }
            ?>
            </div>
            
            <div class="small-12 large-8 large-pull-4 columns">
            <?php
            if(is_active_sidebar('footer-1')){
                echo '<div class="row">';
                dynamic_sidebar('footer-1');
                echo '</div>';
            }
            ?>
            </div>
        
        </div>
    </div>

</div>

<footer id="colophon" class="site-footer" role="contentinfo">
     <div class="wrap">
        
        <div class="column row">
                <div>
                <?php
                printf( '<p><span>&copy; %s Exactify.IT LLC.  All rights reserved</span>. <span><a href="%2$s">Seattle Web Design</a> by <a href="%2$s" target="_blank">Sayenko Design</a>.</span></p>', 
                date( 'Y' ), 'https://www.sayenkodesign.com' );
                
                echo _s_get_social_icons();
                ?>
				</div>
		</div>
	</div>
    
 </footer><!-- #colophon -->

<?php 
wp_footer(); 
?>
</body>
</html>
