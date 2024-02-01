import SliderForm from './SliderForm';
import {Control_Params} from "wordpress__customize-browser/Control";
import ReactDOM from 'react-dom';
import React from 'react';
import {WpbfCustomize, WpbfCustomizeControl} from "../../Base/src/interfaces";

declare var wp: {
	customize: WpbfCustomize;
};

const SliderControl = wp.customize.Control.extend({
	initialize: function (id: string, params: Control_Params) {
		const control = this as WpbfCustomizeControl;

		control.setNotificationContainer = control.setNotificationContainer?.bind(control);

		wp.customize.Control.prototype.initialize.call(control, id, params);

		// The following should be eliminated with <https://core.trac.wordpress.org/ticket/31334>.
		function onRemoved(removedControl: WpbfCustomizeControl) {
			if (control !== removedControl) return;
			if (control.destroy) control.destroy();
			control.container.remove();
			wp.customize.control.unbind('removed', onRemoved);
		}

		wp.customize.control.bind('removed', onRemoved);
	},

	/**
	 * Set notification container and render.
	 *
	 * This will be called when the React component is mounted.
	 */
	setNotificationContainer: function setNotificationContainer(el: HTMLElement) {
		const control = this as WpbfCustomizeControl;

		control.notifications.container = jQuery(el);
		control.notifications.render();
	},

	/**
	 * Render the control into the DOM.
	 *
	 * This will be called from the Control#embed() method in the parent class.
	 */
	renderContent: function renderContent() {
		const control = this as WpbfCustomizeControl;

		ReactDOM.render(
			<SliderForm
				{...control.params}
				control={control}
				customizerSetting={control.setting}
				setNotificationContainer={control.setNotificationContainer}
				value={control.params.value}
			/>,
			control.container[0]
		);

		if (false !== control.params.choices.allowCollapse) {
			control.container.addClass('allowCollapse');
		}
	},

	/**
	 * After control has been first rendered, start re-rendering when setting changes.
	 *
	 * React is available to be used here instead of the wp.customize.Element abstraction.
	 */
	ready: function ready() {
		const control = this as WpbfCustomizeControl;

		if (control.setting) {
			/**
			 * Update component value's state when customizer setting's value is changed.
			 */
			// @ts-ignore
			control.setting.bind((val: string) => {
				control.updateComponentState?.(val);
			});
		}

	},

	/**
	 * This method will be overriden by the rendered component.
	 */
	updateComponentState: (_val: string) => {
	},

	/**
	 * Handle removal/de-registration of the control.
	 *
	 * This is essentially the inverse of the Control#embed() method.
	 *
	 * @link https://core.trac.wordpress.org/ticket/31334
	 */
	destroy: function destroy() {
		const control = this as WpbfCustomizeControl;

		// Garbage collection: undo mounting that was done in the embed/renderContent method.
		ReactDOM.unmountComponentAtNode(control.container[0]);

		// Call destroy method in parent if it exists (as of #31334).
		if (wp.customize.Control.prototype.destroy) {
			wp.customize.Control.prototype.destroy.call(control);
		}
	}
});

export default SliderControl;
