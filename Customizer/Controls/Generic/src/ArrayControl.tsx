import {
	AnyWpbfCustomizeControl,
	WpbfCustomize,
} from "../../Base/src/interface";
import {
	ArrayControlParams,
	ArrayControlValue,
	WpbfCustomizeArrayControl,
} from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

const ArrayControl = wp.customize.Control.extend<WpbfCustomizeArrayControl>({
	initialize: function (
		this: WpbfCustomizeArrayControl,
		id: string,
		params: ArrayControlParams,
	) {
		const control = this;

		wp.customize.Control.prototype.initialize.call(control, id, params);

		// The following should be eliminated with <https://core.trac.wordpress.org/ticket/31334>.
		function onRemoved(removedControl: AnyWpbfCustomizeControl) {
			if (control !== removedControl) return;
			if (control.destroy) control.destroy();
			control.container.remove();
			wp.customize.control.unbind("removed", onRemoved);
		}

		wp.customize.control.bind("removed", onRemoved);
	},

	/**
	 * Render the control into the DOM.
	 *
	 * This will be called from the Control#embed() method in the parent class.
	 */
	renderContent: function renderContent(this: WpbfCustomizeArrayControl) {
		const control = this;
		const field = getInputField(control);
		if (!field) return;

		const value = formatValue(control.params.value);
		field.value = JSON.stringify(value);
	},

	/**
	 * After control has been first rendered, start re-rendering when setting changes.
	 *
	 * React is available to be used here instead of the wp.customize.Element abstraction.
	 */
	ready: function ready(this: WpbfCustomizeArrayControl) {
		const control = this;
		if (!control.setting) return;

		/**
		 * Update component value's state when customizer setting's value is changed.
		 */
		control.setting.bind((val: any) => {
			control.updateComponentState?.(formatValue(val));
		});
	},

	/**
	 * This method will be overridden by the rendered component.
	 */
	updateComponentState: function (
		this: WpbfCustomizeArrayControl,
		val: ArrayControlValue,
	) {
		const control = this;
		const field = getInputField(control);
		if (!field) return;

		field.value = JSON.stringify(val);
	},

	/**
	 * Handle removal/de-registration of the control.
	 *
	 * This is essentially the inverse of the Control#embed() method.
	 *
	 * @link https://core.trac.wordpress.org/ticket/31334
	 */
	destroy: function destroy(this: WpbfCustomizeArrayControl) {
		const control = this;

		// Call destroy method in parent if it exists (as of #31334).
		if (wp.customize.Control.prototype.destroy) {
			wp.customize.Control.prototype.destroy.call(control);
		}
	},
});

function getInputField(
	control: WpbfCustomizeArrayControl,
): HTMLInputElement | undefined {
	const field = (control.container[0] as HTMLElement).querySelector(
		`#_customize-input-${control.id}`,
	);

	if (!field || !(field instanceof HTMLInputElement)) {
		return undefined;
	}

	return field;
}

function formatValue(value: any): ArrayControlValue {
	let arr = [];

	if (value) {
		if ("string" === typeof value) {
			try {
				arr = JSON.parse(value);
			} catch (e) {
				arr = [];
			}
		} else if (Array.isArray(value) || "object" === typeof value) {
			arr = value;
		}
	}

	if (!Array.isArray(arr) && "object" !== typeof arr) {
		arr = [];
	}

	return arr;
}

export default ArrayControl;
