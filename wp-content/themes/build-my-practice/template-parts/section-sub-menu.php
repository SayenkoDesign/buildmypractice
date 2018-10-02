<?php

sub_page_menu();
function sub_page_menu() {
    
    global $post;
    
    /*
    we need to find the top level page ID
    */
    
    if ($post->post_parent)	{
        $ancestors=get_post_ancestors($post->ID);
        $root=count($ancestors)-1;
        $parent = $ancestors[$root];
    } else {
        $parent = $post->ID;
    }

    
    $pages = wp_list_pages( array( 'title_li' => '', 'child_of' => $parent, 'echo' => false ) );
    
        
    if( empty( $pages ) )
        return false;
        
    $pages = sprintf( '<ul>%s</ul>', $pages );
    
    $args = array(
        'html5'   => '<nav %s>',
        'context' => 'nav',
        'attr' => array( 'id' => 'nav-sub-menu', 'class' => 'nav-sub-menu' ),
        'echo' => false
    );
    
    $out = _s_markup( $args );
    
    $out .= '<div class="row small-collapse medium-uncollapse"><div class="small-12 columns">';
    
    $out .= sprintf( '<div class="hide-for-medium"><button class="button terms" type="button" data-toggle="terms-dropdown"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 20 20">
<path fill="#fff" d="M17 7v-2h-14v2h14zM17 11v-2h-14v2h14zM17 15v-2h-14v2h14z"></path>
</svg> <span class="screen-reader-text">%s</span></button><div class="dropdown-pane terms" id="terms-dropdown" data-toggler=".expanded">%s</div></div>', __( 'Menu', '_s' ), $pages );
    
    $out .= sprintf( '<div class="show-for-medium">%s</div>', $pages );
           
    $out .= '</nav>';
    
    $out .= '</div>';
    
    echo $out;
 }