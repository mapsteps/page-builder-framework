import { WpbfCustomizeControl, WpbfCustomizeControlParams } from "../../Base/src/interface";
import { DevicesValue } from "../../Responsive/src/interface";

/**
 * One value of a slider: a number, or text with a unit ("20px"); "" when empty.
 */
export type SliderValue = number | string;

/**
 * The setting value of all three slider types: one value, or for the responsive slider one per device
 * (an object, or the same object as JSON text when the field saves as JSON).
 */
export type SliderSettingValue = SliderValue | DevicesValue;

export interface WpbfCustomizeSliderControlParams extends WpbfCustomizeControlParams<SliderSettingValue> {
	type: "wpbf-slider" | "wpbf-input-slider" | "wpbf-responsive-input-slider";
	min: number;
	max: number;
	step: number;

	// Responsive slider only.
	devices?: string[];
	saveAsJson?: boolean;
}

// The control of all three slider types.
export interface WpbfCustomizeSliderControl
	extends WpbfCustomizeControl<SliderSettingValue, WpbfCustomizeSliderControlParams> {}
