<?php
/**
 * Init
 *
 * All files are being called from here.
 *
 * @package Page Builder Framework
 */

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$menu_logo_font_size             = get_theme_mod( 'menu_logo_font_size' );
$menu_logo_description_font_size = get_theme_mod( 'menu_logo_description_font_size' );

if( $menu_logo_font_size ) {
	set_theme_mod( 'menu_logo_font_size_desktop', $menu_logo_font_size );
	remove_theme_mod( 'menu_logo_font_size' );
}

if( $menu_logo_description_font_size ) {
	set_theme_mod( 'menu_logo_description_font_size_desktop', $menu_logo_description_font_size );
	remove_theme_mod( 'menu_logo_description_font_size' );
}