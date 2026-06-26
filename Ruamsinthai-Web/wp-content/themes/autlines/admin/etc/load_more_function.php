<?php

function autlines_ajax_pagination($wp_query = null) {

            if($wp_query == null) {

                global $wp_query;

            } else {

                $wp_query = $wp_query;

            }


			$max_num_pages = $wp_query->max_num_pages;
			$page = get_query_var('paged');
			$paged = ($page > 1) ? $page : 1;

            wp_register_script('ajax-pagination', get_template_directory_uri().'/assets/js/load-more.js', array('jquery'), null, true);


			wp_localize_script(
                'ajax-pagination',
                'autlines_pagination_data',
                array(
                    'startPage'                 => $paged,
                    'maxPages'                  => $max_num_pages,
                    'nextLink'                  => next_posts($max_num_pages, false),
                    'button_text'               => autlines_get_theme_mod('load_more_text'),
                    'button_text_no_post'       => autlines_get_theme_mod('load_more_text_blog'),
                    'button_loading'            => autlines_get_theme_mod('load_more_loading_text'),
                    'button_text_no_product'    => autlines_get_theme_mod('load_more_text_woo'),
                    'button_text_no_work'       => autlines_get_theme_mod('load_more_text_work'),
                    'container'                 => '.post-wrapper,.vc-cars-wrapper,.products',
                )
            );

			wp_enqueue_script('ajax-pagination');
				echo '<div class="fl-pagination ajax-pagination button-container secondary-btn-style" data-animation="true">'
                    . '<span id="fl-ajax-load-more-pagination" class="fl-button-pagination fl-vc-button fl-font-style-bolt-two">'.autlines_get_theme_mod('load_more_text').'</span>'
                    . '</div>';
		}