<?php
/**
 * Header builder's bottom row section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$section_id = 'wpbf_header_builder_row_3_section';

wpbf_customizer_section()
	->id( $section_id )
	->type( 'invisible' )
	->title( __( 'Bottom Row', 'page-builder-framework' ) )
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

$control_id_prefix = 'wpbf_header_builder_row_3_';

$partial_refresh_key_prefix = 'headerbuilder_row_3_';

$partial_refresh_args = array(
	'container_inclusive' => true,
	'selector'            => '#header',
	'render_callback'     => function () {
		return get_template_part( 'inc/template-parts/header' );
	},
);

/* General Tab */

wpbf_customizer_field()
	->id( $control_id_prefix . 'min_height' )
	->type( 'responsive-input-slider' )
	->tab( 'general' )
	->label( __( 'Min Height', 'page-builder-framework' ) )
	->defaultValue( [
		'desktop' => '50px',
	] )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 300,
		'step' => 1,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'visibility' )
	->type( 'checkbox-buttonset' )
	->tab( 'general' )
	->label( __( 'Visible on:', 'page-builder-framework' ) )
	->defaultValue( [ 'desktop', 'tablet', 'mobile' ] )
	->choices( [
		'desktop' => __( 'Desktop', 'page-builder-framework' ),
		'tablet'  => __( 'Tablet', 'page-builder-framework' ),
		'mobile'  => __( 'Mobile', 'page-builder-framework' ),
	] )
	->properties( [
		'multiple' => true,
	] )
	->partialRefresh( [
		$partial_refresh_key_prefix . 'min_height' => $partial_refresh_args,
	] )
	->addToSection( $section_id );

/* Design Tab */

wpbf_customizer_field()
	->id( $control_id_prefix . 'bg_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( $section_id );
