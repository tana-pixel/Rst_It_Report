<?php
    if (function_exists('vc_map')) {
        vc_map(array(
            'name' => esc_html__('Number Content', 'fl-themes-helper'),
            'base' => 'vc_fl_number_content',
            'icon' => 'fl-icon icon-fl-vc-icon',
            'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
            'controls' => 'full',
            'params' => array_merge(array(
                array(
                    'type'				=> 'param_group',
                    'heading'			=> esc_html__('Number Content', 'fl-themes-helper'),
                    'param_name'		=> 'list_fields',
                    'params'			=> array(
                        array(
                            'type'          => 'textfield',
                            'heading'       => esc_html__('Number', 'fl-themes-helper'),
                            'param_name'    => 'number',
                            'value'         => '01',
                            'description'   => '',
                            'admin_label'   => true
                        ),
                        array(
                            'type'          => 'textfield',
                            'heading'       => esc_html__('Text Title', 'fl-themes-helper'),
                            'param_name'    => 'title',
                            'value'         => 'Search Our Inventory',
                            'description'   => '',
                            'admin_label'   => true
                        ),

                        array(
                            'type'          => 'textarea',
                            'heading'       => esc_html__('Text Content', 'fl-themes-helper'),
                            'param_name'    => 'text_content',
                            'value'         => 'Magna aliqua enim aduas dui veniam quis nostrud exercitation ullam laboris aut aliquip ex consequat. ',
                            'description'   => '',
                            'admin_label'   => true
                        ),
                    ),
                ),


            ), fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
        ));
    }