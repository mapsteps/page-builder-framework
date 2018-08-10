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

/* Setup */
add_action( 'customize_register' , 'wpbf_woo_customizer_setup', 20 );
function wpbf_woo_customizer_setup( $wp_customize ) {

	// change section priorities
	$wp_customize->get_section( 'woocommerce_store_notice' )->priority = 10;
	$wp_customize->get_section( 'woocommerce_product_images' )->priority = 20;
	$wp_customize->get_section( 'woocommerce_product_catalog' )->priority = 30;
	$wp_customize->get_section( 'woocommerce_checkout' )->priority = 50;

	// change section title
	$wp_customize->get_section( 'woocommerce_product_catalog' )->title = esc_attr__( 'Shop Page', 'page-builder-framework' );

}

/* kirki Configuration */
Kirki::add_config( 'wpbf', array(
	'capability'		=>			'edit_theme_options',
	'option_type'		=>			'theme_mod',
	'disable_output'	=>			true
) );

/* Sections – WooCommerce */

// Menu Item
Kirki::add_section( 'wpbf_woocommerce_menu_item_options', array(
	'title'				=>			__( 'Menu Item', 'page-builder-framework' ),
	'panel'				=>			'woocommerce',
	'priority'			=>			25,
) );

// Product Page
Kirki::add_section( 'wpbf_woocommerce_product_options', array(
	'title'				=>			__( 'Product Page', 'page-builder-framework' ),
	'panel'				=>			'woocommerce',
	'priority'			=>			40,
) );

// Sidebar
Kirki::add_section( 'wpbf_woocommerce_sidebar_options', array(
	'title'				=>			__( 'Sidebar', 'page-builder-framework' ),
	'panel'				=>			'woocommerce',
	'priority'			=>			60,
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

/* Fields – Menu Item */

// Menu Item
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'woocommerce_menu_item_desktop',
	'label'				=>			esc_attr__( 'Visibility (Desktop)', 'page-builder-framework' ),
	'description'		=>			__( 'Adds a cart icon to your main navigation', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_menu_item_options',
	'default'			=>			'show',
	'priority'			=>			0,
	'multiple'			=>			1,
	'choices'			=>			array(
		'show'			=>			esc_attr__( 'Show', 'page-builder-framework' ),
		'hide'			=>			esc_attr__( 'Hide', 'page-builder-framework' ),
	),
) );

// Menu Item Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'woocommerce_menu_item_desktop_color',
	'label'				=>			esc_attr__( 'Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_menu_item_options',
	'default'			=>			'',
	'priority'			=>			2,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'woocommerce_menu_item_desktop',
		'operator'		=>			'!=',
		'value'			=>			'hide',
		),
		array(
		'setting'		=>			'woocommerce_menu_item_count',
		'operator'		=>			'!=',
		'value'			=>			'hide',
		),
	)
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-75733',
	'section'			=>			'wpbf_woocommerce_menu_item_options',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			3,
) );

// Mobile Menu Item
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'woocommerce_menu_item_mobile',
	'label'				=>			esc_attr__( 'Visibility (Mobile)', 'page-builder-framework' ),
	'description'		=>			__( 'Adds a cart icon to your mobile navigation', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_menu_item_options',
	'default'			=>			'show',
	'priority'			=>			4,
	'multiple'			=>			1,
	'choices'			=>			array(
		'show'			=>			esc_attr__( 'Show', 'page-builder-framework' ),
		'hide'			=>			esc_attr__( 'Hide', 'page-builder-framework' ),
	),
) );

// Menu Item Font Size
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Font Size', 'page-builder-framework' ),
	'settings'			=>			'woocommerce_menu_item_mobile_font_size',
	'section'			=>			'wpbf_woocommerce_menu_item_options',
	'transport'			=>			'postMessage',
	'priority'			=>			4,
	'default'			=>			'',
	'active_callback'	=>			array(
		array(
		'setting'		=>			'woocommerce_menu_item_mobile',
		'operator'		=>			'!=',
		'value'			=>			'hide',
		)
	)
) );


