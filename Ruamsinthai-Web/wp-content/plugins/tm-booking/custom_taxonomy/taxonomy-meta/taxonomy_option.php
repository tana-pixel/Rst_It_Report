<?php
if(class_exists('ACF')) {
    add_action('acf/init', function() {
        acf_add_local_field_group(array(
            'key' => 'group_61c7471d4235e',
            'title' => 'Discount',
            'fields' => array(
                array(
                    'key' => 'field_61c7473ebb11d',
                    'label' => 'Discount Percent',
                    'name' => 'discount_percent',
                    'type' => 'number',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '%',
                    'prepend' => '',
                    'append' => '',
                    'min' => '',
                    'max' => '',
                    'step' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'taxonomy',
                        'operator' => '==',
                        'value' => 'transports-discount',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));

        acf_add_local_field_group(array(
            'key' => 'group_61dasaa2e3eqe',
            'title' => 'Extra',
            'fields' => array(
                array(
                    'key' => 'field_61aafsdasb11d',
                    'label' => 'Price',
                    'name' => 'extra_price',
                    'type' => 'number',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'prepend' => '',
                    'append' => '',
                    'min' => '',
                    'max' => '',
                    'step' => '',
                ),

                array(
                    'key' => 'field_61c4deefsf491d',
                    'label' => 'Per',
                    'name' => 'per',
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
                        'total' => 'Total',
                        'hour' => 'Hour',
                        'day' => 'Day',
                        'week' => 'Week',
                        'month' => 'Month',
                    ),
                    'default_value' => false,
                    'allow_null' => 0,
                    'multiple' => 0,
                    'ui' => 0,
                    'return_format' => 'value',
                    'ajax' => 0,
                    'placeholder' => '',
                ),
                array(
                    'key' => 'field_61c4deefsf491d',
                    'label' => 'Basic',
                    'name' => 'basic',
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
                        'yes' => 'Yes',
                        'no' => 'No',
                    ),
                    'default_value' => false,
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
                        'param' => 'taxonomy',
                        'operator' => '==',
                        'value' => 'transports-extra',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));

        acf_add_local_field_group(array(
            'key' => 'group_61dasaddasdasda2e3eqe',
            'title' => 'Drop off',
            'fields' => array(

                array(
                    'key' => 'field_61c4deefsfsasfafwf491d',
                    'label' => 'Free/Price',
                    'name' => 'free',
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
                        'free' => 'Free',
                        'price' => 'Price',
                    ),
                    'default_value' => false,
                    'allow_null' => 0,
                    'multiple' => 0,
                    'ui' => 0,
                    'return_format' => 'value',
                    'ajax' => 0,
                    'placeholder' => '',
                ),


                array(
                    'key' => 'field_61aafffwqfsdasb11d',
                    'label' => 'Price',
                    'name' => 'drop_price',
                    'type' => 'number',
                    'instructions' => '',
                    'required' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'prepend' => '',
                    'append' => '',
                    'min' => '',
                    'max' => '',
                    'step' => '',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_61c4deefsfsasfafwf491d',
                                'operator' => '==',
                                'value' => 'price',
                            ),
                        ),
                    ),
                ),


            ),
            'location' => array(
                array(
                    array(
                        'param' => 'taxonomy',
                        'operator' => '==',
                        'value' => 'transports-delivery',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));
    });


} else {

    class TM_Booking_Extra {

        private $fields = [
            'extra_price' => [
                'type' => 'number',
                'label' => 'Price',
                'default' => '1',
            ],
            'per' => [
                'type' => 'select',
                'label' => 'Per',
                'default' => 'total',
                'options' => [
                    'total' => 'Total',
                    'hour' => 'Hour',
                    'day' => 'Day',
                    'week' => 'Week',
                    'month' => 'Month',
                ],
            ],
        ];


        public function __construct() {
            if ( is_admin() ) {
                // Register all the hooks.
                add_action( 'transports-extra_add_form_fields', [ $this, 'tm_booking_render_meta_fields' ], 10, 2 );
                add_action( 'transports-extra_edit_form_fields', [ $this, 'tm_booking_edit_meta_fields' ],  10, 2 );
                add_action( 'created_transports-extra', [ $this, 'tm_booking_save_meta_fields' ], 10, 1 );
                add_action( 'edited_transports-extra',  [ $this, 'tm_booking_save_meta_fields' ], 10, 1 );
            }
        }

        public function tm_booking_render_meta_fields( string $taxonomy ) : void {
            $html = '';
            foreach( $this->fields as $field_id => $field ){
                $meta_value = '';
                if ( isset( $field['default'] ) ) {
                    $meta_value = $field['default'];
                }

                $field_html = $this->tm_booking_render_input_field( $field_id, $field, $meta_value );
                $label = "<label for='$field_id'>{$field['label']}</label>";
                $html .= $this->tm_booking_format_field( $label, $field_html );
            }
            echo $html;
        }

        public function tm_booking_edit_meta_fields( WP_Term $term, string $taxonomy ) : void {
            $html = '';
            foreach( $this->fields as $field_id => $field ){
                $meta_value = get_term_meta( $term->term_id, $field_id, true );
                $field_html = $this->tm_booking_render_input_field( $field_id, $field, $meta_value );
                $label = "<label for='$field_id'>{$field['label']}</label>";
                $html .= $this->tm_booking_format_field( $label, $field_html );
            }
            echo $html;
        }

        public function tm_booking_format_field( string $label, string $field ): string {
            return '<tr class="form-field"><th>'.$label.'</th><td>'.$field.'</td></tr>';
        }

        public function tm_booking_render_input_field( string $field_id, array $field, string $field_value): string {
            switch( $field['type'] ) {
                case 'select': {
                    $field_html = '<select name="'.$field_id.'" id="'.$field_id.'">';
                    foreach( $field['options'] as $key => $value ){
                        $key = ! is_numeric( $key ) ? $key : $value;
                        $selected = '';
                        if( $field_value === $key ){
                            $selected = 'selected="selected"';
                        }
                        $field_html .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                    }
                    $field_html .= '</select>';
                    break;
                }
                case 'textarea': {
                    $field_html = '<textarea name="'.$field_id.'" id="'.$field_id.'" rows="6">'.$field_value.'</textarea>';
                    break;
                }
                default: {
                    $field_html = "<input type='{$field['type']}' id='$field_id' name='$field_id' value='$field_value' />";
                    break;
                }
            }

            return $field_html;
        }

        public function tm_booking_save_meta_fields( int $term_id ) : void {
            foreach ( $this->fields as $field_id => $field ) {
                if( isset( $_POST[$field_id] ) ){
                    // Sanitize fields that need to be sanitized.
                    switch( $field['type'] ){
                        case 'email': {
                            $_POST[$field_id] = sanitize_email( $_POST[$field_id] );
                            break;
                        }
                        case 'text': {
                            $_POST[$field_id] = sanitize_text_field( $_POST[$field_id] );
                            break;
                        }
                    }
                    update_term_meta( $term_id, $field_id, $_POST[$field_id] );
                }
            }
        }

    }
    if ( class_exists( 'TM_Booking_Extra' ) ) {
        new TM_Booking_Extra();
    }


    class TM_Booking_Discount {

        private $fields = [
            'discount_percent' => [
                'type' => 'number',
                'label' => 'Discount Percent',
                'default' => '1',
            ],
            'start_day' => [
                'type' => 'number',
                'label' => 'Start Day (number of days from booking start)',
                'default' => '0',
            ],
        ];

        public function __construct() {
            if ( is_admin() ) {
                // Register all the hooks.
                add_action( 'transports-discount_add_form_fields', [ $this, 'tm_booking_render_meta_fields' ], 10, 2 );
                add_action( 'transports-discount_edit_form_fields', [ $this, 'tm_booking_edit_meta_fields' ],  10, 2 );
                add_action( 'created_transports-discount', [ $this, 'tm_booking_save_meta_fields' ], 10, 1 );
                add_action( 'edited_transports-discount',  [ $this, 'tm_booking_save_meta_fields' ], 10, 1 );
            }
        }

        public function tm_booking_render_meta_fields( string $taxonomy ) : void {
            $html = '';
            foreach( $this->fields as $field_id => $field ){
                $meta_value = '';
                if ( isset( $field['default'] ) ) {
                    $meta_value = $field['default'];
                }

                $field_html = $this->tm_booking_render_input_field( $field_id, $field, $meta_value );
                $label = "<label for='$field_id'>{$field['label']}</label>";
                $html .= $this->tm_booking_format_field( $label, $field_html );
            }
            echo $html;
        }

        public function tm_booking_edit_meta_fields( WP_Term $term, string $taxonomy ) : void {
            $html = '';
            foreach( $this->fields as $field_id => $field ){
                $meta_value = get_term_meta( $term->term_id, $field_id, true );
                $field_html = $this->tm_booking_render_input_field( $field_id, $field, $meta_value );
                $label = "<label for='$field_id'>{$field['label']}</label>";
                $html .= $this->tm_booking_format_field( $label, $field_html );
            }
            echo $html;
        }

        public function tm_booking_format_field( string $label, string $field ): string {
            return '<tr class="form-field"><th>'.$label.'</th><td>'.$field.'</td></tr>';
        }

        public function tm_booking_render_input_field( string $field_id, array $field, string $field_value): string {
            switch( $field['type'] ) {
                case 'select': {
                    $field_html = '<select name="'.$field_id.'" id="'.$field_id.'">';
                    foreach( $field['options'] as $key => $value ){
                        $key = ! is_numeric( $key ) ? $key : $value;
                        $selected = '';
                        if( $field_value === $key ){
                            $selected = 'selected="selected"';
                        }
                        $field_html .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                    }
                    $field_html .= '</select>';
                    break;
                }
                case 'textarea': {
                    $field_html = '<textarea name="'.$field_id.'" id="'.$field_id.'" rows="6">'.$field_value.'</textarea>';
                    break;
                }
                default: {
                    $field_html = "<input type='{$field['type']}' id='$field_id' name='$field_id' value='$field_value' />";
                    break;
                }
            }

            return $field_html;
        }

        public function tm_booking_save_meta_fields( int $term_id ) : void {
            foreach ( $this->fields as $field_id => $field ) {
                if( isset( $_POST[$field_id] ) ){
                    // Sanitize fields that need to be sanitized.
                    switch( $field['type'] ){
                        case 'email': {
                            $_POST[$field_id] = sanitize_email( $_POST[$field_id] );
                            break;
                        }
                        case 'text': {
                            $_POST[$field_id] = sanitize_text_field( $_POST[$field_id] );
                            break;
                        }
                    }
                    update_term_meta( $term_id, $field_id, $_POST[$field_id] );
                }
            }
        }

    }
    if ( class_exists( 'TM_Booking_Discount' ) ) {
        new TM_Booking_Discount();
    }


    class TM_Booking_Delivery {

        private $fields = [
            'free' => [
                'type' => 'select',
                'label' => 'Free/Price',
                'default' => 'free',
                'options' => [
                    'free',
                    'price',
                ],
            ],
            'drop_price' => [
                'type' => 'number',
                'label' => 'Drop Price',
                'default' => '1',
            ],
        ];

        public function __construct() {
            if ( is_admin() ) {
                // Register all the hooks.
                add_action( 'transports-delivery_add_form_fields', [ $this, 'tm_booking_render_meta_fields' ], 10, 2 );
                add_action( 'transports-delivery_edit_form_fields', [ $this, 'tm_booking_edit_meta_fields' ],  10, 2 );
                add_action( 'created_transports-delivery', [ $this, 'tm_booking_save_meta_fields' ], 10, 1 );
                add_action( 'edited_transports-delivery',  [ $this, 'tm_booking_save_meta_fields' ], 10, 1 );
            }
        }

        public function tm_booking_render_meta_fields( string $taxonomy ) : void {
            $html = '';
            foreach( $this->fields as $field_id => $field ){
                $meta_value = '';
                if ( isset( $field['default'] ) ) {
                    $meta_value = $field['default'];
                }

                $field_html = $this->tm_booking_render_input_field( $field_id, $field, $meta_value );
                $label = "<label for='$field_id'>{$field['label']}</label>";
                $html .= $this->tm_booking_format_field( $label, $field_html );
            }
            echo $html;
        }

        public function tm_booking_edit_meta_fields( WP_Term $term, string $taxonomy ) : void {
            $html = '';
            foreach( $this->fields as $field_id => $field ){
                $meta_value = get_term_meta( $term->term_id, $field_id, true );
                $field_html = $this->tm_booking_render_input_field( $field_id, $field, $meta_value );
                $label = "<label for='$field_id'>{$field['label']}</label>";
                $html .= $this->tm_booking_format_field( $label, $field_html );
            }
            echo $html;
        }


        public function tm_booking_format_field( string $label, string $field ): string {
            return '<tr class="form-field"><th>'.$label.'</th><td>'.$field.'</td></tr>';
        }

        public function tm_booking_render_input_field( string $field_id, array $field, string $field_value): string {
            switch( $field['type'] ) {
                case 'select': {
                    $field_html = '<select name="'.$field_id.'" id="'.$field_id.'">';
                    foreach( $field['options'] as $key => $value ){
                        $key = ! is_numeric( $key ) ? $key : $value;
                        $selected = '';
                        if( $field_value === $key ){
                            $selected = 'selected="selected"';
                        }
                        $field_html .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                    }
                    $field_html .= '</select>';
                    break;
                }
                case 'textarea': {
                    $field_html = '<textarea name="'.$field_id.'" id="'.$field_id.'" rows="6">'.$field_value.'</textarea>';
                    break;
                }
                default: {
                    $field_html = "<input type='{$field['type']}' id='$field_id' name='$field_id' value='$field_value' />";
                    break;
                }
            }

            return $field_html;
        }


        public function tm_booking_save_meta_fields( int $term_id ) : void {
            foreach ( $this->fields as $field_id => $field ) {
                if( isset( $_POST[$field_id] ) ){
                    // Sanitize fields that need to be sanitized.
                    switch( $field['type'] ){
                        case 'email': {
                            $_POST[$field_id] = sanitize_email( $_POST[$field_id] );
                            break;
                        }
                        case 'text': {
                            $_POST[$field_id] = sanitize_text_field( $_POST[$field_id] );
                            break;
                        }
                    }
                    update_term_meta( $term_id, $field_id, $_POST[$field_id] );
                }
            }
        }

    }
    if ( class_exists( 'TM_Booking_Delivery' ) ) {
        new TM_Booking_Delivery();
    }

}