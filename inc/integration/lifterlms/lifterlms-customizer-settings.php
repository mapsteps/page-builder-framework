<?php
/**
 * LifterLMS customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Integration/LifterLMS
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Panels */

// LifterLMS.
wpbf_customizer_panel()
	->id( 'lifterlms_panel' )
	->title( __( 'LifterLMS', 'page-builder-framework' ) )
	->priority( 200 )
	->add();

/* Sections */

// Menu item.
wpbf_customizer_section()
	->id( 'wpbf_lifterlms_color_options' )
	->title( __( 'Colors', 'page-builder-framework' ) )
	->priority( 1 )
	->addToPanel( 'lifterlms_panel' );

// Sidebar.

/*
wpbf_customizer_section()
	->id( 'wpbf_lifterlms_sidebar_options' )
	->title( __( 'Sidebar', 'page-builder-framework' ) )
	->priority( 2 )
	->addToPanel( 'lifterlms_panel' );
*/

/* Fields - Colors */

// Primary color.
wpbf_customizer_field()
	->id( 'lifterlms_primary_color' )
	->type( 'color' )
	->label( __( 'Primary Color', 'page-builder-framework' ) )
	->defaultValue( '#2295ff' )
	->priority( 1 )
	// ->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_lifterlms_color_options' );

// Action color.
wpbf_customizer_field()
	->id( 'lifterlms_action_color' )
	->type( 'color' )
	->label( __( 'Action Color', 'page-builder-framework' ) )
	->defaultValue( '#f8954f' )
	->priority( 1 )
	// ->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_lifterlms_color_options' );

// Accent color.
wpbf_customizer_field()
	->id( 'lifterlms_accent_color' )
	->type( 'color' )
	->label( __( 'Accent Color', 'page-builder-framework' ) )
	->defaultValue( '#ef476f' )
	->priority( 1 )
	// ->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_lifterlms_color_options' );
