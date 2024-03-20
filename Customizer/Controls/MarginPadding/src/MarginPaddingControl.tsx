import MarginPaddingForm from "./MarginPaddingForm";
import {
	WpbfCustomize,
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interfaces";
import {
	MarginPaddingValue,
	WpbfCustomizeMarginPaddingControl,
} from "./interface";
import ReactDOM from "react-dom";
import React from "react";
import { createRoot } from "react-dom/client";
import { makeObjValueWithoutUnitFromJson } from "./margin-padding-util";

declare var wp: {
	customize: WpbfCustomize;
};

/**
 * KirkiMarginPaddingControl.
 */
const KirkiMarginPaddingControl = wp.customize.Control.extend({
	/**
	 * Initialize.
	 */
	initialize: function (id: string, params: WpbfCustomizeControlParams) {
		const control = this as WpbfCustomizeMarginPaddingControl;

		// Bind functions to this control context for passing as React props.
		control.setNotificationContainer =
			control.setNotificationContainer.bind(control);

		wp.customize.Control.prototype.initialize.call(control, id, params);

		// The following should be eliminated with <https://core.trac.wordpress.org/ticket/31334>.
		function onRemoved(
			removedControl: WpbfCustomizeControl | WpbfCustomizeMarginPaddingControl,
		) {
			if (control === removedControl) {
				control.destroy();
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
		element: HTMLElement,
	) {
		const control = this as WpbfCustomizeMarginPaddingControl;

		control.notifications.container = jQuery(element);
		control.notifications.render();
	},

	/**
	 * Render the control into the DOM.
	 *
	 * This is called from the Control#embed() method in the parent class.
	 */
	renderContent: function renderContent() {
		const control = this as WpbfCustomizeMarginPaddingControl;
		const root = createRoot(control.container[0]);
		const params = control.params;

		const isResponsive =
			"responsive-margin" === params.subtype ||
			"responsive-padding" === params.subtype;

		root.render(
			<MarginPaddingForm
				type={params.type}
				subtype={params.subtype}
				label={params.label}
				description={params.description}
				setNotificationContainer={control.setNotificationContainer}
				control={control}
				customizerSetting={control.setting}
				default={params.default}
				defaultArray={params.defaultArray}
				valueArray={params.valueArray}
				unit={params.unit}
				saveAsJson={params.saveAsJson}
				dontSaveUnit={params.dontSaveUnit}
				dimensions={params.dimensions}
				devices={params.devices}
				isResponsive={isResponsive}
			/>,
		);

		if (isResponsive) {
			control.container.addClass("wpbf-customize-control-margin-padding");
			control.container.data("control-subtype", params.subtype);
		}

		if (params.allowCollapse) {
			control.container.addClass("allowCollapse");
		}
	},

	/**
	 * After control has been first rendered, start re-rendering when setting changes.
	 *
	 * React is available to be used here instead of the wp.customize.Element abstraction.
	 */
	ready: function ready() {
		const control = this as WpbfCustomizeMarginPaddingControl;

		/**
		 * Update component value's state when customizer setting's value is changed.
		 */
		control.setting.bind((val) => {
			const newVal =
				typeof val === "string"
					? makeObjValueWithoutUnitFromJson(control.params.dimensions, val)
					: val;

			control.updateComponentState(newVal);
		});
	},

	/**
	 * This method will be overridden by the rendered component.
	 */
	updateComponentState: (_val: MarginPaddingValue) => {},

	/**
	 * Handle removal/de-registration of the control.
	 *
	 * This is essentially the inverse of the Control#embed() method.
	 *
	 * @link https://core.trac.wordpress.org/ticket/31334
	 */
	destroy: function destroy() {
		const control = this as WpbfCustomizeMarginPaddingControl;

		// Garbage collection: undo mounting that was done in the embed/renderContent method.
		ReactDOM.unmountComponentAtNode(control.container[0]);

		// Call destroy method in parent if it exists (as of #31334).
		if (wp.customize.Control.prototype.destroy) {
			wp.customize.Control.prototype.destroy.call(control);
		}
	},
});

export default KirkiMarginPaddingControl;
