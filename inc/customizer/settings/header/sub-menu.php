<?php
/**
 * Sub menu customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Fields – Sub Menu */

// Width.
wpbf_customizer_field()
	->id( 'sub_menu_width' )
	->type( 'slider' )
	->tab( 'general' )
	->label( __( 'Sub Menu Width', 'page-builder-framework' ) )
	->defaultValue( 220 )
	->priority( 0 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 100,
		'max'  => 400,
		'step' => 1,
	] )
	->addToSection( 'wpbf_sub_menu_options' );

// Alignment.
wpbf_customizer_field()
	->id( 'sub_menu_alignment' )
	->type( 'radio-image' )
	->tab( 'general' )
	->label( __( 'Sub Menu Alignment', 'page-builder-framework' ) )
	->defaultValue( 'left' )
	->choices( [
		'left'   => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center' => WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'  => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	] )
	->priority( 1 )
	->transport( 'postMessage' )
	->partialRefresh( [
		'submenualignment' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'wpbf_sub_menu_options' );

// Text alignment.
wpbf_customizer_field()
	->id( 'sub_menu_text_alignment' )
	->type( 'radio-image' )
	->tab( 'general' )
	->label( __( 'Text Alignment', 'page-builder-framework' ) )
	->defaultValue( 'left' )
	->choices( [
		'left'   => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center' => WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'  => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	] )
	->priority( 2 )
	->transport( 'postMessage' )
	->addToSection( 'wpbf_sub_menu_options' );

// Padding.
wpbf_customizer_field()
	->id( 'sub_menu_padding' )
	->type( 'padding' )
	->tab( 'general' )
	->label( __( 'Menu Item Padding', 'page-builder-framework' ) )
	->priority( 3 )
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
	->addToSection( 'wpbf_sub_menu_options' );

// Background color.
wpbf_customizer_field()
	->id( 'sub_menu_bg_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( '#ffffff' )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_sub_menu_options' );

// Background color alt.
wpbf_customizer_field()
	->id( 'sub_menu_bg_color_alt' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->defaultValue( '#ffffff' )
	->priority( 5 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_sub_menu_options' );

// Accent color.
wpbf_customizer_field()
	->id( 'sub_menu_accent_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->priority( 6 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_sub_menu_options' );

// Accent color alt.
wpbf_customizer_field()
	->id( 'sub_menu_accent_color_alt' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 7 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_sub_menu_options' );


// Font size.
wpbf_customizer_field()
	->id( 'sub_menu_font_size' )
	->type( 'input-slider' )
	->tab( 'design' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->priority( 8 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->addToSection( 'wpbf_sub_menu_options' );

// Separator toggle.
wpbf_customizer_field()
	->id( 'sub_menu_separator' )
	->type( 'headline-toggle' )
	->tab( 'design' )
	->label( __( 'Sub Menu Separator', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 9 )
	->addToSection( 'wpbf_sub_menu_options' );

// Separator color.
wpbf_customizer_field()
	->id( 'sub_menu_separator_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Color', 'page-builder-framework' ) )
	->defaultValue( '#f5f5f7' )
	->priority( 10 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		array(
			'setting'  => 'sub_menu_separator',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_sub_menu_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs/sub-menu/?utm_source=repository&utm_medium=customizer_sub_menu_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_header_sub_menu' )
		->type( 'custom' )
		->tab( 'general' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_sub_menu_options' );

}
