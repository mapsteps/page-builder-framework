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
	__( 'Get all features with the <a href="%1s" target="_blank">Premium Add-On</a>!', 'page-builder-framework' ),
	esc_url( 'https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=customizer&utm_campaign=wpbf#premium' )
);

// Panel.
Kirki::add_section( 'wpbf_premium_addon', array(
	'title'    => __( 'Premium Features available!', 'page-builder-framework' ),
	'priority' => 1,
	'type'     => 'expanded',
) );

// Field.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'wpbf_premium_ad',
	'section'  => 'wpbf_premium_addon',
	'default'  => $wpbf_premium_ad_link,
	'priority' => 1,
) );
