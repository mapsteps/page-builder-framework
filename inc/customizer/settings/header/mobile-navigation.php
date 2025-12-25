<?php
/**
 * Mobile navigation customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Fields – Mobile Navigation */

$mobile_menu_choices = array(
	'menu-mobile-default'   => __( 'Default', 'page-builder-framework' ),
	'menu-mobile-hamburger' => __( 'Hamburger', 'page-builder-framework' ),
);

// Variations.
wpbf_customizer_field()
	->id( 'mobile_menu_options' )
	->type( 'select' )
	->tab( 'general' )
	->label( __( 'Menu', 'page-builder-framework' ) )
	->defaultValue( 'menu-mobile-hamburger' )
	->priority( 1 )
	->choices( apply_filters( 'wpbf_mobile_menu_options', $mobile_menu_choices ) )
	->partialRefresh( [
		'mobilemenuoptions' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Separator.
wpbf_customizer_field()
	->id( 'mobile_menu_position_separator' )
	->type( 'divider' )
	->priority( 1 )
	->tab( 'general' )
	->activeCallback( [
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => '!==',
			'value'    => 'menu-mobile-default',
		),
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Mobile search icon.
wpbf_customizer_field()
	->id( 'mobile_menu_search_icon' )
	->type( 'toggle' )
	->tab( 'general' )
	->label( __( 'Search Icon', 'page-builder-framework' ) )
	->priority( 1 )
	->activeCallback( [
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => '!==',
			'value'    => 'menu-mobile-default',
		),
	] )
	->partialRefresh( [
		'mobilemenusearchicon' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Separator.
wpbf_customizer_field()
	->id( 'mobile_menu_search_icon_separator' )
	->type( 'divider' )
	->tab( 'general' )
	->priority( 1 )
	->activeCallback( [
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => '!==',
			'value'    => 'menu-mobile-default',
		),
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Height.
wpbf_customizer_field()
	->id( 'mobile_menu_height' )
	->type( 'slider' )
	->tab( 'general' )
	->label( __( 'Height', 'page-builder-framework' ) )
	->defaultValue( 20 )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 80,
		'step' => 1,
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Background color.
wpbf_customizer_field()
	->id( 'mobile_menu_background_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->priority( 3 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => '!=',
			'value'    => 'menu-mobile-elementor',
		),
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Icon color.
wpbf_customizer_field()
	->id( 'mobile_menu_hamburger_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Icon Color', 'page-builder-framework' ) )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => 'in',
			'value'    => array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' ),
		),
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Hamburger size.
wpbf_customizer_field()
	->id( 'mobile_menu_hamburger_size' )
	->type( 'input-slider' )
	->tab( 'design' )
	->label( __( 'Icon Size', 'page-builder-framework' ) )
	->defaultValue( '16px' )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->activeCallback( [
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => 'in',
			'value'    => array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' ),
		),
	] )
	->addToSection( 'wpbf_mobile_menu_options' );


// Hamburger background color.
wpbf_customizer_field()
	->id( 'mobile_menu_hamburger_bg_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Hamburger Icon Button', 'page-builder-framework' ) )
	->tooltip( __( 'Define a background color & turn the hamburger icon into a button.', 'page-builder-framework' ) )
	->priority( 5 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => 'in',
			'value'    => array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' ),
		),
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Border radius.
wpbf_customizer_field()
	->id( 'mobile_menu_hamburger_border_radius' )
	->type( 'slider' )
	->tab( 'design' )
	->label( __( 'Border Radius', 'page-builder-framework' ) )
	->defaultValue( 0 )
	->priority( 5 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->activeCallback( [
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => 'in',
			'value'    => array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' ),
		),
		array(
			'setting'  => 'mobile_menu_hamburger_bg_color',
			'operator' => '!=',
			'value'    => '',
		),
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Headline.
wpbf_customizer_field()
	->id( 'mobile_menu_item_settings_headline' )
	->type( 'headline' )
	->label( esc_html__( 'Menu Item Settings', 'page-builder-framework' ) )
	->priority( 6 )
	->addToSection( 'wpbf_mobile_menu_options' );

// Padding.
wpbf_customizer_field()
	->id( 'mobile_menu_padding' )
	->type( 'padding' )
	->tab( 'general' )
	->label( __( 'Padding', 'page-builder-framework' ) )
	->priority( 8 )
	->transport( 'postMessage' )
	->defaultValue( [
		'top'    => 10,
		'right'  => 20,
		'bottom' => 10,
		'left'   => 20,
	] )
	->properties( [
		'save_as_json'   => true,
		'dont_save_unit' => true,
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Menu item background color.
wpbf_customizer_field()
	->id( 'mobile_menu_bg_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( '#ffffff' )
	->priority( 9 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Menu item background color alt.
wpbf_customizer_field()
	->id( 'mobile_menu_bg_color_alt' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->defaultValue( '#ffffff' )
	->priority( 10 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Font colors.
wpbf_customizer_field()
	->id( 'mobile_menu_font_colors' )
	->type( 'multicolor' )
	->tab( 'design' )
	->label( __( 'Font Colors', 'page-builder-framework' ) )
	->priority( 11 )
	->transport( 'postMessage' )
	->choices( array(
		'default' => __( 'Default', 'page-builder-framework' ),
		'hover'   => __( 'Hover', 'page-builder-framework' ),
	) )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_mobile_menu_options' );

// Divider color.
wpbf_customizer_field()
	->id( 'mobile_menu_border_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Divider Color', 'page-builder-framework' ) )
	->defaultValue( '#d9d9e0' )
	->priority( 13 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Sub menu arrow color.
wpbf_customizer_field()
	->id( 'mobile_menu_submenu_arrow_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Sub Menu Arrow Color', 'page-builder-framework' ) )
	->priority( 14 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

// Font size.
wpbf_customizer_field()
	->id( 'mobile_menu_font_size' )
	->type( 'input-slider' )
	->tab( 'design' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->defaultValue( '16px' )
	->priority( 15 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->addToSection( 'wpbf_mobile_menu_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=customizer_mobile_navigation_panel&utm_campaign=wpbf#premium" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_header_mobile_menu' )
		->type( 'custom' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_mobile_menu_options' );

}
