import {
	AnyWpbfCustomizeControl,
	WpbfCustomize,
} from "../../Base/src/interface";
import {
	WpbfCustomizeSelectControl,
	SelectControlParams,
	SelectControlValue,
} from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

const SelectControl = wp.customize.Control.extend<WpbfCustomizeSelectControl>({
	$selectbox: undefined,

	/**
	 * Initialize.
	 */
	initialize: function (
		this: WpbfCustomizeSelectControl,
		id: string,
		params: SelectControlParams,
	) {
		const control = this;

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
	 */
	setNotificationContainer: function setNotificationContainer(
		this: WpbfCustomizeSelectControl,
		el: HTMLElement,
	) {
		const control = this;
		control.notifications.container = jQuery(el);
		control.notifications.render();
	},

	/**
	 * Render the control into the DOM.
	 *
	 * This is called from the Control#embed() method in the parent class.
	 */
	renderContent: function renderContent(this: WpbfCustomizeSelectControl) {
		const control = this;
		const params = control.params;

		const template = `
		<header clas="wpbf-control-header">
			${
				params.label
					? `<label
						class="customize-control-title"
						for=wpbf-control-input-${control.id}
					>
						<span className="customize-control-title">${params.label}</span>
					</label>`
					: ""
			}

			${
				params.description
					? `<div
						class="customize-control-description description"
					>
						${params.description}
					</div>`
					: ""
			}
		</header>

		<div class="customize-control-notifications-container"></div>

		<div class="wpbf-control-form">
			<select class="wpbf-select2"${params.isMulti ? " multiple" : ""}></select>
		</div>
		`;

		control.container.html(template);

		const notificationsContainer = document.querySelector(
			`#customize-control-${control.id} .customize-control-notifications-container`,
		);

		if (
			notificationsContainer &&
			notificationsContainer instanceof HTMLElement
		) {
			this.setNotificationContainer?.(notificationsContainer);
		}

		this.$selectbox = control.container.find(
			".wpbf-control-form .wpbf-select2",
		);

		this.$selectbox.on("change.select2", (e) => {
			const selectedOptions = control.$selectbox?.select2("data");

			const values = selectedOptions?.map((option) => option.id);
			let value = null;

			if (values?.length) {
				value = params.isMulti ? values : values[0];
			} else {
				value = params.isMulti ? [] : "";
			}

			control.setting?.set(value);
		});

		this.$selectbox.select2({
			placeholder: params.placeholder,
			allowClear: params.isClearable,
			multiple: params.isMulti,
			maximumSelectionLength: params.isMulti ? params.maxSelections : undefined,
			// @ts-ignore - In a grouped option, id can be omitted, but Select2's types requires id to be a string|number -_-.
			data: params.choices,
		});
	},

	/**
	 * After control has been first rendered, start re-rendering when setting changes.
	 */
	ready: function ready(this: WpbfCustomizeSelectControl) {
		const control = this;

		// Update component state when customizer setting changes.
		control.setting?.bind((val?: SelectControlValue) => {
			if (control.updateComponentState) {
				let value = val;

				if (undefined === value) {
					value = control.params.isMulti ? [] : "";
				}

				control.updateComponentState(value);
			}
		});
	},

	updateComponentState: function updateComponentState(
		this: WpbfCustomizeSelectControl,
		value: SelectControlValue,
	) {
		this.$selectbox?.val(value);
	},

	/**
	 * Handle removal/de-registration of the control.
	 *
	 * This is essentially the inverse of the Control#embed() method.
	 *
	 * @link https://core.trac.wordpress.org/ticket/31334
	 */
	destroy: function destroy(this: WpbfCustomizeSelectControl) {
		const control = this;

		if (control.$selectbox) {
			control.$selectbox.off("change.select2");
			control.$selectbox.select2("destroy");
			control.$selectbox = undefined;
		}

		control.container.html("");

		// Call destroy method in parent if it exists (as of #31334).
		if (wp.customize.Control.prototype.destroy) {
			wp.customize.Control.prototype.destroy.call(control);
		}
	},
});

export default SelectControl;
