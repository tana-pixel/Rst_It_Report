<?php
/****************************************************************
 * System Functions
 ****************************************************************/

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
require  AUTLINES_PATH .'/admin.php';
/**
 * General
 */
require AUTLINES_PATH .'/etc/general.php';
/**
 * Preloader
 */
require AUTLINES_PATH .'/etc/preloader-style.php';
/**
 * Register Sidebar
 */
require AUTLINES_PATH .'/option/sidebar.php';
/**
 * Woocommerce register plugin
 */
require AUTLINES_PATH .'/function/woocommerce.php';
/**
 * Load More
 */
require AUTLINES_PATH . '/etc/load_more_function.php';
/**
 * Custom functions that act independently of the theme templates.
 */
require AUTLINES_PATH . '/inc/extras.php';
/**
 * Load Jetpack compatibility file.
 */
require AUTLINES_PATH . '/inc/jetpack.php';
/**
 * Comments walker
 */
require AUTLINES_PATH . '/inc/comments-walker.php';

/**
 * Mega Menu
 */
require AUTLINES_PATH . '/menu/menu.php';
/**
 * Autos Options
 */
require AUTLINES_PATH . '/autos_function.php';

