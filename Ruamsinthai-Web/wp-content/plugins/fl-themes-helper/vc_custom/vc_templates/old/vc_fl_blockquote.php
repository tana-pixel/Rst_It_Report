<?php
if ( ! function_exists( 'vc_fl_blockquote_function' ) ) {
    function vc_fl_blockquote_function($atts, $content = null)
    {

        $css_classes[] = 'fl--vc-blockquote-wrapper';

        global $fl_helping_responsive_style;

        $atts = vc_map_get_attributes('vc_fl_blockquote', $atts);
        extract($atts);



        $result = $wrapper_attributes[] = $responsive_style = $css = $vc_icon =  '';

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
                $responsive_id = uniqid('fl-helping-responsive-').'-'.rand(100,9999);
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

        //Icon
        switch ($icon_type) {
            case 'flquote':
                $icon = $atts['icon_flquote'];
                break;
        }

        vc_icon_element_fonts_enqueue($icon_type);


        if(isset($icon_type) && $icon_type == 'flquote') {
            $vc_icon = '<i class="fl-testimonial-icon  ' . $icon . ' fl-primary-color"></i>';
        }

        if(isset($icon_type) && $icon_type == 'default') {
            $vc_icon = '<i class="dashicons dashicons-format-quote fl-primary-color"></i>';
        }


        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

        $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '. implode( ' ', $wrapper_attributes ).'>';


           $result .= '<div class="fl-quote-icon">'.$vc_icon.'</div>';

            $result .= '<div class="fl-quote-title fl-font-style-semi-bold fl-third-color">'.$title_text.'</div>';

            $result .= '<div class="fl-quote-text fl-font-style-regular fl-secondary-color-back">'.$quote_text.'</div>';

            $result .= '<div class="fl-quote-author-container fl--font-style-three">
                            <span class="fl-quote-author fl-font-style-semi-bold fl-primary-color">'.$author.'</span>
                            <span class="fl-quote-profession fl-font-style-normal fl-third-color">'.$profession.'</span>
                       </div>';


        $result .= '</div>';



        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }

        return $result;
    }
}
add_shortcode('vc_fl_blockquote', 'vc_fl_blockquote_function');