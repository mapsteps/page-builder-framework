<?php
/**
 * Easy Digital Downloads integration.
 *
 * @package Page Builder Framework
 * @subpackage Integration/EDD
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Enqueue scripts & styles.
 */
function wpbf_edd_scripts() {

	wp_dequeue_style( 'edd-styles' );
	wp_deregister_style( 'edd-styles' );

	if ( class_exists( 'EDD_Software_Licensing' ) ) {

		wp_dequeue_style( 'edd-sl-styles' );
		wp_deregister_style( 'edd-sl-styles' );

	}

	// EDD default style.
	wp_enqueue_style( 'wpbf-edd', get_template_directory_uri() . '/css/min/edd-min.css', '', WPBF_VERSION );

}
add_action( 'wp_enqueue_scripts', 'wpbf_edd_scripts', 10 );

/**
 * Render EDD customizer settings.
 */
function wpbf_do_edd_customizer_settings() {

	// EDD Customizer settings.
	require_once WPBF_THEME_DIR . '/inc/integration/edd/edd-customizer-settings.php';

}
add_action( 'after_setup_theme', 'wpbf_do_edd_customizer_settings' );

// EDD functions.
require_once WPBF_THEME_DIR . '/inc/integration/edd/edd-functions.php';

// EDD customizer styles.
require_once WPBF_THEME_DIR . '/inc/integration/edd/edd-styles.php';
