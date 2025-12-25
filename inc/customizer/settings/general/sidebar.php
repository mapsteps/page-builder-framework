<?php
/**
 * Sidebar customizer settings.
 *
 * @package    Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Fields - Sidebar */

wpbf_customizer_field()
	->id( 'sidebar_position' )
	->type( 'select' )
	->label( __( 'Position (Global)', 'page-builder-framework' ) )
	->priority( 1 )
	->defaultValue( 'right' )
	->choices( array(
		'right' => __( 'Right', 'page-builder-framework' ),
		'left'  => __( 'Left', 'page-builder-framework' ),
		'none'  => __( 'No Sidebar', 'page-builder-framework' ),
	) )
	->addToSection( 'wpbf_sidebar_options' );

wpbf_customizer_field()
	->id( 'sidebar_gap' )
	->type( 'enhanced-select' )
	->label( __( 'Gap', 'page-builder-framework' ) )
	->priority( 2 )
	->defaultValue( 'medium' )
	->choices( array(
		'divider'  => __( 'Divider', 'page-builder-framework' ),
		'xlarge'   => __( 'xLarge', 'page-builder-framework' ),
		'large'    => __( 'Large', 'page-builder-framework' ),
		'medium'   => __( 'Medium', 'page-builder-framework' ),
		'small'    => __( 'Small', 'page-builder-framework' ),
		'collapse' => __( 'Collapse', 'page-builder-framework' ),
	) )
	->addToSection( 'wpbf_sidebar_options' );

wpbf_customizer_field()
	->id( 'sidebar_width' )
	->type( 'slider' )
	->transport( 'postMessage' )
	->label( __( 'Width', 'page-builder-framework' ) )
	->priority( 2 )
	->defaultValue( 33.3 )
	->properties( array(
		'min'  => 20,
		'max'  => 40,
		'step' => 0.1,
	) )
	->activeCallback( [
		array(
			'setting'  => 'sidebar_position',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_sidebar_options' );

// Headline.
wpbf_customizer_field()
	->id( 'widget_headline' )
	->type( 'headline' )
	->label( __( 'Sidebar Widgets', 'page-builder-framework' ) )
	->priority( 2 )
	->addToSection( 'wpbf_sidebar_options' );

// Padding.
wpbf_customizer_field()
	->id( 'sidebar_widget_padding' )
	->type( 'responsive-padding' )
	->label( __( 'Padding', 'page-builder-framework' ) )
	->priority( 3 )
	->defaultValue( array(
		'desktop_top'    => 20,
		'desktop_right'  => 20,
		'desktop_bottom' => 20,
		'desktop_left'   => 20,
		'tablet_top'     => 20,
		'tablet_right'   => 20,
		'tablet_bottom'  => 20,
		'tablet_left'    => 20,
		'mobile_top'     => 20,
		'mobile_right'   => 20,
		'mobile_bottom'  => 20,
		'mobile_left'    => 20,
	) )
	->properties( [
		'save_as_json'   => true,
		'dont_save_unit' => true,
	] )
	->addToSection( 'wpbf_sidebar_options' );

// Color.
wpbf_customizer_field()
	->id( 'sidebar_bg_color' )
	->type( 'color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( '#f5f5f7' )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_sidebar_options' );
