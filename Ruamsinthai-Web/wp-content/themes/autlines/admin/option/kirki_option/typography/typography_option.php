<?php
    FL_Options::add_section('typography_setting', array(
        'title'             => esc_attr__( 'Typography', 'autlines' ),
        'priority'          => 8,
        'panel'             => '',
        'icon'              => 'fa fa-font'
    ));

    FL_Options::add_field( array(
        'type'              => 'typography',
        'settings'          => 'body_typography',
        'label'             => esc_attr__( 'Body', 'autlines' ),
        'section'           => 'typography_setting',
        'default'     => array(
            'font-family'                       => 'Lato',
            'variant'                           => 'regular',
            'font-size'                         => '15px',
            'line-height'                       => '26px',
            'letter-spacing'                    => '',
            'color'                             => '#555555',
            'text-transform'                    => 'none',
            'text-align'                        => 'left',
        ),
        'priority'    => 1,
        'output'      => array(
            array(
                'element'                           => 'body',
            ),
        ),
    ) );

    FL_Options::add_field( array(
        'type'              => 'typography',
        'settings'          => 'header_typography',
        'label'             => esc_attr__( 'Header Titles', 'autlines' ),
        'section'           => 'typography_setting',
        'priority'          => 10,
        'default' => array(
            'font-family'                       => 'Montserrat',
            'variant'                           => '700',
            'color'                             => '#222222',
            'text-transform'                    => 'none',
            'subsets'                           => false,
        ),
        'output'    => array(
            array(
                'element' => 'h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6,.fl-text-title-style',
            ),
        ),
    ) );


    FL_Options::add_field( array(
        'type'              => 'typography',
        'settings'          => 'typography_font_bolt',
        'label'             => esc_attr__('Font Style Bolt', 'autlines'),
        'section'           => 'typography_setting',
        'priority'          => 10,
        'transport'         => 'auto',
        'default' => array(
            'font-family'                       => 'Montserrat',
            'variant'                           => '700',
        ),
        'output' => array(
            array(
                'element'                           => '.fl-font-style-bolt,.woocommerce-error li strong,#booking_car_info .car-details__price-inner'
            ),
        ),
    ));

    FL_Options::add_field( array(
        'type'              => 'typography',
        'settings'          => 'typography_font_bolt_two',
        'label'             => esc_attr__('Font Style Bolt Two', 'autlines'),
        'section'           => 'typography_setting',
        'priority'          => 10,
        'transport'         => 'auto',
        'default' => array(
            'font-family'                       => 'Lato',
            'variant'                           => '700',
        ),
        'output' => array(
            array(
                'element'                           => '.fl-font-style-bolt-two,.footer-widget-area .widget.widget_mc4wp_form_widget .widget--title,#pixad-listing.grid .slider-grid__inner .tmpl-gray-footer .tmpl-slider-grid__info li,.card__list li .right--content .card-list__info,.card .card__img .sale,.wc-tab#tab-reviews form.comment-form .author-comment label,.wc-tab#tab-reviews form.comment-form .input-fields-wrapper .author-name label, .wc-tab#tab-reviews form.comment-form .input-fields-wrapper .author-email label,.wc-tab#tab-reviews form.comment-form .comment-form-rating label,.single-product .woocommerce-message a.button, .single-product .woocommerce-message a, .woocommerce-info a.button, .woocommerce-info a, .woocommerce-message a.button, .woocommerce-message a,.woocommerce .cart-collaterals .cart_totals a.checkout-button,.woocommerce table.shop_table tbody tr td.product-name a,.sidebar:not(.cars-sidebar) .booking_car_info .booking_form .rb_field label,.sidebar:not(.cars-sidebar) .booking_car_info .booking_form .submit,.card__wrap-label .card__label'
            ),
        ),
    ));

    FL_Options::add_field( array(
        'type'              => 'typography',
        'settings'          => 'typography_font_semi_bolt',
        'label'             => esc_attr__('Style Semi Bolt', 'autlines'),
        'section'           => 'typography_setting',
        'priority'          => 10,
        'transport'         => 'auto',
        'default' => array(
            'font-family'                       => 'Montserrat',
            'variant'                           => '600',
        ),
        'output' => array(
            array(
                'element'                           => '.fl-font-style-semi-bolt,.car-details .auto-slider .sale,.single-add-to-compare .single-add-to-compare-left .auto-title,.fl-hotspot-shortcode .Hotspot_Title,.fl--woo-add-to-cart-wrap .fl--add-to-cart-btn a,.woocommerce div.product .woocommerce-tabs ul.tabs li a,.woocommerce div.product .woocommerce-product-rating .woocommerce-review-link,.woocommerce div.product p.price,.woocommerce div.product form.cart .button,.woocommerce div.product .yith-wcwl-add-to-wishlist,.post-inner-pagination .pagination-text,.page-inner-pagination .pagination-text,.sidebar:not(.cars-sidebar) .widget_calendar .calendar_wrap #wp-calendar thead th,.sidebar:not(.cars-sidebar) .widget_calendar .calendar_wrap #wp-calendar caption,.sidebar:not(.cars-sidebar) .widget_rss ul li .rsswidget,.fl-blog-post-div .post-style-default .fl-post--item .post-bottom-content .post--title,.single-post-wrapper .post-category--tags .category-post a,#cancel-comment-reply-link,.woocommerce div.product form.cart table.group_table tr td,form.checkout #order_review #payment .place-order button,.language-selector >a .language-name'
            ),
        ),
    ));


    FL_Options::add_field( array(
        'type'              => 'typography',
        'settings'          => 'typography_font_regular',
        'label'             => esc_attr__('Regular Style One', 'autlines'),
        'section'           => 'typography_setting',
        'priority'          => 10,
        'transport'         => 'auto',
        'default' => array(
            'font-family'                       => 'Lato',
            'variant'                           => 'regular',
        ),
        'output' => array(
            array(
                'element'                           => '.fl-font-style-regular'
            ),
        ),
    ));

    FL_Options::add_field( array(
        'type'              => 'typography',
        'settings'          => 'typography_font_regular',
        'label'             => esc_attr__('Regular Style Two', 'autlines'),
        'section'           => 'typography_setting',
        'priority'          => 10,
        'transport'         => 'auto',
        'default' => array(
            'font-family'                       => 'Montserrat',
            'variant'                           => '400',
        ),
        'output' => array(
            array(
                'element'                           => '.fl-font-style-regular-two,.pixad-features-list li'
            ),
        ),
    ));

    FL_Options::add_field( array(
        'type'              => 'slider',
        'settings'          => 'h1_size_typography',
        'label'             => esc_attr__('H1 Size', 'autlines'),
        'section'           => 'typography_setting',
        'default'           => 40,
        'priority'          => 10,
        'choices' => array(
                'min'                               => '15',
                'max'                               => '75',
                'step'                              => '1',
        ),
        'output'      => array(
            array(
                'element'                           => 'h1, .h1',
                'property'                          => 'font-size',
                'units'                             => 'px',
            ),
        ),
    ));

    FL_Options::add_field( array(
        'type'              => 'slider',
        'settings'          => 'h2_size_typography',
        'label'             => esc_attr__('H2 Size', 'autlines'),
        'section'           => 'typography_setting',
        'default'           => 32,
        'priority'          => 10,
        'choices' => array(
                'min'                               => '15',
                'max'                               => '75',
                'step'                              => '1',
        ),
        'output'      => array(
            array(
                'element'                           => 'h2, .h2',
                'property'                          => 'font-size',
                'units'                             => 'px',
            ),
        ),
    ));

    FL_Options::add_field( array(
        'type'              => 'slider',
        'settings'          => 'h3_size_typography',
        'label'             => esc_attr__('H3 Size', 'autlines'),
        'section'           => 'typography_setting',
        'default'           => 28,
        'priority'          => 10,
        'choices' => array(
                'min'                               => '15',
                'max'                               => '75',
                'step'                              => '1',
        ),
        'output'      => array(
            array(
                'element'                           => 'h3, .h3',
                'property'                          => 'font-size',
                'units'                             => 'px',
            ),
        ),
    ));

    FL_Options::add_field( array(
        'type'              => 'slider',
        'settings'          => 'h4_size_typography',
        'label'             => esc_attr__('H4 Size', 'autlines'),
        'section'           => 'typography_setting',
        'default'           => 24,
        'priority'          => 10,
        'choices' => array(
                'min'                               => '15',
                'max'                               => '75',
                'step'                              => '1',
        ),
        'output'      => array(
            array(
                'element'                           => 'h4, .h4',
                'property'                          => 'font-size',
                'units'                             => 'px',
            ),
        ),
    ));

    FL_Options::add_field( array(
        'type'              => 'slider',
        'settings'          => 'h5_size_typography',
        'label'             => esc_attr__('H5 Size', 'autlines'),
        'section'           => 'typography_setting',
        'default'           => 20,
        'priority'          => 10,
        'choices' => array(
                'min'                               => '15',
                'max'                               => '75',
                'step'                              => '1',
        ),
        'output'      => array(
            array(
                'element'                           => 'h5, .h5',
                'property'                          => 'font-size',
                'units'                             => 'px',
            ),
        ),
    ));

    FL_Options::add_field( array(
        'type'              => 'slider',
        'settings'          => 'h6_size_typography',
        'label'             => esc_attr__('H6 Size', 'autlines'),
        'section'           => 'typography_setting',
        'default'           => 16,
        'priority'          => 10,
        'choices' => array(
                'min'                               => '15',
                'max'                               => '75',
                'step'                              => '1',
        ),
        'output'      => array(
            array(
                'element'                           => 'h6, .h6',
                'property'                          => 'font-size',
                'units'                             => 'px',
            ),
        ),
    ));