import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
	writeResponsiveCSSMultiSelector,
} from "../customizer-util";
import { parseJsonOrUndefined } from "../../../../Customizer/Controls/Generic/src/string-util";
import {
	WpbfColorControlValue,
	WpbfMulticolorControlValue,
} from "../../../../Customizer/Controls/Color/src/color-interface";
import { MarginPaddingValue } from "../../../../Customizer/Controls/MarginPadding/src/margin-padding-interface";

export default function footerBuilderRowsSetup() {
	const footerBuilderDesktopRows = [
		"desktop_row_1",
		"desktop_row_2",
		"desktop_row_3",
	];
	const footerBuilderMobileRows = [
		"mobile_row_1",
		"mobile_row_2",
		"mobile_row_3",
	];

	/**
	 * Desktop rows postmessage handlers.
	 *
	 * All rows (Top, Main, Bottom) now have their own controls.
	 */
	footerBuilderDesktopRows.forEach((rowKey) => {
		const controlIdPrefix = `wpbf_footer_builder_${rowKey}_`;

		// Max width (container width)
		listenToCustomizerValueChange<string | number>(
			`${controlIdPrefix}max_width`,
			(settingId, value) => {
				writeCSS(settingId, {
					selector: `.wpbf-footer-row-${rowKey} .wpbf-container`,
					props: { "max-width": maybeAppendSuffix(value) },
				});
			},
		);

		// Vertical padding
		listenToCustomizerValueChange<string | number>(
			`${controlIdPrefix}vertical_padding`,
			function (settingId, value) {
				writeCSS(settingId, {
					selector: `.wpbf-footer-row-${rowKey} .wpbf-row-content`,
					props: {
						"padding-top": maybeAppendSuffix(value),
						"padding-bottom": maybeAppendSuffix(value),
					},
				});
			},
		);

		// Column gap
		listenToCustomizerValueChange<string | number>(
			`${controlIdPrefix}column_gap`,
			function (settingId, value) {
				writeCSS(settingId, {
					selector: `.wpbf-footer-row-${rowKey} .wpbf-row-content, .wpbf-footer-row-${rowKey} .wpbf-builder-zone`,
					props: {
						gap: maybeAppendSuffix(value),
					},
				});
			},
		);

		// Column alignment (per-column)
		const columnKeys = [
			"column_1_start",
			"column_1_end",
			"column_2",
			"column_3_start",
			"column_3_end",
		];

		columnKeys.forEach((columnKey) => {
			listenToCustomizerValueChange<string>(
				`${controlIdPrefix}${columnKey}_align`,
				function (settingId, value) {
					if (!value || value === "default") {
						writeCSS(settingId, {
							selector: `.wpbf-footer-row-${rowKey} .wpbf-builder-column-${columnKey}`,
							props: {
								"justify-content": "",
								"text-align": "",
							},
						});
						return;
					}

					let justify = "flex-start";
					let textAlign = "left";

					if (value === "center") {
						justify = "center";
						textAlign = "center";
					} else if (value === "end" || value === "right") {
						justify = "flex-end";
						textAlign = "right";
					} else if (value === "space-between") {
						justify = "space-between";
						textAlign = "inherit";
					}

					writeCSS(settingId, {
						selector: `.wpbf-footer-row-${rowKey} .wpbf-builder-column-${columnKey}`,
						props: {
							"justify-content": justify,
							"text-align": textAlign,
						},
					});
				},
			);
		});

		// Background color
		listenToCustomizerValueChange<WpbfColorControlValue>(
			`${controlIdPrefix}bg_color`,
			function (settingId, value) {
				writeCSS(settingId, {
					selector: `.wpbf-footer-row-${rowKey}`,
					props: { "background-color": toStringColor(value) },
				});
			},
		);

		// Text color / Font color
		listenToCustomizerValueChange<WpbfColorControlValue>(
			`${controlIdPrefix}text_color`,
			function (settingId, value) {
				writeCSS(settingId, {
					selector: `.wpbf-footer-row-${rowKey}`,
					props: { color: toStringColor(value) },
				});
			},
		);

		// Accent colors
		listenToCustomizerValueChange<WpbfMulticolorControlValue>(
			`${controlIdPrefix}accent_colors`,
			(settingId, value) => {
				const rawDefaultColor = value.default ?? "";
				const defaultColor = toStringColor(rawDefaultColor);

				const rawHoverColor = value.hover ?? "";
				const hoverColor = toStringColor(rawHoverColor);

				writeCSS(settingId, {
					blocks: [
						{
							selector: `.wpbf-footer-row-${rowKey} a`,
							props: { color: defaultColor },
						},
						{
							selector: `.wpbf-footer-row-${rowKey} a:hover, .wpbf-footer-row-${rowKey} a:focus`,
							props: { color: hoverColor },
						},
					],
				});
			},
		);

		// Font size
		listenToCustomizerValueChange<string | number>(
			`${controlIdPrefix}font_size`,
			(settingId, value) => {
				writeCSS(settingId, {
					selector: `.wpbf-footer-row-${rowKey}`,
					props: { "font-size": maybeAppendSuffix(value) },
				});
			},
		);

		// Border top - helper function to get current scope and update CSS
		const updateBorderTop = (settingIdBase: string) => {
			const borderWidth = window.wp
				?.customize?.(`${controlIdPrefix}border_top_width`)
				?.get() as string | number | undefined;
			const borderStyle = window.wp
				?.customize?.(`${controlIdPrefix}border_top_style`)
				?.get() as string | undefined;
			const borderColor = window.wp
				?.customize?.(`${controlIdPrefix}border_top_color`)
				?.get() as string | undefined;
			const borderScope = window.wp
				?.customize?.(`${controlIdPrefix}border_top_scope`)
				?.get() as string | undefined;

			const selector =
				borderScope === "fullwidth"
					? `.wpbf-footer-row-${rowKey}`
					: `.wpbf-footer-row-${rowKey} .wpbf-container`;

			// Clear border for both selectors first, then apply to the correct one
			writeCSS(`${settingIdBase}_combined`, {
				blocks: [
					{
						selector: `.wpbf-footer-row-${rowKey}`,
						props: {
							"border-top-style": "none",
						},
					},
					{
						selector: `.wpbf-footer-row-${rowKey} .wpbf-container`,
						props: {
							"border-top-style": "none",
						},
					},
				],
			});

			if (borderStyle && borderStyle !== "none" && borderWidth) {
				writeCSS(`${settingIdBase}_applied`, {
					selector,
					props: {
						"border-top-width": maybeAppendSuffix(borderWidth),
						"border-top-style": borderStyle,
						"border-top-color": borderColor
							? toStringColor(borderColor)
							: "currentColor",
					},
				});
			} else {
				// Clear the applied styles when border is removed
				writeCSS(`${settingIdBase}_applied`, {
					selector,
					props: {
						"border-top-style": "none",
					},
				});
			}
		};

		// Border top width
		listenToCustomizerValueChange<string | number>(
			`${controlIdPrefix}border_top_width`,
			() => updateBorderTop(`${controlIdPrefix}border_top`),
		);

		// Border top style
		listenToCustomizerValueChange<string>(
			`${controlIdPrefix}border_top_style`,
			() => updateBorderTop(`${controlIdPrefix}border_top`),
		);

		// Border top color
		listenToCustomizerValueChange<WpbfColorControlValue>(
			`${controlIdPrefix}border_top_color`,
			() => updateBorderTop(`${controlIdPrefix}border_top`),
		);

		// Border top scope
		listenToCustomizerValueChange<string>(
			`${controlIdPrefix}border_top_scope`,
			() => updateBorderTop(`${controlIdPrefix}border_top`),
		);
	});

	/**
	 * Mobile rows postmessage handlers.
	 *
	 * Mobile rows don't have max_width control (following header builder pattern).
	 */
	footerBuilderMobileRows.forEach((rowKey) => {
		const controlIdPrefix = `wpbf_footer_builder_${rowKey}_`;

		// Vertical padding
		listenToCustomizerValueChange<string | number>(
			`${controlIdPrefix}vertical_padding`,
			function (settingId, value) {
				writeCSS(settingId, {
					selector: `.wpbf-footer-row-${rowKey} .wpbf-row-content`,
					props: {
						"padding-top": maybeAppendSuffix(value),
						"padding-bottom": maybeAppendSuffix(value),
					},
				});
			},
		);

		// Column gap
		listenToCustomizerValueChange<string | number>(
			`${controlIdPrefix}column_gap`,
			function (settingId, value) {
				writeCSS(settingId, {
					selector: `.wpbf-footer-row-${rowKey} .wpbf-row-content, .wpbf-footer-row-${rowKey} .wpbf-builder-zone`,
					props: {
						gap: maybeAppendSuffix(value),
					},
				});
			},
		);

		// Column alignment (per-column)
		const columnKeys = [
			"column_1_start",
			"column_1_end",
			"column_2",
			"column_3_start",
			"column_3_end",
		];

		columnKeys.forEach((columnKey) => {
			listenToCustomizerValueChange<string>(
				`${controlIdPrefix}${columnKey}_align`,
				function (settingId, value) {
					if (!value || value === "default") {
						writeCSS(settingId, {
							selector: `.wpbf-footer-row-${rowKey} .wpbf-builder-column-${columnKey}`,
							props: {
								"justify-content": "",
								"text-align": "",
							},
						});
						return;
					}

					let justify = "flex-start";
					let textAlign = "left";

					if (value === "center") {
						justify = "center";
						textAlign = "center";
					} else if (value === "end" || value === "right") {
						justify = "flex-end";
						textAlign = "right";
					} else if (value === "space-between") {
						justify = "space-between";
						textAlign = "inherit";
					}

					writeCSS(settingId, {
						selector: `.wpbf-footer-row-${rowKey} .wpbf-builder-column-${columnKey}`,
						props: {
							"justify-content": justify,
							"text-align": textAlign,
						},
					});
				},
			);
		});

		// Background color
		listenToCustomizerValueChange<WpbfColorControlValue>(
			`${controlIdPrefix}bg_color`,
			function (settingId, value) {
				writeCSS(settingId, {
					selector: `.wpbf-footer-row-${rowKey}`,
					props: { "background-color": toStringColor(value) },
				});
			},
		);

		// Text color / Font color
		listenToCustomizerValueChange<WpbfColorControlValue>(
			`${controlIdPrefix}text_color`,
			function (settingId, value) {
				writeCSS(settingId, {
					selector: `.wpbf-footer-row-${rowKey}`,
					props: { color: toStringColor(value) },
				});
			},
		);

		// Accent colors
		listenToCustomizerValueChange<WpbfMulticolorControlValue>(
			`${controlIdPrefix}accent_colors`,
			(settingId, value) => {
				const rawDefaultColor = value.default ?? "";
				const defaultColor = toStringColor(rawDefaultColor);

				const rawHoverColor = value.hover ?? "";
				const hoverColor = toStringColor(rawHoverColor);

				writeCSS(settingId, {
					blocks: [
						{
							selector: `.wpbf-footer-row-${rowKey} a`,
							props: { color: defaultColor },
						},
						{
							selector: `.wpbf-footer-row-${rowKey} a:hover, .wpbf-footer-row-${rowKey} a:focus`,
							props: { color: hoverColor },
						},
					],
				});
			},
		);

		// Font size
		listenToCustomizerValueChange<string | number>(
			`${controlIdPrefix}font_size`,
			(settingId, value) => {
				writeCSS(settingId, {
					selector: `.wpbf-footer-row-${rowKey}`,
					props: { "font-size": maybeAppendSuffix(value) },
				});
			},
		);

		// Border top - helper function to get current scope and update CSS
		const updateBorderTop = (settingIdBase: string) => {
			const borderWidth = window.wp
				?.customize?.(`${controlIdPrefix}border_top_width`)
				?.get() as string | number | undefined;
			const borderStyle = window.wp
				?.customize?.(`${controlIdPrefix}border_top_style`)
				?.get() as string | undefined;
			const borderColor = window.wp
				?.customize?.(`${controlIdPrefix}border_top_color`)
				?.get() as string | undefined;
			const borderScope = window.wp
				?.customize?.(`${controlIdPrefix}border_top_scope`)
				?.get() as string | undefined;

			const selector =
				borderScope === "fullwidth"
					? `.wpbf-footer-row-${rowKey}`
					: `.wpbf-footer-row-${rowKey} .wpbf-container`;

			// Clear border for both selectors first, then apply to the correct one
			writeCSS(`${settingIdBase}_combined`, {
				blocks: [
					{
						selector: `.wpbf-footer-row-${rowKey}`,
						props: {
							"border-top-style": "none",
						},
					},
					{
						selector: `.wpbf-footer-row-${rowKey} .wpbf-container`,
						props: {
							"border-top-style": "none",
						},
					},
				],
			});

			if (borderStyle && borderStyle !== "none" && borderWidth) {
				writeCSS(`${settingIdBase}_applied`, {
					selector,
					props: {
						"border-top-width": maybeAppendSuffix(borderWidth),
						"border-top-style": borderStyle,
						"border-top-color": borderColor
							? toStringColor(borderColor)
							: "currentColor",
					},
				});
			} else {
				// Clear the applied styles when border is removed
				writeCSS(`${settingIdBase}_applied`, {
					selector,
					props: {
						"border-top-style": "none",
					},
				});
			}
		};

		// Border top width
		listenToCustomizerValueChange<string | number>(
			`${controlIdPrefix}border_top_width`,
			() => updateBorderTop(`${controlIdPrefix}border_top`),
		);

		// Border top style
		listenToCustomizerValueChange<string>(
			`${controlIdPrefix}border_top_style`,
			() => updateBorderTop(`${controlIdPrefix}border_top`),
		);

		// Border top color
		listenToCustomizerValueChange<WpbfColorControlValue>(
			`${controlIdPrefix}border_top_color`,
			() => updateBorderTop(`${controlIdPrefix}border_top`),
		);

		// Border top scope
		listenToCustomizerValueChange<string>(
			`${controlIdPrefix}border_top_scope`,
			() => updateBorderTop(`${controlIdPrefix}border_top`),
		);
	});

	/**
	 * Logo widget postmessage handlers.
	 */

	// Desktop logo width
	listenToCustomizerValueChange<string | number>(
		"wpbf_footer_builder_desktop_logo_width",
		(settingId, value) => {
			writeCSS(settingId, {
				selector: ".wpbf-footer-desktop .wpbf-footer-logo img",
				props: { width: maybeAppendSuffix(value) },
			});
		},
	);

	// Mobile logo width
	listenToCustomizerValueChange<string | number>(
		"wpbf_footer_builder_mobile_logo_width",
		(settingId, value) => {
			writeCSS(settingId, {
				selector: ".wpbf-footer-mobile .wpbf-footer-logo img",
				props: { width: maybeAppendSuffix(value) },
			});
		},
	);

	/**
	 * HTML widget content is handled via partialRefresh (server-side)
	 * to support shortcode processing (e.g., [social]).
	 * No client-side postMessage handler is needed for content.
	 */

	/**
	 * Widget title postmessage handlers.
	 *
	 * These handlers update the widget title text directly via postMessage
	 * for instant preview without page refresh.
	 */
	const footerBuilderWidgetTitleKeys = [
		"desktop_menu_1",
		"desktop_menu_2",
		"desktop_html_1",
		"desktop_html_2",
		"mobile_menu_1",
		"mobile_menu_2",
		"mobile_html_1",
		"mobile_html_2",
	];

	footerBuilderWidgetTitleKeys.forEach((widgetKey) => {
		const controlIdPrefix = `wpbf_footer_builder_${widgetKey}`;

		listenToCustomizerValueChange<string>(
			`${controlIdPrefix}_widget_title`,
			function (settingId, value) {
				const titleElement = document.querySelector(
					`.wpbf-footer-widget-title-${widgetKey}`,
				);
				if (titleElement instanceof HTMLElement) {
					titleElement.textContent = value;
					titleElement.style.display = value ? "" : "none";
				}
			},
		);
	});

	/**
	 * Menu widget postmessage handlers.
	 */
	const footerBuilderMenuWidgetKeys = [
		"desktop_menu_1",
		"desktop_menu_2",
		"mobile_menu_1",
		"mobile_menu_2",
	];

	footerBuilderMenuWidgetKeys.forEach((widgetKey) => {
		const controlIdPrefix = `wpbf_footer_builder_${widgetKey}_`;

		// Item spacing
		listenToCustomizerValueChange<string | number>(
			`${controlIdPrefix}item_spacing`,
			(settingId, value) => {
				writeCSS(settingId, {
					selector: `.wpbf-footer-menu.${widgetKey} a`,
					props: {
						"padding-top": maybeAppendSuffix(value),
						"padding-bottom": maybeAppendSuffix(value),
					},
				});
			},
		);

		// Link colors
		listenToCustomizerValueChange<WpbfMulticolorControlValue>(
			`${controlIdPrefix}link_colors`,
			(settingId, value) => {
				const rawDefaultColor = value.default ?? "";
				const defaultColor = toStringColor(rawDefaultColor);

				const rawHoverColor = value.hover ?? "";
				const hoverColor = toStringColor(rawHoverColor);

				writeCSS(settingId, {
					blocks: [
						{
							selector: `.wpbf-footer-menu.${widgetKey} a`,
							props: { color: defaultColor },
						},
						{
							selector: `.wpbf-footer-menu.${widgetKey} a:hover, .wpbf-footer-menu.${widgetKey} a:focus`,
							props: { color: hoverColor },
						},
					],
				});
			},
		);
	});

	/**
	 * Widget responsive padding postmessage handlers.
	 */
	const widgetPaddingConfigs: { settingId: string; selector: string }[] = [
		{ settingId: "wpbf_footer_builder_desktop_menu_1_padding", selector: ".wpbf-footer-menu-widget-desktop_menu_1" },
		{ settingId: "wpbf_footer_builder_desktop_menu_2_padding", selector: ".wpbf-footer-menu-widget-desktop_menu_2" },
		{ settingId: "wpbf_footer_builder_mobile_menu_1_padding", selector: ".wpbf-footer-menu-widget-mobile_menu_1" },
		{ settingId: "wpbf_footer_builder_mobile_menu_2_padding", selector: ".wpbf-footer-menu-widget-mobile_menu_2" },
		{ settingId: "wpbf_footer_builder_desktop_html_1_padding", selector: ".wpbf-footer-html-widget-wrapper-desktop_html_1" },
		{ settingId: "wpbf_footer_builder_desktop_html_2_padding", selector: ".wpbf-footer-html-widget-wrapper-desktop_html_2" },
		{ settingId: "wpbf_footer_builder_mobile_html_1_padding", selector: ".wpbf-footer-html-widget-wrapper-mobile_html_1" },
		{ settingId: "wpbf_footer_builder_mobile_html_2_padding", selector: ".wpbf-footer-html-widget-wrapper-mobile_html_2" },
		{ settingId: "wpbf_footer_builder_desktop_social_padding", selector: ".wpbf-footer-social.wpbf_footer_builder_desktop_social" },
		{ settingId: "wpbf_footer_builder_mobile_social_padding", selector: ".wpbf-footer-social.wpbf_footer_builder_mobile_social" },
		{ settingId: "wpbf_footer_builder_desktop_copyright_padding", selector: ".wpbf-footer-copyright.wpbf_footer_builder_desktop_copyright" },
		{ settingId: "wpbf_footer_builder_mobile_copyright_padding", selector: ".wpbf-footer-copyright.wpbf_footer_builder_mobile_copyright" },
	];

	widgetPaddingConfigs.forEach(({ settingId, selector }) => {
		listenToCustomizerValueChange<string | MarginPaddingValue>(
			settingId,
			function (id, value) {
				const obj = parseJsonOrUndefined<MarginPaddingValue>(value);

				writeResponsiveCSSMultiSelector(id, {
					desktop: {
						selector,
						props: {
							"padding-top": maybeAppendSuffix(obj?.desktop_top),
							"padding-right": maybeAppendSuffix(obj?.desktop_right),
							"padding-bottom": maybeAppendSuffix(obj?.desktop_bottom),
							"padding-left": maybeAppendSuffix(obj?.desktop_left),
						},
					},
					tablet: {
						selector,
						props: {
							"padding-top": maybeAppendSuffix(obj?.tablet_top),
							"padding-right": maybeAppendSuffix(obj?.tablet_right),
							"padding-bottom": maybeAppendSuffix(obj?.tablet_bottom),
							"padding-left": maybeAppendSuffix(obj?.tablet_left),
						},
					},
					mobile: {
						selector,
						props: {
							"padding-top": maybeAppendSuffix(obj?.mobile_top),
							"padding-right": maybeAppendSuffix(obj?.mobile_right),
							"padding-bottom": maybeAppendSuffix(obj?.mobile_bottom),
							"padding-left": maybeAppendSuffix(obj?.mobile_left),
						},
					},
				});
			},
		);
	});
}
