<?php
add_action( 'wp_enqueue_scripts', 'tmbooking_enqueue_ajax_scripts', 99 );
function tmbooking_enqueue_ajax_scripts() {
    // Подключаем NiceSelect перед основным скриптом, чтобы функция была доступна
    wp_enqueue_script('tmbooking-nice-select', plugins_url('/assets/js/NiceSelect.js', __FILE__), array('jquery'), '1.0', true);
    
    // Основной AJAX скрипт
    wp_enqueue_script('tm-booking-ajax', plugins_url('/assets/js/tm-booking-ajax.js', __FILE__), array('jquery', 'tmbooking-nice-select'), '1.0', true);
    wp_localize_script('tm-booking-ajax', 'tm_booking_ajax', array('url' => admin_url('admin-ajax.php')));
    
    // Подключаем скрипт для управления видимостью блока с ценами
    wp_enqueue_script('price-list-visibility', plugins_url('/assets/js/price-list-visibility.js', __FILE__), array('jquery'), '1.0', true);
    wp_localize_script('price-list-visibility', 'price_list_visibility_ajax', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('price_list_visibility_nonce')
    ));
    
    // Get booking settings
    $booking_settings = get_option('tm_booking_settings', array());
    $date_format_setting = isset($booking_settings['date_format']) ? $booking_settings['date_format'] : 'DD/MM/YYYY';
    $show_discounts = isset($booking_settings['show_discounts']) ? $booking_settings['show_discounts'] : 'yes';
    
    // Connect script for checking minimum booking days requirement
    // (Подключаем скрипт для проверки минимального количества дней бронирования)
    wp_enqueue_script('min-booking-days', plugins_url('/assets/js/min-booking-days-fix.js', __FILE__), array('jquery'), '1.0.2', true);
    wp_localize_script('min-booking-days', 'tm_booking_min_days', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('tmbooking_min_days_nonce'),
        'date_format' => get_option('date_format', 'd/m/Y'),
        'date_format_setting' => $date_format_setting // Pass the date format setting to JavaScript
    ));
    
    // Подключаем скрипт для управления видимостью скидок
    // (Connect script for discount visibility management)
    // Отключено из-за отсутствия файла
    // wp_enqueue_script('discount-visibility', plugins_url('/assets/js/discount-visibility.js', __FILE__), array('jquery'), '1.0', true);
    
    // Вместо этого добавляем встроенный скрипт для управления видимостью скидок
    add_action('wp_footer', function() {
        ?>
        <script>
        jQuery(document).ready(function($) {
            // Простая функция для управления видимостью скидок
            function updateDiscountVisibility() {
                var showDiscounts = $('body').attr('data-tm-show-discounts');
                if (showDiscounts === 'yes') {
                    $('.tm-discount-block').show();
                } else {
                    $('.tm-discount-block').hide();
                }
            }
            
            // Запускаем функцию при загрузке страницы
            updateDiscountVisibility();
            
            // Обновляем при изменении атрибута
            $(document).on('tm_discount_visibility_changed', updateDiscountVisibility);
        });
        </script>
        <?php
    }, 20);
    
    // Добавляем атрибут data-tm-show-discounts к тегу body
    // (Add data-tm-show-discounts attribute to body tag)
    add_action('wp_footer', function() use ($show_discounts) {
        echo '<script>jQuery(document).ready(function($) { $(\'body\').attr(\'data-tm-show-discounts\', \'' . esc_js($show_discounts) . '\'); });</script>';
    });
}


add_action('wp_ajax_tmbooking_redirect_to_cart', 'tmbooking_redirect_to_cart_callback');
add_action('wp_ajax_nopriv_tmbooking_redirect_to_cart', 'tmbooking_redirect_to_cart_callback');
function tmbooking_redirect_to_cart_callback() {

    //Get Price
    $price = tmbooking_get_price($_REQUEST['data']['id']);
    $booking_settings = get_option('tm_booking_settings', true);

    //Get Default Product
    $product_id = get_post_meta($_REQUEST['data']['id'], 'tmbooking_sim_product_id', true);

    if(isset($product_id) && $product_id != ''){
        $default_product_obj = get_post( $product_id );
        if(isset($default_product_obj) && $default_product_obj != NULL){
            add_action('woocommerce_init', $default_product = new WC_Product($default_product_obj));
        } else {
            delete_post_meta($_REQUEST['data']['id'], 'tmbooking_sim_product_id');
            $product_id = tm_booking_new_sim_product($_REQUEST['data']['id']);
            $default_product_obj = get_post( $product_id );
        }
    } else {
        $product_id = tm_booking_new_sim_product($_REQUEST['data']['id']);
        $default_product_obj = get_post( $product_id );
    }





    $price = tmbooking_change_price_by_date($price, $_REQUEST['data']['start_date'], $_REQUEST['data']['end_date'], $_REQUEST['data']['start_time'], $_REQUEST['data']['end_time'], $booking_settings['date_format']);

    $percent_all = 0;
    if(isset($_REQUEST['data']['discount'])){
        $discounts = explode(",", $_REQUEST['data']['discount']);
        foreach ($discounts as $d){
            $discount_percent = tmbooking_get_discount_percent($d);
            $percent_all += intval($discount_percent);
        }
    }

    $price = tmbooking_change_price_by_discount($price, $percent_all);
    $price = tmbooking_change_price_by_extra($price, $_REQUEST['data']['extra_ids'], $_REQUEST['data']['start_date'], $_REQUEST['data']['end_date'], $booking_settings['date_format']);
    $price = tmbooking_change_price_by_dr_location($price, $_REQUEST['data']['delivery']);


    //Change price in default product
    $default_product->set_regular_price($price);
    $default_product->save();
    $cart_item_data['tm_booking'] = $_REQUEST['data'];
    $return_error_html = '<div class="tm-booking-error-message">
                            <span class="tm-booking-error-text">
                                ' . esc_html__("Dates are not available", "tm-booking") . '
                            </span>
                        </div>';
    if(!tmbooking_check_times($_REQUEST['data']['id'], $_REQUEST['data']['start_date'], $_REQUEST['data']['end_date'], $_REQUEST['data']['start_time'], $_REQUEST['data']['end_time'], $booking_settings['date_format'])){
        $return_error_html = '<div class="tm-booking-error-message">
                            
                            <span class="tm-booking-error-text">
                                ' . esc_html__("This time is not available", "tm-booking") . '
                            </span>
                        </div>
                        
                         <script>
                            jQuery.noConflict()(function($) {
                               $(".book_now_btn").prop("disabled", true); 
                            });
                        </script>';
    }
    //Cart
    if ( isset($_REQUEST['data']['start_date']) and $_REQUEST['data']['start_date'] != '' and isset($_REQUEST['data']['end_date']) and $_REQUEST['data']['end_date'] != ''){

        if(tmbooking_check_dates($_REQUEST['data']['id'], $_REQUEST['data']['start_date'], $_REQUEST['data']['end_date'], $booking_settings['date_format']) && tmbooking_check_times($_REQUEST['data']['id'], $_REQUEST['data']['start_date'], $_REQUEST['data']['end_date'], $_REQUEST['data']['start_time'], $_REQUEST['data']['end_time'], $booking_settings['date_format'])){
            WC()->cart->empty_cart();
            WC()->cart->add_to_cart( $default_product_obj->ID, 1, 0, [], $cart_item_data);


            if($_REQUEST['data']['start_date'] == $_REQUEST['data']['end_date']){
                if(isset($booking_settings['working_hours']['start']) && $booking_settings['working_hours']['start'] != ''  && $booking_settings['working_hours']['start'] != 'disable' &&
                    isset($booking_settings['working_hours']['end']) && $booking_settings['working_hours']['end'] != ''  && $booking_settings['working_hours']['end'] != 'disable'){
                    $startTime = DateTime::createFromFormat("H:i", $_REQUEST['data']['start_time']);
                    $endTime = DateTime::createFromFormat("H:i", $_REQUEST['data']['end_time']);
                    $interval_time = $startTime->diff($endTime);

                    $hours = $interval_time->h;
                    if($hours == 0){
                        $hours = 1;
                    }
                    $date2 = DateTime::createFromFormat('H:i', $booking_settings['working_hours']['start']);
                    $date3 = DateTime::createFromFormat('H:i', $booking_settings['working_hours']['end']);
                    $l = 0;
                    while ($l <= $hours){
                        if ($startTime >= $date2 && $startTime <= $date3){ } else {
                            $return_error_html = '<div class="details-aside-content__btn">
                                    <span>
                                        x
                                    </span>
                                    <span>
                                        ' . __("This time is not available", "tm-booking") . '
                                    </span>
                                </div>
                                
                                 <script>
                                    jQuery.noConflict()(function($) {
                                       $(".book_now_btn").prop("disabled", true); 
                                    });
                                </script>';

                            wp_send_json( [ 'error' =>  $return_error_html] );
                        }
                        $startTime->modify('+1 hour');
                        $l++;
                    }
                    if(isset($booking_settings['minimum_hours']) && $booking_settings['minimum_hours'] != 'disable'){
                        $minimum_hours = $booking_settings['minimum_hours'];
                    } else {
                        $minimum_hours = '';
                    }
                    if(isset($minimum_hours) && $minimum_hours != '' && $hours < intval($minimum_hours)){
                        $return_error_html = '<div class="details-aside-content__btn">
                                    <span>
                                        x
                                    </span>
                                    <span>
                                        ' . __("Minimum hours ", "tm-booking") .  $minimum_hours .'
                                    </span>
                                </div>
                                
                                 <script>
                                    jQuery.noConflict()(function($) {
                                       $(".book_now_btn").prop("disabled", true); 
                                    });
                                </script>
                                ';
                        wp_send_json( [ 'error' =>  $return_error_html] );
                    }
                }
            }


            //Redirect to cart
            wp_send_json( [ 'redirect' =>  wc_get_cart_url()] );
        } else {
            wp_send_json( [ 'error' =>  $return_error_html] );
        }
    }
    wp_die();
}






