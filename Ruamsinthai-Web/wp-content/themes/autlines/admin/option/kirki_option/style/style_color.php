<?php
FL_Options::add_section('style_setting', array(
    'title'         => esc_attr__('Theme Style', 'autlines'),
    'priority'      => 8,
    'icon'          => 'fa fa-paint-brush'
));

FL_Options::add_field( array(
    'type'          => 'color',
    'settings'      => 'theme_border_color',
    'label'         => esc_attr__( 'Theme Border Color', 'autlines' ),
    'section'       => 'style_setting',
    'priority'      => 1,
    'default'       => '#dddddd',
    'choices'     => array(
        'alpha' => true,
    ),
) );


FL_Options::add_field( array(
    'type'          => 'color',
    'settings'      => 'primary_color_setting',
    'label'         => esc_attr__( 'Primary Color Setting', 'autlines' ),
    'section'       => 'style_setting',
    'priority'      => 1,
    'default'       => '#22abc3',
    'choices'     => array(
        'alpha' => true,
    ),
    'output'      => array(
        array(
            'element'               => '.fl-primary-bg,.fl-primary-bg-hv:hover,.fl--navigation-icon-container .header-btn a:after,.comment--reply a:hover,.submit-comment:after,.post-category--tags .category-post a:hover,.wrap-nav-table-content ul li span:before,.add-to-compare.active-add-compare, .active-add-favorite,.widget_dealer .widget-content ul li .wd-update,.decor-main-cl-right,.decor-main-cl-left,.button-container:not([data-animation=true]).primary-btn-style,.button-container[data-animation].primary-btn-style,.button-container[data-animation].secondary-btn-style .fl-vc-button:after,.button-container:not([data-animation=true]).secondary-btn-style:hover,.fl-tabs .nav-tabs li:hover .tab-link-content:after, .fl-tabs .nav-tabs li:hover .tab-link-content:after,.fl-resent-cars-vc .vc-cars-wrapper .slider-grid__inner .card__img:before,.vc_row[data-row-decor-bottom] .decor-main-cl-bottom-left,form#yith-wcwl-form td.product-add-to-cart a,.sidebar:not(.cars-sidebar) .booking_car_info .booking_form .submit:after',
            'property'              => 'background-color',
            'suffix'                => '!important',
        ),
        array(
            'element'               => '.fl-primary-color,.fl-primary-color-hv:hover,.fl-mega-menu ul li a:hover,.fl-mega-menu ul li.current-menu-item >a,.fl--navigation-icon-container .header-icon i:hover,.remember-login-checkbox-label input[type=checkbox]:checked:after,.footer-widget-area .widget_nav_menu ul li:hover a,.sidebar .widget:after,.breadcrumbs a:hover,.tabs-content .tab-content ul>li:before,.pixad-features-list li i,#pix-sorting .sorting__inner .sorting__item.view-by a.active,#pix-sorting .sorting__inner .sorting__item.view-by a:hover,.sidebar.cars-sidebar .widget-title:after,.widget-content .list-categories li input[type=checkbox]:checked+label .auto_body_name,.fl-vc-vehicle-search .home-pixad-filter .list-categories .list-categories__item input[type=checkbox]:checked+label .auto_body_name,.fl-vc-vehicle-search .home-pixad-filter .list-categories .list-categories__item:hover .auto_body_name',
            'property'              => 'color',
            'suffix'                => '!important',
        ),
        array(
            'element'               => '.post-category--tags .category-post a:hover,.fl-vc-vehicle-search .home-pixad-filter .list-categories .list-categories__item input[type=checkbox]:checked+label,.fl-vc-vehicle-search .home-pixad-filter .list-categories .list-categories__item:hover label',
            'property'              => 'border-color',
            'suffix'                => '!important',
        ),
    ),
) );

FL_Options::add_field( array(
    'type'          => 'color',
    'settings'      => 'secondary_color_setting',
    'label'         => esc_attr__( 'Secondary Color Setting', 'autlines' ),
    'section'       => 'style_setting',
    'priority'      => 1,
    'default'       => '#e2b71c',
    'choices'     => array(
        'alpha' => true,
    ),
    'output'      => array(
        array(
            'element'               => '.fl-secondary-bg,.fl-secondary-bg-hv:hover,.fl-post--item .category-post a:hover,.post-btn-read-more a:after,.post--holder a .link-decor,.comment--reply a,.card .card__img .sale,.autos-pagination li.active a,.autos-pagination li:hover a,.button-container:not([data-animation=true]).primary-btn-style:hover,.button-container[data-animation].primary-btn-style .fl-vc-button:after,.button-container[data-animation].secondary-btn-style,.button-container:not([data-animation=true]).secondary-btn-style,.post-inner-pagination .post-page-numbers.current,.page-inner-pagination .post-page-numbers.current,form#yith-wcwl-form td.product-add-to-cart a:hover,#booking_car_info .car-details__price-inner,.sidebar:not(.cars-sidebar) .booking_car_info .booking_form .submit:before',
            'property'              => 'background-color',
            'suffix'                => '!important',
        ),
        array(
            'element'               => '.fl-secondary-color,.fl-secondary-color-hv:hover,.footer-widget-area .widget_nav_menu ul li:hover:before,input[type=checkbox]:checked:after,.tags-single-blog .tags-content a:hover,.wrap-nav-table-content ul li.active span,.wrap-nav-table-content ul li:hover span,form#yith-wcwl-form .yith-wcwl-share ul li a:hover,.woocommerce div.product form.cart table.group_table tr td a:hover,.woocommerce div.product form.cart .variations .reset_variations:hover',
            'property'              => 'color',
            'suffix'                => '!important',
        ),
        array(
            'element'               => '.fl-post--item .category-post a:hover,.autos-pagination li.active a,.autos-pagination li:hover a,.post-inner-pagination .post-page-numbers.current,.page-inner-pagination .post-page-numbers.current',
            'property'              => 'border-color',
            'suffix'                => '!important',
        ),
        array(
            'element'               => '.car-favorite,.add-to-compare,.car-listing-row .listing-car-item-meta .price',
            'property'              => 'background-color',
        ),
    ),
) );


FL_Options::add_field( array(
    'type'          => 'color',
    'settings'      => 'light_color_setting',
    'label'         => esc_attr__( 'Light Color Setting', 'autlines' ),
    'section'       => 'style_setting',
    'priority'      => 1,
    'default'       => '#f1f5fa',
    'choices'     => array(
        'alpha' => true,
    ),
    'output'      => array(
        array(
            'element'               => '.fl-bg-light,.sidebar:not(.cars-sidebar) .widget,.sidebar.cars-sidebar,.post-share-icon a,form.fl-comment-form input, form.fl-comment-form textarea,.sidebar:not(.cars-sidebar) .booking_car_info .booking_form',
            'property'              => 'background',
            'suffix'                => '!important',
        ),
            array(
                'element'               => '.comment-title-content .back-text',
                'property'              => 'color',
                'suffix'                => '!important',
            ),


    ),
) );
