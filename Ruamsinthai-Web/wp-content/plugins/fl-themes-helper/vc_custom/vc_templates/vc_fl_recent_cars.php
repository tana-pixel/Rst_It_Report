<?php

    if ( ! function_exists( 'vc_fl_resent_car_posts_function' ) ) {
        function vc_fl_resent_car_posts_function($atts, $content = null)
        {
            $css_classes[] = 'fl-resent-cars-vc';

            global $fl_helping_responsive_style, $PIXAD_Autos, $fl_helping_css_style;
            $Settings = new PIXAD_Settings();
            $validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); // Get validation settings

            $showInSidebar = pixad::getsideviewfields($validate);
            $validate = pixad::validation( $validate ); // Fix undefined index notice

            $auto_translate = unserialize( get_option( '_pixad_auto_translate' ) );

            $atts = vc_map_get_attributes('vc_fl_resent_car_posts', $atts);

            extract($atts);

            $btn = $wrapper_attributes[] =$car_wrapper_attributes[]= $css_classes[]=$car_css_classes[] = $responsive_style = '';

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
                $car_css_classes[] = 'fl-animated-item-velocity';
                $car_wrapper_attributes[] = 'data-animate-type="'.$animation.'"';
                $car_wrapper_attributes[] = 'data-item-for-animated=".car-post-vc"';

                if ( ! empty( $custom_delay ) and ( $custom_delay !='off')) {
                    if ( ! empty( $animation_delay ) and ($animation_delay !='')) {
                        $car_wrapper_attributes[] = 'data-item-delay="'.$animation_delay.'"';
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


            // Button Link
            //Btn link
            $tag_link = 'span'; $link_atts='';
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
            if ( ! empty( $btn_link_text ) and ($btn_link_text !='')) {
                $btn = '<' . $tag_link . ' class="fl-vc-button fl-font-style-bolt-two" ' . $link_atts . '>' . $btn_link_text . '</' . $tag_link . '>';
            }

            // Custom Color Setting
            if ( ! empty( $custom_color ) && ($custom_color !='')) {
                $custom_html_class = uniqid('fl-vc-car-btn-').rand(100,9999);
                $css_classes []= $custom_html_class;
                // Hover Color
                if ( ! empty( $btn_text_cl ) && ($btn_text_cl !='')) {
                    $fl_helping_css_style[] = '.' . $custom_html_class . ' .fl-vc-button { color:' . $btn_text_cl . '!important; }';
                }
                if ( ! empty( $btn_bg ) && ($btn_bg !='')) {
                    $fl_helping_css_style[] = '.' . $custom_html_class . ' .fl-pagination { background-color:' . $btn_bg . '!important; }';
                }
                if ( ! empty( $btn_hv_bg ) && ($btn_hv_bg !='')) {
                    $fl_helping_css_style[] = '.' . $custom_html_class . ' .fl-vc-button:after { background-color:' . $btn_hv_bg . '!important; }';
                }
            }






            ob_start();

            $max_page   = new WP_Query($pages = array('post_type' => 'pixad-autos', 'posts_per_page' => $count,));
            $paged      = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args = array(
                'nonce'                     => wp_create_nonce('autlines-load-more-car-nonce'),
                'url'                       => admin_url('admin-ajax.php'),
                'button_text'               => ($btn_text) ? $btn_text : esc_attr__( 'Show More', 'fl-themes-helper' ),
                'button_text_no_post'       => ($btn_text_end) ? $btn_text_end : esc_attr__( 'All Car Is Loaded', 'fl-themes-helper' ),
                'button_loading'            => ($btn_text_loading) ? $btn_text_loading : esc_attr__( 'Loading...', 'fl-themes-helper' ),
                'post_type'                 => 'pixad-autos',
                'posts_per_page'            => $count,
                'post_status' 		        => 'publish',
                'maxpage'                   => $max_page->max_num_pages,
                'paged'                     => $paged,
            );
            $posts = new WP_Query( $args );


            $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );
            $car_css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $car_css_classes ) ) ) );

