<?php
/**
 * Footer builder's desktop social icons section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$section_id = 'wpbf_footer_builder_desktop_social_section';

wpbf_customizer_section()
	->id( $section_id )
	->type( 'invisible' )
	->title( __( 'Social Icons', 'page-builder-framework' ) )
	->priority( 3 )
	->addToPanel( 'footer_panel' );

$control_id_prefix = 'wpbf_footer_builder_desktop_social_';

$partial_refresh_key_prefix = 'footerbuilder_desktop_social_';

$partial_refresh_args = array(
	'container_inclusive' => true,
	'selector'            => '#footer',
	'render_callback'     => function () {
		return get_template_part( 'inc/template-parts/footer-builder' );
	},
);

wpbf_customizer_field()
	->id( $control_id_prefix . 'facebook' )
	->type( 'url' )
	->label( __( 'Facebook URL', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->partialRefresh( [
		$partial_refresh_key_prefix . 'facebook' => $partial_refresh_args,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'twitter' )
	->type( 'url' )
	->label( __( 'X (Twitter) URL', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->partialRefresh( [
		$partial_refresh_key_prefix . 'twitter' => $partial_refresh_args,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'instagram' )
	->type( 'url' )
	->label( __( 'Instagram URL', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->partialRefresh( [
		$partial_refresh_key_prefix . 'instagram' => $partial_refresh_args,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'youtube' )
	->type( 'url' )
	->label( __( 'YouTube URL', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->partialRefresh( [
		$partial_refresh_key_prefix . 'youtube' => $partial_refresh_args,
	] )
	->addToSection( $section_id );

wpbf_customizer_field()
	->id( $control_id_prefix . 'linkedin' )
	->type( 'url' )
	->label( __( 'LinkedIn URL', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->partialRefresh( [
		$partial_refresh_key_prefix . 'linkedin' => $partial_refresh_args,
	] )
	->addToSection( $section_id );
