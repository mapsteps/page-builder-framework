<?php
/**
 * WooCommerce customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Integration/WooCommerce
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Load textdomain. This is required to make strings translatable.
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

/* Sections */

// Menu item.
wpbf_customizer_section()
	->id( 'wpbf_woocommerce_menu_item_options' )
	->title( __( 'Cart Menu Item', 'page-builder-framework' ) )
	->priority( 25 )
	->addToPanel( 'woocommerce' );

// Product page.
wpbf_customizer_section()
	->id( 'wpbf_woocommerce_product_options' )
	->title( __( 'Product Page', 'page-builder-framework' ) )
	->priority( 40 )
	->addToPanel( 'woocommerce' );

// Sidebar.
wpbf_customizer_section()
	->id( 'wpbf_woocommerce_sidebar_options' )
	->title( __( 'Sidebar', 'page-builder-framework' ) )
	->priority( 60 )
	->addToPanel( 'woocommerce' );

// Notices.
wpbf_customizer_section()
	->id( 'wpbf_woocommerce_notices_options' )
	->title( __( 'Notices', 'page-builder-framework' ) )
	->priority( 70 )
	->addToPanel( 'woocommerce' );

/* Fields - Menu Item */

// Hide from non WooCommerce pages.
wpbf_customizer_field()
	->id( 'woocommerce_menu_item_hide_if_not_wc' )
	->type( 'toggle' )
	->label( __( 'Hide from non-Shop Pages', 'page-builder-framework' ) )
	->description( __( 'Display Menu Item only on WooCommerce related pages.', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 5 )
	->addToSection( 'wpbf_woocommerce_menu_item_options' );

// Turn search into product search.
wpbf_customizer_field()
	->id( 'woocommerce_search_menu_item' )
	->type( 'toggle' )
	->label( __( 'Product Search', 'page-builder-framework' ) )
	->description( __( 'Turn the Search Menu Item into a Product Search.', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 5 )
	->addToSection( 'wpbf_woocommerce_menu_item_options' );

// Separator.
wpbf_customizer_field()
	->id( 'woocommerce_search_menu_item_separator' )
	->type( 'divider' )
	->priority( 5 )
	->addToSection( 'wpbf_woocommerce_menu_item_options' );

// Menu item.
wpbf_customizer_field()
	->id( 'woocommerce_menu_item_desktop' )
	->type( 'select' )
	->label( __( 'Visibility (Desktop)', 'page-builder-framework' ) )
	->description( __( 'Add a Cart Icon to your Main Navigation.', 'page-builder-framework' ) )
	->priority( 10 )
	->defaultValue( 'show' )
	->choices( [
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	] )
	->partialRefresh( [
		'woocommerce_menu_item_desktop' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'wpbf_woocommerce_menu_item_options' );

// Menu item color.
wpbf_customizer_field()
	->id( 'woocommerce_menu_item_desktop_color' )
	->type( 'color' )
	->label( __( 'Color', 'page-builder-framework' ) )
	->priority( 11 )
	->transport( 'postMessage' )
	->activeCallback( [
		array(
			'id'       => 'woocommerce_menu_item_desktop',
			'operator' => '!=',
			'value'    => 'hide',
		),
		array(
			'id'       => 'woocommerce_menu_item_count',
			'operator' => '!=',
			'value'    => 'hide',
		),
	] )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_woocommerce_menu_item_options' );

// Separator.
wpbf_customizer_field()
	->id( 'woocommerce_menu_item_separator_1' )
	->type( 'divider' )
	->priority( 12 )
	->addToSection( 'wpbf_woocommerce_menu_item_options' );

// Mobile menu item.
wpbf_customizer_field()
	->id( 'woocommerce_menu_item_mobile' )
	->type( 'select' )
	->label( __( 'Visibility (Mobile)', 'page-builder-framework' ) )
	->description( __( 'Add a Cart Icon to your Mobile Navigation.', 'page-builder-framework' ) )
	->priority( 13 )
	->defaultValue( 'show' )
	->choices( [
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	] )
	->partialRefresh( [
		'woocommerce_menu_item_mobile' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'wpbf_woocommerce_menu_item_options' );

// Menu item color.
wpbf_customizer_field()
	->id( 'woocommerce_menu_item_mobile_color' )
	->type( 'color' )
	->label( __( 'Color', 'page-builder-framework' ) )
	->priority( 14 )
	->transport( 'postMessage' )
	->activeCallback( [
		array(
			'id'       => 'woocommerce_menu_item_mobile',
			'operator' => '!=',
			'value'    => 'hide',
		),
		array(
			'id'       => 'woocommerce_menu_item_count',
			'operator' => '!=',
			'value'    => 'hide',
		),
	] )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_woocommerce_menu_item_options' );

// Separator.
wpbf_customizer_field()
	->id( 'woocommerce_menu_item_separator_2' )
	->type( 'divider' )
	->priority( 15 )
	->addToSection( 'wpbf_woocommerce_menu_item_options' );

// Menu item count.
wpbf_customizer_field()
	->id( 'woocommerce_menu_item_count' )
	->type( 'select' )
	->label( __( 'Count', 'page-builder-framework' ) )
	->priority( 16 )
	->defaultValue( 'show' )
	->choices( [
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	] )
	->partialRefresh( [
		'woocommerce_menu_item_count' => array(
			'container_inclusive' => true,
			'selector'            => '#header',
			'render_callback'     => function () {
				return get_template_part( 'inc/template-parts/header' );
			},
		),
	] )
	->addToSection( 'wpbf_woocommerce_menu_item_options' );

/* Fields - Product Page */

$product_priority = 0;

// Custom width.
wpbf_customizer_field()
	->id( 'woocommerce_single_custom_width' )
	->type( 'dimension' )
	->label( __( 'Custom Content Width', 'page-builder-framework' ) )
	->description( __( 'Default: 1200px', 'page-builder-framework' ) )
	->priority( $product_priority++ )
	->transport( 'postMessage' )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Alignment.
wpbf_customizer_field()
	->id( 'woocommerce_single_alignment' )
	->type( 'radio-image' )
	->label( __( 'Image Alignment', 'page-builder-framework' ) )
	->defaultValue( 'left' )
	->choices( [
		'left'  => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'right' => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	] )
	->priority( $product_priority++ )
	->transport( 'postMessage' )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Image container width.
wpbf_customizer_field()
	->id( 'woocommerce_single_image_width' )
	->type( 'slider' )
	->label( __( 'Image Width', 'page-builder-framework' ) )
	->priority( $product_priority++ )
	->defaultValue( 50 )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 25,
		'max'  => 75,
		'step' => 1,
	] )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Disable gallery zoom.
wpbf_customizer_field()
	->id( 'woocommerce_single_disable_gallery_zoom' )
	->type( 'toggle' )
	->label( __( 'Disable Gallery Zoom', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( $product_priority++ )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Disable gallery slider.
wpbf_customizer_field()
	->id( 'woocommerce_single_disable_gallery_slider' )
	->type( 'toggle' )
	->label( __( 'Disable Gallery Slider', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( $product_priority++ )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Disable gallery lightbox.
wpbf_customizer_field()
	->id( 'woocommerce_single_disable_gallery_lightbox' )
	->type( 'toggle' )
	->label( __( 'Disable Gallery Lightbox', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( $product_priority++ )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Summary separator.
wpbf_customizer_field()
	->id( 'woocommerce_single_summary_separator' )
	->type( 'select' )
	->label( __( 'Summary Separator', 'page-builder-framework' ) )
	->defaultValue( 'hide' )
	->choices( [
		'hide' => __( 'Hide', 'page-builder-framework' ),
		'show' => __( 'Show', 'page-builder-framework' ),
	] )
	->priority( $product_priority++ )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Separator.
wpbf_customizer_field()
	->id( 'woocommerce_single_quantity_separator' )
	->type( 'divider' )
	->priority( $product_priority++ )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Increase - Decrease button.
wpbf_customizer_field()
	->id( 'woocommerce_quantity_buttons' )
	->type( 'select' )
	->label( __( 'Price Quantity Buttons (+/-)', 'page-builder-framework' ) )
	->defaultValue( 'show' )
	->choices( [
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	] )
	->priority( $product_priority++ )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Price color.
wpbf_customizer_field()
	->id( 'woocommerce_single_price_color' )
	->type( 'color' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->defaultValue( '#3e4349' )
	->priority( $product_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Price font size.
wpbf_customizer_field()
	->id( 'woocommerce_single_price_size' )
	->type( 'input-slider' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->defaultValue( '22px' )
	->priority( $product_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Separator.
wpbf_customizer_field()
	->id( 'woocommerce_single_tabs_separator' )
	->type( 'divider' )
	->priority( $product_priority++ )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Tabs layout.
wpbf_customizer_field()
	->id( 'woocommerce_single_tabs' )
	->type( 'select' )
	->label( __( 'Tabs Layout', 'page-builder-framework' ) )
	->defaultValue( 'default' )
	->choices( [
		'default' => __( 'Default', 'page-builder-framework' ),
		'modern'  => __( 'Modern', 'page-builder-framework' ),
	] )
	->priority( $product_priority++ )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Tabs background color.
wpbf_customizer_field()
	->id( 'woocommerce_single_tabs_background_color' )
	->type( 'color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( '#e7e7ec' )
	->priority( $product_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		[
			'id'       => 'woocommerce_single_tabs',
			'operator' => '!=',
			'value'    => 'modern',
		],
	] )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Tabs background color alt.
wpbf_customizer_field()
	->id( 'woocommerce_single_tabs_background_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->defaultValue( '#f5f5f7' )
	->priority( $product_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		[
			'id'       => 'woocommerce_single_tabs',
			'operator' => '!=',
			'value'    => 'modern',
		],
	] )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Tabs background color active.
wpbf_customizer_field()
	->id( 'woocommerce_single_tabs_background_color_active' )
	->type( 'color' )
	->label( __( 'Active', 'page-builder-framework' ) )
	->defaultValue( '#ffffff' )
	->priority( $product_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		[
			'id'       => 'woocommerce_single_tabs',
			'operator' => '!=',
			'value'    => 'modern',
		],
	] )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Tabs font color.
wpbf_customizer_field()
	->id( 'woocommerce_single_tabs_font_color' )
	->type( 'color' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->defaultValue( '#3e4349' )
	->priority( $product_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Tabs hover color.
wpbf_customizer_field()
	->id( 'woocommerce_single_tabs_font_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( $product_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Tabs active color.
wpbf_customizer_field()
	->id( 'woocommerce_single_tabs_font_color_active' )
	->type( 'color' )
	->label( __( 'Active', 'page-builder-framework' ) )
	->priority( $product_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Tabs font size.
wpbf_customizer_field()
	->id( 'woocommerce_single_tabs_font_size' )
	->type( 'input-slider' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->defaultValue( '16px' )
	->priority( $product_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Separator.
wpbf_customizer_field()
	->id( 'woocommerce_single_add_to_cart_ajax_separator' )
	->type( 'divider' )
	->priority( $product_priority++ )
	->addToSection( 'wpbf_woocommerce_product_options' );

// Single add to cart ajax.
wpbf_customizer_field()
	->id( 'woocommerce_single_add_to_cart_ajax' )
	->type( 'toggle' )
	->label( __( 'Enable AJAX add to cart button', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( $product_priority++ )
	->addToSection( 'wpbf_woocommerce_product_options' );

/* Fields - Sidebar */

// Shop sidebar layout.
wpbf_customizer_field()
	->id( 'woocommerce_sidebar_layout' )
	->type( 'select' )
	->label( __( 'Shop Page Sidebar', 'page-builder-framework' ) )
	->defaultValue( 'none' )
	->priority( 0 )
	->choices( [
		'right' => __( 'Right', 'page-builder-framework' ),
		'left'  => __( 'Left', 'page-builder-framework' ),
		'none'  => __( 'No Sidebar', 'page-builder-framework' ),
	] )
	->addToSection( 'wpbf_woocommerce_sidebar_options' );

// Product sidebar layout.
wpbf_customizer_field()
	->id( 'woocommerce_single_sidebar_layout' )
	->type( 'select' )
	->label( __( 'Product Page Sidebar', 'page-builder-framework' ) )
	->defaultValue( 'none' )
	->priority( 1 )
	->choices( [
		'right' => __( 'Right', 'page-builder-framework' ),
		'left'  => __( 'Left', 'page-builder-framework' ),
		'none'  => __( 'No Sidebar', 'page-builder-framework' ),
	] )
	->addToSection( 'wpbf_woocommerce_sidebar_options' );

/* Fields - Notices */

// Store notice color.
wpbf_customizer_field()
	->id( 'woocommerce_store_notice_color' )
	->type( 'color' )
	->label( __( 'Store Notice', 'page-builder-framework' ) )
	// The woocommerce_store_notice priority is 10.
	->priority( 10 )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		[
			'id'       => 'woocommerce_demo_store',
			'operator' => '==',
			'value'    => true,
		],
	] )
	->addToSection( 'woocommerce_store_notice' );

// Separator.
wpbf_customizer_field()
	->id( 'woocommerce_store_notice_separator' )
	->type( 'divider' )
	->priority( 100 )
	->addToSection( 'woocommerce_store_notice' );

// Info color.
wpbf_customizer_field()
	->id( 'woocommerce_info_notice_color' )
	->type( 'color' )
	->label( __( 'Info Notice', 'page-builder-framework' ) )
	->priority( 100 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'woocommerce_store_notice' );

// Success color.
wpbf_customizer_field()
	->id( 'woocommerce_message_notice_color' )
	->type( 'color' )
	->label( __( 'Success Notice', 'page-builder-framework' ) )
	->defaultValue( '#4fe190' )
	->priority( 100 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'woocommerce_store_notice' );

// Error color.
wpbf_customizer_field()
	->id( 'woocommerce_error_notice_color' )
	->type( 'color' )
	->label( __( 'Error Notice', 'page-builder-framework' ) )
	->defaultValue( '#ff6347' )
	->priority( 100 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'woocommerce_store_notice' );

// Separator.
wpbf_customizer_field()
	->id( 'woocommerce_general_notice_color_separator' )
	->type( 'divider' )
	->priority( 100 )
	->addToSection( 'woocommerce_store_notice' );

// General notice's background color.
wpbf_customizer_field()
	->id( 'woocommerce_notice_bg_color' )
	->type( 'color' )
	->label( __( 'Notice Background Color', 'page-builder-framework' ) )
	->priority( 100 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'woocommerce_store_notice' );

// General notice's text color.
wpbf_customizer_field()
	->id( 'woocommerce_notice_text_color' )
	->type( 'color' )
	->label( __( 'Notice Font Color', 'page-builder-framework' ) )
	->priority( 100 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'woocommerce_store_notice' );

/* Fields - Checkout */

// Alignment.
wpbf_customizer_field()
	->id( 'woocommerce_checkout_layout' )
	->type( 'select' )
	->label( __( 'Layout', 'page-builder-framework' ) )
	->defaultValue( 'default' )
	->priority( 1 )
	->choices( [
		'default' => __( 'Default', 'page-builder-framework' ),
		'side'    => __( 'Side by Side', 'page-builder-framework' ),
	] )
	->addToSection( 'woocommerce_checkout' );

// Separator.
wpbf_customizer_field()
	->id( 'woocommerce_checkout_layout_separator' )
	->type( 'divider' )
	->priority( 2 )
	->addToSection( 'woocommerce_checkout' );

/* Fields - Product Loop */

$shop_priority = 20;

// Separator.
wpbf_customizer_field()
	->id( 'woocommerce_loop_separator_0' )
	->type( 'divider' )
	->priority( $shop_priority++ )
	->addToSection( 'woocommerce_product_catalog' );

// Custom width.
wpbf_customizer_field()
	->id( 'woocommerce_loop_custom_width' )
	->type( 'dimension' )
	->label( __( 'Custom Content Width', 'page-builder-framework' ) )
	->description( __( 'Default: 1200px', 'page-builder-framework' ) )
	->priority( $shop_priority++ )
	->transport( 'postMessage' )
	->addToSection( 'woocommerce_product_catalog' );

// Separator.
wpbf_customizer_field()
	->id( 'woocommerce_loop_separator_1' )
	->type( 'divider' )
	->priority( $shop_priority++ )
	->addToSection( 'woocommerce_product_catalog' );

// Remove page title.
wpbf_customizer_field()
	->id( 'woocommerce_loop_remove_page_title' )
	->type( 'toggle' )
	->label( __( 'Hide Page Title', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( $shop_priority++ )
	->addToSection( 'woocommerce_product_catalog' );

// Remove breadcrumbs.
wpbf_customizer_field()
	->id( 'woocommerce_loop_remove_breadcrumbs' )
	->type( 'toggle' )
	->label( __( 'Hide Breadcrumbs', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( $shop_priority++ )
	->addToSection( 'woocommerce_product_catalog' );

// Remove result count.
wpbf_customizer_field()
	->id( 'woocommerce_loop_remove_result_count' )
	->type( 'toggle' )
	->label( __( 'Hide Result Count', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( $shop_priority++ )
	->addToSection( 'woocommerce_product_catalog' );

// Remove ordering.
wpbf_customizer_field()
	->id( 'woocommerce_loop_remove_ordering' )
	->type( 'toggle' )
	->label( __( 'Hide Ordering', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( $shop_priority++ )
	->addToSection( 'woocommerce_product_catalog' );

// Separator.
wpbf_customizer_field()
	->id( 'woocommerce_loop_separator_2' )
	->type( 'divider' )
	->priority( $shop_priority++ )
	->addToSection( 'woocommerce_product_catalog' );

// Products per row.
wpbf_customizer_field()
	->id( 'woocommerce_loop_products_per_row' )
	->type( 'responsive-number' )
	->label( __( 'Products per Row', 'page-builder-framework' ) )
	->defaultValue( array(
		'desktop' => 4,
		'tablet'  => 3,
		'mobile'  => 1,
	) )
	->priority( $shop_priority++ )
	->properties( [
		'save_as_json' => true,
	] )
	->addToSection( 'woocommerce_product_catalog' );

// Grid gap.
wpbf_customizer_field()
	->id( 'woocommerce_loop_grid_gap' )
	->type( 'select' )
	->label( __( 'Grid Gap', 'page-builder-framework' ) )
	->defaultValue( 'large' )
	->priority( $shop_priority++ )
	->choices( [
		'small'    => __( 'Small', 'page-builder-framework' ),
		'medium'   => __( 'Medium', 'page-builder-framework' ),
		'large'    => __( 'Large', 'page-builder-framework' ),
		'xlarge'   => __( 'xLarge', 'page-builder-framework' ),
		'collapse' => __( 'Collapse', 'page-builder-framework' ),
	] )
	->addToSection( 'woocommerce_product_catalog' );

// Content alignment.
wpbf_customizer_field()
	->id( 'woocommerce_loop_content_alignment' )
	->type( 'radio-image' )
	->label( __( 'Content Alignment', 'page-builder-framework' ) )
	->defaultValue( 'left' )
	->priority( $shop_priority++ )
	->choices( [
		'left'   => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center' => WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'  => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	] )
	->transport( 'postMessage' )
	->addToSection( 'woocommerce_product_catalog' );

// Product structure.
wpbf_customizer_field()
	->id( 'woocommerce_loop_sortable_content' )
	->type( 'sortable' )
	->label( __( 'Structure', 'page-builder-framework' ) )
	->defaultValue( [
		'category',
		'title',
		'price',
		'add_to_cart',
	] )
	->choices( [
		'category'    => __( 'Category', 'page-builder-framework' ),
		'title'       => __( 'Title', 'page-builder-framework' ),
		'rating'      => __( 'Rating', 'page-builder-framework' ),
		'price'       => __( 'Price', 'page-builder-framework' ),
		'add_to_cart' => __( 'Add to Cart Button', 'page-builder-framework' ),
		'excerpt'     => __( 'Short Description', 'page-builder-framework' ),
	] )
	->priority( $shop_priority++ )
	->addToSection( 'woocommerce_product_catalog' );

// Layout.
wpbf_customizer_field()
	->id( 'woocommerce_loop_layout' )
	->type( 'select' )
	->label( __( 'Layout', 'page-builder-framework' ) )
	->defaultValue( 'default' )
	->priority( $shop_priority++ )
	->choices( [
		'default' => __( 'Default', 'page-builder-framework' ),
		'list'    => __( 'List', 'page-builder-framework' ),
	] )
	->addToSection( 'woocommerce_product_catalog' );

// Alignment.
wpbf_customizer_field()
	->id( 'woocommerce_loop_image_alignment' )
	->type( 'radio-image' )
	->label( __( 'Image Alignment', 'page-builder-framework' ) )
	->defaultValue( 'left' )
	->choices( [
		'left'  => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'right' => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	] )
	->priority( $shop_priority++ )
	->transport( 'postMessage' )
	->activeCallback( [
		[
			'id'       => 'woocommerce_loop_layout',
			'operator' => '==',
			'value'    => 'list',
		],
	] )
	->addToSection( 'woocommerce_product_catalog' );

// Image container width.
wpbf_customizer_field()
	->id( 'woocommerce_loop_image_width' )
	->type( 'slider' )
	->label( __( 'Image Width', 'page-builder-framework' ) )
	->defaultValue( 50 )
	->priority( $shop_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 25,
		'max'  => 75,
		'step' => 1,
	] )
	->activeCallback( [
		[
			'id'       => 'woocommerce_loop_layout',
			'operator' => '==',
			'value'    => 'list',
		],
	] )
	->addToSection( 'woocommerce_product_catalog' );

// Separator.
wpbf_customizer_field()
	->id( 'woocommerce_loop_sale_separator' )
	->type( 'divider' )
	->priority( $shop_priority++ )
	->addToSection( 'woocommerce_product_catalog' );

// Sale position.
wpbf_customizer_field()
	->id( 'woocommerce_loop_sale_position' )
	->type( 'select' )
	->label( __( 'Sale Badge', 'page-builder-framework' ) )
	->defaultValue( 'outside' )
	->priority( $shop_priority++ )
	->choices( [
		'none'    => __( 'Hide', 'page-builder-framework' ),
		'outside' => __( 'Outside', 'page-builder-framework' ),
		'inside'  => __( 'Inside', 'page-builder-framework' ),
	] )
	->addToSection( 'woocommerce_product_catalog' );

// Sale layout.
wpbf_customizer_field()
	->id( 'woocommerce_loop_sale_layout' )
	->type( 'select' )
	->label( __( 'Layout', 'page-builder-framework' ) )
	->defaultValue( 'round' )
	->priority( $shop_priority++ )
	->choices( [
		'round'  => __( 'Round', 'page-builder-framework' ),
		'square' => __( 'Square', 'page-builder-framework' ),
	] )
	->activeCallback( [
		[
			'id'       => 'woocommerce_loop_sale_position',
			'operator' => '!=',
			'value'    => 'none',
		],
	] )
	->addToSection( 'woocommerce_product_catalog' );

// Sale alignment.
wpbf_customizer_field()
	->id( 'woocommerce_loop_sale_alignment' )
	->type( 'radio-image' )
	->label( __( 'Alignment', 'page-builder-framework' ) )
	->defaultValue( 'left' )
	->choices( [
		'left'   => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center' => WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'  => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	] )
	->priority( $shop_priority++ )
	->activeCallback( [
		[
			'id'       => 'woocommerce_loop_sale_position',
			'operator' => '!=',
			'value'    => 'none',
		],
	] )
	->addToSection( 'woocommerce_product_catalog' );

// Sale font size.
wpbf_customizer_field()
	->id( 'woocommerce_loop_sale_font_size' )
	->type( 'input-slider' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->defaultValue( '14px' )
	->priority( $shop_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->activeCallback( [
		[
			'id'       => 'woocommerce_loop_sale_position',
			'operator' => '!=',
			'value'    => 'none',
		],
	] )
	->addToSection( 'woocommerce_product_catalog' );

// Sale background color.
wpbf_customizer_field()
	->id( 'woocommerce_loop_sale_background_color' )
	->type( 'color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( '#4fe190' )
	->priority( $shop_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		[
			'id'       => 'woocommerce_loop_sale_position',
			'operator' => '!=',
			'value'    => 'none',
		],
	] )
	->addToSection( 'woocommerce_product_catalog' );

// Sale color.
wpbf_customizer_field()
	->id( 'woocommerce_loop_sale_font_color' )
	->type( 'color' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->defaultValue( '#fff' )
	->priority( $shop_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		[
			'id'       => 'woocommerce_loop_sale_position',
			'operator' => '!=',
			'value'    => 'none',
		],
	] )
	->addToSection( 'woocommerce_product_catalog' );

// Separator.
wpbf_customizer_field()
	->id( 'woocommerce_loop_title_separator' )
	->type( 'divider' )
	->priority( $shop_priority++ )
	->addToSection( 'woocommerce_product_catalog' );

// Title font size.
wpbf_customizer_field()
	->id( 'woocommerce_loop_title_size' )
	->type( 'input-slider' )
	->label( __( 'Title Font Size', 'page-builder-framework' ) )
	->defaultValue( '16px' )
	->priority( $shop_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->addToSection( 'woocommerce_product_catalog' );

// Title color.
wpbf_customizer_field()
	->id( 'woocommerce_loop_title_color' )
	->type( 'color' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->defaultValue( '#3e4349' )
	->priority( $shop_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'woocommerce_product_catalog' );

// Separator.
wpbf_customizer_field()
	->id( 'woocommerce_loop_price_separator' )
	->type( 'divider' )
	->priority( $shop_priority++ )
	->addToSection( 'woocommerce_product_catalog' );

// Price font size.
wpbf_customizer_field()
	->id( 'woocommerce_loop_price_size' )
	->type( 'input-slider' )
	->label( __( 'Price Font Size', 'page-builder-framework' ) )
	->defaultValue( '16px' )
	->priority( $shop_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->addToSection( 'woocommerce_product_catalog' );

// Price color.
wpbf_customizer_field()
	->id( 'woocommerce_loop_price_color' )
	->type( 'color' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->defaultValue( '#3e4349' )
	->priority( $shop_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'woocommerce_product_catalog' );

// Separator.
wpbf_customizer_field()
	->id( 'woocommerce_loop_out_of_stock_separator' )
	->type( 'divider' )
	->priority( $shop_priority++ )
	->addToSection( 'woocommerce_product_catalog' );

// Out of stock notice.
wpbf_customizer_field()
	->id( 'woocommerce_loop_out_of_stock_notice' )
	->type( 'select' )
	->label( __( 'Out of Stock Notice', 'page-builder-framework' ) )
	->defaultValue( 'show' )
	->priority( $shop_priority++ )
	->choices( [
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	] )
	->addToSection( 'woocommerce_product_catalog' );

// Out of stock background color.
wpbf_customizer_field()
	->id( 'woocommerce_loop_out_of_stock_background_color' )
	->type( 'color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( 'rgba(0,0,0,.7)' )
	->priority( $shop_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		[
			'id'       => 'woocommerce_loop_out_of_stock_notice',
			'operator' => '!=',
			'value'    => 'hide',
		],
	] )
	->addToSection( 'woocommerce_product_catalog' );

// Out of stock color.
wpbf_customizer_field()
	->id( 'woocommerce_loop_out_of_stock_font_color' )
	->type( 'color' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->defaultValue( '#fff' )
	->priority( $shop_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->activeCallback( [
		[
			'id'       => 'woocommerce_loop_out_of_stock_notice',
			'operator' => '!=',
			'value'    => 'hide',
		],
	] )
	->addToSection( 'woocommerce_product_catalog' );

// Out of stock font size.
wpbf_customizer_field()
	->id( 'woocommerce_loop_out_of_stock_font_size' )
	->type( 'input-slider' )
	->label( __( 'Font Size', 'page-builder-framework' ) )
	->defaultValue( '14px' )
	->priority( $shop_priority++ )
	->transport( 'postMessage' )
	->properties( [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	] )
	->activeCallback( [
		[
			'id'       => 'woocommerce_loop_out_of_stock_notice',
			'operator' => '!=',
			'value'    => 'hide',
		],
	] )
	->addToSection( 'woocommerce_product_catalog' );
