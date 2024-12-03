import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/base-interface";

export interface WpbfDimensionControlParams
	extends WpbfCustomizeControlParams<string | number> {
	inputClass: string;
	labelPosition: string;
	allowUnitless: boolean;
}

export interface WpbfDimensionControl
	extends WpbfCustomizeControl<string | number, WpbfDimensionControlParams> {}
