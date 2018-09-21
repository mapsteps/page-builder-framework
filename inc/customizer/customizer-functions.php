<?php
/**
 * Customizer Functions
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Adjust Tablet Size
function wpbf_adjust_customizer_responsive_sizes() {

	if( function_exists( 'wpbf_breakpoint_medium' ) ) {
		$medium_breakpoint = wpbf_breakpoint_medium();
	} else {
		$medium_breakpoint = 768;
	}

	$tablet_margin_left = -$medium_breakpoint/2 . 'px';
	$tablet_width = $medium_breakpoint . 'px';

	?>
	<style>
		.wp-customizer .preview-tablet .wp-full-overlay-main {
			margin-left: <?php echo esc_attr( $tablet_margin_left ); ?>;
			width: <?php echo esc_attr( $tablet_width ); ?>;
		}
	</style>
	<?php
}

add_action( 'customize_controls_print_styles', 'wpbf_adjust_customizer_responsive_sizes' );

// Generate & Minify Customizer CSS
function wpbf_generate_css() {

	ob_start();
	include_once( get_template_directory() . '/inc/customizer/styles.php' );
	$css = ob_get_clean();

	// Remove Comments
	$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
	// // Remove space after colons
	$css = str_replace( ': ', ':', $css );
	$css = str_replace( ' {', '{', $css );
	$css = str_replace( ', ', ',', $css );
	// // Remove whitespace
	$css = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css );

	return $css;

}

// Enqueue Customizer CSS
add_action( 'wp_enqueue_scripts', 'wpbf_customizer_frontend_scripts', 11 );
function wpbf_customizer_frontend_scripts() {

	$wpbf_inline_style = wpbf_generate_css();
	wp_add_inline_style( apply_filters( 'wpbf_add_inline_style', 'wpbf-style' ), $wpbf_inline_style );

}

// Customizer Live Preview CSS
if( is_customize_preview() ) {

	add_action( 'wp_head', 'wpbf_customizer_preview_css', 999 );
	function wpbf_customizer_preview_css() { ?>
		<style type='text/css'>
		<?php require( get_template_directory() . '/inc/customizer/styles.php' ); ?>
		</style>
	<?php }

}

// Post Message
add_action( 'customize_preview_init' , 'wpbf_customizer_preview_js' );
function wpbf_customizer_preview_js() {
	wp_enqueue_script( 'wpbf-postmessage', get_template_directory_uri() . '/inc/customizer/js/postmessage.js', array(  'jquery', 'customize-preview' ), '', true );
}

// Customizer Scripts & Styles
add_action( 'customize_controls_print_styles' , 'wpbf_customizer_scripts_styles' );

function wpbf_customizer_scripts_styles() {
	wp_enqueue_script( 'wpbf-customizer', get_template_directory_uri() . '/inc/customizer/js/wpbf-customizer.js', array( 'jquery' ), false, true );
	wp_enqueue_style( 'wpbf-customizer', get_template_directory_uri() . '/inc/customizer/css/wpbf-customizer.css' );
}

// Custom Controls
require( get_template_directory() . '/inc/customizer/custom-controls.php' );