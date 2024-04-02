import {
	AnyWpbfCustomizeControl,
	WpbfCustomize,
} from "../../Base/src/interface";
import {
	WpbfCustomizeSelectControl,
	SelectControlParams,
	LabelValuePair,
	SelectGroupedOptions,
	SelectChoices,
} from "./interface";
import SelectForm from "./SelectForm";
import React from "react";
import { createRoot } from "react-dom/client";

declare var wp: {
	customize: WpbfCustomize;
};

const SelectControl = wp.customize.Control.extend<WpbfCustomizeSelectControl>({
	root: undefined,

	initialize: function (
		this: WpbfCustomizeSelectControl,
		id: string,
		params: SelectControlParams,
	) {
		const control = this;

		// Bind functions to this control context for passing as React props
		control.setNotificationContainer =
			control.setNotificationContainer?.bind(control);

		wp.customize.Control.prototype.initialize.call(control, id, params);

		// The following should be eliminated with <https://core.trac.wordpress.org/ticket/31334>.
		function onRemoved(removedControl: AnyWpbfCustomizeControl) {
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
	setNotificationContainer: function setNotificationContainer(
		this: WpbfCustomizeSelectControl,
		el: HTMLElement,
	) {
		const control = this;
		control.notifications.container = jQuery(el);
		control.notifications.render();
	},

	/**
	 * Render the control into the DOM.
	 *
	 * This is called from the Control#embed() method in the parent class.
	 */
	renderContent: function renderContent(this: WpbfCustomizeSelectControl) {
		const control = this;
		const params = control.params;
		let value = control.setting?.get();

		if (!control.initialized) {
			control.parseSelectChoices?.(control.params.choices);
			control.initialized = true;
		}

		if (!control.root) {
			control.root = createRoot(control.container[0]);
		}

		control.root?.render(
			<SelectForm
				control={control}
				customizerSetting={control.setting}
				setNotificationContainer={control.setNotificationContainer}
				value={control.makeReactSelectValue?.(value)}
				label={params.label}
				description={params.description}
				isMulti={params.isMulti}
				options={control.formattedOptions ?? []}
				isOptionDisabled={control.isOptionDisabled}
				maxSelections={control.params.maxSelections}
				isClearable={control.params.isClearable}
				messages={params.messages}
			/>,
		);
	},

	/**
	 * After control has been first rendered, start re-rendering when setting changes.
	 *
	 * React is available to be used here instead of the wp.customize.Element abstraction.
	 */
	ready: function ready(this: WpbfCustomizeSelectControl) {
		const control = this;

		// Re-render control when setting changes.
		control.setting?.bind(() => {
			control.renderContent();
		});
	},

	/**
	 * Handle removal/de-registration of the control.
	 *
	 * This is essentially the inverse of the Control#embed() method.
	 *
	 * @link https://core.trac.wordpress.org/ticket/31334
	 */
	destroy: function destroy(this: WpbfCustomizeSelectControl) {
		const control = this;

		// Garbage collection: undo mounting that was done in the embed/renderContent method.
		control.root?.unmount();
		control.root = undefined;

		// Call destroy method in parent if it exists (as of #31334).
		if (wp.customize.Control.prototype.destroy) {
			wp.customize.Control.prototype.destroy.call(control);
		}
	},

	disabledSelectOptions: [],

	isOptionDisabled: function (this: WpbfCustomizeSelectControl, option: any) {
		const control = this;

		if (!control.disabledSelectOptions) return false;
		if (!control.disabledSelectOptions.length) return false;
		return !!control.disabledSelectOptions.indexOf(option);
	},

	doSelectAction: function (
		this: WpbfCustomizeSelectControl,
		action: string,
		value: any,
	) {
		const control = this;
		let i;

		switch (action) {
			case "disableOption":
				control.disabledSelectOptions =
					"undefined" === typeof control.disabledSelectOptions
						? []
						: control.disabledSelectOptions;

				if (control.makeReactSelectValue) {
					const formattedValue = control.makeReactSelectValue(value);

					if (Array.isArray(formattedValue)) {
						formattedValue.forEach((val) => {
							control.disabledSelectOptions?.push(val);
						});
					} else {
						if (formattedValue) {
							control.disabledSelectOptions.push(formattedValue);
						}
					}
				}

				break;

			case "enableOption":
				if (control.disabledSelectOptions) {
					for (i = 0; i < control.disabledSelectOptions.length; i++) {
						if (control.disabledSelectOptions[i].value === value) {
							control.disabledSelectOptions.splice(i, 1);
						}
					}
				}
				break;

			case "selectOption":
				control.setting?.set(value);
				break;
		}

		control.renderContent();
	},

	formattedOptions: [],

	parseSelectChoices: function (
		this: WpbfCustomizeSelectControl,
		choices: SelectChoices,
	) {
		const control = this;
		control.formattedOptions = [];

		let i = 0;

		for (; i < choices.length; ++i) {
			const choice = choices[i];

			if (choice.o && Array.isArray(choice.o) && choice.o.length) {
				const options: LabelValuePair[] = [];

				let i2 = 0;

				for (; i2 < choice.o.length; ++i2) {
					options.push({
						label: choice.o[i2].l,
						value: choice.o[i2].v,
					});
				}

				control.formattedOptions.push({
					label: choice.l,
					options: options,
				});

				continue;
			}

			if ("string" === typeof choice.v) {
				control.formattedOptions.push({
					label: choice.l,
					value: choice.v,
				});
			}
		}
	},

	makeReactSelectValue: function (
		this: WpbfCustomizeSelectControl,
		rawValue: string | string[],
	): LabelValuePair | LabelValuePair[] | undefined {
		const control = this;

		if (!control.formattedOptions?.length) {
			return control.params.isMulti ? [] : undefined;
		}

		if (!control.params.isMulti) {
			return findMatchedOptionFromValue(control.formattedOptions, rawValue);
		}

		return findMatchedOptionsFromValue(control.formattedOptions, rawValue);
	},
});

function findMatchedOptionFromValue(
	options: LabelValuePair[] & SelectGroupedOptions[],
	value: string | string[],
): LabelValuePair | undefined {
	for (let i = 0; i < options.length; i++) {
		const optionItem = options[i];

		if (optionItem.options && optionItem.options.length) {
			const suboptions = optionItem.options;

			for (let l = 0; l < suboptions.length; l++) {
				if (valueMatches(suboptions[l].value, value)) {
					return suboptions[l];
				}
			}

			continue;
		}

		if (!optionItem.value) continue;

		if (valueMatches(optionItem.value, value)) {
			return {
				label: optionItem.label,
				value: optionItem.value,
			};
		}
	}

	return undefined;
}

function findMatchedOptionsFromValue(
	options: LabelValuePair[] & SelectGroupedOptions[],
	value: string | string[],
): LabelValuePair[] {
	let matchedOptions: LabelValuePair[] = [];

	for (let i = 0; i < options.length; i++) {
		const optionItem = options[i];

		if (optionItem.options && optionItem.options.length) {
			const suboptions = optionItem.options;

			for (let l = 0; l < suboptions.length; l++) {
				if (valueMatches(suboptions[l].value, value)) {
					// We don't call `break` statement here.
					matchedOptions.push(suboptions[l]);
				}
			}

			// Lets keep this `continue` statement for clarity.
			continue;
		}

		if (!optionItem.value) continue;

		if (valueMatches(optionItem.value, value)) {
			matchedOptions.push({
				label: optionItem.label,
				value: optionItem.value,
			});
		}
	}

	return matchedOptions;
}

function valueMatches(value: string, values: string | string[]): boolean {
	if (typeof values === "string") {
		return value === values;
	}

	if (Array.isArray(values)) {
		return values.includes(value);
	}

	return false;
}

export default SelectControl;
