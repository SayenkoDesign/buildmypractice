<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo THEME_FAVICONS;?>/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo THEME_FAVICONS;?>/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo THEME_FAVICONS;?>/favicon-16x16.png">
<link rel="manifest" href="<?php echo THEME_FAVICONS;?>/manifest.json">
<link rel="mask-icon" href="<?php echo THEME_FAVICONS;?>/safari-pinned-tab.svg" color="#51B6C8">
<meta name="theme-color" content="#ffffff">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', '_s' ); ?></a>

    <?php
    $tel = get_field( 'telephone', 'option' );
    ?>
    
    <header id="masthead" class="site-header" role="banner">
		<div class="wrap">
			
			<div class="row">
                
 				<div class="medium-4 large-6 columns site-branding">
                
                    <?php
                    if( !empty( $tel ) ) {
                       printf( '<a class="mobile-phone hide-for-medium" href="%s">%s</a>', _s_format_telephone_url( $tel ), get_svg( 'phone' ) ); 
                    }
                    ?>
                  
					<div class="site-title">
					<?php
					$site_url = home_url();
                    $logo_white = sprintf('<div class="logo-white show-for-medium">%s</div>', get_svg( 'logo-white' ) );
                    $logo = sprintf('<div class="logo hide-for-medium">%s</div>', get_svg( 'logo' ) );
					printf('<a href="%s" title="%s">%s%s</a>',
							$site_url, get_bloginfo( 'name' ), $logo_white, $logo );
  					?>
					</div>
				</div><!-- .site-branding -->
                  
                <div class="medium-8 large-6 columns header-widgets show-for-medium">
                    
                    <?php
                    if( !empty( $tel ) ) {
                       printf( '<aside class="widget widget_text"><h3 class="widget-title">Questions</h3>			
                                <div class="textwidget"><p><a href="%s">%s</a></p></div></aside>', _s_format_telephone_url( $tel ), $tel ); 
                    }
 
                    if(is_active_sidebar('header')){
                        dynamic_sidebar('header');
                    }
                    
                    
                    ?>                    
                </div>
                
                <?php
                
                global $woocommerce; 
                    
                if ( sizeof( $woocommerce->cart->cart_contents) > 0 ) :
                    printf( '<a href="%s" title="%s" class="view-cart">%s%s</a>', 
                            wc_get_cart_url(), 
                            __( 'View Cart' ), 
                            get_svg( 'cart' ),
                            __( 'View Cart' ) );
                   
                endif;
                ?>
                
                <button type="button" class="menu-toggle" data-toggle="modal-menu" aria-controls="modal-menu" aria-haspopup="true" tabindex="0">
                    <?php echo get_svg('menu-icon-white');?>
                    <?php echo get_svg('menu-icon');?>
				    <span class="screen-reader-text">Menu toggle</span></button>
			</div>
              
		</div><!-- wrap -->
         
	</header><!-- #masthead -->



<div id="page" class="site-container">

	<div id="content" class="site-content">
