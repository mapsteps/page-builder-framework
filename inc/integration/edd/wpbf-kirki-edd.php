<?php
/**
 * Easy Digital Downloads customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Integration/EDD
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Textdomain. This is required, otherwise strings aren't translateable.
load_theme_textdomain( 'page-builder-framework' );

/* Panels */

// Easy Digital Downloads.
Kirki::add_panel( 'edd_panel', array(
	'priority' => 200,
	'title'    => __( 'Easy Digital Downloads', 'page-builder-framework' ),
) );

/* Sections */

// Menu item.
Kirki::add_section( 'wpbf_edd_menu_item_options', array(
	'title'    => __( 'Cart Menu Item', 'page-builder-framework' ),
	'panel'    => 'edd_panel',
	'priority' => 1,
) );

// Sidebar.
Kirki::add_section( 'wpbf_edd_sidebar_options', array(
	'title'    => __( 'Sidebar', 'page-builder-framework' ),
	'panel'    => 'edd_panel',
	'priority' => 2,
) );

/* Fields – Sidebar */

// Shop sidebar layout.
Kirki::add_field( 'wpbf', array(
	'type'     => 'select',
	'settings' => 'edd_sidebar_layout',
	'label'    => __( 'Shop Page Sidebar', 'page-builder-framework' ),
	'section'  => 'wpbf_edd_sidebar_options',
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

// Product sidebar layout.
Kirki::add_field( 'wpbf', array(
	'type'     => 'select',
	'settings' => 'edd_single_sidebar_layout',
	'label'    => __( 'Product Page Sidebar', 'page-builder-framework' ),
	'section'  => 'wpbf_edd_sidebar_options',
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

/* Fields – Menu Item */

// Hide from non-EDD pages.
Kirki::add_field( 'wpbf', array(
	'type'        => 'toggle',
	'settings'    => 'edd_menu_item_hide_if_not_edd',
	'label'       => __( 'Hide from non-Shop Pages', 'page-builder-framework' ),
	'description' => __( 'Display Menu Item only on EDD related pages', 'page-builder-framework' ),
	'section'     => 'wpbf_edd_menu_item_options',
	'default'     => 0,
	'priority'    => 5,
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-76314',
	'section'  => 'wpbf_edd_menu_item_options',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 5,
) );

// Menu item.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'edd_menu_item_desktop',
	'label'           => __( 'Visibility (Desktop)', 'page-builder-framework' ),
	'description'     => __( 'Adds a Cart Icon to your Main Navigation', 'page-builder-framework' ),
	'section'         => 'wpbf_edd_menu_item_options',
	'default'         => 'show',
	'priority'        => 10,
	'multiple'        => 1,
	'choices'         => array(
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	),
	'partial_refresh' => array(
		'eddmenuitemdesktop' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );

// Menu item color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'edd_menu_item_desktop_color',
	'label'           => __( 'Color', 'page-builder-framework' ),
	'section'         => 'wpbf_edd_menu_item_options',
	'default'         => '',
	'priority'        => 11,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'edd_menu_item_desktop',
			'operator' => '!=',
			'value'    => 'hide',
		),
		array(
			'setting'  => 'edd_menu_item_count',
			'operator' => '!=',
			'value'    => 'hide',
		),
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-71253',
	'section'  => 'wpbf_edd_menu_item_options',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 12,
) );

// Mobile menu item.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'edd_menu_item_mobile',
	'label'           => __( 'Visibility (Mobile)', 'page-builder-framework' ),
	'description'     => __( 'Adds a Cart Icon to your Mobile Navigation', 'page-builder-framework' ),
	'section'         => 'wpbf_edd_menu_item_options',
	'default'         => 'show',
	'priority'        => 13,
	'multiple'        => 1,
	'choices'         => array(
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	),
	'partial_refresh' => array(
		'eddmenuitemmobile' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );

// Menu item color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'edd_menu_item_mobile_color',
	'label'           => __( 'Color', 'page-builder-framework' ),
	'section'         => 'wpbf_edd_menu_item_options',
	'default'         => '',
	'priority'        => 14,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'edd_menu_item_mobile',
			'operator' => '!=',
			'value'    => 'hide',
		),
		array(
			'setting'  => 'edd_menu_item_count',
			'operator' => '!=',
			'value'    => 'hide',
		),
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-51073',
	'section'  => 'wpbf_edd_menu_item_options',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 15,
) );

// Menu item count.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'edd_menu_item_count',
	'label'           => __( 'Count', 'page-builder-framework' ),
	'section'         => 'wpbf_edd_menu_item_options',
	'default'         => 'show',
	'priority'        => 16,
	'multiple'        => 1,
	'choices'         => array(
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	),
	'partial_refresh' => array(
		'eddmenuitemcount' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );
