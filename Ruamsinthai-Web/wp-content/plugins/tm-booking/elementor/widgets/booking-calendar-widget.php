<?php
/**
 * Booking Calendar Widget for Elementor
 * 
 * Виджет календаря бронирования для Elementor с использованием xdsoft datetimepicker
 * Работает независимо от плагина pix-booking
 * 
 * @package TM Booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Класс виджета календаря бронирования для Elementor
 */
class TMB_Booking_Calendar_Widget extends \Elementor\Widget_Base {

    /**
     * Получение имени виджета
     * 
     * @return string Имя виджета
     */
    public function get_name() {
        return 'tmb_booking_calendar';
    }

    /**
     * Получение заголовка виджета
     * 
     * @return string Заголовок виджета
     */
    public function get_title() {
        return esc_html__('Booking Calendar', 'tm-booking');
    }

    /**
     * Получение иконки виджета
     * 
     * @return string Иконка виджета
     */
    public function get_icon() {
        return 'eicon-calendar';
    }

    /**
     * Получение категорий виджета
     * 
     * @return array Категории виджета
     */
    public function get_categories() {
        return ['tm-booking'];
    }

    /**
     * Получение ключевых слов виджета
     * 
     * @return array Ключевые слова виджета
     */
    public function get_keywords() {
        return ['booking', 'calendar', 'date', 'picker', 'time', 'reservation'];
    }

    /**
     * Регистрация стилей и скриптов виджета
     */
    public function get_script_depends() {
        return ['tmb-datetimepicker-js', 'tmb-booking-calendar-js'];
    }

    /**
     * Регистрация стилей виджета
     */
    public function get_style_depends() {
        return ['tmb-datetimepicker-css', 'tmb-booking-calendar-css'];
    }

