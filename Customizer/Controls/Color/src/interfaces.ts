import { HslColor, HsvColor, RgbColor } from "colord";
import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";
import {
	WpbfCustomizeSelectOptionGroup,
	WpbfCustomizeSelectOptionObject,
} from "../../Select/src/interfaces";

export interface WpbfCustomizeColorControlParams
	extends WpbfCustomizeControlParams {
	mode: string;
	labelStyle: string;
	formComponent: string;
	colorSwatches: string[];
}

export interface WpbfCustomizeColorControl extends WpbfCustomizeControl {
	params: WpbfCustomizeColorControlParams;
	formatOptions: () =>
		| string[]
		| WpbfCustomizeSelectOptionObject[]
		| WpbfCustomizeSelectOptionGroup[];
	getFormattedOptions: () => any[];
	getOptionProps: (value: any) => any[];
}

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
