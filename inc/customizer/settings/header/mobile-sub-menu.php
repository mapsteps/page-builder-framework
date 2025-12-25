<?php
/**
 * Mobile sub menu customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Fields – Mobile Sub Menu */

// Auto collapse other sub-menu when a sub-menu is expanded.
wpbf_customizer_field()
	->id( 'mobile_sub_menu_auto_collapse' )
	->type( 'toggle' )
	->tab( 'general' )
	->label( __( 'Auto Collapse', 'page-builder-framework' ) )
	->description( __( 'Auto collapse open sub-menu if other sub-menu is being opened.', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->addToSection( 'wpbf_mobile_sub_menu_options' );

// Indent.
wpbf_customizer_field()
	->id( 'mobile_sub_menu_indent' )
	->type( 'slider' )
	->tab( 'general' )
	->label( __( 'Indent', 'page-builder-framework' ) )
	->defaultValue( 0 )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->addToSection( 'wpbf_mobile_sub_menu_options' );

// Separator.
wpbf_customizer_field()
	->id( 'mobile_sub_menu_separator' )
	->type( 'divider' )
	->priority( 2 )
	->addToSection( 'wpbf_mobile_sub_menu_options' );

// Menu item background color.
wpbf_customizer_field()
	->id( 'mobile_sub_menu_bg_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->priority( 3 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_sub_menu_options' );

// Menu item background color alt.
wpbf_customizer_field()
	->id( 'mobile_sub_menu_bg_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_sub_menu_options' );

// Font color.
wpbf_customizer_field()
	->id( 'mobile_sub_menu_font_color' )
	->type( 'color' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->priority( 5 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_sub_menu_options' );

// Font color hover.
wpbf_customizer_field()
	->id( 'mobile_sub_menu_font_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 6 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_sub_menu_options' );

// Sub menu arrow color.
wpbf_customizer_field()
	->id( 'mobile_sub_menu_arrow_color' )
	->type( 'color' )
	->label( __( 'Sub Menu Arrow Color', 'page-builder-framework' ) )
	->priority( 8 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_sub_menu_options' );

// Font size.
wpbf_customizer_field()
	->id( 'mobile_sub_menu_font_size' )
	->type( 'input-slider' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->priority( 9 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->addToSection( 'wpbf_mobile_sub_menu_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=customizer_mobile_navigation_panel&utm_campaign=wpbf#premium" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_header_mobile_sub_menu' )
		->type( 'custom' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_mobile_sub_menu_options' );

}
