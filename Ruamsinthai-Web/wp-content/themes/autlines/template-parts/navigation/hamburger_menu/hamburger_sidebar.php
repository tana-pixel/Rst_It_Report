
<div class="fl-hamburger_menu fl-hamburger-sidebar fl-nav-close">

    <div class="fl-sidebar-overlay"></div>

    <div class="fl-nav-container-sidebar">
        <div class="fl-close-btn-menu cf">
            <div class="fl-close-btn">
                <span class="left-close"></span>
                <span class="right-close"></span>
            </div>
        </div>
                <nav id="menu-hamburger-menu" class="menu-hamburger-wrapper">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'hamburger_menu',
                        'menu_class'	=> 'menu menu-hamburger',
                        'container' => false,
                        'depth' => 3,
                        'fallback_cb' => 'autlines_menu_fallback'
                    ));
                    ?>
                </nav>
    </div>
</div>

