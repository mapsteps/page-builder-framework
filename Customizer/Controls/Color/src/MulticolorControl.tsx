import { AnyWpbfCustomizeControl } from "../../Base/src/base-interface";
import {
	WpbfCustomizeMulticolorControlValue,
	WpbfCustomizeMulticolorControl,
} from "./color-interface";
import MulticolorForm from "./MulticolorForm";
import React from "react";
import { createRoot } from "react-dom/client";
import convertColorForCustomizer from "./utils/convert-color-for-customizer";

const MulticolorControl =
	window.wp.customize?.Control.extend<WpbfCustomizeMulticolorControl>({
		root: undefined,

		/**
		 * Initialize.
		 */
		initialize: function (id, params) {
			const control = this;

			// Bind functions to this control context for passing as React props.
			this.setNotificationContainer =
				this.setNotificationContainer?.bind(control);

			window.wp.customize?.Control.prototype.initialize.call(
				control,
				id,
				params,
			);

			// The following should be eliminated with <https://core.trac.wordpress.org/ticket/31334>.
			function onRemoved(removedControl: AnyWpbfCustomizeControl) {
				if (control === removedControl) {
					if (control.destroy) control.destroy();
					control.container?.remove();
					window.wp.customize?.control.unbind("removed", onRemoved);
				}
			}

			window.wp.customize?.control.bind("removed", onRemoved);
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
				<MulticolorForm
					control={this as WpbfCustomizeMulticolorControl}
					container={this.container[0]}
					choices={params.choices}
					keys={Object.keys(params.choices)}
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
		 * React is available to be used here instead of the window.wp.customize?.Element abstraction.
		 */
		ready: function ready() {
			const control = this;

			/**
			 * Update component state when customizer setting changes.
			 */
			this.setting?.bind((val: WpbfCustomizeMulticolorControlValue) => {
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
				"undefined" !== typeof params.default &&
				Object.keys(params.default).length > 0
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

			const value: WpbfCustomizeMulticolorControlValue = {};

			for (const key in val) {
				if (!val.hasOwnProperty(key)) continue;

				value[key] = convertColorForCustomizer(
					val[key],
					useHueMode,
					pickerComponent,
					formComponent,
				);
			}

			this.setting?.set(value);
		},

		// This method will be replaced in ColorForm component.
		updateColorPickers: (val) => {},

		updateComponentState: function (val) {
			this.updateColorPickers?.(val);
		},

		/**
		 * Handle removal/de-registration of the control.
		 *
		 * This is essentially the inverse of the Control#embed() method.
		 */
		destroy: function destroy() {
			this.root?.unmount();
			this.root = undefined;

			// Call destroy method in parent if it exists (as of #31334).
			if (window.wp.customize?.Control.prototype.destroy) {
				window.wp.customize?.Control.prototype.destroy.call(this);
			}
		},
	});

export default MulticolorControl;
