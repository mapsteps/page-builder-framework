<?php
/**
 * Header builder's html_1 section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$section_id = 'wpbf_header_builder_html_2_section';

wpbf_customizer_section()
	->id( $section_id )
	->type( 'invisible' )
	->title( __( 'HTML 2', 'page-builder-framework' ) )
	->priority( 3 )
	->addToPanel( 'header_panel' );

$control_id_prefix = 'wpbf_header_builder_html_2_';

$partial_refresh_key_prefix = 'headerbuilder_html_2_';

$partial_refresh_args = array(
	'container_inclusive' => true,
	'selector'            => '#header',
	'render_callback'     => function () {
		return get_template_part( 'inc/template-parts/header' );
	},
);

wpbf_customizer_field()
	->id( $control_id_prefix . 'content' )
	->type( 'editor' )
	->partialRefresh( [
		$partial_refresh_key_prefix . 'icon_size' => $partial_refresh_args,
	] )
	->addToSection( $section_id );
