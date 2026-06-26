<?php
    if ( ! function_exists( 'vc_fl_gallery_filter_function' ) ) {
        function vc_fl_gallery_filter_function($atts, $content = null)
        {

            $css_classes[] = 'fl-gallery_filter-isotope-wrapper';

            global $fl_helping_responsive_style;

            $atts = vc_map_get_attributes('vc_fl_gallery_filter', $atts);

            extract($atts);


            $result=  $css_classes[] = $wrapper_attributes[]  = $responsive_style = $category_class =$category_name=$result_filter='';


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
                    $responsive_id = uniqid('fl--responsive-gallery_filter').'-'.rand(100,9999);
                    $column_selector = $responsive_id;
                    $responsive_style = fl_helping__addons_get_responsive_style($responsive_css, $column_selector);
                    $css_classes[] = $responsive_id;
                }
            }

            // Animation option
            if ( ! empty( $animation ) and ($animation !='none')) {
                $css_classes[]          = 'fl-animated-item-velocity';
                $wrapper_attributes[]   = 'data-animate-type="'.$animation.'"';

                if ( ! empty( $custom_delay ) and ( $custom_delay !='off')) {
                    if ( ! empty( $animation_delay ) and ($animation_delay !='')) {
                        $wrapper_attributes[] = 'data-item-delay="'.$animation_delay.'"';
                    }
                }
            }


            $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );


            $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '. implode( ' ', $wrapper_attributes ).'>';

            // Filter start
                $result .= '<div class="fl-header-filter-gallery-category-wrapper">';
                    $result .= '<ul class="fl-filter-gallery--group">';
                    if ( ! empty( $show_all ) and ( $show_all !='')) {
                        $result .= '<li class="fl-filter--btn fl-font-style-semi-bold active" data-filter="*"><span>' . $show_all . '</span></li>';
                    }

                    if(isset($list_fields) && !empty($list_fields) && function_exists('vc_param_group_parse_atts')) {

                        $list_fields = (array) vc_param_group_parse_atts($list_fields);
                        foreach($list_fields as $gallery_filter_fields) {

                            if(isset($gallery_filter_fields['category_class_list']) && !empty($gallery_filter_fields['category_class_list'])) {
                                $category_class = 'data-filter=.gallery-category-'.$gallery_filter_fields['category_class_list'].'';
                            }

                            if(isset($gallery_filter_fields['category_list']) && !empty($gallery_filter_fields['category_list'])) {
                                $category_name = $gallery_filter_fields['category_list'];
                            }

                            $result.= '<li class="fl-filter--btn fl-font-style-semi-bold" '.$category_class.'><span>'.$category_name.'</span></li>';
                        }
                    }

                    $result .='</ul>';
                $result .='</div>';
            // Filter End



            $result .= '</div>';


            // Responsive CSS Box
            if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
                $fl_helping_responsive_style .= $responsive_style;
            }

            return $result;

        }
    }
    add_shortcode('vc_fl_gallery_filter', 'vc_fl_gallery_filter_function');

