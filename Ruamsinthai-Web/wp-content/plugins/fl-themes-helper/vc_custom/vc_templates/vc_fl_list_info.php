<?php
if ( ! function_exists( 'vc_fl_list_info_function' ) ) {
    function vc_fl_list_info_function($atts, $content = null)
    {
        $css_classes[] = 'fl_list_info-wrapper';

        global $fl_helping_responsive_style;

        $atts = vc_map_get_attributes('vc_fl_list_info', $atts);

        extract($atts);

        $result = $wrapper_attributes[] = $css_classes[] =  '';

        $css_classes[] = fl_get_css_tab_class($atts);

        if(isset($id) && $id != '') {
            $wrapper_attributes[] = 'id="'.fl_sanitize_class($id).'"';
        }

        if(isset($class) && $class != '') {
            $css_classes[] = fl_sanitize_class($class);
        }

        $custom_class_text = uniqid('fl-custom-text-').'-'.rand(100,9999);

        $css_classes [] = $custom_class_text;

        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            if( !empty( $responsive_css ) && $responsive_css != '' ) {
                $responsive_id = $idf = uniqid('fl-helping-responsive-').'-'.rand(100,9999);
                $column_selector = $responsive_id;
                $responsive_style = fl_helping__addons_get_responsive_style($responsive_css, $column_selector);
                $css_classes[] = $responsive_id;
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

        $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '. implode( ' ', $wrapper_attributes ).'>';

        $result .= '<div class="list-info-content">';

        // Left Content

        $result .= '<div class="left-content-number">';

        if ( ! empty( $number_text ) and ( $number_text !='')) {

            $result .= '<div class="list-number fl-font-style-semi-bold fl-primary-color">';

            $result .= $number_text;

            $result .= '</div>';

        }

        $result .= '</div>';

        // Right Content

        $result .= '<div class="right-content">';

        if ( ! empty( $title_text ) and ( $title_text !='')) {

            $result .= '<div class="title-content fl-font-style-semi-bold">';

                $result .= $title_text;

            $result .= '</div>';

        }

        if ( ! empty( $content ) and ( $content !='')) {

            $result .= '<div class="content-wrapper">';

            $result .= wpb_js_remove_wpautop($content, true);

            $result .= '</div>';

        }

        $result .= '</div>';

        $result .= '</div>';

        $result .= '</div>';

        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }

        return $result;
    }
}


add_shortcode('vc_fl_list_info', 'vc_fl_list_info_function');

