import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
	toNumberValue,
} from "../customizer-util";
import { WpbfColorControlValue } from "../../../../Customizer/Controls/Color/src/color-interface";

export default function sidebarSetup() {
	// Width.
	listenToCustomizerValueChange<number | string>(
		"sidebar_width",
		function (settingId, value) {
			const calculation = 100 - toNumberValue(value);

			writeCSS(settingId, {
				mediaQuery: "@media (min-width: 769px)",
				blocks: [
					{
						selector:
							"body:not(.wpbf-no-sidebar) .wpbf-sidebar-wrapper.wpbf-medium-1-3",
						props: { width: maybeAppendSuffix(value, "%") },
					},
					{
						selector: "body:not(.wpbf-no-sidebar) .wpbf-main.wpbf-medium-2-3",
						props: { width: maybeAppendSuffix(calculation, "%") },
					},
				],
			});
		},
	);

	// Background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"sidebar_bg_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-sidebar .widget, .elementor-widget-sidebar .widget",
				props: { "background-color": toStringColor(value) },
			});
		},
	);
}
