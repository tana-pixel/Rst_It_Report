<?php
// Get settings and ensure it's an array
$booking_settings = get_option('tm_booking_settings', []);
if (!is_array($booking_settings)) {
    $booking_settings = [];
}
$post_types = get_post_types();

// Enqueue styles and scripts
wp_enqueue_style('tm-booking-tabs-style', plugin_dir_url(__FILE__) . 'css/tabs-style.css', [], '1.0.0');
wp_enqueue_script('tm-booking-tabs-script', plugin_dir_url(__FILE__) . 'js/tabs-script.js', ['jquery'], '1.0.0', true);
?>

<div class="tm-booking-settings-wrapper">
    <h2><?php echo esc_html__('Booking Settings', 'tm-booking'); ?></h2>
    
    <?php if(!class_exists('WooCommerce')): ?>
        <div class="notice notice-warning settings-error is-dismissible">
            <?php echo esc_html__('"TM Booking" requires "Woocommerce". Please install and activate "Woocommerce"', 'tm-booking'); ?>
        </div>
    <?php endif; ?>

    <!-- Tab Navigation -->
    <div class="tm-booking-tabs-nav">
        <button class="tm-booking-tab-button active" data-tab="core-config">
            <?php echo esc_html__('Core Configuration', 'tm-booking'); ?>
        </button>
        <button class="tm-booking-tab-button" data-tab="pricing-periods">
            <?php echo esc_html__('Pricing & Periods', 'tm-booking'); ?>
        </button>
        <button class="tm-booking-tab-button" data-tab="working-hours">
            <?php echo esc_html__('Working Hours', 'tm-booking'); ?>
        </button>
        <button class="tm-booking-tab-button" data-tab="notifications">
            <?php echo esc_html__('Notifications', 'tm-booking'); ?>
        </button>
        <button class="tm-booking-tab-button" data-tab="advanced">
            <?php echo esc_html__('Advanced', 'tm-booking'); ?>
        </button>
    </div>

    <!-- Tab Content Container -->
    <div class="tm-booking-tabs-content">
        <form method="post" class="tmbooking_form">
            
            <!-- Core Configuration Tab -->
            <div id="core-config" class="tm-booking-tab-content active">
                <?php include plugin_dir_path(__FILE__) . 'tabs/core-config-tab.php'; ?>
            </div>

            <!-- Pricing & Periods Tab -->
            <div id="pricing-periods" class="tm-booking-tab-content">
                <?php include plugin_dir_path(__FILE__) . 'tabs/pricing-periods-tab.php'; ?>
            </div>

            <!-- Working Hours Tab -->
            <div id="working-hours" class="tm-booking-tab-content">
                <?php include plugin_dir_path(__FILE__) . 'tabs/working-hours-tab.php'; ?>
            </div>

            <!-- Notifications Tab -->
            <div id="notifications" class="tm-booking-tab-content">
                <?php include plugin_dir_path(__FILE__) . 'tabs/notifications-tab.php'; ?>
            </div>

            <!-- Advanced Tab -->
            <div id="advanced" class="tm-booking-tab-content">
                <?php include plugin_dir_path(__FILE__) . 'tabs/advanced-tab.php'; ?>
            </div>

            <!-- Save Button -->
            <div class="form_item tm-booking-save-section">
                <button class="tmbooking_save_btn"><?php echo esc_html__('Save Settings', 'tm-booking'); ?></button>
            </div>

        </form>
    </div>
</div>

<?php
// Handle form submission (same as original)
if(isset($_POST['tm_booking_settings'])){
    $_POST['tm_booking_settings']['calc_periods'][] = 'calc_days';
    if($_POST['tm_booking_settings']['date_format_old'] !== $booking_settings['date_format'] ){
        $_POST['tm_booking_settings']['date_format_old'] = $booking_settings['date_format'];
    }
    // ... rest of the form processing logic
    update_option('tm_booking_settings', $_POST['tm_booking_settings']);
    $redirect_url = get_admin_url() . '?page=tm-booking';
    echo '<script>window.location.href = "' . $redirect_url . '"</script>';
}
?>
