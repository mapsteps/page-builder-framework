import { Control_Constructor } from "wordpress__customize-browser/Control_Constructor";
import { Control } from "wordpress__customize-browser/Control";
import { Customize } from "wordpress__customize-browser/Customize";
import { WpbfCustomizeSelectControl } from "../../Select/src/interfaces";
import { Setting } from "wordpress__customize-browser/Setting";
import { WpbfCustomizeColorControl } from "../../Color/src/interfaces";
import { WpbfCustomizeDimensionControl } from "../../Dimension/src/interface";
import { WpbfCustomizeMarginPaddingControl } from "../../MarginPadding/src/interface";

export interface WpbfCustomizeSetting<T> extends Setting<T> {
	get(): T;

	notifications: any;
}

export interface WpbfCustomizeControl extends Control {
	prototype: WpbfCustomizeControl;
	setting: WpbfCustomizeSetting<any>;
	setNotificationContainer?: (el: HTMLElement) => void;
	destroy?: VoidFunction;
	updateComponentState?: (val: string) => void;

	extend(protoProps: object, classProps?: object): WpbfCustomizeControlItem;
}

export interface WpbfCustomizeDynamicControl extends WpbfCustomizeControl {
	_setUpSettingRootLinks?: () => void;
	_setUpSettingPropertyLinks?: () => void;
	initWpbfControl: (control?: Control) => void;
	actuallyEmbed: () => void;
}

export interface WpbfCustomizeControlConstructor extends Control_Constructor {
	"wpbf-checkbox": WpbfCustomizeControl;
	"wpbf-color": WpbfCustomizeColorControl;
	"wpbf-dimension": WpbfCustomizeDimensionControl;
	"wpbf-generic": WpbfCustomizeControl;
	"wpbf-margin-padding": WpbfCustomizeMarginPaddingControl;
	"wpbf-responsive-margin-padding": WpbfCustomizeMarginPaddingControl;
	"wpbf-radio": {};
	"wpbf-radio-image": {};
	"wpbf-select": WpbfCustomizeSelectControl;
	"wpbf-slider": WpbfCustomizeControl;
	"wpbf-toggle": WpbfCustomizeControl;
}

export type WpbfCustomizeControlItem =
	| WpbfCustomizeControl
	| WpbfCustomizeColorControl
	| WpbfCustomizeDynamicControl
	| WpbfCustomizeDimensionControl
	| WpbfCustomizeSelectControl
	| WpbfCustomizeMarginPaddingControl;

export interface WpbfCustomize extends Customize {
	Control: WpbfCustomizeControlItem;
	controlConstructor: WpbfCustomizeControlConstructor;
}

export interface WpbfControlDependency {
	id: string;
	operator: string;
	value: string;
}

export interface WpbfControlDependencies {
	[controlId: string]: WpbfControlDependency[];
}

export interface WpbfReversedControlDependency {
	dependantControlId: string;
	operator: string;
	value: string;
}

export interface WpbfReversedControlDependencies {
	[dependencyControlId: string]: WpbfReversedControlDependency[];
}
