<?php
/**
 * Breadcrumbs customizer styles.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Breadcrumbs.
$breadcrumbs_alignment = wpbf_customize_str_value( 'breadcrumbs_alignment', 'left' );

if ( 'left' !== $breadcrumbs_alignment ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-breadcrumbs-container',
		'props'    => array( 'text-align' => $breadcrumbs_alignment ),
	) );

}

$breadcrumbs_background_color = wpbf_customize_str_value( 'breadcrumbs_background_color' );
$breadcrumbs_background_color = '#dedee5' === $breadcrumbs_background_color ? '' : $breadcrumbs_background_color;

if ( $breadcrumbs_background_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-breadcrumbs-container',
		'props'    => array( 'background-color' => $breadcrumbs_background_color ),
	) );

}

$breadcrumbs_font_color = wpbf_customize_str_value( 'breadcrumbs_font_color' );

if ( $breadcrumbs_font_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-breadcrumbs',
		'props'    => array( 'color' => $breadcrumbs_font_color ),
	) );

}

$breadcrumbs_accent_color = wpbf_customize_str_value( 'breadcrumbs_accent_color' );

if ( $breadcrumbs_accent_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-breadcrumbs a',
		'props'    => array( 'color' => $breadcrumbs_accent_color ),
	) );

}

$breadcrumbs_accent_color_alt = wpbf_customize_str_value( 'breadcrumbs_accent_color_alt' );

if ( $breadcrumbs_accent_color_alt ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-breadcrumbs a:hover',
		'props'    => array( 'color' => $breadcrumbs_accent_color_alt ),
	) );

}
