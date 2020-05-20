<?php
/**
 * Theme customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Textdomain. This is required, otherwise strings aren't translateable.
load_theme_textdomain( 'page-builder-framework' );

// Kirki global configuration.
function wpbf_kirki_config( $config ) {
	return wp_parse_args( array(
		'disable_loader' => true,
	), $config );
}
add_filter( 'kirki_config', 'wpbf_kirki_config' );

// Default font choice.
function wpbf_default_font_choices() {
	return array(
		'fonts' => apply_filters( 'wpbf_kirki_font_choices', array() ),
	);
}

// Customizer setup.
function wpbf_customizer_setup( $wp_customize ) {

	// Move sections.
	$wp_customize->get_section( 'title_tagline' )->panel    = 'header_panel';
	$wp_customize->get_section( 'background_image' )->panel = 'layout_panel';

	// Move controls.
	$wp_customize->get_control( 'background_color' )->section = 'background_image';

	// Change section titles.
	$wp_customize->get_section( 'title_tagline' )->title    = __( 'Logo', 'page-builder-framework' );
	$wp_customize->get_section( 'background_image' )->title = __( 'Background', 'page-builder-framework' );

	// Change panel priority.
	$wp_customize->get_panel( 'nav_menus' )->priority = 40;

	// Change section priority.
	$wp_customize->get_section( 'background_image' )->priority = 200;

	// Change setting transport method.
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// Change control priorities.
	$wp_customize->get_control( 'custom_logo' )->priority      = 0;
	$wp_customize->get_control( 'blogname' )->priority         = 9;
	$wp_customize->get_control( 'blogdescription' )->priority  = 19;
	$wp_customize->get_control( 'background_color' )->priority = 100;
	$wp_customize->get_control( 'background_image' )->priority = 0;

	// Partial refresh for custom logo.
	// This is faking a partial refresh to have an edit icon displayed for the logo.
	// A partial refresh isn't possible because the logo & mobile logo are the same by default but can be configured differently.
	// Unfortunately we can't pass multiple arrays with add_partial - this would solve the issue.
	$wp_customize->selective_refresh->add_partial( 'custom_logo', array(
		'selector' => '.wpbf-logo',
	) );

	// Partial refresh for blogname.
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector'        => '.site-title a',
		'render_callback' => function () {
			bloginfo( 'name' );
		},
	) );

	// Partial refresh for blogdescription.
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector'        => '.wpbf-tagline',
		'render_callback' => function () {
			bloginfo( 'description' );
		},
	) );

}
add_action( 'customize_register', 'wpbf_customizer_setup', 20 );

// Kirki configuration.
Kirki::add_config( 'wpbf', array(
	'capability'        => 'edit_theme_options',
	'option_type'       => 'theme_mod',
	'gutenberg_support' => true,
	'disable_output'    => true,
) );

/* Panels */

// Premium Add-On.
if ( ! wpbf_is_premium() ) {

	Kirki::add_section( 'wpbf_premium_addon', array(
		'title'    => __( 'Premium Features available!', 'page-builder-framework' ),
		'priority' => 1,
		'type'     => 'expanded',
	) );

	$wpbf_premium_ad_link = sprintf(
		__( 'Get all features with the <a href="%1s" target="_blank">Premium Add-On</a>!', 'page-builder-framework' ),
		esc_url( 'https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=customizer&utm_campaign=wpbf#premium' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad',
		'section'  => 'wpbf_premium_addon',
		'default'  => $wpbf_premium_ad_link,
		'priority' => 1,
	) );

}

// General.
Kirki::add_panel( 'layout_panel', array(
	'priority' => 2,
	'title'    => __( 'General', 'page-builder-framework' ),
) );

// Blog.
Kirki::add_panel( 'blog_panel', array(
	'priority' => 2,
	'title'    => __( 'Blog', 'page-builder-framework' ),
) );

// Typography.
Kirki::add_panel( 'typo_panel', array(
	'priority' => 3,
	'title'    => __( 'Typography', 'page-builder-framework' ),
) );

// Header.
Kirki::add_panel( 'header_panel', array(
	'priority' => 4,
	'title'    => __( 'Header', 'page-builder-framework' ),
) );

// Footer.
Kirki::add_panel( 'footer_panel', array(
	'priority' => 5,
	'title'    => __( 'Footer', 'page-builder-framework' ),
) );

/* Sections – Typography */