add_action('wp_ajax_tmbooking_change_total', 'tmbooking_change_total_callback');
add_action('wp_ajax_nopriv_tmbooking_change_total', 'tmbooking_change_total_callback');
function tmbooking_change_total_callback() {
    // Removed discount logging

    //Get Price
    $price = tmbooking_get_price($_REQUEST['data']['id']);

    $booking_settings = get_option('tm_booking_settings', true);

    $calculate = tmbooking_change_calculate_by_date($_REQUEST['data']['start_date'], $_REQUEST['data']['end_date'], $_REQUEST['data']['start_time'], $_REQUEST['data']['end_time'], $booking_settings['date_format']);
    $return_html = '';

    if (!empty($calculate)){
        if(isset($calculate['interval_month']) && isset($calculate['label_month']) && isset($price[$calculate["name_month"]]) && !empty($price[$calculate["name_month"]]) && $price[$calculate["name_month"]] > 0){
            $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval_month"]) . ' ' . esc_html($calculate["label_month"]) . '</span>';
            $return_html .= '<span class="calculate_price">' . esc_html($price[$calculate["name_month"]]) . get_woocommerce_currency_symbol() . '/' . $calculate["name_month"] . '</span>';
            if(isset($calculate['interval_week']) && isset($calculate['label_week']) && isset($calculate['name_week']) && isset($price[$calculate["name_week"]]) && !empty($price[$calculate["name_week"]]) && $price[$calculate["name_week"]] > 0){
                $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval_week"]) . ' ' . esc_html($calculate["label_week"]) . '</span>';
                $return_html .= '<span class="calculate_price">' . esc_html($price[$calculate["name_week"]]) . get_woocommerce_currency_symbol() . '/' . $calculate["name_week"] . '</span>';
                if($calculate["interval"] != 0 && isset($price[$calculate["name"]]) && !empty($price[$calculate["name"]]) && $price[$calculate["name"]] > 0){
                    $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval"]) . ' ' . esc_html($calculate["label"]) . '</span>';
                    $return_html .= '<span class="calculate_price">' . esc_html($price[$calculate["name"]]) . get_woocommerce_currency_symbol() . '/' . $calculate["name"] . '</span>';
                }
            } else {
                if($calculate["interval"] != 0 && isset($price[$calculate["name"]]) && !empty($price[$calculate["name"]]) && $price[$calculate["name"]] > 0){
                    $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval"]) . ' ' . esc_html($calculate["label"]) . '</span>';
                    $return_html .= '<span class="calculate_price">' . esc_html($price[$calculate["name"]]) . get_woocommerce_currency_symbol() . '/' . $calculate["name"] . '</span>';
                }
            }
        } else {
            if(isset($calculate['interval_week']) && isset($calculate['label_week']) && isset($calculate['name_week']) && isset($price[$calculate["name_week"]]) && !empty($price[$calculate["name_week"]]) && $price[$calculate["name_week"]] > 0){
                $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval_week"]) . ' ' . esc_html($calculate["label_week"]) . '</span>';
                $return_html .= '<span class="calculate_price">' . esc_html($price[$calculate["name_week"]]) . get_woocommerce_currency_symbol() . '/' . $calculate["name_week"] . '</span>';

                if($calculate["interval"] != 0 && isset($price[$calculate["name"]]) && !empty($price[$calculate["name"]]) && $price[$calculate["name"]] > 0){
                    $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval"]) . ' ' . esc_html($calculate["label"]) . '</span>';
                    $return_html .= '<span class="calculate_price">' . esc_html($price[$calculate["name"]]) . get_woocommerce_currency_symbol() . '/' . $calculate["name"] . '</span>';
                }
            } else {
                if($calculate["interval"] != 0 && isset($price[$calculate["name"]]) && !empty($price[$calculate["name"]]) && $price[$calculate["name"]] > 0){
                    if(isset($calculate["name"]) && $calculate["name"] == 'perhour'){

                        if(isset($booking_settings['minimum_hours_day']) && $booking_settings['minimum_hours_day'] != 'disable' ){

                            if($calculate['interval'] >= intval($booking_settings['minimum_hours_day'])){
                                
                                $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval"]) . ' ' . esc_html($calculate["label"]) . '</span>';
                                $return_html .= '<span class="calculate_price">' . esc_html($price[$calculate["name"]]) . get_woocommerce_currency_symbol() . '/' . __('per day', 'tm-booking') . '</span>';

                            } else {
                                $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval"]) . ' ' . esc_html($calculate["label"]) . '</span>';
                                $return_html .= '<span class="calculate_price">' . esc_html($price[$calculate["name"]]) . get_woocommerce_currency_symbol() . '/' . __('per hour', 'tm-booking') . '</span>';
                            }

                        } else {
                            $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval"]) . ' ' . esc_html($calculate["label"]) . '</span>';
                            $return_html .= '<span class="calculate_price">' . esc_html($price[$calculate["name"]]) . get_woocommerce_currency_symbol() . '/' . __('per hour', 'tm-booking') . '</span>';
                        }

                    } else {
                        $return_html .= '<span class="calculate_label">' . esc_html($calculate["interval"]) . ' ' . esc_html($calculate["label"]) . '</span>';
                        $return_html .= '<span class="calculate_price">' . esc_html($price[$calculate["name"]]) . get_woocommerce_currency_symbol() . '/' . __('per day', 'tm-booking') . '</span>';
                    }
                }
            }
        }
    }
    //Get Default Product
    $product_id = get_post_meta($_REQUEST['data']['id'], 'tmbooking_sim_product_id', true);
    if(isset($product_id) && $product_id != ''){
        $default_product_obj = get_post( $product_id );
        add_action('woocommerce_init', $default_product = new WC_Product($default_product_obj));

    } else {
        $default_product_obj = get_page_by_title( 'Booking', OBJECT, 'product' );
        add_action('woocommerce_init', $default_product = new WC_Product($default_product_obj));
    }

    $price = tmbooking_change_price_by_date($price, $_REQUEST['data']['start_date'], $_REQUEST['data']['end_date'], $_REQUEST['data']['start_time'], $_REQUEST['data']['end_time'], $booking_settings['date_format']);

    $percent_all = 0;
    if(isset($_REQUEST['data']['discount'])){
        $discounts = explode(",", $_REQUEST['data']['discount']);
        foreach ($discounts as $d){
            $discount_percent = tmbooking_get_discount_percent($d);
            $percent_all += intval($discount_percent);
        }
    }


    $price = tmbooking_change_price_by_discount($price, $percent_all);
    $price = tmbooking_change_price_by_extra($price, $_REQUEST['data']['extra_ids'], $_REQUEST['data']['start_date'], $_REQUEST['data']['end_date'], $booking_settings['date_format']);
    $price = tmbooking_change_price_by_dr_location($price, $_REQUEST['data']['delivery']);

    // Применяем условия скидок из плагина TM Conditions
    // Apply discount conditions from TM Conditions plugin
    if (function_exists('apply_filters') && has_filter('tmbooking_calculate_price')) {
        // Создаем массив данных бронирования
        // Create booking data array
        $booking_data = array(
            'start_date' => $_REQUEST['data']['start_date'],
            'end_date' => $_REQUEST['data']['end_date'],
            'start_time' => $_REQUEST['data']['start_time'],
            'end_time' => $_REQUEST['data']['end_time']
        );
        
        // Вычисляем количество дней бронирования
        // Calculate booking days count
        $date_format = TMBooking__Helping_Addons::construct_date_format($booking_settings['date_format']);
        $startDate = DateTime::createFromFormat($date_format, $_REQUEST['data']['start_date']);
        $endDate = DateTime::createFromFormat($date_format, $_REQUEST['data']['end_date']);
        $interval = $startDate->diff($endDate);
        $booking_data['days_count'] = ($interval->days > 0) ? $interval->days : 1;
        
        // Применяем фильтр
        // Apply filter
        $original_price = $price;
        $price = apply_filters('tmbooking_calculate_price', $price, $_REQUEST['data']['id'], $booking_data, 'booking');
        
        // Для отладки
        // For debugging
        error_log('TMC Debug: Applied tmbooking_calculate_price filter. Original price: ' . $original_price . ', New price: ' . $price);
    }

    if (isset($_REQUEST['data']['delivery']) && $_REQUEST['data']['delivery'] != ''){
        $terms = get_terms();
        foreach ($terms as $key => $term) {
            if (!empty($term) && $term->taxonomy == 'transports-delivery' && $term->slug === $_REQUEST['data']['delivery'] && tmbooking_get_metabox('free', $term) !== 'free' ){
                $drop_price = tmbooking_get_term_metabox('drop_price', $term->term_id);
                $drop_price = $drop_price . get_woocommerce_currency_symbol();
                if($drop_price == '1' . get_woocommerce_currency_symbol()){
                    $drop_price = __('free', 'tm-booking');
                }

                $return_html .= '<span class="calculate_label">' . __('Delivery price', 'tm-booking') . '</span>';
                $return_html .= '<span class="calculate_price">' . esc_html($drop_price) . '</span>';
            }
        }
    }
    
    // Добавляем информацию о скидке, если она есть
    $booking_days = 0;
    if (isset($calculate['interval']) && $calculate['interval'] > 0) {
        $booking_days = intval($calculate['interval']);
    }

    // Проверяем, есть ли скидка
    if ($percent_all > 0) {
        // Получаем оригинальную цену (без скидки)
        $original_price = $price * 100 / (100 - $percent_all);
        $original_price = round($original_price, 2);
        $savings = $original_price - $price;
        $savings = round($savings, 2);
        
        // Создаем блок со списком скидок
        $discounts_list_html = '';
        
        // Получаем информацию о скидках из терминов
        if (isset($_REQUEST['data']['discount'])) {
            $discounts = explode(",", $_REQUEST['data']['discount']);
            if (!empty($discounts)) {
                foreach ($discounts as $discount_id) {
                    if (empty($discount_id)) continue;
                    
                    $discount_term = get_term($discount_id, 'transports-discount');
                    if ($discount_term && !is_wp_error($discount_term)) {
                        $discount_description = $discount_term->name;
                        $discount_percent = tmbooking_get_term_metabox('discount_percent', $discount_term->term_id);
                        $start_day = tmbooking_get_term_metabox('start_day', $discount_term->term_id);
                        
                        // Создаем блок для каждой скидки
                        $discounts_list_html .= '<div class="discount-info-block" style="margin: 10px 0; padding: 12px; background-color: #f8f8f8; border-left: 3px solid #e44; border-radius: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">';
                        $discounts_list_html .= '<script>console.log("Discount block created in ajax.php - discount list"); alert("Discount block ID: ajax.php-discount-list");</script>';
                        $discounts_list_html .= '<div class="discount-name" style="font-weight: bold; font-size: 16px; color: #333;">' . $discount_description . '</div>';
                        $discounts_list_html .= '</div>';
                    }
                }
            }
        }
        
        // Добавляем блок со списком скидок
        if (!empty($discounts_list_html)) {
            $return_html .= '<section class="tm-booking-price-discount">' . $discounts_list_html . '</section>';
        }
        
        // Формируем блок с информацией о сумме экономии
        $savings_html = '<div class="discount-info-block" style="margin: 10px 0; padding: 12px; background-color: #f8f8f8; border-left: 3px solid #e44; border-radius: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">';
        $savings_html .= '<script>console.log("Discount block created in ajax.php - savings"); alert("Discount block ID: ajax.php-savings");</script>';
        $savings_html .= '<div class="discount-savings" style="font-weight: bold; font-size: 15px; color: #333;">' . esc_html__('You save', 'tm-booking') . ': ' . $savings . get_woocommerce_currency_symbol() . '</div>';
        $savings_html .= '</div>';
        
        // Добавляем блок с информацией о сумме экономии
        $return_html .= $savings_html;
        
        // Update price view: show original (struck through) and discounted price
        $return_html .= '<span class="details-aside-content__total-text total_price_label templines-font-style-semi-bolt">' . esc_html__("Total", "tm-booking") . '</span>';
        $return_html .= '<span class="details-aside-content__total-text total_price templines-font-style-semi-bolt"><span class="original-price" style="text-decoration: line-through; color: #999; display: block; font-size: 14px;">' . tmbooking_get_price_with_currency($original_price) . '</span><span style="color: #e44; font-weight: bold;">' . tmbooking_get_price_with_currency($price) . '</span></span>';
    } else {
        // No discount: clear discount block and show regular price
        $return_html .= '<section class="tm-booking-price-discount"></section>';
        $return_html .= '<span class="details-aside-content__total-text total_price_label templines-font-style-semi-bolt">' . esc_html__("Total", "tm-booking") . '</span>';
        $return_html .= '<span class="details-aside-content__total-text total_price templines-font-style-semi-bolt">' . '<span>' . tmbooking_get_price_with_currency($price) . '</span></span>';
    }

    //Change price in default product
    $default_product->set_regular_price($price);
    $default_product->save();

    $return_error_html = '<div class="tm-booking-error-message">
                            <span class="tm-booking-error-text">
                                ' . esc_html__("Dates are not available", "tm-booking") . '
                            </span>
                        </div>
                         <script>
                            jQuery.noConflict()(function($) {
                               $(".book_now_btn").prop("disabled", true); 
                            });
                        </script>';

    if(!tmbooking_check_times($_REQUEST['data']['id'], $_REQUEST['data']['start_date'], $_REQUEST['data']['end_date'], $_REQUEST['data']['start_time'], $_REQUEST['data']['end_time'], $booking_settings['date_format'])){
        $return_error_html = '<div class="tm-booking-error-message">
                            <span class="tm-booking-error-text">
                                ' . esc_html__("This time is not available", "tm-booking") . '
                            </span>
                        </div>
                        
                         <script>
                            jQuery.noConflict()(function($) {
                               $(".book_now_btn").prop("disabled", true); 
                            });
                        </script>';
    }

    if(tmbooking_check_dates($_REQUEST['data']['id'], $_REQUEST['data']['start_date'], $_REQUEST['data']['end_date'], $booking_settings['date_format']) && tmbooking_check_times($_REQUEST['data']['id'], $_REQUEST['data']['start_date'], $_REQUEST['data']['end_date'], $_REQUEST['data']['start_time'], $_REQUEST['data']['end_time'], $booking_settings['date_format'])){
        if($_REQUEST['data']['start_date'] == $_REQUEST['data']['end_date']){
            if(isset($booking_settings['working_hours']['start']) && $booking_settings['working_hours']['start'] != ''  && $booking_settings['working_hours']['start'] != 'disable' &&
                isset($booking_settings['working_hours']['end']) && $booking_settings['working_hours']['end'] != ''  && $booking_settings['working_hours']['end'] != 'disable'){
                $startTime = DateTime::createFromFormat("H:i", $_REQUEST['data']['start_time']);
                $endTime = DateTime::createFromFormat("H:i", $_REQUEST['data']['end_time']);
                $interval_time = $startTime->diff($endTime);

                $hours = $interval_time->h;
                if($hours == 0){
                    $hours = 1;
                }
                $date2 = DateTime::createFromFormat('H:i', $booking_settings['working_hours']['start']);
                $date3 = DateTime::createFromFormat('H:i', $booking_settings['working_hours']['end']);

                $l = 0;

                while ($l <= $hours){
                    if($startTime >= $date2 && $startTime <= $date3){} else {
                        $return_html = '<div class="tm-booking-error-message">
                            
                            <span class="tm-booking-error-text">
                                ' . esc_html__("This time is not available", "tm-booking") . '
                            </span>
                        </div>
                        
                         <script>
                            jQuery.noConflict()(function($) {
                               $(".book_now_btn").prop("disabled", true); 
                            });
                        </script>';
                    }
                    $startTime->modify('+1 hour');
                    $l++;
                }

                if(isset($booking_settings['minimum_hours']) && $booking_settings['minimum_hours'] != 'disable'){
                    $minimum_hours = $booking_settings['minimum_hours'];
                } else {
                    $minimum_hours = '';
                }

                if(isset($minimum_hours) && $minimum_hours != '' && $hours < intval($minimum_hours)){
                    $return_html = '<div class="tm-booking-error-message">
                                        <span class="tm-booking-error-text">
                                            ' . esc_html__("Minimum hours ", "tm-booking") . $booking_settings['minimum_hours']. ' 
                                        </span>
                                    </div>
                                     <script>
                                        jQuery.noConflict()(function($) {
                                           $(".book_now_btn").prop("disabled", true); 
                                        });
                                    </script>';
                }
                wp_send_json($return_html);
            }
        } else {
            if(!tmbooking_check_dates($_REQUEST['data']['id'], $_REQUEST['data']['start_date'], $_REQUEST['data']['end_date'], $booking_settings['date_format'])){
                $return_html = '<div class="tm-booking-error-message">
                                    <span class="tm-booking-error-text">
                                        ' . esc_html__("Dates are not available", "tm-booking") . ' 
                                    </span>
                                </div>
                                 <script>
                                    jQuery.noConflict()(function($) {
                                       $(".book_now_btn").prop("disabled", true); 
                                    });
                                </script>';

                wp_send_json($return_html);
                die();
            }
        }

        wp_send_json($return_html);
    } else {
        wp_send_json($return_error_html);
    }

    wp_die();
}






