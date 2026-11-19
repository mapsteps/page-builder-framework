<?php
/**
 * Customizer CSS: WooCommerce (notices, cart menu item count, theme buttons on WooCommerce buttons, shop loop, sale
 * badge, product page, checkout).
 *
 * Plain PHP, included with wpbf_css_area( 'woocommerce' ) from wpbf_do_woocommerce_customizer_css()
 * (inc/integration/woocommerce/woocommerce-styles.php), which runs on wpbf_after_customizer_css as before. How to write
 * it: see styles/general.php. Premium's WooCommerce CSS is Premium's.
 *
 * The old code printed the success and error notice colors whenever they were saved, even as their defaults (their
 * links take the color then, which the stylesheet doesn't do), so they stay plain PHP with wpbf_css_saved_mod().
 *
 * Each wpbf_css() block has 'when' => its own option (also the accent color as a fallback): the old code skipped values
 * like 0 or '0' (no control saves them, an import can), so they stay skipped. Layouts, alignments and the tabs style
 * are plain ifs, as before (the preview redraws this file through PHP when they change).
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

use Mapsteps\Wpbf\Customizer\Schema\OptionSchema;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/*
 * Whether the accent color is set and differs from its default (when its wpbf_css() fallbacks below print). Read
 * outside wpbf_css() only for the two fixed rules that go with them; the accent color reloads the preview anyway.
 */
$wpbf_accent_default = OptionSchema::defaultValue( OptionSchema::find( 'page_accent_color' ) );
$wpbf_accent         = get_theme_mod( 'page_accent_color' );
$wpbf_accent_is_set  = $wpbf_accent && strtolower( (string) $wpbf_accent ) !== strtolower( (string) $wpbf_accent_default );

/*
 * Notices. Store and info notices: their own color, else the accent color, written from the fallback to the own color
 * so the own color comes last and wins (the same result as the old if/elseif, each color instant).
 */
wpbf_css( 'p.demo_store, .woocommerce-store-notice', array( 'background' => '{page_accent_color}' ), array( 'when' => 'page_accent_color' ) );
wpbf_css( 'p.demo_store, .woocommerce-store-notice', array( 'background' => '{woocommerce_store_notice_color}' ), array( 'when' => 'woocommerce_store_notice_color' ) );

foreach ( array( 'page_accent_color', 'woocommerce_info_notice_color' ) as $wpbf_option ) {

	wpbf_css( '.woocommerce-info:before, .woocommerce-info a', array( 'color' => '{' . $wpbf_option . '}' ), array( 'when' => $wpbf_option ) );

	if ( 'page_accent_color' !== $wpbf_option ) {
		wpbf_css(
			'.woocommerce-info a:hover',
			array( 'opacity' => '.8' ),
			array(
				'always' => true,
				'when'   => $wpbf_option,
			)
		);
	} elseif ( $wpbf_accent_is_set ) {
		wpbf_css( '.woocommerce-info a:hover', array( 'opacity' => '.8' ), array( 'always' => true ) );
	}

	wpbf_css( '.woocommerce-info', array( 'border-top-color' => '{' . $wpbf_option . '}' ), array( 'when' => $wpbf_option ) );

}

foreach ( array( 'message', 'error' ) as $wpbf_notice ) {

	$wpbf_color = wpbf_css_saved_mod( 'woocommerce_' . $wpbf_notice . '_notice_color' );

	if ( ! $wpbf_color ) {
		continue;
	}

	echo '.woocommerce-' . $wpbf_notice . ':before, .woocommerce-' . $wpbf_notice . ' a {color: ' . esc_attr( $wpbf_color ) . ';}'; // phpcs:ignore WordPress.Security.EscapeOutput -- Escaped.
	echo '.woocommerce-' . $wpbf_notice . ' a:hover {opacity: .8;}'; // phpcs:ignore WordPress.Security.EscapeOutput -- Fixed text.
	echo '.woocommerce-' . $wpbf_notice . ' {border-top-color: ' . esc_attr( $wpbf_color ) . ';}'; // phpcs:ignore WordPress.Security.EscapeOutput -- Escaped.

}

wpbf_css( '.woocommerce-info, .woocommerce-message, .woocommerce-error', array( 'background-color' => '{woocommerce_notice_bg_color}' ), array( 'when' => 'woocommerce_notice_bg_color' ) );
wpbf_css( '.woocommerce-info, .woocommerce-message, .woocommerce-error', array( 'color' => '{woocommerce_notice_text_color}' ), array( 'when' => 'woocommerce_notice_text_color' ) );

