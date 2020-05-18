<?php
/**
 * WooCommerce integration.
 *
 * @package Page Builder Framework
 * @subpackage Integration/WooCommerce
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Change inline styles location.
 *
 * @param string $location The stylesheet handle.
 *
 * @return string The updated stylesheet handle.
 */
function wpbf_woo_change_inline_style_location( $location ) {

	// Don't change location if WooCommerce scripts are removed.
	if ( ! apply_filters( 'wpbf_woocommerce_scripts', true ) ) {
		return $location;
	}

	$location = wpbf_is_premium() ? 'wpbf-premium-woocommerce' : 'wpbf-woocommerce';

	return $location;

}
add_filter( 'wpbf_add_inline_style', 'wpbf_woo_change_inline_style_location' );

/**
 * Theme setup.
 */
function wpbf_woo_theme_setup() {

	add_theme_support( 'woocommerce', array(
		'gallery_thumbnail_image_width' => 300,
		'single_image_width'            => 800,
	) );

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

}
add_action( 'after_setup_theme', 'wpbf_woo_theme_setup' );

// Remove default WooCommerce styles.
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

/**
 * Enqueue scripts & styles.
 */
function wpbf_woo_scripts() {

	if ( ! apply_filters( 'wpbf_woocommerce_scripts', true ) ) {
		return;
	}

	// WooCommerce layout.
	wp_enqueue_style( 'wpbf-woocommerce-layout', get_template_directory_uri() . '/css/min/woocommerce-layout-min.css', '', WPBF_VERSION );

	// WooCommerce.
	wp_enqueue_style( 'wpbf-woocommerce', get_template_directory_uri() . '/css/min/woocommerce-min.css', '', WPBF_VERSION );

	// WooCommerce smallscreen.
	wp_enqueue_style( 'wpbf-woocommerce-smallscreen', get_template_directory_uri() . '/css/min/woocommerce-smallscreen-min.css', '', WPBF_VERSION );

	// WooCommerce.
	wp_enqueue_script( 'wpbf-woocommerce', get_template_directory_uri() . '/assets/woocommerce/js/woocommerce.js', array( 'jquery' ), WPBF_VERSION, true );

	// Single add to cart ajax.
	if ( is_product() && 'yes' === get_option( 'woocommerce_enable_ajax_add_to_cart' ) && get_theme_mod( 'woocommerce_single_add_to_cart_ajax' ) ) {
		wp_enqueue_script( 'wpbf-woocommerce-single-add-to-cart-ajax', get_template_directory_uri() . '/assets/woocommerce/js/woocommerce-single-add-to-cart-ajax.js', array( 'jquery' ), WPBF_VERSION, true );
	}

}
add_action( 'wp_enqueue_scripts', 'wpbf_woo_scripts', 10 );

// WooCommerce customizer settings.
require_once WPBF_THEME_DIR . '/inc/integration/woocommerce/wpbf-kirki-woocommerce.php';

// WooCommerce functions.
require_once WPBF_THEME_DIR . '/inc/integration/woocommerce/woocommerce-functions.php';

// WooCommerce customizer styles.
require_once WPBF_THEME_DIR . '/inc/integration/woocommerce/woocommerce-styles.php';
