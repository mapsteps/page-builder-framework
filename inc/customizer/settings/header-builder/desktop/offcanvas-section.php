<?php
/**
 * Header builder's desktop offcanvas section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$row_key = 'desktop_offcanvas';

$section_id = 'wpbf_header_builder_' . $row_key . '_section';

wpbf_customizer_section()
	->id( $section_id )
	->type( 'invisible' )
	->title( __( 'Desktop Off-Canvas', 'page-builder-framework' ) )
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
		return get_template_part( 'inc/template-parts/header' );
	},
);

wpbf_customizer_field()
	->id( $control_id_prefix . 'reveal_as' )
	->type( 'select' )
	->tab( 'general' )
	->label( __( 'Reveal as', 'page-builder-framework' ) )
	->defaultValue( 'off-canvas' )
	->priority( 5 )
	->choices( [
		'off-canvas'      => __( 'Off-canvas (Right)', 'page-builder-framework' ),
		'off-canvas-left' => __( 'Off-canvas (Left)', 'page-builder-framework' ),
		'full-screen'     => __( 'Full screen', 'page-builder-framework' ),
	] )
	->defaultValue( 'off-canvas' )
	->transport( 'auto' )
	->partialRefresh( [
		'headerbuilder_reveal_as' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( $section_id );
