<?php
FL_Options::add_section('cars_setting', array(
    'title'             => esc_attr__( 'Cars Setting', 'autlines' ),
    'priority'          => 10,
    'panel'             => '',
    'icon'              => 'fa fa-car'
));
// Sidebar Setting
FL_Options::add_field( array(
    'type'              => 'radio-buttonset',
    'settings'          => 'car_sidebar_position',
    'label'             => esc_attr__( 'Sidebar Settings', 'autlines' ),
    'description'       => esc_attr__( 'Select a sidebar position for Blog pages', 'autlines' ),
    'section'           => 'cars_setting',
    'default'           => 'right',
    'priority'          => 1,
    'multiple'          => 1,
    'choices' => array(
        'disable'                => esc_attr__('No Sidebar','autlines'),
        'left'                   => esc_attr__('Left Sidebar','autlines'),
        'right'                  => esc_attr__('Right Sidebar','autlines'),
    ),
) );

FL_Options::add_field( array(
    'type'              => 'radio-buttonset',
    'settings'          => 'car_sticky_sidebar',
    'label'             => esc_attr__( 'Sticky sidebar', 'autlines' ),
    'section'           => 'cars_setting',
    'default'           => 'default',
    'priority'          => 1,
    'multiple'          => 1,
    'choices'     => array(
        'default'           => esc_attr__('Default Sidebar','autlines'),
        'sticky'            => esc_attr__('Sticky Sidebar','autlines'),
    ),
    'active_callback' => array(
        array(
            'setting'           => 'car_sidebar_position',
            'operator'          => '!==',
            'value'             => 'disable',
        ),
    ),
) );

FL_Options::add_field( array(
    'type'              => 'radio-buttonset',
    'settings'          => 'car_sidebar_style',
    'label'             => esc_attr__( 'Style Sidebar', 'autlines' ),
    'section'           => 'cars_setting',
    'default'           => '',
    'priority'          => 1,
    'multiple'          => 1,
    'choices'     => array(
        ''                  => esc_attr__('Default Sidebar Style','autlines'),
        'with_title'            => esc_attr__('Sidebar With Title and Icon','autlines'),
    ),
    'active_callback' => array(
        array(
            'setting'           => 'car_sidebar_position',
            'operator'          => '!==',
            'value'             => 'disable',
        ),
    ),
) );

FL_Options::add_field( array( 
    'type'              => 'text',
    'settings'          => 'after_price_text_car',
    'label'             => esc_attr__( 'After price single page car text', 'revus' ),
    'section'           => 'cars_setting',
    'default'           => esc_attr__('Included Taxes & Checkup*','autlines'),
    'priority'          => 1,
) );