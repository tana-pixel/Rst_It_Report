<?php
if(!function_exists('autlines_demo_import')) {
    function autlines_demo_import()
    {
        return array(
            array(
                'import_file_name'              => esc_html__('Autlines Cars WordPress Theme', 'autlines'),
                'categories'                    => array('e-Commerce,shop,Car Dealer'),
                'local_import_file'             => AUTLINES_PATH . '/demo_install/demo_file/demo-content.xml',
                'local_import_widget_file'      => AUTLINES_PATH . '/demo_install/demo_file/widgets.json',
                'local_import_customizer_file'  => AUTLINES_PATH . '/demo_install/demo_file/customizer.dat',
                'import_preview_image_url'      => AUTLINES_PATH . '/demo_install/demo_img/demo_creative.png',
                'import_notice'                 => 'After you import this demo, you will have to setup the slider separately.',
                'preview_url'                   => 'http://autlines.foras-lab.website/'
            ),
        );
    }
}
add_filter('pt-ocdi/import_files', 'autlines_demo_import');

if(!function_exists('autlines_after_demo_import')) {

    function autlines_after_demo_import() {

        $general_menu           = get_term_by( 'name', 'Main Menu', 'nav_menu' );
        $mobile_menu            = get_term_by( 'name', 'Mobile Menu', 'nav_menu' );

        set_theme_mod( 'nav_menu_locations', array(
                'general-menu'      => $general_menu->term_id,
                'mobile-menu'    => $mobile_menu->term_id,
            )
        );


        $front_page_id = get_page_by_title( 'Home' );
        $blog_page_id  = get_page_by_title( 'Blog' );

        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_page_id->ID );
        update_option( 'page_for_posts', $blog_page_id->ID );

        //Import Revolution Slider
        if ( class_exists( 'RevSlider' ) ) {
            $slider_array = array(
                AUTLINES_PATH . '/demo_install/demo_file/rev_slider/autlines-home-slider.zip',
            );

            $slider = new RevSlider();

            foreach($slider_array as $filepath){
                $slider->importSliderFromPost(true,true,$filepath);
            }

        }

        if (get_option('permalink_structure') !== '/%postname%/') {
            update_option('permalink_structure', '/%postname%/');
        }


    }
}
add_action( 'pt-ocdi/after_import', 'autlines_after_demo_import' );

add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );



