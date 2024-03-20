import { WpbfCustomize } from "../../Base/src/interfaces";
import { WpbfCustomizeGenericControl } from "./interface";
import {
	limitNumber,
	limitNumberWithUnit,
	normalizeMaxValue,
} from "./number-util";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-generic"] =
	wp.customize.wpbfDynamicControl.extend({
		initWpbfControl: function (control: WpbfCustomizeGenericControl) {
			control = control || (this as WpbfCustomizeGenericControl);
			const params = control.params;

			if ("wpbf-generic" !== params.type) {
				return;
			}

			const inputSelector = ".wpbf-control-form input";
			const textareaSelector = ".wpbf-control-form textarea";

			control.container
				.find(`${inputSelector}, ${textareaSelector}`)
				.on("change input", function () {
					let value: string | number = (
						this as HTMLInputElement | HTMLTextAreaElement
					).value;

					if ("number" === params.subtype || "number-unit" === params.subtype) {
						params.max = normalizeMaxValue(params.min, params.max);

						value =
							"number" === params.subtype
								? limitNumber(value, params.min, params.max)
								: limitNumberWithUnit(value, params.min, params.max);
					}

					control.setting.set(value);
				});
		},
	});
