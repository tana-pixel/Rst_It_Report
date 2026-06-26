<?php
/*
 * Shortcode Instagram
 * */
if ( ! function_exists( 'vc_fl_instagram_function' ) ) {
    function vc_fl_instagram_function($atts, $content = null)
    {

        $css_classes []           = 'fl-instagram';

        global $fl_helping_responsive_style;

     //   $text = $_POST['text'];

        $atts = vc_map_get_attributes('vc_fl_instagram', $atts);
        extract($atts);


        $result = $wrapper_attributes[] = $responsive_style = $css=$counter_wrapper_attributes []= $icon_vc =$icon='';

        $css_classes[] .= fl_get_css_tab_class($atts);

        if(isset($id) && $id != '') {
            $wrapper_attributes[] = 'id="'.fl_sanitize_class($id).'"';
        }

        if(isset($class) && $class != '') {
            $css_classes[] = fl_sanitize_class($class);
        }

        //Instagram Login
        if ( ! empty( $instagram_login) and ($instagram_login !='')) {

            $login = $instagram_login;

        }

        //Instagram Access Token
        if ( ! empty( $access_token) and ($access_token !='')) {

            $token = $access_token;

        }

        //Instagram Desc
        if ( ! empty( $instagram_desc) and ($instagram_desc !='')) {

            $desc = $instagram_desc;

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
            $wrapper_attributes[] = 'data-item-for-animated=".fl-grid-item .empty"';

             if ( ! empty( $custom_delay ) and ( $custom_delay !='off')) {
                if ( ! empty( $animation_delay ) and ($animation_delay !='')) {
                    $wrapper_attributes[] = 'data-item-delay="'.$animation_delay.'"';
                }
            }
        }

        ///

        $error = esc_html__('Fill all the Instagram Feed fields in Options Panel','fl-themes-helper');


        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

        $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '. implode( ' ', $wrapper_attributes ).'>';

        if(! empty( $token )) {

            $user_id = 'self';

            $insta_data = fl_theme_helper_instagram_api_curl_connect("https://api.instagram.com/v1/users/" . $user_id . "/media/recent?access_token=" . $token);

            $limit = 23;

            $i = 0;

            $result .= '<div class="fl-isotope-wrapper fl-instagram-grid-wrapper cf">';

            foreach(array_slice($insta_data->data, 0, $limit) as $post ):
                $i++;

                if( $i == 2 || $i == 7 || $i == 11 || $i == 14 ){

                    $result .= '<div class="fl-grid-item fl-grid-item-wx2 fl-grid-item_hx2 fl-big-instagram-image cf">';


                    $result .= '<div class=empty>';

                    $result .= '<a href="'.$post->link.'" target="_blank">';

                    $result .= '<div>';

                    $result .= '<img class="img-responsive img-instagram" alt="instagram-image" src="'.$post->images->standard_resolution->url.'">';

                    $result .= '<div class="insta-info"><span><i class="fl-custom-icon-heart-outline"></i>'.$post->likes->count.'</span> 
                                <span><i class="fl-custom-icon-comments-icon"></i>'.$post->comments->count.'</span></div>';

                    $result .= '</div>';
                    $result .= '</a>';

                    $result .= '</div>';

                    $result .= '</div>';

                } elseif($i == 9) {

                    $result .= '<div class="fl-grid-item fl-small-instagram-image cf">';

                    $result .= '<div class="empty entry-thumb">';

                    $result .= '<a href="'.$post->link.'" target="_blank">';

                    $result .= '<div>';

                    $result .= '<img class="img-responsive img-instagram" alt="instagram-image" src="'.$post->images->standard_resolution->url.'">';

                    $result .= '<div class="insta-info"><span><i class="fl-custom-icon-heart-outline"></i>'.$post->likes->count.'</span> 
                                <span><i class="fl-custom-icon-comments-icon"></i>'.$post->comments->count.'</span></div>';

                    $result .= '</div>';

                    $result .= '</a>';

                    $result .= '</div>';

                    $result .= '</div>';

                    $result .= '<div class="fl-grid-item fl-grid-item-wx4 fl-grid-item_hx2 cf">';

                    $result .= '<div class="empty">';

                    $result .= '<div class="fl--instagram-title-container fl--insta-bg-grey">';

                    $result .= '<i class="fa fa-instagram fl-primary-color" aria-hidden="true"></i>';

                    $result .= '<div class="fl--instagram-username">'.$login.'</div>';

                    $result .= '<span class="fl--instagram-description fl-primary-color">'.$desc.'</span>';

                    $result .= '</div>';

                    $result .= '</div>';

                    $result .= '</div>';

                } else {

                    $result .= '<div class="fl-grid-item fl-small-instagram-image cf">';

                    $result .= '<div class="empty entry-thumb">';

                    $result .= '<a href="'.$post->link.'" target="_blank">';

                    $result .= '<div class="insta-info-wrapper">';

                    $result .= '<img class="img-responsive img-instagram" alt="instagram-image" src="'.$post->images->standard_resolution->url.'">';

                    $result .= '<div class="insta-info"><span><i class="fl-custom-icon-heart-outline"></i>'.$post->likes->count.'</span> 
                                <span><i class="fl-custom-icon-comments-icon"></i>'.$post->comments->count.'</span></div>';

                    $result .= '</div>';

                    $result .= '</a>';

                    $result .= '</div>';

                    $result .= '</div>';
                }

            endforeach;

            $result .='</div>';

        } else {
            $result .= '<div class="text-center">'.esc_attr($error).'</div>';
        }

        $result .='</div>';

        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }

        return $result;
    }
}

add_shortcode('vc_fl_instagram', 'vc_fl_instagram_function');

