import ResponsiveInputSliderControl from "./ResponsiveInputSliderControl";
import { WpbfCustomize } from "../../Base/src/interface";

declare var wp: {
	customize: WpbfCustomize;
};

// Register control type with Customizer.
wp.customize.controlConstructor["wpbf-responsive-input-slider"] =
	ResponsiveInputSliderControl;
