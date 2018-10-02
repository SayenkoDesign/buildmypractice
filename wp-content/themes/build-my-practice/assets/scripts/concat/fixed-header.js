(function (document, window, $) {

	'use strict';
    
    // Scroll up show header

	var $site_header =  $('.site-header');

	// clone header
	var $sticky = $site_header.clone()
							   .prop('id', 'masthead-fixed' )
							   .attr('aria-hidden','true')
							   .addClass('fixed')
							   .insertBefore('#masthead');
     
    
    // We've localized the default logo inside scripts.php
	// We've localized the default logo inside scripts.php
	$sticky.find('.site-title a').html( theme_vars.logo );
    $sticky.find('.menu-toggle').html( theme_vars.menu_icon );

	var header_height = $site_header.height();
	var lastScrollTop = 0;
    var wait = 25; // distance in pixels to wait before showing

	$(window).scroll(function() {

		var scroll = $(window).scrollTop();

		if (scroll < 400 ) {
            $sticky.removeClass("show");
            return;
		} 
        
        $sticky.addClass("show");
        return;

	   var st = $(this).scrollTop();
       
	   if (st > lastScrollTop){
		   // downscroll code
		   $sticky.removeClass("show");
	   } else {
		  // upscroll code
          
          if( lastScrollTop - st >= wait ) {
              $sticky.addClass("show");
          }
          
		  
	   }
	   lastScrollTop = st;

	});
    

}(document, window, jQuery));