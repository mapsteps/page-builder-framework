import { WpbfCustomize, WpbfCustomizeControl } from "../../Base/src/interfaces";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-generic"] =
	wp.customize.wpbfDynamicControl.extend({
		initWpbfControl: function (control: WpbfCustomizeControl) {
			control = control || (this as WpbfCustomizeControl);
			const params = control.params;

			control.container.find("input, textarea").on("change input", function () {
				let value = jQuery(this).val();

				if (
					"wpbf-generic" === params.type &&
					params.inputType &&
					"number" === params.inputType
				) {
					if (
						typeof params.min !== "undefined" &&
						typeof params.max !== "undefined"
					) {
						params.min = parseFloat(params.min);
						params.max = parseFloat(params.max);

						if (value && value < params.min) {
							value = params.min;
						} else if (value && value > params.max) {
							value = params.max;
						}
					} else {
						if (typeof params.min !== "undefined") {
							params.min = parseFloat(params.min);

							if (value && value < params.min) {
								value = params.min;
							}
						} else if (typeof params.max !== "undefined") {
							params.max = parseFloat(params.max);

							if (value && value > params.max) {
								value = params.max;
							}
						}
					}
				}

				control.setting.set(value);
			});
		},
	});
