import {
	listenToCustomizerValueChange,
	writeCSS,
	toStringColor,
	maybeAppendSuffix,
	mediaQueries,
} from "../customizer-util";
import { parseJsonOrUndefined } from "../../../../Customizer/Controls/Generic/src/string-util";
import { WpbfMulticolorControlValue } from "../../../../Customizer/Controls/Color/src/color-interface";
import { DevicesValue } from "../../../../Customizer/Controls/Responsive/src/responsive-interface";

export default function headerBuilderSearchSetup() {
	// Search Icon Color (mobile/tablet only).
	listenToCustomizerValueChange<WpbfMulticolorControlValue>(
		`wpbf_header_builder_mobile_search_icon_color`,
		function (settingId, value) {
			const defaultColor = toStringColor(value?.default ?? "");
			const hoverColor = toStringColor(value?.hover ?? "");

			// Use tablet media query to scope to mobile/tablet viewports only
			writeCSS(settingId, {
				mediaQuery: `@media (${mediaQueries.tablet})`,
				blocks: [
					{
						selector: `.wpbff-search`,
						props: { color: defaultColor + " !important" },
					},
					{
						selector: `.wpbff-search:hover, .wpbff-search:focus`,
						props: { color: hoverColor + " !important" },
					},
				],
			});
		},
	);

	// Search Icon Size.
	listenToCustomizerValueChange<string | DevicesValue>(
		"wpbf_header_builder_mobile_search_icon_size",
		function (settingId, value) {
			const obj = parseJsonOrUndefined<DevicesValue>(value);

			writeCSS(settingId + "-tablet", {
				mediaQuery: `@media (${mediaQueries.tablet})`,
				selector: ".wpbff-search",
				props: { "font-size": maybeAppendSuffix(obj?.tablet) + " !important" },
			});

			writeCSS(settingId + "-mobile", {
				mediaQuery: `@media (${mediaQueries.mobile})`,
				selector: ".wpbff-search",
				props: { "font-size": maybeAppendSuffix(obj?.mobile) + " !important" },
			});
		},
	);
}