// Title & tagline.
Kirki::add_section( 'wpbf_title_tagline_options', array(
	'title'    => __( 'Site Title / Tagline', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 0,
) );

// Menu.
Kirki::add_section( 'wpbf_menu_font_options', array(
	'title'    => __( 'Menu', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 50,
) );

// Text.
Kirki::add_section( 'wpbf_font_options', array(
	'title'    => __( 'Text', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 100,
) );

// H1.
Kirki::add_section( 'wpbf_h1_options', array(
	'title'    => __( 'H1', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 200,
) );

// H2.
Kirki::add_section( 'wpbf_h2_options', array(
	'title'    => __( 'H2', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 300,
) );

// H3.
Kirki::add_section( 'wpbf_h3_options', array(
	'title'    => __( 'H3', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 400,
) );

// H4.
Kirki::add_section( 'wpbf_h4_options', array(
	'title'    => __( 'H4', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 500,
) );

// H5.
Kirki::add_section( 'wpbf_h5_options', array(
	'title'    => __( 'H5', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 600,
) );

// H6.
Kirki::add_section( 'wpbf_h6_options', array(
	'title'    => __( 'H6', 'page-builder-framework' ),
	'panel'    => 'typo_panel',
	'priority' => 700,
) );

/* Sections – General */

// Site layout.
Kirki::add_section( 'wpbf_page_options', array(
	'title'    => __( 'Layout', 'page-builder-framework' ),
	'panel'    => 'layout_panel',
	'priority' => 100,
) );

// Sidebar.
Kirki::add_section( 'wpbf_sidebar_options', array(
	'title'    => __( 'Sidebar', 'page-builder-framework' ),
	'panel'    => 'layout_panel',
	'priority' => 300,
) );

// 404.
Kirki::add_section( 'wpbf_404_options', array(
	'title'    => __( '404 Page', 'page-builder-framework' ),
	'panel'    => 'layout_panel',
	'priority' => 400,
) );

// Breadcrumbs.
Kirki::add_section( 'wpbf_breadcrumb_settings', array(
	'title'    => __( 'Breadcrumbs', 'page-builder-framework' ),
	'panel'    => 'layout_panel',
	'priority' => 500,
) );

// Buttons.
Kirki::add_section( 'wpbf_button_options', array(
	'title'    => __( 'Theme Buttons', 'page-builder-framework' ),
	'panel'    => 'layout_panel',
	'priority' => 600,
) );

// ScrollTop.
Kirki::add_section( 'wpbf_scrolltop_options', array(
	'title'    => __( 'ScrollTop', 'page-builder-framework' ),
	'panel'    => 'layout_panel',
	'priority' => 700,
) );

/* Sections – Blog */

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

/* Sections – Header */

// Pre header.
Kirki::add_section( 'wpbf_pre_header_options', array(
	'title'    => __( 'Pre Header', 'page-builder-framework' ),
	'panel'    => 'header_panel',
	'priority' => 0,
) );

// Navigation.
Kirki::add_section( 'wpbf_menu_options', array(
	'title'    => __( 'Navigation', 'page-builder-framework' ),
	'panel'    => 'header_panel',
	'priority' => 200,
) );

// Sub menu.
Kirki::add_section( 'wpbf_sub_menu_options', array(
	'title'    => __( 'Sub Menu', 'page-builder-framework' ),
	'panel'    => 'header_panel',
	'priority' => 250,
) );

// Mobile menu.
Kirki::add_section( 'wpbf_mobile_menu_options', array(
	'title'    => __( 'Mobile Navigation', 'page-builder-framework' ),
	'panel'    => 'header_panel',
	'priority' => 300,
) );

/* Sections - Footer */

// Widget footer.
Kirki::add_section( 'wpbf_widget_footer_options', array(
	'title'    => __( 'Widget Areas', 'page-builder-framework' ),
	'panel'    => 'footer_panel',
	'priority' => 100,
) );

// Footer.
Kirki::add_section( 'wpbf_footer_options', array(
	'title'    => __( 'Footer Bar', 'page-builder-framework' ),
	'panel'    => 'footer_panel',
	'priority' => 200,
) );

/* Fields – Breadcrumb Settings */

// Toggle.
Kirki::add_field( 'wpbf', array(
	'type'     => 'toggle',
	'settings' => 'breadcrumbs_toggle',
	'label'    => __( 'Breadcrumbs', 'page-builder-framework' ),
	'section'  => 'wpbf_breadcrumb_settings',
	'default'  => 0,
	'priority' => 1,
) );

// Breadcrumbs.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'breadcrumbs',
	'label'           => __( 'Display Breadcrumbs on', 'page-builder-framework' ),
	'section'         => 'wpbf_breadcrumb_settings',
	'default'         => array( 'archive', 'single' ),
	'priority'        => 2,
	'multiple'        => 6,
	'choices'         => array(
		'front_page' => __( 'Front Page', 'page-builder-framework' ),
		'archive'    => __( 'Archives', 'page-builder-framework' ),
		'single'     => __( 'Single', 'page-builder-framework' ),
		'search'     => __( 'Search Page', 'page-builder-framework' ),
		'404'        => __( '404 Page', 'page-builder-framework' ),
		'page'       => __( 'Pages', 'page-builder-framework' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Position.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'breadcrumbs_position',
	'label'           => __( 'Position', 'page-builder-framework' ),
	'section'         => 'wpbf_breadcrumb_settings',
	'default'         => 'content',
	'priority'        => 2,
	'multiple'        => 1,
	'choices'         => array(
		'content' => __( 'Before Content', 'page-builder-framework' ),
		'header'  => __( 'Below Header', 'page-builder-framework' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'            => 'text',
	'settings'        => 'breadcrumbs_separator',
	'label'           => __( 'Separator', 'page-builder-framework' ),
	'section'         => 'wpbf_breadcrumb_settings',
	'default'         => '/',
	'priority'        => 2,
	'active_callback' => array(
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
	),
	'partial_refresh' => array(
		'breadcrumbsseparator' => array(
			'container_inclusive' => true,
			'selector'            => '.wpbf-breadcrumbs',
			'render_callback'     => function () {
				return wpbf_do_breadcrumbs();
			},
		),
	),
) );

// Alignment.
Kirki::add_field( 'wpbf', array(
	'type'            => 'radio-image',
	'settings'        => 'breadcrumbs_alignment',
	'label'           => __( 'Alignment', 'page-builder-framework' ),
	'section'         => 'wpbf_breadcrumb_settings',
	'default'         => 'left',
	'priority'        => 2,
	'multiple'        => 1,
	'transport'       => 'postMessage',
	'choices'         => array(
		'left'   => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center' => WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'  => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	),
	'active_callback' => array(
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'breadcrumbs_position',
			'operator' => '==',
			'value'    => 'header',
		),
	),
) );

// Background color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'breadcrumbs_background_color',
	'label'           => __( 'Background Color', 'page-builder-framework' ),
	'section'         => 'wpbf_breadcrumb_settings',
	'default'         => '#dedee5;',
	'priority'        => 2,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'breadcrumbs_position',
			'operator' => '==',
			'value'    => 'header',
		),
	),
) );

// Font color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'breadcrumbs_font_color',
	'label'           => __( 'Font Color', 'page-builder-framework' ),
	'section'         => 'wpbf_breadcrumb_settings',
	'priority'        => 2,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Accent color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'breadcrumbs_accent_color',
	'label'           => __( 'Accent Color', 'page-builder-framework' ),
	'section'         => 'wpbf_breadcrumb_settings',
	'priority'        => 2,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Accent color hover.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'breadcrumbs_accent_color_alt',
	'label'           => __( 'Hover', 'page-builder-framework' ),
	'section'         => 'wpbf_breadcrumb_settings',
	'priority'        => 2,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

/* Fields – Blog (General) */

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
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-101053674',
	'section'  => 'wpbf_blog_settings',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 1,
) );

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
	'priority'        => 2,
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

// Categories title.
Kirki::add_field( 'wpbf', array(
	'type'            => 'text',
	'settings'        => 'blog_categories_title',
	'label'           => __( 'Categories Title', 'page-builder-framework' ),
	'section'         => 'wpbf_blog_settings',
	'default'         => 'Filed under:',
	'priority'        => 2,
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

/* Fields - Blog (Pagination) */

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

/* Fields - Blog (Blog Layouts) */

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
	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => $archive . '-separator-74767',
		'section'  => 'wpbf_' . $archive . '_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
		'priority' => 0,
	) );

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
	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => $archive . '-separator-26125',
		'section'  => 'wpbf_' . $archive . '_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
		'priority' => 0,
	) );

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
			'plain' => __( 'Plain', 'page-builder-framework' ),
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

	// Beside headline.
	Kirki::add_field( 'wpbf', array(
		'type'            => 'custom',
		'settings'        => $archive . '-separator-824021',
		'section'         => 'wpbf_' . $archive . '_options',
		'default'         => '<h3 style="padding:15px 10px; background:#fff; margin:0;">' . __( 'Image Beside Post Layout Settings', 'page-builder-framework' ) . '</h3>',
		'priority'        => 100,
		'active_callback' => array(
			array(
				'setting'  => $archive . '_layout',
				'operator' => '==',
				'value'    => 'beside',
			),
		),
	) );

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

/* Fields – Blog (Post Layout) */

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
	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => $single . '-separator-74767',
		'section'  => 'wpbf_' . $single . '_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
		'priority' => 0,
	) );

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

	// Separator.
	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => $single . '-separator-23124507',
		'section'  => 'wpbf_' . $single . '_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
		'priority' => 0,
	) );

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
			'plain' => __( 'Plain', 'page-builder-framework' ),
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
	// 	'type'				=>			'radio-image',
	// 	'settings'			=>			$single . '_post_content_alignment',
	// 	'label'				=>			__( 'Content Alignment', 'page-builder-framework' ),
	// 	'section'			=>			'wpbf_' . $single . '_options',
	// 	'default'			=>			'left',
	// 	'priority'			=>			20,
	// 	'multiple'			=>			1,
	// 	'choices'			=>			array(
	// 		'left'			=>			WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
	// 		'center'		=>			WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
	// 		'right'			=>			WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	// 	),
	// ) );

	// Background color.
	Kirki::add_field( 'wpbf', array(
		'type'            => 'color',
		'settings'        => $single . '_post_background_color',
		'label'           => __( 'Background Color', 'page-builder-framework' ),
		'section'         => 'wpbf_single_options',
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

/* Fields – 404 Page */

// 404 title.
Kirki::add_field( 'wpbf', array(
	'type'      => 'text',
	'label'     => __( 'Title', 'page-builder-framework' ),
	'settings'  => '404_headline',
	'section'   => 'wpbf_404_options',
	'default'   => __( "404 - This page couldn't be found.", "page-builder-framework" ),
	'transport' => 'postMessage',
	'priority'  => 1,
) );

// 404 text.
Kirki::add_field( 'wpbf', array(
	'type'      => 'text',
	'label'     => __( 'Text', 'page-builder-framework' ),
	'settings'  => '404_text',
	'section'   => 'wpbf_404_options',
	'default'   => __( "Oops! We're sorry, this page couldn't be found!", "page-builder-framework" ),
	'transport' => 'postMessage',
	'priority'  => 2,
) );

// Search form.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => '404_search_form',
	'label'           => __( 'Search Form', 'page-builder-framework' ),
	'section'         => 'wpbf_404_options',
	'default'         => 'show',
	'priority'        => 3,
	'multiple'        => 1,
	'partial_refresh' => array(
		'404searchform' => array(
			'container_inclusive' => true,
			'selector'            => '.wpbf-404-content #searchform',
			'render_callback'     => function () {
				return get_search_form();
			},
		),
	),
	'choices'         => array(
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	),
) );

/* Fields – Layout */

// Max width.
Kirki::add_field( 'wpbf', array(
	'type'        => 'dimension',
	'label'       => __( 'Page Width', 'page-builder-framework' ),
	'settings'    => 'page_max_width',
	'section'     => 'wpbf_page_options',
	'transport'   => 'postMessage',
	'description' => __( 'Default: 1200px', 'page-builder-framework' ),
	'priority'    => 1,
) );

// Boxed.
Kirki::add_field( 'wpbf', array(
	'type'     => 'toggle',
	'settings' => 'page_boxed',
	'label'    => __( 'Boxed Layout', 'page-builder-framework' ),
	'section'  => 'wpbf_page_options',
	'default'  => 0,
	'priority' => 2,
) );

