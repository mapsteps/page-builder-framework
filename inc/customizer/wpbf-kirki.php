<?php
/**
 * kirki
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Textdomain
 *
 * Required. Otherwise, strings cannot be translated.
 */
load_theme_textdomain( 'page-builder-framework', get_template_directory() . '/languages' );

// Default Font Choice
function wpbf_default_font_choices(){
	return array(
		'fonts' => apply_filters( 'wpbf_kirki_font_choices', array() )
	);
}

/**
 * Setup
 */
function wpbf_customizer_setup( $wp_customize ) {

	// move sections
	$wp_customize->get_section( 'title_tagline' )-> panel ='header_panel';
	$wp_customize->get_section( 'background_image' )-> panel ='layout_panel';

	// move controls
	$wp_customize->get_control( 'background_color' )->section = 'background_image';

	// change section title
	$wp_customize->get_section( 'title_tagline' )->title = esc_attr__( 'Logo', 'page-builder-framework' );
	$wp_customize->get_section( 'background_image' )->title = esc_attr__( 'Background', 'page-builder-framework' );

	// change panel priority
	$wp_customize->get_panel( 'nav_menus' )->priority = 40;

	// change section priority
	$wp_customize->get_section( 'background_image' )->priority = 200;

	// change control priority
	$wp_customize->get_control( 'custom_logo' )->priority = 0;
	$wp_customize->get_control( 'blogname' )->priority = 9;
	$wp_customize->get_control( 'blogdescription' )->priority = 19;

}
add_action( 'customize_register' , 'wpbf_customizer_setup', 20 );

/* kirki Configuration */
Kirki::add_config( 'wpbf', array(
	'capability'        => 'edit_theme_options',
	'option_type'       => 'theme_mod',
	'gutenberg_support' => true,
	'disable_output'    => true
) );

/* Panels */
if( !wpbf_is_premium() ) {

	// Premium Addon
	Kirki::add_section( 'wpbf_premium_addon', array(
		'title'			=>		esc_attr__( 'Premium Features available!', 'page-builder-framework' ),
		'priority'		=>		1,
		'type'			=>		'expanded'
	) );

	$wpbf_premium_ad_link = sprintf(
		/* translators: 1: link target */
		__( 'Get all features with the <a href="%1s" target="_blank">Premium Add-On</a>!', 'page-builder-framework' ),
		esc_url( 'https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=customizer&utm_campaign=wpbf#premium' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'			=>		'custom',
		'settings'		=>		'wpbf_premium_ad',
		'section'		=>		'wpbf_premium_addon',
		'default'		=>		$wpbf_premium_ad_link,
		'priority'		=>		1,
	) );

}

// General
Kirki::add_panel( 'layout_panel', array(
	'priority'			=>		2,
	'title'				=>		esc_attr__( 'General', 'page-builder-framework' ),
) );

// Blog
Kirki::add_panel( 'blog_panel', array(
	'priority'			=>		2,
	'title'				=>		esc_attr__( 'Blog', 'page-builder-framework' ),
) );

// Typography
Kirki::add_panel( 'typo_panel', array(
	'priority'			=>		3,
	'title'				=>		esc_attr__( 'Typography', 'page-builder-framework' ),
) );

// Header
Kirki::add_panel( 'header_panel', array(
	'priority'			=>		4,
	'title'				=>		esc_attr__( 'Header', 'page-builder-framework' ),
) );

// Footer
Kirki::add_section( 'wpbf_footer_options', array(
	'title'				=>		esc_attr__( 'Footer', 'page-builder-framework' ),
	'priority'			=>		5,
) );

/* Sections – Typography */

// Title / Tagline
Kirki::add_section( 'wpbf_title_tagline_options', array(
	'title'				=>			esc_attr__( 'Site Title / Tagline', 'page-builder-framework' ),
	'panel'				=>			'typo_panel',
	'priority'			=>			0,
) );

// Text
Kirki::add_section( 'wpbf_font_options', array(
	'title'				=>			esc_attr__( 'Text', 'page-builder-framework' ),
	'panel'				=>			'typo_panel',
	'priority'			=>			50,
) );

// Menu
Kirki::add_section( 'wpbf_menu_font_options', array(
	'title'				=>			esc_attr__( 'Menu', 'page-builder-framework' ),
	'panel'				=>			'typo_panel',
	'priority'			=>			100,
) );

// H1
Kirki::add_section( 'wpbf_h1_options', array(
	'title'				=>			esc_attr__( 'H1', 'page-builder-framework' ),
	'panel'				=>			'typo_panel',
	'priority'			=>			200,
) );

// H2
Kirki::add_section( 'wpbf_h2_options', array(
	'title'				=>			esc_attr__( 'H2', 'page-builder-framework' ),
	'panel'				=>			'typo_panel',
	'priority'			=>			300,
) );

// H3
Kirki::add_section( 'wpbf_h3_options', array(
	'title'				=>			esc_attr__( 'H3', 'page-builder-framework' ),
	'panel'				=>			'typo_panel',
	'priority'			=>			400,
) );

// H4
Kirki::add_section( 'wpbf_h4_options', array(
	'title'				=>			esc_attr__( 'H4', 'page-builder-framework' ),
	'panel'				=>			'typo_panel',
	'priority'			=>			500,
) );

// H5
Kirki::add_section( 'wpbf_h5_options', array(
	'title'				=>			esc_attr__( 'H5', 'page-builder-framework' ),
	'panel'				=>			'typo_panel',
	'priority'			=>			600,
) );

// H6
Kirki::add_section( 'wpbf_h6_options', array(
	'title'				=>			esc_attr__( 'H6', 'page-builder-framework' ),
	'panel'				=>			'typo_panel',
	'priority'			=>			700,
) );

/* Sections – General */

// Site Layout
Kirki::add_section( 'wpbf_page_options', array(
	'title'				=>			esc_attr__( 'Layout', 'page-builder-framework' ),
	'panel'				=>			'layout_panel',
	'priority'			=>			100,
) );

// Accent Color
Kirki::add_section( 'wpbf_accent_options', array(
	'title'				=>			esc_attr__( 'Accent Color', 'page-builder-framework' ),
	'panel'				=>			'layout_panel',
	'priority'			=>			200,
) );

// Buttons
Kirki::add_section( 'wpbf_button_options', array(
	'title'				=>			esc_attr__( 'Theme Buttons', 'page-builder-framework' ),
	'panel'				=>			'layout_panel',
	'priority'			=>			300,
) );

// Sidebar
Kirki::add_section( 'wpbf_sidebar_options', array(
	'title'				=>			esc_attr__( 'Sidebar', 'page-builder-framework' ),
	'panel'				=>			'layout_panel',
	'priority'			=>			400,
) );

// Breadcrumbs
Kirki::add_section( 'wpbf_breadcrumb_settings', array(
	'title'				=>			esc_attr__( 'Breadcrumbs', 'page-builder-framework' ),
	'panel'				=>			'layout_panel',
	'priority'			=>			600,
) );

// 404
Kirki::add_section( 'wpbf_404_options', array(
	'title'				=>			esc_attr__( '404 Page', 'page-builder-framework' ),
	'panel'				=>			'layout_panel',
	'priority'			=>			700,
) );

/* Sections – Blog */

// General
Kirki::add_section( 'wpbf_blog_settings', array(
	'title'				=>			esc_attr__( 'General', 'page-builder-framework' ),
	'panel'				=>			'blog_panel',
	'priority'			=>			100,
) );

// Pagination
Kirki::add_section( 'wpbf_pagination_settings', array(
	'title'				=>			esc_attr__( 'Pagination', 'page-builder-framework' ),
	'panel'				=>			'blog_panel',
	'priority'			=>			100,
) );

// Archive Layout
$archives = apply_filters( 'wpbf_archives', array( 'archive' ) );

foreach ( $archives as $archive ) {

	$checkbox_title = $archive;

	if( $checkbox_title == 'archive' ) {
		$checkbox_title = __( 'Blog / Archive', 'page-builder-framework' );
	}

	if( $checkbox_title == 'search' ) {
		$checkbox_title = __( 'Search Results', 'page-builder-framework' );
	}

	Kirki::add_section( 'wpbf_' . $archive . '_options', array(
		'title'				=>			ucwords( str_replace( '-', ' ', $checkbox_title ) ) . '&nbsp;' . esc_attr__( 'Layout', 'page-builder-framework' ),
		'panel'				=>			'blog_panel',
		'priority'			=>			100,
	) );

}

// Post Layout
Kirki::add_section( 'wpbf_single_options', array(
	'title'				=>			esc_attr__( 'Post Layout', 'page-builder-framework' ),
	'panel'				=>			'blog_panel',
	'priority'			=>			100,
) );

/* Sections – Header */

// Navigation
Kirki::add_section( 'wpbf_menu_options', array(
	'title'				=>			esc_attr__( 'Navigation', 'page-builder-framework' ),
	'panel'				=>			'header_panel',
	'priority'			=>			200,
) );

// Sub Menu
Kirki::add_section( 'wpbf_sub_menu_options', array(
	'title'				=>			esc_attr__( 'Sub Menu', 'page-builder-framework' ),
	'panel'				=>			'header_panel',
	'priority'			=>			600,
) );

// Mobile Menu
Kirki::add_section( 'wpbf_mobile_menu_options', array(
	'title'				=>			esc_attr__( 'Mobile Navigation', 'page-builder-framework' ),
	'panel'				=>			'header_panel',
	'priority'			=>			700,
) );

// Pre Header
Kirki::add_section( 'wpbf_pre_header_options', array(
	'title'				=>			esc_attr__( 'Pre Header', 'page-builder-framework' ),
	'panel'				=>			'header_panel',
	'priority'			=>			800,
) );

/* Fields – Breadcrumb Settings */

// Activate
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'breadcrumbs_toggle',
	'label'				=>			esc_attr__( 'Breadcrumbs', 'page-builder-framework' ),
	'section'			=>			'wpbf_breadcrumb_settings',
	'default'			=>			0,
	'priority'			=>			1,
) );

// Breadcrumbs
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'breadcrumbs',
	'label'				=>			esc_attr__( 'Display Breadcrumbs on', 'page-builder-framework' ),
	'section'			=>			'wpbf_breadcrumb_settings',
	'default'			=>			array( 'archive', 'single' ),
	'priority'			=>			2,
	'multiple'			=>			6,
	'choices'			=>			array(
		'front_page'	=>			esc_attr__( 'Front Page', 'page-builder-framework' ),
		'archive'		=>			esc_attr__( 'Archives', 'page-builder-framework' ),
		'single'		=>			esc_attr__( 'Single', 'page-builder-framework' ),
		'search'		=>			esc_attr__( 'Search Page', 'page-builder-framework' ),
		'404'			=>			esc_attr__( '404 Page', 'page-builder-framework' ),
		'page'			=>			esc_attr__( 'Pages', 'page-builder-framework' ),
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'breadcrumbs_toggle',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	),
) );

// Position
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'breadcrumbs_position',
	'label'				=>			esc_attr__( 'Position', 'page-builder-framework' ),
	'section'			=>			'wpbf_breadcrumb_settings',
	'default'			=>			'content',
	'priority'			=>			2,
	'multiple'			=>			1,
	'choices'			=>			array(
		'content'		=>			esc_attr__( 'Before Content', 'page-builder-framework' ),
		'header'		=>			esc_attr__( 'Below Header', 'page-builder-framework' ),
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'breadcrumbs_toggle',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	),
) );

// Alignment
Kirki::add_field( 'wpbf', array(
	'type'				=>			'radio-image',
	'settings'			=>			'breadcrumbs_alignment',
	'label'				=>			esc_attr__( 'Alignment', 'page-builder-framework' ),
	'section'			=>			'wpbf_breadcrumb_settings',
	'default'			=>			'left',
	'priority'			=>			2,
	'multiple'			=>			1,
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'left'			=>			WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center'		=>			WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'			=>			WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'breadcrumbs_toggle',
		'operator'		=>			'==',
		'value'			=>			1,
		),
		array(
		'setting'		=>			'breadcrumbs_position',
		'operator'		=>			'==',
		'value'			=>			'header',
		),
	),
) );

// Background Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'breadcrumbs_background_color',
	'label'				=>			esc_attr__( 'Background Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_breadcrumb_settings',
	'default'			=>			'#dedee5;',
	'priority'			=>			2,
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'breadcrumbs_toggle',
		'operator'		=>			'==',
		'value'			=>			1,
		),
		array(
		'setting'		=>			'breadcrumbs_position',
		'operator'		=>			'==',
		'value'			=>			'header',
		),
	),
) );

