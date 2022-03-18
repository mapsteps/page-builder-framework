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
Kirki::add_panel( 'blog_panel', array(
	'priority' => 2,
	'title'    => __( 'Blog', 'page-builder-framework' ),
) );

/* Sections */

// General.
Kirki::add_section( 'wpbf_blog_settings', array(
	'title'    => __( 'General', 'page-builder-framework' ),
	'panel'    => 'blog_panel',
	'priority' => 100,
) );

// Pagination.
Kirki::add_section( 'wpbf_pagination_settings', array(
	'title'    => __( 'Pagination', 'page-builder-framework' ),
	'panel'    => 'blog_panel',
	'priority' => 100,
) );

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

	Kirki::add_section( 'wpbf_' . $archive . '_options', array(
		'title'    => ucwords( str_replace( '-', ' ', $panel_title ) ) . '&nbsp;' . __( 'Layout', 'page-builder-framework' ),
		'panel'    => 'blog_panel',
		'priority' => 100,
	) );

}

// Post layout.
$singles = apply_filters( 'wpbf_singles', array( 'single' ) );

foreach ( $singles as $single ) {

	$panel_title = $single;

	if ( 'single' === $panel_title ) {
		$panel_title = __( 'Post', 'page-builder-framework' );
	}

	Kirki::add_section( 'wpbf_' . $single . '_options', array(
		'title'    => ucwords( $panel_title ) . '&nbsp;' . __( 'Layout', 'page-builder-framework' ),
		'panel'    => 'blog_panel',
		'priority' => 200,
	) );

}

/* Fields - General */

// Meta sortable.
Kirki::add_field( 'wpbf', array(
	'type'            => 'sortable',
	'settings'        => 'blog_sortable_meta',
	'label'           => __( 'Meta Data', 'page-builder-framework' ),
	'section'         => 'wpbf_blog_settings',
	'default'         => array(
		'author',
		'date',
	),
	'partial_refresh' => array(
		'metasortable' => array(
			'container_inclusive' => true,
			'selector'            => '.article-meta',
			'render_callback'     => function () {
				return wpbf_article_meta();
			},
		),
	),
	'choices'         => array(
		'author'   => __( 'Author', 'page-builder-framework' ),
		'date'     => __( 'Date', 'page-builder-framework' ),
		'comments' => __( 'Comments', 'page-builder-framework' ),
	),
	'priority'        => 1,
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'            => 'text',
	'settings'        => 'blog_meta_separator',
	'label'           => __( 'Separator', 'page-builder-framework' ),
	'section'         => 'wpbf_blog_settings',
	'priority'        => 1,
	'default'         => '|',
	'partial_refresh' => array(
		'metaseparator' => array(
			'container_inclusive' => true,
			'selector'            => '.article-meta',
			'render_callback'     => function () {
				return wpbf_article_meta();
			},
		),
	),
) );

// Author avatar.
Kirki::add_field( 'wpbf', array(
	'type'            => 'toggle',
	'settings'        => 'blog_author_avatar',
	'label'           => __( 'Author Avatar', 'page-builder-framework' ),
	'section'         => 'wpbf_blog_settings',
	'priority'        => 1,
	'active_callback' => array(
		array(
			'setting'  => 'blog_sortable_meta',
			'operator' => 'in',
			'value'    => 'author',
		),
	),
	'partial_refresh' => array(
		'metaavatar' => array(
			'container_inclusive' => true,
			'selector'            => '.article-meta',
			'render_callback'     => function () {
				return wpbf_article_meta();
			},
		),
	),
) );

// Separator.
new \Kirki\Pro\Field\Divider(
	[
		'settings' => 'meta_excerpt_separator',
		'section'  => 'wpbf_blog_settings',
		'priority' => 1,
	]
);

// Excerpt length.
Kirki::add_field( 'wpbf', array(
	'type'            => 'number',
	'settings'        => 'excerpt_lenght',
	'label'           => __( 'Excerpt Length', 'page-builder-framework' ),
	'description'     => __( 'By default the excerpt length is set to return 55 words.', 'page-builder-framework' ),
	'default'         => '55',
	'section'         => 'wpbf_blog_settings',
	'priority'        => 1,
	'choices'         => array(
		'min'  => '0',
		'max'  => '100',
		'step' => '1',
	),
	'partial_refresh' => array(
		'blogexcerpt' => array(
			'selector'        => '.entry-summary',
			'render_callback' => function () {
				return the_excerpt();
			},
		),
	),
) );

