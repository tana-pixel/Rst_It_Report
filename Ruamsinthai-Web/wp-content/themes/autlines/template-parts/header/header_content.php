<?php
global $post;
//Save
$header_bg = $pre_title = $breadcrumbs = $custom_html_title_class = '';

// Heading Background Image
$bg_img = autlines_get_theme_mod('page_background_img');

// Blog page Title
$title = autlines_get_theme_mod('archive_blog_title');
// Blog page Pre Title
$pre_title = autlines_get_theme_mod('archive_blog_pre_title');

// Blog page
if (autlines_is_blog_checker()) {
    if(! empty(autlines_get_theme_mod('blog_archive_page_background_img'))){
        $bg_img = autlines_get_theme_mod('blog_archive_page_background_img');
    }
}
if (is_page()) {
    $title = get_the_title();
    if(autlines_get_theme_mod('page_breadcrumbs',true) == 'custom'){
        $breadcrumbs = autlines_get_theme_mod('page_breadcrumb',true);
    }
    if(autlines_get_theme_mod('page_header_custom_style',true) == 'custom'){
        // Pre Title
        if(!empty(autlines_get_theme_mod('page_header_pre_title',true))){
            $pre_title = autlines_get_theme_mod('page_header_pre_title',true);
        }

        if(autlines_get_theme_mod('page_header_title_enable_function',true) != 'disable'){
            if(!empty(autlines_get_theme_mod('page_custom_title',true))){
                $title = autlines_get_theme_mod('page_custom_title',true);
            }
        } else {
            $title = '';
        }

        if(!empty(autlines_get_theme_mod('page_header_img',true))){
            $bg_img = autlines_get_theme_mod('page_header_img',true);
        }
    }
}


// Single post
if(is_single()){
    $custom_html_title_class = 'post-inner-header';


    $title = get_the_title();


    if(autlines_get_theme_mod('post_single_breadcrumbs',true) == 'custom'){
        $breadcrumbs = autlines_get_theme_mod('post_single_breadcrumb',true);
    }
    if(autlines_get_theme_mod('post_single_header_custom_style',true) == 'custom'){
        // Pre Title
        if(!empty(autlines_get_theme_mod('post_single_header_pre_title',true))){
            $pre_title = autlines_get_theme_mod('post_single_header_pre_title',true);
        }

        if(autlines_get_theme_mod('post_single_header_title_enable_function',true) != 'disable'){
            if(!empty(autlines_get_theme_mod('post_single_custom_title',true))){
                $title = autlines_get_theme_mod('post_single_custom_title',true);
            }
        } else {
            $title = '';
        }

        if(!empty(autlines_get_theme_mod('post_single_header_img',true))){
            $bg_img = autlines_get_theme_mod('post_single_header_img',true);
        }
    }

}
// Single Autos
if(is_singular('pixad-autos')){
    if(! empty(autlines_get_theme_mod('autos_single_page_background_img'))){
        $bg_img = autlines_get_theme_mod('autos_single_page_background_img');
    }
}


if (is_category()) { // Category page
    $title = single_cat_title("", false);
    $pre_title = esc_html__('All posts from:', 'autlines');
} else if (is_author()) { // Author page
    $title = get_the_author();
    $pre_title = esc_html__('All posts from author:', 'autlines');
} else if (is_tag()) { // Tag page
    $title = single_tag_title("", false);
    $pre_title = esc_html__('Tagged to:', 'autlines');
} else if (is_search()) {//search page
    $title = get_search_query();
    $pre_title = esc_html__('Search results for:', 'autlines');
} else if (is_archive()) {
    if (is_day()) :
        $title = sprintf(esc_html__('Daily Archive: %s', 'autlines'), get_the_date());
    elseif (is_month()) :
        $title = sprintf(esc_html__('Monthly Archive: %s', 'autlines'), get_the_date(_x('F Y', 'monthly archives date format', 'autlines')));
    elseif (is_year()) :
        $title = sprintf(esc_html__('Yearly Archive: %s', 'autlines'), get_the_date(_x('Y', 'yearly archives date format', 'autlines')));
    else :
        $title = esc_html__('Archive', 'autlines');
    endif;
}

if ( class_exists('WooCommerce') ) {
    if (is_woocommerce()) {
        if (!empty(autlines_get_theme_mod('woo_images_background_img'))) {
            $bg_img = autlines_get_theme_mod('woo_images_background_img');
        }

            if (!empty(autlines_get_theme_mod('woo_header_pre_title'))) {
                $pre_title = autlines_get_theme_mod('woo_header_pre_title');
            }
            if (!empty(autlines_get_theme_mod('woo_header_title'))) {
                $title = autlines_get_theme_mod('woo_header_title');
            }


        if(is_product_category()){
            $title = single_cat_title("", false);
            $pre_title = esc_html__('All products from','autlines');
        }

    }
    if (is_cart() || is_checkout() || is_account_page()) {
        if (!empty(autlines_get_theme_mod('woo_images_background_img'))) {
            $bg_img = autlines_get_theme_mod('woo_images_background_img');
        }
    }
    if(is_product()){
        $pre_title = '';
        $title = get_the_title();
    }
}


// Header background image css
if (isset($bg_img) && $bg_img != '') {
    $header_bg = 'background-image:url(' . $bg_img . ');';
}


$css_style = ($header_bg) ? 'style=' . $header_bg . '' : '';
?>


<div class="fl-page-heading <?php echo esc_attr($custom_html_title_class)?>" <?php echo esc_attr($css_style); ?>>
    <div class="heading-mask"></div>
    <div class="fl--page-header content_header container">
        <?php if (isset($pre_title) && $pre_title != '') { ?>
            <div class="fl-pre--title-wrapper">
                <span class="fl--sub-title fl-font-style-semi-bolt fl-primary-color"><?php echo esc_attr($pre_title); ?></span>
            </div>
        <?php } ?>
        <?php if (isset($title) && $title != '') { ?>
            <h1 class="header-title fl-font-style-bolt">
                <?php echo esc_attr($title); ?>
            </h1>
        <?php } ?>
        <?php if( class_exists('Fl_Helping_Addons')){
            if (isset($breadcrumbs) && $breadcrumbs != 'disable') { ?>
            <div class="breadcrumbs-heading">
                <?php autlines_build_breadcrumbs(); ?>
            </div>
        <?php }
        }
        ?>

    </div>
    <div class="header-decor fl-primary-bg"></div>
</div>


