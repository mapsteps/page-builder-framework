<?php
/**
 * Header builder's mobile menu trigger section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$section_id = 'wpbf_header_builder_mobile_menu_trigger_section';

wpbf_customizer_section()
	->id( $section_id )
	->type( 'invisible' )
	->title( __( 'Menu Trigger', 'page-builder-framework' ) )
	->tabs( [
		'general' => [
			'label' => esc_html__( 'General', 'page-builder-framework' ),
		],
		'design'  => [
			'label' => esc_html__( 'Design', 'page-builder-framework' ),
		],
	] )
	->priority( 3 )
	->addToPanel( 'header_panel' );

$control_id_prefix = 'wpbf_header_builder_mobile_menu_trigger_';

/* General Tab */

wpbf_customizer_field()
	->id( $control_id_prefix . 'icon' )
	->type( 'radio-buttonset' )
	->tab( 'general' )
	->label( __( 'Icon', 'page-builder-framework' ) )
	->defaultValue( 'none' )
	->priority( 1 )
	->choices( [
		'none'      => '
		<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
			<circle cx="50" cy="50" r="35" 
					fill="none" 
					stroke="currentColor" 
					stroke-width="8"/>
			
			<line x1="25" y1="75" 
				x2="75" y2="25" 
				stroke="currentColor" 
				stroke-width="8" 
				stroke-linecap="round"/>
		</svg>
		',
		'variant-1' => '
		<svg class="menu-trigger-button-svg" width="18" height="14" viewBox="0 0 18 14" fill="currentColor" aria-hidden="true" data-variant="variant-1">
			<rect y="0.00" width="18" height="1.7" rx="1"></rect>
			<rect y="6.15" width="18" height="1.7" rx="1"></rect>
			<rect y="12.3" width="18" height="1.7" rx="1"></rect>
		</svg>
		',
		'variant-2' => '
		<svg class="menu-trigger-button-svg" width="18" height="14" viewBox="0 0 18 14" fill="currentColor" aria-hidden="true" data-variant="variant-2">
			<rect y="0.00" width="10" height="1.7" rx="1"></rect>
			<rect y="6.15" width="18" height="1.7" rx="1"></rect>
			<rect y="12.3" width="15" height="1.7" rx="1"></rect>
		</svg>
		',
		'variant-3' => '
		<svg class="menu-trigger-button-svg" width="18" height="14" viewBox="0 0 18 14" fill="currentColor" aria-hidden="true" data-variant="variant-3">
			<rect y="0.00" x="6.00" width="12" height="1.7" rx="1"></rect>
			<rect y="6.15" width="18" height="1.7" rx="1"></rect>
			<rect y="12.3" width="12" height="1.7" rx="1"></rect>
		</svg>
		',
	] )
	->defaultValue( 'variant-1' )
	->transport( 'postMessage' )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'text' )
	->type( 'text' )
	->tab( 'general' )
	->label( __( 'Label', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->properties( array(
		'input_attrs' => array(
			'placeholder' => __( 'Menu', 'page-builder-framework' ),
		),
	) )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'style' )
	->type( 'radio-buttonset' )
	->tab( 'general' )
	->label( __( 'Style', 'page-builder-framework' ) )
	->defaultValue( '' )
	->choices( [
		''        => 'Simple',
		'outline' => 'Outlined',
		'solid'   => 'Solid',
	] )
	->transport( 'postMessage' )
	->addToSection( $section_id );

/* Design Tab */

// Button separator.
wpbf_customizer_field()
	->id( $control_id_prefix . 'button_separator' )
	->type( 'headline' )
	->tab( 'design' )
	->label( __( 'Button Settings', 'page-builder-framework' ) )
	->priority( 190 )
	->activeCallback( [
		array(
			'setting'  => $control_id_prefix . 'icon',
			'operator' => '!=',
			'value'    => 'none',
		),
		array(
			'setting'  => $control_id_prefix . 'style',
			'operator' => 'in',
			'value'    => array( 'outline', 'solid' ),
		),
	] )
	->addToSection( $section_id );

// Padding.
wpbf_customizer_field()
	->id( $control_id_prefix . 'padding' )
	->type( 'padding' )
	->tab( 'design' )
	->label( __( 'Padding', 'page-builder-framework' ) )
	->priority( 200 )
	->defaultValue( array(
		'top'    => 10,
		'right'  => 10,
		'bottom' => 10,
		'left'   => 10,
	) )
	->transport( 'postMessage' )
	->activeCallback( [
		array(
			'setting'  => $control_id_prefix . 'style',
			'operator' => 'in',
			'value'    => array( 'outline', 'solid' ),
		),
		array(
			'setting'  => $control_id_prefix . 'icon',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( $section_id );

// Border radius is added automatically by customizer.ts for mobile; headline above groups button settings.

// Icon separator.
wpbf_customizer_field()
	->id( $control_id_prefix . 'icon_separator' )
	->type( 'headline' )
	->tab( 'design' )
	->label( __( 'Icon Settings', 'page-builder-framework' ) )
	->priority( 290 )
	->activeCallback( [
		array(
			'setting'  => $control_id_prefix . 'icon',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( $section_id );

// Icon color and size are added automatically by customizer.ts for mobile; headline above groups icon settings.
