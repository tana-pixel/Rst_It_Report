<?php
/**
 * Telegram Notification Integration
 *
 * @package TM Booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class for handling Telegram notifications
 */
class TM_Booking_Telegram_Notification {
    /**
     * Constructor
     */
    public function __construct() {
        // Hook into booking creation
        add_action('tm_booking_after_create', array($this, 'send_booking_notification'), 10, 2);
    }
    
    /**
     * Send Telegram notification for new booking
     * 
     * @param int $order_id The WooCommerce order ID
     * @param array $order_data Optional order data
     */
    public function send_booking_notification($order_id, $order_data = null) {
        $booking_settings = get_option('tm_booking_settings', []);
        
        // Check if Telegram notifications are enabled
        if (!isset($booking_settings['telegram_enabled']) || $booking_settings['telegram_enabled'] !== 'yes') {
            return;
        }
        
        // Check if Telegram bot token and chat ID are set
        if (empty($booking_settings['telegram_bot_token']) || empty($booking_settings['telegram_chat_id'])) {
            // Log error if needed
            error_log('TM Booking: Telegram notification failed - missing bot token or chat ID');
            return;
        }
        
        // If we have order data from the hook, use it
        if ($order_data) {
            // Format booking details for Telegram message using order data
            $message = $this->format_booking_message_from_order($order_data);
        } else {
            // Fallback to getting order data directly
            $order = wc_get_order($order_id);
            if (!$order) {
                return;
            }
            
            // Format booking details for Telegram message
            $message = $this->format_booking_message_from_wc_order($order);
        }
        
        // Send Telegram message
        $this->send_telegram_message(
            $booking_settings['telegram_chat_id'], 
            $message, 
            $booking_settings['telegram_bot_token']
        );
    }
    
    /**
     * Format booking message from WooCommerce order data
     * 
     * @param array $order_data The order data
     * @return string Formatted message
     */
    private function format_booking_message_from_order($order_data) {
        $site_name = get_bloginfo('name');
        
        // Get customer details
        $customer_name = isset($order_data['customer']) ? 
            $order_data['customer']['first_name'] . ' ' . $order_data['customer']['last_name'] : 
            __('Unknown', 'tm-booking');
        $customer_email = isset($order_data['customer']) ? $order_data['customer']['email'] : '';
        $customer_phone = isset($order_data['customer']) ? $order_data['customer']['phone'] : '';
        
        // Get booking details
        $booking_data = isset($order_data['booking']) ? $order_data['booking'] : [];
        $booking_id = isset($booking_data['id']) ? $booking_data['id'] : __('Unknown', 'tm-booking');
        $start_date = isset($booking_data['start_date']) ? $booking_data['start_date'] : __('Unknown', 'tm-booking');
        $end_date = isset($booking_data['end_date']) ? $booking_data['end_date'] : __('Unknown', 'tm-booking');
        $start_time = isset($booking_data['start_time']) ? $booking_data['start_time'] : '';
        $end_time = isset($booking_data['end_time']) ? $booking_data['end_time'] : '';
        
        // Get product name
        $product_name = __('Unknown', 'tm-booking');
        if (isset($booking_data['id'])) {
            $product = get_post($booking_data['id']);
            if ($product) {
                $product_name = $product->post_title;
            }
        }
        
        // Format message
        $message = sprintf(
            /* translators: %s: site name */
            __('🔔 *Новое бронирование на %s*', 'tm-booking'),
            $site_name
        ) . "\n\n";
        
        $message .= sprintf(
            /* translators: %s: order ID */
            __('*Номер заказа:* %s', 'tm-booking'),
            $order_data['id']
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: product name */
            __('*Услуга:* %s', 'tm-booking'),
            $product_name
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %1$s: start date, %2$s: end date */
            __('*Даты:* %1$s - %2$s', 'tm-booking'),
            $start_date,
            $end_date
        ) . "\n";
        
        if (!empty($start_time) && !empty($end_time)) {
            $message .= sprintf(
                /* translators: %1$s: start time, %2$s: end time */
                __('*Время:* %1$s - %2$s', 'tm-booking'),
                $start_time,
                $end_time
            ) . "\n";
        }
        
        $message .= "\n" . __('*Информация о клиенте:*', 'tm-booking') . "\n";
        $message .= sprintf(
            /* translators: %s: customer name */
            __('*Имя:* %s', 'tm-booking'),
            $customer_name
        ) . "\n";
        
        if (!empty($customer_email)) {
            $message .= sprintf(
                /* translators: %s: customer email */
                __('*Email:* %s', 'tm-booking'),
                $customer_email
            ) . "\n";
        }
        
        if (!empty($customer_phone)) {
            $message .= sprintf(
                /* translators: %s: customer phone */
                __('*Телефон:* %s', 'tm-booking'),
                $customer_phone
            ) . "\n";
        }
        
        // Add order total if available
        if (isset($order_data['total'])) {
            $message .= "\n" . sprintf(
                /* translators: %s: order total */
                __('*Сумма заказа:* %s', 'tm-booking'),
                wc_price($order_data['total'])
            ) . "\n";
        }
        
        // Add admin link to view order
        $admin_url = admin_url('post.php?post=' . $order_data['id'] . '&action=edit');
        $message .= "\n" . sprintf(
            /* translators: %s: admin URL */
            __('*Ссылка на заказ:* [Открыть в админке](%s)', 'tm-booking'),
            $admin_url
        );
        
        return $message;
    }
    
