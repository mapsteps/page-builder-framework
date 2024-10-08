import "./slider-control.scss";
import SliderControl from "./SliderControl";
import { WpbfCustomizeSliderControl } from "./slider-interface";

declare var wp: {
	customize: WpbfCustomize;
};

// Register control type with Customizer.
wp.customize.controlConstructor["wpbf-slider"] =
	SliderControl as WpbfCustomizeSliderControl;
