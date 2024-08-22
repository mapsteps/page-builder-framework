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

		control.buildAvailableWidgetsPanel?.();
		control.buildBuilderPanel?.();

		// Timeout to wait for the elements to be rendered.
		window.setTimeout(() => {
			control.initSortable?.();
		}, 1);
	},

	buildAvailableWidgetsPanel: function () {
		const control = this;
		if (!control.container) return;

		const params = control.params;
		if (!params) return;

		const availableWidgetsPanel = control.container[0].querySelector(
			`.available-widgets-panel`,
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

		const $availableWidgetsEl = jQuery("<div></div>")
			.addClass("available-widgets sortable-widgets")
			.appendTo(control.availableWidgetsPanel);

		// Add "li" elements based on  availableWidgets and append them to $widgetsPanel.
		for (const widgetKey in availableWidgets) {
			if (!availableWidgets.hasOwnProperty(widgetKey)) continue;

			jQuery("<div></div>")
				.addClass(
					`widget-item widget-item-${widgetKey} ${activeWidgets[widgetKey] ? "disabled" : ""}`,
				)
				.attr("data-widget-key", widgetKey)
				.html(
					`<span class="widget-label">${availableWidgets[widgetKey]}</span>`,
				)
				.appendTo($availableWidgetsEl);
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

		const $headerBuilderPanel = jQuery("<div></div>")
			.addClass("header-builder-panel")
			.insertAfter(customizePreview);

		// Create "div" elements for each row and append them to headerBuilderPanel.
		for (const rowKey in availableRows) {
			if (!availableRows.hasOwnProperty(rowKey)) continue;

			const $row = jQuery("<div></div>")
				.addClass(`builder-row builder-${rowKey}`)
				.attr("data-row-key", rowKey)
				.appendTo($headerBuilderPanel);

			const $rowWidgetsEl = jQuery("<div></div>")
				.addClass(`builder-widgets builder-widgets-${rowKey} sortable-widgets`)
				.appendTo($row);

			const matchedRow = params.value[rowKey];
			if (!matchedRow) continue;

			// Add "li" elements based on params.value and append them to $widgetsPanel.
			for (const widgetKey in matchedRow) {
				if (!matchedRow.hasOwnProperty(widgetKey)) continue;

				jQuery("<div></div>")
					.addClass(`widget-item widget-item-${widgetKey}`)
					.attr("data-widget-key", widgetKey)
					.html(
						`<span class="widget-label">${availableWidgets[widgetKey]}</span>`,
					)
					.appendTo($rowWidgetsEl);
			}
		}

		this.builderPanel = $headerBuilderPanel[0];
	},

	initSortable: function () {
		const control = this;
		const params = control.params;

		if (!params) return;
		if (!control.availableWidgetsPanel || !control.builderPanel) return;

		const controlSelector = "#customize-control-" + params.id;

		jQuery(
			controlSelector +
				" .available-widgets, " +
				controlSelector +
				" .builder-widgets",
		).sortable({
			connectWith: ".sortable-widgets",
			helper: "clone",
			start: function (event, ui) {
				console.log("ui object on sortable start", ui);
				document.body.classList.add("wpbf-dragging-widget");
			},
			update: function (event, ui) {
				console.log("ui object on sortable update", ui);
			},
			stop: function (event, ui) {
				console.log("ui object on sortable stop", ui);
				document.body.classList.remove("wpbf-dragging-widget");
			},
		});

		// Listen to events.
		jQuery(controlSelector + " .available-widgets").on(
			"sortcreate",
			function (event, ui) {
				console.log("ui object on sortcreate", ui);
			},
		);

		jQuery(controlSelector + " .builder-widgets").on(
			"sortstop",
			function (event, ui) {
				console.log("ui object on sortstop", ui);
			},
		);
	},

	destroySortable: function () {
		const control = this;
		if (!control.availableWidgetsPanel || !control.builderPanel) return;

		jQuery(".available-widgets, .builder-widgets").sortable("destroy");
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
