<?php
/**
 * TM Booking Calendar Class
 *
 * @package TM_Booking
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * TM_Booking_Calendar class
 */
class TM_Booking_Calendar {
    private static $table_name = 'tm_bookings';

    public static function install() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . self::$table_name;
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            order_id bigint(20) unsigned NOT NULL,
            product_id bigint(20) unsigned NOT NULL,
            start_date datetime NOT NULL,
            end_date datetime NOT NULL,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY order_product (order_id, product_id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * Constructor
     */
    public function __construct() {
        self::install(); // Ensure table exists
        add_action( 'admin_menu', array( $this, 'add_calendar_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_calendar_scripts' ) );
        add_action( 'wp_ajax_tm_booking_get_calendar_events', array( $this, 'get_calendar_events' ) );
        add_action( 'woocommerce_checkout_order_processed', array( $this, 'save_booking_data' ) );
        add_action( 'woocommerce_order_status_changed', array( $this, 'update_booking_data' ), 10, 3 );
    }

    /**
     * Add calendar menu item
     */
    public function add_calendar_menu() {

        add_submenu_page(
            'woocommerce',
            __( 'Booking Calendar', 'tm-booking' ),
            __( 'Booking Calendar', 'tm-booking' ),
            'manage_woocommerce',
            'tm-booking-calendar',
            array( $this, 'render_calendar_page' )
        );
    }
    /**
     * Enqueue calendar scripts and styles
     */
    /**
     * Save booking data to database when order is created
     */
    /**
     * Сохраняет данные бронирования в базу данных при создании заказа
     * Saves booking data to database when order is created
     * 
     * @param int $order_id ID заказа
     */
    public function save_booking_data($order_id) {
        global $wpdb;

        $order = wc_get_order($order_id);
        if (!$order) return;

        foreach ($order->get_items() as $item_id => $item) {
            $product = $item->get_product();
            if (!$product) continue;

            $start_date = wc_get_order_item_meta($item_id, 'Start date');
            $start_time = wc_get_order_item_meta($item_id, 'Start time');
            $end_date = wc_get_order_item_meta($item_id, 'End date');
            $end_time = wc_get_order_item_meta($item_id, 'End time');

            if ($start_date) {
                $table_name = $wpdb->prefix . self::$table_name;
                
                // Если есть время, используем его, иначе используем полночь
                // If we have time, use it, otherwise use midnight
                if ($start_time) {
                    $start_datetime = date('Y-m-d H:i:s', strtotime("$start_date $start_time"));
                } else {
                    $start_datetime = date('Y-m-d H:i:s', strtotime("$start_date 00:00:00"));
                }
                
                // Аналогично для даты окончания
                // Same for end date
                if ($end_date && $end_time) {
                    $end_datetime = date('Y-m-d H:i:s', strtotime("$end_date $end_time"));
                } elseif ($end_date) {
                    $end_datetime = date('Y-m-d H:i:s', strtotime("$end_date 23:59:59"));
                } else {
                    // Если нет даты окончания, используем дату начала + 1 день
                    // If no end date, use start date + 1 day
                    $end_datetime = date('Y-m-d H:i:s', strtotime("$start_date +1 day"));
                }

                // Сохраняем данные в базу данных
                // Save data to database
                $result = $wpdb->replace(
                    $table_name,
                    array(
                        'order_id' => $order_id,
                        'product_id' => $product->get_id(),
                        'start_date' => $start_datetime,
                        'end_date' => $end_datetime
                    ),
                    array('%d', '%d', '%s', '%s')
                );
                
                // Логируем результат для отладки
                // Log result for debugging
                error_log(sprintf(
                    /* translators: 1: Order ID, 2: Product ID, 3: Start date, 4: End date, 5: Result */
                    __('TM Booking: Saved booking data for order %1$d, product %2$d, start: %3$s, end: %4$s. Result: %5$s', 'tm-booking'),
                    $order_id,
                    $product->get_id(),
                    $start_datetime,
                    $end_datetime,
                    $result ? 'success' : 'failed'
                ));
            }
        }
    }

    /**
     * Update booking data when order status changes
     */
    public function update_booking_data($order_id, $old_status, $new_status) {
        $this->save_booking_data($order_id);
    }

    public function enqueue_calendar_scripts( $hook ) {
        if ( 'woocommerce_page_tm-booking-calendar' !== $hook ) {
            return;
        }

        // Core styles
        wp_enqueue_style('tm-booking-fullcalendar', 'https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/main.min.css', array(), '6.1.10');
        wp_enqueue_style('tm-booking-daygrid', 'https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.10/main.min.css', array(), '6.1.10');
        wp_enqueue_style('tm-booking-multimonth', 'https://cdn.jsdelivr.net/npm/@fullcalendar/multimonth@6.1.10/main.min.css', array(), '6.1.10');
        wp_enqueue_style('tm-booking-admin-calendar', TMBOOKING_THEME_HELPER_URL . 'assets/css/admin-calendar.css', array('tm-booking-fullcalendar'), '1.0.0');

        // Core and plugins
        wp_enqueue_script('tm-booking-fullcalendar-core', 'https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/index.global.min.js', array('jquery'), '6.1.10', true);
        wp_enqueue_script('tm-booking-fullcalendar-daygrid', 'https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.10/index.global.min.js', array('tm-booking-fullcalendar-core'), '6.1.10', true);
        wp_enqueue_script('tm-booking-fullcalendar-multimonth', 'https://cdn.jsdelivr.net/npm/@fullcalendar/multimonth@6.1.10/index.global.min.js', array('tm-booking-fullcalendar-core'), '6.1.10', true);
        
        // Custom calendar script
        wp_enqueue_script('tm-booking-calendar', TMBOOKING_THEME_HELPER_URL . 'assets/js/calendar.js', array('tm-booking-fullcalendar-core', 'tm-booking-fullcalendar-daygrid', 'tm-booking-fullcalendar-multimonth'), '1.0.0', true);
        wp_localize_script('tm-booking-calendar', 'tmBookingCalendar', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('tm-booking-calendar-nonce'),
        ));
    }

