import { isNumeric } from "../../Generic/src/number-util";
import {
	ColorMode,
	HslOrHslaColor,
	HsvOrHsvaColor,
	RgbOrRgbaColor,
	WpbfColorObject,
	WpbfColorControlValue,
} from "./color-interface";

(() => {
	/**
	 * Generate value from color object.
	 */
	function generateStringValueFromColorObj(value: WpbfColorObject): string {
		let alphaEnabled = false;
		let colorMode: ColorMode = "";

		let pos1 = 0;
		let pos2: string | number = 0;
		let pos3: string | number = 0;
		let pos4 = 0;

		if (
			value.hasOwnProperty("r") &&
			value.hasOwnProperty("g") &&
			value.hasOwnProperty("b")
		) {
			colorMode = value.hasOwnProperty("a") ? "rgba" : "rgb";
			alphaEnabled = "rgba" === colorMode ? true : alphaEnabled;

			const val: RgbOrRgbaColor = value as RgbOrRgbaColor;

			pos1 = val.r;
			pos2 = val.g;
			pos3 = val.b;
			pos4 = "rgba" === colorMode ? (val.a ?? 1) : 1;
		} else if (value.hasOwnProperty("h") && value.hasOwnProperty("s")) {
			const val: HslOrHslaColor | HsvOrHsvaColor = value as
				| HslOrHslaColor
				| HsvOrHsvaColor;
			pos1 = val.h;

			if (value.hasOwnProperty("l")) {
				colorMode = value.hasOwnProperty("a") ? "hsla" : "hsl";
				pos2 = isNumeric((val as HslOrHslaColor).l)
					? (val as HslOrHslaColor).l + "%"
					: (val as HslOrHslaColor).l;
			} else if (value.hasOwnProperty("v")) {
				colorMode = value.hasOwnProperty("a") ? "hsva" : "hsv";
				pos2 = isNumeric((val as HsvOrHsvaColor).v)
					? (val as HsvOrHsvaColor).v + "%"
					: (val as HsvOrHsvaColor).v;
			}

			alphaEnabled =
				"hsla" === colorMode || "hsva" === colorMode ? true : alphaEnabled;

			pos3 = isNumeric(val.s) ? val.s + "%" : val.s;
			pos4 = alphaEnabled ? (val.a ?? 1) : 1;
		}

		let formattedValue: string;

		if (alphaEnabled) {
			formattedValue =
				colorMode + "(" + pos1 + ", " + pos2 + ", " + pos3 + ", " + pos4 + ")";
		} else {
			formattedValue = colorMode + "(" + pos1 + ", " + pos2 + ", " + pos3 + ")";
		}

		return formattedValue;
	}

	/**
	 * Function to hook into `wpbfPostMessageStylesOutput` filter.
	 *
	 * @param {string} styles - The styles to be filtered.
	 * @param {WpbfColorControlValue} value - The control's value.
	 * @param {object} output - The control's output argument.
	 * @param {string} controlType - The control type.
	 *
	 * @return {string} The filtered styles.
	 */
	function stylesOutput(
		styles: string,
		value: WpbfColorControlValue,
		output: any,
		controlType: string,
	): string {
		if ("wpbf-color" !== controlType) return styles;
		if ("string" === typeof value || "number" === typeof value) return styles;

		const prefix = output.prefix ? output.prefix : "";
		const suffix = output.suffix ? output.suffix : "";

		styles +=
			output.element +
			"{" +
			output.property +
			": " +
			prefix +
			generateStringValueFromColorObj(value) +
			suffix +
			";\
		}";

		return styles;
	}

	// Hook the function to the `wpbfPostMessageStylesOutput` filter.
	window.wp.hooks.addFilter(
		"wpbfPostMessageStylesOutput",
		"wpbf",
		stylesOutput,
	);
})();
