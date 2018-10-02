(function($) {
	'use strict';	
	
	
	
     
    $('.what-we-do-slider').slick({
        dots: true,
        centerMode: true,
        slidesToShow: 3,
        arrows: false,
        //variableWidth: true,
        //mobileFirst: false,
        responsive: [
            {
              breakpoint: 1280,
              settings: {
                slidesToShow: 2
              }
            },
            {
              breakpoint: 640,
              settings: {
                slidesToShow: 1
              }
            }
        ]
    });
    
    
	
})(jQuery);
