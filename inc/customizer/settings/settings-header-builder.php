<?php
/**
 * Header builder customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

use Mapsteps\Wpbf\Customizer\Controls\Builder\ResponsiveBuilderStore;

defined( 'ABSPATH' ) || die( "Can't access directly" );

wpbf_customizer_section()
	->id( 'wpbf_header_builder_main_section' )
	->type( 'expanded' )
	->title( __( 'Header Builder', 'page-builder-framework' ) )
	->priority( 0 )
	->addToPanel( 'header_panel' );

wpbf_customizer_field()
	->id( 'wpbf_enable_header_builder' )
	->type( 'headline-toggle' )
	->label( __( 'Header Builder', 'page-builder-framework' ) )
	->defaultValue( false )
	->transport( 'auto' )
	->properties([
		'wrapper_attrs' => [
			'class'                  => 'wpbf-builder-toggle',
			'data-connected-builder' => 'wpbf_header_builder',
		],
	])
	->partialRefresh( [
		'headerbuilder_toggle_header' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
		'headerbuilder_toggle_style' => array(
			'container_inclusive' => false,
			'selector'            => '#wpbf-customize-saved-styles',
			'render_callback'     => function () {
				return wpbf_generate_css();
			},
		),
	] )
	->addToSection( 'wpbf_header_builder_main_section' );

wpbf_customizer_field()
	->id( 'wpbf_header_builder' )
	->type( 'responsive-builder' )
	->description( __( 'Drag and drop widgets to build your site header.', 'page-builder-framework' ) )
	->transport( 'auto' )
	->properties( array(
		'available_widgets' => ResponsiveBuilderStore::headerBuilderAvailableWidgets(),
		'available_slots'   => ResponsiveBuilderStore::headerBuilderAvailableSlots(),
	) )
	->partialRefresh( [
		'headerbuilder' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
		'headerbuilder_style' => array(
			'container_inclusive' => false,
			'selector'            => '#wpbf-customize-saved-styles',
			'render_callback'     => function () {
				return wpbf_generate_css();
			},
		),
	] )
	->addToSection( 'wpbf_header_builder_main_section' );

// Desktop row sections.
require_once WPBF_THEME_DIR . '/inc/customizer/settings/header-builder/desktop/top-row-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/header-builder/desktop/main-row-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/header-builder/desktop/bottom-row-section.php';

// Desktop widget sections.
require_once WPBF_THEME_DIR . '/inc/customizer/settings/header-builder/desktop/search-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/header-builder/desktop/button-1-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/header-builder/desktop/button-2-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/header-builder/desktop/html-1-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/header-builder/desktop/html-2-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/header-builder/desktop/menu-1-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/header-builder/desktop/menu-2-section.php';

// Mobile widget sections.
require_once WPBF_THEME_DIR . '/inc/customizer/settings/header-builder/mobile/menu-trigger-section.php';
