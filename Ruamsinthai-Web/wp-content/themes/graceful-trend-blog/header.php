<?php
/**
 * The header for our theme
 *
 * This is the template that displays the <head> section, Header and Navigation
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Graceful Trend Blog
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

	<?php
	if ( graceful_options( 'basic_header_width' ) === 'wrapped' ) {
	    $graceful_header_width = 'class=wrapped-content';
	} else {
	    $graceful_header_width = '';
	}
	if ( graceful_options( 'basic_content_width' ) === 'wrapped' ) {
	    $graceful_content_width = 'wrapped-content';
	} else {
	    $graceful_content_width = '';
	}
	if ( has_header_image() ) {
	?>
    <style>
    	.graceful-trend-overlay {
		    background: rgba(0, 0, 0, 0.3);
		    position: absolute;
		    top: 0;
		    left: 0;
		    width: 100%;
		    height: 100%;
		}		
		.site-branding a {
		    position: relative;
		    z-index: 0;
		    color: #ffffff;
		    font-weight: 700;
		}
		.site-description {
		    position: relative;
		    z-index: 0;
		    color: #ffffff;
		}
    </style>
    <?php
	}
	
	?>

	<?php // Site Loading Animation
	get_template_part('template-parts/sections/site', 'loadinganim'); 
	?>

	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'graceful-trend-blog' ); ?></a>	

	<div id="site-container">
		<div id="site-header" <?php echo esc_attr( $graceful_header_width ); ?>>
		<?php
		get_template_part( 'template-parts/header/main', 'navigation' );
		get_template_part( 'template-parts/header/site', 'header' );
		
		
		?>
		</div><!-- site-header close -->

		<!-- Page Content -->
		<main id="primary" class="site-main">
		<?php
			if ( is_home() && !is_paged() ) {


				get_template_part('template-parts/sections/trend-slider/trend', 'slider');

				// Show Post Slider if enabled
			    $graceful_post_slider_enabled = graceful_options('post_slider_label');
			    if ( $graceful_post_slider_enabled ) {
			        get_template_part('template-parts/sections/post', 'slider');
			    }

			    // Show Featured Boxes if enabled
			    $graceful_featured_boxes_enabled = graceful_trend_blog_options('featured_boxes_show');
			    if ( $graceful_featured_boxes_enabled ) {
			        get_template_part('template-parts/sections/featured', 'boxes');
			    }

			}
		?>
		<div class="main-content clear-fix <?php echo esc_attr( $graceful_content_width ); ?>" data-layout="<?php echo esc_attr( graceful_page_layout() ); ?>" data-sidebar-sticky="<?php echo esc_attr( graceful_options( 'basic_sidebar_sticky' ) ); ?>">
