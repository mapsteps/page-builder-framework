import { WpbfCustomizeControl, WpbfCustomizeControlParams } from "../../Base/src/interface";

export interface WpbfCustomizeCheckboxControlParams extends WpbfCustomizeControlParams<unknown> {
	type: "wpbf-checkbox" | "wpbf-toggle";

	// Toggle only.
	checkboxType?: "toggle" | "switch";
	defaultChoices?: { on: string; off: string };
}

// The control of both checkbox types. The setting holds true or false (older saved values may be "1", "on" …).
export interface WpbfCustomizeCheckboxControl extends WpbfCustomizeControl<unknown, WpbfCustomizeCheckboxControlParams> {}
