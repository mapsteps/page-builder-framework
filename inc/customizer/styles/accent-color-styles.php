<?php
/**
 * Accent color customizer styles.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Accent color.
$page_accent_color = wpbf_customize_str_value( 'page_accent_color' );
$page_accent_color = '#3ba9d2' === $page_accent_color ? '' : $page_accent_color;

if ( $page_accent_color ) {

	wpbf_write_css( array(
		'selector' => 'a',
		'props'    => array( 'color' => $page_accent_color ),
	) );

	wpbf_write_css( array(
		'selector' => '.bypostauthor',
		'props'    => array( 'border-color' => $page_accent_color ),
	) );

	wpbf_write_css( array(
		'selector' => '.wpbf-button-primary',
		'props'    => array( 'background-color' => $page_accent_color ),
	) );

}

$page_accent_color_alt = wpbf_customize_str_value( 'page_accent_color_alt' );
$page_accent_color_alt = '#79c4e0' === $page_accent_color_alt ? '' : $page_accent_color_alt;

if ( $page_accent_color_alt ) {

	wpbf_write_css( array(
		'selector' => 'a:hover',
		'props'    => array( 'color' => $page_accent_color_alt ),
	) );

	wpbf_write_css( array(
		'selector' => '.wpbf-button-primary:hover',
		'props'    => array( 'background-color' => $page_accent_color_alt ),
	) );

	wpbf_write_css( array(
		'selector' => '.wpbf-menu > .current-menu-item > a',
		'props'    => array( 'color' => $page_accent_color_alt . '!important' ),
	) );

}
