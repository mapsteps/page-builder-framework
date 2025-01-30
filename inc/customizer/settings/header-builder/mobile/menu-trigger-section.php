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
		''          => '
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
		'variant-1' => '<svg width="100%" viewBox="0 0 100 70"><path d="M61.2,36.2H38.8c-0.7,0-1.2-0.6-1.2-1.2l0,0c0-0.7,0.6-1.2,1.2-1.2h22.5c0.7,0,1.2,0.6,1.2,1.2l0,0C62.5,35.7,61.9,36.2,61.2,36.2z M62.5,44L62.5,44c0-0.7-0.6-1.2-1.2-1.2H38.8c-0.7,0-1.2,0.6-1.2,1.2l0,0c0,0.7,0.6,1.2,1.2,1.2h22.5C61.9,45.3,62.5,44.7,62.5,44z M62.5,26L62.5,26c0-0.7-0.6-1.3-1.2-1.3H38.8c-0.7,0-1.2,0.6-1.2,1.2v0c0,0.7,0.6,1.2,1.2,1.2h22.5C61.9,27.2,62.5,26.7,62.5,26z"></path></svg>',
		'variant-2' => '<svg width="100%" viewBox="0 0 100 70"><path d="M61.2,36.2H38.8c-0.7,0-1.2-0.6-1.2-1.2l0,0c0-0.7,0.6-1.2,1.2-1.2h22.5c0.7,0,1.2,0.6,1.2,1.2l0,0C62.5,35.7,61.9,36.2,61.2,36.2z M56.3,43L56.3,43c0-0.7-0.6-1.3-1.2-1.3H38.8c-0.7,0-1.2,0.6-1.2,1.2v0c0,0.7,0.6,1.2,1.2,1.2H55C55.7,44.3,56.3,43.7,56.3,43z M50,27L50,27c0-0.7-0.6-1.2-1.2-1.2h-10c-0.7,0-1.2,0.6-1.2,1.2v0c0,0.7,0.6,1.2,1.2,1.2h10C49.4,28.2,50,27.7,50,27z"></path></svg>',
		'variant-3' => '<svg width="100%" viewBox="0 0 100 70"><path d="M61.2,36.2H38.8c-0.7,0-1.2-0.6-1.2-1.2l0,0c0-0.7,0.6-1.2,1.2-1.2h22.5c0.7,0,1.2,0.6,1.2,1.2l0,0C62.5,35.7,61.9,36.2,61.2,36.2z M57.9,43L57.9,43c0-0.7-0.6-1.3-1.2-1.3H40.8c-0.7,0-1.2,0.6-1.2,1.2v0c0,0.7,0.6,1.2,1.2,1.2h15.9C57.4,44.3,57.9,43.7,57.9,43z M60.5,27L60.5,27c0-0.7-0.6-1.2-1.2-1.2H44.9c-0.7,0-1.2,0.6-1.2,1.2v0c0,0.7,0.6,1.2,1.2,1.2h14.3C59.9,28.2,60.5,27.7,60.5,27z"></path></svg>',
	] )
	->defaultValue( 'variant-1' )
	->transport( 'postMessage' )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'text' )
	->type( 'text' )
	->tab( 'general' )
	->label( __( 'Text', 'page-builder-framework' ) )
	->defaultValue( 'Menu' )
	->transport( 'postMessage' )
	->addToSection( $section_id );
