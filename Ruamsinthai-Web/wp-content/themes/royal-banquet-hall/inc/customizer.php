<?php
/**
 * Royal Banquet Hall: Customizer
 *
 * @subpackage Royal Banquet Hall
 * @since 1.0
 */

use WPTRT\Customize\Section\Luzuk_Royal_Banquet_Hall_Button;

add_action( 'customize_register', function( $manager ) {

	$manager->register_section_type( Luzuk_Royal_Banquet_Hall_Button::class );

	$manager->add_section(
		new Luzuk_Royal_Banquet_Hall_Button( $manager, 'luzuk_royal_banquet_hall_pro', [
			'title' => __( 'Royal Banquet Hall Pro', 'royal-banquet-hall' ),
			'priority' => 0,
			'button_text' => __( 'Go Pro', 'royal-banquet-hall' ),
			'button_url'  => esc_url( 'https://www.luzuk.com/products/banquet-hall-wordpress-template/', 'royal-banquet-hall')
		] )
	);

} );


// Load the JS and CSS.
add_action( 'customize_controls_enqueue_scripts', function() {

	$version = wp_get_theme()->get( 'Version' );

	wp_enqueue_script(
		'royal-banquet-hall-customize-section-button',
		get_theme_file_uri( 'vendor/wptrt/customize-section-button/public/js/customize-controls.js' ),
		[ 'customize-controls' ],
		$version,
		true
	);

	wp_enqueue_style(
		'royal-banquet-hall-customize-section-button',
		get_theme_file_uri( 'vendor/wptrt/customize-section-button/public/css/customize-controls.css' ),
		[ 'customize-controls' ],
 		$version
	);

} );

