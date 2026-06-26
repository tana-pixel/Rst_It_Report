<?php

        if (function_exists('vc_map')) {
            vc_map(array(
                'name'      => esc_html__('Product Advantages', 'fl-themes-helper'),
                'base'      => 'vc_fl_product_advantages',
                'category'  => esc_html__('Fl Theme', 'fl-themes-helper'),
                'icon'      => 'fl-icon icon-fl-vc-icon',
                'controls'  => 'full',
                'weight'    => 300,
                'params' => array_merge(array(
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Style', 'fl-themes-helper'),
                        'param_name' => 'product_advantages_style',
                        'std'       => 'product_advantages_left_style',
                        'value' => array(
                            esc_html__('Left Icon Style', 'fl-themes-helper')               => 'product_advantages_left_style',
                            esc_html__('Right Icon Style', 'fl-themes-helper')              => 'product_advantages_right_style',
                        ),
                    ),

                    array(
                        'type'          => 'fl_image_preview',
                        'param_name'    => 'fl_preview_image',
                        'std'       => 'product_advantages_left_style',
                        'value' => array(
                            esc_html__('Left Icon Style', 'fl-themes-helper')               => 'product_advantages_left_style',
                            esc_html__('Right Icon Style', 'fl-themes-helper')              => 'product_advantages_right_style',
                        ),
                    ),

                    array(
                        'type'          => 'textarea',
                        'admin_label'   => true,
                        'heading'       => esc_html__('Title', 'fl-themes-helper'),
                        'param_name'    => 'title_text',
                        'value'         => '',
                        'std'           => 'Maecenas faucibus'
                    ),
                    array(
                        'type'              => 'textarea_html',
                        "heading"           => esc_html__("Text", "fl-themes-helper"),
                        'param_name'        => 'content',
                        'value'             => '',
                        'holder'            => 'div',
                        'std'               => 'Quisque id tortor mi. Etiam eget leo porta, sagittis augue at, mattis nibh. Quisque nec porttitor nibh, sit amet.',
                        "description"       => esc_html__("Enter your text.", "fl-themes-helper")
                    ),
                ), fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
            ));
        }