// Excerpt more.
Kirki::add_field( 'wpbf', array(
	'type'            => 'text',
	'settings'        => 'excerpt_more',
	'label'           => __( 'Excerpt Indicator', 'page-builder-framework' ),
	'section'         => 'wpbf_blog_settings',
	'default'         => '[...]',
	'priority'        => 1,
	'partial_refresh' => array(
		'blogexcerptindicator' => array(
			'selector'        => '.entry-summary',
			'render_callback' => function () {
				return the_excerpt();
			},
		),
	),
) );

// Separator.
new \Kirki\Pro\Field\Divider(
	[
		'settings' => 'blog_read_more_separator',
		'section'  => 'wpbf_blog_settings',
		'priority' => 1,
	]
);

// Read more button.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'blog_read_more_link',
	'label'           => __( 'Read More Link', 'page-builder-framework' ),
	'section'         => 'wpbf_blog_settings',
	'default'         => 'button',
	'priority'        => 1,
	'multiple'        => 1,
	'choices'         => array(
		'text'    => __( 'Text', 'page-builder-framework' ),
		'button'  => __( 'Button', 'page-builder-framework' ),
		'primary' => __( 'Button (Primary)', 'page-builder-framework' ),
	),
	'partial_refresh' => array(
		'blogreadmore' => array(
			'container_inclusive' => true,
			'selector'            => '.article-footer .wpbf-read-more',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/blog/blog-readmore' );
			},
		),
	),
) );

// Read more text.
Kirki::add_field( 'wpbf', array(
	'type'            => 'text',
	'settings'        => 'blog_read_more_text',
	'label'           => __( 'Read More Text', 'page-builder-framework' ),
	'section'         => 'wpbf_blog_settings',
	'default'         => 'Read more',
	'priority'        => 1,
	'partial_refresh' => array(
		'blogreadmoretext' => array(
			'container_inclusive' => true,
			'selector'            => '.article-footer .wpbf-read-more',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/blog/blog-readmore' );
			},
		),
	),
) );

// Separator.
new \Kirki\Pro\Field\Divider(
	[
		'settings' => 'blog_categories_title_separator',
		'section'  => 'wpbf_blog_settings',
		'priority' => 1,
	]
);

// Categories title.
Kirki::add_field( 'wpbf', array(
	'type'            => 'text',
	'settings'        => 'blog_categories_title',
	'label'           => __( 'Categories Title', 'page-builder-framework' ),
	'section'         => 'wpbf_blog_settings',
	'default'         => 'Filed under:',
	'priority'        => 1,
	'partial_refresh' => array(
		'catstitle' => array(
			'container_inclusive' => true,
			'selector'            => '.article-footer .footer-categories',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/blog/blog-categories' );
			},
		),
	),
) );

/* Fields - Pagination */

// Pagination background color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'blog_pagination_background_color',
	'label'     => __( 'Background Color', 'page-builder-framework' ),
	'section'   => 'wpbf_pagination_settings',
	'transport' => 'postMessage',
	'priority'  => 1,
	'choices'   => array(
		'alpha' => true,
	),
) );

// Pagination background color alt.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'blog_pagination_background_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_pagination_settings',
	'priority'  => 2,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Pagination background color active.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'blog_pagination_background_color_active',
	'label'     => __( 'Active', 'page-builder-framework' ),
	'section'   => 'wpbf_pagination_settings',
	'transport' => 'postMessage',
	'priority'  => 3,
	'choices'   => array(
		'alpha' => true,
	),
) );

// Pagination font color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'blog_pagination_font_color',
	'label'     => __( 'Font Color', 'page-builder-framework' ),
	'section'   => 'wpbf_pagination_settings',
	'transport' => 'postMessage',
	'priority'  => 4,
	'choices'   => array(
		'alpha' => true,
	),
) );

// Pagination hover color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'blog_pagination_font_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_pagination_settings',
	'default'   => '',
	'priority'  => 5,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Pagination active color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'blog_pagination_font_color_active',
	'label'     => __( 'Active', 'page-builder-framework' ),
	'section'   => 'wpbf_pagination_settings',
	'transport' => 'postMessage',
	'default'   => '',
	'priority'  => 6,
	'choices'   => array(
		'alpha' => true,
	),
) );

// Border radius.
Kirki::add_field( 'wpbf', array(
	'type'      => 'slider',
	'settings'  => 'blog_pagination_border_radius',
	'label'     => __( 'Border Radius', 'page-builder-framework' ),
	'section'   => 'wpbf_pagination_settings',
	'priority'  => 7,
	'default'   => 0,
	'transport' => 'postMessage',
	'choices'   => array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	),
) );

