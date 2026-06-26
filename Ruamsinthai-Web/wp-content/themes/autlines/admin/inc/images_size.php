<?php

/**
 * Initialize Theme Support Features
 */
function autlines_init_theme_support() {
    if (function_exists('autlines_get_images_sizes')) {
        foreach (autlines_get_images_sizes() as $post_type => $sizes) {
            foreach ($sizes as $config) {
                autlines_add_image_size($post_type, $config);
            }
        }
    }
}
add_action('init', 'autlines_init_theme_support');

/**
 * Add custom image size wrapper
 * @param string $post_type
 * @param array $config
 */
function autlines_add_image_size($post_type, $config) {
    add_image_size($config['name'], $config['width'], $config['height'], $config['crop']);
}



// THIS INCLUDES THE THUMBNAIL IN OUR RSS FEED
function autlines_insert_feed_image($content) {
    global $post;

    if ( has_post_thumbnail( $post->ID ) ){
        $content = ' ' . get_the_post_thumbnail( $post->ID, 'medium' ) . " " . $content;
    }
    return $content;
}

add_filter('the_excerpt_rss', 'autlines_insert_feed_image');
add_filter('the_content_rss', 'autlines_insert_feed_image');