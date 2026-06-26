<?php
    if (function_exists('vc_map')) {
        vc_map(array(
            'name' => esc_html__('Pricing Table', 'fl-themes-helper'),
            'base' => 'vc_fl_pricing_table',
            'icon' => 'fl-icon icon-fl-vc-icon',
            'as_parent' => array(
                'only' => 'vc_fl_pricing_row'
            ),
            'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
            'weight' => 300,
            'controls' => 'full',
            'params' => array_merge(array(



                array(
                    'type'          => 'fl_radio_advanced',
                    'heading'       => esc_html__('Active Pricing', 'fl-themes-helper'),
                    'param_name'    => 'active_pricing',
                    'value'		    => '',
                    'admin_label'   => true,
                    'options' => array(
                        esc_html__('Enable', 'fl-themes-helper')                 => 'enable',
                        esc_html__('Disable', 'fl-themes-helper')                => '',
                    ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__('Title', 'fl-themes-helper'),
                    'param_name'    => 'title',
                    'std'           => 'BASIC STARTUP',
                    'admin_label'   => true,
                    'value'         => '',
                    'description'   => '',
                ),

                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__('Pricing Prefix', 'fl-themes-helper'),
                    'param_name'    => 'pricing_prefix',
                    'std'           => '$',
                    'value'         => '',
                    'description'   => '',
                ),

                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__('Pricing', 'fl-themes-helper'),
                    'param_name'    => 'pricing',
                    'admin_label'   => true,
                    'std'           => '40',
                    'value'         => '',
                    'description'   => '',
                ),

                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__('Pricing period', 'fl-themes-helper'),
                    'param_name'    => 'pricing_period',
                    'admin_label'   => true,
                    'std'           => 'per month',
                    'value'         => '',
                    'description'   => '',
                ),

                array(
                    'type'              => 'textarea_html',
                    "heading"           => esc_html__("Pricing text", "fl-themes-helper"),
                    'param_name'        => 'content',
                    'value'             => '',
                    'holder'            => 'div',
                    'std'               => 'Includes everthing which necessary fora small size of startup company.',
                    "description"       => esc_html__("Enter your text.", "fl-themes-helper")
                ),

                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Icon library', 'fl-themes-helper'),
                    'value' => array(
                        esc_attr__('None', 'fl-themes-helper') => 'none',
                        esc_attr__('Font Awesome', 'fl-themes-helper') => 'fontawesome',
                        esc_attr__('Open Iconic', 'fl-themes-helper') => 'openiconic',
                        esc_attr__('Typicons', 'fl-themes-helper') => 'typicons',
                        esc_attr__('Entypo', 'fl-themes-helper') => 'entypo',
                        esc_attr__('Linecons', 'fl-themes-helper') => 'linecons',
                        esc_attr__('Etline', 'fl-themes-helper') => 'etline',
                        esc_attr__('Iconmoon', 'fl-themes-helper') => 'iconmoon',
                        esc_attr__('Linearicons', 'fl-themes-helper') => 'linearicons',
                        esc_attr__('Elusive', 'fl-themes-helper') => 'elusive',
                        esc_attr__('Iconic', 'fl-themes-helper') => 'iconic',
                        esc_attr__('Fl', 'fl-themes-helper') => 'flicon',

                    ),
                    'param_name' => 'icon_type',
                    'description' => esc_html__('Select icon library', 'fl-themes-helper'),
                    'group' => 'Custom Icon'
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name' => 'icon_fontawesome',
                    'settings' => array(
                        'emptyIcon' => false,
                        'iconsPerPage' => 300
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'fontawesome'
                    ),
                    'group' => 'Custom Icon'
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name' => 'icon_openiconic',
                    'settings' => array(
                        'emptyIcon' => false,
                        'type' => 'openiconic',
                        'iconsPerPage' => 300
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'openiconic'
                    ),
                    'group' => 'Custom Icon'
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name' => 'icon_typicons',
                    'settings' => array(
                        'emptyIcon' => false,
                        'type' => 'typicons',
                        'iconsPerPage' => 300
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'typicons'
                    ),
                    'group' => 'Custom Icon'
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name' => 'icon_entypo',
                    'settings' => array(
                        'emptyIcon' => false,
                        'type' => 'entypo',
                        'iconsPerPage' => 300
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'entypo'
                    ),
                    'group' => 'Custom Icon'
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name' => 'icon_linecons',
                    'settings' => array(
                        'emptyIcon' => false,
                        'type' => 'linecons',
                        'iconsPerPage' => 300
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'linecons'
                    ),
                    'group' => 'Custom Icon'
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name' => 'icon_etline',
                    'settings' => array(
                        'emptyIcon' => false,
                        'type' => 'etline',
                        'iconsPerPage' => 300
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'etline'
                    ),
                    'group' => 'Custom Icon'
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name' => 'icon_iconmoon',
                    'settings' => array(
                        'emptyIcon' => false,
                        'type' => 'iconmoon',
                        'iconsPerPage' => 300
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'iconmoon'
                    ),
                    'group' => 'Custom Icon'
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name' => 'icon_linearicons',
                    'settings' => array(
                        'emptyIcon' => false,
                        'type' => 'linearicons',
                        'iconsPerPage' => 300
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'linearicons'
                    ),
                    'group' => 'Custom Icon'
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name' => 'icon_elusive',
                    'settings' => array(
                        'emptyIcon' => false,
                        'type' => 'elusive',
                        'iconsPerPage' => 300
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'elusive'
                    ),
                    'group' => 'Custom Icon'
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name' => 'icon_flicon',
                    'settings' => array(
                        'emptyIcon' => false,
                        'type' => 'flicon',
                        'iconsPerPage' => 300
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'flicon'
                    ),
                    'group' => 'Custom Icon'
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'fl-themes-helper'),
                    'param_name' => 'icon_iconic',
                    'settings' => array(
                        'emptyIcon' => false,
                        'type' => 'iconic',
                        'iconsPerPage' => 300
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'iconic'
                    ),
                    'group' => 'Custom Icon'
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__('Button Text', 'fl-themes-helper'),
                    'param_name'    => 'btn_text',
                    'std'           => 'SELECT THIS',
                    'admin_label'   => true,
                    'value'         => '',
                    'description'   => '',
                ),
                array(
                    'type'          => 'vc_link',
                    'heading'       => esc_html__('Button Link', 'fl-themes-helper'),
                    'param_name'    => 'link',
                ),
            ), fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
        ));


    }
