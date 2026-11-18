import { WpbfCustomizeControl, WpbfCustomizeControlParams } from "../../Base/src/interface";

// A CSS size as typed ("20px", "50%", "auto" …).
export type DimensionValue = string | number;

export interface WpbfCustomizeDimensionControlParams extends WpbfCustomizeControlParams<DimensionValue> {
	inputClass: string;
	labelPosition: string;
	allowUnitless: boolean;
}

export interface WpbfCustomizeDimensionControl
	extends WpbfCustomizeControl<DimensionValue, WpbfCustomizeDimensionControlParams> {}
