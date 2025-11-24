<?php
/**
 * Footer customizer styles.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Footer */
$footer_layout = wpbf_customize_str_value( 'footer_layout' );
$footer_width  = wpbf_customize_str_value( 'footer_width' );
$footer_width  = '1200' === $footer_width || '1200px' === $footer_width ? '' : $footer_width;
$footer_height = wpbf_customize_str_value( 'footer_height' );
$footer_height = '20' === $footer_height || '20px' === $footer_height ? '' : $footer_height;

if ( 'none' !== $footer_layout && ( $footer_width || $footer_height ) ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-inner-footer',
		'props'    => array(
			'padding-top'    => $footer_height ? wpbf_maybe_append_suffix( $footer_height ) : null,
			'padding-bottom' => $footer_height ? wpbf_maybe_append_suffix( $footer_height ) : null,
			'max-width'      => $footer_width ? wpbf_maybe_append_suffix( $footer_width ) : null,
		),
	) );

}

$footer_bg_color = wpbf_customize_str_value( 'footer_bg_color' );
$footer_bg_color = '#f5f5f7' === $footer_bg_color ? '' : $footer_bg_color;

if ( 'none' !== $footer_layout && $footer_bg_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-page-footer',
		'props'    => array( 'background-color' => $footer_bg_color ),
	) );

}

$footer_font_color = wpbf_customize_str_value( 'footer_font_color' );

if ( 'none' !== $footer_layout && $footer_font_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-inner-footer',
		'props'    => array( 'color' => $footer_font_color ),
	) );

}

$footer_accent_color = wpbf_customize_str_value( 'footer_accent_color' );

if ( 'none' !== $footer_layout && $footer_accent_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-inner-footer a',
		'props'    => array( 'color' => $footer_accent_color ),
	) );

}

$footer_accent_color_alt = wpbf_customize_str_value( 'footer_accent_color_alt' );

if ( 'none' !== $footer_layout && $footer_accent_color_alt ) {

	wpbf_write_css( array(
		'blocks' => array(
			array(
				'selector' => '.wpbf-inner-footer a:hover',
				'props'    => array( 'color' => $footer_accent_color_alt ),
			),
			array(
				'selector' => '.wpbf-inner-footer .wpbf-menu > .current-menu-item > a',
				'props'    => array( 'color' => $footer_accent_color_alt . '!important' ),
			),
		),
	) );

}

$footer_font_size = wpbf_customize_str_value( 'footer_font_size' );
$footer_font_size = '14' === $footer_font_size || '14px' === $footer_font_size ? '' : $footer_font_size;

if ( 'none' !== $footer_layout && $footer_font_size ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-inner-footer, .wpbf-inner-footer .wpbf-menu',
		'props'    => array( 'font-size' => wpbf_maybe_append_suffix( $footer_font_size ) ),
	) );

}
