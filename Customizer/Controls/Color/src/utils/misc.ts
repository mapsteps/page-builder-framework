import { colord } from "colord";
import { WpbfColorControlValue } from "../color-interface";

// Thanks to Blocksy for their base64 image data in their color picker control.
export const colorBgImgData =
	"data:image/webp;base64,UklGRjIAAABXRUJQVlA4TCUAAAAvE8AEAA9w7/97/9/7f/7jAYraNmI6AJQ/1xvvMojof2BSvVEBAA==";

/**
 * Check if the provided value is a numeric.
 *
 * Thanks to Dan (https://stackoverflow.com/users/17121/dan) for his answer on StackOverflow:
 * @see https://stackoverflow.com/questions/175739/built-in-way-in-javascript-to-check-if-a-string-is-a-valid-number#answer-175787
 */
export function isNumeric(char: WpbfColorControlValue): boolean {
	// Number is a numeric.
	if ("number" === typeof char) return true;

	// We only process strings.
	if ("string" !== typeof char) return false;

	return !isNaN(parseFloat(char));
}

export function parseHueModeValue(value: WpbfColorControlValue) {
	let hueValue = 0;

	if (isNumeric(value)) {
		hueValue = Number(value);
	} else if (typeof value === "object" && "h" in value) {
		hueValue = value.h;
	} else {
		hueValue = typeof value !== "number" ? colord(value).toHsl().h : 0;
	}

	hueValue = hueValue < 0 ? 0 : hueValue;

	return hueValue > 360 ? 360 : hueValue;
}

export function hexColorFromHueModeValue(
	value: WpbfColorControlValue,
) {
	const hue = parseHueModeValue(value);
	return colord({ h: hue, s: 100, l: 50 }).toHex();
}