// Menu Item Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'woocommerce_menu_item_mobile_color',
	'label'				=>			esc_attr__( 'Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_menu_item_options',
	'default'			=>			'',
	'priority'			=>			4,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'woocommerce_menu_item_mobile',
		'operator'		=>			'!=',
		'value'			=>			'hide',
		),
		array(
		'setting'		=>			'woocommerce_menu_item_count',
		'operator'		=>			'!=',
		'value'			=>			'hide',
		),
	)
) );

// Menu Item Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'woocommerce_menu_item_mobile_icon_color',
	'label'				=>			esc_attr__( 'Icon Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_menu_item_options',
	'default'			=>			'',
	'priority'			=>			4,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'woocommerce_menu_item_mobile',
		'operator'		=>			'!=',
		'value'			=>			'hide',
		),
	)
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-36652',
	'section'			=>			'wpbf_woocommerce_menu_item_options',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			5,
) );

// Menu Item Count
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'woocommerce_menu_item_count',
	'label'				=>			esc_attr__( 'Count', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_menu_item_options',
	'default'			=>			'show',
	'priority'			=>			6,
	'multiple'			=>			1,
	'choices'			=>			array(
		'show'			=>			esc_attr__( 'Show', 'page-builder-framework' ),
		'hide'			=>			esc_attr__( 'Hide', 'page-builder-framework' ),
	),
) );

/* Fields – Shop & Archive Pages (Loop) */

$loop_priority = 10;

// Custom Width
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Custom Content Width', 'page-builder-framework' ),
	'settings'			=>			'woocommerce_loop_custom_width',
	'section'			=>			'woocommerce_product_catalog',
	'description'		=>			esc_attr__( 'Default: 1200px', 'page-builder-framework' ), 
	'priority'			=>			$loop_priority++,
	'transport'			=>			'postMessage'
) );

Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-56123',
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			$loop_priority++,
) );

// Remove Page Title
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'woocommerce_loop_remove_page_title',
	'label'				=>			esc_attr__( 'Hide Page Title', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			0,
	'priority'			=>			$loop_priority++,
) );

// Remove Breadcrumbs
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'woocommerce_loop_remove_breadcrumbs',
	'label'				=>			esc_attr__( 'Hide Breadcrumbs', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			0,
	'priority'			=>			$loop_priority++,
) );

// Remove Result Count
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'woocommerce_loop_remove_result_count',
	'label'				=>			esc_attr__( 'Hide Result Count', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			0,
	'priority'			=>			$loop_priority++,
) );

// Remove Ordering
Kirki::add_field( 'wpbf', array(
	'type'				=>			'toggle',
	'settings'			=>			'woocommerce_loop_remove_ordering',
	'label'				=>			esc_attr__( 'Hide Ordering', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			0,
	'priority'			=>			$loop_priority++,
) );

Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-72124',
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			$loop_priority++,
) );

add_action( 'customize_register' , 'wpbf_woo_custom_controls_default' );

