<?php
    if (function_exists('vc_map')) {
        vc_map(array(
            'name' => esc_html__('Icon Single', 'fl-themes-helper'),
            'base' => 'vc_fl_icon_single',
            'icon' => 'fl-icon icon-fl-vc-icon',
            'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
            'controls' => 'full',
            'weight' => 500,
            'params' => array_merge(array(
                array(
                    'type' => 'dropdown',
                    'heading'       => esc_html__('Full width icon box', 'fl-themes-helper'),
                    'param_name'    => 'full_width',
                    'value' => array(
                        esc_attr__('Full width', 'fl-themes-helper')            => 'full_width',
                        esc_attr__('Full width disable', 'fl-themes-helper')    => 'disable',
                    ),

                    'std' => 'disable'
                ),
                array(
                    'type' => 'fl_radio_advanced',
                    'heading' => esc_html__('Icon position', 'fl-themes-helper'),
                    'param_name' => 'icon_position',
                    'value' => 'text-left',
                    'options' => array(
                        esc_html__('Left', 'fl-themes-helper')      => 'text-left',
                        esc_html__('Center', 'fl-themes-helper')    => 'text-center',
                        esc_html__('Right', 'fl-themes-helper')     => 'text-right',
                    ),
                    'dependency' => array(
                        'element'   => 'full_width',
                        'value'     => 'full_width'
                    ),
                    'group' => 'Icon'
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
                    'group' => 'Icon'
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
                    'group' => 'Icon'
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
                    'group' => 'Icon'
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
                    'group' => 'Icon'
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
                    'group' => 'Icon'
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
                    'group' => 'Icon'
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
                    'group' => 'Icon'
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
                    'group' => 'Icon'
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
                    'group' => 'Icon'
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
                    'group' => 'Icon'
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
                    'group' => 'Icon'
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
                    'group' => 'Icon'
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__('Icon color', 'fl-themes-helper'),
                    'param_name' => 'i_cl',
                    'edit_field_class' => 'vc_col-sm-3',
                    'value' => '',
                    'group' => 'Icon',
                    'std' => '#393939',
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__('Icon hover color', 'fl-themes-helper'),
                    'edit_field_class' => 'vc_col-sm-3',
                    'param_name' => 'i_hv_cl',
                    'value' => '',
                    'std' => '',
                    'dependency' => array(
                        'element' => 'icon_style',
                        'value' => array('fl_icon_single_style_round', 'fl_icon_single_style_rounded', 'fl_icon_single_style_square'),
                    ),
                    'group' => 'Icon'
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__('Icon Border color', 'fl-themes-helper'),
                    'edit_field_class' => 'vc_col-sm-3',
                    'param_name' => 'i_br_cl',
                    'value' => '',
                    'std' => '',
                    'dependency' => array(
                        'element' => 'icon_border',
                        'value' => array('fl_icon_single_style_border_solid', 'fl_icon_single_style_border_dashed'),
                    ),
                    'group' => 'Icon'
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__('Icon background color', 'fl-themes-helper'),
                    'param_name' => 'i_bg',
                    'value' => '',
                    'std' => '',
                    'dependency' => array(
                        'element' => 'icon_style',
                        'value' => array('fl_icon_single_style_round', 'fl_icon_single_style_rounded', 'fl_icon_single_style_square'),
                    ),
                    'group' => 'Icon'
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__('Icon background hover color', 'fl-themes-helper'),
                    'param_name' => 'i_hv_bg',
                    'value' => '',
                    'std' => '',
                    'dependency' => array(
                        'element' => 'icon_style',
                        'value' => array('fl_icon_single_style_round', 'fl_icon_single_style_rounded', 'fl_icon_single_style_square'),
                    ),
                    'group' => 'Icon'
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Icon style', 'fl-themes-helper'),
                    'param_name' => 'icon_style',
                    'group' => 'Icon',
                    'value' => array(
                        esc_attr__('Default', 'fl-themes-helper') => 'default',
                        esc_attr__('Round', 'fl-themes-helper') => 'fl_icon_single_style_round',
                        esc_attr__('Rounded', 'fl-themes-helper') => 'fl_icon_single_style_rounded',
                        esc_attr__('Square', 'fl-themes-helper') => 'fl_icon_single_style_square',
                    ),
                    'std' => 'default',
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Icon border style', 'fl-themes-helper'),
                    'param_name' => 'icon_border',
                    'dependency' => array(
                        'element' => 'icon_style',
                        'value' => array('fl_icon_single_style_round', 'fl_icon_single_style_rounded', 'fl_icon_single_style_square'),
                    ),
                    'value' => array(
                        esc_attr__('None', 'fl-themes-helper') => '',
                        esc_attr__('Border Solid', 'fl-themes-helper') => 'fl_icon_single_style_border_solid',
                        esc_attr__('Border Dashed', 'fl-themes-helper') => 'fl_icon_single_style_border_dashed',
                    ),
                    'std' => '',
                    'group' => 'Icon'
                ),
                array(
                    "type" => "fl_number",
                    "class" => "",
                    'heading' => esc_html__('Icon Font Size', 'fl-themes-helper'),
                    'param_name' => 'i_fz',
                    "value" => 22,
                    "min" => 1,
                    "max" => 500,
                    'dependency' => array(
                        'element' => 'icon_style',
                        'value' => array('default'),
                    ),
                    'group' => 'Icon',
                    "suffix" => "px",

                ),

                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Icon size', 'fl-themes-helper'),
                    'param_name' => 'icon_size',
                    'dependency' => array(
                        'element' => 'icon_style',
                        'value' => array('fl_icon_single_style_round', 'fl_icon_single_style_rounded', 'fl_icon_single_style_square'),
                    ),
                    'value' => array(
                        esc_attr__('Ultra small', 'fl-themes-helper')   => 'icon-single-ultra-small',
                        esc_attr__('Small', 'fl-themes-helper')         => 'icon-single-small',
                        esc_attr__('Normal', 'fl-themes-helper')        => 'icon-single-normal',
                        esc_attr__('Medium', 'fl-themes-helper')        => 'icon-single-medium',
                        esc_attr__('Large', 'fl-themes-helper')         => 'icon-single-large',
                    ),
                    'group' => 'Icon',
                    'std' => 'icon-single-small',
                ),

            ), fl_helping_get_animation_option(), fl_helping_get_design_tab()),

        ));
    }