import { colord } from "colord";
import {
	WpbfColorPickerValue,
	WpbfColorControlValue,
} from "../color-interface";
import { parseHueModeValue } from "./misc";

/**
 * Convert the value for the color picker.
 *
 * @param {WpbfColorControlValue} value - The value to be converted.
 * @param {string} pickerComponent - The picker component name.
 *
 * @returns {WpbfColorPickerValue} The converted value.
 */
export default function convertColorForPicker(
	value: WpbfColorControlValue,
	useHueMode: boolean,
	pickerComponent: string,
): WpbfColorPickerValue {
	let convertedValue;

	if (useHueMode) {
		const hueValue = parseHueModeValue(value);

		// Hard coded saturation and lightness when using hue mode.
		return { h: hueValue, s: 100, l: 50 };
	}

	// If hudeMode is false, but value is a number, then hardcode the value to #000000.
	if (typeof value === "number") {
		value = "#000000";
	}

	switch (pickerComponent) {
		case "HexColorPicker":
			convertedValue = colord(value).toHex();
			break;

		case "RgbColorPicker":
			convertedValue = colord(value).toRgb();
			convertedValue = {
				r: convertedValue.r,
				g: convertedValue.g,
				b: convertedValue.b,
			};
			break;

		case "RgbStringColorPicker":
			convertedValue = colord(value).toRgbString();
			break;

		case "RgbaColorPicker":
			convertedValue = colord(value).toRgb();
			break;

		case "RgbaStringColorPicker":
			convertedValue = colord(value).toRgbString();

			// Force to set the alpha channel value.
			if (convertedValue.includes("rgb") && !convertedValue.includes("rgba")) {
				convertedValue = convertedValue.replace("rgb", "rgba");
				convertedValue = convertedValue.replace(")", ", 1)");
			}

			break;

		case "HslColorPicker":
			convertedValue = colord(value).toHsl();
			convertedValue = {
				h: convertedValue.h,
				s: convertedValue.s,
				l: convertedValue.l,
			};
			break;

		case "HslStringColorPicker":
			convertedValue = colord(value).toHslString();
			break;

		case "HslaColorPicker":
			convertedValue = colord(value).toHsl();
			break;

		case "HslaStringColorPicker":
			convertedValue = colord(value).toHslString();

			// Force to set the alpha channel value.
			if (convertedValue.includes("hsl") && !convertedValue.includes("hsla")) {
				convertedValue = convertedValue.replace("hsl", "hsla");
				convertedValue = convertedValue.replace(")", ", 1)");
			}

			break;

		case "HsvColorPicker":
			convertedValue = colord(value).toHsv();
			convertedValue = {
				h: convertedValue.h,
				s: convertedValue.s,
				v: convertedValue.v,
			};
			break;

		case "HsvStringColorPicker":
			const hsv = colord(value).toHsv();
			convertedValue = "hsv(" + hsv.h + ", " + hsv.s + "%, " + hsv.v + "%)";

			break;

		case "HsvaColorPicker":
			convertedValue = colord(value).toHsv();
			break;

		case "HsvaStringColorPicker":
			// colord library doesn't provide .toHsvString() method yet.
			const hsva = colord(value).toHsv();
			convertedValue =
				"hsva(" +
				hsva.h +
				", " +
				hsva.s +
				"%, " +
				hsva.v +
				"%, " +
				hsva.a +
				")";

			break;

		default:
			convertedValue = colord(value).toHex();
			break;
	}

	return convertedValue;
}
