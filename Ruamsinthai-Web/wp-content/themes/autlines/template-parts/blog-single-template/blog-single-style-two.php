<?php
$decor_bg = $bg_image='';


$bg_image_holder = autlines_get_theme_mod('background_holder',true);
if(isset($bg_image_holder) && $bg_image_holder !='') {
    $bg_image =   'background-image:url('.$bg_image_holder.');';
}

$decor_image = '';

$css_style = ( $decor_bg ) ? 'style=' . $decor_bg . '' : '';


$bg_style= ( $bg_image ) ? 'style=' . $bg_image . '' : '';
?>
<!-- Content -->
    <div class="fl-blog-post-div bg-holder" <?php echo esc_attr($css_style);?>>
        <div class="bg-holder-after" <?php echo esc_attr($bg_style);?>></div>
        <div class="single-post-wrapper">
            <!-- Top Content -->
            <div class="post-content-top">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="container">
                    <div class="row">
                        <article <?php post_class('col-12 cf'); ?> id="post-<?php the_ID()?>" data-post-id="<?php the_ID()?>">

                        <div class="post-holder--info col-xl-10 offset-xl-1">
                            <?php if (has_post_thumbnail()) { ?>
                                <div class="post-holder">
                                    <?php echo get_the_post_thumbnail(get_the_ID(), 'autlines_size_945x450_crop'); ?>
                                    <div class="holder-decor"></div>
                                </div>
                            <?php } ?>
                            <div class="post-info fl-font-style-regular-two">
                                <?php get_template_part('template-parts/blog-entry-content/post','info');?>
                                <?php get_template_part('template-parts/blog-entry-content/post','share');?>
                            </div>
                        </div>
                        <div class="inner_content cf">
                            <?php the_content(); ?>
                        </div>

                        <?php wp_link_pages(array(
                            'before'        => '<p class="post-inner-pagination">'.'<span class="pagination-text">' . esc_html__('Post Pages:', 'autlines').'</span>',
                            'after'	        => '</p>',
                            'link_before'   => '',
                            'link_after'    => '',
                            'pagelink'      => '<span class="page-numbers">'.'%'.'</span>',

                        )) ?>

                    </article><!-- #post-<?php the_ID(); ?> -->
                    </div>
                </div>
                <?php endwhile; else: ?>
                    <?php get_template_part('template-parts/content', 'none')?>
                <?php endif; ?>
            </div>
            <!-- Top Content End-->
            <div class="post-category--tags style-two">
                <div class="container">
                    <div class="row">
                        <!-- Tags And Category -->
                        <?php get_template_part('template-parts/blog-entry-content/post', 'category'); ?>
                        <?php get_template_part('template-parts/blog-entry-content/post', 'tags'); ?>
                        <!-- Tags And Category End-->
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <!-- Bottom Content -->
                    <div class="post-content-bottom col-md-12">
                        <?php if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif; ?>
                    </div>
                    <!-- Bottom Content End -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content End-->
<!--Padding bottom Start-->
<?php if (autlines_get_theme_mod('post_single_padding_bottom',true) != 'false') { ?>
    <div class="fl-page-padding bottom"></div>
<?php } ?>
<!--Padding bottom End-->
