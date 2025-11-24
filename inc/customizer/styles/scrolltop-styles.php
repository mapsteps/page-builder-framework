<?php
/**
 * Scroll-to-top customizer styles.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Scrolltop.
$scrolltop = wpbf_customize_bool_value( 'layout_scrolltop' );

if ( $scrolltop ) {

	$scrolltop_position = wpbf_customize_str_value( 'scrolltop_position', 'right' );

	if ( 'left' === $scrolltop_position ) {

		wpbf_write_css( array(
			'selector' => '.scrolltop',
			'props'    => array(
				'right' => 'auto',
				'left'  => '20px',
			),
		) );

		wpbf_write_css( array(
			'media_query' => '@media screen and (max-width: ' . $breakpoint_medium . ')',
			'selector'    => '.scrolltop',
			'props'       => array(
				'left'   => '10px',
				'bottom' => '10px',
			),
		) );

	}

	if ( 'right' === $scrolltop_position ) {

		wpbf_write_css( array(
			'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_medium ) . ')',
			'selector'    => '.scrolltop',
			'props'       => array(
				'right'  => '10px',
				'bottom' => '10px',
			),
		) );

	}

	$scrolltop_bg_color = wpbf_customize_str_value( 'scrolltop_bg_color' );
	$scrolltop_bg_color = 'rgba(62,67,73,0.5)' === $scrolltop_bg_color || 'rgba(62, 67, 73, 0.5)' === $scrolltop_bg_color ? '' : $scrolltop_bg_color;

	$scrolltop_border_radius = wpbf_customize_str_value( 'scrolltop_border_radius' );

	if ( $scrolltop_bg_color || $scrolltop_border_radius ) {

		wpbf_write_css( array(
			'selector' => '.scrolltop',
			'props'    => array(
				'background-color' => $scrolltop_bg_color ? $scrolltop_bg_color : null,
				'border-radius'    => $scrolltop_border_radius ? wpbf_maybe_append_suffix( $scrolltop_border_radius ) : null,
			),
		) );

	}

	$scrolltop_icon_color = wpbf_customize_str_value( 'scrolltop_icon_color' );
	$scrolltop_icon_color = '#ffffff' === $scrolltop_icon_color ? '' : $scrolltop_icon_color;

	if ( $scrolltop_icon_color ) {

		wpbf_write_css( array(
			'selector' => '.scrolltop, .scrolltop:hover',
			'props'    => array( 'color' => $scrolltop_icon_color ),
		) );

	}

	$scrolltop_bg_color_alt = wpbf_customize_str_value( 'scrolltop_bg_color_alt' );
	$scrolltop_bg_color_alt = 'rgba(62,67,73,0.7)' === $scrolltop_bg_color_alt || 'rgba(62, 67, 73, 0.7)' === $scrolltop_bg_color_alt ? '' : $scrolltop_bg_color_alt;

	$scrolltop_icon_color_alt = wpbf_customize_str_value( 'scrolltop_icon_color_alt' );

	if ( $scrolltop_bg_color_alt || $scrolltop_icon_color_alt ) {

		wpbf_write_css( array(
			'selector' => '.scrolltop:hover',
			'props'    => array(
				'background-color' => $scrolltop_bg_color_alt ? $scrolltop_bg_color_alt : null,
				'color'            => $scrolltop_icon_color_alt ? $scrolltop_icon_color_alt : null,
			),
		) );

	}

}