// Font Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'breadcrumbs_font_color',
	'label'				=>			esc_attr__( 'Font Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_breadcrumb_settings',
	'priority'			=>			2,
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'breadcrumbs_toggle',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	),
) );

// Accent Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'breadcrumbs_accent_color',
	'label'				=>			esc_attr__( 'Accent Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_breadcrumb_settings',
	'priority'			=>			2,
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'breadcrumbs_toggle',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	),
) );

// Accent Color Hover
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'breadcrumbs_accent_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_breadcrumb_settings',
	'priority'			=>			2,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'breadcrumbs_toggle',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	),
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'text',
	'settings'			=>			'breadcrumbs_separator',
	'label'				=>			esc_attr__( 'Separator', 'page-builder-framework' ),
	'section'			=>			'wpbf_breadcrumb_settings',
	'default'			=>			'/',
	'priority'			=>			2,
	'active_callback'	=>			array(
		array(
		'setting'		=>			'breadcrumbs_toggle',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	),
) );

/* Fields – Blog */

// Meta Sortable
Kirki::add_field( 'wpbf', array(
	'type'				=>			'sortable',
	'settings'			=>			'blog_sortable_meta',
	'label'				=>			esc_attr__( 'Meta Data', 'page-builder-framework' ),
	'section'			=>			'wpbf_blog_settings',
	'default'			=>			array(
		'author',
		'date',
	),
	'choices'			=> array(
		'author'		=>			esc_attr__( 'Author', 'page-builder-framework' ),
		'date'			=>			esc_attr__( 'Date', 'page-builder-framework' ),
		'comments'		=>			esc_attr__( 'Comments', 'page-builder-framework' ),
	),
	'priority'			=>			1,
) );

// Alt Tag
Kirki::add_field( 'wpbf', array(
	'type'				=>			'text',
	'settings'			=>			'blog_meta_separator',
	'label'				=>			esc_attr__( 'Separator', 'page-builder-framework' ),
	'section'			=>			'wpbf_blog_settings',
	'priority'			=>			1,
	'default'			=>			'|',
) );

// Alt Tag
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'blog_author_avatar',
	'label'				=>			esc_attr__( 'Author Avatar', 'page-builder-framework' ),
	'section'			=>			'wpbf_blog_settings',
	'priority'			=>			1,
	'active_callback'	=>			array(
		array(
		'setting'		=>			'blog_sortable_meta',
		'operator'		=>			'in',
		'value'			=>			'author',
		),
	),
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-101053674',
	'section'			=>			'wpbf_blog_settings',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			1,
) );

// Excerpt Length
Kirki::add_field( 'wpbf', array(
	'type'				=>			'number',
	'settings'			=>			'excerpt_lenght',
	'label'				=>			esc_attr__( 'Excerpt Length', 'page-builder-framework' ),
	'description'		=>			esc_attr__( 'By default the excerpt length is set to return 55 words.', 'page-builder-framework' ),
	'default'			=>			'55',
	'section'			=>			'wpbf_blog_settings',
	'priority'			=>			1,
	'choices'			=>			array(
		'min'			=>			'0',
		'max'			=>			'100',
		'step'			=>			'1',
	),
) );

// Read More Button
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'blog_read_more_link',
	'label'				=>			esc_attr__( 'Read More Link', 'page-builder-framework' ),
	'section'			=>			'wpbf_blog_settings',
	'default'			=>			'button',
	'priority'			=>			1,
	'multiple'			=>			1,
	'choices'			=>			array(
		'text'			=>			esc_attr__( 'Text', 'page-builder-framework' ),
		'button'		=>			esc_attr__( 'Button', 'page-builder-framework' ),
		'primary'		=>			esc_attr__( 'Button (Primary)', 'page-builder-framework' ),
	),
) );

// Read More Text
Kirki::add_field( 'wpbf', array(
	'type'				=>			'text',
	'settings'			=>			'blog_read_more_text',
	'label'				=>			esc_attr__( 'Read More Text', 'page-builder-framework' ),
	'section'			=>			'wpbf_blog_settings',
	'default'			=>			'Read more',
	'priority'			=>			2,
) );

// Categories Title
Kirki::add_field( 'wpbf', array(
	'type'				=>			'text',
	'settings'			=>			'blog_categories_title',
	'label'				=>			esc_attr__( 'Categories Title', 'page-builder-framework' ),
	'section'			=>			'wpbf_blog_settings',
	'default'			=>			'Filed under:',
	'priority'			=>			2,
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-23124507',
	'section'			=>			'wpbf_blog_settings',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			2,
) );

// Border Radius
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'blog_pagination_border_radius',
	'label'				=>			esc_attr__( 'Border Radius', 'page-builder-framework' ),
	'section'			=>			'wpbf_pagination_settings',
	'priority'			=>			2,
	'default'			=>			'0',
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'min'			=>			'0',
		'max'			=>			'100',
		'step'			=>			'1',
	),
) );

// Pagination Background Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'blog_pagination_background_color',
	'label'				=>			esc_attr__( 'Background Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_pagination_settings',
	'transport'			=>			'postMessage',
	'priority'			=>			2,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Pagination Background Color Alt
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'blog_pagination_background_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_pagination_settings',
	'priority'			=>			2,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Pagination Background Color Active
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'blog_pagination_background_color_active',
	'label'				=>			esc_attr__( 'Active', 'page-builder-framework' ),
	'section'			=>			'wpbf_pagination_settings',
	'transport'			=>			'postMessage',
	'priority'			=>			2,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Pagination Font Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'blog_pagination_font_color',
	'label'				=>			esc_attr__( 'Font Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_pagination_settings',
	'transport'			=>			'postMessage',
	'priority'			=>			2,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Pagination Hover Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'blog_pagination_font_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_pagination_settings',
	'default'			=>			'',
	'priority'			=>			2,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Pagination Active Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'blog_pagination_font_color_active',
	'label'				=>			esc_attr__( 'Active', 'page-builder-framework' ),
	'section'			=>			'wpbf_pagination_settings',
	'transport'			=>			'postMessage',
	'default'			=>			'',
	'priority'			=>			2,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Pagination Font Size
Kirki::add_field( 'wpbf', array(
	'type'				=>			'input_slider',
	'label'				=>			esc_attr__( 'Font Size', 'page-builder-framework' ),
	'settings'			=>			'blog_pagination_font_size',
	'section'			=>			'wpbf_pagination_settings',
	'transport'			=>			'postMessage',
	'priority'			=>			2,
	'choices'			=>			array(
		'min'			=>			'0',
		'max'			=>			'100',
		'step'			=>			'1',
	),
) );

foreach ( $archives as $archive ) {

	// Width
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'dimension',
		'label'				=>			esc_attr__( 'Custom Content Width', 'page-builder-framework' ),
		'settings'			=>			$archive . '_custom_width',
		'section'			=>			'wpbf_' . $archive . '_options',
		'description'		=>			esc_attr__( 'Default: 1200px', 'page-builder-framework' ), 
		'priority'			=>			0
	) );

	if( $archive !== 'blog' && $archive !== 'search' ) {

	// Headline
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'select',
		'settings'			=>			$archive .'_headline',
		'label'				=>			ucwords( str_replace( '-', ' ', $archive ) ) . '&nbsp;' . esc_attr__( 'Headline', 'page-builder-framework' ),
		'section'			=>			'wpbf_'. $archive .'_options',
		'default'			=>			'show',
		'priority'			=>			0,
		'multiple'			=>			1,
		'choices'			=>			array(
			'show'			=>			esc_attr__( 'Show', 'page-builder-framework' ),
			'hide'			=>			esc_attr__( 'Hide', 'page-builder-framework' ),
			'hide_prefix'	=>			esc_attr__( 'Remove Prefix', 'page-builder-framework' ),
		),
	) );

	}

	// Sidebar Layout
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'select',
		'settings'			=>			$archive . '_sidebar_layout',
		'label'				=>			__( 'Sidebar', 'page-builder-framework' ),
		'section'			=>			'wpbf_'. $archive . '_options',
		'default'			=>			'global',
		'priority'			=>			0,
		'multiple'			=>			1,
		'choices'			=>			array(
			'global'		=>			esc_attr__( 'Inherit Global Settings', 'page-builder-framework' ),
			'right'			=>			esc_attr__( 'Right', 'page-builder-framework' ),
			'left'			=>			esc_attr__( 'Left', 'page-builder-framework' ),
			'none'			=>			esc_attr__( 'No Sidebar', 'page-builder-framework' ),
		),
	) );

	// Separator
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'custom',
		'settings'			=>			$archive . '-separator-74767',
		'section'			=>			'wpbf_' . $archive . '_options',
		'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
		'priority'			=>			0,
	) );

	// Header
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'sortable',
		'settings'			=>			$archive . '_sortable_header',
		'label'				=>			esc_attr__( 'Header', 'page-builder-framework' ),
		'section'			=>			'wpbf_' . $archive . '_options',
		'default'			=>			array(
			'title',
			'meta',
			'featured'
		),
		'choices'			=> array(
			'title'			=>			esc_attr__( 'Title', 'page-builder-framework' ),
			'meta'			=>			esc_attr__( 'Meta Data', 'page-builder-framework' ),
			'featured'		=>			esc_attr__( 'Featured Image', 'page-builder-framework' ),
		),
		'priority'			=>			0,
	) );

	// Footer
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'sortable',
		'settings'			=>			$archive . '_sortable_footer',
		'label'				=>			esc_attr__( 'Footer', 'page-builder-framework' ),
		'section'			=>			'wpbf_' . $archive . '_options',
		'default'			=>			array(
			'readmore',
			'categories',
		),
		'choices'			=> array(
			'readmore'		=>			esc_attr__( 'Read More', 'page-builder-framework' ),
			'categories'	=>			esc_attr__( 'Categories', 'page-builder-framework' ),
			'tags'			=>			esc_attr__( 'Tags', 'page-builder-framework' ),
		),
		'priority'			=>			0,
	) );

	// Separator
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'custom',
		'settings'			=>			$archive . '-separator-26125',
		'section'			=>			'wpbf_' . $archive . '_options',
		'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
		'priority'			=>			0,
	) );

	// Layout
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'select',
		'settings'			=>			$archive . '_layout',
		'label'				=>			esc_attr__( 'Layout', 'page-builder-framework' ),
		'section'			=>			'wpbf_' . $archive . '_options',
		'default'			=>			'default',
		'priority'			=>			10,
		'multiple'			=>			1,
		'choices'			=>			apply_filters( 'wpbf_blog_layouts', array(
			'default'		=>			esc_attr__( 'Default', 'page-builder-framework' ),
			'beside'		=>			esc_attr__( 'Image Beside Post', 'page-builder-framework' ),
		) ),
	) );

	// Style
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'select',
		'settings'			=>			$archive . '_post_style',
		'label'				=>			esc_attr__( 'Style', 'page-builder-framework' ),
		'section'			=>			'wpbf_' . $archive . '_options',
		'default'			=>			'plain',
		'priority'			=>			20,
		'multiple'			=>			1,
		'choices'			=>			array(
			'plain'			=>			esc_attr__( 'Plain', 'page-builder-framework' ),
			'boxed'			=>			esc_attr__( 'Boxed', 'page-builder-framework' ),
		),
	) );

	// Stretch Image
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'toggle',
		'settings'			=>			$archive . '_boxed_image_streched',
		'label'				=>			esc_attr__( 'Stretch Featured Image', 'page-builder-framework' ),
		'section'			=>			'wpbf_' . $archive . '_options',
		'default'			=>			0,
		'priority'			=>			20,
		'active_callback'	=>			array(
			array(
			'setting'		=>			$archive . '_post_style',
			'operator'		=>			'==',
			'value'			=>			'boxed',
			),
			array(
			'setting'		=>			$archive . '_layout',
			'operator'		=>			'!=',
			'value'			=>			'beside',
			),

		),
	) );

	// Space Between
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'slider',
		'label'				=>			esc_attr__( 'Space Between', 'page-builder-framework' ),
		'settings'			=>			$archive . '_post_space_between',
		'section'			=>			'wpbf_' . $archive . '_options',
		'priority'			=>			30,
		'default'			=>			20,
		'choices'			=>			array(
			'min'			=>			'0',
			'max'			=>			'100',
			'step'			=>			'1',
		),
	) );

	/* All Layouts */

	// Alignment
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'radio-image',
		'settings'			=>			$archive . '_post_content_alignment',
		'label'				=>			esc_attr__( 'Content Alignment', 'page-builder-framework' ),
		'section'			=>			'wpbf_' . $archive . '_options',
		'default'			=>			'left',
		'priority'			=>			40,
		'multiple'			=>			1,
		'choices'			=>			array(
			'left'			=>			WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
			'center'		=>			WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
			'right'			=>			WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
		),
	) );

	// Background Color
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'color',
		'settings'			=>			$archive . '_post_background_color',
		'label'				=>			esc_attr__( 'Background Color', 'page-builder-framework' ),
		'section'			=>			'wpbf_' . $archive . '_options',
		'default'			=>			'#f5f5f7',
		'priority'			=>			50,
		'choices'			=>			array(
			'alpha'			=>			true,
		),
		'active_callback'	=>			array(
			array(
			'setting'		=>			$archive . '_post_style',
			'operator'		=>			'==',
			'value'			=>			'boxed',
			),
		),
	) );

	// Accent Color
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'color',
		'settings'			=>			$archive . '_post_accent_color',
		'label'				=>			esc_attr__( 'Accent Color', 'page-builder-framework' ),
		'section'			=>			'wpbf_' . $archive . '_options',
		'priority'			=>			60,
		'choices'			=>			array(
			'alpha'			=>			true,
		),
	) );

	// Hover
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'color',
		'settings'			=>			$archive . '_post_accent_color_alt',
		'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
		'section'			=>			'wpbf_' . $archive . '_options',
		'priority'			=>			70,
		'choices'			=>			array(
			'alpha'			=>			true,
		),
	) );

	// Title Size
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'input_slider',
		'label'				=>			esc_attr__( 'Title Font Size', 'page-builder-framework' ),
		'settings'			=>			$archive . '_post_title_size',
		'section'			=>			'wpbf_' . $archive . '_options',
		'priority'			=>			80,
		'choices'			=>			array(
			'min'			=>			'0',
			'max'			=>			'50',
			'step'			=>			'1',
		),
	) );

	// Font Size
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'input_slider',
		'label'				=>			esc_attr__( 'Font Size', 'page-builder-framework' ),
		'settings'			=>			$archive . '_post_font_size',
		'section'			=>			'wpbf_' . $archive . '_options',
		'priority'			=>			90,
		'choices'			=>			array(
			'min'			=>			'0',
			'max'			=>			'50',
			'step'			=>			'1',
		),
	) );

	/* Beside */

	// Beside Headline
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'custom',
		'settings'			=>			$archive . '-separator-824021',
		'section'			=>			'wpbf_' . $archive . '_options',
		'default'			=>			'<h3 style="padding:15px 10px; background:#fff; margin:0;">'. __( 'Image Beside Post Layout Settings', 'page-builder-framework' ) .'</h3>',
		'priority'			=>			100,
		'active_callback'	=>			array(
			array(
			'setting'		=>			$archive . '_layout',
			'operator'		=>			'==',
			'value'			=>			'beside',
			),
		),
	) );

	// Image Alignment
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'radio-image',
		'settings'			=>			$archive . '_post_image_alignment',
		'label'				=>			esc_attr__( 'Image Alignment', 'page-builder-framework' ),
		'section'			=>			'wpbf_' . $archive . '_options',
		'default'			=>			'left',
		'priority'			=>			110,
		'multiple'			=>			1,
		'choices'			=>			array(
			'left'			=>			WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
			'right'			=>			WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
		),
		'active_callback'	=>			array(
			array(
			'setting'		=>			$archive . '_layout',
			'operator'		=>			'==',
			'value'			=>			'beside',
			),
		),
	) );

	// Image Width
	Kirki::add_field( 'wpbf', array(
		'type'				=>			'slider',
		'settings'			=>			$archive . '_post_image_width',
		'label'				=>			esc_attr__( 'Image Width', 'page-builder-framework' ),
		'section'			=>			'wpbf_' . $archive . '_options',
		'priority'			=>			120,
		'default'			=>			40,
		'choices'			=>			array(
			'min'			=>			'20',
			'max'			=>			'80',
			'step'			=>			'1',
		),
		'active_callback'	=>			array(
			array(
			'setting'		=>			$archive . '_layout',
			'operator'		=>			'==',
			'value'			=>			'beside',
			),
		),
	) );

}

