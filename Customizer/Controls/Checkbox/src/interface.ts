import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/base-interface";

export interface WpbfCustomizeCheckboxControlParams
	extends WpbfCustomizeControlParams<boolean> {}

export interface WpbfCustomizeCheckboxControl
	extends WpbfCustomizeControl<boolean, WpbfCustomizeCheckboxControlParams> {}
