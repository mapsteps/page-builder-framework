import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";

export interface WpbfCustomizeRepeaterControlParams
	extends WpbfCustomizeControlParams<any> {}

export interface WpbfCustomizeRepeaterControl
	extends WpbfCustomizeControl<any, WpbfCustomizeRepeaterControlParams> {}
