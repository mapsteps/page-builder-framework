import {
	encodeJsonOrDefault,
	parseJsonOrUndefined,
} from "../../Generic/src/string-util";
import { WpbfCustomizeBuilderControl } from "./builder-interface";

declare var wp: {
	customize: WpbfCustomize;
};

const HeaderBuilderControl = (wp.customize.controlConstructor[
	"wpbf-header-builder"
] = wp.customize.wpbfDynamicControl.extend<WpbfCustomizeBuilderControl>({
	form: undefined,
	valueField: undefined,
	availableWidgetsPanel: undefined,
	builderPanel: undefined,
	sortables: undefined,

	initWpbfControl: function (
		this: WpbfCustomizeBuilderControl,
		control?: WpbfCustomizeBuilderControl,
	) {
		control = control || this;
		if (!control) return;

		const params = control.params;

		if ("wpbf-header-builder" !== params.type) {
			return;
		}

		const controlForm = document.querySelector(
			`#_customize-input-${control.id} .wpbf-control-form`,
		);

		if (controlForm instanceof HTMLElement) {
			control.form = controlForm;
		}

		/**
		 * Listen to customizer setting change event.
		 * Update component state when customizer setting changed.
		 */
		control.setting?.bind((value: Record<string, any>) => {
			control.updateComponentState?.(value);
		});

		control.valueField = control.form?.querySelector("textarea");

		/**
		 * Listen to input change event.
		 * Update customizer setting when input changed.
		 */
		control.valueField?.addEventListener("change", function () {
			if (!control.setting) return;

			const parsedJson = parseJsonOrUndefined<Record<string, any>>(this.value);
			if (!parsedJson) return;

			control.setting.set(parsedJson);
		});

		control.buildPanels?.();
		control.initSortables?.();
	},

	buildPanels: function () {
		this.buildAvailableWidgetsPanel?.();
		this.buildBuilderPanel?.();
	},

	buildAvailableWidgetsPanel: function () {
		const control = this;
		const params = control.params;
		if (!params) return;

		const availableWidgetsPanel = document.querySelector(
			`#_customize-input-${control.id} .available-widgets-panel`,
		);

		if (!(availableWidgetsPanel instanceof HTMLElement)) {
			return;
		}

		control.availableWidgetsPanel = availableWidgetsPanel;

		const availableWidgets = params.headerBuilder.availableWidgets;
		const activeWidgets: Record<string, string> = {};

		for (const widgetKey in params.value) {
			if (!params.value.hasOwnProperty(widgetKey)) continue;
			activeWidgets[widgetKey] = params.value[widgetKey];
		}

		const $widgetsPanel = jQuery("<ul>")
			.addClass("available-widgets")
			.appendTo(control.availableWidgetsPanel);

		// Add "li" elements based on  availableWidgets and append them to $widgetsPanel.
		for (const widgetKey in availableWidgets) {
			if (!availableWidgets.hasOwnProperty(widgetKey)) continue;

			jQuery("<li>")
				.addClass(
					`widget-item widget-item-${widgetKey} ${activeWidgets[widgetKey] ? "" : "disabled"}`,
				)
				.attr("data-widget-key", widgetKey)
				.html(
					`<span class="widget-label">${availableWidgets[widgetKey]}</span>`,
				)
				.appendTo($widgetsPanel);
		}
	},

	buildBuilderPanel: function () {
		const control = this;
		const params = control.params;
		if (!params) return;

		const availableRows = params.headerBuilder.availableRows;
		const availableWidgets = params.headerBuilder.availableWidgets;
		if (!availableRows || !availableWidgets) return;

		const customizePreview = document.querySelector("#customize-preview");

		if (!(customizePreview instanceof HTMLElement)) {
			return;
		}

		const headerBuilderPanel = jQuery("<div>")
			.addClass("header-builder-panel")
			.insertAfter(customizePreview);

		// Create "div" elements for each row and append them to headerBuilderPanel.
		for (const rowKey in availableRows) {
			if (!availableRows.hasOwnProperty(rowKey)) continue;

			const $row = jQuery("<div>")
				.addClass(`builder-row builder-row-${rowKey}`)
				.attr("data-row-key", rowKey)
				.appendTo(headerBuilderPanel);

			const $rowWidgets = jQuery("ul")
				.addClass("builder-row-widgets")
				.appendTo($row);

			const matchedRow = params.value[rowKey];
			if (!matchedRow) continue;

			// Add "li" elements based on params.value and append them to $widgetsPanel.
			for (const widgetKey in matchedRow) {
				if (!matchedRow.hasOwnProperty(widgetKey)) continue;

				jQuery("<li>")
					.addClass(
						`widget-item widget-item-${widgetKey} ${params.value[widgetKey] ? "" : "disabled"}`,
					)
					.attr("data-widget-key", widgetKey)
					.html(`<button type="button">${availableWidgets[widgetKey]}</button>`)
					.appendTo($rowWidgets);
			}
		}

		this.builderPanel = headerBuilderPanel[0];
	},

	initSortables: function () {
		const control = this;
		const params = control.params;

		if (!params) return;
		if (!this.availableWidgetsPanel || !this.builderPanel) return;

		const availableWidgetsUL = this.availableWidgetsPanel.querySelector(
			"ul.available-widgets",
		);
		if (!availableWidgetsUL) return;

		const builderRowULs = this.builderPanel.querySelectorAll(
			"ul.builder-row-widgets",
		);
		if (!builderRowULs.length) return;
	},

	updateComponentState: function (
		this: WpbfCustomizeBuilderControl,
		value: Record<string, any>,
	) {
		const textarea = this.form?.querySelector("textarea");
		if (!textarea) return;

		textarea.value = encodeJsonOrDefault<Record<string, any>>(value);
	},

	valuesEqual: function <T>(a: T, b: T): boolean {
		const aJson = encodeJsonOrDefault<T>(a);
		const bJson = encodeJsonOrDefault<T>(b);

		return aJson === bJson;
	},
}));

export default HeaderBuilderControl;
