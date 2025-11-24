<?php
/**
 * Layout customizer styles.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* General */

// Page settings.
$page_padding = wpbf_customize_array_value( 'page_padding' );

$page_padding_top_desktop    = wpbf_get_theme_mod_value( $page_padding, 'desktop_top' );
$page_padding_right_desktop  = wpbf_get_theme_mod_value( $page_padding, 'desktop_right' );
$page_padding_bottom_desktop = wpbf_get_theme_mod_value( $page_padding, 'desktop_bottom' );
$page_padding_left_desktop   = wpbf_get_theme_mod_value( $page_padding, 'desktop_left' );

if ( is_numeric( $page_padding_top_desktop ) || is_numeric( $page_padding_right_desktop ) || is_numeric( $page_padding_bottom_desktop ) || is_numeric( $page_padding_left_desktop ) ) {

	wpbf_write_css( array(
		'selector' => '#inner-content',
		'props'    => array(
			'padding-top'    => is_numeric( $page_padding_top_desktop ) ? wpbf_maybe_append_suffix( $page_padding_top_desktop ) : null,
			'padding-right'  => is_numeric( $page_padding_right_desktop ) ? wpbf_maybe_append_suffix( $page_padding_right_desktop ) : null,
			'padding-bottom' => is_numeric( $page_padding_bottom_desktop ) ? wpbf_maybe_append_suffix( $page_padding_bottom_desktop ) : null,
			'padding-left'   => is_numeric( $page_padding_left_desktop ) ? wpbf_maybe_append_suffix( $page_padding_left_desktop ) : null,
		),
	) );

}

$page_padding_top_tablet    = wpbf_get_theme_mod_value( $page_padding, 'tablet_top' );
$page_padding_right_tablet  = wpbf_get_theme_mod_value( $page_padding, 'tablet_right' );
$page_padding_bottom_tablet = wpbf_get_theme_mod_value( $page_padding, 'tablet_bottom' );
$page_padding_left_tablet   = wpbf_get_theme_mod_value( $page_padding, 'tablet_left' );

if ( is_numeric( $page_padding_top_tablet ) || is_numeric( $page_padding_right_tablet ) || is_numeric( $page_padding_bottom_tablet ) || is_numeric( $page_padding_left_tablet ) ) {

	wpbf_write_css( array(
		'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_desktop ) . ')',
		'selector'    => '#inner-content',
		'props'       => array(
			'padding-top'    => is_numeric( $page_padding_top_tablet ) ? wpbf_maybe_append_suffix( $page_padding_top_tablet ) : null,
			'padding-right'  => is_numeric( $page_padding_right_tablet ) ? wpbf_maybe_append_suffix( $page_padding_right_tablet ) : null,
			'padding-bottom' => is_numeric( $page_padding_bottom_tablet ) ? wpbf_maybe_append_suffix( $page_padding_bottom_tablet ) : null,
			'padding-left'   => is_numeric( $page_padding_left_tablet ) ? wpbf_maybe_append_suffix( $page_padding_left_tablet ) : null,
		),
	) );

}

$page_padding_top_mobile    = wpbf_get_theme_mod_value( $page_padding, 'mobile_top' );
$page_padding_right_mobile  = wpbf_get_theme_mod_value( $page_padding, 'mobile_right' );
$page_padding_bottom_mobile = wpbf_get_theme_mod_value( $page_padding, 'mobile_bottom' );
$page_padding_left_mobile   = wpbf_get_theme_mod_value( $page_padding, 'mobile_left' );

if ( is_numeric( $page_padding_top_mobile ) || is_numeric( $page_padding_right_mobile ) || is_numeric( $page_padding_bottom_mobile ) || is_numeric( $page_padding_left_mobile ) ) {

	wpbf_write_css( array(
		'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ')',
		'selector'    => '#inner-content',
		'props'       => array(
			'padding-top'    => is_numeric( $page_padding_top_mobile ) ? wpbf_maybe_append_suffix( $page_padding_top_mobile ) : null,
			'padding-right'  => is_numeric( $page_padding_right_mobile ) ? wpbf_maybe_append_suffix( $page_padding_right_mobile ) : null,
			'padding-bottom' => is_numeric( $page_padding_bottom_mobile ) ? wpbf_maybe_append_suffix( $page_padding_bottom_mobile ) : null,
			'padding-left'   => is_numeric( $page_padding_left_mobile ) ? wpbf_maybe_append_suffix( $page_padding_left_mobile ) : null,
		),
	) );

}

if ( is_numeric( $page_padding_right_desktop ) || is_numeric( $page_padding_left_desktop ) ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-container',
		'props'    => array(
			'padding-right' => is_numeric( $page_padding_right_desktop ) ? wpbf_maybe_append_suffix( $page_padding_right_desktop ) : null,
			'padding-left'  => is_numeric( $page_padding_left_desktop ) ? wpbf_maybe_append_suffix( $page_padding_left_desktop ) : null,
		),
	) );

}

