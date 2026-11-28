import { HslColor, HsvColor, RgbColor } from "colord";
import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";

export interface WpbfCustomizeColorControlParams
	extends WpbfCustomizeControlParams<WpbfCustomizeColorControlValue> {
	mode: string;
	labelStyle: string;
	colorSwatches: string[];
	formComponent?: string;
	colorGroup?: WpbfColorGroup;
}

/**
 * A color's place in a row of states (ColorControl::get_color_group()): the row's first color ("Normal") lists the
 * others, each other one ("Hover", "Active") names the first.
 */
export interface WpbfColorGroup {
	role: "leader" | "member";
	caption: string;
	members?: string[];
	leader?: string;
}

export interface WpbfCustomizeColorControl
	extends WpbfCustomizeControl<
		WpbfCustomizeColorControlValue,
		WpbfCustomizeColorControlParams
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

export type WpbfCustomizeColorControlValue =
	| string
	| number
	| RgbOrRgbaColor
	| HslOrHslaColor
	| HsvOrHsvaColor;
