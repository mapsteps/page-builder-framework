<?php
/**
 * Header builder's desktop menu trigger section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$section_id = 'wpbf_header_builder_desktop_menu_trigger_section';

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
	->addToPanel( 'header_panel' );

$control_id_prefix = 'wpbf_header_builder_desktop_menu_trigger_';

/* General Tab */

wpbf_customizer_field()
	->id( $control_id_prefix . 'icon' )
	->type( 'radio-buttonset' )
	->tab( 'general' )
	->label( __( 'Icon', 'page-builder-framework' ) )
	->defaultValue( 'none' )
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

// Icon separator.
wpbf_customizer_field()
	->id( $control_id_prefix . 'button_separator' )
	->type( 'headline' )
	->tab( 'design' )
	->label( __( 'Button Settings', 'page-builder-framework' ) )
	->activeCallback( [
		array(
			'setting'  => $control_id_prefix . 'icon',
			'operator' => '!=',
			'value'    => 'none',
		),
		array(
			'setting'  => $control_id_prefix . 'style',
			'operator' => '!=',
			'value'    => '',
		),
	] )
	->addToSection( $section_id );

// Padding.
wpbf_customizer_field()
	->id( $control_id_prefix . 'padding' )
	->type( 'padding' )
	->tab( 'design' )
	->label( __( 'Padding', 'page-builder-framework' ) )
	->defaultValue( array(
		'top'    => 5,
		'right'  => 5,
		'bottom' => 5,
		'left'   => 5,
	) )
	->transport( 'postMessage' )
	->activeCallback( [
		array(
			'setting'  => $control_id_prefix . 'style',
			'operator' => '!=',
			'value'    => '',
		),
	] )
	->addToSection( $section_id );

$menu_trigger_style = wpbf_customize_str_value( $control_id_prefix . 'style' );

// Button background color.
wpbf_customizer_field()
	->id( $control_id_prefix . 'bg_color' )
	->type( 'color' )
	->tab( 'design' )
	->label(
		'outline' === $menu_trigger_style
		? __( 'Border Color', 'page-builder-framework' )
		: __( 'Background Color', 'page-builder-framework' )
	)
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		array(
			'setting'  => $control_id_prefix . 'icon',
			'operator' => '!=',
			'value'    => 'none',
		),
		array(
			'setting'  => $control_id_prefix . 'style',
			'operator' => '!=',
			'value'    => '',
		),
	] )
	->addToSection( $section_id );

// Border radius.
wpbf_customizer_field()
	->id( $control_id_prefix . 'border_radius' )
	->type( 'input-slider' )
	->tab( 'design' )
	->label( __( 'Border Radius', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->activeCallback( [
		array(
			'setting'  => $control_id_prefix . 'icon',
			'operator' => '!=',
			'value'    => 'none',
		),
		array(
			'setting'  => $control_id_prefix . 'style',
			'operator' => '!=',
			'value'    => '',
		),
	] )
	->addToSection( $section_id );

// Icon separator.
wpbf_customizer_field()
	->id( $control_id_prefix . 'icon_separator' )
	->type( 'headline' )
	->tab( 'design' )
	->label( __( 'Icon Settings', 'page-builder-framework' ) )
	->activeCallback( [
		array(
			'setting'  => $control_id_prefix . 'icon',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( $section_id );

// Icon color.
wpbf_customizer_field()
	->id( $control_id_prefix . 'icon_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Icon Color', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		array(
			'setting'  => $control_id_prefix . 'icon',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( $section_id );

// Icon size.
wpbf_customizer_field()
	->id( $control_id_prefix . 'icon_size' )
	->type( 'input-slider' )
	->tab( 'design' )
	->label( __( 'Icon Size', 'page-builder-framework' ) )
	->defaultValue( '16px' )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->activeCallback( [
		array(
			'setting'  => $control_id_prefix . 'icon',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( $section_id );
