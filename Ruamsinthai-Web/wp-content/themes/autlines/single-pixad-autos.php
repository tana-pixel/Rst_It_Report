<?php /* The Template for displaying all single autos. */
global $post, $PIXAD_Autos, $PIXAD_Country;
$header_enable = 'enable';
$Settings = new PIXAD_Settings();
$settings = $Settings->getSettings('WP_OPTIONS', '_pixad_autos_settings', true);
$validate = $Settings->getSettings('WP_OPTIONS', '_pixad_autos_validation', true); // Get validation settings
$validate = pixad::validation($validate);
$PIXAD_Autos->Query_Args(array('auto_id' => $post->ID));

$custom = get_post_custom(get_queried_object()->ID);
$layout = get_post_meta($post->ID, 'pixad_auto_sidebar_layout', true) != '' ? get_post_meta($post->ID, 'pixad_auto_sidebar_layout', true) : 'right';

$pix_options = get_option('pix_general_settings');
$auto_translate = unserialize(get_option('_pixad_auto_translate'));


$Auto = new PIXAD_Autos();
$Auto->Query_Args(array('auto_id' => $post->ID));

$pix_show_description_tab = get_post_meta(get_the_ID(), 'pixad_auto_description_tab', true) != '' ? get_post_meta(get_the_ID(), 'pixad_auto_description_tab', true) : 1;
$pix_show_features_tab = get_post_meta(get_the_ID(), 'pixad_auto_features_tab', true) != '' ? get_post_meta(get_the_ID(), 'pixad_auto_features_tab', true) : 1;
$title_1 = get_post_meta(get_the_ID(), 'pixad_auto_custom_title_1', true);
$title_2 = get_post_meta(get_the_ID(), 'pixad_auto_custom_title_2', true);
$title_3 = get_post_meta(get_the_ID(), 'pixad_auto_custom_title_3', true);
$pix_show_contacts_tab = get_post_meta(get_the_ID(), 'pixad_auto_contacts_tab', true) != '' ? get_post_meta(get_the_ID(), 'pixad_auto_contacts_tab', true) : 1;

$pix_show_specifications = get_post_meta(get_the_ID(), 'pixad_auto_specifications', true) != '' ? get_post_meta(get_the_ID(), 'pixad_auto_specifications', true) : 1;


if (class_exists('Pix_Autos')) {
    wp_enqueue_script('google-maps', autlines_google_map_url(), array('jquery'), null, true);
}
$has_video = false;
$YoutubeCode = '';

$video_attachments = array();
$videos = pixad_get_attach_video($post->ID);
//$videos = explode(',', $videos[0]);
if (isset($videos[0]) && $videos[0] != '') {
    $video_attachments = get_posts(array(
        'post_type' => 'attachment',
        'include' => $videos[0]
    ));
}

if (count($video_attachments) > 0 || pixad_get_external_video($post->ID) != '') {
    $has_video = true;
}


$pix_active_description_tab = $pix_active_features_tab = $pix_active_title_1 = $pix_active_title_2 = $pix_active_title_3 = $pix_active_contacts_tab = '';
if ($pix_show_description_tab) {
    $pix_active_description_tab = 'active';
} elseif ($pix_show_features_tab) {
    $pix_show_features_tab = 'active';
} elseif ($title_1) {
    $pix_active_title_1 = 'active';
} elseif ($title_2) {
    $pix_active_title_2 = 'active';
} elseif ($title_3) {
    $pix_active_title_3 = 'active';
} elseif ($pix_show_contacts_tab) {
    $pix_active_contacts_tab = 'active';
}

/// Gallery
$gallery_images = autlines_get_theme_mod('gallery_autos', true);
// Sub Title
$sub_title_content = autlines_get_theme_mod('sub_title_auto',true);
// Custom Class Popup
$custom_class_popup = uniqid('popup').'-'.rand(100,9999);

get_header();

if($header_enable !='disable' ) {
    get_template_part('template-parts/header/header_content');
}

?>
<!--Padding Top Start-->
<?php if (autlines_get_theme_mod('page_padding_top', true) != 'disable') { ?>
    <div class="fl-page-padding top"></div>
<?php } ?>
<!--Padding Top End-->

