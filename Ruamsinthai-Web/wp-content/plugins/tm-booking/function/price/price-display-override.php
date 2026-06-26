<?php
/**
 * Price Display Override
 * 
 * Overrides the tm_price shortcode to respect the price display type setting
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Override the tm_price shortcode to respect the price display type setting
 */
function tmbooking_price_display_override_init() {
    // Remove the original shortcode
    remove_shortcode('tm_price');
    
    // Add our modified shortcode
    add_shortcode('tm_price', 'tmbooking_price_display_override_shortcode');
    
    // Log that we've overridden the shortcode
    error_log('DEBUG - Price display shortcode override initialized');
}
add_action('init', 'tmbooking_price_display_override_init', 20); // Priority 20 to ensure it runs after the original shortcode is registered

/**
 * Modified shortcode function that respects the price display type setting
 */
function tmbooking_price_display_override_shortcode($atts) {
    // Extract attributes
    $atts = shortcode_atts(array(
        'id' => '',
        'style' => 'style_one',
    ), $atts);
    
    // Get post ID
    $post_id = !empty($atts['id']) ? $atts['id'] : get_the_ID();
    
    // Get price display type
    $price_display_type = get_post_meta($post_id, 'tmbooking_price_display_type', true);
    if (empty($price_display_type)) {
        $price_display_type = get_option('tmbooking_price_display_type_default', 'booking');
    }
    
    // Debug information
    error_log('DEBUG - Price display override shortcode called for post ID: ' . $post_id);
    error_log('DEBUG - Price display type: ' . $price_display_type);
    
    // If price display type is set to standard, return empty string
    if ($price_display_type === 'standard') {
        error_log('DEBUG - Price display type is standard, not showing booking price');
        return '';
    }
    
    // Otherwise, call the original function
    if (function_exists('tmbooking_get_price_shortcode')) {
        return tmbooking_get_price_shortcode($atts);
    }
    
    return '';
}