// Boxed margin.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'page_boxed_margin',
	'label'           => __( 'Margin', 'page-builder-framework' ),
	'section'         => 'wpbf_page_options',
	'priority'        => 3,
	'default'         => 0,
	'transport'       => 'postMessage',
	'choices'         => array(
		'min'  => 0,
		'max'  => 80,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Boxed padding.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'page_boxed_padding',
	'label'           => __( 'Padding', 'page-builder-framework' ),
	'section'         => 'wpbf_page_options',
	'priority'        => 4,
	'default'         => 20,
	'transport'       => 'postMessage',
	'choices'         => array(
		'min'  => 20,
		'max'  => 100,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Background color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'page_boxed_background',
	'label'           => __( 'Background Color', 'page-builder-framework' ),
	'section'         => 'wpbf_page_options',
	'default'         => '#ffffff',
	'priority'        => 5,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'            => 'custom',
	'settings'        => 'separator-7473363',
	'section'         => 'wpbf_page_options',
	'default'         => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'        => 5,
	'active_callback' => array(
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Box shadow.
Kirki::add_field( 'wpbf', array(
	'type'            => 'toggle',
	'settings'        => 'page_boxed_box_shadow',
	'label'           => __( 'Box Shadow', 'page-builder-framework' ),
	'section'         => 'wpbf_page_options',
	'default'         => 0,
	'priority'        => 6,
	'active_callback' => array(
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Box shadow blur.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'page_boxed_box_shadow_blur',
	'label'           => __( 'Blur', 'page-builder-framework' ),
	'section'         => 'wpbf_page_options',
	'priority'        => 7,
	'default'         => 25,
	'choices'         => array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Box shadow spread.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'page_boxed_box_shadow_spread',
	'label'           => __( 'Spread', 'page-builder-framework' ),
	'section'         => 'wpbf_page_options',
	'priority'        => 8,
	'default'         => 0,
	'choices'         => array(
		'min'  => -100,
		'max'  => 100,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Box shadow horizontal.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'page_boxed_box_shadow_horizontal',
	'label'           => __( 'Horizontal', 'page-builder-framework' ),
	'section'         => 'wpbf_page_options',
	'priority'        => 9,
	'default'         => 0,
	'choices'         => array(
		'min'  => -100,
		'max'  => 100,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Box shadow vertical.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'page_boxed_box_shadow_vertical',
	'label'           => __( 'Vertical', 'page-builder-framework' ),
	'section'         => 'wpbf_page_options',
	'priority'        => 10,
	'default'         => 0,
	'choices'         => array(
		'min'  => -100,
		'max'  => 100,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Box shadow color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'page_boxed_box_shadow_color',
	'label'           => __( 'Color', 'page-builder-framework' ),
	'section'         => 'wpbf_page_options',
	'default'         => 'rgba(0,0,0,.15)',
	'priority'        => 11,
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'page_boxed',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

/* Fields – ScrollTop */

// Scrolltop.
Kirki::add_field( 'wpbf', array(
	'type'        => 'toggle',
	'settings'    => 'layout_scrolltop',
	'label'       => __( 'ScrollTop', 'page-builder-framework' ),
	'description' => __( 'Select if you would like to display a scroll to top arrow', 'page-builder-framework' ),
	'section'     => 'wpbf_scrolltop_options',
	'default'     => '0',
	'priority'    => 1,
) );

// Alignment.
Kirki::add_field( 'wpbf', array(
	'type'            => 'radio-image',
	'settings'        => 'scrolltop_position',
	'label'           => __( 'Alignment', 'page-builder-framework' ),
	'section'         => 'wpbf_scrolltop_options',
	'default'         => 'right',
	'priority'        => 2,
	'multiple'        => 1,
	'transport'       => 'postMessage',
	'choices'         => array(
		'left'  => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'right' => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	),
	'active_callback' => array(
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Show after.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'scrolltop_value',
	'label'           => __( 'Show after (px)', 'page-builder-framework' ),
	'section'         => 'wpbf_scrolltop_options',
	'priority'        => 3,
	'default'         => 400,
	'choices'         => array(
		'min'  => 50,
		'max'  => 1000,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Background color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'scrolltop_bg_color',
	'label'           => __( 'Background Color', 'page-builder-framework' ),
	'section'         => 'wpbf_scrolltop_options',
	'priority'        => 4,
	'transport'       => 'postMessage',
	'default'         => 'rgba(62,67,73,0.5)',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Background color hover.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'scrolltop_bg_color_alt',
	'label'           => __( 'Hover', 'page-builder-framework' ),
	'section'         => 'wpbf_scrolltop_options',
	'priority'        => 5,
	'default'         => 'rgba(62,67,73,0.7)',
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Icon color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'scrolltop_icon_color',
	'label'           => __( 'Icon Color', 'page-builder-framework' ),
	'section'         => 'wpbf_scrolltop_options',
	'priority'        => 6,
	'transport'       => 'postMessage',
	'default'         => '#ffffff',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Icon color hover.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'scrolltop_icon_color_alt',
	'label'           => __( 'Hover', 'page-builder-framework' ),
	'section'         => 'wpbf_scrolltop_options',
	'priority'        => 7,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

// Border radius.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'scrolltop_border_radius',
	'label'           => __( 'Border Radius', 'page-builder-framework' ),
	'section'         => 'wpbf_scrolltop_options',
	'priority'        => 8,
	'default'         => 0,
	'transport'       => 'postMessage',
	'choices'         => array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'layout_scrolltop',
			'operator' => '==',
			'value'    => 1,
		),
	),
) );

/* Fields – Sidebar */

// Postion.
Kirki::add_field( 'wpbf', array(
	'type'     => 'select',
	'settings' => 'sidebar_position',
	'label'    => __( 'Sidebar', 'page-builder-framework' ),
	'section'  => 'wpbf_sidebar_options',
	'default'  => 'right',
	'priority' => 1,
	'multiple' => 1,
	'choices'  => array(
		'right' => __( 'Right', 'page-builder-framework' ),
		'left'  => __( 'Left', 'page-builder-framework' ),
		'none'  => __( 'No Sidebar', 'page-builder-framework' ),
	),
) );

// Gap.
Kirki::add_field( 'wpbf', array(
	'type'     => 'select',
	'settings' => 'sidebar_gap',
	'label'    => __( 'Gap', 'page-builder-framework' ),
	'section'  => 'wpbf_sidebar_options',
	'default'  => 'medium',
	'priority' => 2,
	'multiple' => 1,
	'choices'  => array(
		'divider'  => __( 'Divider', 'page-builder-framework' ),
		'xlarge'   => __( 'xLarge', 'page-builder-framework' ),
		'large'    => __( 'Large', 'page-builder-framework' ),
		'medium'   => __( 'Medium', 'page-builder-framework' ),
		'small'    => __( 'Small', 'page-builder-framework' ),
		'collapse' => __( 'Collapse', 'page-builder-framework' ),
	),
) );

// Width.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'sidebar_width',
	'label'           => __( 'Width', 'page-builder-framework' ),
	'section'         => 'wpbf_sidebar_options',
	'priority'        => 2,
	'default'         => 33.3,
	'transport'       => 'postMessage',
	'choices'         => array(
		'min'  => 20,
		'max'  => 40,
		'step' => .1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'sidebar_position',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-481013',
	'section'  => 'wpbf_sidebar_options',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 2,
) );

// Color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'sidebar_bg_color',
	'label'     => __( 'Background Color', 'page-builder-framework' ),
	'section'   => 'wpbf_sidebar_options',
	'default'   => '#f5f5f7',
	'priority'  => 4,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

/* Fields – Buttons */

// Background color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'button_bg_color',
	'label'     => __( 'Background Color', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Background color alt.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'button_bg_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Text color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'button_text_color',
	'label'     => __( 'Font Color', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Text color alt.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'button_text_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-81461',
	'section'  => 'wpbf_button_options',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 1,
) );

// Primary background color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'button_primary_bg_color',
	'label'     => __( 'Primary Background Color', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Primary background color alt.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'button_primary_bg_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Primary text color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'button_primary_text_color',
	'label'     => __( 'Primary Font Color', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Primary text color alt.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'button_primary_text_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-33757',
	'section'  => 'wpbf_button_options',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 1,
) );

// Border radius.
Kirki::add_field( 'wpbf', array(
	'type'      => 'slider',
	'settings'  => 'button_border_radius',
	'label'     => __( 'Border Radius', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'default'   => 0,
	'transport' => 'postMessage',
	'choices'   => array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	),
) );

// Border width.
Kirki::add_field( 'wpbf', array(
	'type'      => 'slider',
	'settings'  => 'button_border_width',
	'label'     => __( 'Border Width', 'page-builder-framework' ),
	'section'   => 'wpbf_button_options',
	'priority'  => 1,
	'default'   => 0,
	'transport' => 'postMessage',
	'choices'   => array(
		'min'  => 0,
		'max'  => 10,
		'step' => 1,
	),
) );

// Border color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'button_border_color',
	'label'           => __( 'Border Color', 'page-builder-framework' ),
	'section'         => 'wpbf_button_options',
	'priority'        => 1,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	),
) );

// Border color alt.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'button_border_color_alt',
	'label'           => __( 'Hover', 'page-builder-framework' ),
	'section'         => 'wpbf_button_options',
	'priority'        => 1,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	),
) );

// Primary border color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'button_primary_border_color',
	'label'           => __( 'Primary Border Color', 'page-builder-framework' ),
	'section'         => 'wpbf_button_options',
	'priority'        => 1,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	),
) );

// Primary border color alt.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'button_primary_border_color_alt',
	'label'           => __( 'Hover', 'page-builder-framework' ),
	'section'         => 'wpbf_button_options',
	'priority'        => 1,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	),
) );

/* Fields – Typography */

// Text font toggle.
Kirki::add_field( 'wpbf', array(
	'type'     => 'toggle',
	'settings' => 'page_font_toggle',
	'label'    => __( 'Font Settings', 'page-builder-framework' ),
	'section'  => 'wpbf_font_options',
	'default'  => 0,
	'priority' => 0,
) );

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'page_font_family',
	'label'           => __( 'Font', 'page-builder-framework' ),
	'section'         => 'wpbf_font_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => 'regular',
	),
	'choices'         => wpbf_default_font_choices(),
	'active_callback' => array(
		array(
			'setting'  => 'page_font_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
	'priority'        => 1,
) );

// Color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'page_font_color',
	'label'     => __( 'Color', 'page-builder-framework' ),
	'section'   => 'wpbf_font_options',
	'default'   => '#6D7680',
	'priority'  => 2,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Accent color.
Kirki::add_field( 'wpbf', array(
	'type'     => 'color',
	'settings' => 'page_accent_color',
	'label'    => __( 'Accent Color', 'page-builder-framework' ),
	'section'  => 'wpbf_font_options',
	'priority' => 4,
	'default'  => '#3ba9d2',
	'choices'  => array(
		'alpha' => true,
	),
) );

