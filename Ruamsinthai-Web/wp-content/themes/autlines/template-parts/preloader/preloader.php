<?php
if(autlines_get_theme_mod('preloader_page_show') == 'true') {
    wp_enqueue_script( 'autlines-page-loader' );?>
    <div id="fl-page--preloader">
        <span class="fl-top-progress">
            <span class="fl-loader_right"></span>
            <span class="fl-loader_left"></span>
        </span>


        <div class="fl-top-background-preloader"></div>
        <div class="fl-bottom-background-preloader"></div>
        <div class="fl--preloader-progress-bar"><span></span></div>
        <img alt="<?php echo esc_attr__('Save Preloader image','autlines');?>" src="" class="save_loader_bugs">
        <div class="fl-preloader--text-percent">
            <p class="fl--preloader-percent fl-text-title-style">0%</p>
        </div>
    </div>




<?php } ?>