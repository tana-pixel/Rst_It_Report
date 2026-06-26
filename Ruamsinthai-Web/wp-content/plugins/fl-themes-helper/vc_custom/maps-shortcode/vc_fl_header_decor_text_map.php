<?php

        if (function_exists('vc_map')) {
            vc_map(array(
                'name' => esc_html__('Header Decor Text', 'fl-themes-helper'),
                'base' => 'vc_header_decor_text',
                'icon' => 'fl-icon icon-fl-vc-icon',
                'wrapper_class' => 'clearfix',
                'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
                'controls' => 'full',
                'weight' => 100,
                'params' => array_merge(array(
                    array(
                        'type'              => 'textarea',
                        "heading"           => esc_html__("Text Content", "fl-themes-helper"),
                        'param_name'        => 'text_content',
                        'value'             => '',
                        'std'               => 'Explore Services',
                        "description"       => esc_html__("Enter your text.", "fl-themes-helper"),
                        'admin_label'       => true
                    ),

                    array(
                        'type'              => 'fl_radio_advanced',
                        'heading'           => esc_html__('Text align', 'fl-themes-helper'),
                        'param_name'        => 'text_align',
                        'value'		        => 'text-center',
                        'options' => array(
                            esc_attr__("Left", "fl-themes-helper")                  => "text-left",
                            esc_attr__("Center", "fl-themes-helper")                => "text-center",
                            esc_attr__("Right", "fl-themes-helper")                 => "text-right",
                        ),
                    ),

                    array(
                        'type'          => 'fl_checkbox',
                        'class'         => '',
                        'heading'       => 'Custom color',
                        'param_name'    => 'custom_color',
                        'value'         => 'disable',
                        'options' => array(
                            'enable' => array(
                                'enable'            => esc_attr__('Enable', 'fl-themes-helper'),
                                'disable'           => esc_attr__('Disable', 'fl-themes-helper'),
                            ),
                        ),
                        'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                    ),
                    array(
                        'type'				=> 'fl_heading_param',
                        'text'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                        'param_name'		=> 'title_info_typography',
                        'class'             => 'fl-responsive-title',
                        'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                        'dependency' => array(
                            'element'                   => 'custom_color',
                            'value'                     => 'enable',
                        ),
                    ),
                    array(
                        'type'              => 'colorpicker',
                        'param_name'        => 'text_cl',
                        'heading'           => esc_html__('Text Color', 'fl-themes-helper'),
                        'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                        'edit_field_class'  => 'vc_col-sm-6',
                        'dependency' => array(
                            'element'                   => 'custom_color',
                            'value'                     => 'enable',
                        ),
                        'std'               => ''
                    ),
                    array(
                        'type'              => 'colorpicker',
                        'param_name'        => 'decor_cl',
                        'heading'           => esc_html__('Decor Color', 'fl-themes-helper'),
                        'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                        'edit_field_class'  => 'vc_col-sm-6',
                        'dependency' => array(
                            'element'                   => 'custom_color',
                            'value'                     => 'enable',
                        ),
                        'std'               => ''
                    ),


                ), fl_helping_get_animation_option(), fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
            ));
        }