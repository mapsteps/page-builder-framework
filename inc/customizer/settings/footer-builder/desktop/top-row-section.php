<?php
/**
 * Footer builder's desktop top row section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$row_key = 'desktop_row_1';

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
		return get_template_part( 'inc/template-parts/footer' );
	},
);

/* General Tab */

wpbf_customizer_field()
	->id( $control_id_prefix . 'max_width' )
	->type( 'dimension' )
	->tab( 'general' )
	->label( __( 'Container Width', 'page-builder-framework' ) )
	->description( __( 'Default: 1200px', 'page-builder-framework' ) )
	->priority( 10 )
	->transport( 'postMessage' )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'vertical_padding' )
	->type( 'slider' )
	->tab( 'general' )
	->label( __( 'Vertical Padding', 'page-builder-framework' ) )
	->defaultValue( 15 )
	->priority( 15 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 80,
		'step' => 1,
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
