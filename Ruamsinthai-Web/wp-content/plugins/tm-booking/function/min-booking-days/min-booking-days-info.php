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
 * Get HTML for minimum booking days information
 *
 * @param int $post_id Post ID
 * @return string HTML for minimum booking days information
 */
function tmbooking_get_min_days_info_html_for_form($post_id) {
    // Get minimum booking days for this vehicle
    $min_days = tmbooking_get_min_booking_days($post_id);
    
    // If no minimum days requirement, return empty string
    if ($min_days <= 0) {
        return '';
    }
    
    // Get the correct word form based on the number
    $days_word = _n('day', 'days', $min_days, 'tm-booking');
    
    // Create HTML for minimum booking days information
    $html = '<div class="min-days-info">';
    $html .= sprintf(
        esc_html__('Minimum booking period: %d %s', 'tm-booking'),
        $min_days,
        $days_word
    );
    $html .= '</div>';
    
    return $html;
}
