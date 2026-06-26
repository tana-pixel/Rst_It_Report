<?php
//Navigator class
$navigation_css_class = '';
$button_link = '#';
$css_classes[] = 'fl-header--navigation';
// Phone text
$login_icon = autlines_get_theme_mod('menu_login_icon');
// Search icon
$search_icon = autlines_get_theme_mod('menu_search_icon');
// Hamburger menu
$header_button  = autlines_get_theme_mod('button_header');
$button_text = autlines_get_theme_mod('button_text');
if(!empty(autlines_get_theme_mod('button_link'))){
    $button_link = autlines_get_theme_mod('button_link');
}

// Fixed Nav Bar
$fixed_nav_bar = autlines_get_theme_mod('fixed_nav');
if($fixed_nav_bar == 'true'){
    $css_classes[] = 'fixed-navbar';
}
$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );
?>
<!--Header Start-->
<header class="fl--header <?php echo esc_attr($css_class) ; ?> cf" id="fl-header">
    <?php if( class_exists('Fl_Helping_Addons')){ ?>
    <div class="fl-top-header-content fl-font-style-regular">
         <div class="info-container">
             <div class="left-top-header-content">
                 <?php if ( is_active_sidebar( 'header-sidebar-1' ) ) { ?>
                     <div class="header-sidebar">
                         <?php dynamic_sidebar( 'header-sidebar-1' ); ?>
                     </div>
                     <?php } ?>
             </div>
             <?php get_template_part('template-parts/social_profile/social', 'header');?>
         </div>
    </div>
    <?php } ?>

    <div class="fl-bottom-header-content">
          <div class="fl-navigation-container cf">
            <!-- Start Logo-->
            <div class="fl--logo-container">
                <a href="<?php echo esc_url(home_url("/")); ?>">
                    <?php if (autlines_get_theme_mod( 'site_logo')){ ?>
                        <img src="<?php echo esc_url(autlines_get_theme_mod( 'site_logo')); ?>" alt="<?php esc_attr_e('Site Logotype','autlines')?>" class="img-logotype"/>
                    <?php } else { ?>
                        <h3 class="logotype-text"><?php esc_attr(bloginfo('title')); ?></h3>
                    <?php } ?>
                </a>
            </div>
            <!--Logo End-->

            <!-- Nav Menu Start-->
            <nav class="fl-mega-menu nav-menu">
                <?php if ( has_nav_menu( 'general-menu' ) ) {
                    wp_nav_menu(array(
                        'theme_location'    => 'general-menu',
                        'class'             => 'header-menu nav-menu',
                        'container'         => false,
                        'id'                => 'general-menu',
                        'depth'             => 8,
                        'fallback_cb'       => 'autlines_menu_fallback'
                    ));
                }
                ?>
            </nav>
            <!-- Nav Menu End-->
                <div class="fl--navigation-icon-container">
                    <!--Mobile menu bars-->
                    <div class="fl--hamburger-menu closed header-icon">
                        <div class="fl-flipper-icon">
                            <div class="fl-front-content">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <div class="fl-back-content">
                                <span class="fl-custom-icon-plus-symbol"></span>
                            </div>
                        </div>
                    </div>
                    <!--Mobile menu bars end-->
                    <?php if($login_icon =='enable') { ?>
                      <!--Login -->
                          <div class="header-login header-icon">
                              <?php get_template_part('template-parts/navigation/header_components/content','login-and-register') ;?>
                          </div>
                      <!--Login End-->
                    <?php } ?>
                    <?php if($search_icon =='enable') { ?>
                        <!--Search -->
                    <div class="header-search header-icon">
                        <div class="fl-flipper-icon">
                            <div class="fl-front-content">
                                <i class="ic icon-magnifier"></i>
                            </div>
                            <div class="fl-back-content">
                                <span class="fl-custom-icon-plus-symbol"></span>
                            </div>
                        </div>
                    </div>
                        <!--Search End-->
                    <?php } ?>
                    <!--WPML Language Swicher -->
                    <?php get_template_part('template-parts/navigation/header_components/wpml-language-switch');?>
                    <!--WPML Language end -->
                    <?php if($header_button =='enable') { ?>
                        <!--Header Button -->
                            <div class="header-btn fl-font-style-bolt-two fl-secondary-bg ">
                               <a class="default-btn" href="<?php echo esc_url($button_link);?>"><?php echo esc_attr($button_text) ;?></a>
                            </div>
                        <!--Header Button End-->
                    <?php } ?>

                    <!--Header Button -->

                </div>
        </div>
     </div>
</header>
<?php if($fixed_nav_bar == 'true'){?>
    <div class="header-padding"></div>
<?php }?>
<!--Header End-->