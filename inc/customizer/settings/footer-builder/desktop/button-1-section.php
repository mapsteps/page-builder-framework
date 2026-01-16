<?php
/**
 * Footer builder's button 1 section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$section_id = 'wpbf_footer_builder_desktop_button_1_section';

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
	->addToPanel( 'footer_panel' );

$control_id_prefix = 'wpbf_footer_builder_desktop_button_1_';

/* General Tab */

wpbf_customizer_field()
	->id( $control_id_prefix . 'new_tab' )
	->type( 'toggle' )
	->tab( 'general' )
	->label( __( 'Open in New Tab', 'page-builder-framework' ) )
	->defaultValue( false )
	->transport( 'postMessage' )
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
	->transport( 'postMessage' )
	->addToSection( $section_id );

// We use 'text' instead of 'url' because we support template tags such as '{site_url}'.
wpbf_customizer_field()
	->id( $control_id_prefix . 'url' )
	->type( 'text' )
	->tab( 'general' )
	->label( __( 'Link URL', 'page-builder-framework' ) )
	->description( sprintf(
		// translators: Template tag.
		__( 'You can use template tags such as %s.', 'page-builder-framework' ),
		'<code>{site_url}</code>'
	) )
	->defaultValue( '{site_url}' )
	->transport( 'postMessage' )
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
	->transport( 'postMessage' )
	->addToSection( $section_id );

/* Design Tab */

wpbf_customizer_field()
	->id( $control_id_prefix . 'size' )
	->type( 'select' )
	->tab( 'design' )
	->label( __( 'Button Size', 'page-builder-framework' ) )
	->defaultValue( '' )
	->choices( array(
		''      => __( 'Default', 'page-builder-framework' ),
		'small' => __( 'Small', 'page-builder-framework' ),
		'large' => __( 'Large', 'page-builder-framework' ),
	) )
	->transport( 'postMessage' )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'border_radius' )
	->type( 'responsive-input-slider' )
	->tab( 'design' )
	->label( __( 'Border Radius', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'border_width' )
	->type( 'responsive-input-slider' )
	->tab( 'design' )
	->label( __( 'Border Width', 'page-builder-framework' ) )
	->defaultValue( 0 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 20,
		'step' => 1,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'border_style' )
	->type( 'select' )
	->tab( 'design' )
	->label( __( 'Border Style', 'page-builder-framework' ) )
	->choices( array(
		'none'   => __( 'None', 'page-builder-framework' ),
		'solid'  => __( 'Solid', 'page-builder-framework' ),
		'dashed' => __( 'Dashed', 'page-builder-framework' ),
		'dotted' => __( 'Dotted', 'page-builder-framework' ),
	) )
	->defaultValue( 'none' )
	->transport( 'postMessage' )
	->properties( [
		'layout_style' => 'horizontal',
		'searchable'   => false,
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
	->type( 'multicolor' )
	->tab( 'design' )
	->label( __( 'Border Color', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->choices( array(
		'default' => __( 'Default', 'page-builder-framework' ),
		'hover'   => __( 'Hover', 'page-builder-framework' ),
	) )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'bg_color' )
	->type( 'multicolor' )
	->tab( 'design' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->choices( array(
		'default' => __( 'Default', 'page-builder-framework' ),
		'hover'   => __( 'Hover', 'page-builder-framework' ),
	) )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'text_color' )
	->type( 'multicolor' )
	->tab( 'design' )
	->label( __( 'Text Color', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->choices( array(
		'default' => __( 'Default', 'page-builder-framework' ),
		'hover'   => __( 'Hover', 'page-builder-framework' ),
	) )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'margin_headline' )
	->type( 'headline' )
	->tab( 'design' )
	->label( __( 'Spacing', 'page-builder-framework' ) )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'margin' )
	->type( 'margin-padding' )
	->tab( 'design' )
	->label( __( 'Margin', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->properties( [
		'subtype'        => 'margin',
		'dont_save_unit' => true,
	] )
	->addToSection( $section_id );
