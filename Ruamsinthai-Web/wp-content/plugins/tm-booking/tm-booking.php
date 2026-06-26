<?php
/*
 * Plugin Name: TM Booking
 * Description: Booking Plugin
 * Version: 2.1.5
 * Author:Templines
 * License: GPL v2
 * Text Domain: tm-booking
 * Domain Path: /languages
 */


require 'plugin-update-checker/plugin-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://assets.templines.com/plugins/tm-booking.json',
    __FILE__,
    'tm-booking'
);


/**====================================================================
==  Load Text domain
====================================================================*/
function tmbooking_helper_load_textdomain() {
    load_plugin_textdomain( 'tm-booking', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}
add_action('init', 'tmbooking_helper_load_textdomain');




/**====================================================================
==  Make sure we don't expose any info if called directly
====================================================================*/
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}


define('TMBOOKING_THEME_HELPER_PLUGIN_PATH', plugin_dir_path(__FILE__));
defined('TMBOOKING_HELPING_PLUGIN_VERSION' )   or define( 'TMBOOKING_HELPING_PLUGIN_VERSION', '1.0');
defined('TMBOOKING_THEME_HELPER_ROOT_DIR' )    or define( 'TMBOOKING_THEME_HELPER_ROOT_DIR', plugins_url() . '/tm-booking');
defined('TMBOOKING_THEME_HELPER_URL' )         or define( 'TMBOOKING_THEME_HELPER_URL', plugin_dir_url( __FILE__ ));

// Подключаем исправление для добавления min-days-info-container в стиль equipment-booking-style_four
require_once plugin_dir_path(__FILE__) . 'includes/min-days-style-four-fix.php';

// Подключаем исправление для блокировки забронированных дат в календаре
require_once plugin_dir_path(__FILE__) . 'includes/block-booked-dates.php';

// Функции для проверки доступности автомобилей перенесены в плагин pix-auto-deal
// require_once plugin_dir_path(__FILE__) . 'function/available-cars.php';

// Подключаем отладочный блок для просмотра забронированных дат

// Подключаем обработчик параметра 'when' для фильтрации по диапазону дат
// Функции парсера дат перенесены в плагин pix-auto-deal
// require_once plugin_dir_path(__FILE__) . 'function/search-date-parser.php';


