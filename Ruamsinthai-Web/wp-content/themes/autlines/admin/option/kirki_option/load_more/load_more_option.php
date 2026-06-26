<?php
FL_Options::add_section('load_more_section', array(
    'title'         => esc_attr__('Load More Setting', 'autlines'),
    'priority'      => 8,
    'icon'          => 'fa fa-spinner'
));

FL_Options::add_field( array(
        'type'     => 'text',
        'settings' => 'load_more_text',
        'label'    => esc_html__( 'Load More Text', 'autlines' ),
        'section'  => 'load_more_section',
        'default'  => esc_html__( 'LOAD MORE', 'autlines' ),
        'priority' => 10,
    )
);


FL_Options::add_field( array(
        'type'     => 'text',
        'settings' => 'load_more_loading_text',
        'label'    => esc_html__( 'Load More Loading Text', 'autlines' ),
        'section'  => 'load_more_section',
        'default'  => 'LOADING...',
        'priority' => 10,
    )
);

FL_Options::add_field( array(
        'type'     => 'text',
        'settings' => 'load_more_text_blog',
        'label'    => esc_html__( 'Blog Last Page Text', 'autlines' ),
        'section'  => 'load_more_section',
        'default'  => esc_html__( 'NO MORE POST', 'autlines' ),
        'priority' => 10,
    )
);

if ( class_exists('WooCommerce') ) {
    FL_Options::add_field( array(
            'type'     => 'text',
            'settings' => 'load_more_text_woo',
            'label'    => esc_html__( 'Woo Last Page Text', 'autlines' ),
            'section'  => 'load_more_section',
            'default'  => esc_html__( 'NO MORE PRODUCTS', 'autlines' ),
            'priority' => 10,
        )
    );


}

