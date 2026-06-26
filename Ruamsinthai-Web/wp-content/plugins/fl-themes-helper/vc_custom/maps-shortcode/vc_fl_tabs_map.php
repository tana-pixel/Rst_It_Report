<?php
    if (function_exists('vc_map')) {
        $tab_id_1 = time() . '-1-' . rand( 0, 100 );
        $tab_id_2 = time() . '-2-' . rand( 0, 100 );
        vc_map( array(
            'name'                      => esc_html__( 'Tabs', 'fl-themes-helper' ),
            'base'                      => 'vc_tabs',
            'category'                  => esc_html__('Fl Theme', 'fl-themes-helper'),
            'show_settings_on_create'   => false,
            'is_container'              => true,
            'icon'                      => 'fl-icon icon-fl-vc-icon',
            'description'               => esc_html__( 'Place tabbed content', 'fl-themes-helper' ),
            'weight'                    => 900,
            'params' => array_merge(array(), fl_helping_get_animation_option(), fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
            'custom_markup' => '<div class="wpb_tabs_holder wpb_holder vc_container_for_children">
                      <ul class="tabs_controls">
                      </ul>
                      %content%
                      </div>',
            'default_content' => '[vc_tab title="' . esc_html__( 'Tab 1', 'fl-themes-helper' ) . '" tab_id="' . $tab_id_1 . '"][/vc_tab]
                                  [vc_tab title="' . esc_html__( 'Tab 2', 'fl-themes-helper' ) . '" tab_id="' . $tab_id_2 . '"][/vc_tab]',
            'js_view' => 'VcTabsView'
        ) );

        vc_map( array(
            'name' => esc_html__( 'Tab Item', 'fl-themes-helper' ),
            'base' => 'vc_tab',
            'category'  => esc_html__('Fl Theme', 'fl-themes-helper'),
            'allowed_container_element' => 'vc_row',
            'is_container' => true,
            'content_element' => false,
            'params' => array(
                array(
                    'type'          => 'tab_id',
                    'heading'       => esc_html__( 'ID', 'fl-themes-helper' ),
                    'param_name'    => 'tab_id'
                ),
                array(
                    'type'              => 'textarea',
                    'heading'           => esc_html__( 'Title text', 'fl-themes-helper' ),
                    'param_name'        => 'title',
                    'value'             => 'Tab',
                    'std'               => 'Tab',
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
                        esc_attr__('Flaticon', 'fl-themes-helper') => 'flaticon',
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
                    'param_name' => 'icon_flaticon',
                    'settings' => array(
                        'emptyIcon' => false,
                        'type' => 'flaticon',
                        'iconsPerPage' => 300
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'flaticon'
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
                    'type'			=> 'attach_image',
                    'heading'		=> esc_html__('Upload Background Image:', 'fl-themes-helper'),
                    'param_name'	=> 'image_id',
                    'group'         => 'Custom Style'
                ),

            ),
            'js_view' => 'VcTabView'
        ) );
    }