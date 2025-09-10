import {
	AnyWpbfCustomizeControl,
	WpbfCustomize,
} from "../../Base/src/interface";
import { createRoot } from "react-dom/client";
import InputSliderForm from "./InputSliderForm";
import {
	WpbfCustomizeInputSliderControl,
	WpbfCustomizeInputSliderControlParams,
} from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

/**
 * InputSliderControl
 *
 * @class
 * @augments wp.customize.Control
 * @augments wp.customize.Class
 */
const InputSliderControl =
	wp.customize.Control.extend<WpbfCustomizeInputSliderControl>({
		initialize: function (
			this: WpbfCustomizeInputSliderControl,
			id: string,
			params: WpbfCustomizeInputSliderControlParams,
		) {
			const control = this;

			// Bind functions to this control context for passing as React props.
			control.setNotificationContainer =
				control.setNotificationContainer?.bind(control);

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
		 * Set notification container and render.
		 *
		 * This will be called when the React component is mounted.
		 */
		setNotificationContainer: function setNotificationContainer(
			this: WpbfCustomizeInputSliderControl,
			el: HTMLElement,
		) {
			const control = this;

			control.notifications.container = jQuery(el);
			control.notifications.render();
		},

		/**
		 * Render the control into the DOM.
		 *
		 * This will be called from the Control#embed() method in the parent class.
		 */
		renderContent: function renderContent(
			this: WpbfCustomizeInputSliderControl,
		) {
			const control = this;
			const params = control.params;

			if (!this.root && this.container) {
				this.root = createRoot(this.container[0]);
			}

			this.root?.render(
				<InputSliderForm
					control={control}
					customizerSetting={control.setting ?? undefined}
					setNotificationContainer={control.setNotificationContainer}
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
		ready: function ready(this: WpbfCustomizeInputSliderControl) {
			const control = this;

			if (control.setting) {
				/**
				 * Update component value's state when customizer setting's value is changed.
				 */
				// @ts-ignore
				control.setting.bind((val: string | number) => {
					control.updateComponentState?.(val);
				});
			}
		},

		/**
		 * This method will be overriden by the rendered component.
		 */
		updateComponentState: (val: string | number) => {},

		/**
		 * Handle removal/de-registration of the control.
		 *
		 * This is essentially the inverse of the Control#embed() method.
		 *
		 * @link https://core.trac.wordpress.org/ticket/31334
		 */
		destroy: function destroy(this: WpbfCustomizeInputSliderControl) {
			const control = this;

			this.root?.unmount();
			this.root = undefined;

			// Call destroy method in parent if it exists (as of #31334).
			if (wp.customize.Control.prototype.destroy) {
				wp.customize.Control.prototype.destroy.call(control);
			}
		},
	});

export default InputSliderControl;
