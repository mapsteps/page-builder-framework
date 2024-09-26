import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/base-interface";
import { DevicesValue } from "../../Responsive/src/responsive-interface";

export interface WpbfCustomizeSliderControlParams
	extends WpbfCustomizeControlParams<number | string> {}

export interface WpbfCustomizeSliderControl
	extends WpbfCustomizeControl<
		number | string,
		WpbfCustomizeSliderControlParams
	> {}

export interface WpbfCustomizeInputSliderControlParams
	extends WpbfCustomizeControlParams<string | number> {}

export interface WpbfCustomizeInputSliderControl
	extends WpbfCustomizeControl<
		string | number,
		WpbfCustomizeInputSliderControlParams
	> {}

export interface WpbfCustomizeResponsiveInputSliderControl
	extends WpbfCustomizeControl<
		string | DevicesValue,
		WpbfCustomizeResponsiveInputSliderControlParams
	> {}

export interface WpbfCustomizeResponsiveInputSliderControlParams
	extends WpbfCustomizeControlParams<string | DevicesValue> {}
