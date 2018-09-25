<?php
/**
 * kirki
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Textdomain
load_theme_textdomain( 'page-builder-framework', get_template_directory() . '/languages' );

// make sure we can use is_plugin_active() here
if( !function_exists( 'is_plugin_active' ) ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

// Default Font Choice
function wpbf_default_font_choices(){
	return array(
		'fonts' => apply_filters( 'wpbf_kirki_font_choices', array() )
	);
}

/* Setup */
add_action( 'customize_register' , 'wpbf_customizer_setup', 20 );
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

/* kirki Configuration */
Kirki::add_config( 'wpbf', array(
	'capability'		=>		'edit_theme_options',
	'option_type'		=>		'theme_mod',
	'disable_output'	=>		true
) );

/* Panels */
if( !is_plugin_active( 'wpbf-premium/wpbf-premium.php' ) ) {

	// Premium Addon
	Kirki::add_section( 'wpbf_premium_addon', array(
		'title'			=>		esc_attr__( 'Premium Features available!', 'page-builder-framework' ),
		'priority'		=>		1,
		'type'			=>		'expanded'
	) );

	$wpbf_premium_ad_link = sprintf(
		/* translators: 1: link target */
		__( 'Get all features with the <a href="%1s" target="_blank">Premium Add-On</a>!', 'page-builder-framework' ),
		esc_url( 'https://wp-pagebuilderframework.com/?utm_source=repository&utm_medium=customizer&utm_campaign=wpbf' )
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

// Fonts
Kirki::add_section( 'wpbf_font_options', array(
	'title'				=>			esc_attr__( 'Text', 'page-builder-framework' ),
	'panel'				=>			'typo_panel',
	'priority'			=>			0,
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

// Blog Settings
Kirki::add_section( 'wpbf_blog_settings', array(
	'title'				=>			esc_attr__( 'Blog Settings', 'page-builder-framework' ),
	'panel'				=>			'layout_panel',
	'priority'			=>			500,
) );

// Breadcrumbs
Kirki::add_section( 'wpbf_breadcrumb_settings', array(
	'title'				=>			esc_attr__( 'Breadcrumbs', 'page-builder-framework' ),
	'panel'				=>			'layout_panel',
	'priority'			=>			600,
) );

/* Sections – Layout */

// Index
Kirki::add_section( 'wpbf_blog_options', array(
	'title'				=>			esc_attr__( 'Blog Layout', 'page-builder-framework' ),
	'panel'				=>			'blog_panel',
	'priority'			=>			100,
) );

// Single
Kirki::add_section( 'wpbf_single_options', array(
	'title'				=>			esc_attr__( 'Post Layout', 'page-builder-framework' ),
	'panel'				=>			'blog_panel',
	'priority'			=>			200,
) );

// Archive Layout
Kirki::add_section( 'wpbf_archive_options', array(
	'title'				=>			esc_attr__( 'Archive Layout', 'page-builder-framework' ),
	'panel'				=>			'blog_panel',
	'priority'			=>			300,
) );

// Category Layout
Kirki::add_section( 'wpbf_category_options', array(
	'title'				=>			esc_attr__( 'Category Layout', 'page-builder-framework' ),
	'panel'				=>			'blog_panel',
	'priority'			=>			400,
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

/* Fields – Blog Settings */

// Author
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'blog_author',
	'label'				=>			esc_attr__( 'Author', 'page-builder-framework' ),
	'section'			=>			'wpbf_blog_settings',
	'default'			=>			'show',
	'priority'			=>			1,
	'multiple'			=>			1,
	'choices'			=>			array(
		'show'			=>			esc_attr__( 'Show', 'page-builder-framework' ),
		'hide'			=>			esc_attr__( 'Hide', 'page-builder-framework' ),
	),
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
		'min'			=>			0,
		'max'			=>			100,
		'step'			=>			1,
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

// Archive
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

/* Fields – Blog (Index) */

// Custom Width
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Custom Content Width', 'page-builder-framework' ),
	'settings'			=>			'blog_custom_width',
	'section'			=>			'wpbf_blog_options',
	'description'		=>			esc_attr__( 'Default: 1200px', 'page-builder-framework' ), 
	'priority'			=>			0,
	'transport'			=>			'postMessage'
) );

// Article Layout
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'blog_layout',
	'label'				=>			esc_attr__( 'Layout', 'page-builder-framework' ),
	'section'			=>			'wpbf_blog_options',
	'default'			=>			'default',
	'priority'			=>			0,
	'multiple'			=>			1,
	'choices'			=>			array(
		'default'		=>			esc_attr__( 'Default', 'page-builder-framework' ),
		'beside'		=>			esc_attr__( 'Image Beside Post', 'page-builder-framework' ),
	),
) );

// Sidebar Layout
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'blog_sidebar_layout',
	'label'				=>			__( 'Sidebar', 'page-builder-framework' ),
	'section'			=>			'wpbf_blog_options',
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

// Blog Header
Kirki::add_field( 'wpbf', array(
	'type'				=>			'sortable',
	'settings'			=>			'blog_sortable_header',
	'label'				=>			esc_attr__( 'Header', 'page-builder-framework' ),
	'section'			=>			'wpbf_blog_options',
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
	'priority'			=>			1,
) );

// Blog Footer
Kirki::add_field( 'wpbf', array(
	'type'				=>			'sortable',
	'settings'			=>			'blog_sortable_footer',
	'label'				=>			esc_attr__( 'Footer', 'page-builder-framework' ),
	'section'			=>			'wpbf_blog_options',
	'default'			=>			array(
		'readmore',
		'categories',
	),
	'choices'			=> array(
		'readmore'		=>			esc_attr__( 'Read More', 'page-builder-framework' ),
		'categories'	=>			esc_attr__( 'Categories', 'page-builder-framework' ),
		'tags'			=>			esc_attr__( 'Tags', 'page-builder-framework' ),
		'comments'		=>			esc_attr__( 'Comments', 'page-builder-framework' ),
	),
	'priority'			=>			2,
) );

/* Fields – Category */

// Custom Width
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Custom Content Width', 'page-builder-framework' ),
	'settings'			=>			'category_custom_width',
	'section'			=>			'wpbf_category_options',
	'description'		=>			esc_attr__( 'Default: 1200px', 'page-builder-framework' ), 
	'priority'			=>			0,
	'transport'			=>			'postMessage'
) );

