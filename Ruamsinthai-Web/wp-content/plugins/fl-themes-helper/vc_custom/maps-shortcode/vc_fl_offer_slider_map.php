<?php
    if (function_exists('vc_map')) {
        vc_map(array(
            'name' => esc_html__('Offer Slider', 'fl-themes-helper'),
            'base' => 'vc_fl_offer_slider',
            'icon' => 'fl-icon icon-fl-vc-icon',
            'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
            'controls' => 'full',
            'params' => array_merge(array(
                array(
                    'type'				=> 'param_group',
                    'heading'			=> esc_html__('Offer Slide Content', 'fl-themes-helper'),
                    'param_name'		=> 'list_fields',
                    'params'			=> array(
                        array(
                            'type' => 'iconpicker',
                            'heading' => esc_html__('Icon', 'fl-themes-helper'),
                            'param_name' => 'car_icon',
                            'settings' => array(
                                'emptyIcon' => false,
                                'type' => 'flicon',
                                'iconsPerPage' => 300
                            ),
                        ),

                        array(
                            'type'          => 'textfield',
                            'heading'       => esc_html__('Icon Text Title', 'fl-themes-helper'),
                            'param_name'    => 'i_title',
                            'value'         => 'BUY SELL CARS',
                            'description'   => '',
                            'admin_label'   => true
                        ),

                        array(
                            'type'          => 'textarea',
                            'heading'       => esc_html__('Text Content', 'fl-themes-helper'),
                            'param_name'    => 'text_content',
                            'value'         => 'Adipisicing eiusmod tempor incidids labore dolore magna aliqa ust enim ad minim veniams quis nostrud sed citation ullam co laboris nisit aliquip in culpa qui officia deserunt mollit anim.',
                            'description'   => '',
                            'admin_label'   => true
                        ),

                        array(
                            'type'				=> 'attach_image',
                            'heading'			=> esc_html__('Content Background','fl-themes-helper'),
                            'param_name'		=> 'image_id',
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
                    'param_name'        => 'primary_cl',
                    'heading'           => esc_html__('Primary Color', 'fl-themes-helper'),
                    'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                    'edit_field_class'  => 'vc_col-sm-6',
                    'dependency' => array(
                        'element'                   => 'custom_color',
                        'value'                     => 'enable',
                    ),
                    'std'               => ''
                ),
                array(
                    'type'              => 'colorpicker',
                    'param_name'        => 'secondary_cl',
                    'heading'           => esc_html__('Secondary Color', 'fl-themes-helper'),
                    'group'				=> esc_html__('Color Setting', 'fl-themes-helper'),
                    'edit_field_class'  => 'vc_col-sm-6',
                    'dependency' => array(
                        'element'                   => 'custom_color',
                        'value'                     => 'enable',
                    ),
                    'std'               => ''
                ),

            ), fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
        ));
    }