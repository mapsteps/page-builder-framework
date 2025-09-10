import { DevicesValue } from "../../Responsive/src/interface";
import { parseJsonOrUndefined } from "../../Generic/src/string-util";
import { makeLimitedNumberUnitPair } from "../../Generic/src/number-util";

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
	let strValue = String(value).trim();

	const isTypingNegative = strValue === "-";
	if (isTypingNegative) return "-";

	const isTypingDecimal = strValue.endsWith(".");
	strValue = isTypingDecimal ? strValue.replace(".", "") : strValue;

	const valueObject = makeLimitedNumberUnitPair(value, min, max);

	if ("" === valueObject.number) {
		return isTypingDecimal ? "0." : "";
	}

	let numeric = String(valueObject.number);

	/**
	 * Having `isTypingDecimal` means, the latest char is a decimal point.
	 * No unit is allowed before the decimal point.
	 */
	if (isTypingDecimal) return numeric + ".";

	return valueObject.unit
		? numeric +
				(valueObject.hasTrailingDotBeforeUnit ? "." : "") +
				valueObject.unit
		: numeric;
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
	const valueObject = makeLimitedNumberUnitPair(value, min, max);

	return "" === valueObject.number ? min : valueObject.number;
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
