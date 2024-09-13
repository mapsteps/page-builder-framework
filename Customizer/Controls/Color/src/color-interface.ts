import { HslColor, HsvColor, RgbColor } from "colord";
import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/base-interface";

export type ColorControlLabelStyle = "tooltip" | "top" | "none" | "default";

export interface WpbfCustomizeColorControlParams
	extends WpbfCustomizeControlParams<WpbfCustomizeColorControlValue> {
	mode: string;
	labelStyle: ColorControlLabelStyle;
	colorSwatches: string[];
	formComponent?: string;
}

export interface WpbfCustomizeMulticolorControlParams
	extends WpbfCustomizeControlParams<WpbfCustomizeMulticolorControlValue> {
	choices: Record<string, string>;
	mode: string;
	labelStyle: ColorControlLabelStyle;
	colorSwatches: string[];
	formComponent?: string;
}

export interface WpbfCustomizeColorControl
	extends WpbfCustomizeControl<
		WpbfCustomizeColorControlValue,
		WpbfCustomizeColorControlParams
	> {}

export interface WpbfCustomizeMulticolorControl
	extends WpbfCustomizeControl<
		WpbfCustomizeMulticolorControlValue,
		WpbfCustomizeMulticolorControlParams
	> {}

export type ColorMode =
	| "rgb"
	| "rgba"
	| "hsl"
	| "hsla"
	| "hsv"
	| "hsva"
	| "hex"
	| "";

export type RgbOrRgbaColor = RgbColor & { a?: number };

export type HslOrHslaColor = HslColor & { a?: number };

export type HsvOrHsvaColor = HsvColor & { a?: number };

export type WpbfColorObject = RgbOrRgbaColor | HslOrHslaColor | HsvOrHsvaColor;

export type WpbfColorPickerValue =
	| string
	| RgbOrRgbaColor
	| HslOrHslaColor
	| HsvOrHsvaColor;

export type WpbfCustomizeColorControlValue =
	| number
	| string
	| RgbOrRgbaColor
	| HslOrHslaColor
	| HsvOrHsvaColor;

export type WpbfCustomizeMulticolorControlValue = Record<
	string,
	WpbfCustomizeColorControlValue
>;
