<?php
/**
 * Fix for discount display and error handling
 *
 * @package TM Booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Добавляем метабокс для настройки отображения цены
 */
function tmbooking_add_price_display_metabox() {
    // Проверяем, что плагин букинга активен
    if (!class_exists('TMBooking__Helping_Addons')) {
        return;
    }
    // Метабокс Price Display Settings удален, так как вместо него используется настройка Show & Hide Booking form
    // (Price Display Settings metabox removed as Show & Hide Booking form setting is used instead)
}
add_action('add_meta_boxes', 'tmbooking_add_price_display_metabox');

/**
 * Add error handling and discount display fixes
 */
function tmbooking_discount_fixes() {
    // Fix for undefined array key "delivery" error
    add_filter('tmbooking_check_request_data', 'tmbooking_fix_request_data', 10, 1);
    
    // Add script to ensure discount info is always displayed
    add_action('wp_footer', 'tmbooking_add_discount_display_script');
    
    // Отладочные скрипты удалены, так как они больше не нужны
    // (Debug scripts removed as they are no longer needed)
}
add_action('init', 'tmbooking_discount_fixes');

/**
 * Fix request data to prevent undefined array key errors
 *
 * @param array $data Request data
 * @return array Fixed request data
 */
function tmbooking_fix_request_data($data) {
    // Make sure all required keys exist
    if (!isset($data['delivery'])) {
        $data['delivery'] = '';
    }
    
    if (!isset($data['extra_ids'])) {
        $data['extra_ids'] = '';
    }
    
    return $data;
}

/**
 * Add scripts to ensure discount info is always displayed
 */
function tmbooking_add_discount_display_script() {
    if (!is_admin()) {
        // Enqueue the discount persistence script
        wp_enqueue_script(
            'tmbooking-discount-persist',
            plugin_dir_url(__FILE__) . 'discount-persist.js',
            array('jquery'),
            '1.0.0',
            true
        );
        
        // Отладочный блок отключен
        // (Debug block is disabled)
        if (false && is_singular('pixad-autos')) {
            global $post;
            
            // Проверяем, доступен ли плагин TM Booking
            // (Check if TM Booking plugin is available)
            $booking_plugin_active = class_exists('TMBooking__Helping_Addons');
            
            // Получаем настройку из метаполя
            // (Get setting from meta field)
            $pixad_auto_booking_button = get_post_meta($post->ID, 'pixad_auto_booking_button', true);
            
            // Проверяем значение метаполя (Check meta field value)
            // 0 = Hide, 1 = Show, '' (пусто) = по умолчанию Show
            $show_booking_form = true; // По умолчанию показываем (Default is show)
            
            // Если явно указано "Hide" (0), то скрываем
            // (If explicitly set to "Hide" (0), then hide)
            if ($pixad_auto_booking_button === '0') {
                $show_booking_form = false;
                error_log('DEBUG - Booking form hidden by meta setting: ' . $pixad_auto_booking_button);
            }
            
            // Проверяем настройку темы
            // (Check theme setting)
            $theme_booking_setting = 'show';
            if (function_exists('get_theme_mod')) {
                $theme_booking_setting = get_theme_mod('booking_car', 'show');
                if ($theme_booking_setting !== 'show') {
                    $show_booking_form = false;
                    error_log('DEBUG - Booking form hidden by theme setting: ' . $theme_booking_setting);
                }
            }
            
            // Подключаем скрипт отладки
            // (Enqueue debug script)
            wp_enqueue_script(
                'tmbooking-booking-debug',
                plugin_dir_url(dirname(__FILE__)) . 'function/booking-debug.js',
                array('jquery'),
                '1.0.0',
                true
            );
            
            // Передаем данные в скрипт
            // (Pass data to script)
            wp_localize_script(
                'tmbooking-booking-debug',
                'bookingDebugData',
                array(
                    'postId' => $post->ID,
                    'showBookingForm' => $show_booking_form,
                    'metaSetting' => $pixad_auto_booking_button,
                    'themeSetting' => $theme_booking_setting,
                    'pluginActive' => $booking_plugin_active
                )
            );
        }
    }
}

/**
 * Register and enqueue scripts and styles
 */
