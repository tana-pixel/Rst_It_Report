<?php
        if (function_exists('vc_map')) {
            vc_map(array(
                'name' => esc_html__('Woo Category Banner', 'fl-themes-helper'),
                'base' => 'vc_fl_woo_category_banner',
                'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
                'icon' => 'fl-icon icon-fl-vc-icon',
                'controls' => 'full',
                'weight' => 900,
                'params' => array_merge(array(
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Style', 'fl-themes-helper'),
                        'param_name' => 'woo_product_banner_style',
                        'std'       => 'banner_left_content',
                        'value' => array(
                            esc_html__('Banner Left Content', 'fl-themes-helper')           => 'banner_left_content',
                            esc_html__('Banner Right Content', 'fl-themes-helper')          => 'banner_right_content',
                        ),
                    ),
                    array(
                        'type'          => 'fl_image_preview',
                        'param_name'    => 'fl_preview_image',
                        'std'           => 'banner_left_content',
                        'value' => array(
                            esc_html__('Banner Left Content', 'fl-themes-helper')           => 'banner_left_content',
                            esc_html__('Banner Right Content', 'fl-themes-helper')          => 'banner_right_content',
                        ),
                    ),
                    array(
                        'type'              => 'fl_radio_advanced',
                        'heading'           => esc_html__('Banner Style', 'fl-themes-helper'),
                        'param_name'        => 'banner_style',
                        'value'		        => 'big_banner',
                        'options' => array(
                            esc_html__('Big Banner', 'fl-themes-helper')                => 'big_banner',
                            esc_html__('Small Banner', 'fl-themes-helper')              => 'small_banner',
                        ),
                    ),
                    array(
                        'type'              => 'fl_radio_advanced',
                        'heading'           => esc_html__('Mouse Parallax', 'fl-themes-helper'),
                        'param_name'        => 'mouse_parallax',
                        'value'		        => 'mouse-parallax-image',
                        'options' => array(
                            esc_html__('Enable', 'fl-themes-helper')                => 'mouse-parallax-image',
                            esc_html__('Disable', 'fl-themes-helper')               => '',
                        ),
                    ),
                    array(
                        'type'          => 'attach_image',
                        'heading'       => esc_html__('Banner Image', 'fl-themes-helper'),
                        'param_name'    => 'img',
                        'holder'        => 'img',
                        'class'         => 'vc-preview-image',
                        'value'         => '',
                    ),
                    array(
                        'type'          => 'textarea',
                        'heading'       => esc_html__('Top Sub Title Text', 'fl-themes-helper'),
                        'param_name'    => 'sub_title_text',
                        'value'         => 'Spring 2022',
                        'admin_label'   => true,
                        'description'   => '',
                    ),
                    array(
                        'type'          => 'textarea',
                        'heading'       => esc_html__('Title Text', 'fl-themes-helper'),
                        'param_name'    => 'title_text',
                        'value'         => 'New Collection',
                        'admin_label'   => true,
                        'description'   => '',
                    ),
                    array(
                        'type'          => 'textarea',
                        'heading'       => esc_html__('Light Title Text', 'fl-themes-helper'),
                        'param_name'    => 'light_title_text',
                        'value'         => 'of Clothes',
                        'admin_label'   => true,
                        'description'   => '',
                    ),

                    array(
                        'type'          => 'textarea',
                        'heading'       => esc_html__('Button Text', 'fl-themes-helper'),
                        'param_name'    => 'btn_text',
                        'value'         => 'FOR HER',
                        'admin_label'   => true,
                        'description'   => '',
                    ),

                    array(
                        'type'              => 'fl_checkbox',
                        'class'             => '',
                        'heading'           => '',
                        'param_name'        => 'custom_link',
                        'value'             => 'off',
                        'description'       => '"Checked" to enable custom button link',
                        'options' => array(
                            'on' => array(
                                'on'        => esc_attr__('Yes', 'fl-themes-helper'),
                                'off'       => esc_attr__('No', 'fl-themes-helper'),
                            ),
                        ),
                    ),

                    array(
                        'type'          => 'fl_custom_products_categories',
                        'heading'       => esc_html__( 'Selected woo category link', 'fl-themes-helper'),
                        'param_name'    => 'woo_category_link',
                        'multiple'      => false,
                        'dependency'	=> array('element' => 'custom_link', 'value_not_equal_to' => 'on'),
                    ),

                    array(
                        'type'          => 'vc_link',
                        'heading'       => esc_html__( 'Custom link', 'fl-themes-helper' ),
                        'param_name'    => 'link',
                        'dependency'	=> array('element' => 'custom_link', 'value' => 'on'),
                    ),


                    ), fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),

            ));
        }

