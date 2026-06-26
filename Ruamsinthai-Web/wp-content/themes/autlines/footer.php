<footer class="fl--footer fl-dark-bg">
    <?php if( class_exists('Fl_Helping_Addons')){ ?>
    <div class="top-content-footer">
        <?php if (autlines_get_theme_mod( 'footer_decor_image')){ ?>
        <div class="footer__figure">
                <img src="<?php echo esc_url(autlines_get_theme_mod( 'footer_decor_image')); ?>" alt="<?php esc_attr_e('Footer Decor Image','autlines')?>"/>
        </div>
        <?php } ?>
        <div class="footer__decor"></div>
                <?php if(is_active_sidebar( 'footer-sidebar-1' ) ||  is_active_sidebar( 'footer-sidebar-2' ) ||  is_active_sidebar( 'footer-sidebar-3' ) || is_active_sidebar( 'footer-sidebar-4' )) { ?>
                    <div class="container">
                        <div class="row footer-sidebar-wrapper">
                            <div class="footer-widget-area col-lg-3 col-md-6">
                                <?php if ( is_active_sidebar( 'footer-sidebar-1' ) ) {
                                    dynamic_sidebar( 'footer-sidebar-1' );
                                } ?>
                            </div>
                            <div class="footer-widget-area col-lg-3 col-md-6">
                                <?php if ( is_active_sidebar( 'footer-sidebar-2' ) ) {
                                    dynamic_sidebar( 'footer-sidebar-2' );
                                } ?>
                            </div>
                            <div class="footer-widget-area col-lg-3 col-md-6">
                                <?php if ( is_active_sidebar( 'footer-sidebar-3' ) ) {
                                    dynamic_sidebar( 'footer-sidebar-3' );
                                } ?>
                            </div>
                            <div class="footer-widget-area col-lg-3 col-md-6">
                                <?php if ( is_active_sidebar( 'footer-sidebar-4' ) ) {
                                    dynamic_sidebar( 'footer-sidebar-4' );
                                } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
    </div>
    <?php } ?>
        <div class="bottom-content-footer">
                <div class="container">
                    <div class="row">
                        <div class="fl-copyright--inner col-12 text-center">
                            <?php if(autlines_get_theme_mod('footer_copyrights')){
                                echo esc_html(autlines_get_theme_mod('footer_copyrights'));
                            }?>
                        </div>
                    </div>
                </div>
        </div>
</footer>

<!-- Search form Full Width start -->
 <?php get_template_part('template-parts/footer/footer-component/content','search'); ?>
<!-- Search form Full Width end -->
<!-- Hamburger menu start -->
<?php get_template_part('template-parts/footer/footer-component/content','mobile-menu'); ?>
<!-- Hamburger menu end -->


<!-- Login Form -->
<!-- Login form start -->
<?php if( class_exists('Fl_Helping_Addons')){ ?>
    <?php get_template_part('template-parts/footer/footer-component/content','login');?>
<?php } ?>
<!-- Login form end -->
<?php get_template_part('template-parts/footer/footer-component/mobile-menu'); ?>
<!-- Login Form end -->
</div>
<!-- Main holder End-->
<?php wp_footer(); ?>
</body>
</html>