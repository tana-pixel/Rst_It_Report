<?php
// get metabox
if (!function_exists( 'tmbooking_get_metabox' )):
    function tmbooking_get_metabox($name = null, $postId = null) {
        $value = null;

        // try get value from meta box
        if (function_exists('get_field')) {
            if ($postId == null) {
                $postId = get_the_ID();
            }
            $value = get_field($name, $postId);
        } else {
            $value = get_post_meta( $postId, $name, true);
        }

        return $value;
    }
endif;

/**
 * Get custom book now button text or default text if not set
 *
 * @param int $postId Post ID
 * @return string Button text
 */
if (!function_exists('tmbooking_get_book_now_text')):
    function tmbooking_get_book_now_text($postId = null) {
        $custom_text = tmbooking_get_metabox('price_section_book_now_text', $postId);
        if (!empty($custom_text)) {
            return esc_html($custom_text);
        }
        return esc_html__('Book now', 'tm-booking');
    }
endif;

// get term meta
if (!function_exists( 'tmbooking_get_term_metabox' )):
    function tmbooking_get_term_metabox($name = null, $postId = null) {
        $value = null;
        // try get value from meta box
        if ($postId == null) {
            $postId = get_the_ID();
        }
        if (function_exists('get_field')) {
            $value = get_term_meta( $postId, $name, true);
        } else {
            $value = get_term_meta( $postId, $name, true);
        }


        return $value;
    }
endif;
