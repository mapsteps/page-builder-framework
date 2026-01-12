<?php
/**
 * Footer builder's desktop logo section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$section_id = 'wpbf_footer_builder_desktop_logo_section';

wpbf_customizer_section()
	->id( $section_id )
	->type( 'invisible' )
	->title( __( 'Logo', 'page-builder-framework' ) )
	->priority( 3 )
	->addToPanel( 'footer_panel' );

$control_id_prefix = 'wpbf_footer_builder_desktop_logo_';

$partial_refresh_key_prefix = 'footerbuilder_desktop_logo_';

$partial_refresh_args = array(
	'container_inclusive' => true,
	'selector'            => '#footer',
	'render_callback'     => function () {
		return get_template_part( 'inc/template-parts/footer' );
	},
);

wpbf_customizer_field()
	->id( $control_id_prefix . 'image' )
	->type( 'image' )
	->label( __( 'Logo Image', 'page-builder-framework' ) )
	->description( __( 'Leave empty to use the site logo from Site Identity.', 'page-builder-framework' ) )
	->partialRefresh( [
		$partial_refresh_key_prefix . 'image' => $partial_refresh_args,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'width' )
	->type( 'slider' )
	->label( __( 'Logo Width', 'page-builder-framework' ) )
	->priority( 10 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 500,
		'step' => 1,
	] )
	->addToSection( $section_id );
