<?php
/**
 * Graceful Trend Blog functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Graceful Trend Blog
 */

// ----------------------------------------------------------------------------------
//	Register Front-End Styles And Scripts
// ----------------------------------------------------------------------------------

function graceful_trend_blog_enqueue_child_styles() {
 
    wp_enqueue_style( 'graceful-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'graceful-trend-blog-style', get_stylesheet_directory_uri() . '/style.css', array( 'graceful-style' ), wp_get_theme()->get('Version') );
}
add_action( 'wp_enqueue_scripts', 'graceful_trend_blog_enqueue_child_styles' );


// Load after Theme Setup
function graceful_trend_blog_theme_setup() {

    // ----------------------------------------------------------------------------------
    //  Register Customizer
    // ----------------------------------------------------------------------------------
    function graceful_trend_blog_customize_register( $wp_customize ) {

        $wp_customize->add_panel(
            'layout_settings',
            array(
                'priority'   => 20,
                'capability' => 'edit_theme_options',
                'title'      => __( 'Top Navigaion', 'graceful-trend-blog' ),
            )
        );

        /** Top Navigation */
        // add Top Navigation section
        $wp_customize->add_section( 'graceful_top_navigation' , array(
            'title'      => esc_html__( 'Top Navigation', 'graceful-trend-blog' ),
            'priority'   => 23,
            'capability' => 'edit_theme_options'
        ) );

        // Top Navigation
        $wp_customize->add_setting( 'graceful_trend_blog_options[top_navigation_show]', array(
            'default'    => graceful_trend_blog_options('top_navigation_show'),
            'type'       => 'option',
            'transport'  => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'graceful_sanitize_checkboxes'
        ) );
        $wp_customize->add_control( 'graceful_trend_blog_options[top_navigation_show]', array(
            'label'     => esc_html__( 'Enable Top Navigation', 'graceful-trend-blog' ),
            'section'   => 'graceful_top_navigation',
            'type'      => 'checkbox',
            'priority'  => 1
        ) );

        // Top Navigation Background Color
        $wp_customize->add_setting( 'graceful_trend_blog_options[top_navigation_bg]', array(
            'default'    => graceful_trend_blog_options('top_navigation_bg'),
            'type'       => 'option',
            'transport'  => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'graceful_trend_blog_options[top_navigation_bg]', array(
            'label'     => esc_html__( 'Top Navigation Background Color', 'graceful-trend-blog' ),
            'section'   => 'graceful_top_navigation',
            'priority'  => 3
        ) ) );

        // Main Navigation Background Color
        $wp_customize->add_setting( 'graceful_trend_blog_options[main_navigation_bg]', array(
            'default'    => graceful_trend_blog_options('main_navigation_bg'),
            'type'       => 'option',
            'transport'  => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'graceful_trend_blog_options[main_navigation_bg]', array(
            'label'     => esc_html__( 'Main Navigation Background Color', 'graceful-trend-blog' ),
            'section'   => 'graceful_main_navigation',
            'priority'  => 15
        ) ) );

        /*** Trend Slider ***/
        // Trend Slider section
        $wp_customize->add_section( 'graceful_trend_slider' , array(
            'title'      => esc_html__( 'Trend Slider', 'graceful-trend-blog' ),
            'priority'   => 28,
            'capability' => 'edit_theme_options',
            'description' => esc_html__( 'Configure the Trend Slider navigation options.', 'graceful-trend-blog' ),
        ) );

        // Trend Slider Enable
        $wp_customize->add_setting( 'graceful_trend_blog_options[trend_slider_show]', array(
            'default'    => graceful_trend_blog_options( 'trend_slider_show' ),
            'type'       => 'option',
            'transport'  => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'graceful_sanitize_checkboxes'
        ) );
        $wp_customize->add_control( 'graceful_trend_blog_options[trend_slider_show]', array(
            'label'     => esc_html__( 'Enable Trend Slider', 'graceful-trend-blog' ),
            'section'   => 'graceful_trend_slider',
            'type'      => 'checkbox',
            'priority'  => 1
        ) );

        // Trend Slider Navigation Arrows
        $wp_customize->add_setting( 'graceful_trend_blog_options[trend_slider_arrows_show]', array(
            'default'    => graceful_trend_blog_options( 'trend_slider_arrows_show' ),
            'type'       => 'option',
            'transport'  => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'graceful_sanitize_checkboxes'
        ) );
        $wp_customize->add_control( 'graceful_trend_blog_options[trend_slider_arrows_show]', array(
            'label'     => esc_html__( 'Show Navigation Arrows', 'graceful-trend-blog' ),
            'section'   => 'graceful_trend_slider',
            'type'      => 'checkbox',
            'priority'  => 3
        ) );

        // Trend Slider Pagination Dots
        $wp_customize->add_setting( 'graceful_trend_blog_options[trend_slider_dots_show]', array(
            'default'    => graceful_trend_blog_options( 'trend_slider_dots_show' ),
            'type'       => 'option',
            'transport'  => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'graceful_sanitize_checkboxes'
        ) );
        $wp_customize->add_control( 'graceful_trend_blog_options[trend_slider_dots_show]', array(
            'label'     => esc_html__( 'Show Pagination Dots', 'graceful-trend-blog' ),
            'section'   => 'graceful_trend_slider',
            'type'      => 'checkbox',
            'priority'  => 5
        ) );

        // Trend Slider Accent Color
        $wp_customize->add_setting( 'graceful_trend_blog_options[trend_slider_accent_color]', array(
            'default'    => graceful_trend_blog_options( 'trend_slider_accent_color' ),
            'type'       => 'option',
            'transport'  => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'graceful_trend_blog_options[trend_slider_accent_color]', array(
            'label'     => esc_html__( 'Accent Color (Arrows, Button & Dots)', 'graceful-trend-blog' ),
            'section'   => 'graceful_trend_slider',
            'priority'  => 9,
            'description' => esc_html__( 'This color will be applied to navigation arrows, read more button, and active pagination dots.', 'graceful-trend-blog' )
        ) ) );

        /** Featured Boxes */
        // Featured Boxes section
        $wp_customize->add_section( 'graceful_trend_blog_featured_boxes' , array(
            'title'      => esc_html__( 'Trend Featured Boxes', 'graceful-trend-blog' ),
            'priority'   => 28,
            'capability' => 'edit_theme_options'
        ) );

        // Featured Boxes 1
        $wp_customize->add_setting( 'graceful_trend_blog_options[featured_boxes_show]', array(
            'default'    => graceful_trend_blog_options( 'featured_boxes_show' ),
            'type'       => 'option',
            'transport'  => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'graceful_sanitize_checkboxes'
        ) );
        $wp_customize->add_control( 'graceful_trend_blog_options[featured_boxes_show]', array(
            'label'     => esc_html__( 'Enable Featured Boxes', 'graceful-trend-blog' ),
            'section'   => 'graceful_trend_blog_featured_boxes',
            'type'      => 'checkbox',
            'priority'  => 1
        ) );

        // Featured Boxes Enable
        $wp_customize->add_setting( 'graceful_trend_blog_options[featured_boxes_show]', array(
            'default'    => graceful_trend_blog_options( 'featured_boxes_show' ),
            'type'       => 'option',
            'transport'  => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'graceful_sanitize_checkboxes'
        ) );
        $wp_customize->add_control( 'graceful_trend_blog_options[featured_boxes_show]', array(
            'label'     => esc_html__( 'Enable Featured Boxes', 'graceful-trend-blog' ),
            'section'   => 'graceful_trend_blog_featured_boxes',
            'type'      => 'checkbox',
            'priority'  => 1
        ) );

        // Featured Boxes 1
        $wp_customize->add_setting( 'graceful_trend_blog_options[featured_boxes_title_1]', array(
            'default'    => graceful_trend_blog_options( 'featured_boxes_title_1' ),
            'type'       => 'option',
            'transport'  => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control( 'graceful_trend_blog_options[featured_boxes_title_1]', array(
            'label'     => esc_html__( 'Title 1', 'graceful-trend-blog' ),
            'section'   => 'graceful_trend_blog_featured_boxes',
            'type'      => 'text',
            'priority'  => 9
        ) );

        $wp_customize->add_setting( 'graceful_trend_blog_options[featured_boxes_url_1]', array(
            'default'    => graceful_trend_blog_options( 'featured_boxes_url_1' ),
            'type'       => 'option',
            'transport'  => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_url_raw'
        ) );
        $wp_customize->add_control( 'graceful_trend_blog_options[featured_boxes_url_1]', array(
            'label'     => esc_html__( 'URL 1', 'graceful-trend-blog' ),
            'section'   => 'graceful_trend_blog_featured_boxes',
            'type'      => 'text',
            'priority'  => 11
        ) );

        $wp_customize->add_setting( 'graceful_trend_blog_options[featured_boxes_image_1]', array(
            'default'   => '',
            'type'      => 'option',
            'transport' => 'refresh',
            'sanitize_callback' => 'graceful_sanitize_number_absint'
        ) );
        $wp_customize->add_control(
            new WP_Customize_Cropped_Image_Control( $wp_customize, 'graceful_trend_blog_options[featured_boxes_image_1]', array(
                'label'         => esc_html__( 'Image 1', 'graceful-trend-blog' ),
                'section'       => 'graceful_trend_blog_featured_boxes',
                'flex_width'    => false,
                'flex_height'   => false,
                'width'         => 600,
                'height'        => 340,
                'priority'      => 13
            )
        ) );

        // Featured Boxes 2
        $wp_customize->add_setting( 'graceful_trend_blog_options[featured_boxes_title_2]', array(
            'default'    => graceful_trend_blog_options( 'featured_boxes_title_2' ),
            'type'       => 'option',
            'transport'  => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control( 'graceful_trend_blog_options[featured_boxes_title_2]', array(
            'label'     => esc_html__( 'Title 2', 'graceful-trend-blog' ),
            'section'   => 'graceful_trend_blog_featured_boxes',
            'type'      => 'text',
            'priority'  => 15
        ) );

        $wp_customize->add_setting( 'graceful_trend_blog_options[featured_boxes_url_2]', array(
            'default'    => graceful_trend_blog_options( 'featured_boxes_url_2' ),
            'type'       => 'option',
            'transport'  => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_url_raw'
        ) );
        $wp_customize->add_control( 'graceful_trend_blog_options[featured_boxes_url_2]', array(
            'label'     => esc_html__( 'URL 2', 'graceful-trend-blog' ),
            'section'   => 'graceful_trend_blog_featured_boxes',
            'type'      => 'text',
            'priority'  => 17
        ) );

        $wp_customize->add_setting( 'graceful_trend_blog_options[featured_boxes_image_2]', array(
            'default'   => '',
            'type'      => 'option',
            'transport' => 'refresh',
            'sanitize_callback' => 'graceful_sanitize_number_absint'
        ) );
        $wp_customize->add_control(
            new WP_Customize_Cropped_Image_Control( $wp_customize, 'graceful_trend_blog_options[featured_boxes_image_2]', array(
                'label'         => esc_html__( 'Image 2', 'graceful-trend-blog' ),
                'section'       => 'graceful_trend_blog_featured_boxes',
                'flex_width'    => false,
                'flex_height'   => false,
                'width'         => 600,
                'height'        => 340,
                'priority'      => 19
            )
        ) );

        // Featured Boxes 3
        $wp_customize->add_setting( 'graceful_trend_blog_options[featured_boxes_title_3]', array(
            'default'    => graceful_trend_blog_options( 'featured_boxes_title_3' ),
            'type'       => 'option',
            'transport'  => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control( 'graceful_trend_blog_options[featured_boxes_title_3]', array(
            'label'     => esc_html__( 'Title 3', 'graceful-trend-blog' ),
            'section'   => 'graceful_trend_blog_featured_boxes',
            'type'      => 'text',
            'priority'  => 21
        ) );

        $wp_customize->add_setting( 'graceful_trend_blog_options[featured_boxes_url_3]', array(
            'default'    => graceful_trend_blog_options( 'featured_boxes_url_3' ),
            'type'       => 'option',
            'transport'  => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_url_raw'
        ) );
        $wp_customize->add_control( 'graceful_trend_blog_options[featured_boxes_url_3]', array(
            'label'     => esc_html__( 'URL 3', 'graceful-trend-blog' ),
            'section'   => 'graceful_trend_blog_featured_boxes',
            'type'      => 'text',
            'priority'  => 23
        ) );

        $wp_customize->add_setting( 'graceful_trend_blog_options[featured_boxes_image_3]', array(
            'default'   => '',
            'type'      => 'option',
            'transport' => 'refresh',
            'sanitize_callback' => 'graceful_sanitize_number_absint'
        ) );
        $wp_customize->add_control(
            new WP_Customize_Cropped_Image_Control( $wp_customize, 'graceful_trend_blog_options[featured_boxes_image_3]', array(
                'label'         => esc_html__( 'Image 3', 'graceful-trend-blog' ),
                'section'       => 'graceful_trend_blog_featured_boxes',
                'flex_width'    => false,
                'flex_height'   => false,
                'width'         => 600,
                'height'        => 340,
                'priority'      => 25
            )
        ) );

        // Featured Boxes Layout Width
        $boxed_width_featured_boxes = array(
            'full' => esc_html__( 'Full', 'graceful-trend-blog' ),
            'wrapped' => esc_html__( 'Boxed', 'graceful-trend-blog' ),
        );

        $wp_customize->add_setting( 'graceful_trend_blog_options[featured_boxes_width]', array(
            'default'    => graceful_trend_blog_options( 'featured_boxes_width' ),
            'type'       => 'option',
            'transport'  => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'graceful_sanitize_select'
        ) );
        $wp_customize->add_control( 'graceful_trend_blog_options[featured_boxes_width]', array(
            'label'         => esc_html__( 'Featured Boxes Width', 'graceful-trend-blog' ),
            'section'       => 'graceful_basic',
            'type'          => 'select',
            'choices'       => $boxed_width_featured_boxes,
            'priority'      => 28
        ) );

    }
    add_action( 'customize_register', 'graceful_trend_blog_customize_register', 99 );

    // Sanitize number absint
    function graceful_sanitize_number_absint( $number, $setting ) {

        // ensure $number is an absolute integer
        $number = absint( $number );

        // return default if not integer
        return ( $number ? $number : $setting->default );

    }

    register_nav_menus(
        array(
            'top'  => esc_html__( 'Top Menu', 'graceful-trend-blog' ),
        )
    );

    function graceful_top_menu_fallback() {
        if ( current_user_can( 'edit_theme_options' ) ) {
            ?>
            <ul id="top-menu">
                <li>
                    <a href="<?php echo esc_url( home_url( '/wp-admin/nav-menus.php') ) ?>">
                        <?php esc_html_e( 'Set-up Top Menu', 'graceful-trend-blog' ) ?>
                    </a>
                </li>
            </ul>
            <?php
        }
    }

    function graceful_trend_blog_options( $controls ) {

        $graceful_trend_blog_defaults = array(
            'top_navigation_show' => true,
            'top_navigation_bg' => '#000000',
            'main_navigation_bg' => '#f2f2f2',
            'blog_grid_excerpt_length' => '30',
            // Trend Slider Defaults
            'trend_slider_show' => true,
            'trend_slider_arrows_show' => true,
            'trend_slider_dots_show' => true,
            'trend_slider_accent_color' => '#000000',
            'featured_boxes_show' => false,
            'featured_boxes_window' => true,
            'featured_boxes_width' => 'wrapped',
            'featured_boxes_title_1' => '',
            'featured_boxes_url_1' => '',
            'featured_boxes_image_1' => '',
            'featured_boxes_title_2' => '',
            'featured_boxes_url_2' => '',
            'featured_boxes_image_2' => '',
            'featured_boxes_title_3' => '',
            'featured_boxes_url_3' => '',
            'featured_boxes_image_3' => ''
        );

        // merge defaults and options
        $graceful_trend_blog_defaults = wp_parse_args( get_option( 'graceful_trend_blog_options' ), $graceful_trend_blog_defaults );

        // return control
        return $graceful_trend_blog_defaults[ $controls ];

    }
}
add_action( 'after_setup_theme', 'graceful_trend_blog_theme_setup' );

// ----------------------------------------------------------------------------------
//  New Thumbnail Sizes
// ----------------------------------------------------------------------------------
if ( function_exists( 'add_image_size' ) ) {
    // new column thumbnail size
    add_image_size( 'graceful-post-column-thumbnail', 364, 242, true );
}

// ----------------------------------------------------------------------------------
//  New Fonts
// ----------------------------------------------------------------------------------
function graceful_trend_blog_enqueue_assets()
{
    // Include the file.
    require_once get_theme_file_path('webfont-loader/wptt-webfont-loader.php');
    // Load the webfont.
    wp_enqueue_style(
        'minimalist-stories-fonts',
        wptt_get_webfont_url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Mulish:wght@400&display=auto'),
        array(),
        '1.0'
    );
}
add_action('wp_enqueue_scripts', 'graceful_trend_blog_enqueue_assets');