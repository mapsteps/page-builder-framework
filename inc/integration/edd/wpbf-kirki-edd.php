<?php
/**
 * kirki EDD
 *
 * @package Page Builder Framework
 * @subpackage Integration/EDD
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Textdomain
load_theme_textdomain( 'page-builder-framework', get_template_directory() . '/languages' );

/* Panels */

// Easy Digital Downloads
Kirki::add_panel( 'edd_panel', array(
	'priority'			=>		200,
	'title'				=>		esc_attr__( 'Easy Digital Downloads', 'page-builder-framework' ),
) );

/* Sections */

// Menu Item
Kirki::add_section( 'wpbf_edd_menu_item_options', array(
	'title'				=>			__( 'Menu Item', 'page-builder-framework' ),
	'panel'				=>			'edd_panel',
	'priority'			=>			1,
) );

// Sidebar
Kirki::add_section( 'wpbf_edd_sidebar_options', array(
	'title'				=>			__( 'Sidebar', 'page-builder-framework' ),
	'panel'				=>			'edd_panel',
	'priority'			=>			2,
) );

/* Fields – Sidebar */

// Shop Sidebar Layout
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'edd_sidebar_layout',
	'label'				=>			__( 'Shop Page Sidebar', 'page-builder-framework' ),
	'section'			=>			'wpbf_edd_sidebar_options',
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

// Product Sidebar Layout
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'edd_single_sidebar_layout',
	'label'				=>			__( 'Product Page Sidebar', 'page-builder-framework' ),
	'section'			=>			'wpbf_edd_sidebar_options',
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

/* Fields – Menu Item */

// Hide from non EDD-Pages
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'edd_menu_item_hide_if_not_edd',
	'label'				=>			esc_attr__( 'Hide from non-Shop Pages', 'page-builder-framework' ),
	'description'		=>			__( 'Display Menu Item only on EDD related pages', 'page-builder-framework' ),
	'section'			=>			'wpbf_edd_menu_item_options',
	'default'			=>			0,
	'priority'			=>			5,
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-76314',
	'section'			=>			'wpbf_edd_menu_item_options',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			5,
) );

// Menu Item
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'edd_menu_item_desktop',
	'label'				=>			esc_attr__( 'Visibility (Desktop)', 'page-builder-framework' ),
	'description'		=>			__( 'Adds a Cart Icon to your Main Navigation', 'page-builder-framework' ),
	'section'			=>			'wpbf_edd_menu_item_options',
	'default'			=>			'show',
	'priority'			=>			10,
	'multiple'			=>			1,
	'choices'			=>			array(
		'show'			=>			esc_attr__( 'Show', 'page-builder-framework' ),
		'hide'			=>			esc_attr__( 'Hide', 'page-builder-framework' ),
	),
) );

// Menu Item Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'edd_menu_item_desktop_color',
	'label'				=>			esc_attr__( 'Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_edd_menu_item_options',
	'default'			=>			'',
	'priority'			=>			11,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'edd_menu_item_desktop',
		'operator'		=>			'!=',
		'value'			=>			'hide',
		),
		array(
		'setting'		=>			'edd_menu_item_count',
		'operator'		=>			'!=',
		'value'			=>			'hide',
		),
	)
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-71253',
	'section'			=>			'wpbf_edd_menu_item_options',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			12,
) );

// Mobile Menu Item
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'edd_menu_item_mobile',
	'label'				=>			esc_attr__( 'Visibility (Mobile)', 'page-builder-framework' ),
	'description'		=>			__( 'Adds a Cart Icon to your Mobile Navigation', 'page-builder-framework' ),
	'section'			=>			'wpbf_edd_menu_item_options',
	'default'			=>			'show',
	'priority'			=>			13,
	'multiple'			=>			1,
	'choices'			=>			array(
		'show'			=>			esc_attr__( 'Show', 'page-builder-framework' ),
		'hide'			=>			esc_attr__( 'Hide', 'page-builder-framework' ),
	),
) );

// Menu Item Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'edd_menu_item_mobile_color',
	'label'				=>			esc_attr__( 'Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_edd_menu_item_options',
	'default'			=>			'',
	'priority'			=>			14,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'edd_menu_item_mobile',
		'operator'		=>			'!=',
		'value'			=>			'hide',
		),
		array(
		'setting'		=>			'edd_menu_item_count',
		'operator'		=>			'!=',
		'value'			=>			'hide',
		),
	)
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-51073',
	'section'			=>			'wpbf_edd_menu_item_options',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			15,
) );

// Menu Item Count
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'edd_menu_item_count',
	'label'				=>			esc_attr__( 'Count', 'page-builder-framework' ),
	'section'			=>			'wpbf_edd_menu_item_options',
	'default'			=>			'show',
	'priority'			=>			16,
	'multiple'			=>			1,
	'choices'			=>			array(
		'show'			=>			esc_attr__( 'Show', 'page-builder-framework' ),
		'hide'			=>			esc_attr__( 'Hide', 'page-builder-framework' ),
	),
) );