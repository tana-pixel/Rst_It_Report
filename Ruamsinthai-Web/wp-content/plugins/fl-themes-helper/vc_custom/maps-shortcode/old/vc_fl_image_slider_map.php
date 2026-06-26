<?php

        if (function_exists('vc_map')) {
        vc_map(array(
            'name'          => esc_html__('Slider Image', 'fl-themes-helper'),
            'base'          => 'vc_fl_images_slider',
            'icon' => 'fl-icon icon-fl-vc-icon',
            'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
            'controls'      => 'full',
            'weight'        => 500,
            'params' =>  array_merge(array(
                array(
                    'type'          => 'attach_images',
                    'heading'       => esc_html__('Select Images', 'fl-themes-helper'),
                    'param_name'    => 'images',
                ),

                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Images Size', 'fl-themes-helper'),
                    'param_name'    => 'images_size',
                    'std'           => 'trendsetter_size_1170x668_crop',
                    'value'         => fl_get_image_sizes(),
                    'description'   => ''
                ),

                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('Images Style', 'fl-themes-helper'),
                    'param_name'    => 'img_style',
                    'std'           => 'standard',
                    'value' => array(
                        esc_html__('Standard', 'fl-themes-helper')          => 'standard',
                        esc_html__('Magnific Popup', 'fl-themes-helper')    => 'magnific_popup',
                    ),
                    'description'   => ''
                ),
                array(
                    'type'          => 'dropdown',
                    'param_name'    => 'infinite',
                    'heading'       => esc_html__('Infinite Scroll', 'test'),
                    'value' => array(
                        esc_attr__('True', 'fl-themes-helper')          => 'true',
                        esc_attr__('False', 'fl-themes-helper')         => 'false',
                    ),
                    'std'           => 'true',
                    "admin_label"   => true,
                    'group'         => esc_html__('Slider setting', 'fl-themes-helper'),
                ),

                array(
                    'type'          => 'dropdown',
                    'param_name'    => 'autoplay',
                    'heading'       => esc_html__('Auto play', 'test'),
                    'value' => array(
                        esc_attr__('True', 'fl-themes-helper')          => 'true',
                        esc_attr__('False', 'fl-themes-helper')         => 'false',
                    ),
                    'std'           => 'true',
                    "admin_label"   => true,
                    'group'         => esc_html__('Slider setting', 'fl-themes-helper'),
                ),

                array(
                    'type'          => 'fl_slider',
                    'heading'       => esc_html__('Auto play Speed', 'fl-themes-helper'),
                    'param_name'    => 'autoplay_speed',
                    'min'           => 0,
                    'max'           => 8000,
                    'step'          => 100,
                    'value'         => 3000,
                    'suffix'        => 'ms',
                    'dependency' => array(
                        'element'                                       => 'autoplay',
                        'value'                                         => 'true',
                    ),
                    "admin_label"   => true,
                    'group'         => esc_html__('Slider setting', 'fl-themes-helper'),
                    'description'   => esc_html__('Standard Auto play speed 3000ms', 'fl-themes-helper'),
                ),
                array(
                    'type'          => 'fl_slider',
                    'heading'       => esc_html__('Slider Speed', 'test'),
                    'param_name'    => 'slider_speed',
                    'min'           => 0,
                    'max'           => 8000,
                    'step'          => 100,
                    'value'         => 900,
                    'suffix'        => 'ms',
                    "admin_label"   => true,
                    'group'         => esc_html__('Slider setting', 'fl-themes-helper'),
                    'description'   => esc_html__('Standard Slider speed 900ms', 'fl-themes-helper'),
                ),

            ), fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
        ));


    }