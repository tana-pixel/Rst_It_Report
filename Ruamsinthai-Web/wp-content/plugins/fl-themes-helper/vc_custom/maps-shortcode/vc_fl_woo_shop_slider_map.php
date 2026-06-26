<?php
        if (function_exists('vc_map')) {
            vc_map(array(
                'name' => esc_html__('Woo Shop Slider', 'fl-themes-helper'),
                'base' => 'vc_fl_woo_shop_slider',
                'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
                'icon' => 'fl-icon icon-fl-vc-icon',
                'controls' => 'full',
                'weight' => 900,
                'params' => array_merge(array(
                    array(
                        'type'              => 'fl_number',
                        "heading"           => esc_html__("Product Count", "fl-themes-helper"),
                        "param_name"        => "count",
                        'value'             => 6,
                        'min'               => 0,
                        'max'               => 999999,
                        'step'              => 1,
                    ),
                    array(
                        'type'          => 'fl_custom_products_categories',
                        'heading'       => esc_html__( 'Selected woo category', 'fl-themes-helper'),
                        'param_name'    => 'woo_category_link',
                        'multiple'      => false,
                    ),

                    ), fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),

            ));
        }

