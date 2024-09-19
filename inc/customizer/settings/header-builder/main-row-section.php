<?php
/**
 * Header builder's main row section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$row_key = 'row_2';

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

$partial_refresh_key_prefix = 'headerbuilder_' . $row_key . '_';

$partial_refresh_args = array(
	'container_inclusive' => true,
	'selector'            => '#header',
	'render_callback'     => function () {
		return get_template_part( 'inc/template-parts/header-builder' );
	},
);

/* General Tab */

wpbf_customizer_field()
	->id( $control_id_prefix . 'visibility' )
	->type( 'checkbox-buttonset' )
	->tab( 'general' )
	->label( __( 'Visibility', 'page-builder-framework' ) )
	->description( __( 'In which devices this row should be displayed.', 'page-builder-framework' ) )
	->defaultValue( [ 'large', 'medium', 'small' ] )
	->choices( [
		'large'  => __( 'Desktop', 'page-builder-framework' ),
		'medium' => __( 'Tablet', 'page-builder-framework' ),
		'small'  => __( 'Mobile', 'page-builder-framework' ),
	] )
	->transport( 'auto' )
	->partialRefresh( [
		$partial_refresh_key_prefix . 'visibility' => $partial_refresh_args,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'visibility_separator' )
	->type( 'divider' )
	->tab( 'general' )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'use_container' )
	->type( 'toggle' )
	->tab( 'general' )
	->label( __( 'Use Container', 'page-builder-framework' ) )
	->description( __( "Whether to make this row's layout contained (boxed).", 'page-builder-framework' ) )
	->defaultValue( true )
	->transport( 'auto' )
	->partialRefresh( [
		$partial_refresh_key_prefix . 'use_container' => $partial_refresh_args,
	] )
	->addToSection( $section_id );

/* Design Tab */

wpbf_customizer_field()
	->id( $control_id_prefix . 'min_height' )
	->type( 'responsive-input-slider' )
	->tab( 'design' )
	->label( __( 'Min Height', 'page-builder-framework' ) )
	->defaultValue( [
		'desktop' => '50px',
	] )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 600,
		'step' => 1,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'vertical_padding' )
	->type( 'responsive-input-slider' )
	->tab( 'design' )
	->label( __( 'Vertical Padding', 'page-builder-framework' ) )
	->defaultValue( [
		'desktop' => '15px',
	] )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 200,
		'step' => 1,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'color_separator' )
	->type( 'divider' )
	->tab( 'design' )
	->addToSection( $section_id );

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

wpbf_customizer_field()
	->id( $control_id_prefix . 'text_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Text Color', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( $section_id );
