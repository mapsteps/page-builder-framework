import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
	mediaQueries,
} from "../customizer-util";
import { parseJsonOrUndefined } from "../../../../Customizer/Controls/Generic/src/string-util";
import { DevicesValue } from "../../../../Customizer/Controls/Responsive/src/responsive-interface";
import { WpbfColorControlValue } from "../../../../Customizer/Controls/Color/src/color-interface";

export default function taglineSetup() {
	// Font size.
	listenToCustomizerValueChange<string | DevicesValue>(
		"menu_logo_description_font_size",
		function (settingId, value) {
			const obj = parseJsonOrUndefined<DevicesValue>(value);

			writeCSS(settingId + "-desktop", {
				selector: ".wpbf-logo .wpbf-tagline, .wpbf-mobile-logo .wpbf-tagline",
				props: {
					"font-size": maybeAppendSuffix(obj?.desktop),
				},
			});

			writeCSS(settingId + "-tablet", {
				mediaQuery: `@media (${mediaQueries.tablet})`,
				selector: ".wpbf-mobile-logo .wpbf-tagline",
				props: { "font-size": maybeAppendSuffix(obj?.tablet) },
			});

			writeCSS(settingId + "-mobile", {
				mediaQuery: `@media (${mediaQueries.mobile})`,
				selector: ".wpbf-mobile-logo .wpbf-tagline",
				props: { "font-size": maybeAppendSuffix(obj?.mobile) },
			});
		},
	);

	// Font color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"menu_logo_description_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-tagline",
				props: { color: toStringColor(value) },
			});
		},
	);
}
