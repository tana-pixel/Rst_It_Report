<?php
/*
 * Shortcode Partner Row
 * */
if ( ! function_exists( 'vc_fl_work_share_function' ) ) {
    function vc_fl_work_share_function($atts, $content = null)
    {
        $css_classes[] = 'fl-li-work-info cf';

        global $fl_helping_responsive_style;

        $atts = vc_map_get_attributes('vc_fl_work_share', $atts);

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


        // Icon
        $icon_vc =$icon= $result_icon_share ='';
        if(isset($icon_type) && $icon_type != 'none') {
            switch ($icon_type) {
                case 'fontawesome':
                    $icon = $atts['icon_fontawesome'];
                    break;
                case 'openiconic':
                    $icon = $atts['icon_openiconic'];
                    break;
                case 'typicons':
                    $icon = $atts['icon_typicons'];
                    break;
                case 'entypo':
                    $icon = $atts['icon_entypo'];
                    break;
                case 'linecons':
                    $icon = $atts['icon_linecons'];
                    break;
                case 'elusive':
                    $icon = $atts['icon_elusive'];
                    break;
                case 'etline':
                    $icon = $atts['icon_etline'];
                    break;
                case 'iconmoon':
                    $icon = $atts['icon_iconmoon'];
                    break;
                case 'linearicons':
                    $icon = $atts['icon_linearicons'];
                    break;
                case 'flicon':
                    $icon = $atts['icon_flicon'];
                    break;
                case 'iconic':
                    $icon = $atts['icon_iconic'];
                    break;
                case 'flaticon':
                    $icon = $atts['icon_flaticon'];
                    break;
            }

            vc_icon_element_fonts_enqueue($icon_type);

            $icon_vc = '<i class="' . $icon . ' fl-primary-color"></i>';
        }


        $result_icon_share .= fl_share_buttons($tw,$fb,$lk,$pin,$gl,$rd);

        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

        $result .= '<li class="' . esc_attr( trim( $css_class ) ) . '" '.implode( ' ', $wrapper_attributes).'>';

        $result .= '<div class="fl-left-content fl-work-info-title fl-text-title-style fl-fourth-color">' . $icon_vc . $li_title . '</div>';

        $result .= '<div class="fl-right-content fl-work-info-content fl-font-style-light">'.$result_icon_share.'</div>';

        $result .= '</li>';

        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }

        return $result;

    }
}
add_shortcode('vc_fl_work_share', 'vc_fl_work_share_function');
