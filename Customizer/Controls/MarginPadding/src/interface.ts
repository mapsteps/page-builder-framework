import {
	WpbfCustomizeControl,
	WpbfCustomizeSetting,
} from "../../Base/src/interfaces";

export type MarginPaddingDimension = "top" | "right" | "bottom" | "left";

export interface MarginPaddingValue {
	top: number | string;
	right: number | string;
	bottom: number | string;
	left: number | string;

	[dimension: string]: number | string;
}

export interface MarginPaddingSingleValueObject {
	unit: string;
	number: number;
}

export interface MarginPaddingDimensionValuePair {
	dimension: string;
	value: string | number;
}

export interface WpbfCustomizeMarginPaddingControl
	extends WpbfCustomizeControl {
	prototype: WpbfCustomizeControl;
	setting: WpbfCustomizeSetting<MarginPaddingValue | string>;
	setNotificationContainer: (el: HTMLElement) => void;
	destroy: VoidFunction;
	updateComponentState: (val: MarginPaddingValue | string) => void;
}
