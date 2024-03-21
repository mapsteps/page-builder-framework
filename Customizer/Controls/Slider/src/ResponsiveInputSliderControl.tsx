import {
	WpbfCustomize,
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";
import { createRoot } from "react-dom/client";
import React from "react";
import ReactDOM from "react-dom";
import ResponsiveInputSliderForm from "./ResponsiveInputSliderForm";
import { WpbfCustomizeResponsiveInputSliderControl } from "./interface";
import { DevicesValue } from "../../Responsive/src/interface";

declare var wp: {
	customize: WpbfCustomize;
};

/**
 * ResponsiveInputSliderControl
 *
 * @class
 * @augments wp.customize.Control
 * @augments wp.customize.Class
 */
const ResponsiveInputSliderControl = wp.customize.Control.extend({
	initialize: function (id: string, params: WpbfCustomizeControlParams) {
		const control = this as WpbfCustomizeResponsiveInputSliderControl;

		// Bind functions to this control context for passing as React props.
		control.setNotificationContainer =
			control.setNotificationContainer?.bind(control);

		wp.customize.Control.prototype.initialize.call(control, id, params);

		// The following should be eliminated with <https://core.trac.wordpress.org/ticket/31334>.
		function onRemoved(removedControl: WpbfCustomizeControl) {
			if (control !== removedControl) return;
			if (control.destroy) control.destroy();
			control.container.remove();
			wp.customize.control.unbind("removed", onRemoved);
		}

		wp.customize.control.bind("removed", onRemoved);
	},

	/**
	 * Set notification container and render.
	 *
	 * This will be called when the React component is mounted.
	 */
	setNotificationContainer: function setNotificationContainer(el: HTMLElement) {
		const control = this as WpbfCustomizeResponsiveInputSliderControl;

		control.notifications.container = jQuery(el);
		control.notifications.render();
	},

	/**
	 * Render the control into the DOM.
	 *
	 * This will be called from the Control#embed() method in the parent class.
	 */
	renderContent: function renderContent() {
		const control = this as WpbfCustomizeResponsiveInputSliderControl;
		const params = control.params;
		const root = createRoot(control.container[0]);

		root.render(
			<ResponsiveInputSliderForm
				control={control}
				customizerSetting={control.setting}
				setNotificationContainer={control.setNotificationContainer}
				devices={params.devices}
				saveAsJson={params.saveAsJson}
				label={params.label}
				description={params.description}
				min={params.min}
				max={params.max}
				step={params.step}
				default={params.default}
				value={params.value}
			/>,
		);

		if (control.params.allowCollapse) {
			control.container.addClass("allowCollapse");
		}
	},

	/**
	 * After control has been first rendered, start re-rendering when setting changes.
	 *
	 * React is available to be used here instead of the wp.customize.Element abstraction.
	 */
	ready: function ready() {
		const control = this as WpbfCustomizeResponsiveInputSliderControl;

		if (control.setting) {
			/**
			 * Update component value's state when customizer setting's value is changed.
			 */
			control.setting.bind((val: string | DevicesValue) => {
				control.updateComponentState?.(val);
			});
		}
	},

	/**
	 * This method will be overriden by the rendered component.
	 */
	updateComponentState: (val: string | DevicesValue) => {},

	/**
	 * Handle removal/de-registration of the control.
	 *
	 * This is essentially the inverse of the Control#embed() method.
	 *
	 * @link https://core.trac.wordpress.org/ticket/31334
	 */
	destroy: function destroy() {
		const control = this as WpbfCustomizeResponsiveInputSliderControl;

		// Garbage collection: undo mounting that was done in the embed/renderContent method.
		ReactDOM.unmountComponentAtNode(control.container[0]);

		// Call destroy method in parent if it exists (as of #31334).
		if (wp.customize.Control.prototype.destroy) {
			wp.customize.Control.prototype.destroy.call(control);
		}
	},
});

export default ResponsiveInputSliderControl;