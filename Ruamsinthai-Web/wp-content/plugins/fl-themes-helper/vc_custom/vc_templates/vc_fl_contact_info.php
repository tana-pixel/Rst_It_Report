<?php
if ( ! function_exists( 'vc_fl_contact_info_function' ) ) {
    function vc_fl_contact_info_function($atts, $content = null)
    {

        $css_classes[] = 'fl-contact-info-wrapper-vc';

        global $fl_helping_responsive_style, $fl_helping_css_style;

        $atts = vc_map_get_attributes('vc_fl_contact_info', $atts);
        extract($atts);

        //Button sizes
        $result = $wrapper_attributes[] =$button_container_wrapper_attributes[]= $responsive_style = $css = '';


        $custom_html_class = uniqid('fl-custom-html-').'-'.rand(100,9999);

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




        // Text Align
        if ( ! empty( $text_align ) and $text_align !='' ) {
            $css_classes[]   = $text_align;
        }

        if(! empty( $custom_color ) and  $custom_color =='on' ) {

            if(! empty( $bg_cl ) and  $bg_cl !='' ) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .vc-fl-action-content .inner-content{ background-color:' . $bg_cl. '!important; }';
            }
            if(! empty( $button_cl ) and  $button_cl !='' ) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .vc-fl-action-content .inner-content .action-btn:after{ background-color:' . $button_cl. '; }';
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .vc-fl-action-content .inner-content .action-btn:before{ border-top-color:' . $button_cl. '; border-left-color:' . $button_cl. ';}';

            }
            if(! empty( $title_cl ) and  $title_cl !='' ) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .vc-fl-action-content .inner-content .action-title{ color:' . $title_cl. '!important; }';
            }
            if(! empty( $content_cl ) and  $content_cl !='' ) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .vc-fl-action-content .inner-content .action-content{ color:' . $content_cl. '!important; }';
            }

        }

        if ( ! empty( $style ) and  $style =='phone-style' ) {
            $icon_content = '<i class="fa fa-phone"></i>';
            $link_content = '<a class="phone-number fl-font-style-bolt-two" href="tel:'.str_replace(' ', '',$phone).'">'.$phone.'</a>';
            $text_content = '<span class="phone-info-text">'.$phone_text_content.'</span>';
        } else {
            $icon_content = '<i class="fa fa-envelope"></i>';
            $link_content = '<a class="email-address fl-font-style-bolt-two" href="mailto:'.$email.'">'.$email.'</a>';
            $text_content = '<span class="email-info-text">'.$email_text_content.'</span>';
        }





        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

        $result .= '<div class="' . esc_attr( trim( $css_class ) ) .' " '. implode( ' ', $wrapper_attributes ).'>';

            $result .= $icon_content;

            $result .= $text_content;

            $result .= $link_content;

        $result .= '</div>';



        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }

        return $result;
    }
}
add_shortcode('vc_fl_contact_info', 'vc_fl_contact_info_function');