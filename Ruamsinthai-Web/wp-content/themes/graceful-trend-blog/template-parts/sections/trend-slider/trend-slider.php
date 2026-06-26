<?php
/**
 * Template part for Trend Slider - Owl Carousel displaying 3 latest posts
 *
 * @package Graceful Trend Blog
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Check if Trend Slider is enabled
if ( ! graceful_trend_blog_options( 'trend_slider_show' ) ) {
    return;
}

/**
 * Query for the 3 latest published posts
 * Optimized for performance with minimal cache usage
 */
$graceful_trend_posts = new WP_Query( array(
    'posts_per_page'         => 3,
    'post_status'            => 'publish',
    'orderby'                => 'date',
    'order'                  => 'DESC',
    'no_found_rows'          => true, // Performance optimization
    'cache_results'          => true,
    'update_post_meta_cache' => false, // Performance optimization
    'update_post_term_cache' => false, // Performance optimization
    'ignore_sticky_posts'    => true, // Ignore sticky posts for consistent results
) );

// Check if we have posts to display
if ( ! $graceful_trend_posts->have_posts() ) {
    ?>
    <div class="graceful-trend-slider-wrapper">
        <div class="graceful-trend-slider-error" role="alert" style="text-align: center; padding: 40px; color: #666; font-style: italic;">
            <?php esc_html_e( 'No blog posts available to display in the slider.', 'graceful-trend-blog' ); ?>
        </div>
    </div>
    <?php
    return;
}

// Get customizer options
$show_arrows = graceful_trend_blog_options( 'trend_slider_arrows_show' );
$show_dots = graceful_trend_blog_options( 'trend_slider_dots_show' );
$accent_color = graceful_trend_blog_options( 'trend_slider_accent_color' );

// Calculate hover color (darker version of accent color)
$accent_rgb = sscanf( $accent_color, "#%02x%02x%02x" );
$hover_color = sprintf( "#%02x%02x%02x", 
    max( 0, $accent_rgb[0] - 30 ), 
    max( 0, $accent_rgb[1] - 30 ), 
    max( 0, $accent_rgb[2] - 30 ) 
);

wp_enqueue_script( 
    'trend-slider', 
    get_stylesheet_directory_uri() . '/assets/js/trend-slider.js',
    array( 'jquery' ), // Dependencies: jQuery (Owl Carousel loaded by parent theme)
    wp_get_theme()->get('Version'),
    true
);

// Pass customizer options to JavaScript
wp_localize_script( 'trend-slider', 'trendSliderOptions', array(
    'showArrows' => $show_arrows,
    'showDots' => $show_dots,
) );
?>

<!-- Dynamic CSS Variables for Customizer Colors -->
<style>
:root {
    --trend-slider-accent: <?php echo esc_attr( $accent_color ); ?>;
    --trend-slider-hover: <?php echo esc_attr( $hover_color ); ?>;
    --trend-slider-accent-shadow: <?php echo esc_attr( $accent_color ); ?>4D; /* 30% opacity */
    --trend-slider-accent-shadow-hover: <?php echo esc_attr( $accent_color ); ?>66; /* 40% opacity */
}

<?php if ( ! $show_arrows ) : ?>
/* Hide navigation arrows when disabled in customizer */
.graceful-trend-slider .owl-nav {
    display: none !important;
}
<?php endif; ?>

<?php if ( ! $show_dots ) : ?>
/* Hide pagination dots when disabled in customizer */
.graceful-trend-slider .owl-dots {
    display: none !important;
}
<?php endif; ?>
</style>

<div class="graceful-trend-slider-wrapper">
    <a href="#graceful-trend-slider-end" class="graceful-trend-sr-only graceful-trend-skip-link">
        <?php esc_html_e( 'Skip carousel', 'graceful-trend-blog' ); ?>
    </a>
    <div class="graceful-trend-slider owl-carousel owl-theme" 
         role="region" 
         aria-label="<?php esc_attr_e( 'Latest blog posts carousel', 'graceful-trend-blog' ); ?>"
         tabindex="0">
        <?php
        while ( $graceful_trend_posts->have_posts() ) :
            $graceful_trend_posts->the_post();
            
            // Get post data (raw, will be escaped at output)
            $graceful_post_id = absint( get_the_ID() );
            $post_title = wp_strip_all_tags( get_the_title() );
            $post_excerpt = wp_strip_all_tags( get_the_excerpt() );
            $post_permalink = get_the_permalink();
            $featured_image_url = get_the_post_thumbnail_url( $graceful_post_id, 'large' );
            $has_thumbnail = has_post_thumbnail();
            ?>
            
            <div class="graceful-trend-slide-item" role="group" aria-label="<?php 
                /* translators: 1: slide number, 2: post title */
                echo esc_attr( sprintf( __( 'Slide %1$d: %2$s', 'graceful-trend-blog' ), $graceful_trend_posts->current_post + 1, $post_title ) ); ?>">
                <?php if ( $has_thumbnail && $featured_image_url ) : ?>
                    <div class="graceful-trend-slide-image">
                        <img src="<?php echo esc_url( $featured_image_url ); ?>" 
                             alt="<?php 
                             /* translators: %s: post title */
                             echo esc_attr( sprintf( __( 'Featured image for %1$s', 'graceful-trend-blog' ), $post_title ) ); ?>"
                             loading="lazy">
                    </div>
                <?php endif; ?>
                
                <div class="graceful-trend-slide-content">
                    <h3 class="graceful-trend-slide-title">
                        <a href="<?php echo esc_url( $post_permalink ); ?>"
                           aria-label="<?php 
                           /* translators: %s: post title */
                           echo esc_attr( sprintf( __( 'Read full article: %1$s', 'graceful-trend-blog' ), $post_title ) ); ?>">
                            <?php echo esc_html( $post_title ); ?>
                        </a>
                    </h3>
                    
                    <?php if ( ! empty( $post_excerpt ) ) : ?>
                        <div class="graceful-trend-slide-excerpt">
                            <?php echo esc_html( wp_trim_words( $post_excerpt, 12, '...' ) ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <a href="<?php echo esc_url( $post_permalink ); ?>" 
                       class="graceful-trend-read-more"
                       aria-label="<?php 
                       /* translators: %s: post title */
                       echo esc_attr( sprintf( __( 'Read more about %1$s', 'graceful-trend-blog' ), $post_title ) ); ?>">
                        <?php esc_html_e( 'READ MORE', 'graceful-trend-blog' ); ?>
                    </a>
                </div>
            </div>
            
        <?php endwhile; ?>
    </div>
    <div id="graceful-trend-slider-end" class="graceful-trend-sr-only" tabindex="-1">
        <?php esc_html_e( 'End of carousel', 'graceful-trend-blog' ); ?>
    </div>
</div>

<?php
// Clean up global $post object
wp_reset_postdata();
?>