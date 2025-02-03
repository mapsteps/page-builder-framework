<?php
/**
 * Header builder's mobile main row section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$row_key = 'mobile_row_2';

$section_id = 'wpbf_header_builder_' . $row_key . '_section';

wpbf_customizer_section()
	->id( $section_id )
	->type( 'invisible' )
	->title( __( 'Main Row', 'page-builder-framework' ) )
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

$control_id_prefix = 'wpbf_header_builder_' . $row_key . '_';

wpbf_customizer_field()
	->id( $control_id_prefix . 'vertical_padding' )
	->type( 'slider' )
	->tab( 'general' )
	->label( __( 'Vertical Padding', 'page-builder-framework' ) )
	->defaultValue( 15 )
	->priority( 10 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 80,
		'step' => 1,
	] )
	->addToSection( $section_id );
