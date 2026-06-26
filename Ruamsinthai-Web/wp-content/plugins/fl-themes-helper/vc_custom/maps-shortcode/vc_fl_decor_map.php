<?php

        if (function_exists('vc_map')) {
            vc_map(
                array(
                    "name"          => esc_html__("Decor","fl-themes-helper"),
                    "base"          => "vc_decor",
                    "class"         => "",
                    'icon'          => 'fl-icon icon-fl-vc-icon',
                    'category'      => esc_html__('Fl Theme', 'fl-themes-helper'),
                    "description"   => '',
                    'weight'        => 500,
                    "params" => array(


                    )
                )
            );
        }