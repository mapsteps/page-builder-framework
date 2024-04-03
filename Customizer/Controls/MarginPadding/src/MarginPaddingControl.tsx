import MarginPaddingForm from "./MarginPaddingForm";
import {
	AnyWpbfCustomizeControl,
	WpbfCustomize,
} from "../../Base/src/interface";
import {
	MarginPaddingValue,
	WpbfCustomizeMarginPaddingControl,
	WpbfCustomizeMarginPaddingControlParams,
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
const KirkiMarginPaddingControl =
	wp.customize.Control.extend<WpbfCustomizeMarginPaddingControl>({
		/**
		 * Initialize.
		 */
		initialize: function (
			this: WpbfCustomizeMarginPaddingControl,
			id: string,
			params: WpbfCustomizeMarginPaddingControlParams,
		) {
			const control = this;

			// Bind functions to this control context for passing as React props.
			control.setNotificationContainer =
				control.setNotificationContainer!.bind(control);

			wp.customize.Control.prototype.initialize.call(control, id, params);

			// The following should be eliminated with <https://core.trac.wordpress.org/ticket/31334>.
			function onRemoved(removedControl: AnyWpbfCustomizeControl) {
				if (control === removedControl) {
					control.destroy!();
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
			this: WpbfCustomizeMarginPaddingControl,
			element: HTMLElement,
		) {
			const control = this;

			control.notifications.container = jQuery(element);
			control.notifications.render();
		},

		/**
		 * Render the control into the DOM.
		 *
		 * This is called from the Control#embed() method in the parent class.
		 */
		renderContent: function renderContent(
			this: WpbfCustomizeMarginPaddingControl,
		) {
			const control = this;
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
					customizerSetting={control.setting ?? undefined}
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
		ready: function ready(this: WpbfCustomizeMarginPaddingControl) {
			const control = this;

			/**
			 * Update component value's state when customizer setting's value is changed.
			 */
			control.setting?.bind((val) => {
				const newVal =
					typeof val === "string"
						? makeObjValueWithoutUnitFromJson(control.params.dimensions, val)
						: val;

				control.updateComponentState!(newVal);
			});
		},

		/**
		 * This method will be overridden by the rendered component.
		 */
		updateComponentState: (_val: MarginPaddingValue | string) => {},

		/**
		 * Handle removal/de-registration of the control.
		 *
		 * This is essentially the inverse of the Control#embed() method.
		 *
		 * @link https://core.trac.wordpress.org/ticket/31334
		 */
		destroy: function destroy(this: WpbfCustomizeMarginPaddingControl) {
			const control = this;

			// Garbage collection: undo mounting that was done in the embed/renderContent method.
			ReactDOM.unmountComponentAtNode(control.container[0]);

			// Call destroy method in parent if it exists (as of #31334).
			if (wp.customize.Control.prototype.destroy) {
				wp.customize.Control.prototype.destroy.call(control);
			}
		},
	});

export default KirkiMarginPaddingControl;
