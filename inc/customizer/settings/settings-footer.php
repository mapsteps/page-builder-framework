<?php
/**
 * Footer customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Panel */

// Footer.
wpbf_customizer_panel()
	->id( 'footer_panel' )
	->title( __( 'Footer', 'page-builder-framework' ) )
	->priority( 5 )
	->add();

/* Sections - Footer */

// Widget footer.
wpbf_customizer_section()
	->id( 'wpbf_widget_footer_options' )
	->title( __( 'Widget Area', 'page-builder-framework' ) )
	->priority( 100 )
	->addToPanel( 'footer_panel' );

// Footer.
wpbf_customizer_section()
	->id( 'wpbf_footer_options' )
	->title( __( 'Footer Bar', 'page-builder-framework' ) )
	->priority( 200 )
	->tabs( [
		'general' => [
			'label' => esc_html__( 'General', 'page-builder-framework' ),
		],
		'design'  => [
			'label' => esc_html__( 'Design', 'page-builder-framework' ),
		],
	] )
	->addToPanel( 'footer_panel' );

/* Fields – Footer */

// Layout.
wpbf_customizer_field()
	->id( 'footer_layout' )
	->type( 'radio-buttonset' )
	->tab( 'general' )
	->label( __( 'Footer', 'page-builder-framework' ) )
	->defaultValue( 'two' )
	->priority( 1 )
	->choices( [
		'none' => __( 'None', 'page-builder-framework' ),
		'one'  => __( 'One Column', 'page-builder-framework' ),
		'two'  => __( 'Two Columns', 'page-builder-framework' ),
	] )
	->partialRefresh( [
		'footerlayout' => array(
			'container_inclusive' => true,
			'selector'            => '#footer',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/footer' );
			},
		),
	] )
	->addToSection( 'wpbf_footer_options' );

