<?php
$sidebar_float='disable';
if ( is_active_sidebar( 'main-sidebar' ) and autlines_get_theme_mod('blog_archive_sidebar_position') !='disable' ) {
    $sidebar_float = autlines_get_theme_mod('blog_archive_sidebar_position');
}

if($sidebar_float !='disable'){
    $excerpt = '20';
} else {
    $excerpt = autlines_get_theme_mod('custom_blog_excerpt_count');
}

$archive_year  = get_the_time('Y');
$archive_month = get_the_time('m');
$archive_day   = get_the_time('d');

$left_css_classes []=$right_css_classes[]= '';
if (has_post_thumbnail()) {
    $left_css_classes []= 'col-lg-6';
    $right_css_classes []= 'col-lg-6';
} else{
    $right_css_classes []= 'col-lg-12';
}

$left_css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $left_css_classes ) ) ) );
$right_css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $right_css_classes ) ) ) );
?>

<article <?php post_class('fl-post--item') ?> id="post-<?php the_ID() ?>" data-post-id="<?php the_ID() ?>">
    <?php if (has_post_thumbnail()) { ?>
        <div class="post-left-content <?php echo esc_attr(trim($left_css_class)); ?>">
           <div class="post--holder">
               <?php echo get_the_post_thumbnail(get_the_ID(), 'autlines_size_500x400_crop'); ?>
               <a class="image-post-link" href="<?php esc_url(the_permalink()); ?>">
                   <span class="link-decor"></span>
                   <span class="link-decor"></span>
                   <span class="link-decor"></span>
               </a>
           </div>
        </div>
    <?php } ?>
<div class="post-right-content <?php echo esc_attr(trim($right_css_class)); ?>">
    <!--Category -->
    <div class="category-post fl-font-style-semi-bolt">
        <?php the_category('<span class="category-delimiter"> </span> ', '') ?>
    </div>
    <!--Category end-->
    <h5 class="post--title">
        <a class="title-link fl-primary-color-hv"
           href="<?php esc_url(the_permalink()); ?>">
            <?php esc_attr(the_title()); ?>
        </a>
    </h5>
    <div class="post-info fl-font-style-semi-bolt">
        <!--Date -->
        <div class="date-post">
            <a class="fl-secondary-color-hv" href="<?php echo esc_url(get_day_link( $archive_year, $archive_month, $archive_day)); ?>"><?php echo esc_attr(get_the_date());?></a>
        </div>
        <!--Date end-->
        <!--Author -->
        <div class="author-post">
                <span class="author-prefix"><?php echo esc_html__('By','autlines');?></span>
                <span class="author-link fl-primary-color fl-secondary-color-hv">
                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))) ?>"><?php echo esc_html(get_the_author()); ?></a>
                </span>
        </div>
        <!--Author end-->
    </div>

    <div class="post-text--content fl-font-style-regular">
        <?php echo autlines_limit_excerpt($excerpt); ?>
    </div>

    <div class="post-btn-read-more fl-font-style-bolt-two">
        <a class="post-link" href="<?php the_permalink(); ?>">
            <?php echo esc_html__('Read More', 'autlines') ?>
        </a>
    </div>
</div>
</article>
<!--Post End-->