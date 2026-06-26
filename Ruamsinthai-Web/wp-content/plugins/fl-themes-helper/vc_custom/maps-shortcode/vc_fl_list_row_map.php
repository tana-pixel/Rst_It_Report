<?php
    if (function_exists('vc_map')) {
        vc_map(array(
            'name' => esc_html__('List Row', 'fl-themes-helper'),
            'base' => 'vc_fl_list_row',
            'icon' => 'fl-icon icon-fl-vc-icon',
            'as_child' => array(
                'only' => 'vc_fl_list_table'
            ),
            'params' => array_merge(array(


                array(
                    'type'              => 'textarea',
                    'heading'           => esc_html__('Content', 'fl-themes-helper'),
                    'param_name'        => 'list_content',
                    'admin_label'       => true,
                    'value'             => 'Strategic Advertising Agency',
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Content color', 'fl-themes-helper'),
                    'param_name'        => 'content_color',
                    'std'               => '',
                    'edit_field_class'  => 'vc_col-sm-3',
                ),
                array(
                    'type'              => 'colorpicker',
                    'heading'           => esc_html__('Suffix color', 'fl-themes-helper'),
                    'param_name'        => 'suffix_color',
                    'std'               => '',
                    'edit_field_class'  => 'vc_col-sm-3',
                    'dependency' => array(
                        'element'                                           => 'list_style',
                        'value_not_equal_to'                                => 'list_style_one',
                    ),
                ),


            ), fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
        ));
    }