// Column one layout.
wpbf_customizer_field()
	->id( 'footer_column_one_layout' )
	->type( 'select' )
	->tab( 'general' )
	->label( __( 'Column 1', 'page-builder-framework' ) )
	->defaultValue( 'text' )
	->choices( [
		'text'    => __( 'Text', 'page-builder-framework' ),
		'button'  => __( 'Button', 'page-builder-framework' ),
		'primary' => __( 'Button (Primary)', 'page-builder-framework' ),
	] )
	->priority( 2 )
	->choices( [
		'none' => __( 'None', 'page-builder-framework' ),
		'text' => __( 'Text', 'page-builder-framework' ),
		'menu' => __( 'Menu', 'page-builder-framework' ),
	] )
	->activeCallback( [
		array(
			'id'       => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->partialRefresh( [
		'footercolumnonelayout' => array(
			'container_inclusive' => true,
			'selector'            => '#footer',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/footer' );
			},
		),
	] )
	->addToSection( 'wpbf_footer_options' );

// Column one.
wpbf_customizer_field()
	->id( 'footer_column_one' )
	->type( 'textarea' )
	->tab( 'general' )
	->label( __( 'Text', 'page-builder-framework' ) )
	->defaultValue( __( '&copy; [year] - [blogname] | All rights reserved', 'page-builder-framework' ) )
	->priority( 2 )
	->partialRefresh( [
		'footercolumnonecontent' => array(
			'selector'        => '#footer',
			'render_callback' => function () {
				return get_template_part( 'inc/template-parts/footer' );
			},
		),
	] )
	->activeCallback( [
		array(
			'id'       => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
		array(
			'id'       => 'footer_column_one_layout',
			'operator' => '==',
			'value'    => 'text',
		),
	] )
	->addToSection( 'wpbf_footer_options' );

// Separator.
wpbf_customizer_field()
	->id( 'footer_column_two_separator' )
	->type( 'divider' )
	->tab( 'general' )
	->priority( 3 )
	->activeCallback( [
		array(
			'id'       => 'footer_layout',
			'operator' => '==',
			'value'    => 'two',
		),
	] )
	->addToSection( 'wpbf_footer_options' );

// Column two layout.
wpbf_customizer_field()
	->id( 'footer_column_two_layout' )
	->type( 'select' )
	->tab( 'general' )
	->label( __( 'Column 2', 'page-builder-framework' ) )
	->defaultValue( 'text' )
	->choices( [
		'none' => __( 'None', 'page-builder-framework' ),
		'text' => __( 'Text', 'page-builder-framework' ),
		'menu' => __( 'Menu', 'page-builder-framework' ),
	] )
	->priority( 3 )
	->activeCallback( [
		array(
			'id'       => 'footer_layout',
			'operator' => '==',
			'value'    => 'two',
		),
	] )
	->partialRefresh( [
		'footercolumntwolayout' => array(
			'container_inclusive' => true,
			'selector'            => '#footer',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/footer' );
			},
		),
	] )
	->addToSection( 'wpbf_footer_options' );

// Column two.
wpbf_customizer_field()
	->id( 'footer_column_two' )
	->type( 'textarea' )
	->tab( 'general' )
	->label( __( 'Text', 'page-builder-framework' ) )
	->defaultValue( __( 'Powered by [theme_author]', 'page-builder-framework' ) )
	->priority( 3 )
	->partialRefresh( [
		'footercolumntwocontent' => array(
			'selector'        => '#footer',
			'render_callback' => function () {
				return get_template_part( 'inc/template-parts/footer' );
			},
		),
	] )
	->activeCallback( [
		array(
			'id'       => 'footer_layout',
			'operator' => '==',
			'value'    => 'two',
		),
		array(
			'id'       => 'footer_column_two_layout',
			'operator' => '==',
			'value'    => 'text',
		),
	] )
	->addToSection( 'wpbf_footer_options' );

// Width.
wpbf_customizer_field()
	->id( 'footer_width' )
	->type( 'dimension' )
	->tab( 'general' )
	->label( __( 'Footer Width', 'page-builder-framework' ) )
	->description( __( 'Default: 1200px', 'page-builder-framework' ) )
	->priority( 5 )
	->transport( 'postMessage' )
	->activeCallback( [
		array(
			'id'       => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_footer_options' );

// Footer height.
wpbf_customizer_field()
	->id( 'footer_height' )
	->type( 'slider' )
	->tab( 'general' )
	->label( __( 'Height', 'page-builder-framework' ) )
	->priority( 6 )
	->defaultValue( 20 )
	->transport( 'postMessage' )
	->properties( array(
		'min'  => 1,
		'max'  => 100,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'id'       => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_footer_options' );

// Background color.
wpbf_customizer_field()
	->id( 'footer_bg_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( '#f5f5f7' )
	->priority( 7 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_footer_options' );

// Font color.
wpbf_customizer_field()
	->id( 'footer_font_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->priority( 8 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_footer_options' );

// Accent color.
wpbf_customizer_field()
	->id( 'footer_accent_color' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Accent Color', 'page-builder-framework' ) )
	->priority( 9 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_footer_options' );

// Accent color alt.
wpbf_customizer_field()
	->id( 'footer_accent_color_alt' )
	->type( 'color' )
	->tab( 'design' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 10 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_footer_options' );

// Font size.
wpbf_customizer_field()
	->id( 'footer_font_size' )
	->type( 'input-slider' )
	->tab( 'design' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->priority( 11 )
	->defaultValue( '14px' )
	->transport( 'postMessage' )
	->activeCallback( [
		array(
			'id'       => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->addToSection( 'wpbf_footer_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs/advanced-footer-settings/?utm_source=repository&utm_medium=customizer_footer_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_widget_footer' )
		->type( 'custom' )
		->defaultValue( $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_widget_footer_options' );

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs/advanced-footer-settings/?utm_source=repository&utm_medium=customizer_footer_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_footer' )
		->type( 'custom' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_footer_options' );

}