// Accent color alt.
Kirki::add_field( 'wpbf', array(
	'type'     => 'color',
	'settings' => 'page_accent_color_alt',
	'label'    => __( 'Hover', 'page-builder-framework' ),
	'section'  => 'wpbf_font_options',
	'priority' => 4,
	'default'  => '#8ecde5',
	'choices'  => array(
		'alpha' => true,
	),
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_typography_text',
		'section'  => 'wpbf_font_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

// Title font toggle.
Kirki::add_field( 'wpbf', array(
	'type'     => 'toggle',
	'settings' => 'menu_logo_font_toggle',
	'label'    => __( 'Title Font Settings', 'page-builder-framework' ),
	'section'  => 'wpbf_title_tagline_options',
	'default'  => 0,
	'priority' => 0,
) );

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'menu_logo_font_family',
	'label'           => __( 'Font', 'page-builder-framework' ),
	'section'         => 'wpbf_title_tagline_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
		'subsets'     => array( 'latin-ext' ),
	),
	'choices'         => wpbf_default_font_choices(),
	'priority'        => 1,
	'active_callback' => array(
		array(
			'setting'  => 'menu_logo_font_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-602564',
	'section'  => 'wpbf_title_tagline_options',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 2,
) );

// Tagline font toggle.
Kirki::add_field( 'wpbf', array(
	'type'     => 'toggle',
	'settings' => 'menu_logo_description_toggle',
	'label'    => __( 'Tagline Font Settings', 'page-builder-framework' ),
	'section'  => 'wpbf_title_tagline_options',
	'default'  => 0,
	'priority' => 3,
) );

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'menu_logo_description_font_family',
	'label'           => __( 'Font', 'page-builder-framework' ),
	'section'         => 'wpbf_title_tagline_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
		'subsets'     => array( 'latin-ext' ),
	),
	'choices'         => wpbf_default_font_choices(),
	'priority'        => 4,
	'active_callback' => array(
		array(
			'setting'  => 'menu_logo_description_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
) );

