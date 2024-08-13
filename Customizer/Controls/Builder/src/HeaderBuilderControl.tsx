import {
	AnyWpbfCustomizeControl,
	WpbfCustomize,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";
import React from "react";
import { createRoot } from "react-dom/client";
import { WpbfCustomizeBuilderControl } from "./builder-interface";
import { HeaderBuilderForm } from "./HeaderBuilderForm";

declare var wp: {
	customize: WpbfCustomize;
};

const HeaderBuilderControl =
	wp.customize.Control.extend<WpbfCustomizeBuilderControl>({
		root: undefined,

		/**
		 * Initialize.
		 */
		initialize: function (
			this: WpbfCustomizeBuilderControl,
			id: string,
			params?: WpbfCustomizeControlParams<Record<string, any>>,
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
		setNotificationContainer: function setNotificationContainer(
			el: HTMLElement,
		) {
			const control = this as WpbfCustomizeBuilderControl;
			control.notifications.container = jQuery(el);
			control.notifications.render();
		},

		/**
		 * Render the control into the DOM.
		 *
		 * This will be called from the Control#embed() method in the parent class.
		 */
		renderContent: function renderContent(this: WpbfCustomizeBuilderControl) {
			const control = this;
			const params = control.params;

			if (!control.root) {
				control.root = createRoot(control.container[0]);
			}

			control.root.render(
				<HeaderBuilderForm
					control={control}
					customizerSetting={control.setting ?? undefined}
					setNotificationContainer={control.setNotificationContainer}
					label={params.label}
					description={params.description}
					value={params.value}
					default={params.default}
				/>,
			);
		},

		/**
		 * After control has been first rendered, start re-rendering when setting changes.
		 *
		 * React is available to be used here instead of the wp.customize.Element abstraction.
		 */
		ready: function ready() {
			const control = this as WpbfCustomizeBuilderControl;

			control.setting?.bind((val: any) => {
				if (control.updateComponentState) control.updateComponentState(val);
			});
		},

		updateComponentState: undefined,

		/**
		 * Handle removal/de-registration of the control.
		 *
		 * This is essentially the inverse of the Control#embed() method.
		 */
		destroy: function destroy() {
			const control = this as WpbfCustomizeBuilderControl;

			// Garbage collection: undo mounting that was done in the embed/renderContent method.
			control.root?.unmount();
			control.root = undefined;

			// Call destroy method in parent if it exists (as of #31334).
			if (wp.customize.Control.prototype.destroy) {
				wp.customize.Control.prototype.destroy.call(control);
			}
		},
	}) as WpbfCustomizeBuilderControl;

export default HeaderBuilderControl;
