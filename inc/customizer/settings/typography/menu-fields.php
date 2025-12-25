<?php
/**
 * Typography menu fields.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Fields - Menu */

// Menu font toggle.
wpbf_customizer_field()
	->id( 'menu_font_family_toggle' )
	->type( 'toggle' )
	->label( __( 'Font Settings', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 0 )
	->addToSection( 'wpbf_menu_font_options' );

// Font family.
wpbf_customizer_field()
	->id( 'menu_font_family' )
	->type( 'typography' )
	->label( __( 'Font Family', 'page-builder-framework' ) )
	->defaultValue( array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => 'regular',
	) )
	->properties( wpbf_typography_field_properties() )
	->priority( 1 )
	->activeCallback( array(
		array(
			'setting'  => 'menu_font_family_toggle',
			'operator' => '==',
			'value'    => true,
		),
	) )
	->addToSection( 'wpbf_menu_font_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_typography_menu' )
		->type( 'custom' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_menu_font_options' );

}
