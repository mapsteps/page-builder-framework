import { WpbfCustomize, WpbfCustomizeControl } from "../../Base/src/interfaces";
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
		initWpbfControl: function (control: WpbfCustomizeControl) {
			control = control || (this as WpbfCustomizeControl);
			const params = control.params;

			control.container.find("input, textarea").on("change input", function () {
				let value: string | number = (
					this as HTMLInputElement | HTMLTextAreaElement
				).value;

				if (
					"wpbf-generic" === params.type &&
					("number" === params.subtype || "number-unit" === params.subtype)
				) {
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
