<?php
        if (function_exists('vc_map')) {
            vc_map(array(
                'name' => esc_html__('Finance Calculator', 'fl-themes-helper'),
                'base' => 'vc_fl_finance_calculator',
                'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
                'icon' => 'fl-icon icon-fl-vc-icon',
                'controls' => 'full',
                'weight' => 900,
                'params' => array_merge(
                    array(
                        array(
                            'type'              => 'textfield',
                            'heading'           => esc_html__('Currency Symbol', 'fl-themes-helper'),
                            'param_name'        => 'currency_symbol',
                            'value'             => '$',
                        ),
                        array(
                            'type'              => 'textfield',
                            'heading'           => esc_html__('Thousand', 'fl-themes-helper'),
                            'param_name'        => 'autos_thousand',
                            'value'             => ',',
                        ),
                        array(
                            'type'              => 'textfield',
                            'heading'           => esc_html__('Decimal', 'fl-themes-helper'),
                            'param_name'        => 'autos_decimal',
                            'value'             => '.',
                        ),
                        array(
                            'type'              => 'textfield',
                            'heading'           => esc_html__('Decimal Number', 'fl-themes-helper'),
                            'param_name'        => 'autos_decimal_number',
                            'value'             => '0',
                        ),

                        array(
                            'type'              => 'textfield',
                            'heading'           => esc_html__('Price Auto', 'fl-themes-helper'),
                            'param_name'        => 'price_auto',
                            'value'             => '15000',
                        ),

                        array(
                            'type'              => 'textfield',
                            'heading'           => esc_html__('Interest rate', 'fl-themes-helper'),
                            'param_name'        => 'interest_rate',
                            'value'             => '5',
                        ),

                        array(
                            'type'              => 'textfield',
                            'heading'           => esc_html__('Period (mou)', 'fl-themes-helper'),
                            'param_name'        => 'period',
                            'value'             => '36',
                        ),

                        array(
                            'type'              => 'textfield',
                            'heading'           => esc_html__('Down Payment', 'fl-themes-helper'),
                            'param_name'        => 'down_payment',
                            'value'             => '1000',
                        ),
                    ),
                    fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),

            ));
        }

