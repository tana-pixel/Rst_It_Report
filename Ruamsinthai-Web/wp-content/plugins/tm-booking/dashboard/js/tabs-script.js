/**
 * TM Booking Tabbed Settings JavaScript
 * Author: Templines
 * Website: templines.com
 */

jQuery(document).ready(function($) {
    'use strict';

    // Tab switching functionality
    $('.tm-booking-tab-button').on('click', function(e) {
        e.preventDefault();
        
        var targetTab = $(this).data('tab');
        
        // Remove active class from all buttons and content
        $('.tm-booking-tab-button').removeClass('active');
        $('.tm-booking-tab-content').removeClass('active');
        
        // Add active class to clicked button and corresponding content
        $(this).addClass('active');
        $('#' + targetTab).addClass('active');
        
        // Save active tab to localStorage for persistence
        localStorage.setItem('tm_booking_active_tab', targetTab);
    });

    // Restore active tab from localStorage
    var activeTab = localStorage.getItem('tm_booking_active_tab');
    if (activeTab && $('#' + activeTab).length) {
        $('.tm-booking-tab-button').removeClass('active');
        $('.tm-booking-tab-content').removeClass('active');
        
        $('[data-tab="' + activeTab + '"]').addClass('active');
        $('#' + activeTab).addClass('active');
    }

    // Dynamic visibility for time format option
    function toggleTimeFormatVisibility() {
        var calcPeriods = $('select[name="tm_booking_settings[calc_periods][]"]').val() || [];
        var timeFormatContainer = $('.time-format-container');
        
        if (calcPeriods.includes('calc_hours')) {
            timeFormatContainer.show();
        } else {
            timeFormatContainer.hide();
        }
    }

    // Initial check and bind change event
    toggleTimeFormatVisibility();
    $('select[name="tm_booking_settings[calc_periods][]"]').on('change', toggleTimeFormatVisibility);

    // Form validation before submit
    $('.tmbooking_form').on('submit', function(e) {
        var isValid = true;
        var errorMessages = [];

        // Validate required fields
        var postType = $('select[name="tm_booking_settings[post_type]"]').val();
        if (!postType || postType === 'unset') {
            errorMessages.push('Please select a Post Type');
            isValid = false;
        }

        // Validate notification settings if enabled
        if ($('select[name="tm_booking_settings[whatsapp_enabled]"]').val() === 'yes') {
            var whatsappNumber = $('input[name="tm_booking_settings[whatsapp_number]"]').val();
            if (!whatsappNumber.trim()) {
                errorMessages.push('WhatsApp number is required when WhatsApp notifications are enabled');
                isValid = false;
            }
        }

        if ($('select[name="tm_booking_settings[telegram_enabled]"]').val() === 'yes') {
            var telegramToken = $('input[name="tm_booking_settings[telegram_bot_token]"]').val();
            if (!telegramToken.trim()) {
                errorMessages.push('Telegram Bot Token is required when Telegram notifications are enabled');
                isValid = false;
            }
        }

        if ($('select[name="tm_booking_settings[sms_enabled]"]').val() === 'yes') {
            var twilioSid = $('input[name="tm_booking_settings[twilio_account_sid]"]').val();
            if (!twilioSid.trim()) {
                errorMessages.push('Twilio Account SID is required when SMS notifications are enabled');
                isValid = false;
            }
        }

        if (!isValid) {
            e.preventDefault();
            alert('Please fix the following errors:\n\n' + errorMessages.join('\n'));
            return false;
        }

        // Show loading state
        $('.tmbooking_save_btn').prop('disabled', true).text('Saving...');
    });

    // Auto-save draft functionality (optional)
    var autoSaveTimeout;
    $('.tmbooking_form input, .tmbooking_form select').on('change', function() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(function() {
            // Could implement auto-save draft here if needed
            console.log('Settings changed - could auto-save draft');
        }, 2000);
    });

    // Notification enable/disable toggles
    function toggleNotificationFields(type) {
        var isEnabled = $('select[name="tm_booking_settings[' + type + '_enabled]"]').val() === 'yes';
        var container = $('.' + type + '-fields-container');
        
        if (isEnabled) {
            container.show().find('input').prop('required', true);
        } else {
            container.hide().find('input').prop('required', false);
        }
    }

    // Bind notification toggle events
    $('select[name="tm_booking_settings[whatsapp_enabled]"]').on('change', function() {
        toggleNotificationFields('whatsapp');
    });

    $('select[name="tm_booking_settings[telegram_enabled]"]').on('change', function() {
        toggleNotificationFields('telegram');
    });

    $('select[name="tm_booking_settings[sms_enabled]"]').on('change', function() {
        toggleNotificationFields('sms');
    });

    // Initial toggle state
    toggleNotificationFields('whatsapp');
    toggleNotificationFields('telegram');
    toggleNotificationFields('sms');

    // Help tooltips (if needed)
    $('.tm-booking-help-icon').on('click', function(e) {
        e.preventDefault();
        var helpText = $(this).data('help');
        if (helpText) {
            alert(helpText);
        }
    });

    // Keyboard navigation for tabs
    $('.tm-booking-tab-button').on('keydown', function(e) {
        var $tabs = $('.tm-booking-tab-button');
        var currentIndex = $tabs.index(this);
        
        switch(e.which) {
            case 37: // Left arrow
                e.preventDefault();
                var prevIndex = currentIndex > 0 ? currentIndex - 1 : $tabs.length - 1;
                $tabs.eq(prevIndex).click().focus();
                break;
            case 39: // Right arrow
                e.preventDefault();
                var nextIndex = currentIndex < $tabs.length - 1 ? currentIndex + 1 : 0;
                $tabs.eq(nextIndex).click().focus();
                break;
        }
    });
});
