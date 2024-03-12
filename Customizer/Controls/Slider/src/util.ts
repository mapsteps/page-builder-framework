import { NumberUnitPair } from "./interface";

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
 * @return {string} The value for the input field.
 */
export function makeValueForInput(
	value: string | number,
	min: number,
	max: number,
): string {
	const valueObject = makeNumberUnitPair(value, min, max);
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
