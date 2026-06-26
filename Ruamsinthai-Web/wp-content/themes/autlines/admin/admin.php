<?php

if(!class_exists('AUTLINES_Admin')):
class AUTLINES_Admin {
    public $admin_path;
    public $theme_slug;
    public $theme_name;
    public $theme_version;
    public $theme_uri;
    public $theme_is_child;
    public $theme_id;
    /**
     * The single class instance.
     *
     * @since 1.0.0
     * @access private
     *
     * @var object
     */
    private static $_instance = null;

    /**
    * Main Instance
    * Ensures only one instance of this class exists in memory at any one time.
    *
    */
    public static function instance () {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
            self::$_instance->init_globals();
            self::$_instance->init_includes();
            self::$_instance->init_actions();
        }
        return self::$_instance;
    }

    private function __construct () {
        /* We do nothing here! */
        $this->admin_path = get_template_directory() . '/admin';

        // get theme data
        $theme_data = wp_get_theme();
        $theme_parent = $theme_data->parent();
        if(!empty($theme_parent)) {
            $theme_data = $theme_parent;
        }

        $this->theme_slug = $theme_data->get_stylesheet();
        $this->theme_name = $theme_data['Name'];
        $this->theme_version = $theme_data['Version'];
        $this->theme_uri = $theme_data->get('ThemeURI');
        $this->theme_is_child = !empty($theme_parent);
    }

    /**
     * Init Global variables
     */
    private function init_globals () {
        $extra_headers = get_file_data(get_template_directory() . '/style.css', array(
            'Theme ID' => 'Theme ID'
        ), 'fL_theme');
        $this->theme_id = $extra_headers['Theme ID'];
    }

    /**
     * Init Included Files
     */
    private function init_includes () {
        require $this->admin_path . '/option/options-setting.php';
        require $this->admin_path . '/option/kirki-options.php';
        require $this->admin_path . '/option/acf-metaboxes.php';
    }

    /**
     * Setup the hooks, actions and filters.
     */
    private function init_actions () {
        add_action('wp_enqueue_scripts', array($this, 'autlines_enqueue_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'autlines_enqueue_styles'));

        if (is_admin()) {
            add_action('admin_print_styles', array($this, 'admin_print_styles'));
        }
    }
    


    /**
     * Print Styles
     */
    public function admin_print_styles () {
        wp_enqueue_media();
        wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/css/libs/font-awesome.css', array(), '4.7');
        wp_enqueue_style('autlines-theme-admin-style', get_template_directory_uri() . '/admin/assets/css/style.css', array(), '1.0');
        if(class_exists('Kirki')){
            wp_enqueue_style('autlines-customize-icon-admin-style', get_template_directory_uri() . '/admin/assets/css/customize-icon-style.css', array(), '1.0');
        }
        wp_enqueue_script('autlines-admin-script', get_template_directory_uri() . '/admin/assets/js/admin-scripts.js', '', '', true);
        //Icon Picker
        wp_enqueue_script('fonticonpicker', get_template_directory_uri() . '/admin/assets/js/libs/fonticonpicker.js', '', '', true);
        wp_enqueue_style('icon-piker', get_template_directory_uri() . '/admin/assets/css/libs/icon-piker.css', array(), '1.0');

        wp_register_script( 'autlines-custom-wp-admin-script', get_template_directory_uri() . '/admin/assets/js/custom-admin.js', array( 'jquery' ) );
        wp_localize_script( 'autlines-custom-wp-admin-script', 'meta_image',
            array(
                'title' => esc_html__( 'Choose or Upload an Image', 'autlines' ),
                'button' => esc_html__( 'Use this image', 'autlines' ),
            )
        );

        wp_enqueue_script( 'autlines-custom-wp-admin-script' );

    }

    public function autlines_save_google_fonts_url() {
        $fonts_url = '//fonts.googleapis.com/css2?';
        $fonts = array();
        $subsets = 'latin-text';

        $fonts[] = 'family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap';

        if ( $fonts ) {

            foreach ($fonts as $f){
                $fonts_url .= $f;
            }

        }
        return $fonts_url;


    }
    public function autlines_save_google_fonts_url_two() {
        $fonts_url = '//fonts.googleapis.com/css2?';
        $fonts = array();
        $subsets = 'latin-text';
        $fonts[] = 'family=Lato:wght@100;200;300;400;500;600;700;800;900&display=swap';
        if ( $fonts ) {

            foreach ($fonts as $f){
                $fonts_url .= $f;
            }

        }
        return $fonts_url;
    }

    public function autlines_enqueue_styles() {

        //CSS Libs
        wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/libs/bootstrap.css', array(), '4.0');
        wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/libs/font-awesome.css', array(), '4.7');
        wp_enqueue_style( 'autlines-custom-icon-font', get_template_directory_uri() . '/assets/css/libs/fl-custom-font.css', array(), '1.0');
        wp_enqueue_style( 'simple-line-icons', get_template_directory_uri() . '/assets/css/libs/simple-line-icons.css', array(), '1.0');
        wp_enqueue_style( 'modal-box', get_template_directory_uri() . '/assets/css/libs/modal-box.css', array(), '1.1.0');
        wp_enqueue_style( 'fullcalendar', get_template_directory_uri() . '/assets/css/libs/main_file/fullcalendar.css', array(), '2.1.1');


        // General css
        wp_enqueue_style( 'autlines-general', get_template_directory_uri() . '/assets/css/general.css', array(), '1.0');
        wp_enqueue_style( 'autlines-vc-page-builder-style', get_template_directory_uri() . '/assets/css/vc-page-builder-style.css', array(), '1.0');
        wp_enqueue_style( 'autlines-new-style', get_template_directory_uri() . '/assets/css/new-style-css.css', array(), '1.0');

        // Kirki Save if plugin not active
        wp_enqueue_style( 'autlines-save-google-fonts-two', $this->autlines_save_google_fonts_url_two(), false, '1.0' );
        wp_enqueue_style( 'autlines-save-google-fonts', $this->autlines_save_google_fonts_url(), false, '1.0' );



        if ( !class_exists( 'Kirki' ) ) {


            wp_enqueue_style( 'autlines-save-kirki-customizer', get_template_directory_uri() .'/assets/css/kirki-save.css', array(), '1.0');
        }
    }



    public function autlines_enqueue_scripts() {

        $api_key = autlines_get_theme_mod('google_api_key');

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        wp_enqueue_script( 'imagesloaded' );
        wp_enqueue_script( 'jquery-ui-widget' );


        // Plugin Custom Js
        wp_enqueue_script( 'bootstrap-bundle', get_template_directory_uri() . '/assets/js/vendors-libs/bootstrap-bundle.js', array( 'jquery' ), '4.0', true );
        wp_enqueue_script( 'slick', get_template_directory_uri()  . '/assets/js/vendors-libs/slick.js', array( 'jquery' ), '1.8.0', true );
        wp_enqueue_script( 'custom-select', get_template_directory_uri() . '/assets/js/vendors-libs/jelect.js', array( 'jquery' ), '1.0', true );

        wp_enqueue_script( 'isotope', get_template_directory_uri() . '/assets/js/vendors-libs/isotope.js', array( 'jquery' ), '3.0.6', true );
        wp_enqueue_script( 'cookie', get_template_directory_uri() . '/assets/js/vendors-libs/cookie.js', array( 'jquery' ), '1.4.1', true );
        wp_enqueue_script( 'count-to', get_template_directory_uri() . '/assets/js/vendors-libs/count-to.js', array( 'jquery' ), '1.0', true );
        wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/assets/js/vendors-libs/magnific-popup.js', array( 'jquery' ), '1.1.0', true );
        wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/assets/js/vendors-libs/waypoints.js', array( 'jquery' ), '4.0.1', true );
        wp_enqueue_script( 'mega-menu', get_template_directory_uri() . '/assets/js/vendors-libs/mega-menu.js', array( 'jquery' ), '1.0', true );
        wp_enqueue_script( 'theia-sticky-sidebar', get_template_directory_uri() . '/assets/js/vendors-libs/theia-sticky-sidebar.js', array( 'jquery' ), '1.7.0', true );
        wp_enqueue_script( 'tween-max', get_template_directory_uri() . '/assets/js/vendors-libs/TweenMax.js', array( 'jquery' ), '2.0.2', true );
        wp_enqueue_script( 'velocity', get_template_directory_uri() . '/assets/js/vendors-libs/velocity.js', array( 'jquery' ), '1.5.0', true );
        wp_enqueue_script( 'velocity-pack', get_template_directory_uri() . '/assets/js/vendors-libs/velocity-ui-pack.js', array( 'jquery' ), '5.0.4', true );
        wp_enqueue_script( 'nouislider', get_template_directory_uri() . '/assets/js/vendors-libs/nouislider.js', array( 'jquery' ), '8.5.1', true );
        wp_enqueue_script( 'w-numb', get_template_directory_uri() . '/assets/js/vendors-libs/w-numb.js', array( 'jquery' ), '1.0', true );

        if ( class_exists('WooCommerce') ) {
            // Woo JS
            wp_enqueue_script( 'autlines-woo-custom',get_template_directory_uri() . '/assets/js/woo-scripts.js',array( 'jquery' ),('1.0'),true );
        }

        //Mega Menu
        wp_enqueue_script( 'mega-menu-start', get_template_directory_uri() . '/assets/js/vendors-libs/mega-menu/mega-menu-start.js', array( 'jquery' ),'1.0', true );

        // Preloader
        if(autlines_get_theme_mod('preloader_page_show') == 'true') {
            wp_enqueue_script( 'autlines-page-loader', get_template_directory_uri() . '/assets/js/vendors-libs/autlines-page-loader.js', array( 'jquery' ), '1.0', true );
        }

        // Google Maps
        wp_register_script( 'gmap3', get_template_directory_uri() . '/assets/js/vendors-libs/gmap3.js', array( 'jquery' ), '', true );

        wp_enqueue_script( 'hotspot', get_template_directory_uri() . '/assets/js/vendors-libs/hotspot.js', array( 'jquery' ), '1.0', true );

        // Theme Js Custom File
        wp_enqueue_script( 'autlines-custom-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), '1.0', true );

        // Google Api Key
        if ($api_key !=''){
            wp_enqueue_script( 'google-maps-api', '//maps.googleapis.com/maps/api/js?key='.esc_attr($api_key) );
        }


    }


    /**
     * Returns the login form
     */

    public static function autlines_login_form() {
    $args = array(
        'redirect'                      =>  esc_url( wp_login_url( get_permalink() ) ),
        'form_id'                       => 'loginform-custom',
        'label_username'                => '',
        'label_password'                => '',
    );

    if (class_exists('Fl_Login_Form_Widget')) {
        $args = array(
            'label_log_in'              => esc_html__('Sign in', 'autlines'),
            'label_lost_password'       => esc_html__('Forgot password', 'autlines').'?',
        );

        $autlines_login_widget = new Fl_Login_Form_Widget();

        $autlines_login_widget->wp_login_form($args);
    } else {
        wp_login_form($args);
    }

    }



}
endif;
if ( ! function_exists( 'autlines_admin' ) ) :
function autlines_admin() {
	return AUTLINES_Admin::instance();
}
endif;

autlines_admin();


//Custom Styles Option
function autlines_custom_style() {
    $custom_css = '';
    $primary_color = autlines_get_theme_mod('primary_color_setting');
    $secondary_color = autlines_get_theme_mod('secondary_color_setting');
    $border_color = autlines_get_theme_mod('theme_border_color');
    // Custom CSS
    $custom_css .= 'input,textarea,select,input[type=email], input[type=password], input[type=search], input[type=tel], input[type=text], input[type=url], select, textarea{border-color:'.$border_color.'}';
    $custom_css .='footer.fl--footer{background-size: cover!important;background-position: 50% 0!important;}';
    $custom_css .='.fl-tabs .nav-tabs li .tab-link-content .inner-content .tab-title-content{background-color: '.$primary_color.';}';
    $custom_css .='.fl-pagination.button-container{background-color:'.$secondary_color.';}';
    $custom_css .='.fl-pagination.button-container .fl-vc-button:after{background-color:'.$primary_color.';}';
    $custom_css .='.fl-vc-car-detail-wrapper .car-detail-slider .slick-dots li.slick-active button,.fl-vc-car-detail-wrapper .car-detail-slider .slick-dots li button:hover{background-color:'.$secondary_color.';}';
    $custom_css .='.fl-vc-car-detail-wrapper .car-detail-slider .slick-dots li.slick-active button,.fl-vc-car-detail-wrapper .car-detail-slider .slick-dots li button:hover{border-color:'.$secondary_color.';}';
    $custom_css .= '.fl-hotspot-shortcode .HotspotPlugin_Hotspot:not(.flHotspotImageMarker):before{background-color:'.$primary_color.';}';
    $custom_css .='.vc-offer-slider .offer-slider-slide .offer-slide-inner-content .offer-slider-bottom-content{background-color:'.$primary_color.';}';
    $custom_css .= '.vc-offer-slider .offer-slider-slide .offer-slide-inner-content .offer-slider-top-content i{color:'.$primary_color.';}';
    $custom_css .='.vc-offer-slider .slick-arrow:hover:before{border-color:'.$primary_color.';}';
    $custom_css .= '.vc-offer-slider .slick-arrow:after{background-color:'.$primary_color.';}';
    $custom_css .= '.vc-number-content-container .number-div-content .inner-content .number-title{color:'.$primary_color.';}';
    $custom_css .= '.testimonial-slider .fl-testimonial-slide .bottom-content i{color:'.$primary_color.';}';
    $custom_css .= '.fl-action-content-wrapper-vc.default-bg .vc-fl-action-content .inner-content{background-color:'.$primary_color.';}';
    $custom_css .='.vc-offer-slider .offer-slider-slide.slick-current .offer-slider-top-content i{color:'.$secondary_color.';}';
    $custom_css .= '.vc-number-content-container .number-div-content .inner-content .number:after{background-color:'.$secondary_color.';}';
    $custom_css .= '.fl-action-content-wrapper-vc .vc-fl-action-content .inner-content .action-btn:hover:before{border-color:'.$secondary_color.'}';
    $custom_css .= '.fl-action-content-wrapper-vc .vc-fl-action-content .inner-content .action-btn:hover:after{background-color:'.$secondary_color.'}';
    $custom_css .= '.shop-archive-item:hover .fl-woo-item-inner-content .yith-wcwl-add-to-wishlist a.add_to_wishlist, .shop-archive-item:hover .fl-woo-item-inner-content .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,.shop-archive-item:hover .fl-woo-item-inner-content .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a{color:'.$primary_color.';}';
    $custom_css .= '.shop-archive-item .fl-woo-item-inner-content .yith-wcwl-add-to-wishlist a.add_to_wishlist:hover, .shop-archive-item:hover .fl-woo-item-inner-content .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,.shop-archive-item:hover .fl-woo-item-inner-content .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a{color:'.$secondary_color.';}';
    $custom_css .= '.shop-archive-item .fl-woo-item-inner-content .fl-woo-item-bottom-content .fl--woo-add-to-cart-wrap .fl--add-to-cart-btn a{background-color:'.$primary_color.';}';
    $custom_css .= '.shop-archive-item .fl-woo-item-inner-content .fl-woo-item-bottom-content .fl--woo-add-to-cart-wrap .fl--add-to-cart-btn a:hover{background-color:'.$secondary_color.';}';
    $custom_css .= '.shop-archive-item .fl-woo-item-inner-content .fl-woo-item-bottom-content .fl--woo-category-wrapper a:hover{color:'.$secondary_color.';}';
    $custom_css .= '.fl-shop-slider .slick-dots li button:hover, .fl-shop-slider .slick-dots li.slick-active button{background-color:'.$secondary_color.';}';
    $custom_css .= '.fl-shop-slider .slick-next:hover::before, .fl-shop-slider .slick-prev:hover::before{border-color:'.$primary_color.';}';
    $custom_css .='.fl-shop-slider .slick-next:hover::after, .fl-shop-slider .slick-prev:hover::after{background-color:'.$primary_color.';}';
    $custom_css .= '.fl-contact-info-wrapper-vc i{color:'.$secondary_color.'}';
    $custom_css .= '.fl-phone-number-wrapper-vc.phone-style-two .phone-text{color:'.$primary_color.';}';
    $custom_css .='.fl-icon-box .fl-icon-box-wrapper .icon-box-icon-wrapper i{color:'.$secondary_color.'}';
    $custom_css .= '.fl-services-slider-content-vc .fl-services-slider .slick-dots li button:hover:before, .fl-services-slider-content-vc .fl-services-slider .slick-dots li.slick-active button:before{background-color:'.$secondary_color.'}';
    $custom_css .= '.fl-team-slider-content-vc .fl-team-slider .team-slider-slide .slider-entry-content .team-social li a:hover{color:'.$secondary_color.'}';
    $custom_css .='.fl-team-slider-content-vc .fl-team-slider .slick-dots li button:hover:before, .fl-team-slider-content-vc .fl-team-slider .slick-dots li.slick-active button:before{background-color:'.$secondary_color.'}';
    $custom_css .= '.fl-header-decor-text-wrapper-vc .decor-header-text{color:'.$secondary_color.'}';
    $custom_css .= '.fl-header-decor-text-wrapper-vc .decor-header-text:after{background-color:'.$primary_color.'}';
    $custom_css .= '.fl-blog-post-div .post-style-default .fl-post--item .post-right-content .post-btn-read-more a{background:'.$secondary_color.'}';
    $custom_css .= '.fl-blog-post-div .post-style-default .fl-post--item .post-right-content .post-btn-read-more a:hover{background:'.$primary_color.'}';
    $custom_css .= '.jelect-option:hover, .jelect-option_state_active{background-color:'.$secondary_color.'}';
    $custom_css .='.custom-rev-slider-price-bg .bg-inner,.header-custom-decor-rev-slider:after{background-color:'.$primary_color.';}';
    $custom_css .='.custom-rev-slider-price-bg .bg-inner:after{background-color:'.$primary_color.';opacity:.6;}';
    $custom_css .='.woocommerce div.product .woocommerce-tabs ul.tabs li.active{background-color:'.$secondary_color.'}';
    $custom_css .='.woocommerce div.product form.cart button:before{background-color:'.$secondary_color.'}';
    $custom_css .='.woocommerce div.product form.cart button:after{background-color:'.$primary_color.'}';
    $custom_css .= '.wc-tab#tab-reviews form.comment-form .submit-btn-container button:after{background-color:'.$primary_color.'}';
    $custom_css .= '.header-search-form .search-form-row .searchsubmit button:after{background-color:'.$primary_color.'}';
    $custom_css .='.woocommerce table.shop_table tbody tr td.actions .coupon button,.woocommerce table.shop_table tbody tr td.actions .update--cart-content button.update_cart,.woocommerce .cart-collaterals .cart_totals a.checkout-button,.woocommerce .return-to-shop a.wc-backward,form.checkout #order_review #payment .place-order button,.woocommerce form.login .form-row button.button,.woocommerce form.lost_reset_password button.button,.woocommerce button.button{ background-color:'.$secondary_color.'}';
    $custom_css .='.woocommerce table.shop_table tbody tr td.actions .coupon button:hover,.woocommerce table.shop_table tbody tr td.actions .update--cart-content button.update_cart:hover:enabled,.woocommerce .cart-collaterals .cart_totals a.checkout-button:hover,.woocommerce .return-to-shop a.wc-backward:hover,form.checkout #order_review #payment .place-order button:hover,.woocommerce form.login .form-row button.button:hover,.woocommerce form.lost_reset_password button.button:hover,.woocommerce button.button:hover{ background-color:'.$primary_color.'}';
    $custom_css .='.fl-flipper-icon .fl-back-content:hover .fl-custom-icon-plus-symbol,.sticky .post--title .title-link:after{color:'.$primary_color.';}';
    $custom_css .= '.login-in-btn:before{background-color:'.$secondary_color.'}';
    $custom_css .= '.login-in-btn:after{background-color:'.$primary_color.'}';
    $custom_css .= '.semi-circle-progress-bar-wrapper-vc.secondary-color-progress .vc-semi-circle-progress-bar span{color:'.$secondary_color.'}';
    $custom_css .= '.semi-circle-progress-bar-wrapper-vc.secondary-color-progress .vc-semi-circle-progress-bar .bar{border-bottom-color: '.$secondary_color.';border-right-color: '.$secondary_color.';}';
    $custom_css .= '.semi-circle-progress-bar-wrapper-vc.primary-color-progress .vc-semi-circle-progress-bar span{color:'.$primary_color.'}';
    $custom_css .= '.semi-circle-progress-bar-wrapper-vc.primary-color-progress .vc-semi-circle-progress-bar .bar{border-bottom-color: '.$primary_color.';border-right-color: '.$primary_color.';}';
    $custom_css .= '.fl-list .fl-list-ul li i{color:'.$secondary_color.'}';
    $custom_css .='form.fl-form-password-protected .fl-input-group button.fl-pass-button,.sidebar:not(.cars-sidebar) .widget_tag_cloud .tagcloud a:hover{background:'.$secondary_color.'}';
    $custom_css .='form.fl-form-password-protected .fl-input-group button.fl-pass-button:after{background:'.$primary_color.'}';
    $custom_css .='.fl--404-page-wrapper .fl-404-page-search-form .fl--search-form-404 .searchsubmit button:after,.fl--404-page-wrapper .btn-404-wrapper .fl-404-page-btn:after,.sidebar:not(.cars-sidebar) .widget_tag_cloud .tagcloud a,.sidebar:not(.cars-sidebar) .fl_login_form_widget .logout-btn-wrapper .logout-btn:after{background:'.$primary_color.'}';
    $custom_css .= '.sidebar.cars-sidebar .widget.pixad-filter .noUi-target,.sidebar.cars-sidebar .widget.pixad-filter .list-categories .list-categories__item input[type=checkbox]:checked+label{border-color:'.$primary_color.'}';
    $custom_css .='.sidebar.cars-sidebar .widget.pixad-filter .noUi-horizontal .noUi-handle:after,.sidebar.cars-sidebar .btn-wrapper button:after{background:'.$primary_color.'}';
    $custom_css .= '.sidebar.cars-sidebar .widget.pixad-filter .list-categories .list-categories__item input[type=checkbox]:checked+label .body-icon-wrapper i{color:'.$primary_color.'}';
    $custom_css .= '.fl-blog-post-div .post-style-default .fl-post--item .post-top-content .post--holder .post-info-category .category-post a,.fl-blog-post-div .post-style-grid .fl-post--item .post-top-content .post--holder .category-post a{background:'.$primary_color.';}';
    $custom_css .= '.fl-blog-post-div .post-style-default .fl-post--item .post-bottom-content .post-btn-read-more a:after{background:'.$primary_color.'!important;}';
    $custom_css .='.sidebar:not(.cars-sidebar) .widget_archive ul li a:hover,.sidebar:not(.cars-sidebar) .widget a:hover{color:'.$secondary_color.'}';
    $custom_css .='.sidebar:not(.cars-sidebar) .widget_calendar .calendar_wrap #wp-calendar tbody tr td a:hover:before,.sidebar:not(.cars-sidebar) .widget_calendar .calendar_wrap #wp-calendar tfoot #next a:hover, .sidebar:not(.cars-sidebar) .widget_calendar .calendar_wrap #wp-calendar tfoot #prev a:hover{background-color:'.$secondary_color.'}';
    $custom_css .='.sidebar:not(.cars-sidebar) .widget_rss ul li .rsswidget:hover{color:'.$secondary_color.'}';
    $custom_css .= '.fl-blog-post-div .post-style-default .fl-post--item .post-bottom-content .post-btn-read-more a{color:'.$primary_color.'}';
    $custom_css .='.woocommerce-MyAccount-navigation ul li a:hover{color:'.$secondary_color.';}';
    $custom_css .='.shop-archive-item .fl-woo-item-inner-content .fl-woo-item-bottom-content .fl--woo-add-to-cart-wrap .fl--add-to-cart-btn a.added_to_cart,.shop-archive-item .fl-woo-item-inner-content .fl-woo-item-bottom-content .fl--woo-add-to-cart-wrap .fl--add-to-cart-btn a.added_to_cart{background:'.$secondary_color.';}';
    $custom_css .='.single-add-to-compare{background:'.$primary_color.';}';
    $custom_css .='.single-product .woocommerce-message a.button, .single-product .woocommerce-message a, .woocommerce-info a.button, .woocommerce-info a, .woocommerce-message a.button, .woocommerce-message a{background:'.$primary_color.'!important;}';
    $custom_css .='.single-product .woocommerce-message a.button:hover, .single-product .woocommerce-message a:hover, .woocommerce-info a.button:hover, .woocommerce-info a:hover, .woocommerce-message a.button, .woocommerce-message a:hover{background:'.$secondary_color.'!important;}';
    $custom_css .= '.empty-search-wrapper .empty-search-wrapper-search-form form .searchsubmit button:after{background:'.$primary_color.'}';
    $custom_css .='form.checkout #order_review #payment ul.wc_payment_methods li input:checked:after{color:'.$secondary_color.';}';
    $custom_css .='.woocommerce form.checkout_coupon button:hover{background:'.$primary_color.';}';
    $custom_css .='.woocommerce-error{border-top-color:'.$primary_color.';}';
    $custom_css .='.woocommerce table.shop_table thead tr th{border-bottom-color:'.$secondary_color.'!important;}';
    $custom_css .= '.shipping-calculator-button{color:'.$secondary_color.';}';
    $custom_css .= '.shipping-calculator-button:hover,.woocommerce table.shop_table tbody tr td.product-name a:hover{color:'.$primary_color.';}';
    $custom_css .= '.woocommerce button.button:disabled[disabled]:hover{background-color:'.$primary_color.';}';
    $custom_css .='.single-product .woocommerce-message, .woocommerce-info, .woocommerce-message{border-top-color:'.$primary_color.'!important;}';
    $custom_css .= '.card__wrap-label .card__label,.car-details .auto-slider .sale{background-color:'.$secondary_color.';}';
    $custom_css .='.sidebar.cars-sidebar.with-title .sidebar-car-title:before{color:'.$secondary_color.'!important;}';

    // New Style
    $custom_css .='.vc-auto-search .noUi-horizontal .noUi-handle:after{background:'.$primary_color.'!important;}';
    $custom_css .='.vc-auto-search .noUi-target{border-color:'.$primary_color.'!important;}';
    wp_add_inline_style( 'autlines-general', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'autlines_custom_style',15);


function autlines_google_map_url() {
    $map_key = autlines_get_theme_mod('google_api_key');
    $map_url = '//maps.googleapis.com/maps/api/js?key='.$map_key.'&callback=initMap';
    return esc_url_raw( $map_url );
}



add_action('after_setup_theme', 'autlines_translate_theme_support_setup');
function autlines_translate_theme_support_setup(){

    $autlines_translate = array(
        'automatic' => esc_html__( 'Automatic', 'autlines' ),
        'manual' => esc_html__( 'Manual', 'autlines' ),
        'semi-automatic' => esc_html__( 'Semi-Automatic', 'autlines' ),
        'diesel' => esc_html__( 'Diesel', 'autlines' ),
        'electric' => esc_html__( 'Electric', 'autlines' ),
        'petrol' => esc_html__( 'Petrol', 'autlines' ),
        'hybrid' => esc_html__( 'Hybrid', 'autlines' ),
        'plugin_electric' => esc_html__( 'Plugin electric', 'autlines' ),
        'petrol+cng' => esc_html__( 'Petrol+CNG', 'autlines'  ),
        'lpg' => esc_html__( 'LPG', 'autlines'  ),
        'new' => esc_html__( 'New', 'autlines' ),
        'used' => esc_html__( 'Used', 'autlines' ),
        'driver' => esc_html__( 'Driver', 'autlines' ),
        'non driver' => esc_html__( 'Non driver', 'autlines' ),
        'barnfind' => esc_html__( 'Barnfind', 'autlines' ),
        'projectcar' => esc_html__( 'Projectcar', 'autlines' ),
        'in stock' => esc_html__( 'In stock', 'autlines' ),
        'expected' => esc_html__( 'Expected', 'autlines' ),
        'out of stock' => esc_html__( 'Out of stock', 'autlines' ),
        'front' => esc_html__( 'Front', 'autlines' ),
        'rear' => esc_html__( 'Rear', 'autlines' ),
        'left' => esc_html__( 'Left', 'autlines' ),
        'right' => esc_html__( 'Right', 'autlines' ),
        'fixed' => esc_html__( 'Fixed', 'autlines' ),
        'negotiable' => esc_html__( 'Negotiable', 'autlines' ),
        'no' => esc_html__( 'No', 'autlines' ),
        'yes' => esc_html__( 'Yes', 'autlines' ),
        'Featured' => esc_html__( 'Featured', 'autlines' ),
        'Sold' => esc_html__( 'Sold', 'autlines' ),
        'Request' => esc_html__( 'Request', 'autlines' ),
        'Reserved' => esc_html__( 'Reserved', 'autlines' ),
        'POA' => esc_html__( 'POA', 'autlines' ),
        'white' => esc_html__( 'white', 'autlines' ),
        'silver' => esc_html__( 'silver', 'autlines' ),
        'black' => esc_html__( 'black', 'autlines' ),
        'grey' => esc_html__( 'grey', 'autlines' ),
        'blue' => esc_html__( 'blue', 'autlines' ),
        'red' => esc_html__( 'red', 'autlines' ),
        'brown' => esc_html__( 'brown', 'autlines' ),
        'beige' => esc_html__( 'beige', 'autlines' ),
        'green' => esc_html__( 'green', 'autlines' ),
        'yellow' => esc_html__( 'yellow', 'autlines' ),
        'orange' => esc_html__( 'orange', 'autlines' ),
        'purple' => esc_html__( 'purple', 'autlines' ),
        'Year' => esc_html__( 'Year', 'autlines' ),
        'Drive' => esc_html__( 'Drive', 'autlines' ),
        'Auto Make' => esc_html__( 'Auto Make', 'autlines' ),
        'Auto Model' => esc_html__( 'Auto Model', 'autlines' ),
        'Auto Version' => esc_html__( 'Auto Version', 'autlines' ),
        'Mileage' => esc_html__( 'Mileage', 'autlines' ),
        'Fuel' => esc_html__( 'Fuel', 'autlines' ),
        'Engine' => esc_html__( 'Engine', 'autlines' ),
        'Horsepower' => esc_html__( 'Horsepower', 'autlines' ),
        'Transmission' => esc_html__( 'Transmission', 'autlines' ),
        'Doors' => esc_html__( 'Doors', 'autlines' ),
        'Seats' => esc_html__( 'Seats', 'autlines' ),
        'Color' => esc_html__( 'Color', 'autlines' ),
        'Interior Color' => esc_html__( 'Interior Color', 'autlines' ),
        'Condition' => esc_html__( 'Condition', 'autlines' ),
        'Purpose' => esc_html__( 'Purpose', 'autlines' ),
        'VIN' => esc_html__( 'VIN', 'autlines' ),
        'Price' => esc_html__( 'Price', 'autlines' ),
        'Sale Price' => esc_html__( 'Sale Price', 'autlines' ),
        'Stock Status' => esc_html__( 'Stock Status', 'autlines' ),
        'Price Type' => esc_html__( 'Price Type', 'autlines' ),
        'Warranty' => esc_html__( 'Warranty', 'autlines' ),
        'Currency' => esc_html__( 'Currency', 'autlines' ),
        'Updated Date' => esc_html__( 'Updated Date', 'autlines' ),
        "Seller Company"=> esc_html__( 'Seller Company', 'autlines' ),
        "Seller Email"=> esc_html__( 'Seller Email', 'autlines' ),
        "Seller Phone"=> esc_html__( 'Seller Phone', 'autlines' ),
        "Seller Country"=> esc_html__( 'Seller Country', 'autlines' ),
        "Seller State"=> esc_html__( 'Seller State', 'autlines' ),
        "Seller Town"=> esc_html__( 'Seller Town', 'autlines' ),
        "Seller Location"=> esc_html__( 'Seller Location', 'autlines' ),
        "Seller Location Latitude"=> esc_html__( 'Seller Location Latitude', 'autlines' ),
        "Seller Location Longitude"=> esc_html__( 'Seller Location Longitude', 'autlines' ),


    );

    update_option( '_pixad_auto_translate', serialize( $autlines_translate ) );

}
