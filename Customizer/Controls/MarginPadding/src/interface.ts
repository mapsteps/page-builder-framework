import { WpbfCustomizeControl, WpbfCustomizeControlParams } from "../../Base/src/interface";

export type MarginPaddingDimension = "top" | "right" | "bottom" | "left";

// One value per side (e.g. top or, responsive, desktop_top): a number, text ("10", "10px"), or "" when empty.
export interface MarginPaddingValue {
	[dimension: string]: number | string;
}

// The setting value: the sides as an object, or the same object as JSON text (`saveAsJson`).
export type MarginPaddingSettingValue = MarginPaddingValue | string;

export interface WpbfCustomizeMarginPaddingControlParams extends WpbfCustomizeControlParams<MarginPaddingSettingValue> {
	type: "wpbf-margin-padding" | "wpbf-responsive-margin-padding";
	subtype: string;
	valueArray: MarginPaddingValue;
	defaultArray: MarginPaddingValue;
	unit: string;
	dimensions: string[];
	saveAsJson: boolean;
	dontSaveUnit: boolean;

	// Responsive type only.
	devices?: string[];
}

// The control of both margin/padding types.
export interface WpbfCustomizeMarginPaddingControl
	extends WpbfCustomizeControl<MarginPaddingSettingValue, WpbfCustomizeMarginPaddingControlParams> {}
