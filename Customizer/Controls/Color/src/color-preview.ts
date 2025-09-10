import hooks from "@wordpress/hooks";
import {
  ColorMode,
  HslOrHslaColor,
  HsvOrHsvaColor,
  RgbOrRgbaColor,
} from "./interface";
import { ObjectColor } from "colord/types";

declare var wp: {
  hooks: typeof hooks;
};

(() => {
  /**
   * Check if the provided value is a numeric.
   *
   * Thanks to Dan (https://stackoverflow.com/users/17121/dan) for his answer on StackOverflow:
   * @see https://stackoverflow.com/questions/175739/built-in-way-in-javascript-to-check-if-a-string-is-a-valid-number#answer-175787
   */
  function isNumeric(char: string | number | ObjectColor): boolean {
    // Number is a numeric.
    if ("number" === typeof char) return true;

    // We only process strings.
    if ("string" !== typeof char) return false;

    return !isNaN(parseFloat(char));
  }

  /**
   * Generate value from color object.
   */
  function generateStringValueFromColorObj(value: ObjectColor): string {
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
      pos4 = "rgba" === colorMode ? val.a ?? 1 : 1;
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
      pos4 = alphaEnabled ? val.a ?? 1 : 1;
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
   * @param {string|number|ObjectColor} value - The control's value.
   * @param {object} output - The control's output argument.
   * @param {string} controlType - The control type.
   *
   * @return {string} The filtered styles.
   */
  function stylesOutput(
    styles: string,
    value: string | number | ObjectColor,
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
  wp.hooks.addFilter("wpbfPostMessageStylesOutput", "wpbf", stylesOutput);
})();
