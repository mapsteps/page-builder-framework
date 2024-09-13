import { AnyWpbfCustomizeControl } from "../../Base/src/base-interface";
import {
	WpbfCustomizeColorControl,
	WpbfCustomizeColorControlValue,
} from "./color-interface";
import { ColorForm } from "./ColorForm";
import React from "react";
import { createRoot } from "react-dom/client";
import convertColorForCustomizer from "./utils/convert-color-for-customizer";

export default function ColorControl(
	customizer: WpbfCustomize,
): WpbfCustomizeColorControl {
	return customizer.Control.extend<WpbfCustomizeColorControl>({
		root: undefined,

		/**
		 * Initialize.
		 */
		initialize: function (id, params) {
			const control = this;

			// Bind functions to this control context for passing as React props.
			this.setNotificationContainer =
				this.setNotificationContainer?.bind(control);

			customizer.Control.prototype.initialize.call(control, id, params);

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
		 *
		 * This is called when the React component is mounted.
		 */
		setNotificationContainer: function setNotificationContainer(el) {
			if (this.notifications) {
				this.notifications.container = jQuery(el);
				this.notifications.render();
			}
		},

		/**
		 * Render the control into the DOM.
		 *
		 * This will be called from the Control#embed() method in the parent class.
		 */
		renderContent: function renderContent() {
			const params = this.params;
			if (!params) return;
			if (!this.container || !this.container.length) return;

			const mode = params.mode;
			const useHueMode = "hue" === mode;
			const formComponent = params.formComponent;

			let pickerComponent = "";

			if (formComponent) {
				pickerComponent = formComponent;
			} else {
				pickerComponent =
					mode === "alpha" ? "RgbaStringColorPicker" : "HexColorPicker";
			}

			pickerComponent = useHueMode ? "HueColorPicker" : pickerComponent;

			if (!this.root && this.container) {
				this.root = createRoot(this.container[0]);
			}

			this.root?.render(
				<ColorForm
					control={this as WpbfCustomizeColorControl}
					container={this.container[0]}
					label={params.label}
					description={params.description}
					useHueMode={useHueMode}
					formComponent={formComponent}
					pickerComponent={pickerComponent}
					labelStyle={params.labelStyle}
					colorSwatches={params.colorSwatches}
					value={params.value}
					default={params.default}
					setNotificationContainer={this.setNotificationContainer}
				/>,
			);
		},

		/**
		 * After control has been first rendered, start re-rendering when setting changes.
		 *
		 * React is available to be used here instead of the customizer.Element abstraction.
		 */
		ready: function ready() {
			const control = this;

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
			 * - Provide a updateColorPicker property to this file.
			 * - Inside the component, assign the updateColorPicker with a function to update some states.
			 * - Then inside the binding below, call updateColorPicker instead of re-rendering the component.
			 *
			 * The result: Even though the "x" color picker becomes very slow, it's still usable and responsive enough.
			 */
			this.setting?.bind((val: WpbfCustomizeColorControlValue) => {
				control.updateComponentState?.(val);
			});
		},

		onChange: function (val) {
			this.updateCustomizerSetting?.(val);
		},

		onReset: function () {
			const params = this.params;
			if (!params) return;

			const initialColor =
				"" !== params.default && "undefined" !== typeof params.default
					? params.default
					: params.value;

			this.updateCustomizerSetting?.(initialColor);
		},

		updateCustomizerSetting: function (val) {
			if (typeof val === "undefined") return;
			const params = this.params;
			if (!params) return;

			const mode = params.mode;
			const useHueMode = "hue" === mode;
			const formComponent = params.formComponent;

			let pickerComponent = "";

			if (formComponent) {
				pickerComponent = formComponent;
			} else {
				pickerComponent =
					mode === "alpha" ? "RgbaStringColorPicker" : "HexColorPicker";
			}

			this.setting?.set(
				convertColorForCustomizer(
					val,
					useHueMode,
					pickerComponent,
					formComponent,
				),
			);
		},

		// This method will be replaced in ColorForm component.
		updateColorPicker: (val) => {},

		updateComponentState: function (val: WpbfCustomizeColorControlValue) {
			this.updateColorPicker?.(val);
		},

		/**
		 * Handle removal/de-registration of the control.
		 *
		 * This is essentially the inverse of the Control#embed() method.
		 */
		destroy: function destroy() {
			const control = this;

			// Garbage collection: undo mounting that was done in the embed/renderContent method.
			control.root?.unmount();
			control.root = undefined;

			// Call destroy method in parent if it exists (as of #31334).
			if (customizer.Control.prototype.destroy) {
				customizer.Control.prototype.destroy.call(control);
			}
		},
	});
}
