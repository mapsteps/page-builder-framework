import ResponsiveInputSliderControl from "./ResponsiveInputSliderControl";
import { WpbfCustomize } from "../../Base/src/interface";
import { WpbfCustomizeResponsiveInputSliderControl } from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

// Register control type with Customizer.
wp.customize.controlConstructor["wpbf-responsive-input-slider"] =
	ResponsiveInputSliderControl as WpbfCustomizeResponsiveInputSliderControl;