<div class="container">
    <div class="row">
        <?php if ($layout == 'left'):
            get_template_part('single', 'pixad-autos-sidebar');
        endif; ?>

        <?php if ($layout == 'none'){ ?>
        <div class="col-md-8 col-md-offset-2">
            <?php } else { ?>
            <div class="col-md-8">
                <?php } ?>
                <?php
                // Start the loop.
                while (have_posts()) : the_post();
                    ?>
                    <main class="main-content">
                        <article class="car-details">
                            <div class="car-details__wrap-title clearfix">
                                <?php if ($sub_title_content){
                                    echo '<div class="car-details-sub-title-content fl-font-style-regular">'.esc_attr($sub_title_content).'</div>';
                                }?>
                                <h2 class="car-details__title"><?php esc_attr(the_title()) ?></h2>
                            </div>

                            <div id="slider-auto slider-product" class="auto-slider flexslider slider-product">
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
                                <?php
                                if ( function_exists('compare_cars_list_footer')){
                                    do_action('autlines_autos_single_auto_img', $post);
                                } ?>
                                <ul class="slides fl-magic-popup fl-gallery-popup <?php echo esc_attr($custom_class_popup)?>" data-custom-class="<?php echo esc_attr($custom_class_popup)?>">
                                    <?php

                                    if (has_post_thumbnail()) {

                                        $image_title = esc_attr(get_the_title(get_post_thumbnail_id()));
                                        $image_link = wp_get_attachment_url(get_post_thumbnail_id());
                                        $image = get_the_post_thumbnail($post->ID, 'autlines_size_750x430_crop', array('title' => $image_title));

                                        $values = get_post_custom($post->ID);

                                        echo sprintf('<li><a href="%s">%s</a></li>', $image_link, $image);

                                        if ($has_video) {

                                            $auto_video_code = isset($values['_auto_video_code']) ? $values['_auto_video_code'] : false;
                                            if ($auto_video_code) {
                                                $YoutubeCode = reset($auto_video_code);
                                                preg_match('#(\.be/|/embed/|/v/|/watch\?v=)([A-Za-z0-9_-]{5,11})#', $YoutubeCode, $matches);
                                                if (isset($matches[2]) && $matches[2] != '') {
                                                    $YoutubeCode = $matches[2];
                                                }
                                                $you_t = '<iframe src="//www.youtube.com/embed/' . $YoutubeCode . '" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
                                                echo sprintf('<li>%s</li>', $you_t);
                                            }
                                        }


                                        if ($gallery_images):
                                            foreach ($gallery_images as $image) {
                                                // Проверяем, является ли $image массивом или числом/строкой
                                                if (is_array($image)) {
                                                    // Если это массив, используем ключи как раньше
                                                    $image_id = isset($image['ID']) ? $image['ID'] : 0;
                                                    $image_holder = wp_get_attachment_image($image_id, 'autlines_size_750x430_crop');
                                                    $image_link_gallery = isset($image['url']) ? $image['url'] : '';
                                                    $image_title = isset($image['title']) ? esc_attr($image['title']) : '';
                                                } else {
                                                    // Если это число/строка, считаем его ID изображения
                                                    $image_id = (int)$image;
                                                    $image_holder = wp_get_attachment_image($image_id, 'autlines_size_750x430_crop');
                                                    $image_link_gallery = wp_get_attachment_url($image_id);
                                                    $image_title = get_the_title($image_id);
                                                }
                                                
                                                if ($image_holder) {
                                                    echo sprintf('<li><a href="%s" title="%s" >%s</a></li>', $image_link_gallery, $image_title, $image_holder);
                                                }
                                            }
                                        endif;
                                    } else {
                                        ?>
                                        <img class="no-image" src="<?php echo get_template_directory_uri() . '/admin/assets/images/no_image.jpg'; ?>" alt="<?php esc_attr_e('No image','autlines')?>">
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>

                            <?php
                            if (!empty($gallery_images) && $gallery_images != '' or $has_video != false) {
                                ?>
                                <div id="carousel-auto" class="auto-carousel">
                                    <ul class="slides">
                                        <?php

                                        $image_title = esc_attr(get_the_title(get_post_thumbnail_id()));
                                        $image_link = wp_get_attachment_url(get_post_thumbnail_id());
                                        $image = get_the_post_thumbnail($post->ID, 'autlines_size_480x360_crop', array('title' => $image_title));

                                        echo sprintf('<li>%s</li>', $image);


                                        if ($has_video) {

                                            $auto_video_code = isset($values['_auto_video_code']) ? $values['_auto_video_code'] : false;

                                            if ($auto_video_code) {
                                                $image_title = 'Video';
                                                // $image = get_the_post_thumbnail( $post->ID, 'autlines-auto-thumb', array('title' => $image_title) );
                                                $image = '<i class="fa fa-play" aria-hidden="true"></i><img src="//img.youtube.com/vi/' . $YoutubeCode . '/0.jpg" />';
                                                echo sprintf('<li class="auto-thumb-video">%s</li>', $image);
                                            }
                                        }
                                        // gallery
                                        if ($gallery_images):
                                            foreach ($gallery_images as $image_item) {
                                                // Проверяем, является ли $image_item массивом или числом/строкой
                                                if (is_array($image_item)) {
                                                    // Если это массив, используем ключи как раньше
                                                    $image_id = isset($image_item['ID']) ? $image_item['ID'] : 0;
                                                } else {
                                                    // Если это число/строка, считаем его ID изображения
                                                    $image_id = (int)$image_item;
                                                }
                                                
                                                // Получаем HTML изображения
                                                $image = wp_get_attachment_image($image_id, 'autlines_size_480x360_crop');
                                                if (!$image) continue; // Пропускаем, если изображение не найдено
                                                
                                                $image_class = '';
                                                $image_title = esc_attr(get_the_title($image_id));
                                                
                                                echo sprintf('<li>%s</li>', $image);
                                            }
                                        endif;
                                        ?>
                                    </ul>
                                </div>

                            <?php } ?>





                           <?php if(autlines_get_theme_mod('booking_car_review_calendar',true) =='show'){
                                do_action('autlines_preview_calendar', $post->ID);}
                           ?>



                            <!--  Vehicle Specifications Start-->
                            <div class="vehicle-characteristics cf ">
                                <h2 class="vehicle-characteristics-title"><?php esc_html_e('Vehicle Specifications', 'autlines') ?></h2>
                                    <dl class="list-descriptions list-unstyled">
                                        <?php if ($Auto->get_make()): ?>
                                            <!-- Make -->
                                            <div class="dd-item">
                                                <dt class="left col-md-5 col-sm-3"><?php esc_html_e('Make:', 'autlines'); ?></dt>
                                                <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php echo esc_attr($Auto->get_make()) ?></dd>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($Auto->get_model()): ?>
                                            <!-- Model -->
                                            <div class="dd-item">
                                                <dt class="left col-md-5 col-sm-3"><?php esc_html_e('Model:', 'autlines'); ?></dt>
                                                <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php echo esc_attr($Auto->get_model()) ?></dd>
                                            </div>
                                            <!-- / Model -->
                                        <?php endif; ?>

                                        <?php if ($validate['auto-stock-status_show'] && $Auto->get_meta('_auto_stock_status')): ?>
                                            <div class="dd-item">
                                                <dt class="left col-md-5 col-sm-3"><?php esc_html_e('Stock status:', 'autlines'); ?></dt>
                                                <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php echo pix_translate_validate_info($auto_translate[$Auto->get_meta('_auto_stock_status')]) ?></dd>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($validate['auto-year_show'] && $Auto->get_meta('_auto_year')): ?>
                                            <!-- Made Year -->
                                            <div class="dd-item">
                                                <dt class="left col-md-5 col-sm-3"><?php esc_html_e('Year:', 'autlines'); ?></dt>
                                                <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php echo esc_attr($Auto->get_meta('_auto_year')) ?></dd>
                                            </div>
                                            <!-- / Made Year -->
                                        <?php endif; ?>

                                        <?php if ($validate['auto-mileage_show'] && $Auto->get_meta('_auto_mileage')): ?>
                                            <div class="dd-item">
                                                <!-- Mileage -->
                                                <dt class="left col-md-5 col-sm-3"><?php esc_html_e('Mileage:', 'autlines'); ?></dt>
                                                <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php echo number_format($Auto->get_meta('_auto_mileage'), 0, '', "{$settings['autos_thousand']}"); ?></dd>
                                            </div>
                                            <!-- / Mileage -->
                                        <?php endif; ?>

                                        <?php if ($validate['auto-vin_show'] && $Auto->get_meta('_auto_vin')): ?>
                                            <!-- VIN -->
                                            <div class="dd-item">
                                                <dt class="left col-md-5 col-sm-3"><?php esc_html_e('VIN:', 'autlines'); ?></dt>
                                                <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php echo esc_attr($Auto->get_meta('_auto_vin')) ?></dd>
                                            </div>
                                            <!-- / VIN -->
                                        <?php endif; ?>

                                        <?php if ($validate['auto-version_show'] && $Auto->get_meta('_auto_version')): ?>
                                            <!-- Version -->
                                            <div class="dd-item">
                                                <dt class="left col-md-5 col-sm-3"><?php esc_html_e('Version:', 'autlines'); ?></dt>
                                                <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php echo esc_attr($Auto->get_meta('_auto_version')) ?></dd>
                                            </div>
                                            <!-- / Version -->
                                        <?php endif; ?>

                                        <?php if ($validate['auto-fuel_show'] && $Auto->get_meta('_auto_fuel')): ?>
                                            <!-- Fuel -->
                                            <div class="dd-item">
                                                <dt class="left col-md-5 col-sm-3"><?php esc_html_e('Fuel:', 'autlines'); ?></dt>
                                                <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php echo pix_translate_validate_info($auto_translate[$Auto->get_meta('_auto_fuel')]); ?></dd>
                                            </div>
                                            <!-- / Fuel -->
                                        <?php endif; ?>

                                        <?php if ($validate['auto-engine_show'] && $Auto->get_meta('_auto_engine')): ?>
                                            <!-- Engine -->
                                            <div class="dd-item">
                                                <dt class="left col-md-5 col-sm-3"><?php esc_html_e('Engine, cm3', 'autlines'); ?></dt>
                                                <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php echo esc_attr($Auto->get_meta('_auto_engine')) ?></dd>
                                            </div>
                                            <!-- / Engine -->
                                        <?php endif; ?>

                                        <?php if ($validate['auto-horsepower_show'] && $Auto->get_meta('_auto_horsepower')): ?>
                                            <!-- Horsepower -->
                                            <div class="dd-item">
                                                <dt class="left col-md-5 col-sm-3"><?php esc_html_e('Horsepower (hp):', 'autlines'); ?></dt>
                                                <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php echo esc_attr($Auto->get_meta('_auto_horsepower')) ?></dd>
                                            </div>
                                            <!-- / Horsepower -->
                                        <?php endif; ?>

                                        <?php if ($validate['auto-transmission_show'] && $Auto->get_meta('_auto_transmission')) : ?>
                                            <!-- Transmission -->
                                            <div class="dd-item">
                                                <dt class="left col-md-5 col-sm-3"><?php esc_html_e('Transmission:', 'autlines'); ?></dt>
                                                <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php echo pix_translate_validate_info($auto_translate[$Auto->get_meta('_auto_transmission')]) ?></dd>
                                            </div>
                                            <!-- / Transmission -->
                                        <?php endif; ?>

                                        <?php if ($validate['auto-doors_show'] && $Auto->get_meta('_auto_doors')): ?>
                                            <!-- Doors -->
                                            <div class="dd-item">
                                                <dt class="left col-md-5 col-sm-3"><?php esc_html_e('Doors:', 'autlines'); ?></dt>
                                                <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php echo esc_attr($Auto->get_meta('_auto_doors')) ?></dd>
                                            </div>
                                            <!-- / Doors -->
                                        <?php endif; ?>

                                        <?php if ($validate['auto-condition_show'] && $Auto->get_meta('_auto_condition')): ?>
                                            <!-- Condition -->
                                            <div class="dd-item">
                                                <dt class="left col-md-5 col-sm-3"><?php esc_html_e('Condition:', 'autlines'); ?></dt>
                                                <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php echo pix_translate_validate_info($auto_translate[$Auto->get_meta('_auto_condition')]); ?></dd>
                                            </div>
                                            <!-- / Condition -->
                                        <?php endif; ?>
                                        <?php if ($validate['auto-drive_show'] && $Auto->get_meta('_auto_drive')): ?>
                                            <?php $drive = isset($auto_translate[$Auto->get_meta('_auto_drive')]) ? $auto_translate[$Auto->get_meta('_auto_drive')] : $Auto->get_meta('_auto_drive'); ?>
                                            <!-- Drive -->
                                            <div class="dd-item">
                                                <dt class="left col-md-5 col-sm-3"><?php esc_html_e('Drive:', 'autlines'); ?></dt>
                                                <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php echo esc_attr($drive) ?></dd>
                                            </div>
                                            <!-- / Drive -->
                                        <?php endif; ?>

                                        <?php if ($validate['auto-seats_show'] && $Auto->get_meta('_auto_seats')): ?>
                                            <!-- Seats -->
                                            <div class="dd-item">
                                                <dt class="left col-md-5 col-sm-3"><?php esc_html_e('Seats:', 'autlines'); ?></dt>
                                                <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php echo esc_attr($Auto->get_meta('_auto_seats')) ?></dd>
                                            </div>
                                            <!-- / Seats -->
                                        <?php endif; ?>

                                        <?php if ($validate['auto-color_show'] && $Auto->get_meta('_auto_color')): ?>
                                            <?php $color = isset($auto_translate[$Auto->get_meta('_auto_color')]) ? $auto_translate[$Auto->get_meta('_auto_color')] : $Auto->get_meta('_auto_color'); ?>
                                            <!-- Color -->
                                            <div class="dd-item">
                                                <dt class="left col-md-5 col-sm-3"><?php esc_html_e('Color:', 'autlines'); ?></dt>
                                                <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php echo esc_attr($color) ?></dd>
                                            </div>
                                            <!-- / Color -->
                                        <?php endif; ?>

                                        <?php if ($validate['auto-color-int_show'] && $Auto->get_meta('_auto_color_int')): ?>
                                            <?php $color_int = isset($auto_translate[$Auto->get_meta('_auto_color_int')]) ? $auto_translate[$Auto->get_meta('_auto_color_int')] : $Auto->get_meta('_auto_color_int'); ?>
                                            <div class="dd-item">
                                                <dt class="left col-md-5 col-sm-3"><?php esc_html_e('Interior Color:', 'autlines'); ?></dt>
                                                <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php echo esc_attr($color_int) ?></dd>
                                            </div>
                                            <!-- / Color Int -->
                                        <?php endif; ?>



                                        <?php if ($validate['auto-price-type_show'] && $Auto->get_meta('_auto_price_type')): ?>
                                            <!-- Price Type -->
                                            <div class="dd-item">
                                                <dt class="left col-md-5 col-sm-3"><?php esc_html_e('Price Type:', 'autlines'); ?></dt>
                                                <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php echo pix_translate_validate_info($auto_translate[$Auto->get_meta('_auto_price_type')]); ?></dd>
                                            </div>
                                            <!-- / Price Type -->
                                        <?php endif; ?>

                                        <?php if ($validate['auto-warranty_show'] && $Auto->get_meta('_auto_warranty')): ?>
                                            <!-- Warranty -->
                                            <div class="dd-item">
                                                <dt class="left col-md-5 col-sm-3"><?php esc_html_e('Warranty:', 'autlines'); ?></dt>
                                                <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php 
                                                // Используем переменную $auto_translate вместо константы auto_translate
                                                $warranty_key = $Auto->get_meta('_auto_warranty');
                                                $warranty_value = isset($auto_translate[$warranty_key]) ? $auto_translate[$warranty_key] : $warranty_key;
                                                echo pix_translate_validate_info($warranty_value); 
                                                ?></dd>
                                            </div>
                                            <!-- / Warranty -->
                                        <?php endif; ?>



                                        <?php

                                        $custom_settings_quantity = 1;
                                        $max_custom_settings_quantity = 7;
                                        $group_custom_settings_quantity = 1;

                                        while ($group_custom_settings_quantity <= 5): ?>

                                            <?php if ($validate['group_' . $group_custom_settings_quantity . '_show'] != 'on') : ?>
                                                <?php if ($validate['custom_' . $custom_settings_quantity . '_show'] && $validate['group_' . $group_custom_settings_quantity . '_title'] && $Auto->get_meta('_custom_' . $custom_settings_quantity . '')): ?>
                                                    <div class="title-subtitle-wrapper">
                                                        <h4 class="title"><?php echo esc_attr($validate['group_' . $group_custom_settings_quantity . '_title']); ?> </h4>
                                                        <h5 class="subtitle"><?php echo esc_attr($validate['group_' . $group_custom_settings_quantity . '_sub_title']); ?></h5>
                                                    </div>
                                                <?php endif; ?>
                                                <?php
                                                while ($custom_settings_quantity <= $max_custom_settings_quantity): ?>
                                                    <?php if ($validate['custom_' . $custom_settings_quantity . '_show'] && $Auto->get_meta('_custom_' . $custom_settings_quantity . '')): ?>

                                                        <div class="dd-item">
                                                            <dt class="left col-md-5 col-sm-3"><?php echo esc_attr($validate['custom_' . $custom_settings_quantity . '_name']); ?></dt>
                                                            <dd class="right col-md-7 col-sm-9 fl-font-style-semi-bolt"><?php echo esc_attr($Auto->get_meta('_custom_' . $custom_settings_quantity . '')) ?></dd>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php $custom_settings_quantity++; ?>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <?php $custom_settings_quantity = $custom_settings_quantity + 6; ?>
                                            <?php endif; ?>

                                            <?php $group_custom_settings_quantity++;
                                            $max_custom_settings_quantity = $max_custom_settings_quantity + 7;

                                        endwhile; ?>


                                    </dl>

                            </div>
                            <!--  Vehicle Specifications End -->


                            <div class="wrap-nav-table-content">
                                <ul class="navigation-tabs">
                                    <?php if ($pix_show_description_tab) : ?>
                                        <li class="<?php echo esc_attr($pix_active_description_tab); ?>" data-tab="tab-content-1">
                                            <span class="fl-font-style-regular-two"><?php esc_html_e('Vehicle Description', 'autlines') ?></span>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($pix_show_features_tab) : ?>
                                        <li class="<?php echo esc_attr($pix_active_features_tab); ?>" data-tab="tab-content-2">
                                            <span><?php esc_html_e('Features & Options', 'autlines') ?></span>
                                        </li>
                                    <?php endif; ?>



                                    <?php

                                    $settings_quantity_checked = 0;
                                    $custom_settings_quantity = 1;
                                    while ($custom_settings_quantity <= 35) {
                                        if ($PIXAD_Autos->get_meta('_custom_' . $custom_settings_quantity . '') != '') {
                                            $settings_quantity_checked++;
                                        }

                                        $custom_settings_quantity++;
                                    }

                                    ?>



                                    <?php if ($validate['group_1_show'] || $validate['group_2_show'] || $validate['group_3_show'] || $validate['group_4_show'] || $validate['group_5_show']) : ?>
                                        <?php if ($settings_quantity_checked > 0): ?>
                                            <li class="" data-tab="tab-content-7">
                                                <span class="fl-font-style-regular-two"><?php esc_html_e('Technical', 'autlines') ?></span>
                                            </li>
                                        <?php endif ?>
                                    <?php endif; ?>




                                    <?php
                                    if ($title_1 != '') {
                                        ?>
                                    <li class="<?php echo esc_attr($pix_active_title_1); ?>" data-tab="tab-content-4">
                                        <span class="fl-font-style-regular-two"><?php echo esc_attr($title_1) ?></span>
                                        </li><?php
                                    }
                                    if ($title_2 != '') {
                                        ?>
                                    <li class="<?php echo esc_attr($pix_active_title_2); ?>" data-tab="tab-content-5">
                                        <span class="fl-font-style-regular-two"><?php echo esc_attr($title_2) ?></span>
                                        </li><?php
                                    }
                                    if ($title_3 != '') {
                                        ?>
                                    <li class="<?php echo esc_attr($pix_active_title_3); ?>" data-tab="tab-content-6">
                                        <span class="fl-font-style-regular-two"><?php echo esc_attr($title_3) ?></span>
                                        </li><?php
                                    }
                                    ?>

                                    <?php if ($pix_show_contacts_tab) : ?>
                                        <li class="<?php echo esc_attr($pix_active_contacts_tab); ?>" data-tab="tab-content-3">
                                            <span class="fl-font-style-regular-two"><?php esc_html_e('Contact', 'autlines') ?></span>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ('open' == $post->comment_status): ?>
                                        <li class="" data-tab="tab-content-8">
                                            <span class="fl-font-style-regular-two"><?php esc_html_e('Reviews', 'autlines'); ?></span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <div class="tabs-content">
                                <?php if ($pix_show_description_tab) : ?>
                                    <div class="tab-content <?php echo esc_attr($pix_active_description_tab); ?>"
                                         id="tab-content-1">
                                        <?php the_content() ?>
                                    </div>
                                <?php endif; ?>
                                <div class="tab-content" id="tab-content-8">
                                    <?php comments_template(); ?>
                                </div>

                                <?php if ($pix_show_features_tab) : ?>
                                    <div class="tab-content <?php echo esc_attr($pix_active_features_tab); ?>"
                                         id="tab-content-2">

                                        <?php
                                        $terms = wp_get_post_terms(get_the_ID(), 'auto-equipment', array('fields' => 'ids'));
                                        $args_eq = array('taxonomy' => 'auto-equipment', 'hide_empty' => '0');
                                        $auto_equipment_cat = get_categories($args_eq);
                                        $equip_out = '';
                                        foreach ($auto_equipment_cat as $category) {
                                            if (is_object($category)) {
                                                $t_id = $category->term_id;
                                                $equipment_icon = get_option("auto_equipment_icon_$t_id");
                                                $class_icon_set = $equipment_icon != '' ? 'equipment-icon-set' : '';
                                                if (in_array($category->term_id, $terms)) {
                                                    $feature_icon_true = $equipment_icon != '' ? '<i class="icon ' . esc_attr($equipment_icon) . '"></i>' : '<i class="features-icon">+</i>';
                                                    if(function_exists('pix_autodealer_output_info')){
                                                        $equip_out .= '<li class="pixad-exist ' . esc_attr($class_icon_set) . '">' . pix_autodealer_output_info($feature_icon_true . $category->name) . '</li>';
                                                    }

                                                } elseif ($settings['autos_equipment']) {
                                                    $feature_icon_false = $equipment_icon != '' ? '<i class="icon ' . esc_attr($equipment_icon) . '"></i>' : '<i class="features-icon">-</i>';
                                                    if(function_exists('pix_autodealer_output_info')){
                                                        $equip_out .= '<li class="pixad-none ' . esc_attr($class_icon_set) . '"> ' . pix_autodealer_output_info($feature_icon_false . $category->name) . '</li>';
                                                    }
                                                 }
                                            }
                                        }

                                        if ($equip_out != '')
                                            if(function_exists('pix_autodealer_output_info')){
                                                echo '<ul class="pixad-features-list">' . pix_autodealer_output_info($equip_out) . '</ul>';
                                            }

                                        ?>
                                    </div>
                                <?php endif; ?>


                                <div class="tab-content" id="tab-content-7">
                                    <?php

                                    $custom_settings_quantity = 1;
                                    $max_custom_settings_quantity = 7;
                                    $group_custom_settings_quantity = 1;

                                    while ($group_custom_settings_quantity <= 5): ?>

                                        <?php if ($validate['group_' . $group_custom_settings_quantity . '_show']) : ?>

                                            <div class="tech-group">

                                                <?php if ($validate['custom_' . $custom_settings_quantity . '_show'] && $validate['group_' . $group_custom_settings_quantity . '_title'] && $PIXAD_Autos->get_meta('_custom_' . $custom_settings_quantity . '')): ?>
                                                    <div class="title-subtitle-wrapper">
                                                        <h4 class="title"><i
                                                                    class="<?php echo esc_attr($validate['group_' . $group_custom_settings_quantity . '_icon']); ?>"></i><?php echo esc_attr($validate['group_' . $group_custom_settings_quantity . '_title']); ?>
                                                        </h4>
                                                        <h5 class="subtitle"><?php echo esc_attr($validate['group_' . $group_custom_settings_quantity . '_sub_title']); ?></h5>
                                                        <div class="decor-1"></div>
                                                    </div>
                                                <?php endif; ?>
                                                <dl class="list-descriptions list-unstyled">
                                                    <?php
                                                    while ($custom_settings_quantity <= $max_custom_settings_quantity): ?>
                                                        <?php if ($validate['custom_' . $custom_settings_quantity . '_show'] && $PIXAD_Autos->get_meta('_custom_' . $custom_settings_quantity . '')): ?>
                                                            <div class="dd-item">
                                                                <dt class="left"><?php echo esc_attr($validate['custom_' . $custom_settings_quantity . '_name']); ?></dt>
                                                                <dd class="right"><?php echo esc_attr($PIXAD_Autos->get_meta('_custom_' . $custom_settings_quantity . '')) ?></dd>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php $custom_settings_quantity++; ?>
                                                    <?php endwhile; ?>
                                                </dl>
                                            </div>
                                        <?php

                                        endif;
                                        $group_custom_settings_quantity++;
                                        $max_custom_settings_quantity = $max_custom_settings_quantity + 7;

                                    endwhile;

                                    ?>


                                </div>


                                <?php
                                if ($title_1 != '') {
                                    ?>
                                    <div class="tab-content <?php echo esc_attr($pix_active_title_1); ?>"
                                         id="tab-content-4"><?php echo do_shortcode(get_post_meta(get_the_ID(), 'pixad_auto_custom_content_1', true)) ?></div><?php
                                }
                                if ($title_2 != '') {
                                    ?>
                                    <div class="tab-content <?php echo esc_attr($pix_active_title_2); ?>"
                                         id="tab-content-5"><?php echo do_shortcode(get_post_meta(get_the_ID(), 'pixad_auto_custom_content_2', true)) ?></div><?php
                                }
                                if ($title_3 != '') {
                                    ?>
                                    <div class="tab-content <?php echo esc_attr($pix_active_title_3); ?>"
                                         id="tab-content-6"><?php echo do_shortcode(get_post_meta(get_the_ID(), 'pixad_auto_custom_content_3', true)) ?></div><?php
                                }

                                ?>

                                <?php if ($pix_show_contacts_tab) : ?>
                                    <div class="tab-content <?php echo esc_attr($pix_active_contacts_tab); ?>"
                                         id="tab-content-3">
                                        <div class="rtd auto_contact_desc">
                                            <?php
                                            echo get_post_meta(get_the_ID(), 'pixad_auto_contact', true);
                                            ?>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <dl class="list-descriptions list-unstyled contact-list-info">
                                                    <?php if ($validate['first-name_show'] && $PIXAD_Autos->get_meta('_seller_first_name')) { ?>
                                                        <div class="dd-item">
                                                            <dt class="left fl-font-style-bolt-two"><?php esc_html_e('First Name:', 'autlines'); ?></dt>
                                                            <dd class="right"><?php echo esc_attr($PIXAD_Autos->get_meta('_seller_first_name')) ?></dd>
                                                        </div>
                                                    <?php } elseif ($validate['first-name_show'] && $validate['first-name_def']) { ?>
                                                        <div class="dd-item">
                                                            <dt class="left"><?php esc_html_e('First Name:', 'autlines'); ?></dt>
                                                            <dd class="right"><?php echo esc_attr($validate['first-name_def']); ?></dd>
                                                        </div>
                                                    <?php } else {
                                                    }
                                                    ?>

                                                    <?php if ($validate['last-name_show'] && $PIXAD_Autos->get_meta('_seller_last_name')) { ?>
                                                        <div class="dd-item">
                                                            <dt class="left fl-font-style-bolt-two"><?php esc_html_e('Last Name:', 'autlines'); ?></dt>
                                                            <dd class="right"><?php echo esc_attr($PIXAD_Autos->get_meta('_seller_last_name')) ?></dd>
                                                        </div>
                                                    <?php } elseif ($validate['last-name_show'] && $validate['last-name_def']) { ?>
                                                        <div class="dd-item">
                                                            <dt class="left"><?php esc_html_e('Last Name:', 'autlines'); ?></dt>
                                                            <dd class="right"><?php echo esc_attr($validate['last-name_def']); ?></dd>
                                                        </div>
                                                    <?php } else {
                                                    }
                                                    ?>

                                                    <?php if ($validate['seller-company_show'] && $PIXAD_Autos->get_meta('_seller_company')) { ?>
                                                        <div class="dd-item">
                                                            <dt class="left fl-font-style-bolt-two"><?php esc_html_e('Company:', 'autlines'); ?></dt>
                                                            <dd class="right"><?php echo esc_attr($PIXAD_Autos->get_meta('_seller_company')) ?></dd>
                                                        </div>
                                                    <?php } elseif ($validate['seller-company_show'] && $validate['seller-company_def']) { ?>
                                                        <div class="dd-item">
                                                            <dt class="left"><?php esc_html_e('Company:', 'autlines'); ?></dt>
                                                            <dd class="right"><?php echo esc_attr($validate['seller-company_def']); ?></dd>
                                                        </div>
                                                    <?php } else {
                                                    }
                                                    ?>

                                                    <?php if ($validate['seller-phone_show'] && $PIXAD_Autos->get_meta('_seller_phone')) { ?>
                                                        <div class="dd-item">
                                                            <dt class="left fl-font-style-bolt-two"><?php esc_html_e('Phone:', 'autlines'); ?></dt>
                                                            <dd class="right"><?php echo esc_attr($PIXAD_Autos->get_meta('_seller_phone')) ?></dd>
                                                        </div>
                                                    <?php } elseif ($validate['seller-phone_show'] && $validate['seller-phone_def']) { ?>
                                                        <div class="dd-item">
                                                            <dt class="left fl-font-style-bolt-two"><?php esc_html_e('Phone:', 'autlines'); ?></dt>
                                                            <dd class="right"><?php echo esc_attr($validate['seller-phone_def']); ?></dd>
                                                        </div>
                                                    <?php } else {
                                                    }
                                                    ?>

                                                    <?php if ($PIXAD_Autos->get_meta('_seller_email')) { ?>
                                                        <div class="dd-item">
                                                            <dt class="left fl-font-style-bolt-two"><?php esc_html_e('Email:', 'autlines'); ?></dt>
                                                            <dd class="right"><?php echo esc_attr($PIXAD_Autos->get_meta('_seller_email')) ?></dd>
                                                        </div>
                                                    <?php } elseif ($validate['seller-email_def']) { ?>
                                                        <div class="dd-item">
                                                            <dt class="left fl-font-style-bolt-two"><?php esc_html_e('Email:', 'autlines'); ?></dt>
                                                            <dd class="right"><?php echo esc_attr($validate['seller-email_def']); ?></dd>
                                                        </div>
                                                    <?php } else {
                                                    }
                                                    ?>

                                                    <?php if ($validate['seller-country_show'] && $PIXAD_Autos->get_meta('_seller_country')) { ?>
                                                        <div class="dd-item">
                                                            <dt class="left fl-font-style-bolt-two"><?php esc_html_e('Country:', 'autlines'); ?></dt>
                                                            <dd class="right"><?php echo esc_attr($PIXAD_Autos->get_meta('_seller_country')) ?></dd>
                                                        </div>
                                                    <?php } elseif ($validate['seller-country_def']) { ?>
                                                        <div class="dd-item">
                                                            <dt class="left fl-font-style-bolt-two"><?php esc_html_e('Country:', 'autlines'); ?></dt>
                                                            <dd class="right"><?php echo esc_attr($validate['seller-country_def']); ?></dd>
                                                        </div>
                                                    <?php } else {
                                                    }
                                                    ?>

                                                    <?php if ($validate['seller-state_show'] && $PIXAD_Autos->get_meta('_seller_state')) { ?>
                                                        <div class="dd-item">
                                                            <dt class="left fl-font-style-bolt-two"><?php esc_html_e('State:', 'autlines'); ?></dt>
                                                            <dd class="right"><?php echo esc_attr($PIXAD_Autos->get_meta('_seller_state')) ?></dd>
                                                        </div>
                                                    <?php } elseif ($validate['seller-state_def']) { ?>
                                                        <div class="dd-item">
                                                            <dt class="left"><?php esc_html_e('State:', 'autlines'); ?></dt>
                                                            <dd class="right"><?php echo esc_attr($validate['seller-state_def']); ?></dd>
                                                        </div>
                                                    <?php } else {
                                                    }
                                                    ?>

                                                    <?php if ($validate['seller-town_show'] && $PIXAD_Autos->get_meta('_seller_town')) { ?>
                                                        <div class="dd-item">
                                                            <dt class="left fl-font-style-bolt-two"><?php esc_html_e('Town:', 'autlines'); ?></dt>
                                                            <dd class="right"><?php echo esc_attr($PIXAD_Autos->get_meta('_seller_town')) ?></dd>
                                                        </div>
                                                    <?php } elseif ($validate['seller-town_def']) { ?>
                                                        <div class="dd-item">
                                                            <dt class="left fl-font-style-bolt-two"><?php esc_html_e('Town:', 'autlines'); ?></dt>
                                                            <dd class="right"><?php echo esc_attr($validate['seller-town_def']); ?></dd>
                                                        </div>
                                                    <?php } else {
                                                    }
                                                    ?>

                                                </dl>
                                            </div>
                                            <div class="col-md-8">

                                                <?php
                                                $map_wrapper_attributes[] = "";
                                                if ($PIXAD_Autos->get_meta('_seller_location_lat') && $PIXAD_Autos->get_meta('_seller_location_long')) {
                                                    $local_location = true;
                                                } elseif ($validate['seller-location-lat_def'] && $validate['seller-location-long_def']) {
                                                    $global_location = true;
                                                }

                                                //$wrapper_attributes[] = 'data-map-piker-image"'.$animation.'"';

                                                if($local_location) {
                                                    $wrapper_attributes[] = 'data-location-lat="'.$PIXAD_Autos->get_meta('_seller_location_lat').'"';
                                                    $wrapper_attributes[] = 'data-location-long="'.$PIXAD_Autos->get_meta('_seller_location_long').'"';
                                                }elseif ($global_location) {
                                                    $wrapper_attributes[] = 'data-location-lat="'.$validate['seller-location-lat_def'].'"';
                                                    $wrapper_attributes[] = 'data-location-long="'.$validate['seller-location-long_def'].'"';
                                                }?>

                                                <?php if ($local_location || $global_location) :
                                                    wp_print_scripts( 'google-maps-api' );
                                                    wp_print_scripts( 'gmap3' );

                                                    ?>
                                                    <div id="contact-map" <?php echo implode( ' ', $wrapper_attributes ) ;?>></div>
                                                <?php endif; ?>
                                            </div>
                                        </div> <!-- END ROW -->


                                    </div>
                                <?php endif; ?>
                            </div>

                        </article>


                        <!-- Modal -->
                        <div class="modal fade" id="single-pixad-booking-modal" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">

                                    <div class="modal-body">


                                        <div id="booking_car_form">
                                            <?php do_action('autlines_end_auto', $post); ?>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- END Modal -->


                    </main>
                <?php
                    // End the loop.
                endwhile;
                ?>
            </div>
            <?php if ($layout == 'right'):
                get_template_part('single', 'pixad-autos-sidebar');
            endif; ?>
        </div>
    </div>
</div>

<!--Padding Bottom Start-->
<?php if (autlines_get_theme_mod('page_padding_bottom', true) != 'disable') { ?>
    <div class="fl-page-padding bottom"></div>
<?php } ?>
<!--Padding Bottom End-->
<?php get_footer(); ?>


