(function (document, window, $) {

	'use strict';
        
    $('.radio-group-1').find('.gfield_radio input').change(function() {
        
        $('.radio-group-1').not($(this).parents('.radio-group-1')).find('.gfield_radio input').prop('checked', false);

    });
    
}(document, window, jQuery));




