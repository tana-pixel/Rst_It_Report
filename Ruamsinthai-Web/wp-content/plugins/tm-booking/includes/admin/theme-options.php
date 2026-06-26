<?php
/**
 * TM Booking Theme Options Integration
 *
 * @package TM Booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add discount display settings to theme customizer
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object
 */
function tm_booking_customize_register($wp_customize) {
    // Add section for booking settings
    $wp_customize->add_section('tm_booking_settings_section', array(
        'title'    => esc_html__('TM Booking Settings', 'tm-booking'),
        'priority' => 120,
    ));
    
    // Add setting for showing discounts
    $wp_customize->add_setting('tm_booking_show_discounts', array(
        'default'           => 'yes',
        'sanitize_callback' => 'tm_booking_sanitize_select',
        'transport'         => 'refresh',
    ));
    
    // Add control for showing discounts
    $wp_customize->add_control('tm_booking_show_discounts', array(
        'label'       => esc_html__('Show Discounts', 'tm-booking'),
        'description' => esc_html__('Choose whether to display discount information on booking pages.', 'tm-booking'),
        'section'     => 'tm_booking_settings_section',
        'type'        => 'select',
        'choices'     => array(
            'yes' => esc_html__('Yes', 'tm-booking'),
            'no'  => esc_html__('No', 'tm-booking'),
        ),
    ));
}
add_action('customize_register', 'tm_booking_customize_register');

/**
 * Sanitize select field
 *
 * @param string $input Select field value
 * @param WP_Customize_Setting $setting Setting instance
 * @return string Sanitized value
 */
function tm_booking_sanitize_select($input, $setting) {
    // Get list of choices from the control associated with the setting
    $choices = $setting->manager->get_control($setting->id)->choices;
    
    // Return input if valid or return default if not
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Sync theme customizer settings with plugin settings
 */
function tm_booking_sync_customizer_settings() {
    // Get customizer setting
    $customizer_setting = get_theme_mod('tm_booking_show_discounts', 'yes');
    
    // Get plugin settings
    $booking_settings = get_option('tm_booking_settings', []);
    
    // Update plugin settings if different
    if (!isset($booking_settings['show_discounts']) || $booking_settings['show_discounts'] !== $customizer_setting) {
        $booking_settings['show_discounts'] = $customizer_setting;
        update_option('tm_booking_settings', $booking_settings);
    }
}
add_action('wp_loaded', 'tm_booking_sync_customizer_settings');

/**
 * Add admin menu item for discount settings
 */
function tm_booking_add_admin_menu() {
    add_submenu_page(
        'edit.php?post_type=pixad-autos',
        esc_html__('Booking Settings', 'tm-booking'),
        esc_html__('Booking Settings', 'tm-booking'),
        'manage_options',
        'tm-booking-settings-admin',
        'tm_booking_admin_page'
    );
}
add_action('admin_menu', 'tm_booking_add_admin_menu');

/**
 * Admin page content
 */
function tm_booking_admin_page() {
    // Get current settings
    $booking_settings = get_option('tm_booking_settings', []);
    $show_discounts = isset($booking_settings['show_discounts']) ? $booking_settings['show_discounts'] : 'yes';
    
    // Save settings if form is submitted
    if (isset($_POST['tm_booking_save_settings']) && check_admin_referer('tm_booking_admin_nonce')) {
        $show_discounts = isset($_POST['tm_booking_show_discounts']) ? sanitize_text_field($_POST['tm_booking_show_discounts']) : 'yes';
        $booking_settings['show_discounts'] = $show_discounts;
        update_option('tm_booking_settings', $booking_settings);
        
        // Update theme mod to keep in sync
        set_theme_mod('tm_booking_show_discounts', $show_discounts);
        
        // Show success message
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Settings saved successfully.', 'tm-booking') . '</p></div>';
    }
    
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('TM Booking Settings', 'tm-booking'); ?></h1>
        
        <form method="post" action="">
            <?php wp_nonce_field('tm_booking_admin_nonce'); ?>
            
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
