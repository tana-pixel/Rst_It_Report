<?php
/**
 * Discount calculation functions
 *
 * @package TM Booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get localized human-readable period label from period key.
 * Example: 'perweek' -> 'per week'.
 *
 * @param string $key Period key (perday|perweek|permonth|perhour)
 * @return string Localized label like 'per day'
 */
function tmbooking_get_period_label($key) {
    switch ($key) {
        case 'perday':
            return esc_html__('per day', 'tm-booking');
        case 'perweek':
            return esc_html__('per week', 'tm-booking');
        case 'permonth':
            return esc_html__('per month', 'tm-booking');
        case 'perhour':
            return esc_html__('per hour', 'tm-booking');
        default:
            return esc_html($key);
    }
}

/**
 * Calculate discount without applying extra options and location
 *
 * @param float $base_price Base price
 * @param int $percent_all Discount percentage
 * @param array $booking_data Booking data
 * @return array Discount information
 */
function tmbooking_calculate_discount_info($base_price, $percent_all, $booking_data = array()) {
    // If no discount, return empty array
    if ($percent_all <= 0) {
        return array(
            'has_discount' => false,
            'base_price' => $base_price,
            'discounted_price' => $base_price,
            'savings' => 0,
            'percent' => 0
        );
    }
    
    // Calculate discounted price
    $discounted_price = $base_price * (100 - $percent_all) / 100;
    $discounted_price = round($discounted_price, 2);
    
    // Calculate savings
    $savings = $base_price - $discounted_price;
    $savings = round($savings, 2);
    
    return array(
        'has_discount' => true,
        'base_price' => $base_price,
        'discounted_price' => $discounted_price,
        'savings' => $savings,
        'percent' => $percent_all
    );
}

/**
 * Generate HTML for discount information
 *
 * @param array $discount_info Discount information
 * @param int $discount_term_id Discount term ID
 * @return string HTML for discount display
 */
function tmbooking_generate_discount_html($discount_info, $discount_term_id = 0) {
    // Проверяем настройку отображения скидок (Check discount display setting)
    $booking_settings = get_option('tm_booking_settings', []);
    
    // Если скидки отключены и это не AJAX-запрос, возвращаем пустую строку
    // (If discounts are disabled and this is not an AJAX request, return empty string)
    $is_ajax = defined('DOING_AJAX') && DOING_AJAX;
    if (isset($booking_settings['show_discounts']) && $booking_settings['show_discounts'] === 'no' && !$is_ajax) {
        return '';
    }
    
    // If no discount, return empty string
    if (!$discount_info['has_discount']) {
        return '';
    }
    
    $discount_html = '';
    // Добавляем уникальный идентификатор для блока скидки
    $discount_html .= '<div class="discount-info-block" id="tm-booking-discount-block" data-source="discount-calculation" style="margin: 10px 0; padding: 12px; background-color: #f8f8f8; border-left: 3px solid #e44; border-radius: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">';
    // Информация о блоке скидки из discount-calculation.php
    $discount_html .= '<div class="discount-title" style="font-weight: bold; color: #e44; margin-bottom: 8px; font-size: 16px;">' . esc_html__('Discount', 'tm-booking') . ': ' . $discount_info['percent'] . '%</div>';
    
    // Get discount term information if available
    if ($discount_term_id > 0) {
        $discount_term = get_term($discount_term_id, 'transports-discount');
        if ($discount_term && !is_wp_error($discount_term)) {
            $discount_description = $discount_term->name;
            $start_day = tmbooking_get_term_metabox('start_day', $discount_term->term_id);
            
            $discount_html .= '<div class="discount-name" style="margin-bottom: 8px; font-size: 14px;">' . $discount_description;
            
            // Add information about start day if it's greater than 0
            if (!empty($start_day) && intval($start_day) > 0) {
                $discount_html .= ' (' . esc_html__('from day', 'tm-booking') . ' ' . $start_day . ')';
            }
            
            $discount_html .= '</div>';
        }
    }
    
    // Add information about savings
    $discount_html .= '<div class="discount-savings" style="font-weight: bold; font-size: 15px; color: #333;">' . esc_html__('You save', 'tm-booking') . ': ' . $discount_info['savings'] . get_woocommerce_currency_symbol() . '</div>';
    
    $discount_html .= '</div>';
    
    return $discount_html;
}

/**
 * Apply discount to base price and generate HTML
 *
 * @param float $base_price Base price
 * @param int $percent_all Discount percentage
 * @param int $discount_term_id Discount term ID
 * @return array Discount information with HTML
 */