    /**
     * Format booking message from WooCommerce order object
     * 
     * @param WC_Order $order The WooCommerce order object
     * @return string Formatted message
     */
    private function format_booking_message_from_wc_order($order) {
        $site_name = get_bloginfo('name');
        $order_id = $order->get_id();
        
        // Get customer details
        $customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
        $customer_email = $order->get_billing_email();
        $customer_phone = $order->get_billing_phone();
        
        // Get booking details from order items
        $booking_data = [];
        $product_name = __('Unknown', 'tm-booking');
        
        foreach ($order->get_items() as $item_id => $item) {
            $booking_data = $item->get_meta('tm_booking');
            if (!empty($booking_data)) {
                $product = $item->get_product();
                if ($product) {
                    $product_name = $product->get_name();
                }
                break;
            }
        }
        
        $start_date = isset($booking_data['start_date']) ? $booking_data['start_date'] : __('Unknown', 'tm-booking');
        $end_date = isset($booking_data['end_date']) ? $booking_data['end_date'] : __('Unknown', 'tm-booking');
        $start_time = isset($booking_data['start_time']) ? $booking_data['start_time'] : '';
        $end_time = isset($booking_data['end_time']) ? $booking_data['end_time'] : '';
        
        // Format message
        $message = sprintf(
            /* translators: %s: site name */
            __('🔔 *Новое бронирование на %s*', 'tm-booking'),
            $site_name
        ) . "\n\n";
        
        $message .= sprintf(
            /* translators: %s: order ID */
            __('*Номер заказа:* %s', 'tm-booking'),
            $order_id
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: product name */
            __('*Услуга:* %s', 'tm-booking'),
            $product_name
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %1$s: start date, %2$s: end date */
            __('*Даты:* %1$s - %2$s', 'tm-booking'),
            $start_date,
            $end_date
        ) . "\n";
        
        if (!empty($start_time) && !empty($end_time)) {
            $message .= sprintf(
                /* translators: %1$s: start time, %2$s: end time */
                __('*Время:* %1$s - %2$s', 'tm-booking'),
                $start_time,
                $end_time
            ) . "\n";
        }
        
        $message .= "\n" . __('*Информация о клиенте:*', 'tm-booking') . "\n";
        $message .= sprintf(
            /* translators: %s: customer name */
            __('*Имя:* %s', 'tm-booking'),
            $customer_name
        ) . "\n";
        
        if (!empty($customer_email)) {
            $message .= sprintf(
                /* translators: %s: customer email */
                __('*Email:* %s', 'tm-booking'),
                $customer_email
            ) . "\n";
        }
        
        if (!empty($customer_phone)) {
            $message .= sprintf(
                /* translators: %s: customer phone */
                __('*Телефон:* %s', 'tm-booking'),
                $customer_phone
            ) . "\n";
        }
        
        // Add order total
        $message .= "\n" . sprintf(
            /* translators: %s: order total */
            __('*Сумма заказа:* %s', 'tm-booking'),
            $order->get_formatted_order_total()
        ) . "\n";
        
        // Add admin link to view order
        $admin_url = admin_url('post.php?post=' . $order_id . '&action=edit');
        $message .= "\n" . sprintf(
            /* translators: %s: admin URL */
            __('*Ссылка на заказ:* [Открыть в админке](%s)', 'tm-booking'),
            $admin_url
        );
        
        return $message;
    }
    
    /**
     * Send Telegram message using Telegram Bot API
     * 
     * @param string $chat_id Telegram chat ID
     * @param string $message Message to send
     * @param string $bot_token Telegram bot token
     * @return bool Success or failure
     */
    private function send_telegram_message($chat_id, $message, $bot_token) {
        // Using Telegram Bot API
        $api_url = 'https://api.telegram.org/bot' . $bot_token . '/sendMessage';
        
        // Prepare the message data
        $data = array(
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'Markdown',
            'disable_web_page_preview' => true
        );
        
        // Send the request to Telegram API
        $response = wp_remote_post(
            $api_url,
            array(
                'body' => $data,
                'timeout' => 30,
            )
        );
        
        // Check for errors
        if (is_wp_error($response)) {
            error_log('TM Booking: Telegram API error - ' . $response->get_error_message());
            return false;
        }
        
        // Check response code
        $response_code = wp_remote_retrieve_response_code($response);
        if ($response_code !== 200) {
            $body = wp_remote_retrieve_body($response);
            error_log('TM Booking: Telegram API error - Response code: ' . $response_code . ', Body: ' . $body);
            return false;
        }
        
        return true;
    }
}

// Initialize the Telegram notification class
new TM_Booking_Telegram_Notification();
