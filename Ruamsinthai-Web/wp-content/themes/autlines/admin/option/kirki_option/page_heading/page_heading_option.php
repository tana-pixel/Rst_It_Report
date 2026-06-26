<?php
FL_Options::add_panel('header_option', array(
    'title'     => esc_attr__('Heading Setting', 'autlines'),
    'priority'  => 9,
    'icon'      => 'fa fa-header',
));
// Page Header
FL_Options::add_section('page_heading_setting', array(
    'title'             => esc_attr__( 'Page Heading', 'autlines' ),
    'priority'          => 9,
    'panel'             => 'header_option',
));
FL_Options::add_field( array(
    'type'        => 'image',
    'settings'    => 'page_background_img',
    'label'       => esc_attr__( 'Download the picture', 'autlines' ),
    'section'     => 'page_heading_setting',
    'default'     => '',
    'priority'    => 1,

) );
// Single Blog
FL_Options::add_section('single_page_heading_setting', array(
    'title'             => esc_attr__( 'Single Blog Page Heading', 'autlines' ),
    'priority'          => 9,
    'panel'             => 'header_option',
));
FL_Options::add_field( array(
    'type'        => 'image',
    'settings'    => 'single_blog_page_background_img',
    'label'       => esc_attr__( 'Download the picture', 'autlines' ),
    'section'     => 'single_page_heading_setting',
    'default'     => '',
    'priority'    => 1,
) );

// Blog Archive
FL_Options::add_section('blog_archive_page_heading_setting', array(
    'title'             => esc_attr__( 'Blog Archive Heading', 'autlines' ),
    'priority'          => 9,
    'panel'             => 'header_option',
));
FL_Options::add_field( array(
    'type'        => 'image',
    'settings'    => 'blog_archive_page_background_img',
    'label'       => esc_attr__( 'Download the picture', 'autlines' ),
    'section'     => 'blog_archive_page_heading_setting',
    'default'     => '',
    'priority'    => 1,
) );
// Single Page Autos
FL_Options::add_section('autos_single_page_heading_setting', array(
    'title'             => esc_attr__( 'Autos Single Heading', 'autlines' ),
    'priority'          => 9,
    'panel'             => 'header_option',
));
FL_Options::add_field( array(
    'type'        => 'image',
    'settings'    => 'autos_single_page_background_img',
    'label'       => esc_attr__( 'Download the picture', 'autlines' ),
    'section'     => 'autos_single_page_heading_setting',
    'default'     => '',
    'priority'    => 1,
) );

if ( class_exists('WooCommerce') ) {
// Single Page Autos
    FL_Options::add_section('autos_woo_heading_setting', array(
        'title' => esc_attr__('Woocommerce Heading', 'autlines'),
        'priority' => 9,
        'panel' => 'header_option',
    ));
    FL_Options::add_field(array(
        'type' => 'image',
        'settings' => 'woo_images_background_img',
        'label' => esc_attr__('Download the picture', 'autlines'),
        'section' => 'autos_woo_heading_setting',
        'default' => '',
        'priority' => 1,
    ));
}
