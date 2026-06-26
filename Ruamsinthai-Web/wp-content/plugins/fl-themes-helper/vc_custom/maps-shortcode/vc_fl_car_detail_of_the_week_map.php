<?php

        if (function_exists('vc_map')) {
        vc_map(array(
            'name'      => esc_html__('Car Deals Of The Week', 'fl-themes-helper'),
            'base'      => 'vc_fl_car_detail_of_the_week',
            'icon' => 'fl-icon icon-fl-vc-icon',
            "show_settings_on_create" => false,
            'as_parent' => array(
                'only'              => 'vc_fl_car_detail_of_the_week_row'
            ),

            'category'  => esc_html__('Fl Theme', 'fl-themes-helper'),
            'controls'  => 'full',
            'weight'    => 400,
            'js_view'   => 'VcColumnView',
            'params' => array_merge( fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
        ));


    }
