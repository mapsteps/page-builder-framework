<?php
/**
 * Blog customizer settings - Single/Post Layout Fields.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Fields - Post Layout */

$singles = apply_filters( 'wpbf_singles', array( 'single' ) );

foreach ( $singles as $single ) {

	// Width.
	wpbf_customizer_field()
		->id( $single . '_custom_width' )
		->type( 'dimension' )
		->label( __( 'Custom Content Width', 'page-builder-framework' ) )
		->description( __( 'Default: 1200px', 'page-builder-framework' ) )
		->priority( 0 )
		->addToSection( 'wpbf_' . $single . '_options' );

	// Sidebar layout.
	wpbf_customizer_field()
		->id( $single . '_sidebar_layout' )
		->type( 'select' )
		->label( __( 'Sidebar', 'page-builder-framework' ) )
		->defaultValue( 'global' )
		->choices( [
			'global' => __( 'Inherit Global Settings', 'page-builder-framework' ),
			'right'  => __( 'Right', 'page-builder-framework' ),
			'left'   => __( 'Left', 'page-builder-framework' ),
			'none'   => __( 'No Sidebar', 'page-builder-framework' ),
		] )
		->priority( 0 )
		->addToSection( 'wpbf_' . $single . '_options' );

	// Separator.
	wpbf_customizer_field()
		->id( $single . '_separator_1' )
		->type( 'divider' )
		->priority( 0 )
		->addToSection( 'wpbf_' . $single . '_options' );

	// Header.
	wpbf_customizer_field()
		->id( $single . '_sortable_header' )
		->type( 'sortable' )
		->label( __( 'Header', 'page-builder-framework' ) )
		->defaultValue( array(
			'title',
			'meta',
			'featured',
		) )
		->choices( array(
			'title'    => __( 'Title', 'page-builder-framework' ),
			'meta'     => __( 'Meta Data', 'page-builder-framework' ),
			'featured' => __( 'Featured Image', 'page-builder-framework' ),
		) )
		->priority( 0 )
		->addToSection( 'wpbf_' . $single . '_options' );

	// Footer.
	wpbf_customizer_field()
		->id( $single . '_sortable_footer' )
		->type( 'sortable' )
		->label( __( 'Footer', 'page-builder-framework' ) )
		->defaultValue( array(
			'readmore',
			'categories',
		) )
		->choices( array(
			'readmore'   => __( 'Read More', 'page-builder-framework' ),
			'categories' => __( 'Categories', 'page-builder-framework' ),
			'tags'       => __( 'Tags', 'page-builder-framework' ),
		) )
		->priority( 0 )
		->addToSection( 'wpbf_' . $single . '_options' );

	if ( 'single' === $single ) {

		// Separator.
		wpbf_customizer_field()
			->id( $single . '_separator_comments' )
			->type( 'divider' )
			->priority( 0 )
			->addToSection( 'wpbf_' . $single . '_options' );

		// Toggle.
		wpbf_customizer_field()
			->id( $single . '_disable_comments' )
			->type( 'toggle' )
			->label( __( 'Disable Comments', 'page-builder-framework' ) )
			->defaultValue( false )
			->priority( 0 )
			->addToSection( 'wpbf_' . $single . '_options' );

	}

	// Separator.
	wpbf_customizer_field()
		->id( $single . '_separator_2' )
		->type( 'divider' )
		->priority( 0 )
		->addToSection( 'wpbf_' . $single . '_options' );

	// Post navigation.
	wpbf_customizer_field()
		->id( $single . '_post_nav' )
		->type( 'select' )
		->label( __( 'Post Navigation', 'page-builder-framework' ) )
		->defaultValue( 'show' )
		->choices( [
			'show'    => __( 'Previous/Next Post', 'page-builder-framework' ),
			'default' => __( 'Post Title', 'page-builder-framework' ),
			'hide'    => __( 'Hide', 'page-builder-framework' ),
		] )
		->priority( 0 )
		->addToSection( 'wpbf_' . $single . '_options' );

	// Style.
	wpbf_customizer_field()
		->id( $single . '_post_style' )
		->type( 'select' )
		->label( __( 'Style', 'page-builder-framework' ) )
		->defaultValue( 'plain' )
		->choices( [
			'plain' => __( 'Default', 'page-builder-framework' ),
			'boxed' => __( 'Boxed', 'page-builder-framework' ),
		] )
		->priority( 0 )
		->addToSection( 'wpbf_' . $single . '_options' );

	// Stretch image.
	wpbf_customizer_field()
		->id( $single . '_boxed_image_stretched' )
		->type( 'toggle' )
		->label( __( 'Stretch Featured Image', 'page-builder-framework' ) )
		->defaultValue( false )
		->priority( 0 )
		->activeCallback( [
			array(
				'setting'  => $single . '_post_style',
				'operator' => '==',
				'value'    => 'boxed',
			),
		] )
		->addToSection( 'wpbf_' . $single . '_options' );

	// Padding.
	wpbf_customizer_field()
		->id( $single . '_boxed_padding' )
		->type( 'responsive-padding' )
		->label( __( 'Padding', 'page-builder-framework' ) )
		->priority( 10 )
		->activeCallback( [
			array(
				'setting'  => $single . '_post_style',
				'operator' => '==',
				'value'    => 'boxed',
			),
		] )
		->properties( [
			'save_as_json'   => true,
			'dont_save_unit' => true,
		] )
		->addToSection( 'wpbf_' . $single . '_options' );

	// Background color.
	wpbf_customizer_field()
		->id( $single . '_post_background_color' )
		->type( 'color' )
		->label( __( 'Background Color', 'page-builder-framework' ) )
		->defaultValue( '#f5f5f7' )
		->priority( 20 )
		->properties( [
			'mode' => 'alpha',
		] )
		->activeCallback( [
			array(
				'setting'  => $single . '_post_style',
				'operator' => '==',
				'value'    => 'boxed',
			),
		] )
		->addToSection( 'wpbf_' . $single . '_options' );

	// Title size.
	wpbf_customizer_field()
		->id( $single . '_post_title_size' )
		->type( 'input-slider' )
		->label( __( 'Title Font Size', 'page-builder-framework' ) )
		->properties( [
			'min'  => 0,
			'max'  => 50,
			'step' => 1,
		] )
		->priority( 20 )
		->addToSection( 'wpbf_' . $single . '_options' );

	// Font size.
	wpbf_customizer_field()
		->id( $single . '_post_font_size' )
		->type( 'input-slider' )
		->label( __( 'Font Size', 'page-builder-framework' ) )
		->properties( [
			'min'  => 0,
			'max'  => 50,
			'step' => 1,
		] )
		->priority( 20 )
		->addToSection( 'wpbf_' . $single . '_options' );

}
