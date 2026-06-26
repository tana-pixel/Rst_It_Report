<?php
/**
 * Advanced Tab Content
 * Author: Templines
 * Website: templines.com
 */
?>

<div class="tm-booking-form-section">
    <h3><?php echo esc_html__('Product Relations', 'tm-booking'); ?></h3>
    <div class="description">
        <?php echo esc_html__('Manage the relationship between booking items and WooCommerce products.', 'tm-booking'); ?>
    </div>

    <div class="tm-booking-help-text">
        <strong><?php echo esc_html__('Current Post Type:', 'tm-booking'); ?></strong>
        <?php 
        $current_post_type = isset($booking_settings['post_type']) ? $booking_settings['post_type'] : 'unset';
        if ($current_post_type !== 'unset') {
            echo '<span class="tm-booking-status-enabled">' . esc_html(ucfirst($current_post_type)) . '</span>';
        } else {
            echo '<span class="tm-booking-status-disabled">' . esc_html__('Not configured', 'tm-booking') . '</span>';
        }
        ?>
        <br><br>
        <?php echo esc_html__('This setting determines which post type will be used for bookable items and how they relate to WooCommerce products.', 'tm-booking'); ?>
    </div>

    <div class="form_item">
        <label><?php echo esc_html__('Reset Product Relations', 'tm-booking'); ?></label>
        <?php
        $reset_url = admin_url('?page=tm-booking&reset=true');
        ?>
        <a class="tmbooking_save_btn" href="<?php echo esc_url($reset_url); ?>" onclick="return confirm('<?php echo esc_js(__('Are you sure you want to reset all product relations? This action cannot be undone.', 'tm-booking')); ?>')">
            <?php echo esc_html__('Reset Relations', 'tm-booking'); ?>
        </a>
        <div class="description">
            <?php echo esc_html__('This will reset all relationships between booking items and WooCommerce products. Use with caution.', 'tm-booking'); ?>
        </div>
    </div>
</div>

<div class="tm-booking-form-section">
    <h3><?php echo esc_html__('System Information', 'tm-booking'); ?></h3>
    <div class="description">
        <?php echo esc_html__('System status and plugin information.', 'tm-booking'); ?>
    </div>

    <div class="tm-booking-help-text">
        <strong><?php echo esc_html__('Plugin Version:', 'tm-booking'); ?></strong>
        <?php 
        $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/tm-booking/tm-booking.php');
        echo isset($plugin_data['Version']) ? esc_html($plugin_data['Version']) : esc_html__('Unknown', 'tm-booking');
        ?>
        <br>
        
        <strong><?php echo esc_html__('WordPress Version:', 'tm-booking'); ?></strong>
        <?php echo esc_html(get_bloginfo('version')); ?>
        <br>
        
        <strong><?php echo esc_html__('WooCommerce Status:', 'tm-booking'); ?></strong>
        <?php if (class_exists('WooCommerce')): ?>
            <span class="tm-booking-status-enabled">
                <?php echo esc_html__('Active', 'tm-booking') . ' (v' . esc_html(WC()->version) . ')'; ?>
            </span>
        <?php else: ?>
            <span class="tm-booking-status-disabled"><?php echo esc_html__('Not installed', 'tm-booking'); ?></span>
        <?php endif; ?>
        <br>
        
        <strong><?php echo esc_html__('PHP Version:', 'tm-booking'); ?></strong>
        <?php echo esc_html(PHP_VERSION); ?>
        <br>
        
        <strong><?php echo esc_html__('Database Version:', 'tm-booking'); ?></strong>
        <?php 
        global $wpdb;
        echo esc_html($wpdb->db_version());
        ?>
    </div>
</div>

<div class="tm-booking-form-section">
    <h3><?php echo esc_html__('Debug Information', 'tm-booking'); ?></h3>
    <div class="description">
        <?php echo esc_html__('Debug and troubleshooting information.', 'tm-booking'); ?>
    </div>

    <div class="form_item">
        <label><?php echo esc_html__('Current Settings Summary', 'tm-booking'); ?></label>
        <textarea readonly style="width: 100%; height: 200px; font-family: monospace; font-size: 12px;">
<?php
// Generate settings summary for debugging
$debug_info = [
    'Post Type' => $current_post_type,
    'Date Format' => isset($booking_settings['date_format']) ? $booking_settings['date_format'] : 'Not set',
    'Show Discounts' => isset($booking_settings['show_discounts']) ? $booking_settings['show_discounts'] : 'Not set',
    'Calculate Periods' => isset($booking_settings['calc_periods']) ? implode(', ', $booking_settings['calc_periods']) : 'Not set',
    'Time Format' => isset($booking_settings['time_format']) ? $booking_settings['time_format'] : 'Not set',
    'Working Hours Start' => isset($booking_settings['working_hours']['start']) ? $booking_settings['working_hours']['start'] : 'Not set',
    'Working Hours End' => isset($booking_settings['working_hours']['end']) ? $booking_settings['working_hours']['end'] : 'Not set',
    'Disabled Days' => isset($booking_settings['disable_days']) ? implode(', ', $booking_settings['disable_days']) : 'None',
    'WhatsApp Enabled' => isset($booking_settings['whatsapp_enabled']) ? $booking_settings['whatsapp_enabled'] : 'Not set',
    'Telegram Enabled' => isset($booking_settings['telegram_enabled']) ? $booking_settings['telegram_enabled'] : 'Not set',
    'SMS Enabled' => isset($booking_settings['sms_enabled']) ? $booking_settings['sms_enabled'] : 'Not set',
];

foreach ($debug_info as $key => $value) {
    echo esc_html($key . ': ' . $value . "\n");
}
?>
        </textarea>
        <div class="description">
            <?php echo esc_html__('Copy this information when reporting issues to support.', 'tm-booking'); ?>
        </div>
    </div>
</div>

<div class="tm-booking-form-section">
    <h3><?php echo esc_html__('Support & Documentation', 'tm-booking'); ?></h3>
    <div class="description">
        <?php echo esc_html__('Get help and access documentation.', 'tm-booking'); ?>
    </div>

    <div class="tm-booking-help-text">
        <strong><?php echo esc_html__('Need Help?', 'tm-booking'); ?></strong><br>
        
        • <a href="https://templines.com/docs/tm-booking" target="_blank"><?php echo esc_html__('Documentation', 'tm-booking'); ?></a><br>
        • <a href="https://templines.com/support" target="_blank"><?php echo esc_html__('Support Center', 'tm-booking'); ?></a><br>
        • <a href="https://templines.com/contact" target="_blank"><?php echo esc_html__('Contact Us', 'tm-booking'); ?></a><br><br>
        
        <strong><?php echo esc_html__('Author:', 'tm-booking'); ?></strong> Templines<br>
        <strong><?php echo esc_html__('Website:', 'tm-booking'); ?></strong> <a href="https://templines.com" target="_blank">templines.com</a>
    </div>
</div>
