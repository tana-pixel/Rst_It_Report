<?php
if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_601b480a790d5',
        'title' => esc_attr__('Autos Purpose Setting','autlines'),
        'fields' => array(
            array(
                'key' => 'field_601b481d60c42',
                'label' => esc_attr__('Autos Purpose','autlines'),
                'name' => 'autos_purpose',
                'type' => 'select',
                'instructions' => esc_attr__('Select which cars to display on the page','autlines'),
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    '' => esc_attr__('All','autlines'),
                    'rent' => esc_attr__('Rent','autlines'),
                    'sell' => esc_attr__('Sell','autlines'),
                    'sold' => esc_attr__('Sold','autlines'),
                ),
                'default_value' => array(
                    ''
                ),
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 0,
                'return_format' => 'value',
                'ajax' => 0,
                'placeholder' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_template',
                    'operator' => '==',
                    'value' => 'autos.php',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'side',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

endif;
