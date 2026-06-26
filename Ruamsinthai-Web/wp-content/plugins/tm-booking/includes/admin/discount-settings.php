<?php
/**
 * TM Booking Discount Settings
 *
 * @package TM Booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register discount settings in admin
 */
function tm_booking_register_discount_settings() {
    // Add settings section
    add_settings_section(
        'tm_booking_discount_section',
        esc_html__('Discount Display Settings', 'tm-booking'),
        'tm_booking_discount_section_callback',
        'tm_booking'
    );
    
    // Add settings field
    add_settings_field(
        'tm_booking_show_discounts',
        esc_html__('Show Discounts', 'tm-booking'),
        'tm_booking_show_discounts_callback',
        'tm_booking',
        'tm_booking_discount_section'
    );
    
    // Register setting
    register_setting('tm_booking', 'tm_booking_settings');
}
add_action('admin_init', 'tm_booking_register_discount_settings');

/**
 * Discount settings section callback
 */
function tm_booking_discount_section_callback() {
    echo '<p>' . esc_html__('Configure how discounts are displayed on your site.', 'tm-booking') . '</p>';
}

/**
 * Show discounts field callback
 */
function tm_booking_show_discounts_callback() {
    $booking_settings = get_option('tm_booking_settings', []);
    $show_discounts = isset($booking_settings['show_discounts']) ? $booking_settings['show_discounts'] : 'yes';
    
    echo '<select name="tm_booking_settings[show_discounts]" id="tm_booking_show_discounts">';
    echo '<option value="yes" ' . selected($show_discounts, 'yes', false) . '>' . esc_html__('Yes', 'tm-booking') . '</option>';
    echo '<option value="no" ' . selected($show_discounts, 'no', false) . '>' . esc_html__('No', 'tm-booking') . '</option>';
    echo '</select>';
    echo '<p class="description">' . esc_html__('Choose whether to display discount information on booking pages.', 'tm-booking') . '</p>';
}

/**
 * Add settings page to TM Booking menu
 */
function tm_booking_add_discount_settings_page() {
    add_submenu_page(
        'edit.php?post_type=transports',
        esc_html__('Discount Settings', 'tm-booking'),
        esc_html__('Discount Settings', 'tm-booking'),
        'manage_options',
        'tm-booking-discount-settings',
        'tm_booking_discount_settings_page'
    );
}
add_action('admin_menu', 'tm_booking_add_discount_settings_page');

/**
 * Discount settings page content
 */
function tm_booking_discount_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('TM Booking Discount Settings', 'tm-booking'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('tm_booking');
            do_settings_sections('tm_booking');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

/**
 * Initialize discount settings with default values
 */
function tm_booking_initialize_discount_settings() {
    $booking_settings = get_option('tm_booking_settings', []);
    
    // If settings is not an array, create empty array
    if (!is_array($booking_settings)) {
        $booking_settings = [];
    }
    
    // Set default value for show_discounts if not set
    if (!isset($booking_settings['show_discounts'])) {
        $booking_settings['show_discounts'] = 'yes';
        update_option('tm_booking_settings', $booking_settings);
    }
}
add_action('admin_init', 'tm_booking_initialize_discount_settings');
