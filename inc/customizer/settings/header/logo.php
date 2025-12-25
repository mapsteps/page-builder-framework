<?php
/**
 * Logo customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Fields – Logo */

// Mobile logo.
wpbf_customizer_field()
	->id( 'menu_mobile_logo' )
	->type( 'image' )
	->label( __( 'Mobile Logo', 'page-builder-framework' ) )
	->priority( 1 )
	->activeCallback( [
		array(
			'setting'  => 'custom_logo',
			'operator' => '!=',
			'value'    => '',
		),
	] )
	->partialRefresh( [
		'mobilelogo' => array(
			'container_inclusive' => true,
			'selector'            => '.wpbf-mobile-logo',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/logo/logo-mobile' );
			},
		),
	] )
	->addToSection( 'title_tagline' );

// Size.
wpbf_customizer_field()
	->id( 'menu_logo_size' )
	->type( 'responsive-input-slider' )
	->label( __( 'Logo Width', 'page-builder-framework' ) )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( [
		'min'          => 0,
		'max'          => 500,
		'step'         => 1,
		'save_as_json' => true,
	] )
	->activeCallback( [
		array(
			'setting'  => 'custom_logo',
			'operator' => '!=',
			'value'    => '',
		),
	] )
	->addToSection( 'title_tagline' );

// Separator.
wpbf_customizer_field()
	->id( 'logo_image_separator' )
	->type( 'divider' )
	->priority( 4 )
	->addToSection( 'title_tagline' );

// Color.
wpbf_customizer_field()
	->id( 'menu_logo_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Color', 'page-builder-framework' ) )
	->priority( 11 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		array(
			'setting'  => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
	] )
	->addToSection( 'title_tagline' );

// Hover color.
wpbf_customizer_field()
	->id( 'menu_logo_color_alt' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 12 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		array(
			'setting'  => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
	] )
	->addToSection( 'title_tagline' );

// Font size.
wpbf_customizer_field()
	->id( 'menu_logo_font_size' )
	->type( 'responsive-input-slider' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->priority( 13 )
	->transport( 'postMessage' )
	->defaultValue( [
		'desktop' => '22px',
		'tablet'  => '',
		'mobile'  => '',
	] )
	->activeCallback( [
		array(
			'setting'  => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
	] )
	->properties( [
		'min'          => 0,
		'max'          => 50,
		'step'         => 1,
		'save_as_json' => true,
	] )
	->addToSection( 'title_tagline' );


// Separator.
wpbf_customizer_field()
	->id( 'tagline_separator' )
	->type( 'divider' )
	->priority( 14 )
	->activeCallback( [
		array(
			'setting'  => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
	] )
	->addToSection( 'title_tagline' );

/* Fields – Tagline */

// Toggle.
wpbf_customizer_field()
	->id( 'menu_logo_description' )
	->type( 'toggle' )
	->tab( 'general' )
	->label( __( 'Display Tagline', 'page-builder-framework' ) )
	->defaultValue( 0 )
	->priority( 20 )
	->activeCallback( [
		array(
			'setting'  => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
	] )
	->partialRefresh( [
		'displaytagline' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'title_tagline' );

// Mobile toggle.
wpbf_customizer_field()
	->id( 'menu_logo_description_mobile' )
	->type( 'toggle' )
	->tab( 'general' )
	->label( __( 'Display Tagline on Mobile', 'page-builder-framework' ) )
	->defaultValue( 0 )
	->priority( 20 )
	->activeCallback( [
		array(
			'setting'  => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
		array(
			'setting'  => 'menu_logo_description',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->partialRefresh( [
		'displaytaglinemobile' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'title_tagline' );

// Color.
wpbf_customizer_field()
	->id( 'menu_logo_description_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Color', 'page-builder-framework' ) )
	->priority( 22 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		array(
			'setting'  => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
		array(
			'setting'  => 'menu_logo_description',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'title_tagline' );

// Font size.
wpbf_customizer_field()
	->id( 'menu_logo_description_font_size' )
	->type( 'responsive-input-slider' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->priority( 23 )
	->transport( 'postMessage' )
	->activeCallback( [
		array(
			'setting'  => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
		array(
			'setting'  => 'menu_logo_description',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->properties( [
		'min'          => 0,
		'max'          => 50,
		'step'         => 1,
		'save_as_json' => true,
	] )
	->addToSection( 'title_tagline' );

// Separator.
wpbf_customizer_field()
	->id( 'logo_settings_separator' )
	->type( 'divider' )
	->priority( 24 )
	->addToSection( 'title_tagline' );

/* Fields – Logo Settings */

// Logo URL.
wpbf_customizer_field()
	->id( 'menu_logo_url' )
	->type( 'url' )
	->tab( 'general' )
	->label( __( 'Custom Logo URL', 'page-builder-framework' ) )
	->priority( 30 )
	->transport( 'postMessage' )
	->addToSection( 'title_tagline' );

// Alt tag.
wpbf_customizer_field()
	->id( 'menu_logo_alt' )
	->type( 'text' )
	->tab( 'general' )
	->label( __( 'Custom "alt" Tag', 'page-builder-framework' ) )
	->priority( 31 )
	->transport( 'postMessage' )
	->activeCallback( [
		array(
			'setting'  => 'custom_logo',
			'operator' => '!==',
			'value'    => '',
		),
	] )
	->addToSection( 'title_tagline' );

// Title tag.
wpbf_customizer_field()
	->id( 'menu_logo_title' )
	->type( 'text' )
	->label( __( 'Custom "title" Tag', 'page-builder-framework' ) )
	->priority( 32 )
	->transport( 'postMessage' )
	->activeCallback( [
		array(
			'setting'  => 'custom_logo',
			'operator' => '!==',
			'value'    => '',
		),
	] )
	->addToSection( 'title_tagline' );

// Separator.
wpbf_customizer_field()
	->id( 'logo_container_separator' )
	->type( 'divider' )
	->priority( 33 )
	->addToSection( 'title_tagline' );

/* Fields – Logo Container Width */

// Container width.
wpbf_customizer_field()
	->id( 'menu_logo_container_width' )
	->type( 'slider' )
	->tab( 'general' )
	->label( __( 'Logo Container Width', 'page-builder-framework' ) )
	->description( __( 'Defines the space in % the logo area takes in the navigation.', 'page-builder-framework' ) )
	->defaultValue( 25 )
	->priority( 40 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 10,
		'max'  => 40,
		'step' => 1,
	] )
	->addToSection( 'title_tagline' );

// Mobile container width.
wpbf_customizer_field()
	->id( 'mobile_menu_logo_container_width' )
	->type( 'slider' )
	->tab( 'general' )
	->label( __( 'Logo Container Width (Mobile)', 'page-builder-framework' ) )
	->description( __( 'Defines the space in % the logo area takes in the navigation.', 'page-builder-framework' ) )
	->defaultValue( 66 )
	->priority( 41 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 10,
		'max'  => 80,
		'step' => 1,
	] )
	->addToSection( 'title_tagline' );

// Separator.
wpbf_customizer_field()
	->id( 'favicon_separator' )
	->type( 'divider' )
	->priority( 42 )
	->addToSection( 'title_tagline' );
