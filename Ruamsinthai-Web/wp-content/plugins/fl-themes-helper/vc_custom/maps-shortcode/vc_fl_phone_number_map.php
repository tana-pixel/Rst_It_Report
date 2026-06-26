<?php
            if (function_exists('vc_map')) {
                vc_map(array(
                        "name" => esc_html__("Phone Number", 'fl-themes-helper'),
                        "base" => "vc_fl_phone_number",
                        "class" => "",
                        "controls" => "full",
                        'icon' => 'fl-icon icon-fl-vc-icon',
                        "category" => esc_html__('Fl Theme', 'fl-themes-helper'),
                        'weight' => 900,
                        "params" => array_merge(array(

                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__('Style', 'fl-themes-helper'),
                                'param_name'        => 'style',
                                'value' => array(
                                    esc_attr__("Style One", "fl-themes-helper")                  => "phone-style-one",
                                    esc_attr__("Style Two", "fl-themes-helper")                  => "phone-style-two",
                                ),
                                'std'               => 'phone-style-one'
                            ),

                            array(
                                'type'          => 'textfield',
                                'heading'       => esc_html__('Phone Text', 'fl-themes-helper'),
                                'param_name'    => 'phone_text',
                                'value'         => 'Call Us For Booking',
                                'dependency'	=>
                                    array(
                                        'element'     => 'style',
                                        'value'       => 'phone-style-one'
                                    ),
                            ),

                            array(
                                'type'          => 'textfield',
                                'heading'       => esc_html__('Phone Number', 'fl-themes-helper'),
                                'param_name'    => 'phone_number',
                                'value'         => '+1 (755) 302-8549',
                                'dependency'	=>
                                    array(
                                        'element'     => 'style',
                                        'value'       => 'phone-style-one'
                                    ),
                            ),


                            array(
                                'type'          => 'textfield',
                                'heading'       => esc_html__('Phone Text', 'fl-themes-helper'),
                                'param_name'    => 'phone_text_two',
                                'value'         => 'Get Painting or Styling Estimation',
                                'dependency'	=>
                                    array(
                                        'element'     => 'style',
                                        'value'       => 'phone-style-two'
                                    ),
                            ),

                            array(
                                'type'          => 'textfield',
                                'heading'       => esc_html__('Phone Text suffix', 'fl-themes-helper'),
                                'param_name'    => 'phone_suffix_text',
                                'value'         => 'Call Us Today',
                                'dependency'	=>
                                    array(
                                        'element'     => 'style',
                                        'value'       => 'phone-style-two'
                                    ),
                            ),

                            array(
                                'type'          => 'textfield',
                                'heading'       => esc_html__('Phone Number', 'fl-themes-helper'),
                                'param_name'    => 'phone_number_style_two',
                                'value'         => '+1 (755) 302-8549',
                                'dependency'	=>
                                    array(
                                        'element'     => 'style',
                                        'value'       => 'phone-style-two'
                                    ),
                            ),

                            array(
                                'type'              => 'fl_checkbox',
                                'class'             => '',
                                'heading'           => '',
                                'param_name'        => 'custom_color',
                                'value'             => 'off',
                                'description'       => __('"Checked" to enable custom color', 'fl-themes-helper'),
                                'options' => array(
                                    'on' => array(
                                        'on'        => esc_attr__('Yes', 'fl-themes-helper'),
                                        'off'       => esc_attr__('No', 'fl-themes-helper'),
                                    ),
                                ),
                                'group'				=> esc_html__('Custom Color Setting', 'fl-themes-helper'),
                            ),
                            // Style One
                            array(
                                'type'              => 'colorpicker',
                                'heading'           => esc_html__('Text Color', 'fl-themes-helper'),
                                'param_name'        => 'text_color',
                                'std'               => '',
                                'group'				=> esc_html__('Custom Color Setting', 'fl-themes-helper'),
                                'dependency'	=>
                                    array(
                                        'element'     => 'custom_color',
                                        'value'       => 'on'
                                    ),
                                'edit_field_class'  => 'vc_col-sm-4',
                            ),
                            array(
                                'type'              => 'colorpicker',
                                'heading'           => esc_html__('Phone Color', 'fl-themes-helper'),
                                'param_name'        => 'phone_color',
                                'std'               => '',
                                'group'				=> esc_html__('Custom Color Setting', 'fl-themes-helper'),
                                'dependency'	=>
                                    array(
                                        'element'     => 'custom_color',
                                        'value'       => 'on'
                                    ),
                                'edit_field_class'  => 'vc_col-sm-4',
                            ),
                            array(
                                'type'              => 'colorpicker',
                                'heading'           => esc_html__('Phone Background', 'fl-themes-helper'),
                                'param_name'        => 'phone_bg_color',
                                'std'               => '',
                                'group'				=> esc_html__('Custom Color Setting', 'fl-themes-helper'),
                                'dependency'	=>
                                    array(
                                        'element'     => 'custom_color',
                                        'value'       => 'on'
                                    ),
                                'edit_field_class'  => 'vc_col-sm-4',
                            ),

                        ), fl_helping_get_animation_option(), fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
                    )
                );
            }

