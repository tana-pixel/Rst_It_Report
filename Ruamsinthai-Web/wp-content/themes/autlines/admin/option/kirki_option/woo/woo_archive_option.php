<?php
FL_Options::add_section('woo_setting', array(
    'title'                 => esc_attr__( 'Wooccomerce Archive Setting', 'autlines' ),
    'description'           => esc_attr__( 'Setting Wooccomerce Archive Page', 'autlines' ),
    'priority'              => 10,
    'icon'                  => 'fa fa-cart-plus'
));

FL_Options::add_field(array(
    'type'                  => 'text',
    'settings'              => 'woo_header_pre_title',
    'label'                 => esc_attr__('WooCommerce Pre Title', 'autlines'),
    'description'           => esc_attr__('Specify the pre title for WooCommerce Pages', 'autlines'),
    'section'               => 'woo_setting',
    'default'               => '',
    'priority'              => 1,
));

FL_Options::add_field(array(
    'type'                  => 'text',
    'settings'              => 'woo_header_title',
    'label'                 => esc_attr__('WooCommerce Page Title', 'autlines'),
    'description'           => esc_attr__('Specify the title for WooCommerce pages', 'autlines'),
    'section'               => 'woo_setting',
    'default'               => 'Shop',
    'priority'              => 1,
));

FL_Options::add_field( array(
    'type'              => 'select',
    'settings'          => 'woo_animation',
    'label'             => esc_attr__( 'Product Animation', 'autlines' ),
    'section'           => 'woo_setting',
    'default'           => 'disable',
    'priority'          => 1,
    'multiple'          => 1,
    'choices' => array(
        'disable'                =>         esc_attr__('Disable','autlines'),
        'fadeIn'                 =>         esc_attr__('fadeIn','autlines'),
        'flipXIn'                =>         esc_attr__('flipXIn','autlines'),
        'flipYIn'                =>         esc_attr__('flipYIn','autlines'),
        'flipBounceXIn'          =>         esc_attr__('flipBounceXIn','autlines'),
        'flipBounceYIn'          =>         esc_attr__('flipBounceYIn','autlines'),
        'swoopIn'                =>         esc_attr__('swoopIn','autlines'),
        'raise'                  =>         esc_attr__('raise','autlines'),
        'whirlIn'                =>         esc_attr__('whirlIn','autlines'),
        'shrinkIn'               =>         esc_attr__('shrinkIn','autlines'),
        'expandIn'               =>         esc_attr__('expandIn','autlines'),
        'bounceIn'               =>         esc_attr__('bounceIn','autlines'),
        'bounceUpIn'             =>         esc_attr__('bounceUpIn','autlines'),
        'bounceDownIn'           =>         esc_attr__('bounceDownIn','autlines'),
        'bounceLeftIn'           =>         esc_attr__('bounceLeftIn','autlines'),
        'bounceRightIn'          =>         esc_attr__('bounceRightIn','autlines'),
        'slideUpIn'              =>         esc_attr__('slideUpIn','autlines'),
        'slideDownIn'            =>         esc_attr__('slideDownIn','autlines'),
        'slideLeftIn'            =>         esc_attr__('slideLeftIn','autlines'),
        'slideRightIn'           =>         esc_attr__('slideRightIn','autlines'),
        'slideUpBigIn'           =>         esc_attr__('slideUpBigIn','autlines'),
        'slideDownBigIn'         =>         esc_attr__('slideDownBigIn','autlines'),
        'slideLeftBigIn'         =>         esc_attr__('slideLeftBigIn','autlines'),
        'slideRightBigIn'        =>         esc_attr__('slideRightBigIn','autlines'),
        'perspectiveUpIn'        =>         esc_attr__('perspectiveUpIn','autlines'),
        'perspectiveDownIn'      =>         esc_attr__('perspectiveDownIn','autlines'),
        'perspectiveLeftIn'      =>         esc_attr__('perspectiveLeftIn','autlines'),
        'perspectiveRightIn'     =>         esc_attr__('perspectiveRightIn','autlines'),
        'zoomIn'                 =>         esc_attr__('zoomIn','autlines'),
        'slideInRightVeryBig'    =>         esc_attr__('slideInRightVeryBig','autlines'),
        'slideInLeftVeryBig'     =>         esc_attr__('slideInLeftVeryBig','autlines'),
    ),

) );



FL_Options::add_field(array(
    'type'                  => 'text',
    'settings'              => 'products_per_page',
    'label'                 => esc_attr__('Products per page', 'autlines'),
    'description'           => esc_attr__('Specify the products per page count. by default it is 9', 'autlines'),
    'section'               => 'woo_setting',
    'default'               => '9',
    'priority'              => 1,
));




FL_Options::add_field( array(
    'type'                  => 'select',
    'settings'              => 'woo_archive_padding_top',
    'label'                 => esc_attr__( 'Padding top', 'autlines' ),
    'section'               => 'woo_setting',
    'default'               => 'enable',
    'priority'              => 1,
    'multiple'              => 1,
    'choices'  => array(
        'enable'                                => esc_attr__('Enable','autlines'),
        'disable'                               => esc_attr__('Disable','autlines'),
    ),
) );
FL_Options::add_field( array(
    'type'                  => 'select',
    'settings'              => 'woo_archive_padding_bottom',
    'label'                 => esc_attr__( 'Padding bottom', 'autlines' ),
    'section'               => 'woo_setting',
    'default'               => 'enable',
    'priority'              => 1,
    'multiple'              => 1,
    'choices'   => array(
        'enable'                                => esc_attr__('Enable','autlines'),
        'disable'                               => esc_attr__('Disable','autlines'),
    ),
) );