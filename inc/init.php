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

// Kirki framework.
require_once WPBF_THEME_DIR . '/assets/kirki/kirki.php';

// Kirki customizer settings.
require_once WPBF_THEME_DIR . '/inc/customizer/wpbf-kirki.php';

// Body classes.
require_once WPBF_THEME_DIR . '/inc/body-classes.php';

// Breadcrumbs.
if ( ! function_exists( 'breadcrumb_trail' ) ) {
	require_once WPBF_THEME_DIR . '/inc/breadcrumbs.php';
}

// Helpers.
require_once WPBF_THEME_DIR . '/inc/helpers.php';

// Comments.
require_once WPBF_THEME_DIR . '/inc/comments.php';

// Misc.
require_once WPBF_THEME_DIR . '/inc/misc.php';

// Gutenberg integration.
require_once WPBF_THEME_DIR . '/inc/integration/gutenberg/gutenberg.php';

// Customizer functions.
require_once WPBF_THEME_DIR . '/inc/customizer/customizer-functions.php';

// Theme mods.
require_once WPBF_THEME_DIR . '/inc/theme-mods.php';

add_action( 'admin_menu', 'wpbf_theme_settings_page' );

/**
 * Add theme settings.
 */
function wpbf_theme_settings_page() {
	// Don't add page if premium add-on is active.
	if ( wpbf_is_premium() ) {
		return;
	}

	add_theme_page( __( 'Theme Settings', 'page-builder-framework' ), __( 'Theme Settings', 'page-builder-framework' ), 'manage_options', 'wpbf-premium', 'wpbf_theme_settings_output' );
}

/**
 * Theme settings output.
 */
function wpbf_theme_settings_output() {
	require __DIR__ . '/output/settings-page.php';
}

/**
 * Enqueue nice-notice when necessary.
 */
function wpbf_enqueue_admin_scripts() {
	wp_enqueue_style( 'nice-notice', WPBF_THEME_URI . '/assets/css/nice-notice.css', array(), WPBF_VERSION );
}
add_action( 'admin_enqueue_scripts', 'wpbf_enqueue_admin_scripts' );

/**
 * Enqueue admin scripts no matter premium add-on is active or not.
 */
function wpbf_enqueue_setting_scripts() {
	$current_screen = get_current_screen();

	// Only show to "Theme Settings" page.
	if ( 'appearance_page_wpbf-premium' !== $current_screen->id ) {
		return;
	}

	wp_enqueue_style( 'settings-page', WPBF_THEME_URI . '/assets/css/settings-page.css', array(), WPBF_VERSION );
	wp_enqueue_style( 'wpbf-admin-page', WPBF_THEME_URI . '/assets/css/admin-page.css', array( 'settings-page' ), WPBF_VERSION );

	wp_enqueue_script( 'wpbf-admin-page', WPBF_THEME_URI . '/assets/js/admin-page.js', array( 'jquery' ), WPBF_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'wpbf_enqueue_setting_scripts' );

/**
 * Run action after theme activation.
 *
 * @param string   $old_theme_name The old theme name.
 * @param WP_Theme $old_theme Instance of the old theme.
 */
function wpbf_after_switch_theme( $old_theme_name, $old_theme ) {
	delete_option( 'wpbf_activation_notice_dismissed' );
}
add_action( 'after_switch_theme', 'wpbf_after_switch_theme', 10, 2 );

/**
 * Show activation notice when possible.
 */
function wpbf_show_activation_notice() {
	require __DIR__ . '/output/activation-notice.php';
}
add_action( 'admin_notices', 'wpbf_show_activation_notice' );

/* Integration */

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

// Beaver Themer integration.
// Backwards compatibility check as this was included in the Premium Add-On earlier.
if ( ! function_exists( 'wpbf_bb_header_footer_support' ) && class_exists( 'FLThemeBuilderLoader' ) && class_exists( 'FLBuilderLoader' ) ) {
	require_once WPBF_THEME_DIR . '/inc/integration/beaver-themer.php';
}

// Easy Digital Downloads integration.
if ( class_exists( 'Easy_Digital_Downloads' ) ) {
	require_once WPBF_THEME_DIR . '/inc/integration/edd/edd.php';
}

// WooCommerce integration.
if ( class_exists( 'WooCommerce' ) ) {
	require_once WPBF_THEME_DIR . '/inc/integration/woocommerce/woocommerce.php';
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
