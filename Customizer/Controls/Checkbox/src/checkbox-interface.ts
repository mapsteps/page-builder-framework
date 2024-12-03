import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/base-interface";

export interface WpbfCheckboxControlParams
	extends WpbfCustomizeControlParams<boolean> {}

export interface WpbfCheckboxControl
	extends WpbfCustomizeControl<boolean, WpbfCheckboxControlParams> {}

export type WpbfCheckboxButtonsetControlValue = string[];

export interface WpbfCheckboxButtonsetControlParams
	extends WpbfCustomizeControlParams<WpbfCheckboxButtonsetControlValue> {}

export interface WpbfCheckboxButtonsetControl
	extends WpbfCustomizeControl<
		WpbfCheckboxButtonsetControlValue,
		WpbfCheckboxButtonsetControlParams
	> {}