function wpbf_woo_custom_controls_default( $wp_customize ) {

	$loop_priority = 15;

	$wp_customize->add_setting( 'woocommerce_loop_products_per_row_desktop',
		array(
			'default' => '4',
			'sanitize_callback' => 'absint'
		)
	); 

	$wp_customize->add_setting( 'woocommerce_loop_products_per_row_tablet',
		array(
			'default' => '2',
			'sanitize_callback' => 'absint'
		)
	); 

	$wp_customize->add_setting( 'woocommerce_loop_products_per_row_mobile',
		array(
			'sanitize_callback' => 'absint'
		)
	); 

	$wp_customize->add_control( new WPBF_Customize_Font_Size_Control( 
		$wp_customize, 
		'woocommerce_loop_products_per_row', 
		array(
			'label'	=> esc_attr__( 'Products per Row', 'page-builder-framework' ),
			'section' => 'woocommerce_product_catalog',
			'settings' => 'woocommerce_loop_products_per_row_desktop',
			'priority' => $loop_priority++,
		) 
	));

	$wp_customize->add_control( new WPBF_Customize_Font_Size_Control( 
		$wp_customize, 
		'woocommerce_loop_products_per_row', 
		array(
			'label'	=> esc_attr__( 'Products per Row', 'page-builder-framework' ),
			'section' => 'woocommerce_product_catalog',
			'settings' => 'woocommerce_loop_products_per_row_tablet',
			'priority' => $loop_priority++,
		) 
	));

	$wp_customize->add_control( new WPBF_Customize_Font_Size_Control( 
		$wp_customize, 
		'woocommerce_loop_products_per_row', 
		array(
			'label'	=> esc_attr__( 'Products per Row', 'page-builder-framework' ),
			'section' => 'woocommerce_product_catalog',
			'settings' => 'woocommerce_loop_products_per_row_mobile',
			'priority' => $loop_priority++,
		) 
	));

}

// Gap
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'woocommerce_loop_grid_gap',
	'label'				=>			esc_attr__( 'Grid Gap', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			'large',
	'priority'			=>			$loop_priority++,
	'multiple'			=>			1,
	'choices'			=>			array(
		'small'			=>			esc_attr__( 'Small', 'page-builder-framework' ),
		'medium'		=>			esc_attr__( 'Medium', 'page-builder-framework' ),
		'large'			=>			esc_attr__( 'Large', 'page-builder-framework' ),
		'xlarge'		=>			esc_attr__( 'xLarge', 'page-builder-framework' ),
		'collapse'		=>			esc_attr__( 'Collapse', 'page-builder-framework' ),
	),
) );

// Content Alignment
Kirki::add_field( 'wpbf', array(
	'type'				=>			'radio-image',
	'settings'			=>			'woocommerce_loop_content_alignment',
	'label'				=>			esc_attr__( 'Content Alignment', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			'left',
	'priority'			=>			$loop_priority++,
	'multiple'			=>			1,
	'choices'			=>			array(
		'left'			=>			WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center'		=>			WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'			=>			WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	),
) );

// Product Structure
Kirki::add_field( 'wpbf', array(
	'type'				=>			'sortable',
	'settings'			=>			'woocommerce_loop_sortable_content',
	'label'				=>			esc_attr__( 'Structure', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			array(
		'category',
		'title',
		'price',
		'add_to_cart'
	),
	'choices'			=> array(
		'category'		=>			esc_attr__( 'Category', 'page-builder-framework' ),
		'title'			=>			esc_attr__( 'Title', 'page-builder-framework' ),
		'rating'		=>			esc_attr__( 'Rating', 'page-builder-framework' ),
		'price'			=>			esc_attr__( 'Price', 'page-builder-framework' ),
		'add_to_cart'	=>			esc_attr__( 'Add to Cart Button', 'page-builder-framework' ),
		'excerpt'		=>			esc_attr__( 'Short Description', 'page-builder-framework' ),
	),
	'priority'			=>			$loop_priority++,
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-56377',
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			$loop_priority++,
) );

// Sale Position
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'woocommerce_loop_sale_position',
	'label'				=>			esc_attr__( 'Sale Badge', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			'outside',
	'priority'			=>			$loop_priority++,
	'multiple'			=>			1,
	'choices'			=>			array(
		'outside'		=>			esc_attr__( 'Outside', 'page-builder-framework' ),
		'inside'		=>			esc_attr__( 'Inside', 'page-builder-framework' ),
		'none'			=>			esc_attr__( 'Hide', 'page-builder-framework' ),
	),
) );

// Sale Position
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'woocommerce_loop_sale_layout',
	'label'				=>			esc_attr__( 'Layout', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			'round',
	'priority'			=>			$loop_priority++,
	'multiple'			=>			1,
	'choices'			=>			array(
		'round'			=>			esc_attr__( 'Round', 'page-builder-framework' ),
		'square'		=>			esc_attr__( 'Square', 'page-builder-framework' ),
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'woocommerce_loop_sale_position',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	)
) );

