<?php get_header();
//Header
$header = 'enable';
if (autlines_get_theme_mod('post_single_header_custom_style', true) == 'custom') {
    $header = autlines_get_theme_mod('post_single_header', true);
}
if ($header != 'disable') {
    get_template_part('template-parts/header/header_content');
}

if(autlines_get_theme_mod('post_style', true) != ''){
    $post_style = autlines_get_theme_mod('post_style', true);
} else{
    $post_style = 'one';
}

?>
<!--Post Style Start-->
<?php get_template_part('template-parts/blog-single-template/blog-single-style', ''.$post_style.''); ?>
<!--Post Style End-->

<!--Footer Start-->
<?php get_footer(); ?>
<!--Footer End-->
