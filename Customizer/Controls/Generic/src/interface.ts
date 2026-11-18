import { WpbfCustomizeControl, WpbfCustomizeControlParams } from "../../Base/src/interface";
import { DevicesValue } from "../../Responsive/src/interface";

/**
 * The setting value of the generic types: text or a number, or for the responsive type one value per device
 * (an object, or the same object as JSON text when the field saves as JSON).
 */
export type GenericSettingValue = string | number | DevicesValue;

export interface WpbfCustomizeGenericControlParams extends WpbfCustomizeControlParams<GenericSettingValue> {
	type: "wpbf-generic" | "wpbf-responsive-generic";
	subtype: string;
	inputTag: string;
	inputType?: string;
	min?: number | null;
	max?: number | null;
	step?: number | null;
	rows?: number;

	// Responsive type only.
	defaultArray?: DevicesValue;
	valueArray?: DevicesValue;
	devices?: string[];
	deviceIcons?: Record<string, string>;
	saveAsJson?: boolean;
}

// The control of both generic types.
export interface WpbfCustomizeGenericControl
	extends WpbfCustomizeControl<GenericSettingValue, WpbfCustomizeGenericControlParams> {}

export interface AssocArrayControlParams extends WpbfCustomizeControlParams<Record<string, any>> {}

export interface WpbfCustomizeAssocArrayControl extends WpbfCustomizeControl<Record<string, any>, AssocArrayControlParams> {}
