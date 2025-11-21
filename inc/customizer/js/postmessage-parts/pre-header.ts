import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
	emptyNotZero,
} from "../customizer-util";
import {
	WpbfColorControlValue,
	WpbfMulticolorControlValue,
} from "../../../../Customizer/Controls/Color/src/color-interface";

export default function preHeaderSetup() {
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
}
