import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
} from "../customizer-util";
import { parseJsonOrUndefined } from "../../../../Customizer/Controls/Generic/src/string-util";
import {
	WpbfColorControlValue,
	WpbfMulticolorControlValue,
} from "../../../../Customizer/Controls/Color/src/color-interface";
import { MarginPaddingValue } from "../../../../Customizer/Controls/MarginPadding/src/margin-padding-interface";

export default function mobileHeaderBuilderRowsSetup() {
	const mobileHeaderBuilderRows = [
		"mobile_row_1",
		"mobile_row_2",
		"mobile_row_3",
	];

	mobileHeaderBuilderRows.forEach((rowKey) => {
		const controlIdPrefix = `wpbf_header_builder_${rowKey}_`;

		if (rowKey === "mobile_row_1") {
			// vertical padding
			listenToCustomizerValueChange<number | string>(
				`${controlIdPrefix}vertical_padding`,
				function (settingId: string, value: number | string) {
					writeCSS(settingId, {
						selector: ".wpbf-mobile-header-rows .wpbf-inner-pre-header",
						props: {
							"padding-top": maybeAppendSuffix(value),
							"padding-bottom": maybeAppendSuffix(value),
						},
					});
				},
			);

			// bg color
			listenToCustomizerValueChange<WpbfColorControlValue>(
				`${controlIdPrefix}bg_color`,
				function (settingId: string, value: WpbfColorControlValue) {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey}`,
						props: { "background-color": toStringColor(value) },
					});
				},
			);

			// text color / font color
			listenToCustomizerValueChange<WpbfColorControlValue>(
				`${controlIdPrefix}text_color`,
				function (settingId: string, value: WpbfColorControlValue) {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey}`,
						props: { color: toStringColor(value) },
					});
				},
			);

			// Accent colors
			listenToCustomizerValueChange<WpbfMulticolorControlValue>(
				`${controlIdPrefix}accent_colors`,
				function (settingId: string, value: WpbfMulticolorControlValue) {
					const defaultColor = toStringColor(value?.default ?? "");
					const hoverColor = toStringColor(value?.hover ?? "");

					writeCSS(settingId, {
						blocks: [
							{
								selector: `.wpbf-header-row-${rowKey} a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2)`,
								props: { color: defaultColor },
							},
							{
								selector: `.wpbf-header-row-${rowKey} a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2):hover, .wpbf-header-row-${rowKey} a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2):focus`,
								props: { color: hoverColor },
							},
						],
					});
				},
			);

			// font size
			listenToCustomizerValueChange<string | number>(
				`${controlIdPrefix}font_size`,
				function (settingId: string, value: string | number) {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey}, .wpbf-header-row-${rowKey} .wpbf-mobile-menu a, .wpbf-header-row-${rowKey} .wpbf-menu a`,
						props: { "font-size": maybeAppendSuffix(value) },
					});
				},
			);

			// vertical padding
			listenToCustomizerValueChange<number | string>(
				`${controlIdPrefix}vertical_padding`,
				function (settingId: string, value: number | string) {
					const selector = `.wpbf-header-row-${rowKey}`;
					writeCSS(settingId, {
						selector: selector,
						props: {
							"padding-top": maybeAppendSuffix(value),
							"padding-bottom": maybeAppendSuffix(value),
						},
					});
				},
			);
		}

		if (rowKey === "mobile_row_2") {
			// bg color
			listenToCustomizerValueChange<WpbfColorControlValue>(
				`${controlIdPrefix}bg_color`,
				function (settingId: string, value: WpbfColorControlValue) {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey}`,
						props: { "background-color": toStringColor(value) },
					});
				},
			);

			// text color / font color
			listenToCustomizerValueChange<WpbfColorControlValue>(
				`${controlIdPrefix}text_color`,
				function (settingId: string, value: WpbfColorControlValue) {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey}`,
						props: { color: toStringColor(value) },
					});
				},
			);

			// Accent colors
			listenToCustomizerValueChange<WpbfMulticolorControlValue>(
				`${controlIdPrefix}accent_colors`,
				function (settingId: string, value: WpbfMulticolorControlValue) {
					const defaultColor = toStringColor(value?.default ?? "");
					const hoverColor = toStringColor(value?.hover ?? "");

					writeCSS(settingId, {
						blocks: [
							{
								selector: `.wpbf-header-row-${rowKey} a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2)`,
								props: { color: defaultColor },
							},
							{
								selector: `.wpbf-header-row-${rowKey} a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2):hover, .wpbf-header-row-${rowKey} a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2):focus`,
								props: { color: hoverColor },
							},
						],
					});
				},
			);

			// font size
			listenToCustomizerValueChange<string | number>(
				`${controlIdPrefix}font_size`,
				function (settingId: string, value: string | number) {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey}, .wpbf-header-row-${rowKey} .wpbf-mobile-menu a, .wpbf-header-row-${rowKey} .wpbf-menu a`,
						props: { "font-size": maybeAppendSuffix(value) },
					});
				},
			);

			// vertical padding
			listenToCustomizerValueChange<number | string>(
				`${controlIdPrefix}vertical_padding`,
				function (settingId: string, value: number | string) {
					const selector = `.wpbf-header-row-${rowKey}`;
					writeCSS(settingId, {
						selector: selector,
						props: {
							"padding-top": maybeAppendSuffix(value),
							"padding-bottom": maybeAppendSuffix(value),
						},
					});
				},
			);
		}

		if (rowKey === "mobile_row_3") {
			// bg color
			listenToCustomizerValueChange<WpbfColorControlValue>(
				`${controlIdPrefix}bg_color`,
				function (settingId: string, value: WpbfColorControlValue) {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey}`,
						props: { "background-color": toStringColor(value) },
					});
				},
			);

			// text color / font color
			listenToCustomizerValueChange<WpbfColorControlValue>(
				`${controlIdPrefix}text_color`,
				function (settingId: string, value: WpbfColorControlValue) {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey}`,
						props: { color: toStringColor(value) },
					});
				},
			);

			// Accent colors
			listenToCustomizerValueChange<WpbfMulticolorControlValue>(
				`${controlIdPrefix}accent_colors`,
				function (settingId: string, value: WpbfMulticolorControlValue) {
					const defaultColor = toStringColor(value?.default ?? "");
					const hoverColor = toStringColor(value?.hover ?? "");

					writeCSS(settingId, {
						blocks: [
							{
								selector: `.wpbf-header-row-${rowKey} a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2)`,
								props: { color: defaultColor },
							},
							{
								selector: `.wpbf-header-row-${rowKey} a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2):hover, .wpbf-header-row-${rowKey} a:not(.wpbf_header_builder_mobile_button_1):not(.wpbf_header_builder_mobile_button_2):focus`,
								props: { color: hoverColor },
							},
						],
					});
				},
			);

			// font size
			listenToCustomizerValueChange<string | number>(
				`${controlIdPrefix}font_size`,
				function (settingId: string, value: string | number) {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey}, .wpbf-header-row-${rowKey} .wpbf-mobile-menu a, .wpbf-header-row-${rowKey} .wpbf-menu a`,
						props: { "font-size": maybeAppendSuffix(value) },
					});
				},
			);

			// vertical padding
			listenToCustomizerValueChange<number | string>(
				`${controlIdPrefix}vertical_padding`,
				function (settingId: string, value: number | string) {
					const selector = `.wpbf-header-row-${rowKey}`;
					writeCSS(settingId, {
						selector: selector,
						props: {
							"padding-top": maybeAppendSuffix(value),
							"padding-bottom": maybeAppendSuffix(value),
						},
					});
				},
			);
		}

		// Mobile overlay color.
		listenToCustomizerValueChange<WpbfColorControlValue>(
			"mobile_menu_overlay_color",
			function (settingId: string, value: WpbfColorControlValue) {
				writeCSS(settingId, {
					selector: ".wpbf-mobile-menu-overlay",
					props: { "background-color": toStringColor(value) },
				});
			},
		);
	});

	// Desktop menu 2 padding.
	listenToCustomizerValueChange<number | string>(
		"wpbf_header_builder_desktop_menu_2_menu_padding",
		function (settingId: string, value: number | string) {
			writeCSS(settingId, {
				selector: ".wpbf-menu.desktop_menu_2 > .menu-item > a",
				props: {
					"padding-left": maybeAppendSuffix(value),
					"padding-right": maybeAppendSuffix(value),
				},
			});
		},
	);

	// Desktop menu 2 font size.
	listenToCustomizerValueChange<number | string>(
		"wpbf_header_builder_desktop_menu_2_menu_font_size",
		function (settingId: string, value: number | string) {
			writeCSS(settingId, {
				selector: ".wpbf-menu.desktop_menu_2 > .menu-item > a",
				props: {
					"font-size": maybeAppendSuffix(value),
				},
			});
		},
	);

	// Mobile menu 2 padding.
	listenToCustomizerValueChange<string>(
		"wpbf_header_builder_mobile_menu_2_menu_padding",
		function (settingId: string, value: string) {
			const obj = parseJsonOrUndefined<MarginPaddingValue>(value);

			if (!obj) {
				// Handle simple value (for backward compatibility)
				writeCSS(settingId, {
					selector: ".wpbf-menu.mobile_menu_2 > .menu-item > a",
					props: {
						"padding-top": maybeAppendSuffix(value as string),
						"padding-right": maybeAppendSuffix(value as string),
						"padding-bottom": maybeAppendSuffix(value as string),
						"padding-left": maybeAppendSuffix(value as string),
					},
				});
				return;
			}

			writeCSS(settingId, {
				selector:
					".wpbf-menu.mobile_menu_2 > .menu-item > a, .wpbf-mobile-menu.mobile_menu_2 > .menu-item > a",
				props: {
					"padding-top": maybeAppendSuffix(obj.top.toString()),
					"padding-right": maybeAppendSuffix(obj.right.toString()),
					"padding-bottom": maybeAppendSuffix(obj.bottom.toString()),
					"padding-left": maybeAppendSuffix(obj.left.toString()),
				},
			});
		},
	);
}
