<?php

        if (function_exists('vc_map')) {
            vc_map(array(
                'name' => esc_html__('Gallery', 'fl-themes-helper'),
                'base' => 'vc_fl_gallery',
                'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
                'icon' => 'fl-icon icon-fl-vc-icon',
                'controls' => 'full',
                'weight' => 80,
                'params' => array_merge(array(
                    array(
                        'type'				=> 'param_group',
                        'heading'			=> esc_html__('Layers of Gallery', 'fl-themes-helper'),
                        'param_name'		=> 'list_fields_gallery',
                        'params'			=> array(
                            array(
                                'type'			=> 'attach_image',
                                'heading'		=> esc_html__('Upload Galley Image:', 'fl-themes-helper'),
                                'param_name'	=> 'image_id',
                            ),
                        ),
                    ),

                ), fl_helping_get_animation_option(), fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
            ));
        }