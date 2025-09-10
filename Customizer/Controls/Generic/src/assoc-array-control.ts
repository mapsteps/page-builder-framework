import { WpbfCustomize } from "../../Base/src/interface";
import { WpbfCustomizeAssocArrayControl } from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-assoc-array"] =
	wp.customize.wpbfDynamicControl.extend<WpbfCustomizeAssocArrayControl>({
		initWpbfControl: function (
			this: WpbfCustomizeAssocArrayControl,
			control?: WpbfCustomizeAssocArrayControl,
		) {
			control = control || this;
			const params = control.params;

			if ("wpbf-assoc-array" !== params.type) {
				return;
			}

			/**
			 * AssocArray control is a "one-way" control or like a read-only control.
			 * Becase we only listen to customizer setting change event.
			 * We don't need to listen to the input field change event because they are hidden fields.
			 */
			control.setting?.bind((value: Record<string, any>) => {
				control.updateComponentState?.(value);
			});
		},

		updateComponentState: function (
			this: WpbfCustomizeAssocArrayControl,
			value: Record<string, any>,
		) {
			const fields = this.container[0].querySelectorAll(inputSelector);
			if (!fields.length) return;

			fields.forEach((field) => {
				if (!(field instanceof HTMLInputElement)) return;
				const prop = field.dataset.settingProp;
				if (!prop || !value[prop]) return;
				field.value = value[prop];
			});
		},
	});

const inputSelector = ".wpbf-control-form input[data-setting-prop]";
