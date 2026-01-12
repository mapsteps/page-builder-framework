<?php
/**
 * Footer builder's mobile html 2 section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$section_id = 'wpbf_footer_builder_mobile_html_2_section';

wpbf_customizer_section()
	->id( $section_id )
	->type( 'invisible' )
	->title( __( 'HTML 2', 'page-builder-framework' ) )
	->priority( 3 )
	->addToPanel( 'footer_panel' );

$control_id_prefix = 'wpbf_footer_builder_mobile_html_2_';

wpbf_customizer_field()
	->id( $control_id_prefix . 'content' )
	->type( 'editor' )
	->defaultValue( __( 'Content for widget HTML 2', 'page-builder-framework' ) )
	->transport( 'postMessage' )
	->properties( array(
		'tinymce' => array(
			'toolbar1' => 'formatselect,styleselect,numlist,bullist,removeformat,bold,italic,underline,strikethrough,alignleft,aligncenter,alignright,link,unlink,forecolor,backcolor',
		),
	) )
	->addToSection( $section_id );
