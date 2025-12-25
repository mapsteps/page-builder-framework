<?php
/**
 * Typography text fields.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Fields - Text */

// Text font toggle.
wpbf_customizer_field()
	->id( 'page_font_toggle' )
	->type( 'toggle' )
	->label( __( 'Font Settings', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 0 )
	->addToSection( 'wpbf_font_options' );

// Font family.
wpbf_customizer_field()
	->id( 'page_font_family' )
	->type( 'typography' )
	->defaultValue( array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => 'regular',
	) )
	->priority( 1 )
	->activeCallback( array(
		array(
			'setting'  => 'page_font_toggle',
			'operator' => '==',
			'value'    => true,
		),
	) )
	->properties( wpbf_typography_field_properties() )
	->addToSection( 'wpbf_font_options' );

// Separator.
wpbf_customizer_field()
	->id( 'page_font_toggle_separator' )
	->type( 'divider' )
	->priority( 1 )
	->addToSection( 'wpbf_font_options' );

// Color.
wpbf_customizer_field()
	->id( 'page_font_color' )
	->type( 'color' )
	->label( __( 'Color', 'page-builder-framework' ) )
	->defaultValue( '#6d7680' )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_font_options' );

// Accent color.
wpbf_customizer_field()
	->id( 'page_accent_color' )
	->type( 'color' )
	->label( __( 'Accent Color', 'page-builder-framework' ) )
	->defaultValue( '#3ba9d2' )
	->priority( 4 )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_font_options' );

// Accent color alt.
wpbf_customizer_field()
	->id( 'page_accent_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->defaultValue( '#79c4e0' )
	->priority( 4 )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_font_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_typography_text' )
		->type( 'custom' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_font_options' );

}
