<?php

/*
Modal - Menu
*/

?>
<div class="modal-menu full reveal" id="modal-menu" data-reveal>
    <div class="modal-content">
        <div class="row small-collapse medium-uncollapse" data-equalizer data-equalize-on="medium" id="menu-eq">
            <div class="small-12 columns">
                
                <nav id="site-navigation" class="nav-primary" role="navigation"  data-equalizer-watch>
                    <h6>Sitemap</h6>
                        <?php
                            // Desktop Menu
                            $args = array(
                                'theme_location' => 'primary',
                                'menu' => 'Primary Menu',
                                'container' => 'false',
                                'container_class' => '',
                                'container_id' => '',
                                'menu_id'        => 'primary-menu',
                                'menu_class'     => 'vertical menu',
                                'before' => '',
                                'after' => '',
                                'link_before' => '',
                                'link_after' => '',
                                'items_wrap' => '<ul id="%1$s" class="%2$s" data-accordion-menu>%3$s</ul>',
                                'depth' => 0
                            );
                            wp_nav_menu($args);
                        ?>
                </nav><!-- #site-navigation -->
                
                <div class="recent-articles show-for-medium">
                    <h6>Recent Articles</h6>
                    
                    <?php
                    // arguments, adjust as needed
                    $args = array(
                        'post_type'      => 'post',
                        'posts_per_page' => 3,
                        'post_status'    => 'publish',
                     );
                
                    // Use $loop, a custom variable we made up, so it doesn't overwrite anything
                    $loop = new WP_Query( $args );
                
                    // have_posts() is a wrapper function for $wp_query->have_posts(). Since we
                    // don't want to use $wp_query, use our custom variable instead.
                    if ( $loop->have_posts() ) : 
                        
                        echo '<div>';
                        
                         while ( $loop->have_posts() ) : $loop->the_post(); 
                         
                            echo '<article>';
                
                            printf( '<h3><a href="%s">%s</a></h3>', get_permalink(), get_the_title() );
                            
                            _s_the_excerpt( '...', '', 20);
                            
                            echo '</article>';
                
                        endwhile;
                        
                        $post_id = get_option('page_for_posts');
                        printf( '<p><a href="%s" class="button">More Articles</a></p>', get_permalink( $post_id ) );                        
                        
                        echo '</div>';
                        
                     endif;
                
                    // We only need to reset the $post variable. If we overwrote $wp_query,
                    // we'd need to use wp_reset_query() which does both.
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
            
        </div>
            
    </div>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>