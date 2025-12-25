<?php
/**
 * Typography title and tagline fields.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Fields - Title & tagline */

// Title font toggle.
wpbf_customizer_field()
	->id( 'menu_logo_font_toggle' )
	->type( 'toggle' )
	->label( __( 'Title - Font Settings', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 0 )
	->addToSection( 'wpbf_title_tagline_options' );

// Font family.
wpbf_customizer_field()
	->id( 'menu_logo_font_family' )
	->type( 'typography' )
	->label( __( 'Font Family', 'page-builder-framework' ) )
	->defaultValue( array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
		'subsets'     => array( 'latin-ext' ),
	) )
	->properties( wpbf_typography_field_properties() )
	->priority( 1 )
	->activeCallback( array(
		array(
			'setting'  => 'menu_logo_font_toggle',
			'operator' => '==',
			'value'    => true,
		),
	) )
	->addToSection( 'wpbf_title_tagline_options' );

// Divider.
wpbf_customizer_field()
	->id( 'menu_logo_tagline_divider' )
	->type( 'divider' )
	->priority( 2 )
	->addToSection( 'wpbf_title_tagline_options' );

// Title font toggle.
wpbf_customizer_field()
	->id( 'menu_logo_description_toggle' )
	->type( 'toggle' )
	->label( esc_html__( 'Tagline - Font Settings', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 3 )
	->addToSection( 'wpbf_title_tagline_options' );

// Font family.
wpbf_customizer_field()
	->id( 'menu_logo_description_font_family' )
	->type( 'typography' )
	->label( __( 'Font Family', 'page-builder-framework' ) )
	->defaultValue( array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
		'subsets'     => array( 'latin-ext' ),
	) )
	->properties( wpbf_typography_field_properties() )
	->priority( 4 )
	->activeCallback( array(
		array(
			'setting'  => 'menu_logo_description_toggle',
			'operator' => '==',
			'value'    => true,
		),
	) )
	->addToSection( 'wpbf_title_tagline_options' );
