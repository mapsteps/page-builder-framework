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

/**
 * A typography value as saved, or false when it's off or nothing is saved.
 *
 * Visitors get get_theme_mod() without a default: false when nothing is saved, so no CSS. In the Customizer preview
 * get_theme_mod() hands over the registered default for an option nobody saved or changed; that would print the
 * default font in the preview only (switching a font on without picking one), so the preview treats it as not saved
 * too.
 *
 * @param string $toggle_id The option that switches the font on.
 * @param string $font_id   The typography option.
 *
 * @return mixed The saved value, false for none.
 */
$wpbf_saved_font = function ( $toggle_id, $font_id ) {

	if ( ! get_theme_mod( $toggle_id ) ) {
		return false;
	}

	$value = get_theme_mod( $font_id );

	global $wp_customize;

	if ( $value && is_customize_preview() && $wp_customize instanceof WP_Customize_Manager ) {
		$saved = (array) get_theme_mods();

		if ( ! array_key_exists( $font_id, $saved ) && ! array_key_exists( $font_id, $wp_customize->unsanitized_post_values() ) ) {
			return false;
		}
	}

	return $value;

};

/**
 * Print one font block, as before: the family, and weight and style from the variant.
 *
 * @param string $selector The selector.
 * @param mixed  $value    The typography value.
 */
$wpbf_font_css = function ( $selector, $value ) {

	if ( ! $value ) {
		return;
	}

	// A value saved as anything but a list of parts prints an empty block, as before.
	echo $selector . ' {'; // phpcs:ignore WordPress.Security.EscapeOutput -- Fixed selectors.

	if ( ! empty( $value['font-family'] ) ) {
		echo sprintf( 'font-family: %s;', wpbf_parse_font_family( $value['font-family'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- Escaped by wpbf_parse_font_family().
	}

	// '700italic' → 700, italic; 'regular' → 400, normal. Saved font-weight / font-style parts aren't used.
	if ( ! empty( $value['variant'] ) ) {
		$weight = str_replace( 'italic', '', $value['variant'] );
		$weight = in_array( $weight, array( '', 'regular' ) ) ? '400' : $weight; // phpcs:ignore WordPress.PHP.StrictInArray -- As before (a variant saved as the number 400).
		$style  = false !== strpos( $value['variant'], 'italic' ) ? 'italic' : 'normal';

		echo sprintf( 'font-weight: %s;', esc_attr( $weight ) );
		echo sprintf( 'font-style: %s;', esc_attr( $style ) );
	}

	echo '}';

};

// Page font and color.
$wpbf_font_css( 'body, button, input, optgroup, select, textarea, h1, h2, h3, h4, h5, h6', $wpbf_saved_font( 'page_font_toggle', 'page_font_family' ) );

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
	$wpbf_font_css( $wpbf_selector, $wpbf_saved_font( $wpbf_font[0], $wpbf_font[1] ) );
}
