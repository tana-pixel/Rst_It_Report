<?php

FL_Options::add_field( array(
    'type'              => 'image',
    'settings'          => 'site_logo',
    'label'             => esc_attr__( 'Site Logo', 'autlines' ),
    'description'       => esc_attr__('Upload site logo.', 'autlines' ),
    'section'           => 'title_tagline',
    'default'           => '',
    'priority'          => 2,
) );
FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'logo_wth',
    'label'             => esc_attr__('Max width Logotype', 'autlines' ),
    'description'       => esc_attr__('Site logo width in px.', 'autlines' ),
    'section'           => 'title_tagline',
    'default'           => '190',
    'priority'          => 2,
    'output'      => array(
        array(
            'element'               => '.fl--logo-container img',
            'property'              => 'max-width',
            'suffix'                => 'px',
        ),
    ),
) );
FL_Options::add_field( array(
    'type'              => 'textarea',
    'settings'          => 'google_api_key',
    'label'             => esc_attr__( 'Apikey', 'autlines' ),
    'description'       => esc_attr__( 'Insert Google Maps Apikey.', 'autlines' ),
    'section'           => 'title_tagline',
    'default'           => 'AIzaSyDBuVQgQSnzG2ngl4hzn-A00IIhYVk8RaE',
    'priority'          => 3,
) );

FL_Options::add_field( array(
    'type'              => 'image',
    'settings'          => 'site_sidebar_logo',
    'label'             => esc_attr__( 'Site Sidebar Logo', 'autlines' ),
    'description'       => esc_attr__('Upload site logo.', 'autlines' ),
    'section'           => 'title_tagline',
    'default'           => '',
    'priority'          => 2,
) );
FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'logo_sidebar_wth',
    'label'             => esc_attr__('Max width Logotype Sidebar', 'autlines' ),
    'description'       => esc_attr__('Site Sidebar logo width in px.', 'autlines' ),
    'section'           => 'title_tagline',
    'default'           => '35',
    'priority'          => 2,
    'output'      => array(
        array(
            'element'               => '.sidebar-logotype',
            'property'              => 'max-width',
            'suffix'                => 'px',
        ),
    ),
) );
FL_Options::add_field( array(
    'type'              => 'textarea',
    'settings'          => 'search_text',
    'label'             => esc_attr__( 'Search Text', 'autlines' ),
    'section'           => 'title_tagline',
    'default'           => esc_html__( 'Begin typing your search above and press return to search.', 'autlines' ),
    'priority'          => 3,
) );