// Sale Alignment
Kirki::add_field( 'wpbf', array(
	'type'				=>			'radio-image',
	'settings'			=>			'woocommerce_loop_sale_alignment',
	'label'				=>			esc_attr__( 'Alignment', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			'left',
	'priority'			=>			$loop_priority++,
	'multiple'			=>			1,
	'choices'			=>			array(
		'left'			=>			WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center'		=>			WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'			=>			WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'woocommerce_loop_sale_position',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	)
) );

// Sale Badge Font Size
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Font Size', 'page-builder-framework' ),
	'settings'			=>			'woocommerce_loop_sale_font_size',
	'section'			=>			'woocommerce_product_catalog',
	'transport'			=>			'postMessage',
	'priority'			=>			$loop_priority++,
	'default'			=>			'14px',
	'active_callback'	=>			array(
		array(
		'setting'		=>			'woocommerce_loop_sale_position',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	)
) );

// Sale Badge Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'woocommerce_loop_sale_font_color',
	'label'				=>			esc_attr__( 'Font Color', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'transport'			=>			'postMessage',
	'default'			=>			'#fff',
	'priority'			=>			$loop_priority++,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'woocommerce_loop_sale_position',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	)
) );

// Sale Badge Background Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'woocommerce_loop_sale_background_color',
	'label'				=>			esc_attr__( 'Background Color', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'transport'			=>			'postMessage',
	'default'			=>			'#4fe190',
	'priority'			=>			$loop_priority++,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'woocommerce_loop_sale_position',
		'operator'		=>			'!=',
		'value'			=>			'none',
		),
	)
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-37611',
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			$loop_priority++,
) );

// Title Font Size
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Title Font Size', 'page-builder-framework' ),
	'settings'			=>			'woocommerce_loop_title_size',
	'section'			=>			'woocommerce_product_catalog',
	'transport'			=>			'postMessage',
	'priority'			=>			$loop_priority++,
	'default'			=>			'16px',
) );

// Title Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'woocommerce_loop_title_color',
	'label'				=>			esc_attr__( 'Font Color', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'transport'			=>			'postMessage',
	'default'			=>			'#3e4349',
	'priority'			=>			$loop_priority++,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-58256',
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			$loop_priority++,
) );

// Price Font Size
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Price Font Size', 'page-builder-framework' ),
	'settings'			=>			'woocommerce_loop_price_size',
	'section'			=>			'woocommerce_product_catalog',
	'transport'			=>			'postMessage',
	'priority'			=>			$loop_priority++,
	'default'			=>			'16px',
) );

// Price Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'woocommerce_loop_price_color',
	'label'				=>			esc_attr__( 'Font Color', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'transport'			=>			'postMessage',
	'default'			=>			'#3e4349',
	'priority'			=>			$loop_priority++,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-91969',
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			$loop_priority++,
) );

// Out of Stock Notice
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'woocommerce_loop_out_of_stock_notice',
	'label'				=>			esc_attr__( 'Out of Stock Notice', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'default'			=>			'show',
	'priority'			=>			$loop_priority++,
	'multiple'			=>			1,
	'choices'			=>			array(
		'show'			=>			esc_attr__( 'Show', 'page-builder-framework' ),
		'hide'			=>			esc_attr__( 'Hide', 'page-builder-framework' ),
	)
) );

// Out of Stock Font Size
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Font Size', 'page-builder-framework' ),
	'settings'			=>			'woocommerce_loop_out_of_stock_font_size',
	'section'			=>			'woocommerce_product_catalog',
	'transport'			=>			'postMessage',
	'priority'			=>			$loop_priority++,
	'default'			=>			'14px',
	'active_callback'	=>			array(
		array(
		'setting'		=>			'woocommerce_loop_out_of_stock_notice',
		'operator'		=>			'!=',
		'value'			=>			'hide',
		),
	)
) );

