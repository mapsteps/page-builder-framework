<?php
/**
 * Header builder customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

use Mapsteps\Wpbf\Customizer\Controls\Builder\BuilderStore;

defined( 'ABSPATH' ) || die( "Can't access directly" );

wpbf_customizer_section()
	->id( 'wpbf_header_builder_main_section' )
	->type( 'expanded' )
	->title( __( 'Header Builder', 'page-builder-framework' ) )
	->priority( 0 )
	->addToPanel( 'header_panel' );

wpbf_customizer_field()
	->id( 'wpbf_header_builder_enabled' )
	->type( 'headline-toggle' )
	->label( __( 'Header Builder', 'page-builder-framework' ) )
	->defaultValue( true )
	->properties([
		'wrapper_attrs' => [
			'class'                  => 'wpbf-builder-toggle',
			'data-connected-builder' => 'wpbf_header_builder',
		],
	])
	->partialRefresh( [
		'headerbuildertoggle' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'wpbf_header_builder_main_section' );

wpbf_customizer_field()
	->id( 'wpbf_header_builder' )
	->type( 'builder' )
	->description( __( 'Drag and drop widgets to build your site header.', 'page-builder-framework' ) )
	->properties( array(
		'available_widgets' => BuilderStore::headerBuilderAvailableWidgets(),
		'available_rows'    => BuilderStore::headerBuilderAvailableRows(),
	) )
	->partialRefresh( [
		'headerbuilder' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'wpbf_header_builder_main_section' );

require_once WPBF_THEME_DIR . '/inc/customizer/settings/header-builder/search-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/header-builder/button-1-section.php';
