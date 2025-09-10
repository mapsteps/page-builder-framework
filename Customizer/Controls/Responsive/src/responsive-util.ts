import { limitNumber, makeNumberUnitPair } from "../../Generic/src/number-util";
import { parseJsonOrUndefined } from "../../Generic/src/string-util";
import { DevicesValue } from "./interface";

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
 * @param {number|undefined|null} min - The minimum value.
 * @param {number|undefined|null} max - The maximum value.
 *
 * @return {DevicesValue}
 */
export function makeDevicesValue(
	fieldType: string,
	devices: string[],
	value: string | DevicesValue,
	min?: number | null,
	max?: number | null,
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

		let val = valueObject[device];

		if (fieldType === "number") {
			val = parseNumberValue(valueObject[device], min, max);
		}

		devicesValue[device] =
			"string" !== typeof val && "number" !== typeof val ? "" : val;
	});

	return devicesValue;
}

/**
 * Make a value for an input field.
 *
 * @export
 *
 * @param {string | number} value - The value to convert.
 * @param {number|undefined|null} min - The minimum value.
 * @param {number|undefined|null} max - The maximum value.
 *
 * @return {string|number} The value for the input field.
 */
export function parseNumberValue(
	value: string | number,
	min?: number | null,
	max?: number | null,
): string | number {
	let strValue = String(value).trim();

	if (strValue === "") {
		return "";
	}

	const startTypingNegative = strValue === "-";
	if (startTypingNegative) return "-";

	const startTypingDecimal = strValue.endsWith(".");
	strValue = startTypingDecimal ? strValue.replace(".", "") : strValue;

	const valueObject = makeNumberUnitPair(value);

	if ("" === valueObject.number) {
		return startTypingDecimal ? "0." : "";
	}

	let numeric: number | "" = valueObject.number;

	if ("number" === typeof min || "number" === typeof max) {
		numeric = limitNumber(numeric, min, max);
	}

	return startTypingDecimal ? numeric + "." : numeric;
}
