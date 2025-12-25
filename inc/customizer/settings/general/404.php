<?php
/**
 * 404 Page customizer settings.
 *
 * @package    Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Fields - 404 Page */

// 404 title.
wpbf_customizer_field()
	->id( '404_headline' )
	->type( 'text' )
	->label( __( 'Title', 'page-builder-framework' ) )
	->defaultValue( __( "404 - This page couldn't be found.", 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->addToSection( 'wpbf_404_options' );

// 404 text.
wpbf_customizer_field()
	->id( '404_text' )
	->type( 'text' )
	->label( __( 'Text', 'page-builder-framework' ) )
	->defaultValue( __( "Oops! We're sorry, this page couldn't be found!", 'page-builder-framework' ) )
	->priority( 2 )
	->transport( 'postMessage' )
	->addToSection( 'wpbf_404_options' );

// Search form.
wpbf_customizer_field()
	->id( '404_search_form' )
	->type( 'select' )
	->label( __( 'Search Form', 'page-builder-framework' ) )
	->defaultValue( 'show' )
	->priority( 3 )
	->choices( array(
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	) )
	->partialRefresh( [
		'404searchform' => array(
			'container_inclusive' => true,
			'selector'            => '.wpbf-404-content #searchform',
			'render_callback'     => function () {
				return get_search_form();
			},
		),
	] )
	->addToSection( 'wpbf_404_options' );
