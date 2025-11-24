<?php
/**
 * Typography customizer styles.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Typography */

// Page font settings.
$page_font_toggle  = wpbf_customize_bool_value( 'page_font_toggle' );
$page_font_setting = wpbf_customize_array_value( 'page_font_family' );

if ( $page_font_toggle && $page_font_setting ) {

	wpbf_write_css( array(
		'selector' => 'body, button, input, optgroup, select, textarea, h1, h2, h3, h4, h5, h6',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $page_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $page_font_setting ),
			'font-style'  => wpbf_typography_font_style( $page_font_setting ),
		),
	) );

}

$page_font_color = wpbf_customize_str_value( 'page_font_color' );
$page_font_color = '#6d7680' === $page_font_color ? '' : $page_font_color;

if ( $page_font_color ) {

	wpbf_write_css( array(
		'selector' => 'body',
		'props'    => array( 'color' => $page_font_color ),
	) );

}

// Menu font settings.
$menu_font_toggle  = wpbf_customize_bool_value( 'menu_font_family_toggle' );
$menu_font_setting = wpbf_customize_array_value( 'menu_font_family' );

if ( $menu_font_toggle && $menu_font_setting ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-menu, .wpbf-mobile-menu',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $menu_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $menu_font_setting ),
			'font-style'  => wpbf_typography_font_style( $menu_font_setting ),
		),
	) );

}

// Sub Menu font settings.
$sub_menu_font_toggle  = wpbf_customize_bool_value( 'sub_menu_font_family_toggle' );
$sub_menu_font_setting = wpbf_customize_array_value( 'sub_menu_font_family' );

if ( $sub_menu_font_toggle && $sub_menu_font_setting ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-menu .sub-menu, .wpbf-mobile-menu .sub-menu',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $sub_menu_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $sub_menu_font_setting ),
			'font-style'  => wpbf_typography_font_style( $sub_menu_font_setting ),
		),
	) );

}

// H1 font settings.
$page_h1_font_toggle  = wpbf_customize_bool_value( 'page_h1_toggle' );
$page_h1_font_setting = wpbf_customize_array_value( 'page_h1_font_family' );

if ( $page_h1_font_toggle && $page_h1_font_setting ) {

	wpbf_write_css( array(
		// Intentionally affecting h1-h6.
		'selector' => 'h1, h2, h3, h4, h5, h6',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $page_h1_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $page_h1_font_setting ),
			'font-style'  => wpbf_typography_font_style( $page_h1_font_setting ),
		),
	) );

}

// H2 font settings.
$page_h2_font_toggle  = wpbf_customize_bool_value( 'page_h2_toggle' );
$page_h2_font_setting = wpbf_customize_array_value( 'page_h2_font_family' );

if ( $page_h2_font_toggle && $page_h2_font_setting ) {

	wpbf_write_css( array(
		'selector' => 'h2',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $page_h2_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $page_h2_font_setting ),
			'font-style'  => wpbf_typography_font_style( $page_h2_font_setting ),
		),
	) );

}

// H3 font settings.
$page_h3_font_setting = wpbf_customize_bool_value( 'page_h3_toggle' );
$page_h3_font_family  = wpbf_customize_array_value( 'page_h3_font_family' );

if ( $page_h3_font_setting && $page_h3_font_family ) {

	wpbf_write_css( array(
		'selector' => 'h3',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $page_h3_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $page_h3_font_setting ),
			'font-style'  => wpbf_typography_font_style( $page_h3_font_setting ),
		),
	) );

}

// H4 font settings.
$page_h4_font_toggle  = wpbf_customize_bool_value( 'page_h4_toggle' );
$page_h4_font_setting = wpbf_customize_array_value( 'page_h4_font_family' );

if ( $page_h4_font_toggle && $page_h4_font_setting ) {

	wpbf_write_css( array(
		'selector' => 'h4',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $page_h4_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $page_h4_font_setting ),
			'font-style'  => wpbf_typography_font_style( $page_h4_font_setting ),
		),
	) );

}

// H5 font settings.
$page_h5_font_toggle  = wpbf_customize_bool_value( 'page_h5_toggle' );
$page_h5_font_setting = wpbf_customize_array_value( 'page_h5_font_family' );

if ( $page_h5_font_toggle && $page_h5_font_setting ) {

	wpbf_write_css( array(
		'selector' => 'h5',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $page_h5_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $page_h5_font_setting ),
			'font-style'  => wpbf_typography_font_style( $page_h5_font_setting ),
		),
	) );

}

// H6 font settings.
$page_h6_font_toggle  = wpbf_customize_bool_value( 'page_h6_toggle' );
$page_h6_font_setting = wpbf_customize_array_value( 'page_h6_font_family' );

if ( $page_h6_font_toggle && $page_h6_font_setting ) {

	wpbf_write_css( array(
		'selector' => 'h6',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $page_h6_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $page_h6_font_setting ),
			'font-style'  => wpbf_typography_font_style( $page_h6_font_setting ),
		),
	) );

}

// Footer font settings.
$footer_font_toggle  = wpbf_customize_bool_value( 'footer_font_toggle' );
$footer_font_setting = wpbf_customize_array_value( 'footer_font_family' );

if ( $footer_font_toggle && $footer_font_setting ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-page-footer',
		'props'    => array(
			'font-family' => wpbf_typography_font_family( $footer_font_setting ),
			'font-weight' => wpbf_typography_font_weight( $footer_font_setting ),
			'font-style'  => wpbf_typography_font_style( $footer_font_setting ),
		),
	) );

}
