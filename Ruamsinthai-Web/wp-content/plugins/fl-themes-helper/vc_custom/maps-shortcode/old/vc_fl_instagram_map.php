<?php
if (function_exists('vc_map')) {
    vc_map(array(
        'name' => esc_html__('Instagram', 'fl-themes-helper'),
        'base' => 'vc_fl_instagram',
        'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
        'icon' => 'fl-icon icon-fl-vc-icon',
        'controls' => 'full',
        'weight' => 900,
        'params' => array_merge(array(

            array(
                'type'          => 'textfield',
                'heading'       => esc_html__('Login', 'fl-themes-helper'),
                'param_name'    => 'instagram_login',
                'value'         => 'trendsetter_theme',
                'description'   => '',
            ),

            array(
                'type'          => 'textfield',
                'heading'       => esc_html__('Access Token', 'fl-themes-helper'),
                'param_name'    => 'access_token',
                'value'         => '',
                'description'   => '<a href="#">How get Instagram Access Token</a>',
            ),

            array(
                'type'          => 'textarea',
                'heading'       => esc_html__('Custom Description', 'fl-themes-helper'),
                'param_name'    => 'instagram_desc',
                'value'         => 'AENEAN FEUGIAT LIBERO LIGULA, EGET CURSUS IPSUM LAOREET.',
                'description'   => '',
            ),

        ), fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),

    ));
}

