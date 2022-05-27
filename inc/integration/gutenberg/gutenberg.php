<?php
/**
 * Gutenberg integration.
 *
 * @package Page Builder Framework
 * @subpackage Integration/Gutenberg
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Do block related stuff when they are supported in PBF.
 */
function wpbf_gutenberg_theme_setup() {

	// Editor styles.
	add_theme_support( 'editor-styles' );

	// Add support for wide aligned elements.
	add_theme_support( 'align-wide' );

}
add_action( 'after_setup_theme', 'wpbf_gutenberg_theme_setup' );

/**
 * Add editor styles.
 */
function wpbf_gutenberg_block_editor_assets() {

	if ( apply_filters( 'wpbf_block_editor_styles', true ) ) {
		$inline_styles = wpbf_generate_gutenberg_css();

		wp_enqueue_style( 'wpbf-gutenberg-style', get_template_directory_uri() . '/css/block-editor-styles.css', '', WPBF_VERSION );
		wp_add_inline_style( 'wpbf-gutenberg-style', $inline_styles );
	}

}
add_action( 'enqueue_block_editor_assets', 'wpbf_gutenberg_block_editor_assets' );

/**
 * Generate CSS.
 */
function wpbf_generate_gutenberg_css() {

	ob_start();
	include_once WPBF_THEME_DIR . '/inc/integration/gutenberg/gutenberg-styles.php';
	return wpbf_minify_css( ob_get_clean() );

}