    /**
     * Получает статистику бронирований
     * Get booking statistics
     * 
     * @return array Статистика бронирований
     */
    private function get_booking_statistics() {
        $stats = array(
            'total' => 0,
            'active' => 0,
            'completed' => 0,
            'upcoming' => 0,
            'by_status' => array()
        );
        
        // Получаем все заказы
        // Get all orders
        $args = array(
            'post_type' => 'shop_order',
            'post_status' => array_keys( wc_get_order_statuses() ),
            'posts_per_page' => -1,
        );
        
        $orders = wc_get_orders( $args );
        $stats['total'] = count($orders);
        $today = current_time('timestamp');
        $statuses = wc_get_order_statuses();
        
        // Инициализируем счетчики по статусам
        // Initialize status counters
        foreach ($statuses as $status_key => $status_label) {
            $status = str_replace('wc-', '', $status_key);
            $stats['by_status'][$status] = array(
                'count' => 0,
                'label' => $status_label
            );
        }
        

        
        // Обрабатываем каждый заказ
        // Process each order
        foreach ($orders as $order) {
            $status = $order->get_status();
            
            // Увеличиваем счетчик для статуса
            // Increment status counter
            if (isset($stats['by_status'][$status])) {
                $stats['by_status'][$status]['count']++;
            }
            
            // Активные заказы (в обработке или ожидании)
            // Active orders (processing or on-hold)
            if (in_array($status, array('processing', 'on-hold', 'pending'))) {
                $stats['active']++;
            }
            
            // Завершенные заказы
            // Completed orders
            if ($status === 'completed') {
                $stats['completed']++;
            }
            
            // Обрабатываем каждый товар в заказе
            // Process each item in order
            foreach ($order->get_items() as $item) {
                $product = $item->get_product();
                if (!$product) continue;
                
                // Получаем дату начала бронирования
                // Get booking start date
                $start_date = $item->get_meta('Start date');
                if (!$start_date) continue;
                
                $start_time = $item->get_meta('Start time');
                if ($start_time) {
                    $booking_start = strtotime("$start_date $start_time");
                } else {
                    $booking_start = strtotime("$start_date 00:00:00");
                }
                
                // Предстоящие бронирования (дата начала в будущем)
                // Upcoming bookings (start date in the future)
                if ($booking_start > $today) {
                    $stats['upcoming']++;
                }
                

            }
        }
        
        return $stats;
    }

