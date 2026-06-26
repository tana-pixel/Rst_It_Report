<?php

if ( ! function_exists( 'vc_fl_number_content_function' ) ) {
    function vc_fl_number_content_function($atts, $content = null)
    {

        $css_classes[] = 'vc-number-content-container';

        global $fl_helping_responsive_style, $fl_helping_css_style;

        $atts = vc_map_get_attributes('vc_fl_number_content', $atts);
        extract($atts);

        //Button sizes
        $result = $wrapper_attributes[] = $responsive_style = '';

        $custom_html_class = uniqid('fl-vc-offer-slider').'-'.rand(100,9999);

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
            $css_classes[]              = 'fl-animated-item-velocity';
            $wrapper_attributes[]       = 'data-animate-type="'.$animation.'"';
            $wrapper_attributes[]       = 'data-item-for-animated=".number-div-content"';

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

        $result .= '<div class="' . esc_attr( trim( $css_class ) ) .' " '. implode( ' ', $wrapper_attributes ).'>';
                // Foreach
                $i = 0;
                $list_fields = (array) vc_param_group_parse_atts($list_fields);
                foreach($list_fields as $fields2) {
                    $i++;
                    if($i % 2 == 0){
                        $html_class = 'col-lg-3 reflect-element';
                    }else{
                        $html_class = 'col-lg-3';
                    }

                    $result .='<div class="number-div-content '.$html_class.'">';

                        $result .='<div class="inner-content">';

                            if(isset($fields2['number']) && !empty($fields2['number'])) {
                                $result .= '<div class="number fl-font-style-bolt">'.$fields2['number'].'</div>';
                            }

                            if(isset($fields2['title']) && !empty($fields2['title'])) {
                                $result .= '<div class="number-title fl-font-style-semi-bolt">'.$fields2['title'].'</div>';
                            }

                            if(isset($fields2['text_content']) && !empty($fields2['text_content'])) {
                                $result .= '<div class="number-content">'.$fields2['text_content'].'</div>';
                            }
                        $result .='</div>';

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
add_shortcode('vc_fl_number_content', 'vc_fl_number_content_function');