// Menu font toggle.
Kirki::add_field( 'wpbf', array(
	'type'     => 'toggle',
	'settings' => 'menu_font_family_toggle',
	'label'    => __( 'Menu Font Settings', 'page-builder-framework' ),
	'section'  => 'wpbf_menu_font_options',
	'default'  => 0,
	'priority' => 0,
) );

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'menu_font_family',
	'label'           => __( 'Font', 'page-builder-framework' ),
	'section'         => 'wpbf_menu_font_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => 'regular',
	),
	'choices'         => wpbf_default_font_choices(),
	'active_callback' => array(
		array(
			'setting'  => 'menu_font_family_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
	'priority'        => 1,
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_typography_menu',
		'section'  => 'wpbf_menu_font_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

// H1 font toggle.
Kirki::add_field( 'wpbf', array(
	'type'        => 'toggle',
	'settings'    => 'page_h1_toggle',
	'label'       => __( 'H1 Settings', 'page-builder-framework' ),
	'section'     => 'wpbf_h1_options',
	'default'     => 0,
	'priority'    => 0,
	'description' => __( "The settings below will apply to all headlines if not configured separately.", "page-builder-framework" ),
) );

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'page_h1_font_family',
	'label'           => __( 'Font', 'page-builder-framework' ),
	'section'         => 'wpbf_h1_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
	),
	'choices'         => wpbf_default_font_choices(),
	'active_callback' => array(
		array(
			'setting'  => 'page_h1_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
	'priority'        => 1,
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_typography_h1',
		'section'  => 'wpbf_h1_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

// H2 font toggle.
Kirki::add_field( 'wpbf', array(
	'type'     => 'toggle',
	'settings' => 'page_h2_toggle',
	'label'    => __( 'H2 Settings', 'page-builder-framework' ),
	'section'  => 'wpbf_h2_options',
	'default'  => 0,
	'priority' => 0,
) );

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'page_h2_font_family',
	'label'           => __( 'Font', 'page-builder-framework' ),
	'section'         => 'wpbf_h2_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
	),
	'choices'         => wpbf_default_font_choices(),
	'active_callback' => array(
		array(
			'setting'  => 'page_h2_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
	'priority'        => 1,
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_typography_h2',
		'section'  => 'wpbf_h2_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

// H3 font toggle.
Kirki::add_field( 'wpbf', array(
	'type'     => 'toggle',
	'settings' => 'page_h3_toggle',
	'label'    => __( 'H3 Settings', 'page-builder-framework' ),
	'section'  => 'wpbf_h3_options',
	'default'  => 0,
	'priority' => 0,
) );

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'page_h3_font_family',
	'label'           => __( 'Font', 'page-builder-framework' ),
	'section'         => 'wpbf_h3_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
	),
	'choices'         => wpbf_default_font_choices(),
	'active_callback' => array(
		array(
			'setting'  => 'page_h3_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
	'priority'        => 1,
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_typography_h3',
		'section'  => 'wpbf_h3_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

// H4 font toggle.
Kirki::add_field( 'wpbf', array(
	'type'     => 'toggle',
	'settings' => 'page_h4_toggle',
	'label'    => __( 'H4 Settings', 'page-builder-framework' ),
	'section'  => 'wpbf_h4_options',
	'default'  => 0,
	'priority' => 0,
) );

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'page_h4_font_family',
	'label'           => __( 'Font', 'page-builder-framework' ),
	'section'         => 'wpbf_h4_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
	),
	'choices'         => wpbf_default_font_choices(),
	'active_callback' => array(
		array(
			'setting'  => 'page_h4_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
	'priority'        => 1,
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_typography_h4',
		'section'  => 'wpbf_h4_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

// H5 font toggle.
Kirki::add_field( 'wpbf', array(
	'type'     => 'toggle',
	'settings' => 'page_h5_toggle',
	'label'    => __( 'H5 Settings', 'page-builder-framework' ),
	'section'  => 'wpbf_h5_options',
	'default'  => 0,
	'priority' => 0,
) );

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'page_h5_font_family',
	'label'           => __( 'Font', 'page-builder-framework' ),
	'section'         => 'wpbf_h5_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
	),
	'choices'         => wpbf_default_font_choices(),
	'active_callback' => array(
		array(
			'setting'  => 'page_h5_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
	'priority'        => 1,
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_typography_h5',
		'section'  => 'wpbf_h5_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

// H6 font toggle.
Kirki::add_field( 'wpbf', array(
	'type'     => 'toggle',
	'settings' => 'page_h6_toggle',
	'label'    => __( 'H6 Settings', 'page-builder-framework' ),
	'section'  => 'wpbf_h6_options',
	'default'  => 0,
	'priority' => 0,
) );

// Font family.
Kirki::add_field( 'wpbf', array(
	'type'            => 'typography',
	'settings'        => 'page_h6_font_family',
	'label'           => __( 'Font', 'page-builder-framework' ),
	'section'         => 'wpbf_h6_options',
	'default'         => array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
	),
	'choices'         => wpbf_default_font_choices(),
	'active_callback' => array(
		array(
			'setting'  => 'page_h6_toggle',
			'operator' => '==',
			'value'    => true,
		),
	),
	'priority'        => 1,
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_typography_h6',
		'section'  => 'wpbf_h6_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

/* Fields – Pre Header */

// Pre header layout.
Kirki::add_field( 'wpbf', array(
	'type'            => 'radio-buttonset',
	'settings'        => 'pre_header_layout',
	'label'           => __( 'Layout', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'default'         => 'none',
	'priority'        => 1,
	'choices'         => array(
		'none' => __( 'None', 'page-builder-framework' ),
		'one'  => __( 'One Column', 'page-builder-framework' ),
		'two'  => __( 'Two Columns', 'page-builder-framework' ),
	),
	'partial_refresh' => array(
		'preheaderlayout' => array(
			'container_inclusive' => true,
			'selector'            => '#pre-header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/pre-header' );
			},
		),
	),
) );

// Column one layout.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'pre_header_column_one_layout',
	'label'           => __( 'Column 1', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'default'         => 'text',
	'priority'        => 2,
	'choices'         => array(
		'none' => __( 'None', 'page-builder-framework' ),
		'text' => __( 'Text', 'page-builder-framework' ),
		'menu' => __( 'Menu', 'page-builder-framework' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
	'partial_refresh' => array(
		'preheadercolumnonelayout' => array(
			'container_inclusive' => true,
			'selector'            => '#pre-header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/pre-header' );
			},
		),
	),
) );

// Column one.
Kirki::add_field( 'wpbf', array(
	'type'            => 'textarea',
	'settings'        => 'pre_header_column_one',
	'label'           => __( 'Text', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'default'         => __( 'Column 1', 'page-builder-framework' ),
	'priority'        => 2,
	'partial_refresh' => array(
		'preheadercolumnonecontent' => array(
			'selector'        => '.wpbf-inner-pre-header-left, .wpbf-inner-pre-header-content',
			'render_callback' => function () {
				return do_shortcode( get_theme_mod( 'pre_header_column_one' ) );
			},
		),
	),
	'active_callback' => array(
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
	),
) );

// Column two layout.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'pre_header_column_two_layout',
	'label'           => __( 'Column 2', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'default'         => 'text',
	'priority'        => 2,
	'choices'         => array(
		'none' => __( 'None', 'page-builder-framework' ),
		'text' => __( 'Text', 'page-builder-framework' ),
		'menu' => __( 'Menu', 'page-builder-framework' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '==',
			'value'    => 'two',
		),
	),
	'partial_refresh' => array(
		'preheadercolumntwolayout' => array(
			'container_inclusive' => true,
			'selector'            => '#pre-header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/pre-header' );
			},
		),
	),
) );

// Column two.
Kirki::add_field( 'wpbf', array(
	'type'            => 'textarea',
	'settings'        => 'pre_header_column_two',
	'label'           => __( 'Text', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'default'         => __( 'Column 2', 'page-builder-framework' ),
	'priority'        => 2,
	'partial_refresh' => array(
		'preheadercolumntwocontent' => array(
			'selector'        => '.wpbf-inner-pre-header-right',
			'render_callback' => function () {
				return do_shortcode( get_theme_mod( 'pre_header_column_two' ) );
			},
		),
	),
	'active_callback' => array(
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
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'            => 'custom',
	'settings'        => 'separator-264356125',
	'section'         => 'wpbf_pre_header_options',
	'default'         => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'        => 3,
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Width.
Kirki::add_field( 'wpbf', array(
	'type'            => 'dimension',
	'label'           => __( 'Pre Header Width', 'page-builder-framework' ),
	'description'     => __( 'Default: 1200px', 'page-builder-framework' ),
	'settings'        => 'pre_header_width',
	'section'         => 'wpbf_pre_header_options',
	'priority'        => 3,
	'transport'       => 'postMessage',
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Height.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'pre_header_height',
	'label'           => __( 'Height', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'priority'        => 3,
	'default'         => 10,
	'transport'       => 'postMessage',
	'choices'         => array(
		'min'  => 1,
		'max'  => 25,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Background color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'pre_header_bg_color',
	'label'           => __( 'Background Color', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'default'         => '#ffffff',
	'priority'        => 4,
	'transport'       => 'postMessage',
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
	'choices'         => array(
		'alpha' => true,
	),
) );

// Font color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'pre_header_font_color',
	'label'           => __( 'Font Color', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'priority'        => 4,
	'transport'       => 'postMessage',
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
	'choices'         => array(
		'alpha' => true,
	),
) );

// Accent color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'pre_header_accent_color',
	'label'           => __( 'Accent Color', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'priority'        => 4,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Accent color alt.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'pre_header_accent_color_alt',
	'label'           => __( 'Hover', 'page-builder-framework' ),
	'section'         => 'wpbf_pre_header_options',
	'priority'        => 4,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Font size.
Kirki::add_field( 'wpbf', array(
	'type'            => 'input_slider',
	'label'           => __( 'Font Size', 'page-builder-framework' ),
	'settings'        => 'pre_header_font_size',
	'section'         => 'wpbf_pre_header_options',
	'priority'        => 4,
	'default'         => '14px',
	'transport'       => 'postMessage',
	'active_callback' => array(
		array(
			'setting'  => 'pre_header_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
	'choices'         => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
) );

/* Fields – Logo */

// Mobile logo.
Kirki::add_field( 'wpbf', array(
	'type'            => 'image',
	'settings'        => 'menu_mobile_logo',
	'label'           => __( 'Mobile Logo', 'page-builder-framework' ),
	'section'         => 'title_tagline',
	'priority'        => 1,
	'partial_refresh' => array(
		'mobilelogo' => array(
			'container_inclusive' => true,
			'selector'            => '.wpbf-mobile-logo',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/logo/logo-mobile' );
			},
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'custom_logo',
			'operator' => '!=',
			'value'    => '',
		),
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-05198',
	'section'  => 'title_tagline',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 4,
) );

// Color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'menu_logo_color',
	'label'           => __( 'Color', 'page-builder-framework' ),
	'section'         => 'title_tagline',
	'priority'        => 11,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
	),
) );

// Hover color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'menu_logo_color_alt',
	'label'           => __( 'Hover', 'page-builder-framework' ),
	'section'         => 'title_tagline',
	'priority'        => 12,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-898067',
	'section'  => 'title_tagline',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 14,
) );

/* Fields – Tagline */

// Toggle.
Kirki::add_field( 'wpbf', array(
	'type'            => 'checkbox',
	'settings'        => 'menu_logo_description',
	'label'           => __( 'Display Tagline', 'page-builder-framework' ),
	'section'         => 'title_tagline',
	'default'         => '0',
	'priority'        => 20,
	'active_callback' => array(
		array(
			'setting'  => 'custom_logo',
			'operator' => '==',
			'value'    => '',
		),
	),
	'partial_refresh' => array(
		'displaytagline' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );

// Mobile toggle.
Kirki::add_field( 'wpbf', array(
	'type'            => 'checkbox',
	'settings'        => 'menu_logo_description_mobile',
	'label'           => __( 'Display Tagline on Mobile', 'page-builder-framework' ),
	'section'         => 'title_tagline',
	'default'         => '0',
	'priority'        => 20,
	'active_callback' => array(
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
	),
	'partial_refresh' => array(
		'displaytaglinemobile' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );

// Color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'menu_logo_description_color',
	'label'           => __( 'Color', 'page-builder-framework' ),
	'section'         => 'title_tagline',
	'priority'        => 22,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
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
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-212074',
	'section'  => 'title_tagline',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 24,
) );

/* Fields – Logo Settings */

// Logo URL.
Kirki::add_field( 'wpbf', array(
	'type'      => 'link',
	'settings'  => 'menu_logo_url',
	'label'     => __( 'Custom Logo URL', 'page-builder-framework' ),
	'section'   => 'title_tagline',
	'transport' => 'postMessage',
	'priority'  => 30,
) );

// Alt tag.
Kirki::add_field( 'wpbf', array(
	'type'            => 'text',
	'settings'        => 'menu_logo_alt',
	'label'           => __( 'Custom "alt" Tag', 'page-builder-framework' ),
	'section'         => 'title_tagline',
	'priority'        => 31,
	'transport'       => 'postMessage',
	'active_callback' => array(
		array(
			'setting'  => 'custom_logo',
			'operator' => '!==',
			'value'    => '',
		),
	),
) );

// Title tag.
Kirki::add_field( 'wpbf', array(
	'type'            => 'text',
	'settings'        => 'menu_logo_title',
	'label'           => __( 'Custom "title" Tag', 'page-builder-framework' ),
	'section'         => 'title_tagline',
	'priority'        => 32,
	'transport'       => 'postMessage',
	'active_callback' => array(
		array(
			'setting'  => 'custom_logo',
			'operator' => '!==',
			'value'    => '',
		),
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-791190',
	'section'  => 'title_tagline',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 33,
) );

/* Fields – Logo Container Width */

// Container width.
Kirki::add_field( 'wpbf', array(
	'type'        => 'slider',
	'settings'    => 'menu_logo_container_width',
	'label'       => __( 'Logo Container Width', 'page-builder-framework' ),
	'description' => __( 'Defines the space in % the logo area takes in the navigation', 'page-builder-framework' ),
	'section'     => 'title_tagline',
	'priority'    => 40,
	'default'     => 25,
	'transport'   => 'postMessage',
	'choices'     => array(
		'min'  => 10,
		'max'  => 40,
		'step' => 1,
	),
) );

// Mobile container width.
Kirki::add_field( 'wpbf', array(
	'type'        => 'slider',
	'settings'    => 'mobile_menu_logo_container_width',
	'label'       => __( 'Logo Container Width (Mobile)', 'page-builder-framework' ),
	'description' => __( 'Defines the space in % the logo area takes in the navigation', 'page-builder-framework' ),
	'section'     => 'title_tagline',
	'priority'    => 41,
	'default'     => 66,
	'transport'   => 'postMessage',
	'choices'     => array(
		'min'  => 10,
		'max'  => 80,
		'step' => 1,
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-44545',
	'section'  => 'title_tagline',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 42,
) );

/* Fields – Navigation */

// Variations.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'menu_position',
	'label'           => __( 'Menu', 'page-builder-framework' ),
	'section'         => 'wpbf_menu_options',
	'default'         => 'menu-right',
	'priority'        => 0,
	'multiple'        => 1,
	'choices'         => apply_filters( 'wpbf_menu_position', array(
		'menu-right'    => __( 'Right (default)', 'page-builder-framework' ),
		'menu-left'     => __( 'Left', 'page-builder-framework' ),
		'menu-centered' => __( 'Centered', 'page-builder-framework' ),
		'menu-stacked'  => __( 'Stacked', 'page-builder-framework' ),
	) ),
	'partial_refresh' => array(
		'headerlayout' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );

// Width.
Kirki::add_field( 'wpbf', array(
	'type'        => 'dimension',
	'label'       => __( 'Navigation Width', 'page-builder-framework' ),
	'description' => __( 'Default: 1200px', 'page-builder-framework' ),
	'settings'    => 'menu_width',
	'section'     => 'wpbf_menu_options',
	'transport'   => 'postMessage',
	'priority'    => 1,
) );

// Search icon.
Kirki::add_field( 'wpbf', array(
	'type'            => 'toggle',
	'settings'        => 'menu_search_icon',
	'label'           => __( 'Search Icon', 'page-builder-framework' ),
	'section'         => 'wpbf_menu_options',
	'priority'        => 2,
	'partial_refresh' => array(
		'menusearchicon' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );

// Height.
Kirki::add_field( 'wpbf', array(
	'type'      => 'slider',
	'label'     => __( 'Menu Height', 'page-builder-framework' ),
	'settings'  => 'menu_height',
	'section'   => 'wpbf_menu_options',
	'priority'  => 3,
	'default'   => 20,
	'transport' => 'postMessage',
	'choices'   => array(
		'min'  => 10,
		'max'  => 80,
		'step' => 1,
	),
) );

// Padding.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'label'           => __( 'Menu Item Spacing', 'page-builder-framework' ),
	'settings'        => 'menu_padding',
	'section'         => 'wpbf_menu_options',
	'priority'        => 4,
	'default'         => 20,
	'transport'       => 'postMessage',
	'choices'         => array(
		'min'  => 5,
		'max'  => 40,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'menu_position',
			'operator' => '!=',
			'value'    => 'menu-off-canvas',
		),
		array(
			'setting'  => 'menu_position',
			'operator' => '!=',
			'value'    => 'menu-off-canvas-left',
		),
	),
) );

// Background color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'menu_bg_color',
	'label'     => __( 'Background Color', 'page-builder-framework' ),
	'section'   => 'wpbf_menu_options',
	'default'   => '#f5f5f7',
	'priority'  => 5,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Font color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'menu_font_color',
	'label'     => __( 'Font Color', 'page-builder-framework' ),
	'section'   => 'wpbf_menu_options',
	'priority'  => 6,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Font color alt.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'menu_font_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_menu_options',
	'priority'  => 7,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Font size.
Kirki::add_field( 'wpbf', array(
	'type'      => 'input_slider',
	'label'     => __( 'Font Size', 'page-builder-framework' ),
	'settings'  => 'menu_font_size',
	'section'   => 'wpbf_menu_options',
	'priority'  => 7,
	'default'   => '16px',
	'transport' => 'postMessage',
	'choices'   => array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	),
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=customizer_navigation_panel&utm_campaign=wpbf#premium" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_header_menu',
		'section'  => 'wpbf_menu_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

/* Fields – Sub Menu */

// Alignment.
Kirki::add_field( 'wpbf', array(
	'type'            => 'radio-image',
	'settings'        => 'sub_menu_alignment',
	'label'           => __( 'Sub Menu Alignment', 'page-builder-framework' ),
	'section'         => 'wpbf_sub_menu_options',
	'default'         => 'left',
	'priority'        => 1,
	'multiple'        => 1,
	'choices'         => array(
		'left'   => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center' => WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'  => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	),
	'partial_refresh' => array(
		'submenualignment' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );

// Width.
Kirki::add_field( 'wpbf', array(
	'type'      => 'slider',
	'settings'  => 'sub_menu_width',
	'label'     => __( 'Width', 'page-builder-framework' ),
	'section'   => 'wpbf_sub_menu_options',
	'priority'  => 1,
	'default'   => 220,
	'transport' => 'postMessage',
	'choices'   => array(
		'min'  => 100,
		'max'  => 400,
		'step' => 1,
	),
) );

// Background color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'sub_menu_bg_color',
	'label'     => __( 'Background Color', 'page-builder-framework' ),
	'section'   => 'wpbf_sub_menu_options',
	'default'   => '#ffffff',
	'transport' => 'postMessage',
	'priority'  => 2,
	'choices'   => array(
		'alpha' => true,
	),
) );

// Background color alt.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'sub_menu_bg_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_sub_menu_options',
	'default'   => '#ffffff',
	'priority'  => 3,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Accent color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'sub_menu_accent_color',
	'label'     => __( 'Font Color', 'page-builder-framework' ),
	'section'   => 'wpbf_sub_menu_options',
	'transport' => 'postMessage',
	'priority'  => 4,
) );

// Accent color alt.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'sub_menu_accent_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_sub_menu_options',
	'priority'  => 5,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Font size.
Kirki::add_field( 'wpbf', array(
	'type'      => 'input_slider',
	'label'     => __( 'Font Size', 'page-builder-framework' ),
	'settings'  => 'sub_menu_font_size',
	'section'   => 'wpbf_sub_menu_options',
	'priority'  => 6,
	'transport' => 'postMessage',
	'choices'   => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
) );

// Separator toggle.
Kirki::add_field( 'wpbf', array(
	'type'     => 'toggle',
	'settings' => 'sub_menu_separator',
	'label'    => __( 'Sub Menu Separator', 'page-builder-framework' ),
	'section'  => 'wpbf_sub_menu_options',
	'default'  => 0,
	'priority' => 6,
) );

// Separator color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'sub_menu_separator_color',
	'label'           => __( 'Color', 'page-builder-framework' ),
	'section'         => 'wpbf_sub_menu_options',
	'default'         => '#f5f5f7',
	'priority'        => 6,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'sub_menu_separator',
			'operator' => '==',
			'value'    => true,
		),
	),
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs/sub-menu/?utm_source=repository&utm_medium=customizer_sub_menu_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_header_sub_menu',
		'section'  => 'wpbf_sub_menu_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

/* Fields – Mobile Navigation */

// Variations.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'mobile_menu_options',
	'label'           => __( 'Menu', 'page-builder-framework' ),
	'section'         => 'wpbf_mobile_menu_options',
	'default'         => 'menu-mobile-hamburger',
	'priority'        => 1,
	'multiple'        => 1,
	'choices'         => apply_filters( 'wpbf_mobile_menu_options', array(
		'menu-mobile-default'   => __( 'Default', 'page-builder-framework' ),
		'menu-mobile-hamburger' => __( 'Hamburger', 'page-builder-framework' ),
	) ),
	'partial_refresh' => array(
		'mobilemenuoptions' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );

// Mobile search icon.
Kirki::add_field( 'wpbf', array(
	'type'            => 'toggle',
	'settings'        => 'mobile_menu_search_icon',
	'label'           => __( 'Search Icon', 'page-builder-framework' ),
	'section'         => 'wpbf_mobile_menu_options',
	'priority'        => 1,
	'active_callback' => array(
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => '!==',
			'value'    => 'menu-mobile-default',
		),
	),
	'partial_refresh' => array(
		'mobilemenusearchicon' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );

// Height.
Kirki::add_field( 'wpbf', array(
	'type'      => 'slider',
	'settings'  => 'mobile_menu_height',
	'label'     => __( 'Height', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_menu_options',
	'priority'  => 2,
	'default'   => 20,
	'transport' => 'postMessage',
	'choices'   => array(
		'min'  => 5,
		'max'  => 80,
		'step' => 1,
	),
) );

// Background color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'mobile_menu_background_color',
	'label'           => __( 'Background Color', 'page-builder-framework' ),
	'section'         => 'wpbf_mobile_menu_options',
	'priority'        => 3,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => '!=',
			'value'    => 'menu-mobile-elementor',
		),
	),
) );

// Icon color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'mobile_menu_hamburger_color',
	'label'           => __( 'Icon Color', 'page-builder-framework' ),
	'section'         => 'wpbf_mobile_menu_options',
	'priority'        => 4,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => 'in',
			'value'    => array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' ),
		),
	),
) );

// Hamburger background color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'mobile_menu_hamburger_bg_color',
	'label'           => __( 'Hamburger Icon Color', 'page-builder-framework' ),
	'section'         => 'wpbf_mobile_menu_options',
	'priority'        => 4,
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => 'in',
			'value'    => array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' ),
		),
	),
) );

