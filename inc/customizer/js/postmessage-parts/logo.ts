import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
	toNumberValue,
	mediaQueries,
} from "../customizer-util";
import { parseJsonOrUndefined } from "../../../../Customizer/Controls/Generic/src/string-util";
import { DevicesValue } from "../../../../Customizer/Controls/Responsive/src/responsive-interface";
import { WpbfColorControlValue } from "../../../../Customizer/Controls/Color/src/color-interface";

export default function logoSetup() {
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
}
