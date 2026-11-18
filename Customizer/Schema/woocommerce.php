<?php
/**
 * Option schema: WooCommerce.
 *
 * One entry per option that stores a value: control type, default (the value visitors see when nothing is saved)
 * and, for options saved as JSON text, 'json' => true. See Customizer/Schema/OptionSchema.php.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return array(
	'woocommerce_menu_item_hide_if_not_wc' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'woocommerce_search_menu_item' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'woocommerce_menu_item_desktop' => array(
		'type'    => 'select',
		'default' => 'show',
	),
	'woocommerce_menu_item_desktop_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'woocommerce_menu_item_mobile' => array(
		'type'    => 'select',
		'default' => 'show',
	),
	'woocommerce_menu_item_mobile_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'woocommerce_menu_item_count' => array(
		'type'    => 'select',
		'default' => 'show',
	),
	'woocommerce_single_custom_width' => array(
		'type'    => 'dimension',
		'default' => '',
	),
	'woocommerce_single_alignment' => array(
		'type'    => 'radio-image',
		'default' => 'left',
	),
	'woocommerce_single_image_width' => array(
		'type'    => 'slider',
		'default' => 50,
	),
	'woocommerce_single_disable_gallery_zoom' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'woocommerce_single_disable_gallery_slider' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'woocommerce_single_disable_gallery_lightbox' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'woocommerce_single_summary_separator' => array(
		'type'    => 'select',
		'default' => 'hide',
	),
	'woocommerce_quantity_buttons' => array(
		'type'    => 'select',
		'default' => 'show',
	),
	'woocommerce_single_price_color' => array(
		'type'    => 'color',
		'default' => '#3e4349',
	),
	'woocommerce_single_price_size' => array(
		'type'    => 'input-slider',
		'default' => '22px',
	),
	'woocommerce_single_tabs' => array(
		'type'    => 'select',
		'default' => 'default',
	),
	'woocommerce_single_tabs_background_color' => array(
		'type'    => 'color',
		'default' => '#e7e7ec',
	),
	'woocommerce_single_tabs_background_color_alt' => array(
		'type'    => 'color',
		'default' => '#f5f5f7',
	),
	'woocommerce_single_tabs_background_color_active' => array(
		'type'    => 'color',
		'default' => '#ffffff',
	),
	'woocommerce_single_tabs_font_color' => array(
		'type'    => 'color',
		'default' => '#3e4349',
	),
	'woocommerce_single_tabs_font_color_alt' => array(
		'type'    => 'color',
		'default' => '',
	),
	'woocommerce_single_tabs_font_color_active' => array(
		'type'    => 'color',
		'default' => '',
	),
	'woocommerce_single_tabs_font_size' => array(
		'type'    => 'input-slider',
		'default' => '16px',
	),
	'woocommerce_single_add_to_cart_ajax' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'woocommerce_sidebar_layout' => array(
		'type'    => 'select',
		'default' => 'none',
	),
	'woocommerce_single_sidebar_layout' => array(
		'type'    => 'select',
		'default' => 'none',
	),
	'woocommerce_store_notice_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'woocommerce_info_notice_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'woocommerce_message_notice_color' => array(
		'type'    => 'color',
		'default' => '#4fe190',
	),
	'woocommerce_error_notice_color' => array(
		'type'    => 'color',
		'default' => '#ff6347',
	),
	'woocommerce_notice_bg_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'woocommerce_notice_text_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'woocommerce_checkout_layout' => array(
		'type'    => 'select',
		'default' => 'default',
	),
	'woocommerce_loop_custom_width' => array(
		'type'    => 'dimension',
		'default' => '',
	),
	'woocommerce_loop_remove_page_title' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'woocommerce_loop_remove_breadcrumbs' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'woocommerce_loop_remove_result_count' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'woocommerce_loop_remove_ordering' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'woocommerce_loop_products_per_row' => array(
		'type'    => 'responsive-number',
		'default' => array(
			'desktop' => 4,
			'tablet'  => 3,
			'mobile'  => 1,
		),
		'json'    => true,
	),
	'woocommerce_loop_grid_gap' => array(
		'type'    => 'select',
		'default' => 'large',
	),
	'woocommerce_loop_content_alignment' => array(
		'type'    => 'radio-image',
		'default' => 'left',
	),
	'woocommerce_loop_sortable_content' => array(
		'type'    => 'sortable',
		'default' => array( 'category', 'title', 'price', 'add_to_cart' ),
	),
	'woocommerce_loop_layout' => array(
		'type'    => 'select',
		'default' => 'default',
	),
	'woocommerce_loop_image_alignment' => array(
		'type'    => 'radio-image',
		'default' => 'left',
	),
	'woocommerce_loop_image_width' => array(
		'type'    => 'slider',
		'default' => 50,
	),
	'woocommerce_loop_sale_position' => array(
		'type'    => 'select',
		'default' => 'outside',
	),
	'woocommerce_loop_sale_layout' => array(
		'type'    => 'select',
		'default' => 'round',
	),
	'woocommerce_loop_sale_alignment' => array(
		'type'    => 'radio-image',
		'default' => 'left',
	),
	'woocommerce_loop_sale_font_size' => array(
		'type'    => 'input-slider',
		'default' => '14px',
	),
	'woocommerce_loop_sale_background_color' => array(
		'type'    => 'color',
		'default' => '#4fe190',
	),
	'woocommerce_loop_sale_font_color' => array(
		'type'    => 'color',
		'default' => '#ffffff',
	),
	'woocommerce_loop_title_size' => array(
		'type'    => 'input-slider',
		'default' => '16px',
	),
	'woocommerce_loop_title_color' => array(
		'type'    => 'color',
		'default' => '#3e4349',
	),
	'woocommerce_loop_price_size' => array(
		'type'    => 'input-slider',
		'default' => '16px',
	),
	'woocommerce_loop_price_color' => array(
		'type'    => 'color',
		'default' => '#3e4349',
	),
	'woocommerce_loop_out_of_stock_notice' => array(
		'type'    => 'select',
		'default' => 'show',
	),
	'woocommerce_loop_out_of_stock_background_color' => array(
		'type'    => 'color',
		'default' => 'rgba(0,0,0,.7)',
	),
	'woocommerce_loop_out_of_stock_font_color' => array(
		'type'    => 'color',
		'default' => '#ffffff',
	),
	'woocommerce_loop_out_of_stock_font_size' => array(
		'type'    => 'input-slider',
		'default' => '14px',
	),
);
