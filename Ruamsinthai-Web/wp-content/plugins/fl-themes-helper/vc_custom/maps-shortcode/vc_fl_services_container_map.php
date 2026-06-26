<?php

        if (function_exists('vc_map')) {
        vc_map(array(
            'name'      => esc_html__('Services Slider Container', 'fl-themes-helper'),
            'base'      => 'vc_fl_services_slider_container',
            'icon'      => 'fl-icon icon-fl-vc-icon',
            "show_settings_on_create" => false,
            'category'  => esc_html__('Fl Theme', 'fl-themes-helper'),
            'controls'  => 'full',
            'weight'    => 400,
            "is_container"              => true,
            "js_view"                   => 'VcColumnView',
            'params' => array_merge( fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
        ));


    }