function luzuk_royal_banquet_hall_customize_register( $wp_customize ) {

	$wp_customize->add_setting('luzuk_royal_banquet_hall_logo_size',array(
		'sanitize_callback'	=> 'luzuk_royal_banquet_hall_sanitize_float'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_logo_size',array(
		'type' => 'range',
		'label' => __('Logo Size','royal-banquet-hall'),
		'section' => 'title_tagline'
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_logo_padding',array(
		'sanitize_callback'	=> 'esc_html'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_logo_padding',array(
		'label' => __('Logo Margin','royal-banquet-hall'),
		'section' => 'title_tagline'
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_logo_top_padding',array(
		'default' => '',
		'sanitize_callback'	=> 'luzuk_royal_banquet_hall_sanitize_float'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_logo_top_padding',array(
		'type' => 'number',
		'description' => __('Top','royal-banquet-hall'),
		'section' => 'title_tagline',
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_logo_bottom_padding',array(
		'default' => '',
		'sanitize_callback'	=> 'luzuk_royal_banquet_hall_sanitize_float'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_logo_bottom_padding',array(
		'type' => 'number',
		'description' => __('Bottom','royal-banquet-hall'),
		'section' => 'title_tagline',
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_logo_left_padding',array(
		'default' => '',
		'sanitize_callback'	=> 'luzuk_royal_banquet_hall_sanitize_float'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_logo_left_padding',array(
		'type' => 'number',
		'description' => __('Left','royal-banquet-hall'),
		'section' => 'title_tagline',
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_logo_right_padding',array(
		'default' => '',
		'sanitize_callback'	=> 'luzuk_royal_banquet_hall_sanitize_float'
 	));
 	$wp_customize->add_control('luzuk_royal_banquet_hall_logo_right_padding',array(
		'type' => 'number',
		'description' => __('Right','royal-banquet-hall'),
		'section' => 'title_tagline',
    ));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_show_site_title',array(
		'default' => true,
		'sanitize_callback'	=> 'luzuk_royal_banquet_hall_sanitize_checkbox'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_show_site_title',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Site Title','royal-banquet-hall'),
		'section' => 'title_tagline'
	));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_site_title_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_site_title_color', array(
		'label' => 'Title Color',
		'section' => 'title_tagline',
	)));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_show_tagline',array(
		'default' => true,
		'sanitize_callback'	=> 'luzuk_royal_banquet_hall_sanitize_checkbox'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_show_tagline',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Site Tagline','royal-banquet-hall'),
		'section' => 'title_tagline'
	));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_site_tagline_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_site_tagline_color', array(
		'label' => 'Tagline Color',
		'section' => 'title_tagline',
	)));

	$wp_customize->add_panel( 'luzuk_royal_banquet_hall_panel_id', array(
		'priority' => 10,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Theme Settings', 'royal-banquet-hall' ),
		'description' => __( 'Description of what this panel does.', 'royal-banquet-hall' ),
	) );

	$wp_customize->add_section( 'luzuk_royal_banquet_hall_theme_options_section', array(
    	'title'      => __( 'General Settings', 'royal-banquet-hall' ),
		'priority'   => 30,
		'panel' => 'luzuk_royal_banquet_hall_panel_id'
	) );

	$wp_customize->add_setting('luzuk_royal_banquet_hall_theme_options',array(
		'default' => 'One Column',
		'sanitize_callback' => 'luzuk_royal_banquet_hall_sanitize_choices'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_theme_options',array(
		'type' => 'select',
		'label' => __('Blog Page Sidebar Layout','royal-banquet-hall'),
		'section' => 'luzuk_royal_banquet_hall_theme_options_section',
		'choices' => array(
		   'Left Sidebar' => __('Left Sidebar','royal-banquet-hall'),
		   'Right Sidebar' => __('Right Sidebar','royal-banquet-hall'),
		   'One Column' => __('One Column','royal-banquet-hall'),
		   'Grid Layout' => __('Grid Layout','royal-banquet-hall')
		),
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_single_post_sidebar',array(
		'default' => 'Right Sidebar',
		'sanitize_callback' => 'luzuk_royal_banquet_hall_sanitize_choices'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_single_post_sidebar',array(
        'type' => 'select',
        'label' => __('Single Post Sidebar Layout','royal-banquet-hall'),
        'section' => 'luzuk_royal_banquet_hall_theme_options_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','royal-banquet-hall'),
            'Right Sidebar' => __('Right Sidebar','royal-banquet-hall'),
            'One Column' => __('One Column','royal-banquet-hall')
        ),
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_page_sidebar',array(
		'default' => 'One Column',
		'sanitize_callback' => 'luzuk_royal_banquet_hall_sanitize_choices'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_page_sidebar',array(
        'type' => 'select',
        'label' => __('Page Sidebar Layout','royal-banquet-hall'),
        'section' => 'luzuk_royal_banquet_hall_theme_options_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','royal-banquet-hall'),
            'Right Sidebar' => __('Right Sidebar','royal-banquet-hall'),
            'One Column' => __('One Column','royal-banquet-hall')
        ),
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_archive_page_sidebar',array(
		'default' => 'One Column',
		'sanitize_callback' => 'luzuk_royal_banquet_hall_sanitize_choices'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_archive_page_sidebar',array(
        'type' => 'select',
        'label' => __('Archive & Search Page Sidebar Layout','royal-banquet-hall'),
        'section' => 'luzuk_royal_banquet_hall_theme_options_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','royal-banquet-hall'),
            'Right Sidebar' => __('Right Sidebar','royal-banquet-hall'),
            'One Column' => __('One Column','royal-banquet-hall'),
            'Grid Layout' => __('Grid Layout','royal-banquet-hall')
        ),
	));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_boxfull_width', array(
		'default'           => '',
		'sanitize_callback' => 'luzuk_royal_banquet_hall_sanitize_choices'
	));
	
	$wp_customize->add_control( 'luzuk_royal_banquet_hall_boxfull_width', array(
		'label'    => __( 'Section Width', 'royal-banquet-hall' ),
		'section'  => 'luzuk_royal_banquet_hall_theme_options_section',
		'type'     => 'select',
		'choices'  => array(
			'container'  => __('Box Width', 'royal-banquet-hall'),
			'container-fluid' => __('Full Width', 'royal-banquet-hall'),
			'none' => __('None', 'royal-banquet-hall')
		),
	));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_dropdown_anim', array(
		'default'           => 'None',
		'sanitize_callback' => 'luzuk_royal_banquet_hall_sanitize_choices'
	));
	$wp_customize->add_control( 'luzuk_royal_banquet_hall_dropdown_anim', array(
		'label'    => __( 'Menu Dropdown Animations', 'royal-banquet-hall' ),
		'section'  => 'luzuk_royal_banquet_hall_theme_options_section',
		'type'     => 'select',
		'choices'  => array(
			'bounceInUp'  => __('bounceInUp', 'royal-banquet-hall'),
			'fadeInUp' => __('fadeInUp', 'royal-banquet-hall'),
			'zoomIn'    => __('zoomIn', 'royal-banquet-hall'),
			'None'    => __('None', 'royal-banquet-hall')
		),
	));
 
	//Header
	$wp_customize->add_section( 'luzuk_royal_banquet_hall_header' , array(
    	'title'    => __( 'Header Settings', 'royal-banquet-hall' ),
		'priority' => null,
		'panel' => 'luzuk_royal_banquet_hall_panel_id'
	) );
		
	$wp_customize->add_setting('luzuk_royal_banquet_hall_fblink',array(
    	'default' => '#',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('luzuk_royal_banquet_hall_fblink',array(
	   	'type' => 'url',
	   	'label' => __('Facebook Icon Link','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_header',
	));
	
	$wp_customize->add_setting('luzuk_royal_banquet_hall_instagramlink',array(
    	'default' => '#',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('luzuk_royal_banquet_hall_instagramlink',array(
	   	'type' => 'url',
	   	'label' => __('Instagram Icon Link','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_header',
	));

	
	$wp_customize->add_setting('luzuk_royal_banquet_hall_twitterlink',array(
    	'default' => '#',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('luzuk_royal_banquet_hall_twitterlink',array(
	   	'type' => 'url',
	   	'label' => __('Twitter Icon Link','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_header',
	));
	
	$wp_customize->add_setting('luzuk_royal_banquet_hall_headerbtntext',array(
    	'default' => 'Book A Tour',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('luzuk_royal_banquet_hall_headerbtntext',array(
	   	'type' => 'text',
	   	'label' => __('Button Text','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_header',
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_headerbtnlink',array(
    	'default' => '#',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('luzuk_royal_banquet_hall_headerbtnlink',array(
	   	'type' => 'url',
	   	'label' => __('Button Link','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_header',
	));
	
	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_headertopsocialicon_col', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_headertopsocialicon_col', array(
		'label' => 'Social Icon Color',
		'section' => 'luzuk_royal_banquet_hall_header',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_headertopsocialiconhover_col', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_headertopsocialiconhover_col', array(
		'label' => 'Social Icon Hover Color',
		'section' => 'luzuk_royal_banquet_hall_header',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_menu_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_menu_color', array(
		'label' => 'Menu Color',
		'section' => 'luzuk_royal_banquet_hall_header',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_menuhover_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_menuhover_color', array(
		'label' => 'Menu Hover Color',
		'section' => 'luzuk_royal_banquet_hall_header',
	)));


	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_submenu_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_submenu_color', array(
		'label' => 'Submenu Text Color',
		'section' => 'luzuk_royal_banquet_hall_header',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_submenubg_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_submenubg_color', array(
		'label' => 'Submenu BG Color',
		'section' => 'luzuk_royal_banquet_hall_header',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_header_btntext_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_header_btntext_color', array(
		'label' => 'Button Text Color',
		'section' => 'luzuk_royal_banquet_hall_header',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_header_btnbghvr_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_header_btnbghvr_color', array(
		'label' => 'Button BG Hover Color',
		'section' => 'luzuk_royal_banquet_hall_header',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_header_btntexthover_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_header_btntexthover_color', array(
		'label' => 'Button Text Hover Color',
		'section' => 'luzuk_royal_banquet_hall_header',
	)));


	//home page slider
	$wp_customize->add_section( 'luzuk_royal_banquet_hall_slider_section' , array(
    	'title'    => __( 'Slider Settings', 'royal-banquet-hall' ),
		'description'=> __('<b>Note :</b> Please Add Image in 1440*900 Ratio.','royal-banquet-hall'),
		'priority' => null,
		'panel' => 'luzuk_royal_banquet_hall_panel_id'
	) );

	$wp_customize->add_setting('luzuk_royal_banquet_hall_slider_hide_show',array(
    	'default' => false,
    	'sanitize_callback'	=> 'luzuk_royal_banquet_hall_sanitize_checkbox'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_slider_hide_show',array(
	   	'type' => 'checkbox',
	   	'label' => __('Show / Hide Slider','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_slider_section',
	));


	for ( $count = 1; $count <= 4; $count++ ) {
		$wp_customize->add_setting( 'luzuk_royal_banquet_hall_slider' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'luzuk_royal_banquet_hall_sanitize_dropdown_pages'
		));
		$wp_customize->add_control( 'luzuk_royal_banquet_hall_slider' . $count, array(
			'label' => __('Select A Page', 'royal-banquet-hall' ),
			'section' => 'luzuk_royal_banquet_hall_slider_section',
			'type' => 'dropdown-pages'
		));
	}

	$wp_customize->add_setting('luzuk_royal_banquet_hall_sliderbtntext',array(
    	'default' => 'Book a Hall',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_sliderbtntext',array(
	   	'type' => 'text',
	   	'label' => __('Button Text','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_slider_section',
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_sliderbtnlink',array(
    	'default' => 'Book a Call',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_sliderbtnlink',array(
	   	'type' => 'url',
	   	'label' => __('Button Link','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_slider_section',
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_slider_excerpt_length',array(
		'default' => '15',
		'sanitize_callback'	=> 'luzuk_royal_banquet_hall_sanitize_float'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_slider_excerpt_length',array(
		'type' => 'number',
		'label' => __('Description Excerpt Length','royal-banquet-hall'),
		'section' => 'luzuk_royal_banquet_hall_slider_section',
	));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_slider_title_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_slider_title_color', array(
		'label' => 'Title Color',
		'section' => 'luzuk_royal_banquet_hall_slider_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_slider_description_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_slider_description_color', array(
		'label' => 'Description Color',
		'section' => 'luzuk_royal_banquet_hall_slider_section',
	)));
	
	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_slider_btn1text_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_slider_btn1text_color', array(
		'label' => 'Button Text Color',
		'section' => 'luzuk_royal_banquet_hall_slider_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_slider_btn1bg_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_slider_btn1bg_color', array(
		'label' => 'Button BG Color',
		'section' => 'luzuk_royal_banquet_hall_slider_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_slider_btnicon_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_slider_btnicon_color', array(
		'label' => 'Button Icon Color',
		'section' => 'luzuk_royal_banquet_hall_slider_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_slider_btniconbg_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_slider_btniconbg_color', array(
		'label' => 'Button Icon BG Color',
		'section' => 'luzuk_royal_banquet_hall_slider_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_slider_btn1texthrv_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_slider_btn1texthrv_color', array(
		'label' => 'Button Text Hover Color',
		'section' => 'luzuk_royal_banquet_hall_slider_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_slider_btn1bghrv_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_slider_btn1bghrv_color', array(
		'label' => 'Button BG Hover Color',
		'section' => 'luzuk_royal_banquet_hall_slider_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_slider_arrowicon_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_slider_arrowicon_color', array(
		'label' => 'Arrow Icon Color',
		'section' => 'luzuk_royal_banquet_hall_slider_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_slider_arrowbg_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_slider_arrowbg_color', array(
		'label' => 'Arrow BG Color',
		'section' => 'luzuk_royal_banquet_hall_slider_section',
	)));


	// aboutus Section
	$wp_customize->add_section('luzuk_royal_banquet_hall_aboutus_section',array(
		'title'	=> __('About Us Settings','royal-banquet-hall'),
		'description'=> __('<b>Note :</b> This section will appear below the Slider.','royal-banquet-hall'),
		'panel' => 'luzuk_royal_banquet_hall_panel_id',
	));

	$wp_customize->add_setting(
    	'luzuk_royal_banquet_hall_aboutus_img1',
	    array(
	        'sanitize_callback' => 'esc_url_raw'
	    )
	);
	$wp_customize->add_control(
	    new WP_Customize_Image_Control(
	        $wp_customize,
	        'luzuk_royal_banquet_hall_aboutus_img1',
	        array(
			    'label'   		=> __('Image 1','royal-banquet-hall'),
				'description'   		=> __('Image size 421*531','royal-banquet-hall'),
	            'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	            'settings' => 'luzuk_royal_banquet_hall_aboutus_img1',
	        )
	    )
	);

	$wp_customize->add_setting(
    	'luzuk_royal_banquet_hall_aboutus_img2',
	    array(
	        'sanitize_callback' => 'esc_url_raw'
	    )
	);
	$wp_customize->add_control(
	    new WP_Customize_Image_Control(
	        $wp_customize,
	        'luzuk_royal_banquet_hall_aboutus_img2',
	        array(
			    'label'   		=> __('Image 2','royal-banquet-hall'),
				'description'   		=> __('Image size 640*480','royal-banquet-hall'),
	            'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	            'settings' => 'luzuk_royal_banquet_hall_aboutus_img2',
	        )
	    )
	);

	$wp_customize->add_setting(
    	'luzuk_royal_banquet_hall_aboutus_img3',
	    array(
	        'sanitize_callback' => 'esc_url_raw'
	    )
	);
	$wp_customize->add_control(
	    new WP_Customize_Image_Control(
	        $wp_customize,
	        'luzuk_royal_banquet_hall_aboutus_img3',
	        array(
			    'label'   		=> __('Image 3','royal-banquet-hall'),
				'description'   		=> __('Image size 301*191','royal-banquet-hall'),
	            'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	            'settings' => 'luzuk_royal_banquet_hall_aboutus_img3',
	        )
	    )
	);
	

	$wp_customize->add_setting('luzuk_royal_banquet_hall_aboutusheading',array(
    	'default' => 'About us',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_aboutusheading',array(
	   	'type' => 'text',
	   	'label' => __('Heading','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_aboutustitle',array(
    	'default' => 'WE PROVIDE THE BEST SOLAR ENERGY SOLUTIONS',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_aboutustitle',array(
	   	'type' => 'text',
	   	'label' => __('Title','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_aboutusdescription',array(
    	'default' => 'The solar solution company specializes in providing innovation, eco-friendly energy systems that harness the sun power, reducing carbon footprints and energy costs of residental, commercial, and industrial clients worldwide.',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_aboutusdescription',array(
	   	'type' => 'text',
	   	'label' => __('Description','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_aboutusbox1heading',array(
    	'default' => 'Unsurpassed atmosphere',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_aboutusbox1heading',array(
	   	'type' => 'text',
	   	'label' => __('Box 1 Heading','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_aboutusbox1description',array(
    	'default' => 'Lorem Ipsum are many variations available bat believable.',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_aboutusbox1description',array(
	   	'type' => 'text',
	   	'label' => __('Box 1 Description','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_aboutusbox2heading',array(
    	'default' => 'Unsurpassed atmosphere',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_aboutusbox2heading',array(
	   	'type' => 'text',
	   	'label' => __('Box 2 Heading','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_aboutusbox2description',array(
    	'default' => 'Lorem Ipsum are many variations available bat believable.',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_aboutusbox2description',array(
	   	'type' => 'text',
	   	'label' => __('Box 2 Description','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_aboutussigndescription',array(
    	'default' => 'Lorem Ipsum is simply',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_aboutussigndescription',array(
	   	'type' => 'text',
	   	'label' => __('Box 2 Description','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	));

	$wp_customize->add_setting(
    	'luzuk_royal_banquet_hall_aboutus_signimg',
	    array(
	        'sanitize_callback' => 'esc_url_raw'
	    )
	);
	$wp_customize->add_control(
	    new WP_Customize_Image_Control(
	        $wp_customize,
	        'luzuk_royal_banquet_hall_aboutus_signimg',
	        array(
			    'label'   		=> __('Sign Image','royal-banquet-hall'),
				'description'   		=> __('Image size 100*100','royal-banquet-hall'),
	            'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	            'settings' => 'luzuk_royal_banquet_hall_aboutus_signimg',
	        )
	    )
	);
	
	$wp_customize->add_setting('luzuk_royal_banquet_hall_aboutussignheading',array(
    	'default' => 'David Anderson',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_aboutussignheading',array(
	   	'type' => 'text',
	   	'label' => __('Sign Heading','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_aboutussigndescription',array(
    	'default' => 'Lorem Ipsum is simply',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_aboutussigndescription',array(
	   	'type' => 'text',
	   	'label' => __('Sign Description','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_aboutus_heading_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_aboutus_heading_color', array(
		'label' => 'Heading Color',
		'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_aboutus_title_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_aboutus_title_color', array(
		'label' => 'Title Color',
		'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_aboutus_description_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_aboutus_description_color', array(
		'label' => 'Description Color',
		'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_aboutus_boxicon_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_aboutus_boxicon_color', array(
		'label' => 'Box Icon Color',
		'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_aboutus_boxtitle_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_aboutus_boxtitle_color', array(
		'label' => 'Box Title Color',
		'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_aboutus_boxdescription_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_aboutus_boxdescription_color', array(
		'label' => 'Box Description Color',
		'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_aboutus_signheading_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_aboutus_signheading_color', array(
		'label' => 'Sign Heading Color',
		'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_aboutus_signdescription_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_aboutus_signdescription_color', array(
		'label' => 'Sign Description Color',
		'section' => 'luzuk_royal_banquet_hall_aboutus_section',
	)));



	// services Section
	$wp_customize->add_section('luzuk_royal_banquet_hall_services_section',array(
		'title'	=> __('Services Settings','royal-banquet-hall'),
		'description'=> __('<b>Note :</b> This section will appear below the About Us.','royal-banquet-hall'),
		'panel' => 'luzuk_royal_banquet_hall_panel_id',
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_servicessubheading',array(
    	'default' => '',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_servicessubheading',array(
	   	'type' => 'text',
	   	'label' => __('Sub Heading','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_services_section',
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_servicesheading',array(
    	'default' => '',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('luzuk_royal_banquet_hall_servicesheading',array(
	   	'type' => 'text',
	   	'label' => __('Heading','royal-banquet-hall'),
	   	'section' => 'luzuk_royal_banquet_hall_services_section',
	));

	$pages = get_pages(); // Retrieve pages
	$page_options = array(); // Initialize page options array
	foreach ($pages as $page) {
		$page_options[$page->ID] = $page->post_title; // Store page ID and title in options array
	}

	$wp_customize->add_setting('luzuk_royal_banquet_hall_page_setting_1', array(
		'default'            => '',
		'sanitize_callback'  => 'absint', // Use absint to ensure the value is an integer
	));

	$wp_customize->add_control('luzuk_royal_banquet_hall_page_setting_1', array(
		'label'    => __('Select Page 1', 'royal-banquet-hall'),
		'section'  => 'luzuk_royal_banquet_hall_services_section', 
		'type'     => 'dropdown-pages',
	));



	$wp_customize->add_setting('luzuk_royal_banquet_hall_page_setting_2', array(
		'default'            => '',
		'sanitize_callback'  => 'absint', // Use absint to ensure the value is an integer
	));

	$wp_customize->add_control('luzuk_royal_banquet_hall_page_setting_2', array(
		'label'    => __('Select Page 2', 'royal-banquet-hall'),
		'section'  => 'luzuk_royal_banquet_hall_services_section', 
		'type'     => 'dropdown-pages',
	));


	$wp_customize->add_setting('luzuk_royal_banquet_hall_page_setting_3', array(
		'default'            => '',
		'sanitize_callback'  => 'absint', // Use absint to ensure the value is an integer
	));

	$wp_customize->add_control('luzuk_royal_banquet_hall_page_setting_3', array(
		'label'    => __('Select Page 3', 'royal-banquet-hall'),
		'section'  => 'luzuk_royal_banquet_hall_services_section', 
		'type'     => 'dropdown-pages',
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_page_setting_4', array(
		'default'            => '',
		'sanitize_callback'  => 'absint', // Use absint to ensure the value is an integer
	));

	$wp_customize->add_control('luzuk_royal_banquet_hall_page_setting_4', array(
		'label'    => __('Select Page 4', 'royal-banquet-hall'),
		'section'  => 'luzuk_royal_banquet_hall_services_section', 
		'type'     => 'dropdown-pages',
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_page_setting_5', array(
		'default'            => '',
		'sanitize_callback'  => 'absint', // Use absint to ensure the value is an integer
	));

	$wp_customize->add_control('luzuk_royal_banquet_hall_page_setting_5', array(
		'label'    => __('Select Page 5', 'royal-banquet-hall'),
		'section'  => 'luzuk_royal_banquet_hall_services_section', 
		'type'     => 'dropdown-pages',
	));

	$wp_customize->add_setting('luzuk_royal_banquet_hall_page_setting_6', array(
		'default'            => '',
		'sanitize_callback'  => 'absint', // Use absint to ensure the value is an integer
	));

	$wp_customize->add_control('luzuk_royal_banquet_hall_page_setting_6', array(
		'label'    => __('Select Page 6', 'royal-banquet-hall'),
		'section'  => 'luzuk_royal_banquet_hall_services_section', 
		'type'     => 'dropdown-pages',
	));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_services_subheading_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_services_subheading_color', array(
		'label' => 'Sub Heading Color',
		'section' => 'luzuk_royal_banquet_hall_services_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_services_heading_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_services_heading_color', array(
		'label' => 'Heading Color',
		'section' => 'luzuk_royal_banquet_hall_services_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_services_title_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_services_title_color', array(
		'label' => 'Title Color',
		'section' => 'luzuk_royal_banquet_hall_services_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_services_description_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_services_description_color', array(
		'label' => 'Description Color',
		'section' => 'luzuk_royal_banquet_hall_services_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_services_btntext_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_services_btntext_color', array(
		'label' => 'Button Text Color',
		'section' => 'luzuk_royal_banquet_hall_services_section',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_services_btnbg_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_services_btnbg_color', array(
		'label' => 'Button BG Color',
		'section' => 'luzuk_royal_banquet_hall_services_section',
	)));


	//Footer
    $wp_customize->add_section( 'luzuk_royal_banquet_hall_footer', array(
    	'title'  => __( 'Footer Settings', 'royal-banquet-hall' ),
		'priority' => null,
		'panel' => 'luzuk_royal_banquet_hall_panel_id'
	) );

	$wp_customize->add_setting('luzuk_royal_banquet_hall_show_back_totop',array(
       'default' => true,
       'sanitize_callback'	=> 'luzuk_royal_banquet_hall_sanitize_checkbox'
    ));
    $wp_customize->add_control('luzuk_royal_banquet_hall_show_back_totop',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Back to Top','royal-banquet-hall'),
       'section' => 'luzuk_royal_banquet_hall_footer'
    ));

    $wp_customize->add_setting('luzuk_royal_banquet_hall_footer_copy',array(
		'default' => 'Royal Banquet Hall WordPress Theme By Luzuk',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('luzuk_royal_banquet_hall_footer_copy',array(
		'label'	=> __('Copyright Text','royal-banquet-hall'),
		'section' => 'luzuk_royal_banquet_hall_footer',
		'setting' => 'luzuk_royal_banquet_hall_footer_copy',
		'type' => 'text'
	));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_footertext_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_footertext_color', array(
		'label' => 'Text Color',
		'section' => 'luzuk_royal_banquet_hall_footer',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_footeractivemenu_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_footeractivemenu_color', array(
		'label' => 'Active Menu Color',
		'section' => 'luzuk_royal_banquet_hall_footer',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_footercopyright_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_footercopyright_color', array(
		'label' => 'Copyright Color',
		'section' => 'luzuk_royal_banquet_hall_footer',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_footercopyrightbrd_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_footercopyrightbrd_color', array(
		'label' => 'Border Color',
		'section' => 'luzuk_royal_banquet_hall_footer',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_footerscrolltotoptext_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_footerscrolltotoptext_color', array(
		'label' => 'Scroll To Top Text Color',
		'section' => 'luzuk_royal_banquet_hall_footer',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_footerscrolltotopbg_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_footerscrolltotopbg_color', array(
		'label' => 'Scroll To Top BG Color',
		'section' => 'luzuk_royal_banquet_hall_footer',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_footerscrolltotoptexthover_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_footerscrolltotoptexthover_color', array(
		'label' => 'Scroll To Top Text Hover Color',
		'section' => 'luzuk_royal_banquet_hall_footer',
	)));

	$wp_customize->add_setting( 'luzuk_royal_banquet_hall_footerscrolltotophover_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'luzuk_royal_banquet_hall_footerscrolltotophover_color', array(
		'label' => 'Scroll To Top Hover Color',
		'section' => 'luzuk_royal_banquet_hall_footer',
	)));




	

	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'luzuk_royal_banquet_hall_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'luzuk_royal_banquet_hall_customize_partial_blogdescription',
	) );
}
add_action( 'customize_register', 'luzuk_royal_banquet_hall_customize_register' );

function luzuk_royal_banquet_hall_customize_partial_blogname() {
	bloginfo( 'name' );
}

function luzuk_royal_banquet_hall_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

if (class_exists('WP_Customize_Control')) {

   	class Luzuk_Royal_Banquet_Hall_Fontawesome_Icon_Chooser extends WP_Customize_Control {

      	public $type = 'icon';

      	public function render_content() { ?>
	     	<label>
	            <span class="customize-control-title">
	               <?php echo esc_html($this->label); ?>
	            </span>

	            <?php if ($this->description) { ?>
	                <span class="description customize-control-description">
	                   <?php echo wp_kses_post($this->description); ?>
	                </span>
	            <?php } ?>

	            <div class="royal-banquet-hall-selected-icon">
	                <i class="fa <?php echo esc_attr($this->value()); ?>"></i>
	                <span><i class="fa fa-angle-down"></i></span>
	            </div>

	            <ul class="royal-banquet-hall-icon-list clearfix">
	                <?php
	                $luzuk_royal_banquet_hall_font_awesome_icon_array = luzuk_royal_banquet_hall_font_awesome_icon_array();
	                foreach ($luzuk_royal_banquet_hall_font_awesome_icon_array as $luzuk_royal_banquet_hall_font_awesome_icon) {
	                   $icon_class = $this->value() == $luzuk_royal_banquet_hall_font_awesome_icon ? 'icon-active' : '';
	                   echo '<li class=' . esc_attr($icon_class) . '><i class="' . esc_attr($luzuk_royal_banquet_hall_font_awesome_icon) . '"></i></li>';
	                }
	                ?>
	            </ul>
	            <input type="hidden" value="<?php $this->value(); ?>" <?php $this->link(); ?> />
	        </label>
	        <?php
      	}
  	}
}
function luzuk_royal_banquet_hall_customizer_script() {
   wp_enqueue_style( 'font-awesome-1', esc_url(get_template_directory_uri()).'/assets/css/fontawesome-all.css');
}
add_action( 'customize_controls_enqueue_scripts', 'luzuk_royal_banquet_hall_customizer_script' );