/**====================================================================
==  Require TMBooking_ theme
====================================================================*/
if( !class_exists('TMBooking__Helping_Addons') ) {

    class TMBooking__Helping_Addons {
        private $calendar;
        // Construct
        public function __construct() {
            //Image Size
            add_image_size('tm_booking_size_350x300_crop', 350, 300, true);
            $booking_settings = get_option('tm_booking_settings', true);
            if ($booking_settings == true && !is_array($booking_settings)){
                $default_booking_settings = array();
                $default_booking_settings['date_format'] = "MM/DD/YYYY";
                $default_booking_settings['date_format_old'] = "MM/DD/YYYY";
                $default_booking_settings['drops'] = "down";
                $default_booking_settings['showWeekNumbers'] = "true";
                $default_booking_settings['showISOWeekNumbers'] = "true";

                if(!isset($booking_settings['post_type'])){
                    $default_booking_settings_add = [];
                    $default_booking_settings_add['post_type'] = 'unset';
                    if( class_exists('TMReviews__Helping_Addons') ) {
                        $default_booking_settings_add['post_type'] = tmreviews_get_post_type();
                    }
                    if( class_exists('TMTransport__Helping_Addons') ) {
                        $default_booking_settings_add['post_type'] = tmtransport_get_post_type();
                    }
                    if( class_exists('Pix_Autos') ) {
                        $default_booking_settings_add['post_type'] = 'pixad-autos';
                    }
                    $default_booking_settings = array_merge($default_booking_settings, $default_booking_settings_add);
                }

                if( class_exists('TMReviews__Helping_Addons') ) {
                    $default_booking_settings['post_type'] = tmreviews_get_post_type();
                }
                if( class_exists('TMTransport__Helping_Addons') ) {
                    $default_booking_settings['post_type'] = tmtransport_get_post_type();
                }
                if( class_exists('Pix_Autos') ) {
                    $default_booking_settings['post_type'] = 'pixad-autos';
                }
                $default_booking_settings['verification'] = "disable";
                $default_booking_settings['booked_days'] = "enable";
                $default_booking_settings['calc_periods'] = array("calc_hours", "calc_days", "calc_weeks", "calc_month");
                add_option('tm_booking_settings', $default_booking_settings);
            }

            $this->addCustomFunction();
            $this->addDashboard();
            $this->addCustomTaxonomyServices();
            $this->addCustomDataBaseTable();
            add_action('wp_enqueue_scripts', array($this, 'addStyles'));
            //Add hidden Product
            if (class_exists('WC_Product')){
                if(!class_exists('WeDevs_Dokan')){
                    register_activation_hook( __FILE__, array($this, 'addHiddenWooProduct') );
                }
            }
            // Initialize Calendar
            $this->calendar = new TM_Booking_Calendar();
        }

        /** Add Custom Taxonomy Transports*/
        public function addCustomTaxonomyServices() {
            require_once('acf-metaboxes/acf-metaboxes.php');
            require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'acf-metaboxes/transports/transports_option.php');
            require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'custom_taxonomy/transports.php');
            require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'custom_taxonomy/taxonomy-meta/taxonomy_option.php');
            
            // Подключаем глобальные настройки плагина (Include global settings)
            if (file_exists(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'includes/admin/global-settings.php')) {
                require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'includes/admin/global-settings.php');
            }
            
            // Подключаем интеграцию с WhatsApp (Include WhatsApp integration)
            if (file_exists(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'includes/integrations/whatsapp-notification.php')) {
                require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'includes/integrations/whatsapp-notification.php');
            }
            
            // Подключаем хуки WooCommerce для интеграции (Include WooCommerce hooks)
            if (file_exists(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'includes/integrations/woocommerce-hooks.php')) {
                require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'includes/integrations/woocommerce-hooks.php');
            }
            
            // Подключаем интеграцию с Telegram (Include Telegram integration)
            if (file_exists(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'includes/integrations/telegram-notification.php')) {
                require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'includes/integrations/telegram-notification.php');
            }
            
            // Подключаем интеграцию с Twilio SMS (Include Twilio SMS integration)
            if (file_exists(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'includes/integrations/twilio-notification.php')) {
                require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'includes/integrations/twilio-notification.php');
            }
        }
        /** Add Custom Table to database*/
        public function addCustomDataBaseTable() {
            $table_created = get_option('tmbooking_order_created');
            if($table_created != 'created'){
                global $wpdb;
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                $collate = '';
                if ( $wpdb->has_cap( 'collation' ) ) {
                    $collate = $wpdb->get_charset_collate();
                }
                $sql = "CREATE TABLE if not exists `{$wpdb->prefix}tmbooking_order` (
                `tmbooking_order_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `transport_id` int(11) unsigned NOT NULL,
                `start_date` datetime NOT NULL,
                `end_date` datetime NOT NULL,
                `order_id` int(11) unsigned DEFAULT NULL,
                `status` varchar(255) NOT NULL, 
                PRIMARY KEY (`tmbooking_order_id`),
                KEY `order_id` (`order_id`),
                KEY `start_date` (`start_date`),
                KEY `transport_id` (`transport_id`)
                ) {$collate};";
                dbDelta( $sql );

                add_option('tmbooking_order_created', 'created');
            }

        }
        //Add Hidden Product
        public function addHiddenWooProduct() {
            $objProduct = new WC_Product();
            $objProduct->set_name( __( 'Booking', 'tm-booking' ) );
            $objProduct->set_description( __( 'Product for making a RV reservation', 'tm-booking' ) );
            $objProduct->set_status( "publish" );
            $objProduct->set_catalog_visibility( 'hidden' );
            $objProduct->set_price( 1 );
            $objProduct->set_regular_price( 1 );
            $objProduct->set_manage_stock( false );
            $objProduct->set_stock_quantity( 11 );
            $objProduct->set_stock_status( 'instock' );
            $objProduct->set_backorders( 'no' );
            $objProduct->set_reviews_allowed( false );
            $objProduct->set_sold_individually( false );
            $objProduct->set_virtual( true );
            $product_id = $objProduct->save();

            update_option( 'tm_booking_product_default', $product_id );
        }

        /** Add Custom Function*/
        public function addCustomFunction() {
            // Основные файлы функций
            require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'function/custom_function.php');
            require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'function/ajax.php');
            
            // Файлы для индивидуального текста кнопки и видимости блока с ценами
            require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'function/ui/button-text.php'); // Функции для индивидуального текста кнопки бронирования (Functions for individual booking button text)
            require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'function/ui/price-text.php'); // Функции для индивидуального текста цены (Functions for individual price text)
            require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'function/price/price-list-visibility-ajax.php'); // AJAX для видимости блока с ценами (AJAX for price block visibility)
            
            // Файлы для минимального количества дней бронирования
            require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'function/min-booking-days/min-booking-days-ajax.php'); // AJAX для проверки минимального количества дней (AJAX for checking minimum booking days)
            require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'function/min-booking-days/min-booking-days-display.php'); // Отображение информации о минимальном количестве дней (Display information about minimum booking days)
            require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'function/min-booking-days/min-booking-days-info.php'); // Функции для отображения информации о минимальном количестве дней в форме (Functions for displaying minimum booking days information in form)
            require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'function/min-booking-days/min-days-form-display.php'); // Прямое добавление информации о минимальных днях в форму (Direct addition of minimum days information to form)
            require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'function/ui/enqueue-min-day-hide.php'); // Add min-day-hide class to booking buttons (Добавление класса min-day-hide к кнопкам бронирования)
            
            // Файлы для скидок (Files for discounts)
            //require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'function/discount-functions.php');
            //require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'function/discount-fields.php');
            //require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'function/discount-logger.php');
            require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'function/discount/discount-ajax.php'); // AJAX для скидок (AJAX for discounts)
            //require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'function/discount-display.php');
            require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'function/discount/discount-fix.php'); // Исправления для скидок (Fixes for discounts)
            // Debug scripts removed as they are no longer needed (Отладочные скрипты удалены, так как они больше не нужны)
            require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'function/discount/discount-calculation.php'); // Расчет скидок (Discount calculation)
            
            // Шорткод для календаря поиска (Search calendar shortcode)
    // Шорткод календаря поиска перенесен в плагин pix-auto-deal
    // require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'function/search-calendar-shortcode.php'); // Шорткод для календаря поиска с фильтрами
        }
        


        /** Add Custom Dashboard*/
        public function addDashboard() {
            require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH.'dashboard/dashboard.php');

            // Include Calendar Class
            require_once TMBOOKING_THEME_HELPER_PLUGIN_PATH . 'includes/admin/calendar/class-tm-booking-calendar.php';
        }
        /** Add Custom Styles*/
        public function addStyles() {
            wp_enqueue_style( 'tmbooking_main', plugin_dir_url( __FILE__ ) .  '/function/assets/css/main.css',  array(),'1.0' );
            wp_enqueue_style( 'tmbooking_nice_select_style', plugin_dir_url( __FILE__ ) .  '/function/assets/css/nice-select.css',  array(),'1.0' );
            wp_enqueue_script( 'tmbooking_moment', plugin_dir_url( __FILE__ ) .  '/function/assets/js/moment.min.js',  array(),'1.0' );
            wp_enqueue_script( 'tmbooking_daterangepicker', plugin_dir_url( __FILE__ ) .  '/function/assets/js/daterangepicker.js', array('jquery'), '3.1' );
            wp_enqueue_style( 'tmbooking_daterangepicker', plugin_dir_url( __FILE__ ) .  '/function/assets/css/daterangepicker.css');
            // Подключаем стили для сообщения о недоступных датах (Dates are not available)
            wp_enqueue_style( 'tm_dates_not_available', plugin_dir_url( __FILE__ ) .  '/assets/css/tm-dates-not-available.css',  array(),'1.0' );
        }

        /** Construct Date format */
        public static function construct_date_format($date_format){
            switch ($date_format) {
                case 'MM.DD.YYYY':
                    $date_format = 'm.d.Y';
                    break;
                case 'DD.MM.YYYY':
                    $date_format = 'd.m.Y';
                    break;
                case 'MM-DD-YYYY':
                    $date_format = 'm-d-Y';
                    break;
                case 'DD-MM-YYYY':
                    $date_format = 'd-m-Y';
                    break;
                case 'MM/DD/YYYY':
                    $date_format = 'm/d/Y';
                    break;
                case 'DD/MM/YYYY':
                    $date_format = 'd/m/Y';
                    break;
            }
            return $date_format;
        }
    }
}

function tmbooking_helping_addons(){
    return new TMBooking__Helping_Addons();
}
tmbooking_helping_addons();





// Custom Elementor Option
require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH. '/elementor/elementor.php' );
function TMBooking_Helper_Core_Elementor() {
    $instance = TMBooking_Helper_Core_Elementor::instance( __FILE__, TMBOOKING_THEME_HELPER_PLUGIN_PATH );
    return $instance;
}
TMBooking_Helper_Core_Elementor();




function tmbooking_get_post_type(){
    $opt  = get_option('tm_booking_settings', true);
    if(!isset($opt['post_type']) || $opt['post_type'] == 'unset'){
        $default_booking_settings = get_option('tm_booking_settings', true);
        $default_booking_settings_add = [];
        if( class_exists('TMReviews__Helping_Addons') ) {
            $default_booking_settings_add['post_type'] = tmreviews_get_post_type();
        }
        if( class_exists('TMTransport__Helping_Addons') ) {
            $default_booking_settings_add['post_type'] = tmtransport_get_post_type();
        }
        if( class_exists('Pix_Autos') ) {
            $default_booking_settings_add['post_type'] = 'pixad-autos';
        }
        $default_booking_settings = array_merge($default_booking_settings, $default_booking_settings_add);
        update_option('tm_booking_settings', $default_booking_settings);
    }
    return get_option('tm_booking_settings', true)['post_type'];
}
add_filter( 'aioseo_schema_woocommerce_shipping_disable', '__return_true' );