function tmbooking_change_price_by_date($price, $start_date, $end_date, $start_time, $end_time, $date_format){
    // Проверка входных данных
    if (!is_array($price)) {
        $price = array(
            'perhour' => 0,
            'perday' => 0,
            'perweek' => 0,
            'permonth' => 0
        );
    }
    
    // Убедимся, что все ключи массива цен существуют и имеют числовые значения
    foreach (['perhour', 'perday', 'perweek', 'permonth'] as $key) {
        if (!isset($price[$key]) || !is_numeric($price[$key])) {
            $price[$key] = 0;
        }
    }

    $date_format = TMBooking__Helping_Addons::construct_date_format($date_format);
    $booking_settings = get_option('tm_booking_settings', true);
    
    // Проверка наличия массива calc_periods в настройках
    if (!isset($booking_settings['calc_periods']) || !is_array($booking_settings['calc_periods'])) {
        $booking_settings['calc_periods'] = ['calc_days']; // По умолчанию используем дневные расчеты
    }

    if(isset($start_date) && $start_date != '' && isset($end_date) && $end_date != '' && isset($start_time) && $start_time != '' && isset($end_time) && $end_time != ''){
        $startDate = DateTime::createFromFormat($date_format, $start_date);
        $endDate = DateTime::createFromFormat($date_format, $end_date);
        
        // Проверка корректности дат
        if (!$startDate || !$endDate) {
            // Если даты не удалось преобразовать, возвращаем дневную цену
            return $price['perday'];
        }

        $interval = $startDate->diff($endDate);
        if ($interval->m > 0){
            if($interval->d != 0){
                if($interval->d >= 7){
                    if(in_array('calc_weeks', $booking_settings['calc_periods']) && $price['perweek'] > 0){
                        $price['perweek'] = $price['perweek'] * floor($interval->d/7);
                        $interval_days_left = $interval->d - (floor($interval->d/7) * 7);
                        $price['permonth'] = $price['permonth'] * $interval->m;
                        if($interval_days_left != 0){
                            $price['perday'] = $price['perday'] * $interval_days_left;
                            return $price['permonth'] + $price['perweek'] + $price['perday'];
                        } else {
                            return $price['permonth'] + $price['perweek'];
                        }
                    } elseif(in_array('calc_days', $booking_settings['calc_periods'])) {
                        if(in_array('calc_month', $booking_settings['calc_periods']) && $price['permonth'] > 0) {
                            $price['permonth'] = $price['permonth'] * $interval->m;
                            $price['perday'] = $price['perday'] * $interval->d;
                            return $price['permonth'] + $price['perday'];
                        } else {
                            $price['perday'] = $price['perday'] * $interval->days;
                            return $price['perday'];
                        }
                    } else {
                        // Если нет подходящего метода расчета, используем дневной расчет
                        $price['perday'] = $price['perday'] * $interval->days;
                        return $price['perday'];
                    }
                } else {
                    if(in_array('calc_month', $booking_settings['calc_periods']) && $price['permonth'] > 0) {
                        $price['permonth'] = $price['permonth'] * $interval->m;
                        $price['perday'] = $price['perday'] * $interval->d;
                        return $price['permonth'] + $price['perday'];
                    } else {
                        $price['perday'] = $price['perday'] * $interval->days;
                        return $price['perday'];
                    }
                }
            } else {
                if(in_array('calc_month', $booking_settings['calc_periods']) && $price['permonth'] > 0) {
                    return $price['permonth'] * $interval->m;
                } else {
                    $price['perday'] = $price['perday'] * $interval->days;
                    return $price['perday'];
                }
            }
        } else {
            if ($interval->days == 0){
                $startTime = DateTime::createFromFormat("H:i", $start_time);
                $endTime = DateTime::createFromFormat("H:i", $end_time);
                
                if (!$startTime || !$endTime) {
                    // Если время не удалось преобразовать, возвращаем дневную цену
                    return $price['perday'];
                }
                
                $interval_time = $startTime->diff($endTime);

                if($interval_time->h != 0){
                    $hours = $interval_time->h;
                   
                    if(in_array('calc_hours', $booking_settings['calc_periods']) && isset($booking_settings['minimum_hours_day']) && $booking_settings['minimum_hours_day'] != 'disable' && $booking_settings['minimum_hours_day'] > $hours && $price['perhour'] > 0) {
                        $price['perhour'] = $price['perhour'] * $hours;
                        return $price['perhour'];
                    } else {
                        return $price['perday'];
                    }
                } elseif($interval_time->h == 0){
                    $hours = 1;
                    if(in_array('calc_hours', $booking_settings['calc_periods']) && $price['perhour'] > 0) {
                        $price['perhour'] = $price['perhour'] * $hours;
                        return $price['perhour'];
                    } else {
                        return $price['perday'];
                    }
                }
            } else {
                if(in_array('calc_weeks', $booking_settings['calc_periods']) && $price['perweek'] > 0){
                    if($interval->days >= 7){
                        $price['perweek'] = $price['perweek'] * floor($interval->d/7);
                        $interval_days_left = $interval->days - (floor($interval->d/7) * 7);
                        if($interval_days_left != 0){
                            $price['perday'] = $price['perday'] * $interval_days_left;
                            return $price['perweek'] + $price['perday'];
                        } else {
                            return $price['perweek'];
                        }
                    } else {
                        $price['perday'] = $price['perday'] * $interval->days;
                        return $price['perday'];
                    }
                } else {
                    $price['perday'] = $price['perday'] * $interval->days;
                    return $price['perday'];
                }
            }
        }
    }
    
    // Если что-то пошло не так, возвращаем дневную цену
    return $price['perday'];
}


