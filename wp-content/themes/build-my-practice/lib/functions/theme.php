<?php

// Add modals to footer
function _s_footer() {
    get_template_part( 'template-parts/modal', 'menu' );   
    get_template_part( 'template-parts/modal', 'video' );   
    get_template_part( 'template-parts/modal', 'contact' );   
}
add_action( 'wp_footer', '_s_footer' );
