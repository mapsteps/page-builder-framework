<?php
/**
 * Footer builder's mobile top row section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$row_key = 'mobile_row_1';

$section_id = 'wpbf_footer_builder_' . $row_key . '_section';

wpbf_customizer_section()
	->id( $section_id )
	->type( 'invisible' )
	->title( __( 'Top Row', 'page-builder-framework' ) )
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

$control_id_prefix = 'wpbf_footer_builder_' . $row_key . '_';

$partial_refresh_key_prefix = 'footerbuilder_' . $row_key . '_';

$partial_refresh_args = array(
	'container_inclusive' => true,
	'selector'            => '#footer',
	'render_callback'     => function () {
		return get_template_part( 'inc/template-parts/footer-builder' );
	},
);

/* General Tab */

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

wpbf_customizer_field()
	->id( $control_id_prefix . 'column_gap' )
	->type( 'slider' )
	->tab( 'general' )
	->label( __( 'Column Gap', 'page-builder-framework' ) )
	->defaultValue( 20 )
	->priority( 12 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 80,
		'step' => 1,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'columns_alignment_headline' )
	->type( 'headline' )
	->tab( 'general' )
	->label( __( 'Column Alignment', 'page-builder-framework' ) )
	->priority( 14 )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'column_1_start_align' )
	->type( 'select' )
	->tab( 'general' )
	->label( __( 'Column 1 Start (Left)', 'page-builder-framework' ) )
	->defaultValue( 'default' )
	->priority( 16 )
	->transport( 'postMessage' )
	->choices( [
		'default'       => __( 'Default', 'page-builder-framework' ),
		'start'         => __( 'Left', 'page-builder-framework' ),
		'center'        => __( 'Center', 'page-builder-framework' ),
		'end'           => __( 'Right', 'page-builder-framework' ),
		'space-between' => __( 'Space Between', 'page-builder-framework' ),
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'column_1_end_align' )
	->type( 'select' )
	->tab( 'general' )
	->label( __( 'Column 1 End (Left)', 'page-builder-framework' ) )
	->defaultValue( 'default' )
	->priority( 18 )
	->transport( 'postMessage' )
	->choices( [
		'default'       => __( 'Default', 'page-builder-framework' ),
		'start'         => __( 'Left', 'page-builder-framework' ),
		'center'        => __( 'Center', 'page-builder-framework' ),
		'end'           => __( 'Right', 'page-builder-framework' ),
		'space-between' => __( 'Space Between', 'page-builder-framework' ),
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'column_2_align' )
	->type( 'select' )
	->tab( 'general' )
	->label( __( 'Column 2 (Center)', 'page-builder-framework' ) )
	->defaultValue( 'default' )
	->priority( 20 )
	->transport( 'postMessage' )
	->choices( [
		'default'       => __( 'Default', 'page-builder-framework' ),
		'start'         => __( 'Left', 'page-builder-framework' ),
		'center'        => __( 'Center', 'page-builder-framework' ),
		'end'           => __( 'Right', 'page-builder-framework' ),
		'space-between' => __( 'Space Between', 'page-builder-framework' ),
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'column_3_start_align' )
	->type( 'select' )
	->tab( 'general' )
	->label( __( 'Column 3 Start (Right)', 'page-builder-framework' ) )
	->defaultValue( 'default' )
	->priority( 22 )
	->transport( 'postMessage' )
	->choices( [
		'default'       => __( 'Default', 'page-builder-framework' ),
		'start'         => __( 'Left', 'page-builder-framework' ),
		'center'        => __( 'Center', 'page-builder-framework' ),
		'end'           => __( 'Right', 'page-builder-framework' ),
		'space-between' => __( 'Space Between', 'page-builder-framework' ),
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'column_3_end_align' )
	->type( 'select' )
	->tab( 'general' )
	->label( __( 'Column 3 End (Right)', 'page-builder-framework' ) )
	->defaultValue( 'default' )
	->priority( 24 )
	->transport( 'postMessage' )
	->choices( [
		'default'       => __( 'Default', 'page-builder-framework' ),
		'start'         => __( 'Left', 'page-builder-framework' ),
		'center'        => __( 'Center', 'page-builder-framework' ),
		'end'           => __( 'Right', 'page-builder-framework' ),
		'space-between' => __( 'Space Between', 'page-builder-framework' ),
	] )
	->addToSection( $section_id );

/* Design Tab */

wpbf_customizer_field()
	->id( $control_id_prefix . 'bg_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->priority( 200 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'text_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->priority( 205 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'accent_colors' )
	->type( 'multicolor' )
	->tab( 'design' )
	->label( __( 'Accent Color', 'page-builder-framework' ) )
	->priority( 210 )
	->transport( 'postMessage' )
	->choices( array(
		'default' => __( 'Default', 'page-builder-framework' ),
		'hover'   => __( 'Hover', 'page-builder-framework' ),
	) )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'font_size' )
	->type( 'input-slider' )
	->tab( 'design' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->defaultValue( '16px' )
	->priority( 215 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 1,
		'max'  => 100,
		'step' => 1,
	] )
	->addToSection( $section_id );

/* Top Separator */

wpbf_customizer_field()
	->id( $control_id_prefix . 'top_separator_headline' )
	->type( 'headline' )
	->tab( 'design' )
	->label( __( 'Top Separator', 'page-builder-framework' ) )
	->priority( 218 )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'border_top_style' )
	->type( 'select' )
	->tab( 'design' )
	->label( __( 'Separator Style', 'page-builder-framework' ) )
	->defaultValue( 'none' )
	->priority( 220 )
	->transport( 'postMessage' )
	->choices( [
		'none'   => __( 'None', 'page-builder-framework' ),
		'solid'  => __( 'Solid', 'page-builder-framework' ),
		'dashed' => __( 'Dashed', 'page-builder-framework' ),
		'dotted' => __( 'Dotted', 'page-builder-framework' ),
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'border_top_width' )
	->type( 'input-slider' )
	->tab( 'design' )
	->label( __( 'Separator Width', 'page-builder-framework' ) )
	->priority( 225 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 20,
		'step' => 1,
	] )
	->activeCallback( [
		array(
			'setting'  => $control_id_prefix . 'border_top_style',
			'operator' => '!==',
			'value'    => 'none',
		),
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'border_top_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Separator Color', 'page-builder-framework' ) )
	->priority( 230 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		array(
			'setting'  => $control_id_prefix . 'border_top_style',
			'operator' => '!==',
			'value'    => 'none',
		),
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'border_top_scope' )
	->type( 'select' )
	->tab( 'design' )
	->label( __( 'Separator Scope', 'page-builder-framework' ) )
	->defaultValue( 'container' )
	->priority( 235 )
	->transport( 'postMessage' )
	->choices( [
		'container' => __( 'Container', 'page-builder-framework' ),
		'fullwidth' => __( 'Fullwidth', 'page-builder-framework' ),
	] )
	->activeCallback( [
		array(
			'setting'  => $control_id_prefix . 'border_top_style',
			'operator' => '!==',
			'value'    => 'none',
		),
	] )
	->addToSection( $section_id );
