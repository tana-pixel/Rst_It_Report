<?php


class TMBOOKING_Dashboard
{

    const DASHBOARD_DIRECTORY = '/dashboard/';

    public function __construct()
    {

        $this->dashboard_init_data();
        $this->dashboard_init_action();
        $this->dashboard_init_menu_action();
    }

    public $plugin_path;
    public $plugin_url;
    public $plugin_name;

    public $dashboard_dir;
    public $theme_name;
    public $theme_version;
    public $theme_slug;
    public $theme_is_child;
    public $dashboard_slug;
    public $tgmslug;



    public function dashboard_init_data()
    {

        $this->plugin_path = plugin_dir_path(__FILE__);
        $this->plugin_url = plugin_dir_url(__FILE__);
        $this->dashboard_dir = (dirname(__FILE__)) . self::DASHBOARD_DIRECTORY;
        $theme_info = wp_get_theme();
        $theme_parent = $theme_info->parent();
        if (!empty($theme_parent)) {
            $theme_info = $theme_parent;
        }

        $this->theme_name = $theme_info['Name'];
        $this->theme_version = $theme_info['Version'];
        $this->theme_slug = $theme_info['Slug'];
        $this->theme_is_child = !empty($theme_parent);
        $this->theme_slug = $theme_info->get_stylesheet();
        $this->dashboard_slug = 'theme-dashboard';
        $this->tgmslug = 'theme-plugin-install';

    }

    public function dashboard_init_action()
    {
        if (is_admin()) {
            add_action('admin_print_styles', array($this, 'dashboard_print_styles'));
        }
    }

    public function dashboard_print_styles()
    {
        wp_enqueue_style('fl_dashboard_css', plugin_dir_url(__FILE__) . 'css/style.css', array(), $this->theme_version);
    }


    public function dashboard_init_menu_action()
    {
        add_action('admin_menu', array($this, 'dashboard_admin_menu'));
    }

    public function dashboard_admin_menu()
    {

        add_menu_page( __( 'General', 'tm-booking' ), 'Booking', 'manage_options', 'tm-booking', array($this, 'dashboard_print_welcome'), plugins_url( 'tm-booking/assets/images/icon.png' ), 6 );


    }
    public function render_calendar_page() {
        // Получаем статистику
        // Get statistics
        $stats = $this->get_booking_statistics();
        ?>
        <div class="wrap tm-booking-calendar-wrap">
            <h1><?php echo esc_html__( 'Booking Calendar', 'tm-booking' ); ?></h1>

            <!-- Статистика бронирований -->
            <!-- Booking statistics -->
            <div class="tm-booking-stats">
                <div class="tm-booking-stats-row">
                    <!-- Основная статистика -->
                    <!-- Main statistics -->
                    <div class="tm-booking-stats-card tm-booking-stats-total">
                        <div class="tm-booking-stats-value"><?php echo esc_html($stats['total']); ?></div>
                        <div class="tm-booking-stats-label"><?php echo esc_html__('Total Bookings', 'tm-booking'); ?></div>
                    </div>

                    <div class="tm-booking-stats-card tm-booking-stats-active">
                        <div class="tm-booking-stats-value"><?php echo esc_html($stats['active']); ?></div>
                        <div class="tm-booking-stats-label"><?php echo esc_html__('Active', 'tm-booking'); ?></div>
                    </div>

                    <div class="tm-booking-stats-card tm-booking-stats-completed">
                        <div class="tm-booking-stats-value"><?php echo esc_html($stats['completed']); ?></div>
                        <div class="tm-booking-stats-label"><?php echo esc_html__('Completed', 'tm-booking'); ?></div>
                    </div>

                    <div class="tm-booking-stats-card tm-booking-stats-upcoming">
                        <div class="tm-booking-stats-value"><?php echo esc_html($stats['upcoming']); ?></div>
                        <div class="tm-booking-stats-label"><?php echo esc_html__('Upcoming', 'tm-booking'); ?></div>
                    </div>
                </div>
            </div>

            <div id="tm-booking-calendar"></div>
        </div>
        <?php
    }

    public function dashboard_print_welcome()
    {
        require_once(dirname(__FILE__) . '/general-tabbed.php');
    }


}



function tmbooking_dashboard()
{
    return new TMBOOKING_Dashboard();
}


tmbooking_dashboard();


