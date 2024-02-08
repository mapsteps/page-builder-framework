import {
	HslColor,
	HslaColor,
	HsvColor,
	HsvaColor,
	RgbColor,
	RgbaColor,
} from "colord";

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
