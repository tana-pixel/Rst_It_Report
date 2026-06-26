<?php
        if (function_exists('vc_map')) {
            vc_map(array(
                'name' => esc_html__('Action Content', 'fl-themes-helper'),
                'base' => 'vc_fl_action_content',
                'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
                'icon' => 'fl-icon icon-fl-vc-icon',
                'controls' => 'full',
                'weight' => 900,
                'params' => array_merge(
                    array(
                        array(
                            'type'          => 'vc_link',
                            'heading'       => esc_html__('Button Link', 'fl-themes-helper'),
                            'param_name'    => 'link',
                        ),
                        array(
                            'type'              => 'dropdown',
                            'heading'           => esc_html__('Content Style', 'fl-themes-helper'),
                            'param_name'        => 'style',
                            'value' => array(
                                esc_attr__("Right Content Style", "fl-themes-helper")                => "",
                                esc_attr__("Left Content Style", "fl-themes-helper")                 => "left-content-style",
                            ),
                            'std'               => ''
                        ),

                        array(
                            'type'              => 'textarea_html',
                            'heading'           => esc_html__('Title', 'fl-themes-helper'),
                            'param_name'        => 'content',
                            'value'             => 'ARE YOU LOOKING TO BUY A CAR?',
                            'holder'            => 'div',
                            'std'               => '',
                        ),


                        array(
                            'type'              => 'textarea',
                            'heading'           => esc_html__('Content', 'fl-themes-helper'),
                            'param_name'        => 'text_content',
                            'value'             => '',
                            'holder'            => 'div',
                            'std'               => 'Let’s start searching our inventory that includes 2000+ cars',
                        ),

                        array(
                            'type'				=> 'attach_image',
                            'heading'			=> esc_html__('Background Image','fl-themes-helper'),
                            'param_name'		=> 'bg_image',
                            'description'       => esc_html__('Recommended image size 438x350 px', 'fl-themes-helper'),
                            'edit_field_class'	=> 'vc_col-sm-6',
                        ),

                        array(
                            'type'				=> 'attach_image',
                            'heading'			=> esc_html__('Action Image','fl-themes-helper'),
                            'param_name'		=> 'action_image',
                            'description'       => esc_html__('Recommended image size 692x280 px', 'fl-themes-helper'),
                            'edit_field_class'	=> 'vc_col-sm-6',
                        ),
    // Custom Color
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

