<?php
/**
 * Enqueue script to add min-day-hide class to all booking buttons
 * 
 * @package tm-booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue script and styles for minimum booking days functionality
 */
function tmbooking_enqueue_min_day_hide_script() {
    // Register and enqueue the script for adding min-day-hide class
    wp_register_script(
        'tmbooking-min-day-hide',
        plugins_url('../assets/js/add-min-day-hide.js', __FILE__),
        array('jquery'),
        '1.0.1',
        true
    );
    
    // Register and enqueue the script for positioning min-days-info before button
    // (Скрипт для позиционирования сообщения перед кнопкой)
    wp_register_script(
        'tmbooking-position-min-days-info',
        plugins_url('../assets/js/position-min-days-info.js', __FILE__),
        array('jquery'),
        '1.0.0',
        true
    );
    

    
    wp_enqueue_script('tmbooking-min-day-hide');
    wp_enqueue_script('tmbooking-position-min-days-info');
    wp_enqueue_style('tmbooking-min-day-hide-css');
}
add_action('wp_enqueue_scripts', 'tmbooking_enqueue_min_day_hide_script');