// Out of Stock Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'woocommerce_loop_out_of_stock_font_color',
	'label'				=>			esc_attr__( 'Font Color', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'transport'			=>			'postMessage',
	'default'			=>			'#fff',
	'priority'			=>			$loop_priority++,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'woocommerce_loop_out_of_stock_notice',
		'operator'		=>			'!=',
		'value'			=>			'hide',
		),
	)
) );

// Out of Stock Background Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'woocommerce_loop_out_of_stock_background_color',
	'label'				=>			esc_attr__( 'Background Color', 'page-builder-framework' ),
	'section'			=>			'woocommerce_product_catalog',
	'transport'			=>			'postMessage',
	'default'			=>			'rgba(0,0,0,.7)',
	'priority'			=>			$loop_priority++,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'woocommerce_loop_out_of_stock_notice',
		'operator'		=>			'!=',
		'value'			=>			'hide',
		),
	)
) );

/* Fields – Product Page */

$product_priority = 0;

// Custom Width
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Custom Content Width', 'page-builder-framework' ),
	'settings'			=>			'woocommerce_single_custom_width',
	'section'			=>			'wpbf_woocommerce_product_options',
	'description'		=>			esc_attr__( 'Default: 1200px', 'page-builder-framework' ), 
	'priority'			=>			$product_priority++,
	'transport'			=>			'postMessage'
) );

// Alignment
Kirki::add_field( 'wpbf', array(
	'type'				=>			'radio-image',
	'settings'			=>			'woocommerce_single_alignment',
	'label'				=>			esc_attr__( 'Image Alignment', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_product_options',
	'default'			=>			'left',
	'priority'			=>			$product_priority++,
	'multiple'			=>			1,
	'choices'			=>			array(
		'left'			=>			WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'right'			=>			WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	)
) );

// Image Container Width
Kirki::add_field( 'wpbf', array(
	'type'				=>			'slider',
	'settings'			=>			'woocommerce_single_image_width',
	'label'				=>			esc_attr__( 'Image Container Width', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_product_options',
	'priority'			=>			$product_priority++,
	'default'			=>			50,
	'transport'			=>			'postMessage',
	'choices'			=>			array(
		'min'			=>			'25',
		'max'			=>			'75',
		'step'			=>			'1',
	),
) );

// Summary Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'woocommerce_single_summary_separator',
	'label'				=>			esc_attr__( 'Summary Separator', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_product_options',
	'default'			=>			'hide',
	'priority'			=>			$product_priority++,
	'choices'			=>			array(
		'hide'			=>			esc_attr__( 'Hide', 'page-builder-framework' ),
		'show'			=>			esc_attr__( 'Show', 'page-builder-framework' ),
	)
) );

// Price Font Size
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Price Font Size', 'page-builder-framework' ),
	'settings'			=>			'woocommerce_single_price_size',
	'section'			=>			'wpbf_woocommerce_product_options',
	'transport'			=>			'postMessage',
	'priority'			=>			$product_priority++,
	'default'			=>			'22px',
) );

// Price Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'woocommerce_single_price_color',
	'label'				=>			esc_attr__( 'Font Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_product_options',
	'transport'			=>			'postMessage',
	'default'			=>			'#3e4349',
	'priority'			=>			$product_priority++,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Separator
Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-45153',
	'section'			=>			'wpbf_woocommerce_product_options',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			$product_priority++,
) );

// Tabs Layout
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'woocommerce_single_tabs',
	'label'				=>			esc_attr__( 'Tabs Layout', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_product_options',
	'default'			=>			'default',
	'priority'			=>			$product_priority++,
	'multiple'			=>			1,
	'choices'			=>			array(
		'default'		=>			esc_attr__( 'Default', 'page-builder-framework' ),
		'modern'		=>			esc_attr__( 'Modern', 'page-builder-framework' ),
	)
) );

