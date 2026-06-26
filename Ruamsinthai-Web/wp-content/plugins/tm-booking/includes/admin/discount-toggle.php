<?php
/**
 * TM Booking Discount Toggle
 *
 * @package TM Booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add discount toggle to the Booking metabox
 */
function tm_booking_add_discount_toggle() {
    // Add script to inject our setting into the existing Booking metabox
    add_action('admin_footer', 'tm_booking_inject_discount_toggle_script');
    
    // Handle saving the setting
    add_action('save_post', 'tm_booking_save_discount_toggle', 10, 2);
}
add_action('admin_init', 'tm_booking_add_discount_toggle');

/**
 * Script to inject discount toggle into existing Booking metabox
 */
function tm_booking_inject_discount_toggle_script() {
    // Only run on post edit screens
    $screen = get_current_screen();
    if (!$screen || $screen->base !== 'post') {
        return;
    }
    
    // Get current settings
    $booking_settings = get_option('tm_booking_settings', []);
    $show_discounts = isset($booking_settings['show_discounts']) ? $booking_settings['show_discounts'] : 'yes';
    
    // Create the HTML for our setting
    $setting_html = '<tr>
        <th scope="row"><label for="tm_booking_show_discounts">' . esc_html__('Show Discounts', 'tm-booking') . '</label></th>
        <td><select id="tm_booking_show_discounts" name="tm_booking_show_discounts">
            <option value="yes" ' . selected($show_discounts, 'yes', false) . '>' . esc_html__('Yes', 'tm-booking') . '</option>
            <option value="no" ' . selected($show_discounts, 'no', false) . '>' . esc_html__('No', 'tm-booking') . '</option>
        </select></td>
    </tr>';
    
    // Inject our setting into the Booking metabox
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Find the Booking metabox
        var $bookingMetabox = $('#booking');
        
        if ($bookingMetabox.length) {
            // Find the table inside the metabox
            var $table = $bookingMetabox.find('table.form-table');
            
            if ($table.length) {
                // Add our setting to the table
                $table.append('<?php echo wp_slash($setting_html); ?>');
            }
        }
    });
    </script>
    <?php
}

/**
 * Save discount toggle setting
 */
function tm_booking_save_discount_toggle($post_id, $post) {
    // Check if our field is set
    if (!isset($_POST['tm_booking_show_discounts'])) {
        return;
    }
    
    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Sanitize and save the setting
    $show_discounts = sanitize_text_field($_POST['tm_booking_show_discounts']);
    $booking_settings = get_option('tm_booking_settings', []);
    $booking_settings['show_discounts'] = $show_discounts;
    update_option('tm_booking_settings', $booking_settings);
}

/**
 * Initialize discount settings with default values
 */
function tm_booking_initialize_discount_toggle() {
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
add_action('admin_init', 'tm_booking_initialize_discount_toggle');
