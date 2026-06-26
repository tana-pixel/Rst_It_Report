<?php

FL_Options::add_section('404_setting', array(
    'title'           => esc_attr__( '404 Page', 'autlines' ),
    'priority'        => 10,
    'icon'            => 'fa fa-bug'
));


 //404 Background
FL_Options::add_field( array(
    'type'          => 'textarea',
    'settings'      => '404_text_title',
    'label'         => esc_attr__( 'Text Title', 'autlines' ),
    'section'       => '404_setting',
    'default'       => esc_attr__( 'Nothing was found', 'autlines' ),
) );

FL_Options::add_field( array(
    'type'          => 'textarea',
    'settings'      => '404_text',
    'label'         => esc_attr__( '404 Text', 'autlines' ),
    'section'       => '404_setting',
    'default'       => esc_attr__( 'Sorry, we can\'t find the page you are looking for.', 'autlines' ),
) );
