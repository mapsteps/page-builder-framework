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

		jQuery(document.body).append('<div class="widget-drag-helper"></div>');

		const availableWidgets = params.headerBuilder.availableWidgets;
		const activeWidgets: Record<string, string> = {};

		for (const widgetKey in params.value) {
			if (!params.value.hasOwnProperty(widgetKey)) continue;
			activeWidgets[widgetKey] = params.value[widgetKey];
		}

		const $availableWidgetsEl = jQuery("<div></div>")
			.addClass("header-builder-widgets available-widgets")
			.appendTo(control.availableWidgetsPanel);

		// Add "li" elements based on  availableWidgets and append them to $widgetsPanel.
		for (const widgetKey in availableWidgets) {
			if (!availableWidgets.hasOwnProperty(widgetKey)) continue;

			jQuery("<div></div>")
				.addClass(
					`widget-item widget-item-${widgetKey} ${activeWidgets[widgetKey] ? "disabled" : ""}`,
				)
				.attr("data-widget-key", widgetKey)
				.attr("draggable", "true")
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
				.addClass(
					`header-builder-widgets builder-widgets builder-widgets-${rowKey} sortable-widgets`,
				)
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

		const dragHelper = document.querySelector(".widget-drag-helper");
		if (!(dragHelper instanceof HTMLElement)) return;

		const availableWidgetItems =
			control.availableWidgetsPanel?.querySelectorAll(".widget-item");

		if (availableWidgetItems && availableWidgetItems.length) {
			availableWidgetItems.forEach((item) => {
				// Check if item is a HTMLElement.
				if (!(item instanceof HTMLElement)) return;

				item.addEventListener("dragstart", function (e) {
					// Check if e is a DragEvent.
					if (!(e instanceof DragEvent)) return;

					document.body.classList.add("is-dragging-widget");
					item.classList.add("is-dragging");
					dragHelper.classList.add("is-shown");

					const widgetKey = item.dataset.widgetKey;

					// Set the data to be transferred.
					e.dataTransfer?.setData("text", JSON.stringify({ widgetKey }));

					dragHelper.innerHTML = item.outerHTML;

					/**
					 * The visualDragHelper is a direct body child element with position: fixed, left: 0, and top: 0.
					 * We need to set the position of the dragVisualHelper to be in the same position of current `item` (.wiget-item).
					 * Meaning, we need to get the top and left position of the current event element and set the fixed position of the dragVisualHelper.
					 */
					const draggedElRect = item.getBoundingClientRect();
					const draggedElFixedLeftPos = draggedElRect.left;
					const draggedElFixedTopPos = draggedElRect.top;

					dragHelper.style.left = draggedElFixedLeftPos + "px";
					dragHelper.style.top = draggedElFixedTopPos + "px";

					const dragHelperInnerEl = dragHelper.querySelector(".widget-item");

					const innerElRect = dragHelperInnerEl?.getBoundingClientRect();
					const dragHelperInnerElWidth = innerElRect?.width || 80;
					const dragHelperInnerElHeight = innerElRect?.height || 30;

					dragHelper.style.width = dragHelperInnerElWidth + "px";

					const leftPos = e.clientX - dragHelperInnerElWidth / 2;
					const topPos = e.clientY - dragHelperInnerElHeight / 2;

					// Set image position to be in the middle of the cursor.
					e.dataTransfer?.setDragImage(dragHelper, leftPos, topPos);

					window.setTimeout(() => {
						dragHelper.classList.remove("is-shown");
					}, 10);
				});

				item.addEventListener("drag", function (e) {
					// const innerEl = dragVisualHelper.querySelector(".widget-item");
					// const innerElRect = innerEl?.getBoundingClientRect();
				});

				item.addEventListener("dragend", function (e) {
					// Check if e is a DragEvent.
					if (!(e instanceof DragEvent)) return;

					e.preventDefault();

					item.classList.remove("is-dragging");
					document.body.classList.remove("is-dragging-widget");

					dragHelper.classList.remove("is-shown");
					dragHelper.innerHTML = "";
					dragHelper.removeAttribute("style");
				});
			});
		}

		// Init sortables.
		jQuery(".builder-widgets").sortable({
			connectWith: ".sortable-widgets",
			helper: "clone",
			start: function (event, ui) {
				document.body.classList.add("is-dragging-widget");
			},
			update: function (event, ui) {
				//
			},
			stop: function (event, ui) {
				document.body.classList.remove("is-dragging-widget");
			},
		});

		const builderDropZones =
			control.builderPanel?.querySelectorAll(".builder-widgets");

		if (builderDropZones && builderDropZones.length) {
			builderDropZones.forEach((dropZone) => {
				if (!(dropZone instanceof HTMLElement)) return;

				dropZone.addEventListener("dragover", function (e) {
					// Check if e is a DragEvent.
					if (!(e instanceof DragEvent)) return;

					dropZone.classList.add("dragover");

					e.preventDefault();
				});

				dropZone.addEventListener("dragleave", function (e) {
					// Check if e is a DragEvent.
					if (!(e instanceof DragEvent)) return;

					// dropZone.classList.remove("dragover");

					e.preventDefault();
				});

				dropZone.addEventListener("drop", function (e) {
					// Check if e is a DragEvent.
					if (!(e instanceof DragEvent)) return;

					e.preventDefault();

					const data = e.dataTransfer?.getData("text");
					if (!data) return;

					let parsedJson: null | Record<string, any> = null;

					try {
						parsedJson = JSON.parse(data);
					} catch (e) {
						console.error("Error parsing JSON data:", e);
						parsedJson = null;
					}

					if (!parsedJson) return;

					const widgetKey = parsedJson.widgetKey;
					if (!widgetKey) return;

					const widgetItem = control.availableWidgetsPanel?.querySelector(
						`.widget-item[data-widget-key="${widgetKey}"]`,
					);

					if (!widgetItem) return;

					// Add a new child element (cloned from the widgetItem) to this drop zone.
					const newWidgetItem = widgetItem.cloneNode(true);

					dropZone.appendChild(newWidgetItem);

					// Now refresh the sortable.
					jQuery(".builder-widgets").sortable("refresh");

					widgetItem.classList.add("disabled");
				});
			});
		}
	},

	destroySortable: function () {
		const control = this;
		if (!control.availableWidgetsPanel || !control.builderPanel) return;

		jQuery(".builder-widgets").sortable("destroy");
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
