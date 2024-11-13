<?php
/**
 * Setting up theme settings.
 *
 * @package Page Builder Framework
 */

use Mapsteps\Wpbf\Customizer\Controls\Typography\FontsUtil;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Admin body class.
 *
 * @param string $classes The class names.
 */
function wpbf_theme_settings_admin_body_class( $classes ) {

	$screen = get_current_screen();

	if ( $screen->id !== 'appearance_page_wpbf-premium' ) {
		return $classes;
	}

	$classes .= ' heatbox-admin has-header';

	return $classes;

}
add_action( 'admin_body_class', 'wpbf_theme_settings_admin_body_class' );

/**
 * Add theme settings.
 */
function wpbf_theme_settings_page() {

	// Stop here if Premium Add-On is active.
	if ( wpbf_is_premium() ) {
		return;
	}

	add_theme_page( __( 'Theme Settings', 'page-builder-framework' ), __( 'Theme Settings', 'page-builder-framework' ), 'manage_options', 'wpbf-premium', 'wpbf_theme_settings_callback' );

}
add_action( 'admin_menu', 'wpbf_theme_settings_page' );

/**
 * Theme settings callback.
 */
function wpbf_theme_settings_callback() {
	require __DIR__ . '/settings/settings-page.php';
}

/**
 * Save activation notice dismissal.
 */
function wpbf_activation_notice_dismissal() {

	$nonce   = isset( $_POST['nonce'] ) ? $_POST['nonce'] : 0;
	$dismiss = isset( $_POST['dismiss'] ) ? absint( $_POST['dismiss'] ) : 0;

	if ( empty( $dismiss ) ) {
		wp_send_json_error( 'Invalid Request' );
	}

	if ( ! wp_verify_nonce( $nonce, 'WPBF_Dismiss_Activation_Notice' ) ) {
		wp_send_json_error( 'Invalid Token' );
	}

	update_option( 'wpbf_activation_notice_dismissed', 1 );
	wp_send_json_success( 'Activation notice has been dismissed.' );

}
add_action( 'wp_ajax_wpbf_activation_notice_dismissal', 'wpbf_activation_notice_dismissal' );

/**
 * Save BFCM notice dismissal.
 */
function wpbf_bfcm_notice_dismissal() {

	$nonce   = isset( $_POST['nonce'] ) ? $_POST['nonce'] : 0;
	$dismiss = isset( $_POST['dismiss'] ) ? absint( $_POST['dismiss'] ) : 0;

	if ( empty( $dismiss ) ) {
		wp_send_json_error( 'Invalid Request' );
	}

	if ( ! wp_verify_nonce( $nonce, 'WPBF_Dismiss_Bfcm_Notice' ) ) {
		wp_send_json_error( 'Invalid Token' );
	}

	update_option( 'wpbf_bfcm_notice_dismissed_2024', 1 );
	wp_send_json_success( 'BFCM notice has been dismissed.' );

}
add_action( 'wp_ajax_wpbf_bfcm_notice_dismissal', 'wpbf_bfcm_notice_dismissal' );

/**
 * Display activation notice.
 */
function wpbf_show_activation_notice() {

	// Stop here if Premium Add-On is active.
	if ( wpbf_is_premium() ) {
		return;
	}

	// Stop here if notice has been dismissed.
	if ( ! empty( get_option( 'wpbf_activation_notice_dismissed', 0 ) ) ) {
		return;
	}

	// Stop here if current user can't manage options.
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	require __DIR__ . '/settings/activation-notice.php';

}
add_action( 'admin_notices', 'wpbf_show_activation_notice' );

/**
 * Display BFCM notice.
 */
function wpbf_show_bfcm_notice() {

	// Stop here if Premium Add-On is active.
	if ( wpbf_is_premium() ) {
		return;
	}

	// Stop here if current user is not an admin.
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$start = strtotime( 'november 22nd, 2024' );
	$end   = strtotime( 'december 2nd, 2024' );
	$now   = time();

	// Stop here if we are not in the sales period.
	if ( $now < $start || $now > $end ) {
		return;
	}

	// Stop here if notice has been dismissed.
	if ( ! empty( get_option( 'wpbf_bfcm_notice_dismissed_2024', 0 ) ) ) {
		return;
	}

	require __DIR__ . '/settings/bfcm-notice.php';

}
add_action( 'admin_notices', 'wpbf_show_bfcm_notice' );

/**
 * Display compatibility notice.
 */
function wpbf_compatibility_notice() {

	// Stop here if current user can't manage options.
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Stop here if Premium Add-On is not outdated.
	if ( ! wpbf_is_premium_addon_outdated() ) {
		return;
	}

	require __DIR__ . '/settings/compatibility-notice.php';

}
add_action( 'admin_notices', 'wpbf_compatibility_notice' );

/**
 * Clear font cache directory.
 */
function wpbf_clear_font_cache() {

	$nonce = isset( $_POST['nonce'] ) ? $_POST['nonce'] : 0;

	if ( ! wp_verify_nonce( $nonce, 'WPBF_Clear_Font_Cache' ) ) {
		wp_send_json_error( 'Invalid Token' );
	}

	$result = ( new FontsUtil() )->clearDownloadedGoogleFonts();

	if ( is_wp_error( $result ) ) {
		wp_send_json_error( $result->get_error_message() );
	}

	wp_send_json_success( 'Font Cache cleared.', 'page-builder-framework' );

}
add_action( 'wp_ajax_wpbf_clear_font_cache', 'wpbf_clear_font_cache' );
