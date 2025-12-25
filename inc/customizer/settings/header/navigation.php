<?php
/**
 * Navigation customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Fields – Navigation */

$menu_position_choices = apply_filters(
	'wpbf_menu_position',
	array(
		'menu-right'    => __( 'Right (default)', 'page-builder-framework' ),
		'menu-left'     => __( 'Left', 'page-builder-framework' ),
		'menu-centered' => __( 'Centered', 'page-builder-framework' ),
		'menu-stacked'  => __( 'Stacked', 'page-builder-framework' ),
	)
);

// Variations.
wpbf_customizer_field()
	->id( 'menu_position' )
	->type( 'select' )
	->tab( 'general' )
	->label( __( 'Menu', 'page-builder-framework' ) )
	->defaultValue( 'menu-right' )
	->priority( 0 )
	->choices( $menu_position_choices )
	->partialRefresh( [
		'headerlayout' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'wpbf_menu_options' );

// Separator.
wpbf_customizer_field()
	->id( 'menu_position_separator' )
	->type( 'divider' )
	->priority( 0 )
	->tab( 'general' )
	->addToSection( 'wpbf_menu_options' );

// Search icon.
wpbf_customizer_field()
	->id( 'menu_search_icon' )
	->type( 'toggle' )
	->tab( 'general' )
	->label( __( 'Search Icon', 'page-builder-framework' ) )
	->priority( 1 )
	->partialRefresh( [
		'menusearchicon' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'wpbf_menu_options' );

// Separator.
wpbf_customizer_field()
	->id( 'menu_search_icon_separator' )
	->type( 'divider' )
	->priority( 1 )
	->tab( 'general' )
	->addToSection( 'wpbf_menu_options' );

// Width.
wpbf_customizer_field()
	->id( 'menu_width' )
	->type( 'dimension' )
	->tab( 'general' )
	->label( __( 'Navigation Width', 'page-builder-framework' ) )
	->description( __( 'Default: 1200px', 'page-builder-framework' ) )
	->priority( 2 )
	->transport( 'postMessage' )
	->addToSection( 'wpbf_menu_options' );

// Height.
wpbf_customizer_field()
	->id( 'menu_height' )
	->type( 'slider' )
	->tab( 'general' )
	->label( __( 'Menu Height', 'page-builder-framework' ) )
	->defaultValue( 20 )
	->priority( 3 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 80,
		'step' => 1,
	] )
	->addToSection( 'wpbf_menu_options' );

// Padding.
wpbf_customizer_field()
	->id( 'menu_padding' )
	->type( 'slider' )
	->tab( 'design' )
	->label( __( 'Menu Item Spacing', 'page-builder-framework' ) )
	->defaultValue( 20 )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 5,
		'max'  => 40,
		'step' => 1,
	] )
	->addToSection( 'wpbf_menu_options' );

// Background color.
wpbf_customizer_field()
	->id( 'menu_bg_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( '#f5f5f7' )
	->priority( 5 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_menu_options' );

// Font colors.
wpbf_customizer_field()
	->id( 'menu_font_colors' )
	->type( 'multicolor' )
	->tab( 'design' )
	->label( __( 'Font Colors', 'page-builder-framework' ) )
	->priority( 6 )
	->transport( 'postMessage' )
	->choices( array(
		'default' => __( 'Default', 'page-builder-framework' ),
		'hover'   => __( 'Hover', 'page-builder-framework' ),
	) )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_menu_options' );

// Font size.
wpbf_customizer_field()
	->id( 'menu_font_size' )
	->type( 'input-slider' )
	->tab( 'design' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->priority( 7 )
	->defaultValue( '16px' )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	] )
	->addToSection( 'wpbf_menu_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=customizer_navigation_panel&utm_campaign=wpbf#premium" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_header_menu' )
		->type( 'custom' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_menu_options' );

}