function tmbooking_change_calculate_by_date($start_date, $end_date, $start_time, $end_time, $date_format){
    // Инициализация массива результата
    $calculate = array();
    
    // Проверка формата даты
    $date_format = TMBooking__Helping_Addons::construct_date_format($date_format);
    
    // Получение настроек бронирования
    $booking_settings = get_option('tm_booking_settings', true);
    
    // Проверка наличия массива calc_periods в настройках
    if (!isset($booking_settings['calc_periods']) || !is_array($booking_settings['calc_periods'])) {
        $booking_settings['calc_periods'] = ['calc_days']; // По умолчанию используем дневные расчеты
        error_log('WARNING: calc_periods not set in booking settings, using default calc_days');
    }

    // Проверка входных данных
    if(isset($start_date) && $start_date != '' && isset($end_date) && $end_date != '' && isset($start_time) && $start_time != '' && isset($end_time) && $end_time != ''){
        // Логирование входных данных для отладки
        error_log('tmbooking_change_calculate_by_date - Input data:');
        error_log('Start date: ' . $start_date);
        error_log('End date: ' . $end_date);
        error_log('Start time: ' . $start_time);
        error_log('End time: ' . $end_time);
        error_log('Date format: ' . $date_format);
        
        // Преобразование строк дат в объекты DateTime
        $startDate = DateTime::createFromFormat($date_format, $start_date);
        $endDate = DateTime::createFromFormat($date_format, $end_date);
        
        // Проверка корректности преобразования дат
        if ($startDate && $endDate) {
            // Логирование преобразованных дат
            error_log('Parsed start date with time: ' . $startDate->format('Y-m-d H:i:s'));
            error_log('Parsed end date with time: ' . $endDate->format('Y-m-d H:i:s'));
            error_log('Raw interval days before reset: ' . $startDate->diff($endDate)->days);
            
            // Сброс времени для корректного расчета количества дней
            $startDate->setTime(0, 0, 0);
            $endDate->setTime(0, 0, 0);
            
            // Логирование дат после сброса времени
            error_log('After reset - Start date: ' . $startDate->format('Y-m-d H:i:s'));
            error_log('After reset - End date: ' . $endDate->format('Y-m-d H:i:s'));
        } else {
            // Логирование ошибки и возврат базового результата при ошибке преобразования дат
            error_log('ERROR: Failed to parse dates in tmbooking_change_calculate_by_date');
            $calculate['label'] = __('day', 'tm-booking');
            $calculate['name'] = __('perday', 'tm-booking');
            $calculate['interval'] = 1;
            return $calculate;
        }
        
        // Расчет интервала между датами
        $interval = $startDate->diff($endDate);
        
        // Логирование для отладки
        error_log('tmbooking_change_calculate_by_date - Calculated days: ' . $interval->days);

        // Обработка случая, когда интервал содержит месяцы
        if ($interval->m > 0){
            // Проверяем, включен ли расчет по месяцам
            if(in_array('calc_month', $booking_settings['calc_periods'])) {
                $calculate['label_month'] = __($interval->m == 1 ? 'month' : 'months', 'tm-booking');
                $calculate['name_month'] = __('permonth', 'tm-booking');
                $calculate['interval_month'] = $interval->m;
            } else {
                // Если расчет по месяцам не включен, используем дневной расчет
                $calculate['label'] = __($interval->days == 1 ? 'day' : 'days', 'tm-booking');
                $calculate['name'] = __('perday', 'tm-booking');
                $calculate['interval'] = $interval->days;
            }

            // Обработка дней, если их больше или равно 7
            if($interval->d >= 7){
                // Проверяем, включен ли расчет по неделям
                if(in_array('calc_weeks', $booking_settings['calc_periods'])){
                    $calculate['name'] = __('perday', 'tm-booking');
                    $calculate['name_week'] = __('perweek', 'tm-booking');
                    $calculate['interval_week'] = floor($interval->d/7);
                    $calculate['label_week'] = __($calculate['interval_week'] == 1 ? 'week' : 'weeks', 'tm-booking');
                    $calculate['interval'] = $interval->d - (floor($interval->d/7) * 7);
                    $calculate['label'] = __($calculate['interval'] == 1 ? 'day' : 'days', 'tm-booking');
                } else {
                    // Если расчет по неделям не включен
                    if(in_array('calc_month', $booking_settings['calc_periods'])) {
                        // Если включен расчет по месяцам, добавляем дни
                        $calculate['label'] = __($interval->d == 1 ? 'day' : 'days', 'tm-booking');
                        $calculate['name'] = __('perday', 'tm-booking');
                        $calculate['interval'] = $interval->d;
                    } else {
                        // Иначе используем только дневной расчет для всего периода
                        $calculate['label'] = __($interval->days == 1 ? 'day' : 'days', 'tm-booking');
                        $calculate['name'] = __('perday', 'tm-booking');
                        $calculate['interval'] = $interval->days;
                    }
                }
            } else {
                // Обработка случая, когда дней меньше 7
                if($interval->d != 0){
                    if(in_array('calc_month', $booking_settings['calc_periods'])) {
                        $calculate['label'] = __($interval->d == 1 ? 'day' : 'days', 'tm-booking');
                        $calculate['name'] = __('perday', 'tm-booking');
                        $calculate['interval'] = $interval->d;
                    } else {
                        $calculate['label'] = __($interval->days == 1 ? 'day' : 'days', 'tm-booking');
                        $calculate['name'] = __('perday', 'tm-booking');
                        $calculate['interval'] = $interval->days;
                    }
                }
            }
            return $calculate;

        } else {
            // Обработка случая, когда нет месяцев в интервале
            if ($interval->days == 0){
                // Если даты одинаковые, работаем с временем
                $startTime = DateTime::createFromFormat("H:i", $start_time);
                $endTime = DateTime::createFromFormat("H:i", $end_time);
                
                // Проверка корректности преобразования времени
                if (!$startTime || !$endTime) {
                    error_log('ERROR: Failed to parse times in tmbooking_change_calculate_by_date');
                    $calculate['label'] = __('day', 'tm-booking');
                    $calculate['name'] = __('perday', 'tm-booking');
                    $calculate['interval'] = 1;
                    return $calculate;
                }

                $interval_time = $startTime->diff($endTime);

                if($interval_time->h > 0){
                    // Если есть часы в интервале
                    if(in_array('calc_hours', $booking_settings['calc_periods'])) {
                        // Проверка минимального количества часов для дня
                        if(isset($booking_settings['minimum_hours_day']) && $booking_settings['minimum_hours_day'] != 'disable' ){
                            if($interval_time->h >= intval($booking_settings['minimum_hours_day'])){
                                $calculate['label'] = __('day', 'tm-booking');
                                $calculate['name'] = __('perday', 'tm-booking');
                                $calculate['interval'] = 1;
                            } else {
                                $calculate['label'] = __($interval_time->h == 1 ? 'hour' : 'hours', 'tm-booking');
                                $calculate['name'] = __('perhour', 'tm-booking');
                                $calculate['interval'] = $interval_time->h;
                            }
                        } else {
                            $calculate['label'] = __($interval_time->h == 1 ? 'hour' : 'hours', 'tm-booking');
                            $calculate['name'] = __('perhour', 'tm-booking');
                            $calculate['interval'] = $interval_time->h;
                        }
                    } else {
                        // Если расчет по часам не включен, используем дневной расчет
                        $calculate['label'] = __('day', 'tm-booking');
                        $calculate['name'] = __('perday', 'tm-booking');
                        $calculate['interval'] = 1;
                    }
                } elseif($interval_time->h == 0){
                    // Если часы равны 0 (одинаковое время)
                    if(isset($booking_settings['minimum_hours_day']) && $booking_settings['minimum_hours_day'] != 'disable' ){
                        if(intval($booking_settings['minimum_hours_day']) == 1 && $interval_time->h == 0){
                            $calculate['label'] = __('day', 'tm-booking');
                            $calculate['name'] = __('perday', 'tm-booking');
                            $calculate['interval'] = 1;
                        } else {
                            $hours = 1; // Минимум 1 час
                            $calculate['label'] = __($hours == 1 ? 'hour' : 'hours', 'tm-booking');
                            $calculate['name'] = __('perhour', 'tm-booking');
                            $calculate['interval'] = $hours;
                        }
                    } else {
                        $hours = 1; // Минимум 1 час
                        $calculate['label'] = __($hours == 1 ? 'hour' : 'hours', 'tm-booking');
                        $calculate['name'] = __('perhour', 'tm-booking');
                        $calculate['interval'] = $hours;
                    }
                }
            } else {
                // Если есть дни в интервале
                if($interval->days >= 7 && $interval->m == 0){
                    // Если дней больше или равно 7 и нет месяцев
                    if(in_array('calc_weeks', $booking_settings['calc_periods'])) {
                        // Если включен расчет по неделям
                        $calculate['name'] = __('perday', 'tm-booking');
                        $calculate['name_week'] = __('perweek', 'tm-booking');
                        $calculate['interval_week'] = floor($interval->d / 7);
                        $calculate['label_week'] = __($calculate['interval_week'] == 1 ? 'week' : 'weeks', 'tm-booking');
                        $calculate['interval'] = $interval->days - (floor($interval->d / 7) * 7);
                        $calculate['label'] = __($calculate['interval'] == 1 ? 'day' : 'days', 'tm-booking');
                    } else {
                        // Если расчет по неделям не включен, используем дневной расчет
                        $calculate['label'] = __($interval->days == 1 ? 'day' : 'days', 'tm-booking');
                        $calculate['name'] = __('perday', 'tm-booking');
                        $calculate['interval'] = $interval->days;
                    }
                } else {
                    // Если дней меньше 7, используем дневной расчет
                    $calculate['label'] = __($interval->days == 1 ? 'day' : 'days', 'tm-booking');
                    $calculate['name'] = __('perday', 'tm-booking');
                    $calculate['interval'] = $interval->days;
                }
            }
            return $calculate;
        }
    }
    
    // Если не удалось выполнить расчет, возвращаем базовый результат
    $calculate['label'] = __('day', 'tm-booking');
    $calculate['name'] = __('perday', 'tm-booking');
    $calculate['interval'] = 1;
    return $calculate;
}


