<?php
        if (function_exists('vc_map')) {
            vc_map(array(
                'name' => esc_html__('Resent Car Post', 'fl-themes-helper'),
                'base' => 'vc_fl_resent_car_posts',
                'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
                'icon' => 'fl-icon icon-fl-vc-icon',
                'controls' => 'full',
                'weight' => 900,
                'params' => array_merge(
                    array(
                        array(
                            'type'              => 'fl_number',
                            "heading"           => esc_html__("Cars Count", "fl-themes-helper"),
                            "param_name"        => "count",
                            'value'             => 8,
                            'min'               => -1,
                            'max'               => 999999,
                            'step'              => 1,
                            "admin_label"       => true,
                        ),
                        array(
                            'type'              => 'dropdown',
                            'heading'           => esc_html__('Button Style', 'fl-themes-helper'),
                            'param_name'        => 'button_style',
                            'value' => array(
                                esc_attr__("Load More", "fl-themes-helper")                 => "load_more",
                                esc_attr__("Link", "fl-themes-helper")                      => "link_style",
                            ),
                            'std'               => 'load_more',
                            'group'             => 'Button',
                        ),
                        array(
                            "type"              => "textfield",
                            "heading"           => esc_html__("Button Text", 'fl-themes-helper'),
                            "param_name"        => "btn_text",

                            "value"             => "SHOW MORE",
                            'group'             => 'Button',
                            'dependency' => array(
                                'element'                    => 'button_style',
                                'value'                      => 'load_more'
                            ),
                        ),
                        array(
                            "type"              => "textfield",
                            "heading"           => esc_html__("Button Loading Text", 'fl-themes-helper'),
                            "param_name"        => "btn_text_loading",

                            "value"             => "LOADING",
                            'group'             => 'Button',
                            'dependency' => array(
                                'element'                    => 'button_style',
                                'value'                      => 'load_more'
                            ),
                        ),
                        array(
                            "type"              => "textfield",
                            "heading"           => esc_html__("Button End Text", 'fl-themes-helper'),
                            "param_name"        => "btn_text_end",

                            "value"             => "ALL IS LOADED",
                            'group'             => 'Button',
                            'dependency' => array(
                                'element'                    => 'button_style',
                                'value'                      => 'load_more'
                            ),
                        ),
                        array(
                            "type"              => "textfield",
                            "heading"           => esc_html__("Button Text", 'fl-themes-helper'),
                            "param_name"        => "btn_link_text",

                            "value"             => "SHOW MORE",
                            'group'             => 'Button',
                            'dependency' => array(
                                'element'                    => 'button_style',
                                'value'                      => 'link_style'
                            ),
                        ),
                        array(
                            'type'              => 'vc_link',
                            'heading'           => esc_html__('Button Link', 'fl-themes-helper'),
                            'param_name'        => 'link',
                            'group'             => 'Button',
                            'dependency' => array(
                                'element'                    => 'button_style',
                                'value'                      => 'link_style'
                            ),
                        ),
                        // Color Setting
                        array(
                            'type'				=> 'fl_heading_param',
                            'text'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                            'param_name'		=> 'title_info_typography',
                            'class'             => 'fl-responsive-title',
                            'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                        ),
                        array(
                            'type'              => 'fl_checkbox',
                            'class'             => '',
                            'heading'           => '',
                            'param_name'        => 'custom_color',
                            'value'             => 'off',
                            'description'       => '"Checked" to enable custom Button Color Setting',
                            'options' => array(
                                'on' => array(
                                    'on'        => esc_attr__('Yes', 'fl-themes-helper'),
                                    'off'       => esc_attr__('No', 'fl-themes-helper'),
                                ),
                            ),
                            'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                        ),
                        array(
                            'type'              => 'colorpicker',
                            'param_name'        => 'btn_text_cl',
                            'heading'           => esc_html__('Text Button Color', 'fl-themes-helper'),
                            'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                            'edit_field_class'  => 'vc_col-sm-4',
                            'dependency' => array(
                                'element'                   => 'custom_color',
                                'value'                     => 'on',
                            ),
                            'std'               => '#ffffff'
                        ),
                        array(
                            'type'              => 'colorpicker',
                            'param_name'        => 'btn_bg',
                            'heading'           => esc_html__('Background Button', 'fl-themes-helper'),
                            'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                            'edit_field_class'  => 'vc_col-sm-4',
                            'dependency' => array(
                                'element'                   => 'custom_color',
                                'value'                     => 'on',
                            ),
                            'std'               => '#1c1f23'
                        ),
                        array(
                            'type'              => 'colorpicker',
                            'param_name'        => 'btn_hv_bg',
                            'heading'           => esc_html__('Hover Background Button', 'fl-themes-helper'),
                            'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                            'edit_field_class'  => 'vc_col-sm-4',
                            'dependency' => array(
                                'element'                   => 'custom_color',
                                'value'                     => 'on',
                            ),
                            'std'               => '#1c1f23'
                        ),

                    ),
                    fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),

            ));
        }

