<?php
    if (function_exists('vc_map')) {
        vc_map(array(
            'name' => esc_html__('Testimonial', 'fl-themes-helper'),
            'base' => 'vc_fl_testimonial',
            'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
            'icon' => 'fl-icon icon-fl-vc-icon',
            'controls' => 'full',
            'weight' => 900,
            'params' => array_merge(array(
                //Slider group
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Style', 'fl-themes-helper'),
                    'param_name' => 'testimonial_style',
                    'std'       => 'testimonial_default_style',
                    'value' => array(
                        esc_html__('Without background', 'fl-themes-helper')            => 'testimonial_default_style',
                        esc_html__('With background', 'fl-themes-helper')               => 'testimonial_with_image',
                    ),
                ),

                array(
                    'type'          => 'fl_image_preview',
                    'param_name'    => 'fl_preview_image',
                    'std'           => 'testimonial_default_style',
                    'value' => array(
                        esc_html__('Without background', 'fl-themes-helper')            => 'testimonial_default_style',
                        esc_html__('With background', 'fl-themes-helper')               => 'testimonial_with_image',
                    ),
                ),

                    array(
                        'type'				=> 'param_group',
                        'heading'			=> esc_html__('Layers of Testimonial', 'fl-themes-helper'),
                        'param_name'		=> 'list_fields',
                        'params'			=> array(
                            array(
                                'type'			=> 'attach_image',
                                'heading'		=> esc_html__('Upload Image:', 'fl-themes-helper'),
                                'param_name'	=> 'image_id',
                            ),
                            array(
                                'type'          => 'textfield',
                                'heading'       => esc_html__('Name', 'fl-themes-helper'),
                                'param_name'    => 'title',
                                'value'         => 'Johannes Kepler',
                                'description'   => '',
                            ),
                            array(
                                'type'          => 'textfield',
                                'heading'       => esc_html__('Profession', 'fl-themes-helper'),
                                'param_name'    => 'profession',
                                'value'         => 'Director Multimedia',
                                'description'   => '',
                            ),
                            array(
                                'type'              => 'textarea',
                                "heading"           => esc_html__("Testimonial Text", "fl-themes-helper"),
                                'param_name'        => 'content',
                                'value'             => '',
                                "description"       =>  esc_html__("Enter your text.", "fl-themes-helper"),
                            ),
                        ),
                    ),
            ), fl_helping_get_animation_option(), fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),

        ));
    }
