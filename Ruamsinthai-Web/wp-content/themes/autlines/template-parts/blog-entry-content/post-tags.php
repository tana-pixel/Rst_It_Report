<?php if(get_the_tags()){ ?>
    <div class="tags-single-blog fl-font-style-regular-two">
        <span class="tags-content-text">
           <?php echo esc_html__('Tags:','autlines') ?>
        </span>
        <?php the_tags('<span class="tags-content fl-primary-color">', ', ', '</span>') ;?>
    </div>
<?php } ?>