function tmbooking_change_price_by_discount($price, $discount){
    if(isset($discount) && $discount != ''){
        $price_discount = intval($price) / 100 * intval($discount);
        $price = intval($price) - intval($price_discount);
    }
    return $price;
}


/**
 * Get discount percent for a specific term ID
 *
 * @param int $ID Term ID
 * @return string Discount percent value
 */
function tmbooking_get_discount_percent($ID){
    // Эта функция получает процент скидки для конкретного термина
    // и не требует изменений, так как она работает с одним термином,
    // а не с множеством терминов
    $discount_percent = '';
    $terms = get_terms();
    foreach ($terms as $key => $term) {
        if ($ID == $term->term_id){
            if (!empty($term)){
                $discount_percent = tmbooking_get_term_metabox('discount_percent', $term->term_id);
            }
        }
    }
    return $discount_percent;
}


function tmbooking_change_price_by_extra($price, $extra, $start_date, $end_date, $date_format){
    $terms = get_terms();
    $extra_ids = explode(",", $extra);
    $date_format = TMBooking__Helping_Addons::construct_date_format($date_format);
    $startDate = DateTime::createFromFormat($date_format, $start_date);
    $endDate = DateTime::createFromFormat($date_format, $end_date);
    foreach ($terms as $key => $term) {
        if (!empty($term)){
            if (in_array($term->term_id, $extra_ids)){
                $extra_price = tmbooking_get_term_metabox('extra_price', $term->term_id);
                if(tmbooking_get_term_metabox('per', $term->term_id) == 'total'){
                    $price = $price + $extra_price;
                } elseif(tmbooking_get_term_metabox('per', $term->term_id) == 'day') {
                    $interval = $startDate->diff($endDate);
                    $price = $price + ($extra_price * $interval->days);
                    if ($interval->days == 0){
                        $price = $price + ($extra_price);
                    }
                }
            }
        }
    }
    return $price;
}