/*
 * Cart menu item count: its own color, else the menu's font color, else the accent color (mobile: its own color, the
 * desktop count color, the mobile menu's font color, the menu's font color, the accent color). Written from the last
 * fallback to the first, so the first one that's set comes last and wins.
 */
$wpbf_woo_count_colors = array(
	'.wpbf-menu .wpbf-woo-menu-item .wpbf-woo-menu-item-count'               => array(
		'show'   => 'woocommerce_menu_item_desktop',
		'colors' => array( 'page_accent_color', 'menu_font_color', 'woocommerce_menu_item_desktop_color' ),
	),
	'.wpbf-mobile-nav-wrapper .wpbf-woo-menu-item .wpbf-woo-menu-item-count' => array(
		'show'   => 'woocommerce_menu_item_mobile',
		'colors' => array( 'page_accent_color', 'menu_font_color', 'mobile_menu_font_color', 'woocommerce_menu_item_desktop_color', 'woocommerce_menu_item_mobile_color' ),
	),
);

foreach ( $wpbf_woo_count_colors as $wpbf_selector => $wpbf_count ) {

	if ( 'hide' === get_theme_mod( $wpbf_count['show'] ) ) {
		continue;
	}

	foreach ( $wpbf_count['colors'] as $wpbf_option ) {
		wpbf_css( $wpbf_selector, array( 'background' => '{' . $wpbf_option . '}' ), array( 'when' => $wpbf_option ) );
	}

}

// Theme buttons on WooCommerce buttons: border (only with a border width).
$wpbf_woo_buttons       = '.woocommerce a.button, .woocommerce button.button, .woocommerce a.button.alt, .woocommerce button.button.alt';
$wpbf_woo_buttons_hover = '.woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover';

wpbf_css(
	$wpbf_woo_buttons,
	array(
		'border-width' => '{button_border_width}px',
		'border-style' => 'solid',
		'border-color' => '{button_primary_border_color}',
	),
	array( 'when' => 'button_border_width' )
);

wpbf_css( $wpbf_woo_buttons_hover, array( 'border-color' => '{button_primary_border_color_alt}' ), array( 'when' => 'button_border_width' ) );

// Theme buttons: shape and colors (disabled buttons keep them on hover).
$wpbf_woo_buttons_all = $wpbf_woo_buttons . ', .woocommerce a.button.alt.disabled, .woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled[disabled], .woocommerce a.button.alt.disabled:hover, .woocommerce a.button.alt:disabled:hover, .woocommerce a.button.alt:disabled[disabled]:hover, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled[disabled], .woocommerce button.button.alt.disabled:hover, .woocommerce button.button.alt:disabled:hover, .woocommerce button.button.alt:disabled[disabled]:hover';

wpbf_css( $wpbf_woo_buttons_all, array( 'border-radius' => '{button_border_radius}px' ), array( 'when' => 'button_border_radius' ) );
wpbf_css( $wpbf_woo_buttons_all, array( 'background' => '{button_primary_bg_color}' ), array( 'when' => 'button_primary_bg_color' ) );
wpbf_css( $wpbf_woo_buttons_all, array( 'color' => '{button_primary_text_color}' ), array( 'when' => 'button_primary_text_color' ) );
wpbf_css( $wpbf_woo_buttons_hover, array( 'background' => '{button_primary_bg_color_alt}' ), array( 'when' => 'button_primary_bg_color_alt' ) );
wpbf_css( $wpbf_woo_buttons_hover, array( 'color' => '{button_primary_text_color_alt}' ), array( 'when' => 'button_primary_text_color_alt' ) );

// Shop loop.
wpbf_css( '.archive.woocommerce #inner-content', array( 'max-width' => '{woocommerce_loop_custom_width}' ), array( 'when' => 'woocommerce_loop_custom_width' ) );
wpbf_css( '.woocommerce ul.products li.product, .woocommerce-page ul.products li.product', array( 'text-align' => '{woocommerce_loop_content_alignment}' ), array( 'when' => 'woocommerce_loop_content_alignment' ) );

$wpbf_loop_alignment = get_theme_mod( 'woocommerce_loop_content_alignment' );

