import { WpbfCustomizeSetting } from "../../../Customizer/Controls/Base/src/base-interface";
import { WpbfCheckboxButtonsetControlValue } from "../../../Customizer/Controls/Checkbox/src/checkbox-interface";
import {
	WpbfCustomizeColorControlValue,
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
		value: string | number | undefined,
		suffix?: string,
	) {
		if (value === undefined) return undefined;
		if (value === "") return "";
		suffix = suffix || "px";

		return valueHasUnit(value) ? value : value + suffix;
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

	function toStringColor(color: WpbfCustomizeColorControlValue) {
		if (typeof color === "string") return color;
		if (typeof color === "number") return "";
		if (!("r" in color)) return "";

		const alpha = "a" in color ? color.a : 1;

		return alpha && alpha < 1
			? `rgba(${color.r}, ${color.g}, ${color.b}, ${alpha})`
			: `rgb(${color.r}, ${color.g}, ${color.b})`;
	}

	/* Layout */

	// Page width.
	customizer("page_max_width", function (value) {
		const styleTag = getStyleTag("page_max_width");

		value.bind(function (newValue) {
			newValue = !newValue ? "1200px" : newValue;
			styleTag.innerHTML =
				".wpbf-container, .wpbf-boxed-layout .wpbf-page {max-width: " +
				newValue +
				";}";
		});
	});

	// Padding.
	customizer("page_padding", function (value) {
		const styleTag = getStyleTag("page_padding");

		value.bind(function (newValue) {
			const obj = JSON.parse(newValue);

			const desktop_top = obj.desktop_top;
			const desktop_right = obj.desktop_right;
			const desktop_bottom = obj.desktop_bottom;
			const desktop_left = obj.desktop_left;
			const tablet_top = obj.tablet_top;
			const tablet_right = obj.tablet_right;
			const tablet_bottom = obj.tablet_bottom;
			const tablet_left = obj.tablet_left;
			const mobile_top = obj.mobile_top;
			const mobile_right = obj.mobile_right;
			const mobile_bottom = obj.mobile_bottom;
			const mobile_left = obj.mobile_left;

			styleTag.innerHTML =
				"\
				#inner-content {\
					padding-top: " +
				desktop_top +
				"px;\
					padding-right: " +
				desktop_right +
				"px;\
					padding-bottom: " +
				desktop_bottom +
				"px;\
					padding-left: " +
				desktop_left +
				"px;\
				}\
				@media (" +
				mediaQueries.tablet +
				") {\
					#inner-content {\
						padding-top: " +
				tablet_top +
				"px;\
						padding-right: " +
				tablet_right +
				"px;\
						padding-bottom: " +
				tablet_bottom +
				"px;\
						padding-left: " +
				tablet_left +
				"px;\
					}\
				}\
				@media (" +
				mediaQueries.mobile +
				") {\
					#inner-content {\
						padding-top: " +
				mobile_top +
				"px;\
						padding-right: " +
				mobile_right +
				"px;\
						padding-bottom: " +
				mobile_bottom +
				"px;\
						padding-left: " +
				mobile_left +
				"px;\
					}\
				}\
			";
		});
	});

	// Boxed margin.
	customizer("page_boxed_margin", function (value) {
		value.bind(function (newValue) {
			$(".wpbf-page")
				.css("margin-top", newValue + "px")
				.css("margin-bottom", newValue + "px");
		});
	});

	// Boxed padding.
	customizer("page_boxed_padding", function (value) {
		const styleTag = getStyleTag("page_boxed_padding");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-container {padding-left: " +
				newValue +
				"px; padding-right: " +
				newValue +
				"px;}";
		});
	});

	// Boxed background color.
	customizer("page_boxed_background", function (value) {
		const styleTag = getStyleTag("page_boxed_background");

		value.bind(function (newValue) {
			styleTag.innerHTML = ".wpbf-page {background-color: " + newValue + ";}";
		});
	});

	// ScrollTop position.
	customizer("scrolltop_position", function (value) {
		const styleTag = getStyleTag("scrolltop_position");

		value.bind(function (newValue) {
			if (newValue === "left") {
				styleTag.innerHTML = ".scrolltop {left: 20px; right: auto;}";
			} else {
				styleTag.innerHTML = ".scrolltop {left: auto; right: 20px;}";
			}
		});
	});

	// ScrollTop background color.
	customizer("scrolltop_bg_color", function (value) {
		const styleTag = getStyleTag("scrolltop_bg_color");

		value.bind(function (newValue) {
			styleTag.innerHTML = ".scrolltop {background-color: " + newValue + ";}";
		});
	});

	// ScrollTop background color.
	customizer("scrolltop_bg_color_alt", function (value) {
		const styleTag = getStyleTag("scrolltop_bg_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".scrolltop:hover {background-color: " + newValue + ";}";
		});
	});

	// ScrollTop icon color.
	customizer("scrolltop_icon_color", function (value) {
		const styleTag = getStyleTag("scrolltop_icon_color");

		value.bind(function (newValue) {
			styleTag.innerHTML = ".scrolltop {color: " + newValue + ";}";
		});
	});

	// ScrollTop icon color.
	customizer("scrolltop_icon_color_alt", function (value) {
		const styleTag = getStyleTag("scrolltop_icon_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML = ".scrolltop:hover {color: " + newValue + ";}";
		});
	});

	// ScrollTop border radius.
	customizer("scrolltop_border_radius", function (value) {
		const styleTag = getStyleTag("scrolltop_border_radius");

		value.bind(function (newValue) {
			styleTag.innerHTML = ".scrolltop {border-radius: " + newValue + "px;}";
		});
	});

	/* Typography */

	customizer("page_font_color", function (value) {
		const styleTag = getStyleTag("page_font_color");

		value.bind(function (newValue) {
			styleTag.innerHTML = "body {color: " + newValue + ";}";
		});
	});

	/* 404 */

	customizer("404_headline", function (value) {
		value.bind(function (newValue) {
			$(".wpbf-404-content .entry-title").text(newValue);
		});
	});

	customizer("404_text", function (value) {
		value.bind(function (newValue) {
			$(".wpbf-404-content p").text(newValue);
		});
	});

	/* Navigation */

	const headerWidthSettingId = "menu_width";

	// Width.
	customizer(
		headerWidthSettingId,
		function (setting: WpbfCustomizeSetting<number | string>) {
			setting.bind(function (value) {
				const selector = headerBuilderEnabled()
					? `.wpbf-header-row-row_2 .wpbf-row-content`
					: `.wpbf-nav-wrapper`;

				writeCSS(headerWidthSettingId, {
					selector: selector,
					props: { "max-width": maybeAppendSuffix(value) },
				});
			});
		},
	);

	const headerHeightSettingId = "menu_height";

	// Menu height.
	customizer(
		headerHeightSettingId,
		function (setting: WpbfCustomizeSetting<number | string>) {
			setting.bind(function (value) {
				const selector = headerBuilderEnabled()
					? `.wpbf-header-row-row_2 .wpbf-row-content`
					: `.wpbf-nav-wrapper`;

				writeCSS(headerHeightSettingId, {
					selector: selector,
					props: {
						"padding-top": maybeAppendSuffix(value),
						"padding-bottom": maybeAppendSuffix(value),
					},
				});
			});
		},
	);

	const menuPaddingSettingId = "menu_padding";

	// Menu padding.
	customizer(
		menuPaddingSettingId,
		function (setting: WpbfCustomizeSetting<string | number>) {
			setting.bind(function (value) {
				writeCSS(menuPaddingSettingId, {
					selector: ".wpbf-navigation .wpbf-menu > .menu-item > a",
					props: {
						"padding-left": maybeAppendSuffix(value),
						"padding-right": maybeAppendSuffix(value),
					},
				});
			});
		},
	);

	const menuBgColorSettingId = "menu_bg_color";

	// Background color.
	customizer(
		menuBgColorSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(menuBgColorSettingId, {
					selector:
						".wpbf-navigation:not(.wpbf-navigation-transparent):not(.wpbf-navigation-active)",
					props: { "background-color": toStringColor(value) },
				});
			});
		},
	);

	const menuFontColorsSettingId = "menu_font_colors";

	// Menu font colors.
	customizer(
		menuFontColorsSettingId,
		(value: WpbfCustomizeSetting<WpbfCustomizeMulticolorControlValue>) => {
			value.bind(function (newValue) {
				const rawDefaultColor = newValue.default ?? "";
				const defaultColor = toStringColor(rawDefaultColor);

				const rawHoverColor = newValue.hover ?? "";
				const hoverColor = toStringColor(rawHoverColor);

				writeCSS(menuFontColorsSettingId, {
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
			});
		},
	);

	const menuFontSizeSettingId = "menu_font_size";

	// Font size.
	customizer(
		menuFontSizeSettingId,
		function (setting: WpbfCustomizeSetting<string | number>) {
			setting.bind(function (value) {
				writeCSS(menuFontSizeSettingId, {
					selector: ".wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a",
					props: {
						fontSize: maybeAppendSuffix(value),
					},
				});
			});
		},
	);

	/* Sub Menu */

	const subMenuTextAlignmentSettingId = "sub_menu_text_alignment";

	// Text alignment.
	customizer(
		subMenuTextAlignmentSettingId,
		function (setting: WpbfCustomizeSetting<string>) {
			setting.bind(function (value) {
				writeCSS(subMenuTextAlignmentSettingId, {
					selector: ".wpbf-sub-menu .sub-menu",
					props: { "text-align": value },
				});
			});
		},
	);

	const subMenuPaddingSettingId = "sub_menu_padding";

	// Padding.
	customizer(
		subMenuPaddingSettingId,
		function (setting: WpbfCustomizeSetting<MarginPaddingValue | string>) {
			setting.bind(function (value) {
				const obj =
					typeof value === "string"
						? parseJsonOrUndefined<Record<string, number | string>>(value)
						: value;

				writeCSS(subMenuPaddingSettingId, {
					selector:
						".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu a",
					props: {
						"padding-top": maybeAppendSuffix(obj?.top),
						"padding-right": maybeAppendSuffix(obj?.right),
						"padding-bottom": maybeAppendSuffix(obj?.bottom),
						"padding-left": maybeAppendSuffix(obj?.left),
					},
				});
			});
		},
	);

	const subMenuWidth = "sub_menu_width";

	// Width.
	customizer(
		subMenuWidth,
		function (setting: WpbfCustomizeSetting<string | number>) {
			setting.bind(function (value) {
				writeCSS(subMenuWidth, {
					selector:
						".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu",
					props: { width: maybeAppendSuffix(value) },
				});
			});
		},
	);

	const subMenuBgColor = "sub_menu_bg_color";

	// Background color.
	customizer(
		subMenuBgColor,
		function (setting: WpbfCustomizeSetting<string | number>) {
			setting.bind(function (value) {
				writeCSS(subMenuBgColor, {
					selector:
						".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li",
					props: { "background-color": value },
				});
			});
		},
	);

	const subMenuBgColorAltSettingId = "sub_menu_bg_color_alt";

	// Background color hover.
	customizer(
		subMenuBgColorAltSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(subMenuBgColorAltSettingId, {
					selector:
						".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li:hover",
					props: { "background-color": toStringColor(value) },
				});
			});
		},
	);

	const subMenuAccentColorSettingId = "sub_menu_accent_color";

	// Accent color.
	customizer(
		subMenuAccentColorSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(subMenuAccentColorSettingId, {
					selector: ".wpbf-menu .sub-menu a",
					props: { color: toStringColor(value) },
				});
			});
		},
	);

	const subMenuAccentColorAltSettingId = "sub_menu_accent_color_alt";

	// Accent color hover.
	customizer(
		subMenuAccentColorAltSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(subMenuAccentColorAltSettingId, {
					selector: ".wpbf-navigation .wpbf-menu .sub-menu a:hover",
					props: { color: toStringColor(value) },
				});
			});
		},
	);

	const subMenuFontSizeSettingId = "sub_menu_font_size";

	// Font size.
	customizer(
		subMenuFontSizeSettingId,
		function (setting: WpbfCustomizeSetting<string | number>) {
			setting.bind(function (value) {
				writeCSS(subMenuFontSizeSettingId, {
					selector: ".wpbf-menu .sub-menu a",
					props: { "font-size": maybeAppendSuffix(value) },
				});
			});
		},
	);

	const subMenuSeparatorColorSettingId = "sub_menu_separator_color";

	// Separator color.
	customizer(
		subMenuSeparatorColorSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(subMenuSeparatorColorSettingId, {
					selector:
						".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) li",
					props: { "border-bottom-color": toStringColor(value) },
				});
			});
		},
	);

	/* Mobile Navigation */

	const mobileMenuHeight = "mobile_menu_height";

	// Height.
	customizer(
		mobileMenuHeight,
		function (setting: WpbfCustomizeSetting<string | number>) {
			setting.bind(function (value) {
				writeCSS(mobileMenuHeight, {
					selector: ".wpbf-mobile-nav-wrapper",
					props: {
						"padding-top": maybeAppendSuffix(value),
						"padding-bottom": maybeAppendSuffix(value),
					},
				});
			});
		},
	);

	const mobileMenuBgColorSettingId = "mobile_menu_background_color";

	// Background color.
	customizer(
		mobileMenuBgColorSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(mobileMenuBgColorSettingId, {
					selector: ".wpbf-mobile-nav-wrapper",
					props: { "background-color": toStringColor(value) },
				});
			});
		},
	);

	const mobileMenuHamburgerColorSettingId = "mobile_menu_hamburger_color";

	// Icon color.
	customizer(
		mobileMenuHamburgerColorSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(mobileMenuHamburgerColorSettingId, {
					selector: ".wpbf-mobile-nav-item, .wpbf-mobile-nav-item a",
					props: { color: toStringColor(value) },
				});
			});
		},
	);

	const mobileMenuHamburgerSize = "mobile_menu_hamburger_size";

	// Hamburger size.
	customizer(mobileMenuHamburgerSize, function (setting) {
		setting.bind(function (value) {
			writeCSS(mobileMenuHamburgerSize, {
				selector: ".wpbf-mobile-nav-item",
				props: { "font-size": maybeAppendSuffix(value) },
			});
		});
	});

	const mobileMenuHamburgerBorderRadius = "mobile_menu_hamburger_border_radius";

	// Hamburger border radius (filled).
	customizer(
		mobileMenuHamburgerBorderRadius,
		function (setting: WpbfCustomizeSetting<string | number>) {
			setting.bind(function (value) {
				writeCSS(mobileMenuHamburgerBorderRadius, {
					selector: ".wpbf-mobile-nav-item",
					props: { "border-radius": maybeAppendSuffix(value) },
				});
			});
		},
	);

	const mobileMenuPadding = "mobile_menu_padding";

	// Padding.
	customizer(
		mobileMenuPadding,
		function (setting: WpbfCustomizeSetting<MarginPaddingValue | string>) {
			setting.bind(function (value) {
				const obj =
					typeof value === "string"
						? parseJsonOrUndefined<Record<string, string | number>>(value)
						: value;

				writeCSS(mobileMenuPadding, {
					selector:
						".wpbf-mobile-menu a, .wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle",
					props: {
						"padding-top": maybeAppendSuffix(obj?.top),
						"padding-right": maybeAppendSuffix(obj?.right),
						"padding-bottom": maybeAppendSuffix(obj?.bottom),
						"padding-left": maybeAppendSuffix(obj?.left),
					},
				});
			});
		},
	);

	const mobileMenuItemBgColorSettingId = "mobile_menu_bg_color";

	// Menu item background color.
	customizer(
		mobileMenuItemBgColorSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(mobileMenuItemBgColorSettingId, {
					selector: ".wpbf-mobile-menu > .menu-item a",
					props: { "background-color": toStringColor(value) },
				});
			});
		},
	);

	const mobileMenuItemBgColorAltSettingId = "mobile_menu_bg_color_alt";

	// Menu item background color hover.
	customizer(
		mobileMenuItemBgColorAltSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(mobileMenuItemBgColorAltSettingId, {
					selector: ".wpbf-mobile-menu > .menu-item a:hover",
					props: { "background-color": toStringColor(value) },
				});
			});
		},
	);

	const mobileMenuItemFontColorSettingId = "mobile_menu_font_color";

	// Menu item font color.
	customizer(
		mobileMenuItemFontColorSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(mobileMenuItemFontColorSettingId, {
					selector:
						".wpbf-mobile-menu a, .wpbf-mobile-menu-container .wpbf-close",
					props: { color: toStringColor(value) },
				});
			});
		},
	);

	const mobileMenuItemFontColorAltSettingId = "mobile_menu_font_color_alt";

	// Menu item font color hover.
	customizer(
		mobileMenuItemFontColorAltSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(mobileMenuItemFontColorAltSettingId, {
					selector:
						".wpbf-mobile-menu a:hover, .wpbf-mobile-menu > .current-menu-item > a",
					props: { color: toStringColor(value) + "!important" },
				});
			});
		},
	);

	const mobileMenuItemBorderColor = "mobile_menu_border_color";

	// Menu item divider color.
	customizer(
		mobileMenuItemBorderColor,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(mobileMenuItemBorderColor, {
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
			});
		},
	);

	const mobileSubMenuArrowColorSettingId = "mobile_menu_submenu_arrow_color";

	// Sub menu arrow color.
	customizer(
		mobileSubMenuArrowColorSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(mobileSubMenuArrowColorSettingId, {
					selector: ".wpbf-submenu-toggle",
					props: { color: toStringColor(value) },
				});
			});
		},
	);

	const mobileMenuItemFontSize = "mobile_menu_font_size";

	// Menu item font size.
	customizer(mobileMenuItemFontSize, function (setting) {
		setting.bind(function (value) {
			writeCSS(mobileMenuItemFontSize, {
				selector:
					".wpbf-mobile-menu a, .wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle",
				props: { "font-size": maybeAppendSuffix(value) },
			});
		});
	});

	/* Mobile sub menu */

	const mobileSubMenuAutoCollapseSettingId = "mobile_sub_menu_auto_collapse";

	// Submenu auto collapse.
	customizer(
		mobileSubMenuAutoCollapseSettingId,
		function (setting: WpbfCustomizeSetting<boolean>) {
			setting.bind(function (value) {
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
			});
		},
	);

	const mobileSubMenuIndentSettingId = "mobile_sub_menu_indent";

	// Indent.
	customizer(
		mobileSubMenuIndentSettingId,
		function (setting: WpbfCustomizeSetting<string | number>) {
			setting.bind(function (value) {
				const paddingVal = customizer("mobile_menu_padding").get() as
					| string
					| MarginPaddingValue;

				const padding =
					typeof paddingVal === "string"
						? parseJsonOrUndefined<Record<string, string | number>>(paddingVal)
						: paddingVal;

				let paddingLeft = String(padding?.left ?? 0);

				const calculation =
					parseInt(String(value), 10) + parseInt(paddingLeft, 10);

				writeCSS(mobileSubMenuIndentSettingId, {
					selector: ".wpbf-mobile-menu .sub-menu a",
					props: { "padding-left": maybeAppendSuffix(calculation) },
				});
			});
		},
	);

	const mobileSubMenuItemBgColorSettingId = "mobile_sub_menu_bg_color";

	// Mobile sub-menu item background color.
	customizer(
		mobileSubMenuItemBgColorSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(mobileSubMenuItemBgColorSettingId, {
					selector: ".wpbf-mobile-menu .sub-menu a",
					props: { "background-color": toStringColor(value) },
				});
			});
		},
	);

	const mobileSubMenuItemBgColorAlt = "mobile_sub_menu_bg_color_alt";

	// Mobile sub-menu item background color hover.
	customizer(
		mobileSubMenuItemBgColorAlt,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(mobileSubMenuItemBgColorAlt, {
					selector: ".wpbf-mobile-menu .sub-menu a:hover",
					props: { "background-color": toStringColor(value) },
				});
			});
		},
	);

	const mobileSubMenuItemFontColor = "mobile_sub_menu_font_color";

	// Mobile sub-menu item font color.
	customizer(
		mobileSubMenuItemFontColor,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(mobileSubMenuItemFontColor, {
					selector: ".wpbf-mobile-menu .sub-menu a",
					props: { color: toStringColor(value) },
				});
			});
		},
	);

	const mobileSubMenuItemFontColorAlt = "mobile_sub_menu_font_color_alt";

	// Menu item font color hover.
	customizer(mobileSubMenuItemFontColorAlt, function (setting) {
		setting.bind(function (value) {
			writeCSS(mobileSubMenuItemFontColorAlt, {
				selector:
					".wpbf-mobile-menu .sub-menu a:hover, .wpbf-mobile-menu .sub-menu > .current-menu-item > a",
				props: { color: toStringColor(value) + "!important" },
			});
		});
	});

	const mobileSubMenuItemBorderColor = "mobile_sub_menu_border_color";

	// Mobile sub-menu item divider color.
	customizer(
		mobileSubMenuItemBorderColor,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(mobileSubMenuItemBorderColor, {
					selector: ".wpbf-mobile-menu .sub-menu .menu-item",
					props: { "border-top-color": toStringColor(value) },
				});
			});
		},
	);

	const mobileSubMenuItemArrowColorSettingId = "mobile_sub_menu_arrow_color";

	// Mobile sub-menu item arrow color.
	customizer(
		mobileSubMenuItemArrowColorSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(mobileSubMenuItemArrowColorSettingId, {
					selector: ".wpbf-mobile-menu .sub-menu .wpbf-submenu-toggle",
					props: { color: toStringColor(value) },
				});
			});
		},
	);

	const mobileSubMenuItemFontSize = "mobile_sub_menu_font_size";

	// Mobile sub-menu item font size.
	customizer(
		mobileSubMenuItemFontSize,
		function (setting: WpbfCustomizeSetting<string | number>) {
			setting.bind(function (value) {
				writeCSS(mobileSubMenuItemFontSize, {
					selector:
						".wpbf-mobile-menu .sub-menu a, .wpbf-mobile-menu .sub-menu .menu-item-has-children .wpbf-submenu-toggle",
					props: { "font-size": maybeAppendSuffix(value) },
				});
			});
		},
	);

	/* Logo */

	const menuLogoSizeSettingId = "menu_logo_size";

	// Width.
	customizer(
		menuLogoSizeSettingId,
		function (setting: WpbfCustomizeSetting<string | DevicesValue>) {
			setting.bind(function (value) {
				const obj =
					typeof value === "string"
						? parseJsonOrUndefined<DevicesValue>(value)
						: value;

				writeCSS(menuLogoSizeSettingId + "-desktop", {
					selector: ".wpbf-logo img, .wpbf-mobile-logo img",
					props: {
						width: maybeAppendSuffix(obj?.desktop),
					},
				});

				writeCSS(menuLogoSizeSettingId + "-tablet", {
					mediaQuery: `@media (${mediaQueries.tablet})`,
					selector: ".wpbf-mobile-logo img",
					props: { width: maybeAppendSuffix(obj?.tablet) },
				});

				writeCSS(menuLogoSizeSettingId + "-mobile", {
					mediaQuery: `@media (${mediaQueries.mobile})`,
					selector: ".wpbf-mobile-logo img",
					props: { width: maybeAppendSuffix(obj?.mobile) },
				});
			});
		},
	);

	const menuLogoFontSizeSettingId = "menu_logo_font_size";

	// Font size.
	customizer(
		menuLogoFontSizeSettingId,
		function (setting: WpbfCustomizeSetting<string | DevicesValue>) {
			setting.bind(function (value) {
				const obj =
					typeof value === "string"
						? parseJsonOrUndefined<DevicesValue>(value)
						: value;

				writeCSS(menuLogoFontSizeSettingId + "-desktop", {
					selector: ".wpbf-logo a, .wpbf-mobile-logo a",
					props: {
						"font-size": maybeAppendSuffix(obj?.desktop),
					},
				});

				writeCSS(menuLogoFontSizeSettingId + "-tablet", {
					mediaQuery: `@media (${mediaQueries.tablet})`,
					selector: ".wpbf-mobile-logo a",
					props: { "font-size": maybeAppendSuffix(obj?.tablet) },
				});

				writeCSS(menuLogoFontSizeSettingId + "-mobile", {
					mediaQuery: `@media (${mediaQueries.mobile})`,
					selector: ".wpbf-mobile-logo a",
					props: { "font-size": maybeAppendSuffix(obj?.mobile) },
				});
			});
		},
	);

	const menuLogoColor = "menu_logo_color";

	// Color.
	customizer(
		menuLogoColor,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(menuLogoColor, {
					selector: ".wpbf-logo a, .wpbf-mobile-logo a",
					props: { color: toStringColor(value) },
				});
			});
		},
	);

	const menuLogoColorAlt = "menu_logo_color_alt";

	// Color hover.
	customizer(
		menuLogoColorAlt,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(menuLogoColorAlt, {
					selector: ".wpbf-logo a:hover, .wpbf-mobile-logo a:hover",
					props: { color: toStringColor(value) },
				});
			});
		},
	);

	const menuLogoContainerWidth = "menu_logo_container_width";

	// Container width.
	customizer(
		menuLogoContainerWidth,
		function (setting: WpbfCustomizeSetting<number | string>) {
			setting.bind(function (value) {
				const calculation = 100 - toNumberValue(value);

				writeCSS(menuLogoContainerWidth, {
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
			});
		},
	);

	const mobileMenuLogoContainerWidthSettingId =
		"mobile_menu_logo_container_width";

	// Mobile container width.
	customizer(
		mobileMenuLogoContainerWidthSettingId,
		function (setting: WpbfCustomizeSetting<number | string>) {
			setting.bind(function (value) {
				const calculation = 100 - toNumberValue(value);

				writeCSS(mobileMenuLogoContainerWidthSettingId, {
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
			});
		},
	);

	/* Tagline */

	const menuLogoDescriptionFontSizeSettingId =
		"menu_logo_description_font_size";

	// Font size.
	customizer(
		menuLogoDescriptionFontSizeSettingId,
		function (setting: WpbfCustomizeSetting<string | DevicesValue>) {
			setting.bind(function (value) {
				const obj =
					typeof value === "string"
						? parseJsonOrUndefined<DevicesValue>(value)
						: value;

				writeCSS(menuLogoDescriptionFontSizeSettingId + "-desktop", {
					selector: ".wpbf-logo .wpbf-tagline, .wpbf-mobile-logo .wpbf-tagline",
					props: {
						"font-size": maybeAppendSuffix(obj?.desktop),
					},
				});

				writeCSS(menuLogoDescriptionFontSizeSettingId + "-tablet", {
					mediaQuery: `@media (${mediaQueries.tablet})`,
					selector: ".wpbf-mobile-logo .wpbf-tagline",
					props: { "font-size": maybeAppendSuffix(obj?.tablet) },
				});

				writeCSS(menuLogoDescriptionFontSizeSettingId + "-mobile", {
					mediaQuery: `@media (${mediaQueries.mobile})`,
					selector: ".wpbf-mobile-logo .wpbf-tagline",
					props: { "font-size": maybeAppendSuffix(obj?.mobile) },
				});
			});
		},
	);

	const menuLogoDescriptionColorSettingId = "menu_logo_description_color";

	// Font color.
	customizer(
		menuLogoDescriptionColorSettingId,
		function (value: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			value.bind(function (newValue) {
				writeCSS(menuLogoDescriptionColorSettingId, {
					selector: ".wpbf-tagline",
					props: { color: toStringColor(newValue) },
				});
			});
		},
	);

	/* Pre Header */

	const preHeaderWidthSettingId = "pre_header_width";

	// Width.
	customizer(
		preHeaderWidthSettingId,
		function (setting: WpbfCustomizeSetting<number | string>) {
			setting.bind(function (value) {
				value = emptyNotZero(value) ? "1200px" : value;

				writeCSS(preHeaderWidthSettingId, {
					selector: ".wpbf-inner-pre-header",
					props: { "max-width": maybeAppendSuffix(value) },
				});
			});
		},
	);

	const preHeaderHeightSettingId = "pre_header_height";

	// Height.
	customizer(
		preHeaderHeightSettingId,
		function (setting: WpbfCustomizeSetting<number | string>) {
			setting.bind(function (value) {
				writeCSS(preHeaderHeightSettingId, {
					selector: ".wpbf-inner-pre-header",
					props: {
						"padding-top": maybeAppendSuffix(value),
						"padding-bottom": maybeAppendSuffix(value),
					},
				});
			});
		},
	);

	const preHeaderBgColorSettingId = "pre_header_bg_color";

	// Background color.
	customizer(
		preHeaderBgColorSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(preHeaderBgColorSettingId, {
					selector: ".wpbf-pre-header",
					props: { "background-color": toStringColor(value) },
				});
			});
		},
	);

	const preHeaderFontColorSettingId = "pre_header_font_color";

	// Font color.
	customizer(
		preHeaderFontColorSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(preHeaderFontColorSettingId, {
					selector: ".wpbf-pre-header",
					props: { color: toStringColor(value) },
				});
			});
		},
	);

	const preHeaderAccentColorsSettingId = "pre_header_accent_colors";

	// Pre-header accent colors.
	customizer(
		preHeaderAccentColorsSettingId,
		(value: WpbfCustomizeSetting<WpbfCustomizeMulticolorControlValue>) => {
			value.bind(function (newValue) {
				const rawDefaultColor = newValue.default ?? "";
				const defaultColor = toStringColor(rawDefaultColor);

				const rawHoverColor = newValue.hover ?? "";
				const hoverColor = toStringColor(rawHoverColor);

				writeCSS(preHeaderAccentColorsSettingId, {
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
			});
		},
	);

	const preHeaderFontSizeSettingId = "pre_header_font_size";

	// Font size.
	customizer(
		preHeaderFontSizeSettingId,
		function (setting: WpbfCustomizeSetting<string | number>) {
			setting.bind(function (value) {
				writeCSS(preHeaderFontSizeSettingId, {
					selector:
						".wpbf-pre-header, .wpbf-pre-header .wpbf-menu, .wpbf-pre-header .wpbf-menu .sub-menu a",
					props: { "font-size": maybeAppendSuffix(value) },
				});
			});
		},
	);

	/* Blog – Pagination */

	const blogPaginationBorderRadiusSettingId = "blog_pagination_border_radius";

	// Border radius.
	customizer(
		blogPaginationBorderRadiusSettingId,
		function (setting: WpbfCustomizeSetting<string | number>) {
			setting.bind(function (value) {
				writeCSS(blogPaginationBorderRadiusSettingId, {
					selector: ".pagination .page-numbers",
					props: { borderRadius: maybeAppendSuffix(value) },
				});
			});
		},
	);

	const blogPaginationBgColorSettingId = "blog_pagination_background_color";

	// Background color.
	customizer(
		blogPaginationBgColorSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(blogPaginationBgColorSettingId, {
					selector: ".pagination .page-numbers:not(.current)",
					props: { "background-color": toStringColor(value) },
				});
			});
		},
	);

	const blogPaginationBgColorAltSettingId =
		"blog_pagination_background_color_alt";

	// Background color hover.
	customizer(
		blogPaginationBgColorAltSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(blogPaginationBgColorAltSettingId, {
					selector: ".pagination .page-numbers:not(.current):hover",
					props: { "background-color": toStringColor(value) },
				});
			});
		},
	);

	const blogPaginationBgColorActiveSettingId =
		"blog_pagination_background_color_active";

	// Background color active.
	customizer(
		blogPaginationBgColorActiveSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(blogPaginationBgColorActiveSettingId, {
					selector: ".pagination .page-numbers.current",
					props: { "background-color": toStringColor(value) },
				});
			});
		},
	);

	const blogPaginationFontColorSettingId = "blog_pagination_font_color";

	// Font color.
	customizer(
		blogPaginationFontColorSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(blogPaginationFontColorSettingId, {
					selector: ".pagination .page-numbers:not(.current)",
					props: { color: toStringColor(value) },
				});
			});
		},
	);

	const blogPaginationFontColorAltSettingId = "blog_pagination_font_color_alt";

	// Font color hover.
	customizer(
		blogPaginationFontColorAltSettingId,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(blogPaginationFontColorAltSettingId, {
					selector: ".pagination .page-numbers:not(.current):hover",
					props: { color: toStringColor(value) },
				});
			});
		},
	);

	const blogPaginationFontColorActive = "blog_pagination_font_color_active";

	// Font color active.
	customizer(
		blogPaginationFontColorActive,
		function (setting: WpbfCustomizeSetting<WpbfCustomizeColorControlValue>) {
			setting.bind(function (value) {
				writeCSS(blogPaginationFontColorActive, {
					selector: ".pagination .page-numbers.current",
					props: { color: toStringColor(value) },
				});
			});
		},
	);

	const blogPaginationFontSizeSettingId = "blog_pagination_font_size";

	// Font size.
	customizer(
		blogPaginationFontSizeSettingId,
		function (setting: WpbfCustomizeSetting<string | number>) {
			setting.bind(function (value) {
				writeCSS(blogPaginationFontSizeSettingId, {
					selector: ".pagination .page-numbers",
					props: { "font-size": maybeAppendSuffix(value) },
				});
			});
		},
	);

	/* Sidebar */

	const sidebarWidthSettingId = "sidebar_width";

	// Width.
	customizer(
		sidebarWidthSettingId,
		function (setting: WpbfCustomizeSetting<number | string>) {
			setting.bind(function (value) {
				const calculation = 100 - toNumberValue(value);

				writeCSS(sidebarWidthSettingId, {
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
			});
		},
	);

	const sidebarBgColorSettingId = "sidebar_bg_color";

	// Background color.
	customizer(sidebarBgColorSettingId, function (setting) {
		setting.bind(function (value) {
			writeCSS(sidebarBgColorSettingId, {
				selector: ".wpbf-sidebar .widget, .elementor-widget-sidebar .widget",
				props: { "background-color": value ? value : undefined },
			});
		});
	});

	/* Buttons */

	// Background color.
	customizer("button_bg_color", function (value) {
		const styleTag = getStyleTag("button_bg_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				'.wpbf-button:not(.wpbf-button-primary), input[type="submit"] {background-color: ' +
				newValue +
				";}";
		});
	});

	// Background color hover.
	customizer("button_bg_color_alt", function (value) {
		const styleTag = getStyleTag("button_bg_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				'.wpbf-button:not(.wpbf-button-primary):hover, input[type="submit"]:hover {background-color: ' +
				newValue +
				";}";
		});
	});

	// Text color.
	customizer("button_text_color", function (value) {
		const styleTag = getStyleTag("button_text_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				'.wpbf-button:not(.wpbf-button-primary), input[type="submit"] {color: ' +
				newValue +
				";}";
		});
	});

	// Text color hover.
	customizer("button_text_color_alt", function (value) {
		const styleTag = getStyleTag("button_text_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				'.wpbf-button:not(.wpbf-button-primary):hover, input[type="submit"]:hover {color: ' +
				newValue +
				";}";
		});
	});

	// Primary background color.
	customizer("button_primary_bg_color", function (value) {
		const styleTag = getStyleTag("button_primary_bg_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				"\
				.wpbf-button-primary {background-color: " +
				newValue +
				";}\
				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background) {background-color: " +
				newValue +
				";}\
				.is-style-outline .wp-block-button__link:not(.has-text-color):not(.has-background) {border-color: " +
				newValue +
				"; color: " +
				newValue +
				";}\
			";
		});
	});

	// Primary background color hover.
	customizer("button_primary_bg_color_alt", function (value) {
		const styleTag = getStyleTag("button_primary_bg_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				"\
				.wpbf-button-primary:hover {background-color: " +
				newValue +
				";}\
				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):not(.has-text-color):hover {background-color: " +
				newValue +
				";}\
				.is-style-outline .wp-block-button__link:not(.has-text-color):not(.has-background):hover {border-color: " +
				newValue +
				"; color: " +
				newValue +
				";}\
			";
		});
	});

	// Primary text color.
	customizer("button_primary_text_color", function (value) {
		const styleTag = getStyleTag("button_primary_text_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				"\
				.wpbf-button-primary {color: " +
				newValue +
				";}\
				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-text-color) {color: " +
				newValue +
				";}\
			";
		});
	});

	// Primary text color hover.
	customizer("button_primary_text_color_alt", function (value) {
		const styleTag = getStyleTag("button_primary_text_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				"\
				.wpbf-button-primary:hover {color: " +
				newValue +
				";}\
				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):not(.has-text-color):hover {color: " +
				newValue +
				";}\
			";
		});
	});

	// Border radius.
	customizer("button_border_radius", function (value) {
		const styleTag = getStyleTag("button_border_radius");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				'.wpbf-button, input[type="submit"] {border-radius: ' +
				newValue +
				"px;}";
		});
	});

	// Border width.
	customizer("button_border_width", function (value) {
		const styleTag = getStyleTag("button_border_width");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				'.wpbf-button, input[type="submit"] {border-width: ' +
				newValue +
				"px; border-style: solid;}";
		});
	});

	// Border color.
	customizer("button_border_color", function (value) {
		const styleTag = getStyleTag("button_border_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				'.wpbf-button:not(.wpbf-button-primary), input[type="submit"] {border-color: ' +
				newValue +
				";}";
		});
	});

	// Border color hover.
	customizer("button_border_color_alt", function (value) {
		const styleTag = getStyleTag("button_border_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				'.wpbf-button:not(.wpbf-button-primary):hover, input[type="submit"]:hover {border-color: ' +
				newValue +
				";}";
		});
	});

	// Primary border color.
	customizer("button_primary_border_color", function (value) {
		const styleTag = getStyleTag("button_primary_border_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-button-primary {border-color: " + newValue + ";}";
		});
	});

	// Primary border color hover.
	customizer("button_primary_border_color_alt", function (value) {
		const styleTag = getStyleTag("button_primary_border_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-button-primary:hover {border-color: " + newValue + ";}";
		});
	});

	/* Breadcrumbs */

	// Background background color.
	customizer("breadcrumbs_background_color", function (value) {
		const styleTag = getStyleTag("breadcrumbs_background_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-breadcrumbs-container {background-color: " + newValue + ";}";
		});
	});

	// Alignment.
	customizer("breadcrumbs_alignment", function (value) {
		const styleTag = getStyleTag("breadcrumbs_alignment");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-breadcrumbs-container {text-align: " + newValue + ";}";
		});
	});

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
