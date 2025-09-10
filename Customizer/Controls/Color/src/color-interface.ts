import { HslColor, HsvColor, RgbColor } from "colord";
import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/base-interface";

export type ColorControlLabelStyle =
	| "tooltip"
	| "top"
	| "none"
	| "label_only"
	| "default";

export interface WpbfColorControlParams
	extends WpbfCustomizeControlParams<WpbfColorControlValue> {
	mode: string;
	labelStyle: ColorControlLabelStyle;
	colorSwatches: string[];
	formComponent?: string;
}

export interface WpbfMulticolorControlParams
	extends WpbfCustomizeControlParams<WpbfMulticolorControlValue> {
	choices: Record<string, string>;
	mode: string;
	labelStyle: ColorControlLabelStyle;
	colorSwatches: string[];
	formComponent?: string;
}

export interface WpbfColorControl
	extends WpbfCustomizeControl<WpbfColorControlValue, WpbfColorControlParams> {}

export interface WpbfMulticolorControl
	extends WpbfCustomizeControl<
		WpbfMulticolorControlValue,
		WpbfMulticolorControlParams
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

export type WpbfColorControlValue =
	| number
	| string
	| RgbOrRgbaColor
	| HslOrHslaColor
	| HsvOrHsvaColor;

export type WpbfMulticolorControlValue = Record<string, WpbfColorControlValue>;
