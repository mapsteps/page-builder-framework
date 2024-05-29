import { NumberUnitPair } from "../../Responsive/src/interface";

export function normalizeMaxValue(
	min: number | null | undefined,
	max: number | null | undefined,
): number | null | undefined {
	if ("undefined" === typeof min || "undefined" === typeof max) {
		return max;
	}

	if (null === min || null === max) {
		return max;
	}

	return Math.max(min, max);
}

/**
 * Limit number based on the min and max values.
 *
 * @param {string | number} value - The value to parse.
 * @param {number | null | undefined} min - The minimum value. Null or undefined if not set.
 * @param {number | null | undefined} max - The maximum value. Null or undefined if not set.
 *
 * @return {number | ""} The returned value can be either `number` or empty string.
 */
export function limitNumber(
	value: string | number,
	min?: number | null,
	max?: number | null,
): number | "" {
	if (value === "") {
		return "";
	}

	if (
		(typeof value !== "string" && typeof value !== "number") ||
		isNaN(Number(value))
	) {
		return "";
	}

	let parsedValue = typeof value === "string" ? parseFloat(value) : value;

	if ("number" === typeof min) {
		if (parsedValue < min) {
			parsedValue = min;
		}
	}

	if ("number" === typeof max) {
		if (parsedValue > max) {
			parsedValue = max;
		}
	}

	return parsedValue;
}

export function getUnit(value: any): string {
	const strValue = String(value);
	const unitPattern = /[a-z%]+$/i;
	const unitMatch = strValue.match(unitPattern);

	return unitMatch ? unitMatch[0] : "";
}

/**
 * Separate number and unit.
 *
 * @param {string | number} value The value to separate.
 *
 * @return {NumberUnitPair} The returned value will be a pair of `unit` and `number`.
 */
export function makeNumberUnitPair(value: string | number): NumberUnitPair {
	// We support empty string.
	if (value === "") {
		return {
			number: "",
			unit: "",
		};
	}

	if (
		(typeof value !== "string" && typeof value !== "number") ||
		isNaN(Number(value))
	) {
		return {
			number: "",
			unit: "",
		};
	}

	const strValue = String(value);
	const unit = getUnit(strValue);
	let numeric = unit ? strValue.replace(unit, "") : strValue;

	if ("" === numeric) {
		return {
			number: "",
			unit: unit,
		};
	}

	const number = parseFloat(numeric);

	if (isNaN(number)) {
		return {
			number: "",
			unit: unit,
		};
	}

	return {
		number: number,
		unit: unit,
	};
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
export function makeLimitedNumberUnitPair(
	val: string | number,
	min: number,
	max: number,
): NumberUnitPair {
	const valueObject = makeNumberUnitPair(val);

	if ("" === valueObject.number) {
		return valueObject;
	}

	const number = limitNumber(valueObject.number, min, max);

	return {
		number: number,
		unit: valueObject.unit,
	};
}

/**
 * Limit number with unit based on the min and max values.
 *
 * @param {string | number} value The value to parse.
 * @param {number | null | undefined} min The minimum value. Null or undefined if not set.
 * @param {number | null | undefined} max The maximum value. Null or undefined if not set.
 *
 * @return {string | number} The returned value can be either `number`, `string`, or concatenation between value and unit.
 */
export function limitNumberWithUnit(
	value: string | number,
	min?: number | null,
	max?: number | null,
): string | number {
	if (value === "") {
		return "";
	}

	if (
		(typeof value !== "string" && typeof value !== "number") ||
		isNaN(Number(value))
	) {
		return "";
	}

	const numberAndUnit = makeNumberUnitPair(value);

	const number = numberAndUnit.number;
	const unit: string = numberAndUnit.unit;

	if (number === "") {
		return "";
	}

	const limitedNumber = limitNumber(number, min, max);

	if (!unit) {
		return limitedNumber;
	}

	return `${limitedNumber}${unit}`;
}
