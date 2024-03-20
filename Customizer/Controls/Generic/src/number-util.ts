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
 * @return {number | string} The returned value can be either `number` or empty string.
 */
export function limitNumber(
	value: string | number,
	min?: number | null,
	max?: number | null,
): number | string {
	if (value === "") {
		return "";
	}

	if (
		(typeof value !== "string" && typeof value !== "number") ||
		isNaN(Number(value))
	) {
		return "";
	}

	let parsedValue: number =
		typeof value === "string" ? parseFloat(value) : value;

	if ("number" === typeof min && "number" === typeof max) {
		if (parsedValue < min) {
			parsedValue = min;
		}

		if (parsedValue > max) {
			parsedValue = max;
		}

		return parsedValue;
	}

	if ("number" === typeof min) {
		if (parsedValue < min) {
			parsedValue = min;
		}
	} else if ("number" === typeof max) {
		if (parsedValue > max) {
			parsedValue = max;
		}
	}

	return parsedValue;
}

/**
 * Separate number and unit.
 *
 * @param {string | number} value The value to separate.
 *
 * @return {NumberUnitPair} The returned value will be a pair of `unit` and `number`.
 */
export function separateNumberAndUnit(value: string | number): NumberUnitPair {
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

	const strValue: string = typeof value === "string" ? value : String(value);

	const unit: string = strValue.replace(/\d+/g, "");
	const parsedUnit: string = unit ? unit : "";
	let numeric: string | number = parsedUnit
		? strValue.replace(parsedUnit, "")
		: strValue;

	if ("" === numeric) {
		return {
			number: "",
			unit: "",
		};
	}

	const number = parseFloat(numeric);

	return {
		number: number,
		unit: parsedUnit,
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

	const numberAndUnit = separateNumberAndUnit(value);

	const number: string | number = numberAndUnit.number;
	const unit: string = numberAndUnit.unit;

	if (number === "") {
		return "";
	}

	const limitedNumber: string | number = limitNumber(number, min, max);

	if (!unit) {
		return limitedNumber;
	}

	return `${limitedNumber}${unit}`;
}
