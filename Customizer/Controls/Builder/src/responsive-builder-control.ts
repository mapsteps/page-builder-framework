import {
	ResponsiveBuilderValue,
	WpbfResponsiveBuilderControl,
} from "./builder-interface";

const allowedDevices = ["desktop", "mobile"];

(function () {
	if (!window.wp.customize) return;

	window.wp.customize.controlConstructor["wpbf-responsive-builder"] =
		window.wp.customize.wpbfDynamicControl.extend<WpbfResponsiveBuilderControl>(
			{
				isSaving: false,

				draggableData: undefined,

				emptyWidgetItemMarkup:
					"<div class='widget-item empty-widget-item'>&nbsp;</div>",

				availableWidgetsPanels: {
					desktop: undefined,
					mobile: undefined,
				},

				builderPanel: undefined,

				initWpbfControl: function (ctrl) {
					const control = ctrl ?? this;
					if (!control) return;

					/**
					 * Listen to customizer setting change event.
					 * Update component state when customizer setting changed.
					 */
					control.setting?.bind((value) => {
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

				isWidgetActive: function (widgetKey, device) {
					if (
						!this.params ||
						!device ||
						(device !== "desktop" && device !== "mobile")
					) {
						return false;
					}

					const activeWidgetKeys = this.params.builder[device].activeWidgetKeys;
					if (!activeWidgetKeys.length) return false;

					return activeWidgetKeys.includes(widgetKey);
				},

				findWidgetByKey: function (widgetKey, device) {
					if (
						!this.params ||
						!device ||
						(device !== "desktop" && device !== "mobile")
					) {
						return undefined;
					}

					const availableWidgets = this.params.builder[device].availableWidgets;
					if (!availableWidgets.length) return undefined;

					for (const widget of availableWidgets) {
						if (widget.key === widgetKey) {
							return widget;
						}
					}

					return undefined;
				},

				buildAvailableWidgetsPanel: function () {
					if (!this.container) return;

					const params = this.params;
					if (!params) return;

					const controlForm = this.findHtmlEl?.(
						this.container[0],
						".wpbf-control-form",
					);

					if (!controlForm) return;

					const control = this;

					for (const device in params.builder) {
						if (!params.builder.hasOwnProperty(device)) continue;
						if (device !== "desktop" && device !== "mobile") continue;
						if (!params.builder[device].availableWidgets.length) continue;

						const $availableWidgetPanel = jQuery("<div></div>")
							.addClass("available-widgets-panel")
							.attr("data-device", device)
							.appendTo(controlForm);

						if (!this.availableWidgetsPanels) {
							continue;
						}

						this.availableWidgetsPanels[device] = $availableWidgetPanel[0];

						const $availableWidgetListEl = jQuery("<div></div>")
							.addClass("builder-widgets available-widgets")
							.appendTo(this.availableWidgetsPanels[device]);

						const availableWidgets = params.builder[device].availableWidgets;

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
								.on("click", function (e) {
									control.handleWidgetClick?.(this, widget);
								})
								.appendTo($availableWidgetListEl);
						});
					}

					jQuery(document.body).append(
						'<div class="widget-drag-helper"></div>',
					);
				},

				buildBuilderPanel: function () {
					const control = this;
					const params = control.params;
					if (!params) return;

					const customizePreview = control.findHtmlEl?.("#customize-preview");
					if (!customizePreview) return;

					// Create the panel.
					const $builderPanel = jQuery("<div></div>")
						.addClass(`wpbf-builder-panel ${params.id}-builder-panel`)
						.attr("data-wpbf-builder-panel", params.id)
						.insertAfter(customizePreview);

					const emptyWidgetListClass = "empty-widget-list";

					for (const device in params.builder) {
						if (!params.builder.hasOwnProperty(device)) continue;
						if (device !== "desktop" && device !== "mobile") continue;
						if (!params.builder[device].availableWidgets.length) continue;

						const $builderSlotsEl = jQuery("<div></div>")
							.addClass("wpbf-builder-slots")
							.attr("data-device", device)
							.appendTo($builderPanel);

						const availableWidgets = params.builder[device].availableWidgets;
						if (!availableWidgets.length) return;

						let $mobileBuilderRows: JQuery<HTMLElement> | undefined = undefined;

						if (
							device === "mobile" &&
							params.builder[device].availableSlots.sidebar
						) {
							$builderSlotsEl.addClass(`wpbf-flex wpbf-content-center`);

							const $builderSidebar = jQuery("<div></div>")
								.addClass("builder-sidebar")
								.appendTo($builderSlotsEl);

							const $builderInnerSidebar = jQuery("<div></div>")
								.addClass("builder-inner-sidebar")
								.appendTo($builderSidebar);

							// Build the row setting button.
							jQuery("<button></button>")
								.attr("type", "button")
								.addClass("row-setting-button")
								.html(
									`<i class="dashicons dashicons-admin-generic"></i><span class="button-label">${params.builder[device].availableSlots.sidebar.label}</span>`,
								)
								.on("click", () =>
									control.handleRowSettingClick?.(
										params.builder[device].availableSlots.sidebar.key,
									),
								)
								.appendTo($builderInnerSidebar);

							const $sidebarWidgetsEl = jQuery("<div></div>")
								.addClass("builder-widgets active-widgets")
								.appendTo($builderInnerSidebar);

							if (params.value) {
								// Build the widget list based on `params.value`.
								params.value[device].sidebar.forEach((widgetKey) => {
									const newWidgetItem = control.createWidgetItem?.(
										widgetKey,
										true,
										device,
									);
									if (!newWidgetItem) return;

									$sidebarWidgetsEl.append(newWidgetItem);
								});
							}

							$mobileBuilderRows = jQuery("<div></div>")
								.addClass("builder-rows")
								.appendTo($builderSlotsEl);
						}

						const availableSlots = params.builder[device].availableSlots;
						if (!availableSlots.rows.length) continue;

						const $rowsWrapper =
							device === "mobile" && $mobileBuilderRows
								? $mobileBuilderRows
								: $builderSlotsEl;

						availableSlots.rows.forEach((row) => {
							// Build the row.
							const $row = jQuery("<div></div>")
								.addClass(`builder-row`)
								.attr("data-row-key", row.key)
								.appendTo($rowsWrapper);

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
								.attr("type", "button")
								.attr("data-row-key", row.key)
								.html('<i class="dashicons dashicons-admin-generic"></i>')
								.on("click", () => control.handleRowSettingClick?.(row.key))
								.appendTo($row);

							const matchedRow = params.value
								? params.value[device].rows[row.key]
								: undefined;

							row.columns.forEach((column, columnIndex) => {
								let columnPosClass = "";

								if (column.key.endsWith("_start")) {
									columnPosClass = "wpbf-content-start";
								} else if (column.key.endsWith("_end")) {
									columnPosClass = "wpbf-content-end";
								} else {
									if (
										columnIndex !== 0 &&
										columnIndex !== row.columns.length - 1
									) {
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
										`builder-column builder-widgets active-widgets wpbf-flex ${columnPosClass}`,
									)
									.attr("data-column-key", column.key)
									.appendTo($innerRow);

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
									const newWidgetItem = control.createWidgetItem?.(
										widgetKey,
										true,
										device,
									);
									if (!newWidgetItem) return;

									$widgetListEl.append(newWidgetItem);
								});
							});

							control.bindCustomizeSection?.(row.key);
						});
					}

					control.builderPanel = $builderPanel[0];
				},

				handleRowSettingClick: function (rowKey) {
					window.wp.customize?.section(
						`wpbf_header_builder_${rowKey}_section`,
						function (section) {
							section.expand(section.params);
						},
					);
				},

				bindCustomizeSection: function (rowKey) {
					window.wp.customize?.section(
						`wpbf_header_builder_${rowKey}_section`,
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
					if (!this.params || !this.container || !this.builderPanel) {
						return;
					}

					const dragHelper = this.findHtmlEl?.(".widget-drag-helper");
					if (!dragHelper) return;

					const availableWidgetItems = this.findHtmlEls?.(
						this.container[0],
						".widget-item",
					);

					if (!availableWidgetItems || !availableWidgetItems.length) {
						return;
					}

					const control = this;

					availableWidgetItems.forEach((item) => {
						if (!(item instanceof HTMLElement)) return;

						item.addEventListener("dragstart", (e) => {
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

						item.addEventListener("dragend", (e) => {
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
					if (!this.builderPanel) {
						return;
					}

					const builderDropZones = this.findHtmlEls?.(
						this.builderPanel,
						".active-widgets",
					);

					if (!builderDropZones || !builderDropZones.length) {
						return;
					}

					const control = this;

					builderDropZones.forEach((dropZone) => {
						dropZone.addEventListener("dragenter", (e) => {
							if (!(e instanceof DragEvent)) return;
							e.preventDefault();

							dropZone.classList.add("dragover");
						});

						// This empty block is necessary to let the dropZone accept the drop event.
						dropZone.addEventListener("dragover", (e) => {
							e.preventDefault();
						});

						dropZone.addEventListener("dragleave", (e) => {
							if (!(e instanceof DragEvent)) return;
							e.preventDefault();

							dropZone.classList.remove("dragover");
						});

						dropZone.addEventListener("drop", (e) => {
							if (!(e instanceof DragEvent)) return;
							e.preventDefault();

							dropZone.classList.remove("dragover");

							const widgetItem = control.getWidgetItemFromDraggableData?.(e);
							if (!widgetItem) return;

							const widgetKey = widgetItem.dataset.widgetKey;
							if (!widgetKey) return;

							const area = dropZone.closest(".wpbf-builder-slots");
							if (!(area instanceof HTMLElement)) return;

							const device = area.dataset.device;

							if (!device || (device !== "desktop" && device !== "mobile")) {
								return;
							}

							const newWidgetItem = control.createWidgetItem?.(
								widgetKey,
								true,
								device,
							);

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
					if (!this.container) return undefined;

					const parsedJson = this.parseDraggableData?.(e);
					if (!parsedJson) return undefined;

					const widgetKey = parsedJson.widgetKey;
					if (!widgetKey) return undefined;

					const widgetItem = this.findHtmlEl?.(
						this.container[0],
						`.widget-item[data-widget-key="${widgetKey}"]`,
					);

					return widgetItem;
				},

				createWidgetItem: function (widgetKey, insideBuilderPanel, device) {
					if (!this.container) return undefined;

					const widgetData = this.findWidgetByKey?.(widgetKey, device);
					if (!widgetData) return undefined;

					const control = this;

					const widgetItemToClone = this.findHtmlEl?.(
						this.container[0],
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
						deleteButton.innerHTML =
							'<i class="dashicons dashicons-no-alt"></i>';
						newWidgetItem.appendChild(deleteButton);

						deleteButton.addEventListener("click", (e) => {
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
					const emptyWidgetListClass = "empty-widget-list";

					jQuery(".active-widgets").sortable({
						connectWith: ".active-widgets",
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

					jQuery(".builder-column.column-middle").on(
						"sortover",
						function (e, ui) {
							const target = e.target;
							target.classList.remove(emptyWidgetListClass);
						},
					);

					jQuery(".builder-column.column-middle").on(
						"sortout",
						function (e, ui) {
							control.checkSortableContent?.(e.target);
						},
					);
				},

				handleDeleteActiveWidget: function (activeWidgetEl, availableWidgetEl) {
					const control = this;

					availableWidgetEl?.classList.remove("disabled");

					const sortableEL = activeWidgetEl.closest(".active-widgets");

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
					if (!this.builderPanel) return;
					jQuery(".wpbf-builder-panel .active-widgets").sortable("destroy");
				},

				updateCustomizerSetting: function () {
					const control = this;

					if (control.isSaving) {
						return;
					}

					control.isSaving = true;

					setTimeout(() => {
						if (!control.availableWidgetsPanels) {
							return;
						}

						const newValue: ResponsiveBuilderValue = {
							desktop: { rows: {} },
							mobile: { sidebar: [], rows: {} },
						};

						for (const device of allowedDevices) {
							if (!control.availableWidgetsPanels.hasOwnProperty(device)) {
								continue;
							}

							if (device !== "desktop" && device !== "mobile") {
								continue;
							}

							if (device === "mobile") {
								const sortableEl = control.findHtmlEl?.(
									".builder-sidebar.active-widgets",
								);

								const widgetItems = control.findHtmlEls?.(
									sortableEl,
									".widget-item",
								);

								widgetItems?.forEach((widgetItem) => {
									if (widgetItem.classList.contains("empty-widget-item")) {
										return;
									}

									if (
										widgetItem.classList.contains("ui-sortable-placeholder")
									) {
										return;
									}

									const widgetKey = widgetItem.dataset.widgetKey;
									if (!widgetKey) return;

									newValue[device].sidebar.push(widgetKey);
								});
							}

							const builderRows = control.findHtmlEls?.(
								control.availableWidgetsPanels[device],
								".builder-row",
							);

							if (!builderRows || !builderRows.length) {
								continue;
							}

							builderRows.forEach((row) => {
								const rowKey = row.dataset.rowKey;
								if (!rowKey) return;

								const sortableColumns = control.findHtmlEls?.(
									row,
									".active-widgets",
								);

								if (!sortableColumns || !sortableColumns.length) {
									return;
								}

								sortableColumns.forEach((column) => {
									const columnKey = column.dataset.columnKey;
									if (!columnKey) return;

									newValue[device].rows[rowKey][columnKey] = [];

									const widgetItems = control.findHtmlEls?.(
										column,
										".widget-item",
									);

									if (!widgetItems || !widgetItems.length) {
										return;
									}

									widgetItems.forEach((widgetItem) => {
										if (widgetItem.classList.contains("empty-widget-item")) {
											return;
										}

										if (
											widgetItem.classList.contains("ui-sortable-placeholder")
										) {
											return;
										}

										const widgetKey = widgetItem.dataset.widgetKey;
										if (!widgetKey) return;

										newValue[device].rows[rowKey][columnKey].push(widgetKey);
									});
								});
							});
						}

						control.setting?.set(newValue);
						control.isSaving = false;
					}, 1);
				},

				updateComponentState: function (value) {
					// Update available-widgets & active-widgets.
				},
			},
		);
})();
