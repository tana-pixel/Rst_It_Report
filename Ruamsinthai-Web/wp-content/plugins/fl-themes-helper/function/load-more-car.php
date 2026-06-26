<?php

add_action( 'wp_ajax_autlines_ajax_load_more_car_vc', 'autlines_ajax_load_more_car_vc');
add_action( 'wp_ajax_nopriv_autlines_ajax_load_more_car_vc', 'autlines_ajax_load_more_car_vc');
function autlines_ajax_load_more_car_vc() {

    check_ajax_referer( 'autlines-load-more-car-nonce', 'nonce' );
    $args                   = isset( $_POST['query'] ) ? array_map( 'esc_attr', $_POST['query'] ) : array();
    $args['post_type']      = isset( $args['post_type'] ) ? esc_attr( $args['post_type'] ) : 'pixad-autos';
    $args['paged']          = esc_attr( $_POST['page'] );
    $args['post_status']    = 'publish';
    $args['posts_per_page'] = esc_attr( $_POST['car_per_page'] );

    $article_css_classes [] = $animation_delay = '';
    global $PIXAD_Autos;
    $Settings = new PIXAD_Settings();
    $validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); // Get validation settings

    $showInSidebar = pixad::getsideviewfields($validate);
    $validate = pixad::validation( $validate ); // Fix undefined index notice

    $auto_translate = unserialize( get_option( '_pixad_auto_translate' ) );


    ob_start();
    $posts = new WP_Query( $args );

    if ( $posts->have_posts() ) :  while ( $posts->have_posts() ): $posts->the_post();?>

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
                            <span class="slider-grid__price_wrap fl-font-style-bolt fl-primary-color"><span class="slider-grid__price "><span><?php echo esc_html($PIXAD_Autos->get_meta('custom_price_catalog'));?></span></span></span>
                        <?php } else { ?>
                            <?php if( $validate['auto-price_show'] && $PIXAD_Autos->get_meta('_auto_price') ): ?>
                                <?php if (function_exists('pix_autodealer_output_info')) {?>
                                    <span class="slider-grid__price_wrap fl-font-style-bolt fl-primary-color"><span class="slider-grid__price "><span><?php echo pix_autodealer_output_info($PIXAD_Autos->get_price(false)); ?></span></span></span>
                                <?php } ?>
                            <?php endif; ?>
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
    endwhile; endif;
    wp_reset_postdata();
    $data = ob_get_clean();
    wp_send_json_success( $data );

    wp_die();

}