ob_start();
?>
            <div class="<?php echo esc_attr( trim( $css_class ) )?>" <?php echo implode( ' ', $wrapper_attributes)?>>

                <div class="vc-cars-wrapper <?php echo esc_attr( trim( $car_css_class ) )?>" <?php echo implode( ' ', $car_wrapper_attributes)?>>
                    <?php if( $posts->have_posts() ) { while( $posts->have_posts() ) { $posts->the_post();?>
                    <div class="car-post-vc col-xl-3 col-md-6">
                        <div class="slider-grid__inner slider-grid__inner_mod-b">
                            <div class="card__img">
                                <?php
                                    if( has_post_thumbnail() ):
                                        echo'<a href="'.get_permalink( $posts->ID ).'">';
                                            echo get_the_post_thumbnail($posts->ID, 'autozone_latest_item', array('class' => 'img-responsive'));
                                        echo '</a>';
                                    else:
                                        echo '<img class="no-image" src="'.PIXAD_AUTO_URI .'assets/img/no_image.jpg'.'" alt="no-image">';
                                    endif;
                                ?>
                            </div>
                            <div class="tmpl-gray-footer">
                                <div class="top-info-content">
                                    <span class="tmpl-slider-grid__name fl-font-style-bolt">
                                        <?php echo '<a class="fl-secondary-color-hv" href="'.get_permalink( $posts->ID ).'">'.wp_kses_post(get_the_title()).'</a>'?>
                                    </span>
                                    <?php if(!empty($PIXAD_Autos->get_meta('custom_price_catalog'))){?>
                                        <span class="slider-grid__price_wrap fl-font-style-bolt fl-primary-color"><span class="slider-grid__price "><?php echo esc_html($PIXAD_Autos->get_meta('custom_price_catalog'));?></span></span>
                                    <?php } else { ?>
                                        <?php
                                        if( $validate['auto-price_show'] && $PIXAD_Autos->get_meta('_auto_price') ):
                                            echo '<span class="slider-grid__price_wrap fl-font-style-bolt fl-primary-color"><span class="slider-grid__price ">'.wp_kses_post($PIXAD_Autos->get_price(false)).'</span></span>';
                                        endif;?>
                                    <?php } ?>

                                </div>
                                <ul class="tmpl-slider-grid__info list-unstyled">
                                    <?php
                                    foreach ($showInSidebar as $id => $sideAttribute):
                                        $id='_'.$id;
                                        $id = str_replace('-', '_', $id);
                                        if( $PIXAD_Autos->get_meta($id) ):
                                            echo '<li><i class="'.esc_html($sideAttribute['icon']).'"></i>';
                                            $val_attr =  $PIXAD_Autos->get_meta($id);
                                            if(!empty($auto_translate[$val_attr])  ) {
                                                $attributes = pix_translate_validate_info($auto_translate[$val_attr]);
                                            }else{
                                                $attributes = esc_html($PIXAD_Autos->get_meta($id));
                                            }
                                            echo $attributes;
                                        endif;
                                    endforeach;
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php
                        wp_reset_postdata();
                        }
                    } else {
                        echo 'Added car for your theme.';
                    }
                    ?>
                </div>
                <div class="cf"></div>
                <div class="button-vc-car-wrapper text-center cf">
                    <?php    // Button Load More
                        if ( ! empty( $button_style ) and ($button_style =='load_more')) {

                            if ( $posts->max_num_pages > 1 ) {
                                wp_enqueue_script('fl-load-more-car-vc', plugins_url('../../assets/js/load-more/cars-load-more.js', __FILE__));
                                wp_localize_script('fl-load-more-car-vc', 'autlinesloadmorecarvc', $args);
                                echo '<div class="fl-pagination ajax-pagination button-container" data-animation="true">'
                                    . '<span id="fl-ajax-load-more-pagination-vc" class="fl-button-pagination fl-vc-button fl-font-style-bolt-two fl-load-more-cars-vc-enable" data-car-per-page="'.$count.'">'.$btn_text.'</span>'
                                    . '</div>';
                            }
                        } else {
                            echo '<div class="fl-pagination button-container" data-animation="true">';
                            echo $btn;
                            echo '</div>';
                        }
                     ?>
                </div>
            </div>


        <?php

            // Responsive CSS Box
            if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
                $fl_helping_responsive_style .= $responsive_style;
            }

            return ob_get_clean();

        }
    }
    add_shortcode('vc_fl_resent_car_posts', 'vc_fl_resent_car_posts_function');