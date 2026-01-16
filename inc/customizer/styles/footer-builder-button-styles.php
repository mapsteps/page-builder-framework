<?php
/**
 * Footer Builder Button Styles
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * ----------------------------------------------------------------------
 * Footer Button Widget Styles
 * ----------------------------------------------------------------------
 */

$footer_button_keys = array( 'desktop_button_1', 'desktop_button_2', 'mobile_button_1', 'mobile_button_2' );

foreach ( $footer_button_keys as $button_key ) {

	$control_id_prefix = 'wpbf_footer_builder_' . $button_key . '_';
	$selector          = '.wpbf-button.wpbf_footer_builder_' . $button_key;

	$responsive_border_radius = wpbf_customize_array_value( $control_id_prefix . 'border_radius' );
	$responsive_border_width  = wpbf_customize_array_value( $control_id_prefix . 'border_width' );
	$button_border_style      = wpbf_customize_str_value( $control_id_prefix . 'border_style' );
	$button_border_style      = ! empty( $button_border_style ) ? $button_border_style : 'none';
	$button_border_colors     = wpbf_customize_array_value( $control_id_prefix . 'border_color' );
	$button_bg_colors         = wpbf_customize_array_value( $control_id_prefix . 'bg_color' );
	$button_text_colors       = wpbf_customize_array_value( $control_id_prefix . 'text_color' );
	$button_margin            = wpbf_customize_array_value( $control_id_prefix . 'margin' );

	wpbf_write_css( array(
		'selector' => $selector,
		'props'    => array(
			'border-radius'    => isset( $responsive_border_radius['desktop'] ) && '' !== $responsive_border_radius['desktop'] ? wpbf_maybe_append_suffix( $responsive_border_radius['desktop'] ) : null,
			'border-width'     => isset( $responsive_border_width['desktop'] ) && '' !== $responsive_border_width['desktop'] ? wpbf_maybe_append_suffix( $responsive_border_width['desktop'] ) : null,
			'border-style'     => 'none' !== $button_border_style ? $button_border_style : null,
			'border-color'     => isset( $button_border_colors['default'] ) && '' !== $button_border_colors['default'] ? $button_border_colors['default'] : null,
			'background-color' => isset( $button_bg_colors['default'] ) && '' !== $button_bg_colors['default'] ? $button_bg_colors['default'] : null,
			'color'            => isset( $button_text_colors['default'] ) && '' !== $button_text_colors['default'] ? $button_text_colors['default'] : null,
			'margin-top'       => ! empty( $button_margin['top'] ) ? wpbf_maybe_append_suffix( $button_margin['top'] ) : null,
			'margin-right'     => ! empty( $button_margin['right'] ) ? wpbf_maybe_append_suffix( $button_margin['right'] ) : null,
			'margin-bottom'    => ! empty( $button_margin['bottom'] ) ? wpbf_maybe_append_suffix( $button_margin['bottom'] ) : null,
			'margin-left'      => ! empty( $button_margin['left'] ) ? wpbf_maybe_append_suffix( $button_margin['left'] ) : null,
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

	// Responsive styles for border radius and width (tablet/mobile).
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
