<?php
global $post, $PIXAD_Autos;
$Settings = new PIXAD_Settings();
$settings = $Settings->getSettings('WP_OPTIONS', '_pixad_autos_settings', true);

$validate = $Settings->getSettings('WP_OPTIONS', '_pixad_autos_validation', true); // Get validation settings


$showInList = pixad::getlistviewfields($validate);
//print_r($showInList);

$validate = pixad::validation($validate); // Fix undefined index notice

$auto_translate = unserialize(get_option('_pixad_auto_translate'));

?>
<?php while (have_posts()) : the_post(); ?>

    <?php
    $comment_args = array('status' => 'approve', 'post_id' => $post->ID,);
    $comments = get_comments($comment_args);
    $post_rating = [];
    foreach ($comments as $comment) {
        $post_rating[] = floatval(get_comment_meta($comment->comment_ID, 'rating', true));
    }
    ?>
    <article class="card" id="post-<?php the_ID(); ?>">
        <div class="card__img">
            <?php if (has_post_thumbnail()): ?>
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('autlines-auto-cat', array('class' => 'img-responsive')); ?>
                </a>
            <?php else: ?>
                <img class="no-image" src="<?php echo PIXAD_AUTO_URI . 'assets/img/no_image.jpg'; ?>" alt="<?php esc_attr_e('No image','autlines')?>">
            <?php endif; ?>

            <?php if (autlines_get_theme_mod('auto_featured_text',true)):
                $label_bg = '';
                  if(autlines_get_theme_mod('auto_featured_text_background',true)){
                      $label_bg = 'background-color:'.autlines_get_theme_mod('auto_featured_text_background',true).';';
                  }
                $label_style = ( $label_bg ) ? 'style=' . $label_bg . '' : '';
                ?>
                <div class="card__wrap-label"><span class="card__label" <?php echo esc_attr($label_style);?>><?php echo autlines_get_theme_mod('auto_featured_text',true); ?></span></div>
            <?php endif; ?>

            <?php if ($PIXAD_Autos->get_meta('_auto_sale_price') != ''): ?>
                <span class="card__wrap-label sale"><?php esc_html_e('Sale', 'autlines'); ?></span>
            <?php endif; ?>

        </div>
        <div class="card__inner">
            <div class="top-content">
                <div class="left-content">
                    <h2 class="card__title ui-title-inner"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="card__description">
                        <?php if (autlines_get_theme_mod('list_description_auto', true)) {
                            echo autlines_get_theme_mod('list_description_auto', true);
                        } ?>
                    </div>
                </div>
                <div class="right-content">
                    <?php if (function_exists('pix_autodealer_output_info')) {?>
                        <span class="tmpl-slider-grid__name fl-font-style-bolt"><?php echo pix_autodealer_output_info(get_the_title()); ?></span>
                    <?php } ?>
                    <?php if(!empty($PIXAD_Autos->get_meta('custom_price_catalog'))){?>
                        <div class="card__price fl-primary-bg"><span class="card__price-number fl-font-style-bolt"><?php echo esc_html($PIXAD_Autos->get_meta('custom_price_catalog'));?></span></div>
                    <?php } else { ?>
                        <?php if ($validate['auto-price_show'] && $PIXAD_Autos->get_meta('_auto_price')): ?>
                            <?php 
                            // Безопасно получаем цену и проверяем наличие перевода (Safely get price and check for translation)
                            // Получаем чистую цену без HTML-сущностей (Get clean price without HTML entities)
                            $price_key = strip_tags($PIXAD_Autos->get_price());
                            $price_key = html_entity_decode($price_key, ENT_QUOTES, 'UTF-8');
                            
                            $price = is_numeric($PIXAD_Autos->get_meta('_auto_price')) || $PIXAD_Autos->get_meta('_auto_price') == '' ? 
                                $PIXAD_Autos->get_price(false) : 
                                (isset($auto_translate[$price_key]) ? $auto_translate[$price_key] : $price_key);
                            ?>
                            <div class="card__price fl-primary-bg"><span
                                        class="price-text fl-font-style-bolt-two"><?php esc_html_e('PRICE:', 'autlines') ?></span>
                                <?php if (function_exists('pix_autodealer_output_info')) {?>
                                    <span class="card__price-number fl-font-style-bolt"><?php echo pix_autodealer_output_info($price); ?></span>
                                <?php } ?>
                            </div>
                        <?php endif; ?>
                    <?php } ?>
                </div>
            </div>
            <div class="bottom-content">
                <!-- Car Details -->
                <ul class="card__list list-unstyled">
                    <?php foreach ($showInList as $id => $sideAttribute):
                        $settingName = $showInList[$id]['title'];
                        $settingName = trim($settingName);
                        $id = '_' . $id;
                        $id = str_replace('-', '_', $id);
                        ?>
                        <?php if ($PIXAD_Autos->get_meta($id)): ?>
                            <li class="card-list__row">
                                <?php
                                $val_attr = $PIXAD_Autos->get_meta($id);


                                if (!empty($auto_translate[$val_attr])) {

                                    if ($sideAttribute['icon']) {
                                        ?>
                                        <i class="<?php echo esc_html($sideAttribute['icon']) ?>"></i>
                                        <div class="right--content">
                                        <span class="card-list__title">
                                        <?php
                                    }
                                    if ($settingName) {
                                        echo pix_translate_validate_info($auto_translate[$settingName]).": ";
                                    } else {
                                        $customId = substr($id, 1);
                                        $сustomSettingName = $validate[$customId . '_name'];
                                        echo esc_attr($сustomSettingName);

                                    }

                                    ?></span>
                                    <span class="card-list__info">
                                <?php
                                echo pix_translate_validate_info($auto_translate[$val_attr]);
                                ?>
                              </span>
                                    </div>


                                <?php } else { ?>
                                    <i class="<?php echo esc_html($sideAttribute['icon']) ?>"></i>
                                    <div class="right--content">
                                                <span class="card-list__title">
                                <?php

                                if ($settingName != '') {
                                    echo pix_translate_validate_info($auto_translate[$settingName]).": ";
                                } else {
                                    $customId = substr($id, 1);
                                    $сustomSettingName = $validate[$customId . '_name'];
                                    echo esc_attr($сustomSettingName);

                                }

                                ?></span>
                                        <span class="card-list__info">
                                <?php
                                if ($id == '_auto_mileage') {
                                    echo number_format($PIXAD_Autos->get_meta('_auto_mileage'), 0, '', "{$settings['autos_thousand']}");
                                } else {
                                    echo esc_html($PIXAD_Autos->get_meta($id));
                                }
                                if ($id == '_auto_horsepower') {
                                    echo " ";
                                    esc_html_e('hp', 'autlines');
                                } elseif ($id == '_auto_engine') {
                                    echo " ";
                                    esc_html_e('cm3', 'autlines');
                                } elseif ($id == '_auto_doors') {
                                    echo " ";
                                    esc_html_e('doors', 'autlines');
                                }

                                ?>
                              </span>
                                    </div>
                                <?php } ?>
                            </li>
                        <?php endif; ?>

                    <?php endforeach; ?>

                    <?php if (array_key_exists('auto-date', $showInList) && $validate['auto-date_show'] && get_the_date()): ?>
                        <li><span class="card-list__title"><?php esc_html_e('Updated :', 'autlines'); ?></span>
                            <span><?php echo get_the_date(); ?></span></li>
                    <?php endif; ?>


                </ul><!-- / Car Details -->
            </div>

            <div class="bottom-dbl-content">
                <?php
                $images = autlines_get_theme_mod('gallery_promo_images', true);
                if ($images):
                    ?>
                    <div class="promo-image-gallery">
                        <ul class="images-promo">
                            <?php
                            foreach ($images as $image): ?>
                                <li class="promo-img">
                                    <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php
                endif;
                ?>

                <?php do_action('autlines_autos_single_auto_img', $post); ?>
                <?php
                if (function_exists('compare_cars_settings_page')) {
                    echo  '<div class="tmpl-list-footer">
                         <a class="add-to-compare" data-id="'.get_the_ID().'" data-action="add">
                           <span class="add-cmpr"> 
                               <i class="icon-speedometer" aria-hidden="true"></i>
                              <em class="cmpr-btn-text">'.esc_attr__('Add To Compare','autlines').'</em>
                            </span>
                            <span class="rem-cmpr">
                              <i class="icon-speedometer" aria-hidden="true"></i>
                              <em class="cmpr-btn-text">'.esc_attr__('Remove From Compare','autlines').'</em>
                            </span>   
                         </a>';
                    if(empty(get_option('compare_cars_templ')) || empty(get_option('compare_cars_templ')['no_favorite'])) :
                        echo  '<a class="car-favorite" data-id="'.get_the_ID().'" data-action="add-favorite">
                           <span class="add-fvrt"> 
                              <i class="fa fa-star-o"></i>
                            </span>
                            <span class="rem-fvrt"> 
                              <i class="fa fa-star-o"></i>
                            </span>
                        </a>';
                    endif;
                    echo '</div>';
                }
                ?>
            </div>


        </div>

    </article>
<?php endwhile; ?>


