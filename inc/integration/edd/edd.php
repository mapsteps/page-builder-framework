<?php
/**
 * Easy Digital Downloads Integration
 *
 * @package Page Builder Framework
 * @subpackage Integration/EDD
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Styles & Scripts
add_action( 'wp_enqueue_scripts', 'wpbf_edd_scripts', 10 );
function wpbf_edd_scripts() {

	wp_dequeue_style( 'edd-styles' );
	wp_deregister_style( 'edd-styles' );

	// EDD Default Style
	wp_enqueue_style( 'wpbf-edd', get_template_directory_uri() . '/css/min/edd-min.css', '', WPBF_VERSION );

}

// // WooCommerce Customizer Settings
// require_once( WPBF_THEME_DIR . '/inc/integration/edd/wpbf-kirki-edd.php' );

// // WooCommerce Functions
// require_once( WPBF_THEME_DIR . '/inc/integration/edd/edd-functions.php' );

// // WooCommerce Customizer Styles
// require_once( WPBF_THEME_DIR . '/inc/integration/edd/edd-styles.php' );