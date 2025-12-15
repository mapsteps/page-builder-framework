import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
} from "../customizer-util";
import { headerBuilderEnabled } from "../../../../assets/js/utils/customizer-util";
import {
	WpbfColorControlValue,
	WpbfMulticolorControlValue,
} from "../../../../Customizer/Controls/Color/src/color-interface";

export default function navigationSetup() {
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
				selector: headerBuilderEnabled()
					? ".wpbf-menu.desktop_menu_1 > .menu-item > a"
					: ".wpbf-menu > .menu-item > a",
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
				selector: headerBuilderEnabled()
					? ".wpbf-menu.desktop_menu_1 > .menu-item > a"
					: ".wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a",
				props: {
					"font-size": maybeAppendSuffix(value),
				},
			});
		},
	);
}
