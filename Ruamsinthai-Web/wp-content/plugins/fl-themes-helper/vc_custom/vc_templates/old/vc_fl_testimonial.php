<?php
/*
 * Shortcode testimonial Parent
 * */
if ( ! function_exists( 'vc_fl_testimonial_function' ) ) {
    function vc_fl_testimonial_function($atts, $content = null)
    {
        global $fl_helping_responsive_style;

        $atts = vc_map_get_attributes('vc_fl_testimonial', $atts);
        $css_classes[] = 'fl-testimonial-slider-wrapper text-center cf';
        $slider_css_classes[] = 'fl-testimonial-slider';
        extract($atts);

        $result=$wrapper_attributes[]=$slider_wrapper_attributes[]=$responsive_style=$css=$mr_dots=$css=$content_wrapper_attributes[]='';

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
                $responsive_id = uniqid('fl-helping-testimonial-responsive-').'-'.rand(100,9999);
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

        // HTML
        if(isset($testimonial_style) && $testimonial_style != '') {
            $css_classes[] = $testimonial_style;
        }


        $vc_init = uniqid('fl_testimonial-slider').'-'.rand(100,9999);
        $css_classes[] = $vc_init;

        $slider_css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $slider_css_classes ) ) ) );

        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

        // Start
        $result .= '<div class="' . esc_attr( trim( $css_class ) ) . ' " '. implode( ' ', $wrapper_attributes ).'>';

            $result .='<div class="' . esc_attr( trim( $slider_css_class ) ) . '" '. implode( ' ', $slider_wrapper_attributes ).'>';
            if(isset($list_fields) && !empty($list_fields) && function_exists('vc_param_group_parse_atts')) {

                $list_fields = (array) vc_param_group_parse_atts($list_fields);
                    foreach($list_fields as $fields2) {
                        $result .= '<div class="fl-quote-content">';
                            // Right content
                            $result .= '<div class="fl-quote-image-content">';
                                $result .= '<a class="thumb">';
                                    if(isset($fields2['image_id']) && !empty($fields2['image_id'])) {
                                        $image = wp_get_attachment_image_src($fields2['image_id'], 'trendsetter_size_90x90_crop');
                                        $result .= '<img src="'.esc_url($image[0]).'"/>';
                                    }
                                $result .= '</a>';
                            $result .= '</div>';
                            // Left content
                            $result .= '<div class="fl-quote-content">';
                            $result .= '<div class="fl-author-content">';
                                if(isset($fields2['title']) && !empty($fields2['title'])) {
                                    $result .= '<div class="fl-author-name fl-font-style-medium">'.$fields2['title'].'</div>';
                                }
                                if(isset($fields2['profession']) && !empty($fields2['profession'])) {
                                    $result .= '<div class="fl-author-category fl-font-style-regular">'.$fields2['profession'].'</div>';
                                }
                            $result .= '</div>';
                            if(isset($fields2['content']) && !empty($fields2['content'])) {
                                $result .= '<div class="fl-testimonials-content fl-font-style-normal">'.$fields2['content'].'</div>';
                            }
                            $result .= '</div>';

                        $result .= '</div>';
                    }

                }

            $result .= '</div>';
            $result .= '<div class="fl-testimonials-arrows">';

                $result .= '<div class="fl-testimonials-arrow-left">';
                    $result .='<i class="fa fa-angle-left" aria-hidden="true"></i>';
                $result .= '</div>';

                $result .= '<div class="fl-testimonials-arrow-right">';
                    $result .= '<i class="fa fa-angle-right" aria-hidden="true"></i>';
                $result .= '</div>';

            $result .= '</div>';
        // End Start
        $result .= '</div>';


        $result .= '<script>
                     jQuery.noConflict()(function ($) { 
                         var testimonial_slider = $(\'.'.$vc_init.' .fl-testimonial-slider\'); 
                           testimonial_slider.slick({
                               infinite: true,
                               slidesToShow: 1,
                               slidesToScroll: 1, 
                               nextArrow:(\'.'.$vc_init.' .fl-testimonials-arrow-right\'),
                               prevArrow:(\'.'.$vc_init.' .fl-testimonials-arrow-left\'),
                           }); 
                     }); 
                    </script>';

        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }

        return $result;
    }
}
add_shortcode('vc_fl_testimonial', 'vc_fl_testimonial_function');