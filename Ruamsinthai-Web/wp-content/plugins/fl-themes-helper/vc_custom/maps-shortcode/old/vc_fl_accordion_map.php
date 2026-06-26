<?php
if(function_exists("vc_map"))
{
    vc_map(array(
        'name'          => esc_html__('Custom Accordion', 'fl-themes-helper'),
        'base'          => 'fl_accordion',
        'icon'          => 'fl-icon icon-fl-vc-icon',
        'is_container'  => true,
        'show_settings_on_create' => true,
        'as_parent' => array(
            'only' => 'vc_tta_section'
        ),
        "category"      => esc_html__("Fl Theme", "fl-themes-helper"),
        'params' => array_merge(array(

            array(
                'type'          => 'textfield',
                'param_name'    => 'active_section',
                'heading'       =>  esc_html__('Active Accordion', 'fl-themes-helper'),
                'value'         => 1,
                'description'   => '',
            ),
            array(
                'type'          => 'checkbox',
                'param_name'    => 'collapsible_all',
                'heading'       =>  esc_html__('Collapse All', 'fl-themes-helper'),
                'description'   => '',
            ),
            array(
                'type'          => 'fl_checkbox',
                'class'         => '',
                'heading'       => 'Custom color',
                'param_name'    => 'custom_color',
                'value'         => 'disable',
                'options' => array(
                    'enable' => array(
                        'enable'            => esc_attr__('Enable', 'fl-themes-helper'),
                        'disable'           => esc_attr__('Disable', 'fl-themes-helper'),
                    ),
                ),
                'group'       => 'Color',
            ),

            array(
                'type'          => 'colorpicker',
                'param_name'    => 'act_bg_cl',
                'heading'       => esc_html__('Accordion Active Background', 'fl-themes-helper'),
                'group'         => 'Color',
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element'                   => 'custom_color',
                    'value'                     => 'enable',
                ),
                'std'           => ''
            ),
            array(
                'type'          => 'colorpicker',
                'param_name'    => 'act_cl',
                'heading'       => esc_html__('Accordion Active Color', 'fl-themes-helper'),
                'group'         => 'Color',
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element'                   => 'custom_color',
                    'value'                     => 'enable',
                ),
                'std'           => ''
            ),
            array(
                'type'          => 'colorpicker',
                'param_name'    => 'act_body_bg',
                'heading'       => esc_html__('Body Background Color', 'fl-themes-helper'),
                'group'         => 'Color',
                'edit_field_class' => 'vc_col-sm-12',
                'dependency' => array(
                    'element'                   => 'custom_color',
                    'value'                     => 'enable',
                ),
                'std'           => ''
            ),

        ), fl_helping_get_animation_option(),fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
        'js_view' => 'VcBackendTtaAccordionView',
        'custom_markup' => '
					<div class="vc_tta-container" data-vc-action="collapseAll">
					    <div class="vc_general vc_tta vc_tta-accordion vc_tta-color-backend-accordion-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-o-shape-group vc_tta-controls-align-left vc_tta-gap-2">
					        <div class="vc_tta-panels vc_clearfix {{container-class}}">
					            {{ content }}
					            <div class="vc_tta-panel vc_tta-section-append">
					                <div class="vc_tta-panel-heading">
					                    <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left">
					                        <a href="javascript:;" aria-expanded="false" class="vc_tta-backend-add-control">
					                            <span class="vc_tta-title-text">' . esc_html__('Add Section', 'fl-themes-helper') . '</span>
					                                <i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i>
					                        </a>
					                    </h4>
					                </div>
					            </div>
					        </div>
					    </div>
					</div>',
        'default_content' => '[vc_tta_section title="' . sprintf('%s %d', esc_html__('Section', 'fl-themes-helper'), 1) . '"][/vc_tta_section][vc_tta_section title="' . sprintf('%s %d', esc_html__('Section', 'fl-themes-helper'), 2) . '"][/vc_tta_section]'
    ));
}