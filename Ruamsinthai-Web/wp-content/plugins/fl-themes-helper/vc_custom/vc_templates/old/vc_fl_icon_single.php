<?php
if ( ! function_exists( 'vc_fl_icon_single_function' ) ) {
    function vc_fl_icon_single_function($atts, $content = null)
    {

        $css_classes[] = 'fl-icon-single';

        global $fl_helping_responsive_style;

        $atts = vc_map_get_attributes('vc_fl_icon_single', $atts);

        extract($atts);


        $idf_class = uniqid('fl--single-icon').'-'.rand(100,9999);

        $icon_cl = $icon_fz = $icon_bg = $icon_br_cl = $vc_icon_single_output = $size_icon =  $css =  $custom_id =  '';


        $result = $wrapper_attributes[] = $css_classes[] = $responsive_style = '';

        $css_classes[] = fl_get_css_tab_class($atts);

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
            $css_classes[] = 'wow '.$animation;

            if ( ! empty( $custom_delay ) and ( $custom_delay !='off')) {
                if ( ! empty( $animation_delay ) and ($animation_delay !='')) {
                    $wrapper_attributes[] = 'data-wow-delay="'.$animation_delay.'ms"';
                }
            }
        }

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
        }

        vc_icon_element_fonts_enqueue($icon_type);






        if(isset($i_cl) && $i_cl != '') {
            $icon_cl = 'color:' . $i_cl . ';';
        }
        if(isset($i_bg) && $i_bg != '') {
            $icon_bg = 'background:' . $i_bg . ';';
        }
        if(isset($i_br_cl) && $i_br_cl != '') {
            $icon_br_cl = 'border-color:' . $i_br_cl . ';';
        }
        if(isset($icon_style) && $icon_style != 'default') {
            $size_icon = $icon_size;
            $css_classes [] = $size_icon;
        }
        if(isset($icon_style) && $icon_style == 'default') {
            if (isset($i_fz) && $i_fz != '') {
                $icon_fz = 'font-size:' . $i_fz . 'px;line-height:' . $i_fz . 'px;';
            }
        }


        $icon_single_style_css = ($icon_cl || $icon_bg || $icon_br_cl || $icon_fz) ? 'style=' . esc_attr($icon_br_cl) . esc_attr($icon_bg) . esc_attr($icon_cl) . esc_attr($icon_fz ) . '' : '';

        if(isset($icon) && $icon != '') {

            $vc_icon_single_output .= '<i class="fl-single-icon ' . $icon . '" ' . $icon_single_style_css . '></i>';

        }



        if(isset($i_hv_bg) && $i_hv_bg != '') {
            $css .= '.'.$idf_class.':hover  i { background:' . $i_hv_bg . '!important;}';
        }
        if(isset($i_hv_cl) && $i_hv_cl != '') {
            $css .= '.'.$idf_class.':hover i {color:' . $i_hv_cl . '!important;}';
        }


        $css_classes [] = $idf_class;

        if(isset($icon_style) && $icon_style != 'default') {
            $css_classes [] = $icon_style;
        }
        if(isset($size_icon) && $size_icon != '') {
            $css_classes [] = $size_icon;
        }
        if(isset($icon_border) && $icon_border != '') {
            $css_classes [] = $icon_border;
        }

        if(isset($full_width) && $full_width == 'full_width') {
            $css_classes [] = $full_width;
        }


        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

        $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '.implode( ' ', $wrapper_attributes ).'>';

        if(isset($full_width) && $full_width == 'full_width') {

            $result .= '<div class="fl-icon-single-full-width ' . $icon_position . '">';

            $result .= $vc_icon_single_output;

            $result .= '</div>';

        }

        if(isset($full_width) && $full_width != 'full_width') {

            $result .= $vc_icon_single_output;

        }

        $result .= '</div>';


        if(isset($css) && $css !='') {

            $result .='<script>'
                        . '(function($) {'
                        . '$("head").append("<style>'.$css.'</style>");'
                        . '})(jQuery);'
                    . '</script>';
        }

        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }

        return $result;

    }
}
add_shortcode('vc_fl_icon_single', 'vc_fl_icon_single_function');