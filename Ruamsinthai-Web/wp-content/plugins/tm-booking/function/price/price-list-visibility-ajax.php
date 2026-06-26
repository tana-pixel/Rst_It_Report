<?php
/**
 * AJAX handlers for price list visibility
 *
 * @package TM-Booking
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * AJAX handler for getting price list visibility status
 */
function tmbooking_get_price_list_visibility_callback() {
    // Проверяем nonce для безопасности
    check_ajax_referer('tmbooking_ajax_nonce', 'security');
    
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    
    if ($product_id > 0) {
        $show_price_list = get_post_meta($product_id, 'price_section_show_price_list', true);
        
        if ($show_price_list === 'hide') {
            wp_send_json_success('hide');
        } else {
            wp_send_json_success('show');
        }
    }
    
    wp_send_json_error();
}
add_action('wp_ajax_tmbooking_get_price_list_visibility', 'tmbooking_get_price_list_visibility_callback');
add_action('wp_ajax_nopriv_tmbooking_get_price_list_visibility', 'tmbooking_get_price_list_visibility_callback');
