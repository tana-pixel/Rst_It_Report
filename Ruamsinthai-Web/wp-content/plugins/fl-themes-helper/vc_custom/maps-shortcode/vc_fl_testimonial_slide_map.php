<?php

        if (function_exists('vc_map')) {
        vc_map(array(
            'name' => esc_html__('Testimonial Slide', 'fl-themes-helper'),
            'base' => 'vc_fl_testimonial_slide',
            'icon' => 'fl-icon icon-fl-vc-icon',
            'as_child' => array(
                'only' => 'vc_fl_work_info_table'
            ),
            'params' => array_merge(array(
                array(
                    'type' => 'textarea_html',
                    'heading' => esc_html__('Content', 'fl-themes-helper'),
                    'param_name' => 'content',
                    'value' => '',
                    'holder' => 'div',
                    'std' => 'Norem ipsum dolor sit amet consectetur adipisicing elit aliqua enim veniam quis nostrud exercita duis aute irure dolor krep rehenderit consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip irure dolor.',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Name', 'fl-themes-helper'),
                    'param_name' => 'name',
                    'std' => 'Lester Williams',
                    'value' => '',
                    'description' => '',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Profession', 'fl-themes-helper'),
                    'param_name' => 'profession',
                    'std' => 'Customer',
                    'value' => '',
                    'description' => '',
                ),

            ), fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
        ));
    }