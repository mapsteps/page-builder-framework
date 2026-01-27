import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
} from "../customizer-util";
import { WpbfCustomizeSetting } from "../../../../Customizer/Controls/Base/src/base-interface";
import { WpbfCheckboxButtonsetControlValue } from "../../../../Customizer/Controls/Checkbox/src/checkbox-interface";
import {
	WpbfColorControlValue,
	WpbfMulticolorControlValue,
} from "../../../../Customizer/Controls/Color/src/color-interface";

export default function headerBuilderRowsSetup(customizer: WpbfCustomize) {
	const headerBuilderRows = ["desktop_row_1", "desktop_row_2", "desktop_row_3"];

	headerBuilderRows.forEach((rowKey) => {
		const controlIdPrefix = `wpbf_header_builder_${rowKey}_`;

		const visibilitySettingId = `${controlIdPrefix}visibility`;

		customizer?.(
			visibilitySettingId,
			(value: WpbfCustomizeSetting<WpbfCheckboxButtonsetControlValue>) => {
				const availableSizes = ["large", "medium", "small"];

				value.bind(function (newValue: WpbfCheckboxButtonsetControlValue) {
					if (!newValue || !Array.isArray(newValue)) return;

					const selector =
						rowKey === "desktop_row_1"
							? ".wpbf-pre-header"
							: `.wpbf-header-row-${rowKey}`;

					const el = document.querySelector(selector);
					if (!el) return;

					availableSizes.forEach(function (size) {
						if (newValue.includes(size)) {
							el.classList.remove(`wpbf-hidden-${size}`);
						} else {
							el.classList.add(`wpbf-hidden-${size}`);
						}
					});
				});
			},
		);

		/**
		 * These fields are handled here for desktop_row_3 only
		 * because desktop_row_3 didn't exist before the new header builder added.
		 *
		 * Max width:
		 * - In desktop_row_1, the value is using the existing `pre_header_width` setting.
		 * - In desktop_row_2, the value is using the existing `menu_width` setting.
		 *
		 * Vertical padding:
		 * - In desktop_row_1, the value is using the existing `pre_header_height` setting.
		 * - In desktop_row_2, the value is using the existing `menu_height` setting.
		 *
		 * Font size:
		 * - In desktop_row_1, the value is using the existing `pre_header_font_size` setting.
		 * - In desktop_row_2, the value is using the existing `menu_font_size` setting.
		 *
		 * Background color:
		 * - In desktop_row_1, the value is using the existing `pre_header_bg_color` setting.
		 * - In desktop_row_2, the value is using the existing `menu_bg_color` setting.
		 *
		 * Text color:
		 * - In desktop_row_1, the value is using the existing `pre_header_font_color` setting.
		 * - In desktop_row_2, the value is using the existing `menu_font_colors` (multicolor) setting.
		 *
		 * Accent colors:
		 * - In desktop_row_1, the value is using the existing `pre_header_accent_colors` (multicolor) setting.
		 * - In desktop_row_2, there's no accent colors setting (we follow the old header section).
		 */
		if (rowKey === "desktop_row_3") {
			listenToCustomizerValueChange<string | number>(
				`${controlIdPrefix}max_width`,
				(settingId, value) => {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey} .wpbf-container`,
						props: { "max-width": maybeAppendSuffix(value) },
					});
				},
			);

			listenToCustomizerValueChange<string | number>(
				`${controlIdPrefix}vertical_padding`,
				function (settingId, value) {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey} .wpbf-row-content`,
						props: {
							"padding-top": maybeAppendSuffix(value),
							"padding-bottom": maybeAppendSuffix(value),
						},
					});
				},
			);
		}

		// Background color for desktop_row_1 and desktop_row_2 and desktop_row_3.
		listenToCustomizerValueChange<WpbfColorControlValue>(
			`${controlIdPrefix}bg_color`,
			function (settingId, value) {
				const selector =
					rowKey === "desktop_row_1"
						? ".wpbf-pre-header"
						: `.wpbf-header-row-${rowKey}`;

				writeCSS(settingId, {
					selector: selector,
					props: { "background-color": toStringColor(value) },
				});
			},
		);

		// Font size for desktop_row_2 and desktop_row_3.
		// Row 1 uses existing `pre_header_font_size` setting.
		if (rowKey === "desktop_row_2" || rowKey === "desktop_row_3") {
			listenToCustomizerValueChange<string | number>(
				`${controlIdPrefix}font_size`,
				(settingId, value) => {
					writeCSS(settingId, {
						selector: `.wpbf-header-row-${rowKey}`,
						props: { "font-size": maybeAppendSuffix(value) },
					});
				},
			);
		}

		listenToCustomizerValueChange<WpbfColorControlValue>(
			`${controlIdPrefix}text_color`,
			function (settingId, value) {
				let selector =
					rowKey === "desktop_row_1"
						? ".wpbf-pre-header"
						: `.wpbf-header-row-${rowKey}`;

				if (rowKey === "desktop_row_2") {
					selector += `, .wpbf-header-row-${rowKey} .widget_custom_html, .wpbf-header-row-${rowKey} .textwidget`;
				}

				writeCSS(settingId, {
					selector: selector,
					props: { color: toStringColor(value) },
				});
			},
		);

		listenToCustomizerValueChange<WpbfMulticolorControlValue>(
			`${controlIdPrefix}accent_colors`,
			(settingId, value) => {
				const rawDefaultColor = value.default ?? "";
				const defaultColor = toStringColor(rawDefaultColor);

				const rawHoverColor = value.hover ?? "";
				const hoverColor = toStringColor(rawHoverColor);

				const rowSelector =
					rowKey === "desktop_row_1"
						? ".wpbf-pre-header"
						: `.wpbf-header-row-${rowKey}`;

				const blocks: any[] = [
					{
						selector: `${rowSelector} a:not(.wpbf-button)`,
						props: { color: defaultColor + " !important" },
					},
					{
						selector: `${rowSelector} a:not(.wpbf-button):hover, ${rowSelector} a:not(.wpbf-button):focus`,
						props: { color: hoverColor + " !important" },
					},
				];

				if (rowKey === "desktop_row_1") {
					blocks.push({
						selector:
							".wpbf-pre-header .wpbf-menu > .current-menu-item > a:not(.wpbf-button)",
						props: { color: hoverColor + " !important" },
					});
				}

				writeCSS(settingId, {
					blocks: blocks,
				});
			},
		);
	});
}
