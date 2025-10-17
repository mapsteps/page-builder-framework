<?php
/**
 * Header builder's mobile offcanvas section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$row_key = 'mobile_offcanvas';

$section_id = 'wpbf_header_builder_' . $row_key . '_section';

wpbf_customizer_section()
	->id( $section_id )
	->type( 'invisible' )
	->title( __( 'Mobile Menu', 'page-builder-framework' ) )
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
	->type( 'radio-buttonset' )
	->tab( 'general' )
	->label( __( 'Reveal as', 'page-builder-framework' ) )
	->priority( 5 )
	->choices( [
		'dropdown'   => __( 'Dropdown', 'page-builder-framework' ),
		'off-canvas' => __( 'Off-canvas', 'page-builder-framework' ),
	] )
	->defaultValue( 'dropdown' )
	->transport( 'postMessage' )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'menu_item_settings_headline_design' )
	->type( 'headline' )
	->tab( 'design' )
	->label( __( 'Menu Item Settings', 'page-builder-framework' ) )
	->priority( 6 )
	->activeCallback( function() use ( $control_id_prefix ) {
		$reveal_as = get_theme_mod( $control_id_prefix . 'reveal_as', 'dropdown' );
		return in_array( $reveal_as, ['dropdown', 'off-canvas'] );
	} )
	->addToSection( $section_id );
