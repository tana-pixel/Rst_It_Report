<?php
    if (function_exists('vc_map')) {
        vc_map(array(
            'name' => esc_html__('Car Deals Of The Week Row', 'fl-themes-helper'),
            'base' => 'vc_fl_car_detail_of_the_week_row',
            'icon' => 'fl-icon icon-fl-vc-icon',
            'as_child' => array(
                'only' => 'vc_fl_car_detail_of_the_week'
            ),
            "as_parent" => array(
                'only' => ' vc_single_image, fl_hotspot',
            ),
            "content_element" => true,
            "js_view"  => 'VcColumnView',
            'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
            'controls' => 'full',

            'params' => array_merge(array(

             array(
                 'type'          => 'textfield',
                 'heading'       => esc_html__('Car Title', 'fl-themes-helper'),
                 'param_name'    => 'title_car',
                 'value'         => 'Citroen C4',
                 'description'   => '',
             ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__('Car Price Suffix', 'fl-themes-helper'),
                    'param_name'    => 'car_price_suffix',
                    'value'         => 'MSRP',
                    'description'   => '',
                    'edit_field_class'  => 'vc_col-sm-4',
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__('Car Price', 'fl-themes-helper'),
                    'param_name'    => 'car_price',
                    'value'         => '$60,400',
                    'description'   => '',
                    'edit_field_class'  => 'vc_col-sm-8',
                ),
                array(
                    'type'				=> 'param_group',
                    'heading'			=> esc_html__('Icon Car Content', 'fl-themes-helper'),
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
                            'heading'       => esc_html__('Icon Text', 'fl-themes-helper'),
                            'param_name'    => 'title',
                            'value'         => '35k mi',
                            'description'   => '',
                        ),

                    ),
                ),
            ), fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
        ));
    }