import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/base-interface";

export interface WpbfCustomizeCheckboxControlParams
	extends WpbfCustomizeControlParams<boolean> {}

export interface WpbfCustomizeCheckboxControl
	extends WpbfCustomizeControl<boolean, WpbfCustomizeCheckboxControlParams> {}

export type WpbfCheckboxButtonsetControlValue = string[];

export interface WpbfCustomizeCheckboxButtonsetControlParams
	extends WpbfCustomizeControlParams<WpbfCheckboxButtonsetControlValue> {}

export interface WpbfCustomizeCheckboxButtonsetControl
	extends WpbfCustomizeControl<
		WpbfCheckboxButtonsetControlValue,
		WpbfCustomizeCheckboxButtonsetControlParams
	> {}
