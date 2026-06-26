<?php
    if (function_exists('vc_map')) {
        vc_map(array(
            'name' => esc_html__('Services Slider', 'fl-themes-helper'),
            'base' => 'vc_fl_services_slider',
            'icon' => 'fl-icon icon-fl-vc-icon',
            'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
            'controls' => 'full',
            'params' => array_merge(array(
                array(
                    'type'				=> 'param_group',
                    'heading'			=> esc_html__('Slide Content', 'fl-themes-helper'),
                    'param_name'		=> 'list_fields',
                    'params'			=> array(
                        array(
                            'type'				=> 'attach_image',
                            'heading'			=> esc_html__('Services Image','fl-themes-helper'),
                            'param_name'		=> 'image_id',
                        ),
                        array(
                            'type'          => 'textfield',
                            'heading'       => esc_html__('Services Title', 'fl-themes-helper'),
                            'param_name'    => 'services_title',
                            'value'         => 'Vehicle Color Change',
                            'description'   => '',
                            'admin_label'   => true
                        ),
                        array(
                            'type'          => 'textfield',
                            'heading'       => esc_html__('Title Link', 'fl-themes-helper'),
                            'param_name'    => 'title_link',
                            'value'         => '#',
                            'description'   => '',
                            'admin_label'   => true
                        ),

                    ),
                ),
                // Color Setting
                array(
                    'type'          => 'fl_checkbox',
                    'class'         => '',
                    'heading'       => 'Custom color',
                    'param_name'    => 'custom_color',
                    'value'         => 'disable',
                    'options' => array(
                        'enable' => array(
                            'enable'            => esc_attr__('Enable', 'fl-themes-helper'),
                            'disable'           => esc_attr__('Disable', 'fl-themes-helper'),
                        ),
                    ),
                    'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                ),
                array(
                    'type'				=> 'fl_heading_param',
                    'text'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                    'param_name'		=> 'title_info_typography',
                    'class'             => 'fl-responsive-title',
                    'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                    'dependency' => array(
                        'element'                   => 'custom_color',
                        'value'                     => 'enable',
                    ),
                ),
                array(
                    'type'              => 'colorpicker',
                    'param_name'        => 'title_cl',
                    'heading'           => esc_html__('Title Color', 'fl-themes-helper'),
                    'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                    'edit_field_class'  => 'vc_col-sm-4',
                    'dependency' => array(
                        'element'                   => 'custom_color',
                        'value'                     => 'enable',
                    ),
                    'std'               => ''
                ),
                array(
                    'type'              => 'colorpicker',
                    'param_name'        => 'dots_cl',
                    'heading'           => esc_html__('Dots Color', 'fl-themes-helper'),
                    'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                    'edit_field_class'  => 'vc_col-sm-4',
                    'dependency' => array(
                        'element'                   => 'custom_color',
                        'value'                     => 'enable',
                    ),
                    'std'               => ''
                ),
                array(
                    'type'              => 'colorpicker',
                    'param_name'        => 'dots_active_cl',
                    'heading'           => esc_html__('Dots active and hover Color', 'fl-themes-helper'),
                    'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                    'edit_field_class'  => 'vc_col-sm-4',
                    'dependency' => array(
                        'element'                   => 'custom_color',
                        'value'                     => 'enable',
                    ),
                    'std'               => ''
                ),

            ), fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
        ));
    }