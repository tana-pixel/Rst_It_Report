<?php
// Accordion Elements
VcShortcodeAutoloader::getInstance()->includeClass('WPBakeryShortCode_VC_Tta_Accordion');
if(!class_exists("FL_theme_helper_fl_accordion")){
    class FL_theme_helper_fl_accordion extends WPBakeryShortCode_VC_Tta_Accordion{
        function __construct(){
            add_shortcode( 'fl_accordion',array($this,'fl_accordion_shortcode'));
        }
        function fl_accordion_shortcode($atts,$content = null){

            $css_classes []           = 'fl-accordion';

            $el_class = $css = '';

            $result = $wrapper_attributes[] = $responsive_style = $css='';
            global $fl_helping_responsive_style, $fl_helping_css_style;

            $atts = vc_map_get_attributes( 'fl_accordion', $atts );

            $this->resetVariables( $atts, $content );
            extract( $atts );
            $this->setGlobalTtaInfo();
            $this->enqueueTtaStyles();
            $this->enqueueTtaScript();


            // It is required to be before tabs-list-top/left/bottom/right for tabs/tours
            $prepareContent = $this->getTemplateVariable( 'content' );



            $class_to_filter = $this->getTtaGeneralClasses();

            $class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );

            $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );


            $css_classes[] .= fl_get_css_tab_class($atts);


            if(isset($id) && $id != '') {
                $wrapper_attributes[] = 'id="'.fl_sanitize_class($id).'"';
            }


            if(isset($class) && $class != '') {
                $css_classes[] = fl_sanitize_class($class);
            }

            // Responsive CSS Box
            if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
                if( !empty( $responsive_css ) && $responsive_css != '' ) {
                    $responsive_id = $idf = uniqid('fl-helping-alert-responsive-').'-'.rand(100,9999);
                    $column_selector = $responsive_id;
                    $responsive_style = fl_helping__addons_get_responsive_style($responsive_css, $column_selector);
                    $css_classes[] = $responsive_id;
                }
            }

            // Animation option
            if ( ! empty( $animation ) and ($animation !='none')) {
                $css_classes[] = 'fl-animated-item-velocity';
                $wrapper_attributes[] = 'data-animate-type="'.$animation.'"';

                if ( ! empty( $custom_delay ) and ( $custom_delay !='off')) {
                    if ( ! empty( $animation_delay ) and ($animation_delay !='')) {
                        $wrapper_attributes[] = 'data-item-delay="'.$animation_delay.'"';
                    }
                }
            }

            // Custom Color
            if ( ! empty( $custom_color ) and ($custom_color !='disable')) {
                $custom_CSS_Class = uniqid('custom-color-');

                $css_classes[] = $custom_CSS_Class;
                if ( ! empty( $act_bg_cl ) and ($act_bg_cl !='')) {
                    $fl_helping_css_style[] = '.' . $custom_CSS_Class . ' .vc_tta-panel.vc_active .vc_tta-panel-heading .vc_tta-panel-title a { background:' . $act_bg_cl . '!important; }';
                }
                if ( ! empty( $act_cl ) and ($act_cl !='')) {
                    $fl_helping_css_style[] = '.' . $custom_CSS_Class . ' .vc_tta-panel.vc_active .vc_tta-panel-heading .vc_tta-panel-title a,.' . $custom_CSS_Class . ' .vc_tta-panel.vc_active .vc_tta-panel-heading .vc_tta-panel-title a:focus { color:' . $act_cl . '!important; }';
                }
                if ( ! empty( $act_body_bg ) and ($act_body_bg !='')) {
                    $fl_helping_css_style[] = '.' . $custom_CSS_Class . ' .vc_tta-panel .vc_tta-panel-body { background-color:' . $act_body_bg . '!important; }';
                }

            }


            $accordion_css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

            $result .= '<div class="' . esc_attr( trim( $accordion_css_class ) ) . '" '. implode( ' ', $wrapper_attributes ).'>';


            $result .= '<div ' . $this->getWrapperAttributes() . '>';
            $result .= $this->getTemplateVariable( 'title' );
            $result .= '<div class="' . esc_attr( $css_class ) . '">';
            $result .= $this->getTemplateVariable( 'tabs-list-top' );
            $result .= $this->getTemplateVariable( 'tabs-list-left' );
            $result .= '<div class="vc_tta-panels-container" >';
            $result .= $this->getTemplateVariable( 'pagination-top' );
            $result .= '<div class="vc_tta-panels">';
            $result .= $prepareContent;
            $result .= '</div>';
            $result .= $this->getTemplateVariable( 'pagination-bottom' );
            $result .= '</div>';
            $result .= $this->getTemplateVariable( 'tabs-list-bottom' );
            $result .= $this->getTemplateVariable( 'tabs-list-right' );
            $result .= '</div>';
            $result .= '</div>';


            $result .= '</div>';




            // Responsive CSS Box
            if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
                $fl_helping_responsive_style .= $responsive_style;
            }




            return $result;
        }
    }
    new FL_theme_helper_fl_accordion;

    if(class_exists('WPBakeryShortCode') && !class_exists('WPBakeryShortCode_fl_accordion'))
    {
        class WPBakeryShortCode_fl_accordion extends WPBakeryShortCode_VC_Tta_accordion
        {

        }
    }
}