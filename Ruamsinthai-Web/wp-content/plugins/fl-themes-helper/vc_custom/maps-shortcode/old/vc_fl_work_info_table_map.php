<?php

        if (function_exists('vc_map')) {
        vc_map(array(
            'name' => esc_html__('Work Info', 'fl-themes-helper'),
            'base' => 'vc_fl_work_info_table',
            'icon' => 'fl-icon icon-fl-vc-icon',
            `` => array('only' => ' vc_fl_work_info_row, vc_fl_work_share, vc_fl_work_like'),
            "content_element" => true,
            "js_view"  => 'VcColumnView',
            'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
            'controls' => 'full',
            'weight' => 80,
            "show_settings_on_create" => false,
            'params' => array_merge(array(

            ), fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
        ));


    }