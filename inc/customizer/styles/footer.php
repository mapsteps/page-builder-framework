<?php
/**
 * Customizer CSS: Footer (width, height, colors, font size).
 *
 * Plain PHP, included from styles.php with wpbf_css_area( 'footer' ). How to write it: see styles/general.php.
 * The footer font is in styles/typography.php; Premium's footer CSS is Premium's.
 *
 * Each block has 'when' => its own option: the old code skipped values like 0 or '0' (a slider can't save them, an
 * import can), so they stay skipped.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

if ( 'none' === wpbf_mod( 'footer_layout' ) ) {
	return;
}

wpbf_css(
	'.wpbf-inner-footer',
	array(
		'padding-top'    => '{footer_height}px',
		'padding-bottom' => '{footer_height}px',
	),
	array( 'when' => 'footer_height' )
);

// Empty: the page width (.wpbf-container).
wpbf_css( '.wpbf-inner-footer', array( 'max-width' => '{footer_width}' ), array( 'when' => 'footer_width' ) );

wpbf_css( '.wpbf-page-footer', array( 'background-color' => '{footer_bg_color}' ), array( 'when' => 'footer_bg_color' ) );
wpbf_css( '.wpbf-inner-footer', array( 'color' => '{footer_font_color}' ), array( 'when' => 'footer_font_color' ) );
wpbf_css( '.wpbf-inner-footer a', array( 'color' => '{footer_accent_color}' ), array( 'when' => 'footer_accent_color' ) );
wpbf_css( '.wpbf-inner-footer a:hover', array( 'color' => '{footer_accent_color_alt}' ), array( 'when' => 'footer_accent_color_alt' ) );
wpbf_css( '.wpbf-inner-footer .wpbf-menu > .current-menu-item > a', array( 'color' => '{footer_accent_color_alt}!important' ), array( 'when' => 'footer_accent_color_alt' ) );

// Font size: a plain number gets px (the field saves a typed "18" without a unit).
wpbf_css( '.wpbf-inner-footer, .wpbf-inner-footer .wpbf-menu', array( 'font-size' => '{footer_font_size|px}' ), array( 'when' => 'footer_font_size' ) );
