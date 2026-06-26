<?php
use Elementor\Control_Media;
use Elementor\Core\Base\Document;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use ElementorPro\Modules\QueryControl\Module as QueryControlModule;
use ElementorPro\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TMBooking_Form extends Widget_Base {

    public function get_name() {
        return 'tmbooking-booking';
    }

    public function get_title() {
        return esc_html__( 'Form', 'tm-booking' );
    }

    public function get_icon() {
        return 'fa fa fa-globe tm-booking-icon';
    }

    public function get_categories() {
        return array('tm-booking-core-elementor');
    }


    protected function register_controls() {
        $this->start_controls_section(
            'section_elementor_places_cities_general_setting',
            [
                'label' => __( 'General Setting', 'tm-booking' ),
            ]
        );

        $this->add_control(
            'style',
            [
                'label'   => __( 'Style', 'tm-booking' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'style_one',
                'options' => [
                    'style_one'      =>         esc_attr__('Style One','tm-booking'),
                    'style_two'      =>         esc_attr__('Style Two','tm-booking'),
                    'style_three'    =>         esc_attr__('Style Three','tm-booking'),
                    'style_four'    =>         esc_attr__('Style Four','tm-booking'),
                    'style_five'    =>         esc_attr__('Style Five','tm-booking'),
                    'style_six'    =>         esc_attr__('Style Six','tm-booking'),
                ],
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'tm-booking' ),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'Enter your title', 'tm-booking' ),
                'default' => 'Rent Sunny Villas Retreat',
                'condition' => [
                    'style' => array('style_six'),
                ],
            ]
        );
        $this->add_control(
            'subtitle',
            [
                'label' => esc_html__( 'Sub-Title', 'tm-booking' ),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'Enter your subtitle', 'tm-booking' ),
                'default' => 'Enter details or ask for help',
                'condition' => [
                    'style' => array('style_six'),
                ],
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => __( 'Background Color', 'tm-booking' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .equipment-booking.equipment-booking-style_one' => 'background-color: {{VALUE}}!important;',
                    '{{WRAPPER}} .equipment-booking.equipment-booking-style_one .rental-item__price-btn .booking_form' => 'background: {{VALUE}}!important;',
                    '{{WRAPPER}} .equipment-booking.equipment-booking-style_two' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .equipment-booking.equipment-booking-style_three' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .equipment-booking.equipment-booking-style_four .details-aside-content__inner' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .tm_equipment-booking.equipment-booking.equipment-booking-style_five .details-aside-content__inner' => 'background: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'btn_color',
            [
                'label' => __( 'Button Background Color', 'tm-booking' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .equipment-booking.equipment-booking-style_one .rental-item__price-btn .booking_form .book_now_btn' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .equipment-booking.equipment-booking-style_two .rental-item__price-btn form.booking_form .book_now_btn, .equipment-booking.equipment-booking-style_two .equipment-item__btn form.booking_form .book_now_btn' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .equipment-booking .rental-item__price-btn form.booking_form .book_now_btn, .equipment-booking .equipment-item__btn form.booking_form .book_now_btn' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .equipment-booking.equipment-booking-style_five .rental-item__price-btn form.booking_form .book_now_btn, .equipment-booking .equipment-item__btn form.booking_form .book_now_btn' => 'background-color: {{VALUE}}!important;',
                ],
            ]
        );
        $this->add_control(
            'btn_color_hv',
            [
                'label' => __( 'Button Background Hover Color', 'tm-booking' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .equipment-booking .rental-item__price-btn form.booking_form .book_now_btn:hover' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .equipment-booking.equipment-booking-style_four .details-aside-content__button::before' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .tm_equipment-booking.equipment-booking.equipment-booking-style_five .details-aside-content__button::before' => 'background: {{VALUE}};',
                ],
            ]
        );




        $this->add_control(
            'text_color',
            [
                'label' => __( 'Button Text Color', 'tm-booking' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .equipment-booking .rental-item__price-btn form.booking_form .book_now_btn' => 'color: {{VALUE}};',
                ],
            ]
        );





        $this->end_controls_section();
    }

    protected function render() {
        global $args;
        $this->add_render_attribute( 'wrapper', 'class', 'tmbooking-booking' );
        $this->add_render_attribute( 'wrapper_slider', 'class', 'tmbooking-booking' );
        $settings = $this->get_settings_for_display();

        echo do_shortcode('[tm_booking style="' . $settings['style'] . '" title="' . $settings['title'] . '" subtitle="' . $settings['subtitle'] . '"]');


    }
}