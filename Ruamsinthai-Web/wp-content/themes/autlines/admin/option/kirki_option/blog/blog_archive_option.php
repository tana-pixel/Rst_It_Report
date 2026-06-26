<?php
FL_Options::add_panel('blog_panel_archive', array(
    'title'     => esc_attr__('Blog Archive Setting', 'autlines'),
    'priority'  => 10,
    'icon'      => 'fa fa-newspaper-o'
));


//Blog Archive Animation
FL_Options::add_section('blog_archive_animation', array(
    'title'             => esc_attr__( 'Blog Animation', 'autlines' ),
    'priority'          => 10,
    'panel'             => 'blog_panel_archive',
));

FL_Options::add_field( array(
    'type'              => 'select',
    'settings'          => 'blog_animation',
    'label'             => esc_attr__( 'Blog Animation', 'autlines' ),
    'section'           => 'blog_archive_animation',
    'default'           => 'disable',
    'priority'          => 1,
    'multiple'          => 1,
    'choices' => array(
        'disable'                =>         esc_attr__('Disable','autlines'),
        'fadeIn'                 =>         esc_attr__('fadeIn','autlines'),
        'flipXIn'                =>         esc_attr__('flipXIn','autlines'),
        'flipYIn'                =>         esc_attr__('flipYIn','autlines'),
        'flipBounceXIn'          =>         esc_attr__('flipBounceXIn','autlines'),
        'flipBounceYIn'          =>         esc_attr__('flipBounceYIn','autlines'),
        'swoopIn'                =>         esc_attr__('swoopIn','autlines'),
        'raise'                  =>         esc_attr__('raise','autlines'),
        'whirlIn'                =>         esc_attr__('whirlIn','autlines'),
        'shrinkIn'               =>         esc_attr__('shrinkIn','autlines'),
        'expandIn'               =>         esc_attr__('expandIn','autlines'),
        'bounceIn'               =>         esc_attr__('bounceIn','autlines'),
        'bounceUpIn'             =>         esc_attr__('bounceUpIn','autlines'),
        'bounceDownIn'           =>         esc_attr__('bounceDownIn','autlines'),
        'bounceLeftIn'           =>         esc_attr__('bounceLeftIn','autlines'),
        'bounceRightIn'          =>         esc_attr__('bounceRightIn','autlines'),
        'slideUpIn'              =>         esc_attr__('slideUpIn','autlines'),
        'slideDownIn'            =>         esc_attr__('slideDownIn','autlines'),
        'slideLeftIn'            =>         esc_attr__('slideLeftIn','autlines'),
        'slideRightIn'           =>         esc_attr__('slideRightIn','autlines'),
        'slideUpBigIn'           =>         esc_attr__('slideUpBigIn','autlines'),
        'slideDownBigIn'         =>         esc_attr__('slideDownBigIn','autlines'),
        'slideLeftBigIn'         =>         esc_attr__('slideLeftBigIn','autlines'),
        'slideRightBigIn'        =>         esc_attr__('slideRightBigIn','autlines'),
        'perspectiveUpIn'        =>         esc_attr__('perspectiveUpIn','autlines'),
        'perspectiveDownIn'      =>         esc_attr__('perspectiveDownIn','autlines'),
        'perspectiveLeftIn'      =>         esc_attr__('perspectiveLeftIn','autlines'),
        'perspectiveRightIn'     =>         esc_attr__('perspectiveRightIn','autlines'),
        'zoomIn'                 =>         esc_attr__('zoomIn','autlines'),
        'slideInRightVeryBig'    =>         esc_attr__('slideInRightVeryBig','autlines'),
        'slideInLeftVeryBig'     =>         esc_attr__('slideInLeftVeryBig','autlines'),
    ),

) );
//Blog Archive Post Setting
FL_Options::add_section('blog_archive_post_setting', array(
    'title'             => esc_attr__( 'Blog Post Setting', 'autlines' ),
    'priority'          => 10,
    'panel'             => 'blog_panel_archive',
));
FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'archive_blog_title',
    'label'             => esc_attr__( 'Blog Archive Page Title', 'autlines' ),
    'description'       => esc_attr__( 'Specify the title for Blog archive page', 'autlines' ),
    'section'           => 'blog_archive_post_setting',
    'default'           => esc_attr__( 'Latest News', 'autlines' ),
    'priority'          => 1,
) );
FL_Options::add_field( array(
    'type'        => 'select',
    'settings'    => 'blog_archive_style',
    'label'       => esc_attr__( 'Blog Style', 'autlines' ),
    'section'     => 'blog_archive_post_setting',
    'default'     => 'default',
    'priority'    => 1,
    'multiple'    => 1,
    'choices' => array(
        'default'                => esc_attr__('Standard','autlines'),
        'default-two'            => esc_attr__('Standard Two','autlines'),
        'grid'                   => esc_attr__('Grid','autlines'),
    ),
) );

