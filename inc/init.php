<?php
/**
 * Init
 *
 * All files are being called from here.
 *
 * @package Page Builder Framework
 */

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Is Premium
function wpbf_is_premium() {
	return function_exists( 'wpbf_premium' ) ? true : false;
}

// Backwards Compatibility
require_once( WPBF_THEME_DIR . '/inc/backwards-compatibility.php' );

// Options
require_once( WPBF_THEME_DIR . '/inc/options.php' );

// Kirki Framework
require_once( WPBF_THEME_DIR . '/assets/kirki/kirki.php' );

// Kirki Options
require_once( WPBF_THEME_DIR . '/inc/customizer/wpbf-kirki.php' );

// Body Classes
require_once( WPBF_THEME_DIR . '/inc/body-classes.php' );

// Breadcrumbs
if ( !function_exists( 'breadcrumb_trail' ) ) {
	require_once( WPBF_THEME_DIR . '/inc/breadcrumbs.php' );
}

// Helpers
require_once( WPBF_THEME_DIR . '/inc/helpers.php' );

// Comments
require_once( WPBF_THEME_DIR . '/inc/comments.php' );

// Misc
require_once( WPBF_THEME_DIR . '/inc/misc.php' );

// Gutenberg
require_once( WPBF_THEME_DIR . '/inc/integration/gutenberg/gutenberg.php' );

// Customizer
require_once( WPBF_THEME_DIR . '/inc/customizer/customizer-functions.php' );

// Theme Mods
require_once( WPBF_THEME_DIR . '/inc/theme-mods.php' );

// Header Footer Elementor
if( !function_exists( 'wpbf_header_footer_elementor_support' ) ) { // backwards compatibility check as this was earlier included in Premium. Will be removed at some point.
	require_once( WPBF_THEME_DIR . '/inc/integration/header-footer-elementor.php' );
}

// Easy Digital Downloads
if( class_exists( 'Easy_Digital_Downloads' ) ) {
	require_once( WPBF_THEME_DIR . '/inc/integration/edd/edd.php' );
}

// WooCommerce
if( class_exists( 'WooCommerce' ) ) {
	require_once( WPBF_THEME_DIR . '/inc/integration/woocommerce/woocommerce.php' );
}

/**
 * Pre Header
 */
function wpbf_do_pre_header() {
	get_template_part( 'inc/template-parts/pre-header' );
}
add_action( 'wpbf_pre_header', 'wpbf_do_pre_header' );

/**
 * Header
 */
function wpbf_do_header() {
	get_template_part( 'inc/template-parts/header' );
}
add_action( 'wpbf_header', 'wpbf_do_header' );

/**
 * Footer
 */
function wpbf_do_footer() {
	get_template_part( 'inc/template-parts/footer' );
}
add_action( 'wpbf_footer', 'wpbf_do_footer' );

/**
 * 404 Page
 */
function wpbf_do_404() {
	get_template_part( 'inc/template-parts/404' );
}
add_action( 'wpbf_404', 'wpbf_do_404' );