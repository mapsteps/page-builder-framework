<?php
/**
 * Header builder's search section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

wpbf_customizer_section()
	->id( 'wpbf_header_builder_search_section' )
	->type( 'invisible' )
	->title( __( 'Search', 'page-builder-framework' ) )
	->priority( 3 )
	->addToPanel( 'header_panel' );

wpbf_customizer_field()
	->id( 'wpbf_header_builder_search_icon' )
	->setting( 'menu_search_icon' )
	->type( 'toggle' )
	->tab( 'general' )
	->label( __( 'Search Icon', 'page-builder-framework' ) )
	->partialRefresh( [
		'menusearchicon' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'wpbf_header_builder_search_section' );
