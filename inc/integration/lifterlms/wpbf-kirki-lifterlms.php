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
Kirki::add_panel( 'lifterlms_panel', array(
	'priority' => 200,
	'title'    => __( 'LifterLMS', 'page-builder-framework' ),
) );

/* Sections */

// Menu item.
Kirki::add_section( 'wpbf_lifterlms_color_options', array(
	'title'    => __( 'Colors', 'page-builder-framework' ),
	'panel'    => 'lifterlms_panel',
	'priority' => 1,
) );

// Sidebar.
// Kirki::add_section( 'wpbf_lifterlms_sidebar_options', array(
// 	'title'    => __( 'Sidebar', 'page-builder-framework' ),
// 	'panel'    => 'lifterlms_panel',
// 	'priority' => 2,
// ) );

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