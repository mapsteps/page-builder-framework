import { AnyWpbfCustomizeControl } from "../../Base/src/base-interface";
import { createRoot } from "react-dom/client";
import ResponsiveInputSliderForm from "./ResponsiveInputSliderForm";
import {
	WpbfResponsiveInputSliderControl,
	WpbfResponsiveInputSliderControlParams,
} from "./slider-interface";
import { DevicesValue } from "../../Responsive/src/responsive-interface";

export default function ResponsiveInputSliderControl(
	customizer: WpbfCustomize,
) {
	return customizer.Control.extend<WpbfResponsiveInputSliderControl>({
		initialize: function (
			id: string,
			params: WpbfResponsiveInputSliderControlParams,
		) {
			// Bind functions to this control context for passing as React props.
			this.setNotificationContainer = this.setNotificationContainer?.bind(this);
			this.overrideUpdateComponentStateFn =
				this.overrideUpdateComponentStateFn?.bind(this);
			this.updateCustomizerSetting = this.updateCustomizerSetting?.bind(this);

			customizer.Control.prototype.initialize.call(this, id, params);

			const control = this;

			// The following should be eliminated with <https://core.trac.wordpress.org/ticket/31334>.
			function handleOnRemoved(removedControl: AnyWpbfCustomizeControl) {
				if (control !== removedControl) return;
				if (control.destroy) control.destroy();
				control.container?.remove();
				customizer.control.unbind("removed", handleOnRemoved);
			}

			customizer.control.bind("removed", handleOnRemoved);
		},

		/**
		 * Set notification container and render.
		 *
		 * This will be called when the React component is mounted.
		 */
		setNotificationContainer: function setNotificationContainer(el) {
			if (this.notifications) this.notifications.container = jQuery(el);
			this.notifications?.render();
		},

		/**
		 * Render the control into the DOM.
		 *
		 * This will be called from the Control#embed() method in the parent class.
		 */
		renderContent: function renderContent() {
			if (!this.root && this.container) {
				this.root = createRoot(this.container[0]);
			}

			this.root?.render(
				<ResponsiveInputSliderForm
					id={this.setting?.id ?? ""}
					min={this.params?.min}
					max={this.params?.max}
					step={this.params?.step}
					label={this.params?.label}
					description={this.params?.description}
					default={this.params?.default ?? ""}
					value={this.params?.value ?? ""}
					overrideUpdateComponentStateFn={this.overrideUpdateComponentStateFn}
					updateCustomizerSetting={this.updateCustomizerSetting}
					setNotificationContainer={this.setNotificationContainer}
					devices={this.params?.devices}
					saveAsJson={this.params?.saveAsJson}
				/>,
			);

			this.container?.addClass("allowCollapse");
		},

		/**
		 * After control has been first rendered, start re-rendering when setting changes.
		 *
		 * React is available to be used here instead of the customizer.Element abstraction.
		 */
		ready: function ready() {
			/**
			 * Update component value's state when customizer setting's value is changed.
			 */
			this.setting?.bind((val: string | DevicesValue) => {
				this.updateComponentState?.(val);
			});
		},

		updateCustomizerSetting: function (val) {
			if (val === undefined) return;
			this.setting?.set(val);
		},

		/**
		 * This method will be overriden by the rendered component.
		 */
		updateComponentState: (val: string | DevicesValue) => {},

		overrideUpdateComponentStateFn: function (
			fn: (val: string | DevicesValue) => void,
		) {
			this.updateComponentState = fn;
		},

		/**
		 * Handle removal/de-registration of the control.
		 *
		 * This is essentially the inverse of the Control#embed() method.
		 *
		 * @link https://core.trac.wordpress.org/ticket/31334
		 */
		destroy: function destroy() {
			this.root?.unmount();
			this.root = undefined;

			// Call destroy method in parent if it exists (as of #31334).
			if (customizer.Control.prototype.destroy) {
				customizer.Control.prototype.destroy.call(this);
			}
		},
	});
}
