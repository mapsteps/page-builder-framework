import {WpbfCustomize, WpbfCustomizeControl} from "../../Base/src/interfaces";
import {Control_Params} from "wordpress__customize-browser/Control";
import {WpbfCustomizeSelectControl} from "./interfaces";
import SelectForm from "./SelectForm";
import ReactDOM from "react-dom";
import React from "react";
import _ from "lodash";

declare var wp: {
	customize: WpbfCustomize;
};

const SelectControl = wp.customize.Control.extend({
	/**
	 * Initialize.
	 */
	initialize: function (id: string, params: Control_Params) {
		const control = this as WpbfCustomizeSelectControl;

		// Bind functions to this control context for passing as React props
		control.setNotificationContainer =
			control.setNotificationContainer?.bind(control);

		wp.customize.Control.prototype.initialize.call(control, id, params);

		// The following should be eliminated with <https://core.trac.wordpress.org/ticket/31334>.
		function onRemoved(removedControl: WpbfCustomizeControl) {
			if (control === removedControl) {
				if (control.destroy) control.destroy();
				control.container.remove();
				wp.customize.control.unbind("removed", onRemoved);
			}
		}

		wp.customize.control.bind("removed", onRemoved);
	},

	/**
	 * Set notification container and render.
	 *
	 * This is called when the React component is mounted.
	 */
	setNotificationContainer: function setNotificationContainer(el: HTMLElement) {
		const control = this as WpbfCustomizeSelectControl;
		control.notifications.container = jQuery(el);
		control.notifications.render();
	},

	/**
	 * Render the control into the DOM.
	 *
	 * This is called from the Control#embed() method in the parent class.
	 */
	renderContent: function renderContent() {
		const control = this as WpbfCustomizeSelectControl;
		let value = control.setting?.prototype.get();

		if (Array.isArray(value)) {
			let formattedValue = [];

			for (const key in control.params.choices) {
				if (control.params.choices.hasOwnProperty(key)) {
					if (value.includes(key)) {
						// formattedValue.push();
					}
				}
			}

			// value = control.params.choices;
		}

		const form = (
			<SelectForm
				{...control.params}
				value={value}
				setNotificationContainer={control.setNotificationContainer}
				isClearable={control.params.isClearable}
				customizerSetting={control.setting}
				isOptionDisabled={control.isOptionDisabled}
				control={control}
				isMulti={control.isMulti()}
				maxSelectionNumber={control.params.maxSelectionNumber}
			/>
		);
		ReactDOM.render(form, control.container[0]);
	},

	/**
	 * After control has been first rendered, start re-rendering when setting changes.
	 *
	 * React is available to be used here instead of the wp.customize.Element abstraction.
	 */
	ready: function ready() {
		const control = this;

		// Re-render control when setting changes.
		control.setting.bind(() => {
			control.renderContent();
		});
	},

	isMulti: function () {
		return this.params.isMulti;
	},

	/**
	 * Handle removal/de-registration of the control.
	 *
	 * This is essentially the inverse of the Control#embed() method.
	 *
	 * @link https://core.trac.wordpress.org/ticket/31334
	 */
	destroy: function destroy() {
		const control = this;

		// Garbage collection: undo mounting that was done in the embed/renderContent method.
		ReactDOM.unmountComponentAtNode(control.container[0]);

		// Call destroy method in parent if it exists (as of #31334).
		if (wp.customize.Control.prototype.destroy) {
			wp.customize.Control.prototype.destroy.call(control);
		}
	},

	isOptionDisabled: function (option) {
		const control = this;

		if (!control) return false;
		if (!control.disabledSelectOptions) return false;
		return !!control.disabledSelectOptions.indexOf(option);


	},

	doSelectAction: function (action: any, arg: any) {
		const control = this as WpbfCustomizeSelectControl;
		let i;

		switch (action) {
			case "disableOption":
				control.disabledSelectOptions =
					"undefined" === typeof control.disabledSelectOptions
						? []
						: control.disabledSelectOptions;
				control.disabledSelectOptions.push(control.getOptionProps(arg));
				break;

			case "enableOption":
				if (control.disabledSelectOptions) {
					for (i = 0; i < control.disabledSelectOptions.length; i++) {
						if (control.disabledSelectOptions[i].value === arg) {
							control.disabledSelectOptions.splice(i, 1);
						}
					}
				}
				break;

			case "selectOption":
				control.value = arg;
				break;
		}

		control.renderContent();
	},

	formatOptions: function () {
		const self = this as WpbfCustomizeSelectControl;
		self.formattedOptions = [];

		if (Array.isArray(self.params.choices)) {
			this.formattedOptions = self.params.choices;
			return;
		}

		_.each(self.params.choices, function (label, value) {
			let optGroup;

			if ("object" === typeof label) {
				optGroup = {
					label: label[0],
					options: [],
				};

				_.each(label[1], function (optionVal, optionKey) {
					optGroup.options.push({
						label: optionVal,
						value: optionKey,
					});
				});

				self.formattedOptions.push(optGroup);
			} else if ("string" === typeof label) {
				self.formattedOptions.push({
					label: label,
					value: value,
				});
			}
		});
	},

	getFormattedOptions: function () {
		if (!this.formattedOptions || !this.formattedOptions.length) {
			this.formatOptions();
		}
		return this.formattedOptions;
	},

	getOptionProps: function (value: any) {
		const control = this as WpbfCustomizeSelectControl;

		const options = control.getFormattedOptions();
		let i;
		let l;

		if (control.isMulti()) {
			let values = [];

			for (i = 0; i < options.length; i++) {
				if (Array.isArray(value)) {
					const valueArray = value;

					valueArray.forEach(function (val) {
						if (options[i].value === val) {
							values.push(options[i]);
							return;
						}

						if (options[i].options) {
							for (l = 0; l < options[i].options.length; l++) {
								if (options[i].options[l].value === val) {
									values.push(options[i].options[l]);
								}
							}
						}
					});
				} else {
					if (options[i].value === value) {
						values.push(options[i]);
					}

					if (options[i].options) {
						for (l = 0; l < options[i].options.length; l++) {
							if (options[i].options[l].value === value) {
								values.push(options[i].options[l]);
							}
						}
					}
				}
			}

			return values;
		} else {
			for (i = 0; i < options.length; i++) {
				if (options[i].value === value) {
					return options[i];
				}

				if (options[i].options) {
					for (l = 0; l < options[i].options.length; l++) {
						if (options[i].options[l].value === value) {
							return options[i].options[l];
						}
					}
				}
			}
		}
	},
});

export default SelectControl;
