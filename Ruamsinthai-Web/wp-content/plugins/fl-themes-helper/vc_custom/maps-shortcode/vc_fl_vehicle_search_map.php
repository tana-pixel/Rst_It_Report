<?php

if (class_exists('PIXAD_Settings')) {


    global $post;
    $Settings = new PIXAD_Settings();
    $settings	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
    $validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true );
    $validate = pixad::validation( $validate );

    $args = array( 'post_type' => 'pixad-autos', 'posts_per_page' => -1,);
    $rand_posts = get_posts( $args );

    $custom_settings_quantity = 1;
    while ($custom_settings_quantity <= 35) {
        ${'_custom_'.$custom_settings_quantity.'_setting_value'} = array();
        $custom_settings_quantity++;
    }
    foreach( $rand_posts as $post ) :

        $custom_settings_quantity = 1;
        while ($custom_settings_quantity <= 35) {

            $_custom_setting_key = get_post_custom_values('_custom_'.$custom_settings_quantity.''); // Получили характеристику
            if ($_custom_setting_key[0] !== '') {    // Проверили или есть значение у характеристики
                array_push(${'_custom_'.$custom_settings_quantity.'_setting_value'}, $_custom_setting_key[0]); // Добавили значение в нужный массив
            }
            $custom_settings_quantity++;
        }

    endforeach;
    wp_reset_postdata() ;



    $custom_settings_quantity = 1;
    while ($custom_settings_quantity <= 35) {
        ${'_custom_'.$custom_settings_quantity.'_setting_value'} = array_unique(array_filter(${'_custom_'.$custom_settings_quantity.'_setting_value'}));

        ${'custom_'.$custom_settings_quantity.'_setting_array'}  = array(
            'type' => 'checkbox',
            'heading' => '',
            'param_name' => 'custom_'.$custom_settings_quantity,
            'value' => '',
            'dependency'    => array(
                'element'   => 'booking_pick_up_title',
                'value'     => '4'
            ),

        );
        if(!empty(${'_custom_'.$custom_settings_quantity.'_setting_value'}) && $validate['custom_'. $custom_settings_quantity .'_show']) {


            ${'custom_'.$custom_settings_quantity.'_setting_array'} = array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Show '.$validate['custom_'. $custom_settings_quantity .'_name'], 'fl-themes-helper' ),
                'param_name' => 'custom_'.$custom_settings_quantity,
                'value' => ''
            );


        }

        $custom_settings_quantity++;
    }

    /// section_map
    vc_map(
        array(
            "name"          => esc_html__( "Vehicle Search", 'fl-themes-helper' ),
            "base"          => "vehicle_search",
            'icon'          => 'fl-icon icon-fl-vc-icon',
            'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
            "params" => array_merge(array(
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__( 'Show Booking Time:', 'fl-themes-helper' ),
                    'param_name' => 'booking_time',
                    'value' => ''
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => esc_html__( "Booking PICK-UP DATE Title:", 'fl-themes-helper' ),
                    "param_name" => "booking_pick_up_title",
                    "value" => 'Pick-up Date'
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => esc_html__( "Booking DROP-OFF DATE Title:", 'fl-themes-helper' ),
                    "param_name" => "booking_drop_off_title",
                    "value" => 'Drop-off Date'
                ),

                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__( 'Show Price Range:', 'fl-themes-helper' ),
                    'param_name' => 'price_range',
                    'value' => ''
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => esc_html__( "Price Block Title:", 'fl-themes-helper' ),
                    "param_name" => "price_range_title",
                    "value" => 'Price Range'
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__( 'Show Vehicle Body Type:', 'fl-themes-helper' ),
                    'param_name' => 'vehicle_body',
                    'value' => ''
                ),

                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__( 'Show Makers of Vehicle:', 'fl-themes-helper' ),
                    'param_name' => 'vehicle_makers',
                    'value' => ''
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => esc_html__( "Makers of Vehicle Title:", 'fl-themes-helper' ),
                    "param_name" => "vehicle_makers_title",
                    "value" => 'Select Make'
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__( 'Show Model of the Vehicle:', 'fl-themes-helper' ),
                    'param_name' => 'vehicle_model',
                    'value' => ''
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => esc_html__( "Model of the Vehicle Title:", 'fl-themes-helper' ),
                    "param_name" => "vehicle_model_title",
                    "value" => 'Select a Model'
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__( 'Show Fuel Type:', 'fl-themes-helper' ),
                    'param_name' => 'fuel_type',
                    'value' => ''
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => esc_html__( "Fuel Type Title:", 'fl-themes-helper' ),
                    "param_name" => "fuel_type_title",
                    "value" => 'Fuel Type'
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__( 'Show Mileage Range:', 'fl-themes-helper' ),
                    'param_name' => 'mileage_range',
                    'value' => ''
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => esc_html__( "Mileage Block Title:", 'fl-themes-helper' ),
                    "param_name" => "mileage_range_title",
                    "value" => 'Mileage Range'
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__( 'Show Year Range:', 'fl-themes-helper' ),
                    'param_name' => 'year_range',
                    'value' => ''
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => esc_html__( "Year Range Title:", 'fl-themes-helper' ),
                    "param_name" => "year_range_title",
                    "value" => 'Year Range'
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__( 'Show Transmission Type:', 'fl-themes-helper' ),
                    'param_name' => 'transmission_type',
                    'value' => ''
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => esc_html__( "Transmission Type Title:", 'fl-themes-helper' ),
                    "param_name" => "transmission_type_title",
                    "value" => 'Transmission Range'
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__( 'Show Engine Volume:', 'fl-themes-helper' ),
                    'param_name' => 'engine_volume',
                    'value' => ''
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => esc_html__( "Engine Volume Title:", 'fl-themes-helper' ),
                    "param_name" => "engine_volume_title",
                    "value" => 'Engine Volume'
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__( 'Show Condition:', 'fl-themes-helper' ),
                    'param_name' => 'condition',
                    'value' => ''
                ),


                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => esc_html__( "Condition Title:", 'fl-themes-helper' ),
                    "param_name" => "condition_title",
                    "value" => 'Condition'
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__( 'Show Purpose:', 'fl-themes-helper' ),
                    'param_name' => 'purpose',
                    'value' => ''
                ),


                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => esc_html__( "Purpose Title:", 'fl-themes-helper' ),
                    "param_name" => "purpose_title",
                    "value" => 'Purpose'
                ),
                $custom_1_setting_array,
                $custom_2_setting_array,
                $custom_3_setting_array,
                $custom_4_setting_array,
                $custom_5_setting_array,
                $custom_6_setting_array,
                $custom_7_setting_array,
                $custom_8_setting_array,
                $custom_9_setting_array,
                $custom_10_setting_array,
                $custom_11_setting_array,
                $custom_12_setting_array,
                $custom_13_setting_array,
                $custom_14_setting_array,
                $custom_15_setting_array,
                $custom_16_setting_array,
                $custom_17_setting_array,
                $custom_18_setting_array,
                $custom_19_setting_array,
                $custom_20_setting_array,
                $custom_21_setting_array,
                $custom_22_setting_array,
                $custom_23_setting_array,
                $custom_24_setting_array,
                $custom_25_setting_array,
                $custom_26_setting_array,
                $custom_27_setting_array,
                $custom_28_setting_array,
                $custom_29_setting_array,
                $custom_30_setting_array,
                $custom_31_setting_array,
                $custom_32_setting_array,
                $custom_33_setting_array,
                $custom_34_setting_array,
                $custom_35_setting_array,


        ), fl_helping_get_animation_option(), fl_helping_get_design_tab()))
    );
    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_Vehicle_Search extends WPBakeryShortCode {

        }
    }

}