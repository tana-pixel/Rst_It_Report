<?php
    if ( ! function_exists( 'vc_fl_gallery_function' ) ) {
        function vc_fl_gallery_function($atts, $content = null)
        {

            $image_size = 'full';

            $idf_gallery_popup = uniqid('fl-magnific--popup').'-'.rand(100,9999);

            $i =0;

            $css_classes[] = 'fl-gallery-wrapper';

            global $fl_helping_responsive_style;

            $atts = vc_map_get_attributes('vc_fl_gallery', $atts);

            extract($atts);


            $result=  $css_classes[] = $wrapper_attributes[] = $gallery_css_classes[]= $gallery_wrapper_attributes[] = $responsive_style ='';


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
                    $responsive_id = uniqid('fl--responsive-gallery').'-'.rand(100,9999);
                    $column_selector = $responsive_id;
                    $responsive_style = fl_helping__addons_get_responsive_style($responsive_css, $column_selector);
                    $css_classes[] = $responsive_id;
                }
            }

            // Animation option
            if ( ! empty( $animation ) and ($animation !='none')) {
                $gallery_css_classes[]              = 'fl-animated-item-velocity';
                $gallery_wrapper_attributes[]       = 'data-animate-type="'.$animation.'"';
                $gallery_wrapper_attributes[]       = 'data-item-for-animated=".gallery-item"';
                if ( ! empty( $custom_delay ) and ( $custom_delay !='off')) {
                    if ( ! empty( $animation_delay ) and ($animation_delay !='')) {
                        $gallery_wrapper_attributes[] = 'data-item-delay="'.$animation_delay.'"';
                    }
                }
            }

            if(! empty( $gallery_style ) and ($gallery_style !='')){
                $gallery_css_classes[] = $gallery_style;
            }

            // Custom Gallery Wrapper attributes
            $gallery_css_classes[]             = 'row no-gutters fl-gallery fl-magic-popup fl-gallery-popup '.$idf_gallery_popup.'';

            $gallery_wrapper_attributes[]      = 'data-custom-class="'.$idf_gallery_popup.'"';




            $gallery_css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $gallery_css_classes ) ) ) );


            $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );


            $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '. implode( ' ', $wrapper_attributes ).'>';


            $result .= '<div class=" ' . esc_attr( trim( $gallery_css_class ) ) . '"  '. implode( ' ', $gallery_wrapper_attributes ).'>';

            // Gallery Item Start

            if(isset($list_fields_gallery) && !empty($list_fields_gallery) && function_exists('vc_param_group_parse_atts')) {

                $list_fields_gallery = (array) vc_param_group_parse_atts($list_fields_gallery);

                foreach($list_fields_gallery as $gallery_fields_item) {
                    $i++;$gallery_item_html_class='';
                        if($i == 9){$i=1;}

                        if ($i == 1 ) {

                           $image_size = 'autlines_size_425x320_crop';

                           $gallery_item_html_class .= 'col-lg-3 col-sm-6';

                        } elseif($i == 2 || $i == 7) {

                            $image_size = 'autlines_size_450x320_crop';

                            $gallery_item_html_class .= 'col-lg-3 col-sm-6';

                        } elseif($i == 3 || $i== 6) {

                            $image_size = 'autlines_size_350x320_crop';

                            $gallery_item_html_class .= 'col-lg-2 col-sm-6';

                        } elseif($i == 4) {

                            $image_size = 'autlines_size_625x320_crop';

                            $gallery_item_html_class .= 'col-lg-4 col-sm-6';

                        } elseif($i == 5) {

                            $image_size = 'autlines_size_600x320_crop';

                            $gallery_item_html_class .= 'col-lg-5 col-sm-6';

                        } elseif($i == 8) {

                            $image_size = 'autlines_size_475x320_crop';

                            $gallery_item_html_class .= 'col-lg-2 col-sm-6';

                        }

                        // Image
                        if (isset($gallery_fields_item['image_id']) && !empty($gallery_fields_item['image_id'])) {

                            $image = wp_get_attachment_image_src($gallery_fields_item['image_id'], $image_size);

                            $result .='<div class="gallery-item '.$gallery_item_html_class.'">';

                            $result .= '<a class="s" href="' . wp_get_attachment_image_url($gallery_fields_item['image_id'], 'full') . '">';

                            $result .= '<img alt="photo" class="img-scale" src="' . esc_url($image[0]) . '"/>';

                            $result .= '</a>';

                            $result .='</div>';

                        }
                    }

                }


            // Gallery Item end

            $result .= '</div>';

            $result .= '</div>';


            // Responsive CSS Box
            if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
                $fl_helping_responsive_style .= $responsive_style;
            }

            return $result;

        }
    }
    add_shortcode('vc_fl_gallery', 'vc_fl_gallery_function');

