<?php
/**
 * WooCommerce Integration
 *
 * @package Page Builder Framework
 * @subpackage Integration/WooCommerce
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function wpbf_woo_change_inline_style_location( $location ) {

	if ( !wpbf_is_premium() ) {
		$location = 'wpbf-woocommerce';
	}

	return $location;

}
add_filter( 'wpbf_add_inline_style', 'wpbf_woo_change_inline_style_location' );

// Theme Setup
add_action( 'after_setup_theme', 'wpbf_woo_theme_setup' );

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

// Remove Default WooCommerce Styles
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

// Styles & Scripts
add_action( 'wp_enqueue_scripts', 'wpbf_woo_scripts', 10 );
function wpbf_woo_scripts() {

	// woocommerce layout
	wp_enqueue_style( 'wpbf-woocommerce-layout', get_template_directory_uri() . '/css/min/woocommerce-layout-min.css', '', WPBF_VERSION );

	// woocommerce
	wp_enqueue_style( 'wpbf-woocommerce', get_template_directory_uri() . '/css/min/woocommerce-min.css', '', WPBF_VERSION );

	// woocommerce smallscreen
	wp_enqueue_style( 'wpbf-woocommerce-smallscreen', get_template_directory_uri() . '/css/min/woocommerce-smallscreen-min.css', '', WPBF_VERSION );

}

// WooCommerce Customizer Settings
require_once( WPBF_THEME_DIR . '/inc/integration/woocommerce/wpbf-kirki-woocommerce.php' );

// WooCommerce Functions
require_once( WPBF_THEME_DIR . '/inc/integration/woocommerce/woocommerce-functions.php' );

// WooCommerce Customizer Styles
require_once( WPBF_THEME_DIR . '/inc/integration/woocommerce/woocommerce-styles.php' );