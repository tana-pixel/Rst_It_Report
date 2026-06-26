<?php
FL_Options::add_section('navigator_section', array(
    'title'         => esc_attr__('Navigation Setting', 'autlines'),
    'priority'      => 8,
    'icon'          => 'fa fa-bars'
));


FL_Options::add_field( array(
    'type'              => 'toggle',
    'settings'          => 'fixed_nav',
    'label'             => esc_attr__( 'Fixed Navigator', 'autlines' ),
    'section'           => 'navigator_section',
    'priority'          => 1,
    'choices'     => [
        'true'          => esc_html__( 'Enable', 'autlines' ),
        'false'         => esc_html__( 'Disable', 'autlines' ),
    ],
    'default'           => 'false',
) );

FL_Options::add_field( array(
    'type'              => 'typography',
    'settings'          => 'navigation_typography',
    'label'             => esc_attr__( 'Navigation Typography', 'autlines' ),
    'section'           => 'navigator_section',
    'default'     => array(
        'font-family'                   => 'Montserrat',
        'font-size'                     => '12px',
        'variant'                       => '600',
        'text-transform'                => 'uppercase',
        'subsets'                       => array( 'latin-ext' ),
    ),
    'priority'          => 10,
    'output'            => array(
        array(
            'element'                   => '.fl--header .nav-menu li a',
        ),
    ),
) );

FL_Options::add_field( array(
    'type'              => 'typography',
    'settings'          => 'syb_megamenu_first_child_font',
    'label'             => esc_attr__('Mega Menu First Child Font Style', 'autlines'),
    'section'           => 'navigator_section',
    'priority'          => 10,
    'transport'         => 'auto',
    'default' => array(
        'font-family'                       => 'Montserrat',
        'variant'                           => '700',
        'color'                             => '#222222',
        'font-size'                         => '10px',
    ),
    'output' => array(
        array(
            'element'                           => '.fl-mega-menu>ul>li .sub-nav>ul.sub-menu-wide>li>a'
        ),
    ),
));


FL_Options::add_field( array(
    'type'              => 'typography',
    'settings'          => 'sub_menu_navigation_typography',
    'label'             => esc_attr__( 'Sub Menu Typography', 'autlines' ),
    'section'           => 'navigator_section',
    'default'     => array(
        'font-family'                   => 'Montserrat',
        'variant'                       => '500',
        'font-size'                     => '12px',
        'text-transform'                => 'none',
        'subsets'                       => array( 'latin-ext' ),
    ),
    'priority'          => 10,
    'output'            => array(
        array(
            'element'                   => '.fl--header .nav-menu li .sub-menu li a,.fl--header .nav-menu li .sub-menu li .sub-sub-menu',
        ),
    ),
) );

FL_Options::add_field( array(
    'type'              => 'typography',
    'settings'          => 'mobile_menu_navigation_typography',
    'label'             => esc_attr__( 'Mobile Menu Typography', 'autlines' ),
    'section'           => 'navigator_section',
    'default'     => array(
        'font-family'                   => 'Montserrat',
        'variant'                       => '500',
        'font-size'                     => '11px',
        'text-transform'                => 'uppercase',
        'subsets'                       => array( 'latin-ext' ),
    ),
    'priority'          => 10,
    'output'            => array(
        array(
            'element'                   => '.fl--mobile-menu li a',
        ),
    ),
) );

FL_Options::add_field( array(
    'type'              => 'typography',
    'settings'          => 'mobile_sub_menu_navigation_typography',
    'label'             => esc_attr__( 'Mobile Sub Menu Typography', 'autlines' ),
    'section'           => 'navigator_section',
    'default'     => array(
        'font-family'                   => 'Montserrat',
        'variant'                       => '500',
        'font-size'                     => '11px',
        'text-transform'                => 'none',
        'subsets'                       => array( 'latin-ext' ),
    ),
    'priority'          => 10,
    'output'            => array(
        array(
            'element'                   => '.fl--mobile-menu li .sub-menu li a',
        ),
    ),
) );




FL_Options::add_field( array(
    'type'              => 'toggle',
    'settings'          => 'menu_search_icon',
    'label'             => esc_attr__( 'Search Icon', 'autlines' ),
    'section'           => 'navigator_section',
    'priority'          => 10,
    'choices'     => [
        'enable'          => esc_html__( 'Enable', 'autlines' ),
        'disable'         => esc_html__( 'Disable', 'autlines' ),
    ],
    'default'           => 'disable',
) );

FL_Options::add_field( array(
    'type'              => 'toggle',
    'settings'          => 'menu_login_icon',
    'label'             => esc_attr__( 'Login Icon', 'autlines' ),
    'section'           => 'navigator_section',
    'priority'          => 10,
    'choices'     => [
        'enable'          => esc_html__( 'Enable', 'autlines' ),
        'disable'         => esc_html__( 'Disable', 'autlines' ),
    ],
    'default'           => 'disable',
) );

FL_Options::add_field( array(
    'type'              => 'toggle',
    'settings'          => 'button_header',
    'label'             => esc_attr__( 'Header Button', 'autlines' ),
    'section'           => 'navigator_section',
    'priority'          => 10,
    'choices'     => [
        'enable'          => esc_html__( 'Enable', 'autlines' ),
        'disable'         => esc_html__( 'Disable', 'autlines' ),
    ],
    'default'           => 'disable',
) );


FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'button_text',
    'label'             => esc_html__( 'Button Text', 'autlines' ),
    'section'           => 'navigator_section',
    'priority'          => 10,
    'default'           => esc_attr__( 'Take a test drive', 'autlines' ),
) );

FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'button_link',
    'label'             => esc_html__( 'Button Link', 'autlines' ),
    'section'           => 'navigator_section',
    'priority'          => 10,
    'default'           => '#',
) );


FL_Options::add_field( array(
    'type'              => 'toggle',
    'settings'          => 'lan_switch_nav',
    'label'             => esc_attr__( 'Languages Switcher', 'autlines' ),
    'section'           => 'navigator_section',
    'choices'     => [
        'true'          => esc_html__( 'Enable', 'autlines' ),
        'false'         => esc_html__( 'Disable', 'autlines' ),
    ],
    'default'           => 'false',
) );

FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'lan_shortcode_text',
    'label'             => esc_html__( 'Custom Languages Shortcode', 'autlines' ),
    'section'           => 'navigator_section',
) );