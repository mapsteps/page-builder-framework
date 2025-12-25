<?php
/**
 * Layout customizer settings.
 *
 * @package    Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Fields - Layout */

// Max width.
wpbf_customizer_field()
	->id( 'page_max_width' )
	->type( 'dimension' )
	->label( __( 'Page Width', 'page-builder-framework' ) )
	->description( __( 'Default: 1200px', 'page-builder-framework' ) )
	->priority( 0 )
	->transport( 'postMessage' )
	->addToSection( 'wpbf_page_options' );

// Padding.
wpbf_customizer_field()
	->id( 'page_padding' )
	->type( 'responsive-padding' )
	->label( __( 'Page Padding', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->defaultValue( array(
		'desktop_top'    => 40,
		'desktop_right'  => 20,
		'desktop_bottom' => 40,
		'desktop_left'   => 20,
	) )
	->properties( [
		'save_as_json'   => true,
		'dont_save_unit' => true,
	] )
	->addToSection( 'wpbf_page_options' );

// Boxed.
wpbf_customizer_field()
	->id( 'page_boxed' )
	->type( 'headline-toggle' )
	->label( __( 'Boxed Layout', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 2 )
	->addToSection( 'wpbf_page_options' );

// Boxed margin.
wpbf_customizer_field()
	->id( 'page_boxed_margin' )
	->type( 'slider' )
	->label( __( 'Margin', 'page-builder-framework' ) )
	->priority( 3 )
	->defaultValue( 0 )
	->transport( 'postMessage' )
	->properties( array(
		'min'  => 0,
		'max'  => 80,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_page_options' );

// Boxed padding.
wpbf_customizer_field()
	->id( 'page_boxed_padding' )
	->type( 'slider' )
	->label( __( 'Padding', 'page-builder-framework' ) )
	->priority( 4 )
	->defaultValue( 20 )
	->transport( 'postMessage' )
	->properties( array(
		'min'  => 20,
		'max'  => 100,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_page_options' );

// Background color.
wpbf_customizer_field()
	->id( 'page_boxed_background' )
	->type( 'color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( '#ffffff' )
	->priority( 5 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_page_options' );

// Box shadow.
wpbf_customizer_field()
	->id( 'page_boxed_box_shadow' )
	->type( 'headline-toggle' )
	->label( __( 'Box Shadow', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 6 )
	->activeCallback( [
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_page_options' );

// Box shadow blur.
wpbf_customizer_field()
	->id( 'page_boxed_box_shadow_blur' )
	->type( 'slider' )
	->label( __( 'Blur', 'page-builder-framework' ) )
	->priority( 7 )
	->defaultValue( 25 )
	->properties( array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => true,
		),
		array(
			'setting'  => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_page_options' );

// Box shadow spread.
wpbf_customizer_field()
	->id( 'page_boxed_box_shadow_spread' )
	->type( 'slider' )
	->label( __( 'Spread', 'page-builder-framework' ) )
	->priority( 8 )
	->defaultValue( 0 )
	->properties( array(
		'min'  => - 100,
		'max'  => 100,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => true,
		),
		array(
			'setting'  => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_page_options' );

// Box shadow horizontal.
wpbf_customizer_field()
	->id( 'page_boxed_box_shadow_horizontal' )
	->type( 'slider' )
	->label( __( 'Horizontal', 'page-builder-framework' ) )
	->priority( 9 )
	->defaultValue( 0 )
	->properties( array(
		'min'  => - 100,
		'max'  => 100,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => true,
		),
		array(
			'setting'  => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_page_options' );

// Box shadow vertical.
wpbf_customizer_field()
	->id( 'page_boxed_box_shadow_vertical' )
	->type( 'slider' )
	->label( __( 'Vertical', 'page-builder-framework' ) )
	->priority( 10 )
	->defaultValue( 0 )
	->properties( array(
		'min'  => - 100,
		'max'  => 100,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => true,
		),
		array(
			'setting'  => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_page_options' );

// Box shadow color.
wpbf_customizer_field()
	->id( 'page_boxed_box_shadow_color' )
	->type( 'color' )
	->label( __( 'Color', 'page-builder-framework' ) )
	->defaultValue( 'rgba(0,0,0,.15)' )
	->priority( 11 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => true,
		),
		array(
			'setting'  => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_page_options' );

/* Fields - Background */

// Background color.
/**
 * The idea was to replace the old WordPress color picker with our new interface.
 * But it doesn't work as expected.
wpbf_customizer_field()
	->id( 'background_color' )
	->type( 'color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( '#ffffff' )
	->priority( 100 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'background_image' );
*/
