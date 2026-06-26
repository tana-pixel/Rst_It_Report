<div class="fl-hamburger_menu fl-hamburger-full-width">
    <div class="fl--hamburger-menu closed">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <nav class="fl--full-width--navigation--wrapper cf">
        <?php
            wp_nav_menu(array(
                'theme_location'    => 'hamburger-menu',
                'menu_class'	    => 'fl--full-width--mobile-menu',
                'id'                => 'hamburger-menu',
                'container'         => false,
                'depth'             => 3,
                'fallback_cb'       => 'autlines_menu_fallback'
            ));
        ?>
    </nav>

</div>