import { parseJsonOrUndefined } from "../../Generic/src/string-util";
import {
	MarginPaddingDimension,
	MarginPaddingSingleValueObject,
	MarginPaddingValue,
} from "./interface";

export function parseSingleValueAsObject(
	value: string | number | null,
): MarginPaddingSingleValueObject {
	if (value === "" || value === null) {
		return {
			unit: "",
			number: "",
		};
	}

	let unit = "";
	let number: number = 0;

	value = "string" !== typeof value ? value.toString() : value;
	value = value.trim();
	const negativeSign = -1 < value.indexOf("-") ? "-" : "";
	value = value.replace(negativeSign, "");

	let numeric = "";

	if ("" !== value) {
		unit = value.replace(/\d+/g, "");
		numeric = value.replace(unit, "");
		numeric = negativeSign + numeric.trim();

		number = parseFloat(numeric);
	}

	return {
		unit: unit,
		number: number,
	};
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
			const singleValue = parseSingleValueAsObject(positionValue);
			newValue[position] = singleValue.number;
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
			const singleValue = parseSingleValueAsObject(positionValue);
			newValue[position] = singleValue.number + unit;
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
