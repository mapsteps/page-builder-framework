<?php
/**
 * Blog customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Panel */

// Blog.
wpbf_customizer_panel()
	->id( 'blog_panel' )
	->title( __( 'Blog', 'page-builder-framework' ) )
	->priority( 2 )
	->add();

/* Sections */

// General.
wpbf_customizer_section()
	->id( 'wpbf_blog_settings' )
	->title( __( 'General', 'page-builder-framework' ) )
	->priority( 100 )
	->addToPanel( 'blog_panel' );

// Pagination.
wpbf_customizer_section()
	->id( 'wpbf_pagination_settings' )
	->title( __( 'Pagination', 'page-builder-framework' ) )
	->priority( 100 )
	->addToPanel( 'blog_panel' );

// Archive layout.
$archives = apply_filters( 'wpbf_archives', array( 'archive' ) );

foreach ( $archives as $archive ) {

	$panel_title = $archive;

	if ( 'archive' === $panel_title ) {
		$panel_title = __( 'Blog / Archive', 'page-builder-framework' );
	}

	if ( 'search' === $panel_title ) {
		$panel_title = __( 'Search Results', 'page-builder-framework' );
	}

	$section_title = ucwords( str_replace( '-', ' ', $panel_title ) ) . '&nbsp;' . __( 'Layout', 'page-builder-framework' );

	wpbf_customizer_section()
		->id( 'wpbf_' . $archive . '_options' )
		->title( $section_title )
		->priority( 100 )
		->addToPanel( 'blog_panel' );

}

// Post layout.
$singles = apply_filters( 'wpbf_singles', array( 'single' ) );

foreach ( $singles as $single ) {

	$panel_title = $single;

	if ( 'single' === $panel_title ) {
		$panel_title = __( 'Post', 'page-builder-framework' );
	}

	$section_title = ucwords( $panel_title ) . '&nbsp;' . __( 'Layout', 'page-builder-framework' );

	wpbf_customizer_section()
		->id( 'wpbf_' . $single . '_options' )
		->title( $section_title )
		->priority( 200 )
		->addToPanel( 'blog_panel' );

}

/* Fields - General */

// Meta sortable.
wpbf_customizer_field()
	->id( 'blog_sortable_meta' )
	->type( 'sortable' )
	->label( __( 'Meta Data', 'page-builder-framework' ) )
	->defaultValue( array(
		'author',
		'date',
	) )
	->choices( array(
		'author'   => __( 'Author', 'page-builder-framework' ),
		'date'     => __( 'Date', 'page-builder-framework' ),
		'comments' => __( 'Comments', 'page-builder-framework' ),
	) )
	->priority( 1 )
	->partialRefresh( [
		'metasortable' => array(
			'container_inclusive' => true,
			'selector'            => '.article-meta',
			'render_callback'     => function () {
				return wpbf_article_meta();
			},
		),
	] )
	->addToSection( 'wpbf_blog_settings' );

// Separator.
wpbf_customizer_field()
	->id( 'blog_meta_separator' )
	->type( 'text' )
	->label( __( 'Separator', 'page-builder-framework' ) )
	->defaultValue( '|' )
	->priority( 1 )
	->partialRefresh( [
		'metaseparator' => array(
			'container_inclusive' => true,
			'selector'            => '.article-meta',
			'render_callback'     => function () {
				return wpbf_article_meta();
			},
		),
	] )
	->addToSection( 'wpbf_blog_settings' );

// Author avatar.
wpbf_customizer_field()
	->id( 'blog_author_avatar' )
	->type( 'toggle' )
	->label( __( 'Author Avatar', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 1 )
	->activeCallback( [
		array(
			'id'       => 'blog_sortable_meta',
			'operator' => 'in',
			'value'    => 'author',
		),
	] )
	->partialRefresh( [
		'metaavatar' => array(
			'container_inclusive' => true,
			'selector'            => '.article-meta',
			'render_callback'     => function () {
				return wpbf_article_meta();
			},
		),
	] )
	->addToSection( 'wpbf_blog_settings' );

// Separator.
wpbf_customizer_field()
	->id( 'meta_excerpt_separator' )
	->type( 'divider' )
	->priority( 1 )
	->addToSection( 'wpbf_blog_settings' );

// Excerpt length.
wpbf_customizer_field()
	->id( 'excerpt_lenght' )
	->type( 'number' )
	->label( __( 'Excerpt Length', 'page-builder-framework' ) )
	->description( __( 'By default the excerpt length is set to return 55 words.', 'page-builder-framework' ) )
	->defaultValue( 55 )
	->properties( [
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	] )
	->priority( 1 )
	->partialRefresh( [
		'blogexcerpt' => array(
			'selector'        => '.entry-summary',
			'render_callback' => function () {
				return the_excerpt();
			},
		),
	] )
	->addToSection( 'wpbf_blog_settings' );

// Excerpt more.
wpbf_customizer_field()
	->id( 'excerpt_more' )
	->type( 'text' )
	->label( __( 'Excerpt Indicator', 'page-builder-framework' ) )
	->defaultValue( '[...]' )
	->priority( 1 )
	->partialRefresh( [
		'blogexcerptindicator' => array(
			'selector'        => '.entry-summary',
			'render_callback' => function () {
				return the_excerpt();
			},
		),
	] )
	->addToSection( 'wpbf_blog_settings' );

// Separator.
wpbf_customizer_field()
	->id( 'blog_read_more_separator' )
	->type( 'divider' )
	->priority( 1 )
	->addToSection( 'wpbf_blog_settings' );

// Read more button.
wpbf_customizer_field()
	->id( 'blog_read_more_link' )
	->type( 'select' )
	->label( __( 'Read More Link', 'page-builder-framework' ) )
	->defaultValue( 'button' )
	->choices( [
		'text'    => __( 'Text', 'page-builder-framework' ),
		'button'  => __( 'Button', 'page-builder-framework' ),
		'primary' => __( 'Button (Primary)', 'page-builder-framework' ),
	] )
	->priority( 1 )
	->partialRefresh( [
		'blogreadmore' => array(
			'container_inclusive' => true,
			'selector'            => '.article-footer .wpbf-read-more',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/blog/blog-readmore' );
			},
		),
	] )
	->addToSection( 'wpbf_blog_settings' );

