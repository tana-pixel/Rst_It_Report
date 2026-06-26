<?php

        if (function_exists('vc_map')) {
            vc_map(array(
                'name'      => esc_html__('Semicircle Progress bar', 'fl-themes-helper'),
                'base'      => 'vc_fl_semicircle_progress_bar',
                'category'  => esc_html__('Fl Theme', 'fl-themes-helper'),
                'icon' => 'fl-icon icon-fl-vc-icon',
                'as_child' => array(
                    'only' => 'vc_fl_semi_circle_progress_container'
                ),
                'controls'  => 'full',
                'weight'    => 300,
                'params' => array_merge(array(
                    array(
                        'type'              => 'dropdown',
                        'heading'           => esc_html__('Color Style', 'fl-themes-helper'),
                        'param_name'        => 'style',
                        'value' => array(
                            esc_attr__("Secondary Color", "fl-themes-helper")                   => "secondary-color-progress",
                            esc_attr__("Primary Color", "fl-themes-helper")                     => "primary-color-progress",
                            esc_attr__("Custom Color", "fl-themes-helper")                      => "custom-color",
                        ),
                        'std'               => 'secondary-color-progress'
                    ),
                    array(
                        'type'          => 'textarea',
                        'admin_label'   => true,
                        'heading'       => esc_html__('Title', 'fl-themes-helper'),
                        'param_name'    => 'title_text',
                        'value'         => '',
                        'std'           => 'WEB DEVELOPMENT'
                    ),
                    array(
                        'type'          => 'textfield',
                        'admin_label'   => true,
                        'heading'       => esc_html__('Prefix', 'fl-themes-helper'),
                        'param_name'    => 'prefix',
                        'value'         => '',
                        'edit_field_class'  => 'vc_col-sm-2',
                        'std'           => ''
                    ),

                    array(
                        'type'              => 'fl_slider',
                        'admin_label'       => true,
                        'heading'           => esc_html__('Progress Value', 'fl-themes-helper'),
                        'param_name'        => 'progress_value',
                        'min'               => 0,
                        'max'               => 100,
                        'step'              => 1,
                        'value'             => 56,
                        'edit_field_class'  => 'vc_col-sm-8',
                    ),

                    array(
                        'type'          => 'textfield',
                        'admin_label'   => true,
                        'heading'       => esc_html__('Suffix', 'fl-themes-helper'),
                        'param_name'    => 'suffix',
                        'value'         => '',
                        'edit_field_class'  => 'vc_col-sm-2',
                        'std'           => ''
                    ),
                    array(
                        'type'              => 'colorpicker',
                        'heading'           => esc_html__('Track Color', 'fl-themes-helper'),
                        'param_name'        => 'tack_color',
                        'std'               => '',
                        'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                        'edit_field_class'  => 'vc_col-sm-4',
                        'dependency'	=>
                            array(
                                'element'     => 'style',
                                'value'       => 'custom-color'
                            ),
                    ),
                    array(
                        'type'              => 'colorpicker',
                        'heading'           => esc_html__('Track Progress Color', 'fl-themes-helper'),
                        'param_name'        => 'tack_progress_color',
                        'std'               => '',
                        'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                        'edit_field_class'  => 'vc_col-sm-4',
                        'dependency'	=>
                            array(
                                'element'     => 'style',
                                'value'       => 'custom-color'
                            ),
                    ),
                    array(
                        'type'              => 'colorpicker',
                        'heading'           => esc_html__('Title Color', 'fl-themes-helper'),
                        'param_name'        => 'title_color',
                        'std'               => '',
                        'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                        'edit_field_class'  => 'vc_col-sm-4',
                        'dependency'	=>
                            array(
                                'element'     => 'style',
                                'value'       => 'custom-color'
                            ),
                    ),

                ), fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
            ));
        }