    /**
     * Render calendar page
     */
    public function render_calendar_page() {
        // Получаем статистику
        // Get statistics
        $stats = $this->get_booking_statistics();
        ?>
        <div class="wrap tm-booking-calendar-wrap">
            <h1><?php echo esc_html__( 'Booking Calendar', 'tm-booking' ); ?></h1>
            
            <!-- Статистика бронирований -->
            <!-- Booking statistics -->
            <div class="tm-booking-stats">
                <div class="tm-booking-stats-row">
                    <!-- Основная статистика -->
                    <!-- Main statistics -->
                    <div class="tm-booking-stats-card tm-booking-stats-total">
                        <div class="tm-booking-stats-value"><?php echo esc_html($stats['total']); ?></div>
                        <div class="tm-booking-stats-label"><?php echo esc_html__('Total Bookings', 'tm-booking'); ?></div>
                    </div>
                    
                    <div class="tm-booking-stats-card tm-booking-stats-active">
                        <div class="tm-booking-stats-value"><?php echo esc_html($stats['active']); ?></div>
                        <div class="tm-booking-stats-label"><?php echo esc_html__('Active', 'tm-booking'); ?></div>
                    </div>
                    
                    <div class="tm-booking-stats-card tm-booking-stats-completed">
                        <div class="tm-booking-stats-value"><?php echo esc_html($stats['completed']); ?></div>
                        <div class="tm-booking-stats-label"><?php echo esc_html__('Completed', 'tm-booking'); ?></div>
                    </div>
                    
                    <div class="tm-booking-stats-card tm-booking-stats-upcoming">
                        <div class="tm-booking-stats-value"><?php echo esc_html($stats['upcoming']); ?></div>
                        <div class="tm-booking-stats-label"><?php echo esc_html__('Upcoming', 'tm-booking'); ?></div>
                    </div>
                </div>
            </div>
            
            <div id="tm-booking-calendar"></div>
        </div>
        <?php
    }

