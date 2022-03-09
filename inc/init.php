<?php
/**
 * Init.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Check if Premium Add-On exists.
 *
 * @return bool True or false.
 */
function wpbf_is_premium() {
	return function_exists( 'wpbf_premium' ) ? true : false;
}

// Backwards compatibility.
require_once WPBF_THEME_DIR . '/inc/backwards-compatibility.php';

// Options.
require_once WPBF_THEME_DIR . '/inc/options.php';

// Quick edit.
require_once WPBF_THEME_DIR . '/inc/quick-edit.php';

// Kirki.
require_once WPBF_THEME_DIR . '/assets/kirki/kirki.php';

// Kirki Pro.
if ( ! class_exists( '\Kirki\Pro\HeadlineDivider\Init' ) ) {
	require_once WPBF_THEME_DIR . '/assets/kirki-pro/kirki-pro-headline-divider/vendor/autoload.php';
	new \Kirki\Pro\HeadlineDivider\Init();
}

if ( ! class_exists( '\Kirki\Pro\Tabs\Init' ) ) {
	require_once WPBF_THEME_DIR . '/assets/kirki-pro/kirki-pro-tabs/vendor/autoload.php';
	new \Kirki\Pro\Tabs\Init();
}

// Customizer settings.
require_once WPBF_THEME_DIR . '/inc/customizer/customizer-settings.php';

// Body classes.
require_once WPBF_THEME_DIR . '/inc/body-classes.php';

// Breadcrumbs.
if ( ! function_exists( 'breadcrumb_trail' ) ) {
	require_once WPBF_THEME_DIR . '/inc/breadcrumbs.php';
}

// Helpers.
require_once WPBF_THEME_DIR . '/inc/class-vars.php';
require_once WPBF_THEME_DIR . '/inc/helpers.php';

// Local Gravatars.
require_once WPBF_THEME_DIR . '/inc/gravatar.php';

// Misc.
require_once WPBF_THEME_DIR . '/inc/misc.php';

// Customizer functions.
require_once WPBF_THEME_DIR . '/inc/customizer/customizer-functions.php';

// Theme mods.
require_once WPBF_THEME_DIR . '/inc/theme-mods.php';

// Theme settings.
require_once WPBF_THEME_DIR . '/inc/theme-settings.php';

/* Integration */

// Gutenberg integration.
require_once WPBF_THEME_DIR . '/inc/integration/gutenberg/gutenberg.php';

// Header/Footer Elementor integration.
if ( ! function_exists( 'wpbf_header_footer_elementor_support' ) ) {
	// Backwards compatibility check as this was included in the Premium Add-On earlier.
	require_once WPBF_THEME_DIR . '/inc/integration/header-footer-elementor.php';
}

/**
 * Elementor Pro integration.
 *
 * @since 2.1
 */
function wpbf_do_elementor_pro_integration() {

	// Backwards compatibility check as this was included in the Premium Add-On earlier.
	if ( function_exists( 'wpbf_elementor_pro_integration' ) ) {
		return;
	}

	require_once WPBF_THEME_DIR . '/inc/integration/elementor-pro.php';

}
add_action( 'elementor_pro/init', 'wpbf_do_elementor_pro_integration' );

// Beaver Builder integration.
if ( class_exists( 'FLBuilderLoader' ) ) {
	require_once WPBF_THEME_DIR . '/inc/integration/beaver-builder.php';
}

// Beaver Themer integration.
// Backwards compatibility check as this was included in the Premium Add-On earlier.
if ( ! function_exists( 'wpbf_bb_header_footer_support' ) && class_exists( 'FLThemeBuilderLoader' ) && class_exists( 'FLBuilderLoader' ) ) {
	require_once WPBF_THEME_DIR . '/inc/integration/beaver-themer.php';
}

// Divi integration.
// if ( class_exists( 'ET_Builder_Plugin' ) ) {
// 	require_once WPBF_THEME_DIR . '/inc/integration/divi.php';
// }

// Easy Digital Downloads integration.
if ( class_exists( 'Easy_Digital_Downloads' ) ) {
	require_once WPBF_THEME_DIR . '/inc/integration/edd/edd.php';
}

// WooCommerce integration.
if ( class_exists( 'WooCommerce' ) ) {
	require_once WPBF_THEME_DIR . '/inc/integration/woocommerce/woocommerce.php';
}

// LifterLMS integration.
if ( class_exists( 'LifterLMS' ) ) {
	require_once WPBF_THEME_DIR . '/inc/integration/lifterlms/lifterlms.php';
}

/**
 * Render pre header.
 */
function wpbf_do_pre_header() {
	get_template_part( 'inc/template-parts/pre-header' );
}
add_action( 'wpbf_pre_header', 'wpbf_do_pre_header' );

/**
 * Render header.
 */
function wpbf_do_header() {
	get_template_part( 'inc/template-parts/header' );
}
add_action( 'wpbf_header', 'wpbf_do_header' );

/**
 * Render footer.
 */
function wpbf_do_footer() {
	get_template_part( 'inc/template-parts/footer' );
}
add_action( 'wpbf_footer', 'wpbf_do_footer' );

/**
 * Render 404 page.
 */
function wpbf_do_404() {
	get_template_part( 'inc/template-parts/404' );
}
add_action( 'wpbf_404', 'wpbf_do_404' );
