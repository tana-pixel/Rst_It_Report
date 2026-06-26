<?php
if ( ! function_exists( 'vc_fl_testimonial_slider_function' ) ) {
    function vc_fl_testimonial_slider_function($atts, $content = null)
    {
        $css_classes[] = 'fl-vc-testimonial-slider-wrapper';

        global $fl_helping_responsive_style, $fl_helping_css_style;

        $atts = vc_map_get_attributes('vc_fl_testimonial_slider', $atts);

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


        // Custom Color


        if ( ! empty( $custom_color ) && ($custom_color =='on')) {
            $custom_html_class = uniqid('fl-testimonial-slider-').'-'.rand(100,9999);

            $css_classes[] = $custom_html_class;

            if ( ! empty( $content_cl ) && ($content_cl !='')) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .testimonial-slider .fl-testimonial-slide .testimonial-slide-content{ color:' . $content_cl . '!important; }';
            }

            if ( ! empty( $i_cl ) && ($i_cl !='')) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .testimonial-slider .fl-testimonial-slide .bottom-content i{ color:' . $i_cl . '!important; }';
            }

            if ( ! empty( $name_cl ) && ($name_cl !='')) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .testimonial-slider .fl-testimonial-slide .bottom-content .testimonial-name{ color:' . $name_cl . '!important; }';
            }
            if ( ! empty( $profession_cl ) && ($profession_cl !='')) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .testimonial-slider .fl-testimonial-slide .bottom-content .testimonial-profession{ color:' . $profession_cl . '!important; }';
            }
        }



        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );


        $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '.implode( ' ', $wrapper_attributes).'>';

        $result .= '<div class="testimonial-slider">' . do_shortcode($content) . '</div>';

        $result .= '</div>';


        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }

        return $result;
    }
}
add_shortcode('vc_fl_testimonial_slider', 'vc_fl_testimonial_slider_function');