    /**
     * Get calendar events via AJAX
     */
    /**
     * Получает события календаря через AJAX
     * Get calendar events via AJAX
     */
    public function get_calendar_events() {
        check_ajax_referer( 'tm-booking-calendar-nonce', 'nonce' );

        $start = sanitize_text_field( $_GET['start'] ?? '' );
        $end = sanitize_text_field( $_GET['end'] ?? '' );
        $view = sanitize_text_field( $_GET['view'] ?? 'dayGridMonth' );

        $args = array(
            'post_type' => 'shop_order',
            'post_status' => array_keys( wc_get_order_statuses() ),
            'posts_per_page' => -1,
        );

        $orders = wc_get_orders( $args );
        $events = array();
        $debug = array();

        foreach ( $orders as $order ) {
            $status = $order->get_status();
            $order_number = $order->get_order_number();
            $customer_name = $order->get_billing_first_name();
            $city = $order->get_billing_city();
            
            // Get status label
            $statuses = wc_get_order_statuses();
            $status_label = isset($statuses['wc-' . $status]) ? str_replace('wc-', '', $statuses['wc-' . $status]) : ucfirst($status);
            
            // Debug order info
            $debug_order = array(
                'order_id' => $order->get_id(),
                'order_number' => $order_number,
                'status' => $status,
                'meta' => array()
            );
            
            // Get all meta data for debugging
            $meta_data = $order->get_meta_data();
            foreach ($meta_data as $meta) {
                $debug_order['meta'][$meta->key] = $meta->value;
            }
            
            // Process each item in order
            foreach ($order->get_items() as $item) {
                $product = $item->get_product();
                if (!$product) continue;
                
                $debug_order['items'][] = array(
                    'item_id' => $item->get_id(),
                    'product_id' => $product->get_id(),
                    'name' => $item->get_name(),
                    'meta' => $item->get_meta_data()
                );
                
                global $wpdb;
                
                // Get booking data from tm_bookings table
                $table_name = $wpdb->prefix . self::$table_name;
                $booking_data = $wpdb->get_row($wpdb->prepare(
                    "SELECT * FROM $table_name 
                    WHERE order_id = %d AND product_id = %d",
                    $order->get_id(), $product->get_id()
                ));

                // If booking data found in the database, save it to the order meta
                if ($booking_data && isset($booking_data->start_date)) {
                    $start_date = date('m/d/Y', strtotime($booking_data->start_date));
                    $start_time = date('H:i', strtotime($booking_data->start_date));
                    $end_date = date('m/d/Y', strtotime($booking_data->end_date));
                    $end_time = date('H:i', strtotime($booking_data->end_date));
                    
                    wc_update_order_item_meta($item->get_id(), 'Start date', $start_date);
                    wc_update_order_item_meta($item->get_id(), 'Start time', $start_time);
                    wc_update_order_item_meta($item->get_id(), 'End date', $end_date);
                    wc_update_order_item_meta($item->get_id(), 'End time', $end_time);
                }
                
                // Debug data
                $debug_order['booking_data'] = $booking_data;
                $debug_order['order_id'] = $order->get_id();
                $debug_order['product_id'] = $product->get_id();
                
                // Get start date from booking data
                $booking_start = null;
                if ($booking_data && isset($booking_data->start_date)) {
                    $booking_start = $booking_data->start_date;
                    $debug_order['found_in'] = 'tm_bookings table';
                }
                
                // If not found in bookings table, try meta
                if (!$booking_start) {
                    // First check for 'Start date' directly as it's the most common
                    $start_date = $item->get_meta('Start date');
                    $start_time = $item->get_meta('Start time');
                    
                    if ($start_date) {
                        // If we have both date and time, combine them
                        if ($start_time) {
                            $booking_start = date('Y-m-d H:i:s', strtotime("$start_date $start_time"));
                        } else {
                            // If we only have date, use midnight
                            $booking_start = date('Y-m-d H:i:s', strtotime("$start_date 00:00:00"));
                        }
                        $debug_order['found_in'] = 'item_meta: Start date';
                    }
                    
                    // If still not found, try other meta keys
                    if (!$booking_start) {
                        $meta_keys = array(
                            '_booking_start',
                            '_booking_start_date',
                            '_booking_date',
                            'booking_start_date'
                        );
                        
                        // Try item meta first
                        foreach ($meta_keys as $key) {
                            $value = $item->get_meta($key);
                            if ($value) {
                                $booking_start = $value;
                                $debug_order['found_in'] = 'item_meta: ' . $key;
                                break;
                            }
                        }
                    }
                    
                    // Then try order meta
                    if (!$booking_start) {
                        foreach ($meta_keys as $key) {
                            $value = get_post_meta($order->get_id(), $key, true);
                            if ($value) {
                                $booking_start = $value;
                                $debug_order['found_in'] = 'order_meta: ' . $key;
                                break;
                            }
                        }
                    }
                }
                
                // Проверяем метаданные 'Start date' напрямую, так как это наиболее распространенный вариант
                // Check 'Start date' metadata directly as it's the most common case
                if (!$booking_start) {
                    $start_date_meta = $item->get_meta('Start date', true);
                    $start_time_meta = $item->get_meta('Start time', true);
                    
                    if ($start_date_meta) {
                        if ($start_time_meta) {
                            $booking_start = date('Y-m-d H:i:s', strtotime("$start_date_meta $start_time_meta"));
                        } else {
                            $booking_start = date('Y-m-d H:i:s', strtotime("$start_date_meta 00:00:00"));
                        }
                        $debug_order['found_in'] = 'direct_meta: Start date';
                    }
                }
                
                // В крайнем случае используем дату создания заказа
                // As a last resort, use order creation date
                if (!$booking_start) {
                    $booking_start = $order->get_date_created()->format('Y-m-d H:i:s');
                    $debug_order['using_fallback'] = true;
                }
                
                // Get start and end times
                $start_time = $item->get_meta('Start time');
                $end_time = $item->get_meta('End time');
                $time_info = '';
                if ($start_time && $end_time) {
                    $time_info = sprintf(
                        /* translators: 1: Start time, 2: End time */
                        __('%1$s - %2$s', 'tm-booking'),
                        esc_html($start_time),
                        esc_html($end_time)
                    );
                }

                // Format order info
                $title = sprintf(
                    "%s\n%s\n%s\n%s",
                    sprintf(
                        /* translators: 1: Order number, 2: Status */
                        __('# %1$s | %2$s', 'tm-booking'),
                        esc_html($order_number),
                        esc_html(strtoupper($status_label))
                    ),
                    esc_html($item->get_name()),
                    sprintf(
                        /* translators: 1: Customer name, 2: City */
                        __('%1$s | %2$s', 'tm-booking'),
                        esc_html($customer_name),
                        esc_html($city)
                    ),
                    $time_info
                );
                
                // Преобразуем дату начала бронирования в timestamp
                // Convert booking start date to timestamp
                $event_start = strtotime($booking_start);
                
                // Получаем дату окончания бронирования, если она есть
                // Get booking end date if available
                $booking_end = null;
                $end_date_meta = $item->get_meta('End date', true);
                $end_time_meta = $item->get_meta('End time', true);
                
                if ($end_date_meta) {
                    if ($end_time_meta) {
                        $booking_end = date('Y-m-d\TH:i:s', strtotime("$end_date_meta $end_time_meta"));
                    } else {
                        $booking_end = date('Y-m-d\TH:i:s', strtotime("$end_date_meta 23:59:59"));
                    }
                }
                
                $event_id = absint($order->get_id()) . '-' . absint($item->get_id());
                $event_url = esc_url($order->get_edit_order_url());
                $event_class = 'order-status-' . sanitize_html_class($status);

                // Создаем событие календаря
                // Create calendar event
                $event = array(
                    'id' => $event_id,
                    'title' => $title,
                    'start' => date('Y-m-d\TH:i:s', $event_start),
                    'url' => $event_url,
                    'backgroundColor' => $this->get_status_color($status),
                    'borderColor' => 'transparent',
                    'className' => $event_class,
                    'textColor' => $this->get_status_text_color($status)
                );
                
                // Добавляем дату окончания только если это не годовое представление
                // Add end date only if not in year view
                if ($booking_end && $view !== 'multiMonth') {
                    $event['end'] = $booking_end;
                }
                
                $events[] = $event;
            }
            
            $debug[] = $debug_order;
        }

        // Log debug info to error log
        error_log('TM Booking Calendar Debug: ' . print_r($debug, true));
        
        // Send only events array for FullCalendar
        wp_send_json($events);
    }

