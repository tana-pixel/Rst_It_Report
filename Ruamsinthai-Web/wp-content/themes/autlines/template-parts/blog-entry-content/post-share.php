<?php if( autlines_get_theme_mod('share_post_setting') !='hide') { ?>
    <div class="right-post-top-content">
            <div class="post-share-icon">
                <span class="share-text"><?php echo esc_html__('Share This','autlines');?></span>

                    <?php $fl_share_platforms  = autlines_get_theme_mod('social_sharing_setting'); ?>
                    <?php if ( ! empty( $fl_share_platforms  ) ) : ?>
                        <?php foreach ( $fl_share_platforms  as $checked_value ) : ?>
                            <?php switch ($checked_value) {
                                case 'fb' :
                                    $fl_icon = 'fa-facebook';
                                    break;
                                case 'twi' :
                                    $fl_icon = 'fa-twitter';
                                    break;
                                case 'goglp' :
                                    $fl_icon = 'fa-google';
                                    break;
                                case 'lin' :
                                    $fl_icon = 'fa-linkedin';
                                    break;
                                case 'red' :
                                    $fl_icon = 'fa-reddit-alien';
                                    break;
                                case 'pin' :
                                    $fl_icon = 'fa-pinterest-p';
                                    break;
                                case 'vk' :
                                    $fl_icon = 'fa-vk';
                                    break;
                            } ?>
                            <a href="<?php echo esc_url(fl_get_share($checked_value)); ?>" class="fl_share_icon fl-primary-bg <?php echo esc_attr($checked_value); ?>" onclick="window.open(this.href, 'Share this post', 'width=600,height=300'); return false"><i class="fa <?php echo esc_attr($fl_icon); ?>"></i></a>
                        <?php endforeach; ?>
                    <?php endif; ?>
            </div>
    </div>
<?php } ?>



