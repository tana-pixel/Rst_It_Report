<?php
/*
 * Shortcode counters
 * */
if ( ! function_exists( 'vc_fl_animated_typing_function' ) ) {
    function vc_fl_animated_typing_function($atts, $content = null)
    {
        // Global
        global $fl_helping_responsive_style, $fl_helping_css_style;
        $idf = uniqid('').'-'.rand(100,9999);

        $result = $css_classes_typing[] =$css_classes_typing_bg[]= $wrapper_attributes[] =$wrapper_attributes_typing[]= $responsive_style = $css='';

        $css_classes []           = 'fl-animated-typing';
        $css_classes[]           .= 'fl-animation-typing-'.$idf;

        $wrapper_attributes[] = 'data-text-class=".fl-animation-typing-'.$idf.' .fl-text-wrapper"';

        $atts = vc_map_get_attributes('vc_fl_animated_typing', $atts);
        extract($atts);

        // Design option css
        $css_classes[] .= fl_get_css_tab_class($atts);
        // Custom ID
        if(isset($id) && $id != '') {
            $wrapper_attributes[] = 'id="'.fl_sanitize_class($id).'"';
        }
        // Custom Css class
        if(isset($class) && $class != '') {
            $css_classes[] = fl_sanitize_class($class);
        }

        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            if( !empty( $responsive_css ) && $responsive_css != '' ) {
                $responsive_id = uniqid('fl-helping-responsive-').'-'.rand(100,9999);
                $column_selector = $responsive_id;
                $responsive_style = fl_helping__addons_get_responsive_style($responsive_css, $column_selector);
                $css_classes[] = $responsive_id;
            }
        }
        // Animation Text
        if ( ! empty( $animation_text ) and ($animation_text !='')) {
            $wrapper_attributes[] = 'data-text="'.$animation_text.'"';
        }

        //

        if ( ! empty( $typing_speed ) and ($typing_speed !='')) {
            $wrapper_attributes[] = 'data-animation-typing-speed="'.$typing_speed.'"';
        }


        //Text Align
        if ( ! empty( $text_align) and ($text_align !='')) {
            $css_classes[] = $text_align;
        }
        if ( ! empty( $text_style) and ($text_style !='')) {
            $css_classes_typing[] = $text_style;
        }





        // Custom Typography
        if(isset($text_font_options) && $text_font_options != ''
            || isset($custom_text_google_fonts) && $custom_text_google_fonts != 'off'
            || isset($text_custom_fonts) && $text_custom_fonts != '' ) {
            $text_options = _fl_parse_text_params($text_font_options,$custom_text_google_fonts, $text_custom_fonts,true,false);
        }
        if(isset($text_options['style']) && $text_options['style'] != '') {

            $wrapper_attributes_typing[] = 'style='.$text_options['style'].'';

        }


        // Custom Style Setting
        if ( ! empty( $custom_style_setting ) and ($custom_style_setting !='off')) {

            if ( ! empty( $background_img ) and ($background_img !='')) {

                $css_classes[] = 'fl-typing-has-bg';

                $attachment = fl_get_attachment($background_img, 'full');

                $fl_helping_css_style[] = '.fl-animation-typing-'.$idf.' .fl-gr-text-bg{background: url('.esc_url($attachment['src']).') 100% 50%; background-size: cover;}';

                if ( ! empty( $text_background_color ) and ($text_background_color !='')) {
                    $fl_helping_css_style[] = '.fl-animation-typing-'.$idf.' .fl-text-wrapper,.fl-animation-typing-'.$idf.' .fl-text-wrapper-save{background:'.$text_background_color.'!important;}';
                }
            }
            if ( ! empty( $text_color ) and ($text_color !='')) {
                $fl_helping_css_style[] = '.fl-animation-typing-'.$idf.' .fl-gr-text-bg{color:'.$text_color.'!important;}';
            }
        }

        // Responsive Title Style Start
        if( isset($custom_responsive_option_title) && $custom_responsive_option_title != 'off' ){
            // Custom Class
            if( isset($title_font_size_responsive) && $title_font_size_responsive != ''
                || isset($title_line_height_responsive) && $title_line_height_responsive != ''
                || isset($title_letter_spacing_responsive) && $title_letter_spacing_responsive != ''){

                $responsive_class_text = uniqid('fl-animated-text-responsive-').'-'.rand(100,9999);

                $css_classes_typing_bg [] = $responsive_class_text;

                $css_classes_typing_bg [] = 'fl-vc--responsive';

                $args = array(
                    'target'      =>  $responsive_class_text ,  // set targeted element e.g. unique class/id etc.
                    'media_sizes' => array(
                        'font-size'         => $title_font_size_responsive,
                        'line-height'       => $title_line_height_responsive,
                        'letter-spacing'    => $title_letter_spacing_responsive,
                    ),
                );

                $data_list = fl_helper_get_responsive_text_media_css($args);

                $wrapper_attributes_typing[] = $data_list;

            }
        }


        $css_class_typing = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes_typing ) ) ) );

        $css_class_typing_bg = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes_typing_bg ) ) ) );

        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );


        $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '. implode( ' ', $wrapper_attributes ).'>';
                $result .= '<span class="fl-gr-text-bg ' . esc_attr( trim( $css_class_typing_bg ) ) . '" '. implode( ' ', $wrapper_attributes_typing ).'>';
                    if ( ! empty( $animation_text) and ($animation_text !='')) {
                        $result .= '<span class="fl-text-wrapper-save ' . esc_attr( trim( $css_class_typing ) ) . '">' . $animation_text . '</span>';
                        $result .= '<span class="fl-text-wrapper ' . esc_attr( trim( $css_class_typing ) ) . '"></span>';
                    }
                $result .= '</span>';
        $result .= '</div>';


        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }

        return $result;

    }
}
add_shortcode('vc_fl_animated_typing', 'vc_fl_animated_typing_function');
