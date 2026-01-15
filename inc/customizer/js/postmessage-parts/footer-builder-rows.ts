import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
} from "../customizer-util";
import {
	WpbfColorControlValue,
	WpbfMulticolorControlValue,
} from "../../../../Customizer/Controls/Color/src/color-interface";

export default function footerBuilderRowsSetup() {
	const footerBuilderDesktopRows = ["desktop_row_1", "desktop_row_2", "desktop_row_3"];
	const footerBuilderMobileRows = ["mobile_row_1", "mobile_row_2", "mobile_row_3"];

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
			const borderWidth = window.wp?.customize?.(
				`${controlIdPrefix}border_top_width`,
			)?.get() as string | number | undefined;
			const borderStyle = window.wp?.customize?.(
				`${controlIdPrefix}border_top_style`,
			)?.get() as string | undefined;
			const borderColor = window.wp?.customize?.(
				`${controlIdPrefix}border_top_color`,
			)?.get() as string | undefined;
			const borderScope = window.wp?.customize?.(
				`${controlIdPrefix}border_top_scope`,
			)?.get() as string | undefined;

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
							"border-top-width": "",
							"border-top-style": "",
							"border-top-color": "",
						},
					},
					{
						selector: `.wpbf-footer-row-${rowKey} .wpbf-container`,
						props: {
							"border-top-width": "",
							"border-top-style": "",
							"border-top-color": "",
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
						"border-top-width": "",
						"border-top-style": "",
						"border-top-color": "",
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
			const borderWidth = window.wp?.customize?.(
				`${controlIdPrefix}border_top_width`,
			)?.get() as string | number | undefined;
			const borderStyle = window.wp?.customize?.(
				`${controlIdPrefix}border_top_style`,
			)?.get() as string | undefined;
			const borderColor = window.wp?.customize?.(
				`${controlIdPrefix}border_top_color`,
			)?.get() as string | undefined;
			const borderScope = window.wp?.customize?.(
				`${controlIdPrefix}border_top_scope`,
			)?.get() as string | undefined;

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
							"border-top-width": "",
							"border-top-style": "",
							"border-top-color": "",
						},
					},
					{
						selector: `.wpbf-footer-row-${rowKey} .wpbf-container`,
						props: {
							"border-top-width": "",
							"border-top-style": "",
							"border-top-color": "",
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
						"border-top-width": "",
						"border-top-style": "",
						"border-top-color": "",
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
	 * HTML widget postmessage handlers.
	 *
	 * These handlers update the HTML widget content directly via postMessage
	 * instead of using partialRefresh, which would reload the entire footer.
	 */
	const footerBuilderHtmlWidgetKeys = [
		"desktop_html_1",
		"desktop_html_2",
		"mobile_html_1",
		"mobile_html_2",
	];

	footerBuilderHtmlWidgetKeys.forEach((widgetKey) => {
		const controlIdPrefix = `wpbf_footer_builder_${widgetKey}`;

		listenToCustomizerValueChange<string>(
			`${controlIdPrefix}_content`,
			function (settingId, value) {
				const widget = document.querySelector(`.${controlIdPrefix}`);
				if (!(widget instanceof HTMLElement)) return;
				widget.innerHTML = value;
			},
		);
	});

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
}