FL_Options::add_field( array(
    'type'              => 'text',
    'settings'          => 'custom_blog_excerpt_count',
    'label'             => esc_attr__( 'Number of Words in Description', 'autlines' ),
    'description'       => esc_attr__( 'Specify the Number of Words for Description blog per post.', 'autlines' ),
    'section'           => 'blog_archive_post_setting',
    'default'           => '35',
    'priority'          => 1,
) );

FL_Options::add_field( array(
    'type'        => 'select',
    'settings'    => 'blog_archive_padding_top',
    'label'       => esc_attr__( 'Padding top', 'autlines' ),
    'section'     => 'blog_archive_post_setting',
    'default'     => 'enable',
    'priority'    => 1,
    'multiple'    => 1,
    'choices' => array(
        'enable'                => esc_attr__('Enable','autlines'),
        'disable'               => esc_attr__('Disable','autlines'),
    ),
) );
FL_Options::add_field( array(
    'type'        => 'select',
    'settings'    => 'blog_archive_padding_bottom',
    'label'       => esc_attr__( 'Padding bottom', 'autlines' ),
    'section'     => 'blog_archive_post_setting',
    'default'     => 'enable',
    'priority'    => 1,
    'multiple'    => 1,
    'choices'  => array(
        'enable'                => esc_attr__('Enable','autlines'),
        'disable'               => esc_attr__('Disable','autlines'),
    ),
) );
FL_Options::add_field( array(
    'type'              => 'select',
    'settings'          => 'blog_pagination',
    'label'             => esc_attr__( 'Pagination Settings', 'autlines' ),
    'description'       => esc_attr__( 'Select the Pagination Type for Blog Archives', 'autlines' ),
    'section'           => 'blog_archive_post_setting',
    'default'           => 'pagination',
    'priority'          => 1,
    'multiple'          => 1,
    'choices' => array(
        'pagination'        => esc_attr__('Pagination','autlines'),
        'loadmore'          => esc_attr__('Load More Button','autlines'),
    ),
) );
//Blog Archive Sidebar Setting
FL_Options::add_section('blog_archive_post_sidebar_setting', array(
    'title'             => esc_attr__( 'Blog Archive Sidebar Setting', 'autlines' ),
    'priority'          => 10,
    'panel'             => 'blog_panel_archive',
));
FL_Options::add_field( array(
    'type'              => 'select',
    'settings'          => 'blog_archive_sidebar_position',
    'label'             => esc_attr__( 'Sidebar position', 'autlines' ),
    'section'           => 'blog_archive_post_sidebar_setting',
    'default'           => 'right',
    'priority'          => 1,
    'multiple'          => 1,
    'choices' => array(
        'left'              => esc_attr__('Left','autlines'),
        'right'             => esc_attr__('Right','autlines'),
        'disable'           => esc_attr__('Disable','autlines'),
    ),

) );
FL_Options::add_field( array(
    'type'              => 'select',
    'settings'          => 'blog_archive_sidebar_sticky',
    'label'             => esc_attr__( 'Sidebar sticky', 'autlines' ),
    'section'           => 'blog_archive_post_sidebar_setting',
    'default'           => 'default',
    'priority'          => 1,
    'multiple'          => 1,
    'choices'  => array(
        'sticky'            => esc_attr__('Sticky sidebar','autlines'),
        'default'           => esc_attr__('Default Sidebar','autlines'),
    ),
    'active_callback' => array(
        array(
            'setting'           => 'blog_archive_sidebar_position',
            'operator'          => '!=',
            'value'             => 'disable',
        ),
    ),
) );