if ( 'center' === $wpbf_loop_alignment ) {
	echo '.woocommerce .products .star-rating {margin: 0 auto 10px auto;}';
}

if ( 'right' === $wpbf_loop_alignment ) {
	echo '.woocommerce .products .star-rating {display: block; text-align: right;}';
}

// List layout (the image beside the summary, above the mobile breakpoint).
if ( 'list' === get_theme_mod( 'woocommerce_loop_layout' ) ) {

	$wpbf_list_thumbnail = '.wpbf-woo-list-view .wpbf-woo-loop-thumbnail-wrapper';
	$wpbf_list_summary   = '.wpbf-woo-list-view .wpbf-woo-loop-summary';

	$wpbf_above_mobile = array(
		'media'  => 'min-mobile',
		'always' => true,
	);

	wpbf_css(
		$wpbf_list_thumbnail,
		array(
			'float' => 'left',
			'width' => '48%',
		),
		$wpbf_above_mobile
	);

	wpbf_css(
		$wpbf_list_summary,
		array(
			'float' => 'right',
			'width' => '48%',
		),
		$wpbf_above_mobile
	);

	wpbf_css( '.wpbf-woo-list-view.woocommerce ul.products li.product a img, .wpbf-woo-list-view ul.products li.product a img', array( 'margin-bottom' => '0' ), $wpbf_above_mobile );

	if ( 'right' === get_theme_mod( 'woocommerce_loop_image_alignment' ) ) {
		echo esc_attr( $wpbf_list_thumbnail ) . ' {float: right;}';
		echo esc_attr( $wpbf_list_summary ) . ' {float: left;}';
	}

	// Image width: 2% of it is the gap.
	$wpbf_image_width = array(
		'media' => 'min-mobile',
		'when'  => 'woocommerce_loop_image_width',
	);

	wpbf_css( $wpbf_list_thumbnail, array( 'width' => 'calc({woocommerce_loop_image_width}% - 2%)' ), $wpbf_image_width );
	wpbf_css( $wpbf_list_summary, array( 'width' => 'calc(98% - {woocommerce_loop_image_width}%)' ), $wpbf_image_width );

}

// Sale badge: alignment, shape, position.
$wpbf_sale_alignment = get_theme_mod( 'woocommerce_loop_sale_alignment' );
$wpbf_sale_layout    = get_theme_mod( 'woocommerce_loop_sale_layout' );

if ( 'right' === $wpbf_sale_alignment ) {
	echo '.woocommerce ul.products li.product .onsale {right: 0; left: auto; margin-right: -10px;}';
}

if ( 'center' === $wpbf_sale_alignment ) {
	echo '.woocommerce ul.products li.product .onsale {left: 50%; width: 90px; margin: 0 0 0 -45px; height: auto; line-height: 1; padding: 8px 0; border-radius: 0px;';

	if ( 'square' !== $wpbf_sale_layout ) {
		echo 'border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;';
	}

	echo '}';
}

if ( 'square' === $wpbf_sale_layout ) {
	echo '.woocommerce span.onsale {border-radius: 0;}';
}

if ( 'inside' === get_theme_mod( 'woocommerce_loop_sale_position' ) ) {

	if ( ! $wpbf_sale_alignment || 'left' === $wpbf_sale_alignment ) {
		echo '.woocommerce ul.products li.product .onsale {margin: 10px 0 0 10px;}';
	}

	if ( 'right' === $wpbf_sale_alignment ) {
		echo '.woocommerce ul.products li.product .onsale {margin: 10px 10px 0 0;}';
	}

	echo '.woocommerce span.onsale {margin: 10px 0 0 10px;}';

}

// Sale badge, title, price, out of stock notice. {option|px}: sizes typed without a unit get px.
$wpbf_sale_badge = '.woocommerce ul.products li.product .onsale, .woocommerce span.onsale';

wpbf_css( $wpbf_sale_badge, array( 'font-size' => '{woocommerce_loop_sale_font_size|px}' ), array( 'when' => 'woocommerce_loop_sale_font_size' ) );
wpbf_css( $wpbf_sale_badge, array( 'color' => '{woocommerce_loop_sale_font_color}' ), array( 'when' => 'woocommerce_loop_sale_font_color' ) );
wpbf_css( $wpbf_sale_badge, array( 'background-color' => '{woocommerce_loop_sale_background_color}' ), array( 'when' => 'woocommerce_loop_sale_background_color' ) );