// Tabs Headlines
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'woocommerce_single_tabs_remove_headline',
	'label'				=>			esc_attr__( 'Headlines', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_product_options',
	'default'			=>			'show',
	'priority'			=>			$product_priority++,
	'choices'			=>			array(
		'hide'			=>			esc_attr__( 'Hide', 'page-builder-framework' ),
		'show'			=>			esc_attr__( 'Show', 'page-builder-framework' ),
	)
) );

// Tabs Font Size
Kirki::add_field( 'wpbf', array(
	'type'				=>			'dimension',
	'label'				=>			esc_attr__( 'Font Size', 'page-builder-framework' ),
	'settings'			=>			'woocommerce_single_tabs_font_size',
	'section'			=>			'wpbf_woocommerce_product_options',
	'transport'			=>			'postMessage',
	'priority'			=>			$product_priority++,
	'default'			=>			'16px',
) );

// Tabs Font Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'woocommerce_single_tabs_font_color',
	'label'				=>			esc_attr__( 'Font Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_product_options',
	'default'			=>			'#3e4349',
	'priority'			=>			$product_priority++,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Tabs Hover Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'woocommerce_single_tabs_font_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_product_options',
	'default'			=>			'',
	'priority'			=>			$product_priority++,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Tabs Active Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'woocommerce_single_tabs_font_color_active',
	'label'				=>			esc_attr__( 'Active', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_product_options',
	'default'			=>			'',
	'priority'			=>			$product_priority++,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
) );

// Tabs Background Color
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'woocommerce_single_tabs_background_color',
	'label'				=>			esc_attr__( 'Background Color', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_product_options',
	'default'			=>			'#e7e7ec',
	'priority'			=>			$product_priority++,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'woocommerce_single_tabs',
		'operator'		=>			'!=',
		'value'			=>			'modern',
		),
	)
) );

// Tabs Background Color Alt
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'woocommerce_single_tabs_background_color_alt',
	'label'				=>			esc_attr__( 'Hover', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_product_options',
	'default'			=>			'#f5f5f7',
	'priority'			=>			$product_priority++,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'woocommerce_single_tabs',
		'operator'		=>			'!=',
		'value'			=>			'modern',
		),
	)
) );

// Tabs Background Color Active
Kirki::add_field( 'wpbf', array(
	'type'				=>			'color',
	'settings'			=>			'woocommerce_single_tabs_background_color_active',
	'label'				=>			esc_attr__( 'Active', 'page-builder-framework' ),
	'section'			=>			'wpbf_woocommerce_product_options',
	'default'			=>			'#ffffff',
	'priority'			=>			$product_priority++,
	'choices'			=>			array(
		'alpha'			=>			true,
	),
	'active_callback'	=>			array(
		array(
		'setting'		=>			'woocommerce_single_tabs',
		'operator'		=>			'!=',
		'value'			=>			'modern',
		),
	)
) );

/* Fields – Checkout Page */

// Alignment
Kirki::add_field( 'wpbf', array(
	'type'				=>			'select',
	'settings'			=>			'woocommerce_checkout_layout',
	'label'				=>			esc_attr__( 'Layout', 'page-builder-framework' ),
	'section'			=>			'woocommerce_checkout',
	'default'			=>			'default',
	'priority'			=>			1,
	'multiple'			=>			1,
	'choices'			=>			array(
		'default'		=>			esc_attr__( 'Default', 'page-builder-framework' ),
		'side'			=>			esc_attr__( 'Side by Side', 'page-builder-framework' )
	)
) );

Kirki::add_field( 'wpbf', array(
	'type'				=>			'custom',
	'settings'			=>			'separator-82245',
	'section'			=>			'woocommerce_checkout',
	'default'			=>			'<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority'			=>			2,
) );