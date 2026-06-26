<?php
$module_images_accordion = FL_HELPING_PREVIEW_IMAGE .'/button/';
            if (function_exists('vc_map')) {
                vc_map(array(
                        "name" => esc_html__("Button", 'fl-themes-helper'),
                        "base" => "vc_fl_btn",
                        "class" => "",
                        "controls" => "full",
                        'icon' => 'fl-icon icon-fl-vc-icon',
                        "category" => esc_html__('Fl Theme', 'fl-themes-helper'),
                        'weight' => 900,
                        "params" => array_merge(array(
                            array(
                                'type'      => 'fl_radio_image_select',
                                'heading' => esc_html__('Button Style', 'fl-themes-helper'),
                                'param_name' => 'btn_style',
                                'simple_mode' => false,
                                'options' => array(
                                    'primary-btn-style' => array(
                                        'src' => $module_images_accordion . 'primary-btn-style.png'
                                    ),
                                    'secondary-btn-style' => array(
                                        'src' => $module_images_accordion . 'secondary-btn-style.png'
                                    ),
                                    'custom-colors' => array(
                                        'src' => $module_images_accordion . 'custom-colors.png'
                                    ),

                                ),
                                "value" => "primary-btn-style",
                            ),
                            array(
                                'type'              => 'fl_radio_advanced',
                                'heading'           => esc_html__('Button Hover Animation', 'fl-themes-helper'),
                                'param_name'        => 'btn_hr_animation',
                                'value'		        => 'enable',
                                'options' => array(
                                    esc_attr__("Enable", "fl-themes-helper")                    => "enable",
                                    esc_attr__("Disable", "fl-themes-helper")                   => "disable",
                                ),
                            ),
                            array(
                                'type'              => 'fl_radio_advanced',
                                'heading'           => esc_html__('Button align', 'fl-themes-helper'),
                                'param_name'        => 'btn_align',
                                'value'		        => 'text-left',
                                'options' => array(
                                    esc_attr__("Left", "fl-themes-helper")                  => "text-left",
                                    esc_attr__("Center", "fl-themes-helper")                => "text-center",
                                    esc_attr__("Right", "fl-themes-helper")                 => "text-right",
                                ),
                            ),
                            array(
                                'type'          => 'fl_radio_advanced',
                                'heading'       => esc_html__('Button Size', 'fl-themes-helper'),
                                'param_name'    => 'size',
                                'value'		    => 'normal',
                                'options' => array(
                                    esc_html__('Small', 'fl-themes-helper')             => 'small-btn',
                                    esc_html__('Normal', 'fl-themes-helper')            => 'normal',
                                    esc_html__('Large', 'fl-themes-helper')             => 'large-btn',
                                ),
                                'description' => esc_html__('Select button display size.', 'fl-themes-helper'),
                            ),

                            array(
                                'type'          => 'textfield',
                                'heading'       => esc_html__('Button Text', 'fl-themes-helper'),
                                'param_name'    => 'btn_text',
                                'admin_label'   => true,
                                'value'         => 'READ MORE',
                            ),

                            array(
                                'type'          => 'vc_link',
                                'heading'       => esc_html__('Link', 'fl-themes-helper'),
                                'param_name'    => 'link',
                            ),

// Color Setting
                            array(
                                'type'				=> 'fl_heading_param',
                                'text'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                                'param_name'		=> 'title_info_typography',
                                'class'             => 'fl-responsive-title',
                                'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                                'dependency' => array(
                                    'element'                   => 'btn_style',
                                    'value'                     => 'custom-colors',
                                ),
                            ),
                            array(
                                'type'              => 'colorpicker',
                                'param_name'        => 'btn_bg',
                                'heading'           => esc_html__('Background Button', 'fl-themes-helper'),
                                'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                                'edit_field_class'  => 'vc_col-sm-4',
                                'dependency' => array(
                                    'element'                   => 'btn_style',
                                    'value'                     => 'custom-colors',
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
                                    'element'                   => 'btn_style',
                                    'value'                     => 'custom-colors',
                                ),
                                'std'               => '#1c1f23'
                            ),

                        ), fl_helping_get_animation_option(), fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
                    )
                );
            }