// Border radius.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'mobile_menu_hamburger_border_radius',
	'label'           => __( 'Border Radius', 'page-builder-framework' ),
	'section'         => 'wpbf_mobile_menu_options',
	'priority'        => 4,
	'default'         => 0,
	'transport'       => 'postMessage',
	'choices'         => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => 'in',
			'value'    => array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' ),
		),
		array(
			'setting'  => 'mobile_menu_hamburger_bg_color',
			'operator' => '!=',
			'value'    => false,
		),
	),
) );

// Hamburger size.
Kirki::add_field( 'wpbf', array(
	'type'            => 'input_slider',
	'settings'        => 'mobile_menu_hamburger_size',
	'label'           => __( 'Icon Size', 'page-builder-framework' ),
	'section'         => 'wpbf_mobile_menu_options',
	'default'         => '16px',
	'priority'        => 5,
	'transport'       => 'postMessage',
	'choices'         => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'mobile_menu_options',
			'operator' => 'in',
			'value'    => array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' ),
		),
	),
) );

// Menu item settings.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'mobile-menu-item-settings-headline',
	'section'  => 'wpbf_mobile_menu_options',
	'default'  => '<h3 style="padding:15px 10px; background:#fff; margin:0;">' . __( 'Menu Item Settings', 'page-builder-framework' ) . '</h3>',
	'priority' => 6,
) );

// Menu item background color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'mobile_menu_bg_color',
	'label'     => __( 'Background Color', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_menu_options',
	'priority'  => 9,
	'default'   => '#ffffff',
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Menu item background color alt.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'mobile_menu_bg_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_menu_options',
	'priority'  => 10,
	'default'   => '#ffffff',
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Font color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'mobile_menu_font_color',
	'label'     => __( 'Font Color', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_menu_options',
	'transport' => 'postMessage',
	'priority'  => 11,
) );

