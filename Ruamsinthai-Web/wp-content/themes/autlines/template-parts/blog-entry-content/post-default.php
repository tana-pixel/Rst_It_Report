<?php
$sidebar_float='disable';
if ( is_active_sidebar( 'main-sidebar' ) and autlines_get_theme_mod('blog_archive_sidebar_position') !='disable' ) {
    $sidebar_float = autlines_get_theme_mod('blog_archive_sidebar_position');
}
$excerpt = autlines_get_theme_mod('custom_blog_excerpt_count');


$archive_year  = get_the_time('Y');
$archive_month = get_the_time('m');
$archive_day   = get_the_time('d');
?>

<article <?php post_class('fl-post--item') ?> id="post-<?php the_ID() ?>" data-post-id="<?php the_ID() ?>">
    <?php if (has_post_thumbnail()) { ?>
    <div class="post-top-content">
        <div class="post--holder">
            <div class="post-info-category fl-font-style-semi-bolt">
                <!--Category -->
                <div class="category-post">
                    <?php the_category('<span class="category-delimiter"> </span> ', '') ;?>
                </div>
                <!--Category end-->
            </div>
            <?php echo get_the_post_thumbnail(get_the_ID(), 'autlines_size_945x450_crop'); ?>
            <a class="image-post-link" href="<?php esc_url(the_permalink()); ?>">
                <span class="link-decor"></span>
                <span class="link-decor"></span>
                <span class="link-decor"></span>
            </a>
        </div>
    </div>
    <?php } ?>
<div class="post-bottom-content">
    <div class="post-info">
            <!--Author -->
            <div class="author-post-content">
                <span class="author-avatar"><?php echo get_avatar( get_the_author_meta( 'ID' ), 35 );?></span>
                <span class="author-prefix"><?php echo esc_html__('By','autlines');?></span>
                <span class="author-link fl-secondary-color-hv">
                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))) ?>"><?php echo esc_html(get_the_author()); ?></a>
                </span>
            </div>
            <!--Author end-->
            <!--Date -->
            <div class="post-date-content">
                <a class="fl-secondary-color-hv" href="<?php echo esc_url(get_day_link( $archive_year, $archive_month, $archive_day)); ?>"><?php echo esc_attr(get_the_date());?></a>
            </div>
            <!--Date end-->
            <!-- Comments -->
            <?php if ( !post_password_required() and comments_open() ) {?>
            <div class="post-comments-content">
                <a class="comments-post fl-secondary-color-hv" href="<?php echo get_comments_link(); ?>" title="<?php esc_attr_e('Comments','autlines')?>">
                    <i class="fa fa-comment-o" aria-hidden="true"></i>
                    <span class="comment-count"><?php echo comments_number('Comments 0', 'Comment 1', 'Comments %'); ?></span>
                </a>
            </div>
            <?php } ?>
            <!-- Comments End-->
        </div>
    <h5 class="post--title">
        <a class="title-link fl-primary-color-hv"
           href="<?php esc_url(the_permalink()); ?>">
            <?php esc_attr(the_title()); ?>
        </a>
    </h5>


    <div class="post-text--content fl-font-style-regular">
        <?php echo autlines_limit_excerpt($excerpt); ?>
    </div>

    <div class="post-btn-read-more fl-font-style-bolt-two">
        <a class="post-link default-btn" href="<?php the_permalink(); ?>">
            <?php echo esc_html__('Read More', 'autlines') ?>
        </a>
    </div>
</div>
</article>
<!--Post End-->