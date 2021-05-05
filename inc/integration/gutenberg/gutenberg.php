<?php
/**
 * Gutenberg integration.
 *
 * @package Page Builder Framework
 * @subpackage Integration/Gutenberg
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Theme setup.
 */
function wpbf_gutenberg_theme_setup() {

	// Editor styles.
	add_theme_support( 'editor-styles' );

	// Add support for wide aligned elements.
	add_theme_support( 'align-wide' );

	// Gutenberg default font sizes.

	// Page font size.
	$page_font_size_desktop = get_theme_mod( 'page_font_size_desktop' ) ? (int) get_theme_mod( 'page_font_size_desktop' ) : 16;

	// Only use page font size if it's not greater then the next larger font size.
	if ( $page_font_size_desktop >= 20 ) {
		$page_font_size_desktop = 16;
	}

	add_theme_support(
		'editor-font-sizes',
		array(

			array(
				'name'      => __( 'tiny', 'page-builder-framework' ),
				'shortName' => __( 'XS', 'page-builder-framework' ),
				'size'      => 12,
				'slug'      => 'tiny',
			),

			array(
				'name'      => __( 'small', 'page-builder-framework' ),
				'shortName' => __( 'S', 'page-builder-framework' ),
				'size'      => 14,
				'slug'      => 'small',
			),

			array(
				'name'      => __( 'regular', 'page-builder-framework' ),
				'shortName' => __( 'M', 'page-builder-framework' ),
				'size'      => $page_font_size_desktop,
				'slug'      => 'regular',
			),

			array(
				'name'      => __( 'large', 'page-builder-framework' ),
				'shortName' => __( 'L', 'page-builder-framework' ),
				'size'      => 20,
				'slug'      => 'large',
			),

			array(
				'name'      => __( 'larger', 'page-builder-framework' ),
				'shortName' => __( 'XL', 'page-builder-framework' ),
				'size'      => 32,
				'slug'      => 'larger',
			),

			array(
				'name'      => __( 'extra', 'page-builder-framework' ),
				'shortName' => __( 'XXL', 'page-builder-framework' ),
				'size'      => 44,
				'slug'      => 'extra',
			),

		)
	);

}
add_action( 'after_setup_theme', 'wpbf_gutenberg_theme_setup' );

/**
 * Generate CSS.
 */
function wpbf_generate_gutenberg_css() {

	ob_start();
	include_once WPBF_THEME_DIR . '/inc/integration/gutenberg/gutenberg-styles.php';
	return wpbf_minify_css( ob_get_clean() );

}

/**
 * Add editor styles.
 */
function wpbf_gutenberg_block_editor_assets() {

	$inline_styles = wpbf_generate_gutenberg_css();

	wp_enqueue_style( 'wpbf-gutenberg-style', get_template_directory_uri() . '/css/block-editor-styles.css', '', WPBF_VERSION );
	wp_add_inline_style( 'wpbf-gutenberg-style', $inline_styles );

}
add_action( 'enqueue_block_editor_assets', 'wpbf_gutenberg_block_editor_assets' );

/**
 * Register blocks category.
 *
 * @param array  $categories Block categories.
 * @param object $post Post object.
 *
 * @return array The modified block categories.
 */
function wpbf_register_blocks_category( $categories, $post ) {

	return array_merge(
		$categories,
		array(
			array(
				'slug'  => 'wpbf',
				'title' => __( 'Page Builder Framework', 'page-builder-framework' ),
				'icon'  => 'dashicons-info-outline',
			),
		)
	);

}
add_filter( 'block_categories', 'wpbf_register_blocks_category', 10, 2 );

/**
 * Enqueue block editor assets.
 */
function wpbf_enqueue_block_editor_assets() {

	$enqueue_data = require __DIR__ . '/build/editor.asset.php';
	$version      = $enqueue_data['version'];
	$dependencies = $enqueue_data['dependencies'];

	wp_enqueue_style( 'wpbf-css-framework', WPBF_THEME_URI . '/css/min/framework-min.css', array(), $version );
	wp_enqueue_style( 'wpbf-blocks-editor', WPBF_THEME_URI . '/inc/integration/gutenberg/build/editor.css', array(), $version );

	wp_enqueue_script( 'wpbf-blocks-editor', WPBF_THEME_URI . '/inc/integration/gutenberg/build/editor.js', $dependencies, $version, true );

	wp_add_inline_script(
		'wp-block-editor',
		'var wpbfBlocks = {};',
		'before'
	);

}
add_action( 'enqueue_block_editor_assets', 'wpbf_enqueue_block_editor_assets' );

/**
 * Enqueue block assets for both editor and frontend.
 */
function wpbf_enqueue_block_assets() {

	$enqueue_data = require __DIR__ . '/build/blocks.asset.php';
	$version      = $enqueue_data['version'];
	$dependencies = $enqueue_data['dependencies'];

	wp_enqueue_style( 'wpbf-blocks', WPBF_THEME_URI . '/inc/integration/gutenberg/build/editor.css', array(), $version );

	wp_enqueue_script( 'wpbf-blocks', WPBF_THEME_URI . '/inc/integration/gutenberg/build/editor.js', $dependencies, $version, true );

}
add_action( 'enqueue_block_editor_assets', 'wpbf_enqueue_block_assets' );

/**
 * Register blocks.
 */
function wpbf_register_blocks() {
	$scan = glob( __DIR__ . '/blocks/*/block.php' );

	foreach ( $scan as $path ) {
		$explode    = explode( '/', $path );
		$block_name = $explode[ count( $explode ) - 2 ];
		$func_name  = str_ireplace( '-', '_', $block_name );

		require_once $path;
	}
}
add_action( 'after_setup_theme', 'wpbf_register_blocks' );
