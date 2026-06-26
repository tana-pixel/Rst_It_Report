<?php

    if ( ! function_exists( 'vc_fl_team_slider_function' ) ) {
        function vc_fl_team_slider_function($atts, $content = null)
        {
            $css_classes[] = 'fl-team-slider-content-vc';

            $slider_css_classes[] = 'fl-team-slider';

            global $fl_helping_responsive_style, $fl_helping_css_style;

            $atts = vc_map_get_attributes('vc_fl_team_slider', $atts);

            extract($atts);

            $result = $wrapper_attributes[] = $css_classes[] = $responsive_style = '';


            $css_classes[] .= fl_get_css_tab_class($atts);

            // Custom HTML Class
            $vc_init = uniqid('fl-team-slider-').'-'.rand(100,9999);
            $css_classes[] = $vc_init;

            if(isset($id) && $id != '') {
                $wrapper_attributes[] .= 'id="'.fl_sanitize_class($id).'"';
            }

            if(isset($class) && $class != '') {
                $css_classes[] .= fl_sanitize_class($class);
            }

            // Responsive CSS Box
            if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
                if( !empty( $responsive_css ) && $responsive_css != '' ) {
                    $responsive_id = uniqid('fl-helping-alert-responsive-').'-'.rand(100,9999);
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
                 if ( ! empty( $name_cl ) and $name_cl !='' ) {
                     $fl_helping_css_style[] = '.' . $vc_init . ' .fl-team-slider .team-slider-name{ color:' . $name_cl. ';}';
                 }
                 if ( ! empty( $profession_cl ) and $profession_cl !='' ) {
                     $fl_helping_css_style[] = '.' . $vc_init . ' .fl-team-slider .team-slider-profession{ color:' . $profession_cl. ';}';
                 }
                 if ( ! empty( $soc_i_cl ) and $soc_i_cl !='' ) {
                     $fl_helping_css_style[] = '.' . $vc_init . ' .fl-team-slider .team-social li a i{ color:' . $soc_i_cl. ';}';
                 }


                 // Dots
                 if ( ! empty( $dots_cl ) and $dots_cl !='' ) {
                     $fl_helping_css_style[] = '.' . $vc_init . ' .fl-team-slider .slick-dots li button:before{ background-color:' . $dots_cl. ';}';
                 }
                 if ( ! empty( $dots_active_cl ) and $dots_active_cl !='' ) {
                     $fl_helping_css_style[] = '.' . $vc_init . ' .fl-team-slider .slick-dots li button:hover:before,.'.$vc_init.' .fl-team-slider .slick-dots li.slick-active button:before{ background-color:' . $dots_active_cl. ';}';
                 }
             }

            $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

            $slider_css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $slider_css_classes ) ) ) );

            $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '.implode( ' ', $wrapper_attributes).'>';

                $result .= '<div class="' . esc_attr( trim( $slider_css_class ) ) . '">';

                    // Foreach
                    $list_fields = (array) vc_param_group_parse_atts($list_fields);
                    foreach($list_fields as $fields2) {
                        $result .='<div class="team-slider-slide">';

                            $result .= '<div class="slider-entry-content">';

                                if(isset($fields2['image_id']) && !empty($fields2['image_id'])) {
                                    $image = wp_get_attachment_image_src($fields2['image_id'], 'full');
                                    $result .= '<div class="team-slider-image">';
                                    $result .= '<img src="'.esc_url($image[0]).'" alt=" "/>';
                                    $result .='</div>';
                                }

                                if(isset($fields2['name']) && !empty($fields2['name'])) {
                                    $result .= '<div class="team-slider-name fl-font-style-bolt">'.$fields2['name'].'</div>';
                                }

                                if(isset($fields2['profession']) && !empty($fields2['profession'])) {
                                    $result .= '<div class="team-slider-profession fl-font-style-regular-two">'.$fields2['profession'].'</div>';
                                }

                                $result .='<ul class="team-social">';
                                    if(isset($fields2['tw']) && !empty($fields2['tw'])) {
                                        $result .= '<li class="team-slider-social"><a href="'.$fields2['tw'].'"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>';
                                    }
                                    if(isset($fields2['bh']) && !empty($fields2['bh'])) {
                                        $result .= '<li class="team-slider-social"><a href="'.$fields2['bh'].'"><i class="fa fa-behance" aria-hidden="true"></i></a></li>';
                                    }
                                    if(isset($fields2['fb']) && !empty($fields2['fb'])) {
                                        $result .= '<li class="team-slider-social"><a href="'.$fields2['fb'].'"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>';
                                    }
                                    if(isset($fields2['in']) && !empty($fields2['in'])) {
                                        $result .= '<li class="team-slider-social"><a href="'.$fields2['in'].'"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>';
                                    }
                                    if(isset($fields2['gl']) && !empty($fields2['gl'])) {
                                        $result .= '<li class="team-slider-social"><a href="'.$fields2['gl'].'"><i class="fa fa-google" aria-hidden="true"></i></a></li>';
                                    }
                                    if(isset($fields2['yt']) && !empty($fields2['yt'])) {
                                        $result .= '<li class="team-slider-social"><a href="'.$fields2['yt'].'"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>';
                                    }
                                $result .='</ul>';

                            $result .='</div>';
                        $result .='</div>';
                    }

                $result .= '</div>';

            $result .= '</div>';

                $result .= '<script>
                     jQuery.noConflict()(function ($) { 
                         var image_slider = $(\'.' . $vc_init . ' .fl-team-slider\');  
                         image_slider.slick({ 
                                dots: true, 
                    		    slidesToShow: 3, 
                    		    slidesToScroll: 1,
                                arrows: true,
                               	autoplay: false,
                    		    speed: 800,
                    		    infinite: false,
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
    add_shortcode('vc_fl_team_slider', 'vc_fl_team_slider_function');