function tmbooking_change_price_by_dr_location($price, $location){
    $terms = get_terms();

    foreach ($terms as $key => $term) {
        if (!empty($term) && $term->taxonomy == 'transports-delivery' && $term->slug === $location && tmbooking_get_term_metabox('free', $term->term_id) !== 'free'){
            $drop_price = tmbooking_get_term_metabox('drop_price', $term->term_id);
            $price = $price + $drop_price;
        }


    }
    return $price;
}



function tmbooking_check_dates($id, $start_date, $end_date, $date_format){
    $disable_dates = get_post_meta($id, '_tmbooking_data', true);

    if(isset($disable_dates) && !empty($disable_dates)){
        foreach ($disable_dates as $d){
            $d = explode(" ", $d);
            $disable_dates_js[$d[0]] = $d[0];
        }
    }

    $date_format = TMBooking__Helping_Addons::construct_date_format($date_format);
    $startDate = DateTime::createFromFormat($date_format, $start_date);
    $endDate = DateTime::createFromFormat($date_format, $end_date);
    $booked_period = new DatePeriod(
        $startDate,
        new DateInterval('P1D'),
        $endDate
    );

    $return = true;
    if(isset($disable_dates) && !empty($disable_dates)){
        foreach ($booked_period as $value) {
            $sass .= $value->format($date_format) . ' ';
            if (in_array($value->format($date_format), $disable_dates_js)){
                $return = false;
            }
        }
    }
    $booking_settings = get_option('tm_booking_settings', true);
    if(isset($booking_settings['booked_days']) && $booking_settings['booked_days'] === 'disable'){
        $return = true;
    }
    return $return;
}

function tmbooking_check_times($id, $start_date, $end_date, $start_time, $end_time, $date_format){
    $disable_dates = get_post_meta($id, '_tmbooking_data', true);
    $date_format = TMBooking__Helping_Addons::construct_date_format($date_format);
    $return = true;
    if($start_date == $end_date){
        $disable_dates_j = array();
        if(isset($disable_dates) && is_array($disable_dates) && !empty($disable_dates)){
            $j = 0;
            foreach ($disable_dates as $d){
                $date = DateTime::createFromFormat($date_format . ' H:i', $d);
                $disable_dates_j[$j] = $date->format('H:i');
                $j++;
            }
            $disable_dates_j = array_unique($disable_dates_j);

            $start_time = DateTime::createFromFormat('H:i', $start_time);
            $end_time = DateTime::createFromFormat('H:i', $end_time);


            $date2 = DateTime::createFromFormat('H:i', $disable_dates_j[0]);
            $date3 = DateTime::createFromFormat('H:i', $disable_dates_j[count($disable_dates_j) - 1]);

            $interval_time = $date2->diff($date3);
            $hours = $interval_time->h;
            if($hours == 0){
                $hours = 1;
            }

            $s = 1;
            while ($s <= $hours){
                if($date2 >= $start_time && $date2 <= $end_time){
                    $return = false;
                }
                $date2->modify('+1 hour');
                $s++;
            }

            $a = 1;
            while ($a <= $hours){
                if($date3 >= $start_time && $date3 <= $end_time){
                    $return = false;
                }
                $date3->modify('-1 hour');
                $a++;
            }
        }
    }

    $booking_settings = get_option('tm_booking_settings', true);
    if(isset($booking_settings['booked_days']) && $booking_settings['booked_days'] === 'disable'){
        $return = true;
    }

    return $return;
}





//Woo
function tmbooking_custom_new_product_image($image, $cart_item) {
    if ( ! empty( $cart_item['tm_booking'] ) ) {
        $return = '';
        $feat = tmbooking_get_metabox('featured_image', $cart_item['tm_booking']['id']);
        if(isset($feat) && is_array($feat)){
            $url = wp_get_attachment_image_url($feat['ID'], 'tm_booking_size_350x300_crop');
        } else {
            $url = get_the_post_thumbnail_url($cart_item['tm_booking']['id'], 'tm_booking_size_350x300_crop');
        }
        if(isset($url) && $url != ''){
            $return .= '<img src="'. $url .'" alt="' . esc_attr__("product image", "tm-booking") . '"/>';
        }
    }
    return $return;
}
add_filter( 'woocommerce_cart_item_thumbnail', 'tmbooking_custom_new_product_image', 10, 3 );


if ( ! function_exists( 'tmbooking_cart_add_meta' ) ) {
    function tmbooking_cart_add_meta( $item_data, $cart_item ) {
        add_filter( 'woocommerce_is_sold_individually', function (){return(true);}, 10, 2 );
        if ( ! empty( $cart_item['tm_booking'] ) ) {

            $html_data_to_cart = '';
            $html_data_to_cart .= '<div class="tm_booking_cart_wrap">';
            $html_data_to_cart .= '<div class="tm_booking_cart tm_booking_cart-start-date">
             <div class="start-booking-pickup">
            <span class="start-booking-date">' . __( 'Pickup', 'tm-booking' ) . '</span>
            <span class="value">' . $cart_item['tm_booking']['start_date'] . '</span>';


            if(isset($cart_item['tm_booking']['location']) && $cart_item['tm_booking']['location'] != '' && $cart_item['tm_booking']['location'] != '0') {
                $html_data_to_cart .= '<span class="location-value">' . $cart_item['tm_booking']['location'] . '</span>';
            }

            $html_data_to_cart .= '</div>';


            $html_data_to_cart .= '<div class="tm_booking_cart_drop_off">
            <span class="end-booking-date">' . __( 'Drop Off', 'tm-booking' ) . '</span><span class="value">' . $cart_item['tm_booking']['end_date'] . '</span></div>';


            if(isset($cart_item['tm_booking']['discount']) && $cart_item['tm_booking']['discount'] != ''){
                $html_data_to_cart .= '<div class="tm_booking_cart_discount"><div class="discount-title">' . __( 'Discount', 'tm-booking' ) . '</div><div class="discount-value">' . tmbooking_get_discount_percent_html($cart_item['tm_booking']['id']) . '</div></div>';
            }
            $html_data_to_cart .= '</div>';


            if (isset($cart_item['tm_booking']['extra_ids']) && $cart_item['tm_booking']['extra_ids'] != '') {
                $selected_extras_html = tmbooking_get_selected_extra_html(
                    $cart_item['tm_booking']['id'],
                    $cart_item['tm_booking']['extra_ids']
                );
                if (!empty($selected_extras_html)) {
                    $html_data_to_cart .= '<div class="tm_booking_cart_extra"><span class="tm-extra-title">' . esc_html__( 'Extra items', 'tm-booking' ) . '</span>'
                        . '<span class="tm-extra-value">' . $selected_extras_html . '</span></div>';
                }
            }

            $item_data[] = [
                'key'   => __( 'content', 'tm-booking' ),
                'value' => $html_data_to_cart
            ];
        }


        return $item_data;
    }
}
add_filter( 'woocommerce_get_item_data', 'tmbooking_cart_add_meta', 10, 2 );


