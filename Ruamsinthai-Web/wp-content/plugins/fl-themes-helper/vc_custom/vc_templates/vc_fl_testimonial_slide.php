<?php
if ( ! function_exists( 'vc_fl_testimonial_slide_function' ) ) {
    function vc_fl_testimonial_slide_function($atts, $content = null)
    {
        $css_classes[] = 'fl-testimonial-slide';

        global $fl_helping_responsive_style;

        $atts = vc_map_get_attributes('vc_fl_testimonial_slide', $atts);

        extract($atts);

        $result = $wrapper_attributes[] = $css_classes[] = $responsive_style = '';



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
                $responsive_id = $idf = uniqid('fl-responsive-work-info-row').'-'.rand(100,9999);
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











        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

        $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '.implode( ' ', $wrapper_attributes).'>';

        $result .= '<div class="slider-inner-content">';

        if ( ! empty( $content ) and ( $content !='')) {
            $result .= '<div class="testimonial-slide-content">' . wpb_js_remove_wpautop($content, false) . '</div>';
        }

        $result .='<div class="bottom-content">';

        $result .='<i class="fl-custom-icon-left-quotes-sign-2"></i>';

        if ( ! empty( $name ) and ( $name !='')) {
            $result .='<div class="testimonial-name fl-font-style-semi-bolt">'.$name.'</div>';
        }

        if ( ! empty( $profession ) and ( $profession !='')) {
            $result .='<div class="testimonial-profession">'.$profession.'</div>';
        }

        $result .='</div>';

        $result .= '</div>';

        $result .= '</div>';


        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }

        return $result;

    }
}
add_shortcode('vc_fl_testimonial_slide', 'vc_fl_testimonial_slide_function');
