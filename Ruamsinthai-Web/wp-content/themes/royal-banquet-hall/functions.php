<?php
/**
 * Royal Banquet Hall functions and definitions
 *
 * @subpackage Royal Banquet Hall
 * @since 1.0
 */

include get_theme_file_path( 'vendor/wptrt/autoload/src/Luzuk_Royal_Banquet_Hall_Loader.php' );

$Luzuk_Royal_Banquet_Hall_Loader = new \WPTRT\Autoload\Luzuk_Royal_Banquet_Hall_Loader();

$Luzuk_Royal_Banquet_Hall_Loader->luzuk_royal_banquet_hall_add( 'WPTRT\\Customize\\Section', get_theme_file_path( 'vendor/wptrt/customize-section-button/src' ) );

$Luzuk_Royal_Banquet_Hall_Loader->luzuk_royal_banquet_hall_register();

function luzuk_royal_banquet_hall_setup() {
	
	load_theme_textdomain( 'royal-banquet-hall', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form', ) );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-background', $defaults = array(
	    'default-color'          => '',
	    'default-image'          => '',
	    'default-repeat'         => '',
	    'default-position-x'     => '',
	    'default-attachment'     => '',
	    'wp-head-callback'       => '_custom_background_cb',
	    'admin-head-callback'    => '',
	    'admin-preview-callback' => ''
	));

	$GLOBALS['content_width'] = 525;
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'royal-banquet-hall' ),
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css' ) );

}
add_action( 'after_setup_theme', 'luzuk_royal_banquet_hall_setup' );

function luzuk_royal_banquet_hall_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'royal-banquet-hall' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'royal-banquet-hall' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h2 class="widget-title">',
		'after_title'   => '</h2></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar 2', 'royal-banquet-hall' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your pages and posts', 'royal-banquet-hall' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h2 class="widget-title">',
		'after_title'   => '</h2></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar 3', 'royal-banquet-hall' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your pages and posts', 'royal-banquet-hall' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h2 class="widget-title">',
		'after_title'   => '</h2></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'royal-banquet-hall' ),
		'id'            => 'footer-1',
		'description'   => __( 'Add widgets here to appear in your footer.', 'royal-banquet-hall' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'royal-banquet-hall' ),
		'id'            => 'footer-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'royal-banquet-hall' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 3', 'royal-banquet-hall' ),
		'id'            => 'footer-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'royal-banquet-hall' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 4', 'royal-banquet-hall' ),
		'id'            => 'footer-4',
		'description'   => __( 'Add widgets here to appear in your footer.', 'royal-banquet-hall' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'luzuk_royal_banquet_hall_widgets_init' );

function luzuk_royal_banquet_hall_fonts_url(){

	$font_url = '';
	$font_family = array();
	$font_family[] = 'Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i';

	$font_family[] = 'Space+Grotesk:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i';

	$font_family[] = 'Playfair+Display:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i';



	$query_args = array(
		'family' => rawurlencode(implode('|',$font_family)),
	);
	$font_url = add_query_arg($query_args,'//fonts.googleapis.com/css');
	return $font_url;
}

function luzuk_enqueue_google_fonts() {
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Jost:400,500,700&display=swap');
}
add_action('wp_enqueue_scripts', 'luzuk_enqueue_google_fonts');



