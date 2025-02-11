<?php
/**
 * Header builder's search section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$section_id = 'wpbf_header_builder_mobile_search_section';

wpbf_customizer_section()
	->id( $section_id )
	->type( 'invisible' )
	->title( __( 'Search', 'page-builder-framework' ) )
	->priority( 3 )
	->addToPanel( 'header_panel' );

$control_id_prefix = 'wpbf_header_builder_mobile_search_';

$partial_refresh_key_prefix = 'headerbuilder_mobile_search_';

$partial_refresh_args = array(
	'container_inclusive' => true,
	'selector'            => '#header',
	'render_callback'     => function () {
		return get_template_part( 'inc/template-parts/header' );
	},
);

wpbf_customizer_field()
	->id( $control_id_prefix . 'icon_size' )
	->type( 'responsive-input-slider' )
	->label( __( 'Icon Size', 'page-builder-framework' ) )
	->defaultValue( 16 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	] )
	->partialRefresh( [
		$partial_refresh_key_prefix . 'icon_size' => $partial_refresh_args,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'icon_color' )
	->type( 'multicolor' )
	->label( __( 'Icon Color', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->choices( array(
		'default' => __( 'Default', 'page-builder-framework' ),
		'hover'   => __( 'Hover', 'page-builder-framework' ),
	) )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( $section_id );
