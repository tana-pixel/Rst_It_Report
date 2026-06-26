<?php

    if ( ! function_exists( 'vc_fl_woo_shop_slider_function' ) ) {
        function vc_fl_woo_shop_slider_function($atts, $content = null)
        {
            $css_classes[] = 'fl-woo-slider-content-vc';

            $slider_css_classes[] = 'fl-shop-slider';

            global $fl_helping_responsive_style;

            $atts = vc_map_get_attributes('vc_fl_woo_shop_slider', $atts);

            extract($atts);

            $result = $wrapper_attributes[] = $css_classes[] = $responsive_style = '';


            $css_classes[] .= fl_get_css_tab_class($atts);

            // Custom HTML Class
            $vc_init = uniqid('fl-shop-slider-').'-'.rand(100,9999);
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


            $max_page = new WP_Query($pages = array('post_type' => 'product', 'posts_per_page' => $count,));
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args = array(
                'post_type'                 => 'product',
                'post_status'               => 'publish',
                'maxpage'                   => $max_page->max_num_pages,
                'posts_per_page'            => $count,
                'paged'                     => $paged,
            );

            if ( ! empty( $woo_category_link ) and ($woo_category_link !='0')) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy'  => 'product_cat',
                        'field'     => 'slug',
                        'terms'     => $woo_category_link
                    ),
                );
            }
            $product = new WP_Query( $args );

            $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

            $slider_css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $slider_css_classes ) ) ) );

            $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '.implode( ' ', $wrapper_attributes).'>';

                $result .= '<div class="' . esc_attr( trim( $slider_css_class ) ) . '">';
                ob_start();
                if( $product->have_posts() ) : while( $product->have_posts() ) : $product->the_post();
                    wc_get_template_part( 'content', 'product' );
                endwhile; endif;
                wp_reset_query();

                $result .= ob_get_clean();

                $result .= '</div>';


            $result .= '</div>';

                $result .= '<script>
                     jQuery.noConflict()(function ($) { 
                         var image_slider = $(\'.' . $vc_init . ' .fl-shop-slider\');  
                         image_slider.slick({ 
                                dots: true, 
                    		    slidesToShow: 4, 
                    		    slidesToScroll: 2,
                                arrows: true,
                               	autoplay: false,
                    		    speed: 800,
                    		    infinite: true,
                                responsive: [
                                    {
                                      breakpoint: 900,
                                      settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 2
                                      }
                                    },
                                       {
                                      breakpoint: 800,
                                      settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 2
                                      }
                                    },
                                      { 
                                      breakpoint: 700,
                                      settings: {
                                        slidesToShow: 2,
                                        slidesToScroll: 2
                                      }
                                    },
                                    {
                                        breakpoint: 480,
                                        settings: {
                                            slidesToShow: 1,
                                            slidesToScroll: 1
                                        }
                                    }
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
    add_shortcode('vc_fl_woo_shop_slider', 'vc_fl_woo_shop_slider_function');

