import {
	listenToCustomizerValueChange,
	writeCSS,
	toStringColor,
} from "../customizer-util";
import { WpbfColorControlValue } from "../../../../Customizer/Controls/Color/src/color-interface";

export default function breadcrumbsSetup() {
	// Background background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"breadcrumbs_background_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-breadcrumbs-container",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Alignment.
	listenToCustomizerValueChange<string>(
		"breadcrumbs_alignment",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-breadcrumbs-container",
				props: { "text-align": value },
			});
		},
	);

	// Font color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"breadcrumbs_font_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-breadcrumbs",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Accent color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"breadcrumbs_accent_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-breadcrumbs a",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Accent color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"breadcrumbs_accent_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-breadcrumbs a:hover",
				props: { color: toStringColor(value) },
			});
		},
	);
}
