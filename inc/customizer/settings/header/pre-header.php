<?php
/**
 * Pre-header customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Fields – Pre Header */

// Pre header layout.
wpbf_customizer_field()
	->id( 'pre_header_layout' )
	->type( 'radio-buttonset' )
	->tab( 'general' )
	->label( __( 'Layout', 'page-builder-framework' ) )
	->defaultValue( 'none' )
	->priority( 1 )
	->choices( [
		'none' => __( 'None', 'page-builder-framework' ),
		'one'  => __( 'One Column', 'page-builder-framework' ),
		'two'  => __( 'Two Columns', 'page-builder-framework' ),
	] )
	->partialRefresh( [
		'preheaderlayout' => array(
			'container_inclusive' => true,
			'selector'            => '#pre-header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/pre-header' );
			},
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Column one layout.
wpbf_customizer_field()
	->id( 'pre_header_column_one_layout' )
	->type( 'select' )
	->tab( 'general' )
	->label( __( 'Column 1', 'page-builder-framework' ) )
	->defaultValue( 'text' )
	->priority( 2 )
	->choices( [
		'none' => __( 'None', 'page-builder-framework' ),
		'text' => __( 'Text', 'page-builder-framework' ),
		'menu' => __( 'Menu', 'page-builder-framework' ),
	] )
	->activeCallback( [
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->partialRefresh( [
		'preheadercolumnonelayout' => array(
			'container_inclusive' => true,
			'selector'            => '#pre-header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/pre-header' );
			},
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );


// Column one.
wpbf_customizer_field()
	->id( 'pre_header_column_one' )
	->type( 'textarea' )
	->tab( 'general' )
	->label( __( 'Text', 'page-builder-framework' ) )
	->defaultValue( __( 'Column 1', 'page-builder-framework' ) )
	->priority( 2 )
	->partialRefresh( [
		'preheadercolumnonecontent' => array(
			'selector'        => '.wpbf-inner-pre-header-left, .wpbf-inner-pre-header-content',
			'render_callback' => function () {
				return do_shortcode( get_theme_mod( 'pre_header_column_one' ) );
			},
		),
	] )
	->activeCallback( [
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
		array(
			'setting'  => 'pre_header_column_one_layout',
			'operator' => '==',
			'value'    => 'text',
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Separator.
wpbf_customizer_field()
	->id( 'pre_header_column_two_layout_separator' )
	->type( 'divider' )
	->tab( 'general' )
	->priority( 2 )
	->activeCallback( [
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '==',
			'value'    => 'two',
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Column two layout.
wpbf_customizer_field()
	->id( 'pre_header_column_two_layout' )
	->type( 'select' )
	->tab( 'general' )
	->label( __( 'Column 2', 'page-builder-framework' ) )
	->defaultValue( 'text' )
	->choices( [
		'none' => __( 'None', 'page-builder-framework' ),
		'text' => __( 'Text', 'page-builder-framework' ),
		'menu' => __( 'Menu', 'page-builder-framework' ),
	] )
	->priority( 2 )
	->activeCallback( [
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '==',
			'value'    => 'two',
		),
	] )
	->partialRefresh( [
		'preheadercolumntwolayout' => array(
			'container_inclusive' => true,
			'selector'            => '#pre-header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/pre-header' );
			},
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Column two.
wpbf_customizer_field()
	->id( 'pre_header_column_two' )
	->type( 'textarea' )
	->tab( 'general' )
	->label( __( 'Text', 'page-builder-framework' ) )
	->defaultValue( __( 'Column 2', 'page-builder-framework' ) )
	->priority( 2 )
	->partialRefresh( [
		'preheadercolumntwocontent' => array(
			'selector'        => '.wpbf-inner-pre-header-right',
			'render_callback' => function () {
				return do_shortcode( get_theme_mod( 'pre_header_column_two' ) );
			},
		),
	] )
	->activeCallback( [
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '==',
			'value'    => 'two',
		),
		array(
			'setting'  => 'pre_header_column_two_layout',
			'operator' => '==',
			'value'    => 'text',
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Separator.
wpbf_customizer_field()
	->id( 'pre_header_separator' )
	->type( 'divider' )
	->tab( 'general' )
	->priority( 3 )
	->activeCallback( [
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Width.
wpbf_customizer_field()
	->id( 'pre_header_width' )
	->type( 'dimension' )
	->tab( 'general' )
	->label( __( 'Pre Header Width', 'page-builder-framework' ) )
	->description( __( 'Default: 1200px', 'page-builder-framework' ) )
	->priority( 3 )
	->transport( 'postMessage' )
	->activeCallback( [
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Height.
wpbf_customizer_field()
	->id( 'pre_header_height' )
	->type( 'slider' )
	->tab( 'general' )
	->label( __( 'Height', 'page-builder-framework' ) )
	->priority( 3 )
	->defaultValue( 10 )
	->transport( 'postMessage' )
	->properties( array(
		'min'  => 1,
		'max'  => 25,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Background color.
wpbf_customizer_field()
	->id( 'pre_header_bg_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( '#ffffff' )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Font color.
wpbf_customizer_field()
	->id( 'pre_header_font_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Accent colors.
wpbf_customizer_field()
	->id( 'pre_header_accent_colors' )
	->type( 'multicolor' )
	->tab( 'design' )
	->label( __( 'Accent Color', 'page-builder-framework' ) )
	->priority( 4 )
	->transport( 'postMessage' )
	->choices( array(
		'default' => __( 'Default', 'page-builder-framework' ),
		'hover'   => __( 'Hover', 'page-builder-framework' ),
	) )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_pre_header_options' );

// Font size.
wpbf_customizer_field()
	->id( 'pre_header_font_size' )
	->type( 'input-slider' )
	->tab( 'design' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->priority( 4 )
	->defaultValue( '14px' )
	->transport( 'postMessage' )
	->activeCallback( [
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->addToSection( 'wpbf_pre_header_options' );
