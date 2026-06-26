/**
 * Add min-day-hide class to all booking buttons by default
 * and prevent other scripts from showing them before min days check
 * 
 * @package tm-booking
 */

jQuery(document).ready(function($) {
    'use strict';
    
    // Add min-day-hide class to all booking buttons by default
    $('.book_now_btn').addClass('min-day-hide');
    
    console.log('Added min-day-hide class to all booking buttons');
    
    // Override any other scripts that might try to show the button
    // by monitoring class changes on the button
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                var button = $(mutation.target);
                var form = button.closest('form.booking_form');
                
                // Check if this button should be hidden based on min days check
                if (form.data('min-days-checked') !== 'passed') {
                    console.log('Preventing button from showing before min days check');
                    button.addClass('min-day-hide');
                }
            }
        });
    });
    
    // Apply observer to all booking buttons
    $('.book_now_btn').each(function() {
        observer.observe(this, { attributes: true });
    });
    
    // Intercept the change event on booking forms to ensure min days check
    $(document).on('change', 'form.booking_form', function() {
        var form = $(this);
        var button = form.find('.book_now_btn');
        
        // Mark the form as not checked yet
        form.data('min-days-checked', 'pending');
        
        // Make sure button stays hidden until min days check passes
        button.addClass('min-day-hide');
    });
});
