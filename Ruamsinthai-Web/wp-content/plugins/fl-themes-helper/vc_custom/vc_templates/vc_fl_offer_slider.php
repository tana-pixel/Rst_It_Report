<?php

if ( ! function_exists( 'vc_fl_offer_slider_function' ) ) {
    function vc_fl_offer_slider_function($atts, $content = null)
    {

        $css_classes[] = 'fl-vc-offer-slider-wrapper';

        global $fl_helping_responsive_style, $fl_helping_css_style;

        $atts = vc_map_get_attributes('vc_fl_offer_slider', $atts);
        extract($atts);

        $vc_init  = uniqid('fl-custom-slider-').'-'.rand(100,9999);

        $css_classes[] = $vc_init;

        //Button sizes
        $result = $wrapper_attributes[] = $responsive_style = '';

        $custom_html_class = uniqid('fl-vc-offer-slider').'-'.rand(100,9999);

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


        // Custom Color Setting
        if ( ! empty( $custom_color ) and $custom_color =='enable' ) {
            $css_classes[] = $custom_html_class;
            if ( ! empty( $primary_cl ) and $primary_cl !='' ) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .vc-offer-slider .offer-slider-slide .offer-slide-inner-content .offer-slider-bottom-content{ background-color:'.$primary_cl.'!important; }';
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .vc-offer-slider .offer-slider-slide .offer-slide-inner-content .offer-slider-top-content i{ color:'.$primary_cl.'!important; }';
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .vc-offer-slider .slick-arrow:after{ background-color:'.$primary_cl.'!important; }';
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .vc-offer-slider .slick-arrow:hover:before{ border-color:'.$primary_cl.'!important; }';
            }
            if ( ! empty( $secondary_cl ) and $secondary_cl !='' ) {
                $fl_helping_css_style[] = '.' . $custom_html_class . ' .vc-offer-slider .offer-slider-slide.slick-current .offer-slider-top-content i{ color:'.$secondary_cl.'!important; }';
             }
        }




        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

        $result .= '<div class="' . esc_attr( trim( $css_class ) ) .' " '. implode( ' ', $wrapper_attributes ).'>';

            $result .='<div class="vc-offer-slider">';
                // Foreach
                $list_fields = (array) vc_param_group_parse_atts($list_fields);
                foreach($list_fields as $fields2) {
                    $result .='<div class="offer-slider-slide">';
                        $result .='<div class="offer-slide-inner-content">';
                            // Top Content
                            $result .='<div class="offer-slider-top-content">';
                                if(isset($fields2['car_icon']) && !empty($fields2['car_icon'])) {
                                    vc_icon_element_fonts_enqueue('flicon');
                                    $result .= '<i class="'.$fields2['car_icon'].'"></i>';
                                }

                                if(isset($fields2['i_title']) && !empty($fields2['i_title'])) {
                                    $result .= '<div class="offer-slider-title fl-font-style-semi-bolt">'.$fields2['i_title'].'</div>';
                                }
                            $result .='</div>';

                            // Bottom Content
                            $result .='<div class="offer-slider-bottom-content">';
                                // Custom Slider Image
                                if(isset($fields2['image_id']) && !empty($fields2['image_id'])) {
                                    $image = wp_get_attachment_image_src($fields2['image_id'], 'full');
                                        $result .= '<div class="offer-slider-image">';
                                            $result .= '<img src="'.esc_url($image[0]).'" alt=" "/>';
                                        $result .='</div>';
                                }
                                if(isset($fields2['text_content']) && !empty($fields2['text_content'])) {
                                    $result .= '<div class="offer-slider-content">'.$fields2['text_content'].'</div>';
                                }
                            $result .='</div>';
                        $result .='</div>';

                    $result .='</div>';
                }
            $result .='</div>';

        $result .= '</div>';


        $result .= '<script>
                     jQuery.noConflict()(function ($) { 
                         var image_slider = $(\'.' . $vc_init . ' .vc-offer-slider\');  
                         image_slider.slick({ 
                                    dots: false,
                                    infinite: true,
                                    arrow: true,
                                    speed: 500,
                                    slidesToShow: 3,
                                    slidesToScroll: 1,
                                    centerMode: true,
                                    draggable: true,
                                    autoplay:true,
                                    autoplaySpeed: 6000,
                                         responsive: [
                                    {
                                      breakpoint: 992,
                                      settings: {
                                        slidesToShow: 2,
                                        slidesToScroll: 1
                                      }
                                    },
                                    {
                                      breakpoint: 700,
                                      settings: {
                                        slidesToShow: 1,
                                        slidesToScroll: 1
                                      }
                                    },
                            ] 
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
add_shortcode('vc_fl_offer_slider', 'vc_fl_offer_slider_function');