// Font color hover.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'mobile_menu_font_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_menu_options',
	'priority'  => 12,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Divider color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'mobile_menu_border_color',
	'label'     => __( 'Divider Color', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_menu_options',
	'default'   => '#d9d9e0',
	'priority'  => 13,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Sub menu arrow color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'mobile_menu_submenu_arrow_color',
	'label'     => __( 'Sub Menu Arrow Color', 'page-builder-framework' ),
	'section'   => 'wpbf_mobile_menu_options',
	'priority'  => 14,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Font size.
Kirki::add_field( 'wpbf', array(
	'type'      => 'input_slider',
	'label'     => __( 'Font Size', 'page-builder-framework' ),
	'settings'  => 'mobile_menu_font_size',
	'section'   => 'wpbf_mobile_menu_options',
	'priority'  => 15,
	'default'   => '16px',
	'transport' => 'postMessage',
	'choices'   => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=customizer_mobile_navigation_panel&utm_campaign=wpbf#premium" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_header_mobile_menu',
		'section'  => 'wpbf_mobile_menu_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

/* Fields – Footer */

// Layout.
Kirki::add_field( 'wpbf', array(
	'type'            => 'radio-buttonset',
	'settings'        => 'footer_layout',
	'label'           => __( 'Footer', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
	'default'         => 'two',
	'priority'        => 1,
	'choices'         => array(
		'none' => __( 'None', 'page-builder-framework' ),
		'one'  => __( 'One Column', 'page-builder-framework' ),
		'two'  => __( 'Two Columns', 'page-builder-framework' ),
	),
	'partial_refresh' => array(
		'footerlayout' => array(
			'container_inclusive' => true,
			'selector'            => '#footer',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/footer' );
			},
		),
	),
) );

// Column one layout.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'footer_column_one_layout',
	'label'           => __( 'Column 1', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
	'default'         => 'text',
	'priority'        => 2,
	'choices'         => array(
		'none' => __( 'None', 'page-builder-framework' ),
		'text' => __( 'Text', 'page-builder-framework' ),
		'menu' => __( 'Menu', 'page-builder-framework' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
	'partial_refresh' => array(
		'footercolumnonelayout' => array(
			'container_inclusive' => true,
			'selector'            => '#footer',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/footer' );
			},
		),
	),
) );

// Column one.
Kirki::add_field( 'wpbf', array(
	'type'            => 'textarea',
	'settings'        => 'footer_column_one',
	'label'           => __( 'Text', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
	'default'         => __( '&copy; [year] - [blogname] | All rights reserved', 'page-builder-framework' ),
	'priority'        => 2,
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
		array(
			'setting'  => 'footer_column_one_layout',
			'operator' => '==',
			'value'    => 'text',
		),
	),
	'partial_refresh' => array(
		'footercolumnonecontent' => array(
			'selector'        => '#footer',
			'render_callback' => function () {
				return get_template_part( 'inc/template-parts/footer' );
			},
		),
	),
) );

// Column two layout.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'footer_column_two_layout',
	'label'           => __( 'Column 2', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
	'default'         => 'text',
	'priority'        => 3,
	'choices'         => array(
		'none' => __( 'None', 'page-builder-framework' ),
		'text' => __( 'Text', 'page-builder-framework' ),
		'menu' => __( 'Menu', 'page-builder-framework' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '==',
			'value'    => 'two',
		),
	),
	'partial_refresh' => array(
		'footercolumntwolayout' => array(
			'container_inclusive' => true,
			'selector'            => '#footer',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/footer' );
			},
		),
	),
) );

// Column two.
Kirki::add_field( 'wpbf', array(
	'type'            => 'textarea',
	'settings'        => 'footer_column_two',
	'label'           => __( 'Text', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
	'default'         => __( 'Powered by [theme_author]', 'page-builder-framework' ),
	'priority'        => 3,
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '==',
			'value'    => 'two',
		),
		array(
			'setting'  => 'footer_column_two_layout',
			'operator' => '==',
			'value'    => 'text',
		),
	),
	'partial_refresh' => array(
		'footercolumntwocontent' => array(
			'selector'        => '#footer',
			'render_callback' => function () {
				return get_template_part( 'inc/template-parts/footer' );
			},
		),
	),
) );

