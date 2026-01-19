import { AnyWpbfCustomizeControl } from "../../Base/src/base-interface";
import { WpbfSelectControl } from "./select-interface";
import { createSharedFontDataAdapter } from "./shared-font-data-adapter";

if (window.wp.customize) {
	setupSelectControl(window.wp.customize);
}

function setupSelectControl(customizer: WpbfCustomize) {
	customizer.controlConstructor["wpbf-enhanced-select"] =
		customizer.Control.extend<WpbfSelectControl>({
			/**
			 * Initialize.
			 */
			initialize: function (id, params) {
				const control = this;

				customizer.Control.prototype.initialize.call(control, id, params);

				// The following should be eliminated with <https://core.trac.wordpress.org/ticket/31334>.
				function onRemoved(removedControl: AnyWpbfCustomizeControl) {
					if (control === removedControl) {
						control?.destroy?.();
						control.container?.remove();
						customizer.control.unbind("removed", onRemoved);
					}
				}

				customizer.control.bind("removed", onRemoved);
			},

			/**
			 * Set notification container and render.
			 */
			setNotificationContainer: function (el) {
				if (!this.notifications) return;
				this.notifications.container = jQuery(el);
				this.notifications.render();
			},

			/**
			 * Render the control into the DOM.
			 *
			 * This is called from the Control#embed() method in the parent class.
			 */
			renderContent: function () {
				if (!this.params) return;
				const params = this.params;

				const labelTemplate = `
				<label class="customize-control-title" for="wpbf-control-input-${this.id}">
					<span className="customize-control-title">${params.label}</span>
				</label>
				`;

				const labelDescriptionTemplate = `
				<div class="customize-control-description description">
					${params.description}
				</div>
				`;

				const headerTemplate = `
				<header clas="wpbf-control-header">
					${params.label ? labelTemplate : ""}
					${params.description ? labelDescriptionTemplate : ""}
					<div class="customize-control-notifications-container"></div>
				</header>
				`;

				const formTemplate = `
				<div class="wpbf-control-form">
					<select class="wpbf-select2"${params.multiple ? " multiple" : ""}></select>
				</div>
				`;

				let template = headerTemplate + formTemplate;

				if (params.layoutStyle === "horizontal") {
					template = `
					<div class="wpbf-control-cols">
						<div class="wpbf-control-left-col wpbf-w50">
							${headerTemplate}
						</div>
						<div class="wpbf-control-right-col wpbf-flex wpbf-content-end wpbf-w50">
							${formTemplate}
						</div>
					</div>
					`;
				}

				this.container?.html(template);

				const notificationsContainer = document.querySelector(
					`#customize-control-${this.id} .customize-control-notifications-container`,
				);

				if (
					notificationsContainer &&
					notificationsContainer instanceof HTMLElement
				) {
					this.setNotificationContainer?.(notificationsContainer);
				}

				const $selectbox = this.container?.find(".wpbf-select2");

				$selectbox?.on("change.select2", (e) => {
					const selectedOptions = $selectbox?.select2("data");

					const values = selectedOptions?.map((option) => option.id);
					let value = null;

					if (values?.length) {
						value = params.multiple ? values : values[0];
					} else {
						value = params.multiple ? [] : "";
					}

					this.setting?.set(value);
				});

				const choicesGlobalVar = params.choicesGlobalVar;

				// Check if we should use the shared data adapter (for global font data)
				const hasGlobalData =
					choicesGlobalVar && choicesGlobalVar in window;

				if (hasGlobalData) {
					// Use custom adapter that shares global data without copying
					const value = this.setting?.get();
					const selectedValues = !Array.isArray(value)
						? value
							? [value]
							: []
						: value;

					const SharedAdapter = createSharedFontDataAdapter(
						choicesGlobalVar,
						selectedValues,
					);

					if (SharedAdapter) {
						$selectbox?.select2({
							placeholder: params.placeholder,
							allowClear: params.clearable,
							multiple: params.multiple,
							maximumSelectionLength: params.multiple
								? params.maxSelections
								: undefined,
							dataAdapter: SharedAdapter,
						});
					} else {
						// Fallback to standard behavior if adapter creation failed
						console.warn(
							"SharedFontDataAdapter creation failed, using default",
						);
						$selectbox?.select2({
							placeholder: params.placeholder,
							allowClear: params.clearable,
							multiple: params.multiple,
							maximumSelectionLength: params.multiple
								? params.maxSelections
								: undefined,
							// @ts-ignore
							data: (window as any)[choicesGlobalVar] ?? params.choices,
						});
					}
				} else {
					// Standard behavior for non-global data
					$selectbox?.select2({
						placeholder: params.placeholder,
						allowClear: params.clearable,
						multiple: params.multiple,
						maximumSelectionLength: params.multiple
							? params.maxSelections
							: undefined,
						// @ts-ignore
						data: params.choices,
					});
				}
			},

			/**
			 * After control has been first rendered, start re-rendering when setting changes.
			 */
			ready: function () {
				// Update component state when customizer setting changes.
				this.setting?.bind((val) => {
					if (this.updateComponentState) {
						let value = val;

						if (undefined === value) {
							value = this.params?.multiple ? [] : "";
						}

						this.updateComponentState(value);
					}
				});
			},

			updateComponentState: function (value) {
				const $selectbox = this.container?.find(".wpbf-select2");
				$selectbox?.val(value);
			},

			/**
			 * Handle removal/de-registration of the control.
			 *
			 * This is essentially the inverse of the Control#embed() method.
			 *
			 * @link https://core.trac.wordpress.org/ticket/31334
			 */
			destroy: function destroy() {
				const $selectbox = this.container?.find(".wpbf-select2");
				$selectbox?.off("change.select2");
				$selectbox?.select2("destroy");

				this.container?.html("");

				// Call destroy method in parent if it exists (as of #31334).
				if (customizer.Control.prototype.destroy) {
					customizer.Control.prototype.destroy.call(this);
				}
			},
		});
}
