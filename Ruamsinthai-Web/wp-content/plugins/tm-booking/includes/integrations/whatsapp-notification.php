<?php
/**
 * WhatsApp Notification Integration
 *
 * @package TM Booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class for handling WhatsApp notifications
 */
class TM_Booking_WhatsApp_Notification {
    /**
     * Constructor
     */
    public function __construct() {
        // Hook into booking creation
        add_action('tm_booking_after_create', array($this, 'send_booking_notification'), 10, 2);
    }
    
    /**
     * Send WhatsApp notification for new booking
     * 
     * @param int $order_id The WooCommerce order ID
     * @param array $order_data Optional order data
     */
    public function send_booking_notification($order_id, $order_data = null) {
        $booking_settings = get_option('tm_booking_settings', []);
        
        // Check if WhatsApp notifications are enabled
        if (!isset($booking_settings['whatsapp_enabled']) || $booking_settings['whatsapp_enabled'] !== 'yes') {
            return;
        }
        
        // Check if WhatsApp number and API key are set
        if (empty($booking_settings['whatsapp_number']) || empty($booking_settings['whatsapp_api_key'])) {
            // Log error if needed
            error_log('TM Booking: WhatsApp notification failed - missing number or API key');
            return;
        }
        
        // If we have order data from the hook, use it
        if ($order_data) {
            // Format booking details for WhatsApp message using order data
            $message = $this->format_booking_message_from_order($order_data);
        } else {
            // Fallback to getting order data directly
            $order = wc_get_order($order_id);
            if (!$order) {
                return;
            }
            
            // Format booking details for WhatsApp message
            $message = $this->format_booking_message_from_wc_order($order);
        }
        
        // Send WhatsApp message
        $this->send_whatsapp_message($booking_settings['whatsapp_number'], $message, $booking_settings['whatsapp_api_key']);
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
        $customer_name = $order_data['customer']['first_name'] . ' ' . $order_data['customer']['last_name'];
        $customer_email = $order_data['customer']['email'];
        $customer_phone = $order_data['customer']['phone'];
        
        // Get booking details
        $booking_data = $order_data['booking'];
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
            /* translators: %s: booking date */
            __('*Дата начала:* %s', 'tm-booking'),
            $start_date . ($start_time ? ' ' . $start_time : '')
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: booking date */
            __('*Дата окончания:* %s', 'tm-booking'),
            $end_date . ($end_time ? ' ' . $end_time : '')
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: order total */
            __('*Сумма:* %s', 'tm-booking'),
            wc_price($order_data['total'])
        ) . "\n\n";
        
        $message .= __('*Данные клиента:*', 'tm-booking') . "\n";
        $message .= sprintf(
            /* translators: %s: customer name */
            __('Имя: %s', 'tm-booking'),
            $customer_name
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: customer email */
            __('Email: %s', 'tm-booking'),
            $customer_email
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: customer phone */
            __('Телефон: %s', 'tm-booking'),
            $customer_phone
        ) . "\n\n";
        
        $message .= sprintf(
            /* translators: %s: admin URL */
            __('Посмотреть детали: %s', 'tm-booking'),
            admin_url('post.php?post=' . $order_data['id'] . '&action=edit')
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
        
        // Get customer details
        $customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
        $customer_email = $order->get_billing_email();
        $customer_phone = $order->get_billing_phone();
        
        // Get booking details from order items
        $booking_data = null;
        $product_name = __('Unknown', 'tm-booking');
        
        foreach ($order->get_items() as $item_id => $item) {
            $cart_item_data = $item->get_meta('tm_booking');
            if (!empty($cart_item_data)) {
                $booking_data = $cart_item_data;
                $product_name = $item->get_name();
                break;
            }
        }
        
        if (!$booking_data) {
            return sprintf(
                /* translators: %1$s: site name, %2$s: order ID */
                __('🔔 *Новый заказ #%2$s на %1$s*', 'tm-booking'),
                $site_name,
                $order->get_id()
            );
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
            $order->get_id()
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: product name */
            __('*Услуга:* %s', 'tm-booking'),
            $product_name
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: booking date */
            __('*Дата начала:* %s', 'tm-booking'),
            $start_date . ($start_time ? ' ' . $start_time : '')
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: booking date */
            __('*Дата окончания:* %s', 'tm-booking'),
            $end_date . ($end_time ? ' ' . $end_time : '')
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: order total */
            __('*Сумма:* %s', 'tm-booking'),
            $order->get_formatted_order_total()
        ) . "\n\n";
        
        $message .= __('*Данные клиента:*', 'tm-booking') . "\n";
        $message .= sprintf(
            /* translators: %s: customer name */
            __('Имя: %s', 'tm-booking'),
            $customer_name
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: customer email */
            __('Email: %s', 'tm-booking'),
            $customer_email
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: customer phone */
            __('Телефон: %s', 'tm-booking'),
            $customer_phone
        ) . "\n\n";
        
        $message .= sprintf(
            /* translators: %s: admin URL */
            __('Посмотреть детали: %s', 'tm-booking'),
            admin_url('post.php?post=' . $order->get_id() . '&action=edit')
        );
        
        return $message;
    }
    
    /**
     * Send WhatsApp message using WhatsApp API
     * 
     * @param string $to Recipient WhatsApp number
     * @param string $message Message to send
     * @param string $api_key WhatsApp API key
     * @return bool Success or failure
     */
    private function send_whatsapp_message($to, $message, $api_key) {
        $booking_settings = get_option('tm_booking_settings', []);
        $phone_number_id = isset($booking_settings['whatsapp_phone_number_id']) ? $booking_settings['whatsapp_phone_number_id'] : '';
        
        if (empty($phone_number_id)) {
            error_log('TM Booking: WhatsApp API error - Missing Phone Number ID');
            return false;
        }
        
        // Using WhatsApp Cloud API (Meta/Facebook)
        $api_url = 'https://graph.facebook.com/v17.0/' . $phone_number_id . '/messages';
        
        // Prepare the message data
        $data = array(
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => 'text',
            'text' => array(
                'body' => $message
            )
        );
        
        // Send the request to WhatsApp API
        $response = wp_remote_post(
            $api_url,
            array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $api_key,
                    'Content-Type' => 'application/json',
                ),
                'body' => json_encode($data),
                'timeout' => 30,
            )
        );
        
        // Check for errors
        if (is_wp_error($response)) {
            error_log('TM Booking: WhatsApp API error - ' . $response->get_error_message());
            return false;
        }
        
        // Check response code
        $response_code = wp_remote_retrieve_response_code($response);
        if ($response_code !== 200) {
            $body = wp_remote_retrieve_body($response);
            error_log('TM Booking: WhatsApp API error - Response code: ' . $response_code . ', Body: ' . $body);
            return false;
        }
        
        return true;
    }
}

// Initialize the WhatsApp notification class
new TM_Booking_WhatsApp_Notification();
