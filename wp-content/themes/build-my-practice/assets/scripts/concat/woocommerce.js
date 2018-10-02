(function (document, window, $) {

	'use strict';
    
    /*
    var $packages = $('.bundled_product').not('.bundled_product_7').find('.bundled_product_optional_checkbox :checkbox');
    $packages.change(function() {
        $packages.filter(':checked').not(this).removeAttr('checked');
        
        if( $('.bundled_product_3').find('.bundled_product_optional_checkbox :checkbox').is(':checked') ) {
            $('.bundled_product_7').hide();
            $('.bundled_product_7').find('.bundled_product_optional_checkbox :checkbox').prop( "checked", false );
        }
    });
    
    
    $('.bundled_product').not('.bundled_product_7, .bundled_product_3').find('.bundled_product_optional_checkbox :checkbox').change(function() {
        if(this.checked) {
            $('.bundled_product_7').show();
        }
        else {
            $('.bundled_product_7').hide();
            $('.bundled_product_7').find('.bundled_product_optional_checkbox :checkbox').prop( "checked", false );
        }
    });
    
    /*
    var $microsoft_plan = $('.bundled_product_optional_checkbox input[name!=bundle_selected_optional_3]');
    var $microsoft_addon = $('.bundled_product_7');
    
    // Not Microsoft bundle
    var $unique = $('.bundled_product_optional_checkbox input[name!=bundle_selected_optional_7]');
    $unique.click(function() {
        $unique.filter(':checked').not(this).removeAttr('checked');
        
        $microsoft_addon.toggle();
        
        
        if( ! $microsoft_plan.prop('checked') ) {
             $microsoft_addon.toggle();
             
        }
                
    });
    
    $microsoft_plan.click(function() {
        $microsoft_addon.prop( "checked", false );
        $microsoft_addon.hide();
    });
    
    /*
    // bundle_selected_optional_3
    var $not_microsoft_plan = $('.bundled_product_optional_checkbox input[name!=bundle_selected_optional_3]');
    var $microsoft_plan = $('.bundled_product_3');
    var $microsoft_addon = $('.bundled_product_7');
    
    $microsoft_plan.click(function() {
        if ($microsoft_plan.prop('checked')) {
            microsoft_addon.prop( "checked", false );
            microsoft_addon.hide();
        }
    });
    
    
    $not_microsoft_plan.click(function() {
                
        $microsoft_addon.show();
    });
    */
    
    /* Step 2 */
    
    
    $('#product-477').find('.gfield_radio input').change(function() {
        
        $('.add-to-cart-box').removeClass('office365-new');
        $('.add-to-cart-box').removeClass('office365');
        $('.add-to-cart-box').removeClass('gsuite-new');
        $('.add-to-cart-box').removeClass('gsuite');

        if(this.id === 'choice_3_31_0' ) {
            $('.add-to-cart-box').addClass('office365-new');
        }
        else if(this.id === 'choice_3_31_1' ) {
            $('.add-to-cart-box').addClass('gsuite-new');
        }
        else if (this.id === 'choice_3_31_2') {
            $('.add-to-cart-box').addClass('office365');
        }
        else if (this.id === 'choice_3_31_3') {
            $('.add-to-cart-box').addClass('gsuite');
        }
        
    });
    
    
    var $migrate_value =  $('#product-470 .gfield_radio input:checked').val();
    if($migrate_value === 'I don\'t need any data migrated|0' ) {
        $('.quantity').hide();
        $('.add-to-cart-box').addClass('transparent');
    }
        
    $('#product-470').find('.gfield_radio input').change(function() {
        
        $('.add-to-cart-box').removeClass('transparent');
        $('.quantity').show();
        
        if(this.value === 'I don\'t need any data migrated|0' ) {
            $('.quantity').hide();
            $('.add-to-cart-box').addClass('transparent');
        }
        
    });
    
    $('#product-469').find('.gfield_radio input').change(function() {
        
        $('.add-to-cart-box').removeClass('transparent');
        $('.quantity').show();
        
        if(this.value === 'I don’t need phone service|0' ) {
            $('.quantity').hide();
            $('.add-to-cart-box').addClass('transparent');
        }
        
    });
    
    $('#product-466').find('.gfield_radio input').change(function() {
        
        $('.add-to-cart-box').removeClass('transparent');
        $('.quantity').show();
        
        if(this.value === 'I don’t need PDF software|0' ) {
            $('.quantity').hide();
            $('.add-to-cart-box').addClass('transparent');
        }
        
    });
    
}(document, window, jQuery));


