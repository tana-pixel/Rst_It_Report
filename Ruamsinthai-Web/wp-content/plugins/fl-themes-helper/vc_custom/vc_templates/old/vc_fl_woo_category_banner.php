<?php
if ( ! function_exists( 'vc_fl_woo_category_function' ) ) {
    function vc_fl_woo_category_function($atts, $content = null)
    {

        $css_classes[] = 'fl-woo-category-banner-wrapper';

        $banner_css_classes [] = 'fl-woo-category-banner';

        global $fl_helping_responsive_style;

        $atts = vc_map_get_attributes('vc_fl_woo_category_banner', $atts);

        extract($atts);


        $images_str = $image = $margin_slider = $bg_arrow = $dots_css_classes[] = $slider_css_classes[] = $slider_wrapper_attributes [] ='';

        $result = $wrapper_attributes[] = $css_classes[] = $responsive_style = '';


        $css_classes[] = fl_get_css_tab_class($atts);

        if(isset($id) && $id != '') {
            $wrapper_attributes[] = 'id="'.fl_sanitize_class($id).'"';
        }

        if(isset($class) && $class != '') {
            $css_classes[] = fl_sanitize_class($class);
        }

        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            if( !empty( $responsive_css ) && $responsive_css != '' ) {
                $responsive_id =  uniqid('fl-helping-slider-responsive-').'-'.rand(100,9999);
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



        // Image
        $image = '';
        $attachment = fl_get_attachment($img, 'full');
        if (fl_check_option($attachment)) {
                $image = '<img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment['alt']) . ' " class="fl_slider-img">';
        }

        // Link
        $link_atts     ='href="#"';
        if ( ! empty( $woo_category_link ) and ( $woo_category_link !='0')) {
            $category = get_term_by('slug', $woo_category_link, 'product_cat');
            if ($category && !empty($category) && !is_wp_error($category)) {
                $link_atts = ' href="' . get_term_link($category, 'product_cat') . '"';
            }
        }

        if ( ! empty( $custom_link ) and ( $custom_link !='off')) {
            //Btn link
            if ( fl_check_option($link) && function_exists('vc_build_link')) {
                $link = vc_build_link($link);
                if(isset($link['url']) && $link['url']) {
                    $link_atts = ' href="' . esc_attr($link['url']) . '"';

                    if(isset($link['title']) && $link['title']) {
                        $link_atts .= ' title="' . esc_attr($link['title']) . '"';
                    }
                    if(isset($link['target']) && $link['target']) {
                        $link_atts .= ' target="' . esc_attr(trim($link['target'])) . '"';
                    }
                    if(isset($link['rel']) && $link['rel']) {
                        $link_atts .= ' rel="' . esc_attr(trim($link['rel'])) . '"';
                    }
                }
            }

        }


        if ( ! empty( $woo_product_banner_style) and ( $woo_product_banner_style !='')) {

            $banner_css_classes [] = $woo_product_banner_style;
        }

        if ( ! empty( $banner_style) and ( $banner_style !='')) {

            $banner_css_classes [] = $banner_style;
        }
        if ( ! empty( $mouse_parallax) and ( $mouse_parallax !='')) {

            $banner_css_classes [] = $mouse_parallax;
        }





        $banner_css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $banner_css_classes ) ) ) );

        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

        $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '.implode( ' ', $wrapper_attributes).'>';

        $result .= '<div class="' . esc_attr( trim( $banner_css_class ) ) . '" >';


        $result .= $image;

        /*Wrapper Start */
        $result .='<div class="fl-content-banner-wrapper">';

        // Sub title
        if ( ! empty( $sub_title_text) and ( $sub_title_text !='')) {
            $result .= '<div class="sub-title-banner fl-font-style-semi-bold fl-primary-color">';

            $result .= $sub_title_text;

            $result .= '</div>';
        }

        // Title Content
        $result .= '<div class="fl-banner-title-content">';
        // Title
        if ( ! empty( $title_text) and ( $title_text !='')) {
            $result .= '<div class="title-banner fl-font-style-semi-bold">';

            $result .= $title_text;

            $result .= '</div>';
        }
        // Title Light
        if ( ! empty( $light_title_text) and ( $light_title_text !='')) {
            $result .= '<div class="title-banner-light">';

            $result .= $light_title_text;

            $result .= '</div>';
        }

        $result .= '</div>';

        // Button

        if ( ! empty( $btn_text) and ( $btn_text !='')) {
            $result .= '<div class="fl-banner-button-wrapper">';

            $result .= '<a ' . $link_atts . ' class="fl-banner-button fl-button btn-effect fl-btn-default">' . $btn_text . '</a>';

            $result .= '</div>';
        }

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

add_shortcode('vc_fl_woo_category_banner', 'vc_fl_woo_category_function');