    /**
     * Get color for order status
     *
     * @param string $status Order status
     * @return string Color hex code
     */
    /**
     * Get background color for order status
     *
     * @param string $status Order status
     * @return string Color hex code
     */
    private function get_status_color( $status ) {
        $colors = array(
            'pending' => '#f0f0f0',    // Светло-серый
            'processing' => '#c6e1c6', // Зеленый
            'on-hold' => '#f8dda7',   // Желтый
            'completed' => '#c8d7e1',  // Синий
            'cancelled' => '#eba3a3',  // Красный
            'refunded' => '#e5e5e5',   // Серый
            'failed' => '#eba3a3',     // Красный
        );

        return isset( $colors[ $status ] ) ? $colors[ $status ] : '#e5e5e5';
    }

    /**
     * Get text color for order status
     *
     * @param string $status Order status
     * @return string Color hex code
     */
    private function get_status_text_color( $status ) {
        $colors = array(
            'pending' => '#777777',    // Темно-серый
            'processing' => '#2c472c', // Темно-зеленый
            'on-hold' => '#94660c',   // Темно-желтый
            'completed' => '#2e4453',  // Темно-синий
            'cancelled' => '#761919',  // Темно-красный
            'refunded' => '#777777',   // Темно-серый
            'failed' => '#761919',     // Темно-красный
        );

        return isset( $colors[ $status ] ) ? $colors[ $status ] : '#777777';
    }
}

// Initialize the calendar
// Calendar is initialized in the main plugin class
