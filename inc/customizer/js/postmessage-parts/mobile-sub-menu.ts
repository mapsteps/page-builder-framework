import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
} from "../customizer-util";
import { parseJsonOrUndefined } from "../../../../Customizer/Controls/Generic/src/string-util";
import { MarginPaddingValue } from "../../../../Customizer/Controls/MarginPadding/src/margin-padding-interface";
import { WpbfColorControlValue } from "../../../../Customizer/Controls/Color/src/color-interface";

export default function mobileSubMenuSetup(
	$: JQueryStatic,
	customizer: WpbfCustomize,
) {
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
				props: { color: toStringColor(value) },
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
}
