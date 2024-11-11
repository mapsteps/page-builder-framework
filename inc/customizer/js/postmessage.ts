import { WpbfCustomizeSetting } from "../../../Customizer/Controls/Base/src/base-interface";
import { WpbfCheckboxButtonsetControlValue } from "../../../Customizer/Controls/Checkbox/src/checkbox-interface";
import {
	WpbfCustomizeColorControlValue,
	WpbfCustomizeMulticolorControlValue,
} from "../../../Customizer/Controls/Color/src/color-interface";
import { DevicesValue } from "../../../Customizer/Controls/Responsive/src/responsive-interface";

(function ($: JQueryStatic, customizer: WpbfCustomize | undefined) {
	if (!customizer) return;

	const breakpoints = window.WpbfTheme.breakpoints;

	const mediaQueries = {
		tablet: "max-width: " + (breakpoints.desktop - 1).toString() + "px",
		mobile: "max-width: " + (breakpoints.tablet - 1).toString() + "px",
	};

	function valueHasUnit(value: string | number): boolean {
		if (!value) {
			return false;
		}

		const strValue = String(value);
		const unitPattern = /[a-z%]+$/i;
		const unitMatch = strValue.match(unitPattern);

		return unitMatch && unitMatch.length > 0 ? true : false;
	}

	function maybeAppendSuffix(value: string | number, suffix?: string) {
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

	type WriteCssArgs = {
		selector: string;
		props: string[];
		value: string | number | null | undefined;
		important?: boolean;
	};

	/**
	 * Write CSS to the style tag.
	 *
	 * @param {HTMLStyleElement|string} styleTagOrId - The style tag element or the style tag id.
	 * @param {WriteCssArgs} args - The arguments.
	 */
	function writeCSS(
		styleTagOrId: HTMLStyleElement | string,
		args: WriteCssArgs[],
	) {
		const styleTag =
			typeof styleTagOrId === "string"
				? getStyleTag(styleTagOrId)
				: styleTagOrId;

		if (!args.length) return;

		let content = "";

		args.forEach((arg) => {
			const { selector, props, value, important } = arg;

			if (value === "" || value === null || value === undefined) {
				return;
			}

			content += "\n" + selector + " {";

			for (const prop of props) {
				content += prop + ": " + value + (important ? " !important" : "") + ";";
			}

			content += "}";
		});

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

	// Width.
	customizer("menu_width", function (value) {
		const styleTag = getStyleTag("menu_width");

		value.bind(function (newValue) {
			newValue = !newValue ? "1200px" : newValue;
			styleTag.innerHTML = ".wpbf-nav-wrapper {max-width: " + newValue + ";}";
		});
	});

	const headerHeightSettingId = "menu_height";

	// Menu height.
	customizer(
		headerHeightSettingId,
		function (setting: WpbfCustomizeSetting<number | string>) {
			setting.bind(function (value) {
				const selector = headerBuilderEnabled()
					? `.wpbf-header-row-row_2 .wpbf-row-content`
					: `.wpbf-nav-wrapper`;

				writeCSS(headerHeightSettingId, [
					{
						selector: selector,
						props: ["padding-top", "padding-bottom"],
						value: maybeAppendSuffix(value),
					},
				]);
			});
		},
	);

	// Menu padding.
	customizer("menu_padding", function (value) {
		const styleTag = getStyleTag("menu_padding");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-navigation .wpbf-menu > .menu-item > a {padding-left: " +
				newValue +
				"px; padding-right: " +
				newValue +
				"px;}";
		});
	});

	// Background color.
	customizer("menu_bg_color", function (value) {
		const styleTag = getStyleTag("menu_bg_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-navigation:not(.wpbf-navigation-transparent):not(.wpbf-navigation-active) {background-color: " +
				newValue +
				";}";
		});
	});

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

				writeCSS(menuFontColorsSettingId, [
					{
						selector:
							".wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a, .wpbf-close",
						props: ["color"],
						value: defaultColor,
					},
					{
						selector:
							".wpbf-navigation .wpbf-menu a:hover, .wpbf-mobile-menu a:hover",
						props: ["color"],
						value: hoverColor,
					},
					{
						selector:
							".wpbf-navigation .wpbf-menu > .current-menu-item > a, .wpbf-mobile-menu > .current-menu-item > a",
						props: ["color"],
						value: hoverColor,
						important: true,
					},
				]);
			});
		},
	);

	// Font size.
	customizer("menu_font_size", function (value) {
		const styleTag = getStyleTag("menu_font_size");

		value.bind(function (newValue) {
			var suffix = $.isNumeric(newValue) ? "px" : "";
			styleTag.innerHTML =
				".wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a {font-size: " +
				newValue +
				suffix +
				";}";
		});
	});

	/* Sub Menu */

	// Text alignment.
	customizer("sub_menu_text_alignment", function (value) {
		const styleTag = getStyleTag("sub_menu_text_alignment");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				"\
				.wpbf-sub-menu .sub-menu {\
					text-align: " +
				newValue +
				"\
				}\
			";
		});
	});

	// Padding.
	customizer("sub_menu_padding", function (value) {
		const styleTag = getStyleTag("sub_menu_padding");

		value.bind(function (newValue) {
			var obj = JSON.parse(newValue),
				top = obj.top,
				right = obj.right,
				bottom = obj.bottom,
				left = obj.left;

			styleTag.innerHTML =
				"\
				.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu a {\
					padding-top: " +
				top +
				"px;\
					padding-right: " +
				right +
				"px;\
					padding-bottom: " +
				bottom +
				"px;\
					padding-left: " +
				left +
				"px;\
				}\
			";
		});
	});

	// Width.
	customizer("sub_menu_width", function (value) {
		const styleTag = getStyleTag("sub_menu_width");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu {width: " +
				newValue +
				"px;}";
		});
	});

	// Background color.
	customizer("sub_menu_bg_color", function (value) {
		const styleTag = getStyleTag("sub_menu_bg_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				"\
				.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li,\
				.wpbf-sub-menu > .wpbf-mega-menu > .sub-menu {\
					background-color: " +
				newValue +
				";\
				}\
			";
		});
	});

	// Background color hover.
	customizer("sub_menu_bg_color_alt", function (value) {
		const styleTag = getStyleTag("sub_menu_bg_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				"\
				.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li:hover {\
					background-color: " +
				newValue +
				";\
				}\
			";
		});
	});

	// Accent color.
	customizer("sub_menu_accent_color", function (value) {
		const styleTag = getStyleTag("sub_menu_accent_color");

		value.bind(function (newValue) {
			styleTag.innerHTML = ".wpbf-menu .sub-menu a {color: " + newValue + ";}";
		});
	});

	// Accent color hover.
	customizer("sub_menu_accent_color_alt", function (value) {
		const styleTag = getStyleTag("sub_menu_accent_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-navigation .wpbf-menu .sub-menu a:hover {color: " +
				newValue +
				";}";
		});
	});

	// Font size.
	customizer("sub_menu_font_size", function (value) {
		const styleTag = getStyleTag("sub_menu_font_size");

		value.bind(function (newValue) {
			var suffix = $.isNumeric(newValue) ? "px" : "";
			styleTag.innerHTML =
				".wpbf-menu .sub-menu a {font-size: " + newValue + suffix + ";}";
		});
	});

	// Separator color.
	customizer("sub_menu_separator_color", function (value) {
		const styleTag = getStyleTag("sub_menu_separator_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) li {border-bottom-color: " +
				newValue +
				";}";
		});
	});

	/* Mobile Navigation */

	// Height.
	customizer("mobile_menu_height", function (value) {
		const styleTag = getStyleTag("mobile_menu_height");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-mobile-nav-wrapper {padding-top: " +
				newValue +
				"px; padding-bottom: " +
				newValue +
				"px;}";
		});
	});

	// Background color.
	customizer("mobile_menu_background_color", function (value) {
		const styleTag = getStyleTag("mobile_menu_background_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-mobile-nav-wrapper {background-color: " + newValue + ";}";
		});
	});

	// Icon color.
	customizer("mobile_menu_hamburger_color", function (value) {
		const styleTag = getStyleTag("mobile_menu_hamburger_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-mobile-nav-item, .wpbf-mobile-nav-item a {color: " +
				newValue +
				";}";
		});
	});

	// Hamburger size.
	customizer("mobile_menu_hamburger_size", function (value) {
		const styleTag = getStyleTag("mobile_menu_hamburger_size");

		value.bind(function (newValue) {
			var suffix = $.isNumeric(newValue) ? "px" : "";
			styleTag.innerHTML =
				".wpbf-mobile-nav-item {font-size: " + newValue + suffix + ";}";
		});
	});

	// Hamburger border radius (filled).
	customizer("mobile_menu_hamburger_border_radius", function (value) {
		const styleTag = getStyleTag("mobile_menu_hamburger_border_radius");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-mobile-nav-item {border-radius: " + newValue + "px;}";
		});
	});

	// Padding.
	customizer("mobile_menu_padding", function (value) {
		const styleTag = getStyleTag("mobile_menu_padding");

		value.bind(function (newValue) {
			var obj = JSON.parse(newValue),
				top = obj.top,
				right = obj.right,
				bottom = obj.bottom,
				left = obj.left;

			styleTag.innerHTML =
				"\
				.wpbf-mobile-menu a,\
				.wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle {\
					padding-top: " +
				top +
				"px;\
					padding-right: " +
				right +
				"px;\
					padding-bottom: " +
				bottom +
				"px;\
					padding-left: " +
				left +
				"px;\
				}\
			";
		});
	});

	// Menu item background color.
	customizer("mobile_menu_bg_color", function (value) {
		const styleTag = getStyleTag("mobile_menu_bg_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-mobile-menu > .menu-item a {background-color: " +
				newValue +
				";}";
		});
	});

	// Menu item background color hover.
	customizer("mobile_menu_bg_color_alt", function (value) {
		const styleTag = getStyleTag("mobile_menu_bg_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-mobile-menu > .menu-item a:hover {background-color: " +
				newValue +
				";}";
		});
	});

	// Menu item font color.
	customizer("mobile_menu_font_color", function (value) {
		const styleTag = getStyleTag("mobile_menu_font_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-mobile-menu a, .wpbf-mobile-menu-container .wpbf-close {color: " +
				newValue +
				";}";
		});
	});

	// Menu item font color hover.
	customizer("mobile_menu_font_color_alt", function (value) {
		const styleTag = getStyleTag("mobile_menu_font_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-mobile-menu a:hover, .wpbf-mobile-menu > .current-menu-item > a {color: " +
				newValue +
				"!important;}";
		});
	});

	// Menu item divider color.
	customizer("mobile_menu_border_color", function (value) {
		const styleTag = getStyleTag("mobile_menu_border_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				"\
				.wpbf-mobile-menu .menu-item {border-top-color: " +
				newValue +
				";}\
				.wpbf-mobile-menu > .menu-item:last-child {border-bottom-color: " +
				newValue +
				";}\
			";
		});
	});

	// Sub menu arrow color.
	customizer("mobile_menu_submenu_arrow_color", function (value) {
		const styleTag = getStyleTag("mobile_menu_submenu_arrow_color");

		value.bind(function (newValue) {
			styleTag.innerHTML = ".wpbf-submenu-toggle {color: " + newValue + ";}";
		});
	});

	// Menu item font size.
	customizer("mobile_menu_font_size", function (value) {
		const styleTag = getStyleTag("mobile_menu_font_size");

		value.bind(function (newValue) {
			var suffix = $.isNumeric(newValue) ? "px" : "";
			styleTag.innerHTML =
				".wpbf-mobile-menu a, .wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle {font-size: " +
				newValue +
				suffix +
				";}";
		});
	});

	/* Mobile sub menu */

	// Submenu auto collapse.
	customizer("mobile_sub_menu_auto_collapse", function (value) {
		value.bind(function (newValue) {
			if (!document.querySelector("#mobile-navigation")) return;

			if (newValue) {
				$("#mobile-navigation")
					.closest(".wpbf-navigation")
					.addClass("wpbf-mobile-sub-menu-auto-collapse");
			} else {
				$("#mobile-navigation")
					.closest(".wpbf-navigation")
					.removeClass("wpbf-mobile-sub-menu-auto-collapse");
			}
		});
	});

	// Indent.
	customizer("mobile_sub_menu_indent", function (value) {
		const styleTag = getStyleTag("mobile_sub_menu_indent");

		value.bind(function (newValue) {
			var padding = customizer("mobile_menu_padding").get();
			padding = JSON.parse(padding);

			var calculation = parseInt(newValue, 10) + parseInt(padding.left, 10);
			styleTag.innerHTML =
				".wpbf-mobile-menu .sub-menu a {padding-left: " + calculation + "px;}";
		});
	});

	// Menu item background color.
	customizer("mobile_sub_menu_bg_color", function (value) {
		const styleTag = getStyleTag("mobile_sub_menu_bg_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-mobile-menu .sub-menu a {background-color: " + newValue + ";}";
		});
	});

	// Menu item background color hover.
	customizer("mobile_sub_menu_bg_color_alt", function (value) {
		const styleTag = getStyleTag("mobile_sub_menu_bg_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-mobile-menu .sub-menu a:hover {background-color: " +
				newValue +
				";}";
		});
	});

	// Menu item font color.
	customizer("mobile_sub_menu_font_color", function (value) {
		const styleTag = getStyleTag("mobile_sub_menu_font_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-mobile-menu .sub-menu a {color: " + newValue + ";}";
		});
	});

	// Menu item font color hover.
	customizer("mobile_sub_menu_font_color_alt", function (value) {
		const styleTag = getStyleTag("mobile_sub_menu_font_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-mobile-menu .sub-menu a:hover, .wpbf-mobile-menu .sub-menu > .current-menu-item > a {color: " +
				newValue +
				"!important;}";
		});
	});

	// Menu item divider color.
	customizer("mobile_sub_menu_border_color", function (value) {
		const styleTag = getStyleTag("mobile_sub_menu_border_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-mobile-menu .sub-menu .menu-item {border-top-color: " +
				newValue +
				";}";
		});
	});

	// Sub menu arrow color.
	customizer("mobile_sub_menu_arrow_color", function (value) {
		const styleTag = getStyleTag("mobile_sub_menu_arrow_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-mobile-menu .sub-menu .wpbf-submenu-toggle {color: " +
				newValue +
				";}";
		});
	});

	// Menu item font size.
	customizer("mobile_sub_menu_font_size", function (value) {
		const styleTag = getStyleTag("mobile_sub_menu_font_size");

		value.bind(function (newValue) {
			var suffix = $.isNumeric(newValue) ? "px" : "";
			styleTag.innerHTML =
				".wpbf-mobile-menu .sub-menu a, .wpbf-mobile-menu .sub-menu .menu-item-has-children .wpbf-submenu-toggle {font-size: " +
				newValue +
				suffix +
				";}";
		});
	});

	/* Logo */

	// Width.
	customizer("menu_logo_size", function (value) {
		const styleTag = getStyleTag("menu_logo_size");

		value.bind(function (newValue) {
			var obj = JSON.parse(newValue),
				desktop = obj.desktop,
				tablet = obj.tablet,
				mobile = obj.mobile,
				desktopsuffix = $.isNumeric(desktop) ? "px" : "",
				tabletsuffix = $.isNumeric(tablet) ? "px" : "",
				mobilesuffix = $.isNumeric(mobile) ? "px" : "";

			styleTag.innerHTML =
				"\
				.wpbf-logo img, .wpbf-mobile-logo img {\
					width: " +
				desktop +
				desktopsuffix +
				";\
				}\
				@media (" +
				mediaQueries.tablet +
				") {\
					.wpbf-mobile-logo img {width: " +
				tablet +
				tabletsuffix +
				";}\
				}\
				@media (" +
				mediaQueries.mobile +
				") {\
					.wpbf-mobile-logo img {width: " +
				mobile +
				mobilesuffix +
				";}\
				}\
			";
		});
	});

	// Font size.
	customizer("menu_logo_font_size", function (value) {
		const styleTag = getStyleTag("menu_logo_font_size");

		value.bind(function (newValue) {
			var obj = JSON.parse(newValue),
				desktop = obj.desktop,
				tablet = obj.tablet,
				mobile = obj.mobile,
				desktopsuffix = $.isNumeric(desktop) ? "px" : "",
				tabletsuffix = $.isNumeric(tablet) ? "px" : "",
				mobilesuffix = $.isNumeric(mobile) ? "px" : "";

			styleTag.innerHTML =
				"\
				.wpbf-logo a, .wpbf-mobile-logo a {\
					font-size: " +
				desktop +
				desktopsuffix +
				";\
				}\
				@media (" +
				mediaQueries.tablet +
				") {\
					.wpbf-mobile-logo a {font-size: " +
				tablet +
				tabletsuffix +
				";}\
				}\
				@media (" +
				mediaQueries.mobile +
				") {\
					.wpbf-mobile-logo a {font-size: " +
				mobile +
				mobilesuffix +
				";}\
				}\
			";
		});
	});

	// Color.
	customizer("menu_logo_color", function (value) {
		const styleTag = getStyleTag("menu_logo_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-logo a, .wpbf-mobile-logo a {color: " + newValue + ";}";
		});
	});

	// Color hover.
	customizer("menu_logo_color_alt", function (value) {
		const styleTag = getStyleTag("menu_logo_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-logo a:hover, .wpbf-mobile-logo a:hover {color: " +
				newValue +
				";}";
		});
	});

	// Container width.
	customizer("menu_logo_container_width", function (value) {
		const styleTag = getStyleTag("menu_logo_container_width");

		value.bind(function (newValue) {
			var calculation = 100 - newValue;
			styleTag.innerHTML =
				"\
				.wpbf-navigation .wpbf-1-4 {width: " +
				newValue +
				"%;}\
				.wpbf-navigation .wpbf-3-4 {width: " +
				calculation +
				"%;}\
			";
		});
	});

	// Mobile container width.
	customizer("mobile_menu_logo_container_width", function (value) {
		const styleTag = getStyleTag("mobile_menu_logo_container_width");

		value.bind(function (newValue) {
			var calculation = 100 - newValue;
			styleTag.innerHTML =
				"\
				@media (" +
				mediaQueries.tablet +
				") {\
					.wpbf-navigation .wpbf-2-3 {width: " +
				newValue +
				"%;}\
					.wpbf-navigation .wpbf-1-3 {width: " +
				calculation +
				"%;}\
				}\
			";
		});
	});

	/* Tagline */

	// Font size.
	customizer("menu_logo_description_font_size", function (value) {
		const styleTag = getStyleTag("menu_logo_description_font_size");

		value.bind(function (newValue) {
			var obj = JSON.parse(newValue),
				desktop = obj.desktop,
				tablet = obj.tablet,
				mobile = obj.mobile,
				desktopsuffix = $.isNumeric(desktop) ? "px" : "",
				tabletsuffix = $.isNumeric(tablet) ? "px" : "",
				mobilesuffix = $.isNumeric(mobile) ? "px" : "";

			styleTag.innerHTML =
				"\
				.wpbf-logo .wpbf-tagline, .wpbf-mobile-logo .wpbf-tagline {\
					font-size: " +
				desktop +
				desktopsuffix +
				";\
				}\
				@media (" +
				mediaQueries.tablet +
				") {\
					.wpbf-mobile-logo .wpbf-tagline {font-size: " +
				tablet +
				tabletsuffix +
				";}\
				}\
				@media (" +
				mediaQueries.mobile +
				") {\
					.wpbf-mobile-logo .wpbf-tagline {font-size: " +
				mobile +
				mobilesuffix +
				";}\
				}\
			";
		});
	});

	// Font color.
	customizer("menu_logo_description_color", function (value) {
		const styleTag = getStyleTag("menu_logo_description_color");

		value.bind(function (newValue) {
			styleTag.innerHTML = ".wpbf-tagline {color: " + newValue + ";}";
		});
	});

	/* Pre Header */

	// Width.
	customizer("pre_header_width", function (value) {
		const styleTag = getStyleTag("pre_header_width");

		value.bind(function (newValue) {
			newValue = !newValue ? "1200px" : newValue;
			styleTag.innerHTML =
				".wpbf-inner-pre-header {max-width: " + newValue + ";}";
		});
	});

	// Height.
	customizer("pre_header_height", function (value) {
		const styleTag = getStyleTag("pre_header_height");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-inner-pre-header {padding-top: " +
				newValue +
				"px; padding-bottom: " +
				newValue +
				"px;}";
		});
	});

	// Background color.
	customizer("pre_header_bg_color", function (value) {
		const styleTag = getStyleTag("pre_header_bg_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-pre-header {background-color: " + newValue + ";}";
		});
	});

	// Font color.
	customizer("pre_header_font_color", function (value) {
		const styleTag = getStyleTag("pre_header_font_color");

		value.bind(function (newValue) {
			styleTag.innerHTML = ".wpbf-pre-header {color: " + newValue + ";}";
		});
	});

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

				writeCSS(preHeaderAccentColorsSettingId, [
					{
						selector: ".wpbf-pre-header a",
						props: ["color"],
						value: defaultColor,
					},
					{
						selector:
							".wpbf-pre-header a:hover, .wpbf-pre-header .wpbf-menu > .current-menu-item > a",
						props: ["color"],
						value: hoverColor,
						important: true,
					},
				]);
			});
		},
	);

	// Font size.
	customizer("pre_header_font_size", function (value) {
		const styleTag = getStyleTag("pre_header_font_size");

		value.bind(function (newValue) {
			var suffix = $.isNumeric(newValue) ? "px" : "";
			styleTag.innerHTML =
				"\
				.wpbf-pre-header,\
				.wpbf-pre-header .wpbf-menu,\
				.wpbf-pre-header .wpbf-menu .sub-menu a {\
					font-size: " +
				newValue +
				suffix +
				";\
				}\
			";
		});
	});

	/* Blog – Pagination */

	// Border radius.
	customizer("blog_pagination_border_radius", function (value) {
		const styleTag = getStyleTag("blog_pagination_border_radius");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".pagination .page-numbers {border-radius: " + newValue + "px;}";
		});
	});

	// Background color.
	customizer("blog_pagination_background_color", function (value) {
		const styleTag = getStyleTag("blog_pagination_background_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".pagination .page-numbers:not(.current) {background-color: " +
				newValue +
				";}";
		});
	});

	// Background color hover.
	customizer("blog_pagination_background_color_alt", function (value) {
		const styleTag = getStyleTag("blog_pagination_background_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".pagination .page-numbers:not(.current):hover {background-color: " +
				newValue +
				";}";
		});
	});

	// Background color active.
	customizer("blog_pagination_background_color_active", function (value) {
		const styleTag = getStyleTag("blog_pagination_background_color_active");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".pagination .page-numbers.current {background-color: " +
				newValue +
				";}";
		});
	});

	// Font color.
	customizer("blog_pagination_font_color", function (value) {
		const styleTag = getStyleTag("blog_pagination_font_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".pagination .page-numbers:not(.current) {color: " + newValue + ";}";
		});
	});

	// Font color hover.
	customizer("blog_pagination_font_color_alt", function (value) {
		const styleTag = getStyleTag("blog_pagination_font_color_alt");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".pagination .page-numbers:not(.current):hover {color: " +
				newValue +
				";}";
		});
	});

	// Font color active.
	customizer("blog_pagination_font_color_active", function (value) {
		const styleTag = getStyleTag("blog_pagination_font_color_active");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".pagination .page-numbers.current {color: " + newValue + ";}";
		});
	});

	// Font size.
	customizer("blog_pagination_font_size", function (value) {
		const styleTag = getStyleTag("blog_pagination_font_size");

		value.bind(function (newValue) {
			var suffix = $.isNumeric(newValue) ? "px" : "";
			styleTag.innerHTML =
				".pagination .page-numbers {font-size: " + newValue + suffix + ";}";
		});
	});

	/* Sidebar */

	// Width.
	customizer("sidebar_width", function (value) {
		const styleTag = getStyleTag("sidebar_width");

		value.bind(function (newValue) {
			var calculation = 100 - newValue;

			styleTag.innerHTML =
				"\
				@media (min-width: 769px) {\
					body:not(.wpbf-no-sidebar) .wpbf-sidebar-wrapper.wpbf-medium-1-3 {width: " +
				newValue +
				"%;}\
					body:not(.wpbf-no-sidebar) .wpbf-main.wpbf-medium-2-3 {width: " +
				calculation +
				"%;}\
				}\
			";
		});
	});

	// Background color.
	customizer("sidebar_bg_color", function (value) {
		const styleTag = getStyleTag("sidebar_bg_color");

		value.bind(function (newValue) {
			styleTag.innerHTML =
				".wpbf-sidebar .widget, .elementor-widget-sidebar .widget {background-color: " +
				newValue +
				";}";
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
						writeCSS(maxWidthSettingId, [
							{
								selector: `.wpbf-header-row-${rowKey} .wpbf-container`,
								props: ["max-width"],
								value: maybeAppendSuffix(newValue),
							},
						]);
					});
				},
			);

			const vPaddingSettingId = `${controlIdPrefix}vertical_padding`;

			customizer(
				vPaddingSettingId,
				function (value: WpbfCustomizeSetting<string | number>) {
					value.bind(function (newValue) {
						writeCSS(vPaddingSettingId, [
							{
								selector: `.wpbf-header-row-${rowKey} .wpbf-row-content`,
								props: ["padding-top", "padding-bottom"],
								value: maybeAppendSuffix(newValue),
							},
						]);
					});
				},
			);

			const fontSizeSettingId = `${controlIdPrefix}font_size`;

			customizer(
				fontSizeSettingId,
				(value: WpbfCustomizeSetting<string | number>) => {
					value.bind(function (newValue) {
						writeCSS(fontSizeSettingId, [
							{
								selector: `.wpbf-header-row-${rowKey}`,
								props: ["font-size"],
								value: maybeAppendSuffix(newValue),
							},
						]);
					});
				},
			);

			const bgColorSettinglId = `${controlIdPrefix}bg_color`;

			customizer(bgColorSettinglId, function (value) {
				value.bind(function (newValue) {
					writeCSS(bgColorSettinglId, [
						{
							selector: `.wpbf-header-row-${rowKey}`,
							props: ["background-color"],
							value: newValue,
						},
					]);
				});
			});
		}

		const textColorSettingId = `${controlIdPrefix}text_color`;

		customizer(textColorSettingId, function (value) {
			value.bind(function (newValue) {
				writeCSS(textColorSettingId, [
					{
						selector: `.wpbf-header-row-${rowKey}`,
						props: ["color"],
						value: newValue,
					},
				]);
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

					writeCSS(accentColorsSettingId, [
						{
							selector: `.wpbf-header-row-${rowKey} a`,
							props: ["color"],
							value: defaultColor,
						},
						{
							selector: `.wpbf-header-row-${rowKey} a:hover, .wpbf-header-row-${rowKey} a:focus`,
							props: ["color"],
							value: hoverColor,
						},
					]);
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
