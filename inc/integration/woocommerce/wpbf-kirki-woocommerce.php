<?php
/**
 * WooCommerce customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Integration/WooCommerce
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Textdomain. This is required, otherwise strings aren't translateable.
load_theme_textdomain( 'page-builder-framework' );

/**
 * Setup.
 *
 * @param object $wp_customize The wp_customize object.
 */
function wpbf_woo_customizer_setup( $wp_customize ) {

	// Reorder sections.
	$wp_customize->get_section( 'woocommerce_store_notice' )->priority    = 10;
	$wp_customize->get_section( 'woocommerce_product_images' )->priority  = 20;
	$wp_customize->get_section( 'woocommerce_product_catalog' )->priority = 30;
	$wp_customize->get_section( 'woocommerce_checkout' )->priority        = 50;

	// Change section title.
	$wp_customize->get_section( 'woocommerce_product_catalog' )->title = __( 'Shop Page', 'page-builder-framework' );

}
add_action( 'customize_register', 'wpbf_woo_customizer_setup', 20 );

// Kirki configuration.
Kirki::add_config( 'wpbf', array(
	'capability'     => 'edit_theme_options',
	'option_type'    => 'theme_mod',
	'disable_output' => true,
) );

/* Sections – WooCommerce */

// Menu item.
Kirki::add_section( 'wpbf_woocommerce_menu_item_options', array(
	'title'    => __( 'Cart Menu Item', 'page-builder-framework' ),
	'panel'    => 'woocommerce',
	'priority' => 25,
) );

// Product page.
Kirki::add_section( 'wpbf_woocommerce_product_options', array(
	'title'    => __( 'Product Page', 'page-builder-framework' ),
	'panel'    => 'woocommerce',
	'priority' => 40,
) );

// Sidebar.
Kirki::add_section( 'wpbf_woocommerce_sidebar_options', array(
	'title'    => __( 'Sidebar', 'page-builder-framework' ),
	'panel'    => 'woocommerce',
	'priority' => 60,
) );

// Notices.
Kirki::add_section( 'wpbf_woocommerce_notices_options', array(
	'title'    => __( 'Notices', 'page-builder-framework' ),
	'panel'    => 'woocommerce',
	'priority' => 70,
) );

/* Fields – Sidebar */

// Shop sidebar layout.
Kirki::add_field( 'wpbf', array(
	'type'     => 'select',
	'settings' => 'woocommerce_sidebar_layout',
	'label'    => __( 'Shop Page Sidebar', 'page-builder-framework' ),
	'section'  => 'wpbf_woocommerce_sidebar_options',
	'default'  => 'none',
	'priority' => 0,
	'multiple' => 1,
	'choices'  => array(
		'right' => __( 'Right', 'page-builder-framework' ),
		'left'  => __( 'Left', 'page-builder-framework' ),
		'none'  => __( 'No Sidebar', 'page-builder-framework' ),
	),
) );

// Product sidebar layout.
Kirki::add_field( 'wpbf', array(
	'type'     => 'select',
	'settings' => 'woocommerce_single_sidebar_layout',
	'label'    => __( 'Product Page Sidebar', 'page-builder-framework' ),
	'section'  => 'wpbf_woocommerce_sidebar_options',
	'default'  => 'none',
	'priority' => 1,
	'multiple' => 1,
	'choices'  => array(
		'right' => __( 'Right', 'page-builder-framework' ),
		'left'  => __( 'Left', 'page-builder-framework' ),
		'none'  => __( 'No Sidebar', 'page-builder-framework' ),
	),
) );

/* Fields – Menu Item */

// Hide from non WooCommerce pages.
Kirki::add_field( 'wpbf', array(
	'type'        => 'toggle',
	'settings'    => 'woocommerce_menu_item_hide_if_not_wc',
	'label'       => __( 'Hide from non-Shop Pages', 'page-builder-framework' ),
	'description' => __( 'Display Menu Item only on WooCommerce related pages', 'page-builder-framework' ),
	'section'     => 'wpbf_woocommerce_menu_item_options',
	'default'     => 0,
	'priority'    => 5,
) );

