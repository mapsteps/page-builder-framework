<?php
/**
 * Premium customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Stop if Premium Add-On is installed.
if ( wpbf_is_premium() ) {
	return;
}

$wpbf_premium_ad_link = sprintf(
	// translators: %1s represents the premium feature's URL.
	__( 'Get all features with the <a href="%1s" target="_blank">Premium Add-On</a>!', 'page-builder-framework' ),
	esc_url( 'https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=customizer&utm_campaign=wpbf#premium' )
);

// Section.
wpbf_customizer_section()
	->id( 'wpbf_premium_addon' )
	->type( 'expanded' )
	->title( __( 'Premium Features available!', 'page-builder-framework' ) )
	->priority( 1 )
	->add();

// Field.
wpbf_customizer_field()
	->id( 'wpbf_premium_ad' )
	->type( 'custom' )
	->defaultValue( $wpbf_premium_ad_link )
	->priority( 1 )
	->addToSection( 'wpbf_premium_addon' );
