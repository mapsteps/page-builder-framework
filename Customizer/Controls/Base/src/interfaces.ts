import {Customize} from "@wordpress/customize-browser/Customize";
import {Control} from "@wordpress/customize-browser/Control";

export interface WPCustomize extends Customize {
	Control: Control;
	wpbfDynamicControl?: Control;
}