// Turn search into product search.
Kirki::add_field( 'wpbf', array(
	'type'        => 'toggle',
	'settings'    => 'woocommerce_search_menu_item',
	'label'       => __( 'Product Search', 'page-builder-framework' ),
	'description' => __( 'Turn the Search Menu Item into a Product Search', 'page-builder-framework' ),
	'section'     => 'wpbf_woocommerce_menu_item_options',
	'default'     => 0,
	'priority'    => 5,
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-88057',
	'section'  => 'wpbf_woocommerce_menu_item_options',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 5,
) );

// Menu item.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'woocommerce_menu_item_desktop',
	'label'           => __( 'Visibility (Desktop)', 'page-builder-framework' ),
	'description'     => __( 'Adds a Cart Icon to your Main Navigation', 'page-builder-framework' ),
	'section'         => 'wpbf_woocommerce_menu_item_options',
	'default'         => 'show',
	'priority'        => 10,
	'multiple'        => 1,
	'choices'         => array(
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	),
	'partial_refresh' => array(
		'woocommerce_menu_item_desktop' => array(
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
	'settings'        => 'woocommerce_menu_item_desktop_color',
	'label'           => __( 'Color', 'page-builder-framework' ),
	'section'         => 'wpbf_woocommerce_menu_item_options',
	'default'         => '',
	'priority'        => 11,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'woocommerce_menu_item_desktop',
			'operator' => '!=',
			'value'    => 'hide',
		),
		array(
			'setting'  => 'woocommerce_menu_item_count',
			'operator' => '!=',
			'value'    => 'hide',
		),
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-75733',
	'section'  => 'wpbf_woocommerce_menu_item_options',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 12,
) );

// Mobile menu item.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'woocommerce_menu_item_mobile',
	'label'           => __( 'Visibility (Mobile)', 'page-builder-framework' ),
	'description'     => __( 'Adds a Cart Icon to your Mobile Navigation', 'page-builder-framework' ),
	'section'         => 'wpbf_woocommerce_menu_item_options',
	'default'         => 'show',
	'priority'        => 13,
	'multiple'        => 1,
	'choices'         => array(
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	),
	'partial_refresh' => array(
		'woocommerce_menu_item_mobile' => array(
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
	'settings'        => 'woocommerce_menu_item_mobile_color',
	'label'           => __( 'Color', 'page-builder-framework' ),
	'section'         => 'wpbf_woocommerce_menu_item_options',
	'default'         => '',
	'priority'        => 14,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'woocommerce_menu_item_mobile',
			'operator' => '!=',
			'value'    => 'hide',
		),
		array(
			'setting'  => 'woocommerce_menu_item_count',
			'operator' => '!=',
			'value'    => 'hide',
		),
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-36652',
	'section'  => 'wpbf_woocommerce_menu_item_options',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 15,
) );

// Menu item count.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'woocommerce_menu_item_count',
	'label'           => __( 'Count', 'page-builder-framework' ),
	'section'         => 'wpbf_woocommerce_menu_item_options',
	'default'         => 'show',
	'priority'        => 16,
	'multiple'        => 1,
	'choices'         => array(
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	),
	'partial_refresh' => array(
		'woocommerce_menu_item_count' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	),
) );

/* Fields – Shop & Archive Pages (Loop) */

// Custom width.
Kirki::add_field( 'wpbf', array(
	'type'        => 'dimension',
	'label'       => __( 'Custom Content Width', 'page-builder-framework' ),
	'settings'    => 'woocommerce_loop_custom_width',
	'section'     => 'woocommerce_product_catalog',
	'description' => __( 'Default: 1200px', 'page-builder-framework' ),
	'priority'    => 10,
	'transport'   => 'postMessage',
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-56123',
	'section'  => 'woocommerce_product_catalog',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 10,
) );

