<?php
/**
 * Divi integration.
 *
 * @package Page Builder Framework
 * @subpackage Integration
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Override Divi default headline styles.
 */
function wpbf_divi_default_headline_styles() {

	$inline_styles = '';

	$inline_styles .= '#et-boc .et-l h1, #et-boc .et-l h2, #et-boc .et-l h3, #et-boc .et-l h4, #et-boc .et-l h5, #et-boc .et-l h6 {';
	$inline_styles .= 'color: var(--brand-color);';
	$inline_styles .= 'font-weight: 700;';
	$inline_styles .= 'line-height: 1.2;';
	$inline_styles .= 'padding-bottom: 0;';
	$inline_styles .= '}';

	$inline_styles .= '.et-db #et-boc .et-l .et_pb_module h1, .et-db #et-boc .et-l .et_pb_module h2, .et-db #et-boc .et-l .et_pb_module h3, .et-db #et-boc .et-l .et_pb_module h4, .et-db #et-boc .et-l .et_pb_module h5, .et-db #et-boc .et-l .et_pb_module h6 {';
	$inline_styles .= 'margin: 0 0 20px 0;';
	$inline_styles .= '}';

	// $line_height_h1 = get_theme_mod( 'page_h1_line_height' );
	// $line_height_h2 = get_theme_mod( 'page_h2_line_height' );
	// $line_height_h3 = get_theme_mod( 'page_h3_line_height' );
	// $line_height_h4 = get_theme_mod( 'page_h4_line_height' );
	// $line_height_h5 = get_theme_mod( 'page_h5_line_height' );
	// $line_height_h6 = get_theme_mod( 'page_h6_line_height' );

	// if ( $line_height_h1 ) {
	// }

	// if ( $line_height_h2 ) {
	// }

	// if ( $line_height_h3 ) {
	// }

	// if ( $line_height_h4 ) {
	// }

	// if ( $line_height_h5 ) {
	// }

	// if ( $line_height_h6 ) {
	// }

	$inline_styles = wpbf_minify_css( $inline_styles );

	wp_add_inline_style( 'et-builder-modules-style', $inline_styles );

}
add_action( 'wp_enqueue_scripts', 'wpbf_divi_default_headline_styles', 999 );
