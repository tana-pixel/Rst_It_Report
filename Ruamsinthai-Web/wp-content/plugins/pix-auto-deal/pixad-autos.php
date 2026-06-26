<?php
/*
Plugin Name: PixAutoDeal
Description: Auto Deal Options for Autlines Theme
Version: 1.8
Author: Templines
Author URI: templines.com

*/

/**====================================================================
==  Load Text domain
====================================================================*/
add_action('plugins_loaded', 'PixAutos_load_textdomain');
function PixAutos_load_textdomain() {
    load_plugin_textdomain( 'pixad', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}

if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'Pix_Autos' ) ) {
	class Pix_Autos {
        public $taxQuery;
        public $metaQuery;
        public $Query;
		
		/**
		 * Refers to a single instance of this class.
		 * 
		 * @rewritten
		 * @since 1.0
		 */
		private static $instance = null;
		
		/**
		 * Plugin Version
		 *
		 * @rewritten
		 * @since 1.0
		 */
		static private $version = '1.0.2';
		
		/**
		 * Class Constructor
		 *
		 * @rewritten
		 * @since 1.0
		 */
		function __construct() {
			
			//add_action( 'plugins_loaded', array( $this, 'localization' ) );
			$this->init();
			
		}
		
		/**
		 * Creates or returns an instance of this class.
		 *
		 * @rewritten
		 * @since 1.0
		 */
		public static function get_instance() {
			
			if( null == self::$instance ) {
				self::$instance = new self;
			}
			
			return self::$instance;
		}
		
		/**
		 * Plugin Localization
		 *
		 * @rewritten
		 * @since 1.0
		 */
		function localization() {
			$path = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
			load_plugin_textdomain( 'pixad', false, $path );
		}
		
		/**
		 * Plugin Initialization
		 *
		 * @rewritten
		 * @since 1.0
		 */
		public function init() {
			
			$this->defines();
			$this->includes();
			
		}
		
		/**
		 * Plugin Defines
		 *
		 * @rewritten
		 * @since 1.0
		 */
		private function defines() {
			if( ! defined( 'TEXTDOMAIN' ) )
				   define( 'TEXTDOMAIN', 'pixad' );
			 
			if( ! defined( 'PIXAD_AUTO_URI' ) )
				   define( 'PIXAD_AUTO_URI', plugin_dir_url( __FILE__ ) );
			
			if( ! defined( 'PIXAD_AUTO_DIR' ) ) 
				   define( 'PIXAD_AUTO_DIR', plugin_dir_path( __FILE__ ) );
			  
			if( ! defined( 'PIXAD_TEMPLATES_DIR' ) ) 
				   define( 'PIXAD_TEMPLATES_DIR', PIXAD_AUTO_DIR . 'templates/' );

		}
		
		/**
		 * Include Necessary Files
		 *
		 * @rewritten
		 * @since 1.0
		 */
		private function includes() {
			$files = array(
				PIXAD_AUTO_DIR . 'classes/class.pixad-custom.php',
				PIXAD_AUTO_DIR . 'includes/backend/post_taxonomy_type.php',
				PIXAD_AUTO_DIR . 'install.php',
				PIXAD_AUTO_DIR . 'classes/class.pixad-settings.php',
				PIXAD_AUTO_DIR . 'classes/class.pixad-country.php',
				PIXAD_AUTO_DIR . 'classes/class.pixad-autos.php',
				PIXAD_AUTO_DIR . 'includes/global/media_uploader.php',
				PIXAD_AUTO_DIR . 'includes/functions_global.php',
				PIXAD_AUTO_DIR . 'includes/functions_backend.php',
				PIXAD_AUTO_DIR . 'includes/widgets/widget_sidebar.php',
			);
			if( $files ) {
				foreach( $files as $file ) {
					require_once $file;
				}
			}
		}

		/**
		 * Load Shortcodes
		 *
		 * @rewritten
		 * @since 0.7
		 */
		private function shortcodes() {
			$files = glob( PIXAD_AUTO_DIR . 'shortcodes/*.php' );
			foreach( $files as $file ) {
				require_once $file;
			}
		}

		/**
		 * Get Plugin Version
		 *
		 * @rewritten
		 * @since 1.0
		 */
		public static function version() {
			return self::$version;
		}



        public static function helping_form_server_url() {

		 return $_SERVER['REQUEST_URI'];

        }


	}
	Pix_Autos::get_instance();
}

register_activation_hook( __FILE__, 'pix_add_roles_on_plugin_activation' );
function pix_add_roles_on_plugin_activation() {
	add_role('autodealer', esc_attr('Autodealer', 'pixad'), array(
	 	'read'         => false, 
		'edit_posts'   => false,  
		'delete_posts' => false, 
		'upload_files' => true,  
	) );
}

add_filter('upload_mimes', 'pix_autodealer_upload_mimes');
function pix_autodealer_upload_mimes($mime_types){
	if(!empty( wp_get_current_user()->caps['autodealer'])){
		foreach ($mime_types as $key => $value) {
			if(!(
				$key === 'gif' ||
				$key === 'jpg|jpeg|jpe' ||
				$key === 'png' 
				 )){
				unset($mime_types[$key]);
			}
		}
  		return $mime_types;
	}
	return $mime_types;
}

//
if (!function_exists('pix_autodealer_output_info')) {

    function pix_autodealer_output_info($output_info = null) {

        if($output_info == null) {

            $return = '';

        } else {

            $return = fl_wp_kses($output_info);

        }

        return $return;
    }

}

if(!function_exists('pix_translate_validate_info')) {
    function pix_translate_validate_info($output_info = null,$text_domain = null) {
        $return = '';
        $text_domain1 ='autlines';
        if($text_domain != null ) {
            $text_domain1 =$text_domain;
        }
        if($output_info != null ) {
            $return = esc_html_e($output_info,$text_domain1);
        }

        return $return;
    }
}