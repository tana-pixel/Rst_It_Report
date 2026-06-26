<?php
/**
 * Functions for displaying minimum booking days information directly in booking form
 *
 * @package tm-booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add minimum booking days information to booking form HTML
 */
function tmbooking_add_min_days_info_to_form() {
    // Hook into the booking form HTML generation
    add_filter('tmbooking_before_book_now_button', 'tmbooking_insert_min_days_info', 10, 2);
}
add_action('init', 'tmbooking_add_min_days_info_to_form');

/**
 * Insert minimum booking days information before book now button
 *
 * @param string $html Current HTML
 * @param int $post_id Post ID
 * @return string Modified HTML with minimum booking days information
 */
function tmbooking_insert_min_days_info($html, $post_id) {
    // Get minimum booking days for this vehicle
    $min_days = tmbooking_get_min_booking_days($post_id);
    
    // If no minimum days requirement, return original HTML
    if ($min_days <= 0) {
        return $html;
    }
    
    // Get the correct word form based on the number using WordPress translation functions
    $days_word = _n('day', 'days', $min_days, 'tm-booking');
    $message = sprintf(esc_html__('Minimum booking period: %d %s', 'tm-booking'), $min_days, $days_word);
    
    // Create HTML for minimum booking days information with better positioning
    $min_days_html = '<div class="min-days-info">';
    $min_days_html .= $message; // No need for esc_html here as the message is already escaped
    $min_days_html .= '</div>';
    
    // Return original HTML plus minimum days information
    // We're adding a container div to ensure proper positioning before the button
    return $html . '<div class="min-days-info-container">' . $min_days_html . '</div>';
}
