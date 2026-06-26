<?php

    $fl_pagination_style = autlines_get_theme_mod('blog_pagination');

    if($fl_pagination_style == 'loadmore') {
        $test_align = 'text-center';
    } else {
        $test_align = 'text-left';
    }

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    if(autlines_show_posts_nav()) { ?>
        <div class="fl-blog-post-pagination <?php echo esc_attr($test_align);?>">
            <?php  if($fl_pagination_style == 'loadmore') {
                echo autlines_ajax_pagination();
            } else { ?>
                <div class="pagination fl-default-pagination cf">
                    <?php autlines_page_links(); ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

