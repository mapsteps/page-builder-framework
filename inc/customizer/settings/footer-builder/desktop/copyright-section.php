<?php
/**
 * Footer builder's desktop copyright section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$section_id = 'wpbf_footer_builder_desktop_copyright_section';

wpbf_customizer_section()
	->id( $section_id )
	->type( 'invisible' )
	->title( __( 'Copyright', 'page-builder-framework' ) )
	->priority( 3 )
	->addToPanel( 'footer_panel' );

$control_id_prefix = 'wpbf_footer_builder_desktop_copyright_';

$partial_refresh_key_prefix = 'footerbuilder_desktop_copyright_';

$partial_refresh_args = array(
	'container_inclusive' => true,
	'selector'            => '#footer',
	'render_callback'     => function () {
		return get_template_part( 'inc/template-parts/footer-builder' );
	},
);

wpbf_customizer_field()
	->id( $control_id_prefix . 'text' )
	->type( 'textarea' )
	->label( __( 'Copyright Text', 'page-builder-framework' ) )
	->description( __( 'Use [year] for current year, [blogname] for site name, [theme_author] for theme author.', 'page-builder-framework' ) )
	->defaultValue( __( '© [year] [blogname]. All rights reserved.', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->partialRefresh( [
		$partial_refresh_key_prefix . 'text' => $partial_refresh_args,
	] )
	->addToSection( $section_id );
