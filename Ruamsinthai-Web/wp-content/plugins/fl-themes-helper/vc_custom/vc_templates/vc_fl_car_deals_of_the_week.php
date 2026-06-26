<?php
if ( ! function_exists( 'vc_fl_car_detail_of_the_week_function' ) ) {
    function vc_fl_car_detail_of_the_week_function($atts, $content = null)
    {
        $css_classes[] = 'fl-vc-car-detail-wrapper';

        global $fl_helping_responsive_style;

        $atts = vc_map_get_attributes('vc_fl_car_detail_of_the_week', $atts);

        extract($atts);

        $result = $wrapper_attributes[] = $css_classes[] = $responsive_style = '';

        $vc_init  = uniqid('fl-custom-slider-').'-'.rand(100,9999);

        $css_classes[] = $vc_init;

        $css_classes[] .= fl_get_css_tab_class($atts);

        if(isset($id) && $id != '') {
            $wrapper_attributes[] .= 'id="'.fl_sanitize_class($id).'"';
        }

        if(isset($class) && $class != '') {
            $css_classes[] .= fl_sanitize_class($class);
        }

        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            if( !empty( $responsive_css ) && $responsive_css != '' ) {
                $responsive_id = $idf = uniqid('fl-helping-alert-responsive-').'-'.rand(100,9999);
                $column_selector = $responsive_id;
                $responsive_style = fl_helping__addons_get_responsive_style($responsive_css, $column_selector);
                $css_classes[] .= $responsive_id;
            }
        }

        // Animation option
        if ( ! empty( $animation ) and ($animation !='none')) {
            $css_classes[] = 'fl-animated-item-velocity';
            $wrapper_attributes[] = 'data-animate-type="'.$animation.'"';

            if ( ! empty( $custom_delay ) and ( $custom_delay !='off')) {
                if ( ! empty( $animation_delay ) and ($animation_delay !='')) {
                    $wrapper_attributes[] = 'data-item-delay="'.$animation_delay.'"';
                }
            }
        }
        // Bg Position Option
        if ( ! empty( $desktop_bg_image_position ) and $desktop_bg_image_position !='' ) {
            $css_classes[] = $desktop_bg_image_position;
        }
        // Min Height Option
        if ( ! empty( $desktop_height ) and $desktop_height !='' ) {
            $wrapper_attributes[]   = 'style="min-height:'.$desktop_height.';"';
        }

        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );


        $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '.implode( ' ', $wrapper_attributes).'>';

        $result .= '<div class="car-detail-slider">' . do_shortcode($content) . '</div>';

        $result .= '</div>';

        $result .= '<script>
                     jQuery.noConflict()(function ($) { 
                         var image_slider = $(\'.' . $vc_init . ' .car-detail-slider\');  
                         image_slider.slick({ 
                            dots: true,
                            infinite: true,
                            prevArrow: null,
                            nextArrow: null,
                            speed: 500,
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            draggable: true,
                            autoplay:true,
                            autoplaySpeed: 6000,
                            responsive: [
                                    {
                                      breakpoint: 992,
                                      settings: {
                                        slidesToShow: 1,
                                        slidesToScroll: 1
                                      }
                                    },
                            ] 
                         }); 
                     }); 
                    </script>';

        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }

        return $result;
    }
}
add_shortcode('vc_fl_car_detail_of_the_week', 'vc_fl_car_detail_of_the_week_function');