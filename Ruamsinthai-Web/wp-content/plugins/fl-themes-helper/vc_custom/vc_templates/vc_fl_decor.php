<?php
/*
 * Gap function
* */
if ( ! function_exists( 'vc_decor_function' ) ) {
    function vc_decor_function($atts, $content = null)
    {

        $css_classes[] = 'fl-vc-decor-wrapper';

        $atts = vc_map_get_attributes('vc_decor', $atts);

        extract($atts);


        $result = $wrapper_attributes[] =  $gap_h = '';

        if(isset($height) && $height != '') {
            $gap_h = 'height:'.$height.'px;';
        }

        $text_block_css = ($gap_h ) ? 'style=' . $gap_h .  '' : '';



        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

        $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '. implode( ' ', $wrapper_attributes ).'>';

            $result .='<div class="filter-decor"></div>';

        $result .='</div>';

        return $result;
    }
}
add_shortcode('vc_decor', 'vc_decor_function');