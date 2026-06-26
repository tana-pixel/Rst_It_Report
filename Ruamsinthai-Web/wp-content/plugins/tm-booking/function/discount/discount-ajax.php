<?php
/**
 * Custom AJAX handlers for discount calculations
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Hook into AJAX actions before they are processed
 */
function tmbooking_discount_ajax_init() {
    // Перехватываем действие tmbooking_change_total до его выполнения
    add_action('wp_ajax_tmbooking_change_total', 'tmbooking_discount_change_total_handler', 1);
    add_action('wp_ajax_nopriv_tmbooking_change_total', 'tmbooking_discount_change_total_handler', 1);
    
    // Перехватываем действие tmbooking_redirect_to_cart до его выполнения
    add_action('wp_ajax_tmbooking_redirect_to_cart', 'tmbooking_discount_redirect_to_cart_handler', 1);
    add_action('wp_ajax_nopriv_tmbooking_redirect_to_cart', 'tmbooking_discount_redirect_to_cart_handler', 1);
}
add_action('init', 'tmbooking_discount_ajax_init');

/**
 * Handler for tmbooking_change_total AJAX action
 * Modifies the request data to include booking days and correct discount
 */
function tmbooking_discount_change_total_handler() {
    if (!isset($_REQUEST['data']) || !isset($_REQUEST['data']['id'])) {
        return;
    }
    
    // Removed discount logging
    
    // Получаем настройки бронирования
    $booking_settings = get_option('tm_booking_settings', true);
    
    // Вычисляем количество дней бронирования
    $booking_days = 0;
    if (isset($_REQUEST['data']['start_date']) && isset($_REQUEST['data']['end_date'])) {
        $date_format = isset($booking_settings['date_format']) ? 
            TMBooking__Helping_Addons::construct_date_format($booking_settings['date_format']) : 
            'Y-m-d';
        
        $startDate = DateTime::createFromFormat($date_format, $_REQUEST['data']['start_date']);
        $endDate = DateTime::createFromFormat($date_format, $_REQUEST['data']['end_date']);
        
        if ($startDate && $endDate) {
            $interval = $startDate->diff($endDate);
            $booking_days = ($interval->days > 0) ? $interval->days : 1;
            
            // Добавляем количество дней в запрос
            $_REQUEST['data']['number_days'] = $booking_days;
        }
    }
    
    // Removed discount logging
    
    // Получаем скидку с учетом дня начала
    $post_id = $_REQUEST['data']['id'];
    $percent = tmbooking_get_discount_percent_all($post_id, $booking_days);
    
    // Removed discount logging
    
    // Если скидка найдена, обновляем данные запроса
    if ($percent > 0) {
        // Получаем HTML скидки
        $discount_html = tmbooking_get_discount_percent_html($post_id, $booking_days);
        
        // Извлекаем ID скидки из HTML
        preg_match('/value="([^"]+)"/', $discount_html, $matches);
        if (isset($matches[1])) {
            $_REQUEST['data']['discount'] = $matches[1];
            
            // Removed discount logging
        }
    }
}

/**
 * Handler for tmbooking_redirect_to_cart AJAX action
 * Modifies the request data to include booking days and correct discount
 */
function tmbooking_discount_redirect_to_cart_handler() {
    if (!isset($_REQUEST['data']) || !isset($_REQUEST['data']['id'])) {
        return;
    }
    
    // Removed discount logging
    
    // Получаем настройки бронирования
    $booking_settings = get_option('tm_booking_settings', true);
    
    // Вычисляем количество дней бронирования
    $booking_days = 0;
    if (isset($_REQUEST['data']['start_date']) && isset($_REQUEST['data']['end_date'])) {
        $date_format = isset($booking_settings['date_format']) ? 
            TMBooking__Helping_Addons::construct_date_format($booking_settings['date_format']) : 
            'Y-m-d';
        
        $startDate = DateTime::createFromFormat($date_format, $_REQUEST['data']['start_date']);
        $endDate = DateTime::createFromFormat($date_format, $_REQUEST['data']['end_date']);
        
        if ($startDate && $endDate) {
            $interval = $startDate->diff($endDate);
            $booking_days = ($interval->days > 0) ? $interval->days : 1;
            
            // Добавляем количество дней в запрос
            $_REQUEST['data']['number_days'] = $booking_days;
        }
    }
    
    // Removed discount logging
    
    // Получаем скидку с учетом дня начала
    $post_id = $_REQUEST['data']['id'];
    $percent = tmbooking_get_discount_percent_all($post_id, $booking_days);
    
    // Removed discount logging
    
    // Если скидка найдена, обновляем данные запроса
    if ($percent > 0) {
        // Получаем HTML скидки
        $discount_html = tmbooking_get_discount_percent_html($post_id, $booking_days);
        
        // Извлекаем ID скидки из HTML
        preg_match('/value="([^"]+)"/', $discount_html, $matches);
        if (isset($matches[1])) {
            $_REQUEST['data']['discount'] = $matches[1];
            
            // Removed discount logging
        }
    }
}