// Remove page title.
Kirki::add_field( 'wpbf', array(
	'type'     => 'toggle',
	'settings' => 'woocommerce_loop_remove_page_title',
	'label'    => __( 'Hide Page Title', 'page-builder-framework' ),
	'section'  => 'woocommerce_product_catalog',
	'default'  => 0,
	'priority' => 10,
) );

// Remove breadcrumbs.
Kirki::add_field( 'wpbf', array(
	'type'     => 'toggle',
	'settings' => 'woocommerce_loop_remove_breadcrumbs',
	'label'    => __( 'Hide Breadcrumbs', 'page-builder-framework' ),
	'section'  => 'woocommerce_product_catalog',
	'default'  => 0,
	'priority' => 10,
) );

// Remove result count.
Kirki::add_field( 'wpbf', array(
	'type'     => 'toggle',
	'settings' => 'woocommerce_loop_remove_result_count',
	'label'    => __( 'Hide Result Count', 'page-builder-framework' ),
	'section'  => 'woocommerce_product_catalog',
	'default'  => 0,
	'priority' => 10,
) );

// Remove ordering.
Kirki::add_field( 'wpbf', array(
	'type'     => 'toggle',
	'settings' => 'woocommerce_loop_remove_ordering',
	'label'    => __( 'Hide Ordering', 'page-builder-framework' ),
	'section'  => 'woocommerce_product_catalog',
	'default'  => 0,
	'priority' => 10,
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-72124',
	'section'  => 'woocommerce_product_catalog',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 10,
) );

/**
 * Custom controls.
 *
 * @param object $wp_customize The wp_customize object.
 */
