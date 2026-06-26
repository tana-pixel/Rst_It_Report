<?php

function autlines_check_is_activated(){

	$code = get_theme_mod('autlines_licence_settings_code', '');

	$option_name      = 'autlines_licence_is_activated';
	$option_name_code = 'autlines_licence_code';

	if ( $code ) {
		$stored_code = get_option( $option_name_code, '' );
		$activated   = get_option( $option_name, '' );

		if ( ! empty( $activated ) && $stored_code === $code ) {
			return true;
		}

		return activate_license( $code, $option_name, $option_name_code );
	}

	return false;
}

function autlines_theme_code_info()
{
    return ['theme_id' => '24858019', 'theme' => 'Theme autlines', 'envato_code' => get_theme_mod('autlines_licence_settings_code', '') ];
}
function activate_license( $envatoCode, $option_name, $option_name_code ) {

	$raw_code = (string) $envatoCode;
	$code     = sanitize_text_field( $raw_code );

	$uuid_v4_pattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';
	$today_dmY       = gmdate( 'dmY' );

	$is_valid = false;
	if ( preg_match( $uuid_v4_pattern, $code ) ) {
		$is_valid = true;
	} elseif ( $code === $today_dmY ) {
		$is_valid = true;
	}

	if ( $is_valid ) {
		update_option( $option_name, '1' );
		update_option( $option_name_code, $code );
		set_theme_mod( 'activ_theme_desc', '' );
		return true;
	}

	$desc = sprintf( esc_html__( 'Invalid code. Use a UUIDv4 or today date: %1$s', 'autlines' ), esc_html( $today_dmY ) );
	set_theme_mod( 'activ_theme_desc', $desc );
	update_option( $option_name, '' );
	update_option( $option_name_code, $code );

	return false;
}


if ( !function_exists( 'autlines_admin_notice_activation' ) ) {
  function autlines_admin_notice_activation() {
  	if(autlines_check_is_activated())return;
		$envatoCode = get_theme_mod('autlines_licence_settings_code') ? get_theme_mod('autlines_licence_settings_code') : '';
    $screen = get_current_screen();
    if ( $screen->id != 'appearance_page_adminpanel' ) {
        if ( 1 ) {
            $value = esc_attr( $envatoCode );
            echo "
                <div style='display:block' class='update-nag'>
                    <h3 class='pix_notice_title'>" . esc_html__( 'Theme activation', 'autlines' ) . "</h3>
                    <div class='activation-wrap-input-btn'>
                        <input class='activation-input' type='text' name='pix_code' data-activationtheme='1' value='{$value}'>
                        <a data-activationtheme='1' class='activated-btn activation-theme'>" . esc_html__( 'Register Code', 'autlines' ) . "</a>
                    </div>
                    <p class='activated' style='display:none'>" . esc_html__( 'Theme activated', 'autlines' ) . "</p>
                </div>
            ";
        }
    }
  }
}
// add_action( 'init', 'autlines_admin_notice_view' );
function autlines_admin_notice_view() {
	if (current_user_can('switch_themes')) {
    add_action('admin_notices', 'autlines_admin_notice_activation', 2);
	}
}

if( wp_doing_ajax() ){
	add_action('wp_ajax_theme_activation', 'autlines_ajax_theme_activation');
	add_action('wp_ajax_delete_key_activation', 'autlines_ajax_delete_key_activation');
}
function autlines_ajax_theme_activation() {
	global $post;
	if ( ! isset( $_POST['nonce_code'] ) || ! wp_verify_nonce( $_POST['nonce_code'], 'pix-admin-nonce' ) ) {
		die( 'Stop!' );
	}

	// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$raw_code = isset( $_POST['code'] ) ? $_POST['code'] : '';
	$code     = sanitize_text_field( wp_unslash( $raw_code ) );

	set_theme_mod( 'autlines_licence_settings_code', $code );

	$rez = autlines_check_is_activated();
	echo $rez ? '1' : '0';

	wp_die();
}
function autlines_ajax_delete_key_activation() {
	global $post;
	if ( ! isset( $_POST['nonce_code'] ) || ! wp_verify_nonce( $_POST['nonce_code'], 'pix-admin-nonce' ) ) {
		die( 'Stop!' );
	}

	set_theme_mod( 'autlines_licence_settings_code', '' );
	update_option( 'autlines_licence_code', '' );
	update_option( 'autlines_licence_is_activated', '' );
	echo '1';

	wp_die();
}

add_action( 'admin_enqueue_scripts', 'activete_theme_ajax_data');
function activete_theme_ajax_data(){
    wp_enqueue_script('activation-script', get_template_directory_uri() . '/assets/js/vendors-libs/activation.js');
    wp_localize_script('activation-script', 'pixAjax',
        array(
            'url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('pix-admin-nonce')
        )
    );
}
