<?php
/**
 * TM Booking Global Settings
 *
 * @package TM Booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Удалена функция tm_booking_add_global_settings, так как она создавала дублирующийся пункт меню
// Пункт меню уже добавлен в файле dashboard/dashboard.php

/**
 * Initialize global settings with default values
 */
function tm_booking_initialize_global_settings() {
    $booking_settings = get_option('tm_booking_settings', []);
    
    // If settings is not an array, create empty array
    if (!is_array($booking_settings)) {
        $booking_settings = [];
    }
    
    // Set default values if not set
    if (!isset($booking_settings['show_discounts'])) {
        $booking_settings['show_discounts'] = 'yes';
        update_option('tm_booking_settings', $booking_settings);
    }
}
add_action('admin_init', 'tm_booking_initialize_global_settings');
