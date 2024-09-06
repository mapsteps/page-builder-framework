import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/base-interface";

export interface WpbfCustomizeDimensionControlParams
	extends WpbfCustomizeControlParams<string | number> {
	inputClass: string;
	labelPosition: string;
	allowUnitless: boolean;
}

export interface WpbfCustomizeDimensionControl
	extends WpbfCustomizeControl<
		string | number,
		WpbfCustomizeDimensionControlParams
	> {}
