<?php

/*
 * Shortcode Partner Row
 * */
if ( ! function_exists( 'vc_fl_list_row_function' ) ) {
    function vc_fl_list_row_function($atts, $content = null)
    {

        $css_classes[] = 'fl-list-li';

        global $fl_helping_responsive_style;

        $atts = vc_map_get_attributes('vc_fl_list_row', $atts);

        extract($atts);

        $color_ct = $list_suffix =  $list_suffix = $suffix_cl = '';

        $result = $wrapper_attributes[] = $responsive_style = '';


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
            $css_classes[] = 'fl-animated-item-velocity';
            $wrapper_attributes[] = 'data-animate-type="'.$animation.'"';

            if ( ! empty( $custom_delay ) and ( $custom_delay !='off')) {
                if ( ! empty( $animation_delay ) and ($animation_delay !='')) {
                    $wrapper_attributes[] = 'data-item-delay="'.$animation_delay.'"';
                }
            }
        }








        if(isset($suffix_color) && $suffix_color != '') {
            $suffix_cl = 'color:' . $suffix_color . ';';
        }

        if(isset($list_style) && $list_style == 'list_style_four') {
            if(isset($suffix_color) && $suffix_color != '') {
                $suffix_cl = 'background-color:' . $suffix_color . ';';
            }
        }

        $list_suffix_style = ( $suffix_cl ) ? 'style=' . $suffix_cl . '' : '';

        $content_cl = '';
        if(isset($content_color) && $content_color != '') {
            $content_cl = 'color:' . $content_color . ';';
        }

        $list_content_style = ( $content_cl ) ? 'style=' . $content_cl . '' : '';




        if(isset($list_style) && $list_style != '') {
            $css_classes[] = $list_style;
        }


        $list_suffix  .= '<i class="fa fa-chevron-right" '.$list_suffix_style.'></i>';

        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );


        if(isset($list_content) && $list_content != '') {

            $result .= '<li class="' . esc_attr( trim( $css_class ) ) . '" ' . $list_content_style . ' '.implode( ' ', $wrapper_attributes).'>' . $list_suffix . $list_content . '</li>';

        }

        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }

        return $result;

    }
}
add_shortcode('vc_fl_list_row', 'vc_fl_list_row_function');