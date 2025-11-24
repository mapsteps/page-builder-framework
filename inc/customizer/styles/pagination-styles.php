<?php
/**
 * Pagination customizer styles.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Pagination.
$blog_pagination_border_radius    = wpbf_customize_str_value( 'blog_pagination_border_radius' );
$blog_pagination_font_size        = wpbf_customize_str_value( 'blog_pagination_font_size' );
$blog_pagination_background_color = wpbf_customize_str_value( 'blog_pagination_background_color' );
$blog_pagination_font_color       = wpbf_customize_str_value( 'blog_pagination_font_color' );

// ? Why does this exist? It's not being used anywhere in this file.
$blog_pagination_background_color_next_prev = wpbf_customize_str_value( 'blog_pagination_background_color_next_prev' );

if ( $blog_pagination_border_radius || $blog_pagination_font_size || $blog_pagination_background_color || $blog_pagination_font_color ) {

	wpbf_write_css( array(
		'selector' => '.pagination .page-numbers',
		'props'    => array(
			'border-radius'    => $blog_pagination_border_radius ? wpbf_maybe_append_suffix( $blog_pagination_border_radius ) : null,
			'font-size'        => $blog_pagination_font_size ? wpbf_maybe_append_suffix( $blog_pagination_font_size ) : null,
			'background-color' => $blog_pagination_background_color ? $blog_pagination_background_color : null,
			'color'            => $blog_pagination_font_color ? $blog_pagination_font_color : null,
		),
	) );

}

$blog_pagination_background_color_alt = wpbf_customize_str_value( 'blog_pagination_background_color_alt' );
$blog_pagination_font_color_alt       = wpbf_customize_str_value( 'blog_pagination_font_color_alt' );

if ( $blog_pagination_background_color_alt || $blog_pagination_font_color_alt ) {

	wpbf_write_css( array(
		'selector' => '.pagination .page-numbers:hover',
		'props'    => array(
			'background-color' => $blog_pagination_background_color_alt ? $blog_pagination_background_color_alt : null,
			'color'            => $blog_pagination_font_color_alt ? $blog_pagination_font_color_alt : null,
		),
	) );

}

$blog_pagination_background_color_active = wpbf_customize_str_value( 'blog_pagination_background_color_active' );
$blog_pagination_font_color_active       = wpbf_customize_str_value( 'blog_pagination_font_color_active' );

if ( $blog_pagination_background_color_active || $blog_pagination_font_color_active ) {

	wpbf_write_css( array(
		'selector' => '.pagination .page-numbers.current',
		'props'    => array(
			'background-color' => $blog_pagination_background_color_active ? $blog_pagination_background_color_active . '!important' : null,
			'color'            => $blog_pagination_font_color_active ? $blog_pagination_font_color_active : null,
		),
	) );

}