$wpbf_loop_title = '.woocommerce ul.products li.product h3, .woocommerce ul.products li.product .woocommerce-loop-product__title, .woocommerce ul.products li.product .woocommerce-loop-category__title';

wpbf_css( $wpbf_loop_title, array( 'font-size' => '{woocommerce_loop_title_size|px}' ), array( 'when' => 'woocommerce_loop_title_size' ) );
wpbf_css( $wpbf_loop_title, array( 'color' => '{woocommerce_loop_title_color}' ), array( 'when' => 'woocommerce_loop_title_color' ) );
wpbf_css( '.woocommerce ul.products li.product .price', array( 'font-size' => '{woocommerce_loop_price_size|px}' ), array( 'when' => 'woocommerce_loop_price_size' ) );
wpbf_css( '.woocommerce ul.products li.product .price', array( 'color' => '{woocommerce_loop_price_color}' ), array( 'when' => 'woocommerce_loop_price_color' ) );

// The loop price color on the product page too; the product page's own price color (further down) wins when it's set.
$wpbf_single_price = '.woocommerce div.product span.price, .woocommerce div.product p.price';

wpbf_css( $wpbf_single_price, array( 'color' => '{woocommerce_loop_price_color}' ), array( 'when' => 'woocommerce_loop_price_color' ) );

$wpbf_out_of_stock = '.woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock';

wpbf_css( $wpbf_out_of_stock, array( 'font-size' => '{woocommerce_loop_out_of_stock_font_size|px}' ), array( 'when' => 'woocommerce_loop_out_of_stock_font_size' ) );
wpbf_css( $wpbf_out_of_stock, array( 'color' => '{woocommerce_loop_out_of_stock_font_color}' ), array( 'when' => 'woocommerce_loop_out_of_stock_font_color' ) );
wpbf_css( $wpbf_out_of_stock, array( 'background-color' => '{woocommerce_loop_out_of_stock_background_color}' ), array( 'when' => 'woocommerce_loop_out_of_stock_background_color' ) );

// Product page.
$wpbf_product_images  = '.woocommerce div.product div.images, .woocommerce #content div.product div.images, .woocommerce-page div.product div.images, .woocommerce-page #content div.product div.images';
$wpbf_product_summary = '.woocommerce div.product div.summary, .woocommerce #content div.product div.summary, .woocommerce-page div.product div.summary, .woocommerce-page #content div.product div.summary';

wpbf_css( '.single.woocommerce #inner-content', array( 'max-width' => '{woocommerce_single_custom_width}' ), array( 'when' => 'woocommerce_single_custom_width' ) );

if ( 'right' === get_theme_mod( 'woocommerce_single_alignment' ) ) {
	echo esc_attr( $wpbf_product_summary ) . ' {float: left;}';
	echo esc_attr( $wpbf_product_images ) . ' {float: right;}';
	echo '.single-product.woocommerce span.onsale {display: none;}';
}

// Image width (above the medium breakpoint): 2% of it is the gap.
$wpbf_image_width = array(
	'media' => 'min-medium',
	'when'  => 'woocommerce_single_image_width',
);

wpbf_css( $wpbf_product_images, array( 'width' => 'calc({woocommerce_single_image_width}% - 2%)' ), $wpbf_image_width );
wpbf_css( $wpbf_product_summary, array( 'width' => 'calc(98% - {woocommerce_single_image_width}%)' ), $wpbf_image_width );

if ( 'show' === get_theme_mod( 'woocommerce_single_summary_separator' ) ) {
	echo '.woocommerce div.product form.cart {padding-top: 20px; padding-bottom: 20px; border-top: 1px solid #d9d9e0; border-bottom: 1px solid #d9d9e0;}';
}

// Tabs.
$wpbf_tabs = '.woocommerce div.product .woocommerce-tabs ul.tabs';

wpbf_css( $wpbf_tabs . ' li a', array( 'font-size' => '{woocommerce_single_tabs_font_size|px}' ), array( 'when' => 'woocommerce_single_tabs_font_size' ) );
wpbf_css( $wpbf_tabs . ' li a', array( 'color' => '{woocommerce_single_tabs_font_color}' ), array( 'when' => 'woocommerce_single_tabs_font_color' ) );
wpbf_css( $wpbf_tabs . ' li a:hover', array( 'color' => '{woocommerce_single_tabs_font_color_alt}' ), array( 'when' => 'woocommerce_single_tabs_font_color_alt' ) );
wpbf_css( $wpbf_tabs . ' li.active a', array( 'color' => '{woocommerce_single_tabs_font_color_active}' ), array( 'when' => 'woocommerce_single_tabs_font_color_active' ) );

