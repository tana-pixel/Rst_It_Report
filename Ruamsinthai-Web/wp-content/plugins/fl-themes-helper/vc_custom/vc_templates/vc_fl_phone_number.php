<?php
if ( ! function_exists( 'vc_fl_phone_number_function' ) ) {
    function vc_fl_phone_number_function($atts, $content = null)
    {

        $css_classes[] = 'fl-phone-number-wrapper-vc';

        global $fl_helping_responsive_style, $fl_helping_css_style;

        $atts = vc_map_get_attributes('vc_fl_phone_number', $atts);
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

        if ( ! empty( $custom_color ) and ($custom_color =='on')) {
            $custom_html_class = uniqid('fl-vc-phone-number').'-'.rand(100,9999);
            $css_classes[] = $custom_html_class;

            // Custom Color Style One
            if ( ! empty( $style ) and ($style =='phone-style-one')) {
                if ( ! empty( $text_color ) and ($text_color !='')) {
                    $fl_helping_css_style[] = '.' . $custom_html_class . '{ color:' . $text_color . '!important; }';
                }
                if ( ! empty( $phone_color ) and ($phone_color !='')) {
                    $fl_helping_css_style[] = '.' . $custom_html_class . ' .phone-number-link{ color:' . $phone_color . '!important; }';
                }
                if ( ! empty( $phone_bg_color ) and ($phone_bg_color !='')) {
                    $fl_helping_css_style[] = '.' . $custom_html_class . ' .phone-number-link{ background-color:' . $phone_bg_color . '!important; }';
                }
            }
            // Custom Color Style Two
            if ( ! empty( $style ) and ($style =='phone-style-two')) {
                if ( ! empty( $text_color ) and ($text_color !='')) {
                    $fl_helping_css_style[] = '.' . $custom_html_class . ' .phone-text{ color:' . $text_color . '!important; }';
                }
                if ( ! empty( $phone_color ) and ($phone_color !='')) {
                    $fl_helping_css_style[] = '.' . $custom_html_class . ' .phone-style-two-content{ color:' . $phone_color . '!important; }';
                }
                if ( ! empty( $phone_bg_color ) and ($phone_bg_color !='')) {
                    $fl_helping_css_style[] = '.' . $custom_html_class . ' .phone-style-two-content{ background-color:' . $phone_bg_color . '!important; }';
                }
            }

        }

        // Style
        if ( ! empty( $style ) and ($style !='')) {
            $css_classes[] = $style;
        }




        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

        $result .= '<div class="' . esc_attr( trim( $css_class ) ) .' " '. implode( ' ', $wrapper_attributes ).'>';



         if ( ! empty( $style ) and ($style =='phone-style-one')) {
             $result .= '<i class="ic icon-call-end"></i>';

             if ( ! empty( $phone_text ) and ($phone_text !='')) {

                 $result .= '<span class="phone-text">'.$phone_text.'</span>';

             }

             if ( ! empty( $phone_number ) and ($phone_number !='')) {

                 $result .= '<a href="tel:'.str_replace(' ', '',$phone_number).'" class="phone-number-link fl-font-style-semi-bolt">'.$phone_number.'</a>';

             }
         } else {

             if ( ! empty( $phone_text_two ) and ($phone_text_two !='')) {
                 $result .= '<span class="phone-text fl-font-style-regular-two">'.$phone_text_two.'</span>';
             }

             $result .='<div class="phone-style-two-content">';
             if ( ! empty( $phone_suffix_text ) and ($phone_suffix_text !='')){
                 $result .= '<i class="ic icon-call-end"></i><span class="phone-suffix-text">'.$phone_suffix_text.'</span>';
             }
             if ( ! empty( $phone_number_style_two ) and ($phone_number_style_two !='')){
                 $result .='<a class="phone-number-link-two fl-font-style-semi-bolt" href="tel:'.str_replace(' ', '',$phone_number_style_two).'">'.$phone_number_style_two.'</a>';

             }
             $result .='</div>';
          }

        $result .= '</div>';



        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }

        return $result;
    }
}
add_shortcode('vc_fl_phone_number', 'vc_fl_phone_number_function');