    /**
     * Регистрация элементов управления виджета
     */
    protected function register_controls() {
        // Секция основных настроек
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Calendar Settings', 'tm-booking'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_time',
            [
                'label' => esc_html__('Show Time Picker', 'tm-booking'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'tm-booking'),
                'label_off' => esc_html__('No', 'tm-booking'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'date_format',
            [
                'label' => esc_html__('Date Format', 'tm-booking'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'j/m/Y H:i',
                'options' => [
                    'j/m/Y H:i' => esc_html__('DD/MM/YYYY HH:MM', 'tm-booking'),
                    'm/j/Y H:i' => esc_html__('MM/DD/YYYY HH:MM', 'tm-booking'),
                    'j/m/Y' => esc_html__('DD/MM/YYYY', 'tm-booking'),
                    'm/j/Y' => esc_html__('MM/DD/YYYY', 'tm-booking'),
                ],
            ]
        );

        $this->add_control(
            'min_date_offset',
            [
                'label' => esc_html__('Minimum Date Offset (days)', 'tm-booking'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0,
                'min' => 0,
                'max' => 365,
                'step' => 1,
            ]
        );

        $this->add_control(
            'work_days',
            [
                'label' => esc_html__('Disabled Days of Week', 'tm-booking'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => [
                    '0' => esc_html__('Sunday', 'tm-booking'),
                    '1' => esc_html__('Monday', 'tm-booking'),
                    '2' => esc_html__('Tuesday', 'tm-booking'),
                    '3' => esc_html__('Wednesday', 'tm-booking'),
                    '4' => esc_html__('Thursday', 'tm-booking'),
                    '5' => esc_html__('Friday', 'tm-booking'),
                    '6' => esc_html__('Saturday', 'tm-booking'),
                ],
            ]
        );

        $this->add_control(
            'work_hours',
            [
                'label' => esc_html__('Available Hours', 'tm-booking'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '9:00,10:00,11:00,12:00,13:00,14:00,15:00,16:00,17:00',
                'placeholder' => esc_html__('9:00,10:00,11:00,12:00,13:00,14:00,15:00,16:00,17:00', 'tm-booking'),
                'description' => esc_html__('Enter available hours separated by commas', 'tm-booking'),
                'condition' => [
                    'show_time' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'start_placeholder',
            [
                'label' => esc_html__('Start Date Placeholder', 'tm-booking'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Select start date', 'tm-booking'),
            ]
        );

        $this->add_control(
            'end_placeholder',
            [
                'label' => esc_html__('End Date Placeholder', 'tm-booking'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Select end date', 'tm-booking'),
            ]
        );

        $this->add_control(
            'auto_end_date',
            [
                'label' => esc_html__('Auto Set End Date', 'tm-booking'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'tm-booking'),
                'label_off' => esc_html__('No', 'tm-booking'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => esc_html__('Automatically set end date to next day after start date is selected', 'tm-booking'),
            ]
        );

        $this->add_control(
            'form_id',
            [
                'label' => esc_html__('Form ID', 'tm-booking'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'tmb-booking-form',
                'description' => esc_html__('ID for the booking form', 'tm-booking'),
            ]
        );

        $this->end_controls_section();

        // Секция стилей
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Calendar Style', 'tm-booking'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'calendar_width',
            [
                'label' => esc_html__('Calendar Width', 'tm-booking'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1000,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmb-booking-calendar-wrapper' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'input_padding',
            [
                'label' => esc_html__('Input Padding', 'tm-booking'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tmb-date-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 10,
                    'right' => 15,
                    'bottom' => 10,
                    'left' => 15,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        $this->add_control(
            'input_border_radius',
            [
                'label' => esc_html__('Border Radius', 'tm-booking'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tmb-date-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 4,
                    'right' => 4,
                    'bottom' => 4,
                    'left' => 4,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'input_typography',
                'selector' => '{{WRAPPER}} .tmb-date-input',
            ]
        );

        $this->add_control(
            'input_background_color',
            [
                'label' => esc_html__('Input Background Color', 'tm-booking'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tmb-date-input' => 'background-color: {{VALUE}};',
                ],
                'default' => '#ffffff',
            ]
        );

        $this->add_control(
            'input_text_color',
            [
                'label' => esc_html__('Input Text Color', 'tm-booking'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tmb-date-input' => 'color: {{VALUE}};',
                ],
                'default' => '#333333',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Рендер виджета
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Получаем настройки
        $show_time = $settings['show_time'] === 'yes';
        $date_format = $settings['date_format'];
        $min_date_offset = intval($settings['min_date_offset']);
        $work_days = !empty($settings['work_days']) ? implode(',', $settings['work_days']) : '';
        $work_hours = $settings['work_hours'];
        $start_placeholder = $settings['start_placeholder'];
        $end_placeholder = $settings['end_placeholder'];
        $auto_end_date = $settings['auto_end_date'] === 'yes';
        $form_id = $settings['form_id'];
        
        // Генерируем уникальный ID для календаря
        $calendar_id = 'tmb-calendar-' . uniqid();
        
        // Получаем локаль
        $locale = substr(get_locale(), 0, 2);
        
        // Выводим HTML
        ?>
        <div class="tmb-booking-calendar-wrapper" data-calendar-id="<?php echo esc_attr($calendar_id); ?>">
            <form id="<?php echo esc_attr($form_id); ?>" class="tmb-booking-form">
                <div class="tmb-booking-calendar-fields">
                    <div class="tmb-booking-field tmb-start-date-field">
                        <label for="<?php echo esc_attr($calendar_id); ?>-start"><?php esc_html_e('Start Date', 'tm-booking'); ?></label>
                        <input 
                            type="text" 
                            id="<?php echo esc_attr($calendar_id); ?>-start" 
                            name="tmb_start_date" 
                            class="tmb-date-input tmb-start-date" 
                            placeholder="<?php echo esc_attr($start_placeholder); ?>" 
                            data-min-date="<?php echo esc_attr($min_date_offset); ?>" 
                            data-work-days="<?php echo esc_attr($work_days); ?>" 
                            data-work-hours="<?php echo esc_attr($work_hours); ?>" 
                            data-format="<?php echo esc_attr($date_format); ?>" 
                            data-show-time="<?php echo esc_attr($show_time ? '1' : '0'); ?>" 
                            data-auto-end="<?php echo esc_attr($auto_end_date ? '1' : '0'); ?>" 
                            autocomplete="off" 
                            readonly
                        >
                    </div>
                    <div class="tmb-booking-field tmb-end-date-field">
                        <label for="<?php echo esc_attr($calendar_id); ?>-end"><?php esc_html_e('End Date', 'tm-booking'); ?></label>
                        <input 
                            type="text" 
                            id="<?php echo esc_attr($calendar_id); ?>-end" 
                            name="tmb_end_date" 
                            class="tmb-date-input tmb-end-date" 
                            placeholder="<?php echo esc_attr($end_placeholder); ?>" 
                            data-min-date="<?php echo esc_attr($min_date_offset); ?>" 
                            data-work-days="<?php echo esc_attr($work_days); ?>" 
                            data-work-hours="<?php echo esc_attr($work_hours); ?>" 
                            data-format="<?php echo esc_attr($date_format); ?>" 
                            data-show-time="<?php echo esc_attr($show_time ? '1' : '0'); ?>" 
                            autocomplete="off" 
                            readonly
                        >
                    </div>
                </div>
                
                <!-- Скрытые поля для совместимости с разными форматами -->
                <input type="hidden" name="when" id="<?php echo esc_attr($calendar_id); ?>-when" value="">
                <input type="hidden" name="tmb_date_range" id="<?php echo esc_attr($calendar_id); ?>-range" value="">
            </form>
        </div>
        <?php
    }
}
