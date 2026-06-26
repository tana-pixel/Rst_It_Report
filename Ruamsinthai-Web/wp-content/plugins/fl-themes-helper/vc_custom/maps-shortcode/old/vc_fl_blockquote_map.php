<?php
        if (function_exists('vc_map')) {
            vc_map(array(
                'name' => esc_html__('Blockquote', 'fl-themes-helper'),
                'base' => 'vc_fl_blockquote',
                'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
                'icon' => 'fl-icon icon-fl-vc-icon',
                'controls' => 'full',
                'weight' => 900,
                'params' => array_merge(array(
                    array(
                        'type'          => 'textarea',
                        'heading'       => esc_html__('Title Text', 'fl-themes-helper'),
                        'param_name'    => 'title_text',
                        'value'         => 'Quote',
                        'admin_label'   => true,
                        'description'   => '',
                    ),
                    array(
                        'type'          => 'textarea',
                        'heading'       => esc_html__('Blockquote Text', 'fl-themes-helper'),
                        'param_name'    => 'quote_text',
                        'value'         => '',
                        'admin_label'   => true,
                        'description'   => '',
                    ),
                    array(
                        'type'          => 'textarea',
                        'heading'       => esc_html__('Author', 'fl-themes-helper'),
                        'param_name'    => 'author',
                        'value'         => '- Benjamin Franklin',
                        'admin_label'   => true,
                        'description'   => '',
                    ),
                    array(
                        'type'          => 'textarea',
                        'heading'       => esc_html__('Profession', 'fl-themes-helper'),
                        'param_name'    => 'profession',
                        'value'         => 'Art Director',
                        'admin_label'   => true,
                        'description'   => '',
                    ),

                    array(
                        'type'          => 'dropdown',
                        'heading'       => esc_html__('Select your icon', 'fl-themes-helper'),
                        'value' => array(
                            esc_attr__('Default', 'fl-themes-helper')   => 'default',
                            esc_attr__('Custom', 'fl-themes-helper')    => 'flquote',
                        ),
                        'param_name'    => 'icon_type',
                        'std'           => 'default',
                        'group'         => 'Icon',
                    ),
                    array(
                        'type'       => 'iconpicker',
                        'heading'    => esc_html__('Icon', 'fl-themes-helper'),
                        'param_name' => 'icon_flquote',
                        'settings' => array(
                            'emptyIcon'     => false,
                            'type'          => 'flquote',
                            'iconsPerPage'  => 300
                        ),
                        'dependency' => array(
                            'element'       => 'icon_type',
                            'value'         => 'flquote'
                        ),
                        'group'         => 'Icon',

                    ),
                    ), fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),

            ));
        }

