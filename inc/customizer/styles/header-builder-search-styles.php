<?php
/**
 * Header Builder Search Styles
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * ----------------------------------------------------------------------
 * Mobile Header Builder: Search Icon Styles.
 * ----------------------------------------------------------------------
 */

$control_id_prefix = $header_builder_control_id_prefix . 'mobile_search_';
$icon_size         = wpbf_customize_array_value( $control_id_prefix . 'icon_size' );
$icon_size         = '' === $icon_size || '16' === $icon_size ? '16px' : $icon_size;

foreach ( $devices as $device ) {
	if ( 'tablet' !== $device && 'mobile' !== $device ) {
		continue;
	}

	$breakpoint_width = 'tablet' === $device ? $breakpoint_medium : $breakpoint_mobile;

	$device_icon_size = isset( $icon_size[ $device ] ) && '' !== $icon_size[ $device ] ? $icon_size[ $device ] : null;

	if ( is_null( $device_icon_size ) ) {
		continue;
	}

	wpbf_write_css( array(
		'media_query' => '@media screen and (max-width: ' . $breakpoint_width . ')',
		'selector'    => '.wpbff-search',
		'props'       => array(
			'font-size' => $device_icon_size ? wpbf_maybe_append_suffix( $device_icon_size ) : null,
		),
	) );
}

/**
 * ----------------------------------------------------------------------
 * Mobile Header Builder: Search Icon color.
 * ----------------------------------------------------------------------
 */
$icon_color = wpbf_customize_array_value( $control_id_prefix . 'icon_color' );

if ( ! empty( $icon_color ) ) {
	$default_color = ! empty( $icon_color['default'] ) ? $icon_color['default'] : '';
	$hover_color   = ! empty( $icon_color['hover'] ) ? $icon_color['hover'] : '';

	if ( $default_color ) {
		wpbf_write_css( array(
			'selector' => '.wpbff-search',
			'props'    => array( 'color' => $default_color ),
		) );
	}

	if ( $hover_color ) {
		wpbf_write_css( array(
			'selector' => '.wpbff-search:hover, .wpbff-search:focus',
			'props'    => array( 'color' => $hover_color ),
		) );
	}
}
