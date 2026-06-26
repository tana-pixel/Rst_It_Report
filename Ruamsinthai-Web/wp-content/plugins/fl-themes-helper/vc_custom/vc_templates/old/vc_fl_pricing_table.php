<?php
if ( ! function_exists( 'vc_fl_pricing_table_function' ) ) {
    function vc_fl_pricing_table_function($atts, $content = null)
    {
        $css_classes[] = 'fl-pricing--table-wrapper';

        $css_pr_tb [] = '';

        global $fl_helping_responsive_style;

        $atts = vc_map_get_attributes('vc_fl_pricing_table', $atts);

        extract($atts);

        $result = $wrapper_attributes[] = $responsive_style =$pg_prefix = $css=  $icon_class ='';


        // Custom Class
        $css_classes_table[] = 'fl-pricing--table';

        $btn_css_classes[] = 'fl-button btn-effect';


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
                $responsive_id = $idf = uniqid('fl-responsive-pricing-table-').'-'.rand(100,9999);
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
        // Active Pricing

        if(isset($active_pricing) && $active_pricing == 'enable') {
            $css_classes_table[] = 'fl-primary-bg active-pricing';
            $btn_css_classes[] = 'fl-btn-active-pricing';
        }
        if(isset($active_pricing) && $active_pricing != 'enable') {
            $btn_css_classes[] = 'fl-btn-default';
            $icon_class = 'fl-primary-color';
        }

        if(isset($pricing_prefix) && $pricing_prefix != ''){
            $pg_prefix = $pricing_prefix;
        }


        // Custom icon
        $icon ='';
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
            }

            vc_icon_element_fonts_enqueue($icon_type);

            $icon_price = '<i class="'.$icon.' '.$icon_class.'"></i>';
        }

        // Button Link Option
        //Btn link
        $tag_link = 'span';$link_atts=$btn='';
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

        if(isset($btn_text) && $btn_text != '') {
            $btn = '<'.$tag_link.' class="' . esc_attr( trim( $btn_css_class ) ) . '" '.$link_atts.'>'.$btn_text.'</'.$tag_link.'>';
        }






        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

        $css_class_table = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes_table ) ) ) );


        $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '. implode( ' ', $wrapper_attributes ).'>';

        $result .= '<div class="' . esc_attr( trim( $css_class_table ) ) . '">';

        //Title
        if(isset($title) && $title != '') {
            $result .= '<div class="fl-pricing-title fl-font-style-semi-bold">'.$title.'</div>';
        }

        // Pricing
        if(isset($pricing) && $pricing != '') {
            $result .= '<div class="fl-pricing fl-font-style-semi-bold">'.$pg_prefix.$pricing.'</div>';
        }
        // Pricing period
        if(isset($pricing_period) && $pricing_period != '') {
            $result .= '<div class="fl-pricing-period fl-font-style-regular">'.$pricing_period.'</div>';
        }


        // Icon Pricing
        if(isset($icon_price) && $icon_price != '') {
            $result .= '<div class="fl-pricing-icon fl-fifth-color">'.$icon_price.'</div>';
        }

        //Description
        $result .= '<div class="fl-pricing-description">' .  wpb_js_remove_wpautop($content, true) . '</div>';


        // Pricing Button
        if(isset($btn_text) && $btn_text != '') {
            $result .= $btn;
        }

        $result .= '</div>';

        $result .= '</div>';

        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }



        if(isset($css) && $css !='') {

            $result .='<script>'
                . '(function($) {'
                . '$("head").append("<style>'.$css.'</style>");'
                . '})(jQuery);'
                . '</script>';
        }


        return $result;
    }
}
add_shortcode('vc_fl_pricing_table', 'vc_fl_pricing_table_function');