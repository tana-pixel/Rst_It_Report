<?php
FL_Options::add_section('social_profiles', array(
    'title'             => esc_attr__( 'Footer Social Profile', 'autlines' ),
    'priority'          => 10,
    'panel'             => '',
    'icon'              => 'fa fa-facebook'
));



FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'linkedin',
    'label'             => esc_attr__( 'Linkedin', 'autlines' ),
    'description'       => esc_attr__( 'Your Linkedin profile URL.', 'autlines' ),
    'section'           => 'social_profiles',
    'default'           => '#',
    'priority'          => 10,
) );

FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'vime',
    'label'             => esc_attr__( 'Vimeo', 'autlines' ),
    'description'       => esc_attr__( 'Your Vimeo profile URL.', 'autlines' ),
    'section'           => 'social_profiles',
    'default'           => '',
    'priority'          => 10,
) );

FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'yt',
    'label'             => esc_attr__( 'YouTube', 'autlines' ),
    'description'       => esc_attr__( 'Your YouTube profile URL.', 'autlines' ),
    'section'           => 'social_profiles',
    'default'           => '',
    'priority'          => 10,
) );

FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'twi',
    'label'             => esc_attr__( 'Twitter', 'autlines' ),
    'description'       => esc_attr__( 'Your twitter profile URL.', 'autlines' ),
    'section'           => 'social_profiles',
    'default'           => '#',
    'priority'          => 10,
) );

FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'fb',
    'label'             => esc_attr__( 'Facebook', 'autlines' ),
    'description'       => esc_attr__( 'Your Facebook profile URL.', 'autlines' ),
    'section'           => 'social_profiles',
    'default'           => '#',
    'priority'          => 10,
) );

FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'pin',
    'label'             => esc_attr__( 'Pinterest', 'autlines' ),
    'description'       => esc_attr__( 'Your Pinterest profile URL.', 'autlines' ),
    'section'           => 'social_profiles',
    'default'           => '#',
    'priority'          => 10,
) );

FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'gpl',
    'label'             => esc_attr__( 'Google Plus+', 'autlines' ),
    'description'       => esc_attr__( 'Your Google Plus+ profile URL.', 'autlines' ),
    'section'           => 'social_profiles',
    'default'           => '#',
    'priority'          => 10,
) );

FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'insta',
    'label'             => esc_attr__( 'Instagram', 'autlines' ),
    'description'       => esc_attr__( 'Your Instagram profile URL.', 'autlines' ),
    'section'           => 'social_profiles',
    'default'           => '#',
    'priority'          => 10,
) );

FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'beh',
    'label'             => esc_attr__( 'Behance', 'autlines' ),
    'description'       => esc_attr__( 'Your Behance profile URL.', 'autlines' ),
    'section'           => 'social_profiles',
    'default'           => '#',
    'priority'          => 10,
) );