<?php
/**
 * Customizer function.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Adjust customizer preview.
 */
function wpbf_adjust_customizer_responsive_sizes() {

	$medium_breakpoint = function_exists( 'wpbf_breakpoint_medium' ) ? wpbf_breakpoint_medium() : 768;
	$mobile_breakpoint = function_exists( 'wpbf_breakpoint_mobile' ) ? wpbf_breakpoint_mobile() : 480;

	$tablet_margin_left = -$medium_breakpoint / 2 . 'px';
	$tablet_width       = $medium_breakpoint . 'px';

	$mobile_margin_left = -$mobile_breakpoint / 2 . 'px';
	$mobile_width       = $mobile_breakpoint . 'px';

	?>

	<style>
		.wp-customizer .preview-tablet .wp-full-overlay-main {
			margin-left: <?php echo esc_attr( $tablet_margin_left ); ?>;
			width: <?php echo esc_attr( $tablet_width ); ?>;
		}
		.wp-customizer .preview-mobile .wp-full-overlay-main {
			margin-left: <?php echo esc_attr( $mobile_margin_left ); ?>;
			width: <?php echo esc_attr( $mobile_width ); ?>;
			height: 680px;
		}
	</style>

	<?php

}
add_action( 'customize_controls_print_styles', 'wpbf_adjust_customizer_responsive_sizes' );

/**
 * Minify CSS.
 *
 * @param string $css The css.
 *
 * @return string The minified CSS.
 */
function wpbf_minify_css( $css ) {

	// Remove Comments
	$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
	// Remove space after colons
	$css = str_replace( ': ', ':', $css );
	$css = str_replace( ' {', '{', $css );
	$css = str_replace( ', ', ',', $css );
	// Remove whitespace
	$css = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css );

	return $css;

}

/**
 * Generate customizer CSS.
 */
function wpbf_generate_css() {

	ob_start();
	include get_template_directory() . '/inc/customizer/styles.php';
	return wpbf_minify_css( ob_get_clean() );

}

/**
 * Create wpbf-customizer-styles.css file.
 */
function wpbf_create_customizer_css_file() {

	if ( 'file' !== apply_filters( 'wpbf_css_output', 'inline' ) ) {
		return;
	}

	$css = wpbf_generate_css();

	require_once ABSPATH . 'wp-admin/includes/file.php';

	global $wp_filesystem;

	$upload_dir = wp_upload_dir();
	$dir        = trailingslashit( $upload_dir['basedir'] ) . 'page-builder-framework/';

	WP_Filesystem();

	// Create wpbf-customizer-styles.css file if it doesn't exist.
	if ( ! file_exists( $upload_dir['basedir'] . '/page-builder-framework/wpbf-customizer-styles.css' ) ) {

		$wp_filesystem->mkdir( $dir );
		$wp_filesystem->put_contents( $dir . 'wpbf-customizer-styles.css', $css, 0644 );

	} else {

		// Override the file only if changes were made to the customizer.
		if ( $css !== $wp_filesystem->get_contents( $dir . 'wpbf-customizer-styles.css' ) ) {

			$wp_filesystem->put_contents( $dir . 'wpbf-customizer-styles.css', $css, 0644 );

		}
	}

}
add_action( 'wp_loaded', 'wpbf_create_customizer_css_file' );

/**
 * Enqueue customizer CSS.
 */
function wpbf_customizer_frontend_scripts() {

	$css_output = apply_filters( 'wpbf_css_output', 'inline' );

	if ( 'inline' === $css_output ) {

		$inline_styles = wpbf_generate_css();
		wp_add_inline_style( apply_filters( 'wpbf_add_inline_style', 'wpbf-style' ), $inline_styles );

	} elseif ( 'file' === $css_output ) {

		$upload_dir = wp_upload_dir();

		if ( file_exists( $upload_dir['basedir'] . '/page-builder-framework/wpbf-customizer-styles.css' ) ) {

			wp_enqueue_style( 'wpbf-customizer', $upload_dir['baseurl'] . '/page-builder-framework/wpbf-customizer-styles.css', '', WPBF_VERSION );

		}
	}

}
add_action( 'wp_enqueue_scripts', 'wpbf_customizer_frontend_scripts', 11 );

/**
 * Customizer CSS live preview.
 */
function wpbf_customizer_preview_css() {

	if ( ! is_customize_preview() ) {
		return;
	}

	echo '<style id="wpbf-customize-saved-styles">';
	require get_template_directory() . '/inc/customizer/styles.php';
	echo '</style>';

}
add_action( 'wp_head', 'wpbf_customizer_preview_css', 999 );

/**
 * Post message.
 */
function wpbf_customizer_preview_js() {

	wp_enqueue_script( 'wpbf-postmessage', get_template_directory_uri() . '/inc/customizer/js/postmessage.js', array( 'jquery', 'customize-preview' ), WPBF_VERSION, true );

}
add_action( 'customize_preview_init', 'wpbf_customizer_preview_js' );

/**
 * Enqueue customizer scripts & styles.
 */
function wpbf_customizer_scripts_styles() {

	wp_enqueue_script( 'wpbf-customizer', get_template_directory_uri() . '/inc/customizer/js/customizer.js', array( 'jquery' ), WPBF_VERSION, true );
	wp_enqueue_style( 'wpbf-customizer', get_template_directory_uri() . '/inc/customizer/css/customizer.css', '', WPBF_VERSION );

}
add_action( 'customize_controls_print_styles', 'wpbf_customizer_scripts_styles' );

// Custom controls.
require get_template_directory() . '/inc/customizer/controls/custom-controls.php';