// Pagination font size.
Kirki::add_field( 'wpbf', array(
	'type'      => 'input_slider',
	'label'     => __( 'Font Size', 'page-builder-framework' ),
	'settings'  => 'blog_pagination_font_size',
	'section'   => 'wpbf_pagination_settings',
	'transport' => 'postMessage',
	'priority'  => 8,
	'choices'   => array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	),
) );

/* Fields - Blog Layouts */

foreach ( $archives as $archive ) {

	// Width.
	Kirki::add_field( 'wpbf', array(
		'type'        => 'dimension',
		'label'       => __( 'Custom Content Width', 'page-builder-framework' ),
		'settings'    => $archive . '_custom_width',
		'section'     => 'wpbf_' . $archive . '_options',
		'description' => __( 'Default: 1200px', 'page-builder-framework' ),
		'priority'    => 0,
	) );

	if ( 'blog' !== $archive && 'search' !== $archive ) {

		// Headline.
		Kirki::add_field( 'wpbf', array(
			'type'     => 'select',
			'settings' => $archive . '_headline',
			'label'    => ucwords( str_replace( '-', ' ', $archive ) ) . '&nbsp;' . __( 'Headline', 'page-builder-framework' ),
			'section'  => 'wpbf_' . $archive . '_options',
			'default'  => 'show',
			'priority' => 0,
			'multiple' => 1,
			'choices'  => array(
				'show'        => __( 'Show', 'page-builder-framework' ),
				'hide'        => __( 'Hide', 'page-builder-framework' ),
				'hide_prefix' => __( 'Remove Prefix', 'page-builder-framework' ),
			),
		) );

	}

	// Sidebar layout.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'select',
		'settings' => $archive . '_sidebar_layout',
		'label'    => __( 'Sidebar', 'page-builder-framework' ),
		'section'  => 'wpbf_' . $archive . '_options',
		'default'  => 'global',
		'priority' => 0,
		'multiple' => 1,
		'choices'  => array(
			'global' => __( 'Inherit Global Settings', 'page-builder-framework' ),
			'right'  => __( 'Right', 'page-builder-framework' ),
			'left'   => __( 'Left', 'page-builder-framework' ),
			'none'   => __( 'No Sidebar', 'page-builder-framework' ),
		),
	) );

	// Separator.
	new \Kirki\Pro\Field\Divider(
		[
			'settings' => $archive . '_separator_1',
			'section'  => 'wpbf_' . $archive . '_options',
			'priority' => 0,
		]
	);

	// Header.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'sortable',
		'settings' => $archive . '_sortable_header',
		'label'    => __( 'Header', 'page-builder-framework' ),
		'section'  => 'wpbf_' . $archive . '_options',
		'default'  => array(
			'title',
			'meta',
			'featured',
		),
		'choices'  => array(
			'title'    => __( 'Title', 'page-builder-framework' ),
			'meta'     => __( 'Meta Data', 'page-builder-framework' ),
			'featured' => __( 'Featured Image', 'page-builder-framework' ),
		),
		'priority' => 0,
	) );

	// Header.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'sortable',
		'settings' => $archive . '_sortable_content',
		'label'    => __( 'Content', 'page-builder-framework' ),
		'section'  => 'wpbf_' . $archive . '_options',
		'default'  => array(
			'excerpt',
		),
		'choices'  => array(
			'excerpt' => __( 'Excerpt', 'page-builder-framework' ),
			'post'    => __( 'Full Post', 'page-builder-framework' ),
		),
		'priority' => 0,
	) );

	// Footer.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'sortable',
		'settings' => $archive . '_sortable_footer',
		'label'    => __( 'Footer', 'page-builder-framework' ),
		'section'  => 'wpbf_' . $archive . '_options',
		'default'  => array(
			'readmore',
			'categories',
		),
		'choices'  => array(
			'readmore'   => __( 'Read More', 'page-builder-framework' ),
			'categories' => __( 'Categories', 'page-builder-framework' ),
			'tags'       => __( 'Tags', 'page-builder-framework' ),
		),
		'priority' => 0,
	) );

	// Separator.
	new \Kirki\Pro\Field\Divider(
		[
			'settings' => $archive . '_separator_2',
			'section'  => 'wpbf_' . $archive . '_options',
			'priority' => 0,
		]
	);

	// Layout.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'select',
		'settings' => $archive . '_layout',
		'label'    => __( 'Layout', 'page-builder-framework' ),
		'section'  => 'wpbf_' . $archive . '_options',
		'default'  => 'default',
		'priority' => 10,
		'multiple' => 1,
		'choices'  => apply_filters( 'wpbf_blog_layouts', array(
			'default' => __( 'Default', 'page-builder-framework' ),
			'beside'  => __( 'Image Beside Post', 'page-builder-framework' ),
		) ),
	) );

	// Style.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'select',
		'settings' => $archive . '_post_style',
		'label'    => __( 'Style', 'page-builder-framework' ),
		'section'  => 'wpbf_' . $archive . '_options',
		'default'  => 'plain',
		'priority' => 20,
		'multiple' => 1,
		'choices'  => array(
			'plain' => __( 'Default', 'page-builder-framework' ),
			'boxed' => __( 'Boxed', 'page-builder-framework' ),
		),
	) );

	// Stretch image.
	Kirki::add_field( 'wpbf', array(
		'type'            => 'toggle',
		'settings'        => $archive . '_boxed_image_streched',
		'label'           => __( 'Stretch Featured Image', 'page-builder-framework' ),
		'section'         => 'wpbf_' . $archive . '_options',
		'default'         => 0,
		'priority'        => 20,
		'active_callback' => array(
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
		),
	) );

	// Padding.
	Kirki::add_field( 'wpbf', array(
		'type'              => 'responsive_padding',
		'label'             => __( 'Padding', 'page-builder-framework' ),
		'section'           => 'wpbf_' . $archive . '_options',
		'settings'          => $archive . '_boxed_padding',
		'priority'          => 25,
		'active_callback'   => array(
			array(
				'setting'  => $archive . '_post_style',
				'operator' => '==',
				'value'    => 'boxed',
			),
		),
		'sanitize_callback' => wpbf_kirki_sanitize_helper( 'wpbf_is_numeric_sanitization_helper' ),
	) );

	// Space between.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'slider',
		'label'    => __( 'Space Between', 'page-builder-framework' ),
		'settings' => $archive . '_post_space_between',
		'section'  => 'wpbf_' . $archive . '_options',
		'priority' => 30,
		'default'  => 20,
		'choices'  => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		),
	) );

	/* All Layouts */

	// Alignment.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'radio-image',
		'settings' => $archive . '_post_content_alignment',
		'label'    => __( 'Content Alignment', 'page-builder-framework' ),
		'section'  => 'wpbf_' . $archive . '_options',
		'default'  => 'left',
		'priority' => 40,
		'multiple' => 1,
		'choices'  => array(
			'left'   => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
			'center' => WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
			'right'  => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
		),
	) );

	// Background color.
	Kirki::add_field( 'wpbf', array(
		'type'            => 'color',
		'settings'        => $archive . '_post_background_color',
		'label'           => __( 'Background Color', 'page-builder-framework' ),
		'section'         => 'wpbf_' . $archive . '_options',
		'default'         => '#f5f5f7',
		'priority'        => 50,
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => $archive . '_post_style',
				'operator' => '==',
				'value'    => 'boxed',
			),
		),
	) );

	// Accent color.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'color',
		'settings' => $archive . '_post_accent_color',
		'label'    => __( 'Accent Color', 'page-builder-framework' ),
		'section'  => 'wpbf_' . $archive . '_options',
		'priority' => 60,
		'choices'  => array(
			'alpha' => true,
		),
	) );

	// Hover.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'color',
		'settings' => $archive . '_post_accent_color_alt',
		'label'    => __( 'Hover', 'page-builder-framework' ),
		'section'  => 'wpbf_' . $archive . '_options',
		'priority' => 70,
		'choices'  => array(
			'alpha' => true,
		),
	) );

	// Title size.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'input_slider',
		'label'    => __( 'Title Font Size', 'page-builder-framework' ),
		'settings' => $archive . '_post_title_size',
		'section'  => 'wpbf_' . $archive . '_options',
		'priority' => 80,
		'choices'  => array(
			'min'  => 0,
			'max'  => 50,
			'step' => 1,
		),
	) );

	// Font size.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'input_slider',
		'label'    => __( 'Font Size', 'page-builder-framework' ),
		'settings' => $archive . '_post_font_size',
		'section'  => 'wpbf_' . $archive . '_options',
		'priority' => 90,
		'choices'  => array(
			'min'  => 0,
			'max'  => 50,
			'step' => 1,
		),
	) );

	/* Beside */

	// Headline.
	new \Kirki\Pro\Field\Headline(
		[
			'settings'        => $archive . '_image_beside_post_headline',
			'label'           => esc_html__( 'Image Beside Post Layout Settings', 'page-builder-framework' ),
			'section'         => 'wpbf_' . $archive . '_options',
			'priority'        => 100,
			'active_callback' => [
				[
					'setting'  => $archive . '_layout',
					'operator' => '==',
					'value'    => 'beside',
				],
			],
		]
	);

	// Image alignment.
	Kirki::add_field( 'wpbf', array(
		'type'            => 'radio-image',
		'settings'        => $archive . '_post_image_alignment',
		'label'           => __( 'Image Alignment', 'page-builder-framework' ),
		'section'         => 'wpbf_' . $archive . '_options',
		'default'         => 'left',
		'priority'        => 110,
		'multiple'        => 1,
		'choices'         => array(
			'left'  => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
			'right' => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
		),
		'active_callback' => array(
			array(
				'setting'  => $archive . '_layout',
				'operator' => '==',
				'value'    => 'beside',
			),
		),
	) );

	// Image width.
	Kirki::add_field( 'wpbf', array(
		'type'            => 'slider',
		'settings'        => $archive . '_post_image_width',
		'label'           => __( 'Image Width', 'page-builder-framework' ),
		'section'         => 'wpbf_' . $archive . '_options',
		'priority'        => 120,
		'default'         => 40,
		'choices'         => array(
			'min'  => 20,
			'max'  => 80,
			'step' => 1,
		),
		'active_callback' => array(
			array(
				'setting'  => $archive . '_layout',
				'operator' => '==',
				'value'    => 'beside',
			),
		),
	) );

}