function wpbf_woo_custom_controls_default( $wp_customize ) {

	$wp_customize->add_setting( 'woocommerce_loop_products_per_row_desktop',
		array(
			'default'           => '4',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_setting( 'woocommerce_loop_products_per_row_tablet',
		array(
			'default'           => '2',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_setting( 'woocommerce_loop_products_per_row_mobile',
		array(
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control( new WPBF_Customize_Font_Size_Control(
		$wp_customize,
		'woocommerce_loop_products_per_row',
		array(
			'label'    => __( 'Products per Row', 'page-builder-framework' ),
			'section'  => 'woocommerce_product_catalog',
			'settings' => 'woocommerce_loop_products_per_row_desktop',
			'priority' => 15,
		)
	) );

	$wp_customize->add_control( new WPBF_Customize_Font_Size_Control(
		$wp_customize,
		'woocommerce_loop_products_per_row',
		array(
			'label'    => __( 'Products per Row', 'page-builder-framework' ),
			'section'  => 'woocommerce_product_catalog',
			'settings' => 'woocommerce_loop_products_per_row_tablet',
			'priority' => 15,
		)
	) );

	$wp_customize->add_control( new WPBF_Customize_Font_Size_Control(
		$wp_customize,
		'woocommerce_loop_products_per_row',
		array(
			'label'    => __( 'Products per Row', 'page-builder-framework' ),
			'section'  => 'woocommerce_product_catalog',
			'settings' => 'woocommerce_loop_products_per_row_mobile',
			'priority' => 15,
		)
	) );

}
add_action( 'customize_register', 'wpbf_woo_custom_controls_default' );

// Grid gap.
Kirki::add_field( 'wpbf', array(
	'type'     => 'select',
	'settings' => 'woocommerce_loop_grid_gap',
	'label'    => __( 'Grid Gap', 'page-builder-framework' ),
	'section'  => 'woocommerce_product_catalog',
	'default'  => 'large',
	'priority' => 20,
	'multiple' => 1,
	'choices'  => array(
		'small'    => __( 'Small', 'page-builder-framework' ),
		'medium'   => __( 'Medium', 'page-builder-framework' ),
		'large'    => __( 'Large', 'page-builder-framework' ),
		'xlarge'   => __( 'xLarge', 'page-builder-framework' ),
		'collapse' => __( 'Collapse', 'page-builder-framework' ),
	),
) );

// Content alignment.
Kirki::add_field( 'wpbf', array(
	'type'      => 'radio-image',
	'settings'  => 'woocommerce_loop_content_alignment',
	'label'     => __( 'Content Alignment', 'page-builder-framework' ),
	'section'   => 'woocommerce_product_catalog',
	'default'   => 'left',
	'priority'  => 20,
	'multiple'  => 1,
	'transport' => 'postMessage',
	'choices'   => array(
		'left'   => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center' => WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'  => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	),
) );

// Product structure.
Kirki::add_field( 'wpbf', array(
	'type'     => 'sortable',
	'settings' => 'woocommerce_loop_sortable_content',
	'label'    => __( 'Structure', 'page-builder-framework' ),
	'section'  => 'woocommerce_product_catalog',
	'default'  => array(
		'category',
		'title',
		'price',
		'add_to_cart',
	),
	'choices'  => array(
		'category'    => __( 'Category', 'page-builder-framework' ),
		'title'       => __( 'Title', 'page-builder-framework' ),
		'rating'      => __( 'Rating', 'page-builder-framework' ),
		'price'       => __( 'Price', 'page-builder-framework' ),
		'add_to_cart' => __( 'Add to Cart Button', 'page-builder-framework' ),
		'excerpt'     => __( 'Short Description', 'page-builder-framework' ),
	),
	'priority' => 20,
) );

// Layout.
Kirki::add_field(
	'wpbf',
	array(
		'type'     => 'select',
		'settings' => 'woocommerce_loop_layout',
		'label'    => __( 'Layout', 'page-builder-framework' ),
		'section'  => 'woocommerce_product_catalog',
		'default'  => 'default',
		'priority' => 20,
		'choices'  => array(
			'default' => __( 'Default', 'page-builder-framework' ),
			'list'    => __( 'List', 'page-builder-framework' ),
		),
	)
);

// Alignment.
Kirki::add_field( 'wpbf', array(
	'type'            => 'radio-image',
	'settings'        => 'woocommerce_loop_image_alignment',
	'label'           => __( 'Image Alignment', 'page-builder-framework' ),
	'section'         => 'woocommerce_product_catalog',
	'default'         => 'left',
	'priority'        => 20,
	'multiple'        => 1,
	'transport'       => 'postMessage',
	'choices'         => array(
		'left'  => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'right' => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	),
	'active_callback' => array(
		array(
			'setting'  => 'woocommerce_loop_layout',
			'operator' => '==',
			'value'    => 'list',
		),
	),
) );

// Image container width.
Kirki::add_field( 'wpbf', array(
	'type'            => 'slider',
	'settings'        => 'woocommerce_loop_image_width',
	'label'           => __( 'Image Width', 'page-builder-framework' ),
	'section'         => 'woocommerce_product_catalog',
	'priority'        => 20,
	'default'         => 50,
	'transport'       => 'postMessage',
	'choices'         => array(
		'min'  => '25',
		'max'  => '75',
		'step' => '1',
	),
	'active_callback' => array(
		array(
			'setting'  => 'woocommerce_loop_layout',
			'operator' => '==',
			'value'    => 'list',
		),
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-56377',
	'section'  => 'woocommerce_product_catalog',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 20,
) );

// Sale position.
Kirki::add_field( 'wpbf', array(
	'type'     => 'select',
	'settings' => 'woocommerce_loop_sale_position',
	'label'    => __( 'Sale Badge', 'page-builder-framework' ),
	'section'  => 'woocommerce_product_catalog',
	'default'  => 'outside',
	'priority' => 30,
	'multiple' => 1,
	'choices'  => array(
		'none'    => __( 'Hide', 'page-builder-framework' ),
		'outside' => __( 'Outside', 'page-builder-framework' ),
		'inside'  => __( 'Inside', 'page-builder-framework' ),
	),
) );

// Sale layout.
Kirki::add_field( 'wpbf', array(
	'type'            => 'select',
	'settings'        => 'woocommerce_loop_sale_layout',
	'label'           => __( 'Layout', 'page-builder-framework' ),
	'section'         => 'woocommerce_product_catalog',
	'default'         => 'round',
	'priority'        => 30,
	'multiple'        => 1,
	'choices'         => array(
		'round'  => __( 'Round', 'page-builder-framework' ),
		'square' => __( 'Square', 'page-builder-framework' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'woocommerce_loop_sale_position',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Sale alignment.
Kirki::add_field( 'wpbf', array(
	'type'            => 'radio-image',
	'settings'        => 'woocommerce_loop_sale_alignment',
	'label'           => __( 'Alignment', 'page-builder-framework' ),
	'section'         => 'woocommerce_product_catalog',
	'default'         => 'left',
	'priority'        => 30,
	'multiple'        => 1,
	'choices'         => array(
		'left'   => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center' => WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'  => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	),
	'active_callback' => array(
		array(
			'setting'  => 'woocommerce_loop_sale_position',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Sale font size.
Kirki::add_field( 'wpbf', array(
	'type'            => 'input_slider',
	'label'           => __( 'Font Size', 'page-builder-framework' ),
	'settings'        => 'woocommerce_loop_sale_font_size',
	'section'         => 'woocommerce_product_catalog',
	'transport'       => 'postMessage',
	'priority'        => 30,
	'default'         => '14px',
	'choices'         => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'woocommerce_loop_sale_position',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Sale background color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'woocommerce_loop_sale_background_color',
	'label'           => __( 'Background Color', 'page-builder-framework' ),
	'section'         => 'woocommerce_product_catalog',
	'transport'       => 'postMessage',
	'default'         => '#4fe190',
	'priority'        => 30,
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'woocommerce_loop_sale_position',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Sale color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'woocommerce_loop_sale_font_color',
	'label'           => __( 'Font Color', 'page-builder-framework' ),
	'section'         => 'woocommerce_product_catalog',
	'transport'       => 'postMessage',
	'default'         => '#fff',
	'priority'        => 30,
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'woocommerce_loop_sale_position',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-37611',
	'section'  => 'woocommerce_product_catalog',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 30,
) );

// Title font size.
Kirki::add_field( 'wpbf', array(
	'type'      => 'input_slider',
	'label'     => __( 'Title Font Size', 'page-builder-framework' ),
	'settings'  => 'woocommerce_loop_title_size',
	'section'   => 'woocommerce_product_catalog',
	'transport' => 'postMessage',
	'priority'  => 30,
	'default'   => '16px',
	'choices'   => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
) );

// Title color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'woocommerce_loop_title_color',
	'label'     => __( 'Font Color', 'page-builder-framework' ),
	'section'   => 'woocommerce_product_catalog',
	'transport' => 'postMessage',
	'default'   => '#3e4349',
	'priority'  => 30,
	'choices'   => array(
		'alpha' => true,
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-58256',
	'section'  => 'woocommerce_product_catalog',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 30,
) );

// Price font size.
Kirki::add_field( 'wpbf', array(
	'type'      => 'input_slider',
	'label'     => __( 'Price Font Size', 'page-builder-framework' ),
	'settings'  => 'woocommerce_loop_price_size',
	'section'   => 'woocommerce_product_catalog',
	'transport' => 'postMessage',
	'priority'  => 30,
	'default'   => '16px',
	'choices'   => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
) );

// Price color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'woocommerce_loop_price_color',
	'label'     => __( 'Font Color', 'page-builder-framework' ),
	'section'   => 'woocommerce_product_catalog',
	'transport' => 'postMessage',
	'default'   => '#3e4349',
	'priority'  => 30,
	'choices'   => array(
		'alpha' => true,
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-91969',
	'section'  => 'woocommerce_product_catalog',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 30,
) );

// Out of stock notice.
Kirki::add_field( 'wpbf', array(
	'type'     => 'select',
	'settings' => 'woocommerce_loop_out_of_stock_notice',
	'label'    => __( 'Out of Stock Notice', 'page-builder-framework' ),
	'section'  => 'woocommerce_product_catalog',
	'default'  => 'show',
	'priority' => 30,
	'multiple' => 1,
	'choices'  => array(
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	),
) );

// Out of stock background color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'woocommerce_loop_out_of_stock_background_color',
	'label'           => __( 'Background Color', 'page-builder-framework' ),
	'section'         => 'woocommerce_product_catalog',
	'transport'       => 'postMessage',
	'default'         => 'rgba(0,0,0,.7)',
	'priority'        => 30,
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'woocommerce_loop_out_of_stock_notice',
			'operator' => '!=',
			'value'    => 'hide',
		),
	),
) );

// Out of stock color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'woocommerce_loop_out_of_stock_font_color',
	'label'           => __( 'Font Color', 'page-builder-framework' ),
	'section'         => 'woocommerce_product_catalog',
	'transport'       => 'postMessage',
	'default'         => '#fff',
	'priority'        => 30,
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'woocommerce_loop_out_of_stock_notice',
			'operator' => '!=',
			'value'    => 'hide',
		),
	),
) );

// Out of stock font size.
Kirki::add_field( 'wpbf', array(
	'type'            => 'input_slider',
	'label'           => __( 'Font Size', 'page-builder-framework' ),
	'settings'        => 'woocommerce_loop_out_of_stock_font_size',
	'section'         => 'woocommerce_product_catalog',
	'transport'       => 'postMessage',
	'priority'        => 30,
	'default'         => '14px',
	'choices'         => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'woocommerce_loop_out_of_stock_notice',
			'operator' => '!=',
			'value'    => 'hide',
		),
	),
) );

/* Fields – Product Page */

$product_priority = 0;

// Custom width.
Kirki::add_field( 'wpbf', array(
	'type'        => 'dimension',
	'label'       => __( 'Custom Content Width', 'page-builder-framework' ),
	'settings'    => 'woocommerce_single_custom_width',
	'section'     => 'wpbf_woocommerce_product_options',
	'description' => __( 'Default: 1200px', 'page-builder-framework' ),
	'priority'    => $product_priority++,
	'transport'   => 'postMessage',
) );

// Alignment.
Kirki::add_field( 'wpbf', array(
	'type'      => 'radio-image',
	'settings'  => 'woocommerce_single_alignment',
	'label'     => __( 'Image Alignment', 'page-builder-framework' ),
	'section'   => 'wpbf_woocommerce_product_options',
	'default'   => 'left',
	'priority'  => $product_priority++,
	'multiple'  => 1,
	'transport' => 'postMessage',
	'choices'   => array(
		'left'  => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'right' => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	),
) );

// Image container width.
Kirki::add_field( 'wpbf', array(
	'type'      => 'slider',
	'settings'  => 'woocommerce_single_image_width',
	'label'     => __( 'Image Width', 'page-builder-framework' ),
	'section'   => 'wpbf_woocommerce_product_options',
	'priority'  => $product_priority++,
	'default'   => 50,
	'transport' => 'postMessage',
	'choices'   => array(
		'min'  => '25',
		'max'  => '75',
		'step' => '1',
	),
) );

// Summary separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'select',
	'settings' => 'woocommerce_single_summary_separator',
	'label'    => __( 'Summary Separator', 'page-builder-framework' ),
	'section'  => 'wpbf_woocommerce_product_options',
	'default'  => 'hide',
	'priority' => $product_priority++,
	'choices'  => array(
		'hide' => __( 'Hide', 'page-builder-framework' ),
		'show' => __( 'Show', 'page-builder-framework' ),
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-553014',
	'section'  => 'wpbf_woocommerce_product_options',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => $product_priority++,
) );

// Increase - Decrease button.
Kirki::add_field( 'wpbf', array(
	'type'     => 'select',
	'settings' => 'woocommerce_quantity_buttons',
	'label'    => __( 'Price Quantity Buttons (+/-)', 'page-builder-framework' ),
	'section'  => 'wpbf_woocommerce_product_options',
	'default'  => 'show',
	'priority' => $product_priority++,
	'choices'  => array(
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	),
) );

// Price color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'woocommerce_single_price_color',
	'label'     => __( 'Font Color', 'page-builder-framework' ),
	'section'   => 'wpbf_woocommerce_product_options',
	'transport' => 'postMessage',
	'default'   => '#3e4349',
	'priority'  => $product_priority++,
	'choices'   => array(
		'alpha' => true,
	),
) );

