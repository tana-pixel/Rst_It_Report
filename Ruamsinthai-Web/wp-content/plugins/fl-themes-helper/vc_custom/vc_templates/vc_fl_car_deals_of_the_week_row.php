<?php
if ( ! function_exists( 'vc_fl_car_detail_of_the_week_row_function' ) ) {
    function vc_fl_car_detail_of_the_week_row_function($atts, $content = null)
    {
        $css_classes[] = 'car-detail-slide';

        global $fl_helping_responsive_style;

        $atts = vc_map_get_attributes('vc_fl_car_detail_of_the_week_row', $atts);

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
                $responsive_id = $idf = uniqid('fl-helping-alert-responsive-').'-'.rand(100,9999);
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

        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );


        $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '.implode( ' ', $wrapper_attributes).'>';

        $result .= '<div class="slider-content">';
        $result .= '<div class="top-slide-content">' . do_shortcode($content) . '</div>';
        $result .= '<div class="bottom-slide-content">';


        $result .= '<div class="top-car-info">';

        if ( ! empty( $title_car ) and ( $title_car !='')) {
            $result .= '<div class="title-car-info fl-font-style-semi-bolt fl-primary-color">'.$title_car.'</div>';
        }
        // Car Info
        $result .= '<div class="price-car-info">';
        // Prefix
        if ( ! empty( $car_price_suffix ) and ( $car_price_suffix !='')) {
            $result .= '<span class="prefix-car-price-info">'.$car_price_suffix.'</span>';
        }
        // Price
        if ( ! empty( $car_price ) and ( $car_price !='')) {
            $result .= '<span class="price--car-price-info fl-font-style-semi-bolt fl-secondary-color">'.$car_price.'</span>';
        }
        $result .= '</div>';
        $result .= '</div>';
        // Car Info End
            // Bottom Car Info
                $result .= '<div class="bottom-car-info">';

                         // Foreach
                        $list_fields = (array) vc_param_group_parse_atts($list_fields);
                        foreach($list_fields as $fields2) {
                            $result .= '<div class="icon-content-info-wrapper">';
                                $result .= '<div class="icon-content-info-inner">';
                                    $result .='<div class="wrap">';
                                        if(isset($fields2['car_icon']) && !empty($fields2['car_icon'])) {
                                            vc_icon_element_fonts_enqueue('flicon');
                                            $result .= '<i class="'.$fields2['car_icon'].'"></i>';
                                        }
                                        if(isset($fields2['title']) && !empty($fields2['title'])) {
                                            $result .= '<div class="icon-title">'.$fields2['title'].'</div>';
                                        }
                                    $result .= '</div>';
                                $result .= '</div>';
                            $result .= '</div>';
                        }

                $result .= '</div>';
            // Bottom Car Info End
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
add_shortcode('vc_fl_car_detail_of_the_week_row', 'vc_fl_car_detail_of_the_week_row_function');