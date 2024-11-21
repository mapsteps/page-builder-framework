import { WpbfCustomizeSetting } from "../../../Customizer/Controls/Base/src/base-interface";
import { WpbfCheckboxButtonsetControlValue } from "../../../Customizer/Controls/Checkbox/src/checkbox-interface";
import {
	WpbfColorControlValue,
	WpbfCustomizeMulticolorControlValue,
} from "../../../Customizer/Controls/Color/src/color-interface";
import { parseJsonOrUndefined } from "../../../Customizer/Controls/Generic/src/string-util";
import { MarginPaddingValue } from "../../../Customizer/Controls/MarginPadding/src/margin-padding-interface";
import { DevicesValue } from "../../../Customizer/Controls/Responsive/src/responsive-interface";

(function ($: JQueryStatic, customizer: WpbfCustomize | undefined) {
	if (!customizer) return;

	const breakpoints = window.WpbfTheme.breakpoints;

	const mediaQueries = {
		tablet: "max-width: " + (breakpoints.desktop - 1).toString() + "px",
		mobile: "max-width: " + (breakpoints.tablet - 1).toString() + "px",
	};

	function toNumberValue(value: string | number): number {
		if (typeof value === "number") {
			return value;
		}

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
		if (!customizer) return false;
		return customizer("wpbf_enable_header_builder").get() ? true : false;
	}

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

		const devices = Object.keys(window.WpbfTheme.breakpoints);
		let css = "";

		for (const device of devices) {
			if (!value.hasOwnProperty(device)) continue;
			if (value[device] === "") continue;

			css += `${selector} {
				${"string" === typeof rule ? `${rule}: ${value[device]};` : rule.map((rule) => `${rule}: ${value[device]};`).join("\n")}
			}`;
		}

		styleTag.innerHTML = css;
	}

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
				? `.wpbf-header-row-row_2 .wpbf-row-content`
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
				? `.wpbf-header-row-row_2 .wpbf-row-content`
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
	listenToCustomizerValueChange<WpbfCustomizeMulticolorControlValue>(
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

	// Hamburger border radius (filled).
	listenToCustomizerValueChange<string | number>(
		"mobile_menu_hamburger_border_radius",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-mobile-nav-item",
				props: { "border-radius": maybeAppendSuffix(value) },
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
			const paddingVal = customizer("mobile_menu_padding").get() as
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
	listenToCustomizerValueChange<WpbfCustomizeMulticolorControlValue>(
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
	customizer("breadcrumbs_font_color", function (value) {
		const styleTag = getStyleTag("breadcrumbs_font_color");

		value.bind(function (newValue) {
			styleTag.innerHTML = ".wpbf-breadcrumbs {color: " + newValue + ";}";
		});
	});

	// Accent color.
	customizer("breadcrumbs_accent_color", function (value) {
		const styleTag = getStyleTag("breadcrumbs_accent_color");

		value.bind(function (newValue) {
			styleTag.innerHTML = ".wpbf-breadcrumbs a {color: " + newValue + ";}";
		});
	});

	// Accent color hover.
	customizer("breadcrumbs_accent_color_alt", function (value) {
		const styleTag = getStyleTag("breadcrumbs_accent_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-breadcrumbs a:hover {color: " + newValue + ";}";
		});
	});

	/* Footer */

	// Width.
	customizer("footer_width", function (value) {
		const styleTag = getStyleTag("footer_width");

		value.bind(function (newValue) {
			newValue = !newValue ? "1200px" : newValue;
			styleTag.innerHTML = ".wpbf-inner-footer {max-width: " + newValue + ";}";
		});
	});

	// Height.
	customizer("footer_height", function (value) {
		const styleTag = getStyleTag("footer_height");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-inner-footer {padding-top: " +
				newValue +
				"px; padding-bottom: " +
				newValue +
				"px;}";
		});
	});

	// Background color.
	customizer("footer_bg_color", function (value) {
		const styleTag = getStyleTag("footer_bg_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-page-footer {background-color: " + newValue + ";}";
		});
	});

	// Font color.
	customizer("footer_font_color", function (value) {
		const styleTag = getStyleTag("footer_font_color");

		value.bind(function (newValue) {
			styleTag.innerHTML = ".wpbf-inner-footer {color: " + newValue + ";}";
		});
	});

	// Accent color.
	customizer("footer_accent_color", function (value) {
		const styleTag = getStyleTag("footer_accent_color");

		value.bind(function (newValue) {
			styleTag.innerHTML = ".wpbf-inner-footer a {color: " + newValue + ";}";
		});
	});

	// Accent color hover.
	customizer("footer_accent_color_alt", function (value) {
		const styleTag = getStyleTag("footer_accent_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-inner-footer a:hover, .wpbf-inner-footer .wpbf-menu > .current-menu-item > a {color: " +
				newValue +
				";}";
		});
	});

	// Font size.
	customizer("footer_font_size", function (value) {
		const styleTag = getStyleTag("footer_font_size");

		value.bind(function (newValue) {
			var suffix = $.isNumeric(newValue) ? "px" : "";
			styleTag.innerHTML =
				".wpbf-inner-footer, .wpbf-inner-footer .wpbf-menu {font-size: " +
				newValue +
				suffix +
				";}";
		});
	});

	/* WooCommerce - Defaults */

	// Button border radius.
	customizer("button_border_radius", function (value) {
		const styleTag = getStyleTag("button_border_radius");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".woocommerce a.button, .woocommerce button.button {border-radius: " +
				newValue +
				"px;}";
		});
	});

	// Custom width.
	customizer("woocommerce_loop_custom_width", function (value) {
		const styleTag = getStyleTag("woocommerce_loop_custom_width");

		value.bind(function (newValue) {
			newValue = !newValue ? "1200px" : newValue;
			styleTag.innerHTML =
				".archive.woocommerce #inner-content {max-width: " + newValue + ";}";
		});
	});

	/* WooCommerce - Menu Item */

	// Desktop color.
	customizer("woocommerce_menu_item_desktop_color", function (value) {
		const styleTag = getStyleTag("woocommerce_menu_item_desktop_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				"\
				.wpbf-menu .wpbf-woo-menu-item .wpbf-woo-menu-item-count {background-color: " +
				newValue +
				";}\
			";
		});
	});

	// Mobile color.
	customizer("woocommerce_menu_item_mobile_color", function (value) {
		const styleTag = getStyleTag("woocommerce_menu_item_mobile_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				"\
				.wpbf-mobile-nav-wrapper .wpbf-woo-menu-item .wpbf-woo-menu-item-count {background-color: " +
				newValue +
				";}\
			";
		});
	});

	/* WooCommerce - Loop */

	// Content alignment.
	customizer("woocommerce_loop_content_alignment", function (value) {
		const styleTag = getStyleTag("woocommerce_loop_content_alignment");

		value.bind(function (newValue) {
			if (newValue === "center") {
				styleTag.innerHTML =
					"\
						.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {text-align: " +
					newValue +
					";}\
						.woocommerce .products .star-rating {margin: 0 auto 10px auto;}\
					";
			} else if (newValue === "right") {
				styleTag.innerHTML =
					"\
						.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {text-align: " +
					newValue +
					";}\
						.woocommerce .products .star-rating {display: inline-block; text-align: right;}\
					";
			} else {
				styleTag.innerHTML =
					".woocommerce ul.products li.product, .woocommerce-page ul.products li.product {text-align: " +
					newValue +
					";}";
			}
		});
	});

	// Image alignment.
	customizer("woocommerce_loop_image_alignment", function (value) {
		const styleTag = getStyleTag("woocommerce_loop_image_alignment");

		value.bind(function (newValue) {
			if (newValue == "left") {
				styleTag.innerHTML =
					"\
					.wpbf-woo-list-view .wpbf-woo-loop-thumbnail-wrapper {float: left;}\
					.wpbf-woo-list-view .wpbf-woo-loop-summary {float: right;}\
				";
			} else {
				styleTag.innerHTML =
					"\
					.wpbf-woo-list-view .wpbf-woo-loop-thumbnail-wrapper {float: right;}\
					.wpbf-woo-list-view .wpbf-woo-loop-summary {float: left;}\
				";
			}
		});
	});

	// Image width.
	customizer("woocommerce_loop_image_width", function (value) {
		const styleTag = getStyleTag("woocommerce_loop_image_width");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				"\
				.wpbf-woo-list-view .wpbf-woo-loop-thumbnail-wrapper {width: " +
				(newValue - 2) +
				"%;}\
				.wpbf-woo-list-view .wpbf-woo-loop-summary {width: " +
				(98 - newValue) +
				"%;}\
			";
		});
	});

	// Title font size.
	customizer("woocommerce_loop_title_size", function (value) {
		const styleTag = getStyleTag("woocommerce_loop_title_size");

		value.bind(function (newValue) {
			var suffix = $.isNumeric(newValue) ? "px" : "";

			styleTag.innerHTML =
				"\
				.woocommerce ul.products li.product h3,\
				.woocommerce ul.products li.product .woocommerce-loop-product__title,\
				.woocommerce ul.products li.product .woocommerce-loop-category__title {\
					font-size: " +
				newValue +
				suffix +
				";\
				}\
			";
		});
	});

	// Title font color.
	customizer("woocommerce_loop_title_color", function (value) {
		const styleTag = getStyleTag("woocommerce_loop_title_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				"\
				.woocommerce ul.products li.product h3,\
				.woocommerce ul.products li.product .woocommerce-loop-product__title,\
				.woocommerce ul.products li.product .woocommerce-loop-category__title {\
					color: " +
				newValue +
				";\
				}\
			";
		});
	});

	// Price font size.
	customizer("woocommerce_loop_price_size", function (value) {
		const styleTag = getStyleTag("woocommerce_loop_price_size");

		value.bind(function (newValue) {
			var suffix = $.isNumeric(newValue) ? "px" : "";
			styleTag.innerHTML =
				".woocommerce ul.products li.product .price {font-size: " +
				newValue +
				suffix +
				";}";
		});
	});

	// Price font color.
	customizer("woocommerce_loop_price_color", function (value) {
		const styleTag = getStyleTag("woocommerce_loop_price_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".woocommerce ul.products li.product .price {color: " + newValue + ";}";
		});
	});

	// Out of stock notice.
	customizer("woocommerce_loop_out_of_stock_font_size", function (value) {
		const styleTag = getStyleTag("woocommerce_loop_out_of_stock_font_size");

		value.bind(function (newValue) {
			var suffix = $.isNumeric(newValue) ? "px" : "";
			styleTag.innerHTML =
				".woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock {font-size: " +
				newValue +
				suffix +
				";}";
		});
	});

	// Out of stock color.
	customizer("woocommerce_loop_out_of_stock_font_color", function (value) {
		const styleTag = getStyleTag("woocommerce_loop_out_of_stock_font_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock {color: " +
				newValue +
				";}";
		});
	});

	// Out of stock background color.
	customizer(
		"woocommerce_loop_out_of_stock_background_color",
		function (value) {
			const styleTag = getStyleTag(
				"woocommerce_loop_out_of_stock_background_color",
			);

			value.bind(function (newValue) {
				styleTag.innerHTML =
					".woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock {background-color: " +
					newValue +
					";}";
			});
		},
	);

	// Sale font size.
	customizer("woocommerce_loop_sale_font_size", function (value) {
		const styleTag = getStyleTag("woocommerce_loop_sale_font_size");

		value.bind(function (newValue) {
			var suffix = $.isNumeric(newValue) ? "px" : "";
			styleTag.innerHTML =
				".woocommerce span.onsale {font-size: " + newValue + suffix + ";}";
		});
	});

	// Sale font color.
	customizer("woocommerce_loop_sale_font_color", function (value) {
		const styleTag = getStyleTag("woocommerce_loop_sale_font_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".woocommerce span.onsale {color: " + newValue + ";}";
		});
	});

	// Sale background color.
	customizer("woocommerce_loop_sale_background_color", function (value) {
		const styleTag = getStyleTag("woocommerce_loop_sale_background_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".woocommerce span.onsale {background-color: " + newValue + ";}";
		});
	});

	/* WooCommerce - Single */

	// Custom width.
	customizer("woocommerce_single_custom_width", function (value) {
		const styleTag = getStyleTag("woocommerce_single_custom_width");

		value.bind(function (newValue) {
			newValue = !newValue ? "1200px" : newValue;
			styleTag.innerHTML =
				".single.woocommerce #inner-content {max-width: " + newValue + ";}";
		});
	});

	// Image alignment.
	customizer("woocommerce_single_alignment", function (value) {
		const styleTag = getStyleTag("woocommerce_single_alignment");

		value.bind(function (newValue) {
			if (newValue === "right") {
				styleTag.innerHTML =
					"\
					.woocommerce div.product div.summary,\
					.woocommerce #content div.product div.summary,\
					.woocommerce-page div.product div.summary,\
					.woocommerce-page #content div.product div.summary {float: left;}\
					\
					.woocommerce div.product div.images,\
					.woocommerce #content div.product div.images,\
					.woocommerce-page div.product div.images,\
					.woocommerce-page #content div.product div.images {float: right;}\
					\
					.single-product.woocommerce span.onsale {display: none;}\
				";
			} else {
				styleTag.innerHTML =
					"\
					.woocommerce div.product div.summary,\
					.woocommerce #content div.product div.summary,\
					.woocommerce-page div.product div.summary,\
					.woocommerce-page #content div.product div.summary {float: right;}\
					\
					.woocommerce div.product div.images,\
					.woocommerce #content div.product div.images,\
					.woocommerce-page div.product div.images,\
					.woocommerce-page #content div.product div.images {float: left;}\
					\
					.single-product.woocommerce span.onsale {display: block;}\
				";
			}
		});
	});

	// Image width.
	customizer("woocommerce_single_image_width", function (value) {
		const styleTag = getStyleTag("woocommerce_single_image_width");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				"\
				.woocommerce div.product div.images,\
				.woocommerce #content div.product div.images,\
				.woocommerce-page div.product div.images,\
				.woocommerce-page #content div.product div.images {width: " +
				(newValue - 2) +
				"%;}\
				\
				.woocommerce div.product div.summary,\
				.woocommerce #content div.product div.summary,\
				.woocommerce-page div.product div.summary,\
				.woocommerce-page #content div.product div.summary {width: " +
				(98 - newValue) +
				"%;}\
			";
		});
	});

	// Price font size.
	customizer("woocommerce_single_price_size", function (value) {
		const styleTag = getStyleTag("woocommerce_single_price_size");

		value.bind(function (newValue) {
			var suffix = $.isNumeric(newValue) ? "px" : "";
			styleTag.innerHTML =
				".woocommerce div.product span.price, .woocommerce div.product p.price {font-size: " +
				newValue +
				suffix +
				";}";
		});
	});

	// Price font color.
	customizer("woocommerce_single_price_color", function (value) {
		const styleTag = getStyleTag("woocommerce_single_price_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".woocommerce div.product span.price, .woocommerce div.product p.price {color: " +
				newValue +
				";}";
		});
	});

	// Tabs background color.
	customizer("woocommerce_single_tabs_background_color", function (value) {
		const styleTag = getStyleTag("woocommerce_single_tabs_background_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".woocommerce div.product .woocommerce-tabs ul.tabs li {background-color: " +
				newValue +
				";}";
		});
	});

	// Tabs background color hover.
	customizer("woocommerce_single_tabs_background_color_alt", function (value) {
		const styleTag = getStyleTag(
			"woocommerce_single_tabs_background_color_alt",
		);

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".woocommerce div.product .woocommerce-tabs ul.tabs li:hover {background-color: " +
				newValue +
				"; border-bottom-color: " +
				newValue +
				";}";
		});
	});

	// Tabs background color active.
	customizer(
		"woocommerce_single_tabs_background_color_active",
		function (value) {
			const styleTag = getStyleTag(
				"woocommerce_single_tabs_background_color_active",
			);

			value.bind(function (newValue) {
				styleTag.innerHTML =
					".woocommerce div.product .woocommerce-tabs ul.tabs li.active, .woocommerce div.product .woocommerce-tabs ul.tabs li.active:hover {background-color: " +
					newValue +
					"; border-bottom-color: " +
					newValue +
					";}";
			});
		},
	);

	// Tabs font color.
	customizer("woocommerce_single_tabs_font_color", function (value) {
		const styleTag = getStyleTag("woocommerce_single_tabs_font_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".woocommerce div.product .woocommerce-tabs ul.tabs li:not(.active) a {color: " +
				newValue +
				";}";
		});
	});

	// Tabs font color hover.
	customizer("woocommerce_single_tabs_font_color_alt", function (value) {
		const styleTag = getStyleTag("woocommerce_single_tabs_font_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".woocommerce div.product .woocommerce-tabs ul.tabs li:not(.active) a:hover {color: " +
				newValue +
				";}";
		});
	});

	// Tabs font color active.
	customizer("woocommerce_single_tabs_font_color_active", function (value) {
		const styleTag = getStyleTag("woocommerce_single_tabs_font_color_active");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".woocommerce div.product .woocommerce-tabs ul.tabs li.active a {color: " +
				newValue +
				";}";
		});
	});

	/** Woocommerce Store & Notices */

	// Woocommerce info notice's accent color.
	customizer("woocommerce_info_notice_color", function (value) {
		const styleTag = getStyleTag("woocommerce_info_notice_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				"\
				.woocommerce-info {border-top-color: " +
				newValue +
				";}\
				.woocommerce-info:before, .woocommerce-info a {color: " +
				newValue +
				"}\
			";
		});
	});

	// Woocommerce success notice's accent color.
	customizer("woocommerce_message_notice_color", function (value) {
		const styleTag = getStyleTag("woocommerce_message_notice_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				"\
				.woocommerce-message {border-top-color: " +
				newValue +
				";}\
				.woocommerce-message:before, .woocommerce-message a {color: " +
				newValue +
				"}\
			";
		});
	});

	// Woocommerce error notice's accent color.
	customizer("woocommerce_error_notice_color", function (value) {
		const styleTag = getStyleTag("woocommerce_error_notice_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				"\
				.woocommerce-error {border-top-color: " +
				newValue +
				";}\
				.woocommerce-error:before, .woocommerce-error a {color: " +
				newValue +
				"}\
			";
		});
	});

	// Woocommerce general notice's background color.
	customizer("woocommerce_notice_bg_color", function (value) {
		const styleTag = getStyleTag("woocommerce_notice_bg_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".woocommerce-message {background-color: " + newValue + ";}";
		});
	});

	// Woocommerce general notice's text color.
	customizer("woocommerce_notice_text_color", function (value) {
		const styleTag = getStyleTag("woocommerce_notice_text_color");

		value.bind(function (newValue) {
			styleTag.innerHTML = ".woocommerce-message {color: " + newValue + ";}";
		});
	});

	// Tabs font size.
	customizer("woocommerce_single_tabs_font_size", function (value) {
		const styleTag = getStyleTag("woocommerce_single_tabs_font_size");

		value.bind(function (newValue) {
			const suffix = $.isNumeric(newValue) ? "px" : "";

			styleTag.innerHTML =
				".woocommerce div.product .woocommerce-tabs ul.tabs li a {font-size: " +
				newValue +
				suffix +
				";}";
		});
	});

	/* EDD - Menu Item */

	// Desktop color.
	customizer("edd_menu_item_desktop_color", function (value) {
		const styleTag = getStyleTag("edd_menu_item_desktop_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				"\
				.wpbf-menu .wpbf-edd-menu-item .wpbf-edd-menu-item-count {background-color: " +
				newValue +
				";}\
			";
		});
	});

	// Mobile color.
	customizer("edd_menu_item_mobile_color", function (value) {
		const styleTag = getStyleTag("edd_menu_item_mobile_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				"\
				.wpbf-mobile-nav-wrapper .wpbf-edd-menu-item .wpbf-edd-menu-item-count {background-color: " +
				newValue +
				";}\
			";
		});
	});

	/* Easy Digital Downloads - Defaults */

	// Button border radius.
	customizer("button_border_radius", function (value) {
		const styleTag = getStyleTag("button_border_radius");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".edd-submit.button {border-radius: " + newValue + "px;}";
		});
	});

	/* Header Builder */
	const headerBuilderRows = ["row_1", "row_2", "row_3"];

	headerBuilderRows.forEach((rowKey) => {
		const controlIdPrefix = `wpbf_header_builder_${rowKey}_`;

		const visibilitySettingId = `${controlIdPrefix}visibility`;

		customizer(
			visibilitySettingId,
			(value: WpbfCustomizeSetting<WpbfCheckboxButtonsetControlValue>) => {
				const availableSizes = ["large", "medium", "small"];

				value.bind(function (newValue) {
					if (!newValue || !Array.isArray(newValue)) return;

					const selector =
						rowKey === "row_1"
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
		 * These fields are handled here for row_3 only
		 * because row_3 didn't exist before the new header builder added.
		 *
		 * Max width:
		 * - In row_1, the value is using the existing `pre_header_width` setting.
		 * - In row_2, the value is using the existing `menu_width` setting.
		 *
		 * Vertical padding:
		 * - In row_1, the value is using the existing `pre_header_height` setting.
		 * - In row_2, the value is using the existing `menu_height` setting.
		 *
		 * Font size:
		 * - In row_1, the value is using the existing `pre_header_font_size` setting.
		 * - In row_2, the value is using the existing `menu_font_size` setting.
		 *
		 * Background color:
		 * - In row_1, the value is using the existing `pre_header_bg_color` setting.
		 * - In row_2, the value is using the existing `menu_bg_color` setting.
		 *
		 * Text color:
		 * - In row_1, the value is using the existing `pre_header_font_color` setting.
		 * - In row_2, the value is using the existing `menu_font_colors` (multicolor) setting.
		 *
		 * Accent colors:
		 * - In row_1, the value is using the existing `pre_header_accent_colors` (multicolor) setting.
		 * - In row_2, there's no accent colors setting (we follow the old header section).
		 */
		if (rowKey === "row_3") {
			const maxWidthSettingId = `${controlIdPrefix}max_width`;

			customizer(
				maxWidthSettingId,
				(value: WpbfCustomizeSetting<string | number>) => {
					value.bind(function (newValue) {
						writeCSS(maxWidthSettingId, {
							selector: `.wpbf-header-row-${rowKey} .wpbf-container`,
							props: { "max-width": maybeAppendSuffix(newValue) },
						});
					});
				},
			);

			const vPaddingSettingId = `${controlIdPrefix}vertical_padding`;

			customizer(
				vPaddingSettingId,
				function (value: WpbfCustomizeSetting<string | number>) {
					value.bind(function (newValue) {
						writeCSS(vPaddingSettingId, {
							selector: `.wpbf-header-row-${rowKey} .wpbf-row-content`,
							props: {
								"padding-top": maybeAppendSuffix(newValue),
								"padding-bottom": maybeAppendSuffix(newValue),
							},
						});
					});
				},
			);

			const fontSizeSettingId = `${controlIdPrefix}font_size`;

			customizer(
				fontSizeSettingId,
				(value: WpbfCustomizeSetting<string | number>) => {
					value.bind(function (newValue) {
						writeCSS(fontSizeSettingId, {
							selector: `.wpbf-header-row-${rowKey}`,
							props: { "font-size": maybeAppendSuffix(newValue) },
						});
					});
				},
			);

			const bgColorSettinglId = `${controlIdPrefix}bg_color`;

			customizer(bgColorSettinglId, function (value) {
				value.bind(function (newValue) {
					writeCSS(bgColorSettinglId, {
						selector: `.wpbf-header-row-${rowKey}`,
						props: { "background-color": newValue },
					});
				});
			});
		}

		const textColorSettingId = `${controlIdPrefix}text_color`;

		customizer(textColorSettingId, function (value) {
			value.bind(function (newValue) {
				writeCSS(textColorSettingId, {
					selector: `.wpbf-header-row-${rowKey}`,
					props: { color: newValue },
				});
			});
		});

		const accentColorsSettingId = `${controlIdPrefix}accent_colors`;

		customizer(
			accentColorsSettingId,
			(value: WpbfCustomizeSetting<WpbfCustomizeMulticolorControlValue>) => {
				value.bind(function (newValue) {
					const rawDefaultColor = newValue.default ?? "";
					const defaultColor = toStringColor(rawDefaultColor);

					const rawHoverColor = newValue.hover ?? "";
					const hoverColor = toStringColor(rawHoverColor);

					writeCSS(accentColorsSettingId, {
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
				});
			},
		);
	});

	const headerBuilderButtonKeys = ["button_1", "button_2"];

	headerBuilderButtonKeys.forEach((buttonKey) => {
		const controlIdPrefix = `wpbf_header_builder_${buttonKey}`;

		customizer(
			controlIdPrefix + "_new_tab",
			function (value: WpbfCustomizeSetting<boolean>) {
				value.bind((newValue) => {
					const link = document.querySelector(
						`.wpbf-button.${controlIdPrefix}`,
					);
					if (!(link instanceof HTMLAnchorElement)) return;

					if (newValue) {
						link.target = "_blank";
					} else {
						link.removeAttribute("target");
					}
				});
			},
		);

		customizer(
			controlIdPrefix + "_text",
			function (value: WpbfCustomizeSetting<string>) {
				value.bind((newValue) => {
					const link = document.querySelector(
						`.wpbf-button.${controlIdPrefix}`,
					);
					if (!(link instanceof HTMLAnchorElement)) return;
					link.innerHTML = parseTemplateTags(newValue);
				});
			},
		);

		customizer(
			controlIdPrefix + "_url",
			function (value: WpbfCustomizeSetting<string>) {
				value.bind((newValue) => {
					const link = document.querySelector(
						`.wpbf-button.${controlIdPrefix}`,
					);
					if (!(link instanceof HTMLAnchorElement)) return;
					link.href = parseTemplateTags(newValue);
				});
			},
		);

		customizer(
			controlIdPrefix + "_rel",
			function (value: WpbfCustomizeSetting<string[]>) {
				value.bind((newValue) => {
					const link = document.querySelector(
						`.wpbf-button.${controlIdPrefix}`,
					);
					if (!(link instanceof HTMLAnchorElement)) return;

					if (Array.isArray(newValue) && newValue.length) {
						link.rel = newValue.join(" ");
					} else {
						link.removeAttribute("rel");
					}
				});
			},
		);

		customizer(
			controlIdPrefix + "_size",
			function (value: WpbfCustomizeSetting<string>) {
				value.bind((newValue) => {
					const link = document.querySelector(
						`.wpbf-button.${controlIdPrefix}`,
					);
					if (!(link instanceof HTMLAnchorElement)) return;

					link.classList.remove("wpbf-button-small");
					link.classList.remove("wpbf-button-large");

					if ("small" === newValue) {
						link.classList.add("wpbf-button-small");
					} else if ("large" === newValue) {
						link.classList.add("wpbf-button-large");
					}
				});
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
		customizer(
			`${controlIdPrefix}_border_style`,
			function (value: WpbfCustomizeSetting<string>) {
				const styleTag = getStyleTag(controlIdPrefix);

				value.bind(function (newValue) {
					styleTag.innerHTML = `.wpbf-button.${controlIdPrefix} {
						border-style: ${newValue};
					}`;
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

	function listenToBuilderMulticolorControl(props: {
		controlId: string;
		cssSelector: string;
		cssProps: string | string[];
	}) {
		if (!customizer) return;

		customizer(
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
		if (!customizer) return;

		customizer(
			props.controlId,
			function (values: WpbfCustomizeSetting<string | DevicesValue>) {
				const styleTag = getStyleTag(props.controlId);

				values.bind((newValues) => {
					if ("string" === typeof newValues) {
						styleTag.innerHTML = "";
						return;
					}

					const validatedValues: DevicesValue = {};

					for (const device in newValues) {
						if (!newValues.hasOwnProperty(device)) continue;
						if (newValues[device] === "") continue;

						const deviceValue = props.useValueSuffix
							? valueHasUnit(newValues[device])
								? newValues[device]
								: newValues[device] + "px"
							: newValues[device];

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
