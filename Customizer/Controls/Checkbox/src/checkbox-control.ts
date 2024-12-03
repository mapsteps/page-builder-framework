import "./checkbox-control.scss";
import {
	WpbfCheckboxButtonsetControl,
	WpbfCheckboxControl,
} from "./checkbox-interface";

((customizer: WpbfCustomize | undefined) => {
	if (!customizer) return;

	customizer.controlConstructor["wpbf-checkbox"] =
		customizer.wpbfDynamicControl.extend<WpbfCheckboxControl>({
			initWpbfControl: function (ctrl) {
				const control = ctrl || this;

				control.container?.on("change", "input", function () {
					control.setting?.set(jQuery(this).is(":checked"));
				});
			},
		});

	customizer.controlConstructor["wpbf-toggle"] =
		customizer.wpbfDynamicControl.extend<WpbfCheckboxControl>({
			initWpbfControl: function (ctrl) {
				const control = ctrl || this;

				control.container?.on("change", "input", function () {
					control.setting?.set(jQuery(this).is(":checked"));
				});
			},
		});

	customizer.controlConstructor["wpbf-checkbox-buttonset"] =
		customizer.wpbfDynamicControl.extend<WpbfCheckboxButtonsetControl>(
			{
				currentValue: undefined,

				ready: function () {
					const control = this;

					this.currentValue = this.setting?.get();

					this.container?.on("change", ".switch-input", (e) => {
						const values: string[] = [];

						if (!control.container) return values;

						const fields = control.container[0].querySelectorAll(
							".switch-input:checked",
						);

						fields.forEach((field) => {
							if (!(field instanceof HTMLInputElement)) return;
							values.push(field.value);
						});

						control.setting?.set(values);
					});

					this.setting?.bind((val) => {
						control.updateComponentState?.(val);
					});
				},

				updateComponentState: function (val) {
					if (this.currentValue === val) return;
					if (!this.container) return;

					const fields = this.container[0].querySelectorAll(".switch-input");

					fields.forEach((field) => {
						if (!(field instanceof HTMLInputElement)) return;
						field.checked = val.includes(field.value);
					});
				},
			},
		);
})(window.wp.customize);
