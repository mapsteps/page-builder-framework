import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/base-interface";
import { DevicesValue } from "../../Responsive/src/responsive-interface";

export interface WpbfGenericControl
	extends WpbfCustomizeControl<string | number, WpbfGenericControlParams> {}

export interface WpbfGenericControlParams
	extends WpbfCustomizeControlParams<string | number> {
	subtype: string;
	inputTag: string;
	inputType?: string;
	min?: number | null;
	max?: number | null;
	step?: number | null;
	rows?: number;
}

export interface WpbfResponsiveGenericControl
	extends WpbfCustomizeControl<
		DevicesValue | string,
		WpbfResponsiveGenericControlParams
	> {}

export interface WpbfResponsiveGenericControlParams
	extends WpbfGenericControlParams {
	defaultArray: DevicesValue;
	valueArray: DevicesValue;
	devices: string[];
	deviceIcons: Record<string, string>;
	saveAsJson: boolean;
}

export interface WpbfAssocArrayControlParams
	extends WpbfCustomizeControlParams<Record<string, any>> {}

export interface WpbfAssocArrayControl
	extends WpbfCustomizeControl<
		Record<string, any>,
		WpbfAssocArrayControlParams
	> {}