if ( ! function_exists( 'tmbooking_woo_add_custom_order_line_item_meta' ) ) {
    function tmbooking_woo_add_custom_order_line_item_meta($item, $cart_item_key, $values, $order) {
        if (!empty($values['tm_booking'])) {
            $item->add_meta_data('ID', $values['tm_booking']['id']);
            $item->add_meta_data('Item', '<a href="' . get_post_permalink($values['tm_booking']['id']) . '">' . get_the_title($values['tm_booking']['id']) . '</a>');

            if(isset( $values['tm_booking']['location']) && $values['tm_booking']['location'] != '' && $values['tm_booking']['location'] != '0'){
                $location = $values['tm_booking']['location'];
                $item->add_meta_data('Location', $location);
            }

            $discount = tmbooking_get_discount_percent_html($values['tm_booking']['id']);
            $item->add_meta_data('Discount', $discount);

            if(isset( $values['tm_booking']['start_date']) && $values['tm_booking']['start_date'] != ''){
                $start_date = $values['tm_booking']['start_date'];
                $item->add_meta_data('Start date', $start_date);
            }

            if(isset( $values['tm_booking']['end_date']) && $values['tm_booking']['end_date'] != ''){
                $start_date = $values['tm_booking']['end_date'];
                $item->add_meta_data('End date', $start_date);
            }

            if(isset( $values['tm_booking']['start_time']) && $values['tm_booking']['start_time'] != ''){
                $start_time = $values['tm_booking']['start_time'];
                $item->add_meta_data('Start time', $start_time);
            }

            if(isset( $values['tm_booking']['end_time']) && $values['tm_booking']['end_time'] != ''){
                $end_time = $values['tm_booking']['end_time'];
                $item->add_meta_data('End time', $end_time);
            }

            if (isset($values['tm_booking']['extra_ids']) && $values['tm_booking']['extra_ids'] !== '') {
                $extra = tmbooking_get_selected_extra_html($values['tm_booking']['id'], $values['tm_booking']['extra_ids']);
                if (!empty($extra)) {
                    $item->add_meta_data('Extra', $extra);
                }
            }

        }
    }
}
add_action('woocommerce_checkout_create_order_line_item', 'tmbooking_woo_add_custom_order_line_item_meta', 10, 4);


add_action('before_delete_post', 'tmbooking_delete_by_order_id', 10, 1);
function tmbooking_delete_by_order_id($id) {
    global $wpdb;
    $post_type = get_post_type($id);
    if ($post_type !== 'shop_order_placehold' && $post_type !== 'shop_order') {
        return;
    }

    $booking_settings = get_option('tm_booking_settings', true);
    $date_format = TMBooking__Helping_Addons::construct_date_format($booking_settings['date_format']);

    $sql_select_transport_id = $wpdb->prepare( "SELECT transport_id FROM {$wpdb->prefix}tmbooking_order WHERE order_id=%d", $id );
    $sql_select_transport_start_date = $wpdb->prepare( "SELECT start_date FROM {$wpdb->prefix}tmbooking_order WHERE order_id=%d", $id );
    $sql_select_transport_end_date = $wpdb->prepare( "SELECT end_date FROM {$wpdb->prefix}tmbooking_order WHERE order_id=%d", $id );

    $transport_id = $wpdb->get_var( $sql_select_transport_id );
    $start_date = $wpdb->get_var( $sql_select_transport_start_date );
    $end_date = $wpdb->get_var( $sql_select_transport_end_date );

    $days_meta = get_post_meta($transport_id, '_tmbooking_data', true);
    if(isset($start_date) && $start_date != 0 && isset($end_date) && $end_date != ''){
        $startDate = DateTime::createFromFormat('Y-m-d H:i:s', $start_date);
        $endDate = DateTime::createFromFormat('Y-m-d H:i:s', $end_date);
        $booked_period_to_del = new DatePeriod(
            $startDate,
            new DateInterval('P1D'),
            $endDate
        );
    }

    $booked_days = array();
    if(isset($days_meta) && !empty($days_meta)){
        foreach ($days_meta as $value){
            $booked_days[] .= $value;
        }
    }

    if(isset($booked_period_to_del) && !empty($booked_period_to_del)){
        foreach ($booked_period_to_del as $key => $value) {
            $booked_days = array_diff($booked_days, [$value->format($date_format . ' H:i')]);
        }
        update_post_meta($transport_id, '_tmbooking_data', $booked_days);

    }

    $sql_delete = $wpdb->prepare( "DELETE FROM {$wpdb->prefix}tmbooking_order WHERE order_id=%d", $id );
    $wpdb->query( $sql_delete );
}


add_action( 'woocommerce_order_status_failed', 'tmbooking_trash_by_order_id' );
add_action( 'woocommerce_order_status_refunded', 'tmbooking_trash_by_order_id' );
add_action( 'woocommerce_order_status_cancelled', 'tmbooking_trash_by_order_id' );
add_action( 'wp_trash_post', 'tmbooking_trash_by_order_id' );
add_action( 'woocommerce_trash_order', 'tmbooking_trash_by_order_id' );

function tmbooking_trash_by_order_id($id) {
    global $wpdb;
    $post_type = get_post_type($id);

    if ($post_type !== 'shop_order_placehold' && $post_type !== 'shop_order') {
        return;
    }


    $booking_settings = get_option('tm_booking_settings', true);
    $date_format = TMBooking__Helping_Addons::construct_date_format($booking_settings['date_format']);

    $sql_select_transport_id = $wpdb->prepare( "SELECT transport_id FROM {$wpdb->prefix}tmbooking_order WHERE order_id=%d", $id );
    $sql_select_transport_start_date = $wpdb->prepare( "SELECT start_date FROM {$wpdb->prefix}tmbooking_order WHERE order_id=%d", $id );
    $sql_select_transport_end_date = $wpdb->prepare( "SELECT end_date FROM {$wpdb->prefix}tmbooking_order WHERE order_id=%d", $id );

    $transport_id = $wpdb->get_var( $sql_select_transport_id );


    $start_date = $wpdb->get_var( $sql_select_transport_start_date );
    $end_date = $wpdb->get_var( $sql_select_transport_end_date );

    $days_meta = get_post_meta($transport_id, '_tmbooking_data', true);



    if(isset($start_date) && $start_date != 0 && isset($end_date) && $end_date != 0){
        $startDate = DateTime::createFromFormat('Y-m-d H:i:s', $start_date);
        $endDate = DateTime::createFromFormat('Y-m-d H:i:s', $end_date);

        $booked_period_to_del = new DatePeriod(
            $startDate,
            new DateInterval('P1D'),
            $endDate
        );
    }

    $booked_days = array();
    if (isset($days_meta) && !empty($days_meta)){
        if(isset($days_meta) && !empty($days_meta)){
            foreach ($days_meta as $value){
                $booked_days[] .= $value;
            }
        }
    }





    if(isset($booked_period_to_del) && !empty($booked_period_to_del)){

        foreach ($booked_period_to_del as $key => $value) {
            $booked_days = array_diff($booked_days, [$value->format($date_format . ' H:i')]);
        }

        if($startDate->format($date_format) == $endDate->format($date_format)){
            $s = 1;
            $interval_time = $startDate->diff($endDate);
            $hours = $interval_time->h;
            if($hours == 0){
                $hours = 1;
            }
            while ($s <= $hours){
                $booked_days = array_diff($booked_days, [$startDate->format($date_format . ' H:i')]);

                $startDate->modify('+1 hour');
                $s++;

                $booked_days = array_diff($booked_days, [$startDate->format($date_format . ' H:i')]);
            }

        }



        update_post_meta($transport_id, '_tmbooking_data', $booked_days);

    }

    $sql_trash = $wpdb->prepare( "UPDATE {$wpdb->prefix}tmbooking_order SET status='trash' WHERE order_id=%d", $id );
    $wpdb->query( $sql_trash );
}


