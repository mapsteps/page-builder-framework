<?php
/**
 * Blog customizer settings - Pagination Fields.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Fields - Pagination */

// Pagination background color.
wpbf_customizer_field()
	->id( 'blog_pagination_background_color' )
	->type( 'color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_pagination_settings' );

// Pagination background color alt.
wpbf_customizer_field()
	->id( 'blog_pagination_background_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_pagination_settings' );

// Pagination background color active.
wpbf_customizer_field()
	->id( 'blog_pagination_background_color_active' )
	->type( 'color' )
	->label( __( 'Active', 'page-builder-framework' ) )
	->priority( 3 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_pagination_settings' );

// Pagination font color.
wpbf_customizer_field()
	->id( 'blog_pagination_font_color' )
	->type( 'color' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_pagination_settings' );

// Pagination hover color.
wpbf_customizer_field()
	->id( 'blog_pagination_font_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 5 )
	->transport( 'postMessage' )
	->defaultValue( '' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_pagination_settings' );

// Pagination active color.
wpbf_customizer_field()
	->id( 'blog_pagination_font_color_active' )
	->type( 'color' )
	->label( __( 'Active', 'page-builder-framework' ) )
	->priority( 6 )
	->transport( 'postMessage' )
	->defaultValue( '' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_pagination_settings' );

// Border radius.
wpbf_customizer_field()
	->id( 'blog_pagination_border_radius' )
	->type( 'slider' )
	->label( __( 'Border Radius', 'page-builder-framework' ) )
	->defaultValue( 0 )
	->priority( 7 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	] )
	->addToSection( 'wpbf_pagination_settings' );

// Pagination font size.
wpbf_customizer_field()
	->id( 'blog_pagination_font_size' )
	->type( 'input-slider' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->priority( 8 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	] )
	->addToSection( 'wpbf_pagination_settings' );