// Category Headline
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'category_headline',
	'label'				=>			esc_attr__( 'Category Headline', 'page-builder-framework' ),
	'section'			=>			'wpbf_category_options',
	'default'			=>			'show',
	'priority'			=>			0,
	'multiple'			=>			1,
	'choices'			=>			array(
		'show'			=>			esc_attr__( 'Show', 'page-builder-framework' ),
		'hide'			=>			esc_attr__( 'Hide', 'page-builder-framework' ),
	),
) );

// Article Layout
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'category_layout',
	'label'				=>			esc_attr__( 'Layout', 'page-builder-framework' ),
	'section'			=>			'wpbf_category_options',
	'default'			=>			'default',
	'priority'			=>			0,
	'multiple'			=>			1,
	'choices'			=>			array(
		'default'		=>			esc_attr__( 'Default', 'page-builder-framework' ),
		'beside'		=>			esc_attr__( 'Image Beside Post', 'page-builder-framework' ),
	),
) );

// Sidebar Layout
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'category_sidebar_layout',
	'label'				=>			__( 'Sidebar', 'page-builder-framework' ),
	'section'			=>			'wpbf_category_options',
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

// Category Header
Kirki::add_field( 'wpbf', array(
	'type'				=>			'sortable',
	'settings'			=>			'category_sortable_header',
	'label'				=>			esc_attr__( 'Header', 'page-builder-framework' ),
	'section'			=>			'wpbf_category_options',
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
	'priority'			=>			1,
) );

