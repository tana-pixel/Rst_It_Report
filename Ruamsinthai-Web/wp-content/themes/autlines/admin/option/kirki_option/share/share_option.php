<?php

FL_Options::add_section('share_setting', array(
    'title'           => esc_attr__( 'Share Option', 'autlines'),
    'priority'        => 10,
    'icon'            => 'fa fa-pinterest'
));

FL_Options::add_field( array(
    'type'        => 'select',
    'settings'    => 'share_post_setting',
    'label'       => esc_attr__( 'Share icons from blog pages', 'autlines' ),
    'description' => esc_attr__( 'Choose to show or hide share icon on blog pages', 'autlines' ),
    'section'     => 'share_setting',
    'default'     => 'hide',
    'priority'    => 1,
    'multiple'    => 1,
    'choices'     => array(
        'hide' => esc_attr__('Hide Share Icon','autlines'),
        'show' => esc_attr__('Show Share Icon','autlines'),
    ),
) );
FL_Options::add_field( array(
    'type'        => 'multicheck',
    'settings'    => 'social_sharing_setting',
    'label'       => esc_attr__( 'Share Platforms', 'autlines' ),
    'description' => esc_attr__( 'Check the platforms you want to use for social share.', 'autlines' ),
    'section'     => 'share_setting',
    'default'     => array('fb', 'twi', 'goglp'),
    'priority'    => 1,
    'choices'     => array(
        'fb'        =>'Facebook',
        'twi'       =>'Twitter',
        'goglp'     =>'Google +',
        'lin'       =>'Linkedin',
        'red'       =>'Reddit',
        'pin'       =>'Pinterest',
        'vk'        =>'Vkontakte'
    ),
    'active_callback' => array(
        array(
            'setting' => 'share_post_setting',
            'operator' => '==',
            'value' => 'show',
        ),
    ),
) );
