import { DevicesValue, NumberUnitPair } from "../../Responsive/src/interface";
import { parseJsonOrUndefined } from "../../Generic/src/string-util";

/**
 * Limit a value based on a min and max value.
 *
 * @export
 *
 * @param {number} value - The value to limit.
 * @param {number} min - The minimum value.
 * @param {number} max - The maximum value.
 *
 * @return {number} The limited value.
 */
export function limitValue(value: number, min: number, max: number): number {
	if (value < min) value = min;
	if (value > max) value = max;

	return value;
}

/**
 * Make a `NumberUnitPair` object from a string or number.
 *
 * @export
 *
 * @param {(string | number)} val - The value to convert.
 * @param {number} min - The minimum value.
 * @param {number} max - The maximum value.
 *
 * @return {NumberUnitPair} The `NumberUnitPair` object.
 */
export function makeNumberUnitPair(
	val: string | number,
	min: number,
	max: number,
): NumberUnitPair {
	const value = "string" === typeof val ? val : val.toString();

	if (!value) {
		return {
			number: "",
			unit: "",
		};
	}

	const valueUnit = value.replace(/\d+/g, "");
	const valueNumeric = valueUnit ? value.replace(valueUnit, "") : value;

	if (!valueNumeric) {
		return {
			number: "",
			unit: valueUnit,
		};
	}

	const floatValue = parseFloat(valueNumeric.trim());

	if (isNaN(floatValue)) {
		return {
			number: "",
			unit: valueUnit,
		};
	}

	const valueNumber = limitValue(floatValue, min, max);

	return {
		number: valueNumber,
		unit: valueUnit,
	};
}

/**
 * Make a value for an input field.
 *
 * @export
 *
 * @param {(string | number)} value - The value to convert.
 * @param {number} min - The minimum value.
 * @param {number} max - The maximum value.
 *
 * @return {string|number} The value for the input field.
 */
export function makeValueForInput(
	value: string | number,
	min: number,
	max: number,
): string | number {
	const valueObject = makeNumberUnitPair(value, min, max);

	if ("" === valueObject.number) return "";
	if (!valueObject.unit) return valueObject.number;
	return valueObject.number + valueObject.unit;
}

/**
 * Make a value for a range-slider field.
 *
 * @export
 *
 * @param {(string | number)} value - The value to convert.
 * @param {number} min - The minimum value.
 * @param {number} max - The maximum value.
 *
 * @return {number} The value for the slider.
 */
export function makeValueForSlider(
	value: string | number,
	min: number,
	max: number,
): number {
	const valueObject = makeNumberUnitPair(value, min, max);

	return "string" === typeof valueObject.number ? min : valueObject.number;
}

/**
 * Make a string value from a string or number.
 *
 * @export
 *
 * @param {(string | number)} value - The value to convert.
 *
 * @return {string} The string value.
 */
export function makeStringValue(value: string | number): string {
	return "string" === typeof value ? value : value.toString();
}

/**
 * Make an empty `DevicesValue` object.
 *
 * @param {string[]} devices - The allowed devices.
 *
 * @return {DevicesValue} Empty `DevicesValue` object.
 */
function makeEmptyDevicesValue(devices: string[]): DevicesValue {
	const value: DevicesValue = {};

	devices.forEach((device) => {
		value[device] = "";
	});

	return value;
}

/**
 * Make a `DevicesValue` object from a JSON encoded string or `DevicesValue` object.
 *
 * @export
 *
 * @param {string[]} devices - The allowed devices.
 * @param {(string | DevicesValue)} value - The value to convert.
 * @param {number} min - The minimum value.
 * @param {number} max - The maximum value.
 *
 * @return {DevicesValue}
 */
export function makeDevicesValue(
	devices: string[],
	value: string | DevicesValue,
	min: number,
	max: number,
): DevicesValue {
	const valueObject =
		"string" === typeof value
			? parseJsonOrUndefined<DevicesValue>(value)
			: value;

	if (!valueObject) {
		return makeEmptyDevicesValue(devices);
	}

	const devicesValue: DevicesValue = {};

	devices.forEach((device) => {
		if (!valueObject.hasOwnProperty(device)) {
			devicesValue[device] = "";
			return;
		}

		const val = makeValueForInput(valueObject[device], min, max);

		devicesValue[device] =
			"string" !== typeof val && "number" !== typeof val ? "" : val;
	});

	return devicesValue;
}
