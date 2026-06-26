<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'vc_fl_icon_box_function' ) ) {
    function vc_fl_icon_box_function($atts, $content = null)
    {

        $css_classes[] = 'fl-icon-box cf';

        global $fl_helping_responsive_style, $fl_helping_css_style;

        $atts = vc_map_get_attributes('vc_fl_icon_box', $atts);

        extract($atts);

        $result = $wrapper_attributes[] = $responsive_style = $css=$icon='';

        $css_classes[] .= fl_get_css_tab_class($atts);

        if(isset($id) && $id != '') {
            $wrapper_attributes[] = 'id="'.fl_sanitize_class($id).'"';
        }

        if(isset($class) && $class != '') {
            $css_classes[] = fl_sanitize_class($class);
        }

        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            if( !empty( $responsive_css ) && $responsive_css != '' ) {
                $responsive_id = $idf = uniqid('fl-helping-alert-responsive-').'-'.rand(100,9999);
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



// Custom Color Setting
        if ( ! empty( $custom_color ) and ($custom_color !='disable')) {
            $idf = uniqid('fl-custom-icon-').rand(100,9999);
            $css_classes[] .= $idf;
            if (!empty($i_cl) and ($i_cl != '')) {
                $fl_helping_css_style[] = '.' . $idf . ' .fl-icon-box-wrapper .icon-box-icon-wrapper i{color:' . $i_cl . '!important;}';
            }
            if (!empty($tl_cl) and ($tl_cl != '')) {
                $fl_helping_css_style[] = '.' . $idf . ' .fl-icon-box-wrapper .icon-box-title{ color:' . $tl_cl . '!important; }';
            }
            if (!empty($cn_cl) and ($cn_cl != '')) {
                $fl_helping_css_style[] = '.' . $idf . ' .fl-icon-box-wrapper .icon-box-text-content{ color:' . $cn_cl . '!important; }';
            }
        }




        // Icon

        if(isset($icon_type) && $icon_type != '') {

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

        }
        $icon_vc ='<i class="'.$icon.'"></i>';


        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

        $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '. implode( ' ', $wrapper_attributes ).'>';

            $result .= '<div class="fl-icon-box-wrapper">';
                //Icon
                $result .= '<div class="icon-box-icon-wrapper">'.$icon_vc.'</div>';

                $result .='<div class="icon-box-right-content">';
                    // Title
                    if ( ! empty( $title) and ($title !='')) {
                        $result .= '<div class="icon-box-title fl-text-title-style">'.$title.'</div>';
                    }
                    // Text Content
                    if ( ! empty( $content) and ($content !='')) {
                        $result .= '<div class="icon-box-text-content">'.wpb_js_remove_wpautop($content, false).'</div>';
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

add_shortcode('vc_fl_icon_box', 'vc_fl_icon_box_function');
