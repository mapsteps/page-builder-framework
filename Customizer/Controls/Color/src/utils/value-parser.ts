import {
	WpbfColorPickerValue,
	WpbfCustomizeColorControlValue,
} from "../color-interface";
import convertColorForCustomizer from "./convert-color-for-customizer";
import convertColorForInput from "./convert-color-for-input";
import convertColorForPicker from "./convert-color-for-picker";

/**
 * Check if the provided value is a numeric.
 *
 * Thanks to Dan (https://stackoverflow.com/users/17121/dan) for his answer on StackOverflow:
 * @see https://stackoverflow.com/questions/175739/built-in-way-in-javascript-to-check-if-a-string-is-a-valid-number#answer-175787
 */
export function isNumeric(char: WpbfCustomizeColorControlValue): boolean {
	// Number is a numeric.
	if ("number" === typeof char) return true;

	// We only process strings.
	if ("string" !== typeof char) return false;

	return !isNaN(parseFloat(char));
}

export function parseEmptyValue(useHueMode: boolean) {
	return useHueMode ? 0 : "#000000";
}

export function parseHueModeValue(value: WpbfCustomizeColorControlValue) {
	if (typeof value === "string" && isNumeric(value)) {
		value = Number(value);
	} else if (typeof value === "object" && "h" in value) {
		value = value.h || 0 === value.h ? value.h : value;
	}

	if (typeof value !== "number") {
		return 0;
	}

	value = value < 0 ? 0 : value;

	return value > 360 ? 360 : value;
}

export function parseInputValue(
	value: WpbfCustomizeColorControlValue,
	pickerComponent: string,
	formComponent?: string,
	useHueMode?: boolean,
): string {
	if ("" === value) return "";

	if (useHueMode) {
		return String(parseHueModeValue(value));
	}

	if (typeof value === "number") {
		return "";
	}

	return convertColorForInput(value, pickerComponent, formComponent).replace(
		";",
		"",
	);
}

export function parseCustomizerValue(
	value: WpbfColorPickerValue,
	pickerComponent: string,
	formComponent?: string,
) {
	if ("" === value) return "";
	return convertColorForCustomizer(value, pickerComponent, formComponent);
}

export function parsePickerValue(
	value: WpbfCustomizeColorControlValue,
	pickerComponent: string,
	useHueMode: boolean,
) {
	value = value || parseEmptyValue(useHueMode);

	if (typeof value === "number") {
		return { h: value, s: 100, l: 50 };
	}

	// Hard coded saturation and lightness when using hue mode.
	return convertColorForPicker(value, pickerComponent);
}
