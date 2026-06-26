<?php
 if (function_exists('vc_map')) {
     vc_map(array(
         'name' => esc_html__('Gallery Filter', 'fl-themes-helper'),
         'base' => 'vc_fl_gallery_filter',
         'category' => esc_html__('Fl Theme', 'fl-themes-helper'),
         'icon' => 'fl-icon icon-fl-vc-icon',
         'controls' => 'full',
         'weight' => 80,
         'params' => array_merge(array(
             array(
                 'type'          => 'textfield',
                 'heading'       => esc_html__('All Filter Text', 'fl-themes-helper'),
                 'param_name'    => 'show_all',
                 'value'         => 'SHOW ALL',
                 'description'   => '',
             ),
             array(
                 'type'				=> 'param_group',
                 'heading'			=> esc_html__('Layers Gallery Filter', 'fl-themes-helper'),
                 'param_name'		=> 'list_fields',
                 'params'			=> array(
                     array(
                         'type'          => 'textfield',
                         'heading'       => esc_html__('Category Class', 'fl-themes-helper'),
                         'param_name'    => 'category_class_list',
                         'value'         => 'photography',
                         'description'   => '',
                     ),
                     array(
                         'type'          => 'textfield',
                         'heading'       => esc_html__('Category Name', 'fl-themes-helper'),
                         'param_name'    => 'category_list',
                         'value'         => 'PHOTOGRAPHY',
                         'description'   => '',
                     ),
                 ),
             ),
         ), fl_helping_get_animation_option(), fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
     ));
 }