/* Fields – Blog (Single) */

// Width
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Custom Content Width', 'page-builder-framework' ),
	'settings'			=>			'single_custom_width',
	'section'			=>			'wpbf_single_options',
	'description'		=>			esc_attr__( 'Default: 1200px', 'page-builder-framework' ), 
	'priority'			=>			0,
	'transport'			=>			'postMessage'
) );

// Sidebar Layout
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'single_sidebar_layout',
	'label'				=>			__( 'Sidebar', 'page-builder-framework' ),
	'section'			=>			'wpbf_single_options',
	'default'			=>			'global',
	'priority'			=>			0,
	'multiple'			=>			1,
	'choices'			=>			array(
		'global'		=>			esc_attr__( 'Inherit Global Settings', 'page-builder-framework' ),
		'right'			=>			esc_attr__( 'Right', 'page-builder-framework' ),
		'left'			=>			esc_attr__( 'Left', 'page-builder-framework' ),
		'none'			=>			esc_attr__( 'No Sidebar', 'page-builder-framework' ),
	),
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'single-separator-74767',
	'section'			=>			'wpbf_single_options',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			0,
) );

// Header
Kirki::add_field( 'wpbf', array(
	'type'				=>			'sortable',
	'settings'			=>			'single_sortable_header',
	'label'				=>			esc_attr__( 'Header', 'page-builder-framework' ),
	'section'			=>			'wpbf_single_options',
	'default'			=>			array(
		'title',
		'meta',
		'featured'
	),
	'choices'			=> array(
		'title'			=>			esc_attr__( 'Title', 'page-builder-framework' ),
		'meta'			=>			esc_attr__( 'Meta Data', 'page-builder-framework' ),
		'featured'		=>			esc_attr__( 'Featured Image', 'page-builder-framework' ),
	),
	'priority'			=>			0,
) );

// Footer
Kirki::add_field( 'wpbf', array(
	'type'				=>			'sortable',
	'settings'			=>			'single_sortable_footer',
	'label'				=>			esc_attr__( 'Footer', 'page-builder-framework' ),
	'section'			=>			'wpbf_single_options',
	'default'			=>			array(
		'readmore',
		'categories',
	),
	'choices'			=> array(
		'readmore'		=>			esc_attr__( 'Read More', 'page-builder-framework' ),
		'categories'	=>			esc_attr__( 'Categories', 'page-builder-framework' ),
		'tags'			=>			esc_attr__( 'Tags', 'page-builder-framework' ),
	),
	'priority'			=>			0,
) );

// Post Navigation
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'single_post_nav',
	'label'				=>			esc_attr__( 'Post Navigation', 'page-builder-framework' ),
	'section'			=>			'wpbf_single_options',
	'default'			=>			'show',
	'priority'			=>			0,
	'multiple'			=>			1,
	'choices'			=>			array(
		'show'			=>			esc_attr__( 'Previous/Next Post', 'page-builder-framework' ),
		'default'		=>			esc_attr__( 'Post Title', 'page-builder-framework' ),
		'hide'			=>			esc_attr__( 'Hide', 'page-builder-framework' ),
	),
) );

/* Fields – General */

// 404 Title
Kirki::add_field( 'wpbf', array(
	'type'				=>			'text',
	'label'				=>			esc_attr__( 'Title', 'page-builder-framework' ),
	'settings'			=>			'404_headline',
	'section'			=>			'wpbf_404_options',
	'default'			=>			esc_html__( "404 - This page couldn't be found.", "page-builder-framework" ),
	'priority'			=>			1,
) );

// 404 Text
Kirki::add_field( 'wpbf', array(
	'type'				=>			'text',
	'label'				=>			esc_attr__( 'Text', 'page-builder-framework' ),
	'settings'			=>			'404_text',
	'section'			=>			'wpbf_404_options',
	'default'			=>			esc_html__( "Oops! We're sorry, this page couldn't be found!", "page-builder-framework" ),
	'priority'			=>			2,
) );

// Search Form
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'404_search_form',
	'label'				=>			esc_attr__( 'Search Form', 'page-builder-framework' ),
	'section'			=>			'wpbf_404_options',
	'default'			=>			'show',
	'priority'			=>			3,
	'multiple'			=>			1,
	'choices'			=>			array(
		'show'			=>			esc_attr__( 'Show', 'page-builder-framework' ),
		'hide'			=>			esc_attr__( 'Hide', 'page-builder-framework' ),
	),
) );

// Max Width
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Page Width', 'page-builder-framework' ),
	'settings'			=>			'page_max_width',
	'section'			=>			'wpbf_page_options',
	'description'		=>			esc_attr__( 'Default: 1200px', 'page-builder-framework' ), 
	'priority'			=>			1,
) );

// Boxed
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'page_boxed',
	'label'				=>			esc_attr__( 'Boxed', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'default'			=>			0,
	'priority'			=>			2,
) );

// Boxed Margin
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'page_boxed_margin',
	'label'				=>			esc_attr__( 'Margin', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'priority'			=>			3,
	'default'			=>			0,
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'min'			=>			'0',
		'max'			=>			'80',
		'step'			=>			'1',
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'page_boxed',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	),
) );

// Boxed Padding
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'page_boxed_padding',
	'label'				=>			esc_attr__( 'Padding', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'priority'			=>			4,
	'default'			=>			20,
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'min'			=>			'20',
		'max'			=>			'100',
		'step'			=>			'1',
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'page_boxed',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	),
) );

// Background Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'page_boxed_background',
	'label'				=>			esc_attr__( 'Background Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'default'			=>			'#ffffff',
	'priority'			=>			5,
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'alpha'		=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'page_boxed',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	),
) );

// Box Shadow
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'page_boxed_box_shadow',
	'label'				=>			esc_attr__( 'Box Shadow', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'default'			=>			0,
	'priority'			=>			6,
	'active_callback'	=>			array(
		array(
		'setting'		=>			'page_boxed',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	),
) );

// Box Shadow Blur
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'page_boxed_box_shadow_blur',
	'label'				=>			esc_attr__( 'Blur', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'priority'			=>			7,
	'default'			=>			25,
	'choices'			=>			array(
		'min'			=>			'0',
		'max'			=>			'100',
		'step'			=>			'1',
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'page_boxed',
		'operator'		=>			'==',
		'value'			=>			1,
		),
		array(
		'setting'		=>			'page_boxed_box_shadow',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	),
) );

// Box Shadow Spread
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'page_boxed_box_shadow_spread',
	'label'				=>			esc_attr__( 'Spread', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'priority'			=>			8,
	'default'			=>			0,
	'choices'			=>			array(
		'min'			=>			'-100',
		'max'			=>			'100',
		'step'			=>			'1',
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'page_boxed',
		'operator'		=>			'==',
		'value'			=>			1,
		),
		array(
		'setting'		=>			'page_boxed_box_shadow',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	),
) );

// Box Shadow Horizontal
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'page_boxed_box_shadow_horizontal',
	'label'				=>			esc_attr__( 'Horizontal', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'priority'			=>			9,
	'default'			=>			0,
	'choices'			=>			array(
		'min'			=>			'-100',
		'max'			=>			'100',
		'step'			=>			'1',
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'page_boxed',
		'operator'		=>			'==',
		'value'			=>			1,
		),
		array(
		'setting'		=>			'page_boxed_box_shadow',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	),
) );

// Box Shadow Vertical
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'page_boxed_box_shadow_vertical',
	'label'				=>			esc_attr__( 'Vertical', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'priority'			=>			10,
	'default'			=>			0,
	'choices'			=>			array(
		'min'			=>			'-100',
		'max'			=>			'100',
		'step'			=>			'1',
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'page_boxed',
		'operator'		=>			'==',
		'value'			=>			1,
		),
		array(
		'setting'		=>			'page_boxed_box_shadow',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	),
) );

// Box Shadow Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'page_boxed_box_shadow_color',
	'label'				=>			esc_attr__( 'Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'default'			=>			'rgba(0,0,0,.15)',
	'priority'			=>			11,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'page_boxed',
		'operator'		=>			'==',
		'value'			=>			1,
		),
		array(
		'setting'		=>			'page_boxed_box_shadow',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	),
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-26125',
	'section'			=>			'wpbf_page_options',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			12,
) );

// Scrolltop
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'layout_scrolltop',
	'label'				=>			esc_attr__( 'ScrollTop', 'page-builder-framework' ),
	'description'		=>			esc_attr__( 'Select if you would like to display a scroll to top arrow', 'page-builder-framework' ), 
	'section'			=>			'wpbf_page_options',
	'default'			=>			'0',
	'priority'			=>			13,
) );

