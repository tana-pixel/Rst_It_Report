<?php
FL_Options::add_section('header_social_profiles', array(
    'title'             => esc_attr__( 'Header Social Profile', 'autlines' ),
    'priority'          => 8,
    'panel'             => '',
    'icon'              => 'fa fa-facebook'
));



FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'header_linkedin',
    'label'             => esc_attr__( 'Linkedin', 'autlines' ),
    'description'       => esc_attr__( 'Your Linkedin profile URL.', 'autlines' ),
    'section'           => 'header_social_profiles',
    'default'           => '',
    'priority'          => 10,
) );

FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'header_vime',
    'label'             => esc_attr__( 'Vimeo', 'autlines' ),
    'description'       => esc_attr__( 'Your Vimeo profile URL.', 'autlines' ),
    'section'           => 'header_social_profiles',
    'default'           => '',
    'priority'          => 10,
) );

FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'header_yt',
    'label'             => esc_attr__( 'YouTube', 'autlines' ),
    'description'       => esc_attr__( 'Your YouTube profile URL.', 'autlines' ),
    'section'           => 'header_social_profiles',
    'default'           => '',
    'priority'          => 10,
) );

FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'header_twi',
    'label'             => esc_attr__( 'Twitter', 'autlines' ),
    'description'       => esc_attr__( 'Your twitter profile URL.', 'autlines' ),
    'section'           => 'header_social_profiles',
    'default'           => '',
    'priority'          => 10,
) );

FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'header_fb',
    'label'             => esc_attr__( 'Facebook', 'autlines' ),
    'description'       => esc_attr__( 'Your Facebook profile URL.', 'autlines' ),
    'section'           => 'header_social_profiles',
    'default'           => '',
    'priority'          => 10,
) );

FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'header_pin',
    'label'             => esc_attr__( 'Pinterest', 'autlines' ),
    'description'       => esc_attr__( 'Your Pinterest profile URL.', 'autlines' ),
    'section'           => 'header_social_profiles',
    'default'           => '',
    'priority'          => 10,
) );

FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'header_gpl',
    'label'             => esc_attr__( 'Google Plus+', 'autlines' ),
    'description'       => esc_attr__( 'Your Google Plus+ profile URL.', 'autlines' ),
    'section'           => 'header_social_profiles',
    'default'           => '',
    'priority'          => 10,
) );

FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'header_insta',
    'label'             => esc_attr__( 'Instagram', 'autlines' ),
    'description'       => esc_attr__( 'Your Instagram profile URL.', 'autlines' ),
    'section'           => 'header_social_profiles',
    'default'           => '',
    'priority'          => 10,
) );

FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'header_beh',
    'label'             => esc_attr__( 'Behance', 'autlines' ),
    'description'       => esc_attr__( 'Your Behance profile URL.', 'autlines' ),
    'section'           => 'header_social_profiles',
    'default'           => '',
    'priority'          => 10,
) );