/* Fields - Post Layout */

foreach ( $singles as $single ) {

	// Width.
	Kirki::add_field( 'wpbf', array(
		'type'        => 'dimension',
		'label'       => __( 'Custom Content Width', 'page-builder-framework' ),
		'settings'    => $single . '_custom_width',
		'section'     => 'wpbf_' . $single . '_options',
		'description' => __( 'Default: 1200px', 'page-builder-framework' ),
		'priority'    => 0,
	) );

	// Sidebar layout.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'select',
		'settings' => $single . '_sidebar_layout',
		'label'    => __( 'Sidebar', 'page-builder-framework' ),
		'section'  => 'wpbf_' . $single . '_options',
		'default'  => 'global',
		'priority' => 0,
		'multiple' => 1,
		'choices'  => array(
			'global' => __( 'Inherit Global Settings', 'page-builder-framework' ),
			'right'  => __( 'Right', 'page-builder-framework' ),
			'left'   => __( 'Left', 'page-builder-framework' ),
			'none'   => __( 'No Sidebar', 'page-builder-framework' ),
		),
	) );

	// Separator.
	new \Kirki\Pro\Field\Divider(
		[
			'settings' => $single . '_separator_1',
			'section'  => 'wpbf_' . $single . '_options',
			'priority' => 0,
		]
	);

	// Header.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'sortable',
		'settings' => $single . '_sortable_header',
		'label'    => __( 'Header', 'page-builder-framework' ),
		'section'  => 'wpbf_' . $single . '_options',
		'default'  => array(
			'title',
			'meta',
			'featured',
		),
		'choices'  => array(
			'title'    => __( 'Title', 'page-builder-framework' ),
			'meta'     => __( 'Meta Data', 'page-builder-framework' ),
			'featured' => __( 'Featured Image', 'page-builder-framework' ),
		),
		'priority' => 0,
	) );

	// Footer.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'sortable',
		'settings' => $single . '_sortable_footer',
		'label'    => __( 'Footer', 'page-builder-framework' ),
		'section'  => 'wpbf_' . $single . '_options',
		'default'  => array(
			'readmore',
			'categories',
		),
		'choices'  => array(
			'readmore'   => __( 'Read More', 'page-builder-framework' ),
			'categories' => __( 'Categories', 'page-builder-framework' ),
			'tags'       => __( 'Tags', 'page-builder-framework' ),
		),
		'priority' => 0,
	) );

	if ( 'single' === $single ) {

		// Separator.
		new \Kirki\Pro\Field\Divider(
			[
				'settings' => $single . '_separator_comments',
				'section'  => 'wpbf_' . $single . '_options',
				'priority' => 0,
			]
		);

		// Toggle.
		Kirki::add_field( 'wpbf', array(
			'type'     => 'toggle',
			'label'    => __( 'Disable Comments', 'page-builder-framework' ),
			'settings' => $single . '_disable_comments',
			'section'  => 'wpbf_' . $single . '_options',
			'priority' => 0,
			'default'  => 0,
		) );

	}

	// Separator.
	new \Kirki\Pro\Field\Divider(
		[
			'settings' => $single . '_separator_2',
			'section'  => 'wpbf_' . $single . '_options',
			'priority' => 0,
		]
	);

	// Post navigation.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'select',
		'settings' => $single . '_post_nav',
		'label'    => __( 'Post Navigation', 'page-builder-framework' ),
		'section'  => 'wpbf_' . $single . '_options',
		'default'  => 'show',
		'priority' => 0,
		'multiple' => 1,
		'choices'  => array(
			'show'    => __( 'Previous/Next Post', 'page-builder-framework' ),
			'default' => __( 'Post Title', 'page-builder-framework' ),
			'hide'    => __( 'Hide', 'page-builder-framework' ),
		),
	) );

	// Style.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'select',
		'settings' => $single . '_post_style',
		'label'    => __( 'Style', 'page-builder-framework' ),
		'section'  => 'wpbf_' . $single . '_options',
		'default'  => 'plain',
		'priority' => 0,
		'multiple' => 1,
		'choices'  => array(
			'plain' => __( 'Default', 'page-builder-framework' ),
			'boxed' => __( 'Boxed', 'page-builder-framework' ),
		),
	) );

	// Stretch image.
	Kirki::add_field( 'wpbf', array(
		'type'            => 'toggle',
		'settings'        => $single . '_boxed_image_stretched',
		'label'           => __( 'Stretch Featured Image', 'page-builder-framework' ),
		'section'         => 'wpbf_' . $single . '_options',
		'default'         => 0,
		'priority'        => 0,
		'active_callback' => array(
			array(
				'setting'  => $single . '_post_style',
				'operator' => '==',
				'value'    => 'boxed',
			),
		),
	) );

	// Alignment
	// Kirki::add_field( 'wpbf', array(
	//  'type'              =>          'radio-image',
	//  'settings'          =>          $single . '_post_content_alignment',
	//  'label'             =>          __( 'Content Alignment', 'page-builder-framework' ),
	//  'section'           =>          'wpbf_' . $single . '_options',
	//  'default'           =>          'left',
	//  'priority'          =>          20,
	//  'multiple'          =>          1,
	//  'choices'           =>          array(
	//      'left'          =>          WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
	//      'center'        =>          WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
	//      'right'         =>          WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	//  ),
	// ) );

	// Padding.
	Kirki::add_field( 'wpbf', array(
		'type'              => 'responsive_padding',
		'label'             => __( 'Padding', 'page-builder-framework' ),
		'section'           => 'wpbf_' . $single . '_options',
		'settings'          => $single . '_boxed_padding',
		'priority'          => 10,
		'active_callback'   => array(
			array(
				'setting'  => $single . '_post_style',
				'operator' => '==',
				'value'    => 'boxed',
			),
		),
		'sanitize_callback' => wpbf_kirki_sanitize_helper( 'wpbf_is_numeric_sanitization_helper' ),
	) );

	// Background color.
	Kirki::add_field( 'wpbf', array(
		'type'            => 'color',
		'settings'        => $single . '_post_background_color',
		'label'           => __( 'Background Color', 'page-builder-framework' ),
		'section'         => 'wpbf_' . $single . '_options',
		'default'         => '#f5f5f7',
		'priority'        => 20,
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => $single . '_post_style',
				'operator' => '==',
				'value'    => 'boxed',
			),
		),
	) );

	// Title size.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'input_slider',
		'label'    => __( 'Title Font Size', 'page-builder-framework' ),
		'settings' => $single . '_post_title_size',
		'section'  => 'wpbf_' . $single . '_options',
		'priority' => 20,
		'choices'  => array(
			'min'  => 0,
			'max'  => 50,
			'step' => 1,
		),
	) );

	// Font size.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'input_slider',
		'label'    => __( 'Font Size', 'page-builder-framework' ),
		'settings' => $single . '_post_font_size',
		'section'  => 'wpbf_' . $single . '_options',
		'priority' => 20,
		'choices'  => array(
			'min'  => 0,
			'max'  => 50,
			'step' => 1,
		),
	) );

}