// Position
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'scrolltop_position',
	'label'				=>			esc_attr__( 'Position', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'default'			=>			'right',
	'priority'			=>			14,
	'multiple'			=>			1,
	'choices'			=>			array(
		'right'			=>			esc_attr__( 'Right', 'page-builder-framework' ),
		'left'			=>			esc_attr__( 'Left', 'page-builder-framework' ),
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'layout_scrolltop',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	)
) );

// Show after
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'scrolltop_value',
	'label'				=>			esc_attr__( 'Show after (px)', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'priority'			=>			15,
	'default'			=>			'400',
	'choices'			=>			array(
		'min'			=>			'50',
		'max'			=>			'1000',
		'step'			=>			'1',
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'layout_scrolltop',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	)
) );

// Background Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'scrolltop_bg_color',
	'label'				=>			esc_attr__( 'Background Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'priority'			=>			16,
	'transport'			=>			'postMessage',
	'default'			=>			'rgba(62,67,73,.5)',
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'layout_scrolltop',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	)
) );

// Background Color Hover
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'scrolltop_bg_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'priority'			=>			17,
	'default'			=>			'rgba(62,67,73,.7)',
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'layout_scrolltop',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	)
) );

// Border Radius
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'scrolltop_border_radius',
	'label'				=>			esc_attr__( 'Border Radius', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'priority'			=>			18,
	'default'			=>			'0',
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'min'			=>			'0',
		'max'			=>			'100',
		'step'			=>			'1',
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'layout_scrolltop',
		'operator'		=>			'==',
		'value'			=>			1,
		),
	)
) );


/* Fields – Sidebar */

// Postion
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'sidebar_position',
	'label'				=>			esc_attr__( 'Sidebar', 'page-builder-framework' ),
	'section'			=>			'wpbf_sidebar_options',
	'default'			=>			'right',
	'priority'			=>			1,
	'multiple'			=>			1,
	'choices'			=>			array(
		'right'			=>			esc_attr__( 'Right', 'page-builder-framework' ),
		'left'			=>			esc_attr__( 'Left', 'page-builder-framework' ),
		'none'			=>			esc_attr__( 'No Sidebar', 'page-builder-framework' ),
	),
) );

// Gap
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'sidebar_gap',
	'label'				=>			esc_attr__( 'Gap', 'page-builder-framework' ),
	'section'			=>			'wpbf_sidebar_options',
	'default'			=>			'medium',
	'priority'			=>			2,
	'multiple'			=>			1,
	'choices'			=>			array(
		'divider'		=>			esc_attr__( 'Divider', 'page-builder-framework' ),
		'xlarge'		=>			esc_attr__( 'xLarge', 'page-builder-framework' ),
		'large'			=>			esc_attr__( 'Large', 'page-builder-framework' ),
		'medium'		=>			esc_attr__( 'Medium', 'page-builder-framework' ),
		'small'			=>			esc_attr__( 'Small', 'page-builder-framework' ),
		'collapse'		=>			esc_attr__( 'Collapse', 'page-builder-framework' ),
	),
) );

// Width
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'sidebar_width',
	'label'				=>			esc_attr__( 'Width', 'page-builder-framework' ),
	'section'			=>			'wpbf_sidebar_options',
	'priority'			=>			2,
	'default'			=>			'33.3',
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'min'			=>			'20',
		'max'			=>			'40',
		'step'			=>			'.1',
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'sidebar_position',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	)
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-481013',
	'section'			=>			'wpbf_sidebar_options',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			2,
) );

// Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'sidebar_bg_color',
	'label'				=>			esc_attr__( 'Background Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_sidebar_options',
	'default'			=>			'#f5f5f7',
	'priority'			=>			4,
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

/* Fields – Accent Color */

// Accent Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'page_accent_color',
	'label'				=>			esc_attr__( 'Accent Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_accent_options',
	'priority'			=>			1,
	'default'			=>			'#3ba9d2',
	'choices'			=>			array(
		'alpha'		=>			true,
	),
) );

// Accent Color Alt
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'page_accent_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_accent_options',
	'priority'			=>			2,
	'default'			=>			'#8ecde5',
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

/* Fields – Buttons */

// Background Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'button_bg_color',
	'label'				=>			esc_attr__( 'Background Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_button_options',
	'priority'			=>			1,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Background Color Alt
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'button_bg_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_button_options',
	'priority'			=>			1,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Text Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'button_text_color',
	'label'				=>			esc_attr__( 'Font Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_button_options',
	'priority'			=>			1,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Text Color Alt
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'button_text_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_button_options',
	'priority'			=>			1,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-81461',
	'section'			=>			'wpbf_button_options',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			1,
) );

// Primary
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'button_primary_bg_color',
	'label'				=>			esc_attr__( 'Primary Background Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_button_options',
	'priority'			=>			1,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Primary Background Color Alt
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'button_primary_bg_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_button_options',
	'priority'			=>			1,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Primary Text Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'button_primary_text_color',
	'label'				=>			esc_attr__( 'Primary Font Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_button_options',
	'priority'			=>			1,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Primary Text Color Alt
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'button_primary_text_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_button_options',
	'priority'			=>			1,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-33757',
	'section'			=>			'wpbf_button_options',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			1,
) );

// Border Radius
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'button_border_radius',
	'label'				=>			esc_attr__( 'Border Radius', 'page-builder-framework' ),
	'section'			=>			'wpbf_button_options',
	'priority'			=>			1,
	'default'			=>			'0',
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'min'			=>			'0',
		'max'			=>			'100',
		'step'			=>			'1',
	),
) );

// Border Width
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'button_border_width',
	'label'				=>			esc_attr__( 'Border Width', 'page-builder-framework' ),
	'section'			=>			'wpbf_button_options',
	'priority'			=>			1,
	'default'			=>			'0',
	'choices'			=>			array(
		'min'			=>			'0',
		'max'			=>			'10',
		'step'			=>			'1',
	),
) );

// Border Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'button_border_color',
	'label'				=>			esc_attr__( 'Border Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_button_options',
	'priority'			=>			1,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'button_border_width',
		'operator'		=>			'!==',
		'value'			=>			'0',
		),
	),
) );

// Border Color Alt
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'button_border_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_button_options',
	'priority'			=>			1,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'button_border_width',
		'operator'		=>			'!==',
		'value'			=>			'0',
		),
	),
) );

// Primary Border Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'button_primary_border_color',
	'label'				=>			esc_attr__( 'Primary Border Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_button_options',
	'priority'			=>			1,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'button_border_width',
		'operator'		=>			'!==',
		'value'			=>			'0',
		),
	),
) );

// Primary Border Color Alt
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'button_primary_border_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_button_options',
	'priority'			=>			1,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'button_border_width',
		'operator'		=>			'!==',
		'value'			=>			'0',
		),
	),
) );

/* Fields – Typography */

// Text
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'page_font_toggle',
	'label'				=>			esc_attr__( 'Font Settings', 'page-builder-framework' ),
	'section'			=>			'wpbf_font_options',
	'default'			=>			0,
	'priority'			=>			0,
) );

// Font Family
Kirki::add_field( 'wpbf', array(
	'type'				=>			'typography',
	'settings'			=>			'page_font_family',
	'label'				=>			esc_attr__( 'Font', 'page-builder-framework' ),
	'section'			=>			'wpbf_font_options',
	'default'			=>			array(
		'font-family'	=>			'Helvetica, Arial, sans-serif',
		'variant'		=>			'regular',
	),
	'choices'			=>			wpbf_default_font_choices(),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'page_font_toggle',
		'operator'		=>			'==',
		'value'			=>			true,
		),
	),
	'priority'			=>			1,
) );

// Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'page_font_color',
	'label'				=>			esc_attr__( 'Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_font_options',
	'default'			=>			'#6D7680',
	'priority'			=>			2,
	'choices'			=>			array(
		'alpha'			=>			true,
	)
) );

if( !wpbf_is_premium() ) {

	$wpbf_premium_ad_link = sprintf(
		/* translators: 1: link target */
		__( 'Premium Features available. <a href="%1$s" target="%2$s">Learn More</a>', 'page-builder-framework' ),
		esc_url( 'https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf' ),
		esc_attr( '_blank' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'			=>		'custom',
		'settings'		=>		'wpbf_premium_ad_typography_text',
		'section'		=>		'wpbf_font_options',
		'default'		=>		'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority'		=>		9999,
	) );

}

// Title / Tagline

// Title Font Toggle
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'menu_logo_font_toggle',
	'label'				=>			esc_attr__( 'Title Font Settings', 'page-builder-framework' ),
	'section'			=>			'wpbf_title_tagline_options',
	'default'			=>			0,
	'priority'			=>			0,
) );

// Font Family
Kirki::add_field( 'wpbf', array(
	'type'				=>			'typography',
	'settings'			=>			'menu_logo_font_family',
	'label'				=>			esc_attr__( 'Font', 'page-builder-framework' ),
	'section'			=>			'wpbf_title_tagline_options',
	'default'			=>			array(
		'font-family'	=>			'Helvetica, Arial, sans-serif',
		'variant'		=>			'700',
		'subsets'		=>			array( 'latin-ext' ),
	),
	'choices'			=>			wpbf_default_font_choices(),
	'priority'			=>			1,
	'active_callback'	=>			array(
		array(
		'setting'		=>			'menu_logo_font_toggle',
		'operator'		=>			'==',
		'value'			=>			true,
		),
	)
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-602564',
	'section'			=>			'wpbf_title_tagline_options',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			2,
) );

// Tagline Font Toggle
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'menu_logo_description_toggle',
	'label'				=>			esc_attr__( 'Tagline Font Settings', 'page-builder-framework' ),
	'section'			=>			'wpbf_title_tagline_options',
	'default'			=>			0,
	'priority'			=>			3,
) );

// Font Family
Kirki::add_field( 'wpbf', array(
	'type'				=>			'typography',
	'settings'			=>			'menu_logo_description_font_family',
	'label'				=>			esc_attr__( 'Font', 'page-builder-framework' ),
	'section'			=>			'wpbf_title_tagline_options',
	'default'			=>			array(
		'font-family'	=>			'Helvetica, Arial, sans-serif',
		'variant'		=>			'700',
		'subsets'		=>			array( 'latin-ext' ),
	),
	'choices'			=>			wpbf_default_font_choices(),
	'priority'			=>			4,
	'active_callback'	=>			array(
		array(
		'setting'		=>			'menu_logo_description_toggle',
		'operator'		=>			'==',
		'value'			=>			true,
		),
	)
) );

// Menu
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'menu_font_family_toggle',
	'label'				=>			esc_attr__( 'Menu Font Settings', 'page-builder-framework' ),
	'section'			=>			'wpbf_menu_font_options',
	'default'			=>			0,
	'priority'			=>			0,
) );

// Font Family
Kirki::add_field( 'wpbf', array(
	'type'				=>			'typography',
	'settings'			=>			'menu_font_family',
	'label'				=>			esc_attr__( 'Font', 'page-builder-framework' ),
	'section'			=>			'wpbf_menu_font_options',
	'default'			=>			array(
		'font-family'	=>			'Helvetica, Arial, sans-serif',
		'variant'		=>			'regular',
	),
	'choices'			=>			wpbf_default_font_choices(),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'menu_font_family_toggle',
		'operator'		=>			'==',
		'value'			=>			true,
		),
	),
	'priority'			=>			1,
) );

if( !wpbf_is_premium() ) {

	$wpbf_premium_ad_link = sprintf(
		/* translators: 1: link target */
		__( 'Premium Features available. <a href="%1$s" target="%2$s">Learn More</a>', 'page-builder-framework' ),
		esc_url( 'https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf' ),
		esc_attr( '_blank' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'			=>		'custom',
		'settings'		=>		'wpbf_premium_ad_typography_menu',
		'section'		=>		'wpbf_menu_font_options',
		'default'		=>		'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority'		=>		9999,
	) );

}

// H1
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'page_h1_toggle',
	'label'				=>			esc_attr__( 'H1 Settings', 'page-builder-framework' ),
	'section'			=>			'wpbf_h1_options',
	'default'			=>			0,
	'priority'			=>			0,
	'description'		=>			esc_attr__( "The settings below will apply to all headlines if not configured separately.", "page-builder-framework" ),
) );

// Font Family
Kirki::add_field( 'wpbf', array(
	'type'				=>			'typography',
	'settings'			=>			'page_h1_font_family',
	'label'				=>			esc_attr__( 'Font', 'page-builder-framework' ),
	'section'			=>			'wpbf_h1_options',
	'default'			=>			array(
		'font-family'	=>			'Helvetica, Arial, sans-serif',
		'variant'		=>			'700',
	),
	'choices'			=>			wpbf_default_font_choices(),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'page_h1_toggle',
		'operator'		=>			'==',
		'value'			=>			true,
		),
	),
	'priority'			=>			1,
) );

