import { WpbfCustomize } from "../../Base/src/interface";
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
	wp.customize.wpbfDynamicControl.extend<WpbfCustomizeGenericControl>({
		initWpbfControl: function (
			this: WpbfCustomizeGenericControl,
			control?: WpbfCustomizeGenericControl,
		) {
			control = control || this;
			const params = control.params;

			if ("wpbf-generic" !== params.type) {
				return;
			}

			const inputSelector = ".wpbf-control-form input";
			const textareaSelector = ".wpbf-control-form textarea";

			control.container
				.find(`${inputSelector}, ${textareaSelector}`)
				.on("input", function () {
					let fieldValue: string | number =
						this instanceof HTMLInputElement ||
						this instanceof HTMLTextAreaElement
							? this.value
							: "";

					if ("number" === params.subtype || "number-unit" === params.subtype) {
						params.max = normalizeMaxValue(params.min, params.max);

						fieldValue =
							"number" === params.subtype
								? limitNumber(fieldValue, params.min, params.max)
								: limitNumberWithUnit(fieldValue, params.min, params.max);
					}

					control.setting?.set(fieldValue);
				});
		},
	});
