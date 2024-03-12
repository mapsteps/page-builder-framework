import {
	WpbfCustomizeControl,
	WpbfCustomizeSetting,
} from "../../Base/src/interfaces";

export interface WpbfCustomizeInputSliderControl extends WpbfCustomizeControl {
	setting: WpbfCustomizeSetting<string | number>;
	updateComponentState?: (val: string|number) => void;
}

export type NumberUnitPair = {
	// The `number` prop can be an empty string.
	number: number | string;
	unit: string;
};

export type DevicesValue = {
	[device: string]: number|string;
}

export type DeviceValuePair = {
	device: string;
	value: string|number;
}

export interface WpbfCustomizeResponsiveInputSliderControl extends WpbfCustomizeControl {
	setting: WpbfCustomizeSetting<string | DevicesValue>;
	updateComponentState?: (val: string | DevicesValue) => void;
}
