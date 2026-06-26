/**
 * Script to handle discount visibility based on settings
 * 
 * @package TM Booking
 */
jQuery(document).ready(function($) {
    // Check if we need to hide discount items
    var hideDiscountItems = function() {
        // Get the show_discounts setting from the data attribute
        var showDiscounts = $('body').data('tm-show-discounts');
        
        if (showDiscounts === 'no') {
            // Hide discount items but keep the discount-info-block visible
            $('.tm-booking-discount-item').hide();
            
            // Make sure discount-info-block is visible when it appears via AJAX
            $(document).ajaxComplete(function(event, xhr, settings) {
                if (settings.url && settings.url.indexOf('admin-ajax.php') !== -1) {
                    // Keep the discount-info-block visible
                    $('.discount-info-block').show();
                }
            });
        }
    };
    
    // Run on page load
    hideDiscountItems();
});
