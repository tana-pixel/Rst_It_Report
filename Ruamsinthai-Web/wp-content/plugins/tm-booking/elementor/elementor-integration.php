<?php
/**
 * TM Booking Elementor Integration
 * 
 * Интеграция плагина TM Booking с Elementor
 * 
 * @package TM Booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Класс интеграции TM Booking с Elementor
 */
class TMB_Elementor_Integration {

    /**
     * Экземпляр класса
     * 
     * @var TMB_Elementor_Integration
     */
    private static $instance = null;

    /**
     * Получение экземпляра класса
     * 
     * @return TMB_Elementor_Integration
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Конструктор класса
     */
    public function __construct() {
        // Регистрация категории виджетов
        add_action('elementor/elements/categories_registered', array($this, 'register_widget_categories'));
        
        // Регистрация виджетов
        add_action('elementor/widgets/register', array($this, 'register_widgets'));
        
        // Регистрация скриптов и стилей
        add_action('wp_enqueue_scripts', array($this, 'register_scripts'));
        
        // Добавление скриптов и стилей в редактор Elementor
        add_action('elementor/editor/before_enqueue_scripts', array($this, 'editor_scripts'));
    }

    /**
     * Регистрация категории виджетов
     * 
     * @param \Elementor\Elements_Manager $elements_manager Менеджер элементов Elementor
     */
    public function register_widget_categories($elements_manager) {
        $elements_manager->add_category(
            'tm-booking',
            [
                'title' => esc_html__('TM Booking', 'tm-booking'),
                'icon' => 'fa fa-calendar',
            ]
        );
    }

    /**
     * Регистрация виджетов
     * 
     * @param \Elementor\Widgets_Manager $widgets_manager Менеджер виджетов Elementor
     */
    public function register_widgets($widgets_manager) {
        // Подключаем файл виджета календаря
        require_once TMB_PLUGIN_DIR . 'elementor/widgets/booking-calendar-widget.php';
        
        // Регистрируем виджет
        $widgets_manager->register(new TMB_Booking_Calendar_Widget());
    }

    /**
     * Регистрация скриптов и стилей
     */
    public function register_scripts() {
        // Путь к директории плагина
        $plugin_url = plugin_dir_url(TMB_PLUGIN_FILE);
        
        // Регистрация библиотеки xdsoft datetimepicker
        if (!wp_script_is('jquery-datetimepicker', 'registered')) {
            // Проверяем, не зарегистрирована ли уже библиотека другим плагином
            wp_register_script(
                'tmb-datetimepicker-js',
                $plugin_url . 'elementor/assets/vendor/jquery.datetimepicker.full.min.js',
                array('jquery'),
                '2.5.20',
                true
            );
            
            wp_register_style(
                'tmb-datetimepicker-css',
                $plugin_url . 'elementor/assets/vendor/jquery.datetimepicker.min.css',
                array(),
                '2.5.20'
            );
        }
        
        // Регистрация скриптов и стилей виджета
        wp_register_script(
            'tmb-booking-calendar-js',
            $plugin_url . 'elementor/assets/js/tmb-booking-calendar.js',
            array('jquery', 'tmb-datetimepicker-js'),
            TMB_VERSION,
            true
        );
        
        wp_register_style(
            'tmb-booking-calendar-css',
            $plugin_url . 'elementor/assets/css/tmb-booking-calendar.css',
            array('tmb-datetimepicker-css'),
            TMB_VERSION
        );
    }

    /**
     * Добавление скриптов и стилей в редактор Elementor
     */
    public function editor_scripts() {
        // Подключаем стили для редактора
        wp_enqueue_style('tmb-datetimepicker-css');
        wp_enqueue_style('tmb-booking-calendar-css');
    }

    /**
     * Проверка наличия библиотеки xdsoft datetimepicker в плагине pix-booking-auto
     * 
     * @return bool
     */
    public function check_pix_booking_datetimepicker() {
        // Проверяем наличие файла библиотеки в плагине pix-booking-auto
        $pix_booking_path = WP_PLUGIN_DIR . '/pix-booking-auto/js/jquery.datetimepicker.full.min.js';
        
        return file_exists($pix_booking_path);
    }
}

// Инициализация интеграции с Elementor
TMB_Elementor_Integration::get_instance();
