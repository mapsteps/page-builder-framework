import { BuilderValue, WpbfBuilderControl } from "./builder-interface";

(function () {
	if (!window.wp.customize) return;

	window.wp.customize.controlConstructor["wpbf-builder"] =
		window.wp.customize.wpbfDynamicControl.extend<WpbfBuilderControl>({
			isSaving: false,

			form: undefined,

			draggableData: undefined,

			emptyWidgetItemMarkup:
				"<div class='widget-item empty-widget-item'>&nbsp;</div>",

			availableWidgetsPanel: undefined,

			builderPanel: undefined,

			initWpbfControl: function (
				this: WpbfBuilderControl,
				control?: WpbfBuilderControl,
			) {
				control = control || this;
				if (!control) return;

				/**
				 * Listen to customizer setting change event.
				 * Update component state when customizer setting changed.
				 */
				control.setting?.bind((value: Record<string, any>) => {
					control.updateComponentState?.(value);
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

			isSortableEmpty: function (sortableEl) {
				const children = this.findHtmlEls?.(sortableEl, ".widget-item");

				if (!children || !children.length) {
					return true;
				}

				for (let i = 0; i < children.length; i++) {
					const child = children[i];

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
				return this.params.builder.activeWidgetKeys.includes(widgetKey);
			},

			findWidgetByKey: function (widgetKey) {
				if (!this.params) return undefined;

				const availableWidgets = this.params.builder.availableWidgets;
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

				const availableWidgetsPanel = control.findHtmlEl?.(
					control.container[0],
					".available-widgets-panel",
				);

				if (!availableWidgetsPanel) return;

				control.availableWidgetsPanel = availableWidgetsPanel;

				jQuery(document.body).append('<div class="widget-drag-helper"></div>');

				const availableWidgets = params.builder.availableWidgets;

				const $availableWidgetListEl = jQuery("<div></div>")
					.addClass("builder-widgets available-widgets")
					.appendTo(control.availableWidgetsPanel);

				// Build the available widgets list based on `availableWidgets`.
				availableWidgets.forEach((widget) => {
					const widgetKey = widget.key;

					const $widgetItem = jQuery("<div></div>");

					$widgetItem
						.addClass(
							`widget-item widget-item-${widgetKey} ${control.isWidgetActive?.(widgetKey) ? "disabled" : ""}`,
						)
						.attr("data-widget-key", widgetKey)
						.attr("draggable", "true")
						.html(`<span class="widget-label">${widget.label}</span>`)
						.on("click", function (e) {
							control.handleWidgetClick?.(this, widget);
						})
						.appendTo($availableWidgetListEl);
				});
			},

			buildBuilderPanel: function () {
				const control = this;
				const params = control.params;
				if (!params) return;

				const availableRows = params.builder.availableRows;
				const availableWidgets = params.builder.availableWidgets;
				if (!availableRows || !availableWidgets) return;

				const customizePreview = control.findHtmlEl?.("#customize-preview");
				if (!customizePreview) return;

				// Create the panel.
				const $builderPanel = jQuery("<div></div>")
					.addClass(`wpbf-builder-panel ${params.id}-builder-panel`)
					.attr("data-wpbf-builder-panel", params.id)
					.insertAfter(customizePreview);

				availableRows.forEach((row) => {
					// Build the row.
					const $row = jQuery("<div></div>")
						.addClass(`builder-row`)
						.attr("data-row-key", row.key)
						.appendTo($builderPanel);

					// Build the inner row.
					const $innerRow = jQuery("<div></div>")
						.addClass(`builder-inner-row`)
						.appendTo($row);

					// Build the row label (tooltip)
					jQuery("<div></div>")
						.addClass("row-label")
						.attr("data-row-key", row.key)
						.text(row.label)
						.appendTo($row);

					// Build the row setting button.
					jQuery("<button></button>")
						.addClass("row-setting-button")
						.attr("data-row-key", row.key)
						.html('<i class="dashicons dashicons-admin-generic"></i>')
						.on("click", () => control.handleRowSettingClick?.(row.key))
						.appendTo($row);

					const matchedRow = params.value[row.key];

					row.columns.forEach((column, columnIndex) => {
						let columnPosClass = "";

						if (column.key.endsWith("_start")) {
							columnPosClass = "wpbf-content-start";
						} else if (column.key.endsWith("_end")) {
							columnPosClass = "wpbf-content-end";
						} else {
							if (columnIndex !== 0 && columnIndex !== row.columns.length - 1) {
								columnPosClass = "wpbf-content-center column-middle";
							}
						}

						if (columnIndex === 0) {
							columnPosClass += " column-start wpbf-content-start";
						} else if (columnIndex === row.columns.length - 1) {
							columnPosClass += " column-end wpbf-content-end";
						}

						const $widgetListEl = jQuery("<div></div>")
							.addClass(
								`builder-widgets builder-column sortable-widgets wpbf-flex ${columnPosClass}`,
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
							const newWidgetItem = control.createWidgetItem?.(widgetKey, true);
							if (!newWidgetItem) return;

							$widgetListEl.append(newWidgetItem);
						});
					});

					control.bindCustomizeSection?.(row.key);
				});

				control.builderPanel = $builderPanel[0];
			},

			handleRowSettingClick: function (rowKey) {
				const controlId = this.params?.id;
				if (!controlId) return;

				window.wp.customize?.section(
					`${controlId}_${rowKey}_section`,
					function (section) {
						section.expand(section.params);
					},
				);
			},

			bindCustomizeSection: function (rowKey) {
				const controlId = this.params?.id;
				if (!controlId) return;

				window.wp.customize?.section(
					`${controlId}_${rowKey}_section`,
					function (section) {
						section.expanded.bind(function (expanded) {
							const row = document.querySelector(
								`.builder-row[data-row-key="${rowKey}"]`,
							);
							if (!row) return;

							if (expanded) {
								row.classList.add("is-active");
							} else {
								row.classList.remove("is-active");
							}
						});
					},
				);
			},

			handleWidgetClick: function (widgetEl, widgetData) {
				// If this is from the available widgets panel.
				if (!widgetEl.classList.contains("ui-sortable-handle")) {
					if (!widgetEl.classList.contains("disabled")) {
						return;
					}
				}

				if (!widgetData.section) return;

				const connectedSection = window.wp.customize?.section(
					widgetData.section,
				);
				if (!connectedSection || !connectedSection.params) return;

				connectedSection.expand(connectedSection.params);
			},

			initDraggable: function () {
				const control = this;
				const params = control.params;

				if (!params) return;
				if (!control.availableWidgetsPanel || !control.builderPanel) return;

				const dragHelper = control.findHtmlEl?.(".widget-drag-helper");
				if (!dragHelper) return;

				const availableWidgetItems = control.findHtmlEls?.(
					control.availableWidgetsPanel,
					".widget-item",
				);

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

						const dragHelperInnerEl = control.findHtmlEl?.(
							dragHelper,
							".widget-item",
						);

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

				const builderDropZones = control.findHtmlEls?.(
					control.builderPanel,
					".builder-column",
				);

				if (!builderDropZones || !builderDropZones.length) {
					return;
				}

				builderDropZones.forEach((dropZone) => {
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

						const widgetKey = widgetItem.dataset.widgetKey;
						if (!widgetKey) return;

						const newWidgetItem = control.createWidgetItem?.(widgetKey, true);
						if (!newWidgetItem) return;

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

						const emptyWidgetItem =
							dropZone.querySelector(".empty-widget-item");

						if (emptyWidgetItem) {
							emptyWidgetItem.remove();
						}

						// Now refresh the sortable.
						jQuery(dropZone).sortable("refresh");

						widgetItem.classList.add("disabled");
						control.draggableData = undefined;
						control.updateCustomizerSetting?.();
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
				const control = this;

				const parsedJson = this.parseDraggableData?.(e);
				if (!parsedJson) return undefined;

				const widgetKey = parsedJson.widgetKey;
				if (!widgetKey) return undefined;

				const widgetItem = control.findHtmlEl?.(
					this.availableWidgetsPanel,
					`.widget-item[data-widget-key="${widgetKey}"]`,
				);

				return widgetItem;
			},

			createWidgetItem: function (widgetKey, insideBuilderPanel) {
				const control = this;
				const widgetData = control.findWidgetByKey?.(widgetKey);
				if (!widgetData) return undefined;

				const widgetItemToClone = control.findHtmlEl?.(
					control.availableWidgetsPanel,
					`.widget-item[data-widget-key="${widgetKey}"]`,
				);

				if (!widgetItemToClone) return undefined;

				const newWidgetItem = widgetItemToClone.cloneNode(true);
				if (!(newWidgetItem instanceof HTMLElement)) return undefined;

				newWidgetItem.classList.remove("disabled");
				newWidgetItem.classList.remove("is-dragging");
				newWidgetItem.removeAttribute("draggable");

				if (insideBuilderPanel) {
					const deleteButton = document.createElement("button");
					deleteButton.type = "button";
					deleteButton.className = "widget-button delete-widget-button";
					deleteButton.innerHTML = '<i class="dashicons dashicons-no-alt"></i>';
					newWidgetItem.appendChild(deleteButton);

					deleteButton.addEventListener("click", function (e) {
						e.preventDefault();
						e.stopPropagation();

						control.handleDeleteActiveWidget?.(
							newWidgetItem,
							widgetItemToClone,
						);
					});

					newWidgetItem.addEventListener("click", function (e) {
						e.preventDefault();
						control.handleWidgetClick?.(this, widgetData);
					});
				}

				return newWidgetItem;
			},

			initSortable: function () {
				const control = this;
				const params = control.params;

				if (!params) return;
				if (!control.availableWidgetsPanel || !control.builderPanel) return;

				const emptyWidgetListClass = "empty-widget-list";
				const $builderPanel = jQuery(control.builderPanel);

				// Scope sortable to this specific builder panel only.
				const $sortableWidgets = $builderPanel.find(".sortable-widgets");
				const $builderColumns = $builderPanel.find(".builder-column");

				$sortableWidgets.sortable({
					connectWith: $builderColumns,
					placeholder: "widget-item",
					start: function (e, ui) {
						document.body.classList.add("is-sorting-widget");

						const labelEl = control.findHtmlEl?.(ui.item[0], ".widget-label");

						if (labelEl) {
							ui.placeholder[0].appendChild(labelEl.cloneNode(true));
						}
					},
					update: function (e, ui) {
						const sortableEl = e.target;
						if (!(sortableEl instanceof HTMLElement)) return;

						control.checkSortableContent?.(sortableEl);
						control.updateCustomizerSetting?.();
					},
					stop: function (e, ui) {
						document.body.classList.remove("is-sorting-widget");
					},
				});

				$builderPanel.find(".builder-column.column-middle").on(
					"sortover",
					function (e, ui) {
						const target = e.target;
						target.classList.remove(emptyWidgetListClass);
					},
				);

				$builderPanel
					.find(".builder-column.column-middle")
					.on("sortout", function (e, ui) {
						control.checkSortableContent?.(e.target);
					});
			},

			handleDeleteActiveWidget: function (activeWidgetEl, availableWidgetEl) {
				const control = this;

				availableWidgetEl?.classList.remove("disabled");

				const sortableEL = activeWidgetEl.closest(".sortable-widgets");

				activeWidgetEl.remove();

				if (sortableEL instanceof HTMLElement) {
					control.checkSortableContent?.(sortableEL);
				}

				if (sortableEL) {
					jQuery(sortableEL).sortable("refresh");
				}

				control.updateCustomizerSetting?.();
			},

			checkSortableContent: function (sortableEl) {
				const emptyWidgetListClass = "empty-widget-list";
				const emptyWidgetItemClass = "empty-widget-item";

				const emptyWidgetItem = sortableEl.querySelector(
					"." + emptyWidgetItemClass,
				);

				if (this.isSortableEmpty?.(sortableEl)) {
					sortableEl.classList.add(emptyWidgetListClass);

					if (!emptyWidgetItem) {
						jQuery(sortableEl).append(this.emptyWidgetItemMarkup ?? "");
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

			updateCustomizerSetting: function () {
				const control = this;

				if (control.isSaving) {
					return;
				}

				control.isSaving = true;

				setTimeout(() => {
					const builderRows = control.findHtmlEls?.(
						control.builderPanel,
						".builder-row",
					);

					if (!builderRows || !builderRows.length) {
						control.isSaving = false;
						return;
					}

					const values: BuilderValue = {};

					builderRows.forEach((row) => {
						const rowKey = row.dataset.rowKey;
						if (!rowKey) return;

						values[rowKey] = {};

						const sortableColumns = control.findHtmlEls?.(
							row,
							".builder-column.sortable-widgets",
						);

						if (!sortableColumns || !sortableColumns.length) {
							return;
						}

						sortableColumns.forEach((column) => {
							const columnKey = column.dataset.columnKey;
							if (!columnKey) return;

							values[rowKey][columnKey] = [];

							const widgetItems = control.findHtmlEls?.(column, ".widget-item");

							if (!widgetItems || !widgetItems.length) {
								return;
							}

							widgetItems.forEach((widgetItem) => {
								if (widgetItem.classList.contains("empty-widget-item")) {
									return;
								}

								if (widgetItem.classList.contains("ui-sortable-placeholder")) {
									return;
								}

								const widgetKey = widgetItem.dataset.widgetKey;
								if (!widgetKey) return;

								values[rowKey][columnKey].push(widgetKey);
							});
						});
					});

					control.setting?.set(values);
					control.isSaving = false;
				}, 1);
			},

			updateComponentState: function (
				this: WpbfBuilderControl,
				value: Record<string, any>,
			) {
				// Update available-widgets & sortable-widgets.
			},
		});
})();
