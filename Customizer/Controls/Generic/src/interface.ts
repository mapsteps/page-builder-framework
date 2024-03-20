import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
	WpbfCustomizeSetting,
} from "../../Base/src/interfaces";
import { DevicesValue } from "../../Responsive/src/interface";

export interface WpbfCustomizeGenericControlParams
	extends WpbfCustomizeControlParams {
	subtype: string;
	inputTag: string;
	inputType?: string;
	min?: number | null;
	max?: number | null;
	step?: number | null;
	rows?: number;
}

export interface WpbfCustomizeGenericControl extends WpbfCustomizeControl {
	setting: WpbfCustomizeSetting<string | number>;
	params: WpbfCustomizeGenericControlParams;
	updateComponentState?: (val: string | number) => void;
}

export interface WpbfCustomizeResponsiveGenericControlParams
	extends WpbfCustomizeGenericControlParams {
	defaultArray: DevicesValue;
	valueArray: DevicesValue;
	devices: string[];
	deviceIcons: Record<string, string>;
	saveAsJson: boolean;
}

export interface WpbfCustomizeResponsiveGenericControl
	extends WpbfCustomizeControl {
	setting: WpbfCustomizeSetting<DevicesValue | string>;
	params: WpbfCustomizeResponsiveGenericControlParams;
	updateComponentState?: (val: DevicesValue | string) => void;
}
