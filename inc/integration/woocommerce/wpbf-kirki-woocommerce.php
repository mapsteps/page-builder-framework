<?php
/**
 * kirki WooCommerce
 *
 * @package Page Builder Framework
 * @subpackage Integration/WooCommerce
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Textdomain
load_theme_textdomain( 'page-builder-framework', get_template_directory() . '/languages' );

/* kirki Configuration */
Kirki::add_config( 'wpbf', array(
	'capability'		=>			'edit_theme_options',
	'option_type'		=>			'theme_mod',
	'disable_output'	=>			true
) );

/* Sections – WooCommerce */

// Sidebar
Kirki::add_section( 'wpbf_woocommerce_sidebar_options', array(
	'title'				=>			__( 'Sidebar', 'page-builder-framework' ),
	'panel'				=>			'woocommerce',
	'priority'			=>			30,
) );

// Product Page
Kirki::add_section( 'wpbf_woocommerce_product_options', array(
	'title'				=>			__( 'Product Page', 'page-builder-framework' ),
	'panel'				=>			'woocommerce',
	'priority'			=>			40,
) );

// Checkout
Kirki::add_section( 'wpbf_woocommerce_checkout_options', array(
	'title'				=>			__( 'Checkout Page', 'page-builder-framework' ),
	'panel'				=>			'woocommerce',
	'priority'			=>			50,
) );

/* Fields – Sidebar */

// Shop Sidebar Layout
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'woocommerce_sidebar_layout',
	'label'				=>			esc_attr__( 'Shop Page Sidebar', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_sidebar_options',
	'default'			=>			'none',
	'priority'			=>			0,
	'multiple'			=>			1,
	'choices'			=>			array(
		'right'			=>			esc_attr__( 'Right', 'page-builder-framework' ),
		'left'			=>			esc_attr__( 'Left', 'page-builder-framework' ),
		'none'			=>			esc_attr__( 'No Sidebar', 'page-builder-framework' ),
	),
) );

// Product Sidebar Layout
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'woocommerce_single_sidebar_layout',
	'label'				=>			esc_attr__( 'Product Page Sidebar', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_sidebar_options',
	'default'			=>			'none',
	'priority'			=>			1,
	'multiple'			=>			1,
	'choices'			=>			array(
		'right'			=>			esc_attr__( 'Right', 'page-builder-framework' ),
		'left'			=>			esc_attr__( 'Left', 'page-builder-framework' ),
		'none'			=>			esc_attr__( 'No Sidebar', 'page-builder-framework' ),
	),
) );

/* Fields – Shop & Archive Pages */

Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-56123',
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			11,
) );

// Remove Page Title
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'woocommerce_loop_show_page_title',
	'label'				=>			esc_attr__( 'Show Page Title', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			0,
	'priority'			=>			11,
) );

// Remove Breadcrumbs
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'woocommerce_loop_show_breadcrumbs',
	'label'				=>			esc_attr__( 'Show Breadcrumbs', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			0,
	'priority'			=>			11,
) );

// Remove Result Count
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'woocommerce_loop_remove_result_count',
	'label'				=>			esc_attr__( 'Hide Result Count', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			0,
	'priority'			=>			11,
) );

// Remove Ordering
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'woocommerce_loop_remove_ordering',
	'label'				=>			esc_attr__( 'Hide Ordering', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			0,
	'priority'			=>			11,
) );

Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-72124',
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			11,
) );

// Content Alignment
Kirki::add_field( 'wpbf', array(
	'type'				=>			'radio-image',
	'settings'			=>			'woocommerce_loop_content_alignment',
	'label'				=>			esc_attr__( 'Content Alignment', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			'left',
	'priority'			=>			11,
	'multiple'			=>			1,
	'choices'			=>			array(
		'left'			=>			WPBF_PREMIUM_URI . '/inc/customizer/img/align-left.jpg',
		'center'		=>			WPBF_PREMIUM_URI . '/inc/customizer/img/align-center.jpg',
		'right'			=>			WPBF_PREMIUM_URI . '/inc/customizer/img/align-right.jpg',
	),
) );

// Remove Star Rating
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'woocommerce_loop_remove_star_rating',
	'label'				=>			esc_attr__( 'Hide Star Rating', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			0,
	'priority'			=>			12,
) );

// Remove Add to Cart Button
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'woocommerce_loop_remove_button',
	'label'				=>			esc_attr__( 'Hide "Add to cart" Button', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			0,
	'priority'			=>			13,
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-56377',
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			14,
) );

// Sale Position
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'woocommerce_loop_sale_position',
	'label'				=>			esc_attr__( 'Sale Badge', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			'outside',
	'priority'			=>			15,
	'multiple'			=>			1,
	'choices'			=>			array(
		'outside'		=>			esc_attr__( 'Outside', 'page-builder-framework' ),
		'inside'		=>			esc_attr__( 'Inside', 'page-builder-framework' ),
		'none'			=>			esc_attr__( 'Hide', 'page-builder-framework' ),
	),
) );

// Sale Alignment
Kirki::add_field( 'wpbf', array(
	'type'				=>			'radio-image',
	'settings'			=>			'woocommerce_loop_sale_alignment',
	'label'				=>			esc_attr__( 'Sale Badge Alignment', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			'right',
	'priority'			=>			16,
	'multiple'			=>			1,
	'choices'			=>			array(
		'left'			=>			WPBF_PREMIUM_URI . '/inc/customizer/img/align-left.jpg',
		'center'		=>			WPBF_PREMIUM_URI . '/inc/customizer/img/align-center.jpg',
		'right'			=>			WPBF_PREMIUM_URI . '/inc/customizer/img/align-right.jpg',
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'woocommerce_loop_sale_position',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	)
) );

/* Fields – Product Page */

// Alignment
Kirki::add_field( 'wpbf', array(
	'type'				=>			'radio-image',
	'settings'			=>			'woocommerce_product_alignment',
	'label'				=>			esc_attr__( 'Image Alignment', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_product_options',
	'default'			=>			'left',
	'priority'			=>			1,
	'multiple'			=>			1,
	'choices'			=>			array(
		'left'			=>			WPBF_PREMIUM_URI . '/inc/customizer/img/align-left.jpg',
		'right'			=>			WPBF_PREMIUM_URI . '/inc/customizer/img/align-right.jpg',
	)
) );

/* Fields – Checkout Page */

// Alignment
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'woocommerce_checkout_layout',
	'label'				=>			esc_attr__( 'Layout', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_checkout_options',
	'default'			=>			'default',
	'priority'			=>			1,
	'multiple'			=>			1,
	'choices'			=>			array(
		'default'		=>			esc_attr__( 'Default', 'page-builder-framework' ),
		'side'			=>			esc_attr__( 'Side by Side', 'page-builder-framework' ),
		'multistep'		=>			esc_attr__( 'Multi-Step Checkout', 'page-builder-framework' ),
	)
) );