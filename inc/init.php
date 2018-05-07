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

// Options
require_once( WPBF_THEME_DIR . '/inc/options.php' );

// Kirki Framework
require_once( WPBF_THEME_DIR . '/assets/kirki/kirki.php' );

// Kirki Options
require_once( WPBF_THEME_DIR . '/inc/customizer/wpbf-kirki.php' );

// Body Classes
require_once( WPBF_THEME_DIR . '/inc/body-classes.php' );

// Helpers
require_once( WPBF_THEME_DIR . '/inc/helpers.php' );

// Comments
require_once( WPBF_THEME_DIR . '/inc/comments.php' );

// Misc
require_once( WPBF_THEME_DIR . '/inc/misc.php' );

// Customizer
require_once( WPBF_THEME_DIR . '/inc/customizer/customizer-functions.php' );

// Theme Mods
require_once( WPBF_THEME_DIR . '/inc/theme-mods.php' );

// WooCommerce
if ( class_exists( 'WooCommerce' ) ) {
	require_once( WPBF_THEME_DIR . '/inc/woocommerce.php' );
}

/* Template Parts */

// Pre Header
add_action( 'wpbf_pre_header', 'wpbf_do_pre_header' );
function wpbf_do_pre_header() {
	get_template_part( 'inc/template-parts/pre-header' );
}

// Header
add_action( 'wpbf_header', 'wpbf_do_header' );

function wpbf_do_header() {
	get_template_part( 'inc/template-parts/header' );
}

// Footer
add_action( 'wpbf_footer', 'wpbf_do_footer' );

function wpbf_do_footer() {
	get_template_part( 'inc/template-parts/footer' );
}

// 404
add_action('wpbf_404', 'wpbf_do_404');

function wpbf_do_404() {
	get_template_part( 'inc/template-parts/404' );
}