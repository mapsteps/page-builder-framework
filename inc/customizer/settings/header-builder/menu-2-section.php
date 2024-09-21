<?php
/**
 * Header builder's menu 1 section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$row_key = 'menu_2';

$section_id = 'wpbf_header_builder_' . $row_key . '_section';

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

$control_id_prefix = 'wpbf_header_builder_' . $row_key . '_';

$partial_refresh_key_prefix = 'headerbuilder_' . $row_key . '_';

$partial_refresh_args = array(
	'container_inclusive' => true,
	'selector'            => '#header',
	'render_callback'     => function () {
		return get_template_part( 'inc/template-parts/header-builder' );
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
	->type( 'select' )
	->tab( 'general' )
	->label( __( 'Select Menu', 'page-builder-framework' ) )
	->choices( $menu_choices )
	->transport( 'postMessage' )
	->partialRefresh( [
		$partial_refresh_key_prefix . 'visibility' => $partial_refresh_args,
	] )
	->addToSection( $section_id );
