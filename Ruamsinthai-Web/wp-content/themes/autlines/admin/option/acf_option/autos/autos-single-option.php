<?php
if( function_exists('acf_add_local_field_group') ):
    // Gallery Function
    acf_add_local_field_group(array(
        'key' => 'group_5d0e22dc791d8',
        'title' => esc_attr__('Gallery','autlines'),
        'fields' => array(
            array(
                'key' => 'field_5d0e22f0435c2',
                'label' => esc_attr__('Gallery','autlines'),
                'name' => 'gallery_autos',
                'type' => 'gallery',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'array',
                'preview_size' => 'full',
                'insert' => 'append',
                'library' => 'all',
                'min' => '',
                'max' => '',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
            array(
                'key' => 'field_5d0e23aa79f12',
                'label' => esc_attr__('Gallery "Promo Images"','autlines'),
                'name' => 'gallery_promo_images',
                'type' => 'gallery',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'array',
                'preview_size' => 'full',
                'insert' => 'append',
                'library' => 'all',
                'min' => '',
                'max' => '',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'pixad-autos',
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

    // Sub Title Option
    acf_add_local_field_group(array(
        'key' => 'group_57f7a57b1a6b1',
        'title' => esc_attr__('Sub Title Content','autlines'),
        'fields' => array(
            array(
                'key' => 'field_57f7a6039be07',
                'label' => 'Sub Title',
                'name' => 'sub_title_auto',
                'type' => 'text',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'pixad-autos',
                ),
            ),
        ),
        'menu_order' => 1,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));
    // Car List Description
    acf_add_local_field_group(array(
        'key' => 'group_yntDla4Bjb9Do',
        'title' => esc_attr__('Car List Setting','autlines'),
        'fields' => array(
            array(
                'key' => 'field_rJpIYNoRrJEam',
                'label' => esc_attr__('Car List Description','autlines'),
                'name' => 'list_description_auto',
                'type' => 'wysiwyg',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'pixad-autos',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));


if (class_exists('Pixad_Booking_AUTO')){
    acf_add_local_field_group(array(
        'key' => 'group_5de169d858057',
        'title' => esc_attr__('Booking Car','autlines'),
        'fields' => array(
            array(
                'key' => 'field_5de169e31b2d5',
                'label' => esc_attr__('Booking Car','autlines'),
                'name' => 'booking_car',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'show' => 'Show',
                    'hide' => 'Hide',
                ),
                'default_value' => array(
                    0 => 'hide',
                ),
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 0,
                'return_format' => 'value',
                'ajax' => 0,
                'placeholder' => '',
            ),
            array(
                'key' => 'field_IfbnOeVoienqK',
                'label' => esc_attr__('Booking Car Preview Booked Calendar','autlines'),
                'name' => 'booking_car_review_calendar',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'show' => 'Show',
                    'hide' => 'Hide',
                ),
                'default_value' => array(
                    0 => 'hide',
                ),
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 0,
                'return_format' => 'value',
                'ajax' => 0,
                'placeholder' => '',
            ),
            array(
                'key' => 'field_pmHMO0R2DEnbg',
                'label' => esc_attr__('Preview Mod Calendar','autlines'),
                'instructions' => esc_attr__('A familiarization calendar, if none of the reserved dates is selected, a false calendar with false dates is displayed','autlines'),
                'name' => 'calendar_preview_mode',
                'type' => 'select',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'show' => 'Show',
                    'hide' => 'Hide',
                ),
                'default_value' => array(
                    0 => 'hide',
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
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'pixad-autos',
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
}



    acf_add_local_field_group(array(
        'key' => 'group_5de428ad1d802',
        'title' => esc_attr__('Auto Label','autlines'),
        'fields' => array(
            array(
                'key' => 'field_5de428b96858f',
                'label' => esc_attr__('Label Auto','autlines'),
                'name' => 'auto_featured_text',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5de428f763883',
                'label' => esc_attr__('Label Background','autlines'),
                'name' => 'auto_featured_text_background',
                'type' => 'color_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'pixad-autos',
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