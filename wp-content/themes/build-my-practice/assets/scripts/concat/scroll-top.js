(function (document, window, $) {

	'use strict';
    
    $('.site-footer').append( '<div class="scroll-top"><button class="scroll"><span class="screen-reader-text"></span><svg viewbox="0 0 27 45" width="15" xmlns="http://www.w3.org/2000/svg"><path d="M18.244 21.905L.762 39.37c-.296.296-.446.636-.446 1.022s.15.727.446 1.023l2.224 2.221c.295.296.637.445 1.024.445.383 0 .725-.15 1.023-.445l20.73-20.707c.295-.299.445-.64.445-1.023 0-.386-.15-.727-.445-1.023L5.033.175C4.735-.124 4.396-.27 4.01-.27c-.387 0-.729.146-1.024.445L.762 2.395c-.296.297-.446.637-.446 1.023 0 .384.15.725.446 1.021l17.482 17.466z" fill="#252B33" fill-rule="evenodd"/><span class="screen-reader-text">next</span></svg></button></div>' );
    
    
    // ===== Scroll to Top ==== 
    $(window).scroll(function() {
        if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
            $('.scroll-top').fadeIn(200);    // Fade in the arrow
        } else {
            $('.scroll-top').fadeOut(200);   // Else fade out the arrow
        }
    });
    
    $('.scroll-top .scroll').on('click', function() {
      $.smoothScroll({
        scrollTarget: 'body'
      });
      return false;
    });
    
}(document, window, jQuery));
