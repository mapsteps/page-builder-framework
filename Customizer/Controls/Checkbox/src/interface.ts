import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";

export interface WpbfCustomizeCheckboxControlParams
	extends WpbfCustomizeControlParams<boolean> {}

export interface WpbfCustomizeCheckboxControl
	extends WpbfCustomizeControl<boolean, WpbfCustomizeCheckboxControlParams> {}
