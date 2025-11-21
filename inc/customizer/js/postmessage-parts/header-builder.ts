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

export default function headerBuilderSetup() {
	// Row visibility.
	const rows = ["top", "main", "bottom"];

	rows.forEach((row) => {
		listenToCustomizerValueChange<WpbfCheckboxButtonsetResponsiveValue>(
			`wpbf_header_builder_${row}_row_visibility`,
			function (settingId, value) {
				const selector = `.wpbf-header-row-desktop_row_${row === "top" ? "1" : row === "main" ? "2" : "3"}`;

				writeCSS(settingId, {
					selector: selector,
					props: {
						display: value.desktop ? "block" : "none",
					},
				});
			},
		);
	});

	// Button settings.
	listenToCustomizerValueChange<WpbfMulticolorControlValue>(
		"wpbf_header_builder_button_color",
		function (settingId, value) {
			const rawDefaultColor = value.default ?? "";
			const defaultColor = toStringColor(rawDefaultColor);

			const rawHoverColor = value.hover ?? "";
			const hoverColor = toStringColor(rawHoverColor);

			writeCSS(settingId, {
				blocks: [
					{
						selector: ".wpbf-header-button .wpbf-button",
						props: {
							"background-color": defaultColor,
							"border-color": defaultColor,
						},
					},
					{
						selector: ".wpbf-header-button .wpbf-button:hover",
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
		"wpbf_header_builder_button_text_color",
		function (settingId, value) {
			const rawDefaultColor = value.default ?? "";
			const defaultColor = toStringColor(rawDefaultColor);

			const rawHoverColor = value.hover ?? "";
			const hoverColor = toStringColor(rawHoverColor);

			writeCSS(settingId, {
				blocks: [
					{
						selector: ".wpbf-header-button .wpbf-button",
						props: { color: defaultColor },
					},
					{
						selector: ".wpbf-header-button .wpbf-button:hover",
						props: { color: hoverColor },
					},
				],
			});
		},
	);

	listenToBuilderResponsiveControl({
		controlId: "wpbf_header_builder_button_width",
		cssSelector: ".wpbf-header-button .wpbf-button",
		cssProps: "width",
		useValueSuffix: true,
	});

	listenToBuilderResponsiveControl({
		controlId: "wpbf_header_builder_button_font_size",
		cssSelector: ".wpbf-header-button .wpbf-button",
		cssProps: "font-size",
		useValueSuffix: true,
	});

	listenToCustomizerValueChange<string | number>(
		"wpbf_header_builder_button_border_radius",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-header-button .wpbf-button",
				props: { "border-radius": maybeAppendSuffix(value) },
			});
		},
	);

	listenToCustomizerValueChange<string | number>(
		"wpbf_header_builder_button_border_width",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-header-button .wpbf-button",
				props: { "border-width": maybeAppendSuffix(value) },
			});
		},
	);

	// Search icon settings.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"wpbf_header_builder_search_icon_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-header-search-icon svg",
				props: { color: toStringColor(value) },
			});
		},
	);

	listenToCustomizerValueChange<WpbfColorControlValue>(
		"wpbf_header_builder_search_icon_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-header-search-icon:hover svg",
				props: { color: toStringColor(value) },
			});
		},
	);

	listenToCustomizerValueChange<string | number>(
		"wpbf_header_builder_search_icon_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-header-search-icon svg",
				props: {
					width: maybeAppendSuffix(value),
					height: maybeAppendSuffix(value),
				},
			});
		},
	);
}