if( !wpbf_is_premium() ) {

	$wpbf_premium_ad_link = sprintf(
		/* translators: 1: link target */
		__( 'Premium Features available. <a href="%1$s" target="%2$s">Learn More</a>', 'page-builder-framework' ),
		esc_url( 'https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf' ),
		esc_attr( '_blank' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'			=>		'custom',
		'settings'		=>		'wpbf_premium_ad_typography_h1',
		'section'		=>		'wpbf_h1_options',
		'default'		=>		'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority'		=>		9999,
	) );

}

// H2
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'page_h2_toggle',
	'label'				=>			esc_attr__( 'H2 Settings', 'page-builder-framework' ),
	'section'			=>			'wpbf_h2_options',
	'default'			=>			0,
	'priority'			=>			0,
) );

// Font Family
Kirki::add_field( 'wpbf', array(
	'type'				=>			'typography',
	'settings'			=>			'page_h2_font_family',
	'label'				=>			esc_attr__( 'Font', 'page-builder-framework' ),
	'section'			=>			'wpbf_h2_options',
	'default'			=>			array(
		'font-family'	=>			'Helvetica, Arial, sans-serif',
		'variant'		=>			'700',
	),
	'choices'			=>			wpbf_default_font_choices(),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'page_h2_toggle',
		'operator'		=>			'==',
		'value'			=>			true,
		),
	),
	'priority'			=>			1,
) );

if( !wpbf_is_premium() ) {

	$wpbf_premium_ad_link = sprintf(
		/* translators: 1: link target */
		__( 'Premium Features available. <a href="%1$s" target="%2$s">Learn More</a>', 'page-builder-framework' ),
		esc_url( 'https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf' ),
		esc_attr( '_blank' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'			=>		'custom',
		'settings'		=>		'wpbf_premium_ad_typography_h2',
		'section'		=>		'wpbf_h2_options',
		'default'		=>		'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority'		=>		9999,
	) );

}

// H3
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'page_h3_toggle',
	'label'				=>			esc_attr__( 'H3 Settings', 'page-builder-framework' ),
	'section'			=>			'wpbf_h3_options',
	'default'			=>			0,
	'priority'			=>			0,
) );

// Font Family
Kirki::add_field( 'wpbf', array(
	'type'				=>			'typography',
	'settings'			=>			'page_h3_font_family',
	'label'				=>			esc_attr__( 'Font', 'page-builder-framework' ),
	'section'			=>			'wpbf_h3_options',
	'default'			=>			array(
		'font-family'	=>			'Helvetica, Arial, sans-serif',
		'variant'		=>			'700',
	),
	'choices'			=>			wpbf_default_font_choices(),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'page_h3_toggle',
		'operator'		=>			'==',
		'value'			=>			true,
		),
	),
	'priority'			=>			1,
) );

if( !wpbf_is_premium() ) {

	$wpbf_premium_ad_link = sprintf(
		/* translators: 1: link target */
		__( 'Premium Features available. <a href="%1$s" target="%2$s">Learn More</a>', 'page-builder-framework' ),
		esc_url( 'https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf' ),
		esc_attr( '_blank' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'			=>		'custom',
		'settings'		=>		'wpbf_premium_ad_typography_h3',
		'section'		=>		'wpbf_h3_options',
		'default'		=>		'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority'		=>		9999,
	) );

}

// H4
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'page_h4_toggle',
	'label'				=>			esc_attr__( 'H4 Settings', 'page-builder-framework' ),
	'section'			=>			'wpbf_h4_options',
	'default'			=>			0,
	'priority'			=>			0,
) );

// Font Family
Kirki::add_field( 'wpbf', array(
	'type'				=>			'typography',
	'settings'			=>			'page_h4_font_family',
	'label'				=>			esc_attr__( 'Font', 'page-builder-framework' ),
	'section'			=>			'wpbf_h4_options',
	'default'			=>			array(
		'font-family'	=>			'Helvetica, Arial, sans-serif',
		'variant'		=>			'700',
	),
	'choices'			=>			wpbf_default_font_choices(),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'page_h4_toggle',
		'operator'		=>			'==',
		'value'			=>			true,
		),
	),
	'priority'			=>			1,
) );

if( !wpbf_is_premium() ) {

	$wpbf_premium_ad_link = sprintf(
		/* translators: 1: link target */
		__( 'Premium Features available. <a href="%1$s" target="%2$s">Learn More</a>', 'page-builder-framework' ),
		esc_url( 'https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf' ),
		esc_attr( '_blank' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'			=>		'custom',
		'settings'		=>		'wpbf_premium_ad_typography_h4',
		'section'		=>		'wpbf_h4_options',
		'default'		=>		'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority'		=>		9999,
	) );

}

// H5
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'page_h5_toggle',
	'label'				=>			esc_attr__( 'H5 Settings', 'page-builder-framework' ),
	'section'			=>			'wpbf_h5_options',
	'default'			=>			0,
	'priority'			=>			0,
) );

// Font Family
Kirki::add_field( 'wpbf', array(
	'type'				=>			'typography',
	'settings'			=>			'page_h5_font_family',
	'label'				=>			esc_attr__( 'Font', 'page-builder-framework' ),
	'section'			=>			'wpbf_h5_options',
	'default'			=>			array(
		'font-family'	=>			'Helvetica, Arial, sans-serif',
		'variant'		=>			'700',
	),
	'choices'			=>			wpbf_default_font_choices(),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'page_h5_toggle',
		'operator'		=>			'==',
		'value'			=>			true,
		),
	),
	'priority'			=>			1,
) );

if( !wpbf_is_premium() ) {

	$wpbf_premium_ad_link = sprintf(
		/* translators: 1: link target */
		__( 'Premium Features available. <a href="%1$s" target="%2$s">Learn More</a>', 'page-builder-framework' ),
		esc_url( 'https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf' ),
		esc_attr( '_blank' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'			=>		'custom',
		'settings'		=>		'wpbf_premium_ad_typography_h5',
		'section'		=>		'wpbf_h5_options',
		'default'		=>		'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority'		=>		9999,
	) );

}

// H6
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'page_h6_toggle',
	'label'				=>			esc_attr__( 'H6 Settings', 'page-builder-framework' ),
	'section'			=>			'wpbf_h6_options',
	'default'			=>			0,
	'priority'			=>			0,
) );

// Font Family
Kirki::add_field( 'wpbf', array(
	'type'				=>			'typography',
	'settings'			=>			'page_h6_font_family',
	'label'				=>			esc_attr__( 'Font', 'page-builder-framework' ),
	'section'			=>			'wpbf_h6_options',
	'default'			=>			array(
		'font-family'	=>			'Helvetica, Arial, sans-serif',
		'variant'		=>			'700',
	),
	'choices'			=>			wpbf_default_font_choices(),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'page_h6_toggle',
		'operator'		=>			'==',
		'value'			=>			true,
		),
	),
	'priority'			=>			1,
) );

if( !wpbf_is_premium() ) {

	$wpbf_premium_ad_link = sprintf(
		/* translators: 1: link target */
		__( 'Premium Features available. <a href="%1$s" target="%2$s">Learn More</a>', 'page-builder-framework' ),
		esc_url( 'https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf' ),
		esc_attr( '_blank' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'			=>		'custom',
		'settings'		=>		'wpbf_premium_ad_typography_h6',
		'section'		=>		'wpbf_h6_options',
		'default'		=>		'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority'		=>		9999,
	) );

}

/* Fields – Pre Header */

// Pre Header Layout
Kirki::add_field( 'wpbf', array(
	'type'				=>			'radio-buttonset',
	'settings'			=>			'pre_header_layout',
	'label'				=>			esc_attr__( 'Layout', 'page-builder-framework' ),
	'section'			=>			'wpbf_pre_header_options',
	'default'			=>			'none',
	'priority'			=>			1,
	'choices'			=>			array(
		'none'			=>			esc_attr__( 'None', 'page-builder-framework' ),
		'one'			=>			esc_attr__( 'One Column', 'page-builder-framework' ),
		'two'			=>			esc_attr__( 'Two Columns', 'page-builder-framework' ),
	),
) );

// Column One Layout
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'pre_header_column_one_layout',
	'label'				=>			esc_attr__( 'Column 1', 'page-builder-framework' ),
	'section'			=>			'wpbf_pre_header_options',
	'default'			=>			'text',
	'priority'			=>			2,
	'choices'			=>			array(
		'none'			=>			esc_attr__( 'None', 'page-builder-framework' ),
		'text'			=>			esc_attr__( 'Text', 'page-builder-framework' ),
		'menu'			=>			esc_attr__( 'Menu', 'page-builder-framework' ),
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'pre_header_layout',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	)
) );

// Column One
Kirki::add_field( 'wpbf', array(
	'type'				=>			'textarea',
	'settings'			=>			'pre_header_column_one',
	'label'				=>			esc_attr__( 'Text', 'page-builder-framework' ),
	'section'			=>			'wpbf_pre_header_options',
	'default'			=>			esc_attr__( 'Column 1', 'page-builder-framework' ),
	'priority'			=>			2,
	'active_callback'	=>			array(
		array(
		'setting'		=>			'pre_header_layout',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
		array(
		'setting'		=>			'pre_header_column_one_layout',
		'operator'		=>			'==',
		'value'			=>			'text',
		),
	)
) );

// Column Two Layout
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'pre_header_column_two_layout',
	'label'				=>			esc_attr__( 'Column 2', 'page-builder-framework' ),
	'section'			=>			'wpbf_pre_header_options',
	'default'			=>			'text',
	'priority'			=>			2,
	'choices'			=>			array(
		'none'			=>			esc_attr__( 'None', 'page-builder-framework' ),
		'text'			=>			esc_attr__( 'Text', 'page-builder-framework' ),
		'menu'			=>			esc_attr__( 'Menu', 'page-builder-framework' ),
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'pre_header_layout',
		'operator'		=>			'==',
		'value'			=>			'two',
		),
	)
) );

// Column Two
Kirki::add_field( 'wpbf', array(
	'type'				=>			'textarea',
	'settings'			=>			'pre_header_column_two',
	'label'				=>			esc_attr__( 'Text', 'page-builder-framework' ),
	'section'			=>			'wpbf_pre_header_options',
	'default'			=>			esc_attr__( 'Column 2', 'page-builder-framework' ),
	'priority'			=>			2,
	'active_callback'	=>			array(
		array(
		'setting'		=>			'pre_header_layout',
		'operator'		=>			'==',
		'value'			=>			'two',
		),
		array(
		'setting'		=>			'pre_header_column_two_layout',
		'operator'		=>			'==',
		'value'			=>			'text',
		),
	)
) );

// Height
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'pre_header_height',
	'label'				=>			esc_attr__( 'Height', 'page-builder-framework' ),
	'section'			=>			'wpbf_pre_header_options',
	'priority'			=>			4,
	'default'			=>			'10',
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'min'			=>			'1',
		'max'			=>			'25',
		'step'			=>			'1',
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'pre_header_layout',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	)
) );

// Background Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'pre_header_bg_color',
	'label'				=>			esc_attr__( 'Background Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_pre_header_options',
	'default'			=>			'#ffffff',
	'priority'			=>			5,
	'transport'			=>			'postMessage',
	'active_callback'	=>			array(
		array(
		'setting'		=>			'pre_header_layout',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	),
	'choices'			=>			array(
		'alpha'			=>			true,
	)
) );

// Font Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'pre_header_font_color',
	'label'				=>			esc_attr__( 'Font Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_pre_header_options',
	'default'			=>			'#6d7680',
	'priority'			=>			6,
	'transport'			=>			'postMessage',
	'active_callback'	=>			array(
		array(
		'setting'		=>			'pre_header_layout',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	),
	'choices'			=>			array(
		'alpha'			=>			true,
	)
) );

/* Fields – Logo */

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-05198',
	'section'			=>			'title_tagline',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			4,
) );

// Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'menu_logo_color',
	'label'				=>			esc_attr__( 'Color', 'page-builder-framework' ),
	'section'			=>			'title_tagline',
	'priority'			=>			11,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'custom_logo',
		'operator'		=>			'==',
		'value'			=>			'',
		),
	)
) );

// Hover Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'menu_logo_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'title_tagline',
	'priority'			=>			12,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'custom_logo',
		'operator'		=>			'==',
		'value'			=>			'',
		),
	)
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-898067',
	'section'			=>			'title_tagline',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			14,
) );

/* Fields – Tagline */

