<?php
        if (function_exists('vc_map')) {
            vc_map(array(
                'name' => esc_html__('Home Page Blog Posts', 'fl-themes-helper'),
                'base' => 'vc_fl_blog_posts',
                'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
                'icon' => 'fl-icon icon-fl-vc-icon',
                'controls' => 'full',
                'weight' => 900,
                'params' => array_merge(
                    array(
                        array(
                            'type'              => 'dropdown',
                            'heading'           => esc_html__('Blog Style', 'fl-themes-helper'),
                            'param_name'        => 'style_blog',
                            'value' => array(
                                esc_attr__("Style One", "fl-themes-helper")                 => "style-one",
                                esc_attr__("Style Two", "fl-themes-helper")                 => "style-two",
                            ),
                            'std'               => 'style-one'
                        ),
                    ),
                    fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),

            ));
        }

