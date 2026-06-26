<?php

if (function_exists('vc_map')) {
    vc_map(array(
            "name"      => esc_html__("List Info", 'fl-themes-helper'),
            "base"      => "vc_fl_list_info",
            "class"     => "",
            "controls"  => "full",
            'icon'      => 'fl-icon icon-fl-vc-icon',
            "category"  => esc_html__('Fl Theme', 'fl-themes-helper'),
            'weight'    => 900,
            "params" => array_merge(array(
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Number Text', 'fl-themes-helper'),
                    'param_name'        => 'number_text',
                    'admin_label'       => true,
                    'value'             => '01',
                ),
                array(
                    'type'              => 'textfield',
                    'heading'           => esc_html__('Title Text', 'fl-themes-helper'),
                    'param_name'        => 'title_text',
                    'admin_label'       => true,
                    'value'             => 'Nunc tincidunt aliquam',
                ),
                array(
                    'type'              => 'textarea_html',
                    "heading"           => esc_html__("Content", "fl-themes-helper"),
                    'param_name'        => 'content',
                    'value'             => '',
                    'holder'            => 'div',
                    'std'               => 'Accumsan blandit sem convallis a. Sed vitae euismod dolor. Cras non accumsan mi, non lacinia enim. Quisque porta et orci eget blandit.',
                    "description"       => esc_html__("Enter your text.", "fl-themes-helper")
                ),
            ), fl_helping_get_animation_option(), fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
        )
    );
}