// Category Footer
Kirki::add_field( 'wpbf', array(
	'type'				=>			'sortable',
	'settings'			=>			'category_sortable_footer',
	'label'				=>			esc_attr__( 'Footer', 'page-builder-framework' ),
	'section'			=>			'wpbf_category_options',
	'default'			=>			array(
		'readmore',
		'categories',
	),
	'choices'			=> array(
		'readmore'		=>			esc_attr__( 'Read More', 'page-builder-framework' ),
		'categories'	=>			esc_attr__( 'Categories', 'page-builder-framework' ),
		'tags'			=>			esc_attr__( 'Tags', 'page-builder-framework' ),
		'comments'		=>			esc_attr__( 'Comments', 'page-builder-framework' ),
	),
	'priority'			=>			2,
) );

/* Fields – Archive */

// Custom Width
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Custom Content Width', 'page-builder-framework' ),
	'settings'			=>			'archive_custom_width',
	'section'			=>			'wpbf_archive_options',
	'description'		=>			esc_attr__( 'Default: 1200px', 'page-builder-framework' ), 
	'priority'			=>			0,
	'transport'			=>			'postMessage'
) );

// Archive Headline
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'archive_headline',
	'label'				=>			esc_attr__( 'Archive Headline', 'page-builder-framework' ),
	'section'			=>			'wpbf_archive_options',
	'default'			=>			'show',
	'priority'			=>			0,
	'multiple'			=>			1,
	'choices'			=>			array(
		'show'			=>			esc_attr__( 'Show', 'page-builder-framework' ),
		'hide'			=>			esc_attr__( 'Hide', 'page-builder-framework' ),
	),
) );

// Article Layout
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'archive_layout',
	'label'				=>			esc_attr__( 'Layout', 'page-builder-framework' ),
	'section'			=>			'wpbf_archive_options',
	'default'			=>			'default',
	'priority'			=>			0,
	'multiple'			=>			1,
	'choices'			=>			array(
		'default'		=>			esc_attr__( 'Default', 'page-builder-framework' ),
		'beside'		=>			esc_attr__( 'Image Beside Post', 'page-builder-framework' ),
	),
) );

// Sidebar Layout
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'archive_sidebar_layout',
	'label'				=>			__( 'Sidebar', 'page-builder-framework' ),
	'section'			=>			'wpbf_archive_options',
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

// Archive Header
Kirki::add_field( 'wpbf', array(
	'type'				=>			'sortable',
	'settings'			=>			'archive_sortable_header',
	'label'				=>			esc_attr__( 'Header', 'page-builder-framework' ),
	'section'			=>			'wpbf_archive_options',
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
	'priority'			=>			1,
) );

// Archive Footer
Kirki::add_field( 'wpbf', array(
	'type'				=>			'sortable',
	'settings'			=>			'archive_sortable_footer',
	'label'				=>			esc_attr__( 'Footer', 'page-builder-framework' ),
	'section'			=>			'wpbf_archive_options',
	'default'			=>			array(
		'readmore',
		'categories',
	),
	'choices'			=> array(
		'readmore'		=>			esc_attr__( 'Read More', 'page-builder-framework' ),
		'categories'	=>			esc_attr__( 'Categories', 'page-builder-framework' ),
		'tags'			=>			esc_attr__( 'Tags', 'page-builder-framework' ),
		'comments'		=>			esc_attr__( 'Comments', 'page-builder-framework' ),
	),
	'priority'			=>			2,
) );

/* Fields – Single */

// Custom Width
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

// Single Header
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
	'priority'			=>			1,
) );

// Single Footer
Kirki::add_field( 'wpbf', array(
	'type'				=>			'sortable',
	'settings'			=>			'single_sortable_footer',
	'label'				=>			esc_attr__( 'Footer', 'page-builder-framework' ),
	'section'			=>			'wpbf_single_options',
	'default'			=>			array(
		'categories',
	),
	'choices'			=> array(
		'categories'	=>			esc_attr__( 'Categories', 'page-builder-framework' ),
		'tags'			=>			esc_attr__( 'Tags', 'page-builder-framework' ),
	),
	'priority'			=>			2,
) );

