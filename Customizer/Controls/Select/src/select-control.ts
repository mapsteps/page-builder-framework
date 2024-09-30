import { AnyWpbfCustomizeControl } from "../../Base/src/base-interface";
import {
	SelectControlChoice,
	WpbfCustomizeSelectControl,
} from "./select-interface";

import "./select-control.scss";

if (window.wp.customize) {
	setupSelectControl(window.wp.customize);
}

function setupSelectControl(customizer: WpbfCustomize) {
	customizer.controlConstructor["wpbf-select"] =
		customizer.Control.extend<WpbfCustomizeSelectControl>({
			$selectbox: undefined,

			/**
			 * Initialize.
			 */
			initialize: function (id, params) {
				customizer.Control.prototype.initialize.call(this, id, params);

				const control = this;

				// The following should be eliminated with <https://core.trac.wordpress.org/ticket/31334>.
				function onRemoved(removedControl: AnyWpbfCustomizeControl) {
					if (control === removedControl) {
						if (control.destroy) control.destroy();
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
					<select class="wpbf-select2"${params.isMulti ? " multiple" : ""}></select>
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

				this.$selectbox = this.container?.find(
					".wpbf-control-form .wpbf-select2",
				);

				this.$selectbox?.on("change.select2", (e) => {
					const selectedOptions = this.$selectbox?.select2("data");

					const values = selectedOptions?.map((option) => option.id);
					let value = null;

					if (values?.length) {
						value = params.isMulti ? values : values[0];
					} else {
						value = params.isMulti ? [] : "";
					}

					this.setting?.set(value);
				});

				const choicesGlobalVar = params.choicesGlobalVar;

				const choicesFromGlobalVar = choicesGlobalVar
					? (window[choicesGlobalVar] as SelectControlChoice[])
					: undefined;

				if (choicesFromGlobalVar) {
					const value = this.setting?.get();
					const values = !Array.isArray(value) ? [value] : value;

					choicesFromGlobalVar.forEach((choice, index) => {
						if (choice.id && values.includes(choice.id)) {
							choicesFromGlobalVar[index].selected = true;
						}

						if (choice.children && choice.children.length) {
							choice.children.forEach((child, childIndex) => {
								if (child.id && values.includes(child.id)) {
									if (choicesFromGlobalVar[index].children) {
										choicesFromGlobalVar[index].children[childIndex].selected =
											true;
									}
								}
							});
						}
					});
				}

				this.$selectbox?.select2({
					placeholder: params.placeholder,
					allowClear: params.isClearable,
					multiple: params.isMulti,
					maximumSelectionLength: params.isMulti
						? params.maxSelections
						: undefined,
					// @ts-ignore - In a grouped option, id can be omitted, but Select2's types requires id to be a string|number -_-.
					data: choicesFromGlobalVar ?? params.choices,
				});
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
							value = this.params?.isMulti ? [] : "";
						}

						this.updateComponentState(value);
					}
				});
			},

			updateComponentState: function (value) {
				this.$selectbox?.val(value);
			},

			/**
			 * Handle removal/de-registration of the control.
			 *
			 * This is essentially the inverse of the Control#embed() method.
			 *
			 * @link https://core.trac.wordpress.org/ticket/31334
			 */
			destroy: function destroy() {
				if (this.$selectbox) {
					this.$selectbox.off("change.select2");
					this.$selectbox.select2("destroy");
					this.$selectbox = undefined;
				}

				this.container?.html("");

				// Call destroy method in parent if it exists (as of #31334).
				if (customizer.Control.prototype.destroy) {
					customizer.Control.prototype.destroy.call(this);
				}
			},
		});
}
