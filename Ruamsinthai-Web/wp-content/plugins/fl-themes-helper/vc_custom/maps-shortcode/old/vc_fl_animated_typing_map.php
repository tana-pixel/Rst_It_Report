<?php
        if (function_exists('vc_map')) {
            vc_map(array(
                'name' => esc_html__('Animated Typing', 'fl-themes-helper'),
                'base' => 'vc_fl_animated_typing',
                'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
                'icon' => 'fl-icon icon-fl-vc-icon',
                'controls' => 'full',
                'weight' => 900,
                'params' => array_merge(array(
                    array(
                        'type'          => 'textarea',
                        'heading'       => esc_html__('Animation Text', 'fl-themes-helper'),
                        'param_name'    => 'animation_text',
                        'value'         => 'Enter some text here',
                        'admin_label'   => true,
                        'description'   => '',
                    ),
                    array(
                        'type'              => 'fl_number',
                        "heading"           => esc_html__("Typing Speed", "fl-themes-helper"),
                        "param_name"        => "typing_speed",
                        'value'             => '',
                        'min'               => 0,
                        'max'               => 999999,
                        'step'              => 1,
                    ),
// Typography
                    array(
                        'type'				=> 'fl_heading_param',
                        'text'				=> esc_html__('Typography Setting', 'fl-themes-helper'),
                        'param_name'		=> 'title_info_typography',
                        'class'             => 'fl-responsive-title',
                        'group'				=> esc_html__('Typography', 'fl-themes-helper'),
                    ),
                    array(
                        'type'              => 'fl_radio_advanced',
                        'heading'           => esc_html__('Text Style', 'fl-themes-helper'),
                        'param_name'        => 'text_style',
                        'value'		        => '',
                        'options' => array(
                            esc_html__('Standard', 'fl-themes-helper')              => '',
                            esc_html__('Title Style', 'fl-themes-helper')           => 'fl-font-style-semi-bold',
                        ),
                        'group'				=> esc_html__('Typography', 'fl-themes-helper'),
                    ),
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
                        'group'				=> esc_html__('Typography', 'fl-themes-helper'),
                    ),
                    array(
                        'type'				=> 'fl_font_setting',
                        'heading'			=> '',
                        'param_name'		=> 'text_font_options',
                        'settings'				=> array(
                            'fields'				=> array(
                                'font_size',
                                'letter_spacing',
                                'line_height',
                                'font_style'
                            ),
                        ),
                        'group'				=> esc_html__('Typography', 'fl-themes-helper'),
                    ),
                    array(
                        'type'				=> 'fl_checkbox',
                        'heading'			=> esc_html__('Custom Text Font Family', 'fl-themes-helper'),
                        'dependency' => array(
                            'element'                    => 'text_style',
                            'value_not_equal_to'         => 'fl-font-style-semi-bold'
                        ),
                        'param_name'		=> 'custom_text_google_fonts',
                        'options'			=> array(
                            'yes'				=> array(
                                'on'	=> 'Yes',
                                'off'	=> 'No',
                            ),
                        ),
                        'std'               => 'off',
                        'group'				=> esc_html__('Typography', 'fl-themes-helper'),
                    ),

                    array(
                        'type'				=> 'google_fonts',
                        'param_name'		=> 'text_custom_fonts',
                        'dependency' => array(
                            'element'                    => 'custom_text_google_fonts',
                            'value'                      => 'yes'
                        ),
                        'settings'			=> array(
                            'fields'			=> array(
                                'font_family_description'	=> esc_html__('Select font family.', 'fl-themes-helper'),
                                'font_style_description'	=> esc_html__('Select font style.', 'fl-themes-helper'),
                            ),
                        ),
                        'group'				=> esc_html__('Typography', 'fl-themes-helper'),
                    ),
//Style Setting
                    array(
                        'type'				=> 'fl_heading_param',
                        'text'				=> esc_html__('Style Setting', 'fl-themes-helper'),
                        'param_name'		=> 'i_title_info',
                        'class'             => 'fl-responsive-title',
                        'group'             => 'Style Setting'
                    ),
                    array(
                        'type'              => 'fl_checkbox',
                        'class'             => '',
                        'heading'           => '',
                        'param_name'        => 'custom_style_setting',
                        'value'             => 'off',
                        'description'       => '"Checked" to enable custom Style Setting',
                        'options' => array(
                            'on' => array(
                                'on'        => esc_attr__('Yes', 'fl-themes-helper'),
                                'off'       => esc_attr__('No', 'fl-themes-helper'),
                            ),
                        ),
                        'group'             => 'Style Setting'
                    ),

                    array(
                        'type'              => 'attach_image',
                        'heading'           => esc_html__('Text Background Image', 'fl-themes-helper'),
                        'param_name'        => 'background_img',
                        'edit_field_class'  => 'vc_col-sm-4',
                        'admin_label'       => false,
                        'dependency' => array(
                            'element'                    => 'custom_style_setting',
                            'value'                      => 'on',
                        ),
                        'group'             => 'Style Setting'
                    ),
                    array(
                        'type'          => 'colorpicker',
                        'param_name'    => 'text_background_color',
                        'heading'       => esc_html__('Text Background color', 'test'),
                        'dependency' => array(
                            'element'                    => 'custom_style_setting',
                            'value'                      => 'on',
                        ),
                        'group'             => 'Style Setting',
                        'edit_field_class'  => 'vc_col-sm-4',
                        'std'               => '#ffffff'
                    ),
                    array(
                        'type'          => 'colorpicker',
                        'param_name'    => 'text_color',
                        'heading'       => esc_html__('Text color', 'test'),
                        'dependency' => array(
                            'element'                    => 'custom_style_setting',
                            'value'                      => 'on',
                        ),
                        'group'             => 'Style Setting',
                        'edit_field_class'  => 'vc_col-sm-4',
                        'std'               => ''
                    ),


// Start Responsive Option Title
                    array(
                        'type'				=> 'fl_heading_param',
                        'text'				=> esc_html__('Custom Responsive Option', 'fl-themes-helper'),
                        'param_name'		=> 'title_responsive_headings',
                        'class'             => 'fl-responsive-text',
                        "group"             => "Responsive",
                        'description'       => __('
                                                 <i class="fa fa-laptop"></i> Desktop : Screen resolutions from 1199px to 991px<br>
                                                 <i class="fa fa-tablet"></i> Tablet : Screen resolutions from 991px to 767px<br>
                                                 <i class="fa fa-mobile"></i> Mobile : Screen resolutions less than 767px', 'fl-themes-helper'),
                    ),
                    array(
                        'type'              => 'fl_checkbox',
                        'class'             => '',
                        'heading'           => '',
                        'param_name'        => 'custom_responsive_option_title',
                        'value'             => 'off',
                        'description'       => __('"Checked" to enable custom responsive option to text', 'fl-themes-helper'),
                        'options' => array(
                            'on' => array(
                                'on'        => esc_attr__('Yes', 'fl-themes-helper'),
                                'off'       => esc_attr__('No', 'fl-themes-helper'),
                            ),
                        ),
                        "group"             => "Responsive",
                    ),
                    array(
                        "type"              => "fl_responsive_text",
                        "class"             => "",
                        "heading"           => esc_attr__("Title Font Size", 'fl-themes-helper'),
                        "param_name"        => "title_font_size_responsive",
                        "unit"              => "px",
                        "media" => array(
                            "Desktop"           => '',
                            "Tablet"            => '',
                            "Mobile"            => '',
                        ),
                        'dependency' => array(
                            'element'                    => 'custom_responsive_option_title',
                            'value'                      => 'on'
                        ),
                        "group"             => "Responsive",
                    ),
                    array(
                        "type"              => "fl_responsive_text",
                        "class"             => "",
                        "heading"           => esc_attr__("Title Line Height", 'fl-themes-helper'),
                        "param_name"        => "title_line_height_responsive",
                        "unit"              => "px",
                        "media" => array(
                            "Desktop"           => '',
                            "Tablet"            => '',
                            "Mobile"            => '',
                        ),
                        'dependency' => array(
                            'element'                    => 'custom_responsive_option_title',
                            'value'                      => 'on'
                        ),
                        "group"             => "Responsive",
                    ),
                    array(
                        "type"              => "fl_responsive_text",
                        "class"             => "",
                        "heading"           => esc_attr__("Title Letter Spacing", 'fl-themes-helper'),
                        "param_name"        => "title_letter_spacing_responsive",
                        "unit"              => "px",
                        "media" => array(
                            "Desktop"           => '',
                            "Tablet"            => '',
                            "Mobile"            => '',
                        ),
                        'dependency' => array(
                            'element'                    => 'custom_responsive_option_title',
                            'value'                      => 'on'
                        ),
                        "group"             => "Responsive",
                    ),



                    ), fl_helping_get_design_tab()),

            ));
        }

