<?php
/**
 * Functions for custom booking button text and price list visibility
 *
 * @package TM-Booking
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Get custom book now button text or default text if not set
 *
 * @param int $post_id Post ID
 * @return string Button text
 */
function tmbooking_get_book_now_text($post_id = null) {
    if (is_null($post_id)) {
        global $post;
        if (isset($post->ID)) {
            $post_id = $post->ID;
        }
    }
    
    $custom_text = get_post_meta($post_id, 'price_section_book_now_text', true);
    
    if (!empty($custom_text)) {
        return esc_html($custom_text);
    }
    
    return esc_html__('Book now', 'tm-booking');
}

/**
 * Check if price list block should be shown or hidden
 *
 * @param int $post_id Post ID
 * @return string CSS class to add to the price list block
 */
function tmbooking_get_price_list_visibility_class($post_id = null) {
    if (is_null($post_id)) {
        global $post;
        if (isset($post->ID)) {
            $post_id = $post->ID;
        }
    }
    
    $show_price_list = get_post_meta($post_id, 'price_section_show_price_list', true);
    
    if ($show_price_list === 'hide') {
        return 'car_premium_price_hide';
    }
    
    return '';
}

/**
 * Get minimum booking days required for a vehicle
 *
 * @param int $post_id Post ID
 * @return int Minimum number of days required for booking (0 means no minimum)
 */
function tmbooking_get_min_booking_days($post_id = null) {
    if (is_null($post_id)) {
        global $post;
        if (isset($post->ID)) {
            $post_id = $post->ID;
        }
    }
    
    $min_days = get_post_meta($post_id, 'price_section_min_booking_days', true);
    
    // If the value is not set or is not a number, return 0 (no minimum) // (Если значение не задано или не является числом, возвращаем 0 (нет минимума))
    if (empty($min_days) || !is_numeric($min_days)) {
        return 0;
    }
    
    return intval($min_days);
}

/**
 * Get custom price text or empty string if not set
 *
 * @param int $post_id Post ID
 * @return string Custom price text or empty string
 */
function tmbooking_get_custom_price_text($post_id = null) {
    if (is_null($post_id)) {
        global $post;
        if (isset($post->ID)) {
            $post_id = $post->ID;
        }
    }
    
    $custom_text = get_post_meta($post_id, 'price_section_custom_price_text', true);
    
    if (!empty($custom_text)) {
        return esc_html($custom_text);
    }
    
    return '';
}
