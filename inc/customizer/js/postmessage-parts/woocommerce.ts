import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
	emptyNotZero,
	toNumberValue,
} from "../customizer-util";
import { WpbfColorControlValue } from "../../../../Customizer/Controls/Color/src/color-interface";

export default function woocommerceSetup() {
	/* WooCommerce - Defaults */

	// Button border radius.
	listenToCustomizerValueChange<string | number>(
		"button_border_radius",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".woocommerce a.button, .woocommerce button.button",
				props: { "border-radius": maybeAppendSuffix(value) },
			});
		},
	);

	// Custom width.
	listenToCustomizerValueChange<string | number>(
		"woocommerce_loop_custom_width",
		function (settingId, value) {
			value = emptyNotZero(value) ? "1200px" : value;

			writeCSS(settingId, {
				selector: ".archive.woocommerce #inner-content",
				props: { "max-width": maybeAppendSuffix(value) },
			});
		},
	);

	/* WooCommerce - Menu Item */

	// Desktop color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_menu_item_desktop_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-menu .wpbf-woo-menu-item .wpbf-woo-menu-item-count",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Mobile color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_menu_item_mobile_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".wpbf-mobile-nav-wrapper .wpbf-woo-menu-item .wpbf-woo-menu-item-count",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	/* WooCommerce - Loop */

	// Content alignment.
	listenToCustomizerValueChange<string>(
		"woocommerce_loop_content_alignment",
		function (settingId, value) {
			writeCSS(settingId, {
				blocks: [
					{
						selector:
							".woocommerce ul.products li.product, .woocommerce-page ul.products li.product",
						props: { "text-align": value },
					},
					{
						selector: ".woocommerce .products .star-rating",
						props: {
							display: value === "right" ? "inline-block" : undefined,
							margin: value === "center" ? "0 auto 10px auto" : undefined,
							"text-align": value === "right" ? "right" : undefined,
						},
					},
				],
			});
		},
	);

	// Image alignment.
	listenToCustomizerValueChange<string>(
		"woocommerce_loop_image_alignment",
		function (settingId, value) {
			writeCSS(settingId, {
				blocks: [
					{
						selector: ".wpbf-woo-list-view .wpbf-woo-loop-thumbnail-wrapper",
						props: { float: value === "left" ? "left" : "right" },
					},
					{
						selector: ".wpbf-woo-list-view .wpbf-woo-loop-summary",
						props: { float: value === "left" ? "right" : "left" },
					},
				],
			});
		},
	);

	// Image width.
	listenToCustomizerValueChange<string | number>(
		"woocommerce_loop_image_width",
		function (settingId, value) {
			const numberValue = toNumberValue(value);

			writeCSS(settingId, {
				blocks: [
					{
						selector: ".wpbf-woo-list-view .wpbf-woo-loop-thumbnail-wrapper",
						props: { width: String(numberValue - 2) + "%" },
					},
					{
						selector: ".wpbf-woo-list-view .wpbf-woo-loop-summary",
						props: { width: String(98 - numberValue) + "%" },
					},
				],
			});
		},
	);

	// Title font size.
	listenToCustomizerValueChange<string | number>(
		"woocommerce_loop_title_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".woocommerce ul.products li.product h3, .woocommerce ul.products li.product .woocommerce-loop-product__title, .woocommerce ul.products li.product .woocommerce-loop-category__title",
				props: { "font-size": maybeAppendSuffix(value) },
			});
		},
	);

	// Title font color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_loop_title_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".woocommerce ul.products li.product h3, .woocommerce ul.products li.product .woocommerce-loop-product__title, .woocommerce ul.products li.product .woocommerce-loop-category__title",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Price font size.
	listenToCustomizerValueChange<string | number>(
		"woocommerce_loop_price_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".woocommerce ul.products li.product .price",
				props: { "font-size": maybeAppendSuffix(value) },
			});
		},
	);

	// Price font color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_loop_price_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".woocommerce ul.products li.product .price",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Out of stock notice.
	listenToCustomizerValueChange<string | number>(
		"woocommerce_loop_out_of_stock_font_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock",
				props: { "font-size": maybeAppendSuffix(value) },
			});
		},
	);

	// Out of stock color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_loop_out_of_stock_font_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Out of stock background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_loop_out_of_stock_background_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Sale font size.
	listenToCustomizerValueChange<string | number>(
		"woocommerce_loop_sale_font_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".woocommerce span.onsale",
				props: { "font-size": maybeAppendSuffix(value) },
			});
		},
	);

	// Sale font color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_loop_sale_font_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".woocommerce span.onsale",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Sale background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_loop_sale_background_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".woocommerce span.onsale",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	/* WooCommerce - Single */

	// Custom width.
	listenToCustomizerValueChange<string | number>(
		"woocommerce_single_custom_width",
		function (settingId, value) {
			value = emptyNotZero(value) ? "1200px" : value;

			writeCSS(settingId, {
				selector: ".single.woocommerce #inner-content",
				props: { "max-width": maybeAppendSuffix(value) },
			});
		},
	);

	// Image alignment.
	listenToCustomizerValueChange<string>(
		"woocommerce_single_alignment",
		function (settingId, value) {
			writeCSS(settingId, {
				blocks: [
					{
						selector:
							".woocommerce div.product div.summary, .woocommerce #content div.product div.summary, .woocommerce-page div.product div.summary, .woocommerce-page #content div.product div.summary",
						props: { float: value === "right" ? "left" : "right" },
					},
					{
						selector:
							".woocommerce div.product div.images, .woocommerce #content div.product div.images, .woocommerce-page div.product div.images, .woocommerce-page #content div.product div.images",
						props: { float: value === "right" ? "right" : "left" },
					},
					{
						selector: ".single-product.woocommerce span.onsale",
						props: { display: value === "right" ? "none" : "block" },
					},
				],
			});
		},
	);

	// Image width.
	listenToCustomizerValueChange<string | number>(
		"woocommerce_single_image_width",
		function (settingId, value) {
			const numberValue = toNumberValue(value);

			writeCSS(settingId, {
				blocks: [
					{
						selector:
							".woocommerce div.product div.images, .woocommerce #content div.product div.images, .woocommerce-page div.product div.images, .woocommerce-page #content div.product div.images",
						props: { width: String(numberValue - 2) + "%" },
					},
					{
						selector:
							".woocommerce div.product div.summary, .woocommerce #content div.product div.summary, .woocommerce-page div.product div.summary, .woocommerce-page #content div.product div.summary",
						props: { width: String(98 - numberValue) + "%" },
					},
				],
			});
		},
	);

	// Price font size.
	listenToCustomizerValueChange<string | number>(
		"woocommerce_single_price_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".woocommerce div.product span.price, .woocommerce div.product p.price",
				props: { fontSize: maybeAppendSuffix(value) },
			});
		},
	);

	// Price font color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_single_price_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".woocommerce div.product span.price, .woocommerce div.product p.price",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Tabs background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_single_tabs_background_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".woocommerce div.product .woocommerce-tabs ul.tabs li",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Tabs background color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_single_tabs_background_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".woocommerce div.product .woocommerce-tabs ul.tabs li:hover",
				props: {
					"background-color": toStringColor(value),
					"border-bottom-color": toStringColor(value),
				},
			});
		},
	);

	// Tabs background color active.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_single_tabs_background_color_active",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".woocommerce div.product .woocommerce-tabs ul.tabs li.active, .woocommerce div.product .woocommerce-tabs ul.tabs li.active:hover",
				props: {
					"background-color": toStringColor(value),
					"border-bottom-color": toStringColor(value),
				},
			});
		},
	);

	// Tabs font color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_single_tabs_font_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".woocommerce div.product .woocommerce-tabs ul.tabs li:not(.active) a",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Tabs font color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_single_tabs_font_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".woocommerce div.product .woocommerce-tabs ul.tabs li:not(.active) a:hover",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Tabs font color active.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_single_tabs_font_color_active",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".woocommerce div.product .woocommerce-tabs ul.tabs li.active a",
				props: { color: toStringColor(value) },
			});
		},
	);

	/** Woocommerce Store & Notices */

	// Woocommerce info notice's accent color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_info_notice_color",
		function (settingId, value) {
			writeCSS(settingId, {
				blocks: [
					{
						selector: ".woocommerce-info",
						props: { "border-top-color": toStringColor(value) },
					},
					{
						selector: ".woocommerce-info:before, .woocommerce-info a",
						props: { color: toStringColor(value) },
					},
				],
			});
		},
	);

	// Woocommerce success notice's accent color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_message_notice_color",
		function (settingId, value) {
			writeCSS(settingId, {
				blocks: [
					{
						selector: ".woocommerce-message",
						props: { "border-top-color": toStringColor(value) },
					},
					{
						selector: ".woocommerce-message:before, .woocommerce-message a",
						props: { color: toStringColor(value) },
					},
				],
			});
		},
	);

	// Woocommerce error notice's accent color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_error_notice_color",
		function (settingId, value) {
			writeCSS(settingId, {
				blocks: [
					{
						selector: ".woocommerce-error",
						props: { "border-top-color": toStringColor(value) },
					},
					{
						selector: ".woocommerce-error:before, .woocommerce-error a",
						props: { color: toStringColor(value) },
					},
				],
			});
		},
	);

	// Woocommerce general notice's background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_notice_bg_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".woocommerce-message",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Woocommerce general notice's text color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"woocommerce_notice_text_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".woocommerce-message",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Tabs font size.
	listenToCustomizerValueChange<string | number>(
		"woocommerce_single_tabs_font_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".woocommerce div.product .woocommerce-tabs ul.tabs li a",
				props: { fontSize: maybeAppendSuffix(value) },
			});
		},
	);
}
