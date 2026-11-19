<?php
/**
 * Customizer CSS: Typography (page font and color, menu, sub menu, headings H1-H6, footer font).
 *
 * Plain PHP, included from styles.php with wpbf_css_area( 'typography' ). How to write it: see styles/general.php.
 * The logo and tagline fonts are in the header CSS; font sizes, line heights, letter spacing, text transform and the
 * other typography options are Premium's CSS. Loading the fonts (@font-face, Google Fonts) is
 * Customizer/Output/FontsOutput.php.
 *
 * The font blocks are plain PHP, not wpbf_css(): a typography value is turned into CSS (the family through
 * wpbf_parse_font_family(), the variant into weight and style), and they print whenever their switch is on, even
 * with the default font (that sets the weight: the page font's 400 applies to the headings too). Font family and
 * variant reload the preview anyway (the new font's @font-face comes from PHP).
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/*
 * A typography value as saved (wpbf_css_saved_mod()), or false when its switch is off. Printed with wpbf_css_font().
 */
$wpbf_saved_font = function ( $toggle_id, $font_id ) {

	return get_theme_mod( $toggle_id ) ? wpbf_css_saved_mod( $font_id ) : false;

};

// Page font and color.
wpbf_css_font( 'body, button, input, optgroup, select, textarea, h1, h2, h3, h4, h5, h6', $wpbf_saved_font( 'page_font_toggle', 'page_font_family' ) );

wpbf_css( 'body', array( 'color' => '{page_font_color}' ), array( 'when' => 'page_font_color' ) );

// Menu, sub menu, headings (H1 sets all headings, H2-H6 their own), footer. Later blocks win.
$wpbf_fonts = array(
	'.wpbf-menu, .wpbf-mobile-menu'                     => array( 'menu_font_family_toggle', 'menu_font_family' ),
	'.wpbf-menu .sub-menu, .wpbf-mobile-menu .sub-menu' => array( 'sub_menu_font_family_toggle', 'sub_menu_font_family' ),
	'h1, h2, h3, h4, h5, h6'                            => array( 'page_h1_toggle', 'page_h1_font_family' ),
	'h2'                                                => array( 'page_h2_toggle', 'page_h2_font_family' ),
	'h3'                                                => array( 'page_h3_toggle', 'page_h3_font_family' ),
	'h4'                                                => array( 'page_h4_toggle', 'page_h4_font_family' ),
	'h5'                                                => array( 'page_h5_toggle', 'page_h5_font_family' ),
	'h6'                                                => array( 'page_h6_toggle', 'page_h6_font_family' ),
	'.wpbf-page-footer'                                 => array( 'footer_font_toggle', 'footer_font_family' ),
);

foreach ( $wpbf_fonts as $wpbf_selector => $wpbf_font ) {
	wpbf_css_font( $wpbf_selector, $wpbf_saved_font( $wpbf_font[0], $wpbf_font[1] ) );
}
