<?php
/**
 * Customizer Functions
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Adjust Customizer Preview Responsive Sizes
 */
function wpbf_adjust_customizer_responsive_sizes() {

	// vars
	$medium_breakpoint = function_exists( 'wpbf_breakpoint_medium' ) ? wpbf_breakpoint_medium() : 768;
	$mobile_breakpoint = function_exists( 'wpbf_breakpoint_mobile' ) ? wpbf_breakpoint_mobile() : 480;

	$tablet_margin_left = -$medium_breakpoint/2 . 'px';
	$tablet_width = $medium_breakpoint . 'px';

	$mobile_margin_left = -$mobile_breakpoint/2 . 'px';
	$mobile_width = $mobile_breakpoint . 'px';

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
 * Minify CSS
 *
 * Function that's being used to minify Custom CSS
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
 * Generate Customizer CSS
 */
function wpbf_generate_css() {
 
	ob_start();
	include( get_template_directory() . '/inc/customizer/styles.php' );
	return wpbf_minify_css( ob_get_clean() );

}

/**
 * Create wpbf-customizer-styles.css file
 */
function wpbf_create_customizer_css_file() {

	if( apply_filters( 'wpbf_css_output', 'inline' ) !== 'file' ) return;

	$css = wpbf_generate_css();

	require_once( ABSPATH . 'wp-admin/includes/file.php' );

	global $wp_filesystem;

	$upload_dir = wp_upload_dir();
	$dir        = trailingslashit( $upload_dir['basedir'] ) . 'page-builder-framework/';

	WP_Filesystem();

	// create wpbf-customizer-styles.css file if it doesn't exist.
	if( !file_exists( $upload_dir['basedir'] .'/page-builder-framework/wpbf-customizer-styles.css' ) ) {

		$wp_filesystem->mkdir( $dir );
		$wp_filesystem->put_contents( $dir . 'wpbf-customizer-styles.css', $css, 0644 );

	} else {

		// override the file only if changes have been made to the customizer.
		// I'm not sure yet if it's better to override the file regardless or do this check.
		if( $css !== $wp_filesystem->get_contents( $dir . 'wpbf-customizer-styles.css' ) ) {

			$wp_filesystem->put_contents( $dir . 'wpbf-customizer-styles.css', $css, 0644 );

		}

	}

}
add_action( 'wp_loaded', 'wpbf_create_customizer_css_file' );

/**
 * Enqueue Customizer CSS
 */
function wpbf_customizer_frontend_scripts() {

	$css_output = apply_filters( 'wpbf_css_output', 'inline' );

	if( $css_output === 'inline' ) {

		$inline_styles = wpbf_generate_css();
		wp_add_inline_style( apply_filters( 'wpbf_add_inline_style', 'wpbf-style' ), $inline_styles );

	} elseif( $css_output === 'file' ) {

		$upload_dir = wp_upload_dir();

		if( file_exists( $upload_dir['basedir'] .'/page-builder-framework/wpbf-customizer-styles.css' ) ) {

			wp_enqueue_style( 'wpbf-customizer', $upload_dir['baseurl'] .'/page-builder-framework/wpbf-customizer-styles.css', '', WPBF_VERSION );

		}

	}

}
add_action( 'wp_enqueue_scripts', 'wpbf_customizer_frontend_scripts', 11 );

/**
 * Customizer CSS Live Preview
 */
function wpbf_customizer_preview_css() {

	if( !is_customize_preview() ) return;

	echo '<style type="text/css">';
	require( get_template_directory() . '/inc/customizer/styles.php' );
	echo '</style>';

}
add_action( 'wp_head', 'wpbf_customizer_preview_css', 999 );

/**
 * Post Message
 */
function wpbf_customizer_preview_js() {

	wp_enqueue_script( 'wpbf-postmessage', get_template_directory_uri() . '/inc/customizer/js/postmessage.js', array(  'jquery', 'customize-preview' ), '', true );

}
add_action( 'customize_preview_init' , 'wpbf_customizer_preview_js' );

/**
 * Scripts & Styles
 */
function wpbf_customizer_scripts_styles() {

	wp_enqueue_script( 'wpbf-customizer', get_template_directory_uri() . '/inc/customizer/js/wpbf-customizer.js', array( 'jquery' ), false, true );
	wp_enqueue_style( 'wpbf-customizer', get_template_directory_uri() . '/inc/customizer/css/wpbf-customizer.css' );

}
add_action( 'customize_controls_print_styles' , 'wpbf_customizer_scripts_styles' );

// Custom Controls
require( get_template_directory() . '/inc/customizer/custom-controls.php' );