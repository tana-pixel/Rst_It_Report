<?php if(autlines_get_theme_mod('header_fb') || autlines_get_theme_mod('header_twi')|| autlines_get_theme_mod('header_pin')
        || autlines_get_theme_mod('header_linkedin') || autlines_get_theme_mod('header_yt')|| autlines_get_theme_mod('header_vime')
        || autlines_get_theme_mod('header_gpl') || autlines_get_theme_mod('header_insta')|| autlines_get_theme_mod('header_beh')){?>
<div class="right-top-header-content">
     <ul class="header-social-profile">
        <?php if(autlines_get_theme_mod('header_fb')){ ?>
            <li>
            <a class="fl_footer_social_icon fl-primary-color-hv" href="<?php echo esc_url(autlines_get_theme_mod('header_fb')); ?>">
                <i class="fa fa-facebook" aria-hidden="true"></i>
            </a>
            </li>
        <?php } ?>
        <?php if(autlines_get_theme_mod('header_twi')){ ?>
            <li>
            <a class="fl_footer_social_icon fl-primary-color-hv" href="<?php echo esc_url(autlines_get_theme_mod('header_twi')); ?>">
                <i class="fa fa-twitter" aria-hidden="true"></i>
            </a>
            </li><?php } ?>
        <?php if(autlines_get_theme_mod('header_pin')){ ?>
            <li>
            <a class="fl_footer_social_icon fl-primary-color-hv" href="<?php echo esc_url(autlines_get_theme_mod('header_pin')); ?>">
                <i class="fa fa-pinterest-p" aria-hidden="true"></i>
            </a>
            </li><?php } ?>
        <?php if(autlines_get_theme_mod('header_linkedin')){ ?><li>
            <a class="fl_footer_social_icon fl-primary-color-hv" href="<?php echo esc_url(autlines_get_theme_mod('header_linkedin')); ?>">
                <i class="fa fa-linkedin" aria-hidden="true"></i>
            </a>
            </li><?php } ?>
        <?php if(autlines_get_theme_mod('header_yt')){ ?>
            <li>
            <a class="fl_footer_social_icon fl-primary-color-hv" href="<?php echo esc_url(autlines_get_theme_mod('header_yt')); ?>">
                <i class="fa fa-youtube" aria-hidden="true"></i>
            </a>
            </li><?php } ?>
        <?php if(autlines_get_theme_mod('header_vime')){ ?>
            <li>
            <a class="fl_footer_social_icon fl-primary-color-hv" href="<?php echo esc_url(autlines_get_theme_mod('header_vime')); ?>">
                <i class="fa fa-vimeo" aria-hidden="true"></i>
            </a>
            </li><?php } ?>
        <?php if(autlines_get_theme_mod('header_gpl')){ ?>
            <li>
            <a class="fl_footer_social_icon fl-primary-color-hv" href="<?php echo esc_url(autlines_get_theme_mod('header_gpl')); ?>">
                <i class="fa fa-google" aria-hidden="true"></i>
            </a>
            </li><?php } ?>
        <?php if(autlines_get_theme_mod('header_insta')){ ?>
            <li>
            <a class="fl_footer_social_icon fl-primary-color-hv" href="<?php echo esc_url(autlines_get_theme_mod('header_insta')); ?>">
                <i class="fa fa-instagram" aria-hidden="true"></i>
            </a>
            </li><?php } ?>
        <?php if(autlines_get_theme_mod('header_beh')){ ?>
            <li>
            <a class="fl_footer_social_icon fl-primary-color-hv" href="<?php echo esc_url(autlines_get_theme_mod('header_beh')); ?>">
                <i class="fa fa-behance" aria-hidden="true"></i>
            </a>
            </li><?php } ?>
    </ul>
</div>
<?php } ;?>