import {Control_Constructor} from "wordpress__customize-browser/Control_Constructor";
import {Control} from "wordpress__customize-browser/Control";
import {Customize} from "wordpress__customize-browser/Customize";
import {WpbfCustomizeSelectControl} from "../../Select/src/interfaces";
import {Setting} from "wordpress__customize-browser/Setting";

export interface WpbfCustomizeSetting<T> extends Setting<T> {
	get(): T;
}

export interface WpbfCustomizeControl extends Control {
	prototype: WpbfCustomizeControl;
	setting: WpbfCustomizeSetting<any>;
	setNotificationContainer?: (el: HTMLElement) => void;
	destroy?: VoidFunction;
	updateComponentState?: (val: string) => void;
}

export interface WpbfCustomizeDynamicControl extends WpbfCustomizeControl {
	_setUpSettingRootLinks?: () => void;
	_setUpSettingPropertyLinks?: () => void;
	initWpbfControl: (control?: Control) => void;
	actuallyEmbed: () => void;
}

export interface WpbfCustomizeControlConstructor extends Control_Constructor {
	'wpbf-slider': WpbfCustomizeControl;
	'wpbf-select': WpbfCustomizeSelectControl;
}

export interface WpbfCustomize extends Customize {
	Control: WpbfCustomizeControl | WpbfCustomizeDynamicControl | WpbfCustomizeSelectControl;
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