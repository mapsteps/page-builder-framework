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

	// We only support blocks from WP version 5.9 and up.
	if ( version_compare( get_bloginfo( 'version' ), '5.9', '<' ) ) {
		return;
	}

	// Editor styles.
	add_theme_support( 'editor-styles' );

	// Add support for wide aligned elements.
	add_theme_support( 'align-wide' );

	// Register block categories.
	add_filter( 'block_categories_all', 'wpbf_register_blocks_category', 10, 2 );

	// Register PBF's blocks.
	wpbf_register_blocks();

}
add_action( 'after_setup_theme', 'wpbf_gutenberg_theme_setup' );

/**
 * Register blocks category.
 *
 * @param array                    $categories Array of categories for block types.
 * @param \WP_Block_Editor_Context $block_editor_context The current block editor context.
 *
 * @return array The modified block categories.
 */
function wpbf_register_blocks_category( $categories, $block_editor_context ) {

	return array_merge(
		$categories,
		array(
			array(
				'slug'  => 'wpbf',
				'title' => __( 'Page Builder Framework', 'page-builder-framework' ),
			),
		)
	);

}

/**
 * Register blocks.
 */
function wpbf_register_blocks() {

	$scan = glob( __DIR__ . '/blocks/*/block.php' );

	foreach ( $scan as $path ) {
		require_once $path;
	}

}

/**
 * Add editor styles.
 */
function wpbf_gutenberg_block_editor_assets() {

	if ( apply_filters( 'wpbf_block_editor_styles', true ) ) {
		$inline_styles = wpbf_generate_gutenberg_css();

		wp_enqueue_style( 'wpbf-gutenberg-style', get_template_directory_uri() . '/css/block-editor-styles.css', '', WPBF_VERSION );
		wp_add_inline_style( 'wpbf-gutenberg-style', $inline_styles );
	}

	// We only support blocks from WP version 5.9 and up.
	if ( version_compare( get_bloginfo( 'version' ), '5.9', '<' ) ) {
		return;
	}

	$dependencies = array( 'wp-block-editor', 'wp-blocks', 'wp-components', 'wp-element', 'wp-i18n', 'wp-polyfill', 'wp-primitives' );

	wp_enqueue_style( 'wpbf-block-editor', WPBF_THEME_URI . '/inc/integration/gutenberg/build/wpbf-block-editor.css', array(), WPBF_VERSION );

	wp_enqueue_script( 'wpbf-block-editor', WPBF_THEME_URI . '/inc/integration/gutenberg/build/wpbf-block-editor.js', $dependencies, WPBF_VERSION, true );

	wp_add_inline_script(
		'wp-block-editor',
		'var wpbfBlocks = {};',
		'before'
	);

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
