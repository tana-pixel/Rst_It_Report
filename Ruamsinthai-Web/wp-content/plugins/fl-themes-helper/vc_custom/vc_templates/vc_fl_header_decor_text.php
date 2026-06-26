<?php
if ( ! function_exists( 'vc_header_decor_text_function' ) ) {
    function vc_header_decor_text_function($atts, $content = null)
    {

        $css_classes[] = 'fl-header-decor-text-wrapper-vc';

        global $fl_helping_responsive_style, $fl_helping_css_style;

        $atts = vc_map_get_attributes('vc_header_decor_text', $atts);
        extract($atts);

        //Button sizes
        $result = $wrapper_attributes[] =$button_container_wrapper_attributes[]= $responsive_style = $css = '';



        $css_classes[] .= fl_get_css_tab_class($atts);

        if(isset($id) && $id != '') {
            $wrapper_attributes[] = 'id="'.fl_sanitize_class($id).'"';
        }

        if(isset($class) && $class != '') {
            $css_classes[] .= fl_sanitize_class($class);
        }



        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            if( !empty( $responsive_css ) && $responsive_css != '' ) {
                $responsive_id = $idf = uniqid('fl-helping-responsive-').'-'.rand(100,9999);
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


        if ( ! empty( $btn_hr_animation ) and ($btn_hr_animation !='disable')) {
            $button_container_wrapper_attributes[] = 'data-animation="true"';
        }


        // Custom Color Setting

        if ( ! empty( $custom_color ) and ($custom_color =='enable')) {
            $custom_html_class = uniqid('fl-vc-custom-html').'-'.rand(100,9999);
            $css_classes[] = $custom_html_class;

            // Custom Color Style Two

            if ( ! empty( $text_cl ) and ($text_cl !='')) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .decor-header-text{ color:' . $text_cl . '!important; }';
            }
            if ( ! empty( $decor_cl ) and ($decor_cl !='')) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .decor-header-text:after{ background-color:' . $decor_cl . '!important; }';
            }

        }

        // Style
        if ( ! empty( $text_align ) and ($text_align !='')) {
            $css_classes[] = $text_align;
        }




        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

        $result .= '<div class="' . esc_attr( trim( $css_class ) ) .' " '. implode( ' ', $wrapper_attributes ).'>';

            if ( ! empty( $text_content ) and ($text_content !='')) {
                $result .= '<div class="decor-header-text fl-font-style-semi-bolt">'.$text_content.'</div>';
            }

        $result .= '</div>';



        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }

        return $result;
    }
}
add_shortcode('vc_header_decor_text', 'vc_header_decor_text_function');