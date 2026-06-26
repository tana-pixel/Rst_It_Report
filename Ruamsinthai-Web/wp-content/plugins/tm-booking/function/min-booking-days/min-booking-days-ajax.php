<?php
/**
 * AJAX handler for checking minimum booking days requirement
 *
 * @package tm-booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * AJAX handler for checking if minimum booking days requirement is met
 */
add_action('wp_ajax_tmbooking_check_min_days', 'tmbooking_check_min_days_ajax');
add_action('wp_ajax_nopriv_tmbooking_check_min_days', 'tmbooking_check_min_days_ajax');

/**
 * Check if the selected booking period meets the minimum days requirement
 */
function tmbooking_check_min_days_ajax() {
    // Check nonce for security
    check_ajax_referer('tmbooking_min_days_nonce', 'nonce');
    
    // Get post ID
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    
    // Get dates
    $start_date = isset($_POST['start_date']) ? sanitize_text_field($_POST['start_date']) : '';
    $end_date = isset($_POST['end_date']) ? sanitize_text_field($_POST['end_date']) : '';
    
    // Get date format
    $date_format = isset($_POST['date_format']) ? sanitize_text_field($_POST['date_format']) : 'Y-m-d';
    
    // Проверяем формат даты и корректируем его при необходимости
    // Если формат 'F j, Y' (June 8, 2025), но даты в формате 'm/d/Y' (06/08/2025)
    if ($date_format === 'F j, Y' && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $start_date)) {
        $date_format = 'm/d/Y';
        error_log(esc_html__('Date format corrected from "F j, Y" to "m/d/Y" based on actual date format', 'tm-booking'));
    }
    
    // Log received data for debugging
    error_log(esc_html__('tmbooking_check_min_days - Received data:', 'tm-booking'));
    error_log(sprintf(esc_html__('Start date: %s', 'tm-booking'), $start_date));
    error_log(sprintf(esc_html__('End date: %s', 'tm-booking'), $end_date));
    error_log(sprintf(esc_html__('Date format: %s', 'tm-booking'), $date_format));
    
    // Attempt to parse dates directly without conversion
    $start = null;
    $end = null;
    
    // Get booking settings to determine date format
    $booking_settings = get_option('tm_booking_settings', array());
    $date_format_setting = isset($booking_settings['date_format']) ? $booking_settings['date_format'] : 'DD/MM/YYYY';
    
    // Determine primary format based on settings
    $primary_format = 'd/m/Y'; // Default to DD/MM/YYYY
    
    if ($date_format_setting === 'MM/DD/YYYY') {
        $primary_format = 'm/d/Y';
    } else if ($date_format_setting === 'DD/MM/YYYY') {
        $primary_format = 'd/m/Y';
    } else if ($date_format_setting === 'MM-DD-YYYY') {
        $primary_format = 'm-d-Y';
    } else if ($date_format_setting === 'DD-MM-YYYY') {
        $primary_format = 'd-m-Y';
    } else if ($date_format_setting === 'MM.DD.YYYY') {
        $primary_format = 'm.d.Y';
    } else if ($date_format_setting === 'DD.MM.YYYY') {
        $primary_format = 'd.m.Y';
    }
    
    error_log(sprintf(esc_html__('Date format setting: %s', 'tm-booking'), $date_format_setting));
    error_log(sprintf(esc_html__('Primary date format: %s', 'tm-booking'), $primary_format));
    
    // Try to parse dates using various formats, with the primary format first
    $possible_formats = array(
        $primary_format, // Primary format based on settings
        'd/m/Y', // 31/12/2023
        'm/d/Y', // 12/31/2023
        'Y-m-d', // 2023-12-31
        'd.m.Y', // 31.12.2023
        'm.d.Y', // 12.31.2023
        'Y.m.d', // 2023.12.31
        'd-m-Y', // 31-12-2023
        'm-d-Y', // 12-31-2023
        'n/j/Y', // 1/1/2023
        'j/n/Y', // 1/1/2023
        'j.n.Y', // 1.1.2023
        'n.j.Y', // 1.1.2023
        'j-n-Y', // 1-1-2023
        'n-j-Y'  // 1-1-2023
    );
    
    // Try to convert the date format from Flatpickr format to PHP format
    try {
        if (class_exists('TMBooking')) {
            $date_format_php = TMBooking::construct_date_format($date_format);
            $start = DateTime::createFromFormat($date_format_php, $start_date);
            $end = DateTime::createFromFormat($date_format_php, $end_date);
            
            if ($start && $end) {
                error_log('Dates parsed successfully with TMBooking format: ' . $date_format_php);
            }
        }
    } catch (Exception $e) {
        error_log('Error converting date format: ' . $e->getMessage());
    }
    
    // If dates are still not parsed, try all possible formats
    if (!$start || !$end) {
        error_log('Trying alternative date formats');
        foreach ($possible_formats as $format) {
            if (!$start) {
                $start = DateTime::createFromFormat($format, $start_date);
                if ($start) {
                    error_log('Start date parsed with format: ' . $format);
                }
            }
            if (!$end) {
                $end = DateTime::createFromFormat($format, $end_date);
                if ($end) {
                    error_log('End date parsed with format: ' . $format);
                }
            }
            if ($start && $end) {
                break;
            }
        }
    }
    
    // Last resort: try to parse with strtotime
    if (!$start || !$end) {
        $start_timestamp = strtotime($start_date);
        $end_timestamp = strtotime($end_date);
        
        if ($start_timestamp && $end_timestamp) {
            $start = new DateTime();
            $start->setTimestamp($start_timestamp);
            
            $end = new DateTime();
            $end->setTimestamp($end_timestamp);
            
            error_log('Dates parsed with strtotime');
        }
    }
    
    // If we still can't parse the dates, return an error
    if (!$start || !$end) {
        error_log('Failed to parse dates: ' . $start_date . ' - ' . $end_date);
        wp_send_json_error(array('message' => esc_html__('Неверный формат даты', 'tm-booking')));
        return;
    }
    
    // Log the parsed dates for debugging
    error_log('Start date: ' . $start_date . ', parsed as: ' . $start->format('Y-m-d H:i:s'));
    error_log('End date: ' . $end_date . ', parsed as: ' . $end->format('Y-m-d H:i:s'));
    
    // Log dates before resetting time
    error_log('Before reset - Start date: ' . $start->format('Y-m-d H:i:s'));
    error_log('Before reset - End date: ' . $end->format('Y-m-d H:i:s'));
    error_log('Before reset - Raw interval days: ' . $start->diff($end)->days);
    
    // Reset time components to ensure we only count whole days
    $start->setTime(0, 0, 0);
    $end->setTime(0, 0, 0);
    
    // Log dates after resetting time
    error_log('After reset - Start date: ' . $start->format('Y-m-d H:i:s'));
    error_log('After reset - End date: ' . $end->format('Y-m-d H:i:s'));
    
    // Calculate number of days
    $interval = $start->diff($end);
    
    // Get days difference ignoring hours
    $days = $interval->days;
    error_log('Raw interval days after reset: ' . $days);
    
    // If dates are the same, count as 1 day
    if ($days == 0) {
        $days = 1;
        error_log('Dates are the same, setting days to 1');
    }
    
    // Log the calculated days
    error_log('Final calculated days (ignoring hours): ' . $days);
    
    // Get minimum booking days
    $min_days = tmbooking_get_min_booking_days($post_id);
    
    // Check if minimum days requirement is met
    $meets_requirement = ($min_days <= 0 || $days >= $min_days);
    
    // Prepare response
    $response = array(
        'meets_requirement' => $meets_requirement,
        'min_days' => $min_days,
        'actual_days' => $days
    );
    
    // Add error message if requirement is not met
    if (!$meets_requirement) {
        // For Russian translation
        if (get_locale() === 'ru_RU') {
            // Russian pluralization for min_days
            if ($min_days % 10 == 1 && $min_days % 100 != 11) {
                $min_days_word = 'день';
            } elseif ($min_days % 10 >= 2 && $min_days % 10 <= 4 && ($min_days % 100 < 10 || $min_days % 100 >= 20)) {
                $min_days_word = 'дня';
            } else {
                $min_days_word = 'дней';
            }
            
            // Russian pluralization for selected days
            if ($days % 10 == 1 && $days % 100 != 11) {
                $days_word = 'день';
            } elseif ($days % 10 >= 2 && $days % 10 <= 4 && ($days % 100 < 10 || $days % 100 >= 20)) {
                $days_word = 'дня';
            } else {
                $days_word = 'дней';
            }
            
            $response['message'] = sprintf(
                'Минимальный период бронирования: %d %s. Вы выбрали: %d %s.',
                $min_days,
                $min_days_word,
                $days,
                $days_word
            );
        } else {
            // Default English
            $min_days_word = _n('day', 'days', $min_days, 'tm-booking');
            $days_word = _n('day', 'days', $days, 'tm-booking');
            
            // Create two separate parts of the message
            $first_part = sprintf(
                esc_html__('Minimum booking period is %d %s.', 'tm-booking'),
                $min_days,
                $min_days_word
            );
            
            $second_part = sprintf(
                esc_html__('You have selected %d %s.', 'tm-booking'),
                $days,
                $days_word
            );
            
            // Send both parts separately to be handled by JavaScript
            $response['message_parts'] = array(
                'first' => $first_part,
                'second' => $second_part
            );
        }
    }
    
    // Send JSON response
    wp_send_json_success($response);
}
