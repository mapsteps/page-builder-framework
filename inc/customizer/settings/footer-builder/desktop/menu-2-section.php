<?php
/**
 * Footer builder's desktop menu 2 section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$widget_key = 'desktop_menu_2';

$section_id = 'wpbf_footer_builder_' . $widget_key . '_section';

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
	->addToPanel( 'footer_panel' );

$control_id_prefix = 'wpbf_footer_builder_' . $widget_key . '_';

$partial_refresh_key_prefix = 'footerbuilder_' . $widget_key . '_';

$partial_refresh_args = array(
	'container_inclusive' => true,
	'selector'            => '#footer',
	'render_callback'     => function () {
		return get_template_part( 'inc/template-parts/footer-builder' );
	},
);

/* General Tab */

$menu_term_list = wp_get_nav_menus();

$menu_choices = [ '' => __( '— Select a Menu —', 'page-builder-framework' ) ];

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
		$partial_refresh_key_prefix . 'menu_id' => $partial_refresh_args,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'item_spacing' )
	->type( 'slider' )
	->tab( 'general' )
	->label( __( 'Item Spacing', 'page-builder-framework' ) )
	->description( __( 'Vertical spacing between menu items.', 'page-builder-framework' ) )
	->defaultValue( 5 )
	->priority( 15 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 30,
		'step' => 1,
	] )
	->addToSection( $section_id );

/* Design Tab */

wpbf_customizer_field()
	->id( $control_id_prefix . 'link_colors' )
	->type( 'multicolor' )
	->tab( 'design' )
	->label( __( 'Link Color', 'page-builder-framework' ) )
	->priority( 200 )
	->transport( 'postMessage' )
	->choices( array(
		'default' => __( 'Default', 'page-builder-framework' ),
		'hover'   => __( 'Hover', 'page-builder-framework' ),
	) )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( $section_id );