function tmbooking_register_frontend_assets() {
    // Register the discount persistence script
    wp_register_script(
        'tmbooking-discount-persist',
        plugin_dir_url(__FILE__) . 'discount-persist.js',
        array('jquery'),
        '1.0.0',
        true
    );
    
    // Register frontend styles - отключено из-за отсутствия файла
    /*
    wp_register_style(
        'tmbooking-frontend',
        plugin_dir_url(dirname(dirname(__FILE__))) . 'assets/css/tmbooking.css',
        array(),
        '1.0.0'
    );
    */
    
    // Создаем встроенные стили вместо отсутствующего файла
    wp_register_style('tmbooking-frontend-inline', false);
    wp_enqueue_style('tmbooking-frontend-inline');
    wp_add_inline_style('tmbooking-frontend-inline', '
        .tm-discount-block {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #eee;
            background-color: #f9f9f9;
        }
        .tm-discount-amount {
            font-weight: bold;
            color: #e74c3c;
        }
    ');
    
    // Enqueue on frontend only
    if (!is_admin()) {
        wp_enqueue_script('tmbooking-discount-persist');
        // wp_enqueue_style('tmbooking-frontend'); - отключено
    }
}
add_action('wp_enqueue_scripts', 'tmbooking_register_frontend_assets');

/**
 * Fix for tmbooking_change_price_by_dr_location function
 * 
 * @param float $price Current price
 * @param string $delivery Delivery option
 * @return float Modified price
 */
function tmbooking_change_price_by_dr_location_fixed($price, $delivery) {
    // Make sure delivery is not empty
    if (empty($delivery)) {
        return $price;
    }
    
    return tmbooking_change_price_by_dr_location($price, $delivery);
}

// Apply our fixes to the AJAX request
add_action('wp_ajax_tmbooking_change_total', 'tmbooking_fix_ajax_request', 1);
add_action('wp_ajax_nopriv_tmbooking_change_total', 'tmbooking_fix_ajax_request', 1);

/**
 * Fix AJAX request data before processing
 */
function tmbooking_fix_ajax_request() {
    if (isset($_REQUEST['data'])) {
        // Apply fixes to request data
        $_REQUEST['data'] = tmbooking_fix_request_data($_REQUEST['data']);
    }
}

/**
 * Шорткод для вывода списка скидок
 * Использование: [tm_booking_discounts product_id="123" layout="list|grid|simple"]
 *
 * @param array $atts Атрибуты шорткода
 * @return string HTML-код списка скидок
 */
function tm_booking_discounts_shortcode($atts) {
    // Проверяем настройку отображения скидок
    $booking_settings = get_option('tm_booking_settings', []);
    if (isset($booking_settings['show_discounts']) && $booking_settings['show_discounts'] === 'no') {
        return ''; // Если скидки отключены, возвращаем пустую строку
    }
    
    // Получаем параметры шорткода
    $atts = shortcode_atts(array(
        'product_id' => 0,       // ID товара
        'id' => 0,              // Альтернативный параметр для ID товара
        'layout' => 'list',      // Тип отображения: list, grid, simple
        'title' => esc_html__('Available Discounts', 'tm-booking'), // Заголовок блока
        'show_title' => 'yes',   // Показывать заголовок: yes, no
    ), $atts, 'tm_booking_discounts');
    
    // Проверяем ID товара (поддерживаем как product_id, так и id)
    $product_id = intval($atts['product_id']);
    if ($product_id <= 0 && intval($atts['id']) > 0) {
        $product_id = intval($atts['id']);
    }
    if ($product_id <= 0) {
        // Если ID товара не указан, пытаемся получить ID текущего товара
        global $post;
        if ($post && $post->post_type === 'transports') {
            $product_id = $post->ID;
        } else {
            return ''; // Не удалось определить ID товара
        }
    }
    
    // Получаем все скидки для данного товара
    $discounts = get_the_terms($product_id, 'transports-discount');
    
    // Если скидок нет, возвращаем пустую строку
    if (empty($discounts) || is_wp_error($discounts)) {
        return '';
    }
    
    // Начинаем формировать HTML
    $output = '<div class="tm-booking-discounts-list">';
    
    // Добавляем заголовок, если нужно
    if ($atts['show_title'] === 'yes' && !empty($atts['title'])) {
        $output .= '<h3 class="tm-booking-discounts-title">' . esc_html($atts['title']) . '</h3>';
    }
    
    // Определяем класс для контейнера в зависимости от выбранного макета
    $container_class = 'tm-booking-discounts-container';
    if ($atts['layout'] === 'grid') {
        $container_class .= ' tm-booking-discounts-grid';
    } elseif ($atts['layout'] === 'simple') {
        $container_class .= ' tm-booking-discounts-simple';
    } else {
        $container_class .= ' tm-booking-discounts-list';
    }
    
    $output .= '<div class="' . esc_attr($container_class) . '">';
    
    // Перебираем все скидки
    foreach ($discounts as $discount) {
        // Получаем процент скидки
        $discount_percent = tmbooking_get_term_metabox('discount_percent', $discount->term_id);
        
        // Если процент скидки не указан, пропускаем
        if (empty($discount_percent)) {
            continue;
        }
        
        // Получаем день начала скидки
        $start_day = tmbooking_get_term_metabox('start_day', $discount->term_id);
        
        // Формируем HTML для скидки в зависимости от выбранного макета
        if ($atts['layout'] === 'simple') {
            // Простой макет - только название и процент
            $output .= '<div class="tm-booking-discount-item tm-booking-discount-simple">';
            $output .= '<span class="tm-booking-discount-name">' . esc_html($discount->name) . '</span>';
            $output .= '<span class="tm-booking-discount-percent">' . esc_html($discount_percent) . '%</span>';
            $output .= '</div>';
        } else {
            // Стандартный макет (list или grid)
            $output .= '<div class="tm-booking-discount-item">';
            
            // Создаем иконку скидки
            $output .= '<div class="tm-booking-discount-icon">%</div>';
            
            $output .= '<div class="tm-booking-discount-content">';
            $output .= '<div class="tm-booking-discount-header">';
            $output .= '<span class="tm-booking-discount-name">' . esc_html($discount->name) . '</span>';
            $output .= '<span class="tm-booking-discount-percent">' . esc_html($discount_percent) . '%</span>';
            $output .= '</div>';
            
            // Добавляем информацию о дне начала скидки, если он указан
            if (!empty($start_day) && intval($start_day) > 0) {
                $output .= '<div class="tm-booking-discount-details">';
                $output .= '<span class="tm-booking-discount-start-day">' . 
                           sprintf(esc_html__('Available from day %s', 'tm-booking'), intval($start_day)) . 
                           '</span>';
                $output .= '</div>';
            }
            
            // Добавляем описание скидки, если оно есть
            if (!empty($discount->description)) {
                $output .= '<div class="tm-booking-discount-description">' . esc_html($discount->description) . '</div>';
            }
            
            $output .= '</div>'; // Закрываем tm-booking-discount-content
            $output .= '</div>'; // Закрываем tm-booking-discount-item
        }
    }
    
    $output .= '</div>'; // Закрываем контейнер
    $output .= '</div>'; // Закрываем основной блок
    
    // Добавляем стили для списка скидок
    $output .= '<style>
        .tm-booking-discounts-list {
            margin: 20px 0;
        }
        .tm-booking-discounts-title {
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .tm-booking-discounts-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .tm-booking-discounts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
        }
        .tm-booking-discount-item {
            display: flex;
            align-items: flex-start;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 4px;
        }
        .tm-booking-discount-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            background-color: #e44;
            color: white;
            border-radius: 50%;
            font-weight: bold;
            margin-right: 10px;
            flex-shrink: 0;
        }
        .tm-booking-discount-content {
            flex: 1;
        }
        .tm-booking-discount-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }
        .tm-booking-discount-name {
            font-weight: bold;
            font-size: 15px;
            color: #333;
        }
        .tm-booking-discount-percent {
            font-weight: bold;
            color: #e44;
            font-size: 15px;
        }
        .tm-booking-discount-details {
            font-size: 13px;
            color: #666;
            margin-bottom: 5px;
        }
        .tm-booking-discount-description {
            font-size: 13px;
            color: #555;
        }
        .tm-booking-discount-simple {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            background-color: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 4px;
        }
    </style>';
    
    return $output;
}

// Регистрируем шорткод
add_shortcode('tm_booking_discounts', 'tm_booking_discounts_shortcode');
