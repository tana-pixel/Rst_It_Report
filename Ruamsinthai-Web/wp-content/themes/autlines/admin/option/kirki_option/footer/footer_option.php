<?php
FL_Options::add_section('footer_setting', array(
    'title'             => esc_attr__( 'Footer', 'autlines' ),
    'priority'          => 11,
    'panel'             => '',
    'icon'              => 'fa fa-copyright'
));

FL_Options::add_field( array(
    'type'              => 'image',
    'settings'          => 'footer_decor_image',
    'label'             => esc_attr__( 'Footer Decor Image', 'autlines' ),
    'description'       => esc_attr__('Upload image', 'autlines' ),
    'section'           => 'footer_setting',
    'default'           => '',
    'priority'          => 2,
) );


FL_Options::add_field( array(
    'type'              => 'image',
    'settings'          => 'footer_bg',
    'label'             => esc_attr__( 'Footer Background Image', 'autlines' ),
    'section'           => 'footer_setting',
    'transport'         => 'auto',
    'default'           =>  '',
    'output'  => array(
        array(
            'element'                   => '.fl--footer',
            'property'                  => 'background-image',
            'suffix'                    => '!important'
        ),
    ),
) );


FL_Options::add_field( array(
    'type'              => 'textarea',
    'settings'          => 'footer_copyrights',
    'label'             => esc_attr__( 'Copyrights', 'autlines' ),
    'description'       => esc_attr__( 'Insert the Copyrights text.', 'autlines' ),
    'section'           => 'footer_setting',
    'default'           => esc_html__( '(c) 2022 AUTLINES - Auto Dealer Theme. All rights reserved.', 'autlines' ),
    'priority'          => 10,
) );
