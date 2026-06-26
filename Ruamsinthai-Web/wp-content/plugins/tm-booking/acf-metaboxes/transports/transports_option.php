<?php
if(class_exists('ACF')){
    add_action('acf/init', function() {
        $booking_settings = get_option('tm_booking_settings', []);
        $show_calculate_price = array();
        
        // Проверяем, что calc_periods существует и является массивом (Check that calc_periods exists and is an array)
        $calc_periods = isset($booking_settings['calc_periods']) && is_array($booking_settings['calc_periods']) ? $booking_settings['calc_periods'] : [];
        
        if(in_array("calc_hours", $calc_periods)){
            $show_calculate_price['hour'] = __('hour', 'tm-booking');
        }

        if(in_array("calc_days", $calc_periods)){
            $show_calculate_price['day'] = __('day', 'tm-booking');
        }

        if(in_array("calc_weeks", $calc_periods)){
            $show_calculate_price['week'] = __('week', 'tm-booking');
        }

        if(in_array("calc_month", $calc_periods)) {
            $show_calculate_price['month'] = __('month', 'tm-booking');
        }

        acf_add_local_field_group(array(
            'key' => 'group_61c44d514d1fc',
            'title' => __('Booking', 'tm-booking'),
            'fields' => array(
                array(
                    'key' => 'field_61c52352523a91d',
                    'label' => __('Show & Hide Booking form', 'tm-booking'),
                    'name' => 'show_booking_form',
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
                        'show' => __('Show', 'tm-booking'),
                        'hide' => __('Hide', 'tm-booking'),
                    ),
                    'default_value' => 'show',
                    'allow_null' => 0,
                    'multiple' => 0,
                    'ui' => 0,
                    'return_format' => 'value',
                    'ajax' => 0,
                    'placeholder' => '',
                ),
                array(
                    'key' => 'field_61c44d5c8766e',
                    'label' => __('Price', 'tm-booking'),
                    'name' => 'price_section',
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layout' => 'table',
                    'sub_fields' => array(
                        in_array("calc_hours", $calc_periods) ? array(
                            'key' => 'field_61c44d848766f',
                            'label' => __('Price per/hour', 'tm-booking'),
                            'name' => 'price_perhour',
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
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'min' => '',
                            'max' => '',
                            'step' => '',
                        ) : false,
                        in_array("calc_days", $calc_periods) ? array(
                            'key' => 'field_61c44d9787670',
                            'label' => __('Price per/day', 'tm-booking'),
                            'name' => 'price_perday',
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
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'min' => '',
                            'max' => '',
                            'step' => '',
                        ) : false,
                        in_array("calc_weeks", $calc_periods) ? array(
                            'key' => 'field_61c44da187671',
                            'label' => __('Price per/week', 'tm-booking'),
                            'name' => 'price_perweek',
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
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'min' => '',
                            'max' => '',
                            'step' => '',
                        ) : false,
                        in_array("calc_month", $calc_periods) ? array(
                            'key' => 'field_61c44dac87672',
                            'label' => __('Price per/month', 'tm-booking'),
                            'name' => 'price_permonth',
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
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'min' => '',
                            'max' => '',
                            'step' => '',
                        ) : false,
                        array(
                            'key' => 'field_61c44dfbc491d',
                            'label' => __('Show & Calculate Price', 'tm-booking'),
                            'name' => 'show_calculate_price',
                            'type' => 'select',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'choices' => $show_calculate_price,
                            'default_value' => false,
                            'allow_null' => 0,
                            'multiple' => 0,
                            'ui' => 0,
                            'return_format' => 'value',
                            'ajax' => 0,
                            'placeholder' => '',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_61c7462dad149',
                    'label' => __('Other settings', 'tm-booking'),
                    'name' => 'other_settings',
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_61c74644ad14a',
                            'label' => __('Extra Items', 'tm-booking'),
                            'name' => 'extra_items',
                            'type' => 'taxonomy',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'taxonomy' => 'transports-extra',
                            'field_type' => 'checkbox',
                            'add_term' => 0,
                            'save_terms' => 1,
                            'load_terms' => 1,
                            'return_format' => 'object',
                            'multiple' => 0,
                            'allow_null' => 0,
                        ),

                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => tmbooking_get_post_type(),
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
    class booking_car {
        public $config = '{
        "title":"Show & Hide Booking form", 
        "prefix":"show_hide_booking_form_",
        "domain":"booking_car",
        "class_name":"booking_car",
        "post-type":["default_value_from_tm_booking"],
        "context":"normal",
        "priority":"default",
        "fields":[
            {
                "type":"select",
                "label":"Show & Hide Booking form",
                "default":"show",
                "options":"show : Show\r\nhide : Hide",
                "id":"show_booking_form"
            },
            {
                "type":"select",
                "label":"Show & Calculate Price",
                "options":"hour : Hour\r\nday : Day\r\nweek : Week\r\nmonth : Month",
                "id":"price_section_show_calculate_price"
            }
        ]
    }';

        public function __construct() {
            $this->config = json_decode( $this->config, true );
            $this->config['title'] = "Booking";
            $booking_settings = get_option('tm_booking_settings', []);

            $show_calculate_price = array();
            
            // Проверяем, что calc_periods существует и является массивом (Check that calc_periods exists and is an array)
            $calc_periods = isset($booking_settings['calc_periods']) && is_array($booking_settings['calc_periods']) ? $booking_settings['calc_periods'] : [];
            
            if(in_array("calc_hours", $calc_periods)){
                $show_calculate_price['hour'] = 'hour';
                $this->config['fields'][] = array(
                    "type" => "number",
                    "label" => "Price per/hour",
                    "id" =>"price_section_price_perhour"
                );
            }

            if(in_array("calc_days", $calc_periods)){
                $show_calculate_price['day'] = 'day';
                $this->config['fields'][] = array(
                    "type" => "number",
                    "label" => "Price per/day",
                    "id" =>"price_section_price_perday"
                );
            }

            if(in_array("calc_weeks", $calc_periods)){
                $show_calculate_price['week'] = 'week';
                $this->config['fields'][] = array(
                    "type" => "number",
                    "label" => "Price per/week",
                    "id" =>"price_section_price_perweek"
                );
            }

            if(in_array("calc_month", $calc_periods)) {
                $show_calculate_price['month'] = 'month';
                $this->config['fields'][] = array(
                    "type" => "number",
                    "label" => "Price per/month",
                    "id" =>"price_section_price_permonth"
                );
            }

            // Добавляем новое поле для настройки текста кнопки бронирования
            $this->config['fields'][] = array(
                "type" => "text",
                "label" => esc_html__('Book Now Button Text', 'tm-booking'),
                "id" => "price_section_book_now_text",
                "description" => esc_html__('Custom text for the booking button. Leave empty to use default "Book now" text.', 'tm-booking')
            );
            
            // Добавляем новое поле для настройки текста цены
            $this->config['fields'][] = array(
                "type" => "text",
                "label" => esc_html__('Custom Price Text', 'tm-booking'),
                "id" => "price_section_custom_price_text",
                "description" => esc_html__('Custom text to display instead of the price. Leave empty to show the actual price.', 'tm-booking')
            );
            
            // Добавляем новое поле для включения/отключения отображения блока с ценами
            $this->config['fields'][] = array(
                "type" => "select",
                "label" => esc_html__('Show Price List Block', 'tm-booking'),
                "id" => "price_section_show_price_list",
                "options" => array(
                    "show" => esc_html__('Show', 'tm-booking'),
                    "hide" => esc_html__('Hide', 'tm-booking')
                ),
                "default" => "show",
            );
            
            // Добавляем новое поле для минимального количества дней бронирования
            $this->config['fields'][] = array(
                "type" => "number",
                "label" => esc_html__('Minimum Booking Days', 'tm-booking'),
                "id" => "price_section_min_booking_days",
                "description" => esc_html__('Minimum number of days required for booking. Leave empty or set to 0 for no minimum.', 'tm-booking'),
                "default" => "0",
                "min" => "0",
                "step" => "1"
            );
            
            foreach ($this->config['fields'] as $key => $field){
                if($field['id'] === 'show_booking_form'){
                    $this->config['fields'][$key]['options'] = ["show" => "Show", "hide" => "Hide"];
                }
                if($field['id'] === 'price_section_show_calculate_price'){
                    $this->config['fields'][$key]['options'] = $show_calculate_price;
                }
            }



            add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
            add_action( 'save_post', [ $this, 'save_post' ] );
        }

        public function add_meta_boxes() {

            $this->config['post-type'][] = tmbooking_get_post_type();
            foreach ( $this->config['post-type'] as $screen ) {
                add_meta_box(
                    sanitize_title( $this->config['title'] ),
                    $this->config['title'],
                    [ $this, 'add_meta_box_callback' ],
                    $screen,
                    $this->config['context'],
                    $this->config['priority']
                );
            }
        }

        public function save_post( $post_id ) {

            if(isset($this->config['fields']) && is_array($this->config['fields'])){
                foreach ( $this->config['fields'] as $field ) {
                    if(is_array($_POST) && !empty($_POST)){
                        switch ( $field['type'] ) {
                            default:
                                if ( isset( $_POST[ $field['id'] ] ) ) {
                                    $sanitized = sanitize_text_field( $_POST[ $field['id'] ] );
                                    update_post_meta( $post_id, $field['id'], $sanitized );
                                }
                        }
                    }
                }
            }

        }

        public function add_meta_box_callback() {
            $this->fields_table();
        }

        private function fields_table() {
            ?><table class="form-table" role="presentation">
            <tbody><?php
            foreach ( $this->config['fields'] as $field ) {
                ?><tr>
                <th scope="row"><?php $this->label( $field ); ?></th>
                <td><?php $this->field( $field ); ?></td>
                </tr><?php
            }
            ?></tbody>
            </table><?php
        }

        private function label( $field ) {
            switch ( $field['type'] ) {
                default:
                    printf(
                        '<label class="" for="%s">%s</label>',
                        $field['id'], $field['label']
                    );
            }
        }

        private function field( $field ) {
            switch ( $field['type'] ) {
                case 'number':
                    $this->input_minmax( $field );
                    break;
                case 'select':
                    $this->select( $field );
                    break;
                default:
                    $this->input( $field );
            }
        }

        private function input( $field ) {
            printf(
                '<input class="regular-text %s" id="%s" name="%s" %s type="%s" value="%s">',
                isset( $field['class'] ) ? $field['class'] : '',
                $field['id'], $field['id'],
                isset( $field['pattern'] ) ? "pattern='{$field['pattern']}'" : '',
                $field['type'],
                $this->value( $field )
            );
        }

        private function input_minmax( $field ) {
            printf(
                '<input class="regular-text" id="%s" %s %s name="%s" %s type="%s" value="%s">',
                $field['id'],
                isset( $field['max'] ) ? "max='{$field['max']}'" : '',
                isset( $field['min'] ) ? "min='{$field['min']}'" : '',
                $field['id'],
                isset( $field['step'] ) ? "step='{$field['step']}'" : '',
                $field['type'],
                $this->value( $field )
            );
        }

        private function select( $field ) {
            printf(
                '<select id="%s" name="%s">%s</select>',
                $field['id'], $field['id'],
                $this->select_options( $field )
            );
        }

        private function select_selected( $field, $current ) {
            $value = $this->value( $field );
            if ( $value === $current ) {
                return 'selected';
            }
            return '';
        }

        private function select_options( $field ) {
            $output = [];
            $i = 0;
            foreach ( $field['options'] as $key => $option ) {
                $output[] = sprintf(
                    '<option %s value="%s"> %s</option>',
                    $this->select_selected( $field, $key ),
                    $key, $option
                );
                $i++;
            }
            return implode( '<br>', $output );
        }

        private function value( $field ) {
            global $post;
            if ( metadata_exists( 'post', $post->ID, $field['id'] ) ) {
                $value = get_post_meta( $post->ID, $field['id'], true );
            } else if ( isset( $field['default'] ) ) {
                $value = $field['default'];
            } else {
                return '';
            }
            return str_replace( '\u0027', "'", $value );
        }

    }
    new booking_car;
}










