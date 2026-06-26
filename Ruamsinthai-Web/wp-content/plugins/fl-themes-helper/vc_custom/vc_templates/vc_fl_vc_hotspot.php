<?php


if ( ! function_exists( 'fl_hotspot_function' ) ) {
    function fl_hotspot_function($atts, $content = null)
    {

        global $fl_helping_responsive_style, $fl_helping_css_style;

        $css_classes[] = 'fl-hotspot-shortcode-wrapper';

        $result = $wrapper_attributes[] = $data_atts = $responsive_style = $css = '';

        $atts = vc_map_get_attributes('fl_hotspot', $atts);

        extract($atts);

        $css_classes[] .= fl_get_css_tab_class($atts);


        $custom_html_class = uniqid('fl-vc-hotspot').'-'.rand(100,9999);

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


        if(isset($custom_color) && $custom_color == 'on') {
            // Custom Color Setting
            $css_classes[] = $custom_html_class;
            // Background color
            if (!empty($marker_background) && ($marker_background != '')) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .HotspotPlugin_Hotspot:before { background-color:' . $marker_background . '!important; }';
            }
            // Background color
            if (!empty($marker_deco_background) && ($marker_deco_background != '')) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .HotspotPlugin_Hotspot:after { background-color:' . $marker_deco_background . '!important; }';
            }
        }

        if(isset($image) && !empty($image)) {



            wp_enqueue_script('trendsetter-hotspot');


            /*Data attributes*/
            if(!empty($hotspot_data)) {
                $data_atts .= ' data-hotspot-content="'.esc_attr($hotspot_data).'" ';
            }


            // Custom Color Setting
            $button_container_css_classes[] = $custom_html_class;
            // Background color
            if ( ! empty( $btn_bg ) && ($btn_bg !='') && ! empty( $btn_hr_animation ) && ($btn_hr_animation !='disable')) {
                $fl_helping_css_style[] = '.' . $custom_html_class . '[data-animation] { background-color:' . $btn_bg . '!important; }';
            }



            $img_src = wp_get_attachment_image_src($image, 'full');


            $img_html = '<img src="'.esc_attr($img_src[0]).'" width="'.esc_attr($img_src[1]).'" height="'.esc_attr($img_src[2]).'" alt=" "  />';

            $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

            $result .= '<div class="' . esc_attr( trim( $css_class ) ) .' " '. implode( ' ', $wrapper_attributes ).'>';
                $result .= '<div class="fl-hotspot-shortcode text-center" '.$data_atts.'>';
                    $result .= '<div class="fl-hotspot-image-cover">';
                        $result .= $img_html;
                    $result .= '</div>';
                $result .= '</div>';
            $result .= '</div>';
        }

        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }

        return $result;
    }
}


add_shortcode('fl_hotspot', 'fl_hotspot_function');






