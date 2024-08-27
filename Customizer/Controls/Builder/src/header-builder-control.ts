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

	draggableData: undefined,

	emptyWidgetItemMarkup:
		"<div class='widget-item empty-widget-item'>&nbsp;</div>",

	availableWidgetsPanel: undefined,

	builderPanel: undefined,

	initWpbfControl: function (
		this: WpbfCustomizeBuilderControl,
		control?: WpbfCustomizeBuilderControl,
	) {
		control = control || this;
		if (!control) return;

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
		control.initDraggable?.();
		control.initDroppable?.();

		// Timeout to wait for the elements to be rendered.
		window.setTimeout(() => {
			control.initSortable?.();
		}, 1);
	},

	isSortableEmpty: function (el) {
		const children = el.querySelectorAll(".widget-item");

		if (!children.length) {
			return true;
		}

		for (let i = 0; i < children.length; i++) {
			const child = children[i];

			if (!(child instanceof HTMLElement)) {
				continue;
			}

			if (child.classList.contains("empty-widget-item")) {
				continue;
			}

			if (child.classList.contains("ui-sortable-placeholder")) {
				continue;
			}

			if (child.classList.contains("ui-sortable-helper")) {
				continue;
			}

			return false;
		}

		return true;
	},

	isWidgetActive: function (widgetKey) {
		if (!this.params) return false;

		const value = this.params.value;
		if (!value) return false;

		for (const rowKey in value) {
			if (!value.hasOwnProperty(rowKey)) continue;

			const row = value[rowKey];

			if (!row || !Object.keys(row).length) continue;

			for (const columnKey in row) {
				if (!row.hasOwnProperty(columnKey)) continue;

				const column = row[columnKey];

				if (!column || !column.length) continue;

				if (column.includes(widgetKey)) {
					return true;
				}
			}
		}

		return false;
	},

	findWidgetByKey: function (widgetKey) {
		if (!this.params) return undefined;

		const availableWidgets = this.params.headerBuilder.availableWidgets;
		if (!availableWidgets.length) return undefined;

		for (const widget of availableWidgets) {
			if (widget.key === widgetKey) {
				return widget;
			}
		}

		return undefined;
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

		const $availableWidgetListEl = jQuery("<div></div>")
			.addClass("header-builder-widgets available-widgets")
			.appendTo(control.availableWidgetsPanel);

		// Build the available widgets list based on `availableWidgets`.
		availableWidgets.forEach((widget) => {
			const widgetKey = widget.key;

			jQuery("<div></div>")
				.addClass(
					`widget-item widget-item-${widgetKey} ${control.isWidgetActive?.(widgetKey) ? "disabled" : ""}`,
				)
				.attr("data-widget-key", widgetKey)
				.attr("draggable", "true")
				.html(`<span class="widget-label">${widget.label}</span>`)
				.appendTo($availableWidgetListEl);
		});
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

		// Create the panel.
		const $headerBuilderPanel = jQuery("<div></div>")
			.addClass("header-builder-panel")
			.insertAfter(customizePreview);

		availableRows.forEach((row) => {
			// Build the row.
			const $row = jQuery("<div></div>")
				.addClass(`builder-row`)
				.attr("data-row-key", row.key)
				.appendTo($headerBuilderPanel);

			// Build the inner row.
			const $innerRow = jQuery("<div></div>")
				.addClass(`builder-inner-row`)
				.appendTo($row);

			// Build the row setting button.
			jQuery("<button></button>")
				.addClass("row-setting-button")
				.attr("data-row-key", row.key)
				.html('<i class="dashicons dashicons-admin-generic"></i>')
				.appendTo($row);

			const matchedRow = params.value[row.key];

			row.columns.forEach((column, columnIndex) => {
				const columnPosClass =
					columnIndex === 0
						? "column-start"
						: columnIndex === row.columns.length - 1
							? "column-end"
							: "column-middle";

				const $widgetListEl = jQuery("<div></div>")
					.addClass(
						`header-builder-widgets builder-column sortable-widgets ${columnPosClass}`,
					)
					.attr("data-column-key", column.key)
					.appendTo($innerRow);

				const emptyWidgetListClass = "empty-widget-list";

				if (!matchedRow || !Object.keys(matchedRow).length) {
					$widgetListEl.addClass(emptyWidgetListClass);
					$widgetListEl.html(control.emptyWidgetItemMarkup ?? "");
					return;
				}

				const matchedColumn = matchedRow[column.key];

				if (!matchedColumn || !matchedColumn.length) {
					$widgetListEl.addClass(emptyWidgetListClass);
					$widgetListEl.html(control.emptyWidgetItemMarkup ?? "");
					return;
				}

				// Build the widget list based on `matchedColumn`.
				matchedColumn.forEach((widgetKey) => {
					const matchedWidget = control.findWidgetByKey?.(widgetKey);
					if (!matchedWidget) return;

					jQuery("<div></div>")
						.addClass(`widget-item widget-item-${widgetKey}`)
						.attr("data-widget-key", widgetKey)
						.html(`<span class="widget-label">${matchedWidget.label}</span>`)
						.appendTo($widgetListEl);
				});
			});
		});

		this.builderPanel = $headerBuilderPanel[0];
	},

	initDraggable: function () {
		const control = this;
		const params = control.params;

		if (!params) return;
		if (!control.availableWidgetsPanel || !control.builderPanel) return;

		const dragHelper = document.querySelector(".widget-drag-helper");
		if (!(dragHelper instanceof HTMLElement)) return;

		const availableWidgetItems =
			control.availableWidgetsPanel?.querySelectorAll(".widget-item");

		if (!availableWidgetItems || !availableWidgetItems.length) {
			return;
		}

		availableWidgetItems.forEach((item) => {
			if (!(item instanceof HTMLElement)) return;

			item.addEventListener("dragstart", function (e) {
				if (!(e instanceof DragEvent)) return;

				document.body.classList.add("is-dragging-widget");
				item.classList.add("is-dragging");
				dragHelper.classList.add("is-shown");

				const widgetKey = item.dataset.widgetKey;
				if (!widgetKey) return;

				/**
				 * Set the data to be transferred.
				 * We use both e.dataTransfer and control.draggableData to store the data.
				 * Because e.dataTransfer can't be accessed from "dragenter" and "dragover" event.
				 */
				control.draggableData = { widgetKey };
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

				dragHelper.style.width = dragHelperInnerElWidth + "px";

				e.dataTransfer?.setDragImage(dragHelper, 0, 0);

				window.setTimeout(() => {
					dragHelper.classList.remove("is-shown");
				}, 10);
			});

			item.addEventListener("dragend", function (e) {
				if (!(e instanceof DragEvent)) return;

				e.preventDefault();

				item.classList.remove("is-dragging");
				document.body.classList.remove("is-dragging-widget");

				dragHelper.classList.remove("is-shown");
				dragHelper.innerHTML = "";
				dragHelper.removeAttribute("style");

				control.draggableData = undefined;
			});
		});
	},

	initDroppable: function () {
		const control = this;
		const params = control.params;

		if (!params) return;
		if (!control.availableWidgetsPanel || !control.builderPanel) return;

		const builderDropZones =
			control.builderPanel?.querySelectorAll(".builder-column");

		if (!builderDropZones || !builderDropZones.length) {
			return;
		}

		builderDropZones.forEach((dropZone) => {
			if (!(dropZone instanceof HTMLElement)) return;

			dropZone.addEventListener("dragenter", function (e) {
				if (!(e instanceof DragEvent)) return;
				e.preventDefault();

				dropZone.classList.add("dragover");
			});

			// This empty block is necessary to let the dropZone accept the drop event.
			dropZone.addEventListener("dragover", function (e) {
				e.preventDefault();
			});

			dropZone.addEventListener("dragleave", function (e) {
				if (!(e instanceof DragEvent)) return;
				e.preventDefault();

				dropZone.classList.remove("dragover");
			});

			dropZone.addEventListener("drop", function (e) {
				if (!(e instanceof DragEvent)) return;
				e.preventDefault();

				dropZone.classList.remove("dragover");

				const widgetItem = control.getWidgetItemFromDraggableData?.(e);
				if (!widgetItem) return;

				const newWidgetItem = control.createWidgetItem?.(widgetItem, true);
				if (!(newWidgetItem instanceof HTMLElement)) return;

				const temporaryWidgetItem = dropZone.querySelector(
					".ui-sortable-placeholder.from-available-widgets",
				);

				if (temporaryWidgetItem) {
					dropZone.removeChild(temporaryWidgetItem);
				}

				if (dropZone.classList.contains("column-end")) {
					dropZone.insertBefore(newWidgetItem, dropZone.firstChild);
				} else {
					dropZone.appendChild(newWidgetItem);
				}

				const emptyWidgetItem = dropZone.querySelector(".empty-widget-item");

				if (emptyWidgetItem) {
					emptyWidgetItem.remove();
				}

				// Now refresh the sortable.
				jQuery(dropZone).sortable("refresh");

				widgetItem.classList.add("disabled");
				control.draggableData = undefined;
			});
		});
	},

	parseDraggableData: function (e) {
		const data = e.dataTransfer?.getData("text");
		if (!data) return undefined;

		let parsedJson: undefined | Record<string, any> = undefined;

		try {
			parsedJson = JSON.parse(data);
		} catch (e) {
			console.error("Error parsing JSON data:", e);
		}

		if (!parsedJson) return undefined;

		return parsedJson;
	},

	getWidgetItemFromDraggableData: function (e) {
		const data = e.dataTransfer?.getData("text");
		if (!data) return undefined;

		const parsedJson = this.parseDraggableData?.(e);
		if (!parsedJson) return undefined;

		const widgetKey = parsedJson.widgetKey;
		if (!widgetKey) return undefined;

		const widgetItem = this.availableWidgetsPanel?.querySelector(
			`.widget-item[data-widget-key="${widgetKey}"]`,
		);

		if (!widgetItem || !(widgetItem instanceof HTMLElement)) return undefined;

		return widgetItem;
	},

	createWidgetItem: function (widgetItemToClone, addDeleteButton) {
		const newWidgetItem = widgetItemToClone.cloneNode(true);

		if (newWidgetItem instanceof HTMLElement) {
			newWidgetItem.classList.remove("disabled");
			newWidgetItem.classList.remove("is-dragging");

			if (addDeleteButton) {
				const deleteButton = document.createElement("button");
				deleteButton.type = "button";
				deleteButton.className = "widget-button delete-widget-button";
				deleteButton.innerHTML = '<i class="dashicons dashicons-no-alt"></i>';
				newWidgetItem.appendChild(deleteButton);

				deleteButton.addEventListener("click", function (e) {
					newWidgetItem.remove();
					widgetItemToClone.classList.remove("disabled");
				});
			}
		}

		return newWidgetItem;
	},

	initSortable: function () {
		const control = this;
		const params = control.params;

		if (!params) return;
		if (!control.availableWidgetsPanel || !control.builderPanel) return;

		const emptyWidgetListClass = "empty-widget-list";

		// Init sortables.
		jQuery(".sortable-widgets").sortable({
			connectWith: ".builder-column",
			placeholder: "widget-item",
			start: function (e, ui) {
				document.body.classList.add("is-sorting-widget");

				const labelEl = ui.item[0].querySelector(".widget-label");

				if (labelEl instanceof HTMLElement) {
					ui.placeholder[0].appendChild(labelEl.cloneNode(true));
				}
			},
			update: function (e, ui) {
				const sortableEl = e.target;
				if (!(sortableEl instanceof HTMLElement)) return;

				control.handleSortableSortout?.(sortableEl);
			},
			stop: function (e, ui) {
				document.body.classList.remove("is-sorting-widget");
			},
		});

		jQuery(".builder-column.column-middle").on("sortover", function (e, ui) {
			const target = e.target;
			target.classList.remove(emptyWidgetListClass);
			console.log(ui.placeholder[0].outerHTML);
		});

		jQuery(".builder-column.column-middle").on("sortout", function (e, ui) {
			control.handleSortableSortout?.(e.target);
		});
	},

	handleSortableSortout: function (sortableEl) {
		const emptyWidgetListClass = "empty-widget-list";
		const emptyWidgetItemClass = "empty-widget-item";

		const control = this;
		if (!control.availableWidgetsPanel || !control.builderPanel) return;

		const emptyWidgetItem = sortableEl.querySelector(
			"." + emptyWidgetItemClass,
		);

		if (control.isSortableEmpty?.(sortableEl)) {
			sortableEl.classList.add(emptyWidgetListClass);

			if (!emptyWidgetItem) {
				jQuery(sortableEl).append(control.emptyWidgetItemMarkup ?? "");
			}
		} else {
			sortableEl.classList.remove(emptyWidgetListClass);

			if (emptyWidgetItem) {
				emptyWidgetItem.remove();
			}
		}
	},

	destroySortable: function () {
		const control = this;
		if (!control.availableWidgetsPanel || !control.builderPanel) return;

		jQuery(".builder-column").sortable("destroy");
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
