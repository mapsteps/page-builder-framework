<?php
/**
 * Header Builder Button Styles
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * ----------------------------------------------------------------------
 * Button Widget Styles
 * ----------------------------------------------------------------------
 */

$button_keys = array( 'desktop_button_1', 'desktop_button_2', 'mobile_button_1', 'mobile_button_2' );

foreach ( $button_keys as $button_key ) {

	$selector = '.wpbf-button.' . $header_builder_control_id_prefix . $button_key;

	$responsive_border_radius = wpbf_customize_array_value( $header_builder_control_id_prefix . $button_key . '_border_radius' );
	$responsive_border_width  = wpbf_customize_array_value( $header_builder_control_id_prefix . $button_key . '_border_width' );
	$button_border_style      = wpbf_customize_str_value( $header_builder_control_id_prefix . $button_key . '_border_style' );
	$button_border_style      = ! empty( $button_border_style ) ? $button_border_style : 'none';
	$button_border_colors     = wpbf_customize_array_value( $header_builder_control_id_prefix . $button_key . '_border_color' );
	$button_bg_colors         = wpbf_customize_array_value( $header_builder_control_id_prefix . $button_key . '_bg_color' );
	$button_text_colors       = wpbf_customize_array_value( $header_builder_control_id_prefix . $button_key . '_text_color' );

	wpbf_write_css( array(
		'selector' => $selector,
		'props'    => array(
			'border-radius'    => isset( $responsive_border_radius['desktop'] ) && '' !== $responsive_border_radius['desktop'] ? wpbf_maybe_append_suffix( $responsive_border_radius['desktop'] ) : null,
			'border-width'     => isset( $responsive_border_width['desktop'] ) && '' !== $responsive_border_width['desktop'] ? wpbf_maybe_append_suffix( $responsive_border_width['desktop'] ) : null,
			'border-style'     => 'none' !== $button_border_style ? $button_border_style : null,
			'border-color'     => isset( $button_border_colors['default'] ) && '' !== $button_border_colors['default'] ? $button_border_colors['default'] : null,
			'background-color' => isset( $button_bg_colors['default'] ) && '' !== $button_bg_colors['default'] ? $button_bg_colors['default'] : null,
			'color'            => isset( $button_text_colors['default'] ) && '' !== $button_text_colors['default'] ? $button_text_colors['default'] : null,
		),
	) );

	wpbf_write_css( array(
		'selector' => $selector . ':hover',
		'props'    => array(
			'border-color'     => isset( $button_border_colors['hover'] ) && '' !== $button_border_colors['hover'] ? $button_border_colors['hover'] : null,
			'background-color' => isset( $button_bg_colors['hover'] ) && '' !== $button_bg_colors['hover'] ? $button_bg_colors['hover'] : null,
			'color'            => isset( $button_text_colors['hover'] ) && '' !== $button_text_colors['hover'] ? $button_text_colors['hover'] : null,
		),
	) );

	// Sticky navigation styles - only retrieve these once per loop iteration, not in nested conditions.
	$cta_button_sticky_background_color     = wpbf_customize_str_value( 'cta_button_sticky_background_color' );
	$cta_button_sticky_background_color_alt = wpbf_customize_str_value( 'cta_button_sticky_background_color_alt' );
	$cta_button_sticky_font_color           = wpbf_customize_str_value( 'cta_button_sticky_font_color' );
	$cta_button_sticky_font_color_alt       = wpbf_customize_str_value( 'cta_button_sticky_font_color_alt' );

	// Apply sticky navigation colors when sticky header is active.
	if ( $cta_button_sticky_background_color || $cta_button_sticky_font_color ) {
		wpbf_write_css( array(
			'selector' => '.wpbf-navigation-active ' . $selector,
			'props'    => array(
				'background-color' => $cta_button_sticky_background_color ? $cta_button_sticky_background_color : null,
				'color'            => $cta_button_sticky_font_color ? $cta_button_sticky_font_color : null,
			),
		) );

		if ( ! $cta_button_sticky_font_color_alt ) {
			wpbf_write_css( array(
				'selector' => '.wpbf-navigation-active ' . $selector . ':hover',
				'props'    => array(
					'color' => $cta_button_sticky_font_color ? $cta_button_sticky_font_color : null,
				),
			) );
		}

		if ( ! $cta_button_sticky_background_color_alt ) {
			wpbf_write_css( array(
				'selector' => '.wpbf-navigation-active ' . $selector . ':hover',
				'props'    => array(
					'background-color' => $cta_button_sticky_background_color ? $cta_button_sticky_background_color : null,
				),
			) );
		}
	}

	if ( $cta_button_sticky_background_color_alt || $cta_button_sticky_font_color_alt ) {
		wpbf_write_css( array(
			'selector' => '.wpbf-navigation-active ' . $selector . ':hover',
			'props'    => array(
				'background-color' => $cta_button_sticky_background_color_alt ? $cta_button_sticky_background_color_alt : null,
				'color'            => $cta_button_sticky_font_color_alt ? $cta_button_sticky_font_color_alt : null,
			),
		) );
	}


	foreach ( $devices as $device ) {
		if ( 'tablet' !== $device && 'mobile' !== $device ) {
			continue;
		}

		$breakpoint_width = 'tablet' === $device ? $breakpoint_medium : $breakpoint_mobile;

		$device_border_radius = isset( $responsive_border_radius[ $device ] ) && '' !== $responsive_border_radius[ $device ] ? $responsive_border_radius[ $device ] : null;
		$device_border_width  = isset( $responsive_border_width[ $device ] ) && '' !== $responsive_border_width[ $device ] ? $responsive_border_width[ $device ] : null;

		if ( is_null( $device_border_radius ) && is_null( $device_border_width ) ) {
			continue;
		}

		wpbf_write_css( array(
			'media_query' => '@media screen and (max-width: ' . $breakpoint_width . ')',
			'selector'    => $selector,
			'props'       => array(
				'border-radius' => $device_border_radius ? wpbf_maybe_append_suffix( $device_border_radius ) : null,
				'border-width'  => $device_border_width ? wpbf_maybe_append_suffix( $device_border_width ) : null,
			),
		) );
	}

}
