import {
	WpbfCustomizeControl,
	WpbfCustomizeSetting,
} from "../../Base/src/interfaces";

export interface WpbfCustomizeInputSliderControl extends WpbfCustomizeControl {
	setting: WpbfCustomizeSetting<string | number>;
	updateComponentState?: (val: string|number) => void;
}

export type ValueObject = {
	// The `number` prop can be an empty string.
	number: number | string;
	unit: string;
};