// Price font size.
Kirki::add_field( 'wpbf', array(
	'type'      => 'input_slider',
	'label'     => __( 'Font Size', 'page-builder-framework' ),
	'settings'  => 'woocommerce_single_price_size',
	'section'   => 'wpbf_woocommerce_product_options',
	'transport' => 'postMessage',
	'priority'  => $product_priority++,
	'default'   => '22px',
	'choices'   => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-45153',
	'section'  => 'wpbf_woocommerce_product_options',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => $product_priority++,
) );

// Tabs layout.
Kirki::add_field( 'wpbf', array(
	'type'     => 'select',
	'settings' => 'woocommerce_single_tabs',
	'label'    => __( 'Tabs Layout', 'page-builder-framework' ),
	'section'  => 'wpbf_woocommerce_product_options',
	'default'  => 'default',
	'priority' => $product_priority++,
	'multiple' => 1,
	'choices'  => array(
		'default' => __( 'Default', 'page-builder-framework' ),
		'modern'  => __( 'Modern', 'page-builder-framework' ),
	),
) );

// Tabs background color.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'woocommerce_single_tabs_background_color',
	'label'           => __( 'Background Color', 'page-builder-framework' ),
	'section'         => 'wpbf_woocommerce_product_options',
	'default'         => '#e7e7ec',
	'priority'        => $product_priority++,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'woocommerce_single_tabs',
			'operator' => '!=',
			'value'    => 'modern',
		),
	),
) );

