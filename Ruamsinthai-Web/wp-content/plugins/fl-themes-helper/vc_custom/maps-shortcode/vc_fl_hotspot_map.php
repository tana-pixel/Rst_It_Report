<?php
if (function_exists('vc_map')) {
                vc_map(
                array(
                    'name' => esc_html__('Hotspot','fl-themes-helper'),
                    'base' => 'fl_hotspot',
                    'class' => 'fl_hotspot fl_shortcode',
                    'icon' => 'fl-icon icon-fl-vc-icon',
                    "category" => esc_html__('Fl Theme', 'fl-themes-helper'),
                    'params' => array_merge(array(
                        array(
                            'type'				=> 'attach_image',
                            'heading'			=> esc_html__('Image','fl-themes-helper'),
                            'param_name'		=> 'image',
                            'edit_field_class'	=> 'vc_col-sm-12',
                            'description'       => esc_html__('Don\'t use characters such as " , \' " in content', 'fl-themes-helper'),

                        ),
                        array(
                            'type'				=> 'fl_hotspot_param',
                            'heading'			=> '',
                            'param_name'		=> 'hotspot_data',
                            'edit_field_class'	=> 'vc_col-sm-12',
                        ),

                        array(
                            'type'          => 'fl_checkbox',
                            'class'         => '',
                            'heading'       => '',
                            'param_name'    => 'custom_color',
                            'value'         => 'off',
                            'description'   => '"Checked" to enable custom marker color setting',
                            'options' => array(
                                'on' => array(
                                    'on'        => esc_attr__('Yes', 'fl-themes-helper'),
                                    'off'       => esc_attr__('No', 'fl-themes-helper'),
                                ),
                            ),
                            'group'				=> esc_html__('Marker', 'fl-themes-helper'),
                        ),

                        array(
                            'type'				=> 'colorpicker',
                            'param_name'		=> 'marker_background',
                            'heading'			=> esc_html__('Marker Background', 'fl-themes-helper'),
                            'edit_field_class'	=> 'vc_col-sm-6',
                            'value'				=> '#1f94a9',
                            'group'				=> esc_html__('Marker', 'fl-themes-helper'),
                            'dependency'	=>
                                array(
                                    'element'     => 'custom_color',
                                    'value'       => 'on'
                                ),
                        ),
                        array(
                            'type'				=> 'colorpicker',
                            'param_name'		=> 'marker_deco_background',
                            'heading'			=> esc_html__('Marker decoration Border Background', 'fl-themes-helper'),
                            'edit_field_class'	=> 'vc_col-sm-6',
                            'value'				=> 'rgba(255,255,255,.3)',
                            'group'				=> esc_html__('Marker', 'fl-themes-helper'),
                            'dependency'	=>
                                array(
                                    'element'     => 'custom_color',
                                    'value'       => 'on'
                                ),
                        ),

                    ), fl_helping_get_animation_option(), fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
                )
            );
}

