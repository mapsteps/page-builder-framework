import { WpbfCustomize } from "../../Base/src/interface";
import { encodeJsonOrDefault } from "./string-util";
import { WpbfCustomizeResponsiveGenericControl } from "./interface";
import {
	limitNumber,
	limitNumberWithUnit,
	normalizeMaxValue,
} from "./number-util";
import { makeDevicesValue } from "../../Responsive/src/responsive-util";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-responsive-generic"] =
	wp.customize.wpbfDynamicControl.extend<WpbfCustomizeResponsiveGenericControl>(
		{
			initWpbfControl: function (
				this: WpbfCustomizeResponsiveGenericControl,
				control?: WpbfCustomizeResponsiveGenericControl,
			) {
				control = control || this;
				const params = control.params;

				if ("wpbf-responsive-generic" !== params.type) {
					return;
				}

				const inputSelector = ".wpbf-control-form input";
				const textareaSelector = ".wpbf-control-form textarea";

				control.container
					.find(`${inputSelector}, ${textareaSelector}`)
					.on("input", function (e) {
						const existingValue = control.setting?.get();

						const valueRecord =
							"string" === typeof existingValue
								? makeDevicesValue(
										params.subtype,
										params.devices,
										existingValue,
										params.min,
										params.max,
									)
								: existingValue;

						const parent = this.parentNode;

						const device =
							parent instanceof HTMLElement
								? parent.dataset.wpbfDevice
								: undefined;

						if (
							!device ||
							!valueRecord ||
							!valueRecord.hasOwnProperty(device)
						) {
							return;
						}

						let fieldValue: string | number =
							this instanceof HTMLInputElement ||
							this instanceof HTMLTextAreaElement
								? this.value
								: "";

						if (
							"number" === params.subtype ||
							"number-unit" === params.subtype
						) {
							params.max = normalizeMaxValue(params.min, params.max);

							fieldValue =
								"number" === params.subtype
									? limitNumber(fieldValue, params.min, params.max)
									: limitNumberWithUnit(fieldValue, params.min, params.max);
						}

						valueRecord[device] = fieldValue;

						const customizerValue = params.saveAsJson
							? encodeJsonOrDefault(valueRecord)
							: valueRecord;

						control.setting?.set(customizerValue);
					});
			},
		},
	);
