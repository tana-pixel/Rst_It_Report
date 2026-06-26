<?php
/**====================================================================
==  ICON VC
====================================================================*/
require 'icon/vc_icon.php';

/**====================================================================
==  Shortcode_extend
====================================================================*/

add_action('vc_before_init', 'fl_shortcode_extend');

if(!function_exists('fl_shortcode_extend')){
    function fl_shortcode_extend()
    {
        if ( class_exists( 'WPBakeryShortCodesContainer' ) )
        {
            class WPBakeryShortCode_Vc_Fl_List_Table                        extends WPBakeryShortCodesContainer {}
            class WPBakeryShortCode_Vc_Fl_Contact_Info_Parent               extends WPBakeryShortCodesContainer {}


            class WPBakeryShortCode_Vc_Fl_Car_Detail_Of_The_Week            extends WPBakeryShortCodesContainer {}
            class WPBakeryShortCode_Vc_Fl_Car_Detail_Of_The_Week_Row        extends WPBakeryShortCodesContainer {}
            class WPBakeryShortCode_Vc_Fl_Testimonial_Slider                extends WPBakeryShortCodesContainer {}
            class WPBakeryShortCode_Vc_Fl_Services_Slider_Container         extends WPBakeryShortCodesContainer {}
            class WPBakeryShortCode_Vc_Fl_Header_Custom_Container           extends WPBakeryShortCodesContainer {}
            class WPBakeryShortCode_Vc_Fl_Semi_Circle_Progress_Container    extends WPBakeryShortCodesContainer {}


        }
    }
}

/**====================================================================
==  VC Plugin Scripts
====================================================================*/
add_action('wp_enqueue_scripts', 'fl_short_code_scripts');
if ( !function_exists( 'fl_short_code_scripts' ) )
{
    function fl_short_code_scripts()
    {
        wp_enqueue_style('fl-font-vc', plugin_dir_url( __FILE__ ). '/icon/icon_assets/css/fl-icon.min.css', array(),'1.0');

        wp_enqueue_script('fl-vc-custom',plugin_dir_url( __FILE__ ).'js/vc_custom.js', false, null , true);

        wp_register_script('fl-vc-google-maps',plugin_dir_url( __FILE__ ).'../assets/js/save_js/gmap3.min.js', false, null , true);

    }
}
/**====================================================================
==  Update Custom short code
====================================================================*/
//
add_action( 'vc_before_init', 'fl_vc_before_init_actions' );
function fl_vc_before_init_actions()
{
    if( function_exists('vc_set_shortcodes_templates_dir') )
    {
        vc_set_shortcodes_templates_dir( plugin_dir_path(__FILE__) .'custom_vc_shortcode');
    }
}








