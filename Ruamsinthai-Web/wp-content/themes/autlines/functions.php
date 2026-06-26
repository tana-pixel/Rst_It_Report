<?php
/****************************************************************
 * DO NOT DELETE
 ****************************************************************/

// include system functions
if (!isset($content_width)) $content_width = 1140;


/**
 * Load Theme Variable Data
 * @param string $var
 * @return string
 */
function autlines_theme_data_variable($var) {
    if (!is_file(STYLESHEETPATH . '/style.css')) {
        return '';
    }

    $theme_data = wp_get_theme();
    return $theme_data->{$var};
}
/****************************************************************
 * Define Constants
 ****************************************************************/

define("AUTLINES_THEME_URL", get_template_directory_uri());
define('AUTLINES_THEME_VERSION', autlines_theme_data_variable('Version'));

/****************************************************************
 * Require Needed Files & Libraries
 ****************************************************************/
/**
 * Admin References & CSS and JS files register
 */
require  get_template_directory() .'/admin/admin.php';
/**
 * General
 */
require get_template_directory() .'/admin/etc/general.php';
/**
 * Preloader
 */
require get_template_directory() .'/admin/etc/preloader-style.php';
/**
 * Register Sidebar
 */
require get_template_directory() .'/admin/option/sidebar.php';
/**
 * Woocommerce register plugin
 */
require get_template_directory() .'/admin/function/woocommerce.php';
/**
 * Load More
 */
require get_template_directory() .'/admin/etc/load_more_function.php';
/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() .'/admin/inc/extras.php';
/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() .'/admin/inc/jetpack.php';
/**
 * Comments walker
 */
require get_template_directory() .'/admin/inc/comments-walker.php';

/**
 * Mega Menu
 */
require get_template_directory() .'/admin/menu/menu.php';
/**
 * Autos Options
 */
require get_template_directory() .'/admin/autos_function.php';
/**
 * About Theme Option
 */
require get_template_directory() .'/admin/theme-dashboard/dashboard.php';

/**
 * Remove 'sizes' attribute from images
 */
function autlines_remove_sizes_attribute($attr) {
    // Remove sizes attribute completely
    if (isset($attr['sizes'])) {
        if ($attr['sizes'] === 'auto' || strpos($attr['sizes'], 'auto,') === 0) {
            unset($attr['sizes']);
        }
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'autlines_remove_sizes_attribute', 10, 1);

/**
 * Remove sizes attribute from post thumbnails and other images
 */
function autlines_filter_post_thumbnail_html($html) {
    // Use regex to remove sizes attribute with auto value
    $pattern = '/\\s+sizes=(["\'])auto(,\\s+.*?)?\\1/i';
    $html = preg_replace($pattern, '', $html);
    return $html;
}
add_filter('post_thumbnail_html', 'autlines_filter_post_thumbnail_html', 10, 1);
add_filter('the_content', 'autlines_filter_post_thumbnail_html', 10, 1);