// Toggle
Kirki::add_field( 'wpbf', array(
	'type'				=>			'checkbox',
	'settings'			=>			'menu_logo_description',
	'label'				=>			esc_attr__( 'Display Tagline', 'page-builder-framework' ),
	'section'			=>			'title_tagline',
	'default'			=>			'0',
	'priority'			=>			20,
	'active_callback'	=>			array(
		array(
		'setting'		=>			'custom_logo',
		'operator'		=>			'==',
		'value'			=>			'',
		),
	)
) );

// Toggle
Kirki::add_field( 'wpbf', array(
	'type'				=>			'checkbox',
	'settings'			=>			'menu_logo_description_mobile',
	'label'				=>			esc_attr__( 'Display Tagline on Mobile', 'page-builder-framework' ),
	'section'			=>			'title_tagline',
	'default'			=>			'0',
	'priority'			=>			20,
	'active_callback'	=>			array(
		array(
		'setting'		=>			'custom_logo',
		'operator'		=>			'==',
		'value'			=>			'',
		),
		array(
		'setting'		=>			'menu_logo_description',
		'operator'		=>			'==',
		'value'			=>			true,
		),
	)
) );

// Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'menu_logo_description_color',
	'label'				=>			esc_attr__( 'Color', 'page-builder-framework' ),
	'section'			=>			'title_tagline',
	'priority'			=>			22,
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'custom_logo',
		'operator'		=>			'==',
		'value'			=>			'',
		),
		array(
		'setting'		=>			'menu_logo_description',
		'operator'		=>			'==',
		'value'			=>			true,
		),
	)
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-212074',
	'section'			=>			'title_tagline',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			24,
) );

/* Fields – Logo Settings Misc */

// Logo URL
Kirki::add_field( 'wpbf', array(
	'type'				=>			'link',
	'settings'			=>			'menu_logo_url',
	'label'				=>			esc_attr__( 'Custom Logo URL', 'page-builder-framework' ),
	'section'			=>			'title_tagline',
	'transport'			=>			'postMessage',
	'priority'			=>			30,
) );

// Alt Tag
Kirki::add_field( 'wpbf', array(
	'type'				=>			'text',
	'settings'			=>			'menu_logo_alt',
	'label'				=>			esc_attr__( 'Custom "alt" Tag', 'page-builder-framework' ),
	'section'			=>			'title_tagline',
	'priority'			=>			31,
	'transport'			=>			'postMessage',
	'active_callback'	=>			array(
		array(
		'setting'		=>			'custom_logo',
		'operator'		=>			'!==',
		'value'			=>			'',
		),
	),
) );

// Title Tag
Kirki::add_field( 'wpbf', array(
	'type'				=>			'text',
	'settings'			=>			'menu_logo_title',
	'label'				=>			esc_attr__( 'Custom "title" Tag', 'page-builder-framework' ),
	'section'			=>			'title_tagline',
	'priority'			=>			32,
	'transport'			=>			'postMessage',
	'active_callback'	=>			array(
		array(
		'setting'		=>			'custom_logo',
		'operator'		=>			'!==',
		'value'			=>			'',
		),
	),
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-791190',
	'section'			=>			'title_tagline',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			33,
) );

/* Fields – Logo Container Width */

// Container Width
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'menu_logo_container_width',
	'label'				=>			esc_attr__( 'Logo Container Width', 'page-builder-framework' ),
	'description'		=>			esc_attr__( 'Defines the space in % the logo area takes in the navigation', 'page-builder-framework' ),
	'section'			=>			'title_tagline',
	'priority'			=>			40,
	'default'			=>			'25',
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'min'			=>			'10',
		'max'			=>			'40',
		'step'			=>			'1',
	),
) );

// Mobile Container Width
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'mobile_menu_logo_container_width',
	'label'				=>			esc_attr__( 'Logo Container Width (Mobile)', 'page-builder-framework' ),
	'description'		=>			esc_attr__( 'Defines the space in % the logo area takes in the navigation', 'page-builder-framework' ),
	'section'			=>			'title_tagline',
	'priority'			=>			41,
	'default'			=>			'66',
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'min'			=>			'10',
		'max'			=>			'80',
		'step'			=>			'1',
	),
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-44545',
	'section'			=>			'title_tagline',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			42,
) );

/* Fields – Navigation */

// Variations
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'menu_position',
	'label'				=>			esc_attr__( 'Menu', 'page-builder-framework' ),
	'section'			=>			'wpbf_menu_options',
	'default'			=>			'menu-right',
	'priority'			=>			0,
	'multiple'			=>			1,
	'choices'			=>			apply_filters( 'wpbf_menu_position', array(
		'menu-right'	=>			esc_attr__( 'Right (default)', 'page-builder-framework' ),
		'menu-left'		=>			esc_attr__( 'Left', 'page-builder-framework' ),
		'menu-centered'	=>			esc_attr__( 'Centered', 'page-builder-framework' ),
		'menu-stacked'	=>			esc_attr__( 'Stacked', 'page-builder-framework' )
	) ),
) );

// Width
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Navigation Width', 'page-builder-framework' ),
	'description'		=>			esc_attr__( 'Default: 1200px', 'page-builder-framework' ),
	'settings'			=>			'menu_width',
	'section'			=>			'wpbf_menu_options',
	'priority'			=>			1,
) );

// Search Icon
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'menu_search_icon',
	'label'				=>			esc_attr__( 'Search Icon', 'page-builder-framework' ),
	'section'			=>			'wpbf_menu_options',
	'priority'			=>			2
) );

// Height
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'label'				=>			esc_attr__( 'Menu Height', 'page-builder-framework' ),
	'settings'			=>			'menu_height',
	'section'			=>			'wpbf_menu_options',
	'priority'			=>			3,
	'default'			=>			'20',
	'choices'			=>			array(
		'min'			=>			'10',
		'max'			=>			'80',
		'step'			=>			'1',
	),
) );

// Padding
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'label'				=>			esc_attr__( 'Menu Item Spacing', 'page-builder-framework' ),
	'settings'			=>			'menu_padding',
	'section'			=>			'wpbf_menu_options',
	'priority'			=>			4,
	'default'			=>			'20',
	'choices'			=>			array(
		'min'			=>			'5',
		'max'			=>			'40',
		'step'			=>			'1',
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'menu_position',
		'operator'		=>			'!=',
		'value'			=>			'menu-off-canvas',
		),
		array(
		'setting'		=>			'menu_position',
		'operator'		=>			'!=',
		'value'			=>			'menu-off-canvas-left',
		),
	)
) );

// Background Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'menu_bg_color',
	'label'				=>			esc_attr__( 'Background Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_menu_options',
	'default'			=>			'#f5f5f7',
	'priority'			=>			5,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Font Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'menu_font_color',
	'label'				=>			esc_attr__( 'Font Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_menu_options',
	'priority'			=>			6,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Font Color Alt
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'menu_font_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_menu_options',
	'priority'			=>			7,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Font Size
Kirki::add_field( 'wpbf', array(
	'type'				=>			'input_slider',
	'label'				=>			esc_attr__( 'Font Size', 'page-builder-framework' ),
	'settings'			=>			'menu_font_size',
	'section'			=>			'wpbf_menu_options',
	'priority'			=>			7,
	'default'			=>			'16px',
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'min'			=>			'0',
		'max'			=>			'100',
		'step'			=>			'1',
	),
) );

if( !wpbf_is_premium() ) {

	$wpbf_premium_ad_link = sprintf(
		/* translators: 1: link target */
		__( 'Premium Features available. <a href="%1$s" target="%2$s">Learn More</a>', 'page-builder-framework' ),
		esc_url( 'https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=customizer_navigation_panel&utm_campaign=wpbf#premium' ),
		esc_attr( '_blank' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'			=>		'custom',
		'settings'		=>		'wpbf_premium_ad_header_menu',
		'section'		=>		'wpbf_menu_options',
		'default'		=>		'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority'		=>		9999,
	) );

}

/* Fields – Sub Menu */

// Alignment
Kirki::add_field( 'wpbf', array(
	'type'				=>			'radio-image',
	'settings'			=>			'sub_menu_alignment',
	'label'				=>			esc_attr__( 'Sub Menu Alignment', 'page-builder-framework' ),
	'section'			=>			'wpbf_sub_menu_options',
	'default'			=>			'left',
	'priority'			=>			1,
	'multiple'			=>			1,
	'choices'			=>			array(
		'left'			=>			WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center'		=>			WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'			=>			WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	),
) );

// Width
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'sub_menu_width',
	'label'				=>			esc_attr__( 'Width', 'page-builder-framework' ),
	'section'			=>			'wpbf_sub_menu_options',
	'priority'			=>			1,
	'default'			=>			'220',
	'choices'			=>			array(
		'min'			=>			'100',
		'max'			=>			'400',
		'step'			=>			'1',
	),
) );

// Background Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'sub_menu_bg_color',
	'label'				=>			esc_attr__( 'Background Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_sub_menu_options',
	'default'			=>			'#ffffff',
	'transport'			=>			'postMessage',
	'priority'			=>			2,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Background Color Alt
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'sub_menu_bg_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_sub_menu_options',
	'default'			=>			'#ffffff',
	'priority'			=>			3,
	'choices'			=>			array(
		'alpha'			=>			true,
	)
) );

// Accent Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'sub_menu_accent_color',
	'label'				=>			esc_attr__( 'Font Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_sub_menu_options',
	'transport'			=>			'postMessage',
	'priority'			=>			4,
) );

// Accent Color Alt
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'sub_menu_accent_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_sub_menu_options',
	'priority'			=>			5,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Font Size
Kirki::add_field( 'wpbf', array(
	'type'				=>			'input_slider',
	'label'				=>			esc_attr__( 'Font Size', 'page-builder-framework' ),
	'settings'			=>			'sub_menu_font_size',
	'section'			=>			'wpbf_sub_menu_options',
	'priority'			=>			6,
	'transport'			=>			'postMessage',
		'choices'			=>			array(
			'min'			=>			'0',
			'max'			=>			'100',
			'step'			=>			'1',
		),
) );

// Toggle
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'sub_menu_separator',
	'label'				=>			esc_attr__( 'Sub Menu Separator', 'page-builder-framework' ),
	'section'			=>			'wpbf_sub_menu_options',
	'default'			=>			0,
	'priority'			=>			6,
) );

// Separator Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'sub_menu_separator_color',
	'label'				=>			esc_attr__( 'Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_sub_menu_options',
	'default'			=>			'#f5f5f7',
	'priority'			=>			6,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'sub_menu_separator',
		'operator'		=>			'==',
		'value'			=>			true,
		),
	)
) );

if( !wpbf_is_premium() ) {

	$wpbf_premium_ad_link = sprintf(
		/* translators: 1: link target */
		__( 'Premium Features available. <a href="%1$s" target="%2$s">Learn More</a>', 'page-builder-framework' ),
		esc_url( 'https://wp-pagebuilderframework.com/docs/sub-menu/?utm_source=repository&utm_medium=customizer_sub_menu_panel&utm_campaign=wpbf' ),
		esc_attr( '_blank' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'			=>		'custom',
		'settings'		=>		'wpbf_premium_ad_header_sub_menu',
		'section'		=>		'wpbf_sub_menu_options',
		'default'		=>		'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority'		=>		9999,
	) );

}

/* Fields – Mobile Navigation */

// Variations
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'mobile_menu_options',
	'label'				=>			esc_attr__( 'Menu', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'default'			=>			'menu-mobile-hamburger',
	'priority'			=>			1,
	'multiple'			=>			1,
	'choices'			=>			apply_filters( 'wpbf_mobile_menu_options', array(
		'menu-mobile-default'		=>			esc_attr__( 'Default', 'page-builder-framework' ),
		'menu-mobile-hamburger'		=>			esc_attr__( 'Hamburger', 'page-builder-framework' )
	) )
) );

// Icon Style
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'mobile_menu_hamburger_style',
	'label'				=>			esc_attr__( 'Hamburger Icon Style', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'default'			=>			'default',
	'priority'			=>			1,
	'multiple'			=>			1,
	'choices'			=>			array(
		'default'		=>			esc_attr__( 'Default', 'page-builder-framework' ),
		'filled'		=>			esc_attr__( 'Filled', 'page-builder-framework' ),
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'mobile_menu_options',
		'operator'		=>			'in',
		'value'			=>			array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' )
		)
	)
) );

// Border Radius
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'mobile_menu_hamburger_border_radius',
	'label'				=>			esc_attr__( 'Border Radius', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'priority'			=>			1,
	'default'			=>			'0',
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'min'			=>			'0',
		'max'			=>			'50',
		'step'			=>			'1',
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'mobile_menu_options',
		'operator'		=>			'in',
		'value'			=>			array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' )
		),
		array(
		'setting'		=>			'mobile_menu_hamburger_style',
		'operator'		=>			'==',
		'value'			=>			'filled',
		),
	)
) );

