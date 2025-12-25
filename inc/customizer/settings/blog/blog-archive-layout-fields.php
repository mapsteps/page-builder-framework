<?php
/**
 * Blog customizer settings - Archive Layout Fields.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Fields - Blog Layouts */

$archives = apply_filters( 'wpbf_archives', array( 'archive' ) );

foreach ( $archives as $archive ) {

	// Width.
	wpbf_customizer_field()
		->id( $archive . '_custom_width' )
		->type( 'dimension' )
		->label( __( 'Custom Content Width', 'page-builder-framework' ) )
		->description( __( 'Default: 1200px', 'page-builder-framework' ) )
		->priority( 0 )
		->addToSection( 'wpbf_' . $archive . '_options' );

	if ( 'blog' !== $archive && 'search' !== $archive ) {

		// Headline.
		wpbf_customizer_field()
			->id( $archive . '_headline' )
			->type( 'select' )
			->label( ucwords( str_replace( '-', ' ', $archive ) ) . '&nbsp;' . __( 'Headline', 'page-builder-framework' ) )
			->defaultValue( 'show' )
			->priority( 0 )
			->choices( [
				'show'        => __( 'Show', 'page-builder-framework' ),
				'hide'        => __( 'Hide', 'page-builder-framework' ),
				'hide_prefix' => __( 'Remove Prefix', 'page-builder-framework' ),
			] )
			->addToSection( 'wpbf_' . $archive . '_options' );

	}

	// Sidebar layout.
	wpbf_customizer_field()
		->id( $archive . '_sidebar_layout' )
		->type( 'select' )
		->label( __( 'Sidebar', 'page-builder-framework' ) )
		->defaultValue( 'global' )
		->priority( 0 )
		->choices( [
			'global' => __( 'Inherit Global Settings', 'page-builder-framework' ),
			'right'  => __( 'Right', 'page-builder-framework' ),
			'left'   => __( 'Left', 'page-builder-framework' ),
			'none'   => __( 'No Sidebar', 'page-builder-framework' ),
		] )
		->addToSection( 'wpbf_' . $archive . '_options' );

	// Separator.
	wpbf_customizer_field()
		->id( $archive . '_separator_1' )
		->type( 'divider' )
		->priority( 0 )
		->addToSection( 'wpbf_' . $archive . '_options' );

	// Header.
	wpbf_customizer_field()
		->id( $archive . '_sortable_header' )
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
		->addToSection( 'wpbf_' . $archive . '_options' );

	// Header.
	wpbf_customizer_field()
		->id( $archive . '_sortable_content' )
		->type( 'sortable' )
		->label( __( 'Content', 'page-builder-framework' ) )
		->defaultValue( array(
			'excerpt',
		) )
		->choices( array(
			'excerpt' => __( 'Excerpt', 'page-builder-framework' ),
			'post'    => __( 'Full Post', 'page-builder-framework' ),
		) )
		->priority( 0 )
		->addToSection( 'wpbf_' . $archive . '_options' );

	// Footer.
	wpbf_customizer_field()
		->id( $archive . '_sortable_footer' )
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
		->addToSection( 'wpbf_' . $archive . '_options' );

	// Separator.
	wpbf_customizer_field()
		->id( $archive . '_separator_2' )
		->type( 'divider' )
		->priority( 0 )
		->addToSection( 'wpbf_' . $archive . '_options' );

	// Layout.
	wpbf_customizer_field()
		->id( $archive . '_layout' )
		->type( 'select' )
		->label( __( 'Layout', 'page-builder-framework' ) )
		->defaultValue( 'default' )
		->choices( apply_filters(
			'wpbf_blog_layouts',
			array(
				'default' => __( 'Default', 'page-builder-framework' ),
				'beside'  => __( 'Image Beside Post', 'page-builder-framework' ),
			)
		) )
		->priority( 10 )
		->addToSection( 'wpbf_' . $archive . '_options' );

	// Style.
	wpbf_customizer_field()
		->id( $archive . '_post_style' )
		->type( 'select' )
		->label( __( 'Style', 'page-builder-framework' ) )
		->defaultValue( 'plain' )
		->choices( [
			'plain' => __( 'Default', 'page-builder-framework' ),
			'boxed' => __( 'Boxed', 'page-builder-framework' ),
		] )
		->priority( 20 )
		->addToSection( 'wpbf_' . $archive . '_options' );

	// Stretch image.
	wpbf_customizer_field()
		->id( $archive . '_boxed_image_streched' )
		->type( 'toggle' )
		->label( __( 'Stretch Featured Image', 'page-builder-framework' ) )
		->defaultValue( false )
		->priority( 20 )
		->activeCallback( [
			array(
				'setting'  => $archive . '_post_style',
				'operator' => '==',
				'value'    => 'boxed',
			),
			array(
				'setting'  => $archive . '_layout',
				'operator' => '!=',
				'value'    => 'beside',
			),
		] )
		->addToSection( 'wpbf_' . $archive . '_options' );

	// Padding.
	wpbf_customizer_field()
		->id( $archive . '_boxed_padding' )
		->type( 'responsive-padding' )
		->label( __( 'Padding', 'page-builder-framework' ) )
		->priority( 25 )
		->activeCallback( [
			array(
				'setting'  => $archive . '_post_style',
				'operator' => '==',
				'value'    => 'boxed',
			),
		] )
		->properties( [
			'save_as_json'   => true,
			'dont_save_unit' => true,
		] )
		->addToSection( 'wpbf_' . $archive . '_options' );

	// Space between.
	wpbf_customizer_field()
		->id( $archive . '_post_space_between' )
		->type( 'slider' )
		->label( __( 'Space Between', 'page-builder-framework' ) )
		->defaultValue( 20 )
		->properties( [
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		] )
		->priority( 30 )
		->addToSection( 'wpbf_' . $archive . '_options' );

	/* All Layouts */

	// Alignment.
	wpbf_customizer_field()
		->id( $archive . '_post_content_alignment' )
		->type( 'radio-image' )
		->label( __( 'Content Alignment', 'page-builder-framework' ) )
		->defaultValue( 'left' )
		->choices( [
			'left'   => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
			'center' => WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
			'right'  => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
		] )
		->priority( 40 )
		->addToSection( 'wpbf_' . $archive . '_options' );

	// Background color.
	wpbf_customizer_field()
		->id( $archive . '_post_background_color' )
		->type( 'color' )
		->label( __( 'Background Color', 'page-builder-framework' ) )
		->defaultValue( '#f5f5f7' )
		->priority( 50 )
		->properties( [
			'mode' => 'alpha',
		] )
		->activeCallback( [
			array(
				'setting'  => $archive . '_post_style',
				'operator' => '==',
				'value'    => 'boxed',
			),
		] )
		->addToSection( 'wpbf_' . $archive . '_options' );

	// Accent color.
	wpbf_customizer_field()
		->id( $archive . '_post_accent_color' )
		->type( 'color' )
		->label( __( 'Accent Color', 'page-builder-framework' ) )
		->priority( 60 )
		->properties( [
			'mode' => 'alpha',
		] )
		->addToSection( 'wpbf_' . $archive . '_options' );

	// Hover.
	wpbf_customizer_field()
		->id( $archive . '_post_accent_color_alt' )
		->type( 'color' )
		->label( __( 'Hover', 'page-builder-framework' ) )
		->priority( 70 )
		->properties( [
			'mode' => 'alpha',
		] )
		->addToSection( 'wpbf_' . $archive . '_options' );

	// Title size.
	wpbf_customizer_field()
		->id( $archive . '_post_title_size' )
		->type( 'input-slider' )
		->label( __( 'Title Font Size', 'page-builder-framework' ) )
		->properties( [
			'min'  => 0,
			'max'  => 50,
			'step' => 1,
		] )
		->priority( 80 )
		->addToSection( 'wpbf_' . $archive . '_options' );

	// Font size.
	wpbf_customizer_field()
		->id( $archive . '_post_font_size' )
		->type( 'input-slider' )
		->label( __( 'Font Size', 'page-builder-framework' ) )
		->properties( [
			'min'  => 0,
			'max'  => 50,
			'step' => 1,
		] )
		->priority( 90 )
		->addToSection( 'wpbf_' . $archive . '_options' );

	/* Beside */

	// Headline.
	wpbf_customizer_field()
		->id( $archive . '_image_beside_post_headline' )
		->type( 'headline' )
		->label( __( 'Image Beside Post Layout Settings', 'page-builder-framework' ) )
		->priority( 100 )
		->activeCallback( [
			array(
				'setting'  => $archive . '_layout',
				'operator' => '==',
				'value'    => 'beside',
			),
		] )
		->addToSection( 'wpbf_' . $archive . '_options' );

	// Image alignment.
	wpbf_customizer_field()
		->id( $archive . '_post_image_alignment' )
		->type( 'radio-image' )
		->label( __( 'Image Alignment', 'page-builder-framework' ) )
		->defaultValue( 'left' )
		->choices( [
			'left'  => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
			'right' => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
		] )
		->priority( 110 )
		->activeCallback( [
			array(
				'setting'  => $archive . '_layout',
				'operator' => '==',
				'value'    => 'beside',
			),
		] )
		->addToSection( 'wpbf_' . $archive . '_options' );

	// Image width.
	wpbf_customizer_field()
		->id( $archive . '_post_image_width' )
		->type( 'slider' )
		->label( __( 'Image Width', 'page-builder-framework' ) )
		->defaultValue( 40 )
		->priority( 120 )
		->properties( [
			'min'  => 20,
			'max'  => 80,
			'step' => 1,
		] )
		->activeCallback( [
			array(
				'setting'  => $archive . '_layout',
				'operator' => '==',
				'value'    => 'beside',
			),
		] )
		->addToSection( 'wpbf_' . $archive . '_options' );

}
