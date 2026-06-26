<?php
$archive_year  = get_the_time('Y');
$archive_month = get_the_time('m');
$archive_day   = get_the_time('d');

?>

<div class="left-post-top-content">
    <!--Date -->
        <a class="date-post fl-secondary-color-hv" href="<?php echo esc_url(get_day_link( $archive_year, $archive_month, $archive_day)); ?>"><?php echo esc_attr(get_the_date());?></a>
    <!--Date end-->
    <!--Author -->
        <span class="author-prefix"><?php echo esc_html__('By','autlines');?></span>
        <span class="author-link fl-primary-color fl-secondary-color-hv">
            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))) ?>"><?php echo esc_html(get_the_author()); ?></a>
        </span>
    <!--Author end-->
    <?php if ( !post_password_required() and comments_open() ) {?>

        <a class="comments-post fl-secondary-color-hv" href="<?php echo get_comments_link(); ?>" title="<?php esc_attr_e('Comments','autlines')?>">
            <i class="fa fa-comment-o" aria-hidden="true"></i>
            <span class="comment-count"><?php echo comments_number('Comments 0', 'Comment 1', 'Comments %'); ?></span>
        </a>

    <?php } ?>
</div>




