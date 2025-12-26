import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
	removeStyleTag,
	emptyNotZero,
} from "../customizer-util";
import { parseJsonOrUndefined } from "../../../../Customizer/Controls/Generic/src/string-util";
import { MarginPaddingValue } from "../../../../Customizer/Controls/MarginPadding/src/margin-padding-interface";
import {
	WpbfColorControlValue,
	WpbfMulticolorControlValue,
} from "../../../../Customizer/Controls/Color/src/color-interface";
import { headerBuilderEnabled } from "../../../../assets/js/utils/customizer-util";

export default function mobileNavigationSetup(customizer: WpbfCustomize) {
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
			const colorValue = toStringColor(value);
			writeCSS(settingId, {
				selector:
					".wpbf-mobile-nav-item, .wpbf-mobile-nav-item a, .wpbf-mobile-menu-toggle, .wpbf-mobile-menu-toggle.wpbff, .wpbf-mobile-menu-toggle svg, .wpbf-mobile-menu-toggle svg path",
				props: {
					color: colorValue + " !important",
					fill: colorValue,
					stroke: colorValue,
				},
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
			const isHeaderBuilderEnabled = headerBuilderEnabled();

			// When header builder is disabled, this control acts as a simple "solid" button style.
			// When header builder is enabled, respect the menu trigger style setting.
			let buttonStyle = "solid"; // Default for legacy (non-header-builder) mode

			if (isHeaderBuilderEnabled) {
				const menuTriggerStyle = customizer?.(
					"wpbf_header_builder_mobile_menu_trigger_style",
				)?.get();

				buttonStyle =
					menuTriggerStyle && String(menuTriggerStyle).trim() !== ""
						? String(menuTriggerStyle)
						: "simple";

				// Only apply if style is solid or outline (header builder mode)
				if (buttonStyle !== "solid" && buttonStyle !== "outline") {
					// Reset styles for simple
					writeCSS(settingId, {
						selector: ".wpbf-mobile-menu-toggle",
						props: {
							"background-color": "unset !important",
							color: "unset",
							padding: "unset",
							"line-height": "unset",
							border: "unset !important",
							"border-radius": "unset",
						},
					});
					return;
				}
			}

			if (!value) {
				removeStyleTag(settingId);
				return;
			}

			const borderRadius = customizer?.(
				"mobile_menu_hamburger_border_radius",
			).get();

			if (buttonStyle === "solid") {
				writeCSS(settingId, {
					selector: ".wpbf-mobile-menu-toggle",
					props: {
						"background-color": toStringColor(value) + " !important",
						color: "#ffffff",
						// Only hardcode padding for legacy (non-header-builder) mode
						padding: isHeaderBuilderEnabled ? undefined : "10px",
						"line-height": 1,
						border: "unset !important",
						"border-radius": emptyNotZero(borderRadius)
							? undefined
							: maybeAppendSuffix(borderRadius),
					},
				});
			} else if (buttonStyle === "outline") {
				writeCSS(settingId, {
					selector: ".wpbf-mobile-menu-toggle",
					props: {
						"background-color": "unset !important",
						border: "2px solid " + toStringColor(value) + " !important",
						color: toStringColor(value),
						// Only hardcode padding for legacy (non-header-builder) mode
						padding: isHeaderBuilderEnabled ? undefined : "10px",
						"line-height": 1,
						"border-radius": emptyNotZero(borderRadius)
							? undefined
							: maybeAppendSuffix(borderRadius),
					},
				});
			}
		},
	);

	// Hamburger (filled) button border radius.
	listenToCustomizerValueChange<string | number>(
		"mobile_menu_hamburger_border_radius",
		function (settingId, value) {
			const isHeaderBuilderEnabled = headerBuilderEnabled();

			// When header builder is disabled, always apply border radius (legacy behavior).
			// When header builder is enabled, respect the menu trigger style setting.
			let buttonStyle = "solid"; // Default for legacy (non-header-builder) mode

			if (isHeaderBuilderEnabled) {
				const menuTriggerStyle = customizer?.(
					"wpbf_header_builder_mobile_menu_trigger_style",
				)?.get();

				buttonStyle =
					menuTriggerStyle && String(menuTriggerStyle).trim() !== ""
						? String(menuTriggerStyle)
						: "simple";

				// Only apply if style is solid or outline (header builder mode)
				if (buttonStyle !== "solid" && buttonStyle !== "outline") {
					writeCSS(settingId, {
						selector: ".wpbf-mobile-menu-toggle",
						props: {
							"border-radius": "unset !important",
						},
					});
					return;
				}
			}

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
					".wpbf-mobile-menu.mobile_menu_1 a, .wpbf-mobile-menu.mobile_menu_1 .menu-item-has-children .wpbf-submenu-toggle",
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
				blocks: [
					{
						selector: ".wpbf-mobile-menu > .menu-item a",
						props: { "background-color": toStringColor(value) },
					},
					{
						selector: ".wpbf-mobile-menu-dropdown .wpbf-mobile-menu-container",
						props: { "background-color": toStringColor(value) },
					},
				],
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

	// Menu item font colors.
	listenToCustomizerValueChange<WpbfMulticolorControlValue>(
		"mobile_menu_font_colors",
		(settingId, value) => {
			const rawDefaultColor = value.default ?? "";
			const defaultColor = toStringColor(rawDefaultColor);

			const rawHoverColor = value.hover ?? "";
			const hoverColor = toStringColor(rawHoverColor);

			writeCSS(settingId, {
				blocks: [
					{
						selector:
							".wpbf-mobile-menu a, .wpbf-mobile-menu-container .wpbf-close",
						props: { color: defaultColor },
					},
					{
						selector: ".wpbf-mobile-menu a:hover",
						props: { color: hoverColor },
					},
					{
						selector: ".wpbf-mobile-menu > .current-menu-item > a",
						props: { color: `${hoverColor}!important` },
					},
				],
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
}
