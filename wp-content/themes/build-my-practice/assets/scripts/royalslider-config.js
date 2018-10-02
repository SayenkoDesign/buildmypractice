(function($) {
	'use strict';	
	
	
	
	var royalSlider, nav;
	
	var default_opts = {
		transitionType: 'fade',
		controlNavigation:'none',
		imageScaleMode: 'fill',
		imageAlignCenter:true,
		arrowsNav: true,
		arrowsNavAutoHide: true,
		sliderTouch: true,
		addActiveClass: true,
		sliderDrag:false,
		arrowsNavHideOnTouch: false,
		fullscreen: false,
		loop: true,
		autoScaleSlider: true, 
		//autoScaleSliderWidth: 1500,     
		//autoScaleSliderHeight: 592,
		slidesSpacing: 0,
		keyboardNavEnabled: false,
		navigateByClick: false,
		fadeinLoadedSlide: true,
		globalCaption:true,
		//imgWidth: 1500,
		//imgHeight: 592,
		transitionSpeed: 1000,
		
		autoPlay: {
				// autoplay options go gere
				enabled: true,
				pauseOnHover: false,
				delay: 1000
			}
	  };
	  
	  
	  $('.section-gallery .royalSlider').royalSlider(default_opts);
	  
	  
	  // Homepage Slider
	  
	  var custom_opts = {
		transitionType: 'fade',
		controlNavigation:'none',
		imageScaleMode: 'fill',
		imageAlignCenter:true,
		arrowsNav: false,
		arrowsNavAutoHide: true,
		sliderTouch: false,
		addActiveClass: true,
		sliderDrag:false,
		arrowsNavHideOnTouch: false,
		fullscreen: false,
		loop: true,
		autoScaleSlider: true, 
		autoScaleSliderWidth: 1500,     
		autoScaleSliderHeight: 592,
		slidesSpacing: 0,
		keyboardNavEnabled: false,
		navigateByClick: false,
		fadeinLoadedSlide: true,
		globalCaption:true,
		imgWidth: 1500,
		imgHeight: 592,
		transitionSpeed: 1000,
		
		autoPlay: {
				// autoplay options go gere
				enabled: true,
				pauseOnHover: false,
				delay: 1000
			}
	  };
	
   	$('.slideshow .royalSlider').royalSlider(custom_opts);
		
	royalSlider = $(".royalSlider");
	
	//$('.rsNav').appendTo('.slideshow');
  
   // hide single slider nav
	nav = royalSlider.find('.rsNav'); 
	if (nav.length && royalSlider.data('royalSlider').numSlides <= 1) { 
		nav.hide();
	}
	
	var slider = $(".royalSlider").data('royalSlider');
	
	if( royalSlider.length ) {
		
	}
		
	
})(jQuery);
