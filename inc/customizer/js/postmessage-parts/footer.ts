import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
	emptyNotZero,
} from "../customizer-util";
import { WpbfColorControlValue } from "../../../../Customizer/Controls/Color/src/color-interface";

export default function footerSetup() {
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
}
