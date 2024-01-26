import {Control_Constructor} from "wordpress__customize-browser/Control_Constructor";
import {Control} from "wordpress__customize-browser/Control";
import {Customize} from "wordpress__customize-browser/Customize";

export interface WpbfCustomizeControl extends Control {
	prototype: WpbfCustomizeControl;
	_setUpSettingRootLinks: () => void;
	_setUpSettingPropertyLinks: () => void;
	initWpbfControl: (control?: Control) => void;
	actuallyEmbed: () => void;
	setNotificationContainer: (el: HTMLElement) => void;
	destroy?: VoidFunction;

	updateComponentState(val: string): void;
}

export interface WpbfCustomizeControlConstructor extends Control_Constructor {
	'wpbf-slider': WpbfCustomizeControl;
}

export interface WpbfCustomize extends Customize {
	Control: WpbfCustomizeControl;
	controlConstructor: WpbfCustomizeControlConstructor;
}