// Author
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'single_author',
	'label'				=>			esc_attr__( 'Author', 'page-builder-framework' ),
	'section'			=>			'wpbf_single_options',
	'default'			=>			'show',
	'priority'			=>			3,
	'multiple'			=>			1,
	'choices'			=>			array(
		'show'			=>			esc_attr__( 'Show', 'page-builder-framework' ),
		'hide'			=>			esc_attr__( 'Hide', 'page-builder-framework' ),
	),
) );

// Previous & Next Post Nav
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'single_post_nav',
	'label'				=>			esc_attr__( 'Post Navigation', 'page-builder-framework' ),
	'section'			=>			'wpbf_single_options',
	'default'			=>			'show',
	'priority'			=>			4,
	'multiple'			=>			1,
	'choices'			=>			array(
		'show'			=>			esc_attr__( 'Show', 'page-builder-framework' ),
		'hide'			=>			esc_attr__( 'Hide', 'page-builder-framework' ),
	),
) );

/* Fields – General */

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
		'step'			=>			'5',
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
		'step'			=>			'5',
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

// Box Shadow Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'page_boxed_box_shadow_color',
	'label'				=>			esc_attr__( 'Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'default'			=>			'rgba(0,0,0,.15)',
	'priority'			=>			7,
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

// Box Shadow Blur
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'page_boxed_box_shadow_blur',
	'label'				=>			esc_attr__( 'Blur', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'priority'			=>			8,
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

// Box Shadow Horizontal
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'page_boxed_box_shadow_horizontal',
	'label'				=>			esc_attr__( 'Horizontal', 'page-builder-framework' ),
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

// Box Shadow Vertical
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'page_boxed_box_shadow_vertical',
	'label'				=>			esc_attr__( 'Vertical', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'priority'			=>			11,
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
	'priority'			=>			12,
) );

// Position
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'scrolltop_position',
	'label'				=>			esc_attr__( 'Position', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'default'			=>			'right',
	'priority'			=>			13,
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
	'label'				=>			esc_attr__( 'Show after', 'page-builder-framework' ),
	'description'		=>			esc_attr__( 'Value in px', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'priority'			=>			14,
	'default'			=>			'400',
	'choices'			=>			array(
		'min'			=>			'50',
		'max'			=>			'1000',
		'step'			=>			'10',
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
	'priority'			=>			14,
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
	'label'				=>			esc_attr__( 'Background Color Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_page_options',
	'priority'			=>			15,
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
	'priority'			=>			16,
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
	'label'				=>			esc_attr__( 'Sidebar Position', 'page-builder-framework' ),
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

// Gap
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'sidebar_gap',
	'label'				=>			esc_attr__( 'Sidebar Gap', 'page-builder-framework' ),
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

// Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'sidebar_bg_color',
	'label'				=>			esc_attr__( 'Widget Background Color', 'page-builder-framework' ),
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
		'alpha'		=>			true,
	),
) );

/* Fields – Buttons */

// Background Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'button_bg_color',
	'label'				=>			esc_attr__( 'Button Background Color', 'page-builder-framework' ),
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
	'label'				=>			esc_attr__( 'Button Font Color', 'page-builder-framework' ),
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
	'label'				=>			esc_attr__( 'Button Background Color Hover', 'page-builder-framework' ),
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
	'label'				=>			esc_attr__( 'Button Font Color Hover', 'page-builder-framework' ),
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
	'label'				=>			esc_attr__( 'Button Primary Background Color', 'page-builder-framework' ),
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
	'label'				=>			esc_attr__( 'Button Primary Font Color', 'page-builder-framework' ),
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
	'label'				=>			esc_attr__( 'Button Primary Background Color Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_button_options',
	'priority'			=>			1,
	// 'default'			=>			'#79c4e0',
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Primary Text Color Alt
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'button_primary_text_color_alt',
	'label'				=>			esc_attr__( 'Button Primary Font Color Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_button_options',
	'priority'			=>			1,
	// 'default'			=>			'#fff',
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
	'default'			=>			'#e7e7ec',
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
	'label'				=>			esc_attr__( 'Border Color Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_button_options',
	'priority'			=>			1,
	'default'			=>			'#d9d9e0',
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
	// 'default'			=>			'#e7e7ec',
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
	'label'				=>			esc_attr__( 'Primary Border Color Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_button_options',
	'priority'			=>			1,
	// 'default'			=>			'#e7e7ec',
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

// Height
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'pre_header_height',
	'label'				=>			esc_attr__( 'Height', 'page-builder-framework' ),
	'section'			=>			'wpbf_pre_header_options',
	'priority'			=>			2,
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

// Column One
Kirki::add_field( 'wpbf', array(
	'type'				=>			'textarea',
	'settings'			=>			'pre_header_column_one',
	'label'				=>			esc_attr__( 'Column 1', 'page-builder-framework' ),
	'section'			=>			'wpbf_pre_header_options',
	'default'			=>			esc_attr__( 'Column 1', 'page-builder-framework' ),
	'priority'			=>			2,
	'active_callback'	=>			array(
		array(
		'setting'		=>			'pre_header_layout',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	)
) );

// Column Two
Kirki::add_field( 'wpbf', array(
	'type'				=>			'textarea',
	'settings'			=>			'pre_header_column_two',
	'label'				=>			esc_attr__( 'Column 2', 'page-builder-framework' ),
	'section'			=>			'wpbf_pre_header_options',
	'default'			=>			esc_attr__( 'Column 2', 'page-builder-framework' ),
	'priority'			=>			3,
	'active_callback'	=>			array(
		array(
		'setting'		=>			'pre_header_layout',
		'operator'		=>			'==',
		'value'			=>			'two',
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
	'priority'			=>			4,
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

/* Fields – Logo */

// Size
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'menu_logo_size',
	'label'				=>			esc_attr__( 'Logo Size (height)', 'page-builder-framework' ),
	'section'			=>			'title_tagline',
	'priority'			=>			2,
	'default'			=>			'48',
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'min'			=>			'10',
		'max'			=>			'200',
		'step'			=>			'1',
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'custom_logo',
		'operator'		=>			'!==',
		'value'			=>			'',
		),
	)
) );

// Size Mobile
// Kirki::add_field( 'wpbf', array(
// 	'type'				=>			'upload',
// 	'settings'			=>			'menu_mobile_logo',
// 	'label'				=>			esc_attr__( 'Mobile Logo', 'page-builder-framework' ),
// 	'section'			=>			'title_tagline',
// 	'priority'			=>			3,
// 	'active_callback'	=>			array(
// 		array(
// 		'setting'		=>			'custom_logo',
// 		'operator'		=>			'!==',
// 		'value'			=>			'',
// 		),
// 	)
// ) );

// Size Mobile
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'menu_mobile_logo_size',
	'label'				=>			esc_attr__( 'Logo Size on mobiles (height)', 'page-builder-framework' ),
	'section'			=>			'title_tagline',
	'priority'			=>			3,
	'default'			=>			'25',
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'min'			=>			'10',
		'max'			=>			'100',
		'step'			=>			'1',
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'custom_logo',
		'operator'		=>			'!==',
		'value'			=>			'',
		),
	)
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-05198',
	'section'			=>			'title_tagline',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			4,
) );

// Font Family
Kirki::add_field( 'wpbf', array(
	'type'				=>			'typography',
	'settings'			=>			'menu_logo_font_family',
	'label'				=>			esc_attr__( 'Font', 'page-builder-framework' ),
	'section'			=>			'title_tagline',
	'default'			=>			array(
		'font-family'	=>			'Helvetica, Arial, sans-serif',
		'variant'		=>			'700',
		'subsets'		=>			array( 'latin-ext' ),
	),
	'choices'			=>			wpbf_default_font_choices(),
	'priority'			=>			10,
	'active_callback'	=>			array(
		array(
		'setting'		=>			'custom_logo',
		'operator'		=>			'==',
		'value'			=>			'',
		),
	)
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

// Font Size
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Font Size', 'page-builder-framework' ),
	'settings'			=>			'menu_logo_font_size',
	'section'			=>			'title_tagline',
	'priority'			=>			13,
	'default'			=>			'22px',
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

// Font Family
Kirki::add_field( 'wpbf', array(
	'type'				=>			'typography',
	'settings'			=>			'menu_logo_description_font_family',
	'label'				=>			esc_attr__( 'Font', 'page-builder-framework' ),
	'section'			=>			'title_tagline',
	'default'			=>			array(
		'font-family'	=>			'Helvetica, Arial, sans-serif',
		'variant'		=>			'700',
		'subsets'		=>			array( 'latin-ext' ),
	),
	'choices'			=>			wpbf_default_font_choices(),
	'priority'			=>			21,
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

// Font Size
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Font Size', 'page-builder-framework' ),
	'settings'			=>			'menu_logo_description_font_size',
	'section'			=>			'title_tagline',
	'priority'			=>			23,
	'transport'			=>			'postMessage',
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
	'type'				=>			'text',
	'settings'			=>			'menu_logo_url',
	'label'				=>			esc_attr__( 'Custom Logo URL', 'page-builder-framework' ),
	'description'		=>			esc_attr__( 'URL including http:// or https://', 'page-builder-framework' ),
	'section'			=>			'title_tagline',
	'transport'			=>			'postMessage',
	'priority'			=>			30,
) );

// Alt Tag
Kirki::add_field( 'wpbf', array(
	'type'				=>			'text',
	'settings'			=>			'menu_logo_alt',
	'label'				=>			esc_attr__( 'Custom alt tag (optional)', 'page-builder-framework' ),
	'section'			=>			'title_tagline',
	'priority'			=>			31,
	'description'		=>			esc_attr__( 'If not declared, the site title will be used', 'page-builder-framework' ),
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
	'label'				=>			esc_attr__( 'Title tag (optional)', 'page-builder-framework' ),
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
		'min'			=>			'25',
		'max'			=>			'75',
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
	'priority'			=>			2,
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
		array(
		'setting'		=>			'menu_position',
		'operator'		=>			'!=',
		'value'			=>			'menu-full-screen',
		),
	)
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

/* Fields – Sub Menu */

// Alignment
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'sub_menu_alignment',
	'label'				=>			esc_attr__( 'Sub Menu Alignment', 'page-builder-framework' ),
	'section'			=>			'wpbf_sub_menu_options',
	'default'			=>			'left',
	'priority'			=>			1,
	'multiple'			=>			1,
	'choices'			=>			array(
		'left'			=>			esc_attr__( 'Left (default)', 'page-builder-framework' ),
		'right'			=>			esc_attr__( 'Right', 'page-builder-framework' ),
		'center'		=>			esc_attr__( 'Center', 'page-builder-framework' ),
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
	'label'				=>			esc_attr__( 'Background Color Hover', 'page-builder-framework' ),
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
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Font Size', 'page-builder-framework' ),
	'settings'			=>			'sub_menu_font_size',
	'section'			=>			'wpbf_sub_menu_options',
	'priority'			=>			6,
	'transport'			=>			'postMessage',
) );

/* Fields – Mobile Navigation */

// Variations
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'mobile_menu_options',
	'label'				=>			esc_attr__( 'Menu Options', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'default'			=>			'menu-mobile-hamburger',
	'priority'			=>			1,
	'multiple'			=>			1,
	'choices'			=>			apply_filters( 'wpbf_mobile_menu_options', array(
		'menu-mobile-hamburger'		=>			esc_attr__( 'Hamburger', 'page-builder-framework' ),
		'menu-mobile-default'		=>			esc_attr__( 'Default', 'page-builder-framework' ),
	) ),
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

// Hamburger Size
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'mobile_menu_hamburger_size',
	'label'				=>			esc_attr__( 'Hamburger Icon Size', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'default'			=>			'16',
	'priority'			=>			3,
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'min'			=>			'16',
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
	'label'				=>			esc_attr__( 'Hamburger Icon Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'default'			=>			'#6d7680',
	'priority'			=>			4,
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

// Background Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'mobile_menu_background_color',
	'label'				=>			esc_attr__( 'Background Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'priority'			=>			5,
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
	'label'				=>			esc_attr__( 'Menu Item Background Color Hover', 'page-builder-framework' ),
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
	'label'				=>			esc_attr__( 'Submenu Arrow Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_mobile_menu_options',
	'priority'			=>			14,
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Font Size
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Font Size', 'page-builder-framework' ),
	'settings'			=>			'mobile_menu_font_size',
	'section'			=>			'wpbf_mobile_menu_options',
	'priority'			=>			15,
	'default'			=>			'16px',
) );

/* Fields – Footer */

// Footer Height
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'footer_height',
	'label'				=>			esc_attr__( 'Height', 'page-builder-framework' ),
	'section'			=>			'wpbf_footer_options',
	'priority'			=>			4,
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
	'priority'			=>			4,
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
	'default'			=>			'#6D7680',
	'transport'			=>			'postMessage',
	'priority'			=>			5,
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
	'priority'			=>			6,
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

// Font Size
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Font Size', 'page-builder-framework' ),
	'settings'			=>			'footer_font_size',
	'section'			=>			'wpbf_footer_options',
	'priority'			=>			8,
	'default'			=>			'14px',
	'transport'			=>			'postMessage',
	'active_callback'	=>			array(
		array(
		'setting'		=>			'footer_layout',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	)
) );

/* Custom Controls */
add_action( 'customize_register' , 'wpbf_custom_controls_default' );

function wpbf_custom_controls_default( $wp_customize ) {

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

	// Sidebar Widget Padding
	$wp_customize->add_setting( 'sidebar_widget_padding_top',
		array(
			'default' => '20',
			'sanitize_callback' => 'absint'
		)
	); 

	$wp_customize->add_setting( 'sidebar_widget_padding_right',
		array(
			'default' => '20',
			'sanitize_callback' => 'absint'
		)
	); 

	$wp_customize->add_setting( 'sidebar_widget_padding_bottom',
		array(
			'default' => '20',
			'sanitize_callback' => 'absint'
		)
	); 

	$wp_customize->add_setting( 'sidebar_widget_padding_left',
		array(
			'default' => '20',
			'sanitize_callback' => 'absint'
		)
	); 

	$wp_customize->add_control( new WPBF_Customize_Padding_Control( 
		$wp_customize, 
		'mobile_menu_padding',
		array(
			'label'	=> esc_attr__( 'Sidebar Widget Padding', 'page-builder-framework' ),
			'section' => 'wpbf_sidebar_options',
			'settings' => 'sidebar_widget_padding_top',
			'priority' => 3,
		)
	));

	$wp_customize->add_control( new WPBF_Customize_Padding_Control( 
		$wp_customize, 
		'mobile_menu_padding',
		array(
			'label'	=> esc_attr__( 'Sidebar Widget Padding', 'page-builder-framework' ),
			'section' => 'wpbf_sidebar_options',
			'settings' => 'sidebar_widget_padding_right',
			'priority' => 3,
		)
	));

	$wp_customize->add_control( new WPBF_Customize_Padding_Control( 
		$wp_customize, 
		'mobile_menu_padding',
		array(
			'label'	=> esc_attr__( 'Sidebar Widget Padding', 'page-builder-framework' ),
			'section' => 'wpbf_sidebar_options',
			'settings' => 'sidebar_widget_padding_bottom',
			'priority' => 3,
		)
	));

	$wp_customize->add_control( new WPBF_Customize_Padding_Control( 
		$wp_customize, 
		'mobile_menu_padding',
		array(
			'label'	=> esc_attr__( 'Sidebar Widget Padding', 'page-builder-framework' ),
			'section' => 'wpbf_sidebar_options',
			'settings' => 'sidebar_widget_padding_left',
			'priority' => 3,
		)
	));

}

/* Premium Addon */
do_action( 'wpbf_kirki_premium' );

// Kirki Custom Default Fonts
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