import { Control } from "wordpress__customize-browser/Control";
import {
	WpbfCustomizeControl,
	WpbfCustomizeSetting,
} from "../../Base/src/interfaces";

export type MarginPaddingDimension = "top" | "right" | "bottom" | "left";

// We allow empty string.
export interface MarginPaddingValuesWithoutUnit {
	top: number | string;
	right: number | string;
	bottom: number | string;
	left: number | string;

	[dimension: string]: number | string;
}

export interface MarginPaddingValuesWithUnit {
	top: string;
	right: string;
	bottom: string;
	left: string;

	[dimension: string]: string;
}

export type MarginPaddingValues =
	| MarginPaddingValuesWithoutUnit
	| MarginPaddingValuesWithUnit;

export interface MarginPaddingSingleValueObject {
	unit: string;
	number: number;
}

export interface WpbfCustomizeMarginPaddingControl extends Control {
	prototype: WpbfCustomizeControl;
	setting: WpbfCustomizeSetting<any>;
	setNotificationContainer: (el: HTMLElement) => void;
	destroy: VoidFunction;
	updateComponentState: (val: MarginPaddingValuesWithUnit) => void;
}
