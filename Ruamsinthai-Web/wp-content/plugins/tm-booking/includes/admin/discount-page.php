<?php
/**
 * TM Booking Discount Settings Page
 *
 * @package TM Booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the settings page
 */
function tm_booking_register_discount_page() {
    add_submenu_page(
        'edit.php?post_type=pixad-autos',
        esc_html__('Discount Settings', 'tm-booking'),
        esc_html__('Discount Settings', 'tm-booking'),
        'manage_options',
        'tm-booking-discount-settings',
        'tm_booking_discount_settings_page'
    );
}
add_action('admin_menu', 'tm_booking_register_discount_page');

/**
 * Initialize discount settings
 */
function tm_booking_initialize_discount_page() {
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
add_action('admin_init', 'tm_booking_initialize_discount_page');

/**
 * Render the settings page
 */
function tm_booking_discount_settings_page() {
    // Check if form is submitted
    if (isset($_POST['tm_booking_save_settings']) && check_admin_referer('tm_booking_discount_settings')) {
        // Save settings
        $show_discounts = isset($_POST['tm_booking_show_discounts']) ? sanitize_text_field($_POST['tm_booking_show_discounts']) : 'yes';
        
        $booking_settings = get_option('tm_booking_settings', []);
        $booking_settings['show_discounts'] = $show_discounts;
        update_option('tm_booking_settings', $booking_settings);
        
        // Show success message
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Settings saved successfully.', 'tm-booking') . '</p></div>';
    }
    
    // Get current settings
    $booking_settings = get_option('tm_booking_settings', []);
    $show_discounts = isset($booking_settings['show_discounts']) ? $booking_settings['show_discounts'] : 'yes';
    
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('TM Booking Discount Settings', 'tm-booking'); ?></h1>
        
        <form method="post" action="">
            <?php wp_nonce_field('tm_booking_discount_settings'); ?>
            
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="tm_booking_show_discounts"><?php esc_html_e('Show Discounts', 'tm-booking'); ?></label>
                    </th>
                    <td>
                        <select name="tm_booking_show_discounts" id="tm_booking_show_discounts">
                            <option value="yes" <?php selected($show_discounts, 'yes'); ?>><?php esc_html_e('Yes', 'tm-booking'); ?></option>
                            <option value="no" <?php selected($show_discounts, 'no'); ?>><?php esc_html_e('No', 'tm-booking'); ?></option>
                        </select>
                        <p class="description"><?php esc_html_e('Choose whether to display discount information on booking pages.', 'tm-booking'); ?></p>
                    </td>
                </tr>
            </table>
            
            <p class="submit">
                <input type="submit" name="tm_booking_save_settings" class="button-primary" value="<?php esc_attr_e('Save Settings', 'tm-booking'); ?>" />
            </p>
        </form>
    </div>
    <?php
}
