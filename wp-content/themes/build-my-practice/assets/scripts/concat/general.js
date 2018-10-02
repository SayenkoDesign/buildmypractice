(function (document, window, $) {

	'use strict';
    
    
    $('#primary-menu .sub-menu').each( function() {
        $(this).addClass('menu vertical nested');
    });
    
    

	// Load Foundation
	$(document).foundation();
    
    
    $(document).on('click', '.play-video', playVideo);
    
    function playVideo() {
                
        var $this = $(this);
        
        var url = $this.data('src');
                
        var $modal = $('#' + $this.data('open'));
        
        /*
        $.ajax(url)
          .done(function(resp){
            $modal.find('.flex-video').html(resp).foundation('open');
        });
        */
        
        var $iframe = $('<iframe>', {
            src: url,
            id:  'video',
            frameborder: 0,
            scrolling: 'no'
            });
        
        $iframe.appendTo('.video-placeholder', $modal );        
        
        
        
    }
    
    // Make sure videos don't play in background
    $(document).on(
      'closed.zf.reveal', '#modal-video', function () {
        $(this).find('.video-placeholder').html('');
      }
    );
    
    // Add/Remove desktop menu class
    $(document).on(
      'closeme.zf.reveal', '#modal-menu', function () {
        $('body').addClass('modal-menu-open');
        $('.site-header.fixed').removeClass('show');
        //new Foundation.Equalizer($('#menu-eq'));
      }
    );
    
    // Add/Remove desktop menu class
    $(document).on(
      'closed.zf.reveal', '#modal-menu', function () {
        $('body').removeClass('modal-menu-open');
        $('.site-header.fixed').removeClass('show');
       }
    );
    
    // Close desktop menu on mobile
    $(window).on('load changed.zf.mediaquery', function(event, newSize, oldSize) {
              
        if( ! Foundation.MediaQuery.atLeast('medium') ) {
          $('#modal-menu').foundation('close');
        }
       
    });
    
    
    
    $('.slick-posts').slick({
        dots: false,
        centerMode: true,
        //centerPadding: 0,
        slidesToShow: 3,
        arrows: true,
        nextArrow: '<div class="arrow-right"><span class="screen-reader-text">Next</span></div>',
        prevArrow: '<div class="arrow-left"><span class="screen-reader-text">Previous</span></div>',
        responsive: [
            {
              breakpoint: 980,
              settings: {
                centerMode: false,
                slidesToShow: 2,
                arrows: false                
              }
            },
            {
              breakpoint: 768,
              settings: {
                centerMode: false,
                slidesToShow: 1,
                arrows: false,
                dots: true
              }
            }
        ]
    });
    
    /*
    $('.slick-posts .post').mouseleave(function() {
		$('.hover').stop().animate({
			'max-height' : '0',
		}, 300, function() {		//animation complete
			
		});
    });
	$('.slick-posts .post').mouseover(function() {
		$('.hover').stop().animate({
			'max-height' : '1000px',
		}, 600, function() {		//animation complete
			
		});
    });
    */
    
    
    // only call masonry if ie10> && parent container exists
    if (Modernizr.dataset && $('.masonry-layout').length ) {
    
        var macy = Macy({
            container: '.masonry-layout',
            //trueOrder: false,
            waitForImages: false,
            margin: 12,
            columns: 3,
            breakAt: {
                980: 2,
                600: 1
            }
        });
    
    }
    
    
}(document, window, jQuery));
