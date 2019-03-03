<?php
/**
 * Backwards Compatibility
 *
 * @package Page Builder Framework
 */

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$menu_logo_font_size             = get_theme_mod( 'menu_logo_font_size' );
$menu_logo_description_font_size = get_theme_mod( 'menu_logo_description_font_size' );
$sidebar_widget_padding_top      = get_theme_mod( 'sidebar_widget_padding_top' );
$sidebar_widget_padding_right    = get_theme_mod( 'sidebar_widget_padding_right' );
$sidebar_widget_padding_bottom   = get_theme_mod( 'sidebar_widget_padding_bottom' );
$sidebar_widget_padding_left     = get_theme_mod( 'sidebar_widget_padding_left' );

if( $menu_logo_font_size ) {
	set_theme_mod( 'menu_logo_font_size_desktop', $menu_logo_font_size );
	remove_theme_mod( 'menu_logo_font_size' );
}

if( $menu_logo_description_font_size ) {
	set_theme_mod( 'menu_logo_description_font_size_desktop', $menu_logo_description_font_size );
	remove_theme_mod( 'menu_logo_description_font_size' );
}

if( $sidebar_widget_padding_top ) {
	set_theme_mod( 'sidebar_widget_padding_top_desktop', $sidebar_widget_padding_top );
	remove_theme_mod( 'sidebar_widget_padding_top' );
}

if( $sidebar_widget_padding_right ) {
	set_theme_mod( 'sidebar_widget_padding_right_desktop', $sidebar_widget_padding_right );
	remove_theme_mod( 'sidebar_widget_padding_right' );
}

if( $sidebar_widget_padding_bottom ) {
	set_theme_mod( 'sidebar_widget_padding_bottom_desktop', $sidebar_widget_padding_bottom );
	remove_theme_mod( 'sidebar_widget_padding_bottom' );
}

if( $sidebar_widget_padding_left ) {
	set_theme_mod( 'sidebar_widget_padding_left_desktop', $sidebar_widget_padding_left );
	remove_theme_mod( 'sidebar_widget_padding_left' );
}