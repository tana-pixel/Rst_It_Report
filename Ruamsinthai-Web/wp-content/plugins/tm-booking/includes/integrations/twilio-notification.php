<?php
/**
 * Twilio SMS Notification Integration
 *
 * @package TM Booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class for handling Twilio SMS notifications
 */
class TM_Booking_Twilio_Notification {
    /**
     * Constructor
     */
    public function __construct() {
        // Hook into booking creation
        add_action('tm_booking_after_create', array($this, 'send_booking_notification'), 10, 2);
    }
    
    /**
     * Send SMS notification for new booking
     * 
     * @param int $order_id The WooCommerce order ID
     * @param array $order_data Optional order data
     */
    public function send_booking_notification($order_id, $order_data = null) {
        $booking_settings = get_option('tm_booking_settings', []);
        
        // Check if SMS notifications are enabled
        if (!isset($booking_settings['sms_enabled']) || $booking_settings['sms_enabled'] !== 'yes') {
            return;
        }
        
        // Check if Twilio credentials are set
        if (empty($booking_settings['twilio_account_sid']) || 
            empty($booking_settings['twilio_auth_token']) || 
            empty($booking_settings['twilio_phone_number']) || 
            empty($booking_settings['admin_phone_number'])) {
            // Log error if needed
            error_log(esc_html__('TM Booking: SMS notification failed - missing Twilio credentials', 'tm-booking'));
            return;
        }
        
        // If we have order data from the hook, use it
        if ($order_data) {
            // Format booking details for SMS message using order data
            $message = $this->format_booking_message_from_order($order_data);
        } else {
            // Fallback to getting order data directly
            $order = wc_get_order($order_id);
            if (!$order) {
                return;
            }
            
            // Format booking details for SMS message
            $message = $this->format_booking_message_from_wc_order($order);
        }
        
        // Send SMS message
        $this->send_sms_message(
            $booking_settings['admin_phone_number'], 
            $message, 
            $booking_settings['twilio_account_sid'],
            $booking_settings['twilio_auth_token'],
            $booking_settings['twilio_phone_number']
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
            esc_html__('Unknown', 'tm-booking');
        $customer_email = isset($order_data['customer']) ? $order_data['customer']['email'] : '';
        $customer_phone = isset($order_data['customer']) ? $order_data['customer']['phone'] : '';
        
        // Get booking details
        $booking_data = isset($order_data['booking']) ? $order_data['booking'] : [];
        $booking_id = isset($booking_data['id']) ? $booking_data['id'] : esc_html__('Unknown', 'tm-booking');
        $start_date = isset($booking_data['start_date']) ? $booking_data['start_date'] : esc_html__('Unknown', 'tm-booking');
        $end_date = isset($booking_data['end_date']) ? $booking_data['end_date'] : esc_html__('Unknown', 'tm-booking');
        $start_time = isset($booking_data['start_time']) ? $booking_data['start_time'] : '';
        $end_time = isset($booking_data['end_time']) ? $booking_data['end_time'] : '';
        
        // Get product name
        $product_name = esc_html__('Unknown', 'tm-booking');
        if (isset($booking_data['id'])) {
            $product = get_post($booking_data['id']);
            if ($product) {
                $product_name = $product->post_title;
            }
        }
        
        // Format message - Keep it shorter for SMS
        $message = sprintf(
            /* translators: %s: site name */
            esc_html__('New booking on %s', 'tm-booking'),
            $site_name
        ) . "\n\n";
        
        $message .= sprintf(
            /* translators: %s: order ID */
            esc_html__('Order #: %s', 'tm-booking'),
            $order_data['id']
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: product name */
            esc_html__('Service: %s', 'tm-booking'),
            $product_name
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: booking date */
            esc_html__('Start: %s', 'tm-booking'),
            $start_date . ($start_time ? ' ' . $start_time : '')
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: booking date */
            esc_html__('End: %s', 'tm-booking'),
            $end_date . ($end_time ? ' ' . $end_time : '')
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: order total */
            esc_html__('Total: %s', 'tm-booking'),
            wc_price($order_data['total'])
        ) . "\n\n";
        
        $message .= esc_html__('Customer:', 'tm-booking') . ' ' . $customer_name;
        
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
        $product_name = esc_html__('Unknown', 'tm-booking');
        
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
                esc_html__('New order #%2$s on %1$s', 'tm-booking'),
                $site_name,
                $order->get_id()
            );
        }
        
        $start_date = isset($booking_data['start_date']) ? $booking_data['start_date'] : esc_html__('Unknown', 'tm-booking');
        $end_date = isset($booking_data['end_date']) ? $booking_data['end_date'] : esc_html__('Unknown', 'tm-booking');
        $start_time = isset($booking_data['start_time']) ? $booking_data['start_time'] : '';
        $end_time = isset($booking_data['end_time']) ? $booking_data['end_time'] : '';
        
        // Format message - Keep it shorter for SMS
        $message = sprintf(
            /* translators: %s: site name */
            esc_html__('New booking on %s', 'tm-booking'),
            $site_name
        ) . "\n\n";
        
        $message .= sprintf(
            /* translators: %s: order ID */
            esc_html__('Order #: %s', 'tm-booking'),
            $order->get_id()
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: product name */
            esc_html__('Service: %s', 'tm-booking'),
            $product_name
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: booking date */
            esc_html__('Start: %s', 'tm-booking'),
            $start_date . ($start_time ? ' ' . $start_time : '')
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: booking date */
            esc_html__('End: %s', 'tm-booking'),
            $end_date . ($end_time ? ' ' . $end_time : '')
        ) . "\n";
        
        $message .= sprintf(
            /* translators: %s: order total */
            esc_html__('Total: %s', 'tm-booking'),
            $order->get_formatted_order_total()
        ) . "\n\n";
        
        $message .= esc_html__('Customer:', 'tm-booking') . ' ' . $customer_name;
        
        return $message;
    }
    
    /**
     * Send SMS message using Twilio API
     * 
     * @param string $to Recipient phone number
     * @param string $message Message to send
     * @param string $account_sid Twilio Account SID
     * @param string $auth_token Twilio Auth Token
     * @param string $from_number Twilio phone number
     * @return bool Success or failure
     */
    private function send_sms_message($to, $message, $account_sid, $auth_token, $from_number) {
        // Twilio API endpoint
        $api_url = 'https://api.twilio.com/2010-04-01/Accounts/' . $account_sid . '/Messages.json';
        
        // Prepare the message data
        $data = array(
            'To' => $to,
            'From' => $from_number,
            'Body' => $message
        );
        
        // Send the request to Twilio API
        $response = wp_remote_post(
            $api_url,
            array(
                'headers' => array(
                    'Authorization' => 'Basic ' . base64_encode($account_sid . ':' . $auth_token),
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ),
                'body' => $data,
                'timeout' => 30,
            )
        );
        
        // Check for errors
        if (is_wp_error($response)) {
            error_log('TM Booking: Twilio API error - ' . $response->get_error_message());
            return false;
        }
        
        // Check response code
        $response_code = wp_remote_retrieve_response_code($response);
        if ($response_code < 200 || $response_code >= 300) {
            $body = wp_remote_retrieve_body($response);
            error_log('TM Booking: Twilio API error - Response code: ' . $response_code . ', Body: ' . $body);
            return false;
        }
        
        return true;
    }
}

// Initialize the Twilio notification class
new TM_Booking_Twilio_Notification();