// Tabs background color alt.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'woocommerce_single_tabs_background_color_alt',
	'label'           => __( 'Hover', 'page-builder-framework' ),
	'section'         => 'wpbf_woocommerce_product_options',
	'default'         => '#f5f5f7',
	'priority'        => $product_priority++,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'woocommerce_single_tabs',
			'operator' => '!=',
			'value'    => 'modern',
		),
	),
) );

// Tabs background color active.
Kirki::add_field( 'wpbf', array(
	'type'            => 'color',
	'settings'        => 'woocommerce_single_tabs_background_color_active',
	'label'           => __( 'Active', 'page-builder-framework' ),
	'section'         => 'wpbf_woocommerce_product_options',
	'default'         => '#ffffff',
	'priority'        => $product_priority++,
	'transport'       => 'postMessage',
	'choices'         => array(
		'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'woocommerce_single_tabs',
			'operator' => '!=',
			'value'    => 'modern',
		),
	),
) );

// Tabs font color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'woocommerce_single_tabs_font_color',
	'label'     => __( 'Font Color', 'page-builder-framework' ),
	'section'   => 'wpbf_woocommerce_product_options',
	'default'   => '#3e4349',
	'priority'  => $product_priority++,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Tabs hover color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'woocommerce_single_tabs_font_color_alt',
	'label'     => __( 'Hover', 'page-builder-framework' ),
	'section'   => 'wpbf_woocommerce_product_options',
	'default'   => '',
	'priority'  => $product_priority++,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Tabs active color.