$wpbf_tabs_style = get_theme_mod( 'woocommerce_single_tabs' );

// Default tabs: background colors.
if ( ! $wpbf_tabs_style || 'default' === $wpbf_tabs_style ) {

	wpbf_css( $wpbf_tabs . ' li', array( 'background-color' => '{woocommerce_single_tabs_background_color}' ), array( 'when' => 'woocommerce_single_tabs_background_color' ) );

	wpbf_css(
		$wpbf_tabs . ' li:hover',
		array(
			'background-color'    => '{woocommerce_single_tabs_background_color_alt}',
			'border-bottom-color' => '{woocommerce_single_tabs_background_color_alt}',
		),
		array( 'when' => 'woocommerce_single_tabs_background_color_alt' )
	);

	wpbf_css(
		$wpbf_tabs . ' li.active, ' . $wpbf_tabs . ' li.active:hover',
		array(
			'background-color'    => '{woocommerce_single_tabs_background_color_active}',
			'border-bottom-color' => '{woocommerce_single_tabs_background_color_active}',
		),
		array( 'when' => 'woocommerce_single_tabs_background_color_active' )
	);

}

// Modern tabs: a line above the active tab in the active tab's font color, else the accent color.
if ( 'modern' === $wpbf_tabs_style ) {

	echo esc_attr( $wpbf_tabs ) . ' {border-top: 1px solid #d9d9e0;}';
	echo esc_attr( $wpbf_tabs ) . ' li {border: none; border-top: 5px solid transparent; background: none; margin: 0 40px 0 0;}';
	echo esc_attr( $wpbf_tabs ) . ' li a {padding-left: 0; padding-right: 0;}';
	echo esc_attr( $wpbf_tabs ) . ' li:last-child {border-right: none;}';
	echo esc_attr( $wpbf_tabs . ' li:hover, ' . $wpbf_tabs . ' li.active:hover' ) . ' {background: none;}';

	wpbf_css(
		$wpbf_tabs . ' li.active',
		array(
			'background' => 'none',
			'border-top' => '5px solid ' . $wpbf_accent_default,
		),
		array( 'always' => true )
	);

	wpbf_css( $wpbf_tabs . ' li.active', array( 'border-top' => '5px solid {page_accent_color}' ), array( 'when' => 'page_accent_color' ) );
	wpbf_css( $wpbf_tabs . ' li.active', array( 'border-top' => '5px solid {woocommerce_single_tabs_font_color_active}' ), array( 'when' => 'woocommerce_single_tabs_font_color_active' ) );

	echo '.woocommerce div.product .woocommerce-tabs .panel {padding: 0; border: none; margin-top: 30px;}';

}

// Price.
wpbf_css( $wpbf_single_price, array( 'font-size' => '{woocommerce_single_price_size|px}' ), array( 'when' => 'woocommerce_single_price_size' ) );
wpbf_css( $wpbf_single_price, array( 'color' => '{woocommerce_single_price_color}' ), array( 'when' => 'woocommerce_single_price_color' ) );

// Checkout: order review beside the form (one column from the medium breakpoint down).
if ( 'side' === get_theme_mod( 'woocommerce_checkout_layout' ) ) {

	echo '.woocommerce-checkout .col2-set {width: 53%; float: left;}';
	echo '.woocommerce-checkout .col2-set .col-1, .woocommerce-checkout .col2-set .col-2 {float: none; width: 100%;}';
	echo '#order_review_heading {float: right; width: 42%;}';
	echo '.woocommerce-checkout-review-order {width: 42%; float: right;}';
	echo '.woocommerce #payment #place_order, .woocommerce-page #payment #place_order {width: 100%;}';

	wpbf_css(
		'.woocommerce-checkout .col2-set, #order_review_heading, .woocommerce-checkout-review-order',
		array(
			'width' => '100%',
			'float' => 'none',
		),
		array(
			'media'  => 'max-medium',
			'always' => true,
		)
	);

}
