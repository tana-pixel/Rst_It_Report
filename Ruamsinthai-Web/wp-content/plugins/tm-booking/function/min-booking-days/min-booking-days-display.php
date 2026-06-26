<?php
/**
 * Functions for displaying minimum booking days information
 *
 * @package tm-booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get HTML for displaying minimum booking days information
 *
 * @param int $post_id Post ID
 * @return string HTML for minimum booking days information
 */
function tmbooking_get_min_days_info_html($post_id = null) {
    if (is_null($post_id)) {
        global $post;
        if (isset($post->ID)) {
            $post_id = $post->ID;
        }
    }
    
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

/**
 * Add minimum booking days information to booking form
 *
 * @param string $html HTML for booking form
 * @param int $post_id Post ID
 * @return string Modified HTML with minimum booking days information
 */
function tmbooking_add_min_days_info($html, $post_id) {
    $min_days_info = tmbooking_get_min_days_info_html($post_id);
    
    if (!empty($min_days_info)) {
        // Добавляем информацию перед кнопкой бронирования
        $html = preg_replace(
            '/(<span class="booking_count booking_count[0-9]*"><\/span>\s*)/i',
            '$1' . $min_days_info . '\n',
            $html
        );
    }
    
    return $html;
}

// Добавляем хук для модификации HTML формы бронирования
add_filter('tmbooking_booking_form_html', 'tmbooking_add_min_days_info', 10, 2);
