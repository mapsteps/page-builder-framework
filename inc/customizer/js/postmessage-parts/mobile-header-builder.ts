import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
	listenToBuilderResponsiveControl,
	WpbfCheckboxButtonsetResponsiveValue,
} from "../customizer-util";
import {
	WpbfColorControlValue,
	WpbfMulticolorControlValue,
} from "../../../../Customizer/Controls/Color/src/color-interface";

export default function mobileHeaderBuilderSetup() {
	// Row visibility.
	const rows = ["top", "main", "bottom"];

	rows.forEach((row) => {
		listenToCustomizerValueChange<WpbfCheckboxButtonsetResponsiveValue>(
			`wpbf_header_builder_mobile_${row}_row_visibility`,
			function (settingId, value) {
				const selector = `.wpbf-header-row-mobile_row_${row === "top" ? "1" : row === "main" ? "2" : "3"}`;

				writeCSS(settingId, {
					selector: selector,
					props: {
						display: value.mobile ? "block" : "none",
					},
				});
			},
		);
	});

	// Button settings.
	listenToCustomizerValueChange<WpbfMulticolorControlValue>(
		"wpbf_header_builder_mobile_button_color",
		function (settingId, value) {
			const rawDefaultColor = value.default ?? "";
			const defaultColor = toStringColor(rawDefaultColor);

			const rawHoverColor = value.hover ?? "";
			const hoverColor = toStringColor(rawHoverColor);

			writeCSS(settingId, {
				blocks: [
					{
						selector: ".wpbf-mobile-header-button .wpbf-button",
						props: {
							"background-color": defaultColor,
							"border-color": defaultColor,
						},
					},
					{
						selector: ".wpbf-mobile-header-button .wpbf-button:hover",
						props: {
							"background-color": hoverColor,
							"border-color": hoverColor,
						},
					},
				],
			});
		},
	);

	listenToCustomizerValueChange<WpbfMulticolorControlValue>(
		"wpbf_header_builder_mobile_button_text_color",
		function (settingId, value) {
			const rawDefaultColor = value.default ?? "";
			const defaultColor = toStringColor(rawDefaultColor);

			const rawHoverColor = value.hover ?? "";
			const hoverColor = toStringColor(rawHoverColor);

			writeCSS(settingId, {
				blocks: [
					{
						selector: ".wpbf-mobile-header-button .wpbf-button",
						props: { color: defaultColor },
					},
					{
						selector: ".wpbf-mobile-header-button .wpbf-button:hover",
						props: { color: hoverColor },
					},
				],
			});
		},
	);

	listenToBuilderResponsiveControl({
		controlId: "wpbf_header_builder_mobile_button_width",
		cssSelector: ".wpbf-mobile-header-button .wpbf-button",
		cssProps: "width",
		useValueSuffix: true,
	});

	listenToBuilderResponsiveControl({
		controlId: "wpbf_header_builder_mobile_button_font_size",
		cssSelector: ".wpbf-mobile-header-button .wpbf-button",
		cssProps: "font-size",
		useValueSuffix: true,
	});

	listenToCustomizerValueChange<string | number>(
		"wpbf_header_builder_mobile_button_border_radius",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-mobile-header-button .wpbf-button",
				props: { "border-radius": maybeAppendSuffix(value) },
			});
		},
	);

	listenToCustomizerValueChange<string | number>(
		"wpbf_header_builder_mobile_button_border_width",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-mobile-header-button .wpbf-button",
				props: { "border-width": maybeAppendSuffix(value) },
			});
		},
	);

	// Note: Search icon settings (color, size) are handled in header-builder-search.ts
	// using the correct .wpbff-search selector and multicolor control type.

	// Menu trigger settings.
	listenToCustomizerValueChange<string | number>(
		"wpbf_header_builder_mobile_menu_trigger_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-mobile-menu-toggle",
				props: { "font-size": maybeAppendSuffix(value) },
			});
		},
	);

	listenToCustomizerValueChange<WpbfColorControlValue>(
		"wpbf_header_builder_mobile_menu_trigger_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".wpbf-mobile-menu-toggle, .wpbf-mobile-menu-toggle .wpbf-mobile-menu-toggle-icon",
				props: { color: toStringColor(value) },
			});
		},
	);
}
