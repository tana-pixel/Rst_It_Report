<?php
/*
 * Shortcode Button
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! function_exists( 'vc_fl_render_fl_btn' ) ) {
    function vc_fl_render_fl_btn($atts, $content = null)
    {

        $css_classes[] = 'fl-button-wrapper-vc';

        $btn_css_classes[] = 'fl-button btn-effect';

        global $fl_helping_responsive_style, $fl_helping_css_style;

        $atts = vc_map_get_attributes('vc_fl_btn', $atts);
        extract($atts);

        //Button sizes
        $result = $wrapper_attributes[] = $responsive_style = $css = '';



        $css_classes[] .= fl_get_css_tab_class($atts);

        if(isset($id) && $id != '') {
            $wrapper_attributes[] = 'id="'.fl_sanitize_class($id).'"';
        }

        if(isset($class) && $class != '') {
            $css_classes[] .= fl_sanitize_class($class);
        }

        $custom_html_class = uniqid('fl-button').'-'.rand(100,9999);

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




        //HTML Class
        if(isset($btn_align) && $btn_align != '') {
            $css_classes[] = $btn_align;
        }
        // Button Size
        if(isset($size) && $size != 'fl-normal-btn') {
            $btn_css_classes[] = $size;
        }
        // Button Style
        if(isset($btn_style) && $btn_style != 'custom-colors') {
            $btn_css_classes[] = $btn_style;
        }


        if(isset($btn_style) && $btn_style == 'custom-colors') {
            // Custom Color Setting
            $btn_css_classes[] = $custom_html_class;
            // Border color
            if ( ! empty( $border_cl ) and ($border_cl !='')) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' { border-color:' . $border_cl . '!important; }';
            }
            // Background color
            if ( ! empty( $background_cl ) and ($background_cl !='')) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' { background-color:' . $background_cl . '!important; }';
            }
            // Color
            if ( ! empty( $text_cl ) and ($text_cl !='')) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' { color:' . $text_cl . '!important; }';
            }
        // Hover Setting
            // Border color
            if ( ! empty( $border_cl_hover ) and ($border_cl_hover !='')) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ':hover { border-color:' . $border_cl_hover . '!important; }';
            }
            // Background color
            if ( ! empty( $background_cl_hover ) and ($background_cl_hover !='')) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ':after { background-color:' . $background_cl_hover . '!important; }';
            }
            // Color
            if ( ! empty( $text_cl_hover ) and ($text_cl_hover !='')) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ':hover { color:' . $text_cl_hover . '!important; }';
            }
        }



        //Btn link
        $tag_link = 'span';$link_atts='';
        if ( fl_check_option($link) && function_exists('vc_build_link')) {
            $link = vc_build_link($link);
            if(isset($link['url']) && $link['url']) {
                $tag_link = 'a';
                $link_atts = ' href="' . esc_attr($link['url']) . '"';

                if(isset($link['title']) && $link['title']) {
                    $link_atts .= ' title="' . esc_attr($link['title']) . '"';
                }
                if(isset($link['target']) && $link['target']) {
                    $link_atts .= ' target="' . esc_attr(trim($link['target'])) . '"';
                }
                if(isset($link['rel']) && $link['rel']) {
                    $link_atts .= ' rel="' . esc_attr(trim($link['rel'])) . '"';
                }
            }
        }


        $btn_css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $btn_css_classes ) ) ) );




        $btn = '<'.$tag_link.' class="' . esc_attr( trim( $btn_css_class ) ) . '" '.$link_atts.'>'.$btn_text.'</'.$tag_link.'>';



        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

        $result .= '<div class="' . esc_attr( trim( $css_class ) ) .' " '. implode( ' ', $wrapper_attributes ).'>';

            $result .= $btn;

        $result .= '</div>';



        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }

        return $result;
    }
}
add_shortcode('vc_fl_btn', 'vc_fl_render_fl_btn');