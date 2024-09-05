<?php
/**
 * Header builder's button 1 section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$section_id = 'wpbf_header_builder_button_1_section';

wpbf_customizer_section()
	->id( $section_id )
	->type( 'invisible' )
	->title( __( 'Button 1', 'page-builder-framework' ) )
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

$control_id_prefix = 'wpbf_header_builder_button_1_';

$partial_refresh_key_prefix = 'headerbuilder_button_1_';

$partial_refresh_args = array(
	'container_inclusive' => true,
	'selector'            => '#header',
	'render_callback'     => function () {
		return get_template_part( 'inc/template-parts/header' );
	},
);

/* General Tab */

wpbf_customizer_field()
	->id( $control_id_prefix . 'new_tab' )
	->type( 'toggle' )
	->tab( 'general' )
	->label( __( 'Open in New Tab', 'page-builder-framework' ) )
	->defaultValue( false )
	->partialRefresh( [
		$partial_refresh_key_prefix . 'new_tab' => $partial_refresh_args,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'link_separator' )
	->type( 'divider' )
	->tab( 'general' )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'text' )
	->type( 'text' )
	->tab( 'general' )
	->label( __( 'Link Text', 'page-builder-framework' ) )
	->defaultValue( 'Button 1' )
	->partialRefresh( [
		$partial_refresh_key_prefix . 'text' => $partial_refresh_args,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'url' )
	->type( 'url' )
	->tab( 'general' )
	->label( __( 'Link URL', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->partialRefresh( [
		$partial_refresh_key_prefix . 'url' => $partial_refresh_args,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'rel' )
	->type( 'select' )
	->tab( 'general' )
	->label( __( 'Link Rel', 'page-builder-framework' ) )
	->choices( array(
		'nofollow'   => __( 'nofollow', 'page-builder-framework' ),
		'noreferrer' => __( 'noreferrer', 'page-builder-framework' ),
		'noopener'   => __( 'noopener', 'page-builder-framework' ),
	) )
	->properties( array(
		'multiple' => true,
	) )
	->partialRefresh( [
		$partial_refresh_key_prefix . 'rel' => $partial_refresh_args,
	] )
	->addToSection( $section_id );

/* Design Tab */

wpbf_customizer_field()
	->id( $control_id_prefix . 'size' )
	->type( 'select' )
	->tab( 'design' )
	->label( __( 'Button Size', 'page-builder-framework' ) )
	->defaultValue( 'default' )
	->choices( array(
		'default' => __( 'Default', 'page-builder-framework' ),
		'small'   => __( 'Small', 'page-builder-framework' ),
		'medium'  => __( 'Medium', 'page-builder-framework' ),
		'large'   => __( 'Large', 'page-builder-framework' ),
	) )
	->partialRefresh( [
		$partial_refresh_key_prefix . 'size' => $partial_refresh_args,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'border_radius' )
	->type( 'responsive-input-slider' )
	->tab( 'design' )
	->label( __( 'Border Radius', 'page-builder-framework' ) )
	->defaultValue( 4 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'border_width' )
	->type( 'responsive-input-slider' )
	->tab( 'design' )
	->label( __( 'Border Width', 'page-builder-framework' ) )
	->defaultValue( 1 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 20,
		'step' => 1,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'colors_headline' )
	->type( 'headline' )
	->tab( 'design' )
	->label( __( 'Colors', 'page-builder-framework' ) )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'border_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Border Color', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
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

wpbf_customizer_field()
	->id( $control_id_prefix . 'accent_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Accent Color', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( $section_id );
