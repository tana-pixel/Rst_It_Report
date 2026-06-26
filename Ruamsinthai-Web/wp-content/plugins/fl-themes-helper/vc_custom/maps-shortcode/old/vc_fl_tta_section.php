<?php
$parent_tag = vc_post_param('parent_tag', '');
$include_icon_params = ( 'vc_tta_pageable' !== $parent_tag );

if ($include_icon_params) {
	$icon_params = array(
		array(
            'type'          => 'fl_checkbox',
            'class'         => '',
            'heading'		=> esc_html__('Custom Icon', 'fl-themes-helper'),
            'param_name'	=> 'add_icon',
            'value'         => 'no',
            'options' => array(
                'true' => array(
                    'yes'           => esc_attr__('Yes', 'fl-themes-helper'),
                    'no'            => esc_attr__('No', 'fl-themes-helper'),
                ),
            ),
		),
        array(
            'type'          => 'fl_radio_advanced',
            'heading'       => esc_html__('Icon position', 'fl-themes-helper'),
            'param_name'	=> 'i_position',
            'value'			=> 'left',
            'options' => array(
                esc_html__('Before title', 'fl-themes-helper')	        => 'left',
                esc_html__('After title', 'fl-themes-helper')	        => 'right',
            ),
            'dependency'	=> array(
                'element'   => 'add_icon',
                'value'     => 'true'
            ),
        ),
    );
    $icon_params = array_merge($icon_params, (array) vc_map_integrate_shortcode(vc_icon_element_params_tta_section(), 'i_', '', array(
        'include_only_regex' => '/^(type|icon_\w*)/',
    ), array(
        'element' => 'add_icon',
        'value' => 'true',
    )));

} else {
	$icon_params = array();
}

$params = array_merge(
	array(
		array(
			'type'			=> 'textfield',
			'param_name'	=> 'title',
			'heading'		=> esc_html__('Title', 'fl-themes-helper'),
		),
		array(
			'type'			=> 'el_id',
			'heading'		=> esc_html__('Section ID', 'fl-themes-helper'),
			'param_name'	=> 'tab_id',
			'settings'		=> array(
				'auto_generate' => true,
			),
			'description'	=> esc_html__('Enter section ID. Note: make sure it is unique and valid according to','fl-themes-helper').' <a href="http://www.w3schools.com/tags/att_global_id.asp" target="_blank">'.esc_html__('w3c specification','fl-themes-helper').'</a>',
		),
	),
	$icon_params,array(
        array(
            'type'              => 'textfield',
            'heading'           => esc_html__('Custom Classes', 'fl-themes-helper'),
            'param_name'        => 'class',
            'value'             => '',
            'admin_label'       => true,
            'description'       => 'Style particular content element differently - add a class name and refer to it in custom CSS.',
        )
    )
);

vc_map(array(
	'name' => esc_html__('Section', 'fl-themes-helper'),
	'base' => 'vc_tta_section',
	'icon' => 'dfd_tta_section dfd_shortcode',
	'class' => 'dfd_tta_section dfd_shortcode',
	'allowed_container_element' => 'vc_row',
	'is_container' => true,
	'show_settings_on_create' => false,
	'as_child' => array(
		'only' => 'vc_tta_tour,vc_tta_tabs,vc_tta_accordion',
	),
	'category' => esc_html__('Content', 'fl-themes-helper'),
	'description' => esc_html__('Section for Tabs, Tours, Accordions.', 'fl-themes-helper'),
	'params' => $params,
	'js_view' => 'VcBackendTtaSectionView',
	'custom_markup' => '
		<div class="vc_tta-panel-heading">
		    <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left"><a href="javascript:;" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-accordion data-vc-container=".vc_tta-container"><span class="vc_tta-title-text">{{ section_title }}</span><i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i></a></h4>
		</div>
		<div class="vc_tta-panel-body">
			{{ editor_controls }}
			<div class="{{ container-class }}">
			{{ content }}
			</div>
		</div>',
	'default_content' => '',
));
