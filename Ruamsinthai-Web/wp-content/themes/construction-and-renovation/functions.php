<?php

/**
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Construction And Renovation for publication on WordPress.org
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

require_once get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'construction_and_renovation_register_required_plugins', 0);
function construction_and_renovation_register_required_plugins()
{
	$plugins = array(
		array(
			'name'      => 'Superb Addons',
			'slug'      => 'superb-blocks',
			'required'  => false,
		)
	);

	$config = array(
		'id'           => 'construction-and-renovation',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => true,
		'message'      => '',
	);

	tgmpa($plugins, $config);
}


function construction_and_renovation_pattern_styles()
{
	wp_enqueue_style('construction-and-renovation-patterns', get_stylesheet_directory_uri() . '/assets/css/patterns.css', array(), filemtime(get_template_directory() . '/assets/css/patterns.css'));
	if (is_admin()) {
		global $pagenow;
		if ('site-editor.php' === $pagenow) {
			// Do not enqueue editor style in site editor
			return;
		}
		wp_enqueue_style('construction-and-renovation-editor', get_stylesheet_directory_uri() . '/assets/css/editor.css', array(), filemtime(get_template_directory() . '/assets/css/editor.css'));
	}
}
add_action('enqueue_block_assets', 'construction_and_renovation_pattern_styles');


add_theme_support('wp-block-styles');

// Removes the default wordpress patterns
add_action('init', function () {
	remove_theme_support('core-block-patterns');
});

// Register customer Construction And Renovation pattern categories
function construction_and_renovation_register_block_pattern_categories()
{
	register_block_pattern_category(
		'header',
		array(
			'label'       => __('Header', 'construction-and-renovation'),
			'description' => __('Header patterns', 'construction-and-renovation'),
		)
	);
	register_block_pattern_category(
		'call_to_action',
		array(
			'label'       => __('Call To Action', 'construction-and-renovation'),
			'description' => __('Call to action patterns', 'construction-and-renovation'),
		)
	);
	register_block_pattern_category(
		'content',
		array(
			'label'       => __('Content', 'construction-and-renovation'),
			'description' => __('Construction And Renovation content patterns', 'construction-and-renovation'),
		)
	);
	register_block_pattern_category(
		'teams',
		array(
			'label'       => __('Teams', 'construction-and-renovation'),
			'description' => __('Team patterns', 'construction-and-renovation'),
		)
	);
	register_block_pattern_category(
		'banners',
		array(
			'label'       => __('Banners', 'construction-and-renovation'),
			'description' => __('Banner patterns', 'construction-and-renovation'),
		)
	);
	register_block_pattern_category(
		'contact',
		array(
			'label'       => __('Contact', 'construction-and-renovation'),
			'description' => __('Contact patterns', 'construction-and-renovation'),
		)
	);
	register_block_pattern_category(
		'layouts',
		array(
			'label'       => __('Layouts', 'construction-and-renovation'),
			'description' => __('layout patterns', 'construction-and-renovation'),
		)
	);
	register_block_pattern_category(
		'testimonials',
		array(
			'label'       => __('Testimonial', 'construction-and-renovation'),
			'description' => __('Testimonial and review patterns', 'construction-and-renovation'),
		)
	);

}

add_action('init', 'construction_and_renovation_register_block_pattern_categories');




