<?php
/**
 * Header builder's menu trigger section.
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
		<svg class="ct-icon" width="18" height="14" viewBox="0 0 18 14" fill="currentColor" aria-hidden="true" data-variant="variant-1">
			<rect y="0.00" width="18" height="1.7" rx="1"></rect>
			<rect y="6.15" width="18" height="1.7" rx="1"></rect>
			<rect y="12.3" width="18" height="1.7" rx="1"></rect>
		</svg>
		',
		'variant-2' => '
		<svg class="ct-icon" width="18" height="14" viewBox="0 0 18 14" fill="currentColor" aria-hidden="true" data-variant="variant-2">
			<rect y="0.00" width="10" height="1.7" rx="1"></rect>
			<rect y="6.15" width="18" height="1.7" rx="1"></rect>
			<rect y="12.3" width="15" height="1.7" rx="1"></rect>
		</svg>
		',
		'variant-3' => '
		<svg class="ct-icon" width="18" height="14" viewBox="0 0 18 14" fill="currentColor" aria-hidden="true" data-variant="variant-3">
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
