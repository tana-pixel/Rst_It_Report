<?php

defined( 'ABSPATH' ) or die();

class TMBooking_Helper_Core_Elementor {

    private static $_instance = null;

    private $_version;
    private $file;
    private $dir;
    private $widgets_dir;
    private $assets_dir;
    private $assets_url;
    private $_token;

    function __construct( $file, $version = '1.0.0' ) {

        $this->_version    = $version;
        $this->file        = $file;
        $this->dir         = dirname( $this->file );
        $this->widgets_dir = trailingslashit( $this->dir ) . 'elementor';
        $this->assets_dir  = trailingslashit( $this->dir ) . 'assets';
        $this->assets_url  = esc_url( trailingslashit( plugins_url( '/elementor/assets/', $this->file ) ) );
        $this->_token      = 'tm-booking-core-elementor';


        add_action( 'elementor/init', [ $this, 'load_elementor_widgets' ] );
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ], 1 );
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_elementor_widgets' ] );
        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'elementor_add_js' ],99 );
        add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'elementor_add_css_editor' ] );


    }

    public function load_elementor_widgets() {
        require_once $this->widgets_dir . '/widgets/booking_form.php';
        require_once $this->widgets_dir . '/widgets/price.php';
    }

    public function register_elementor_widgets() {
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TMBooking_Form() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TMBooking_Price() );
    }

    public function add_elementor_widget_categories( $elements_manager ) {
        $elements_manager->add_category(
            'tm-booking-core-elementor',
            [
                'title' => __( 'TM Booking', 'tm-booking' ),
                'icon' => 'fa fa-plug',
            ]
        );
    }

    /** Add Custom Widgets*/


    public function elementor_add_js() {
        $is_preview_mode = class_exists( 'Elementor\Plugin' ) && \Elementor\Plugin::$instance->preview->is_preview_mode();
        if ( $is_preview_mode ) {
            wp_register_script( $this->_token . '-elementor', esc_url( $this->assets_url ) . 'js/elementor.js', ['jquery'], $this->_version );
            wp_enqueue_script( $this->_token . '-elementor' );
            wp_register_script( $this->_token . '-custom-animation-elementor', esc_url( $this->assets_url ) . 'js/elementor_custom_animation.js', ['jquery'], $this->_version );
            wp_enqueue_script( $this->_token . '-custom-animation-elementor' );
        }
    }


    public function elementor_add_css_editor() {
        wp_register_style( $this->_token . '-elementor', esc_url( $this->assets_url ) . 'css/elementor.css', [], $this->_version );
        wp_enqueue_style( $this->_token . '-elementor' );
    }

    public static function instance( $file = '', $version = '1.0.0' ) {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self( $file, $version );
        }

        return self::$_instance;
    } // End instance ()


    public function __clone() {
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'tm-booking' ), $this->_version );
    } // End __clone ()


    public function __wakeup() {
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'tm-booking' ), $this->_version );
    } // End __wakeup ()


}

class TMBooking_Elementor_Extension {
    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );
    }

    public function add_elementor_widget_categories( $elements_manager ) {
        $elements_manager->add_category(
            'tm-booking',
            [
                'title' => __( 'TM Reviews', 'tm-booking' ),
                'icon' => 'fa fa-plug',
            ]
        );
    }
}

// Custom Controle
require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH. '/elementor/custom-controle/image-selector/custom-control-init.php' );