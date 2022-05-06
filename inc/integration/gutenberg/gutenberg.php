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

	if ( apply_filters( 'wpbf_block_editor_styles', true ) ) {
		$inline_styles = wpbf_generate_gutenberg_css();

		wp_enqueue_style( 'wpbf-gutenberg-style', get_template_directory_uri() . '/css/block-editor-styles.css', '', WPBF_VERSION );
		wp_add_inline_style( 'wpbf-gutenberg-style', $inline_styles );
	}

	if ( ! function_exists( 'register_block_type_from_metadata' ) ) {
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
 * Change the url of Page Builder Framework's block assets url.
 *
 * @see https://developer.wordpress.org/reference/functions/plugins_url/
 *
 * @param string $url    The complete URL to the plugins directory including scheme and path.
 * @param string $path   Path relative to the URL to the plugins directory. Blank string
 *                       if no path is specified.
 * @param string $plugin The plugin file path to be relative to. Blank string if no plugin
 *                       is specified.
 */
function wpbf_parse_block_assets_url( $url, $path, $plugin ) {

	if ( ! function_exists( 'register_block_type_from_metadata' ) ) {
		return;
	}

	if (
		false === stripos( $path, '../../build/wpbf-block-editor' ) &&
		false === stripos( $path, '../../build/wpbf-blocks' )
	) {
		return $url;
	}

	$path = str_ireplace( '../../build/wpbf-', '/build/wpbf-', $path );
	$url  = WPBF_THEME_URI . '/inc/integration/gutenberg' . $path;

	return $url;

}
add_filter( 'plugins_url', 'wpbf_parse_block_assets_url', 10, 3 );

/**
 * Register blocks category.
 *
 * @param array  $categories Block categories.
 * @param object $post Post object.
 *
 * @return array The modified block categories.
 */
function wpbf_register_blocks_category( $categories, $post ) {

	if ( ! function_exists( 'register_block_type_from_metadata' ) ) {
		return;
	}

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
add_filter( 'block_categories_all', 'wpbf_register_blocks_category', 10, 2 );

/**
 * Register blocks.
 */
function wpbf_register_blocks() {

	if ( ! function_exists( 'register_block_type_from_metadata' ) ) {
		return;
	}

	$scan = glob( __DIR__ . '/blocks/*/block.php' );

	foreach ( $scan as $path ) {
		$explode    = explode( '/', $path );
		$block_name = $explode[ count( $explode ) - 2 ];
		$func_name  = str_ireplace( '-', '_', $block_name );

		require_once $path;
	}

}
add_action( 'after_setup_theme', 'wpbf_register_blocks' );
