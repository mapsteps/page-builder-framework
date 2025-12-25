<?php
/**
 * Theme Buttons customizer settings.
 *
 * @package    Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Fields - Buttons */

// Headline.
wpbf_customizer_field()
	->id( 'button_headline' )
	->type( 'headline' )
	->label( __( 'Theme Buttons', 'page-builder-framework' ) )
	->tooltip( __( 'Applies to default buttons such as "Read more" used throughout the theme.', 'page-builder-framework' ) )
	->priority( 0 )
	->addToSection( 'wpbf_button_options' );

// Background color.
wpbf_customizer_field()
	->id( 'button_bg_color' )
	->type( 'color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Background color alt.
wpbf_customizer_field()
	->id( 'button_bg_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Text color.
wpbf_customizer_field()
	->id( 'button_text_color' )
	->type( 'color' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Text color alt.
wpbf_customizer_field()
	->id( 'button_text_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Headline.
wpbf_customizer_field()
	->id( 'button_primary_headline' )
	->type( 'headline' )
	->label( __( 'Theme Buttons (Primary)', 'page-builder-framework' ) )
	->tooltip( __( 'Applies to buttons displayed in the themes accent color such as WooCommerce buttons.', 'page-builder-framework' ) )
	->priority( 1 )
	->addToSection( 'wpbf_button_options' );

// Primary background color.
wpbf_customizer_field()
	->id( 'button_primary_bg_color' )
	->type( 'color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Primary background color alt.
wpbf_customizer_field()
	->id( 'button_primary_bg_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Primary text color.
wpbf_customizer_field()
	->id( 'button_primary_text_color' )
	->type( 'color' )
	->label( __( 'Primary Font Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Primary text color alt.
wpbf_customizer_field()
	->id( 'button_primary_text_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Divider.
wpbf_customizer_field()
	->id( 'button_border_divider' )
	->type( 'divider' )
	->priority( 1 )
	->addToSection( 'wpbf_button_options' );

// Border radius.
wpbf_customizer_field()
	->id( 'button_border_radius' )
	->type( 'slider' )
	->label( __( 'Border Radius', 'page-builder-framework' ) )
	->defaultValue( 0 )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	) )
	->addToSection( 'wpbf_button_options' );

// Border width.
wpbf_customizer_field()
	->id( 'button_border_width' )
	->type( 'slider' )
	->label( __( 'Border Width', 'page-builder-framework' ) )
	->defaultValue( 0 )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'min'  => 0,
		'max'  => 10,
		'step' => 1,
	) )
	->addToSection( 'wpbf_button_options' );

// Divider.
wpbf_customizer_field()
	->id( 'button_border_divider_2' )
	->type( 'divider' )
	->priority( 1 )
	->activeCallback( [
		array(
			'setting'  => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	] )
	->addToSection( 'wpbf_button_options' );

// Border color.
wpbf_customizer_field()
	->id( 'button_border_color' )
	->type( 'color' )
	->label( __( 'Border Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'setting'  => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	] )
	->addToSection( 'wpbf_button_options' );

// Border color alt.
wpbf_customizer_field()
	->id( 'button_border_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'setting'  => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	] )
	->addToSection( 'wpbf_button_options' );

// Primary border color.
wpbf_customizer_field()
	->id( 'button_primary_border_color' )
	->type( 'color' )
	->label( __( 'Primary Border Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'setting'  => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	] )
	->addToSection( 'wpbf_button_options' );

// Primary border color alt.
wpbf_customizer_field()
	->id( 'button_primary_border_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'setting'  => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	] )
	->addToSection( 'wpbf_button_options' );
