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
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly





class TMBooking_Price extends Widget_Base {

    public function get_name() {
        return 'tmbooking-price';
    }

    public function get_title() {
        return esc_html__( 'Price', 'tm-booking' );
    }

    public function get_icon() {
        return 'fa fa-location-arrow tm-booking-icon';
    }


    public function get_categories() {
        return array('tm-booking-core-elementor');
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_elementor_places_catalog_general_setting',
            [
                'label' => __( 'General Setting', 'tm-booking' ),
            ]
        );
        $this->add_control(
            'style',
            [
                'label'   => __( 'Style', 'tm-reviews' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'style_one',
                'options' => [
                    'style_one'      =>         esc_attr__('Style One','tm-reviews'),
                    'style_two'      =>         esc_attr__('Style Two','tm-reviews'),
                    'style_three'    =>         esc_attr__('Style Three','tm-reviews'),
                    'style_four'    =>         esc_attr__('Style Four','tm-reviews'),
                ],
            ]
        );


        $this->add_control(
            'bg_color',
            [
                'label' => __( 'Background Color', 'tm-reviews' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(24, 32, 18, 0.95)',
                'selectors' => [
                    '{{WRAPPER}} .auto-price-info .top-info' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .booking_car_info.booking_car_info_style_two .equipment-order' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .booking_car_info.booking_car_info_style_three' => 'background: {{VALUE}}!important;',
                    '{{WRAPPER}} .tm_booking_car_info.booking_car_info.booking_car_info_style_four .details-aside-content-top' => 'background: {{VALUE}}!important;',
                ],
            ]
        );
        $this->add_control(
            'brdr_color',
            [
                'label' => __( 'Border Color', 'tm-reviews' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#efb007',
                'selectors' => [
                    '{{WRAPPER}} .booking_car_info.booking_car_info_style_two .equipment-order' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'style' => array('style_two'),
                ],
            ]
        );
        $this->add_control(
            'bg_color_two',
            [
                'label' => __( 'Background Color for bottom Price', 'tm-reviews' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(24, 32, 18, 0.95)',
                'selectors' => [
                    '{{WRAPPER}} .car_premium_price' => 'background: {{VALUE}};',
                ],
                'condition' => [
                    'style' => array('style_one'),
                ],
            ]
        );
        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'tm-reviews' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .tm_booking_car_info.booking_car_info.booking_car_info_style_one .auto-price-info .top-info .prc' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .auto-price-info .top-info .price-text' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .auto-price-info .top-info' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .booking_car_info.booking_car_info_style_one .auto-price-info ul.car_premium_price li' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .booking_car_info.booking_car_info_style_two .equipment-order__title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .booking_car_info.booking_car_info_style_two .equipment-order__price .current-price' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .booking_car_info.booking_car_info_style_two .equipment-order__price .old-price' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .booking_car_info.booking_car_info_style_two .equipment-order .equipment-item__prices' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .booking_car_info.booking_car_info_style_two .equipment-order .equipment-item__prices ul li' => 'color: {{VALUE}}!important;',
                    '{{WRAPPER}} .booking_car_info.booking_car_info_style_three .details-aside-content-top__price' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .booking_car_info.booking_car_info_style_three .details-aside-content-top__rent-text' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tm_booking_car_info.booking_car_info.booking_car_info_style_four .details-aside-content-top__rent-text' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tm_booking_car_info.booking_car_info.booking_car_info_style_four .details-aside-content-top__price' => 'color: {{VALUE}};',
                ],
            ]
        );



        $this->add_control(
            'font',
            [
                'label' => esc_html__( 'Font Family', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::FONT,
                'default' => "'Open Sans', sans-serif",
                'selectors' => [
                    '{{WRAPPER}}' => 'font-family: {{VALUE}}',
                    '{{WRAPPER}} .tm_booking_car_info.booking_car_info.booking_car_info_style_one .auto-price-info .top-info .prc' => 'font-family: {{VALUE}}',
                ],
            ]
        );
    }

    protected function render() {
        global $args;
        $idsa = rand(100,9999);
        $this->add_render_attribute( 'wrapper_slider', 'class', 'tmbooking-price' );
        $settings = $this->get_settings_for_display();

        echo do_shortcode('[tm_price style="' . $settings['style'] . '"]');


    }
}