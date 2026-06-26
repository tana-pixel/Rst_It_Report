/**
 * TM Booking - Block Booked Dates
 * 
 * This script ensures that booked dates are properly blocked in all booking form styles,
 * with special focus on equipment-booking-style_one.
 */
jQuery(document).ready(function($) {
    // Function to block unavailable dates in style_one
    function blockUnavailableDatesStyleOne() {
        // Find all calendar cells with classes that indicate they are unavailable
        $('.daterangepicker td.off, .daterangepicker td.disabled').each(function() {
            // Add our custom class
            $(this).addClass('tm-booking-date-blocked');
            
            // Remove any click handlers
            $(this).off('click');
            
            // Add our own click handler that prevents selection
            $(this).on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Blocked date clicked');
                
                // Show message
                if ($('.tm-booking-date-blocked-message').length === 0) {
                    $('<div class="tm-booking-date-blocked-message">' + 
                      'Эта дата недоступна для бронирования' + 
                      '</div>').appendTo('body').fadeIn();
                    
                    setTimeout(function() {
                        $('.tm-booking-date-blocked-message').fadeOut(function() {
                            $(this).remove();
                        });
                    }, 2000);
                }
                
                return false;
            });
            
            // Add pointer-events: none to make sure the element is not clickable
            $(this).css('pointer-events', 'none');
        });
    }
    
    // Function to handle the daterangepicker initialization
    function handleDateRangePickerInit() {
        // Override the original isCustomDate function to make it also block dates
        if (typeof $.fn.daterangepicker !== 'undefined') {
            // Store the original daterangepicker constructor
            var originalDaterangepicker = $.fn.daterangepicker;
            
            // Override the daterangepicker constructor
            $.fn.daterangepicker = function(options) {
                // If isCustomDate is defined, enhance it
                if (options && options.isCustomDate) {
                    var originalIsCustomDate = options.isCustomDate;
                    
                    options.isCustomDate = function(data) {
                        // Get the original result
                        var result = originalIsCustomDate.call(this, data);
                        
                        // If the result indicates this is a disabled date, also make it invalid
                        if (result === 'off' || result === 'disabled' || result === 'weekend off disabled') {
                            // This will both style the date AND make it unselectable
                            return 'off disabled';
                        }
                        
                        return result;
                    };
                }
                
                // Call the original constructor
                return originalDaterangepicker.apply(this, arguments);
            };
        }
    }
    
    // Call our function before any daterangepicker is initialized
    handleDateRangePickerInit();
    
    // Run the blocking function after a delay to ensure the calendar is loaded
    setTimeout(blockUnavailableDatesStyleOne, 500);
    
    // Also run when the calendar is shown (for dynamically loaded calendars)
    $(document).on('shown.daterangepicker', function() {
        setTimeout(blockUnavailableDatesStyleOne, 100);
    });
    
    // Run when the month is changed
    $(document).on('click', '.daterangepicker .prev, .daterangepicker .next', function() {
        setTimeout(blockUnavailableDatesStyleOne, 100);
    });
    
    

    
});
