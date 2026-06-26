/**
 * Script to ensure min-days-info is positioned correctly before the booking button
 * 
 * @package tm-booking
 */

jQuery(document).ready(function($) {
    /**
     * Position min-days-info before book now button
     * Ensures the message is always displayed in the correct position
     * with neutral styling by default
     */
    function positionMinDaysInfo() {
        // Find all booking forms
        $('.tm-booking-form').each(function() {
            var form = $(this);
            var button = form.find('.book_now_btn');
            var minDaysInfo = form.find('.min-days-info');
            
            // If both elements exist
            if (button.length && minDaysInfo.length) {
                // Create a wrapper if it doesn't exist
                if (form.find('.min-days-button-wrapper').length === 0) {
                    button.wrap('<div class="min-days-button-wrapper"></div>');
                }
                
                // Move the min-days-info before the button
                form.find('.min-days-button-wrapper').prepend(minDaysInfo);
                
                // Remove warning class on initial display - use neutral style by default
                // (Удаляем класс предупреждения при первом показе - используем нейтральный стиль по умолчанию)
                minDaysInfo.removeClass('warning');
                
                // Make sure it's visible initially but with opacity 0
                minDaysInfo.css({
                    'display': 'block',
                    'opacity': '0',
                    'margin-bottom': '10px',
                    'transition': 'all 0.3s ease'
                });
                
                // Fade in after a short delay
                setTimeout(function() {
                    minDaysInfo.css('opacity', '1');
                }, 100);
            }
        });
    }
    
    // Run on page load
    positionMinDaysInfo();
    
    // Also run when AJAX content is loaded
    $(document).ajaxComplete(function() {
        setTimeout(positionMinDaysInfo, 100);
    });
});