//Enqueue scripts and styles.
function luzuk_royal_banquet_hall_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'royal-banquet-hall-fonts', luzuk_royal_banquet_hall_fonts_url(), array(), null );
	
	//Bootstarp 
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri().'/assets/css/bootstrap.css' );
	
	// Theme stylesheet.
	wp_enqueue_style( 'royal-banquet-hall-basic-style', get_stylesheet_uri() );

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'royal-banquet-hall-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'royal-banquet-hall-style' ), '1.0' );
		wp_style_add_data( 'royal-banquet-hall-ie9', 'conditional', 'IE 9' );
	}
	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'royal-banquet-hall-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'royal-banquet-hall-style' ), '1.0' );
	wp_style_add_data( 'royal-banquet-hall-ie8', 'conditional', 'lt IE 9' );


	wp_enqueue_style( 'owl-carousel-css', get_template_directory_uri().'/assets/css/owl-carousel.css' );
	wp_enqueue_style( 'owl-default-css', get_template_directory_uri().'/assets/css/owl-default.css' );

	
	//font-awesome
	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/assets/css/font-awesome.css' );
	wp_enqueue_style( 'font-awesome-css', get_template_directory_uri().'/assets/css/fontawesome-all.css' );

	wp_enqueue_style('custom-animations', get_template_directory_uri() . '/assets/css/animations.css');

	require get_parent_theme_file_path( '/lz-custom-style.php' );
	wp_add_inline_style( 'royal-banquet-hall-basic-style',$luzuk_royal_banquet_hall_custom_style );

	wp_enqueue_script( 'ajax-jquery', get_template_directory_uri(). '/assets/js/ajaxjquery.js', array('jquery') );

	wp_enqueue_script( 'owl-carousel', get_theme_file_uri( '/assets/js/owl-carousel.js' ), array( 'jquery' ) );

	wp_enqueue_script( 'custom-script', get_theme_file_uri( '/assets/js/customscript.js' ), array( 'jquery' ) );

	wp_enqueue_script( 'index-js', get_theme_file_uri( '/assets/js/index.js' ), array( 'jquery' ), '2.1.2', true );

	wp_enqueue_script( 'royal-banquet-hall-navigation-jquery', get_theme_file_uri( '/assets/js/navigation.js' ), array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri(). '/assets/js/bootstrap.js', array('jquery') );
	wp_enqueue_script( 'jquery-superfish', get_template_directory_uri(). '/assets/js/jquery.superfish.js', array('jquery') ,'',true);


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'luzuk_royal_banquet_hall_scripts' );

function luzuk_royal_banquet_hall_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'luzuk_royal_banquet_hall_front_page_template' );

function luzuk_royal_banquet_hall_sanitize_dropdown_pages( $page_id, $setting ) {
	// Ensure $input is an absolute integer.
	$page_id = absint( $page_id );
	// If $page_id is an ID of a published page, return it; otherwise, return the default.
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

function luzuk_royal_banquet_hall_sanitize_choices( $input, $setting ) {
    global $wp_customize; 
    $control = $wp_customize->get_control( $setting->id ); 
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function luzuk_royal_banquet_hall_sanitize_checkbox( $input ) {
	return ( ( isset( $input ) && true == $input ) ? true : false );
}

function luzuk_royal_banquet_hall_sanitize_phone_number( $phone ) {
	return preg_replace( '/[^\d+]/', '', $phone );
}

function luzuk_royal_banquet_hall_sanitize_float( $input ) {
    return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

/* Excerpt Limit Begin */
function luzuk_royal_banquet_hall_string_limit_words($string, $word_limit) {
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit)
	array_pop($words);
	return implode(' ', $words);
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'luzuk_royal_banquet_hall_loop_columns');
if (!function_exists('luzuk_royal_banquet_hall_loop_columns')) {
	function luzuk_royal_banquet_hall_loop_columns() {
		return 3; // 3 products per row
	}
}

/* Breadcrumb Begin */
function luzuk_royal_banquet_hall_breadcrumb() {
	if (!is_home()) {
		echo '<a href="';
			echo esc_url(home_url());
		echo '">';
			bloginfo('name');
		echo "</a>";
		if (is_category() || is_single()) {
			the_category(', ');
			if (is_single()) {
				echo "<span> ";
					the_title();
				echo "</span>";
			}
		} elseif (is_page()) {
			echo "<span>";
				the_title();
			echo "</span> ";
		}
	}
}


function luzuk_royal_banquet_hall_banner_image( $image_url ){
    global $post;

    if( is_singular() ){
        $image_url      = get_the_post_thumbnail_url( $post->ID, 'full' );
    }
    return $image_url;
}



require get_parent_theme_file_path( '/inc/custom-header.php' );

require get_parent_theme_file_path( '/inc/template-tags.php' );

require get_parent_theme_file_path( '/inc/template-functions.php' );

require get_parent_theme_file_path( '/inc/customizer.php' );

require get_parent_theme_file_path( '/inc/font-awesome-icons.php' );

require get_parent_theme_file_path( '/inc/wptt-webfont-loader.php' );

// Custom page walker.
require get_template_directory() . '/classes/class-Luzuk_Royal_Banquet_Hall-walker-page.php';