// Hamburger Background Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'mobile_menu_hamburger_bg_color',
	'label'				=>			esc_attr__( 'Hamburger Icon Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'priority'			=>			1,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'mobile_menu_options',
		'operator'		=>			'in',
		'value'			=>			array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' )
		),
		array(
		'setting'		=>			'mobile_menu_hamburger_style',
		'operator'		=>			'==',
		'value'			=>			'filled',
		),
	)
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-680902',
	'section'			=>			'wpbf_mobile_menu_options',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			1,
	'active_callback'	=>			array(
		array(
		'setting'		=>			'mobile_menu_options',
		'operator'		=>			'in',
		'value'			=>			array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' )
		)
	)
) );

// Mobile Search Icon
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'mobile_menu_search_icon',
	'label'				=>			esc_attr__( 'Search Icon', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'priority'			=>			1,
	'active_callback'	=>			array(
		array(
		'setting'		=>			'mobile_menu_options',
		'operator'		=>			'!==',
		'value'			=>			'menu-mobile-default'
		)
	)
) );

// Height
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'mobile_menu_height',
	'label'				=>			esc_attr__( 'Height', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'priority'			=>			2,
	'default'			=>			'20',
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'min'			=>			'5',
		'max'			=>			'80',
		'step'			=>			'1',
	),
) );

// Background Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'mobile_menu_background_color',
	'label'				=>			esc_attr__( 'Background Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'priority'			=>			3,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'mobile_menu_options',
		'operator'		=>			'!=',
		'value'			=>			'menu-mobile-elementor'
		)
	)
) );

// Hamburger Size
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'mobile_menu_hamburger_size',
	'label'				=>			esc_attr__( 'Icon Size', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'default'			=>			'16',
	'priority'			=>			4,
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'min'			=>			'12',
		'max'			=>			'24',
		'step'			=>			'1',
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'mobile_menu_options',
		'operator'		=>			'in',
		'value'			=>			array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' )
		)
	)
) );

// Hamburger Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'mobile_menu_hamburger_color',
	'label'				=>			esc_attr__( 'Icon Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'default'			=>			'#6d7680',
	'priority'			=>			5,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'mobile_menu_options',
		'operator'		=>			'in',
		'value'			=>			array( 'menu-mobile-hamburger', 'menu-mobile-off-canvas' )
		)
	)
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-71744',
	'section'			=>			'wpbf_mobile_menu_options',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			6,
) );

// Menu Item Background Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'mobile_menu_bg_color',
	'label'				=>			esc_attr__( 'Menu Item Background Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'default'			=>			'#ffffff',
	'priority'			=>			9,
	'choices'			=>			array(
		'alpha'			=>			true,
	)
) );

// Menu Item Background Color Alt
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'mobile_menu_bg_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'default'			=>			'#ffffff',
	'priority'			=>			10,
	'choices'			=>			array(
		'alpha'			=>			true,
	)
) );

// Font Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'mobile_menu_font_color',
	'label'				=>			esc_attr__( 'Font Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'priority'			=>			11,
) );

// Font Color Hover
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'mobile_menu_font_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'priority'			=>			12,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Divider Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'mobile_menu_border_color',
	'label'				=>			esc_attr__( 'Divider Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'default'			=>			'#d9d9e0',
	'priority'			=>			13,
	'choices'			=>			array(
		'alpha'			=>			true,
	)
) );

// Sub Menu Arrow Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'mobile_menu_submenu_arrow_color',
	'label'				=>			esc_attr__( 'Sub Menu Arrow Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'priority'			=>			14,
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Font Size
Kirki::add_field( 'wpbf', array(
	'type'				=>			'input_slider',
	'label'				=>			esc_attr__( 'Font Size', 'page-builder-framework' ),
	'settings'			=>			'mobile_menu_font_size',
	'section'			=>			'wpbf_mobile_menu_options',
	'priority'			=>			15,
	'default'			=>			'16px',
	'choices'			=>			array(
		'min'			=>			'0',
		'max'			=>			'50',
		'step'			=>			'1',
	)
) );

if( !wpbf_is_premium() ) {

	$wpbf_premium_ad_link = sprintf(
		/* translators: 1: link target */
		__( 'Premium Features available. <a href="%1$s" target="%2$s">Learn More</a>', 'page-builder-framework' ),
		esc_url( 'https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=customizer_mobile_navigation_panel&utm_campaign=wpbf#premium' ),
		esc_attr( '_blank' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'			=>		'custom',
		'settings'		=>		'wpbf_premium_ad_header_mobile_menu',
		'section'		=>		'wpbf_mobile_menu_options',
		'default'		=>		'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority'		=>		9999,
	) );

}

/* Fields – Footer */

// Layout
Kirki::add_field( 'wpbf', array(
	'type'				=>			'radio-buttonset',
	'settings'			=>			'footer_layout',
	'label'				=>			esc_attr__( 'Footer', 'page-builder-framework' ),
	'section'			=>			'wpbf_footer_options',
	'default'			=>			'two',
	'priority'			=>			1,
	'choices'			=>			array(
		'none'			=>			esc_attr__( 'None', 'page-builder-framework' ),
		'one'			=>			esc_attr__( 'One Column', 'page-builder-framework' ),
		'two'			=>			esc_attr__( 'Two Columns', 'page-builder-framework' ),
	),
) );

// Column One Layout
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'footer_column_one_layout',
	'label'				=>			esc_attr__( 'Column 1', 'page-builder-framework' ),
	'section'			=>			'wpbf_footer_options',
	'default'			=>			'text',
	'priority'			=>			2,
	'choices'			=>			array(
		'none'			=>			esc_attr__( 'None', 'page-builder-framework' ),
		'text'			=>			esc_attr__( 'Text', 'page-builder-framework' ),
		'menu'			=>			esc_attr__( 'Menu', 'page-builder-framework' ),
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'footer_layout',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	)
) );

// Column One
Kirki::add_field( 'wpbf', array(
	'type'				=>			'textarea',
	'settings'			=>			'footer_column_one',
	'label'				=>			esc_attr__( 'Text', 'page-builder-framework' ),
	'section'			=>			'wpbf_footer_options',
	'default'			=>			esc_html__( '&copy; [year] - [blogname] | All rights reserved', 'page-builder-framework' ),
	'priority'			=>			2,
	'active_callback'	=>			array(
		array(
		'setting'		=>			'footer_layout',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
		array(
		'setting'		=>			'footer_column_one_layout',
		'operator'		=>			'==',
		'value'			=>			'text',
		),
	)
) );

// Column Two Layout
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'footer_column_two_layout',
	'label'				=>			esc_attr__( 'Column 2', 'page-builder-framework' ),
	'section'			=>			'wpbf_footer_options',
	'default'			=>			'text',
	'priority'			=>			3,
	'choices'			=>			array(
		'none'			=>			esc_attr__( 'None', 'page-builder-framework' ),
		'text'			=>			esc_attr__( 'Text', 'page-builder-framework' ),
		'menu'			=>			esc_attr__( 'Menu', 'page-builder-framework' ),
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'footer_layout',
		'operator'		=>			'==',
		'value'			=>			'two',
		),
	)
) );

// Column Two
Kirki::add_field( 'wpbf', array(
	'type'				=>			'textarea',
	'settings'			=>			'footer_column_two',
	'label'				=>			esc_attr__( 'Text', 'page-builder-framework' ),
	'section'			=>			'wpbf_footer_options',
	'default'			=>			__( 'Powered by [theme_author]', 'page-builder-framework' ),
	'priority'			=>			3,
	'active_callback'	=>			array(
		array(
		'setting'		=>			'footer_layout',
		'operator'		=>			'==',
		'value'			=>			'two',
		),
		array(
		'setting'		=>			'footer_column_two_layout',
		'operator'		=>			'==',
		'value'			=>			'text',
		),
	)
) );

// Width
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Footer Width', 'page-builder-framework' ),
	'description'		=>			esc_attr__( 'Default: 1200px', 'page-builder-framework' ),
	'settings'			=>			'footer_width',
	'section'			=>			'wpbf_footer_options',
	'priority'			=>			5,
	'transport'			=>			'postMessage',
	'active_callback'	=>			array(
		array(
		'setting'		=>			'footer_layout',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	)
) );

// Footer Height
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'footer_height',
	'label'				=>			esc_attr__( 'Height', 'page-builder-framework' ),
	'section'			=>			'wpbf_footer_options',
	'priority'			=>			6,
	'default'			=>			20,
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'min'			=>			'1',
		'max'			=>			'100',
		'step'			=>			'1',
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'footer_layout',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	)
) );

// Background Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'footer_bg_color',
	'label'				=>			esc_attr__( 'Background Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_footer_options',
	'default'			=>			'#f5f5f7',
	'transport'			=>			'postMessage',
	'priority'			=>			7,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'footer_layout',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	)
) );

// Font Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'footer_font_color',
	'label'				=>			esc_attr__( 'Font Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_footer_options',
	'transport'			=>			'postMessage',
	'priority'			=>			8,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'footer_layout',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	)
) );

// Accent Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'footer_accent_color',
	'label'				=>			esc_attr__( 'Accent Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_footer_options',
	'priority'			=>			9,
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'footer_layout',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	)
) );

// Accent Color Alt
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'footer_accent_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_footer_options',
	'priority'			=>			10,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'footer_layout',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	)
) );

