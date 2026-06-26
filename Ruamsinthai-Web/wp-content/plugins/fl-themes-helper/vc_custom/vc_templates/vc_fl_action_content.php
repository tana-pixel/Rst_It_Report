<?php
if ( ! function_exists( 'vc_fl_action_content_function' ) ) {
    function vc_fl_action_content_function($atts, $content = null)
    {

        $css_classes[] = 'fl-action-content-wrapper-vc';

        global $fl_helping_responsive_style, $fl_helping_css_style;

        $atts = vc_map_get_attributes('vc_fl_action_content', $atts);
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

        if ( ! empty( $style ) and  $style !='' ) {
            $css_classes[] = $style;
        }

        //Btn link
        $tag_link = 'span'; $link_atts='';
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




        $img_html='';
        if(isset($action_image) && !empty($action_image)) {

            $img_src = wp_get_attachment_image_src($action_image, 'full');

            $img_html = '<div class="action-image"><img alt="" src="'.esc_attr($img_src[0]).'"/></div>';

        }

        if(isset($bg_image) && !empty($bg_image) or ! empty( $custom_color ) and  $custom_color =='on' ) {

            $css_classes[] = $custom_html_class;

        }


        if(isset($bg_image) && !empty($bg_image)) {

            $img_url = wp_get_attachment_image_url($bg_image, 'full');

            $fl_helping_css_style[] = '.' . $custom_html_class . ' .vc-fl-action-content .inner-content{ background-image: url(' . $img_url . ')!important; }';

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

        } else{

            $css_classes[] ='default-bg';
        }





        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

        $result .= '<div class="' . esc_attr( trim( $css_class ) ) .' " '. implode( ' ', $wrapper_attributes ).'>';

        $result .= '<div class="vc-fl-action-content">';

        $result .= '<div class="inner-content">';

        $result .= '<'.$tag_link.' class="action-btn" '.$link_atts.'></'.$tag_link.'>';

        if ( ! empty( $content ) and ( $content !='')) {
            $result .= '<div class="action-title fl-font-style-bolt">' . wpb_js_remove_wpautop($content, false) . '</div>';
        }

        if ( ! empty( $text_content ) and ( $text_content !='')) {
            $result .= '<div class="action-content">'.$text_content.'</div>';
        }

        $result .= '</div>';

        $result .= $img_html;

        $result .= '</div>';

        $result .= '</div>';



        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }

        return $result;
    }
}
add_shortcode('vc_fl_action_content', 'vc_fl_action_content_function');