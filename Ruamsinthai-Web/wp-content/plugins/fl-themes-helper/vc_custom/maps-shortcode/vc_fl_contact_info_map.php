<?php
        if (function_exists('vc_map')) {
            vc_map(array(
                'name' => esc_html__('Contact Info', 'fl-themes-helper'),
                'base' => 'vc_fl_contact_info',
                'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
                'icon' => 'fl-icon icon-fl-vc-icon',
                'controls' => 'full',
                'weight' => 900,
                'params' => array_merge(
                    array(

                        array(
                            'type' => 'fl_radio_advanced',
                            'heading'           => esc_html__('Text align', 'fl-themes-helper'),
                            'param_name'        => 'text_align',
                            'value'		        => 'text-left',
                            'options' => array(
                                esc_attr__("Left", "fl-themes-helper")                  => "text-left",
                                esc_attr__("Center", "fl-themes-helper")                => "text-center",
                                esc_attr__("Right", "fl-themes-helper")                 => "text-right",
                            ),
                        ),
                        array(
                            'type'              => 'dropdown',
                            'heading'           => esc_html__('Style', 'fl-themes-helper'),
                            'param_name'        => 'style',
                            'value' => array(
                                esc_attr__("Phone Info Style", "fl-themes-helper")                  => "phone-style",
                                esc_attr__("Email Info Style", "fl-themes-helper")                  => "email-style",
                            ),
                            'std'               => 'phone-style'
                        ),

                        array(
                            'type'              => 'textarea',
                            'heading'           => esc_html__('Phone Text Content', 'fl-themes-helper'),
                            'param_name'        => 'phone_text_content',
                            'value'             => '',
                            'std'               => 'Call us',
                            'dependency' => array(
                                'element'                   => 'style',
                                'value'                     => 'phone-style',
                            ),
                        ),
                        array(
                            'type'              => 'textarea',
                            'heading'           => esc_html__('Phone', 'fl-themes-helper'),
                            'param_name'        => 'phone',
                            'value'             => '',
                            'std'               => '+1 755 302 8549',
                            'dependency' => array(
                                'element'                   => 'style',
                                'value'                     => 'phone-style',
                            ),
                        ),

                        array(
                            'type'              => 'textarea',
                            'heading'           => esc_html__('Email Text Content', 'fl-themes-helper'),
                            'param_name'        => 'email_text_content',
                            'value'             => '',
                            'std'               => 'Email us',
                            'dependency' => array(
                                'element'                   => 'style',
                                'value'                     => 'email-style',
                            ),
                        ),
                        array(
                            'type'              => 'textarea',
                            'heading'           => esc_html__('Email', 'fl-themes-helper'),
                            'param_name'        => 'email',
                            'value'             => '',
                            'std'               => 'support@autlines.com',
                            'dependency' => array(
                                'element'                   => 'style',
                                'value'                     => 'email-style',
                            ),
                        ),

    // Custom Color
                        array(
                            'type'				=> 'fl_heading_param',
                            'text'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                            'param_name'		=> 'title_info_typography',
                            'class'             => 'fl-responsive-title',
                            'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                            'dependency' => array(
                                'element'                   => 'custom_color',
                                'value'                     => 'on',
                            ),
                        ),
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
                            'group'             => esc_attr__('Color Setting', 'fl-themes-helper'),
                        ),

                        array(
                            'type'              => 'colorpicker',
                            'param_name'        => 'bg_cl',
                            'heading'           => esc_html__('Action Background Color', 'fl-themes-helper'),
                            'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                            'edit_field_class'  => 'vc_col-sm-6',
                            'dependency' => array(
                                'element'                   => 'custom_color',
                                'value'                     => 'on',
                            ),
                            'std'               => ''
                        ),
                        array(
                            'type'              => 'colorpicker',
                            'param_name'        => 'button_cl',
                            'heading'           => esc_html__('Button Color', 'fl-themes-helper'),
                            'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                            'edit_field_class'  => 'vc_col-sm-6',
                            'dependency' => array(
                                'element'                   => 'custom_color',
                                'value'                     => 'on',
                            ),
                            'std'               => ''
                        ),
                        array(
                            'type'              => 'colorpicker',
                            'param_name'        => 'title_cl',
                            'heading'           => esc_html__('Title Color', 'fl-themes-helper'),
                            'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                            'edit_field_class'  => 'vc_col-sm-6',
                            'dependency' => array(
                                'element'                   => 'custom_color',
                                'value'                     => 'on',
                            ),
                            'std'               => ''
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
                            'std'               => ''
                        ),
                    ),
                    fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),

            ));
        }

