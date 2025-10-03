import { WpbfCustomizeSetting } from "../../../Customizer/Controls/Base/src/base-interface";
import { WpbfCheckboxButtonsetControlValue } from "../../../Customizer/Controls/Checkbox/src/checkbox-interface";
import {
	WpbfColorControlValue,
	WpbfMulticolorControlValue,
} from "../../../Customizer/Controls/Color/src/color-interface";
import { parseJsonOrUndefined } from "../../../Customizer/Controls/Generic/src/string-util";
import { MarginPaddingValue } from "../../../Customizer/Controls/MarginPadding/src/margin-padding-interface";
import { DevicesValue } from "../../../Customizer/Controls/Responsive/src/responsive-interface";
import { proNotice } from "./partials/pro-notice";

(function ($: JQueryStatic, customizer?: WpbfCustomize) {
	const breakpoints = window.WpbfTheme.breakpoints;

	const mediaQueries = {
		mobile: "max-width: " + (breakpoints.tablet - 1).toString() + "px",
		tablet: "max-width: " + (breakpoints.desktop - 1).toString() + "px",
		desktop: "min-width: " + breakpoints.desktop.toString() + "px",
	};

	function toNumberValue(value: string | number): number {
		if (typeof value === "number") {
			return value;
		}

		if (value === "") return 0;

		return parseFloat(value);
	}

	/**
	 * Check if provided value is empty but not zero.
	 *
	 * @param {number|string} value The value to check.
	 * @returns {boolean} True or false.
	 */
	function emptyNotZero(value: number | string): boolean {
		if (value === "0" || value === 0) {
			return false;
		}

		return value ? false : true;
	}

	function valueHasUnit(value: string | number): boolean {
		if (!value) {
			return false;
		}

		const strValue = String(value);
		const unitPattern = /[a-z%]+$/i;
		const unitMatch = strValue.match(unitPattern);

		return unitMatch && unitMatch.length > 0 ? true : false;
	}

	function maybeAppendSuffix(
		value: string | number | undefined | null,
		suffix?: string,
	) {
		if (value === undefined || value === "" || value === null) {
			return undefined;
		}

		suffix = suffix || "px";

		return valueHasUnit(value) ? value : value + suffix;
	}

	function toStringColor(color: WpbfColorControlValue) {
		if (color === "" || typeof color === "number") {
			return undefined;
		}

		if (typeof color === "string") return color;
		if (!("r" in color)) return undefined;

		const alpha = "a" in color ? color.a : 1;

		return alpha && alpha < 1
			? `rgba(${color.r}, ${color.g}, ${color.b}, ${alpha})`
			: `rgb(${color.r}, ${color.g}, ${color.b})`;
	}

	function parseTemplateTags(value: string): string {
		if (!value) return "";

		let parsedValue = value.replace(/\{site_url\}/g, window.WpbfObj.siteUrl);

		return parsedValue;
	}

	function headerBuilderEnabled() {
		return customizer?.("wpbf_enable_header_builder").get() ? true : false;
	}

	// Mobile menu trigger handlers
	listenToCustomizerValueChange<string | number>(
		"wpbf_header_builder_mobile_menu_trigger_icon_size",
		(settingId, to) => {
			writeCSS(settingId, {
				selector: ".wpbf-menu-toggle",
				props: { "font-size": maybeAppendSuffix(to) }
			});
		}
	);

	listenToCustomizerValueChange<WpbfColorControlValue>(
		"wpbf_header_builder_mobile_menu_trigger_color",
		(settingId, to) => {
			writeCSS(settingId, {
				selector: ".wpbf-menu-toggle",
				props: { color: toStringColor(to) }
			});
		}
	);

	/**
	 * Get style tag element based on control id.
	 *
	 * @param {string} id The style data id.
	 * @return {HTMLStyleElement} The style tag element.
	 */
	function getStyleTag(id: string): HTMLStyleElement {
		const tag = document.head.querySelector(`style[data-id="${id}"]`);
		if (tag instanceof HTMLStyleElement) return tag;

		const styleTag = document.createElement("style");
		styleTag.dataset.id = id;
		styleTag.className = "wpbf-customize-live-style";

		document.head.append(styleTag);
		return styleTag;
	}

	function removeStyleTag(id: string) {
		const styleTag = document.querySelector(`style[data-id="${id}"]`);
		styleTag?.remove();
	}

	function writeCSS(
		styleTagOrId: HTMLStyleElement | string,
		args: {
			mediaQuery?: string;
			blocks?: {
				selector: string;
				props: Record<string, string | number | null | undefined>;
			}[];
			selector?: string;
			props?: Record<string, string | number | null | undefined>;
		},
	) {
		const styleTag =
			typeof styleTagOrId === "string"
				? getStyleTag(styleTagOrId)
				: styleTagOrId;

		const blocks = args.blocks && Array.isArray(args.blocks) ? args.blocks : [];
		const selector = args.selector || "";

		// Either blocks or selector should be set.
		if (!blocks.length && !selector) {
			return;
		}

		const mediaQuery = args.mediaQuery || "";

		let content = "";

		if (blocks.length) {
			if (mediaQuery) {
				content += `${mediaQuery} {`;
			}

			blocks.forEach((block) => {
				const blockSelector = block.selector;
				const blockProps = block.props;

				if (!blockSelector || !blockProps || !Object.keys(blockProps).length) {
					return;
				}

				content += `${blockSelector} {`;

				for (const [cssProp, cssValue] of Object.entries(blockProps)) {
					if (!cssProp || cssValue === null || cssValue === undefined) {
						continue;
					}

					content += `${cssProp}: ${cssValue};`;
				}

				content += "}";
			});

			if (mediaQuery) {
				content += "}";
			}

			styleTag.innerHTML = content;
			return;
		}

		const props = args.props;

		if (!props || !Object.keys(props).length) {
			return;
		}

		content = "";

		if (mediaQuery) {
			content += `${mediaQuery} {`;
		}

		content += `${selector} {`;

		for (const [cssProp, cssValue] of Object.entries(props)) {
			if (!cssProp || cssValue === null || cssValue === undefined) {
				continue;
			}

			content += `${cssProp}: ${cssValue};`;
		}

		content += "}";

		if (mediaQuery) {
			content += "}";
		}

		styleTag.innerHTML = content;
	}

	/**
	 * Write responsive CSS.
	 *
	 * @param {HTMLStyleElement} styleTagOrId - The style tag element or the style tag id.
	 * @param {string} selector - The CSS selector.
	 * @param {string|string[]} rule - The CSS rule.
	 * @param {Record<string, any>} value - The responsive CSS value.
	 */
	function writeResponsiveCSS(
		styleTagOrId: HTMLStyleElement | string,
		selector: string,
		rule: string | string[],
		value: Record<string, any>,
	) {
		const styleTag =
			typeof styleTagOrId === "string"
				? getStyleTag(styleTagOrId)
				: styleTagOrId;

		const breakpoints = window.WpbfTheme.breakpoints;
		let css = "";

		for (const device in value) {
			if (!value.hasOwnProperty(device)) continue;
			if (value[device] === "") continue;

			let deviceCSS = `${selector} { 
            ${typeof rule === "string" ? `${rule}: ${value[device]};` : rule.map((r) => `${r}: ${value[device]};`).join("\n")}
        }`;

			// Apply media queries based on the device.
			if (device === "mobile" && breakpoints.mobile) {
				deviceCSS = `@media (${mediaQueries.mobile}) { ${deviceCSS} }`;
			} else if (device === "tablet" && breakpoints.tablet) {
				deviceCSS = `@media (${mediaQueries.tablet}) { ${deviceCSS} }`;
			} else if (device === "desktop" && breakpoints.desktop) {
				deviceCSS = `@media (${mediaQueries.desktop}) { ${deviceCSS} }`;
			}

			css += deviceCSS + "\n";
		}

		styleTag.innerHTML = css;
	}

	window.wp.customize?.preview?.bind("pro_notice", function (action: string) {
		if (action === "show") {
			proNotice.show();
		} else {
			proNotice.hide();
		}
	});

	function listenToCustomizerValueChange<VT>(
		settingId: string,
		fn: (settingId: string, value: VT) => void,
	) {
		customizer?.(settingId, function (setting: WpbfCustomizeSetting<VT>) {
			setting.bind(function (value) {
				fn(settingId, value);
			});
		});
	}

	/* Layout */

	// Page width.
	listenToCustomizerValueChange<string | number>(
		"page_max_width",
		function (settingId, value) {
			value = emptyNotZero(value) ? "1200px" : value;

			writeCSS(settingId, {
				selector: ".wpbf-container, .wpbf-boxed-layout .wpbf-page",
				props: {
					"max-width": maybeAppendSuffix(value),
				},
			});
		},
	);

	// Padding.
	listenToCustomizerValueChange<string | MarginPaddingValue>(
		"page_padding",
		function (settingId, value) {
			const obj = parseJsonOrUndefined<MarginPaddingValue>(value);

			writeCSS(settingId + "-desktop", {
				selector: "#inner-content",
				props: {
					"padding-top": maybeAppendSuffix(obj?.desktop_top),
					"padding-right": maybeAppendSuffix(obj?.desktop_right),
					"padding-bottom": maybeAppendSuffix(obj?.desktop_bottom),
					"padding-left": maybeAppendSuffix(obj?.desktop_left),
				},
			});

			writeCSS(settingId + "-tablet", {
				mediaQuery: `@media (${mediaQueries.tablet})`,
				selector: "#inner-content",
				props: {
					"padding-top": maybeAppendSuffix(obj?.tablet_top),
					"padding-right": maybeAppendSuffix(obj?.tablet_right),
					"padding-bottom": maybeAppendSuffix(obj?.tablet_bottom),
					"padding-left": maybeAppendSuffix(obj?.tablet_left),
				},
			});

			writeCSS(settingId + "-mobile", {
				mediaQuery: `@media (${mediaQueries.mobile})`,
				selector: "#inner-content",
				props: {
					"padding-top": maybeAppendSuffix(obj?.mobile_top),
					"padding-right": maybeAppendSuffix(obj?.mobile_right),
					"padding-bottom": maybeAppendSuffix(obj?.mobile_bottom),
					"padding-left": maybeAppendSuffix(obj?.mobile_left),
				},
			});
		},
	);

	// Boxed margin.
	listenToCustomizerValueChange<string | number>(
		"page_boxed_margin",
		function (settingId, value) {
			$(".wpbf-page")
				.css("margin-top", value + "px")
				.css("margin-bottom", value + "px");
		},
	);

	// Boxed padding.
	listenToCustomizerValueChange<string | number>(
		"page_boxed_padding",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-container",
				props: {
					"padding-left": maybeAppendSuffix(value),
					"padding-right": maybeAppendSuffix(value),
				},
			});
		},
	);

	// Boxed background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"page_boxed_background",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-page",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// ScrollTop position.
	listenToCustomizerValueChange<string>(
		"scrolltop_position",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".scrolltop",
				props: {
					left: value === "left" ? "20px" : "auto",
					right: value === "left" ? "auto" : "20px",
				},
			});
		},
	);

	// ScrollTop background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"scrolltop_bg_color",
		function (settingId, value) {
			// styleTag.innerHTML = ".scrolltop {background-color: " + newValue + ";}";
			writeCSS(settingId, {
				selector: ".scrolltop",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// ScrollTop background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"scrolltop_bg_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".scrolltop:hover",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// ScrollTop icon color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"scrolltop_icon_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".scrolltop",
				props: { color: toStringColor(value) },
			});
		},
	);

	// ScrollTop icon color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"scrolltop_icon_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".scrolltop:hover",
				props: { color: toStringColor(value) },
			});
		},
	);

	// ScrollTop border radius.
	listenToCustomizerValueChange<string | number>(
		"scrolltop_border_radius",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".scrolltop",
				props: { borderRadius: maybeAppendSuffix(value) },
			});
		},
	);

	/* Typography */

	listenToCustomizerValueChange<WpbfColorControlValue>(
		"page_font_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: "body",
				props: { color: toStringColor(value) },
			});
		},
	);

	/* 404 */

	listenToCustomizerValueChange<string>(
		"404_headline",
		function (settingId, value) {
			$(".wpbf-404-content .entry-title").text(value);
		},
	);

	listenToCustomizerValueChange<string>(
		"404_text",
		function (settingId, value) {
			$(".wpbf-404-content p").text(value);
		},
	);

	/* Navigation */

	// Width.
	listenToCustomizerValueChange<number | string>(
		"menu_width",
		function (settingId, value) {
			const selector = headerBuilderEnabled()
				? `.wpbf-header-row-desktop_row_2 .wpbf-container`
				: `.wpbf-nav-wrapper`;

			writeCSS(settingId, {
				selector: selector,
				props: { "max-width": maybeAppendSuffix(value) },
			});
		},
	);

	// Menu height.
	listenToCustomizerValueChange<number | string>(
		"menu_height",
		function (settingId, value) {
			const selector = headerBuilderEnabled()
				? `.wpbf-header-row-desktop_row_2`
				: `.wpbf-nav-wrapper`;

			writeCSS(settingId, {
				selector: selector,
				props: {
					"padding-top": maybeAppendSuffix(value),
					"padding-bottom": maybeAppendSuffix(value),
				},
			});
		},
	);

	// Menu padding.
	listenToCustomizerValueChange<string | number>(
		"menu_padding",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-navigation .wpbf-menu > .menu-item > a",
				props: {
					"padding-left": maybeAppendSuffix(value),
					"padding-right": maybeAppendSuffix(value),
				},
			});
		},
	);

	// Background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"menu_bg_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".wpbf-navigation:not(.wpbf-navigation-transparent):not(.wpbf-navigation-active)",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Menu font colors.
	listenToCustomizerValueChange<WpbfMulticolorControlValue>(
		"menu_font_colors",
		(settingId, value) => {
			const rawDefaultColor = value.default ?? "";
			const defaultColor = toStringColor(rawDefaultColor);

			const rawHoverColor = value.hover ?? "";
			const hoverColor = toStringColor(rawHoverColor);

			writeCSS(settingId, {
				blocks: [
					{
						selector:
							".wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a, .wpbf-close",
						props: { color: defaultColor },
					},
					{
						selector:
							".wpbf-navigation .wpbf-menu a:hover, .wpbf-mobile-menu a:hover",
						props: { color: hoverColor },
					},
					{
						selector:
							".wpbf-navigation .wpbf-menu > .current-menu-item > a, .wpbf-mobile-menu > .current-menu-item > a",
						props: { color: `${hoverColor}!important` },
					},
				],
			});
		},
	);

	// Font size.
	listenToCustomizerValueChange<string | number>(
		"menu_font_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a",
				props: {
					fontSize: maybeAppendSuffix(value),
				},
			});
		},
	);

	/* Sub Menu */

	// Text alignment.
	listenToCustomizerValueChange<string>(
		"sub_menu_text_alignment",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-sub-menu .sub-menu",
				props: { "text-align": value },
			});
		},
	);

	// Padding.
	listenToCustomizerValueChange<MarginPaddingValue | string>(
		"sub_menu_padding",
		function (settingId, value) {
			const obj = parseJsonOrUndefined<Record<string, number | string>>(value);

			writeCSS(settingId, {
				selector:
					".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu a",
				props: {
					"padding-top": maybeAppendSuffix(obj?.top),
					"padding-right": maybeAppendSuffix(obj?.right),
					"padding-bottom": maybeAppendSuffix(obj?.bottom),
					"padding-left": maybeAppendSuffix(obj?.left),
				},
			});
		},
	);

	// Width.
	listenToCustomizerValueChange<string | number>(
		"sub_menu_width",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu",
				props: { width: maybeAppendSuffix(value) },
			});
		},
	);

	// Background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"sub_menu_bg_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Background color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"sub_menu_bg_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li:hover",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Accent color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"sub_menu_accent_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-menu .sub-menu a",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Accent color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"sub_menu_accent_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-navigation .wpbf-menu .sub-menu a:hover",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Font size.
	listenToCustomizerValueChange<string | number>(
		"sub_menu_font_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-menu .sub-menu a",
				props: { "font-size": maybeAppendSuffix(value) },
			});
		},
	);

	// Separator color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"sub_menu_separator_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) li",
				props: { "border-bottom-color": toStringColor(value) },
			});
		},
	);

	/* Mobile Navigation */

	// Height.
	listenToCustomizerValueChange<string | number>(
		"mobile_menu_height",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-mobile-nav-wrapper",
				props: {
					"padding-top": maybeAppendSuffix(value),
					"padding-bottom": maybeAppendSuffix(value),
				},
			});
		},
	);

	// Background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"mobile_menu_background_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-mobile-nav-wrapper",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Icon color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"mobile_menu_hamburger_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-mobile-nav-item, .wpbf-mobile-nav-item a",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Hamburger size.
	listenToCustomizerValueChange<string | number>(
		"mobile_menu_hamburger_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-mobile-nav-item",
				props: { "font-size": maybeAppendSuffix(value) },
			});
		},
	);

	// Hamburger (filled) button color.
	listenToCustomizerValueChange<string | number>(
		"mobile_menu_hamburger_bg_color",
		function (settingId, value) {
			if (!value) {
				removeStyleTag(settingId);
				return;
			}

			const borderRadius = customizer?.(
				"mobile_menu_hamburger_border_radius",
			).get();

			writeCSS(settingId, {
				selector: ".wpbf-mobile-menu-toggle",
				props: {
					"background-color": toStringColor(value),
					color: "#ffffff !important",
					padding: "10px",
					"line-height": 1,
					"border-radius": emptyNotZero(borderRadius)
						? undefined
						: maybeAppendSuffix(borderRadius),
				},
			});
		},
	);

	// Hamburger (filled) button border radius.
	listenToCustomizerValueChange<string | number>(
		"mobile_menu_hamburger_border_radius",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-mobile-menu-toggle",
				props: {
					/**
					 * Intentionally not checking for the value,
					 * because we need to force overwrite the border-radius value set in "mobile_menu_hamburger_bg_color" block.
					 */
					"border-radius": maybeAppendSuffix(value),
				},
			});
		},
	);

	// Padding.
	listenToCustomizerValueChange<MarginPaddingValue | string>(
		"mobile_menu_padding",
		function (settingId, value) {
			const obj = parseJsonOrUndefined<Record<string, string | number>>(value);

			writeCSS(settingId, {
				selector:
					".wpbf-mobile-menu a, .wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle",
				props: {
					"padding-top": maybeAppendSuffix(obj?.top),
					"padding-right": maybeAppendSuffix(obj?.right),
					"padding-bottom": maybeAppendSuffix(obj?.bottom),
					"padding-left": maybeAppendSuffix(obj?.left),
				},
			});
		},
	);

	// Menu item background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"mobile_menu_bg_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-mobile-menu > .menu-item a",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Menu item background color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"mobile_menu_bg_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-mobile-menu > .menu-item a:hover",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Menu item font color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"mobile_menu_font_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".wpbf-mobile-menu a, .wpbf-mobile-menu-container .wpbf-close",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Menu item font color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"mobile_menu_font_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".wpbf-mobile-menu a:hover, .wpbf-mobile-menu > .current-menu-item > a",
				props: { color: toStringColor(value) + "!important" },
			});
		},
	);

	// Menu item divider color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"mobile_menu_border_color",
		function (settingId, value) {
			writeCSS(settingId, {
				blocks: [
					{
						selector: ".wpbf-mobile-menu .menu-item",
						props: { "border-top-color": toStringColor(value) },
					},
					{
						selector: ".wpbf-mobile-menu > .menu-item:last-child",
						props: { "border-bottom-color": toStringColor(value) },
					},
				],
			});
		},
	);

	// Sub menu arrow color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"mobile_menu_submenu_arrow_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-submenu-toggle",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Menu item font size.
	listenToCustomizerValueChange<string | number>(
		"mobile_menu_font_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".wpbf-mobile-menu a, .wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle",
				props: { "font-size": maybeAppendSuffix(value) },
			});
		},
	);

	/* Mobile sub menu */

	// Submenu auto collapse.
	listenToCustomizerValueChange<boolean>(
		"mobile_sub_menu_auto_collapse",
		function (settingId, value) {
			if (!document.querySelector("#mobile-navigation")) return;

			if (value) {
				$("#mobile-navigation")
					.closest(".wpbf-navigation")
					.addClass("wpbf-mobile-sub-menu-auto-collapse");
			} else {
				$("#mobile-navigation")
					.closest(".wpbf-navigation")
					.removeClass("wpbf-mobile-sub-menu-auto-collapse");
			}
		},
	);

	// Indent.
	listenToCustomizerValueChange<string | number>(
		"mobile_sub_menu_indent",
		function (settingId, value) {
			const paddingVal = customizer?.("mobile_menu_padding").get() as
				| string
				| MarginPaddingValue;

			const padding =
				parseJsonOrUndefined<Record<string, string | number>>(paddingVal);

			let paddingLeft = String(padding?.left ?? 0);

			const calculation =
				parseInt(String(value), 10) + parseInt(paddingLeft, 10);

			writeCSS(settingId, {
				selector: ".wpbf-mobile-menu .sub-menu a",
				props: { "padding-left": maybeAppendSuffix(calculation) },
			});
		},
	);

	// Mobile sub-menu item background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"mobile_sub_menu_bg_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-mobile-menu .sub-menu a",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Mobile sub-menu item background color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"mobile_sub_menu_bg_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-mobile-menu .sub-menu a:hover",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Mobile sub-menu item font color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"mobile_sub_menu_font_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-mobile-menu .sub-menu a",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Menu item font color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"mobile_sub_menu_font_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".wpbf-mobile-menu .sub-menu a:hover, .wpbf-mobile-menu .sub-menu > .current-menu-item > a",
				props: { color: toStringColor(value) + "!important" },
			});
		},
	);

	// Mobile sub-menu item divider color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"mobile_sub_menu_border_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-mobile-menu .sub-menu .menu-item",
				props: { "border-top-color": toStringColor(value) },
			});
		},
	);

	// Mobile sub-menu item arrow color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"mobile_sub_menu_arrow_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-mobile-menu .sub-menu .wpbf-submenu-toggle",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Mobile sub-menu item font size.
	listenToCustomizerValueChange<string | number>(
		"mobile_sub_menu_font_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".wpbf-mobile-menu .sub-menu a, .wpbf-mobile-menu .sub-menu .menu-item-has-children .wpbf-submenu-toggle",
				props: { "font-size": maybeAppendSuffix(value) },
			});
		},
	);

	/* Logo */

	// Width.
	listenToCustomizerValueChange<string | DevicesValue>(
		"menu_logo_size",
		function (settingId, value) {
			const obj = parseJsonOrUndefined<DevicesValue>(value);

			writeCSS(settingId + "-desktop", {
				selector: ".wpbf-logo img, .wpbf-mobile-logo img",
				props: {
					width: maybeAppendSuffix(obj?.desktop),
				},
			});

			writeCSS(settingId + "-tablet", {
				mediaQuery: `@media (${mediaQueries.tablet})`,
				selector: ".wpbf-mobile-logo img",
				props: { width: maybeAppendSuffix(obj?.tablet) },
			});

			writeCSS(settingId + "-mobile", {
				mediaQuery: `@media (${mediaQueries.mobile})`,
				selector: ".wpbf-mobile-logo img",
				props: { width: maybeAppendSuffix(obj?.mobile) },
			});
		},
	);

	// Font size.
	listenToCustomizerValueChange<string | DevicesValue>(
		"menu_logo_font_size",
		function (settingId, value) {
			const obj = parseJsonOrUndefined<DevicesValue>(value);

			writeCSS(settingId + "-desktop", {
				selector: ".wpbf-logo a, .wpbf-mobile-logo a",
				props: {
					"font-size": maybeAppendSuffix(obj?.desktop),
				},
			});

			writeCSS(settingId + "-tablet", {
				mediaQuery: `@media (${mediaQueries.tablet})`,
				selector: ".wpbf-mobile-logo a",
				props: { "font-size": maybeAppendSuffix(obj?.tablet) },
			});

			writeCSS(settingId + "-mobile", {
				mediaQuery: `@media (${mediaQueries.mobile})`,
				selector: ".wpbf-mobile-logo a",
				props: { "font-size": maybeAppendSuffix(obj?.mobile) },
			});
		},
	);

	// Color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"menu_logo_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-logo a, .wpbf-mobile-logo a",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"menu_logo_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-logo a:hover, .wpbf-mobile-logo a:hover",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Container width.
	listenToCustomizerValueChange<number | string>(
		"menu_logo_container_width",
		function (settingId, value) {
			const calculation = 100 - toNumberValue(value);

			writeCSS(settingId, {
				blocks: [
					{
						selector: ".wpbf-navigation .wpbf-1-4",
						props: {
							width: maybeAppendSuffix(value, "%"),
						},
					},
					{
						selector: ".wpbf-navigation .wpbf-3-4",
						props: {
							width: maybeAppendSuffix(calculation, "%"),
						},
					},
				],
			});
		},
	);

	// Mobile container width.
	listenToCustomizerValueChange<number | string>(
		"mobile_menu_logo_container_width",
		function (settingId, value) {
			const calculation = 100 - toNumberValue(value);

			writeCSS(settingId, {
				mediaQuery: `@media (${mediaQueries.tablet})`,
				blocks: [
					{
						selector: ".wpbf-navigation .wpbf-2-3",
						props: { width: maybeAppendSuffix(value, "%") },
					},
					{
						selector: ".wpbf-navigation .wpbf-1-3",
						props: { width: maybeAppendSuffix(calculation, "%") },
					},
				],
			});
		},
	);

	/* Tagline */

	// Font size.
	listenToCustomizerValueChange<string | DevicesValue>(
		"menu_logo_description_font_size",
		function (settingId, value) {
			const obj = parseJsonOrUndefined<DevicesValue>(value);

			writeCSS(settingId + "-desktop", {
				selector: ".wpbf-logo .wpbf-tagline, .wpbf-mobile-logo .wpbf-tagline",
				props: {
					"font-size": maybeAppendSuffix(obj?.desktop),
				},
			});

			writeCSS(settingId + "-tablet", {
				mediaQuery: `@media (${mediaQueries.tablet})`,
				selector: ".wpbf-mobile-logo .wpbf-tagline",
				props: { "font-size": maybeAppendSuffix(obj?.tablet) },
			});

			writeCSS(settingId + "-mobile", {
				mediaQuery: `@media (${mediaQueries.mobile})`,
				selector: ".wpbf-mobile-logo .wpbf-tagline",
				props: { "font-size": maybeAppendSuffix(obj?.mobile) },
			});
		},
	);

	// Font color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"menu_logo_description_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-tagline",
				props: { color: toStringColor(value) },
			});
		},
	);

	/* Pre Header */

	// Width.
	listenToCustomizerValueChange<number | string>(
		"pre_header_width",
		function (settingId, value) {
			value = emptyNotZero(value) ? "1200px" : value;

			writeCSS(settingId, {
				selector: ".wpbf-inner-pre-header",
				props: { "max-width": maybeAppendSuffix(value) },
			});
		},
	);

	// Height.
	listenToCustomizerValueChange<number | string>(
		"pre_header_height",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-inner-pre-header",
				props: {
					"padding-top": maybeAppendSuffix(value),
					"padding-bottom": maybeAppendSuffix(value),
				},
			});
		},
	);

	// Background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"pre_header_bg_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-pre-header",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Font color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"pre_header_font_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-pre-header",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Pre-header accent colors.
	listenToCustomizerValueChange<WpbfMulticolorControlValue>(
		"pre_header_accent_colors",
		(settingId, value) => {
			const rawDefaultColor = value.default ?? "";
			const defaultColor = toStringColor(rawDefaultColor);

			const rawHoverColor = value.hover ?? "";
			const hoverColor = toStringColor(rawHoverColor);

			writeCSS(settingId, {
				blocks: [
					{
						selector: ".wpbf-pre-header a",
						props: { color: defaultColor },
					},
					{
						selector:
							".wpbf-pre-header a:hover, .wpbf-pre-header .wpbf-menu > .current-menu-item > a",
						props: { color: `${hoverColor}!important` },
					},
				],
			});
		},
	);

	// Font size.
	listenToCustomizerValueChange<string | number>(
		"pre_header_font_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".wpbf-pre-header, .wpbf-pre-header .wpbf-menu, .wpbf-pre-header .wpbf-menu .sub-menu a",
				props: { "font-size": maybeAppendSuffix(value) },
			});
		},
	);

	/* Blog – Pagination */

	// Border radius.
	listenToCustomizerValueChange<string | number>(
		"blog_pagination_border_radius",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".pagination .page-numbers",
				props: { borderRadius: maybeAppendSuffix(value) },
			});
		},
	);

	// Background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"blog_pagination_background_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".pagination .page-numbers:not(.current)",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Background color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"blog_pagination_background_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".pagination .page-numbers:not(.current):hover",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Background color active.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"blog_pagination_background_color_active",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".pagination .page-numbers.current",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Font color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"blog_pagination_font_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".pagination .page-numbers:not(.current)",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Font color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"blog_pagination_font_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".pagination .page-numbers:not(.current):hover",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Font color active.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"blog_pagination_font_color_active",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".pagination .page-numbers.current",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Font size.
	listenToCustomizerValueChange<string | number>(
		"blog_pagination_font_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".pagination .page-numbers",
				props: { "font-size": maybeAppendSuffix(value) },
			});
		},
	);

	/* Sidebar */

	// Width.
	listenToCustomizerValueChange<number | string>(
		"sidebar_width",
		function (settingId, value) {
			const calculation = 100 - toNumberValue(value);

			writeCSS(settingId, {
				mediaQuery: "@media (min-width: 769px)",
				blocks: [
					{
						selector:
							"body:not(.wpbf-no-sidebar) .wpbf-sidebar-wrapper.wpbf-medium-1-3",
						props: { width: maybeAppendSuffix(value, "%") },
					},
					{
						selector: "body:not(.wpbf-no-sidebar) .wpbf-main.wpbf-medium-2-3",
						props: { width: maybeAppendSuffix(calculation, "%") },
					},
				],
			});
		},
	);

	// Background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"sidebar_bg_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-sidebar .widget, .elementor-widget-sidebar .widget",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	/* Buttons */

	// Background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_bg_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					'.wpbf-button:not(.wpbf-button-primary), input[type="submit"]',
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Background color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_bg_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					'.wpbf-button:not(.wpbf-button-primary):hover, input[type="submit"]:hover',
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Text color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_text_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					'.wpbf-button:not(.wpbf-button-primary), input[type="submit"]',
				props: { color: toStringColor(value) },
			});
		},
	);

	// Text color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_text_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					'.wpbf-button:not(.wpbf-button-primary):hover, input[type="submit"]:hover',
				props: { color: toStringColor(value) },
			});
		},
	);

	// Primary background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_primary_bg_color",
		function (settingId, value) {
			writeCSS(settingId, {
				blocks: [
					{
						selector: ".wpbf-button-primary",
						props: {
							"background-color": toStringColor(value),
						},
					},
					{
						selector:
							".wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background)",
						props: {
							"background-color": toStringColor(value),
						},
					},
					{
						selector:
							".is-style-outline .wp-block-button__link:not(.has-text-color):not(.has-background)",
						props: {
							"border-color": toStringColor(value),
							color: toStringColor(value),
						},
					},
				],
			});
		},
	);

	// Primary background color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_primary_bg_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				blocks: [
					{
						selector: ".wpbf-button-primary:hover",
						props: { "background-color": toStringColor(value) },
					},
					{
						selector:
							".wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):not(.has-text-color):hover",
						props: { "background-color": toStringColor(value) },
					},
					{
						selector:
							".is-style-outline .wp-block-button__link:not(.has-text-color):not(.has-background):hover",
						props: {
							"border-color": toStringColor(value),
							color: toStringColor(value),
						},
					},
				],
			});
		},
	);

	// Primary text color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_primary_text_color",
		function (settingId, value) {
			writeCSS(settingId, {
				blocks: [
					{
						selector: ".wpbf-button-primary",
						props: { color: toStringColor(value) },
					},
					{
						selector:
							".wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-text-color)",
						props: { color: toStringColor(value) },
					},
				],
			});
		},
	);

	// Primary text color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_primary_text_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				blocks: [
					{
						selector: ".wpbf-button-primary:hover",
						props: {
							color: toStringColor(value),
						},
					},
					{
						selector:
							".wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):not(.has-text-color):hover",
						props: {
							color: toStringColor(value),
						},
					},
				],
			});
		},
	);

	// Border radius.
	listenToCustomizerValueChange<string | number>(
		"button_border_radius",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: '.wpbf-button, input[type="submit"]',
				props: {
					"border-radius": maybeAppendSuffix(value),
				},
			});
		},
	);

	// Border width.
	listenToCustomizerValueChange<number | string>(
		"button_border_width",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: '.wpbf-button, input[type="submit"]',
				props: {
					"border-width": maybeAppendSuffix(value),
					"border-style": "solid",
				},
			});
		},
	);

	// Border color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_border_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					'.wpbf-button:not(.wpbf-button-primary), input[type="submit"]',
				props: { "border-color": toStringColor(value) },
			});
		},
	);

	// Border color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_border_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					'.wpbf-button:not(.wpbf-button-primary):hover, input[type="submit"]:hover',
				props: { "border-color": toStringColor(value) },
			});
		},
	);

	// Primary border color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_primary_border_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-button-primary",
				props: { "border-color": toStringColor(value) },
			});
		},
	);

	// Primary border color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_primary_border_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-button-primary:hover",
				props: { "border-color": toStringColor(value) },
			});
		},
	);

	/* Breadcrumbs */

	// Background background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"breadcrumbs_background_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-breadcrumbs-container",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Alignment.
	listenToCustomizerValueChange<string>(
		"breadcrumbs_alignment",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-breadcrumbs-container",
				props: { "text-align": value },
			});
		},
	);

	// Font color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"breadcrumbs_font_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-breadcrumbs",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Accent color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"breadcrumbs_accent_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-breadcrumbs a",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Accent color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"breadcrumbs_accent_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-breadcrumbs a:hover",
				props: { color: toStringColor(value) },
			});
		},
	);

	/* Footer */

	// Width.
	listenToCustomizerValueChange<string | number>(
		"footer_width",
		function (settingId, value) {
			value = emptyNotZero(value) ? "1200px" : value;

			writeCSS(settingId, {
				selector: ".wpbf-inner-footer",
				props: { "max-width": maybeAppendSuffix(value) },
			});
		},
	);

	// Height.
	listenToCustomizerValueChange<string | number>(
		"footer_height",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-inner-footer",
				props: {
					"padding-top": maybeAppendSuffix(value),
					"padding-bottom": maybeAppendSuffix(value),
				},
			});
		},
	);

	// Background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"footer_bg_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-page-footer",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Font color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"footer_font_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-inner-footer",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Accent color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"footer_accent_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-inner-footer a",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Accent color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"footer_accent_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".wpbf-inner-footer a:hover, .wpbf-inner-footer .wpbf-menu > .current-menu-item > a",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Font size.
	listenToCustomizerValueChange<string | number>(
		"footer_font_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-inner-footer, .wpbf-inner-footer .wpbf-menu",
				props: {
					"font-size": maybeAppendSuffix(value),
				},
			});
		},
	);

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

	/* EDD - Menu Item */

	// Desktop color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"edd_menu_item_desktop_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-menu .wpbf-edd-menu-item .wpbf-edd-menu-item-count",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Mobile color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"edd_menu_item_mobile_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".wpbf-mobile-nav-wrapper .wpbf-edd-menu-item .wpbf-edd-menu-item-count",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	/* Easy Digital Downloads - Defaults */

	// Button border radius.
	listenToCustomizerValueChange<string | number>(
		"button_border_radius",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".edd-submit.button",
				props: { borderRadius: maybeAppendSuffix(value) },
			});
		},
	);

	/* Header Builder */
	const headerBuilderRows = ["desktop_row_1", "desktop_row_2", "desktop_row_3"];

	headerBuilderRows.forEach((rowKey) => {
		const controlIdPrefix = `wpbf_header_builder_${rowKey}_`;

		const visibilitySettingId = `${controlIdPrefix}visibility`;

		customizer?.(
			visibilitySettingId,
			(value: WpbfCustomizeSetting<WpbfCheckboxButtonsetControlValue>) => {
				const availableSizes = ["large", "medium", "small"];

				value.bind(function (newValue) {
					if (!newValue || !Array.isArray(newValue)) return;

					const selector =
						rowKey === "desktop_row_1"
							? ".wpbf-pre-header"
							: `.wpbf-header-row-${rowKey}`;

					const el = document.querySelector(selector);
					if (!el) return;

					availableSizes.forEach(function (size) {
						if (newValue.includes(size)) {
							el.classList.remove(`wpbf-hidden-${size}`);
						} else {
							el.classList.add(`wpbf-hidden-${size}`);
						}
					});
				});
			},
		);

		/**
		 * These fields are handled here for desktop_row_3 only
		 * because desktop_row_3 didn't exist before the new header builder added.
		 *
		 * Max width:
		 * - In desktop_row_1, the value is using the existing `pre_header_width` setting.
		 * - In desktop_row_2, the value is using the existing `menu_width` setting.
		 *
		 * Vertical padding:
		 * - In desktop_row_1, the value is using the existing `pre_header_height` setting.
		 * - In desktop_row_2, the value is using the existing `menu_height` setting.
		 *
		 * Font size:
		 * - In desktop_row_1, the value is using the existing `pre_header_font_size` setting.
		 * - In desktop_row_2, the value is using the existing `menu_font_size` setting.
		 *
		 * Background color:
		 * - In desktop_row_1, the value is using the existing `pre_header_bg_color` setting.
		 * - In desktop_row_2, the value is using the existing `menu_bg_color` setting.
		 *
		 * Text color:
		 * - In desktop_row_1, the value is using the existing `pre_header_font_color` setting.
		 * - In desktop_row_2, the value is using the existing `menu_font_colors` (multicolor) setting.
		 *
		 * Accent colors:
		 * - In desktop_row_1, the value is using the existing `pre_header_accent_colors` (multicolor) setting.
		 * - In desktop_row_2, there's no accent colors setting (we follow the old header section).
		 */
		if (rowKey === "desktop_row_3") {
			listenToCustomizerValueChange<string | number>(
				`${controlIdPrefix}max_width`,
				(settingId, value) => {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey} .wpbf-container`,
						props: { "max-width": maybeAppendSuffix(value) },
					});
				},
			);

			listenToCustomizerValueChange<string | number>(
				`${controlIdPrefix}vertical_padding`,
				function (settingId, value) {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey} .wpbf-row-content`,
						props: {
							"padding-top": maybeAppendSuffix(value),
							"padding-bottom": maybeAppendSuffix(value),
						},
					});
				},
			);

			listenToCustomizerValueChange<string | number>(
				`${controlIdPrefix}font_size`,
				(settingId, value) => {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey}`,
						props: { "font-size": maybeAppendSuffix(value) },
					});
				},
			);

			listenToCustomizerValueChange<WpbfColorControlValue>(
				`${controlIdPrefix}bg_color`,
				function (settingId, value) {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey}`,
						props: { "background-color": toStringColor(value) },
					});
				},
			);
		}

		listenToCustomizerValueChange<WpbfColorControlValue>(
			`${controlIdPrefix}text_color`,
			function (settingId, value) {
				writeCSS(settingId, {
					selector: `.wpbf-header-row-${rowKey}`,
					props: { color: toStringColor(value) },
				});
			},
		);

		listenToCustomizerValueChange<WpbfMulticolorControlValue>(
			`${controlIdPrefix}accent_colors`,
			(settingId, value) => {
				const rawDefaultColor = value.default ?? "";
				const defaultColor = toStringColor(rawDefaultColor);

				const rawHoverColor = value.hover ?? "";
				const hoverColor = toStringColor(rawHoverColor);

				writeCSS(settingId, {
					blocks: [
						{
							selector: `.wpbf-header-row-${rowKey} a`,
							props: { color: defaultColor },
						},
						{
							selector: `.wpbf-header-row-${rowKey} a:hover, .wpbf-header-row-${rowKey} a:focus`,
							props: { color: hoverColor },
						},
					],
				});
			},
		);
	});

	const headerBuilderButtonKeys = [
		"desktop_button_1",
		"desktop_button_2",
		"mobile_button_1",
		"mobile_button_2",
	];

	headerBuilderButtonKeys.forEach((buttonKey) => {
		const controlIdPrefix = `wpbf_header_builder_${buttonKey}`;

		listenToCustomizerValueChange<boolean>(
			controlIdPrefix + "_new_tab",
			function (settingId, value) {
				const link = document.querySelector(`.wpbf-button.${controlIdPrefix}`);
				if (!(link instanceof HTMLAnchorElement)) return;

				if (value) {
					link.target = "_blank";
				} else {
					link.removeAttribute("target");
				}
			},
		);

		listenToCustomizerValueChange<string>(
			controlIdPrefix + "_text",
			function (settingId, value) {
				const link = document.querySelector(`.wpbf-button.${controlIdPrefix}`);
				if (!(link instanceof HTMLAnchorElement)) return;
				link.innerHTML = parseTemplateTags(value);
			},
		);

		listenToCustomizerValueChange<string>(
			controlIdPrefix + "_url",
			function (settingId, value) {
				const link = document.querySelector(`.wpbf-button.${controlIdPrefix}`);
				if (!(link instanceof HTMLAnchorElement)) return;
				link.href = parseTemplateTags(value);
			},
		);

		listenToCustomizerValueChange<string[]>(
			controlIdPrefix + "_rel",
			function (settingId, value) {
				const link = document.querySelector(`.wpbf-button.${controlIdPrefix}`);
				if (!(link instanceof HTMLAnchorElement)) return;

				if (Array.isArray(value) && value.length) {
					link.rel = value.join(" ");
				} else {
					link.removeAttribute("rel");
				}
			},
		);

		listenToCustomizerValueChange<string | number>(
			controlIdPrefix + "_size",
			function (settingId, value) {
				const link = document.querySelector(`.wpbf-button.${controlIdPrefix}`);
				if (!(link instanceof HTMLAnchorElement)) return;

				link.classList.remove("wpbf-button-small");
				link.classList.remove("wpbf-button-large");

				if ("small" === value) {
					link.classList.add("wpbf-button-small");
				} else if ("large" === value) {
					link.classList.add("wpbf-button-large");
				}
			},
		);

		// Listen to the header builder's border radius control.
		listenToBuilderResponsiveControl({
			controlId: `${controlIdPrefix}_border_radius`,
			cssSelector: `.wpbf-button.${controlIdPrefix}`,
			cssProps: "border-radius",
			useValueSuffix: true,
		});

		// Listen to the header builder's border width control.
		listenToBuilderResponsiveControl({
			controlId: `${controlIdPrefix}_border_width`,
			cssSelector: `.wpbf-button.${controlIdPrefix}`,
			cssProps: "border-width",
			useValueSuffix: true,
		});

		// Listen to the header builder's border style control.
		listenToCustomizerValueChange<string>(
			`${controlIdPrefix}_border_style`,
			function (settingId, value) {
				writeCSS(settingId, {
					selector: `.wpbf-button.${controlIdPrefix}`,
					props: { "border-style": value },
				});
			},
		);

		// Listen to the header builder's border color control.
		listenToBuilderMulticolorControl({
			controlId: `${controlIdPrefix}_border_color`,
			cssSelector: `.wpbf-button.${controlIdPrefix}`,
			cssProps: "border-color",
		});

		// Listen to the header builder's background color control.
		listenToBuilderMulticolorControl({
			controlId: `${controlIdPrefix}_bg_color`,
			cssSelector: `.wpbf-button.${controlIdPrefix}`,
			cssProps: "background-color",
		});

		// Listen to the header builder's text color control.
		listenToBuilderMulticolorControl({
			controlId: `${controlIdPrefix}_text_color`,
			cssSelector: `.wpbf-button.${controlIdPrefix}`,
			cssProps: "color",
		});
	});

	// Search Icon Color.
	listenToCustomizerValueChange<WpbfMulticolorControlValue>(
		`wpbf_header_builder_mobile_search_icon_color`,
		function (settingId, value) {
			const defaultColor = toStringColor(value?.default ?? ""); // Ensure a fallback
			const hoverColor = toStringColor(value?.hover ?? "");

			writeCSS(settingId, {
				blocks: [
					{
						selector: `.wpbff-search`,
						props: { color: defaultColor },
					},
					{
						selector: `.wpbff-search:hover, .wpbff-search:focus`,
						props: { color: hoverColor },
					},
				],
			});
		},
	);

	// Search Icon Size.
	listenToCustomizerValueChange<string | DevicesValue>(
		"wpbf_header_builder_mobile_search_icon_size",
		function (settingId, value) {
			const obj = parseJsonOrUndefined<DevicesValue>(value);

			writeCSS(settingId + "-tablet", {
				mediaQuery: `@media (${mediaQueries.tablet})`,
				selector: ".wpbff-search",
				props: { "font-size": maybeAppendSuffix(obj?.tablet) },
			});

			writeCSS(settingId + "-mobile", {
				mediaQuery: `@media (${mediaQueries.mobile})`,
				selector: ".wpbff-search",
				props: { "font-size": maybeAppendSuffix(obj?.mobile) },
			});
		},
	);

	/* Mobile Header Builder */

	const mobileHeaderBuilderRows = [
		"mobile_row_1",
		"mobile_row_2",
		"mobile_row_3",
	];

	mobileHeaderBuilderRows.forEach((rowKey) => {
		const controlIdPrefix = `wpbf_header_builder_${rowKey}_`;

		if (rowKey === "mobile_row_1") {
			// vertical padding
			listenToCustomizerValueChange<number | string>(
				`${controlIdPrefix}vertical_padding`,
				function (settingId, value) {
					writeCSS(settingId, {
						selector: ".mobile-header-rows .wpbf-inner-pre-header",
						props: {
							"padding-top": maybeAppendSuffix(value),
							"padding-bottom": maybeAppendSuffix(value),
						},
					});
				},
			);

			// bg color
			listenToCustomizerValueChange<WpbfColorControlValue>(
				`${controlIdPrefix}bg_color`,
				function (settingId, value) {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey}`,
						props: { "background-color": toStringColor(value) },
					});
				},
			);

			// text color / font color
			listenToCustomizerValueChange<WpbfColorControlValue>(
				`${controlIdPrefix}text_color`,
				function (settingId, value) {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey}`,
						props: { color: toStringColor(value) },
					});
				},
			);

			// Accent colors
			listenToCustomizerValueChange<WpbfMulticolorControlValue>(
				`${controlIdPrefix}accent_colors`,
				function (settingId, value) {
					const defaultColor = toStringColor(value?.default ?? ""); // Ensure a fallback
					const hoverColor = toStringColor(value?.hover ?? "");

					writeCSS(settingId, {
						blocks: [
							{
								selector: `.wpbf-header-row-${rowKey} a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2)`,
								props: { color: defaultColor },
							},
							{
								selector: `.wpbf-header-row-${rowKey} a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2):hover, .wpbf-header-row-${rowKey} a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2):focus`,
								props: { color: hoverColor },
							},
						],
					});
				},
			);

			// font size
			listenToCustomizerValueChange<string | number>(
				`${controlIdPrefix}font_size`,
				function (settingId, value) {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey}`,
						props: { "font-size": maybeAppendSuffix(value) },
					});
				},
			);
		}

		if (rowKey === "mobile_row_2") {
			// vertical padding
			listenToCustomizerValueChange<number | string>(
				`${controlIdPrefix}vertical_padding`,
				function (settingId, value) {
					const selector = `.wpbf-header-row-${rowKey}`;
					writeCSS(settingId, {
						selector: selector,
						props: {
							"padding-top": maybeAppendSuffix(value),
							"padding-bottom": maybeAppendSuffix(value),
						},
					});
				},
			);

			// bg color
			listenToCustomizerValueChange<WpbfColorControlValue>(
				`${controlIdPrefix}bg_color`,
				function (settingId, value) {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey}`,
						props: { "background-color": toStringColor(value) },
					});
				},
			);
		}

		if (rowKey === "mobile_row_3") {
			// vertical padding
			listenToCustomizerValueChange<number | string>(
				`${controlIdPrefix}vertical_padding`,
				function (settingId, value) {
					const selector = `.wpbf-header-row-${rowKey}`;
					writeCSS(settingId, {
						selector: selector,
						props: {
							"padding-top": maybeAppendSuffix(value),
							"padding-bottom": maybeAppendSuffix(value),
						},
					});
				},
			);

			// bg color
			listenToCustomizerValueChange<WpbfColorControlValue>(
				`${controlIdPrefix}bg_color`,
				function (settingId, value) {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey}`,
						props: { "background-color": toStringColor(value) },
					});
				},
			);

			// text color / font color
			listenToCustomizerValueChange<WpbfColorControlValue>(
				`${controlIdPrefix}text_color`,
				function (settingId, value) {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey}`,
						props: { color: toStringColor(value) },
					});
				},
			);

			// Accent colors
			listenToCustomizerValueChange<WpbfMulticolorControlValue>(
				`${controlIdPrefix}accent_colors`,
				function (settingId, value) {
					const defaultColor = toStringColor(value?.default ?? ""); // Ensure a fallback
					const hoverColor = toStringColor(value?.hover ?? "");

					writeCSS(settingId, {
						blocks: [
							{
								selector: `.wpbf-header-row-${rowKey} a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2)`,
								props: { color: defaultColor },
							},
							{
								selector: `.wpbf-header-row-${rowKey} a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2):hover, .wpbf-header-row-${rowKey} a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2):focus`,
								props: { color: hoverColor },
							},
						],
					});
				},
			);

			// font size
			listenToCustomizerValueChange<string | number>(
				`${controlIdPrefix}font_size`,
				function (settingId, value) {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey}`,
						props: { "font-size": maybeAppendSuffix(value) },
					});
				},
			);
		}

		// Mobile overlay color.
		listenToCustomizerValueChange<WpbfColorControlValue>(
			"mobile_menu_overlay_color",
			function (settingId, value) {
				writeCSS(settingId, {
					selector: ".wpbf-mobile-menu-overlay",
					props: { "background-color": toStringColor(value) },
				});
			},
		);
	});

	function listenToMenuTriggerValueChange(device: "desktop" | "mobile") {
		/**
		 * The mobile menu trigger button's color already handled in "mobile_menu_hamburger_color" control.
		 * The mobile menu trigger button's icon size already handled in "mobile_menu_hamburger_size" control.
		 */
		if (device === "desktop") {
			// Menu trigger button icon's color.
			listenToCustomizerValueChange<WpbfColorControlValue>(
				"wpbf_header_builder_desktop_menu_trigger_icon_color",
				function (settingId, value) {
					writeCSS(settingId, {
						selector: ".wpbf-menu-toggle",
						props: { color: toStringColor(value) },
					});
				},
			);

			// Menu trigger button icon's size.
			listenToCustomizerValueChange<string | number>(
				"wpbf_header_builder_desktop_menu_trigger_icon_size",
				function (settingId, value) {
					writeCSS(settingId, {
						selector: ".wpbf-menu-toggle",
						props: { "font-size": maybeAppendSuffix(value) },
					});
				},
			);
		}

		listenToCustomizerValueChange<string>(
			"wpbf_header_builder_" + device + "_menu_trigger_icon",
			function (settingId, value) {
				const iconVariant = value ? String(value) : "variant-1";

				if (
					iconVariant !== "none" &&
					iconVariant !== "variant-1" &&
					iconVariant !== "variant-2" &&
					iconVariant !== "variant-3"
				) {
					return;
				}

				const triggerButton = document.querySelector(
					"#wpbf-mobile-menu-toggle",
				);
				if (!triggerButton) return;

				const existingSvg = triggerButton.querySelector(
					".menu-trigger-button-svg",
				);

				const buttonStyleVal = customizer?.(
					"wpbf_header_builder_" + device + "_menu_trigger_style",
				).get();

				const buttonStyle =
					"" === buttonStyleVal ? "simple" : String(buttonStyleVal);

				if (
					buttonStyle !== "simple" &&
					buttonStyle !== "outline" &&
					buttonStyle !== "solid"
				) {
					return;
				}

				triggerButton.classList.remove("simple", "outline", "solid");

				triggerButton.classList.add(buttonStyle);

				if (iconVariant === "none") {
					existingSvg?.remove();
				} else {
					const newSvg =
						window.wpbfMenuTriggerButtonSvg?.[iconVariant] &&
						window.wpbfMenuTriggerButtonSvg[iconVariant]
							? window.wpbfMenuTriggerButtonSvg[iconVariant]
							: null;

					if (newSvg) {
						if (existingSvg) {
							existingSvg.outerHTML = newSvg;
						} else {
							triggerButton.insertAdjacentHTML("afterbegin", newSvg);
						}
					}
				}
			},
		);

		listenToCustomizerValueChange(
			"wpbf_header_builder_" + device + "_menu_trigger_style",
			function (settingId, value) {
				const buttonStyle = value ? String(value) : "simple";

				if (
					buttonStyle !== "simple" &&
					buttonStyle !== "outline" &&
					buttonStyle !== "solid"
				) {
					return;
				}

				const triggerButton = document.querySelector(
					device === "mobile"
						? "#wpbf-mobile-menu-toggle"
						: "#wpbf-menu-toggle",
				);

				if (!triggerButton) return;

				triggerButton.classList.remove("simple", "outline", "solid");
				triggerButton.classList.add(buttonStyle);

				let props: Record<string, string | number | undefined> = {};

				const menuButtonColor: string | undefined = customizer?.(
					device === "mobile"
						? "mobile_menu_hamburger_bg_color"
						: "wpbf_header_builder_" + device + "_menu_trigger_bg_color",
				)?.get();

				const menuBorderColor: string | undefined = customizer?.(
					device === "mobile"
						? "mobile_menu_hamburger_color"
						: "wpbf_header_builder_" + device + "_menu_trigger_icon_color",
				)?.get();

				const menuBorderRadius: string | undefined = customizer?.(
					device === "mobile"
						? "mobile_menu_hamburger_border_radius"
						: "wpbf_header_builder_" + device + "_menu_trigger_border_radius",
				)?.get();

				if (buttonStyle === "solid") {
					props = {
						border: "unset",
					};

					if (menuButtonColor) {
						props["background-color"] = toStringColor(menuButtonColor);
					}

					if (menuBorderRadius) {
						props["border-radius"] = maybeAppendSuffix(menuBorderRadius);
					}
				}

				if (buttonStyle === "outline") {
					props = {
						"background-color": "unset",
					};

					if (menuBorderColor) {
						props["border"] = "2px solid " + toStringColor(menuBorderColor);
					}

					if (menuBorderRadius) {
						props["border-radius"] = maybeAppendSuffix(menuBorderRadius);
					}
				}

				if (buttonStyle === "simple") {
					props = {
						"background-color": "unset",
						border: "unset",
					};
				}

				writeCSS(settingId, {
					selector:
						device === "mobile"
							? "#wpbf-mobile-menu-toggle"
							: "#wpbf-menu-toggle",
					props: props,
				});
			},
		);

		listenToCustomizerValueChange<string>(
			"wpbf_header_builder_" + device + "_menu_trigger_text",
			function (settingId, value) {
				const triggerButton = document.querySelector(
					device === "mobile"
						? "#wpbf-mobile-menu-toggle"
						: "#wpbf-menu-toggle",
				);
				if (!triggerButton) return;

				const existingLabelSpan = triggerButton.querySelector(
					".menu-trigger-button-text",
				);

				if (value.trim() === "") {
					existingLabelSpan?.remove();
				} else {
					if (existingLabelSpan) {
						existingLabelSpan.textContent = value;
					} else {
						const newLabelSpan = document.createElement("span");
						newLabelSpan.classList.add("menu-trigger-button-text");
						newLabelSpan.textContent = value;
						triggerButton.appendChild(newLabelSpan);
					}
				}
			},
		);
	}

	listenToMenuTriggerValueChange("mobile");
	listenToMenuTriggerValueChange("desktop");

	function listenToBuilderMulticolorControl(props: {
		controlId: string;
		cssSelector: string;
		cssProps: string | string[];
	}) {
		customizer?.(
			props.controlId,
			function (value: WpbfCustomizeSetting<Record<string, string>>) {
				const styleTag = getStyleTag(props.controlId);
				const states = ["default", "hover", "active", "focus"];

				value.bind((newValue) => {
					if (!newValue) {
						styleTag.innerHTML = "";
						return;
					}

					let css = "";

					for (const state of states) {
						if (!newValue.hasOwnProperty(state)) continue;
						const stateSelector = state === "default" ? "" : `:${state}`;

						if (state in newValue) {
							const stateValue = newValue[state];
							if (!stateValue) continue;

							css += `
								${props.cssSelector}${stateSelector} {
									${"string" === typeof props.cssProps ? `${props.cssProps}: ${newValue[state]};` : props.cssProps.map((prop) => `${prop}: ${newValue[state]};`).join("\n")}
								}
							`;
						}
					}

					styleTag.innerHTML = css;
				});
			},
		);
	}

	function listenToBuilderResponsiveControl(props: {
		controlId: string;
		cssSelector: string;
		cssProps: string | string[];
		useValueSuffix?: boolean;
	}) {
		customizer?.(
			props.controlId,
			function (setting: WpbfCustomizeSetting<string | DevicesValue>) {
				const styleTag = getStyleTag(props.controlId);

				setting.bind((values) => {
					if ("string" === typeof values) {
						styleTag.innerHTML = "";
						return;
					}

					const validatedValues: DevicesValue = {};

					for (const device in values) {
						if (!values.hasOwnProperty(device)) continue;
						if (values[device] === "") continue;

						const deviceValue = props.useValueSuffix
							? valueHasUnit(values[device])
								? values[device]
								: values[device] + "px"
							: values[device];

						validatedValues[device] = deviceValue;
					}

					writeResponsiveCSS(
						styleTag,
						props.cssSelector,
						props.cssProps,
						validatedValues,
					);
				});
			},
		);
	}
})(jQuery, window.wp.customize);
