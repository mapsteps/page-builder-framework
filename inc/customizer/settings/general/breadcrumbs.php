<?php
/**
 * Breadcrumbs customizer settings.
 *
 * @package    Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Fields - Breadcrumb Settings */

// Toggle.
wpbf_customizer_field()
	->id( 'breadcrumbs_toggle' )
	->type( 'toggle' )
	->label( __( 'Breadcrumbs', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 1 )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Separator.
wpbf_customizer_field()
	->id( 'breadcrumbs_toggle_separator' )
	->type( 'divider' )
	->priority( 1 )
	->activeCallback( [
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Breadcrumbs.
wpbf_customizer_field()
	->id( 'breadcrumbs' )
	->type( 'enhanced-select' )
	->label( __( 'Display Breadcrumbs on', 'page-builder-framework' ) )
	->defaultValue( array( 'archive', 'single' ) )
	->priority( 2 )
	->choices( array(
		'front_page' => __( 'Front Page', 'page-builder-framework' ),
		'archive'    => __( 'Archives', 'page-builder-framework' ),
		'single'     => __( 'Single', 'page-builder-framework' ),
		'search'     => __( 'Search Page', 'page-builder-framework' ),
		'404'        => __( '404 Page', 'page-builder-framework' ),
		'page'       => __( 'Pages', 'page-builder-framework' ),
	) )
	->properties( array(
		'multiple'       => true,
		'max_selections' => 6,
	) )
	->activeCallback( [
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Position.
wpbf_customizer_field()
	->id( 'breadcrumbs_position' )
	->type( 'select' )
	->label( __( 'Position', 'page-builder-framework' ) )
	->defaultValue( 'content' )
	->priority( 2 )
	->choices( array(
		'content' => __( 'Before Content', 'page-builder-framework' ),
		'header'  => __( 'Below Header', 'page-builder-framework' ),
	) )
	->activeCallback( [
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Separator.
wpbf_customizer_field()
	->id( 'breadcrumbs_separator' )
	->type( 'text' )
	->label( __( 'Separator', 'page-builder-framework' ) )
	->defaultValue( '/' )
	->priority( 2 )
	->activeCallback( [
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->partialRefresh( [
		'breadcrumbs_separator' => array(
			'container_inclusive' => true,
			'selector'            => '.wpbf-breadcrumbs',
			'render_callback'     => function () {
				return wpbf_do_breadcrumbs();
			},
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Alignment.
wpbf_customizer_field()
	->id( 'breadcrumbs_alignment' )
	->type( 'radio-image' )
	->label( __( 'Alignment', 'page-builder-framework' ) )
	->defaultValue( 'left' )
	->priority( 2 )
	->choices( array(
		'left'   => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center' => WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'  => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	) )
	->activeCallback( [
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		),
		array(
			'setting'  => 'breadcrumbs_position',
			'operator' => '==',
			'value'    => 'header',
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Headline.
wpbf_customizer_field()
	->id( 'breadcrumbs_color_divider' )
	->type( 'divider' )
	->priority( 2 )
	->activeCallback( [
		[
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		],
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

wpbf_customizer_field()
	->id( 'breadcrumbs_background_color' )
	->type( 'color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( '#dedee5' )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		[
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		],
		[
			'setting'  => 'breadcrumbs_position',
			'operator' => '==',
			'value'    => 'header',
		],
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );


// Font color.
wpbf_customizer_field()
	->id( 'breadcrumbs_font_color' )
	->type( 'color' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Accent color.
wpbf_customizer_field()
	->id( 'breadcrumbs_accent_color' )
	->type( 'color' )
	->label( __( 'Accent Color', 'page-builder-framework' ) )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Accent color hover.
wpbf_customizer_field()
	->id( 'breadcrumbs_accent_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );
