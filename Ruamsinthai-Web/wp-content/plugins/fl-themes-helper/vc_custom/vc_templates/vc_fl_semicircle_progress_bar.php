<?php
if ( ! function_exists( 'vc_fl_semicircle_progress_bar_function' ) ) {
    function vc_fl_semicircle_progress_bar_function($atts, $content = null)
    {

        $css_classes[] = 'semi-circle-progress-bar-wrapper-vc';

        global $fl_helping_responsive_style, $fl_helping_css_style;

        $atts = vc_map_get_attributes('vc_fl_semicircle_progress_bar', $atts);
        extract($atts);

        //Button sizes
        $result = $wrapper_attributes[] =$button_container_wrapper_attributes[]= $responsive_style = $css = '';


        $custom_html_class = uniqid('fl-custom-html-').'-'.rand(100,9999);

        $css_classes[] .= $custom_html_class;

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


        // Style
        if ( ! empty( $style ) and $style !='custom-color' ) {
            $css_classes[] = $style;
        }


        // Text Align
        if ( ! empty( $text_align ) and $text_align !='' ) {
            $css_classes[]   = $text_align;
        }

        if(! empty( $suffix ) and  $suffix !='' ) {
            $fl_helping_css_style[] = '.' . $custom_html_class . ' .vc-semi-circle-progress-bar span:after{ content:"' . $suffix. '"; }';

        }
        if(! empty( $prefix ) and  $prefix !='' ) {
            $fl_helping_css_style[] = '.' . $custom_html_class . ' .vc-semi-circle-progress-bar span:before{ content:"' . $prefix. '"; }';

        }

        if(! empty( $style ) and  $style =='custom-color' ) {

            if(! empty( $tack_color ) and  $tack_color !='' ) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .vc-semi-circle-progress-bar .bar{ border-color:' . $tack_color. '; }';
            }

            if(! empty( $tack_progress_color ) and  $tack_progress_color !='' ) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .vc-semi-circle-progress-bar .bar{ border-bottom-color:' . $tack_progress_color. ';border-right-color:' . $tack_progress_color. '; }';
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .vc-semi-circle-progress-bar span{ color:' . $tack_progress_color. ';}';

            }
            if(! empty( $title_color ) and  $title_color !='' ) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .vc-semi-circle-progress-bar .title-text{ color:' . $title_color. ';}';

            }

        }



        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

        $result .= '<div class="' . esc_attr( trim( $css_class ) ) .' " '. implode( ' ', $wrapper_attributes ).'>';

            $result .= '<div class="vc-semi-circle-progress-bar">';

                $result .='<div class="barOverflow">
                                <div class="bar"></div>
                           </div>';

                $result .='<span class="fl-font-style-semi-bolt">'.$progress_value.'</span>';

                $result .= '<div class="title-text fl-font-style-regular-two">'.$title_text.'</div>';

            $result .= '</div>';

        $result .= '</div>';



        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }

        return $result;
    }
}
add_shortcode('vc_fl_semicircle_progress_bar', 'vc_fl_semicircle_progress_bar_function');