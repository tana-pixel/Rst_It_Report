<?php
/**
 * TM Booking Discount Direct Integration
 *
 * @package TM Booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add discount toggle directly to the form
 */
function tm_booking_add_discount_direct() {
    // Add our field directly to the form using output buffering
    add_action('admin_footer', 'tm_booking_inject_discount_direct');
    
    // Handle saving the setting
    add_action('save_post', 'tm_booking_save_discount_direct', 10, 2);
}
add_action('admin_init', 'tm_booking_add_discount_direct');

/**
 * Inject discount toggle directly into the form
 */
function tm_booking_inject_discount_direct() {
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
    
    // Inject our setting using a more direct approach
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Try multiple selectors to find the booking metabox table
        var $tables = $('.postbox .inside table.form-table');
        
        if ($tables.length) {
            // Look for the table that contains booking-related fields
            $tables.each(function() {
                var $table = $(this);
                // Check if this table contains booking-related fields
                if ($table.find('select[name="show_booking_form"]').length || 
                    $table.find('select[id="show_booking_form"]').length) {
                    // This is the booking table, append our setting
                    $table.append('<?php echo wp_slash($setting_html); ?>');
                    return false; // Break the loop
                }
            });
        }
        
        // Alternative approach - add to any postbox with "Booking" in the title
        $('.postbox').each(function() {
            var $box = $(this);
            var title = $box.find('.hndle').text().trim();
            
            if (title === 'Booking') {
                var $table = $box.find('table.form-table');
                if ($table.length) {
                    $table.append('<?php echo wp_slash($setting_html); ?>');
                }
            }
        });
    });
    </script>
    <?php
}

/**
 * Save discount toggle setting
 */
function tm_booking_save_discount_direct($post_id, $post) {
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
function tm_booking_initialize_discount_direct() {
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
add_action('admin_init', 'tm_booking_initialize_discount_direct');

/**
 * Add a hidden field to ensure our setting is always present in the form
 */
function tm_booking_add_hidden_field() {
    $booking_settings = get_option('tm_booking_settings', []);
    $show_discounts = isset($booking_settings['show_discounts']) ? $booking_settings['show_discounts'] : 'yes';
    
    echo '<input type="hidden" name="tm_booking_show_discounts" value="' . esc_attr($show_discounts) . '" />';
}
add_action('edit_form_after_title', 'tm_booking_add_hidden_field');
