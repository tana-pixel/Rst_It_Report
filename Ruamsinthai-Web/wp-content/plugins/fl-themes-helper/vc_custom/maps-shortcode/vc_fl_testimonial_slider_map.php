<?php

        if (function_exists('vc_map')) {
        vc_map(array(
            'name' => esc_html__('Testimonial Slider', 'fl-themes-helper'),
            'base' => 'vc_fl_testimonial_slider',
            'icon' => 'fl-icon icon-fl-vc-icon',
            "as_parent" => array('only' => ' vc_fl_testimonial_slide'),
            "content_element" => true,
            "js_view"  => 'VcColumnView',
            'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
            'controls' => 'full',
            'weight' => 80,
            "show_settings_on_create" => false,
            'params' => array_merge( fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab(),array(

// Color Setting
                array(
                    'type'              => 'fl_checkbox',
                    'class'             => '',
                    'heading'           => '',
                    'param_name'        => 'custom_color',
                    'value'             => 'off',
                    'description'       => '"Checked" to enable color setting',
                    'options' => array(
                        'on' => array(
                            'on'        => esc_attr__('Yes', 'fl-themes-helper'),
                            'off'       => esc_attr__('No', 'fl-themes-helper'),
                        ),
                    ),
                    'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                ),

                array(
                    'type'				=> 'fl_heading_param',
                    'text'				=> esc_html__('Custom Color Setting', 'fl-themes-helper'),
                    'param_name'		=> 'custom_color_setting_header',
                    'class'             => 'fl-responsive-title',
                    'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                    'dependency' => array(
                        'element'                   => 'custom_color',
                        'value'                     => 'on',
                    ),
                ),
                array(
                    'type'              => 'colorpicker',
                    'param_name'        => 'content_cl',
                    'heading'           => esc_html__('Content Color', 'fl-themes-helper'),
                    'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                    'edit_field_class'  => 'vc_col-sm-6',
                    'dependency' => array(
                        'element'                   => 'custom_color',
                        'value'                     => 'on',
                    ),
                    'std'               => '#ffffff'
                ),
                array(
                    'type'              => 'colorpicker',
                    'param_name'        => 'i_cl',
                    'heading'           => esc_html__('Icon Color', 'fl-themes-helper'),
                    'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                    'edit_field_class'  => 'vc_col-sm-6',
                    'dependency' => array(
                        'element'                   => 'custom_color',
                        'value'                     => 'on',
                    ),
                    'std'               => '#ffffff'
                ),
                array(
                    'type'              => 'colorpicker',
                    'param_name'        => 'name_cl',
                    'heading'           => esc_html__('Name Color', 'fl-themes-helper'),
                    'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                    'edit_field_class'  => 'vc_col-sm-6',
                    'dependency' => array(
                        'element'                   => 'custom_color',
                        'value'                     => 'on',
                    ),
                    'std'               => '#ffffff'
                ),
                array(
                    'type'              => 'colorpicker',
                    'param_name'        => 'profession_cl',
                    'heading'           => esc_html__('Profession Color', 'fl-themes-helper'),
                    'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                    'edit_field_class'  => 'vc_col-sm-6',
                    'dependency' => array(
                        'element'                   => 'custom_color',
                        'value'                     => 'on',
                    ),
                    'std'               => '#ffffff'
                ),

            )),
        ));


    }