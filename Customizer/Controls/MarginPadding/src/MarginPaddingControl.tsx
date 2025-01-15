import MarginPaddingForm from "./MarginPaddingForm";
import { AnyWpbfCustomizeControl } from "../../Base/src/base-interface";
import {
	MarginPaddingValue,
	WpbfMarginPaddingControl,
	WpbfMarginPaddingControlParams,
} from "./margin-padding-interface";
import { createRoot } from "react-dom/client";
import { makeObjValueWithoutUnitFromJson } from "./margin-padding-util";

export default function MarginPaddingControl(customizer: WpbfCustomize) {
	return customizer.Control.extend<WpbfMarginPaddingControl>({
		/**
		 * Initialize.
		 */
		initialize: function (
			this: WpbfMarginPaddingControl,
			id: string,
			params: WpbfMarginPaddingControlParams,
		) {
			const control = this;

			// Bind functions to this control context for passing as React props.
			control.setNotificationContainer =
				control.setNotificationContainer!.bind(control);

			customizer.Control.prototype.initialize.call(control, id, params);

			// The following should be eliminated with <https://core.trac.wordpress.org/ticket/31334>.
			function onRemoved(removedControl: AnyWpbfCustomizeControl) {
				if (control === removedControl) {
					control.destroy!();
					control.container.remove();
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
		setNotificationContainer: function setNotificationContainer(
			this: WpbfMarginPaddingControl,
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
		renderContent: function renderContent(this: WpbfMarginPaddingControl) {
			const control = this;
			const params = control.params;

			const isResponsive =
				"responsive-margin" === params.subtype ||
				"responsive-padding" === params.subtype;

			if (!this.root && this.container) {
				this.root = createRoot(this.container[0]);
			}

			this.root?.render(
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
		 * React is available to be used here instead of the customizer.Element abstraction.
		 */
		ready: function ready(this: WpbfMarginPaddingControl) {
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
		destroy: function destroy(this: WpbfMarginPaddingControl) {
			this.root?.unmount();
			this.root = undefined;

			// Call destroy method in parent if it exists (as of #31334).
			if (customizer.Control.prototype.destroy) {
				customizer.Control.prototype.destroy.call(this);
			}
		},
	});
}
