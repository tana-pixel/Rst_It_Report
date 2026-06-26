<?php
add_theme_support( 'post-thumbnails', tmbooking_get_post_type() );


add_action( 'init', 'tmbooking__transports_init' );
add_action( 'after_setup_theme', 'tmbooking__transports_init' );

if( !function_exists('tmbooking__transports_init') ){
    function tmbooking__transports_init() {

        /**
         * Register a taxonomy for transports Extra Items
         * http://codex.wordpress.org/Function_Reference/register_taxonomy
         */

        //Custom Extra Items for Transports
        $taxonomy_extra_labels = array(
            'name'                          => esc_html__( 'Extra Items', 'tm-booking' ),
            'singular_name'                 => esc_html__( 'Extra Item', 'tm-booking' ),
            'search_items'                  => esc_html__( 'Search Extra Items', 'tm-booking' ),
            'popular_items'                 => esc_html__( 'Popular Extra Items', 'tm-booking' ),
            'all_items'                     => esc_html__( 'All Extra Items', 'tm-booking' ),
            'parent_item'                   => esc_html__( 'Parent Extra Item', 'tm-booking' ),
            'parent_item_colon'             => esc_html__( 'Parent Extra Item:', 'tm-booking' ),
            'edit_item'                     => esc_html__( 'Edit Extra Item', 'tm-booking' ),
            'update_item'                   => esc_html__( 'Update Extra Item', 'tm-booking' ),
            'add_new_item'                  => esc_html__( 'Add New Extra Item', 'tm-booking' ),
            'new_item_name'                 => esc_html__( 'New Extra Item Name', 'tm-booking' ),
            'separate_items_with_commas'    => esc_html__( 'Separate Extra Items with commas', 'tm-booking' ),
            'add_or_remove_items'           => esc_html__( 'Add or remove Extra Items', 'tm-booking' ),
            'choose_from_most_used'         => esc_html__( 'Choose from the most used extra items', 'tm-booking' ),
            'menu_name'                     => esc_html__( 'Extra Items', 'tm-booking' ),
        );
        $taxonomy_extra_args = array(
            'labels'            => $taxonomy_extra_labels,
            'public'            => true,
            'show_in_nav_menus' => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_tagcloud'     => true,
            'hierarchical'      => true,
            'query_var'         => true,
            'show_in_rest'         => true,
            'rewrite'           => false,
        );
        register_taxonomy( 'transports-extra', array( tmbooking_get_post_type() ), $taxonomy_extra_args );


        /**
         * Register a taxonomy for transports Discount
         * http://codex.wordpress.org/Function_Reference/register_taxonomy
         */
        //Custom Discount for Transports
        $taxonomy_discount_labels = array(
            'name'                          => esc_html__( 'Discounts', 'tm-booking' ),
            'singular_name'                 => esc_html__( 'Discount', 'tm-booking' ),
            'search_items'                  => esc_html__( 'Search Discounts', 'tm-booking' ),
            'popular_items'                 => esc_html__( 'Popular Discounts', 'tm-booking' ),
            'all_items'                     => esc_html__( 'All Discounts', 'tm-booking' ),
            'parent_item'                   => esc_html__( 'Parent Discount', 'tm-booking' ),
            'parent_item_colon'             => esc_html__( 'Parent Discount:', 'tm-booking' ),
            'edit_item'                     => esc_html__( 'Edit Discount', 'tm-booking' ),
            'update_item'                   => esc_html__( 'Update Discount', 'tm-booking' ),
            'add_new_item'                  => esc_html__( 'Add New Discount', 'tm-booking' ),
            'new_item_name'                 => esc_html__( 'New Discount Name', 'tm-booking' ),
            'separate_items_with_commas'    => esc_html__( 'Separate Discounts with commas', 'tm-booking' ),
            'add_or_remove_items'           => esc_html__( 'Add or remove Discounts', 'tm-booking' ),
            'choose_from_most_used'         => esc_html__( 'Choose from the most used Discounts', 'tm-booking' ),
            'menu_name'                     => esc_html__( 'Discounts', 'tm-booking' ),
        );

        $taxonomy_discount_args = array(
            'labels'            => $taxonomy_discount_labels,
            'public'            => true,
            'show_in_nav_menus' => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_tagcloud'     => false,
            'hierarchical'      => true,
            'query_var'         => true,
            'show_in_rest'         => true,
            'rewrite'           => false,
        );
        register_taxonomy( 'transports-discount', array( tmbooking_get_post_type() ), $taxonomy_discount_args );


        /**
         * Register a taxonomy for transports Locations
         * http://codex.wordpress.org/Function_Reference/register_taxonomy
         */
        //Custom Locations for Transports
        $taxonomy_location_labels = array(
            'name'                          => esc_html__( 'Pick up Locations', 'tm-booking' ),
            'singular_name'                 => esc_html__( 'Pick up Location', 'tm-booking' ),
            'search_items'                  => esc_html__( 'Search Pick up Locations', 'tm-booking' ),
            'popular_items'                 => esc_html__( 'Popular Pick up Locations', 'tm-booking' ),
            'all_items'                     => esc_html__( 'All Pick up Locations', 'tm-booking' ),
            'parent_item'                   => esc_html__( 'Parent Pick up Location', 'tm-booking' ),
            'parent_item_colon'             => esc_html__( 'Parent Pick up Location:', 'tm-booking' ),
            'edit_item'                     => esc_html__( 'Edit Pick up Location', 'tm-booking' ),
            'update_item'                   => esc_html__( 'Update Pick up Location', 'tm-booking' ),
            'add_new_item'                  => esc_html__( 'Add New Pick up Location', 'tm-booking' ),
            'new_item_name'                 => esc_html__( 'New Pick up Location Name', 'tm-booking' ),
            'separate_items_with_commas'    => esc_html__( 'Separate Pick up Locations with commas', 'tm-booking' ),
            'add_or_remove_items'           => esc_html__( 'Add or remove Pick up Locations', 'tm-booking' ),
            'choose_from_most_used'         => esc_html__( 'Choose from the most used Pick up Locations', 'tm-booking' ),
            'menu_name'                     => esc_html__( 'Pick up Locations', 'tm-booking' ),
        );

        $taxonomy_location_args = array(
            'labels'            => $taxonomy_location_labels,
            'public'            => true,
            'show_in_nav_menus' => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_tagcloud'     => false,
            'hierarchical'      => true,
            'query_var'         => true,
            'show_in_rest'         => true,
            'rewrite'           => false,
        );
        register_taxonomy( 'transports-locations', array( tmbooking_get_post_type() ), $taxonomy_location_args );


        /**
         * Register a taxonomy for transports Drop off Locations
         * http://codex.wordpress.org/Function_Reference/register_taxonomy
         */
        //Custom Locations for Transports
        $taxonomy_location_labels = array(
            'name'                          => esc_html__( 'Drop off Locations', 'tm-booking' ),
            'singular_name'                 => esc_html__( 'Drop off Location', 'tm-booking' ),
            'search_items'                  => esc_html__( 'Search Drop off Locations', 'tm-booking' ),
            'popular_items'                 => esc_html__( 'Popular Drop off Locations', 'tm-booking' ),
            'all_items'                     => esc_html__( 'All Drop off Locations', 'tm-booking' ),
            'parent_item'                   => esc_html__( 'Parent Drop off Location', 'tm-booking' ),
            'parent_item_colon'             => esc_html__( 'Parent Drop off Location:', 'tm-booking' ),
            'edit_item'                     => esc_html__( 'Edit Drop off Location', 'tm-booking' ),
            'update_item'                   => esc_html__( 'Update Drop off Location', 'tm-booking' ),
            'add_new_item'                  => esc_html__( 'Add New Drop off Location', 'tm-booking' ),
            'new_item_name'                 => esc_html__( 'New Drop off Location Name', 'tm-booking' ),
            'separate_items_with_commas'    => esc_html__( 'Separate Drop off Locations with commas', 'tm-booking' ),
            'add_or_remove_items'           => esc_html__( 'Add or remove Drop off Locations', 'tm-booking' ),
            'choose_from_most_used'         => esc_html__( 'Choose from the most used Drop off Locations', 'tm-booking' ),
            'menu_name'                     => esc_html__( 'Drop off Locations', 'tm-booking' ),
        );

        $taxonomy_location_args = array(
            'labels'            => $taxonomy_location_labels,
            'public'            => true,
            'show_in_nav_menus' => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_tagcloud'     => false,
            'hierarchical'      => true,
            'query_var'         => true,
            'show_in_rest'         => true,
            'rewrite'           => false,
        );
        register_taxonomy( 'transports-dr-locations', array( tmbooking_get_post_type() ), $taxonomy_location_args );


        /**
         * Register a taxonomy for transports Delivery
         * http://codex.wordpress.org/Function_Reference/register_taxonomy
         */
        //Custom Locations for Transports
        $taxonomy_location_labels = array(
            'name'                          => esc_html__( 'Delivery', 'tm-booking' ),
            'singular_name'                 => esc_html__( 'Delivery', 'tm-booking' ),
            'search_items'                  => esc_html__( 'Search Delivery', 'tm-booking' ),
            'popular_items'                 => esc_html__( 'Popular Delivery', 'tm-booking' ),
            'all_items'                     => esc_html__( 'All Delivery', 'tm-booking' ),
            'parent_item'                   => esc_html__( 'Parent Delivery Location', 'tm-booking' ),
            'parent_item_colon'             => esc_html__( 'Parent Delivery Location:', 'tm-booking' ),
            'edit_item'                     => esc_html__( 'Edit Delivery Location', 'tm-booking' ),
            'update_item'                   => esc_html__( 'Update Delivery Location', 'tm-booking' ),
            'add_new_item'                  => esc_html__( 'Add New Delivery Location', 'tm-booking' ),
            'new_item_name'                 => esc_html__( 'New Delivery Name', 'tm-booking' ),
            'separate_items_with_commas'    => esc_html__( 'Separate Delivery with commas', 'tm-booking' ),
            'add_or_remove_items'           => esc_html__( 'Add or remove Delivery', 'tm-booking' ),
            'choose_from_most_used'         => esc_html__( 'Choose from the most used Delivery', 'tm-booking' ),
            'menu_name'                     => esc_html__( 'Delivery', 'tm-booking' ),
        );

        $taxonomy_location_args = array(
            'labels'            => $taxonomy_location_labels,
            'public'            => true,
            'show_in_nav_menus' => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_tagcloud'     => false,
            'hierarchical'      => true,
            'query_var'         => true,
            'show_in_rest'         => true,
            'rewrite'           => false,
        );
        register_taxonomy( 'transports-delivery', array( tmbooking_get_post_type() ), $taxonomy_location_args );


    }
}


