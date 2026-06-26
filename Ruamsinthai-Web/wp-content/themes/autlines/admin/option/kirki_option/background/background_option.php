<?php


FL_Options::add_section('background_setting', array(
    'title'             => esc_attr__( 'Background', 'autlines' ),
    'priority'          => 8,
    'panel'             => '',
    'icon'              => 'fa fa-picture-o'
));

FL_Options::add_field( array(
    'type'              => 'select',
    'settings'          => 'show_background_page',
    'label'             => esc_attr__( 'Background page', 'autlines' ),
    'section'           => 'background_setting',
    'default'           => 'disable',
    'priority'          => 1,
    'multiple'          => 1,
    'choices' => array(
            'disable'                   => esc_attr__('Disable background','autlines'),
            'enable'                    => esc_attr__('Enable background','autlines'),
    ),
) );


FL_Options::add_field( array(
    'type'              => 'background',
    'settings'          => 'body_bg',
    'label'             => esc_attr__( 'Body Background Image', 'autlines' ),
    'section'           => 'background_setting',
    'transport'         => 'auto',
    'default'  => array(
            'background-image'          => '',
            'background-color'          => '',
            'background-repeat'         => 'repeat-all',
            'background-size'           => 'auto',
            'background-attachment'     => 'fixed',
            'background-position'       => 'left top',
    ),
    'active_callback' => array(
        array(
            'setting'                   => 'show_background_page',
            'operator'                  => '==',
            'value'                     => 'enable',
        ),
    ),
    'output'  => array(
        array(
            'element'                   => 'body',
        ),
    ),
) );