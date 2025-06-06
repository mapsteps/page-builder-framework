import { colord } from "colord";
import { WpbfColorControlValue } from "../color-interface";
import { isNumeric } from "../../../Generic/src/number-util";

// Thanks to Blocksy for their base64 image data in their color picker control.
export const colorBgImgData =
	"data:image/webp;base64,UklGRjIAAABXRUJQVlA4TCUAAAAvE8AEAA9w7/97/9/7f/7jAYraNmI6AJQ/1xvvMojof2BSvVEBAA==";

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

export function hexColorFromHueModeValue(value: WpbfColorControlValue) {
	const hue = parseHueModeValue(value);
	return colord({ h: hue, s: 100, l: 50 }).toHex();
}
