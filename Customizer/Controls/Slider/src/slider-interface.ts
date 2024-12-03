import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/base-interface";
import { DevicesValue } from "../../Responsive/src/responsive-interface";

export interface WpbfSliderControlParams
	extends WpbfCustomizeControlParams<number | string> {}

export interface WpbfSliderControl
	extends WpbfCustomizeControl<number | string, WpbfSliderControlParams> {}

export interface WpbfInputSliderControlParams
	extends WpbfCustomizeControlParams<string | number> {}

export interface WpbfInputSliderControl
	extends WpbfCustomizeControl<string | number, WpbfInputSliderControlParams> {}

export interface WpbfResponsiveInputSliderControl
	extends WpbfCustomizeControl<
		string | DevicesValue,
		WpbfResponsiveInputSliderControlParams
	> {}

export interface WpbfResponsiveInputSliderControlParams
	extends WpbfCustomizeControlParams<string | DevicesValue> {}
