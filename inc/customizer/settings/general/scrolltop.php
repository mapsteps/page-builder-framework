<?php
/**
 * Scroll to Top customizer settings.
 *
 * @package    Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Fields - ScrollTop */

// Toggle.
wpbf_customizer_field()
	->id( 'layout_scrolltop' )
	->type( 'toggle' )
	->label( __( 'Scroll to Top Button', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 0 )
	->addToSection( 'wpbf_scrolltop_options' );

// Separator.
wpbf_customizer_field()
	->id( 'layout_scrolltop_separator' )
	->type( 'divider' )
	->priority( 0 )
	->activeCallback( [
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Alignment.
wpbf_customizer_field()
	->id( 'scrolltop_position' )
	->type( 'radio-image' )
	->label( __( 'Alignment', 'page-builder-framework' ) )
	->defaultValue( 'right' )
	->priority( 1 )
	->transport( 'postMessage' )
	->choices( array(
		'left'  => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'right' => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	) )
	->activeCallback( [
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Show after.
wpbf_customizer_field()
	->id( 'scrolltop_value' )
	->type( 'slider' )
	->label( __( 'Show after (px)', 'page-builder-framework' ) )
	->defaultValue( 400 )
	->priority( 2 )
	->properties( array(
		'min'  => 50,
		'max'  => 1000,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Divider.
wpbf_customizer_field()
	->id( 'layout_scrolltop_separator_2' )
	->type( 'divider' )
	->priority( 3 )
	->activeCallback( [
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Background color.
wpbf_customizer_field()
	->id( 'scrolltop_bg_color' )
	->type( 'color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( 'rgba(62,67,73,0.5)' )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Background color hover.
wpbf_customizer_field()
	->id( 'scrolltop_bg_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->defaultValue( 'rgba(62,67,73,0.7)' )
	->priority( 5 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );


// Icon color.
wpbf_customizer_field()
	->id( 'scrolltop_icon_color' )
	->type( 'color' )
	->label( __( 'Icon Color', 'page-builder-framework' ) )
	->defaultValue( '#ffffff' )
	->priority( 6 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Icon color hover.
wpbf_customizer_field()
	->id( 'scrolltop_icon_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 7 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Border radius.
wpbf_customizer_field()
	->id( 'scrolltop_border_radius' )
	->type( 'slider' )
	->label( __( 'Border Radius', 'page-builder-framework' ) )
	->defaultValue( 0 )
	->priority( 8 )
	->properties( array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );
