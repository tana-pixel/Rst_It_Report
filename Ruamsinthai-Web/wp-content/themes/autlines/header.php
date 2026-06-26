<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<!DOCTYPE html>

<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    
    
    <?php 

if (function_exists('wp_body_open')) {
    wp_body_open();
}

if (function_exists('templines_page_loader')) {
    templines_page_loader();
}
?>
    
<?php
if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}?>
<!-- Main holder -->
<div id="fl-main-holder">
<?php get_template_part('template-parts/preloader/preloader');
      get_template_part('template-parts/navigation/navigator_content');
?>