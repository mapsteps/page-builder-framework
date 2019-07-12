<?php
/**
 * WooCommerce Integration
 *
 * @package Page Builder Framework
 * @subpackage Integration/WooCommerce
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Change WooCommerce Inline Styles Location
 */
function wpbf_woo_change_inline_style_location( $location ) {

	$location = wpbf_is_premium() ? 'wpbf-premium-woocommerce' : 'wpbf-woocommerce';

	return $location;

}
add_filter( 'wpbf_add_inline_style', 'wpbf_woo_change_inline_style_location' );

/**
 * Theme Setup
 */
function wpbf_woo_theme_setup() {

	// WooCommerce
	add_theme_support( 'woocommerce', array(
		'gallery_thumbnail_image_width' => 300,
		'single_image_width' => 800,
	) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

}
add_action( 'after_setup_theme', 'wpbf_woo_theme_setup' );

// Remove Default WooCommerce Styles
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

/**
 * Scripts & Styles
 */
function wpbf_woo_scripts() {

	// WooCommerce Layout
	wp_enqueue_style( 'wpbf-woocommerce-layout', get_template_directory_uri() . '/css/min/woocommerce-layout-min.css', '', WPBF_VERSION );

	// WooCommerce
	wp_enqueue_style( 'wpbf-woocommerce', get_template_directory_uri() . '/css/min/woocommerce-min.css', '', WPBF_VERSION );

	// WooCommerce Smallscreen
	wp_enqueue_style( 'wpbf-woocommerce-smallscreen', get_template_directory_uri() . '/css/min/woocommerce-smallscreen-min.css', '', WPBF_VERSION );

}
add_action( 'wp_enqueue_scripts', 'wpbf_woo_scripts', 10 );

// WooCommerce Customizer Settings
require_once( WPBF_THEME_DIR . '/inc/integration/woocommerce/wpbf-kirki-woocommerce.php' );

// WooCommerce Functions
require_once( WPBF_THEME_DIR . '/inc/integration/woocommerce/woocommerce-functions.php' );

// WooCommerce Customizer Styles
require_once( WPBF_THEME_DIR . '/inc/integration/woocommerce/woocommerce-styles.php' );