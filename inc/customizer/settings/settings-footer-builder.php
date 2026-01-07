<?php
/**
 * Footer builder customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

use Mapsteps\Wpbf\Customizer\FooterBuilder\FooterBuilderConfig;

defined( 'ABSPATH' ) || die( "Can't access directly" );

wpbf_customizer_section()
	->id( 'wpbf_footer_builder_main_section' )
	->type( 'expanded' )
	->title( __( 'Footer Builder', 'page-builder-framework' ) )
	->priority( 0 )
	->addToPanel( 'footer_panel' );

wpbf_customizer_field()
	->id( 'wpbf_enable_footer_builder' )
	->type( 'headline-toggle' )
	->label( __( 'Footer Builder', 'page-builder-framework' ) )
	->defaultValue( false )
	->transport( 'auto' )
	->properties([
		'wrapper_attrs' => [
			'class'                  => 'wpbf-builder-toggle',
			'data-connected-builder' => 'wpbf_footer_builder',
		],
	])
	->partialRefresh( [
		'footerbuilder_toggle_footer' => array(
			'container_inclusive' => true,
			'selector'            => '#footer',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/footer' );
			},
		),
		'footerbuilder_toggle_style' => array(
			'container_inclusive' => false,
			'selector'            => '#wpbf-customize-saved-styles',
			'render_callback'     => function () {
				return wpbf_generate_css();
			},
		),
	] )
	->addToSection( 'wpbf_footer_builder_main_section' );

wpbf_customizer_field()
	->id( 'wpbf_footer_builder' )
	->type( 'responsive-builder' )
	->description( __( 'Drag and drop widgets to build your site footer.', 'page-builder-framework' ) )
	->transport( 'auto' )
	->properties( array(
		'available_widgets' => FooterBuilderConfig::availableWidgets(),
		'available_slots'   => FooterBuilderConfig::availableSlots(),
	) )
	->partialRefresh( [
		'footerbuilder' => array(
			'container_inclusive' => true,
			'selector'            => '#footer',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/footer' );
			},
		),
		'footerbuilder_style' => array(
			'container_inclusive' => false,
			'selector'            => '#wpbf-customize-saved-styles',
			'render_callback'     => function () {
				return wpbf_generate_css();
			},
		),
	] )
	->addToSection( 'wpbf_footer_builder_main_section' );

// Desktop row sections.
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/desktop/top-row-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/desktop/main-row-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/desktop/bottom-row-section.php';

// Desktop widget sections.
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/desktop/logo-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/desktop/menu-1-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/desktop/menu-2-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/desktop/html-1-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/desktop/html-2-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/desktop/social-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/desktop/copyright-section.php';

// Mobile row sections.
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/mobile/top-row-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/mobile/main-row-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/mobile/bottom-row-section.php';

// Mobile widget sections.
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/mobile/logo-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/mobile/menu-1-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/mobile/menu-2-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/mobile/html-1-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/mobile/html-2-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/mobile/social-section.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/footer-builder/mobile/copyright-section.php';
