import { makeNumberUnitPair } from "../../Generic/src/number-util";
import { parseJsonOrUndefined } from "../../Generic/src/string-util";
import { MarginPaddingDimension, MarginPaddingValue } from "./interface";

/**
 * Make a value for an input number field in margin/padding control.
 *
 * It shouldn't contain unit because it's a number field.
 *
 * @export
 *
 * @param {string | number} value - The value to convert.
 * @return {string|number} The value for the input field.
 */
export function makeMarginPaddingFieldValue(
	value: string | number,
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

	let numeric = String(valueObject.number);

	return startTypingDecimal ? numeric + "." : numeric;
}

/**
 * Create a `MarginPaddingValue` object without unit.
 *
 * Used for the input field's values in the customizer control.
 *
 * @param {string[]} dimensions - The allowed dimensions.
 * @param {MarginPaddingValue} value - The value to parse.
 *
 * @return {MarginPaddingValue} - The value as object (without unit).
 */
export function makeObjValueWithoutUnit(
	dimensions: string[],
	value: MarginPaddingValue,
): MarginPaddingValue {
	const newValue: Record<string, number | string> = {};

	for (let i = 0; i < dimensions.length; i++) {
		const dimension = dimensions[i];
		newValue[dimension] = dimensions[i];
	}

	for (const position in value) {
		if (!dimensions.includes(position)) {
			continue;
		}

		if (!value.hasOwnProperty(position)) continue;
		if (!newValue.hasOwnProperty(position)) continue;

		const positionValue = value[position];

		if ("" !== positionValue) {
			newValue[position] = makeMarginPaddingFieldValue(positionValue);
		}
	}

	return newValue as MarginPaddingValue;
}

/**
 * Create a `MarginPaddingValue` object with unit.
 *
 * Used for the customizer setting's value.
 *
 * @param {string[]} dimensions - The allowed dimensions.
 * @param {string} unit - The unit.
 * @param {MarginPaddingValue} value - The value to parse.
 *
 * @return {MarginPaddingValue} - The value as object (with unit).
 */
export function makeObjValueWithUnit(
	dimensions: string[],
	unit: string,
	value: MarginPaddingValue,
): MarginPaddingValue {
	const newValue: Record<string, number | string> = {};

	for (let i = 0; i < dimensions.length; i++) {
		const dimension = dimensions[i];
		newValue[dimension] = dimensions[i];
	}

	for (const position in value) {
		if (!dimensions.includes(position)) {
			continue;
		}

		if (!newValue.hasOwnProperty(position)) continue;

		const positionValue = value[position as MarginPaddingDimension];

		if ("" !== positionValue) {
			const singleValue = makeMarginPaddingFieldValue(positionValue);
			newValue[position] = singleValue + unit;
		}
	}

	return newValue as MarginPaddingValue;
}

export function makeObjValueWithoutUnitFromJson(
	dimensions: string[],
	jsonStr: string | null | undefined,
): MarginPaddingValue {
	const value = parseJsonOrUndefined<MarginPaddingValue>(jsonStr);

	if (!value) {
		return makeEmptyValueObj(dimensions);
	}

	return makeObjValueWithoutUnit(dimensions, value);
}

export function makeEmptyValueObj(dimensions: string[]): MarginPaddingValue {
	const value: Record<string, number | string> = {};

	for (let i = 0; i < dimensions.length; i++) {
		const dimension = dimensions[i];

		// We allow empty strings for each dimension.
		value[dimension] = "";
	}

	return value as MarginPaddingValue;
}
