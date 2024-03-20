import { Control_Constructor } from "wordpress__customize-browser/Control_Constructor";
import { Control, Control_Params } from "wordpress__customize-browser/Control";
import { Customize } from "wordpress__customize-browser/Customize";
import { WpbfCustomizeSelectControl } from "../../Select/src/interfaces";
import { Setting } from "wordpress__customize-browser/Setting";
import { WpbfCustomizeColorControl } from "../../Color/src/interfaces";
import { WpbfCustomizeDimensionControl } from "../../Dimension/src/interface";
import { WpbfCustomizeMarginPaddingControl } from "../../MarginPadding/src/interface";
import {
	WpbfCustomizeInputSliderControl,
	WpbfCustomizeResponsiveInputSliderControl,
} from "../../Slider/src/interface";
import { WpbfCustomizeSortableControl } from "../../Sortable/src/interface";
import { Section_Constructor } from "wordpress__customize-browser/Section_Constructor";
import { Section, Section_Params } from "wordpress__customize-browser/Section";
import {
	WpbfCustomizeGenericControl,
	WpbfCustomizeResponsiveGenericControl,
} from "../../Generic/src/interface";

export interface WpbfCustomizeSetting<T> extends Setting<T> {
	get(): T;

	notifications: any;
}

export interface WpbfCustomizeControlParams extends Control_Params {
	sectionId: string;
	default: any;
	value: any;
	choices: any[];
	link: string;
	id: string;
	ajaxurl: string;
	inputAttrs: Record<string, number | string>;
	inputId: string;
	wrapperAttrs: Record<string, number | string>;
	allowCollapse: boolean;
	[key: string]: any;
}

export interface WpbfCustomizeControl extends Control {
	prototype: WpbfCustomizeControl;
	setting: WpbfCustomizeSetting<any>;
	params: WpbfCustomizeControlParams;
	setNotificationContainer?: (el: HTMLElement) => void;
	destroy?: VoidFunction;
	updateComponentState?: (val: any) => void;

	extend<CT>(this: CT, protoProps: object, classProps?: object): CT;
}

export interface WpbfCustomizeDynamicControl extends WpbfCustomizeControl {
	_setUpSettingRootLinks?: () => void;
	_setUpSettingPropertyLinks?: () => void;
	initWpbfControl: (control?: WpbfCustomizeDynamicControl) => void;
	actuallyEmbed: () => void;
}

export type WpbfCustomizeControlItem =
	| WpbfCustomizeControl
	| WpbfCustomizeColorControl
	| WpbfCustomizeDynamicControl
	| WpbfCustomizeDimensionControl
	| WpbfCustomizeGenericControl
	| WpbfCustomizeResponsiveGenericControl
	| WpbfCustomizeInputSliderControl
	| WpbfCustomizeResponsiveInputSliderControl
	| WpbfCustomizeMarginPaddingControl
	| WpbfCustomizeSelectControl
	| WpbfCustomizeSortableControl;

export interface WpbfCustomizeControlConstructor extends Control_Constructor {
	"wpbf-checkbox": WpbfCustomizeControl;
	"wpbf-color": WpbfCustomizeColorControl;
	"wpbf-dimension": WpbfCustomizeDimensionControl;
	"wpbf-generic": WpbfCustomizeGenericControl;
	"wpbf-responsive-generic": WpbfCustomizeResponsiveGenericControl;
	"wpbf-image": WpbfCustomizeControl;
	"wpbf-margin-padding": WpbfCustomizeMarginPaddingControl;
	"wpbf-responsive-margin-padding": WpbfCustomizeMarginPaddingControl;
	"wpbf-radio": {};
	"wpbf-radio-buttonset": {};
	"wpbf-radio-image": {};
	"wpbf-select": WpbfCustomizeSelectControl;
	"wpbf-slider": WpbfCustomizeControl;
	"wpbf-input-slider": WpbfCustomizeInputSliderControl;
	"wpbf-responsive-input-slider": WpbfCustomizeResponsiveInputSliderControl;
	"wpbf-sortable": WpbfCustomizeSortableControl;
	"wpbf-toggle": WpbfCustomizeControl;
}

export interface WpbfCustomizeSectionConstructor extends Section_Constructor {
	"wpbf-link": any;
}

export interface WpbfSectionParams extends Section_Params {
	section?: WpbfCustomizeSection;
}

export interface WpbfCustomizeSection extends Section {
	params: WpbfSectionParams;
}

export interface WpbfCustomize extends Customize {
	Control: WpbfCustomizeControlItem;
	controlConstructor: WpbfCustomizeControlConstructor;
	sectionConstructor: WpbfCustomizeSectionConstructor;
	wpbfDynamicControl: WpbfCustomizeDynamicControl;
}

export interface WpbfControlDependency {
	id: string;
	operator: string;
	value: string;
}

export interface WpbfReversedControlDependency {
	dependantControlId: string;
	operator: string;
	value: string;
}

export interface WpbfReversedControlDependencies {
	[dependencyControlId: string]: WpbfReversedControlDependency[];
}
