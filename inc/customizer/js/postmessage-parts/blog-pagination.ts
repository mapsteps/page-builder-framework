import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
} from "../customizer-util";
import { WpbfColorControlValue } from "../../../../Customizer/Controls/Color/src/color-interface";

export default function blogPaginationSetup() {
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
}
