<?php
/**
 * TM Booking Metabox for Discount Settings
 *
 * @package TM Booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add metabox for discount settings
 */
function tm_booking_add_discount_metabox() {
    // Check if we're using pixad-autos or another post type
    $booking_settings = get_option('tm_booking_settings', []);
    $post_type = isset($booking_settings['post_type']) ? $booking_settings['post_type'] : 'pixad-autos';
    
    add_meta_box(
        'tm_booking_discount_settings',
        esc_html__('Booking Discount Settings', 'tm-booking'),
        'tm_booking_discount_metabox_callback',
        $post_type,
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'tm_booking_add_discount_metabox');

/**
 * Metabox callback function
 */
function tm_booking_discount_metabox_callback($post) {
    // Add nonce for security
    wp_nonce_field('tm_booking_discount_metabox', 'tm_booking_discount_metabox_nonce');
    
    // Get current settings
    $booking_settings = get_option('tm_booking_settings', []);
    $show_discounts = isset($booking_settings['show_discounts']) ? $booking_settings['show_discounts'] : 'yes';
    
    // Output the field
    ?>
    <p>
        <label for="tm_booking_show_discounts"><?php esc_html_e('Show Discounts:', 'tm-booking'); ?></label>
        <select name="tm_booking_show_discounts" id="tm_booking_show_discounts" class="widefat">
            <option value="yes" <?php selected($show_discounts, 'yes'); ?>><?php esc_html_e('Yes', 'tm-booking'); ?></option>
            <option value="no" <?php selected($show_discounts, 'no'); ?>><?php esc_html_e('No', 'tm-booking'); ?></option>
        </select>
    </p>
    <p class="description">
        <?php esc_html_e('Choose whether to display discount information on booking pages.', 'tm-booking'); ?>
    </p>
    <?php
}

/**
 * Save metabox data
 */
function tm_booking_save_discount_metabox($post_id) {
    // Check if our nonce is set
    if (!isset($_POST['tm_booking_discount_metabox_nonce'])) {
        return;
    }
    
    // Verify the nonce
    if (!wp_verify_nonce($_POST['tm_booking_discount_metabox_nonce'], 'tm_booking_discount_metabox')) {
        return;
    }
    
    // If this is an autosave, our form has not been submitted, so we don't want to do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Check if our field is set
    if (!isset($_POST['tm_booking_show_discounts'])) {
        return;
    }
    
    // Sanitize and save the setting
    $show_discounts = sanitize_text_field($_POST['tm_booking_show_discounts']);
    $booking_settings = get_option('tm_booking_settings', []);
    $booking_settings['show_discounts'] = $show_discounts;
    update_option('tm_booking_settings', $booking_settings);
}
add_action('save_post', 'tm_booking_save_discount_metabox');

/**
 * Add global settings page
 */
function tm_booking_add_global_settings_page() {
    add_options_page(
        esc_html__('TM Booking Settings', 'tm-booking'),
        esc_html__('TM Booking', 'tm-booking'),
        'manage_options',
        'tm-booking-settings',
        'tm_booking_global_settings_page'
    );
}
add_action('admin_menu', 'tm_booking_add_global_settings_page');

/**
 * Global settings page content
 */
function tm_booking_global_settings_page() {
    // Get current settings
    $booking_settings = get_option('tm_booking_settings', []);
    $show_discounts = isset($booking_settings['show_discounts']) ? $booking_settings['show_discounts'] : 'yes';
    
    // Check if form is submitted
    if (isset($_POST['tm_booking_settings_submit']) && check_admin_referer('tm_booking_settings_nonce')) {
        // Save settings
        $show_discounts = isset($_POST['tm_booking_show_discounts']) ? sanitize_text_field($_POST['tm_booking_show_discounts']) : 'yes';
        $booking_settings['show_discounts'] = $show_discounts;
        update_option('tm_booking_settings', $booking_settings);
        
        // Show success message
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Settings saved.', 'tm-booking') . '</p></div>';
    }
    
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('TM Booking Settings', 'tm-booking'); ?></h1>
        
        <form method="post" action="">
            <?php wp_nonce_field('tm_booking_settings_nonce'); ?>
            
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
                <input type="submit" name="tm_booking_settings_submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'tm-booking'); ?>" />
            </p>
        </form>
    </div>
    <?php
}
