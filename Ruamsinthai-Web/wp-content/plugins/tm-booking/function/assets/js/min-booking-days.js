/**
 * JavaScript for checking minimum booking days requirement
 * 
 * @package tm-booking
 */

jQuery(document).ready(function($) {
    'use strict';
    
    // Проверяем, что все необходимые объекты существуют
    if (typeof tm_booking_min_days === 'undefined') {
        console.error('tm_booking_min_days is not defined');
        return;
    }

    // Store original button text for each form
    var originalButtonTexts = {};
    
    // Function to check minimum booking days requirement
    function checkMinBookingDays(form) {
        console.log('Checking minimum booking days for form:', form);
        
        var formData = getFormData(form);
        var postId = form.data('id');
        
        console.log('Form data:', formData);
        console.log('Post ID:', postId);
        
        // If we don't have start date or end date, don't proceed
        if (!formData.start_date || !formData.end_date) {
            console.log('Missing start or end date, skipping check');
            return;
        }
        
        // Get the button
        var button = form.find('.book_now_btn');
        
        // Store original button text if not already stored
        if (!originalButtonTexts[postId]) {
            originalButtonTexts[postId] = button.text();
        }
        
        // Prepare data for AJAX request
        var data = {
            action: 'tmbooking_check_min_days',
            nonce: tm_booking_min_days.nonce,
            post_id: postId,
            start_date: formData.start_date,
            end_date: formData.end_date,
            date_format: tm_booking_min_days.date_format
        };
        
        console.log('Sending AJAX request with data:', data);
        
        // Send AJAX request
        $.post(tm_booking_min_days.url, data, function(response) {
            console.log('AJAX response received:', response);
            
            if (response.success) {
                var data = response.data;
                console.log('Minimum days requirement met:', data.meets_requirement);
                console.log('Min days:', data.min_days, 'Actual days:', data.actual_days);
                
                // If minimum days requirement is met
                if (data.meets_requirement) {
                    console.log('Showing booking button');
                    // Show button and remove min-days-error class
                    button.removeClass('min-days-hidden');
                    
                    // Remove error message if exists
                    form.find('.min-days-error').remove();
                    
                    // Restore original button text
                    button.text(originalButtonTexts[postId]);
                } else {
                    console.log('Hiding booking button and showing error message');
                    // Hide button
                    button.addClass('min-days-hidden');
                    
                    // Show error message
                    var errorMessage = data.message;
                    console.log('Error message:', errorMessage);
                    
                    if (form.find('.min-days-error').length === 0) {
                        console.log('Adding new error message element');
                        form.find('.booking_count').after('<div class="min-days-error">' + errorMessage + '</div>');
                    } else {
                        console.log('Updating existing error message');
                        form.find('.min-days-error').text(errorMessage);
                    }
                }
            } else {
                console.error('AJAX request failed:', response);
            }
        }).fail(function(xhr, status, error) {
            console.error('AJAX error:', status, error);
        });
    }
    
    // Helper function to get form data
    function getFormData($form) {
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};
        
        $.map(unindexed_array, function(n, i) {
            indexed_array[n['name']] = n['value'];
        });
        
        return indexed_array;
    }
    
    // Check minimum booking days when form changes
    $('form.booking_form').on('change', function() {
        checkMinBookingDays($(this));
    });
    
    // Check minimum booking days on page load for forms with pre-filled dates
    $(document).ready(function() {
        $('form.booking_form').each(function() {
            var form = $(this);
            var startDate = form.find('.start_date').val();
            var endDate = form.find('.end_date').val();
            
            if (startDate && endDate) {
                checkMinBookingDays(form);
            }
        });
    });
});
