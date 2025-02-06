import MarginPaddingForm from "./MarginPaddingForm";
import { AnyWpbfCustomizeControl } from "../../Base/src/base-interface";
import {
	MarginPaddingValue,
	WpbfMarginPaddingControl,
} from "./margin-padding-interface";
import { createRoot } from "react-dom/client";
import { makeObjValueWithoutUnitFromJson } from "./margin-padding-util";

export default function MarginPaddingControl(customizer: WpbfCustomize) {
	return customizer.Control.extend<WpbfMarginPaddingControl>({
		initialize: function initialize(id, params) {
			// Bind functions to this control context for passing as React props.
			this.setNotificationContainer = this.setNotificationContainer?.bind(this);
			this.overrideUpdateComponentStateFn =
				this.overrideUpdateComponentStateFn?.bind(this);
			this.updateCustomizerSetting = this.updateCustomizerSetting?.bind(this);

			customizer.Control.prototype.initialize.call(this, id, params);

			const control = this;

			// The following should be eliminated with <https://core.trac.wordpress.org/ticket/31334>.
			function onRemoved(removedControl: AnyWpbfCustomizeControl) {
				if (control === removedControl) {
					control.destroy?.();
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
			if (this.notifications) this.notifications.container = jQuery(el);
			this.notifications?.render();
		},

		/**
		 * Render the control into the DOM.
		 *
		 * This is called from the Control#embed() method in the parent class.
		 */
		renderContent: function renderContent() {
			const isResponsive =
				"responsive-margin" === this.params?.subtype ||
				"responsive-padding" === this.params?.subtype;

			if (!this.root && this.container) {
				this.root = createRoot(this.container[0]);
			}

			this.root?.render(
				<MarginPaddingForm
					id={this.setting?.id ?? ""}
					type={this.params?.type}
					subtype={this.params?.subtype}
					label={this.params?.label}
					description={this.params?.description}
					default={this.params?.default}
					defaultArray={this.params?.defaultArray}
					valueArray={this.params?.valueArray}
					unit={this.params?.unit}
					saveAsJson={this.params?.saveAsJson}
					dontSaveUnit={this.params?.dontSaveUnit}
					dimensions={this.params?.dimensions}
					devices={this.params?.devices}
					isResponsive={isResponsive}
					updateCustomizerSetting={this.updateCustomizerSetting}
					overrideUpdateComponentStateFn={this.overrideUpdateComponentStateFn}
					setNotificationContainer={this.setNotificationContainer}
				/>,
			);

			if (isResponsive) {
				this.container?.addClass("wpbf-customize-control-margin-padding");
				this.container?.data("control-subtype", this.params?.subtype);
			}

			if (this.params?.allowCollapse) {
				this.container?.addClass("allowCollapse");
			}
		},

		/**
		 * After control has been first rendered, start re-rendering when setting changes.
		 *
		 * React is available to be used here instead of the customizer.Element abstraction.
		 */
		ready: function ready() {
			// Update component value's state when customizer setting's value is changed.
			this.setting?.bind((val) => {
				const newVal =
					typeof val === "string"
						? makeObjValueWithoutUnitFromJson(this.params?.dimensions, val)
						: val;

				this.updateComponentState?.(newVal);
			});
		},

		updateCustomizerSetting: function updateCustomizerSetting(val) {
			if (val === undefined) return;
			this.setting?.set(val);
		},

		/**
		 * This method will be overriden by the rendered component via overrideUpdateComponentStateFn.
		 */
		updateComponentState: (_val: MarginPaddingValue | string) => {},

		overrideUpdateComponentStateFn: function overrideUpdateComponentStateFn(
			fn,
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
			customizer.Control.prototype.destroy?.call(this);
		},
	});
}