// Read more text.
wpbf_customizer_field()
	->id( 'blog_read_more_text' )
	->type( 'text' )
	->label( __( 'Read More Text', 'page-builder-framework' ) )
	->defaultValue( 'Read more' )
	->priority( 1 )
	->partialRefresh( [
		'blogreadmoretext' => array(
			'container_inclusive' => true,
			'selector'            => '.article-footer .wpbf-read-more',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/blog/blog-readmore' );
			},
		),
	] )
	->addToSection( 'wpbf_blog_settings' );

// Separator.
wpbf_customizer_field()
	->id( 'blog_categories_title_separator' )
	->type( 'divider' )
	->priority( 1 )
	->addToSection( 'wpbf_blog_settings' );

// Categories title.
wpbf_customizer_field()
	->id( 'blog_categories_title' )
	->type( 'text' )
	->label( __( 'Categories Title', 'page-builder-framework' ) )
	->defaultValue( 'Filed under:' )
	->priority( 1 )
	->partialRefresh( [
		'catstitle' => array(
			'container_inclusive' => true,
			'selector'            => '.article-footer .footer-categories',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/blog/blog-categories' );
			},
		),
	] )
	->addToSection( 'wpbf_blog_settings' );

/* Fields - Pagination */

// Pagination background color.
wpbf_customizer_field()
	->id( 'blog_pagination_background_color' )
	->type( 'color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_pagination_settings' );

// Pagination background color alt.
wpbf_customizer_field()
	->id( 'blog_pagination_background_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_pagination_settings' );

// Pagination background color active.
wpbf_customizer_field()
	->id( 'blog_pagination_background_color_active' )
	->type( 'color' )
	->label( __( 'Active', 'page-builder-framework' ) )
	->priority( 3 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_pagination_settings' );

// Pagination font color.
wpbf_customizer_field()
	->id( 'blog_pagination_font_color' )
	->type( 'color' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_pagination_settings' );

// Pagination hover color.
wpbf_customizer_field()
	->id( 'blog_pagination_font_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 5 )
	->transport( 'postMessage' )
	->defaultValue( '' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_pagination_settings' );

// Pagination active color.
wpbf_customizer_field()
	->id( 'blog_pagination_font_color_active' )
	->type( 'color' )
	->label( __( 'Active', 'page-builder-framework' ) )
	->priority( 6 )
	->transport( 'postMessage' )
	->defaultValue( '' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_pagination_settings' );

// Border radius.
wpbf_customizer_field()
	->id( 'blog_pagination_border_radius' )
	->type( 'slider' )
	->label( __( 'Border Radius', 'page-builder-framework' ) )
	->defaultValue( 0 )
	->priority( 7 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	] )
	->addToSection( 'wpbf_pagination_settings' );

// Pagination font size.
wpbf_customizer_field()
	->id( 'blog_pagination_font_size' )
	->type( 'input-slider' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->priority( 8 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	] )
	->addToSection( 'wpbf_pagination_settings' );

/* Fields - Blog Layouts */

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
				'id'       => $archive . '_post_style',
				'operator' => '==',
				'value'    => 'boxed',
			),
			array(
				'id'       => $archive . '_layout',
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
				'id'       => $archive . '_post_style',
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
				'id'       => $archive . '_post_style',
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
				'id'       => $archive . '_layout',
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
				'id'       => $archive . '_layout',
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
				'id'       => $archive . '_layout',
				'operator' => '==',
				'value'    => 'beside',
			),
		] )
		->addToSection( 'wpbf_' . $archive . '_options' );

}

/* Fields - Post Layout */

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
				'id'       => $single . '_post_style',
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
				'id'       => $single . '_post_style',
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
				'id'       => $single . '_post_style',
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