function tmbooking_apply_discount($base_price, $percent_all, $discount_term_id = 0) {
    // Calculate discount information
    $discount_info = tmbooking_calculate_discount_info($base_price, $percent_all);
    
    // Generate HTML for discount display
    $discount_html = tmbooking_generate_discount_html($discount_info, $discount_term_id);
    
    // Add HTML to discount info
    $discount_info['html'] = $discount_html;
    
    return $discount_info;
}

/**
 * Override the tmbooking_change_total_callback function to handle discounts separately from extra options
 */
function tmbooking_override_change_total_callback() {
    // Remove the original callback
    remove_action('wp_ajax_tmbooking_change_total', 'tmbooking_change_total_callback');
    remove_action('wp_ajax_nopriv_tmbooking_change_total', 'tmbooking_change_total_callback');
    
    // Add our modified callback
    add_action('wp_ajax_tmbooking_change_total', 'tmbooking_modified_change_total_callback');
    add_action('wp_ajax_nopriv_tmbooking_change_total', 'tmbooking_modified_change_total_callback');
}
add_action('init', 'tmbooking_override_change_total_callback');

/**
 * Modified version of tmbooking_change_total_callback that separates discount calculation from extra options
 */
function tmbooking_modified_change_total_callback() {
    // Логируем входящие данные
    if (function_exists('tmbooking_log_discount')) {
        tmbooking_log_discount($_REQUEST['data'], 'AJAX Request Data');
    }

    //Get Price
    $price = tmbooking_get_price($_REQUEST['data']['id']);

    $booking_settings = get_option('tm_booking_settings', true);

    $calculate = tmbooking_change_calculate_by_date($_REQUEST['data']['start_date'], $_REQUEST['data']['end_date'], $_REQUEST['data']['start_time'], $_REQUEST['data']['end_time'], $booking_settings['date_format']);
    $return_html = '';

    if (!empty($calculate)){
        // Existing code for price calculation display
        if(isset($calculate['interval_month']) && isset($calculate['label_month']) && isset($price[$calculate["name_month"]]) && !empty($price[$calculate["name_month"]]) && $price[$calculate["name_month"]] > 0){
            $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval_month"]) . ' ' . esc_html($calculate["label_month"]) . '</span>';
            $return_html .= '<span class="calculate_price">' . tmbooking_get_price_with_currency($price[$calculate["name_month"]]) . ' / ' . tmbooking_get_period_label($calculate["name_month"]) . '</span>';
            if(isset($calculate['interval_week']) && isset($calculate['label_week']) && isset($calculate['name_week']) && isset($price[$calculate["name_week"]]) && !empty($price[$calculate["name_week"]]) && $price[$calculate["name_week"]] > 0){
                $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval_week"]) . ' ' . esc_html($calculate["label_week"]) . '</span>';
                $return_html .= '<span class="calculate_price">' . tmbooking_get_price_with_currency($price[$calculate["name_week"]]) . ' / ' . tmbooking_get_period_label($calculate["name_week"]) . '</span>';
                if($calculate["interval"] != 0 && isset($price[$calculate["name"]]) && !empty($price[$calculate["name"]]) && $price[$calculate["name"]] > 0){
                    $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval"]) . ' ' . esc_html($calculate["label"]) . '</span>';
                    $return_html .= '<span class="calculate_price">' . tmbooking_get_price_with_currency($price[$calculate["name"]]) . ' / ' . tmbooking_get_period_label($calculate["name"]) . '</span>';
                }
            } else {
                if($calculate["interval"] != 0 && isset($price[$calculate["name"]]) && !empty($price[$calculate["name"]]) && $price[$calculate["name"]] > 0){
                    $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval"]) . ' ' . esc_html($calculate["label"]) . '</span>';
                    $return_html .= '<span class="calculate_price">' . tmbooking_get_price_with_currency($price[$calculate["name"]]) . ' / ' . tmbooking_get_period_label($calculate["name"]) . '</span>';
                }
            }
        } else {
            if(isset($calculate['interval_week']) && isset($calculate['label_week']) && isset($calculate['name_week']) && isset($price[$calculate["name_week"]]) && !empty($price[$calculate["name_week"]]) && $price[$calculate["name_week"]] > 0){
                $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval_week"]) . ' ' . esc_html($calculate["label_week"]) . '</span>';
                $return_html .= '<span class="calculate_price">' . tmbooking_get_price_with_currency($price[$calculate["name_week"]]) . ' / ' . tmbooking_get_period_label($calculate["name_week"]) . '</span>';

                if($calculate["interval"] != 0 && isset($price[$calculate["name"]]) && !empty($price[$calculate["name"]]) && $price[$calculate["name"]] > 0){
                    $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval"]) . ' ' . esc_html($calculate["label"]) . '</span>';
                    $return_html .= '<span class="calculate_price">' . tmbooking_get_price_with_currency($price[$calculate["name"]]) . ' / ' . tmbooking_get_period_label($calculate["name"]) . '</span>';
                }
            } else {
                if($calculate["interval"] != 0 && isset($price[$calculate["name"]]) && !empty($price[$calculate["name"]]) && $price[$calculate["name"]] > 0){
                    if(isset($calculate["name"]) && $calculate["name"] == 'perhour'){

                        if(isset($booking_settings['minimum_hours_day']) && $booking_settings['minimum_hours_day'] != 'disable' ){

                            if($calculate['interval'] >= intval($booking_settings['minimum_hours_day'])){
                                
                                $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval"]) . ' ' . esc_html($calculate["label"]) . '</span>';
                                $return_html .= '<span class="calculate_price">' . tmbooking_get_price_with_currency($price[$calculate["name"]]) . '/' . esc_html__('per day', 'tm-booking') . '</span>';

                            } else {
                                $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval"]) . ' ' . esc_html($calculate["label"]) . '</span>';
                                $return_html .= '<span class="calculate_price">' . tmbooking_get_price_with_currency($price[$calculate["name"]]) . '/' . esc_html__('per hour', 'tm-booking') . '</span>';
                            }

                        } else {
                            $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval"]) . ' ' . esc_html($calculate["label"]) . '</span>';
                            $return_html .= '<span class="calculate_price">' . tmbooking_get_price_with_currency($price[$calculate["name"]]) . '/' . esc_html__('per hour', 'tm-booking') . '</span>';
                        }

                    } else {
                        $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval"]) . ' ' . esc_html($calculate["label"]) . '</span>';
                        $return_html .= '<span class="calculate_price">' . tmbooking_get_price_with_currency($price[$calculate["name"]]) . '/' . esc_html__('per day', 'tm-booking') . '</span>';
                    }
                }
            }
        }
    }
    
    // Get Default Product
    $product_id = get_post_meta($_REQUEST['data']['id'], 'tmbooking_sim_product_id', true);
    if(isset($product_id) && $product_id != ''){
        $default_product_obj = get_post( $product_id );
        add_action('woocommerce_init', $default_product = new WC_Product($default_product_obj));

    } else {
        $default_product_obj = get_page_by_title( 'Booking', OBJECT, 'product' );
        add_action('woocommerce_init', $default_product = new WC_Product($default_product_obj));
    }

    // Apply date-based price changes
    $price = tmbooking_change_price_by_date($price, $_REQUEST['data']['start_date'], $_REQUEST['data']['end_date'], $_REQUEST['data']['start_time'], $_REQUEST['data']['end_time'], $booking_settings['date_format']);

    // Save base price before applying any modifications
    $base_price = $price;
    
    // Get discount percentage
    $percent_all = 0;
    $discount_term_id = 0;
    if(isset($_REQUEST['data']['discount'])){
        $discounts = explode(",", $_REQUEST['data']['discount']);
        if (!empty($discounts)) {
            $discount_term_id = $discounts[0];
        }
        foreach ($discounts as $d){
            $discount_percent = tmbooking_get_discount_percent($d);
            $percent_all += intval($discount_percent);
        }
    }
    
    // Calculate discount information
    $discount_info = tmbooking_calculate_discount_info($base_price, $percent_all);
    
    // Apply discount to base price
    $price_with_discount = $discount_info['discounted_price'];
    
    // Check if extra_ids exists
    $extra_ids = isset($_REQUEST['data']['extra_ids']) ? $_REQUEST['data']['extra_ids'] : '';
    // Check if delivery exists
    $delivery = isset($_REQUEST['data']['delivery']) ? $_REQUEST['data']['delivery'] : '';
    
    // Apply extra options and location to the discounted price
    $price = tmbooking_change_price_by_extra($price_with_discount, $extra_ids, $_REQUEST['data']['start_date'], $_REQUEST['data']['end_date'], $booking_settings['date_format']);
    $price = tmbooking_change_price_by_dr_location($price, $delivery);
    
    // Process TM Conditions plugin discounts if available
    if (function_exists('apply_filters') && has_filter('tmbooking_calculate_price')) {
        // Create booking data array
        $booking_data = array(
            'start_date' => $_REQUEST['data']['start_date'],
            'end_date' => $_REQUEST['data']['end_date'],
            'start_time' => $_REQUEST['data']['start_time'],
            'end_time' => $_REQUEST['data']['end_time']
        );
        
        // Calculate booking days count
        $date_format = TMBooking__Helping_Addons::construct_date_format($booking_settings['date_format']);
        $startDate = DateTime::createFromFormat($date_format, $_REQUEST['data']['start_date']);
        $endDate = DateTime::createFromFormat($date_format, $_REQUEST['data']['end_date']);
        $interval = $startDate->diff($endDate);
        $booking_data['days_count'] = ($interval->days > 0) ? $interval->days : 1;
        
        // Apply filter
        $original_price = $price;
        $price = apply_filters('tmbooking_calculate_price', $price, $_REQUEST['data']['id'], $booking_data, 'booking');
    }
    
    // Add delivery price display if applicable
    if (isset($_REQUEST['data']['delivery']) && $_REQUEST['data']['delivery'] != ''){
        $terms = get_terms();
        foreach ($terms as $key => $term) {
            if (!empty($term) && $term->taxonomy == 'transports-delivery' && $term->slug === $_REQUEST['data']['delivery'] && tmbooking_get_metabox('free', $term) !== 'free' ){
                $drop_price = tmbooking_get_term_metabox('drop_price', $term->term_id);
                $drop_price_html = tmbooking_get_price_with_currency($drop_price);
                if($drop_price == '1' . get_woocommerce_currency_symbol()){
                    $drop_price = __('free', 'tm-booking');
                }

                $return_html .= '<span class="calculate_label">' . esc_html__('Delivery price', 'tm-booking') . '</span>';
                $return_html .= '<span class="calculate_price">' . $drop_price_html . '</span>';
            }
        }
    }
    
    // Get booking days for discount display
    $booking_days = 0;
    if (isset($calculate['interval']) && $calculate['interval'] > 0) {
        $booking_days = intval($calculate['interval']);
    }

    // Generate discount HTML
    $discount_html = tmbooking_generate_discount_html($discount_info, $discount_term_id);
    
    // Add discount information to the output
    if ($percent_all > 0) {
        // Add discount block
        $return_html .= '<section class="tm-booking-price-discount">' . $discount_html . '</section>';
        
        // Show original price (struck through) and discounted price
        $return_html .= '<span class="details-aside-content__total-text total_price_label">' . esc_html__('Total', 'tm-booking') . '</span>';
        $return_html .= '<span class="details-aside-content__total-text total_price"><span class="original-price" style="text-decoration: line-through; color: #999; display: block; font-size: 14px;">' . tmbooking_get_price_with_currency($discount_info['base_price']) . '</span><span style="color: #e44; font-weight: bold;">' . tmbooking_get_price_with_currency($price) . '</span></span>';
    } else {
        // No discount, show regular price
        $return_html .= '<section class="tm-booking-price-discount"></section>';
        $return_html .= '<span class="details-aside-content__total-text total_price_label">' . esc_html__('Total', 'tm-booking') . '</span>';
        $return_html .= '<span class="details-aside-content__total-text total_price">' . '<span>' . tmbooking_get_price_with_currency($price) . '</span></span>';
    }

    // Update product price
    $default_product->set_regular_price($price);
    $default_product->save();

    // Handle error cases
    $return_error_html = '<div class="tm-booking-error-message">
                            <span class="tm-booking-error-icon"></span>
                            <span class="tm-booking-error-text">
                                ' . esc_html__('Dates are not available', 'tm-booking') . '
                            </span>
                        </div>
                        
                         <script>
                            jQuery.noConflict()(function($) {
                               $(".book_now_btn").prop("disabled", true); 
                            });
                        </script>';

    if(!tmbooking_check_times($_REQUEST['data']['id'], $_REQUEST['data']['start_date'], $_REQUEST['data']['end_date'], $_REQUEST['data']['start_time'], $_REQUEST['data']['end_time'], $booking_settings['date_format'])){
        $return_error_html = '<div class="tm-booking-error-message">
                            <span class="tm-booking-error-icon"></span>
                            <span class="tm-booking-error-text">
                                ' . esc_html__('This time is not available', 'tm-booking') . '
                            </span>
                        </div>
                        
                         <script>
                            jQuery.noConflict()(function($) {
                               $(".book_now_btn").prop("disabled", true); 
                            });
                        </script>';
    }

    // Check dates and times availability
    if(tmbooking_check_dates($_REQUEST['data']['id'], $_REQUEST['data']['start_date'], $_REQUEST['data']['end_date'], $booking_settings['date_format']) && tmbooking_check_times($_REQUEST['data']['id'], $_REQUEST['data']['start_date'], $_REQUEST['data']['end_date'], $_REQUEST['data']['start_time'], $_REQUEST['data']['end_time'], $booking_settings['date_format'])){
        // Return the HTML
        echo $return_html;
    } else {
        echo $return_error_html;
    }

    wp_die();
}