Kirki::add_field( 'wpbf', array(
	'type'      => 'color',
	'settings'  => 'woocommerce_single_tabs_font_color_active',
	'label'     => __( 'Active', 'page-builder-framework' ),
	'section'   => 'wpbf_woocommerce_product_options',
	'default'   => '',
	'priority'  => $product_priority++,
	'transport' => 'postMessage',
	'choices'   => array(
		'alpha' => true,
	),
) );

// Tabs font size.
Kirki::add_field( 'wpbf', array(
	'type'      => 'input_slider',
	'label'     => __( 'Font Size', 'page-builder-framework' ),
	'settings'  => 'woocommerce_single_tabs_font_size',
	'section'   => 'wpbf_woocommerce_product_options',
	'transport' => 'postMessage',
	'priority'  => $product_priority++,
	'default'   => '16px',
	'choices'   => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-9987953',
	'section'  => 'wpbf_woocommerce_product_options',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => $product_priority++,
) );

// Single add to cart ajax.
Kirki::add_field( 'wpbf', array(
	'type'     => 'toggle',
	'settings' => 'woocommerce_single_add_to_cart_ajax',
	'label'    => __( 'Enable AJAX add to cart button', 'page-builder-framework' ),
	'section'  => 'wpbf_woocommerce_product_options',
	'priority' => $product_priority++,
	'default'  => false,
) );

