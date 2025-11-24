<?php
/**
 * Sidebar, breadcrumbs, and pagination customizer styles.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Sidebar.
$sidebar_widget_padding = wpbf_customize_array_value( 'sidebar_widget_padding' );

$sidebar_widget_padding_top_desktop    = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'desktop_top', 20 );
$sidebar_widget_padding_right_desktop  = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'desktop_right', 20 );
$sidebar_widget_padding_bottom_desktop = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'desktop_bottom', 20 );
$sidebar_widget_padding_left_desktop   = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'desktop_left', 20 );

$sidebar_bg_color = wpbf_customize_str_value( 'sidebar_bg_color' );
$sidebar_bg_color = '#f5f5f7' === $sidebar_bg_color ? '' : $sidebar_bg_color;

if ( $sidebar_bg_color ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-sidebar .widget, .elementor-widget-sidebar .widget',
		'props'    => array( 'background-color' => $sidebar_bg_color ),
	) );

}

if ( is_numeric( $sidebar_widget_padding_top_desktop ) || is_numeric( $sidebar_widget_padding_right_desktop ) || is_numeric( $sidebar_widget_padding_bottom_desktop ) || is_numeric( $sidebar_widget_padding_left_desktop ) ) {

	wpbf_write_css( array(
		'selector' => '.wpbf-sidebar .widget, .elementor-widget-sidebar .widget',
		'props'    => array(
			'padding-top'    => is_numeric( $sidebar_widget_padding_top_desktop ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_top_desktop ) : null,
			'padding-right'  => is_numeric( $sidebar_widget_padding_right_desktop ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_right_desktop ) : null,
			'padding-bottom' => is_numeric( $sidebar_widget_padding_bottom_desktop ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_bottom_desktop ) : null,
			'padding-left'   => is_numeric( $sidebar_widget_padding_left_desktop ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_left_desktop ) : null,
		),
	) );

}

$sidebar_widget_padding_top_tablet    = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'tablet_top', 20 );
$sidebar_widget_padding_right_tablet  = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'tablet_right', 20 );
$sidebar_widget_padding_bottom_tablet = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'tablet_bottom', 20 );
$sidebar_widget_padding_left_tablet   = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'tablet_left', 20 );

if ( is_numeric( $sidebar_widget_padding_top_tablet ) || is_numeric( $sidebar_widget_padding_right_tablet ) || is_numeric( $sidebar_widget_padding_bottom_tablet ) || is_numeric( $sidebar_widget_padding_left_tablet ) ) {

	wpbf_write_css( array(
		'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_desktop ) . ')',
		'selector'    => '.wpbf-sidebar .widget, .elementor-widget-sidebar .widget',
		'props'       => array(
			'padding-top'    => is_numeric( $sidebar_widget_padding_top_tablet ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_top_tablet ) : null,
			'padding-right'  => is_numeric( $sidebar_widget_padding_right_tablet ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_right_tablet ) : null,
			'padding-bottom' => is_numeric( $sidebar_widget_padding_bottom_tablet ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_bottom_tablet ) : null,
			'padding-left'   => is_numeric( $sidebar_widget_padding_left_tablet ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_left_tablet ) : null,
		),
	) );

}

$sidebar_widget_padding_top_mobile    = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'mobile_top', 20 );
$sidebar_widget_padding_right_mobile  = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'mobile_right', 20 );
$sidebar_widget_padding_bottom_mobile = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'mobile_bottom', 20 );
$sidebar_widget_padding_left_mobile   = wpbf_get_theme_mod_value( $sidebar_widget_padding, 'mobile_left', 20 );

if ( is_numeric( $sidebar_widget_padding_top_mobile ) || is_numeric( $sidebar_widget_padding_right_mobile ) || is_numeric( $sidebar_widget_padding_bottom_mobile ) || is_numeric( $sidebar_widget_padding_left_mobile ) ) {

	wpbf_write_css( array(
		'media_query' => '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ')',
		'selector'    => '.wpbf-sidebar .widget, .elementor-widget-sidebar .widget',
		'props'       => array(
			'padding-top'    => is_numeric( $sidebar_widget_padding_top_mobile ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_top_mobile ) : null,
			'padding-right'  => is_numeric( $sidebar_widget_padding_right_mobile ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_right_mobile ) : null,
			'padding-bottom' => is_numeric( $sidebar_widget_padding_bottom_mobile ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_bottom_mobile ) : null,
			'padding-left'   => is_numeric( $sidebar_widget_padding_left_mobile ) ? wpbf_maybe_append_suffix( $sidebar_widget_padding_left_mobile ) : null,
		),
	) );

}

$sidebar_width = wpbf_customize_str_value( 'sidebar_width' );
$sidebar_width = '33.3' === $sidebar_width || '33.3px' === $sidebar_width ? '' : $sidebar_width;

if ( $sidebar_width ) {

	wpbf_write_css( array(
		'media_query' => '@media (min-width: ' . ( $breakpoint_medium_int + 1 ) . 'px)',
		'blocks'      => array(
			array(
				'selector' => 'body:not(.wpbf-no-sidebar) .wpbf-sidebar-wrapper.wpbf-medium-1-3',
				'props'    => array( 'width' => wpbf_maybe_append_suffix( $sidebar_width, '%' ) ),
			),
			array(
				'selector' => 'body:not(.wpbf-no-sidebar) .wpbf-main.wpbf-medium-2-3',
				'props'    => array( 'width' => ( 100 - $sidebar_width ) . '%' ),
			),
		),
	) );

}
