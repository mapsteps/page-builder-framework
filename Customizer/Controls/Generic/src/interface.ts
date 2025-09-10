import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";
import { DevicesValue } from "../../Responsive/src/interface";

export interface WpbfCustomizeGenericControl
	extends WpbfCustomizeControl<
		string | number,
		WpbfCustomizeGenericControlParams
	> {}

export interface WpbfCustomizeGenericControlParams
	extends WpbfCustomizeControlParams<string | number> {
	subtype: string;
	inputTag: string;
	inputType?: string;
	min?: number | null;
	max?: number | null;
	step?: number | null;
	rows?: number;
}

export interface WpbfCustomizeResponsiveGenericControl
	extends WpbfCustomizeControl<
		DevicesValue | string,
		WpbfCustomizeResponsiveGenericControlParams
	> {}

export interface WpbfCustomizeResponsiveGenericControlParams
	extends WpbfCustomizeGenericControlParams {
	defaultArray: DevicesValue;
	valueArray: DevicesValue;
	devices: string[];
	deviceIcons: Record<string, string>;
	saveAsJson: boolean;
}

export interface AssocArrayControlParams
	extends WpbfCustomizeControlParams<Record<string, any>> {}

export interface WpbfCustomizeAssocArrayControl
	extends WpbfCustomizeControl<Record<string, any>, AssocArrayControlParams> {}