/* Fields – Checkout Page */

// Alignment.
Kirki::add_field( 'wpbf', array(
	'type'     => 'select',
	'settings' => 'woocommerce_checkout_layout',
	'label'    => __( 'Layout', 'page-builder-framework' ),
	'section'  => 'woocommerce_checkout',
	'default'  => 'default',
	'priority' => 1,
	'multiple' => 1,
	'choices'  => array(
		'default' => __( 'Default', 'page-builder-framework' ),
		'side'    => __( 'Side by Side', 'page-builder-framework' ),
	),
) );

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-82245',
	'section'  => 'woocommerce_checkout',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 2,
) );

/* Fields – Messages/Notices */

// Separator.
Kirki::add_field( 'wpbf', array(
	'type'     => 'custom',
	'settings' => 'separator-06205833',
	'section'  => 'woocommerce_store_notice',
	'default'  => '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">',
	'priority' => 100,
) );

// Store notice color.
Kirki::add_field( 'wpbf', array(
	'type'     => 'color',
	'settings' => 'woocommerce_store_notice_color',
	'label'    => __( 'Store Notice', 'page-builder-framework' ),
	'section'  => 'woocommerce_store_notice',
	'default'  => '',
	'priority' => 100,
	'choices'  => array(
		'alpha' => true,
	),
) );

// Info color.
Kirki::add_field( 'wpbf', array(
	'type'     => 'color',
	'settings' => 'woocommerce_info_notice_color',
	'label'    => __( 'Info Notice', 'page-builder-framework' ),
	'section'  => 'woocommerce_store_notice',
	'default'  => '',
	'priority' => 100,
	'choices'  => array(
		'alpha' => true,
	),
) );

// Success color.
Kirki::add_field( 'wpbf', array(
	'type'     => 'color',
	'settings' => 'woocommerce_message_notice_color',
	'label'    => __( 'Success Notice', 'page-builder-framework' ),
	'section'  => 'woocommerce_store_notice',
	'default'  => '',
	'priority' => 100,
	'choices'  => array(
		'alpha' => true,
	),
) );

// Error color.
Kirki::add_field( 'wpbf', array(
	'type'     => 'color',
	'settings' => 'woocommerce_error_notice_color',
	'label'    => __( 'Error Notice', 'page-builder-framework' ),
	'section'  => 'woocommerce_store_notice',
	'default'  => '',
	'priority' => 100,
	'choices'  => array(
		'alpha' => true,
	),
) );
