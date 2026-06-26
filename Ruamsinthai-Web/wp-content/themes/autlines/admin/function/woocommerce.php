<?php
/**
 * Create a woo img container hover style
 */
if ( class_exists('WooCommerce') ) {

    // Other Functions
    get_template_part('admin/function/woo-function/other_woo_functions');
    // Single Product Function
    get_template_part('admin/function/woo-function/archive_function');
    // Archive Product Function
    get_template_part('admin/function/woo-function/single_function');


    //Declare WooCommerce support
    add_action( 'after_setup_theme', 'autlines_woocommerce_support' );
    function autlines_woocommerce_support() {
        add_theme_support( 'woocommerce' );
    }


    //Up sells Products columns based on options columns
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
    add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 15 );

    if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
        function woocommerce_output_upsells() {
            $autlines_column = 3;

            switch ( $autlines_column ) {
                case 'one' :
                    woocommerce_upsell_display( 1, 1 );
                    break;
                case 'two' :
                    woocommerce_upsell_display( 2, 2 );
                    break;
                case 'three' :
                    woocommerce_upsell_display( 3, 3 );
                    break;
                case 'four' :
                    woocommerce_upsell_display( 4, 4 );
                    break;
                case 'five' :
                    woocommerce_upsell_display( 5, 5 );
                    break;
            }
        }
    }


    add_action( 'init', 'autlines_remove_wc_breadcrumbs' );
    function autlines_remove_wc_breadcrumbs() {
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
    }

    //Load Custom Select JS and CSS
    function autlines_woo_enqueue_styles() {
        wp_enqueue_style( 'autlines-woo-style', get_template_directory_uri() .'/woocommerce/css/scss/woocommerce.css', array(), '1.0');
    }

    add_action( 'wp_enqueue_scripts', 'autlines_woo_enqueue_styles',45 );



    /**
     * ------------------------------------------------------------------------------------------------
     *  Products per page based on theme options
     * ------------------------------------------------------------------------------------------------
     */
    if(autlines_get_theme_mod('products_per_page')){
        function autlines_loop_shop_per_page( $cols ) {
            $cols = autlines_get_theme_mod('products_per_page');
            return $cols;
        }
        add_filter( 'loop_shop_per_page', 'autlines_loop_shop_per_page', 20 );
    }

}