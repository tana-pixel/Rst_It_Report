<?php

/*
 * Shortcode Image slider
 * */
if ( ! function_exists( 'vc_fl_image_slider_function' ) ) {
    function vc_fl_image_slider_function($atts, $content = null)
    {

        $css_classes[] = 'fl-slider-wrapper cf';

        $slider_css_classes[] = 'fl--slick-box';

        global $fl_helping_responsive_style;

        $atts = vc_map_get_attributes('vc_fl_images_slider', $atts);

        extract($atts);


        $images_str = $image = $margin_slider = $bg_arrow = $dots_css_classes[] = $slider_css_classes[] = $slider_wrapper_attributes [] ='';

        $result = $wrapper_attributes[] = $css_classes[] = $responsive_style = '';


        $vc_init = uniqid().'-'.rand(100,9999);

        $css_classes[] = $vc_init;


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
                $responsive_id =  uniqid('fl-helping-slider-responsive-').'-'.rand(100,9999);
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





        $array_images = explode(',', $images);

        foreach ($array_images as $attachment_id) {

            $attachment = fl_get_attachment($attachment_id, $images_size);

            if (fl_check_option($attachment)) {

                if(isset($img_style) && $img_style == 'magnific_popup') {
                    $image = '<a href="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment['alt']) . '"><img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment['alt']) . ' " class="fl_slider-img"></a>';
                } else {
                    $image = '<img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment['alt']) . ' " class="fl_slider-img">';
                }

                $images_str .= '<div class="fl-slider-img-div fl_slick_slide">
                                        ' . $image . '
                                </div>';

            }
        }


        $idf_gallery_popup = uniqid('fl-magnific--popup').'-'.rand(100,9999);

        if(isset($img_style) && $img_style == 'magnific_popup') {
            $slider_css_classes[] = 'fl-magic-popup fl-gallery-popup '.$idf_gallery_popup.'';
            $slider_wrapper_attributes [] = 'data-custom-class="'.$idf_gallery_popup.'"';
        }


        $slider_css_classes[] = $margin_slider;



        if(isset($dots_position) && $dots_position != '') {
            $slider_css_classes[] = $dots_position;
        }

        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

        $slider_css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $slider_css_classes ) ) ) );

        $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '.implode( ' ', $wrapper_attributes).'>';

        $result .= '<div class="fl-slider-box">'; 

        $result .= '<div class="' . esc_attr( trim( $slider_css_class ) ) . '" '.implode( ' ', $slider_wrapper_attributes).'>';


        if ( ! empty( $images ) ) {

            $result .= $images_str;

        }


        $result .= '</div>';

            //Slider Arrow
            $result .='<div class="fl-image-slider-arrows-contain">';

                $result .='<div class="fl-image-slider-prev-arrow"><i class="fa fa-angle-left"></i></div>';
                $result .='<div class="fl-image-slider-next-arrow"><i class="fa fa-angle-right"></i></div>';

            $result .='</div>';

        $result .= '</div>';

        $result .= '</div>';

        $result .= '<script>
                     jQuery.noConflict()(function ($) { 
                         var image_slider = $(\'.'.$vc_init.' .fl--slick-box\'); 
                         image_slider.slick({
                                initialSlide: 0,
                    		    autoplay: '.$autoplay.',
                    		    autoplaySpeed: '.$autoplay_speed.',
                    		    speed: '.$slider_speed.',
                    		    infinite: '.$infinite.',
                    		    slidesToShow: 1,
                    		    slidesToScroll: 1,
                    		    arrows: true,
                    		    dots: false,
                                nextArrow:(\'.'.$vc_init.' .fl-image-slider-next-arrow\'),
                                prevArrow:(\'.'.$vc_init.' .fl-image-slider-prev-arrow\'),
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

add_shortcode('vc_fl_images_slider', 'vc_fl_image_slider_function');