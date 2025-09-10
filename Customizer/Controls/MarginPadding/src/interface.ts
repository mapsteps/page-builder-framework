import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";

export type MarginPaddingDimension = "top" | "right" | "bottom" | "left";

export interface MarginPaddingValue {
	top: number | string;
	right: number | string;
	bottom: number | string;
	left: number | string;

	[dimension: string]: number | string;
}

export interface MarginPaddingDimensionValuePair {
	dimension: string;
	value: string | number;
}

export interface WpbfCustomizeMarginPaddingControlParams
	extends WpbfCustomizeControlParams<MarginPaddingValue | string> {}

export interface WpbfCustomizeMarginPaddingControl
	extends WpbfCustomizeControl<
		MarginPaddingValue | string,
		WpbfCustomizeMarginPaddingControlParams
	> {}
