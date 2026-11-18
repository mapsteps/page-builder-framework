import { WpbfCustomizeControl, WpbfCustomizeControlParams } from "../../Base/src/interface";

// An image choice of wpbf-radio-image: the image URL, or the image with its alt text (shown on hover).
export type RadioImageChoice = { src?: string; alt?: string };

export interface WpbfCustomizeRadioControlParams extends WpbfCustomizeControlParams<unknown> {
	type: "wpbf-radio" | "wpbf-radio-buttonset" | "wpbf-radio-image";

	// Radio image only: the style input attribute, also put on the image labels.
	labelStyle?: string;
}

// The control of the three radio types. The setting holds the chosen key.
export interface WpbfCustomizeRadioControl extends WpbfCustomizeControl<unknown, WpbfCustomizeRadioControlParams> {}
