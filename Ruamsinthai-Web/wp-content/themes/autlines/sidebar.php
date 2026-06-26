<?php

$sidebar_position = $sticky_sidebar = $page_sidebar_sticky ="";


if(autlines_get_theme_mod('blog_archive_sidebar')!= 'disable'){
    $sidebar_position= autlines_get_theme_mod('blog_archive_sidebar_position');
    $sticky_sidebar = autlines_get_theme_mod('blog_archive_sidebar_sticky');
}



if(is_singular('post')) {
    $sidebar_position= autlines_get_theme_mod('blog_single_sidebar_position');
    $sticky_sidebar = autlines_get_theme_mod('blog_single_sticky');
    if (autlines_get_theme_mod('post_sidebar_custom',true) =='custom'){
        $sidebar_position= autlines_get_theme_mod('post_sidebar_position',true);
        $sticky_sidebar = autlines_get_theme_mod('post_sidebar_sticky',true);
    }
}

if(is_page()) {
    if (autlines_get_theme_mod('page_sidebar_custom',true) =='custom'){
        $sidebar_position= autlines_get_theme_mod('page_sidebar_position',true);
        $sticky_sidebar = autlines_get_theme_mod('page_sidebar_sticky',true);
    }
}

// Template Blog Navigation Style
if(is_page_template( 'template-blog.php' )){
    if(autlines_get_theme_mod('blog_template_sidebar_custom',true) == 'custom'){
        $sidebar_position= autlines_get_theme_mod('blog_template_sidebar_position',true);
        $sticky_sidebar = autlines_get_theme_mod('blog_template_sidebar_sticky',true);
    }
}

if($sidebar_position == 'left'){
    $page_sidebar_position = 'sidebar_left col-md-3';
}else if($sidebar_position== 'right') {
    $page_sidebar_position = 'sidebar_right col-md-3';
}

if($sticky_sidebar == 'sticky'){
    $page_sidebar_sticky = 'sidebar-sticky';
}

?>



<?php if ( is_active_sidebar( 'main-sidebar' ) ) { ?>
 <div class="sidebar-container <?php echo esc_attr($page_sidebar_position); ?> <?php echo esc_attr($page_sidebar_sticky); ?>" >
    <aside class="sidebar cf">
        <div class="sidebar_container">
            <?php dynamic_sidebar( 'main-sidebar' ); ?>
        </div>
    </aside>
 </div>
<?php } ?>


