import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
} from "../customizer-util";
import { parseJsonOrUndefined } from "../../../../Customizer/Controls/Generic/src/string-util";
import { MarginPaddingValue } from "../../../../Customizer/Controls/MarginPadding/src/margin-padding-interface";
import { WpbfColorControlValue } from "../../../../Customizer/Controls/Color/src/color-interface";

export default function subMenuSetup() {
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
}
