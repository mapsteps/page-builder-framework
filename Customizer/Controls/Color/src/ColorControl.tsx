import {
	AnyWpbfCustomizeControl,
	WpbfCustomize,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";
import {
	WpbfCustomizeColorControl,
	WpbfCustomizeColorControlValue,
} from "./interface";
import { ColorForm } from "./ColorForm";
import React from "react";
import { createRoot } from "react-dom/client";

declare var wp: {
	customize: WpbfCustomize;
};

const ColorControl = wp.customize.Control.extend<WpbfCustomizeColorControl>({
	root: undefined,

	/**
	 * Initialize.
	 */
	initialize: function (
		this: WpbfCustomizeColorControl,
		id: string,
		params?: WpbfCustomizeControlParams<WpbfCustomizeColorControlValue>,
	) {
		const control = this;

		// Bind functions to this control context for passing as React props.
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
	setNotificationContainer: function setNotificationContainer(el: HTMLElement) {
		const control = this as WpbfCustomizeColorControl;
		control.notifications.container = jQuery(el);
		control.notifications.render();
	},

	/**
	 * Render the control into the DOM.
	 *
	 * This will be called from the Control#embed() method in the parent class.
	 */
	renderContent: function renderContent(this: WpbfCustomizeColorControl) {
		const control = this;
		const params = control.params;
		const mode = params.mode;
		const useHueMode = "hue" === mode;
		const formComponent = params.formComponent;

		let pickerComponent;

		if (formComponent) {
			pickerComponent = formComponent;
		} else {
			pickerComponent =
				mode === "alpha" || mode === "hue"
					? "RgbaStringColorPicker"
					: "HexColorPicker";
		}

		pickerComponent = useHueMode ? "HueColorPicker" : pickerComponent;

		if (!control.root) {
			control.root = createRoot(control.container[0]);
		}

		control.root.render(
			<ColorForm
				control={control}
				label={params.label}
				description={params.description}
				customizerSetting={control.setting ?? undefined}
				useHueMode={useHueMode}
				formComponent={formComponent}
				pickerComponent={pickerComponent}
				labelStyle={params.labelStyle}
				colorSwatches={params.colorSwatches}
				value={control.params.value}
				default={control.params.default}
				setNotificationContainer={control.setNotificationContainer}
			/>,
		);
	},

	/**
	 * After control has been first rendered, start re-rendering when setting changes.
	 *
	 * React is available to be used here instead of the wp.customize.Element abstraction.
	 */
	ready: function ready() {
		const control = this as WpbfCustomizeColorControl;

		/**
		 * Update component state when customizer setting changes.
		 *
		 * There was an issue (that's fixed):
		 *
		 * Let's say we have other color picker ("x" color picker) and this current color picker ("y" color picker).
		 * Let's say there's a script that bind to that "x" color picker to make change to this "y" color picker.
		 *
		 * When "x" color picker is changed fast (by dragging the color, for example),
		 * then the re-render of this "y" color picker will be messy.
		 * There was something like "function-call race" between component re-render and function call inside the component.
		 *
		 * When that happens, the "x" color picker becomes unresponsive and un-usable.
		 *
		 * How we fixed that:
		 * - Provide a updateComponentState property to this file.
		 * - Inside the component, assign the updateComponentState with a function to update some states.
		 * - Then inside the binding below, call updateComponentState instead of re-rendering the component.
		 *
		 * The result: Even though the "x" color picker becomes very slow, it's still usable and responsive enough.
		 */
		control.setting?.bind((val: any) => {
			if (control.updateComponentState) control.updateComponentState(val);
		});
	},

	updateComponentState: () => {},

	/**
	 * Handle removal/de-registration of the control.
	 *
	 * This is essentially the inverse of the Control#embed() method.
	 */
	destroy: function destroy() {
		const control = this as WpbfCustomizeColorControl;

		// Garbage collection: undo mounting that was done in the embed/renderContent method.
		control.root?.unmount();
		control.root = undefined;

		// Call destroy method in parent if it exists (as of #31334).
		if (wp.customize.Control.prototype.destroy) {
			wp.customize.Control.prototype.destroy.call(control);
		}
	},
}) as WpbfCustomizeColorControl;

export default ColorControl;
