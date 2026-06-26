<?php
/**
 * WooCommerce Integration Hooks
 *
 * @package TM Booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Send WhatsApp notification when a new booking order is created
 * 
 * @param int $order_id The WooCommerce order ID
 */
function tm_booking_woocommerce_new_order($order_id) {
    // Get the order
    $order = wc_get_order($order_id);
    
    // Check if this is a booking order
    $has_booking = false;
    $booking_data = array();
    
    // Loop through order items to find booking items
    foreach ($order->get_items() as $item_id => $item) {
        $cart_item_data = $item->get_meta('tm_booking');
        
        if (!empty($cart_item_data)) {
            $has_booking = true;
            $booking_data = $cart_item_data;
            break;
        }
    }
    
    // If this is not a booking order, return
    if (!$has_booking) {
        return;
    }
    
    // Get order details
    $order_data = array(
        'id' => $order_id,
        'date' => $order->get_date_created()->date_i18n(get_option('date_format')),
        'status' => $order->get_status(),
        'total' => $order->get_total(),
        'customer' => array(
            'first_name' => $order->get_billing_first_name(),
            'last_name' => $order->get_billing_last_name(),
            'email' => $order->get_billing_email(),
            'phone' => $order->get_billing_phone()
        ),
        'booking' => $booking_data
    );
    
    // Fire action for WhatsApp notification
    do_action('tm_booking_after_create', $order_id, $order_data);
}
add_action('woocommerce_checkout_order_processed', 'tm_booking_woocommerce_new_order', 10, 1);

/**
 * Send WhatsApp notification when order status changes
 * 
 * @param int $order_id The WooCommerce order ID
 * @param string $old_status The old order status
 * @param string $new_status The new order status
 */
function tm_booking_woocommerce_order_status_changed($order_id, $old_status, $new_status) {
    // Get the order
    $order = wc_get_order($order_id);
    
    // Check if this is a booking order
    $has_booking = false;
    $booking_data = array();
    
    // Loop through order items to find booking items
    foreach ($order->get_items() as $item_id => $item) {
        $cart_item_data = $item->get_meta('tm_booking');
        
        if (!empty($cart_item_data)) {
            $has_booking = true;
            $booking_data = $cart_item_data;
            break;
        }
    }
    
    // If this is not a booking order, return
    if (!$has_booking) {
        return;
    }
    
    // Get order details
    $order_data = array(
        'id' => $order_id,
        'date' => $order->get_date_created()->date_i18n(get_option('date_format')),
        'old_status' => $old_status,
        'new_status' => $new_status,
        'total' => $order->get_total(),
        'customer' => array(
            'first_name' => $order->get_billing_first_name(),
            'last_name' => $order->get_billing_last_name(),
            'email' => $order->get_billing_email(),
            'phone' => $order->get_billing_phone()
        ),
        'booking' => $booking_data
    );
    
    // Fire action for WhatsApp notification
    do_action('tm_booking_status_changed', $order_id, $order_data, $old_status, $new_status);
}
add_action('woocommerce_order_status_changed', 'tm_booking_woocommerce_order_status_changed', 10, 3);
