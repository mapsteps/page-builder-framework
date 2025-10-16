<?php
/**
 * Header builder's menu 2 section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$widget_key = 'desktop_menu_2';

$section_id = 'wpbf_header_builder_' . $widget_key . '_section';

wpbf_customizer_section()
	->id( $section_id )
	->type( 'invisible' )
	->title( __( 'Menu 2', 'page-builder-framework' ) )
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

$control_id_prefix = 'wpbf_header_builder_' . $widget_key . '_';

$partial_refresh_key_prefix = 'headerbuilder_' . $widget_key . '_';

$partial_refresh_args = array(
	'container_inclusive' => true,
	'selector'            => '#header',
	'render_callback'     => function () {
		return get_template_part( 'inc/template-parts/header' );
	},
);

/* General Tab */

$menu_term_list = wp_get_nav_menus();

$menu_choices = [];

if ( ! empty( $menu_term_list ) ) {
	foreach ( $menu_term_list as $menu_term ) {
		$menu_choices[ $menu_term->term_id ] = $menu_term->name;
	}
}

wpbf_customizer_field()
	->id( $control_id_prefix . 'menu_id' )
	->type( 'enhanced-select' )
	->tab( 'general' )
	->label( __( 'Select Menu', 'page-builder-framework' ) )
	->choices( $menu_choices )
	->transport( 'postMessage' )
	->partialRefresh( [
		$partial_refresh_key_prefix . 'visibility' => $partial_refresh_args,
	] )
	->addToSection( $section_id );

/* Design Tab */

// Padding.
wpbf_customizer_field()
	->id( $control_id_prefix . 'menu_padding' )
	->type( 'slider' )
	->tab( 'design' )
	->label( __( 'Menu Item Spacing', 'page-builder-framework' ) )
	->defaultValue( 20 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 5,
		'max'  => 40,
		'step' => 1,
	] )
	->addToSection( $section_id );
