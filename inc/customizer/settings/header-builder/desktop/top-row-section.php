<?php
/**
 * Header builder's desktop top row section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$row_key = 'desktop_row_1';

$section_id = 'wpbf_header_builder_' . $row_key . '_section';

wpbf_customizer_section()
	->id( $section_id )
	->type( 'invisible' )
	->title( __( 'Top Row', 'page-builder-framework' ) )
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
		return get_template_part( 'inc/template-parts/header' );
	},
);

/* General Tab */

/*
wpbf_customizer_field()
	->id( $control_id_prefix . 'visibility' )
	->type( 'checkbox-buttonset' )
	->tab( 'general' )
	->label( __( 'Visibility', 'page-builder-framework' ) )
	->description( __( 'In which devices this row should be displayed.', 'page-builder-framework' ) )
	->defaultValue( [ 'large', 'medium', 'small' ] )
	->choices( [
		'large'  => __( 'Desktop', 'page-builder-framework' ),
		'medium' => __( 'Tablet', 'page-builder-framework' ),
		'small'  => __( 'Mobile', 'page-builder-framework' ),
	] )
	->transport( 'postMessage' )
	->priority( 5 )
	->addToSection( $section_id );
*/

/* Design Tab */
