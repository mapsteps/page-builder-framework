<?php
/**
 * LifterLMS customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Integration/LifterLMS
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Textdomain. This is required, otherwise strings aren't translateable.
load_theme_textdomain( 'page-builder-framework' );

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
// wpbf_customizer_section()
// 	->id( 'wpbf_lifterlms_sidebar_options' )
// 	->title( __( 'Sidebar', 'page-builder-framework' ) )
// 	->priority( 2 )
// 	->addToPanel( 'lifterlms_panel' );

/* Fields - Colors */

// Primary color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'lifterlms_primary_color',
	'label'           => __( 'Primary Color', 'page-builder-framework' ),
	'section'         => 'wpbf_lifterlms_color_options',
	'default'         => '#2295ff',
	'priority'        => 1,
	// 'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
) );

// Action color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'lifterlms_action_color',
	'label'           => __( 'Action Color', 'page-builder-framework' ),
	'section'         => 'wpbf_lifterlms_color_options',
	'default'         => '#f8954f',
	'priority'        => 1,
	// 'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
) );

// Accent color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'lifterlms_accent_color',
	'label'           => __( 'Accent Color', 'page-builder-framework' ),
	'section'         => 'wpbf_lifterlms_color_options',
	'default'         => '#ef476f',
	'priority'        => 1,
	// 'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
) );