if ( is_numeric( $page_padding_right_tablet ) || is_numeric( $page_padding_left_tablet ) ) {

	wpbf_write_css( array(
		'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_desktop ) . ')',
		'selector'    => '.wpbf-container',
		'props'       => array(
			'padding-right' => is_numeric( $page_padding_right_tablet ) ? wpbf_maybe_append_suffix( $page_padding_right_tablet ) : null,
			'padding-left'  => is_numeric( $page_padding_left_tablet ) ? wpbf_maybe_append_suffix( $page_padding_left_tablet ) : null,
		),
	) );

}

if ( is_numeric( $page_padding_right_mobile ) || is_numeric( $page_padding_left_mobile ) ) {

	wpbf_write_css( array(
		'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ')',
		'selector'    => '.wpbf-container',
		'props'       => array(
			'padding-right' => is_numeric( $page_padding_right_mobile ) ? wpbf_maybe_append_suffix( $page_padding_right_mobile ) : null,
			'padding-left'  => is_numeric( $page_padding_left_mobile ) ? wpbf_maybe_append_suffix( $page_padding_left_mobile ) : null,
		),
	) );

}

$page_width = wpbf_customize_str_value( 'page_max_width' );
$page_width = '1200' === $page_width || '1200px' === $page_width ? '' : $page_width;

if ( $page_width ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-container',
		'props'    => array( 'max-width' => wpbf_maybe_append_suffix( $page_width ) ),
	) );

}

$page_boxed = wpbf_customize_bool_value( 'page_boxed' );

if ( $page_boxed ) {

	$page_boxed_padding = wpbf_customize_str_value( 'page_boxed_padding' );
	$page_boxed_padding = '20' === $page_boxed_padding || '20px' === $page_boxed_padding ? '' : $page_boxed_padding;

	if ( $page_boxed_padding ) {

		wpbf_write_css( array(
			'selector' => '.wpbf-container',
			'props'    => array(
				'padding-left'  => wpbf_maybe_append_suffix( $page_boxed_padding ),
				'padding-right' => wpbf_maybe_append_suffix( $page_boxed_padding ),
			),
		) );

	}

	$page_boxed_max_width  = $page_width ? $page_width : '1200px';
	$page_boxed_margin     = wpbf_customize_str_value( 'page_boxed_margin' );
	$page_boxed_background = wpbf_customize_str_value( 'page_boxed_background', '#ffffff' );

	wpbf_write_css( array(
		'selector' => '.wpbf-page',
		'props'    => array(
			'max-width'        => wpbf_maybe_append_suffix( $page_boxed_max_width ),
			'margin'           => '0 auto',
			'margin-top'       => $page_boxed_margin ? wpbf_maybe_append_suffix( $page_boxed_margin ) : null,
			'margin-bottom'    => $page_boxed_margin ? wpbf_maybe_append_suffix( $page_boxed_margin ) : null,
			'background-color' => $page_boxed_background ? $page_boxed_background : null,
		),
	) );

	$page_boxed_shadow = wpbf_customize_bool_value( 'page_boxed_box_shadow' );

	if ( $page_boxed_shadow ) {

		$page_boxed_shadow_horizontal = wpbf_customize_str_value( 'page_boxed_box_shadow_horizontal' );
		$page_boxed_shadow_horizontal = $page_boxed_shadow_horizontal ? wpbf_maybe_append_suffix( $page_boxed_shadow_horizontal ) : '0px';

		$page_boxed_shadow_vertical = wpbf_customize_str_value( 'page_boxed_box_shadow_vertical' );
		$page_boxed_shadow_vertical = $page_boxed_shadow_vertical ? wpbf_maybe_append_suffix( $page_boxed_shadow_vertical ) : '0px';

		$page_boxed_shadow_blur = wpbf_customize_str_value( 'page_boxed_box_shadow_blur' );
		$page_boxed_shadow_blur = $page_boxed_shadow_blur ? wpbf_maybe_append_suffix( $page_boxed_shadow_blur ) : '25px';

		$page_boxed_shadow_spread = wpbf_customize_str_value( 'page_boxed_box_shadow_spread' );
		$page_boxed_shadow_spread = $page_boxed_shadow_spread ? wpbf_maybe_append_suffix( $page_boxed_shadow_spread ) : '0px';

		$page_boxed_shadow_color = wpbf_customize_str_value( 'page_boxed_box_shadow_color', 'rgba(0, 0, 0, .15)' );

		wpbf_write_css( array(
			'selector' => '#container',
			'props'    => array(
				'box-shadow' => $page_boxed_shadow_horizontal . ' ' . $page_boxed_shadow_vertical . ' ' . $page_boxed_shadow_blur . ' ' . $page_boxed_shadow_spread . ' ' . $page_boxed_shadow_color,
			),
		) );

	}
}