// Width.
Kirki::add_field( 'wpbf', array(
	'type'            => 'dimension',
	'label'           => __( 'Footer Width', 'page-builder-framework' ),
	'description'     => __( 'Default: 1200px', 'page-builder-framework' ),
	'settings'        => 'footer_width',
	'section'         => 'wpbf_footer_options',
	'priority'        => 5,
	'transport'       => 'postMessage',
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Footer height.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'footer_height',
	'label'           => __( 'Height', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
	'priority'        => 6,
	'default'         => 20,
	'transport'       => 'postMessage',
	'choices'         => array(
		'min'  => 1,
		'max'  => 100,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Background color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'footer_bg_color',
	'label'           => __( 'Background Color', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
	'default'         => '#f5f5f7',
	'transport'       => 'postMessage',
	'priority'        => 7,
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Font color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'footer_font_color',
	'label'           => __( 'Font Color', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
	'transport'       => 'postMessage',
	'priority'        => 8,
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Accent color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'footer_accent_color',
	'label'           => __( 'Accent Color', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
	'priority'        => 9,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Accent color alt.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'footer_accent_color_alt',
	'label'           => __( 'Hover', 'page-builder-framework' ),
	'section'         => 'wpbf_footer_options',
	'priority'        => 10,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Font size.
Kirki::add_field( 'wpbf', array(
	'type'            => 'input_slider',
	'label'           => __( 'Font Size', 'page-builder-framework' ),
	'settings'        => 'footer_font_size',
	'section'         => 'wpbf_footer_options',
	'priority'        => 11,
	'default'         => '14px',
	'transport'       => 'postMessage',
	'active_callback' => array(
		array(
			'setting'  => 'footer_layout',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
	'choices'         => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
) );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs/advanced-footer-settings/?utm_source=repository&utm_medium=customizer_footer_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_widget_footer',
		'section'  => 'wpbf_widget_footer_options',
		'default'  => $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs/advanced-footer-settings/?utm_source=repository&utm_medium=customizer_footer_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'     => 'custom',
		'settings' => 'wpbf_premium_ad_footer',
		'section'  => 'wpbf_footer_options',
		'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority' => 9999,
	) );

}

/**
 * Custom controls.
 *
 * @param object $wp_customize The wp_customize object.
 */
function wpbf_custom_controls_default( $wp_customize ) {

	// Logo size.
	$wp_customize->add_setting( 'menu_logo_size_desktop',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting( 'menu_logo_size_tablet',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting( 'menu_logo_size_mobile',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control( new WPBF_Customize_Responsive_Input_Slider(
		$wp_customize,
		'menu_logo_size',
		array(
			'label'           => __( 'Logo Width', 'page-builder-framework' ),
			'section'         => 'title_tagline',
			'settings'        => 'menu_logo_size_desktop',
			'priority'        => 2,
			'choices'         => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'active_callback' => function () {return get_theme_mod( 'custom_logo' ) ? true : false;},
		)
	) );

	$wp_customize->add_control( new WPBF_Customize_Responsive_Input_Slider(
		$wp_customize,
		'menu_logo_size',
		array(
			'label'           => __( 'Logo Width', 'page-builder-framework' ),
			'section'         => 'title_tagline',
			'settings'        => 'menu_logo_size_tablet',
			'priority'        => 2,
			'choices'         => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'active_callback' => function () {return get_theme_mod( 'custom_logo' ) ? true : false;},
		)
	) );

	$wp_customize->add_control( new WPBF_Customize_Responsive_Input_Slider(
		$wp_customize,
		'menu_logo_size',
		array(
			'label'           => __( 'Logo Width', 'page-builder-framework' ),
			'section'         => 'title_tagline',
			'settings'        => 'menu_logo_size_mobile',
			'priority'        => 2,
			'choices'         => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'active_callback' => function () {return get_theme_mod( 'custom_logo' ) ? true : false;},
		)
	) );

	// Site title font size.
	$wp_customize->add_setting( 'menu_logo_font_size_desktop',
		array(
			'default'           => '22px',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting( 'menu_logo_font_size_tablet',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting( 'menu_logo_font_size_mobile',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control( new WPBF_Customize_Responsive_Input_Slider(
		$wp_customize,
		'menu_logo_font_size',
		array(
			'label'           => __( 'Font Size', 'page-builder-framework' ),
			'section'         => 'title_tagline',
			'settings'        => 'menu_logo_font_size_desktop',
			'priority'        => 13,
			'choices'         => array(
				'min'  => 0,
				'max'  => 50,
				'step' => 1,
			),
			'active_callback' => function () {return get_theme_mod( 'custom_logo' ) ? false : true;},
		)
	) );

	$wp_customize->add_control( new WPBF_Customize_Responsive_Input_Slider(
		$wp_customize,
		'menu_logo_font_size',
		array(
			'label'           => __( 'Font Size', 'page-builder-framework' ),
			'section'         => 'title_tagline',
			'settings'        => 'menu_logo_font_size_tablet',
			'priority'        => 13,
			'choices'         => array(
				'min'  => 0,
				'max'  => 50,
				'step' => 1,
			),
			'active_callback' => function () {return get_theme_mod( 'custom_logo' ) ? false : true;},
		)
	) );

	$wp_customize->add_control( new WPBF_Customize_Responsive_Input_Slider(
		$wp_customize,
		'menu_logo_font_size',
		array(
			'label'           => __( 'Font Size', 'page-builder-framework' ),
			'section'         => 'title_tagline',
			'settings'        => 'menu_logo_font_size_mobile',
			'priority'        => 13,
			'choices'         => array(
				'min'  => 0,
				'max'  => 50,
				'step' => 1,
			),
			'active_callback' => function () {return get_theme_mod( 'custom_logo' ) ? false : true;},
		)
	) );

	// Tagline font size.
	$wp_customize->add_setting( 'menu_logo_description_font_size_desktop',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting( 'menu_logo_description_font_size_tablet',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting( 'menu_logo_description_font_size_mobile',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control( new WPBF_Customize_Responsive_Input_Slider(
		$wp_customize,
		'menu_logo_description_font_size',
		array(
			'label'           => __( 'Font Size', 'page-builder-framework' ),
			'section'         => 'title_tagline',
			'settings'        => 'menu_logo_description_font_size_desktop',
			'priority'        => 23,
			'choices'         => array(
				'min'  => 0,
				'max'  => 50,
				'step' => 1,
			),
			'active_callback' => function () {return ! get_theme_mod( 'custom_logo' ) && get_theme_mod( 'menu_logo_description' ) ? true : false;},
		)
	) );

	$wp_customize->add_control( new WPBF_Customize_Responsive_Input_Slider(
		$wp_customize,
		'menu_logo_description_font_size',
		array(
			'label'           => __( 'Font Size', 'page-builder-framework' ),
			'section'         => 'title_tagline',
			'settings'        => 'menu_logo_description_font_size_tablet',
			'priority'        => 23,
			'choices'         => array(
				'min'  => 0,
				'max'  => 50,
				'step' => 1,
			),
			'active_callback' => function () {return ! get_theme_mod( 'custom_logo' ) && get_theme_mod( 'menu_logo_description' ) ? true : false;},
		)
	) );

	$wp_customize->add_control( new WPBF_Customize_Responsive_Input_Slider(
		$wp_customize,
		'menu_logo_description_font_size',
		array(
			'label'           => __( 'Font Size', 'page-builder-framework' ),
			'section'         => 'title_tagline',
			'settings'        => 'menu_logo_description_font_size_mobile',
			'priority'        => 23,
			'choices'         => array(
				'min'  => 0,
				'max'  => 50,
				'step' => 1,
			),
			'active_callback' => function () {return ! get_theme_mod( 'custom_logo' ) && get_theme_mod( 'menu_logo_description' ) ? true : false;},
		)
	) );

	// Sub menu padding.
	$wp_customize->add_setting( 'sub_menu_padding_top',
		array(
			'default'           => '10',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting( 'sub_menu_padding_right',
		array(
			'default'           => '20',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting( 'sub_menu_padding_bottom',
		array(
			'default'           => '10',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting( 'sub_menu_padding_left',
		array(
			'default'           => '20',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control( new WPBF_Customize_Padding_Control(
		$wp_customize,
		'sub_menu_padding',
		array(
			'label'    => __( 'Padding', 'page-builder-framework' ),
			'section'  => 'wpbf_sub_menu_options',
			'settings' => 'sub_menu_padding_top',
			'priority' => 2,
		)
	) );

	$wp_customize->add_control( new WPBF_Customize_Padding_Control(
		$wp_customize,
		'sub_menu_padding',
		array(
			'label'    => __( 'Padding', 'page-builder-framework' ),
			'section'  => 'wpbf_sub_menu_options',
			'settings' => 'sub_menu_padding_right',
			'priority' => 2,
		)
	) );

	$wp_customize->add_control( new WPBF_Customize_Padding_Control(
		$wp_customize,
		'sub_menu_padding',
		array(
			'label'    => __( 'Padding', 'page-builder-framework' ),
			'section'  => 'wpbf_sub_menu_options',
			'settings' => 'sub_menu_padding_bottom',
			'priority' => 2,
		)
	) );

	$wp_customize->add_control( new WPBF_Customize_Padding_Control(
		$wp_customize,
		'sub_menu_padding',
		array(
			'label'    => __( 'Padding', 'page-builder-framework' ),
			'section'  => 'wpbf_sub_menu_options',
			'settings' => 'sub_menu_padding_left',
			'priority' => 2,
		)
	) );

	// Mobile menu padding.
	$wp_customize->add_setting( 'mobile_menu_padding_top',
		array(
			'default'           => '10',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting( 'mobile_menu_padding_right',
		array(
			'default'           => '20',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting( 'mobile_menu_padding_bottom',
		array(
			'default'           => '10',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting( 'mobile_menu_padding_left',
		array(
			'default'           => '20',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control( new WPBF_Customize_Padding_Control(
		$wp_customize,
		'mobile_menu_padding',
		array(
			'label'    => __( 'Padding', 'page-builder-framework' ),
			'section'  => 'wpbf_mobile_menu_options',
			'settings' => 'mobile_menu_padding_top',
			'priority' => 8,
		)
	) );

	$wp_customize->add_control( new WPBF_Customize_Padding_Control(
		$wp_customize,
		'mobile_menu_padding',
		array(
			'label'    => __( 'Padding', 'page-builder-framework' ),
			'section'  => 'wpbf_mobile_menu_options',
			'settings' => 'mobile_menu_padding_right',
			'priority' => 8,
		)
	) );

	$wp_customize->add_control( new WPBF_Customize_Padding_Control(
		$wp_customize,
		'mobile_menu_padding',
		array(
			'label'    => __( 'Padding', 'page-builder-framework' ),
			'section'  => 'wpbf_mobile_menu_options',
			'settings' => 'mobile_menu_padding_bottom',
			'priority' => 8,
		)
	) );

	$wp_customize->add_control( new WPBF_Customize_Padding_Control(
		$wp_customize,
		'mobile_menu_padding',
		array(
			'label'    => __( 'Padding', 'page-builder-framework' ),
			'section'  => 'wpbf_mobile_menu_options',
			'settings' => 'mobile_menu_padding_left',
			'priority' => 8,
		)
	) );

	// Responsive sidebar widget padding.
	$responsive_sidebar_padding_settings = array(
		'sidebar_widget_padding_top_desktop', 'sidebar_widget_padding_top_tablet', 'sidebar_widget_padding_top_mobile',
		'sidebar_widget_padding_right_desktop', 'sidebar_widget_padding_right_tablet', 'sidebar_widget_padding_right_mobile',
		'sidebar_widget_padding_bottom_desktop', 'sidebar_widget_padding_bottom_tablet', 'sidebar_widget_padding_bottom_mobile',
		'sidebar_widget_padding_left_desktop', 'sidebar_widget_padding_left_tablet', 'sidebar_widget_padding_left_mobile',
	);

	foreach ( $responsive_sidebar_padding_settings as $responsive_sidebar_padding_setting ) {

		$wp_customize->add_setting( $responsive_sidebar_padding_setting,
			array(
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control( new WPBF_Customize_Responsive_Padding_Control(
			$wp_customize,
			'sidebar_widget_padding',
			array(
				'label'    => __( 'Widget Padding', 'page-builder-framework' ),
				'section'  => 'wpbf_sidebar_options',
				'settings' => $responsive_sidebar_padding_setting,
				'priority' => 3,
			)
		) );

	}

	// Responsive post style settings.
	$archives = apply_filters( 'wpbf_archives', array( 'archive' ) );

	foreach ( $archives as $archive ) {

		$responsive_boxed_style_post_settings = array(
			$archive . '_boxed_padding_top_desktop', $archive . '_boxed_padding_top_tablet', $archive . '_boxed_padding_top_mobile',
			$archive . '_boxed_padding_right_desktop', $archive . '_boxed_padding_right_tablet', $archive . '_boxed_padding_right_mobile',
			$archive . '_boxed_padding_bottom_desktop', $archive . '_boxed_padding_bottom_tablet', $archive . '_boxed_padding_bottom_mobile',
			$archive . '_boxed_padding_left_desktop', $archive . '_boxed_padding_left_tablet', $archive . '_boxed_padding_left_mobile',
		);

		foreach ( $responsive_boxed_style_post_settings as $responsive_boxed_style_post_setting ) {

			$wp_customize->add_setting( $responsive_boxed_style_post_setting,
				array(
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control( new WPBF_Customize_Responsive_Padding_Control(
				$wp_customize,
				$archive . '_boxed_padding',
				array(
					'label'           => __( 'Padding', 'page-builder-framework' ),
					'section'         => 'wpbf_' . $archive . '_options',
					'settings'        => $responsive_boxed_style_post_setting,
					'priority'        => 25,
					'active_callback' => function () use ( $archive ) {return 'boxed' === get_theme_mod( $archive . '_post_style' ) ? true : false;},
				)
			) );

		}

	}

	// Responsive article style settings.
	$singles = apply_filters( 'wpbf_singles', array( 'single' ) );

	foreach ( $singles as $single ) {

		$responsive_article_style_post_settings = array(
			$single . '_boxed_padding_top_desktop', $single . '_boxed_padding_top_tablet', $single . '_boxed_padding_top_mobile',
			$single . '_boxed_padding_right_desktop', $single . '_boxed_padding_right_tablet', $single . '_boxed_padding_right_mobile',
			$single . '_boxed_padding_bottom_desktop', $single . '_boxed_padding_bottom_tablet', $single . '_boxed_padding_bottom_mobile',
			$single . '_boxed_padding_left_desktop', $single . '_boxed_padding_left_tablet', $single . '_boxed_padding_left_mobile',
		);

		foreach ( $responsive_article_style_post_settings as $responsive_article_style_post_setting ) {

			$wp_customize->add_setting( $responsive_article_style_post_setting,
				array(
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control( new WPBF_Customize_Responsive_Padding_Control(
				$wp_customize,
				$single . '_boxed_padding',
				array(
					'label'           => __( 'Padding', 'page-builder-framework' ),
					'section'         => 'wpbf_' . $single . '_options',
					'settings'        => $responsive_article_style_post_setting,
					'priority'        => 10,
					'active_callback' => function () use ( $single ) {return 'boxed' === get_theme_mod( $single . '_post_style' ) ? true : false;},
				)
			) );

		}

	}

}
add_action( 'customize_register', 'wpbf_custom_controls_default' );

// Deprecated hook to load in Premium Add-On customizer settings.
// Will be removed at some point.
do_action( 'wpbf_kirki_premium' );

/**
 * Custom Kirki default fonts.
 *
 * @param array $standard_fonts The standard fonts.
 *
 * @return array The updated standard fonts.
 */
function wpbf_custom_default_fonts( $standard_fonts ) {

	$standard_fonts['helvetica_neue'] = array(
		'label'    => 'Helvetica Neue',
		'variants' => array( 'regular', 'italic', '700', '700italic' ),
		'stack'    => '"Helvetica Neue", Helvetica, Arial, sans-serif',
	);

	$standard_fonts['helvetica'] = array(
		'label'    => 'Helvetica',
		'variants' => array( 'regular', 'italic', '700', '700italic' ),
		'stack'    => 'Helvetica, Arial, sans-serif',
	);

	$standard_fonts['arial'] = array(
		'label'    => 'Arial',
		'variants' => array( 'regular', 'italic', '700', '700italic' ),
		'stack'    => 'Arial, Helvetica, sans-serif',
	);

	return $standard_fonts;

}
add_filter( 'kirki/fonts/standard_fonts', 'wpbf_custom_default_fonts', 0 );