// Font Size
Kirki::add_field( 'wpbf', array(
	'type'				=>			'input_slider',
	'label'				=>			esc_attr__( 'Font Size', 'page-builder-framework' ),
	'settings'			=>			'footer_font_size',
	'section'			=>			'wpbf_footer_options',
	'priority'			=>			11,
	'default'			=>			'14px',
	'transport'			=>			'postMessage',
	'active_callback'	=>			array(
		array(
		'setting'		=>			'footer_layout',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	),
	'choices'			=>			array(
		'min'			=>			'0',
		'max'			=>			'50',
		'step'			=>			'1',
	)
) );

if( !wpbf_is_premium() ) {

	$wpbf_premium_ad_link = sprintf(
		/* translators: 1: link target */
		__( 'Premium Features available. <a href="%1$s" target="%2$s">Learn More</a>', 'page-builder-framework' ),
		esc_url( 'https://wp-pagebuilderframework.com/docs/advanced-footer-settings/?utm_source=repository&utm_medium=customizer_footer_panel&utm_campaign=wpbf' ),
		esc_attr( '_blank' )
	);

	Kirki::add_field( 'wpbf', array(
		'type'			=>		'custom',
		'settings'		=>		'wpbf_premium_ad_footer',
		'section'		=>		'wpbf_footer_options',
		'default'		=>		'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link,
		'priority'		=>		9999,
	) );

}

/**
 * Custom Controls
 */
function wpbf_custom_controls_default( $wp_customize ) {

	// Logo Size
	$wp_customize->add_setting( 'menu_logo_size_desktop',
		array(
			'sanitize_callback' => 'esc_textarea',
		)
	);

	$wp_customize->add_setting( 'menu_logo_size_tablet',
		array(
			'sanitize_callback' => 'esc_textarea',
		)
	);

	$wp_customize->add_setting( 'menu_logo_size_mobile',
		array(
			'sanitize_callback' => 'esc_textarea',
		)
	);

	$wp_customize->add_control( new WPBF_Customize_Responsive_Input_Slider(
		$wp_customize,
		'menu_logo_size',
		array(
			'label'	=> esc_attr__( 'Logo Width', 'page-builder-framework' ),
			'section' => 'title_tagline',
			'settings' => 'menu_logo_size_desktop',
			'priority' => 2,
			'choices'			=>			array(
				'min'			=>			'0',
				'max'			=>			'500',
				'step'			=>			'1',
			),
			'active_callback' => function() { return get_theme_mod( 'custom_logo' ) ? true : false; }
		)
	));

	$wp_customize->add_control( new WPBF_Customize_Responsive_Input_Slider(
		$wp_customize,
		'menu_logo_size',
		array(
			'label'	=> esc_attr__( 'Logo Width', 'page-builder-framework' ),
			'section' => 'title_tagline',
			'settings' => 'menu_logo_size_tablet',
			'priority' => 2,
			'choices'			=>			array(
				'min'			=>			'0',
				'max'			=>			'500',
				'step'			=>			'1',
			),
			'active_callback' => function() { return get_theme_mod( 'custom_logo' ) ? true : false; },
		)
	));

	$wp_customize->add_control( new WPBF_Customize_Responsive_Input_Slider(
		$wp_customize,
		'menu_logo_size',
		array(
			'label'	=> esc_attr__( 'Logo Width', 'page-builder-framework' ),
			'section' => 'title_tagline',
			'settings' => 'menu_logo_size_mobile',
			'priority' => 2,
			'choices'			=>			array(
				'min'			=>			'0',
				'max'			=>			'500',
				'step'			=>			'1',
			),
			'active_callback' => function() { return get_theme_mod( 'custom_logo' ) ? true : false; },
		)
	));

	// Site Title
	$wp_customize->add_setting( 'menu_logo_font_size_desktop',
		array(
			'default' => '22px',
			'sanitize_callback' => 'esc_textarea',
		)
	);

	$wp_customize->add_setting( 'menu_logo_font_size_tablet',
		array(
			'sanitize_callback' => 'esc_textarea',
		)
	);

	$wp_customize->add_setting( 'menu_logo_font_size_mobile',
		array(
			'sanitize_callback' => 'esc_textarea',
		)
	);

	$wp_customize->add_control( new WPBF_Customize_Font_Size_Control( 
		$wp_customize, 
		'menu_logo_font_size', 
		array(
			'label'	=> esc_attr__( 'Font Size', 'page-builder-framework' ),
			'section' => 'title_tagline',
			'settings' => 'menu_logo_font_size_desktop',
			'priority' => 13,
			'active_callback' => function() { return get_theme_mod( 'custom_logo' ) ? false : true; },
		) 
	));

	$wp_customize->add_control( new WPBF_Customize_Font_Size_Control( 
		$wp_customize, 
		'menu_logo_font_size', 
		array(
			'label'	=> esc_attr__( 'Font Size', 'page-builder-framework' ),
			'section' => 'title_tagline',
			'settings' => 'menu_logo_font_size_tablet',
			'priority' => 13,
			'active_callback' => function() { return get_theme_mod( 'custom_logo' ) ? false : true; },
		) 
	));

	$wp_customize->add_control( new WPBF_Customize_Font_Size_Control( 
		$wp_customize, 
		'menu_logo_font_size', 
		array(
			'label'	=> esc_attr__( 'Font Size', 'page-builder-framework' ),
			'section' => 'title_tagline',
			'settings' => 'menu_logo_font_size_mobile',
			'priority' => 13,
			'active_callback' => function() { return get_theme_mod( 'custom_logo' ) ? false : true; },
		) 
	));

	// Tagline
	$wp_customize->add_setting( 'menu_logo_description_font_size_desktop',
		array(
			'sanitize_callback' => 'esc_textarea',
		)
	);

	$wp_customize->add_setting( 'menu_logo_description_font_size_tablet',
		array(
			'sanitize_callback' => 'esc_textarea',
		)
	);

	$wp_customize->add_setting( 'menu_logo_description_font_size_mobile',
		array(
			'sanitize_callback' => 'esc_textarea',
		)
	);

	$wp_customize->add_control( new WPBF_Customize_Font_Size_Control( 
		$wp_customize, 
		'menu_logo_description_font_size', 
		array(
			'label'	=> esc_attr__( 'Font Size', 'page-builder-framework' ),
			'section' => 'title_tagline',
			'settings' => 'menu_logo_description_font_size_desktop',
			'priority' => 23,
			'active_callback' => function() { return !get_theme_mod( 'custom_logo' ) && get_theme_mod( 'menu_logo_description' ) ? true : false; },
		) 
	));

	$wp_customize->add_control( new WPBF_Customize_Font_Size_Control( 
		$wp_customize, 
		'menu_logo_description_font_size', 
		array(
			'label'	=> esc_attr__( 'Font Size', 'page-builder-framework' ),
			'section' => 'title_tagline',
			'settings' => 'menu_logo_description_font_size_tablet',
			'priority' => 23,
			'active_callback' => function() { return !get_theme_mod( 'custom_logo' ) && get_theme_mod( 'menu_logo_description' ) ? true : false; },
		) 
	));

	$wp_customize->add_control( new WPBF_Customize_Font_Size_Control( 
		$wp_customize, 
		'menu_logo_description_font_size', 
		array(
			'label'	=> esc_attr__( 'Font Size', 'page-builder-framework' ),
			'section' => 'title_tagline',
			'settings' => 'menu_logo_description_font_size_mobile',
			'priority' => 23,
			'active_callback' => function() { return !get_theme_mod( 'custom_logo' ) && get_theme_mod( 'menu_logo_description' ) ? true : false; },
		)
	));

	// Sub Menu Padding
	$wp_customize->add_setting( 'sub_menu_padding_top',
		array(
			'default' => '10',
			'sanitize_callback' => 'absint'
		)
	);

	$wp_customize->add_setting( 'sub_menu_padding_right',
		array(
			'default' => '20',
			'sanitize_callback' => 'absint'
		)
	);

	$wp_customize->add_setting( 'sub_menu_padding_bottom',
		array(
			'default' => '10',
			'sanitize_callback' => 'absint'
		)
	);

	$wp_customize->add_setting( 'sub_menu_padding_left',
		array(
			'default' => '20',
			'sanitize_callback' => 'absint'
		)
	);

	$wp_customize->add_control( new WPBF_Customize_Padding_Control( 
		$wp_customize, 
		'sub_menu_padding',
		array(
			'label'	=> esc_attr__( 'Padding', 'page-builder-framework' ),
			'section' => 'wpbf_sub_menu_options',
			'settings' => 'sub_menu_padding_top',
			'priority' => 2,
		)
	));

	$wp_customize->add_control( new WPBF_Customize_Padding_Control( 
		$wp_customize, 
		'sub_menu_padding',
		array(
			'label'	=> esc_attr__( 'Padding', 'page-builder-framework' ),
			'section' => 'wpbf_sub_menu_options',
			'settings' => 'sub_menu_padding_right',
			'priority' => 2,
		)
	));

	$wp_customize->add_control( new WPBF_Customize_Padding_Control( 
		$wp_customize, 
		'sub_menu_padding',
		array(
			'label'	=> esc_attr__( 'Padding', 'page-builder-framework' ),
			'section' => 'wpbf_sub_menu_options',
			'settings' => 'sub_menu_padding_bottom',
			'priority' => 2,
		)
	));

	$wp_customize->add_control( new WPBF_Customize_Padding_Control( 
		$wp_customize, 
		'sub_menu_padding',
		array(
			'label'	=> esc_attr__( 'Padding', 'page-builder-framework' ),
			'section' => 'wpbf_sub_menu_options',
			'settings' => 'sub_menu_padding_left',
			'priority' => 2,
		)
	));

	// Mobile Menu Padding
	$wp_customize->add_setting( 'mobile_menu_padding_top',
		array(
			'default' => '10',
			'sanitize_callback' => 'absint'
		)
	); 

	$wp_customize->add_setting( 'mobile_menu_padding_right',
		array(
			'default' => '20',
			'sanitize_callback' => 'absint'
		)
	); 

	$wp_customize->add_setting( 'mobile_menu_padding_bottom',
		array(
			'default' => '10',
			'sanitize_callback' => 'absint'
		)
	); 

	$wp_customize->add_setting( 'mobile_menu_padding_left',
		array(
			'default' => '20',
			'sanitize_callback' => 'absint'
		)
	); 

	$wp_customize->add_control( new WPBF_Customize_Padding_Control( 
		$wp_customize, 
		'mobile_menu_padding',
		array(
			'label'	=> esc_attr__( 'Menu Item Padding', 'page-builder-framework' ),
			'section' => 'wpbf_mobile_menu_options',
			'settings' => 'mobile_menu_padding_top',
			'priority' => 8,
		)
	));

	$wp_customize->add_control( new WPBF_Customize_Padding_Control( 
		$wp_customize, 
		'mobile_menu_padding',
		array(
			'label'	=> esc_attr__( 'Menu Item Padding', 'page-builder-framework' ),
			'section' => 'wpbf_mobile_menu_options',
			'settings' => 'mobile_menu_padding_right',
			'priority' => 8,
		)
	));

	$wp_customize->add_control( new WPBF_Customize_Padding_Control( 
		$wp_customize, 
		'mobile_menu_padding',
		array(
			'label'	=> esc_attr__( 'Menu Item Padding', 'page-builder-framework' ),
			'section' => 'wpbf_mobile_menu_options',
			'settings' => 'mobile_menu_padding_bottom',
			'priority' => 8,
		)
	));

	$wp_customize->add_control( new WPBF_Customize_Padding_Control( 
		$wp_customize, 
		'mobile_menu_padding',
		array(
			'label'	=> esc_attr__( 'Menu Item Padding', 'page-builder-framework' ),
			'section' => 'wpbf_mobile_menu_options',
			'settings' => 'mobile_menu_padding_left',
			'priority' => 8,
		)
	));

	// Responsive Sidebar Widget Padding
	$responsive_sidebar_padding_settings = array(
		'sidebar_widget_padding_top_desktop', 'sidebar_widget_padding_top_tablet', 'sidebar_widget_padding_top_mobile',
		'sidebar_widget_padding_right_desktop', 'sidebar_widget_padding_right_tablet', 'sidebar_widget_padding_right_mobile',
		'sidebar_widget_padding_bottom_desktop', 'sidebar_widget_padding_bottom_tablet', 'sidebar_widget_padding_bottom_mobile',
		'sidebar_widget_padding_left_desktop', 'sidebar_widget_padding_left_tablet', 'sidebar_widget_padding_left_mobile',
	);

	foreach( $responsive_sidebar_padding_settings as $responsive_sidebar_padding_setting ) {
		$wp_customize->add_setting( $responsive_sidebar_padding_setting,
			array(
				'sanitize_callback' => 'absint'
			)
		);

		$wp_customize->add_control( new WPBF_Customize_Responsive_Padding_Control( 
			$wp_customize, 
			'sidebar_widget_padding',
			array(
				'label'	=> esc_attr__( 'Widget Padding', 'page-builder-framework' ),
				'section' => 'wpbf_sidebar_options',
				'settings' => $responsive_sidebar_padding_setting,
				'priority' => 3,
			)
		));

	}

	// Responsive Post Style Setting (Boxed)
	$archives = apply_filters( 'wpbf_archives', array( 'archive' ) );

	foreach ( $archives as $archive ) {

		$responsive_boxed_style_post_settings = array(
			$archive . '_boxed_padding_top_desktop', $archive . '_boxed_padding_top_tablet', $archive . '_boxed_padding_top_mobile',
			$archive . '_boxed_padding_right_desktop', $archive . '_boxed_padding_right_tablet', $archive . '_boxed_padding_right_mobile',
			$archive . '_boxed_padding_bottom_desktop', $archive . '_boxed_padding_bottom_tablet', $archive . '_boxed_padding_bottom_mobile',
			$archive . '_boxed_padding_left_desktop', $archive . '_boxed_padding_left_tablet', $archive . '_boxed_padding_left_mobile',
		);

		foreach( $responsive_boxed_style_post_settings as $responsive_boxed_style_post_setting ) {
			$wp_customize->add_setting( $responsive_boxed_style_post_setting,
				array(
					'sanitize_callback' => 'absint'
				)
			);

			$wp_customize->add_control( new WPBF_Customize_Responsive_Padding_Control( 
				$wp_customize, 
				$archive . '_boxed_padding',
				array(
					'label'	=> esc_attr__( 'Padding', 'page-builder-framework' ),
					'section' => 'wpbf_' . $archive . '_options',
					'settings' => $responsive_boxed_style_post_setting,
					'priority' => 25,
					'active_callback' => function() use ($archive) { return get_theme_mod( $archive . '_post_style' ) == 'boxed' ? true : false; },
				)
			));

		}

	}

}
add_action( 'customize_register' , 'wpbf_custom_controls_default' );

/* Premium Addon */
do_action( 'wpbf_kirki_premium' );

// kirki Custom Default Fonts
function wpbf_custom_default_fonts( $standard_fonts ) {

	$standard_fonts['helvetica_neue'] = array(
		'label' => 'Helvetica Neue',
		'variants' => array( 'regular', 'italic', '700', '700italic' ),
		'stack' => '"Helvetica Neue", Helvetica, Arial, sans-serif',
	);

	$standard_fonts['helvetica'] = array(
		'label' => 'Helvetica',
		'variants' => array( 'regular', 'italic', '700', '700italic' ),
		'stack' => 'Helvetica, Arial, sans-serif',
	);

	$standard_fonts['arial'] = array(
		'label' => 'Arial',
		'variants' => array( 'regular', 'italic', '700', '700italic' ),
		'stack' => 'Arial, Helvetica, sans-serif',
	);

	return $standard_fonts;

}
add_filter( 'kirki/fonts/standard_fonts', 'wpbf_custom_default_fonts', 0 );