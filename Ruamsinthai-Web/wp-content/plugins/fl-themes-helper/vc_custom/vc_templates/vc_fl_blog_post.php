<?php

    if ( ! function_exists( 'vc_fl_blog_posts_function' ) ) {
        function vc_fl_blog_posts_function($atts, $content = null)
        {
            $archive_year  = get_the_time('Y');
            $archive_month = get_the_time('m');
            $archive_day   = get_the_time('d');
            $css_classes[] = 'fl-home-page-posts-content-vc';

            global $fl_helping_responsive_style,$post;

            $atts = vc_map_get_attributes('vc_fl_blog_posts', $atts);

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
                    $responsive_id = uniqid('fl-post-responsive-').'-'.rand(100,9999);
                    $column_selector = $responsive_id;
                    $responsive_style = fl_helping__addons_get_responsive_style($responsive_css, $column_selector);
                    $css_classes[] .= $responsive_id;
                }
            }



            // Animation option
            if ( ! empty( $animation ) and ($animation !='none')) {
                $css_classes[] = 'fl-animated-item-velocity';
                $wrapper_attributes[] = 'data-animate-type="'.$animation.'"';
                if(! empty( $style_blog ) and ($style_blog =='style-one')){
                    $wrapper_attributes[] = 'data-item-for-animated=".blog-post-default"';
                }else{
                    $wrapper_attributes[] = 'data-item-for-animated=".blog-post"';
                }


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


            // Slider Style
            if ( ! empty( $woo_product_slider_style ) and ($woo_product_slider_style !='')) {
                $slider_css_classes[] = $woo_product_slider_style;
            }
            if(! empty( $style_blog ) and ($style_blog =='style-one')){
                $post_count = '3';
            }else{
                $post_count = '4';
            }


            $max_page = new WP_Query($pages = array('post_type' => 'product', 'posts_per_page' => 4,));
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args = array(
                'post_type'                 => 'post',
                'post_status'               => 'publish',
                'ignore_sticky_posts'       => 1,
                'maxpage'                   => $max_page->max_num_pages,
                'posts_per_page'            => $post_count,
                'paged'                     => $paged,
            );
            $posts = new WP_Query( $args );
            $count_post = wp_count_posts('post')->publish;

            $i = 0;
            $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

            $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '.implode( ' ', $wrapper_attributes).'>';

                $result .= '<div class="home-page-post-container">';

                if( $posts->have_posts() ) : while( $posts->have_posts() ) : $posts->the_post();
                    $post_date = get_the_date();
                    ob_start();
                    // Style One
                    if(! empty( $style_blog ) and ($style_blog =='style-one')){
                        $result .='<div class="blog-post-default col-md-4" id="post-'.$post->ID.'" data-post-id="'.$post->ID.'">';
                       if(has_post_thumbnail()){
                            $result .= '<div class="post-holder">';
                            $result .='<a href="'.get_permalink( $post->ID ).'">';
                            $result .= get_the_post_thumbnail($post->ID, 'autlines_size_600x360_crop');
                            $result .='</a>';
                            $result .= '</div>';
                        }
                        // Post Info
                        $result .= '<div class="post-info">';

                            // Author info
                            $result .= '<div class="post-author-info-content">';
                                // Author ava
                                $result .= '<span class="author-avatar">'.get_avatar( get_the_author_meta('user_email'), 35 ).'</span>';
                                // Author Prefix
                                $result .= '<span class="author-prefix">'.esc_html__('By','fl-themes-helper').'</span>';
                                // Author Nickname
                                $result .= '<span class="author-link fl-secondary-color-hv">'.get_the_author_posts_link().'</span>';
                            $result .= '</div>';
                            // Date info
                            $result .='<div class="post-date-info-content">';
                                $result .='<a class="fl-secondary-color-hv" href="'.get_day_link( $archive_year, $archive_month, $archive_day).'">';
                                    $result .= get_the_date();
                                $result .='</a>';
                            $result .= '</div>';
                        $result .='</div>';

                        $result .= '<div class="fl-font-style-bolt post-title fl-secondary-color-hv"><a href="'.get_permalink( $post->ID ).'">'.get_the_title( $post->ID ).'</a></div>';
                        $result .= '<div class="post-bottom-content fl-font-style-regular">'.fl_limit_excerpt(15).'</div>';
                        $result .= '</div>';
                    }
                    // Style Two
                    if(! empty( $style_blog ) and ($style_blog =='style-two')){
                        // Left content
                        if ( $i== 0 and $count_post > 2) {
                            $result .='<div class="col-md-4 left-post-content">';
                        }
                        if($i == 0 || $i == 1){
                            $result .='<div class="blog-post left-post-style" id="post-'.$post->ID.'" data-post-id="'.$post->ID.'">';
                            $result .='<div class="post-top-info fl-font-style-semi-bolt"><span class="post-date">'.$post_date.'</span> <span class="post-author"><span>'.esc_html__('by','trendsetter').'</span> <span class="author-link fl-primary-color fl-secondary-color-hv">'.wp_kses_post(get_the_author_posts_link()).'</span></span></div>';
                            $result .= '<div class="fl-font-style-bolt post-title fl-secondary-color-hv"><a href="'.get_permalink( $post->ID ).'">'.get_the_title( $post->ID ).'</a></div>';
                            $result .= '<div class="post-bottom-content fl-font-style-regular">'.fl_limit_excerpt(15).'</div>';
                            $result .= '</div>';
                        } else {
                            $result .='<div class="blog-post col-md-4 right-post-style" id="post-'.$post->ID.'" data-post-id="'.$post->ID.'">';
                            $result .='<div class="post-top-info fl-font-style-semi-bolt"><span class="post-date">'.$post_date.'</span> <span class="post-author"><span>'.esc_html__('by','trendsetter').'</span> <span class="author-link fl-primary-color fl-secondary-color-hv">'.wp_kses_post(get_the_author_posts_link()).'</span></span></div>';
                            if(has_post_thumbnail()){
                                $result .= '<div class="post-holder">';
                                $result .='<a href="'.get_permalink( $post->ID ).'">';
                                $result .= get_the_post_thumbnail($post->ID, 'autlines_size_600x360_crop');
                                $result .='</a>';
                                $result .= '</div>';
                            }
                            $result .= '<div class="fl-font-style-bolt post-title fl-secondary-color-hv"><a href="'.get_permalink( $post->ID ).'">'.get_the_title( $post->ID ).'</a></div>';
                            $result .= '<div class="post-bottom-content fl-font-style-regular">'.fl_limit_excerpt(15).'</div>';
                            $result .= '</div>';
                        }
                        if ( $i== 1 and $count_post > 2) {
                            $result .='</div>';
                        }

                    }

                    ob_clean();




                    $i++; endwhile; endif;
                wp_reset_query();


                $result .= '</div>';


            $result .= '</div>';

            // Responsive CSS Box
            if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
                $fl_helping_responsive_style .= $responsive_style;
            }

            return $result;
        }
    }
    add_shortcode('vc_fl_blog_posts', 'vc_fl_blog_posts_function');