add_action( 'woocommerce_order_status_processing', 'tmbooking_untrash_by_order_id' );
add_action( 'untrash_post', 'tmbooking_untrash_by_order_id' );
function tmbooking_untrash_by_order_id( $id ) {
    global $wpdb;
    $post_type = get_post_type($id);
    if ($post_type !== 'shop_order_placehold' && $post_type !== 'shop_order') {
        return;
    }

    $booking_settings = get_option('tm_booking_settings', true);
    $date_format = TMBooking__Helping_Addons::construct_date_format($booking_settings['date_format']);

    $sql_select_transport_id = $wpdb->prepare( "SELECT transport_id FROM {$wpdb->prefix}tmbooking_order WHERE order_id=%d", $id );
    $sql_select_transport_start_date = $wpdb->prepare( "SELECT start_date FROM {$wpdb->prefix}tmbooking_order WHERE order_id=%d", $id );
    $sql_select_transport_end_date = $wpdb->prepare( "SELECT end_date FROM {$wpdb->prefix}tmbooking_order WHERE order_id=%d", $id );

    $transport_id = $wpdb->get_var( $sql_select_transport_id );
    $start_date = $wpdb->get_var( $sql_select_transport_start_date );
    $end_date = $wpdb->get_var( $sql_select_transport_end_date );

    $days_meta = get_post_meta($transport_id, '_tmbooking_data', true);

    if (isset($start_date) && $start_date != 0 && isset($end_date) && $end_date != 0){
        $startDate = DateTime::createFromFormat('Y-m-d H:i:s', $start_date);
        $endDate = DateTime::createFromFormat('Y-m-d H:i:s', $end_date);

        $booked_period_to_del = new DatePeriod(
            $startDate,
            new DateInterval('P1D'),
            $endDate
        );


    }

    $booked_days = array();

    if(isset($days_meta) && !empty($days_meta)){
        if(isset($days_meta) && !empty($days_meta)){
            foreach ($days_meta as $value){
                $booked_days[] .= $value;
            }
        }
    }

    if (isset($booked_period_to_del)){
        foreach ($booked_period_to_del as $key => $value) {
            $booked_days[] .= $value->format($date_format . ' H:i');
        }


        if($startDate->format($date_format) == $endDate->format($date_format)){
            $s = 1;
            $interval_time = $startDate->diff($endDate);
            $hours = $interval_time->h;
            if($hours == 0){
                $hours = 1;
            }
            while ($s <= $hours){
                $booked_days[] .= $startDate->format($date_format . ' H:i');
                $startDate->modify('+1 hour');
                $booked_days[] .= $startDate->format($date_format . ' H:i');
                $s++;
            }
        }


        $booked_days = array_unique($booked_days);
        update_post_meta($transport_id, '_tmbooking_data', $booked_days);
    }



    $sql_trash = $wpdb->prepare( "UPDATE {$wpdb->prefix}tmbooking_order SET status='processing' WHERE order_id=%d", $id );
    $wpdb->query( $sql_trash );
}


add_action( 'woocommerce_thankyou', 'tmbooking_add_to_db', 4 );
function tmbooking_add_to_db( $order_id ) {
    $order = new WC_Order($order_id);

    foreach ( $order->get_items() as $key => $item ) {
        $transport_id = wc_get_order_item_meta( $key, 'ID' );
        $start_date = wc_get_order_item_meta( $key, 'Start date' );
        $end_date = wc_get_order_item_meta( $key, 'End date' );
        $start_time = wc_get_order_item_meta( $key, 'Start time' );
        $end_time = wc_get_order_item_meta( $key, 'End time' );
    }

    if(tmbooking_check_data_in_db($transport_id, $start_date, $end_date, $start_time, $end_time, $order_id) == 0){
        tmbooking_insert_to_database($transport_id, $start_date, $end_date, $start_time, $end_time, $order_id);
    }

    //Add metabox
    if(isset($start_date) && $start_date != '' && isset($end_date) && $end_date != ''){
        $default_product_meta = get_post_meta($transport_id, '_tmbooking_data', true);

        $booking_settings = get_option('tm_booking_settings', true);
        $date_format = TMBooking__Helping_Addons::construct_date_format($booking_settings['date_format']);

        $startDate = DateTime::createFromFormat($date_format . ' H:i', $start_date . ' ' . $start_time);
        $endDate = DateTime::createFromFormat($date_format . ' H:i', $end_date . ' ' . $end_time);
        $booked_period = new DatePeriod(
            $startDate,
            new DateInterval('P1D'),
            $endDate
        );
        $booked_days = array();
        if(isset($default_product_meta) && !empty($default_product_meta)){
            foreach ($default_product_meta as $value){
                $booked_days[] .= $value;
            }
        }
        foreach ($booked_period as $key => $value) {
            $booked_days[] .= $value->format($date_format . ' H:i');
        }


        if($startDate->format($date_format) == $endDate->format($date_format)){
            $s = 1;
            $interval_time = $startDate->diff($endDate);
            $hours = $interval_time->h;
            if($hours == 0){
                $hours = 1;
            }
            while ($s <= $hours){
                $booked_days[] .= $startDate->format($date_format . ' H:i');
                $startDate->modify('+1 hour');
                $s++;
            }
        }


    }
    $booked_days = array_unique($booked_days);
    update_post_meta($transport_id, '_tmbooking_data', $booked_days);


}


//tmbooking_order database table functions
function tmbooking_insert_to_database($transport_id, $start_date, $end_date, $start_time, $end_time, $order_id){
    global $wpdb;
    
    // Validate input parameters
    if (empty($transport_id) || empty($start_date) || empty($end_date) || empty($order_id)) {
        error_log('TM Booking: Invalid parameters in tmbooking_insert_to_database');
        return false;
    }
    
    $booking_settings = get_option('tm_booking_settings', true);
    if (!is_array($booking_settings) || !isset($booking_settings['date_format'])) {
        error_log('TM Booking: Invalid booking settings in tmbooking_insert_to_database');
        return false;
    }
    
    $date_format = TMBooking__Helping_Addons::construct_date_format($booking_settings['date_format']);
    
    // Create DateTime objects with error checking
    $startDate = DateTime::createFromFormat($date_format . ' H:i', $start_date . ' ' . $start_time);
    $endDate = DateTime::createFromFormat($date_format . ' H:i', $end_date . ' ' . $end_time);
    
    // Check if DateTime creation was successful
    if ($startDate === false || $endDate === false) {
        error_log('TM Booking: Failed to parse dates in tmbooking_insert_to_database. Start: ' . $start_date . ' ' . $start_time . ', End: ' . $end_date . ' ' . $end_time . ', Format: ' . $date_format);
        return false;
    }

    $sql = $wpdb->prepare( "INSERT INTO {$wpdb->prefix}tmbooking_order (transport_id, start_date, end_date, order_id, status) VALUES (%d, %s, %s, %s, %s)", $transport_id, $startDate->format( 'Y-m-d H:i' ), $endDate->format( 'Y-m-d H:i' ), $order_id, "processing");
    $result = $wpdb->query($sql);
    
    if ($result === false) {
        error_log('TM Booking: Database insert failed in tmbooking_insert_to_database. Error: ' . $wpdb->last_error);
        return false;
    }
    
    return true;
}


//Check if has data
function tmbooking_check_data_in_db($transport_id, $start_date, $end_date, $start_time, $end_time, $order_id){
    global $wpdb;
    
    // Validate input parameters
    if (empty($transport_id) || empty($start_date) || empty($end_date) || empty($order_id)) {
        return 0;
    }
    
    $booking_settings = get_option('tm_booking_settings', true);
    if (!is_array($booking_settings) || !isset($booking_settings['date_format'])) {
        return 0;
    }
    
    $date_format = TMBooking__Helping_Addons::construct_date_format($booking_settings['date_format']);
    
    // Create DateTime objects with error checking
    $startDate = DateTime::createFromFormat($date_format . ' H:i', $start_date . ' ' . $start_time);
    $endDate = DateTime::createFromFormat($date_format . ' H:i', $end_date . ' ' . $end_time);
    
    // Check if DateTime creation was successful
    if ($startDate === false || $endDate === false) {
        error_log('TM Booking: Failed to parse dates in tmbooking_check_data_in_db. Start: ' . $start_date . ' ' . $start_time . ', End: ' . $end_date . ' ' . $end_time . ', Format: ' . $date_format);
        return 0;
    }

    $sql = $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->prefix}tmbooking_order WHERE transport_id = %d AND start_date = %s AND end_date = %s AND order_id = %d", $transport_id, $startDate->format( 'Y-m-d H:i' ), $endDate->format( 'Y-m-d H:i' ), $order_id);
    $data = $wpdb->get_var($sql);
    return intval($data);
}

